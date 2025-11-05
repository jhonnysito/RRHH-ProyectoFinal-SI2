<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('🗓️ Entrevistas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Botones para filtrar -->
                <div class="flex gap-4 mb-6">
                    <a href="{{ route('entrevistas.index', ['filtro' => 'pendientes']) }}"
                       class="px-4 py-2 rounded-lg font-medium
                       {{ request('filtro') == 'pendientes' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Pendientes
                    </a>
                    <a href="{{ route('entrevistas.index', ['filtro' => 'evaluadas']) }}"
                       class="px-4 py-2 rounded-lg font-medium
                       {{ request('filtro') == 'evaluadas' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Evaluadas
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="border px-4 py-2">#</th>
                                <th class="border px-4 py-2">Postulante</th>
                                <th class="border px-4 py-2">Fecha</th>
                                <th class="border px-4 py-2">Hora</th>
                                <th class="border px-4 py-2">Notas</th>
                                <th class="border px-4 py-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($entrevistas as $entrevista)
                                @php
                                    $evaluada = $entrevista->evaluaciones->count() > 0;
                                @endphp

                                @if (($filtro == 'pendientes' && !$evaluada) || ($filtro == 'evaluadas' && $evaluada) || !$filtro)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $entrevista->id }}</td>
                                    <td class="border px-4 py-2">
                                        {{ $entrevista->postulante->nombres ?? 'Sin asignar' }}
                                        {{ $entrevista->postulante->apellidos ?? '' }}
                                    </td>
                                    <td class="border px-4 py-2">{{ $entrevista->fecha }}</td>
                                    <td class="border px-4 py-2">{{ $entrevista->hora }}</td>
                                    <td class="border px-4 py-2">{{ $entrevista->notas ?? '—' }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <div class="flex justify-center gap-2">
                                            @if ($evaluada)
                                                <a href="{{ route('evaluaciones.show', $entrevista->evaluaciones->first()->id) }}"
                                                   class="text-blue-600 hover:underline">👁️ Ver Evaluación</a>
                                            @else
                                                <a href="{{ route('entrevistas.evaluar', $entrevista->id) }}"
                                                   class="text-green-600 hover:underline">📝 Evaluar</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">
                                        No hay entrevistas para mostrar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
