<?php

namespace App\Exports;

use App\Models\RequestDetail;
use App\Models\RequestBarang;
use App\Models\Divisi;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class RequestExport implements FromArray, WithHeadings, WithMapping
{
    protected String $date1;
    protected String $date2;
    protected String $area_id;
    protected String $request_type_id;

    function __construct(String $date1, String $date2, String $area_id, String $request_type_id)
    {
        $this->date1 = $date1;
        $this->date2 = $date2;
        $this->area_id = $area_id;
        $this->request_type_id = $request_type_id;
    }

    public function array(): array
    {
        $area_id = $this->area_id;
        $request_type_id = $this->request_type_id;
        $products = Product::all();
        $divisions = Divisi::orderBy('division')->where('area_id', $area_id)->get();
        $result = [];
        //$result[[kertas,10.000,$qty[]],[],[]]
        //#result[[kertas,10.000,$qty[3,2,6,...]],[pulpen,8.000,[5,3,4]].............]

        foreach ($products as $product) {
            $qty = [];
            //posisi divisi busdev [3]
            //posisi divisi scm [3,2]
            //posisi divisi fam [3,2,6...........]
            
            foreach ($divisions as $division) {
                $total = 0;

                $requests = RequestBarang::with('user.division', 'user.division.area','closedby','request_detail.product','request_type')
                ->where('request_type_id', $request_type_id)
                ->whereHas('request_detail', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                    
                })
                ->whereHas('user', function ($query) use ($division) {
                    $query->where('division_id', $division->id);
                })
                ->whereHas('user.division.area', function ($query) use ($area_id) {
                    $query->whereIn('area_id', [$area_id]);
                })
                ->whereBetween('created_at',[$this->date1,$this->date2])
                ->get();

                //$request[] //collection 3 request

                foreach ($requests as $request) {
                    if($request->user->division->area->area_id == 4 || $request->user->division->area->area_id == 5) {
                        foreach ($request->request_detail as $reqdetail) {
                            if ($reqdetail->product_id == $product->id) {
                                $total += $reqdetail->qty_approved;
                            }
                        }
                    } else {
                        foreach ($request->request_detail as $reqdetail) {
                            if ($reqdetail->product_id == $product->id) {
                                $total += $reqdetail->qty_request;
                            }
                        }
                    }
                }
                array_push($qty, strval($total));
            }
            array_push($result, [
                'product_name' => $product->product,
                'price' => $product->price,
                'qty' => $qty
            ]);
        }
        return $result;
    }

    public function headings(): array
    {
        $area_id = $this->area_id;

        $division = DB::table('divisions')
        ->where('area_id', $area_id)
        ->orderBy('division')
        ->pluck('division')
        ->toArray();
        
        $headings = ['Barang', 'Harga'];
        $headings = array_merge($headings, $division);

        return $headings;

        // Behavior Maatwebsite -> kesamping
        // [barang , harga , division all -> ...]
    }

    public function map($row): array
    {
        $result = [$row['product_name'], $row['price']];
        $result = array_merge($result, $row['qty']);
        return $result;
    }
}
