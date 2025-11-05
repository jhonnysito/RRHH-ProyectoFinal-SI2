<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('👤 Detalles del Postulante') }}
            </h2>
            <a href="{{ route('postulantes.index') }}"
               class="bg-gray-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-gray-700 transition">
                ⬅️ Volver a la lista
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Nombre completo -->
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-indigo-700">
                        {{ $postulante->nombres }} {{ $postulante->apellidos }}
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <p><span class="font-semibold text-gray-700">Correo:</span> {{ $postulante->email }}</p>
                        <p><span class="font-semibold text-gray-700">Teléfono:</span> {{ $postulante->telefono }}</p>
                        <p><span class="font-semibold text-gray-700">Años de Experiencia:</span> {{ $postulante->experiencia_anios }}</p>
                    </div>
                    <div>
                        <p><span class="font-semibold text-gray-700">Habilidades:</span></p>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach(json_decode($postulante->skills) ?? [] as $skill)
                                <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full text-xs font-medium">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- CV -->
                <div class="mb-6">
                    <p class="font-semibold text-gray-700 mb-2">Currículum Vitae:</p>
                    @if ($postulante->cv)
                        <a href="{{ asset('cv/' . $postulante->cv) }}" target="_blank"
                           class="inline-flex items-center bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition">
                            📄 Ver CV
                        </a>
                        <a href="{{ asset('cv/' . $postulante->cv) }}" download
                           class="inline-flex items-center bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition ml-2">
                            ⬇️ Descargar CV
                        </a>
                    @else
                        <p class="text-gray-500">No se subió ningún CV.</p>
                    @endif
                </div>

                <!-- Botón programar entrevista -->
                <div class="mt-6">
                    <a href="{{ route('entrevistas.crear', ['postulante' => $postulante->id]) }}"
                       class="inline-flex items-center bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                        📅 Programar Entrevista
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
