<?php

namespace App\Http\Controllers;

use App\Exports\InsuranceExport;
use App\Exports\InsuranceTemplateExport;
use App\Exports\InsuranceUpdateExport;
use App\Exports\InsuranceUpdateTemplateExport;
use App\Imports\InsuranceImport;
use App\Imports\InsuranceUpdateImport;
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
use Illuminate\Support\Facades\DB;

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
                'insurance_update'=> function($query) {$query->latest('expired_date');
            }])
            ->where('policy_number','LIKE','%'.$request->search.'%')
            ->orWhere('insured_address','LIKE','%'.$request->search.'%')
            ->orWhere('insured_name','LIKE','%'.$request->search.'%')
            ->orWhere('insured_detail','LIKE','%'.$request->search.'%')
            ->orWhere('risk_address','LIKE','%'.$request->search.'%')
            ->paginate(50);
        } else if ($request->selectStatus) {
            $insurances = Insurance::with([
                'stock_insurance_provider',
                'building_insurance_provider',
                'insurance_category',
                'insurance_scope',
                'insurance_update' => function($query) use($request) {
                    $query->latest('expired_date');
            }])
            ->select(['insurances.*', DB::raw('(SELECT MAX(expired_date) FROM insurance_updates WHERE insurance_id = insurances.id) as latest_expired_date')])
            ->where(function($query) use($request) {
                $query->where('insurances.status', 'LIKE', '%'.$request->selectStatus.'%')
                    ->orWhereHas('insurance_update', function($query) use($request) {
                        $query->where('status', 'LIKE', '%'.$request->selectStatus.'%')
                        ->latest('expired_date');
                        //latestnya gabisa
                    });
            })
            ->orderByRaw("COALESCE((SELECT MAX(expired_date) FROM insurance_updates WHERE insurance_id = insurances.id), insurances.expired_date) ASC")
            ->paginate(50);
        } else {
            $insurances = Insurance::with([
                'insurance_category',
                'insurance_scope',
                'insurance_update',
                'insurance_update.stock_insurance_provider',
                'insurance_update.building_insurance_provider',
            ])
            ->selectRaw('insurances.*, (SELECT status FROM insurance_updates WHERE insurance_id = insurances.id ORDER BY expired_date DESC LIMIT 1) AS latest_status')
            ->orderBy('latest_status', 'asc')
            ->selectRaw('insurances.*, (SELECT expired_date FROM insurance_updates WHERE insurance_id = insurances.id ORDER BY expired_date DESC LIMIT 1) AS latest_date')
            ->orderBy('latest_date', 'asc')
            ->paginate(50);
            
            // dd($insurances[25]);
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
            // dd($request->all());
            $user = Auth::user()->id;

            $insurance = Insurance::create([
                'insured_address' => $request->insured_address,
                'insured_name' => $request->insured_name,
                'warehouse_code' => $request->warehouse_code,
                'insured_detail' => $request->insured_detail,
                'risk_address' => $request->risk_address,
                'insurance_category_id' => $request->insurance_category_id,
                'insurance_scope_id' => $request->insurance_scope_id,
            ]);

            InsuranceUpdate::create([
                'insurance_id' => $insurance->id,
                'policy_number' => $request->policy_number, 
                'stock_inprov_id' => $request->stock_inprov_id,
                'building_inprov_id' => $request->building_inprov_id,
                'stock_worth' => $request->stock_worth,
                'actual_stock_worth' => $request->actual_stock_worth,
                'stock_premium' => $request->stock_premium,
                'building_worth' => $request->building_worth,
                'building_premium' => $request->building_premium,
                'join_date' => Carbon::createFromFormat('d/m/Y', $request->join_date)->format('Y-m-d'),
                'expired_date' => Carbon::createFromFormat('d/m/Y', $request->expired_date)->format('Y-m-d'),
                'user_id' => $user,
                'notes' => $request->notes,
            ]);

            // $request['user_id'] = $user;
            // $request['join_date'] = Carbon::createFromFormat('d/m/Y', $request['join_date'])->format('Y-m-d');
            // $request['expired_date'] = Carbon::createFromFormat('d/m/Y', $request['expired_date'])->format('Y-m-d');
            // Insurance::create($request->all());

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

        //$file->move(storage_path('import/'), $namaFile); not necessary
        Excel::import(new InsuranceImport, storage_path('app/public/import/' . $namaFile));
        return redirect('insurance')->with(['success' => 'Berhasil import data asuransi !']);
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

        Excel::import(new InsuranceUpdateImport, storage_path('app/public/import/' . $namaFile));
        return redirect('insurance/'.$request->insurance_id)->with(['success' => 'Berhasil import data asuransi !']);
    }

    public function template()
    {
        return Excel::download(new InsuranceTemplateExport, 'asuransi_template.xlsx');
    }

    public function templateUpdate()
    {
        return Excel::download(new InsuranceUpdateTemplateExport, 'asuransi_update_template.xlsx');
    }

    public function export()
    {
        return Excel::download(new InsuranceExport, 'asuransi.xlsx');
    }

    public function exportUpdate($id)
    {
        $polis = Insurance::find($id);

        return Excel::download(new InsuranceUpdateExport($polis->id, $polis->policy_number), 'asuransi_update_nopol-'.$polis->policy_number.'_.xlsx');
    }
}
