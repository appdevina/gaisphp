<?php

namespace App\Http\Controllers;

use App\Models\ProblemReport;
use App\Models\PRCategory;
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
        $user = Auth::user()->id;
        $userRole = Auth::user()->role_id;

        if ($userRole >= 3) {
            $problems = ProblemReport::with('prcategory','user','closedby')
            ->where('user_id', $user)
            ->orderBy('status','desc')
            ->orderBy('status_client', 'asc')
            ->orderBy('date', 'desc')
            ->paginate(30);
        }

        $problems = ProblemReport::with('prcategory','user','closedby')
            ->orderBy('status','desc')
            ->orderBy('status_client', 'asc')
            ->orderBy('date', 'desc')
            ->paginate(30);

        $dataid = null;
        $problemid = null;

        return view('problems.index', [
            'problems' => $problems,
            'prcategories' => PRCategory::all(),
            'dataid' => $dataid,
            'problemid' => $problemid,
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
            
            $clientPending = ProblemReport::with('user')
            ->where('user_id', $user)
            ->where('status_client', '0')
            ->count();

            if ($clientPending >= 1) {
                return redirect('problemReport')->with(['error' => 'Harap ubah status akhir laporan terlebih dahulu !']);
            }

            return view('problems.addProblem', [
                'prcategories' => PRCategory::all(),
            ]);
        } catch (Exception $e) {
            return redirect('problemReport')->with(['error' => $e->getMessage()]);
        }
     }

    public function store(Request $request)
    {
        try {
            $request['date'] = Carbon::now()->format('Y-m-d H:i:s');
            ProblemReport::create($request->all());

            return redirect('problemReport')->with('success', 'Data berhasil diinput !');
        } catch (Exception $e) {
            return redirect('problemReport')->with(['error' => $e->getMessage()]);
        }
    }

    public function editStatus(ProblemReport $problem)
    {
        return view('problems.editStatus', [
            'problem' => $problem,
        ]);
    }

    public function editStatusClient(ProblemReport $problem)
    {
        return view('problems.editStatusClient', [
            'problem' => $problem,
        ]);
    }

    public function updateStatusClient(Request $request, ProblemReport $problem)
    {
        try {
            $problem->status_client = $request->status_client;
            $problem->save();

            return redirect('problemReport')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('problemReport')->with(['error' => $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, ProblemReport $problem)
    {
        try {
            $user = Auth::user()->id;
            
            if($request->status == "CLOSED"){
                $problem->closed_by = $user;
                $problem->closed_at = Carbon::now()->format('Y-m-d H:i:s');
            }

            if ($request->scheduled_at != null){
                $problem->scheduled_at = Carbon::parse($request->scheduled_at)->format('Y-m-d');
            }

            $problem->result_desc = $request->result_desc;
            $problem->status = $request->status;       
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
