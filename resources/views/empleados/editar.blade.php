<x-app-layout>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>

        <style>
            @import url('https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css');
        </style>
        <title>Editar_Empleado</title>
    </head>
    <form method="POST" action="{{ route('empleados.actualizar', $usuario->id) }}" enctype="multipart/form-data"
        autocomplete="off">
        @csrf
        @method('PUT')
        <div class="bg-gradient-to-r from-indigo-700 to-indigo-950 p-8">
            <!-- Cuadro exterior con fondo azul marino y relleno de 8 unidades -->
            <div class="bg-gray-100 p-4 overflow-hidden shadow-xl sm:rounded-lg m-5 ">
                <div class= "text-center font-sans text-black font-bold text-3xl antialiased pb-10 mt-10">
                    EDITAR EMPLEADO
                </div>
                <div>
                    <label class="font-bold text-lg" for=""> Nombre</label>
                    <div class="flex">
                        <div class="w-full px-3 mb-5">
                            <div class="flex">
                                <div
                                    class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                    <i class="fa-solid fa-user text-gray-400 text-lg"></i>
                                </div>
                                <input id= "nombre_completo" type="text" name="nombre_completo"
                                    class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                    placeholder="Ingresar nombre" value="{{ $empleados->usuario->name }}">
                                @error('nombre_completo')
                                    <strong class = "text-red-500">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <label class="font-bold text-lg" for=""> Correo Electronico</label>
                    <div class="flex">
                        <div class="w-full px-3 mb-5">
                            <div class="flex">
                                <div
                                    class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                    <i class="fa-solid fa-envelope text-gray-400 text-lg"></i>
                                </div>
                                <input id= "correo" type="email" name="correo"
                                    class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                    placeholder="ingresar correo electrónico" value="{{ $empleados->usuario->email }}"v>
                                @error('correo')
                                    <strong class = "text-red-500">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <label class="font-bold text-lg" for=""> Dirección</label>
                    <div class="flex">
                        <div class="w-full px-3 mb-5">
                            <div class="flex">
                                <div
                                    class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                    <i class="fa-solid fa-house text-gray-400 text-lg"></i>
                                </div>
                                <input id= "direccion" type="text" name="direccion"
                                    class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                    placeholder="ingresar dirección" value="{{ $empleados->usuario->direccion }}">
                            </div>
                        </div>
                    </div>
                    <div class="flex -mx-3">
                        <div class="w-1/2 px-3 mb-5">
                            <label class="font-bold text-lg" for="telefono">Teléfono</label>
                            <div class="flex">
                                <div
                                    class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                    <i class="fa-solid fa-phone text-gray-400 text-lg"></i>
                                </div>
                                <input id="telefono" type="integer" name="telefono"
                                    class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                    placeholder="Ingresar teléfono" value="{{ $empleados->usuario->telefono }}">
                                @error('telefono')
                                    <strong class="text-red-500">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <!-- CI -->
                        <div class="w-1/2 px-3 mb-5">
                            <label class="font-bold text-lg" for="ci">C.I.</label>
                            <div class="flex">
                                <div
                                    class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                    <i class="fa-solid fa-user text-gray-400 text-lg"></i>
                                </div>
                                <input id="ci" type="integer" name="ci"
                                    class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                    placeholder="Ingresar C.I." value="{{ $empleados->usuario->ci }}">
                                @error('ci')
                                    <strong class="text-red-500">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex -mx-3">
                        <div class="w-1/2 px-3 mb-5">
                            <label class="font-bold text-lg" for="password">Contraseña</label>
                            <div class="flex">
                                <div
                                    class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                    <i class="fa-solid fa-lock text-gray-400 text-lg"></i>
                                </div>
                                <input id="password" type="password" name="password"
                                    class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500"
                                    placeholder="Ingresar Contraseña" value="{{ old('password') }}">
                            </div>
                            @error('password')
                                <strong class="text-red-500">{{ $message }}</strong>
                            @enderror
                        </div>

                        <!-- Campo Departamento -->
                        <div class="w-1/2 px-3 mb-5">
                            <label class="font-bold text-lg" for="departamento">Departamento</label>
                            <div class="flex">
                                <div
                                    class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                    <i class="fa-solid fa-user text-gray-400 text-lg"></i>
                                </div>
                                <select name="departamento_id" id="departamento_id"
                                    class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500">
                                    <option value="">Selecciona el Departamento</option>
                                    @foreach ($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}"
                                            @if ($departamento->id == $empleados->departamento->id) selected @endif>
                                            {{ $departamento->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('departamento_id')
                                <strong class="text-red-500">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="flex -mx-3">
                        <div class="w-1/2 px-3 mb-5">
                            <label class="font-bold text-lg" for="roles">Seleccionar Roles</label>
                            <div>
                                @foreach ($roles as $rol)
                                    <label for="{{ $rol->id }}">
                                        <input type="checkbox" 
                                               name="roles[]" 
                                               value="{{ $rol->id }}" 
                                               id="{{ $rol->id }}" 
                                               class="mr-1" 
                                               {{ $empleados->usuario->hasRole($rol->name) ? 'checked' : '' }} />
                                        {{ $rol->name }}
                                    </label>
                                @endforeach
                            </div>
                            
                            @error('roles')
                                <strong class="text-red-500 font-bold">Ingresar al menos un Rol</strong>
                            @enderror
                        </div>

                        <!-- Cargo -->
                        <div class="w-1/2 pl-3" id="cargo-container">
                            <label class="font-bold text-lg" for="ID_Cargo">Cargo</label>
                            <div class="flex">
                                <div
                                    class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center">
                                    <i class="fa-regular fa-registered"></i>
                                </div>
                                <select name="cargo_id" id="cargo_id"
                                    class="w-full -ml-10 pl-10 pr-3 py-2 rounded-2xl border-2 border-gray-200 outline-none focus:border-indigo-500">
                                    <option value="">Selecciona el Cargo</option>
                                    @foreach ($cargos as $cargo)
                                        <option value="{{ $cargo->id }}"
                                            data-departamento="{{ $cargo->ID_Departamento }}"
                                            @if ($cargo->id == $empleados->cargo->id) selected @endif>{{ $cargo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Imagen y botón de enviar -->
                    <div class="flex justify-center items-center space-x-6 py-9 pb-10">
                        <div class="shrink-0">
                            <img id='imagen' class="object-cover rounded-full"
                                style="width: 100px; height: 100px;" src="{{ $empleados->ruta_imagen_e }}"
                                alt="Imagen del empleado" />
                        </div>
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" id="ruta_imagen_e" name="ruta_imagen_e" onchange="loadFile(event)"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                        </label>
                        {{-- @error('ruta_imagen_e') --}}
                        <strong class="text-danger">Debes ingresar una imagen</strong>
                        {{-- @enderror --}}
                    </div>

                    <!-- Botón de registro -->
                    <div class="w-full px-3 mb-5">
                        <button type="submit" id="registrar"
                            class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-3 font-semibold">ACTUALIZAR</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtiene el contenedor de cargos
            const cargoContainer = document.getElementById('cargo-container');
            // Obtiene el select de departamento
            const departamentoSelect = document.getElementById('ID_Departamento');
            // Obtiene todos los options de cargos
            const cargoOptions = cargoContainer.querySelectorAll('option');

            // Agrega un evento change al select de departamento
            departamentoSelect.addEventListener('change', function() {
                const selectedDepartamento = this.value; // Obtiene el valor seleccionado del departamento
                // Itera sobre todas las opciones de cargos
                cargoOptions.forEach(option => {
                    // Si el valor de data-departamento coincide con el departamento seleccionado, muestra la opción, de lo contrario, ocúltala
                    if (option.getAttribute('data-departamento') === selectedDepartamento || option
                        .value === "") {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            });
        });
    </script>
</x-app-layout>
