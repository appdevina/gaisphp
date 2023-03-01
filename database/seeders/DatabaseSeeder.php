<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AreaSeeder::class,
            BadanUsahaSeeder::class,
            CategorySeeder::class,
            DivisionSeeder::class,
            ProblemReportCategorySeeder::class,
            RequestTypeSeeder::class,
            RoleSeeder::class,
            UnitTypeSeeder::class,
            UserSeeder::class,
        ]);
    }
}
