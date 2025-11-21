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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

                    <!-- Características personales -->
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">🧍 Características Personales (sobre 10)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        @php
                        $personales = [
                        'apariencia_profesional' => 'Apariencia Profesional',
                        'actitud' => 'Actitud',
                        'conversacion' => 'Conversación',
                        'cooperacion_entrevistador' => 'Cooperación con el entrevistador',
                        'relaciones_interpersonales' => 'Relaciones Interpersonales',
                        ];
                        @endphp
                        @foreach($personales as $campo => $label)
                        <div>
                            <label class="block text-gray-700 font-semibold">{{ $label }}</label>
                            <input type="number" name="{{ $campo }}" min="0" max="10"
                                value="{{ old($campo) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error($campo)
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        @endforeach
                    </div>

                    <!-- Características relacionadas con el puesto -->
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">💼 Características del Puesto (sobre 10)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        @php
                        $puesto = [
                        'experiencia_puesto' => 'Experiencia para el puesto',
                        'conocimiento_cargo' => 'Conocimiento del cargo',
                        'perfil_puesto' => 'Perfil del puesto',
                        'valoracion_curricular' => 'Valoración curricular',
                        'adecuacion_puesto' => 'Adecuación al puesto',
                        ];
                        @endphp
                        @foreach($puesto as $campo => $label)
                        <div>
                            <label class="block text-gray-700 font-semibold">{{ $label }}</label>
                            <input type="number" name="{{ $campo }}" min="0" max="10"
                                value="{{ old($campo) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error($campo)
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        @endforeach
                    </div>

                    

                    <!-- Total y Candidato (calculado automáticamente) -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label class="block text-gray-700 font-semibold">Total de Puntuación</label>
                            <input type="number" name="total_puntuacion" id="total_puntuacion" readonly
                                value="{{ old('total_puntuacion') }}"
                                class="mt-1 block w-full border-gray-300 bg-gray-100 rounded-md shadow-sm">
                        </div>

                        <div class="flex gap-2">
                            <button type="button" id="calcular_total"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                Calcular Total
                            </button>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold">Candidato</label>
                            <select name="candidato" id="candidato" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" disabled>
                                <option value="">Según puntuación</option>
                                <option value="Malo">Malo</option>
                                <option value="Regular">Regular</option>
                                <option value="Bueno">Bueno</option>
                                <option value="Muy Bueno">Muy Bueno</option>
                            </select>
                        </div>
                    </div>

                    <!-- Comentario final -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">📝 Comentario Final</label>
                        <textarea name="comentario_final" rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('comentario_final') }}</textarea>
                        @error('comentario_final')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Botones -->
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

<!-- JS para calcular total y candidato -->
<script>
    document.getElementById('calcular_total').addEventListener('click', function() {
        let total = 0;

        // Selecciona todos los inputs de tipo number dentro del formulario que no sean readonly
        const inputs = document.querySelectorAll('input[type="number"]:not([readonly])');
        inputs.forEach(input => {
            const val = parseFloat(input.value) || 0;
            total += val;
        });

        // Calcula el total sobre 100
        const porcentaje = (total / (inputs.length * 10)) * 100;
        const totalInput = document.getElementById('total_puntuacion');
        totalInput.value = Math.round(porcentaje);

        // Determinar el candidato según el porcentaje
        const candidatoSelect = document.getElementById('candidato');
        if (porcentaje < 40) {
            candidatoSelect.value = 'Malo';
        } else if (porcentaje < 60) {
            candidatoSelect.value = 'Regular';
        } else if (porcentaje < 80) {
            candidatoSelect.value = 'Bueno';
        } else {
            candidatoSelect.value = 'Muy Bueno';
        }
    });
</script>
