<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class InsuranceTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'no_polis_induk',
            'alamat_tertanggung',
            'nama_tertanggung',
            'kode_gudang',
            'detail_asuransi',
            'alamat_yang_diasuransikan',
            'kategori_asuransi',
            'cakupan_asuransi',
        ];
    }
}
