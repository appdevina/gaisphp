<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class InsuranceUpdateTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'no_polis_induk',
            'no_polis',
            'asuransi_stok',
            'nilai_stok',
            'asuransi_bangunan',
            'nilai_bangunan',
            'tanggal_mulai',
            'tanggal_akhir',
        ];
    }
}
