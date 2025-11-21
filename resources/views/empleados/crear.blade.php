<x-app-layout>

    <head>

        <title>Registrar_Empleado</title>
    </head>

    <form action="{{ route('empleados.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Errores de validación --}}
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-5" role="alert">
            <strong class="font-bold">¡Error de validación!</strong>
            <span class="block sm:inline">Por favor, corrige los siguientes errores:</span>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-5" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <input type="hidden" name="estado" value="Activo">

        <div class="bg-gradient-to-r from-indigo-700 to-indigo-950 p-8">
            <div class="bg-gray-100 p-4 overflow-hidden shadow-xl sm:rounded-lg m-5">
                <div class="text-center font-sans text-black font-bold text-3xl antialiased pb-10 mt-10">
                    REGISTRAR EMPLEADO
                </div>

                {{-- Nombre --}}
                <label class="font-bold text-lg" for="">Nombre</label>
                <div class="flex -mx-3">
                    <div class="w-full px-3 mb-5">
                        <div class="flex">
                            <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                <i class="fa-solid fa-user text-gray-400 text-lg"></i>
                            </div>
                            <input id="nombre_completo" type="text" name="nombre_completo"
                                class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                placeholder="Ingresar nombre completo" value="{{ old('nombre_completo') }}">
                        </div>
                        @error('nombre_completo')
                        <strong class="text-red-500">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>

                {{-- Dirección --}}
                <label class="font-bold text-lg" for="">Dirección</label>
                <div class="flex -mx-3">
                    <div class="w-full px-3 mb-5">
                        <div class="flex">
                            <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                <i class="fa-solid fa-house text-gray-400 text-lg"></i>
                            </div>
                            <input id="direccion" type="text" name="direccion"
                                class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                placeholder="Ingresar dirección" value="{{ old('direccion') }}">
                        </div>
                    </div>
                </div>

                {{-- Correo --}}
                <label class="font-bold text-lg" for="">Correo Electrónico</label>
                <div class="flex -mx-3">
                    <div class="w-full px-3 mb-5">
                        <div class="flex">
                            <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                <i class="fa-solid fa-envelope text-gray-400 text-lg"></i>
                            </div>
                            <input id="correo" type="email" name="correo"
                                class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                placeholder="Ingresar correo electrónico" value="{{ old('correo') }}">
                        </div>
                        @error('correo')
                        <strong class="text-red-500">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>

                {{-- Teléfono y C.I. --}}
                <div class="flex -mx-3">
                    <div class="w-1/2 px-3 mb-5">
                        <label class="font-bold text-lg" for="">Teléfono</label>
                        <div class="flex">
                            <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                <i class="fa-solid fa-phone text-gray-400 text-lg"></i>
                            </div>
                            <input id="telefono" type="text" name="telefono"
                                class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                placeholder="Ingresar teléfono" value="{{ old('telefono') }}">
                        </div>
                        @error('telefono')
                        <strong class="text-red-500">{{ $message }}</strong>
                        @enderror
                    </div>

                    <div class="w-1/2 px-3 mb-5">
                        <label class="font-bold text-lg" for="">C.I.</label>
                        <div class="flex">
                            <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                <i class="fa-solid fa-id-card text-gray-400 text-lg"></i>
                            </div>
                            <input id="ci" type="text" name="ci"
                                class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                placeholder="Ingresar C.I." value="{{ old('ci') }}">
                        </div>
                        @error('ci')
                        <strong class="text-red-500">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>

                {{-- Departamento --}}
                <div class="flex -mx-3">
                    <div class="w-1/2 px-3 mb-5">
                        <label class="font-bold text-lg" for="">Departamento</label>
                        <div class="flex">
                            <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                <i class="fa-regular fa-registered"></i>
                            </div>
                            <select name="departamento_id" id="departamento_id"
                                class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500">
                                <option value="">Selecciona el Departamento</option>
                                @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('departamento_id')
                        <strong class="text-red-500">Debe seleccionar el Departamento</strong>
                        @enderror
                    </div>
                </div>

                {{-- Cargo --}}
                <div class="w-1/2 px-3 mb-5">
                    <div id="cargo-container">
                        <label class="font-bold text-lg" for="">Cargo</label>
                        <div class="flex">
                            <div class="w-full">
                                <select name="cargo_id" id="cargo_id"
                                    class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500">
                                    <option value="">Selecciona el Cargo</option>
                                    @foreach ($cargos as $cargo)
                                    <option value="{{ $cargo->id }}"
                                        data-departamento="{{ $cargo->ID_Departamento }}"
                                        {{ old('cargo_id') == $cargo->id ? 'selected' : '' }}>
                                        {{ $cargo->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('cargo_id')
                        <strong class="text-red-500">Debe seleccionar el Cargo</strong>
                        @enderror
                    </div>
                </div>
                {{-- Roles y Cargo --}}
                <div class="flex -mx-3">
                    <div class="w-1/2 px-3 mb-5">
                        <label class="font-bold text-lg" for="roles">Seleccionar Roles</label>
                        <div>
                            @foreach ($roles as $rol)
                            <label for="{{ $rol->id }}" class="mr-3">
                                <input type="checkbox" name="roles[]" value="{{ $rol->name }}" id="{{ $rol->id }}">
                                {{ $rol->name }}
                            </label>
                            @endforeach
                        </div>
                        @error('roles')
                        <strong class="text-red-500 font-bold">Ingresar al menos un Rol</strong>
                        @enderror
                    </div>


                </div>

                {{-- Imagen --}}
                <div class="flex justify-center items-center space-x-6 py-9 pb-10">
                    <div class="shrink-0">
                        <img id='imagen' class="object-cover rounded-full" style="width:100px; height:100px;"
                            src="https://lh3.googleusercontent.com/a-/AFdZucpC_6WFBIfaAbPHBwGM9z8SxyM1oV4wB4Ngwp_UyQ=s96-c"
                            alt="Imagen del empleado" />
                    </div>
                    <label class="block">
                        <input type="file" id="ruta_imagen_e" name="ruta_imagen_e" onchange="loadFile(event)"
                            class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-violet-700
                            hover:file:bg-violet-100" />
                    </label>
                    @error('ruta_imagen_e')
                    <strong class="text-red-500">Debes ingresar una imagen</strong>
                    @enderror
                </div>

                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                {{-- Botón Registrar --}}
                <div class="flex -mx-3 pt-9">
                    <div class="w-full px-3 mb-5">
                        <button type="submit" id="registrar"
                            class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-3 font-semibold">
                            REGISTRAR
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>

    {{-- Scripts --}}
    <script>
        var loadFile = function(event) {
            var input = event.target;
            var file = input.files[0];

            var output = document.getElementById('imagen');
            if (file) {
                output.src = URL.createObjectURL(file);
                output.onload = function() {
                    URL.revokeObjectURL(output.src)
                }
            }
        };

        document.addEventListener("DOMContentLoaded", function() {
            const departamentoSelect = document.getElementById('departamento_id');
            const cargoSelect = document.getElementById('cargo_id');
            const allCargos = @json($cargos); // Todos los cargos

            departamentoSelect.addEventListener('change', function() {
                const departamentoId = this.value;

                // Limpiar select
                cargoSelect.innerHTML = '<option value="">Selecciona el Cargo</option>';

                if (departamentoId) {
                    const filteredCargos = allCargos.filter(c => c.departamento_id == departamentoId);
                    filteredCargos.forEach(cargo => {
                        const option = document.createElement('option');
                        option.value = cargo.id;
                        option.textContent = cargo.nombre;
                        cargoSelect.appendChild(option);
                    });
                }
            });
        });
    </script>

</x-app-layout>
