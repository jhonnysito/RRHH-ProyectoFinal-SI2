<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitar Permiso') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <strong class="font-bold">¡Error!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('permisos.enviar-solicitud') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="incidencia_id" class="block text-sm font-medium text-gray-700">Tipo de Permiso (*)</label>
                        <select id="incidencia_id" name="incidencia_id" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="" disabled selected>Seleccione el tipo...</option>
                            @foreach ($incidencias as $incidencia)
                                <option value="{{ $incidencia->id }}" {{ old('incidencia_id') == $incidencia->id ? 'selected' : '' }}>
                                    {{ $incidencia->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de Inicio (*)</label>
                            <input id="fecha_inicio" type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha de Fin (*)</label>
                            <input id="fecha_fin" type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="motivo" class="block text-sm font-medium text-gray-700">Motivo / Descripción</label>
                        <textarea id="motivo" name="motivo" rows="3" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('motivo') }}</textarea>
                    </div>

                    <div>
                        <label for="archivo_adjunto" class="block text-sm font-medium text-gray-700">Documento de Respaldo (Opcional)</label>
                        <input id="archivo_adjunto" type="file" name="archivo_adjunto"
                            class="mt-1 block w-full text-sm text-gray-500
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-full file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-indigo-50 file:text-indigo-700
                                   hover:file:bg-indigo-100"/>
                        <p class="text-xs text-gray-500 mt-1">Archivos permitidos: PDF, JPG, PNG (Máx 2MB)</p>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Enviar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>