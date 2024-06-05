<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'title' => 'criar_regras',
            ],
            [
                'title' => 'editar_regras',
            ],
            [
                'title' => 'enxergar_regras',
            ],
            [
                'title' => 'apagar_regras',
            ],
            [
                'title' => 'acesso_regras',
            ],
            [
                'title' => 'criar_alunos',
            ],
            [
                'title' => 'editar_alunos',
            ],
            [
                'title' => 'enxergar_alunos',
            ],
            [
                'title' => 'apagar_alunos',
            ],
            [
                'title' => 'acesso_alunos',
            ],
        ];

        Permission::insert($permissions);
    }
}
