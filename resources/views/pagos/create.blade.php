<x-app-layout>
    <x-slot name="title">Nuevo Salario</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">➕ Registrar Nuevo Salario</h1>
        <a href="{{ route('salarios.index') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700">
            🔙 Volver a la Lista
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('salarios.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label for="empleado_id" class="block font-semibold mb-1">Empleado</label>
            <select name="empleado_id" id="empleado_id" class="w-full border px-3 py-2 rounded">
                <option value="">-- Seleccione un empleado --</option>
                @foreach ($empleados as $empleado)
                    <option value="{{ $empleado->id }}" {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                        {{ $empleado->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="salario_base" class="block font-semibold mb-1">Salario Base</label>
            <input type="number" name="salario_base" id="salario_base" step="0.01"
                   value="{{ old('salario_base') }}"
                   class="w-full border px-3 py-2 rounded" placeholder="0.00">
        </div>

        <div class="mb-4">
            <label for="total_bonos" class="block font-semibold mb-1">Total Bonos</label>
            <input type="number" name="total_bonos" id="total_bonos" step="0.01"
                   value="{{ old('total_bonos', 0) }}"
                   class="w-full border px-3 py-2 rounded" placeholder="0.00">
        </div>

        <div class="mb-4">
            <label for="total_descuentos" class="block font-semibold mb-1">Total Descuentos</label>
            <input type="number" name="total_descuentos" id="total_descuentos" step="0.01"
                   value="{{ old('total_descuentos', 0) }}"
                   class="w-full border px-3 py-2 rounded" placeholder="0.00">
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
            💾 Guardar Salario
        </button>
    </form>
</x-app-layout>
