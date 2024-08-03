<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'file.viewAny']);
        Permission::create(['name' => 'file.create']);
        Permission::create(['name' => 'file.edit']);
        Permission::create(['name' => 'file.editAny']);
        Permission::create(['name' => 'file.delete']);
        Permission::create(['name' => 'file.deleteAny']);

        Permission::create(['name' => 'post.viewAny']);
        Permission::create(['name' => 'post.create']);
        Permission::create(['name' => 'post.editAny']);
        Permission::create(['name' => 'post.edit']);
        Permission::create(['name' => 'post.deleteAny']);
        Permission::create(['name' => 'post.delete']);
        Permission::create(['name' => 'post.publish']);
        Permission::create(['name' => 'post.unpublish']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'creator']);
        $role1->givePermissionTo('file.create');
        $role1->givePermissionTo('file.edit');
        $role1->givePermissionTo('file.delete');

        $role1->givePermissionTo('post.create');
        $role1->givePermissionTo('post.edit');
        $role1->givePermissionTo('post.delete');
        $role1->givePermissionTo('post.publish');
        $role1->givePermissionTo('post.unpublish');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('file.viewAny');
        $role2->givePermissionTo('file.editAny');
        $role2->givePermissionTo('file.deleteAny');
        $role2->givePermissionTo('post.viewAny');
        $role2->givePermissionTo('post.editAny');
        $role2->givePermissionTo('post.deleteAny');

        Role::create(['name' => 'super']);
        // gets all permissions via Gate::before rule; see AppServiceProvider
    }
}
