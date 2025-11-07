<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Conversación: {{ $conversacion->asunto }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="space-y-4 mb-6" style="height: 50vh; overflow-y: auto;">
                        @foreach ($conversacion->mensajes as $mensaje)
                            @php
                                $esMio = $mensaje->user_id === Auth::id();
                            @endphp
                            <div class="flex {{ $esMio ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs lg:max-w-md px-4 py-3 rounded-lg {{ $esMio ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                                    <p class="font-bold text-sm">{{ $mensaje->user->name }}</p>
                                    <p class="text-base">{{ $mensaje->contenido }}</p>
                                    <p class="text-xs text-right mt-1 {{ $esMio ? 'text-blue-100' : 'text-gray-600' }}">
                                        {{ $mensaje->created_at->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form method="POST" action="{{ route('mensajes.store', $conversacion) }}">
                        @csrf
                        <div class="flex space-x-2">
                            <textarea name="contenido" rows="2" class="flex-1 block w-full rounded-md shadow-sm border-gray-300" placeholder="Escribe tu respuesta..." required></textarea>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                Enviar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>