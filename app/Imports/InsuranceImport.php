<?php

namespace App\Imports;

use App\Models\Insurance;
use App\Models\InsuranceCategory;
use App\Models\InsuranceProvider;
use App\Models\InsuranceScope;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class InsuranceImport implements ToModel, WithHeadingRow
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
        $insurance = $insurance->where('insurance', strtolower($row['policy_number']));
        if ($insurance->first()) {
            $stock_inprov_id = InsuranceProvider::where('insurance_provider', preg_replace('/\s+/', '', $row['asuransi_stok']))->first()->id;
            $building_inprov_id = InsuranceProvider::where('insurance_provider', preg_replace('/\s+/', '', $row['asuransi_bangunan']))->first()->id;
            $incategory_id = InsuranceCategory::where('insurance_category', preg_replace('/\s+/', '', $row['kategori_asuransi']))->first()->id;
            $inscope_id = InsuranceScope::where('insurance_scope', preg_replace('/\s+/', '', $row['insurance_scope']))->first()->id;
            $insurance->update([
                'policy_number' => $row['no_polis'],
                'insured_address' => $row['alamat_tertanggung'],
                'insured_name' => $row['nama_tertanggung'],
                'insured_detail' => $row['detail_asuransi'],
                'risk_address' => $row['alamat_yang_diasuransikan'],
                'stock_inprov_id' => $stock_inprov_id,
                'building_inprov_id' => $building_inprov_id,
                'stock_worth' => $row['nilai_stok'],
                'building_worth' => $row['nilai_bangunan'],
                'insurance_category_id' => $incategory_id,
                'join_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_mulai']),
                'expired_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_akhir']),
                'insurance_scope_id' => $inscope_id,
                'user_id' => $user_id
            ]);
        } else {
            $stock_inprov_id = InsuranceProvider::where('insurance_provider', preg_replace('/\s+/', '', $row['asuransi_stok']))->first()->id;
            $building_inprov_id = InsuranceProvider::where('insurance_provider', preg_replace('/\s+/', '', $row['asuransi_bangunan']))->first()->id;
            $incategory_id = InsuranceCategory::where('insurance_category', preg_replace('/\s+/', '', $row['kategori_asuransi']))->first()->id;
            $inscope_id = InsuranceScope::where('insurance_scope', preg_replace('/\s+/', '', $row['insurance_scope']))->first()->id;
            return new insurance([
                'policy_number' => $row['no_polis'],
                'insured_address' => $row['alamat_tertanggung'],
                'insured_name' => $row['nama_tertanggung'],
                'insured_detail' => $row['detail_asuransi'],
                'risk_address' => $row['alamat_yang_diasuransikan'],
                'stock_inprov_id' => $stock_inprov_id,
                'building_inprov_id' => $building_inprov_id,
                'stock_worth' => $row['nilai_stok'],
                'building_worth' => $row['nilai_bangunan'],
                'insurance_category_id' => $incategory_id,
                'join_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_mulai']),
                'expired_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_akhir']),
                'insurance_scope_id' => $inscope_id,
                'user_id' => $user_id
            ]);
        }
    }
}
