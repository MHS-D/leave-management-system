<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Role::truncate();
        Role::create(['name' => config('settings.roles.names.adminRole')]);
        Role::create(['name' => config('settings.roles.names.department1Role')]);
        Role::create(['name' => config('settings.roles.names.department2Role')]);
        Role::create(['name' => config('settings.roles.names.department3Role')]);
        Role::create(['name' => config('settings.roles.names.department4Role')]);
        Role::create(['name' => config('settings.roles.names.department5Role')]);
        Role::create(['name' => config('settings.roles.names.department6Role')]);
        Role::create(['name' => config('settings.roles.names.subAdminRole')]);

        Schema::enableForeignKeyConstraints();
    }
}
