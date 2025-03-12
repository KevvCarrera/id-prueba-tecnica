<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions products
        Permission::create(['name' => 'list-product']);
        Permission::create(['name' => 'create-product']);
        Permission::create(['name' => 'update-product']);
        Permission::create(['name' => 'delete-product']);

        // create permissions sales
        Permission::create(['name' => 'list-sales']);
        Permission::create(['name' => 'create-sales']);
        Permission::create(['name' => 'update-sales']);
        Permission::create(['name' => 'delete-sales']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'vendedor']);
        $role1->givePermissionTo('list-product');
        $role1->givePermissionTo('create-product');
        $role1->givePermissionTo('update-product');
        $role1->givePermissionTo('create-sales');

        $role2 = Role::create(['name' => 'admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create users
        $user = \App\Models\User::factory()->create([
            'name' => 'Vendedor',
            'last_name' => 'User',
            'email' => 'tester@example.com',
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($role2);
    }
}