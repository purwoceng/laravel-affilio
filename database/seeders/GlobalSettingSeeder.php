<?php

namespace Database\Seeders;

use App\Models\GlobalSetting;
use Illuminate\Database\Seeder;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $markup = [
            [
                'key' => "markup global",
                'markup_price' => "10",
            ],
        ];

        foreach ($markup as $key => $value) {
            GlobalSetting::create([
                'key' => $value['key'],
                'markup_price' => $value['markup_price'],
            ]);
        }
    }
}
