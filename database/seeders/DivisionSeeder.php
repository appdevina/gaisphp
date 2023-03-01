<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('divisions')->insert([
            [
                'division' => '-',
                'area_id' => 1,   
            ],
            [
                'division' => 'BUSDEV',
                'area_id' => 2,   
            ],
            [
                'division' => 'FAM',
                'area_id' => 2,
            ],
            [
                'division' => 'HCM',
                'area_id' => 2,
            ],
            [
                'division' => 'MIS',
                'area_id' => 2,
            ],
            [
                'division' => 'MARCOMM',
                'area_id' => 2,
            ],
            [
                'division' => 'AUDIT',
                'area_id' => 2,
            ],
            [
                'division' => 'SCM',
                'area_id' => 2,
            ],
            [
                'division' => 'WHM',
                'area_id' => 2,
            ],
            [
                'division' => 'DSM',
                'area_id' => 3,
            ],
            [
                'division' => 'ONLINE',
                'area_id' => 3,
            ],
            [
                'division' => 'COMPLETEME',
                'area_id' => 6,
            ],
            [
                'division' => 'AMAZY',
                'area_id' => 7,
            ],
            [
                'division' => 'TKANAN',
                'area_id' => 8,
            ],
            [
                'division' => 'COMPLETEMULIA',
                'area_id' => 9,
            ],
            [
                'division' => 'DOLPHIN',
                'area_id' => 10,
            ],
        ],
    );
    }
}
