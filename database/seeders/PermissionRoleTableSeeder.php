<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_permissions = Permission::all();
        $user_permissions = Permission::whereIn('title', ['acesso_alunos', 'enxergar_alunos'])->get();

        Role::find(1)->permissions()->attach($admin_permissions);
        Role::find(2)->permissions()->attach($user_permissions);
    }
}
