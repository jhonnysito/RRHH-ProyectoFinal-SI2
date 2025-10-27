<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Puesto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow py-4 mb-6">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-2xl font-bold text-blue-900">RRHH</h1>
            <nav class="space-x-4">
                <a href="/" class="text-gray-800 hover:text-blue-600">Inicio</a>
                <a href="{{ url()->previous() }}" class="text-gray-800 hover:text-blue-600">Volver</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-8 px-4 bg-white rounded-lg shadow">
        <h2 class="text-3xl font-bold text-blue-900 mb-4">{{ $puesto->nombre }}</h2>

        <p><strong>Área:</strong> {{ $puesto->area }}</p>
        <p><strong>Descripción:</strong> {{ $puesto->descripcion }}</p>
        <p><strong>Requisitos:</strong> {{ $puesto->requisitos }}</p>
        <p><strong>Tipo de contrato:</strong> {{ $puesto->tipo_contrato }}</p>
        <p><strong>Modalidad:</strong> {{ $puesto->modalidad }}</p>
        <p><strong>Nivel:</strong> {{ $puesto->nivel }}</p>
        <p><strong>Salario:</strong> {{ $puesto->salario }}</p>
        <p><strong>Ubicación:</strong> {{ $puesto->ubicacion }}</p>
        <p><strong>Vacantes:</strong> {{ $puesto->vacantes }}</p>
        <p><strong>Fecha límite:</strong> {{ $puesto->fecha_limite }}</p>
        <p><strong>Estado:</strong> {{ $puesto->estado }}</p>
        <p><strong>Beneficios:</strong> {{ $puesto->beneficios }}</p>

        <!-- Botón de Postulación -->
        <div class="mt-6">
            <a href="{{ route('puesto.postular', $puesto->id) }}" 
               class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-full">
               Postularme
            </a>
        </div>
    </main>

</body>
</html>
