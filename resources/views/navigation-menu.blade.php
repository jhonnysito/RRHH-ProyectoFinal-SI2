<nav x-data="{ open: false, sidebarVisible: false }" class="bg-white border-b border-gray-100">

    <!-- Primary Navigation Menu -->
    <div class="h-14 bg-gray-100 top-0 w-full fixed shadow" style="z-index: 99999;">
        <div class="flex justify-between items-center pr-10 pl-3 h-14">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('archivos/logo2.jpg') }}" alt="Logo" class="block h-9 w-auto" />

                </a>
                <div class="ml-4">
                    @auth
                    <h2 class="text-md font-bold">{{ Auth::user()->name }}</h2>
                    @else
                    <h2 class="text-md font-bold">Invitado</h2>
                    @endauth
                    <p class="text-gray-400 text-[12px]">
                        @if (Auth::user()->empleado && Auth::user()->empleado->cargo)
                        {{ Auth::user()->empleado->cargo->nombre }}
                        @else
                        <span>Sin cargo asignado</span>
                        @endif
                    </p>
                </div>
                <!-- Botón de ejemplo (puedes ponerlo donde quieras) -->
                <button @click="sidebarVisible = !sidebarVisible"
                    class="m-2 bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">
                    <i :class="sidebarVisible ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'"></i>
                </button>
            </div>


            <ul class="flex items-center gap-5">
                {{-- Icono de Personalización (Engranaje) --}}
                <li>
                    <a href="{{ route('tenant.customization.edit') }}"
                        class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700"
                        title="Personalización">
                        <i class="fa-solid fa-cog text-lg"></i>
                    </a>
                </li>
                <li class="">
                    <div class="ml-3 relative" x-data="{ open: false }">
        <button @click="open = !open"
            class="relative inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
            
            <!-- Ícono de notificación -->
            <div class="p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="text-gray-600 w-6 h-6" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                </svg>
            </div>

            <!-- ¡NUEVO! Contador de Notificaciones No Leídas -->
            @if (auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </button>

        <!-- ¡NUEVO! Dropdown de Notificaciones -->
        <div x-show="open" @click.away="open = false"
             class="origin-top-right absolute right-0 mt-2 w-80 md:w-96 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             style="display: none;">
            
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Notificaciones</h3>
            </div>

            <div class="max-h-96 overflow-y-auto">
                @forelse (auth()->user()->unreadNotifications as $notification)
                    <a href="{{ $notification->data['url'] ?? '#' }}" 
                       class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100">
                        <p class="font-medium">{{ $notification->data['remitente_nombre'] ?? 'Sistema' }}</p>
                        <p class="text-gray-600">{{ $notification->data['mensaje'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </a>
                @empty
                    <p class="text-center text-gray-500 py-6">No tienes notificaciones nuevas.</p>
                @endforelse

                @if(auth()->user()->readNotifications->count() > 0)
                    <div class="p-2 border-t border-gray-200">
                        <h4 class="text-xs font-medium text-gray-400 uppercase px-4 py-2">Leídas</h4>
                    </div>
                    @foreach (auth()->user()->readNotifications->take(3) as $notification)
                        <a href="{{ $notification->data['url'] ?? '#' }}" 
                           class="block px-4 py-3 text-sm text-gray-500 bg-gray-50 hover:bg-gray-100 border-b border-gray-100">
                            <p>{{ $notification->data['mensaje'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </a>
                    @endforeach
                @endif
            </div>

            <div class="p-2 bg-gray-50 border-t border-gray-200">
                <!-- (Opcional) Enlace para marcar todas como leídas -->
                <form action="{{ route('notificaciones.leerTodas') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900 w-full text-center">
                        Marcar todas como leídas
                    </button>
                </form>
            </div>
        </div>
    </div>
                </li>
                <li class="" onclick="openUserDropdown()">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">

                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>







                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </li>
            </ul>
        </div>
    </div>
    <!-- left sidebar -->
    <aside id="sidebar"
        x-show="sidebarVisible"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-x-10"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform -translate-x-10"
        class="w-60 h-[calc(100vh-55px)] top-14 whitespace-nowrap fixed shadow overflow-x-hidden transition-all duration-500 ease-in-out bg-gray-100 overflow-y-auto z-10">

        <div class="flex flex-col justify-between h-full">

           <ul class="flex flex-col gap-1 mt-2">

    {{-- =====================  ADMINISTRADOR ===================== --}}
    @role('Administrador')

        {{-- Dashboard --}}
        <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
            <a class="w-full flex items-center py-3" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-house text-center px-5"></i>
                <span class="whitespace-nowrap pl-1">Dashboard</span>
            </a>
        </li>

        {{-- Departamentos --}}
        <x-sidebar-dropdown texto="Departamentos">
            <a href="{{ route('departamentos.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
            <a href="{{ route('departamentos.index') }}"  class="block px-2 py-1 hover:bg-gray-200 rounded">Gestionar</a>
        </x-sidebar-dropdown>

        {{-- Cargos --}}
        <x-sidebar-dropdown texto="Cargos">
            <a href="{{ route('cargos.create') }}"  class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
            <a href="{{ route('cargos.index') }}"   class="block px-2 py-1 hover:bg-gray-200 rounded">Gestionar</a>
        </x-sidebar-dropdown>

        {{-- Puestos Disponibles --}}
        <x-sidebar-dropdown texto="Puestos Disponibles">
            <a href="{{ route('puesto_disponibles.crear') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
            <a href="{{ route('puesto_disponibles.inicio') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
        </x-sidebar-dropdown>

        {{-- Postulantes --}}
        <x-sidebar-dropdown texto="Postulantes">
            <a href="{{ route('postulantes.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
            <a href="{{ route('entrevistas.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Entrevistas</a>
        </x-sidebar-dropdown>

        {{-- Empleados --}}
        <x-sidebar-dropdown texto="Empleados">
            <a href="{{ route('empleados.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
            <a href="{{ route('empleados.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Gestionar</a>
        </x-sidebar-dropdown>

        {{-- Roles --}}
        <x-sidebar-dropdown texto="Roles">
            <a href="{{ route('roles.crear') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
            <a href="{{ route('roles.inicio') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Gestionar</a>
        </x-sidebar-dropdown>

        {{-- Asistencias --}}
        <x-sidebar-dropdown texto="Asistencias">
            <a href="{{ route('asistencias.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Marcar</a>
            <a href="{{ route('asistencias.index') }}"  class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
        </x-sidebar-dropdown>

        {{-- Horarios --}}
        <x-sidebar-dropdown texto="Horarios">
            <a href="{{ route('horarios.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
            <a href="{{ route('horarios.index') }}"  class="block px-2 py-1 hover:bg-gray-200 rounded">Gestionar</a>
        </x-sidebar-dropdown>

        {{-- Permisos de Empleados --}}
        <x-sidebar-dropdown texto="Permisos">
            <a href="{{ route('permisos.solicitud') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Solicitar Permiso</a>
            <a href="{{ route('permisos.historial') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Historial</a>
            <a href="{{ route('permisos.historial') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Aprobar / Denegar</a>
        </x-sidebar-dropdown>

               <!-- ENLACE DE SUSCRIPCIÓN (NUEVO) -->
                    <div class="border-t border-gray-200"></div>
                            <x-dropdown-link href="{{ route('suscripcion.index') }}">
                                {{ __('Planes de Suscripción') }}
                            </x-dropdown-link>

                            <!-- Si el usuario ya tiene ID de stripe, mostrar botón al portal -->
                            @if(Auth::user()->stripe_id)
                                <x-dropdown-link href="{{ route('suscripcion.portal') }}">
                                    {{ __('Gestionar Pagos') }}
                                </x-dropdown-link>
                            @endif

                        <div class="border-t border-gray-200"></div>





                <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                    <a class="w-full flex items-center py-3" href="{{ route('departamentos.index') }}">
                        <i class="fa-solid fa-building text-center px-5"></i>
                        <span class="whitespace-nowrap pl-1">Departamentos</span>
                    </a>
                </li>

                <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                    <a class="w-full flex items-center py-3" href="{{ route('asistencia.index') }}">
                        <i class="fa-solid fa-map-location-dot text-center px-5"></i>
                        <span class="whitespace-nowrap pl-1">Asistencias</span>
                    </a>
                </li>

                <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                    <a class="w-full flex items-center py-3" href="{{ route('postulantes.index') }}">
                        <i class="fa-solid fa-building text-center px-5"></i>
                        <span class="whitespace-nowrap pl-1">Postulantes</span>
                    </a>
                </li>

                <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                    <a class="w-full flex items-center py-3" href="{{ route('solicitudes.index') }}">
                        <i class="fa-solid fa-building text-center px-5"></i>
                        <span class="whitespace-nowrap pl-1">Solicitudes de Empleo</span>
                    </a>
                </li>

                @can('Inicio Cargos')
                    <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                        <a class="w-full flex items-center py-3" href="{{ route('cargos.index') }}">
                            <i class="fa-solid fa-briefcase text-center px-5"></i>
                            <span class="whitespace-nowrap pl-1">Cargos</span>
                        </a>
                    </li>
                @endcan 

                @can('Inicio Reportes')
                    <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                        <a class="w-full flex items-center py-3" href="{{ route('reportes.inicio') }}">
                            <i class="fa-solid fa-chart-line text-center px-5"></i>
                            <span class="whitespace-nowrap pl-1">Reportes</span>
                        </a>
                    </li>
                @endcan


                @can('Inicio Roles')
                    <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                        <a class="w-full flex items-center py-3" href="{{ route('roles.inicio') }}">
                            <i class="fa-solid fa-user-shield text-center px-5"></i>
                            <span class="whitespace-nowrap pl-1">Roles</span>
                        </a>
                    </li>
                @endcan

                @can('Inicio Bitacoras')
                    <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                        <a class="w-full flex items-center py-3" href="{{ route('bitacora.rinicio') }}">
                            <i class="fa-solid fa-clock-rotate-left text-center px-5"></i>
                            <span class="whitespace-nowrap pl-1">Bitacoras</span>
                        </a>
                    </li>
                @endcan

                @can('Inicio Empleados')
                    <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                        <a class="w-full flex items-center py-3" href="{{ route('empleados.index') }}">
                            <i class="fa-solid fa-user-check text-center px-5"></i>
                            <span class="whitespace-nowrap pl-1">Empleados</span>
                        </a>
                    </li>
                @endcan



    {{-- =====================  EMPLEADO ===================== --}}
    @role('Empleado')

        {{-- Dashboard --}}
        <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
            <a class="w-full flex items-center py-3" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-house text-center px-5"></i>
                <span class="whitespace-nowrap pl-1">Dashboard</span>
            </a>
        </li>

        {{-- Asistencias --}}
        <x-sidebar-dropdown texto="Asistencias">
            <a href="{{ route('asistencias.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Marcar</a>
        </x-sidebar-dropdown>

        {{-- Horarios --}}
        <x-sidebar-dropdown texto="Horarios">
            <a href="{{ route('horarios.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver Horarios</a>
        </x-sidebar-dropdown>

        {{-- Permisos --}}
        <x-sidebar-dropdown texto="Permisos">
            <a href="{{ route('permisos.solicitud') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Solicitar</a>
            <a href="{{ route('permisos.historial') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Historial</a>
        </x-sidebar-dropdown>

        
    @endrole



    {{-- =====================  ENCARGADO / POSTULANTE (si los tienes) ===================== --}}
    {{-- Aquí podemos agregar más roles si quieres más adelante --}}



    {{-- ===================== CHAT ===================== --}}
    <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
        <a class="w-full flex items-center py-3" href="{{ route('chat.index') }}">
            <i class="fa-solid fa-comments text-center px-5"></i>
            <span class="whitespace-nowrap pl-1">Mis Chats</span>
        </a>
    </li>

    {{-- ===================== LOGOUT ===================== --}}
    <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900 mt-2">
        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <a class="w-full flex items-center py-3" href="{{ route('logout') }}"
                @click.prevent="$root.submit();">
                <i class="fa-solid fa-right-from-bracket text-center px-5"></i>
                <span class="pl-1">Logout</span>
            </a>
        </form>
    </li>

</ul>


        </div>
    </aside>


</nav>
<script></script>