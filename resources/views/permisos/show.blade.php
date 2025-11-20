<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de Solicitud de Permiso') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Información del Solicitante</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $permisoEmpleado->user->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cargo</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ optional(optional($permisoEmpleado->user)->empleado)->cargo ? $permisoEmpleado->user->empleado->cargo->nombre : 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $permisoEmpleado->user->email ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ optional(optional($permisoEmpleado->user)->empleado)->departamento ? $permisoEmpleado->user->empleado->departamento->nombre : 'N/A' }}</dd>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Detalles de la Solicitud</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tipo de Permiso</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $permisoEmpleado->incidencia->nombre ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Estado Actual</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($permisoEmpleado->estado == 'aprobado') bg-green-100 text-green-800
                                @elseif($permisoEmpleado->estado == 'rechazado') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                    {{ ucfirst($permisoEmpleado->estado) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Inicio</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($permisoEmpleado->fecha_inicio)->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Fin</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($permisoEmpleado->fecha_fin)->format('d/m/Y') }}</dd>
                        </div>
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Motivo</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $permisoEmpleado->motivo ?? 'Sin motivo.' }}</dd>
                        </div>
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Documento de Respaldo</dt>
                            @if ($permisoEmpleado->archivo_adjunto)
                                <dd class="mt-1 text-sm">
                                    <a href="{{ Storage::url($permisoEmpleado->archivo_adjunto) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                        Ver Documento Adjunto (PDF/Imagen)
                                    </a>
                                </dd>
                            @else
                                <dd class="mt-1 text-sm text-gray-900">No se adjuntó ningún documento.</dd>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($permisoEmpleado->estado == 'solicitado')
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Tomar Decisión</h3>
                    <p class="mt-1 text-sm text-gray-600">Una vez tomada la decisión, el empleado será notificado (próximamente).</p>
                    <div class="mt-6 flex justify-end space-x-4">
                        <form action="{{ route('permisos.deny', $permisoEmpleado) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Rechazar
                            </button>
                        </form>
                        <form action="{{ route('permisos.approve', $permisoEmpleado) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                Aprobar
                            </button>
                        </form>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>