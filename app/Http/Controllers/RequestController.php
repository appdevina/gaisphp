<?php

namespace App\Http\Controllers;

use App\Models\RequestType;
use App\Models\RequestBarang;
use App\Models\RequestDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->id;
        $userRole = Auth::user()->role_id;

        if ($userRole >= 3) {
            $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type')
            ->where('user_id', $user)
            ->orderBy('status_po','asc')
            ->orderBy('status_client', 'asc')
            ->orderBy('date', 'desc')
            ->paginate(30);
            $request_types = RequestType::all();
            $products = Product::all();
        }

        $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type')
            ->orderBy('status_po','asc')
            ->orderBy('status_client', 'asc')
            ->orderBy('date', 'desc')
            ->paginate(30);
            $request_types = RequestType::all();
            $products = Product::all();


        return view('request.index', [
            'requestBarangs' => $requestBarangs,
            'request_types' => $request_types,
            'products' => $products,
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
            
            $clientPending = RequestBarang::with('user')
            ->where('user_id', $user)
            ->where('status_client', '0')
            ->count();

            if ($clientPending >= 1) {
                return redirect('request')->with(['error' => 'Harap ubah status akhir pengajuan terlebih dahulu !']);
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
            //dd($request->all());
            $request_file = $this->storeImage($request);

            $date = Carbon::now()->format('Y-m-d H:i:s');

            $requestBarang = RequestBarang::create([
                'user_id' => $request->user_id,
                'date' => $date,
                'total_cost' => 0,
                'status_po' => 0,
                'request_type_id' => $request->request_type_id,
            ]);
            $requestBarang->request_file = $request_file;
            $requestBarang->save();

            RequestDetail::create([
                'request_id' => $requestBarang->id,
                'product_id' => $request->product_id,
                'qty_request' => $request->qty_request,
                'qty_remaining' => $request->qty_remaining,
                'description' => $request->description,
            ]);

            return redirect('request')->with('success', 'Data berhasil diinput !');
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
}
