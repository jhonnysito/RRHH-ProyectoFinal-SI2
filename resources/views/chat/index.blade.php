<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Conversaciones con RRHH
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('chat.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 mb-4">
                        + Nueva Conversación
                    </a>
                    
                    <div class="mt-4">
                        @forelse ($conversaciones as $conv)
                            <a href="{{ route('chat.show', $conv) }}" class="block p-4 mb-2 border rounded-lg hover:bg-gray-100">
                                <div class="flex justify-between">
                                    <span class="font-bold">{{ $conv->asunto }}</span>
                                    <span class="text-sm text-gray-600">{{ $conv->updated_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-700 mt-1">
                                    {{ $conv->mensajes->last()->contenido ?? 'Sin mensajes' }}
                                </p>
                            </a>
                        @empty
                            <p>No tienes conversaciones.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>