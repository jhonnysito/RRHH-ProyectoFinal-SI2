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
                            <div class="absolute left-0 top-0 bg-red-500 rounded-full">

                            </div>
                            <div class="p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="text-gray-600 w-6 h-6" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                                </svg>
                            </div>
                        </button>
                        <!-- Dropdown de notificaciones -->

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

                {{-- Dashboard --}}
                <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                    <a class="w-full flex items-center py-3" href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-house text-center px-5"></i>
                        <span class="whitespace-nowrap pl-1">Dashboard</span>
                    </a>
                </li>

                {{-- Departamentos --}}
                @canany(['Agregar Departamentos','Editar Departamentos','Eliminar Departamentos','Ver Departamentos'])
                <x-sidebar-dropdown texto="Departamentos">
                    @can('Agregar Departamentos')
                    <a href="{{ route('departamentos.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
                    @endcan
                    @can('Editar Departamentos')
                    <a href="{{ route('departamentos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Editar</a>
                    @endcan
                    @can('Eliminar Departamentos')
                    <a href="{{ route('departamentos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Eliminar</a>
                    @endcan
                    @can('Ver Departamentos')
                    <a href="{{ route('departamentos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
                    @endcan
                </x-sidebar-dropdown>
                @endcanany

                {{-- Cargos --}}
                @canany(['Agregar Cargos','Editar Cargos','Eliminar Cargos','Ver Cargos'])
                <x-sidebar-dropdown texto="Cargos">
                    @can('Agregar Cargos')
                    <a href="{{ route('cargos.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
                    @endcan
                    @can('Editar Cargos')
                    <a href="{{ route('cargos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Editar</a>
                    @endcan
                    @can('Eliminar Cargos')
                    <a href="{{ route('cargos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Eliminar</a>
                    @endcan
                    @can('Ver Cargos')
                    <a href="{{ route('cargos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
                    @endcan
                </x-sidebar-dropdown>
                @endcanany

                {{-- Puestos Disponibles --}}
                @canany(['Agregar Puestos','Editar Puestos','Eliminar Puestos','Ver Puestos'])
                <x-sidebar-dropdown texto="Puestos Disponibles">
                    @can('Agregar Puestos')
                    <a href="{{ route('puestos.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
                    @endcan
                    @can('Editar Puestos')
                    <a href="{{ route('puestos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Editar</a>
                    @endcan
                    @can('Eliminar Puestos')
                    <a href="{{ route('puestos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Eliminar</a>
                    @endcan
                    @can('Ver Puestos')
                    <a href="{{ route('puestos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
                    @endcan

                </x-sidebar-dropdown>
                @endcanany

<<<<<<< HEAD


                {{-- Puestos Disponibles --}}
                @canany(['Agregar Puestos Disponibles','Editar Puestos Disponibles','Eliminar Puestos Disponibles','Ver Puestos Disponibles'])
                <x-sidebar-dropdown texto="Puestos Disponibles">
                    @can('Ver Puestos Disponibles')
                    <a href="{{ route('puesto_disponibles.inicio') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
                    @endcan
=======
                {{-- Enlace único para el Chat --}}
                <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                    <a class="w-full flex items-center py-3" href="{{ route('chat.index') }}">
                        <i class="fa-solid fa-comments text-center px-5"></i>
                        <span class="whitespace-nowrap pl-1">Mis Chats</span>
                    </a>
                </li>
