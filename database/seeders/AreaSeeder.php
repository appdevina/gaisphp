<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('areas')->insert([
            [
                'area' => '-',   
            ],
            [
                'area' => 'COO',   
            ],
            [
                'area' => 'CSO',   
            ],
            [
                'area' => 'RETAIL',
            ],
            [
                'area' => 'DEPO',
            ],
            [
                'area' => 'CME',
            ],
            [
                'area' => 'AMZ',
            ],
            [
                'area' => 'ANN',
            ],
            [
                'area' => 'CMM',
            ],
            [
                'area' => 'DLP',
            ],
        ],
    );
    }
}
