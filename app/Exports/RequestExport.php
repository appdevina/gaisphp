<?php

namespace App\Exports;

use App\Models\RequestDetail;
use App\Models\RequestBarang;
use App\Models\Divisi;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class RequestExport implements FromArray, WithHeadings, WithMapping
{
    protected String $date1;
    protected String $date2;
    protected String $area_id;
    protected String $request_type_id;
    protected String $filter_request;

    function __construct(String $date1, String $date2, String $area_id, String $request_type_id, String $filter_request)
    {
        $this->date1 = $date1;
        $this->date2 = $date2;
        $this->area_id = $area_id;
        $this->request_type_id = $request_type_id;
        $this->filter_request = $filter_request;
    }

    public function array(): array
    {
        $area_id = $this->area_id;
        $request_type_id = $this->request_type_id;
        $products = Product::where('category_id', $request_type_id)->get();
        $divisions = Divisi::orderBy('division')->where('area_id', $area_id)->get();
        $result = [];
        $totalPrice = 0;
        $totalItemsAllProducts = 0;
        $filter_request = $this->filter_request;
        //$result[[kertas,10.000,$qty[]],[],[]]
        //#result[[kertas,10.000,$qty[3,2,6,...]],[pulpen,8.000,[5,3,4]].............]

        foreach ($products as $product) {
            $qty = [];
            $totalPricePerProduct = [];
            $totalPricePerDivision = [];
            $totalProductPerProduct = [];
            $totalItemsPerDivision = [];
            //posisi divisi busdev [3]
            //posisi divisi scm [3,2]
            //posisi divisi fam [3,2,6...........]
            
            foreach ($divisions as $division) {
                $total = 0;

                switch ($filter_request) {
                    case 0:
                        $requests = RequestBarang::with('user.division', 'user.division.area','closedby','request_detail.product','request_type', 'request_approval')
                        ->whereHas('request_approval', function ($q) {
                            $q->where('approval_type', 'EXECUTOR')
                            ->where('approved_by', null);
                        })
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
                        break;
                    case 1:
                        $requests = RequestBarang::with('user.division', 'user.division.area','closedby','request_detail.product','request_type', 'request_approval')
                        ->whereHas('request_approval', function ($q) {
                            $q->where('approval_type', 'EXECUTOR')
                            ->where('approved_by', '!=', null);
                        })
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
                        break;
                    case 2:
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
                        break;
                    case 3:
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
                        ->where('status_client', '!=', 2)
                        ->whereBetween('created_at',[$this->date1,$this->date2])
                        ->get();
                        break;
                    case 4:
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
                        ->where('status_client', 2)
                        ->whereBetween('created_at',[$this->date1,$this->date2])
                        ->get();
                        break;
                    case 5:
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
                        ->where('status_client', 4)
                        ->whereBetween('created_at',[$this->date1,$this->date2])
                        ->get();
                        break;
                    default:
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
                        ->where('status_client', '!=', 2)
                        ->whereBetween('created_at',[$this->date1,$this->date2])
                        ->get();
                        break;
                    }

                //$request[] //collection 3 request

                foreach ($requests as $request) {
                    if($request->user->division->area->id == 4 || $request->user->division->area->id == 5 || $request->user->division->area->id == 6 || $request->user->division->area->id == 11) {
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
                $totalPricePerDivision[$division->division] = ($total * $product->price); // Calculate and store the total price for the division
                //array_push($qty, strval($total));
                $qty[$division->id] = $total;
                $totalItemsPerDivision[$division->division] = $total;
            }
            $totalPricePerProduct = array_sum($totalPricePerDivision);
            $totalPrice += $totalPricePerProduct;
            $totalProductPerProduct = array_sum($qty);
            $totalItemsAllDivisions = array_sum($totalItemsPerDivision);
            
            array_push($result, [
                'product_name' => $product->product,
                'unit_type' => $product->unit_type->unit_type,
                'price' => $product->price,
                'qty' => $qty,
                'total_item' => $totalProductPerProduct,
                'total_price' => $totalPricePerProduct,
            ]);           
        }

        // Calculate and store the total items for each division
        $divisionTotalItems = [];
        $divisionPriceItems = [];

        foreach ($divisions as $division) {
            $divisionTotal = 0;
            $divisionPrice = 0;

            foreach ($result as $product) {
                if (isset($product['qty'][$division->id])) {
                $divisionTotal += $product['qty'][$division->id];
                $divisionPrice += $product['qty'][$division->id] * $product['price'];
                }
            }
            $divisionTotalItems[] = $divisionTotal;
            $divisionPriceItems[] = $divisionPrice;
        }

        // Add a new row to the result array with total items for each division
        $divisionTotalRow = [
            'product_name' => 'Total Item per Divisi',
            'unit_type' => '',
            'price' => '',
            'qty' => $divisionTotalItems,
            'total_item' => array_sum($divisionTotalItems),
            'total_price' => '',
        ];

        // Add a new row to the result array with total price for each division
        $divisionPriceRow = [
            'product_name' => 'Total Biaya per Divisi',
            'unit_type' => '',
            'price' => '',
            'qty' => $divisionPriceItems,
            'total_item' => '',
            'total_price' => array_sum($divisionPriceItems),
        ];
        
        array_push($result, $divisionTotalRow, $divisionPriceRow);

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
        
        $headings = ['Barang', 'Tipe Unit', 'Harga'];
        $endHeadings = ['Total Item', 'Total Biaya'];
        $headings = array_merge($headings, $division, $endHeadings);

        return $headings;

        // Behavior Maatwebsite -> kesamping
        // [barang , harga , division all -> ...]
    }

    public function map($row): array
    {
        $result = [$row['product_name'], $row['unit_type'], $row['price']];
        $result = array_merge($result, $row['qty'], [$row['total_item'], $row['total_price']]);
        return $result;
    }
}
