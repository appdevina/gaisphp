<?php

namespace App\Imports;

use App\Models\Insurance;
use App\Models\InsuranceUpdate;
use App\Models\InsuranceProvider;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Exception;

class InsuranceUpdateImport implements ToModel, WithHeadingRow
{
    protected String $insurance_id;

    function __construct(String $insurance_id)
    {
        $this->insurance_id = $insurance_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row) 
    {
        //Cari sampel salah satu data di insurance_update
        $insurance_update = InsuranceUpdate::where('policy_number', $row['no_polis_induk'])->get();

        //kalau ada first() ambil 1
        if ($insurance_update->first()) {
            //cari sampel Insurance/parent dengan id dari sampel insurance_update
            $insurance = Insurance::find($insurance_update->first()->insurance_id);

            $stock_inprov_id = InsuranceProvider::where('insurance_provider', preg_replace('/\s+/', '', $row['asuransi_stok']))->first()->id ?? null;
            $building_inprov_id = InsuranceProvider::where('insurance_provider', preg_replace('/\s+/', '', $row['asuransi_bangunan']))->first()->id ?? null;

            //Ambil semua insurance_update yang memiliki insurance_id seperti Insurance/parent
            $existing_inupdate = InsuranceUpdate::where('insurance_id', $insurance->id)->get();

            //Looping semua data insurance_update existing (bentuk list)
            for ($i = 0; $i < count($existing_inupdate); $i++) {
                //kalau policy_number index ke-n existing_inupdate sama dengan row[no_polis] di excel
                if ($existing_inupdate[$i]->policy_number == $row['no_polis']) {
                    //maka update
                    $existing_inupdate[$i]->update([
                        'insurance_id' => $insurance->id,
                        'policy_number' => $row['no_polis'], 
                        'stock_inprov_id' => $stock_inprov_id,
                        'building_inprov_id' => $building_inprov_id,
                        'stock_worth' => $row['nilai_stok'],
                        'actual_stock_worth' => ($row['nilai_aktual_stok'] !== null && $row['nilai_aktual_stok'] !== '') ? $row['nilai_aktual_stok'] : null,
                        'stock_premium' => $row['premi_stok'],
                        'building_worth' => $row['nilai_bangunan'],
                        'building_premium' => $row['premi_bangunan'],
                        'join_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_mulai']),
                        'expired_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_akhir']),
                        'user_id' => Auth::id(),
                        'notes' => $row['catatan'],
                        'status' => $row['status'] ?? 'BERJALAN',
                    ]);
                } else {
                    //tapi kalau index ke-n existing_inupdate tidak sama dengan row[no_polis]
                    //update status data sebelumnya jadi pembaharuan
                    $existing_inupdate[$i]->status = 'PEMBAHARUAN';
                    $existing_inupdate[$i]->save();

                    //lalu jika index terakhir itu sama dengan panjang dari list existing_inupdate DAN row[no_polis] tidak ada dalam list existing_inupdate
                    if ($i == (count($existing_inupdate) - 1) && !$existing_inupdate->contains(function ($value, $key) use($row) {
                        return $value['policy_number'] == $row['no_polis'];
                    })) {
                        //maka insert data terbaru
                        InsuranceUpdate::create([
                            'insurance_id' => $insurance->id,
                            'extension_of_policy' => $existing_inupdate[$i]->policy_number,
                            'policy_number' => $row['no_polis'], 
                            'stock_inprov_id' => $stock_inprov_id,
                            'building_inprov_id' => $building_inprov_id,
                            'stock_worth' => $row['nilai_stok'],
                            'actual_stock_worth' => ($row['nilai_aktual_stok'] !== null && $row['nilai_aktual_stok'] !== '') ? $row['nilai_aktual_stok'] : null,
                            'stock_premium' => $row['premi_stok'],
                            'building_worth' => $row['nilai_bangunan'],
                            'building_premium' => $row['premi_bangunan'],
                            'join_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_mulai']),
                            'expired_date' => Carbon::createFromFormat('Y-m-d', $row['tanggal_akhir']),
                            'user_id' => Auth::id(),
                            'notes' => $row['catatan'],
                            'status' => $row['status'] ?? 'BERJALAN',
                        ]);
                    }
                }
            }
        } else {
            throw new Exception("No Polis " . $row['no_polis_induk'] . " belum ada pada Kontrak Awal", 1);
        }
    }
}
