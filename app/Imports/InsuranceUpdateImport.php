<?php

namespace App\Imports;

use App\Models\Insurance;
use App\Models\InsuranceUpdate;
use App\Models\InsuranceProvider;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class InsuranceUpdateImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user_id = Auth::user()->id;
        $insurance = new Insurance();
        $insurance_id = Insurance::where('policy_number', strtolower($row['no_polis_induk']))->first();
        if ($insurance_id) {
            $insurance = InsuranceUpdate::where('insurance_id', function($query) use ($insurance_id) {
                $query->select('id')
                    ->from('insurances')
                    ->where('policy_number', $insurance_id->policy_number);
            })->where('policy_number', $insurance_id->policy_number)
            ->first();
        }
        if ($insurance) {
            //Trying to get property 'id' of non-object (masih error)
            $stock_inprov_id = InsuranceProvider::where('insurance_provider', preg_replace('/\s+/', '', $row['asuransi_stok']))->first()->id;
            $building_inprov_id = InsuranceProvider::where('insurance_provider', preg_replace('/\s+/', '', $row['asuransi_bangunan']))->first()->id;
            $insurance->update([
                'insurance_id' => $insurance_id->id,
                'policy_number' => $row['no_polis'],
                'stock_inprov_id' => $stock_inprov_id,
                'building_inprov_id' => $building_inprov_id,
                'stock_worth' => $row['nilai_stok'],
                'building_worth' => $row['nilai_bangunan'],
                'join_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_mulai']),
                'expired_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_akhir']),
                'user_id' => $user_id
            ]);
        } else {
            $stock_inprov_id = InsuranceProvider::where('insurance_provider', preg_replace('/\s+/', '', $row['asuransi_stok']))->first()->id;
            $building_inprov_id = InsuranceProvider::where('insurance_provider', preg_replace('/\s+/', '', $row['asuransi_bangunan']))->first()->id;
            return new InsuranceUpdate([
                'insurance_id' => $insurance_id->id,
                'policy_number' => $row['no_polis'],
                'stock_inprov_id' => $stock_inprov_id,
                'building_inprov_id' => $building_inprov_id,
                'stock_worth' => $row['nilai_stok'],
                'building_worth' => $row['nilai_bangunan'],
                'join_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_mulai']),
                'expired_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_akhir']),
                'user_id' => $user_id
            ]);
        }
    }
}
