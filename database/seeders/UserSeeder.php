<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',   
                'fullname' => 'ADMIN',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 1,
                'division_id' => 1,
                'role_id' => 1,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                'username' => 'accounting',   
                'fullname' => 'ACCOUNTING',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 1,
                'division_id' => 1,
                'role_id' => 2,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                'username' => 'ga',   
                'fullname' => 'ADMIN GA',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 3,
                'division_id' => 4,
                'role_id' => 3,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                'username' => 'arik',   
                'fullname' => 'ARIK CAHYA HIDAYAT',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 3,
                'division_id' => 2,
                'role_id' => 3,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                'username' => 'sandi',   
                'fullname' => 'SANDI DWI H',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 2,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 4,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                'username' => 'farid',   
                'fullname' => 'FARID',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 2,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 4,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                'username' => 'devina',   
                'fullname' => 'DEVINA VIANTIE',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 2,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 4,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                'username' => 'umam',   
                'fullname' => 'NASIHUL UMAM',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 3,
                'division_id' => 2,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 4,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
        ],
    );
    }
}
