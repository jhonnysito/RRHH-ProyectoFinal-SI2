<?php

namespace Tests\Feature;

use App\Models\Bitacora;
use App\Models\DetalleBitacora;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class BitacoraTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database with a test user
        $this->seed(\Database\Seeders\UsuarioSeeder::class);
    }

    /** @test */
    public function login_creates_bitacora_and_detalle_bitacora_records()
    {
        $user = User::first();

        // Assert no records exist before login
        $this->assertEquals(0, Bitacora::count());
        $this->assertEquals(0, DetalleBitacora::count());

        // Perform login
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '12345678', // Password from UsuarioSeeder
        ]);

        $response->assertRedirect('/dashboard');

        // Assert records were created
        $this->assertEquals(1, Bitacora::count());
        $this->assertEquals(1, DetalleBitacora::count());

        $bitacora = Bitacora::first();
        $detalle = DetalleBitacora::first();

        // Assert relationships
        $this->assertEquals($user->id, $bitacora->ID_Usuario);
        $this->assertEquals($bitacora->id, $detalle->ID_Bitacora);

        // Assert encrypted data can be decrypted
        $decryptedTipo = Crypt::decrypt($bitacora->tipo); // Use decrypt() for serialized data
        $this->assertEquals('Postulante', $decryptedTipo); // Listener sets this based on user type
        $this->assertEquals('POST', Crypt::decryptString($detalle->metodo));
        $this->assertStringContainsString('/login', Crypt::decryptString($detalle->ruta));
    }

    /** @test */
    public function logout_creates_bitacora_and_detalle_bitacora_records()
    {
        $user = User::first();

        // Login first
        $this->actingAs($user);

        // Get initial counts
        $initialBitacoraCount = Bitacora::count();
        $initialDetalleCount = DetalleBitacora::count();

        // Perform logout
        $response = $this->post('/logout');

        $response->assertRedirect('/');

        // Assert new records were created
        $this->assertEquals($initialBitacoraCount + 1, Bitacora::count());
        $this->assertEquals($initialDetalleCount + 1, DetalleBitacora::count());

        $bitacora = Bitacora::latest()->first();
        $detalle = DetalleBitacora::latest()->first();

        // Assert relationships
        $this->assertEquals($user->id, $bitacora->ID_Usuario);
        $this->assertEquals($bitacora->id, $detalle->ID_Bitacora);

        // Assert encrypted data can be decrypted
        $this->assertEquals('logout', Crypt::decryptString($bitacora->tipo));
        $this->assertEquals('POST', Crypt::decryptString($detalle->metodo));
        $this->assertStringContainsString('/logout', Crypt::decryptString($detalle->ruta));
    }

    /** @test */
    public function bitacora_controller_displays_user_bitacoras()
    {
        $user = User::first();

        // Create some test bitacora records
        Bitacora::create([
            'ID_Usuario' => $user->id,
            'entrada' => now(),
            'salida' => null,
            'usuario' => Crypt::encryptString('testuser'),
            'tipo' => Crypt::encryptString('login'),
            'direccionIp' => Crypt::encryptString('127.0.0.1'),
            'navegador' => Crypt::encryptString('Chrome'),
        ]);

        $this->actingAs($user);

        $response = $this->get("/bitacoras/inicio/{$user->id}");

        $response->assertStatus(200);
        $response->assertViewHas('bitacoras');
        $response->assertViewHas('usuario');
    }

    /** @test */
    public function detalle_bitacora_controller_displays_bitacora_details()
    {
        $user = User::first();

        // Create test bitacora
        $bitacora = Bitacora::create([
            'ID_Usuario' => $user->id,
            'entrada' => now(),
            'salida' => null,
            'usuario' => Crypt::encryptString('testuser'),
            'tipo' => Crypt::encryptString('login'),
            'direccionIp' => Crypt::encryptString('127.0.0.1'),
            'navegador' => Crypt::encryptString('Chrome'),
        ]);

        // Create test detalle
        DetalleBitacora::create([
            'ID_Bitacora' => $bitacora->id,
            'accion' => Crypt::encryptString('User logged in'),
            'metodo' => Crypt::encryptString('POST'),
            'hora' => now(),
            'tabla' => Crypt::encryptString('users'),
            'registroId' => Crypt::encryptString('1'),
            'ruta' => Crypt::encryptString('/login'),
        ]);

        $this->actingAs($user);

        $response = $this->get("/detbitacoras/inicio/{$bitacora->id}");

        $response->assertStatus(200);
        $response->assertViewHas('detbitacoras');
        $response->assertViewHas('bitacora');
    }

    /** @test */
    public function bitacora_relationships_work_correctly()
    {
        $user = User::first();

        $bitacora = Bitacora::create([
            'ID_Usuario' => $user->id,
            'entrada' => now(),
            'salida' => null,
            'usuario' => Crypt::encryptString('testuser'),
            'tipo' => Crypt::encryptString('login'),
            'direccionIp' => Crypt::encryptString('127.0.0.1'),
            'navegador' => Crypt::encryptString('Chrome'),
        ]);

        DetalleBitacora::create([
            'ID_Bitacora' => $bitacora->id,
            'accion' => Crypt::encryptString('User logged in'),
            'metodo' => Crypt::encryptString('POST'),
            'hora' => now(),
            'tabla' => Crypt::encryptString('users'),
            'registroId' => Crypt::encryptString('1'),
            'ruta' => Crypt::encryptString('/login'),
        ]);

        // Test User -> Bitacora relationship
        $this->assertInstanceOf(Bitacora::class, $user->bitacoras->first());
        $this->assertEquals($bitacora->id, $user->bitacoras->first()->id);

        // Test Bitacora -> User relationship
        $this->assertInstanceOf(User::class, $bitacora->user);
        $this->assertEquals($user->id, $bitacora->user->id);

        // Test Bitacora -> DetalleBitacora relationship
        $this->assertInstanceOf(DetalleBitacora::class, $bitacora->detallebitacoras->first());

        // Test DetalleBitacora -> Bitacora relationship
        $detalle = $bitacora->detallebitacoras->first();
        $this->assertInstanceOf(Bitacora::class, $detalle->bitacora);
        $this->assertEquals($bitacora->id, $detalle->bitacora->id);
    }
}
