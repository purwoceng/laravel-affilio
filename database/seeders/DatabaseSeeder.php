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
        $this->call([
            UserRolePermissionSeeder::class,
            MemberTypeSeeder::class,
            MemberTableSeeder::class,
            InvoiceSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class,
        ]);
    }
}
