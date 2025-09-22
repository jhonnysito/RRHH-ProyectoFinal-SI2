<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/tailwindcss@1.0.4/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="h-full overflow-hidden items-center justify-center" style="background: #edf2f7;">
    <div class="bg-purple-800 p-8 h-screen">
        <div class="bg-white flex flex-col font-sans h-full">
            <div class="px-4 h-full">
                <header class="flex flex-col sm:flex-row items-center justify-between py-6 relative">
                    <h3 class="text-2xl font-bold uppercase text-blue-900">PUESTOS DISPONIBLES</h3>
                    <nav class="text-lg">
                        @auth
                            <div class="md:flex">
                                <a href="{{ url('/dashboard') }}"
                                    class="text-gray-800 hover:text-purple-300 py-3 px-6">Dashboard</a>
                            </div>
                        @else
                            <div class="flex justify-center md:justify-start">
                                <a href="{{ route('puestos') }}"
                                    class="text-sm md:text-base text-gray-800 hover:text-purple-300 py-2 px-2 sm:py-3 sm:px-3 md:px-4 lg:px-6">Puestos
                                    Disponibles</a>
                                <a href="#"
                                    class="text-sm md:text-base text-gray-800 hover:text-purple-300 py-2 px-2 sm:py-3 sm:px-3 md:px-4 lg:px-6">Información
                                    de la empresa</a>
                                {{-- <a href="#" class="text-sm md:text-base text-gray-800 hover:text-purple-300 py-2 px-2 sm:py-3 sm:px-3 md:px-4 lg:px-6">Contact</a>
                                <a href="#" class="text-sm md:text-base text-gray-800 hover:text-purple-300 py-2 px-2 sm:py-3 sm:px-3 md:px-4 lg:px-6">FAQ</a> --}}
                                <a href="{{ url('/') }}"
                                    class="bg-purple-200 hover:bg-purple-300 rounded-full uppercase text-sm md:text-base text-purple-700 py-2 px-3 sm:py-3 sm:px-4 md:px-6 lg:px-8">Home</a>
                            </div>
                        @endauth
                    </nav>

                </header>
                <title>Puestos Disponibles</title>
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full">
                                    <thead class="bg-white border-b">
                                        <tr>
                                            <th scope="col"
                                                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                Nombre
                                            </th>
                                            <th scope="col"
                                                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                Información
                                            </th>
                                            <th scope="col"
                                                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                Puestos Disponibles
                                            </th>
                                            <th scope="col"
                                                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($puesto_disponibles as $Puesto_Disponible)
                                            <tr class="bg-gray-100 border-b">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $Puesto_Disponible->nombre }}</td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ $Puesto_Disponible->informacion }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ $Puesto_Disponible->disponible }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <a href="{{ route('register') }}"
                                                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-4 rounded">
                                                        Postularse
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
