<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Iniciar nueva conversación con RRHH
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('chat.store') }}">
                        @csrf

                        <div>
                            <label for="asunto" class="block font-medium text-sm text-gray-700">Asunto</label>
                            <input id="asunto" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" type="text" name="asunto" :value="old('asunto')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="mensaje" class="block font-medium text-sm text-gray-700">Tu primer mensaje</label>
                            <textarea id="mensaje" name="mensaje" rows="5" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>{{ old('mensaje') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
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