{{-- resources/views/onboarding/register.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <title>Registro - Mi SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h1 class="text-2xl font-bold mb-6">Registra tu Empresa</h1>

            @if (session('error'))
                <div class="bg-red-100 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('onboarding.register') }}">
                @csrf

                <input type="hidden" name="plan" value="{{ $plan }}">


                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Empresa</label>
                    <input type="text" name="company_name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tu Nombre</label>
                    <input type="text" name="name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    Registrarse y Suscribirse al plan {{ ucfirst($plan) }}

                </button>

                <p class="text-sm text-gray-600 mt-4 text-center">
                    Serás redirigido a Stripe para ingresar tu tarjeta después del registro
                </p>
            </form>
        </div>
    </div>
</body>

</html>
