<?php

namespace Database\Seeders;

use App\Constants\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

        // Create "Admin"
        $user_admin = User::create([
            'first_name' => 'مدير',
            'last_name' => 'Admin',
            'username' => 'admin',
            'phone' => '123456789',
            'password' => Hash::make('123456789'),
            'status' => Status::ACTIVE,
        ]);
        $user_admin->assignRole(config('settings.roles.names.adminRole'));

    }
}
