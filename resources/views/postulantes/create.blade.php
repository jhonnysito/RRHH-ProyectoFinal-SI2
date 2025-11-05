<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('📋 Crear Nuevo Postulante') }}
            </h2>
            <a href="{{ route('postulantes.index') }}"
                class="bg-gray-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-gray-700 transition">
                ⬅️ Volver a la lista
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('postulantes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="nombres" class="block text-gray-700">Nombres</label>
                        <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('nombres')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="apellidos" class="block text-gray-700">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('apellidos')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Correo Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="telefono" class="block text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('telefono')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cv" class="block text-gray-700">CV (PDF, DOC, DOCX)</label>
                        <input type="file" name="cv" id="cv"
                            class="mt-1 block w-full text-sm text-gray-500 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('cv')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="skills" class="block text-gray-700">Habilidades (separadas por coma)</label>
                        <input type="text" name="skills" id="skills" value="{{ old('skills') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('skills')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="experiencia_anios" class="block text-gray-700">Años de Experiencia</label>
                        <input type="number" name="experiencia_anios" id="experiencia_anios"
                            value="{{ old('experiencia_anios') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('experiencia_anios')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end gap-4">
                        <a href="{{ route('postulantes.index') }}" class="text-gray-500 hover:text-gray-700">Cancelar</a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-blue-700">
                            Crear Postulante
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
