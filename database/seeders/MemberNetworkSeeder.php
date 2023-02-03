<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\MemberGeneration;
use App\Models\MemberPosition;
use Illuminate\Database\Seeder;

class MemberNetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $founders_username = ['tromol', 'raals'];

        foreach ($founders_username as $username) {
            $member = Member::where('username', $username)->first();
            MemberGeneration::create(['member_id' => $member->id, 'networks' => "{$member->id}"]);
            MemberPosition::create([
                'member_id' => $member->id,
                'networks' => "{$member->id}",
                'generation' => 0,
                'member_upline_id' => 0,
            ]);
        }

        $gen_one_members = [
            [
                'username' => 'purwoceng',
                'upline' => 'raals',
            ],
            [
                'username' => 'anjas',
                'upline' => 'tromol',
            ],
            [
                'username' => 'panjiieh',
                'upline' => 'tromol',
            ],
        ];

        foreach ($gen_one_members as $first_gen) {
            $member = Member::where('username', $first_gen['username'])->first();
            $upline_member = Member::where('username', $first_gen['upline'])->first();

            $upline_generation = MemberGeneration::where('member_id', $upline_member->id)->first();

            $new_gen = "{$upline_generation->networks}.{$member->id}";
            $gen_array = array_reverse(explode('.', $new_gen));

            MemberGeneration::create(['member_id' => $member->id, 'networks' => $new_gen]);

            $gen = [];
            for ($i = 0; $i < count($gen_array); $i++) {
                if (!empty($gen_array[$i + 1])) {
                    $gen[] = $gen_array[$i];
                    $current_gen = $gen_array[$i + 1] . "." . implode('.', array_reverse($gen));

                    MemberPosition::create([
                        'member_id' => $member->id,
                        'networks' => $current_gen,
                        'generation' => $i + 1,
                        'member_upline_id' => $gen_array[$i + 1],
                    ]);
                }
            }
        }

        $gen_two_members = [
            [
                'username' => 'ucup',
                'upline' => 'purwoceng',
            ],
            [
                'username' => 'qanggriawan',
                'upline' => 'anjas',
            ],
            [
                'username' => 'rendy_hakim',
                'upline' => 'panjiieh',
            ],
        ];

        foreach ($gen_two_members as $second_gen) {
            $member = Member::where('username', $second_gen['username'])->first();
            $upline_member = Member::where('username', $second_gen['upline'])->first();
            $upline_generation = MemberGeneration::where('member_id', $upline_member->id)->first();

            $new_gen = "{$upline_generation->networks}.{$member->id}";
            $gen_array = array_reverse(explode('.', $new_gen));
            MemberGeneration::create(['member_id' => $member->id, 'networks' => $new_gen]);

            $gen = [];
            for ($i = 0; $i < count($gen_array); $i++) {
                if (!empty($gen_array[$i + 1])) {
                    $gen[] = $gen_array[$i];
                    $current_gen = $gen_array[$i + 1] . "." . implode('.', array_reverse($gen));

                    MemberPosition::create([
                        'member_id' => $member->id,
                        'networks' => $current_gen,
                        'generation' => $i + 1,
                        'member_upline_id' => $gen_array[$i + 1],
                    ]);
                }
            }
        }

        $gen_three_members = [
            [
                'username' => 'hani_permadi',
                'upline' => 'ucup',
            ],
            [
                'username' => 'nwijayanti',
                'upline' => 'qanggriawan',
            ],
        ];

        foreach ($gen_three_members as $third_gen) {
            $member = Member::where('username', $third_gen['username'])->first();
            $upline_member = Member::where('username', $third_gen['upline'])->first();
            $upline_generation = MemberGeneration::where('member_id', $upline_member->id)->first();

            $new_gen = "{$upline_generation->networks}.{$member->id}";
            $gen_array = array_reverse(explode('.', $new_gen));
            MemberGeneration::create(['member_id' => $member->id, 'networks' => $new_gen]);

            $gen = [];
            for ($i = 0; $i < count($gen_array); $i++) {
                if (!empty($gen_array[$i + 1])) {
                    $gen[] = $gen_array[$i];
                    $current_gen = $gen_array[$i + 1] . "." . implode('.', array_reverse($gen));

                    MemberPosition::create([
                        'member_id' => $member->id,
                        'networks' => $current_gen,
                        'generation' => $i + 1,
                        'member_upline_id' => $gen_array[$i + 1],
                    ]);
                }
            }
        }
    }
}
