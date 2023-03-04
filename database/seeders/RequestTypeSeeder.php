<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('request_type')->insert([
            [
                'request_type' => 'ASSET/NON ASSET',
                'approval_id' => 1,   
            ],
            [
                'request_type' => 'ATK',
                'approval_id' => 1,
            ],
        ],
    );
    }
}
