<?php

namespace App\Http\Controllers;

use App\Exports\RequestExport;
use App\Models\RequestType;
use App\Models\RequestBarang;
use App\Models\RequestDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user()->id;
        $userRole = Auth::user()->role_id;
        $userDivisi = Auth::user()->division_id;
        
        switch ($userRole) {
            case 1:
                if ($request->search) {
                    $data = explode('-', preg_replace('/\s+/', '', $request->search));
                    $date1 = Carbon::parse($data[0])->format('Y-m-d');
                    $date2 = Carbon::parse($data[1])->format('Y-m-d');
                    $date2 = date('Y-m-d', strtotime('+ 1 day', strtotime($date2)));
                    $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type')
                    ->whereBetween('date', [$date1, $date2])
                    ->orderBy('date')
                    ->paginate(30);
                } else {
                    $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type')
                    ->orderBy('status_client', 'asc')
                    ->orderBy('date', 'desc')
                    ->paginate(30);
                }
                break;
            case 2:
                if ($request->search) {
                    $data = explode('-', preg_replace('/\s+/', '', $request->search));
                    $date1 = Carbon::parse($data[0])->format('Y-m-d');
                    $date2 = Carbon::parse($data[1])->format('Y-m-d');
                    $date2 = date('Y-m-d', strtotime('+ 1 day', strtotime($date2)));
                    $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type')
                    ->where('request_type_id',1)
                    ->whereBetween('date', [$date1, $date2])
                    ->orderBy('date')
                    ->paginate(30);
                } else {
                    $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type')
                    ->where('request_type_id',1)
                    ->orderBy('status_client', 'asc')
                    ->orderBy('date', 'desc')
                    ->paginate(30);
                }
                break; 
            case 3:
                if ($request->search) {
                    $data = explode('-', preg_replace('/\s+/', '', $request->search));
                    $date1 = Carbon::parse($data[0])->format('Y-m-d');
                    $date2 = Carbon::parse($data[1])->format('Y-m-d');
                    $date2 = date('Y-m-d', strtotime('+ 1 day', strtotime($date2)));
                    $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type')
                    //whereHas('request_type', function($q) use($userDivisi) { $q->where('pic_division_id', $userDivisi) })
                    ->whereBetween('date', [$date1, $date2])
                    ->orderBy('date')
                    ->paginate(30);
                } else {
                    $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type')
                    //whereHas('request_type', function($q) use($userDivisi) { $q->where('pic_division_id', $userDivisi) })
                    ->orderBy('status_client', 'asc')
                    ->orderBy('date', 'desc')
                    ->paginate(30);
                }
                break;
            default:
                if ($request->search){
                    //handle user melakukan pencarian
                    $data = explode('-', preg_replace('/\s+/', '', $request->search));
                    $date1 = Carbon::parse($data[0])->format('Y-m-d');
                    $date2 = Carbon::parse($data[1])->format('Y-m-d');
                    $date2 = date('Y-m-d', strtotime('+ 1 day', strtotime($date2)));
                    $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type')
                    ->whereBetween('date', [$date1, $date2])
                    ->where('user_id', $user)
                    ->orderBy('date')
                    ->paginate(30);
                } else {
                    $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type')
                    ->where('user_id', $user)
                    ->orderBy('status_client', 'asc')
                    ->orderBy('date', 'desc')
                    ->paginate(30);
                }            
                break;
        }
        $request_types = RequestType::all();
        $products = Product::all();
        
        return view('request.index', [
            'requestBarangs' => $requestBarangs,
            'request_types' => RequestType::all(),
            'products' => Product::all(),
        ]);
    }

    public function show($id)
    {
        $requestBarang = RequestBarang::with('request_detail.product')->find($id);

        return view('request.show', [
            'requestBarang' => $requestBarang,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $user = Auth::user()->id;
            
            //SEMUA TIPE PENGAJUAN KALAU USER BELUM CLOSE GABISA NAMBAH
            $clientPending = RequestBarang::with('user')
            ->where('user_id', $user)
            ->where('status_client', '0')
            ->count();

            $pengajuanAsset = RequestBarang::with('user')
            ->where('user_id', $user)
            ->where('request_type_id', '1')
            ->where('status_client', '0')
            ->count();

            if ($pengajuanAsset >= 1) {
                return redirect('request')->with(['error' => 'Harap ubah status akhir pengajuan asset/non asset terlebih dahulu !']);
            }

            return view('request.addRequest', [
                'request_types' => RequestType::all(),
                'products' => Product::all(),
            ]);
        } catch (Exception $e) {
            return redirect('request')->with(['error' => $e->getMessage()]);
        }
    }


    public function store(Request $request)
    {
         try {
            $date = Carbon::now()->format('Y-m-d H:i:s');

            if ($request->request_type_id == 1 && $request->request_file == null) {
                return redirect('request/create')->with('error', 'Harap upload file pengajuan !');
            }

            if ($request->request_type_id == 1) {
                $request_file = $this->storeImage($request);

                $requestBarang = RequestBarang::create([
                    'user_id' => $request->user_id,
                    'date' => $date,
                    'total_cost' => 0,
                    'status_po' => 0,
                    'request_type_id' => $request->request_type_id,
                ]);
                $requestBarang->request_file = $request_file;
                $requestBarang->save();

                for ($i = 0; $i < count($request->get('qty_requests')); $i++) {
                    $temp = array();
                    $temp['request_id'] = $requestBarang->id;
                    $temp['product_id'] = $request->get('products')[$i];
                    $temp['qty_request'] = $request->get('qty_requests')[$i];
                    // $temp['qty_remaining'] = $request->get('qty_remainings')[$i];
                    $temp['description'] = $request->get('descriptions')[$i];

                    $insertDetail = RequestDetail::create($temp);
                }

                // Input data barangnya satuan
                // RequestDetail::create([
                //     'request_id' => $requestBarang->id,
                //     'product_id' => $request->product_id,
                //     'qty_request' => $request->qty_request,
                //     // 'qty_remaining' => $request->qty_remaining,
                //     'description' => $request->description,
                // ]);

                return redirect('request')->with('success', 'Pengajuan Barang Baru berhasil diinput !');
            }

                $requestBarang = RequestBarang::create([
                    'user_id' => $request->user_id,
                    'date' => $date,
                    'total_cost' => 0,
                    'status_po' => 0,
                    'request_type_id' => $request->request_type_id,
                ]);
                $requestBarang->save();

                for ($i = 0; $i < count($request->get('qty_requests')); $i++) {
                        $temp = array();
                        $temp['request_id'] = $requestBarang->id;
                        $temp['product_id'] = $request->get('products')[$i];
                        $temp['qty_request'] = $request->get('qty_requests')[$i];
                        // $temp['qty_remaining'] = $request->get('qty_remainings')[$i];
                        $temp['description'] = $request->get('descriptions')[$i];

                        $insertDetail = RequestDetail::create($temp);
                }

                return redirect('request')->with('success', 'Pengajuan berhasil diinput !');            
        } catch (Exception $e) {
            return redirect('request')->with(['error' => $e->getMessage()]);
        }
    }

    public function storeImage(Request $request, $disk = 'public')
    {
        try {
            $this->validate($request, [
                'request_file' => 'required|file|image|mimes:jpeg,png,jpg,pdf|max:2048',
            ]);
    
            $file = $request->file('request_file');
            $date = Carbon::now()->format('Y-m-d');
            $request_id = $request->request_id;
            $extension = $file->getClientOriginalExtension();
            $path = 'Request_File';
            if (! Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->makeDirectory($path);
            }
    
            $filename = "Req-".$request_id."_".$date."_". time() .".".$extension;
    
            $file->storeAs($path, $filename, $disk);
    
            return $filename;

        } catch (Exception $e) {
            return redirect('request')->with(['error' => $e->getMessage()]);
        }
    }

    public function editStatus(RequestBarang $requestBarang)
    {
        return view('request.editStatus', [
            'requestBarang' => $requestBarang,
        ]);
    }

    public function editStatusClient(RequestBarang $requestBarang)
    {
        return view('request.editStatusClient', [
            'requestBarang' => $requestBarang,
        ]);
    }

    public function editStatusAcc(RequestBarang $requestBarang)
    {
        return view('request.editStatusAcc', [
            'requestBarang' => $requestBarang,
        ]);
    }

    public function updateStatusClient(Request $request, RequestBarang $requestBarang)
    {
        try {
            $requestBarang->status_client = $request->status_client;
            $requestBarang->save();

            return redirect('request')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('request')->with(['error' => $e->getMessage()]);
        }
    }

    public function updateStatusAcc(Request $request, RequestBarang $requestBarang)
    {
        try {
            $requestBarang->status_po = $request->status_po;
            $requestBarang->save();

            return redirect('request')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('request')->with(['error' => $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, RequestBarang $requestBarang)
    {
        try {
            $user = Auth::user()->id;
            
            if($request->status == 'CLOSED'){
                $requestBarang->closed_by = $user;
                $requestBarang->closed_at = Carbon::now()->format('Y-m-d H:i:s');
                $requestBarang->save();
            }

            return redirect('request')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('request')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function export(Request $request){
        if ($request->exportRequest) {
            $data = explode('-', preg_replace('/\s+/', '', $request->exportRequest));
            $date1 = Carbon::parse($data[0])->format('Y-m-d');
            $date2 = Carbon::parse($data[1])->format('Y-m-d');
            $date2 = date('Y-m-d', strtotime('+ 1 day', strtotime($date2)));
            $problems = RequestBarang::with('user','closedby','request_detail','request_type')
                ->whereBetween('date', [$date1, $date2])
                ->orderBy('date')
                ->get();
        }

        return Excel::download(new RequestExport($date1, $date2), 'pengajuan_'. $date1 . '_to_' . $date2 . '.xlsx',);
    }
}
