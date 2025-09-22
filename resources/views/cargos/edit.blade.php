<x-app-layout>
    <x-slot name="title">Editar Cargo</x-slot>

    <h1 class="text-2xl font-bold mb-6">✏️ Editar Cargo</h1>

    <form action="{{ route('cargos.update', $cargo) }}" method="POST" class="bg-white p-6 rounded shadow-md space-y-4">
        @csrf
        @method('PUT')

        <!-- Departamento -->
        <div>
            <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento</label>
            <select name="departamento_id" id="departamento_id"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @foreach ($departamentos as $dep)
                    <option value="{{ $dep->id }}" {{ $cargo->departamento_id == $dep->id ? 'selected' : '' }}>
                        {{ $dep->nombre }}
                    </option>
                @endforeach
            </select>
            @error('departamento_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nombre -->
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del cargo</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $cargo->nombre) }}"
                   class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Descripción -->
        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">{{ old('descripcion', $cargo->descripcion) }}</textarea>
            @error('descripcion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-2">
            <a href="{{ route('cargos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ⬅️ Cancelar
            </a>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                💾 Guardar Cambios
            </button>
        </div>
    </form>
</x-app-layout>
