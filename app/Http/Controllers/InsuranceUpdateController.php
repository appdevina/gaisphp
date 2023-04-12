<?php

namespace App\Http\Controllers;

use App\Models\InsuranceUpdate;
use App\Models\InsuranceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;

class InsuranceUpdateController extends Controller
{
    public function editUpdate($id)
    {
        $insurance = InsuranceUpdate::find($id);

        return view('insurances.insurance.showEditUpdate', [
            'insurance' => $insurance,
            'inprovs' => InsuranceProvider::orderBy('insurance_provider')->get(),
        ]);
    }

    public function updateInsuranceUpdate(Request $request, InsuranceUpdate $insuranceUpdate)
    {
        try {
            $user = Auth::user()->id;

            $request['user_id'] = $user;
            $request['join_date'] = Carbon::createFromFormat('d/m/Y', $request['join_date'])->format('Y-m-d');
            $request['expired_date'] = Carbon::createFromFormat('d/m/Y', $request['expired_date'])->format('Y-m-d');
            $insuranceUpdate->update($request->all());

            return redirect('insurance/'.$request->insurance_id)->with('success', 'Asuransi berhasil diupdate !');  
        } catch (Exception $e) {
            return redirect('insurance/'.$request->insurance_id)->with(['error' => $e->getMessage()]);
        }
    }
}
