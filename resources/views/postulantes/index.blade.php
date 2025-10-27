<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('👥 Gestión de Postulantes') }}
            </h2>
            
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm"
                     role="alert">
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tabla de Postulantes -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="table-responsive">
                    <table class="min-w-full table-auto border-collapse">
                        <thead class="bg-indigo-50 border-b border-indigo-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Nombre</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Gmail</th>
                                 <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Telefono</th>
                                 <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">puntos</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($postulantes as $postulante)
                                <tr class="hover:bg-indigo-50 transition duration-150">
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        {{ $postulante->nombres }} {{ $postulante->apellidos }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $postulante->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $postulante->telefono }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $postulante->puntuacion }}</td>
                                    <td class="px-6 py-4 text-sm space-x-2 whitespace-nowrap">
                                        <a href="{{ route('postulantes.show', $postulante->id) }}"
                                           class="bg-blue-500 text-white px-3 py-1 rounded-full hover:bg-blue-600 text-xs font-medium transition">
                                            👀 Ver
                                      
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
