<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\User;
use App\Models\Product;
use App\Models\ProblemReport;
use App\Models\Rent;
use App\Models\RequestBarang;
use App\Models\RequestSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalRequest = RequestBarang::count();
        $requestDone = RequestBarang::where('status_client', 1)->count();
        $totalProblem = ProblemReport::count();
        $problemDone = ProblemReport::where('status_client', 1)->count();
        $totalProduct = Product::count();
        $totalUser = User::count();
        $totalInsurance = Insurance::count();
        $totalRent = Rent::count();

        $requestBarangs = RequestBarang::with('user','closedby','request_detail','request_type', 'request_approval')
        ->whereHas('request_approval', function ($q) {
            $q->where('approval_type', 'EXECUTOR')
            ->where('approved_by', null);
        })
        ->orderBy('date', 'desc')
        ->limit(5)
        ->take(5)
        ->get();

        $problemReport = ProblemReport::where('closed_by', null)
        ->orderBy('date', 'desc')
        ->limit(5)
        ->take(5)
        ->get();

        $insurances = Insurance::with([
            'stock_insurance_provider',
            'building_insurance_provider',
            'insurance_category',
            'insurance_scope',
            'insurance_update' => function($query) {
                $query->where('status', '!=', 'TUTUP')
                ->where('status', '!=', 'REFUND')
                ->latest('expired_date');
            }])
            ->whereDoesntHave('insurance_update', function($query) {
                $query->whereIn('status', ['TUTUP', 'REFUND']);
            })
            ->select(['insurances.*', DB::raw('(SELECT MAX(expired_date) FROM insurance_updates WHERE insurance_id = insurances.id) as latest_expired_date')])
            ->orderByRaw("COALESCE((SELECT MAX(expired_date) FROM insurance_updates WHERE insurance_id = insurances.id), insurances.expired_date) ASC")
            ->where('insurances.status', '!=', 'TUTUP')
            ->where('insurances.status', '!=', 'REFUND')
            ->take(5)
            ->get();
            
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
            ->take(5)
            ->get();

        return view('dashboard.index', [
            'totalRequest' => $totalRequest,
            'totalProblem' => $totalProblem,
            'totalProduct' => $totalProduct,
            'totalUser' => $totalUser,
            'requestBarangs' => $requestBarangs,
            'problemReport' => $problemReport,
            'requestSetting' => RequestSetting::all(),
            'totalInsurance' => $totalInsurance,
            'totalRent' => $totalRent,
            'insurances' => $insurances,
            'rents' => $rents,
            'problemDone' => $problemDone,
            'problemPending' => $totalProblem - $problemDone,
            'requestDone' => $requestDone,
            'requestPending' => $totalRequest - $requestDone,
        ]);
    }

    
    public function indexRequestSettings()
    {
        return view('settings.request-settings.index', [
            'requestSettings' => RequestSetting::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRequestSettings(Request $request)
    {
        try {
            $request['request_month'] = Carbon::createFromFormat('d-m-Y', '01-' . $request['request_month'])->format('Y-m-d');
            $request['open_date'] = Carbon::createFromFormat('d/m/Y', $request['open_date'])->format('Y-m-d');
            $request['closed_date'] = Carbon::createFromFormat('d/m/Y', $request['closed_date'])->format('Y-m-d');
            RequestSetting::create($request->all());

            return redirect('request-settings')->with('success', 'Pengaturan berhasil diinput !');
        } catch (Exception $e) {
            return redirect('request-settings')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRequestSettings(RequestSetting $rs)
    {
        return view('settings.request-settings.edit', [
            'requestSetting' => $rs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRequestSettings(Request $request, RequestSetting $rs)
    {
        try {
            $request['request_month'] = Carbon::createFromFormat('d-m-Y', '01-' . $request['request_month'])->format('Y-m-d');
            $request['open_date'] = Carbon::createFromFormat('d/m/Y', $request['open_date'])->format('Y-m-d');
            $request['closed_date'] = Carbon::createFromFormat('d/m/Y', $request['closed_date'])->format('Y-m-d');
            $rs->update($request->all());

            return redirect('request-settings')->with('success', 'Pengaturan berhasil diupdate !');  
        } catch (Exception $e) {
            return redirect('request-settings')->with(['error' => $e->getMessage()]);
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
