<?php

namespace Database\Seeders;

use App\Models\MemberType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'type' => "Member",
                'min_omset' => "10000000",

            ],
            [
                'type' => "Core Member",
                'min_omset' => "20000000",

            ],
            [
                'type' => "Leader",
                'min_omset' => "30000000",
            ],
            [
                'type' => "Super Leader",
                'min_omset' => "40000000",

            ],
            [
                'type' => "Bronze",
                'min_omset' => "50000000",

            ],
            [
                'type' => "Super Bronze",
                'min_omset' => "60000000",

            ],
            [
                'type' => "Silver",
                'min_omset' => "70000000",

            ],
            [
                'type' => "Super Silver",
                'min_omset' => "80000000",

            ],
            [
                'type' => "Gold",
                'min_omset' => "90000000",

            ],
            [
                'type' => "Super Gold",
                'min_omset' => "100000000",

            ],
            [
                'type' => "Platinum",
                'min_omset' => "110000000",

            ],
            [
                'type' => "Super Platinum",
                'min_omset' => "120000000",

            ],
            [
                'type' => "Diamond",
                'min_omset' => "130000000",

            ],
            [
                'type' => "Super Diamond",
                'min_omset' => "140000000",

            ],
        ];


        foreach ($types as $key => $value) {
            MemberType::create([
                'type' => $value['type'],
                'min_omset' => $value['min_omset'],
            ]);
        }
    }
}
