<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Registros de Asistencia por Ubicación') }}
            </h2>
        </div>
    </x-slot>

    <title>Registros de Asistencia</title>

    <div class="m-5 bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse block md:table">
                <thead class="block md:table-header-group bg-gray-600 text-white">
                    <tr class="md:table-row block">
                        <th class="p-3 text-left font-bold md:table-cell">Nombre</th>
                        <th class="p-3 text-left font-bold md:table-cell">Fecha</th>
                        <th class="p-3 text-left font-bold md:table-cell">Hora</th>
                        <th class="p-3 text-left font-bold md:table-cell">Coordenadas</th>
                        <th class="p-3 text-left font-bold md:table-cell">Ver en Mapa</th>
                    </tr>
                </thead>

                <tbody class="block md:table-row-group">
                    @forelse ($records as $record)
                        <tr
                            class="bg-white border border-gray-300 md:border-none block md:table-row hover:bg-gray-100 transition">
                            <!-- Nombre -->
                            <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">Nombre</span>
                                {{ $record->name }}
                            </td>

                            <!-- Fecha -->
                            <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">Fecha</span>
                                {{ $record->recorded_at->format('d/m/Y') }}
                            </td>

                            <!-- Hora -->
                            <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">Hora</span>
                                {{ $record->recorded_at->format('H:i:s A') }}
                            </td>

                            <!-- Coordenadas -->
                            <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">Coordenadas</span>
                                {{ $record->latitude }}, {{ $record->longitude }}
                            </td>

                            <!-- Ver en Mapa -->
                            <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">Ver en Mapa</span>
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $record->latitude }},{{ $record->longitude }}"
                                    target="_blank"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg inline-block">
                                    <i class="fas fa-map-marker-alt mr-1"></i> Abrir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border border-gray-300 md:border-none block md:table-row">
                            <td colspan="5" class="text-center p-5 text-gray-500 font-semibold">
                                No hay registros de asistencia todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($records->hasPages())
            <div class="p-4 border-t border-gray-300">
                {{ $records->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
