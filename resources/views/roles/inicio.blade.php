<x-app-layout>
    <x-slot name="header">
        <div class = "flex flex-wrap justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            @can('Crear Rol')
                <a class = "px-3 py-2 bg-indigo-600 font-bold text-white rounded-lg" href="{{ route('roles.crear') }}">CREAR
                    ROL</a>
            @endcan
        </div>
    </x-slot>
    <table class="min-w-full border-collapse block md:table">
        <thead class="block md:table-header-group">
            <tr
                class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                <th
                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    ID</th>
                <th
                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Nombre</th>
                <th
                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Permisos</th>
                <th
                    class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                </th>
            </tr>
        </thead>
        <tbody class="block md:table-row-group">
            @foreach ($roles as $key => $rol)
                @php
                    $bgColor = $key % 2 == 0 ? 'bg-gray-300' : 'bg-white';
                @endphp
                <tr class="{{ $bgColor }} border border-grey-500 md:border-none block md:table-row">
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                            class="inline-block w-1/3 md:hidden font-bold">ID</span>{{ $rol->id }}</td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                            class="inline-block w-1/3 md:hidden font-bold">Nombre</span>{{ $rol->name }}</td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                            class="inline-block w-1/3 md:hidden font-bold">Permisos</span><?php
                            $permisos = $rol->permissions;
                            ?>
                        @foreach ($permisos as $permiso)
                            {{ $permiso->name }}
                            <br>
                        @endforeach
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <div class="flex flex-wrap">
                            <span class="inline-block w-1/3 md:hidden font-bold">Acciones</span>
                            @can('Editar Rol')
                            <a href="{{ route('roles.editar', $rol->id) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded" title="Editar">
                                <i class="fas fa-edit"></i> 
                            </a>
                            @endcan
                            @can('Eliminar Rol')
                            <div>
                                <form id="formEliminar_{{ $rol->id }}"
                                    action="{{ route('roles.eliminar', $rol->id) }}" method="POST">
                                    @csrf
                                    <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded" title="Eliminar"
                                        onclick="confirmarEliminacion('{{ $rol->id }}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                            @endcan
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        @if (Session::has('eliminado'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
            toastr.success("{{ session('eliminado') }}")
        @endif
        @if (Session::has('actualizado'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
            toastr.success("{{ session('actualizado') }}")
        @endif
        @if (Session::has('creado'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
            toastr.success("{{ session('creado') }}")
        @endif
    </script>
</x-app-layout>
