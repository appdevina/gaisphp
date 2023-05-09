<?php

namespace App\Imports;

use App\Models\Insurance;
use App\Models\InsuranceCategory;
use App\Models\InsuranceScope;
use App\Models\InsuranceUpdate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InsuranceImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $insurance = new Insurance();
        $insurance_update_id = InsuranceUpdate::where('policy_number', $row['no_polis_induk']);
        if ($insurance_update_id->first()) {
            $insurance = $insurance->where('id', $insurance_update_id->first()->insurance_id);

            $incategory_id = InsuranceCategory::where('insurance_category', preg_replace('/\s+/', '', $row['kategori_asuransi']))->first()->id;
            $inscope_id = InsuranceScope::where('insurance_scope', preg_replace('/\s+/', '', $row['cakupan_asuransi']))->first()->id;
            $insurance->update([
                'insured_address' => $row['alamat_tertanggung'],
                'insured_name' => $row['nama_tertanggung'],
                'warehouse_code' => $row['kode_gudang'],
                'insured_detail' => $row['detail_asuransi'],
                'risk_address' => $row['alamat_yang_diasuransikan'],
                'insurance_category_id' => $incategory_id,
                'insurance_scope_id' => $inscope_id,
            ]);
        } else {
            $incategory_id = InsuranceCategory::where('insurance_category', preg_replace('/\s+/', '', $row['kategori_asuransi']))->first()->id;
            $inscope_id = InsuranceScope::where('insurance_scope', preg_replace('/\s+/', '', $row['cakupan_asuransi']))->first()->id;
            return new insurance([
                'insured_address' => $row['alamat_tertanggung'],
                'insured_name' => $row['nama_tertanggung'],
                'warehouse_code' => $row['kode_gudang'],
                'insured_detail' => $row['detail_asuransi'],
                'risk_address' => $row['alamat_yang_diasuransikan'],
                'insurance_category_id' => $incategory_id,
                'insurance_scope_id' => $inscope_id,
            ]);
        }
    }
}
