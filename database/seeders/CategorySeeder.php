<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'category' => 'ASSET/NONASSET',   
            ],
            [
                'category' => 'ATK',   
            ],
            [
                'category' => 'NOTA',   
            ],
        ],
    );
    }
}
