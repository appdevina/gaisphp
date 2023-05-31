<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\PRCategory;
use App\Models\User;
use App\Models\Product;
use App\Models\ProblemReport;
use App\Models\Rent;
use App\Models\RequestBarang;
use App\Models\RequestSetting;
use App\Models\RequestType;
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
    public function index(Request $request)
    {
        if ($request->dateChartRequestItem && $request->request_type) {
            $data = explode('-', preg_replace('/\s+/', '', $request->dateChartRequestItem));
            $date1 = Carbon::parse($data[0])->format('Y-m-d');
            $date2 = Carbon::parse($data[1])->format('Y-m-d');
            $date2 = date('Y-m-d', strtotime('+ 1 day', strtotime($date2)));

            $highestRequestItem = RequestBarang::with('request_detail', 'user.division.area')
                ->selectRaw('user_id, CASE WHEN areas.id IN (4, 5) AND request_type_id = 2 THEN SUM(request_details.qty_approved) ELSE SUM(request_details.qty_request) END AS highestRequestItem')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('divisions', 'users.division_id', '=', 'divisions.id')
                ->join('areas', 'divisions.area_id', '=', 'areas.id')
                ->join('request_details', 'requests.id', '=', 'request_details.request_id')
                ->where('status_client', '<>', 2)
                ->where('request_type_id', $request->request_type)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id', 'request_type_id', 'areas.id')
                ->orderBy('highestRequestItem', 'DESC')
                ->limit(10)
                ->get();

            $highestRequestCost = RequestBarang::with('request_detail', 'request_detail.product', 'user.division.area')
                ->selectRaw('user_id, CASE WHEN areas.id IN (4, 5) AND request_type_id = 2 THEN SUM(request_details.qty_approved * products.price) ELSE SUM(request_details.qty_request * products.price) END AS highestRequestCost')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('divisions', 'users.division_id', '=', 'divisions.id')
                ->join('areas', 'divisions.area_id', '=', 'areas.id')
                ->join('request_details', 'requests.id', '=', 'request_details.request_id')
                ->join('products', 'request_details.product_id', '=', 'products.id')
                ->where('status_client', '<>', 2)
                ->where('request_type_id', $request->request_type)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id', 'request_type_id', 'areas.id')
                ->orderBy('highestRequestCost', 'DESC')
                ->limit(10)
                ->get();

            $highestProblemTotal = ProblemReport::with('prcategory', 'user')
                ->selectRaw('user_id, COUNT(*) as highestProblemTotal')
                ->where('pr_category_id', $request->pr_category_id)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id')
                ->orderBy('highestProblemTotal', 'DESC')
                ->limit(10)
                ->get();

            $highestProblemCategory = ProblemReport::with('prcategory', 'user')
                ->selectRaw('pr_category_id, COUNT(*) as highestProblemCategory')
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('pr_category_id')
                ->orderBy('highestProblemCategory', 'DESC')
                ->limit(10)
                ->get();

        } else if ($request->dateChartRequestCost && $request->request_type) {
            $data = explode('-', preg_replace('/\s+/', '', $request->dateChartRequestCost));
            $date1 = Carbon::parse($data[0])->format('Y-m-d');
            $date2 = Carbon::parse($data[1])->format('Y-m-d');
            $date2 = date('Y-m-d', strtotime('+ 1 day', strtotime($date2)));

            $highestRequestItem = RequestBarang::with('request_detail', 'user.division.area')
                ->selectRaw('user_id, CASE WHEN areas.id IN (4, 5) AND request_type_id = 2 THEN SUM(request_details.qty_approved) ELSE SUM(request_details.qty_request) END AS highestRequestItem')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('divisions', 'users.division_id', '=', 'divisions.id')
                ->join('areas', 'divisions.area_id', '=', 'areas.id')
                ->join('request_details', 'requests.id', '=', 'request_details.request_id')
                ->where('status_client', '<>', 2)
                ->where('request_type_id', $request->request_type)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id', 'request_type_id', 'areas.id')
                ->orderBy('highestRequestItem', 'DESC')
                ->limit(10)
                ->get();

            $highestRequestCost = RequestBarang::with('request_detail', 'request_detail.product', 'user.division.area')
                ->selectRaw('user_id, CASE WHEN areas.id IN (4, 5) AND request_type_id = 2 THEN SUM(request_details.qty_approved * products.price) ELSE SUM(request_details.qty_request * products.price) END AS highestRequestCost')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('divisions', 'users.division_id', '=', 'divisions.id')
                ->join('areas', 'divisions.area_id', '=', 'areas.id')
                ->join('request_details', 'requests.id', '=', 'request_details.request_id')
                ->join('products', 'request_details.product_id', '=', 'products.id')
                ->where('status_client', '<>', 2)
                ->where('request_type_id', $request->request_type)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id', 'request_type_id', 'areas.id')
                ->orderBy('highestRequestCost', 'DESC')
                ->limit(10)
                ->get();
            
            $highestProblemTotal = ProblemReport::with('prcategory', 'user')
                ->selectRaw('user_id, COUNT(*) as highestProblemTotal')
                ->where('pr_category_id', $request->pr_category_id)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id')
                ->orderBy('highestProblemTotal', 'DESC')
                ->limit(10)
                ->get();

            $highestProblemCategory = ProblemReport::with('prcategory', 'user')
                ->selectRaw('pr_category_id, COUNT(*) as highestProblemCategory')
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('pr_category_id')
                ->orderBy('highestProblemCategory', 'DESC')
                ->limit(10)
                ->get();

        } else if ($request->dateChartProblemTotal && $request->pr_category_id) {
            $data = explode('-', preg_replace('/\s+/', '', $request->dateChartProblemTotal));
            $date1 = Carbon::parse($data[0])->format('Y-m-d');
            $date2 = Carbon::parse($data[1])->format('Y-m-d');
            $date2 = date('Y-m-d', strtotime('+ 1 day', strtotime($date2)));

            $highestRequestItem = RequestBarang::with('request_detail', 'user.division.area')
                ->selectRaw('user_id, CASE WHEN areas.id IN (4, 5) AND request_type_id = 2 THEN SUM(request_details.qty_approved) ELSE SUM(request_details.qty_request) END AS highestRequestItem')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('divisions', 'users.division_id', '=', 'divisions.id')
                ->join('areas', 'divisions.area_id', '=', 'areas.id')
                ->join('request_details', 'requests.id', '=', 'request_details.request_id')
                ->where('status_client', '<>', 2)
                ->where('request_type_id', $request->request_type)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id', 'request_type_id', 'areas.id')
                ->orderBy('highestRequestItem', 'DESC')
                ->limit(10)
                ->get();

            $highestRequestCost = RequestBarang::with('request_detail', 'request_detail.product', 'user.division.area')
                ->selectRaw('user_id, CASE WHEN areas.id IN (4, 5) AND request_type_id = 2 THEN SUM(request_details.qty_approved * products.price) ELSE SUM(request_details.qty_request * products.price) END AS highestRequestCost')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('divisions', 'users.division_id', '=', 'divisions.id')
                ->join('areas', 'divisions.area_id', '=', 'areas.id')
                ->join('request_details', 'requests.id', '=', 'request_details.request_id')
                ->join('products', 'request_details.product_id', '=', 'products.id')
                ->where('status_client', '<>', 2)
                ->where('request_type_id', $request->request_type)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id', 'request_type_id', 'areas.id')
                ->orderBy('highestRequestCost', 'DESC')
                ->limit(10)
                ->get();
            
            $highestProblemTotal = ProblemReport::with('prcategory', 'user')
                ->selectRaw('user_id, COUNT(*) as highestProblemTotal')
                ->where('pr_category_id', $request->pr_category_id)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id')
                ->orderBy('highestProblemTotal', 'DESC')
                ->limit(10)
                ->get();

            $highestProblemCategory = ProblemReport::with('prcategory', 'user')
                ->selectRaw('pr_category_id, COUNT(*) as highestProblemCategory')
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('pr_category_id')
                ->orderBy('highestProblemCategory', 'DESC')
                ->limit(10)
                ->get();

        } else if ($request->dateChartProblemCategory) {
            $data = explode('-', preg_replace('/\s+/', '', $request->dateChartProblemCategory));
            $date1 = Carbon::parse($data[0])->format('Y-m-d');
            $date2 = Carbon::parse($data[1])->format('Y-m-d');
            $date2 = date('Y-m-d', strtotime('+ 1 day', strtotime($date2)));

            $highestRequestItem = RequestBarang::with('request_detail', 'user.division.area')
                ->selectRaw('user_id, CASE WHEN areas.id IN (4, 5) AND request_type_id = 2 THEN SUM(request_details.qty_approved) ELSE SUM(request_details.qty_request) END AS highestRequestItem')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('divisions', 'users.division_id', '=', 'divisions.id')
                ->join('areas', 'divisions.area_id', '=', 'areas.id')
                ->join('request_details', 'requests.id', '=', 'request_details.request_id')
                ->where('status_client', '<>', 2)
                ->where('request_type_id', $request->request_type)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id', 'request_type_id', 'areas.id')
                ->orderBy('highestRequestItem', 'DESC')
                ->limit(10)
                ->get();

            $highestRequestCost = RequestBarang::with('request_detail', 'request_detail.product', 'user.division.area')
                ->selectRaw('user_id, CASE WHEN areas.id IN (4, 5) AND request_type_id = 2 THEN SUM(request_details.qty_approved * products.price) ELSE SUM(request_details.qty_request * products.price) END AS highestRequestCost')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('divisions', 'users.division_id', '=', 'divisions.id')
                ->join('areas', 'divisions.area_id', '=', 'areas.id')
                ->join('request_details', 'requests.id', '=', 'request_details.request_id')
                ->join('products', 'request_details.product_id', '=', 'products.id')
                ->where('status_client', '<>', 2)
                ->where('request_type_id', $request->request_type)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id', 'request_type_id', 'areas.id')
                ->orderBy('highestRequestCost', 'DESC')
                ->limit(10)
                ->get();
            
            $highestProblemTotal = ProblemReport::with('prcategory', 'user')
                ->selectRaw('user_id, COUNT(*) as highestProblemTotal')
                ->where('pr_category_id', $request->pr_category_id)
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('user_id')
                ->orderBy('highestProblemTotal', 'DESC')
                ->limit(10)
                ->get();

            $highestProblemCategory = ProblemReport::with('prcategory', 'user')
                ->selectRaw('pr_category_id, COUNT(*) as highestProblemCategory')
                ->whereBetween('date', [$date1, $date2])
                ->groupBy('pr_category_id')
                ->orderBy('highestProblemCategory', 'DESC')
                ->limit(10)
                ->get();
        } else {
            $highestRequestItem = RequestBarang::with('request_detail', 'user.division.area')
                ->selectRaw('user_id, CASE WHEN areas.id IN (4, 5) AND request_type_id = 2 THEN SUM(request_details.qty_approved) ELSE SUM(request_details.qty_request) END AS highestRequestItem')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('divisions', 'users.division_id', '=', 'divisions.id')
                ->join('areas', 'divisions.area_id', '=', 'areas.id')
                ->join('request_details', 'requests.id', '=', 'request_details.request_id')
                ->where('status_client', '<>', 2)
                ->groupBy('user_id', 'request_type_id', 'areas.id')
                ->orderBy('highestRequestItem', 'DESC')
                ->limit(10)
                ->get();
            
            $highestRequestCost = RequestBarang::with('request_detail', 'request_detail.product', 'user.division.area')
                ->selectRaw('user_id, CASE WHEN areas.id IN (4, 5) AND request_type_id = 2 THEN SUM(request_details.qty_approved * products.price) ELSE SUM(request_details.qty_request * products.price) END AS highestRequestCost')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->join('divisions', 'users.division_id', '=', 'divisions.id')
                ->join('areas', 'divisions.area_id', '=', 'areas.id')
                ->join('request_details', 'requests.id', '=', 'request_details.request_id')
                ->join('products', 'request_details.product_id', '=', 'products.id')
                ->where('status_client', '<>', 2)
                ->groupBy('user_id', 'request_type_id', 'areas.id')
                ->orderBy('highestRequestCost', 'DESC')
                ->limit(10)
                ->get();

            $highestProblemTotal = ProblemReport::with('prcategory', 'user')
                ->selectRaw('user_id, COUNT(*) as highestProblemTotal')
                ->groupBy('user_id')
                ->orderBy('highestProblemTotal', 'DESC')
                ->limit(10)
                ->get();

            $highestProblemCategory = ProblemReport::with('prcategory', 'user')
                ->selectRaw('pr_category_id, COUNT(*) as highestProblemCategory')
                ->groupBy('pr_category_id')
                ->orderBy('highestProblemCategory', 'DESC')
                ->limit(10)
                ->get();

        }
            //HIGHEST REQUEST ITEM CHART
            $highestRequestUser = [];
            $highestRequestUnit = [];

            foreach ($highestRequestItem as $hri) {
                $highestRequestUser[] = $hri->user->fullname ?? 'Nonactive User';
                $highestRequestUnit[] = $hri->highestRequestItem ?? 0;
            }

            if ($highestRequestUser == [] || $highestRequestUnit == []) {
                $highestRequestUser = ['null', 'null', 'null'];
                $highestRequestUnit = ['0', '0' ,'0'];
            }

            //HIGHEST REQUEST COST CHART
            $highestRequestCostUser = [];
            $highestRequestCostUnit = [];

            foreach ($highestRequestCost as $hrc) {
                $highestRequestCostUser[] = $hrc->user->fullname ?? 'Nonactive User';
                $highestRequestCostUnit[] = $hrc->highestRequestCost ?? 0;
            }

            if ($highestRequestCostUser == [] || $highestRequestCostUnit == []) {
                $highestRequestCostUser = ['null', 'null', 'null'];
                $highestRequestCostUnit = ['0', '0' ,'0'];
            }

            //HIGHEST PROBKLEM REPORT COUNT CHART
            $highestProblemTotalUser = [];
            $highestProblemTotalUnit = [];

            foreach ($highestProblemTotal as $hpt) {
                $highestProblemTotalUser[] = $hpt->user->fullname ?? 'Nonactive User';
                $highestProblemTotalUnit[] = $hpt->highestProblemTotal ?? 0;
            }

            if ($highestProblemTotalUser == [] || $highestProblemTotalUnit == []) {
                $highestProblemTotalUser = ['null', 'null', 'null'];
                $highestProblemTotalUnit = ['0', '0' ,'0'];
            }

            //HIGHEST PROBLEM REPORT CATEGORY CHART
            $highestProblemCategoryUser = [];
            $highestProblemCategoryUnit = [];

            foreach ($highestProblemCategory as $hpc) {
                $highestProblemCategoryUser[] = $hpc->prcategory->problem_report_category ?? 'Nonactive Category';
                $highestProblemCategoryUnit[] = $hpc->highestProblemCategory ?? 0;
            }

            if ($highestProblemCategoryUser == [] || $highestProblemCategoryUnit == []) {
                $highestProblemCategoryUser = ['null', 'null', 'null'];
                $highestProblemCategoryUnit = ['0', '0' ,'0'];
            }

            //FOR SUMMARY
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
            'highestRequestUser' => $highestRequestUser,
            'highestRequestUnit' => $highestRequestUnit,
            'highestRequestCostUser' => $highestRequestCostUser,
            'highestRequestCostUnit' => $highestRequestCostUnit,
            'request_types' => RequestType::all(),
            'prcategories' => PRCategory::all(),
            'highestProblemTotalUser' => $highestProblemTotalUser,
            'highestProblemTotalUnit' => $highestProblemTotalUnit,
            'highestProblemCategoryUser' => $highestProblemCategoryUser,
            'highestProblemCategoryUnit' => $highestProblemCategoryUnit,
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
