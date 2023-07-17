<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsByRole = [
            'admin' => [
                'create user',
                'view any user',
                'update any user',
                'delete any user',
                'export any user',

                'create project',
                'view any project',
                'update any project',
                'delete any project',
                'export any project',
            ],

        ];

        Schema::disableForeignKeyConstraints();

        // Empty permissions table
        Permission::truncate();
        DB::table('role_has_permissions')->truncate();

        // Insert permissions and assign to roles
        $insertPermissions = fn ($role) => collect($permissionsByRole[$role])
            ->map(fn ($name) => Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web'])->id)
            ->toArray();


        $permissionIdsByRole = [
            'admin' => $insertPermissions('admin'),
        ];

        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $role = Role::whereName($role)->first();

            DB::table('role_has_permissions')
                ->insert(
                    collect($permissionIds)->map(fn ($id) => [
                        'role_id' => $role->id,
                        'permission_id' => $id
                    ])->toArray()
                );
        }

        Schema::enableForeignKeyConstraints();
    }
}
