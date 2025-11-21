<x-app-layout>
    <x-slot name="title">Crear Descuento</x-slot>

    <!-- Encabezado -->
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-3xl font-bold">💸 Nuevo Descuento</h1>
        <a href="{{ route('descuentos.index') }}"
            class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
            ⬅ Volver a Descuentos
        </a>
    </div>

    <!-- Formulario -->
    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('descuentos.store') }}" method="POST">
            @csrf

            <!-- Tipo de descuento -->
            <div class="mb-4">
                <label for="tipo" class="block text-gray-700 font-semibold mb-2">Tipo de Descuento</label>
                <input type="text" name="tipo" id="tipo" value="{{ old('tipo') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                    placeholder="Ej: Seguro, AFP, Préstamo, Anticipo">
            </div>

            <!-- Porcentaje -->
            <div class="mb-4">
                <label for="monto" class="block text-gray-700 font-semibold mb-2">Porcentaje de Descuento (%)</label>
                <input type="number" step="0.01" min="0" max="100" name="monto" id="monto" value="{{ old('monto') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200"
                    placeholder="Ej: 15.50">
            </div>

            <!-- Botón de guardar -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Guardar Descuento
                </button>
            </div>
        </form>
    </div>
</x-app-layout>