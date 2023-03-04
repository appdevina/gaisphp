<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProblemReportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('problem_report_categories')->insert([
            [
                'problem_report_category' => 'KOMPUTER',
            ],
            [
                'problem_report_category' => 'LAPTOP',
            ],
            [
                'problem_report_category' => 'PRINTER',
            ],
            [
                'problem_report_category' => 'SOFTWARE/APLIKASI',
            ],
            [
                'problem_report_category' => 'KONEKSI',
            ],
            [
                'problem_report_category' => 'CCTV',
            ],
            [
                'problem_report_category' => 'UMUM',
            ],
        ],
    );
    }
}
