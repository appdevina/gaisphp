<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadanUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('badan_usahas')->insert([
            [
                'badan_usaha' => '-',   
            ],
            [
                'badan_usaha' => 'CV.CS',   
            ],
            [
                'badan_usaha' => 'CV.TOP',
            ],
            [
                'badan_usaha' => 'PT.MKLI',
            ]
        ],
    );
    }
}
