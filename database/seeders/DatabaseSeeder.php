<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([

            TenantSeeder::class,
            RoleSeeder::class,
            UsuarioSeeder::class,
            PagosSeeder::class,
            LocationRecordSeeder::class,
            DepartamentoSeeder::class,
            CargoSeeder::class,
            EmpleadoSeeder::class,
            PuestosDisponiblesSeeder::class,
        ]);
    }
}