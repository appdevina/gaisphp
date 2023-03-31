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
                'area' => 'HO',   
            ],
            [
                'area' => 'TOKO',   
            ],
            [
                'area' => 'TOP',
            ],
            [
                'area' => 'MKLI-DEPO',
            ],
            [
                'area' => 'MKLI-4S',
            ],
            [
                'area' => 'COMPLETEME',
            ],
            [
                'area' => 'AMAZY',
            ],
            [
                'area' => 'TKANAN',
            ],
            [
                'area' => 'CMULIA',
            ],
        ],
    );
    }
}