>>>>>>> origin/chatrrhhcorrejido2

                    @can('Agregar Puestos Disponibles')
                    <a href="{{ route('puesto_disponibles.crear') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
                    @endcan
                </x-sidebar-dropdown>

                @endcanany
                {{-- Postulantes --}}
                @canany(['Ver Postulantes','Ver Entrevistas'])
                <x-sidebar-dropdown texto="Postulantes">
                    @can('Ver Postulantes')
                    <a href="{{ route('postulantes.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver Postulantes</a>
                    @endcan
                     @can('Ver Entrevistas')
                    <a href="{{ route('entrevistas.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver Entrevistas</a>
                    @endcan
                </x-sidebar-dropdown>
                @endcanany

                {{-- Empleados --}}
                @canany(['Agregar Empleados','Editar Empleados','Eliminar Empleados','Ver Empleados'])
                <x-sidebar-dropdown texto="Empleados">
                    @can('Agregar Empleados')
                    <a href="{{ route('empleados.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
                    @endcan
                    @can('Editar Empleados')
                    <a href="{{ route('empleados.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Editar</a>
                    @endcan
                    @can('Eliminar Empleados')
                    <a href="{{ route('empleados.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Eliminar</a>
                    @endcan
                    @can('Ver Empleados')
                    <a href="{{ route('empleados.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
                    @endcan
                </x-sidebar-dropdown>
                @endcanany



                {{-- Bitácoras --}}
                @canany(['Agregar Bitacoras','Editar Bitacoras','Eliminar Bitacoras','Ver Bitacoras'])
                <x-sidebar-dropdown texto="Bitácoras">
                    @can('Agregar Bitacoras')
                    <a href="{{ route('bitacora.rinicio') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
                    @endcan
                    @can('Editar Bitacoras')
                    <a href="{{ route('bitacora.rinicio') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Editar</a>
                    @endcan
                    @can('Eliminar Bitacoras')
                    <a href="{{ route('bitacora.rinicio') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Eliminar</a>
                    @endcan
                    @can('Ver Bitacoras')
                    <a href="{{ route('bitacora.rinicio') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
                    @endcan
                </x-sidebar-dropdown>
                @endcanany
                {{-- Roles --}}
                @canany(['Agregar Roles','Editar Roles','Eliminar Roles','Ver Roles'])
                <x-sidebar-dropdown texto="Roles">
                    @can('Agregar Roles')
                    <a href="{{ route('roles.crear') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
                    @endcan
                    @can('Editar Roles')
                    <a href="{{route('roles.editar')}}" class="block px-2 py-1 hover:bg-gray-200 rounded">Editar</a>
                    @endcan
                    @can('Eliminar Roles')
                    <a href="{{ route('roles.inicio') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Eliminar</a>
                    @endcan
                    @can('Ver Roles')
                    <a href="{{ route('roles.inicio') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
                    @endcan
                </x-sidebar-dropdown>
                @endcanany

                {{-- Permisos --}}
                @canany(['Agregar Permisos','Editar Permisos','Eliminar Permisos','Ver Permisos'])
                <x-sidebar-dropdown texto="Permisos">
                    @can('Agregar Permisos')
                    <a href="{{ route('permisos.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
                    @endcan
                    @can('Editar Permisos')
                    <a href="{{ route('permisos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Editar</a>
                    @endcan
                    @can('Eliminar Permisos')
                    <a href="{{ route('permisos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Eliminar</a>
                    @endcan
                    @can('Ver Permisos')
                    <a href="{{ route('permisos.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
                    @endcan
                </x-sidebar-dropdown>
                @endcanany

                
                {{-- Asistencias --}}
                @canany(['Agregar Asistencias del Empleado','Editar Asistencias del Empleado','Eliminar Asistencias del Empleado','Ver Asistencias del Empleado'])
                <x-sidebar-dropdown texto="Asistencias">
                    @can('Agregar Asistencias del Empleado')
                    <a href="{{ route('asistencias.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
                    @endcan
                    @can('Editar Asistencias del Empleado')
                    <a href="{{ route('asistencias.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Editar</a>
                    @endcan
                    @can('Eliminar Asistencias del Empleado')
                    <a href="{{ route('asistencias.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Eliminar</a>
                    @endcan
                    @can('Ver Asistencias del Empleado')
                    <a href="{{ route('asistencias.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
                    @endcan
                </x-sidebar-dropdown>
                @endcanany

                {{-- Horarios --}}
                @canany(['Agregar Horarios','Editar Horarios','Eliminar Horarios','Ver Horarios'])
                <x-sidebar-dropdown texto="Horarios">
                    @can('Agregar Horarios')
                    <a href="{{ route('horarios.create') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Agregar</a>
                    @endcan
                    @can('Editar Horarios')
                    <a href="{{ route('horarios.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Editar</a>
                    @endcan
                    @can('Eliminar Horarios')
                    <a href="{{ route('horarios.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Eliminar</a>
                    @endcan
                    @can('Ver Horarios')
                    <a href="{{ route('horarios.index') }}" class="block px-2 py-1 hover:bg-gray-200 rounded">Ver</a>
                    @endcan
                </x-sidebar-dropdown>
                @endcanany 

                


            </ul>

            {{-- Logout --}}
            <ul class="flex flex-col gap-1 mt-2">
                <li class="text-gray-500 hover:bg-gray-100 hover:text-gray-900">
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