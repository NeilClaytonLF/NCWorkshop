<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         /**
         * Clear out cached roles and persmissions
         */
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /**
         * Create the required Permissions needed use Spatie Laravel Permissions
         */
        Permission::create(['name' => 'add user']);

        /**
         * Create roles (Admin and User) and assign required permissions
         */
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo('add user');

        $user = Role::create(['name' => 'user']);

        /**
         * Create Demo Users
         */
        $adminUser = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@workshoptracker.test'
        ]);
        $adminUser->assignRole($admin);

        $standardUser = \App\Models\User::factory()->create([
            'name' => 'Standard User',
            'email' => 'user@workshoptracker.test'
        ]);

        
    }
}
