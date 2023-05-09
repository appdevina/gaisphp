<?php

namespace App\Http\Controllers; 

use App\Models\User;
use App\Models\Product;
use App\Models\ProblemReport;
use App\Models\RequestBarang;
use App\Models\RequestSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        $totalProblem = ProblemReport::count();
        $totalProduct = Product::count();
        $totalUser = User::count();

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

        return view('dashboard.index', [
            'totalRequest' => $totalRequest,
            'totalProblem' => $totalProblem,
            'totalProduct' => $totalProduct,
            'totalUser' => $totalUser,
            'requestBarangs' => $requestBarangs,
            'problemReport' => $problemReport,
            'requestSetting' => RequestSetting::all(),
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
