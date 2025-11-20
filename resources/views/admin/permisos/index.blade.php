<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Permisos</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">Nombre</th>
                        <th class="py-3 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($permisos as $permiso)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-6">{{ $permiso->name }}</td>
                        <td class="py-3 px-6 text-center space-x-2">
                            <a href="{{ route('permisos.editar', $permiso->id) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-400">Editar</a>

                            <form action="{{ route('permisos.eliminar', $permiso->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Deseas eliminar este permiso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
