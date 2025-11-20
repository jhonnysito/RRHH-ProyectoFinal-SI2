<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('📝 Evaluar Entrevista') }}
            </h2>
            <a href="{{ route('entrevistas.index') }}"
               class="bg-gray-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-gray-700 transition">
                ⬅️ Volver a la lista
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Información del postulante -->
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-indigo-700">
                        {{ $entrevista->postulante->nombres ?? 'Sin asignar' }}
                        {{ $entrevista->postulante->apellidos ?? '' }}
                    </h3>
                    <p class="text-gray-500">
                        Fecha: {{ $entrevista->fecha }} | Hora: {{ $entrevista->hora }}
                    </p>
                </div>

                <!-- Formulario de evaluación -->
                <form action="{{ route('entrevistas.guardarEvaluacion', $entrevista->id) }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold">Puntaje Comunicación</label>
                            <input type="number" name="puntaje_comunicacion" min="0" max="10" value="{{ old('puntaje_comunicacion') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('puntaje_comunicacion')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold">Puntaje Conocimiento</label>
                            <input type="number" name="puntaje_conocimiento" min="0" max="10" value="{{ old('puntaje_conocimiento') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('puntaje_conocimiento')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold">Puntaje Actitud</label>
                            <input type="number" name="puntaje_actitud" min="0" max="10" value="{{ old('puntaje_actitud') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('puntaje_actitud')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold">Puntaje Trabajo en Equipo</label>
                            <input type="number" name="puntaje_trabajo_equipo" min="0" max="10" value="{{ old('puntaje_trabajo_equipo') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('puntaje_trabajo_equipo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Resultado Final</label>
                        <select name="resultado_final"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Selecciona</option>
                            <option value="aprobado" {{ old('resultado_final') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                            <option value="rechazado" {{ old('resultado_final') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            <option value="pendiente" {{ old('resultado_final') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                        @error('resultado_final')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold">Comentarios</label>
                        <textarea name="comentarios" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('comentarios') }}</textarea>
                        @error('comentarios')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('entrevistas.index') }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancelar</a>
                        <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            Registrar Evaluación
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>