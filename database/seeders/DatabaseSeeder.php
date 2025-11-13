<?php

namespace Database\Seeders;
use Database\Seeders\IncidenciaSeeder;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(IncidenciaSeeder::class); 
        $this->call([
            RoleSeeder::class,     // 1. Crear roles y permisos
            TenantSeeder::class,   // 3. Crear tenant y dominio
            UsuarioSeeder::class,  // 2. Crear usuario y asignarle rol

            // User::factory()->create([
            //     'name' => 'Test User',
            //     'email' => 'test@example.com',
        ]);
    }
    

}
 
