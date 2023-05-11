<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Member::factory()->count(50)->create();

        $members = json_decode(file_get_contents(public_path() . "/dummy_data/member.json"), true);

        foreach ($members as $key => $value) {
            Member::create([
                "member_type_id" => $value['member_type_id'],
                "username" => $value['username'],
                "email" => $value['email'],
                "name" => $value['name'],
                "phone" => $value['phone'],
                "hash" => Hash::make($value['hash']),
                "referral" => $value['referral'],
                "is_verified" => $value['is_verified'],
                "is_blocked" => $value['is_blocked'],
                "publish" => $value['publish'],
            ]);
        }
    }
}
