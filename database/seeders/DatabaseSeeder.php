<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::firstOrCreate([
            'name' => 'admin'
            ]);
        $clienteRole = Role::firstOrCreate([
            'name' => 'cliente'
        ]);
        
        // Crear usuario admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123')
            ]
        );

        $admin->assignRole($adminRole);

        // Crear usuario cliente
        $cliente = User::firstOrCreate(
            ['email' => 'cliente@example.com'],
            [
                'name' => 'Cliente',
                'password' => Hash::make('cliente123')
            ]
        );
        
        $cliente->assignRole($clienteRole);
    }
}
