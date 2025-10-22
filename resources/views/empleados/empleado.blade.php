@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    {{-- Barra superior con notificaciones y perfil --}}
    <div class="flex justify-between items-center bg-white shadow p-4">
        <h1 class="text-xl font-semibold">Gestión de Empleados</h1>
        <div class="flex items-center space-x-4">
            {{-- Icono de campana (notificaciones) --}}
            <button class="relative focus:outline-none">
                <i class="fa fa-bell text-gray-600 text-xl"></i>
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">3</span>
            </button>

            {{-- Menú de perfil --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                    <img src="{{ asset('images/user.png') }}" alt="Admin" class="w-8 h-8 rounded-full">
                    <span class="text-gray-700 font-medium">Administrador</span>
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Perfil</a>
                    {{--<a href="{{ route('admin.info') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Información</a> --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Contenido principal --}}
    <div class="max-w-7xl mx-auto py-6 px-4">

        {{-- Encabezado con total de empleados y botón nuevo --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold text-gray-800">
                1011 empleados
            </h2>
            <a href="{{ route('empleados.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center space-x-2">
                <i class="fa fa-plus"></i>
                <span>Nuevo Empleado</span>
            </a> 
        </div>

        {{-- Filtros --}}
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Departamento</label>
                    <select id="departamento" class="w-full mt-1 border-gray-300 rounded-md">
                        <option value="">Seleccione departamento</option>
                        {{-- Aquí se cargarán los departamentos desde el controlador --}}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cargo</label>
                    <select id="cargo" class="w-full mt-1 border-gray-300 rounded-md">
                        <option value="">Seleccione cargo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="estado" class="w-full mt-1 border-gray-300 rounded-md">
                        <option value="">Seleccione estado</option>
                        <option value="activo">Activo</option>
                        <option value="licencia">Licencia</option>
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <button id="btnBuscar" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                    <button id="btnNuevaBusqueda" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        <i class="fa fa-undo"></i> Nueva búsqueda
                    </button>
                </div>
            </div>
        </div>

        {{-- Botones de exportación --}}
        <div class="flex justify-end mb-4 space-x-2">
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fa fa-file-excel mr-2"></i> RPTE EMPLEADOS (Excel)
            </button>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fa fa-file-excel mr-2"></i> RPTE LICENCIAS (Excel)
            </button>
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fa fa-file-pdf mr-2"></i> RPTE EMPLEADOS (PDF)
            </button>
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fa fa-file-pdf mr-2"></i> RPTE LICENCIAS (PDF)
            </button>
        </div>

        {{-- Tabla de empleados --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr class="text-gray-700 text-sm uppercase">
                        <th class="px-6 py-3 text-left">Foto</th>
                        <th class="px-6 py-3 text-left">Nombre completo</th>
                        <th class="px-6 py-3 text-left">Correo electrónico</th>
                        <th class="px-6 py-3 text-left">Dirección</th>
                        <th class="px-6 py-3 text-left">Teléfono</th>
                        <th class="px-6 py-3 text-left">C.I.</th>
                        <th class="px-6 py-3 text-left">Departamento</th>
                        <th class="px-6 py-3 text-left">Cargo</th>
                        <th class="px-6 py-3 text-left">Estado</th>
                        <th class="px-6 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    {{-- Aquí se cargarán los empleados desde el controlador --}}
                    <tr>
                        <td class="px-6 py-4">
                            <button class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded-full">
                                <i class="fa fa-plus"></i>
                            </button>
                        </td>
                        <td class="px-6 py-4">Juan Pérez</td>
                        <td class="px-6 py-4">juan.perez@empresa.com</td>
                        <td class="px-6 py-4">Av. Siempre Viva 123</td>
                        <td class="px-6 py-4">700-12345</td>
                        <td class="px-6 py-4">1234567 LP</td>
                        <td class="px-6 py-4">Recursos Humanos</td>
                        <td class="px-6 py-4">Analista</td>
                        <td class="px-6 py-4">Activo</td>
                        <td class="px-6 py-4 space-x-2">
                            <button class="text-blue-600 hover:underline">Editar</button>
                            <button class="text-red-600 hover:underline">Eliminar</button>
                            <button class="text-green-600 hover:underline">Crear contrato</button>
                            <button class="text-gray-600 hover:underline">Ver contrato</button>
                            <button class="text-yellow-600 hover:underline">Ver información</button>
                            <button class="text-purple-600 hover:underline">Asignar horario</button>
                            <button class="text-indigo-600 hover:underline">Bitácora</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Paginación / mostrar cantidad --}}
        <div class="flex justify-between items-center mt-4">
            <div class="text-sm text-gray-600">Mostrar 
                <select class="border-gray-300 rounded-md text-sm">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                empleados
            </div>
            <div>
                {{-- Aquí iría el paginador real --}}
                <span class="text-gray-600 text-sm">Página 1 de 10</span>
            </div>
        </div>
    </div>
</div>

{{-- AlpineJS --}}
<script src="https://unpkg.com/alpinejs" defer></script>
@endsection
