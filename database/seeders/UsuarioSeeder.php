<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $moderadorRole = Role::firstOrCreate(['name' => 'moderador']);

        // Crear usuario Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@reutilizagt.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin1234'),
            ]
        );
        $admin->syncRoles([$adminRole]);

        // Crear usuario Moderador
        $moderador = User::firstOrCreate(
            ['email' => 'moderador@reutilizagt.com'],
            [
                'name' => 'Moderador',
                'password' => Hash::make('mod1234'),
            ]
        );
        $moderador->syncRoles([$moderadorRole]);
    }
}
