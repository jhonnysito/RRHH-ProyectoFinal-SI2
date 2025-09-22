
<x-app-layout>
    <x-slot name="title">Departamentos</x-slot>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">📋 Lista de Departamentos</h1>
        <a href="{{ route('departamentos.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
            ➕ Nuevo Departamento
        </a>
    </div>

    <div class="bg-white shadow-md rounded overflow-hidden">
        <table class="min-w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 border-b">ID</th>
                    <th class="px-6 py-3 border-b">Nombre</th>
                    <th class="px-6 py-3 border-b">Descripción</th>
                    <th class="px-6 py-3 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departamentos as $departamento)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 border-b">{{ $departamento->id }}</td>
                        <td class="px-6 py-3 border-b">{{ $departamento->nombre }}</td>
                        <td class="px-6 py-3 border-b">{{ $departamento->descripcion }}</td>
                        <td class="px-6 py-3 border-b flex gap-2">
                            <a href="{{ route('departamentos.edit', $departamento) }}"
                               class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                               ✏️ Editar
                            </a>
                            <form action="{{ route('departamentos.destroy', $departamento) }}"
                                  method="POST" onsubmit="return confirm('¿Eliminar este departamento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
