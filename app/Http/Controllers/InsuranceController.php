<?php

namespace App\Http\Controllers;

use App\Exports\InsuranceTemplateExport;
use App\Imports\InsuranceImport;
use App\Models\Insurance;
use App\Models\InsuranceCategory;
use App\Models\InsuranceProvider;
use App\Models\InsuranceScope;
use App\Models\InsuranceUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $insurances = Insurance::with([
                'stock_insurance_provider',
                'building_insurance_provider',
                'insurance_category',
                'insurance_scope',
                'insurance_update',
            ])
            ->where('policy_number','LIKE','%'.$request->search.'%')
            ->orWhere('insured_address','LIKE','%'.$request->search.'%')
            ->orWhere('insured_name','LIKE','%'.$request->search.'%')
            ->orWhere('insured_detail','LIKE','%'.$request->search.'%')
            ->orWhere('risk_address','LIKE','%'.$request->search.'%')
            ->paginate(30);
        } else {
            $insurances = Insurance::with([
                'stock_insurance_provider',
                'building_insurance_provider',
                'insurance_category',
                'insurance_scope',
                'insurance_update' => function($query) {$query->latest('expired_date')->get();
            }])
            ->paginate(30);
        }

       return view('insurances.insurance.index', [
            'insurances' => $insurances,
            'inprovs' => InsuranceProvider::orderBy('insurance_provider')->get(),
            'incategories' => InsuranceCategory::orderBy('insurance_category')->get(),
            'inscopes' => InsuranceScope::orderBy('insurance_scope')->get(),
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

            $request['user_id'] = $user;
            $request['join_date'] = Carbon::createFromFormat('d/m/Y', $request['join_date'])->format('Y-m-d');
            $request['expired_date'] = Carbon::createFromFormat('d/m/Y', $request['expired_date'])->format('Y-m-d');
            Insurance::create($request->all());

            return redirect('insurance')->with('success', 'Asuransi berhasil diinput !');  
        } catch (Exception $e) {
            return redirect('insurance')->with(['error' => $e->getMessage()]);
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
        $detailInsurance = Insurance::with('insurance_update')
        ->find($id);

        return view('insurances.insurance.show', [
            'detailInsurance' => $detailInsurance,
            'inprovs' => InsuranceProvider::orderBy('insurance_provider')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Insurance $insurance)
    {
        return view('insurances.insurance.edit', [
            'insurance' => $insurance,
            'inprovs' => InsuranceProvider::orderBy('insurance_provider')->get(),
            'incategories' => InsuranceCategory::orderBy('insurance_category')->get(),
            'inscopes' => InsuranceScope::orderBy('insurance_scope')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insurance $insurance)
    {
         try {
            $user = Auth::user()->id;

            $request['user_id'] = $user;
            $request['join_date'] = Carbon::createFromFormat('d/m/Y', $request['join_date'])->format('Y-m-d');
            $request['expired_date'] = Carbon::createFromFormat('d/m/Y', $request['expired_date'])->format('Y-m-d');
            $insurance->update($request->all());

            return redirect('insurance')->with('success', 'Asuransi berhasil diupdate !');  
        } catch (Exception $e) {
            return redirect('insurance')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insurance $insurance)
    {
        try {
            $insurance->delete($insurance);

            return redirect('insurance')->with('success', 'Data berhasil dihapus !');
        } catch (Exception $e) {
            return redirect('insurance')->with(['error' => $e->getMessage()]);
        }
    }

    public function storeUpdate(Request $request)
    {
        try {
            //d($request->all());
            $user = Auth::user()->id;

            $request['user_id'] = $user;
            $request['join_date'] = Carbon::createFromFormat('d/m/Y', $request['join_date'])->format('Y-m-d');
            $request['expired_date'] = Carbon::createFromFormat('d/m/Y', $request['expired_date'])->format('Y-m-d');
            InsuranceUpdate::create($request->all());

            return redirect('insurance/'.$request->insurance_id)->with('success', 'Update Asuransi berhasil diinput !');  
        } catch (Exception $e) {
            return redirect('insurance/'.$request->insurance_id)->with(['error' => $e->getMessage()]);
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

        
        $file->move(storage_path('import/'), $namaFile);
        Excel::import(new InsuranceImport, storage_path('import/' . $namaFile));
        return redirect('insurance')->with(['success' => 'Berhasil import data asuransi !']);
    }

    public function template()
    {
        return Excel::download(new InsuranceTemplateExport, 'asuransi_template.xlsx');
    }
}