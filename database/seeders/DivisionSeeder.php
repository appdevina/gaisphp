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
                ##1
                'division' => '-',
                'area_id' => 1,   
            ],
            [
                ##2
                'division' => 'BUSDEV',
                'area_id' => 2,   
            ],
            [
                ##3
                'division' => 'FINANCE',
                'area_id' => 2,
            ],
            [
                ##4
                'division' => 'FINANCE-PAJAK',
                'area_id' => 2,
            ],
            [
                ##5
                'division' => 'FINANCE-AR',
                'area_id' => 2,
            ],
            [
                ##6
                'division' => 'HCM',
                'area_id' => 2,
            ],
            [
                ##7
                'division' => 'MARCOMM',
                'area_id' => 2,
            ],
            [
                ##8
                'division' => 'SCM-PURCHASE',
                'area_id' => 2,
            ],
            [
                ##9
                'division' => 'WHM',
                'area_id' => 2,
            ],
            [
                ##10
                'division' => 'MIS-DATA',
                'area_id' => 2,
            ],
            [
                ##11
                'division' => 'MIS-IT',
                'area_id' => 2,
            ],
            [
                ##12
                'division' => 'AUDIT',
                'area_id' => 2,
            ],
            [
                ##13
                'division' => 'ONLINE',
                'area_id' => 2,
            ],
            [
                ##14
                'division' => 'TELEMARKETING',
                'area_id' => 2,
            ],
            [
                ##15
                'division' => 'DEPO-CRB-HO',
                'area_id' => 4,
            ],
            [
                ##16
                'division' => 'CS-CILEDUG',
                'area_id' => 3,
            ],
            [
                ##17
                'division' => 'CS-PETRATEAN',
                'area_id' => 3,
            ],
            [
                ##18
                'division' => 'CS-SINDANG',
                'area_id' => 3,
            ],
            [
                ##19
                'division' => 'CS-TUPAREV',
                'area_id' => 3,
            ],
            [
                ##20
                'division' => 'CS-PABUARAN2',
                'area_id' => 3,
            ],
            [
                ##21
                'division' => 'MISHOP-CILEDUG',
                'area_id' => 3,
            ],
            [
                ##22
                'division' => 'CS-GEBANG',
                'area_id' => 3,
            ],
            [
                ##23
                'division' => 'HPMART-SINDANG',
                'area_id' => 3,
            ],
            [
                ##24
                'division' => 'CS-PATROL',
                'area_id' => 3,
            ],
            [
                ##25
                'division' => 'CS-JATIWANGI1',
                'area_id' => 3,
            ],
            [
                ##26
                'division' => 'CS-JATIWANGI2',
                'area_id' => 3,
            ],
            [
                ##27
                'division' => 'CS-CILACAP',
                'area_id' => 3,
            ],
            [
                ##28
                'division' => 'CS-SURYA',
                'area_id' => 3,
            ],
            [
                ##29
                'division' => 'CS-PERUM',
                'area_id' => 3,
            ],
            [
                ##30
                'division' => 'CS-BABAKAN',
                'area_id' => 3,
            ],
            [
                ##31
                'division' => 'CS-SUBANG',
                'area_id' => 3,
            ],
            [
                ##32
                'division' => 'CS-TEGAL',
                'area_id' => 3,
            ],
            [
                ##33
                'division' => 'OS-TP',
                'area_id' => 3,
            ],
            [
                ##34
                'division' => 'GHM',
                'area_id' => 3,
            ],
            [
                ##35
                'division' => 'TRANSSION-STORE',
                'area_id' => 3,
            ],
            [
                ##36
                'division' => 'DEPO-ACC',
                'area_id' => 4,
            ],
            [
                ##37
                'division' => 'DEPO-PWT',
                'area_id' => 4,
            ],
            [
                ##38
                'division' => 'DEPO-SEMARANG',
                'area_id' => 4,
            ],
            [
                ##39
                'division' => 'DEPO-JOGJA',
                'area_id' => 4,
            ],
            [
                ##40
                'division' => 'DEPO-PWK',
                'area_id' => 4,
            ],
            [
                ##41
                'division' => 'DEPO-BANDUNG',
                'area_id' => 4,
            ],
            [
                ##42
                'division' => 'DEPO-JAKARTA',
                'area_id' => 4,
            ],
            [
                ##43
                'division' => 'DEPO-TEGAL',
                'area_id' => 4,
            ],
            [
                ##44
                'division' => 'DEPO-LOGISTIK',
                'area_id' => 4,
            ],
            [
                ##45
                'division' => 'GCRB-RETUR',
                'area_id' => 4,
            ],
            [
                ##46
                'division' => 'GCRB-HP',
                'area_id' => 4,
            ],
            [
                ##47
                'division' => 'MKLI-BANDUNG',
                'area_id' => 5,
            ],
            [
                ##48
                'division' => 'MKLI-CIREBON',
                'area_id' => 5,
            ],
            [
                ##49
                'division' => 'MKLI-DADAP',
                'area_id' => 5,
            ],
            [
                ##50
                'division' => 'MKLI-KARAWANG',
                'area_id' => 5,
            ],
            [
                ##51
                'division' => 'MKLI-PURWOKERTO',
                'area_id' => 5,
            ],
            [
                ##52
                'division' => 'MKLI-TANGERANG',
                'area_id' => 5,
            ],
            [
                ##53
                'division' => 'MKLI-PURWAKARTA',
                'area_id' => 5,
            ],
            [
                ##54
                'division' => 'MKLI-JOGJA',
                'area_id' => 5,
            ],
            [
                ##55
                'division' => 'MKLI-MAKASSAR',
                'area_id' => 5,
            ],
            [
                ##56
                'division' => 'MKLI-MANADO',
                'area_id' => 5,
            ],
            [
                ##57
                'division' => 'MKLI-PEKANBARU',
                'area_id' => 5,
            ],
            [
                ##58
                'division' => '4S-CILEDUG',
                'area_id' => 6,
            ],
            [
                ##59
                'division' => '4S-SINDANG',
                'area_id' => 6,
            ],
            [
                ##60
                'division' => '4S-RENGAS',
                'area_id' => 6,
            ],
            [
                ##61
                'division' => '4S-PASIRKOJA',
                'area_id' => 6,
            ],
            [
                ##62
                'division' => '4S-TELAGASARI',
                'area_id' => 6,
            ],
            [
                ##63
                'division' => 'COMPLETEME',
                'area_id' => 7,
            ],
            [
                ##64
                'division' => 'AMAZY',
                'area_id' => 8,
            ],
            [
                ##65
                'division' => 'TKANAN',
                'area_id' => 9,
            ],
            [
                ##62
                'division' => 'CMULIA',
                'area_id' => 10,
            ],
        ],
    );
    }
}
