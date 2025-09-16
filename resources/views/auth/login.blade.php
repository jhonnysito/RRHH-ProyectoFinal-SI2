<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - RRHH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Iniciar Sesión</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Correo electrónico</label>
                <input type="email" name="email" id="email" placeholder="usuario@ejemplo.com" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="********" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            </div>

            <!-- Recordarme -->
            <div class="flex items-center mb-4">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-gray-700 text-sm">Recordarme</label>
            </div>

            <!-- Botón -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                Iniciar Sesión
            </button>
        </form>

        <!-- Links -->
        <p class="text-center text-gray-600 text-sm mt-4">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Regístrate</a>
        </p>
    </div>

</body>
</html>
