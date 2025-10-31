<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles y Permisos') }}
            </h2>
            @can('Crear Rol')
                <a href="{{ route('roles.crear') }}" 
                   class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-500 transition">
                    CREAR ROL
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="p-3 text-left font-semibold uppercase tracking-wider">Nombre</th>
                        <th class="p-3 text-left font-semibold uppercase tracking-wider">Permisos</th>
                        <th class="p-3 text-center font-semibold uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $rol)
                        <tr class="border-b hover:bg-gray-100 transition">
                            <td class="p-3 font-medium text-gray-700">{{ $rol->name }}</td>
                            <td class="p-3">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($rol->permissions as $permiso)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">{{ $permiso->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="p-3 flex justify-center gap-2">
                                @can('Editar Roles')
                                    <a href="{{ route('roles.editar', $rol->id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded flex items-center gap-1 transition" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                @endcan
                                @can('Eliminar Roles')
                                    <form action="{{ route('roles.eliminar', $rol->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este rol?');">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded flex items-center gap-1 transition"
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        @if (Session::has('eliminado'))
            toastr.options = { closeButton: true, progressBar: true };
            toastr.success("{{ session('eliminado') }}");
        @endif
        @if (Session::has('actualizado'))
            toastr.options = { closeButton: true, progressBar: true };
            toastr.success("{{ session('actualizado') }}");
        @endif
        @if (Session::has('creado'))
            toastr.options = { closeButton: true, progressBar: true };
            toastr.success("{{ session('creado') }}");
        @endif
    </script>
</x-app-layout>
