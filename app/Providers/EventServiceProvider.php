<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;
use App\Observers\CargoObserver;
use App\Observers\DepartamentoObserver;
use App\Observers\EducacionObserver;
use App\Observers\UserObserver;
use App\Observers\ExperienciaObserver;
use App\Observers\FuenteObserver;
use App\Observers\IdiomaObserver;
use App\Observers\Postulante_IdiomaObserver;
use App\Observers\PostulanteObserver;
use App\Observers\Puesto_DisponibleObserver;
use App\Observers\ReconocimientoObserver;
use App\Observers\ReferenciaObserver;
use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\Educacion;
use App\Models\User;
use App\Models\Experiencia;
use App\Models\Fuente_De_Contratacion;
use App\Models\Idioma;
use App\Models\Postulante_Idioma;
use App\Models\Postulante;
use App\Models\Puesto_Disponible;
use App\Models\Reconocimiento;
use App\Models\Referencia;
use App\Observers\RoleObserver;
use Spatie\Permission\Models\Role;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Login::class => [
            LogSuccessfulLogin::class,
        ],
        Logout::class => [
            LogSuccessfulLogout::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        /*
        Cargo::observe(CargoObserver::class);
        Departamento::observe(DepartamentoObserver::class);
        Educacion::observe(EducacionObserver::class);
        Empleado::observe(EmpleadoObserver::class);
        Experiencia::observe(ExperienciaObserver::class);
        Fuente_De_Contratacion::observe(FuenteObserver::class);
        Idioma::observe(IdiomaObserver::class);
        Postulante_Idioma::observe(Postulante_IdiomaObserver::class);
        Postulante::observe(PostulanteObserver::class);
        Puesto_Disponible::observe(Puesto_DisponibleObserver::class);
        Reconocimiento::observe(ReconocimientoObserver::class);
        Referencia::observe(ReferenciaObserver::class);
        Role::observe(RoleObserver::class);
        */
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
