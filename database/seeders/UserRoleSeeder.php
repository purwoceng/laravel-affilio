<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserRoleSeeder extends Seeder
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
            $akuntansi = User::create(array_merge([
                'email' => 'arimunandar@aplikasi.dev',
                'username' => 'akuntansi123',
                'name' => 'akuntansi123',
            ], $default_user_value));

            $supplier = User::create(array_merge([
                'email' => 'anjas@aplikasi.dev',
                'username' => 'supplier123',
                'name' => 'supplier123',
            ], $default_user_value));

            $konten = User::create(array_merge([
                'email' => 'panji@aplikasi.dev',
                'username' => 'konten123',
                'name' => 'konten123',
            ], $default_user_value));

            $even = User::create(array_merge([
                'email' => 'robby@aplikasi.dev',
                'username' => 'even123',
                'name' => 'even123',
            ], $default_user_value));

            $view = User::create(array_merge([
                'email' => 'robby@aplikasi.dev',
                'username' => 'view123',
                'name' => 'view123',
            ], $default_user_value));


            // $role_super_user = Role::create([
            //     'name' => 'super_user',
            //     'label' => 'Super User',
            // ]);

            $role_akuntansi = Role::create([
                'name' => 'akuntansi',
                'label' => 'Akuntansi',
            ]);
            $role_supplier = Role::create([
                'name' => 'supplier',
                'label' => 'Supplier',
            ]);
            $role_konten = Role::create([
                'name' => 'konten',
                'label' => 'Konten',
            ]);
            $role_even = Role::create([
                'name' => 'even',
                'label' => 'Even',
            ]);
            $role_view = Role::create([
                'name' => 'view',
                'label' => 'View',
            ]);

            // $role_admin_member = Role::create([
            //     'name' => 'admin_member',
            //     'label' => 'Admin Member',
            // ]);

            $permission_role = Permission::create(['name' => 'read_role']);
            $permission_role = Permission::create(['name' => 'create_role']);
            $permission_role = Permission::create(['name' => 'update_role']);
            $permission_role = Permission::create(['name' => 'delete_role']);

            $permission_konten = Permission::create(['name' => 'read_konten']);
            $permission_konten = Permission::create(['name' => 'create_konten']);
            $permission_konten = Permission::create(['name' => 'update_konten']);
            $permission_konten = Permission::create(['name' => 'delete_konten']);

            $permission_akuntansi = Permission::create(['name' => 'read_akuntansi']);
            $permission_akuntansi = Permission::create(['name' => 'create_akuntansi']);
            $permission_akuntansi = Permission::create(['name' => 'update_akuntansi']);
            $permission_akuntansi = Permission::create(['name' => 'delete_akuntansi']);

            $permission_view = Permission::create(['name' => 'read_view']);
            $permission_view = Permission::create(['name' => 'create_view']);
            $permission_view = Permission::create(['name' => 'update_view']);
            $permission_view = Permission::create(['name' => 'delete_view']);

            $permission_even = Permission::create(['name' => 'read_even']);
            $permission_even = Permission::create(['name' => 'create_even']);
            $permission_even = Permission::create(['name' => 'update_even']);
            $permission_even = Permission::create(['name' => 'delete_even']);

            $permission_supplier = Permission::create(['name' => 'read_supplier']);
            $permission_supplier = Permission::create(['name' => 'create_supplier']);
            $permission_supplier = Permission::create(['name' => 'update_supplier']);
            $permission_supplier = Permission::create(['name' => 'delete_supplier']);

            $permission_member = Permission::create(['name' => 'read_member']);
            $permission_member = Permission::create(['name' => 'create_member']);
            $permission_member = Permission::create(['name' => 'update_member']);
            $permission_member = Permission::create(['name' => 'delete_member']);

            $role_super_user->givePermissionTo('read_role');
            $role_super_user->givePermissionTo('create_role');
            $role_super_user->givePermissionTo('update_role');
            $role_super_user->givePermissionTo('delete_role');

            $role_akuntansi->givePermissionTo('read_akuntansi');
            $role_akuntansi->givePermissionTo('create_akuntansi');
            $role_akuntansi->givePermissionTo('update_akuntansi');
            $role_akuntansi->givePermissionTo('delete_akuntansi');

            $role_supplier->givePermissionTo('read_supplier');
            $role_supplier->givePermissionTo('create_supplier');
            $role_supplier->givePermissionTo('update_supplier');
            $role_supplier->givePermissionTo('delete_supplier');

            $role_konten->givePermissionTo('read_konten');
            $role_konten->givePermissionTo('create_konten');
            $role_konten->givePermissionTo('update_konten');
            $role_konten->givePermissionTo('delete_konten');

            $role_even->givePermissionTo('read_even');
            $role_even->givePermissionTo('create_even');
            $role_even->givePermissionTo('update_even');
            $role_even->givePermissionTo('delete_even');

            $role_view->givePermissionTo('read_view');
            $role_view->givePermissionTo('create_view');
            $role_view->givePermissionTo('update_view');
            $role_view->givePermissionTo('delete_view');

            // $super_user->assignRole('super_user');
            // $admin_member->assignRole('admin_member');
            $akuntansi->assignRole('akuntansi');
            $supplier->assignRole('supplier');
            $konten->assignRole('konten');
            $even->assignRole('even');
            $view->assignRole('view');



            DB::commit();
        } catch (\Throwable $throw) {
            DB::rollBack();
        }
    }
}
