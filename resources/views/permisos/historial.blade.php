<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Historial de Permisos') }}
            </h2>
            <!-- Botón para solicitar permiso -->
            @if (!Auth::user()->hasRole('Administrador'))
            <a href="{{ route('permisos.solicitud') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Pedir Permiso
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <!-- Contenido del historial de permisos -->
                @if ($permisos->isEmpty())
                    <p class="text-center">No hay permisos registrados.</p>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full md:min-w-max">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Solicitante
                                </th>
                                <th scope="col" class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cargo
                                </th>
                                <th scope="col" class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Departamento
                                </th>
                                <th scope="col" class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tipo
                                </th>
                                <th scope="col" class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Motivo
                                </th>
                                <th scope="col" class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha de Inicio
                                </th>
                                <th scope="col" class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha de Fin
                                </th>
                                <th scope="col" class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <!-- Acciones -->
                                @if (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Encargado'))
                                <th scope="col" class="px-8 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($permisos as $permiso)
                                <tr>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <!-- Usamos optional() por si el usuario fue eliminado -->
                                        <div class="text-sm text-gray-900">{{ optional($permiso->user)->name ?? 'Usuario Eliminado' }}</div>
                                    </td>
                                    
                                    <!-- ¡¡¡CORRECCIÓN CRÍTICA CON OPTIONAL()!!! -->
                                    <!-- Esto evita que la página falle si el User no es un Empleado -->
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ optional(optional($permiso->user)->empleado)->cargo ? $permiso->user->empleado->cargo->nombre : 'N/A' }}</div>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ optional(optional($permiso->user)->empleado)->departamento ? $permiso->user->empleado->departamento->nombre : 'N/A' }}</div>
                                    </td>

                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $permiso->tipo_permiso ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $permiso->motivo }}</div>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $permiso->fecha_inicio }}</div>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $permiso->fecha_fin }}</div>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($permiso->aprobado)
                                            bg-green-100 text-green-800
                                        @elseif($permiso->denegado)
                                            bg-red-100 text-red-800
                                        @else
                                            bg-yellow-100 text-yellow-800
                                        @endif
                                        ">
                                            @if($permiso->aprobado)
                                                Aprobado
                                            @elseif($permiso->denegado)
                                                Denegado
                                            @else
                                                Pendiente
                                            @endif
                                        </span>
                                    </td>
                                    <!-- Acciones -->
                                    @if (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Encargado'))
                                    <td class="px-8 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        @if (!$permiso->aprobado && !$permiso->denegado)
                                            <form action="{{ route('permisos.approve', $permiso->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                    Aprobar
                                                </button>
                                            </form>
                                            <form action="{{ route('permisos.deny', $permiso->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                    Denegar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

            </div>
        </div>
    </div>
    <script>
        // ... (Tu script de toastr se queda igual) ...
    </script>
</x-app-layout>