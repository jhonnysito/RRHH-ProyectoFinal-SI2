@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Puestos Disponibles</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <div class="p-4 bg-purple-100 rounded-lg shadow hover:bg-purple-200 transition">
            <h2 class="text-xl font-semibold text-gray-800">Desarrollador Backend</h2>
            <p class="text-gray-700 mt-2">Encargado de la lógica y bases de datos.</p>
        </div>
        <div class="p-4 bg-purple-100 rounded-lg shadow hover:bg-purple-200 transition">
            <h2 class="text-xl font-semibold text-gray-800">Diseñador UI/UX</h2>
            <p class="text-gray-700 mt-2">Encargado del diseño y experiencia de usuario.</p>
        </div>
        <div class="p-4 bg-purple-100 rounded-lg shadow hover:bg-purple-200 transition">
            <h2 class="text-xl font-semibold text-gray-800">Analista de RRHH</h2>
            <p class="text-gray-700 mt-2">Encargado de gestión de personal y nóminas.</p>
        </div>
    </div>
</div>
@endsection
