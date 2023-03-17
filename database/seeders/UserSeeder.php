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
                ##1
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
                ##2
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
                ##3
                'username' => 'ga',   
                'fullname' => 'ADMIN GA',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 3,
                'division_id' => 6,
                'role_id' => 3,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##4
                'username' => 'dian',   
                'fullname' => 'DIAN FATMAWATI',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 1,
                'division_id' => 9,
                'role_id' => 3,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##5
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
                ##6
                'username' => 'itsupport1',   
                'fullname' => 'MEKA NURUL HAYAT',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 11,
                'role_id' => 3,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##7
                'username' => 'itsupport2',   
                'fullname' => 'BAGUS FAJAR HERLANI',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 11,
                'role_id' => 3,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##8
                'username' => 'itsupport3',   
                'fullname' => 'MUHAMMAD DITO PRAMUDYA',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 11,
                'role_id' => 3,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##9
                'username' => 'itsupport4',   
                'fullname' => 'SAEPUL BAHRI',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 11,
                'role_id' => 3,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##10
                'username' => 'busdev',   
                'fullname' => 'BUSDEV',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 2,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##11
                'username' => 'finance',   
                'fullname' => 'FINANCE',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 3,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##12
                'username' => 'financepajak',   
                'fullname' => 'FINANCE PAJAK',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 4,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##13
                'username' => 'financear',   
                'fullname' => 'FINANCE AR',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 5,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##14
                'username' => 'hcm',   
                'fullname' => 'HUMAN CAPITAL',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 6,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##12
                'username' => 'marcomm',   
                'fullname' => 'MARCOMM',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 7,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##13
                'username' => 'purchase',   
                'fullname' => 'SCM-PURCHASE',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 8,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##14
                'username' => 'whm',   
                'fullname' => 'SCM-WAREHOUSE',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 9,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##15
                'username' => 'data',   
                'fullname' => 'MIS-DATA',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 10,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##16
                'username' => 'it',   
                'fullname' => 'MIS-IT',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 11,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##17
                'username' => 'audit',   
                'fullname' => 'AUDIT',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 12,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##18
                'username' => 'online',   
                'fullname' => 'ONLINE',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 13,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
            [
                ##19
                'username' => 'telemarketing',   
                'fullname' => 'TELEMARKETING',
                'password' => bcrypt('complete123'),
                'badan_usaha_id' => 2,
                'division_id' => 14,
                'role_id' => 4,
                'profile_picture' => null,
                'approval_id' => 1,
                'notif_id' => null,
                'remember_token' => Str::random(60),
            ],
        ],
    );
    }
}
