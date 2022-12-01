<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $role = DB::table('user_roles')->where('name', 'Super User')->first();

        DB::table('users')->insert([
            'user_role_id' => $role->id,
            'name' => 'Super User',
            'email' => 'dandi@aplikasix.dev',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'email_verified_at' => '2022-12-01 20:55:00',
            'created_at' => '2022-12-01 20:55:00',
            'updated_at' => '2022-12-01 20:55:00',
        ]);
    }
}
