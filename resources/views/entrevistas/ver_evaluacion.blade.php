<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('📝 Evaluación de Entrevista') }}
            </h2>
            <a href="{{ route('entrevistas.index') }}"
               class="bg-gray-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-gray-700 transition">
                ⬅️ Volver a entrevistas
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Datos del postulante -->
                <h3 class="text-2xl font-bold text-indigo-700 mb-4">
                    {{ $entrevista->postulante->nombres }} {{ $entrevista->postulante->apellidos }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p><span class="font-semibold text-gray-700">Correo:</span> {{ $entrevista->postulante->email }}</p>
                        <p><span class="font-semibold text-gray-700">Teléfono:</span> {{ $entrevista->postulante->telefono }}</p>
                        <p><span class="font-semibold text-gray-700">Fecha Entrevista:</span> {{ $entrevista->fecha }}</p>
                        <p><span class="font-semibold text-gray-700">Hora Entrevista:</span> {{ $entrevista->hora }}</p>
                    </div>

                    <div>
                        <p><span class="font-semibold text-gray-700">CV:</span></p>
                        @if ($entrevista->postulante->cv)
                            <a href="{{ asset('cv/' . $entrevista->postulante->cv) }}" target="_blank"
                               class="inline-flex items-center bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition">
                                📄 Ver CV
                            </a>
                        @else
                            <p class="text-gray-500">No se subió ningún CV.</p>
                        @endif
                    </div>
                </div>

                <hr class="my-4 border-gray-300">

                <!-- Evaluación -->
                <h4 class="text-xl font-semibold text-gray-800 mb-4">Detalles de la Evaluación</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p><span class="font-semibold text-gray-700">Evaluador:</span> {{ $evaluacion->evaluador->name ?? '—' }}</p>
                        <p><span class="font-semibold text-gray-700">Puntaje Comunicación:</span> {{ $evaluacion->puntaje_comunicacion }}</p>
                        <p><span class="font-semibold text-gray-700">Puntaje Conocimiento:</span> {{ $evaluacion->puntaje_conocimiento }}</p>
                    </div>

                    <div>
                        <p><span class="font-semibold text-gray-700">Puntaje Actitud:</span> {{ $evaluacion->puntaje_actitud }}</p>
                        <p><span class="font-semibold text-gray-700">Puntaje Trabajo en Equipo:</span> {{ $evaluacion->puntaje_trabajo_equipo }}</p>
                        <p><span class="font-semibold text-gray-700">Puntaje Total:</span> {{ $evaluacion->puntaje_total }}</p>
                        <p><span class="font-semibold text-gray-700">Resultado Final:</span> {{ $evaluacion->resultado_final }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <p><span class="font-semibold text-gray-700">Comentarios:</span></p>
                    <p class="text-gray-600 whitespace-pre-line">{{ $evaluacion->comentarios }}</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
