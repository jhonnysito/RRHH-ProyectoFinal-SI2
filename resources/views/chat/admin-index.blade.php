<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de Chat - RRHH
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium">Todas las Conversaciones</h3>
                    <div class="mt-4">
                        @forelse ($conversaciones as $conv)
                            <a href="{{ route('chat.show', $conv) }}" class="block p-4 mb-2 border rounded-lg hover:bg-gray-100">
                                <div class="flex justify-between">
                                    <div>
                                        <span class="font-bold">{{ $conv->asunto }}</span>
                                        <span class="text-sm text-gray-600 ml-2">(de: {{ $conv->empleado->user->name }})</span>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ $conv->updated_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-700 mt-1">
                                    Último: {{ $conv->mensajes->last()->contenido ?? 'Sin mensajes' }}
                                </p>
                            </a>
                        @empty
                            <p>No hay conversaciones activas.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>