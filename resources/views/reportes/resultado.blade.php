<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resultado del Reporte') }} ({{ $tipoReporte }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h3 class="text-2xl font-semibold mb-4">Reporte de {{ ucfirst($tipoReporte) }}</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach ($titulos as $titulo)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $titulo }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($datos as $dato)
                                <tr>
                                    @foreach ($dato->getAttributes() as $valor)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $valor }}
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($titulos) }}" class="px-6 py-4 text-center text-gray-500">
                                        No se encontraron datos para este reporte.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <button onclick="window.history.back()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Volver
                    </button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

