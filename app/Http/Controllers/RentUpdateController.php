<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\RentUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Illuminate\Support\Facades\DB;

class RentUpdateController extends Controller
{
    public function storeUpdate(Request $request)
    {
        try {
            $prefix = 'RENTUP';
            $count = DB::table('rent_updates')->count() + 1;
            $rent_code = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);

            $request['rent_id'] = $request->rent_id;
            $request['rent_code'] = $rent_code;
            $request['user_id'] = Auth::id();
            $request['join_date'] = Carbon::createFromFormat('d/m/Y', $request['join_date'])->format('Y-m-d');
            $request['expired_date'] = Carbon::createFromFormat('d/m/Y', $request['expired_date'])->format('Y-m-d');
            RentUpdate::create($request->all());

            return redirect('rent/'.$request->rent_id)->with('success', 'Update Perjanjian Sewa berhasil diinput !');  
        } catch (Exception $e) {
            return redirect('rent/'.$request->rent_id)->with(['error' => $e->getMessage()]);
        }
    }

    public function editUpdate($id)
    {
        $rent = RentUpdate::find($id);

        return view('rents.rent.showEditUpdate', [
            'rent' => $rent,
        ]);
    }

    public function updateRentUpdate(Request $request, RentUpdate $rentUpdate)
    {
        try {
            $request['user_id'] = Auth::id();
            $request['join_date'] = Carbon::createFromFormat('d/m/Y', $request['join_date'])->format('Y-m-d');
            $request['expired_date'] = Carbon::createFromFormat('d/m/Y', $request['expired_date'])->format('Y-m-d');
            $rentUpdate->update($request->all());

            return redirect('rent/'.$request->rent_id)->with('success', 'Perjanjian Sewa berhasil diupdate !');  
        } catch (Exception $e) {
            return redirect('rent/'.$request->rent_id)->with(['error' => $e->getMessage()]);
        }
    }

    public function deleteUpdate(RentUpdate $rentUpdate, Rent $rent)
    {
        try {
            $rentUpdate->delete($rentUpdate);

            return redirect('rent/'.$rent->id)->with('success', 'Data berhasil dihapus !');
        } catch (Exception $e) {
            return redirect('rent/'.$rent->id)->with(['error' => $e->getMessage()]);
        }
    }
}
