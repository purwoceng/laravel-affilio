<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ];

        try {
            $super_user = User::create(array_merge([
                'email' => 'super.user@aplikasi.dev',
                'username' => 'super_admin',
                'name' => 'Super User',
            ], $default_user_value));

            $admin_member = User::create(array_merge([
                'email' => 'admin.member@aplikasi.dev',
                'username' => 'admin_member',
                'name' => 'Admin Member',
            ], $default_user_value));

            $role_super_user = Role::create([
                'name' => 'super_user',
                'label' => 'Super User',
            ]);
            $role_admin_member = Role::create([
                'name' => 'admin_member',
                'label' => 'Admin Member',
            ]);

            $permission_role = Permission::create(['name' => 'read_role']);
            $permission_role = Permission::create(['name' => 'create_role']);
            $permission_role = Permission::create(['name' => 'update_role']);
            $permission_role = Permission::create(['name' => 'delete_role']);

            $permission_member = Permission::create(['name' => 'read_member']);
            $permission_member = Permission::create(['name' => 'create_member']);
            $permission_member = Permission::create(['name' => 'update_member']);
            $permission_member = Permission::create(['name' => 'delete_member']);

            $role_super_user->givePermissionTo('read_role');
            $role_super_user->givePermissionTo('create_role');
            $role_super_user->givePermissionTo('update_role');
            $role_super_user->givePermissionTo('delete_role');

            $super_user->assignRole('super_user');
            $admin_member->assignRole('admin_member');

            DB::commit();
        } catch (\Throwable $throw) {
            DB::rollBack();
        }
    }
}
