<?php

namespace App\Http\Controllers; 

use App\Models\User;
use App\Models\Product;
use App\Models\ProblemReport;
use App\Models\RequestBarang;
use Illuminate\Http\Request;

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
