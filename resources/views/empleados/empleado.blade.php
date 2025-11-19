<x-app-layout>
   
    <div class="min-h-screen bg-gray-100">
        {{-- aquí va todo tu contenido tal cual lo tienes --}}
        <div class="min-h-screen bg-gray-100">
            {{-- Barra superior con notificaciones y perfil --}}


        {{-- Contenido principal --}}
        <div class="max-w-7xl mx-auto py-6 px-4">
            {{-- Encabezado --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $empleados->count() }} empleados
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
                            <option value="Activo">Activo</option>
                            <option value="Licencia">Licencia</option>
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button id="btnBuscar"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                        <button id="btnNuevaBusqueda"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                            <i class="fa fa-undo"></i> Nueva búsqueda
                        </button>
                    </div>
                </div>
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
                        @foreach ($empleados as $empleado)
                        <tr>
                            <td class="px-6 py-4">
                                <img src="{{ asset('images/user.png') }}" alt="Foto" class="w-10 h-10 rounded-full">
                            </td>
                            <td class="px-6 py-4">{{ $empleado->nombre_completo }}</td>
                            <td class="px-6 py-4">{{ $empleado->correo }}</td>
                            <td class="px-6 py-4">{{ $empleado->direccion }}</td>
                            <td class="px-6 py-4">{{ $empleado->telefono }}</td>
                            <td class="px-6 py-4">{{ $empleado->ci }}</td>
                            <td class="px-6 py-4">{{ $empleado->departamento->nombre ?? 'Sin depto' }}</td>
                            <td class="px-6 py-4">{{ $empleado->cargo->nombre ?? 'Sin cargo' }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $empleado->estado == 'Activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $empleado->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="relative inline-block text-left">
                                    <button type="button"
                                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                                        onclick="toggleMenu({{ $empleado->id }})">
                                        Acciones
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    {{-- Menú desplegable --}}
<div id="dropdownMenu_{{ $empleado->id }}"
    class="hidden absolute right-0 mt-2 w-48 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg z-50">
    <div class="py-1">

        {{-- ✏️ Editar --}}
        @can('Editar Empleados')
        <a href="{{ route('empleados.editar', $empleado->id) }}"
            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            ✏️ Editar
        </a>
        @endcan

        {{-- 📄 Crear Contrato --}}
       {{--@can('Crear Contrato') --}}
<a href="{{ route('contratos.crear', $empleado->id) }}"
   class="flex items-center gap-2 px-4 py-2 text-sm text-blue-700 hover:bg-blue-100">
   📄 Crear Contrato
</a>
{{-- @endcan--}} 

        {{-- 👁️ Ver Contrato --}}
       {{--@can('Ver Contrato')--}}
        <a href="{{ route('contratos.ver', $empleado->id) }}"
            class="flex items-center gap-2 px-4 py-2 text-sm text-green-700 hover:bg-green-100">
            👁️ Ver Contrato
        </a>
        {{--@endcan--}}

        {{-- 📘 Información --}}
        {{--@can('Ver Empleado')--}}
        <a href="{{ route('empleados.info', $empleado->id) }}"
            class="flex items-center gap-2 px-4 py-2 text-sm text-purple-700 hover:bg-purple-100">
            📘 Información
        </a>
        {{--@endcan--}}

        {{-- 🗑️ Eliminar --}}
        @can('Eliminar Empleados')
        <form id="formEliminar_{{ $empleado->id }}"
            action="{{ route('empleados.destroy', $empleado->id) }}"
            method="POST">
            @csrf
             @method('DELETE')
            <button type="button"
                onclick="confirmarEliminacion('{{ $empleado->id }}')"
                class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-700 hover:bg-red-100">
                🗑️ Eliminar
            </button>
        </form>
        @endcan

    </div>
</div>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación / mostrar cantidad --}}
            <div class="flex justify-between items-center mt-4">
                <div class="text-sm text-gray-600">
                    Mostrar
                    <select class="border-gray-300 rounded-md text-sm">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    empleados
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Página 1 de 10</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script>
        function toggleMenu(id) {
            const menu = document.getElementById('dropdownMenu_' + id);
            document.querySelectorAll('[id^="dropdownMenu_"]').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });
            menu.classList.toggle('hidden');
        }

        function confirmarEliminacion(id) {
            if (confirm('¿Seguro que deseas eliminar este empleado?')) {
                document.getElementById('formEliminar_' + id).submit();
            }
        }
    </script>
     @if (session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  
</x-app-layout>
