<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('🗓️ Programar Entrevista') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-semibold mb-6">Programar entrevista para: {{ $postulante->nombres }} {{ $postulante->apellidos }}</h1>

        <form action="{{ route('entrevistas.guardar') }}" method="POST">
            @csrf

            <input type="hidden" name="postulante_id" value="{{ $postulante->id }}">

            <div class="mb-4">
                <label for="fecha" class="block text-gray-700 font-medium mb-2">Fecha de la Entrevista:</label>
                <input type="date" name="fecha" id="fecha" class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="hora" class="block text-gray-700 font-medium mb-2">Hora:</label>
                <input type="time" name="hora" id="hora" class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="notas" class="block text-gray-700 font-medium mb-2">Notas / Comentarios:</label>
                <textarea name="notas" id="notas" rows="4" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                📅 Agendar Entrevista
            </button>
        </form>
    </div>
</x-app-layout>