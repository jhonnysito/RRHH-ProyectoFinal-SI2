<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Postulante</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-3xl font-semibold mb-6">✏️ Editar Postulante</h1>

        <form action="{{ route('postulantes.update', $postulante->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Los mismos campos que en la vista de creación (pero con los valores del postulante a editar) -->
            <div class="mb-4">
                <label for="nombres" class="block text-gray-700">Nombres</label>
                <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $postulante->nombres) }}"
                    required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="apellidos" class="block text-gray-700">Apellidos</label>
                <input type="text" name="apellidos" id="apellidos"
                    value="{{ old('apellidos', $postulante->apellidos) }}" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="{{ old('email', $postulante->email) }}"
                    required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="telefono" class="block text-gray-700">Teléfono</label>
                <input type="text" name="telefono" id="telefono"
                    value="{{ old('telefono', $postulante->telefono) }}" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
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
                <label for="skills" class="block text-gray-700">Habilidades</label>
                <input type="text" name="skills" id="skills"
                    value="{{ old('skills', implode(', ', json_decode($postulante->skills))) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">


            </div>

            <div class="mb-4">
                <label for="experiencia_anios" class="block text-gray-700">Años de Experiencia</label>
                <input type="number" name="experiencia_anios" id="experiencia_anios"
                    value="{{ old('experiencia_anios', $postulante->experiencia_anios) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('postulantes.index') }}" class="text-gray-500 hover:text-gray-700">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-blue-700">
                    Actualizar Postulante
                </button>
            </div>
        </form>
    </div>

</body>

</html>
