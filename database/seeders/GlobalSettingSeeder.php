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
                'key' => "markup_global",
                'value' => "10",
            ],
        ];

        foreach ($markup as $key => $value) {
            GlobalSetting::create([
                'key' => $value['key'],
                'value' => $value['value'],
            ]);
        }
    }
}
