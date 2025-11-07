<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Departamento;
use App\Models\Cargo;
use App\Models\Conversacion; // <-- AÑADIDO
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class PruebasChatSeeder extends Seeder
{
    public function run(): void
    {
        // ... (Pasos 1-3: Crear Rol, Depto, Cargo - esto es igual) ...
        $this->command->info('Creando Rol, Departamento y Cargo de prueba...');
        $rrhhRole = Role::firstOrCreate(['name' => 'Recursos Humanos']);
        $depto = Departamento::firstOrCreate(
            ['nombre' => 'Departamento General'],
            ['descripcion' => 'Departamento para pruebas', 'tenant_id' => tenant('id')]
        );
        $cargo = Cargo::firstOrCreate(
            ['nombre' => 'Empleado General', 'departamento_id' => $depto->id],
            ['descripcion' => 'Cargo para pruebas', 'tenant_id' => tenant('id')]
        );

        // ... (Pasos 4-5: Crear Usuarios - esto es igual) ...
        $this->command->info('Creando usuarios de prueba (empleado@test.com y rrhh@test.com)...');
        $userEmpleado = User::firstOrCreate(
            ['email' => 'empleado@test.com'],
            [
                'name' => 'Empleado Prueba',
                'password' => Hash::make('password'),
                'tenant_id' => tenant('id')
            ]
        );
        $userRRHH = User::firstOrCreate(
            ['email' => 'rrhh@test.com'],
            [
                'name' => 'RRHH Prueba',
                'password' => Hash::make('password'),
                'tenant_id' => tenant('id')
            ]
        );
        $userRRHH->assignRole($rrhhRole);

        // ... (Paso 6: Crear Perfil de Empleado - esto es igual) ...
        Empleado::firstOrCreate(
            ['user_id' => $userEmpleado->id],
            [
                'nombre' => $userEmpleado->name,
                'nombre_completo' => $userEmpleado->name,
                'correo' => $userEmpleado->email,
                'departamento_id' => $depto->id,
                'cargo_id' => $cargo->id,
                'tenant_id' => tenant('id')
            ]
        );
        $this->command->info('Configuración de usuarios lista.');

        // --- ¡NUEVO! PASO 7: Crear una conversación de bienvenida ---
        $this->command->info('Creando conversación de bienvenida...');
        
        $conversacion = Conversacion::create([
            'tenant_id' => tenant('id'),
            'asunto' => 'Consulta de Bienvenida (Prueba)',
        ]);

        // Adjuntar participantes
        $conversacion->participantes()->attach($userEmpleado->id);
        $conversacion->participantes()->attach($userRRHH->id);

        // Añadir mensajes de prueba
        $conversacion->mensajes()->create([
            'user_id' => $userEmpleado->id,
            'contenido' => 'Hola, solo quería probar el nuevo chat. ¡Gracias!'
        ]);
        
        $conversacion->mensajes()->create([
            'user_id' => $userRRHH->id,
            'contenido' => '¡Recibido! El chat funciona. Bienvenido.'
        ]);

        $this->command->info('¡Seeder completado! La base de datos está lista para probar.');
    }
}