<?php

namespace App\Exports;

use App\Models\RequestBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RequestExport implements FromCollection, WithHeadings, WithMapping
{
    protected String $date1;
    protected String $date2;

    function __construct(String $date1, String $date2)
    {
        $this->date1 = $date1;
        $this->date2 = $date2;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $date1 = $this->date1;
        $date2 = $this->date2;

        return RequestBarang::with('user','closedby','request_detail','request_type')
            ->whereBetween('date', [$date1, $date2])
            ->orderBy('date')
            ->get();
    }

    public function headings(): array
    {
        return [
            'pengaju',
            'diajukan pada',
            'tipe pengajuan',
            'lampiran',
            'status po',
            'diproses oleh',
            'diproses pada',
            'status akhir',
        ];
    }

    public function map($row): array
    {
        return [
            $row->user->fullname ?? 'Nonactive users',
            $row->date,
            $row->request_type->request_type,
            $row->request_file,
            $row->status_po == 0 ? 'TIDAK' : 'YA',
            $row->closedby->fullname ?? 'Nonactive users',
            $row->closed_at,
            $row->status_client == 0 ? 'MENUNGGU' : 'SELESAI',
        ];
    }
}
