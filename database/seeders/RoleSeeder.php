<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{

    private $permissions = [
        'role-assign',    'role-revoke',
        'role-list',      'role-show',      'role-create',     'role-edit',      'role-delete',
        'joke-list',   'joke-show',   'joke-create',  'joke-edit',   'joke-delete',
        'user-list',      'user-show',      'user-create',     'user-edit',      'user-delete',
        'members',   'trash-clear',    'trash-recover',
    ];


    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create each of the permissions ready for role creation
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Generate the Super-Admin Role
        $roleSuperAdmin = Role::create(['name' => 'Super-Admin']);
        $permissionsAll = Permission::pluck('id', 'id')->all();
        $roleSuperAdmin->syncPermissions($permissionsAll);

        // Generate the Admin Role
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleAdmin->givePermissionTo('role-assign');
        $roleAdmin->givePermissionTo('role-revoke');
        $roleAdmin->givePermissionTo('joke-list');
        $roleAdmin->givePermissionTo('joke-show');
        $roleAdmin->givePermissionTo('joke-create');
        $roleAdmin->givePermissionTo('joke-edit');
        $roleAdmin->givePermissionTo('joke-delete');
        $roleAdmin->givePermissionTo('user-list');
        $roleAdmin->givePermissionTo('user-edit');
        $roleAdmin->givePermissionTo('user-show');
        $roleAdmin->givePermissionTo('user-create');
        $roleAdmin->givePermissionTo('user-delete');
        $roleAdmin->givePermissionTo('members');
        $roleAdmin->givePermissionTo('trash-clear');
        $roleAdmin->givePermissionTo('trash-recover');

        $roleStaff = Role::create(['name' => 'Staff']);
        $roleStaff->givePermissionTo([
            'joke-list', 'joke-show', 'joke-create', 'joke-edit', 'joke-delete',
            'members'
        ]);

        // Generate the Client role
        $roleUser = Role::create(['name' => 'Client']);
        $roleUser->givePermissionTo('joke-list');
        $roleUser->givePermissionTo('joke-edit');
        $roleUser->givePermissionTo('joke-show');
        $roleUser->givePermissionTo('joke-create');
        $roleUser->givePermissionTo('joke-delete');
        $roleUser->givePermissionTo('members');

//        // Unverified Guest Role
//        $roleGuest = Role::create(['name' => 'Guest']);
//        $roleGuest->givePermissionTo('joke-list');
//        $roleGuest->givePermissionTo('joke-show');
//        $roleGuest->givePermissionTo('members');

    }
}
