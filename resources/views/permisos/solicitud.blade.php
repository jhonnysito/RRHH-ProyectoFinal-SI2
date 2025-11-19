<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitar Permiso') }}
        </h2>
    </x-slot>

    <div class="container mx-auto">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                    {{-- Mostrar errores de validación --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">¡Error!</strong>
                            <span class="block sm:inline">Corrige los siguientes errores:</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORMULARIO --}}
                    <form method="POST" 
                          action="{{ route('permisos.enviar-solicitud') }}" 
                          class="space-y-6"
                          enctype="multipart/form-data">
                        @csrf

                        {{-- Tipo de Permiso --}}
                        <div>
                            <label for="incidencia" class="block text-sm font-medium text-gray-700">Tipo de Permiso</label>
                            <select id="incidencia" 
                                    name="incidencia" 
                                    class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    required>
                                <option value="">Seleccione un tipo...</option>
                                <option value="enfermedad" {{ old('incidencia') == 'enfermedad' ? 'selected' : '' }}>Enfermedad</option>
                                <option value="vacaciones" {{ old('incidencia') == 'vacaciones' ? 'selected' : '' }}>Vacaciones</option>
                                <option value="otros" {{ old('incidencia') == 'otros' ? 'selected' : '' }}>Otros</option>
                            </select>
                        </div>

                        {{-- Motivo --}}
                        <div>
                            <label for="motivo" class="block text-sm font-medium text-gray-700">Motivo del Permiso</label>
                            <input id="motivo" 
                                   type="text" 
                                   class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   name="motivo" 
                                   value="{{ old('motivo') }}" 
                                   required>
                        </div>

                        {{-- Comprobante / Imagen --}}
                        <div>
                            <label for="imagen" class="block text-sm font-medium text-gray-700">
                                Comprobante / Documento (opcional)
                            </label>
                            <input type="file" 
                                   id="imagen" 
                                   name="imagen"
                                   class="mt-2 block w-full text-sm text-gray-700">
                            <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, PNG, PDF — Máx 5MB</p>
                        </div>

                        {{-- Fechas --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                                <input id="fecha_inicio" 
                                       type="date" 
                                       class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" 
                                       name="fecha_inicio" 
                                       value="{{ old('fecha_inicio') }}" 
                                       required>
                            </div>

                            <div>
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                                <input id="fecha_fin" 
                                       type="date" 
                                       class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" 
                                       name="fecha_fin" 
                                       value="{{ old('fecha_fin') }}" 
                                       required>
                            </div>
                        </div>

                        {{-- Botón --}}
                        <div>
                            <button type="submit" 
                                    class="inline-block px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
                                Enviar Solicitud
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
