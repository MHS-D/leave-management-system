<?php

namespace Database\Seeders;

use App\Constants\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Disable foreign key constraints to avoid issues with truncating
        // the users table if it has foreign key references
        Schema::disableForeignKeyConstraints();
        User::truncate();


        $data = [
            config('settings.roles.names.adminRole') =>
             [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'username' => 'super_admin',
                'phone' => '123456789',
                'password' => Hash::make('123456789'),
                'status' => Status::ACTIVE,
            ],

            config('settings.roles.names.employeeRole') =>
            [
                'first_name' => 'Employee',
                'last_name' => 'Employee',
                'username' => 'employee',
                'phone' => '123456789',
                'password' => Hash::make('123456789'),
                'status' => Status::ACTIVE,
            ],
        ];

        foreach ($data as $role => $userData) {
            $user = User::create($userData);
            $user->assignRole($role);
        }
    }
}
