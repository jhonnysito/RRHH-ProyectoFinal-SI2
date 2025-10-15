<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Personalización de la Aplicación') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('personalizacion.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Sección del Logo -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Logo de la Empresa</h3>
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    @if ($logoPath)
                                        {{-- El helper tenant_asset() lo crearemos en la Fase 3, por ahora usamos asset(storage/...) --}}
                                        <img id="logo-preview" class="h-16 w-16 object-cover rounded-md"
                                            src="{{ asset('storage/' . $logoPath) }}" alt="Logo actual" />
                                    @else
                                        <img id="logo-preview" class="h-16 w-16 object-cover rounded-md"
                                            src="https://via.placeholder.com/150" alt="Vista previa del logo" />
                                    @endif
                                </div>
                                <label class="block">
                                    <span class="sr-only">Elegir foto de perfil</span>
                                    <input type="file" name="logo" onchange="previewLogo(event)"
                                        class="block w-full text-sm text-slate-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100
                                    " />
                                </label>
                            </div>
                            @error('logo')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sección de Colores -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Colores de la Marca</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="primary_color" class="block text-sm font-medium text-gray-700">Color
                                        Primario</label>
                                    <input type="color" name="primary_color" id="primary_color"
                                        value="{{ old('primary_color', $primaryColor) }}"
                                        class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label for="secondary_color"
                                        class="block text-sm font-medium text-gray-700">Color Secundario</label>
                                    <input type="color" name="secondary_color" id="secondary_color"
                                        value="{{ old('secondary_color', $secondaryColor) }}"
                                        class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de Guardar -->
                    <div class="flex justify-end mt-8">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function previewLogo(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('logo-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
