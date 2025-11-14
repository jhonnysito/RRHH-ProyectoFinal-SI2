<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Crear Permiso</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('permisos.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nombre del Permiso</label>
                    <input type="text" name="name" id="name"
                        class="w-full p-3 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ej: Ver Departamentos" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        Crear Permiso
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
