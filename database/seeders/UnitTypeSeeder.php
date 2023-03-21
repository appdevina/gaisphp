<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('unit_types')->insert([
            [
                'unit_type' => 'UNIT',   
            ],
            [
                'unit_type' => 'PACK',   
            ],
            [
                'unit_type' => 'ROLL',   
            ],
            [
                'unit_type' => 'TUBE',   
            ],
            [
                'unit_type' => 'RIM',   
            ],
            [
                'unit_type' => 'DUS',   
            ],
        ],
    );
    }
}
