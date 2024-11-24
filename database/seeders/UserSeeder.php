<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get the Super Admin and Admin roles for the Administrator, Lecturer and Student
        $roleSuperAdmin = Role::whereName('Super-Admin')->get();
        $roleAdmin = Role::whereName('Admin')->get();
        $roleStaff = Role::whereName('Staff')->get();
        $roleClient = Role::whereName('Client')->get();
//        $roleGuest = Role::whereName('Guest')->get();

        // Create Super Admin User and assign the role to him.
        $userAdmin = User::create([
            'id' => 111,
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'Password1',
        ]);
        $userAdmin->assignRole([$roleSuperAdmin]);

        // Create Admin
        $userLecturer = User::create([
            'id' => 500,
            'name' => 'Adrian Gould',
            'email' => 'adrian.gould@example.com',
            'password' => 'Password1',
        ]);
        $userLecturer->assignRole([$roleAdmin]);

        $userStudent = User::create([
            'id' => 501,
            'name' => 'YANG WANG',
            'email' => 'yang@example.com',
            'password' => 'Password1',
        ]);
        $userStudent->assignRole([$roleAdmin]);

        // Create Staff
        $userStaff = User::create([
            'id' => 1000,
            'name' => "Cat A'Tonic",
            'email' => 'cat.atonic@example.com',
            'password' => 'Password1',
        ]);
        $userStaff->assignRole([$roleStaff]);

        // Creat Client (verified user)
        $userClient = User::create([
            'id' => 2000,
            'name' => "Bobbi Wang",
            'email' => 'bobbi@example.com',
            'password' => 'Password1',
        ]);
        $userClient->assignRole([$roleClient]);

        $userClient = User::create([
            'id' => 2001,
            'name' => "Neeko",
            'email' => 'neeko@example.com',
            'password' => 'Password1',
        ]);
        $userClient->assignRole([$roleClient]);

        // Creat Guest (unverified user)
//        $userGuest = User::create([
//            'id' => 3000,
//            'name' => 'Dee Mouser',
//            'email' => 'dee.mouser@example.com',
//            'password' => 'Password1',
//        ]);
//        $userGuest->assignRole([$roleGuest]);


        // User::factory(10)->create();

        User::factory()->createMany([
            [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=>'Password1',
            ],
            [
            'name' => 'Dee Mouser',
            'email' => 'dee.mouser@example.com',
            'password' => 'Password1',
            ]
        ]);
    }
}
