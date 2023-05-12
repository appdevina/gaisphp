<?php

namespace App\Http\Controllers;

use App\Exports\RentExport;
use App\Exports\RentTemplateExport;
use App\Exports\RentUpdateExport;
use App\Exports\RentUpdateTemplateExport;
use App\Imports\RentImport;
use App\Imports\RentUpdateImport;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $rents = Rent::with([
                'rent_update'  => function($query) {
                    $query->latest('expired_date');
                }])
                ->where('rent_code','LIKE','%'.$request->search.'%')
                ->orWhere('rented_detail','LIKE','%'.$request->search.'%')
                ->orWhere('rented_address','LIKE','%'.$request->search.'%')
                ->orWhere('first_party','LIKE','%'.$request->search.'%')
                ->orWhere('second_party','LIKE','%'.$request->search.'%')
                ->paginate(50);
        } else if ($request->selectStatus) {
            $rents = Rent::with([
                'rent_update'  => function($query) {
                    $query->latest('expired_date');
                }])
                ->select(['rents.*', DB::raw('(SELECT MAX(expired_date) FROM rent_updates WHERE rent_id = rents.id) as latest_expired_date')])
                ->where(function($query) use($request) {
                    $query->where('rents.status', 'LIKE', '%'.$request->selectStatus.'%')
                        ->orWhereHas('rent_update', function($query) use($request) {
                            $query->where('status', 'LIKE', '%'.$request->selectStatus.'%')
                            ->latest('expired_date');
                        });
                })
                ->orderByRaw("COALESCE((SELECT MAX(expired_date) FROM rent_updates WHERE rent_id = rents.id), rents.expired_date) ASC")
                ->paginate(50);
        } else {
            $rents = Rent::with([
                'rent_update'  => function($query) {
                    $query->where('status', '!=', 'TUTUP')
                    ->where('status', '!=', 'REFUND')
                    ->latest('expired_date');
                }])
                ->whereDoesntHave('rent_update', function($query) {
                    $query->whereIn('status', ['TUTUP', 'REFUND']);
                })
                ->select(['rents.*', DB::raw('(SELECT MAX(expired_date) FROM rent_updates WHERE rent_id = rents.id) as latest_expired_date')])
                ->orderByRaw("COALESCE((SELECT MAX(expired_date) FROM rent_updates WHERE rent_id = rents.id), rents.expired_date) ASC")
                ->where('rents.status', '!=', 'TUTUP')
                ->where('rents.status', '!=', 'REFUND')
                ->paginate(50);
        }
        
        return view('rents.rent.index', [
            'rents' => $rents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user()->id;
            $prefix = 'RENT';
            $count = DB::table('rents')->count() + 1;
            $rent_code = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);

            $request['rent_code'] = $rent_code;
            $request['user_id'] = $user;
            $request['join_date'] = Carbon::createFromFormat('d/m/Y', $request['join_date'])->format('Y-m-d');
            $request['expired_date'] = Carbon::createFromFormat('d/m/Y', $request['expired_date'])->format('Y-m-d');
            Rent::create($request->all());

            return redirect('rent')->with('success', 'Perjanjian Sewa berhasil diinput !');  
        } catch (Exception $e) {
            return redirect('rent')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detailRent = Rent::with('rent_update')
        ->find($id);

        return view('rents.rent.show', [
            'detailRent' => $detailRent,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rent $rent)
    {
        return view('rents.rent.edit', [
            'rent' => $rent,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rent $rent)
    {
        try {
            $user = Auth::user()->id;

            $request['user_id'] = $user;
            $request['join_date'] = Carbon::createFromFormat('d/m/Y', $request['join_date'])->format('Y-m-d');
            $request['expired_date'] = Carbon::createFromFormat('d/m/Y', $request['expired_date'])->format('Y-m-d');
            $rent->update($request->all());

            return redirect('rent/'.$request->rent_id)->with('success', 'Perjanjian Sewa berhasil diupdate !');  
        } catch (Exception $e) {
            return redirect('rent/'.$request->rent_id)->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rent $rent)
    {
        try {
            $rent->delete($rent);

            return redirect('rent')->with('success', 'Data berhasil dihapus !');
        } catch (Exception $e) {
            return redirect('rent')->with(['error' => $e->getMessage()]);
        }
    }

    public function import(Request $request, $disk = 'public')
    {
        $file = $request->file('fileImport');
        $namaFile = $file->getClientOriginalName();

        $path = 'import';
        if (! Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->makeDirectory($path);
        }
        $file->storeAs($path, $namaFile, $disk);

        Excel::import(new RentImport, storage_path('app/public/import/' . $namaFile));
        return redirect('rent')->with(['success' => 'Berhasil import data perjanjian sewa !']);
    }

    public function importUpdate(Request $request, $disk = 'public')
    {
        $file = $request->file('fileImport');
        $namaFile = $file->getClientOriginalName();

        $path = 'import';
        if (! Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->makeDirectory($path);
        }
        $file->storeAs($path, $namaFile, $disk);

        Excel::import(new RentUpdateImport, storage_path('app/public/import/' . $namaFile));
        return redirect('rent/'.$request->rent_id)->with(['success' => 'Berhasil import data perjanjian sewa !']);
    }

    public function template()
    {
        return Excel::download(new RentTemplateExport, 'sewa_template.xlsx');
    }

    public function templateUpdate()
    {
        return Excel::download(new RentUpdateTemplateExport, 'sewa_update_template.xlsx');
    }

    public function export()
    {
        return Excel::download(new RentExport, 'sewa.xlsx');
    }

    public function exportUpdate($id)
    {
        $rent = Rent::find($id);

        return Excel::download(new RentUpdateExport($rent->id, $rent->rent_code), 'sewa_update_kode-'.$rent->rent_code.'_.xlsx');
    }
}
