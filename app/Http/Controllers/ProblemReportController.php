<?php

namespace App\Http\Controllers;

use App\Models\ProblemReport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProblemReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $problems = ProblemReport::orderBy('status','desc')
        ->orderBy('status_client', 'asc')
        ->orderBy('date', 'desc')
        ->paginate(30);

        return view('problems.index', [
            'problems' => $problems,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $request['date'] = Carbon::now()->format('Y-m-d H:i:s');
            ProblemReport::create($request->all());

            return redirect('problemReport')->with('success', 'Data berhasil diinput !');
        } catch (Exception $e) {
            return redirect('problemReport')->with(['error' => $e->getMessage()]);
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

    }

    public function updateStatusClient(Request $request, $id)
    {
        try {
            $problem = ProblemReport::find($request->dataid);

            $problem->status_client = $request->status_client;
            $problem->save();

            return redirect('problemReport')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('problemReport')->with(['error' => $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $problem = ProblemReport::find($request->problemid);
            $user = Auth::user()->id;
            
            $problem->scheduled_at = Carbon::parse($request->scheduled_at)->format('Y-m-d');
            $problem->status = $request->status;
            $problem->closed_by = $user;
            $problem->closed_at = Carbon::now()->format('Y-m-d H:i:s');
            $problem->save();

            return redirect('problemReport')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('problemReport')->with(['error' => $e->getMessage()]);
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
