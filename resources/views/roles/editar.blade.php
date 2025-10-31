<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Roles y Permisos</h1>

        <div class="overflow-x-auto">
            <form action="{{ route('roles.actualizar') }}" method="POST">
                @csrf

                <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-6 text-left w-1/3">Rol</th>
                            <th class="py-3 px-6 text-left w-2/3">Permisos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($roles as $rol)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-6">
                                <input type="text" name="roles[{{ $rol->id }}][name]" value="{{ $rol->name }}"
                                    class="w-full min-w-0 p-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </td>
                            <td class="py-3 px-6">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($permissions as $permission)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="roles[{{ $rol->id }}][permissions][]" value="{{ $permission->id }}"
                                            class="form-checkbox h-4 w-4"
                                            {{ $rol->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <span class="text-gray-700 text-sm">{{ $permission->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Botón centrado -->
                <div class="flex justify-center mt-6">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
