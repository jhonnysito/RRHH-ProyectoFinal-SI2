<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Sidebar -->
    <!-- Agregar el enlace al archivo de estilos de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Agregar el enlace al archivo de la biblioteca FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Agregar el enlace al archivo de la biblioteca Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="/dist/output.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Script para aplicar el tema oscuro si está guardado en localStorage
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    {{-- Estilos dinámicos del Tenant --}}
    @isset($dynamicCss)
        <style>
            {!! $dynamicCss !!}
        </style>
    @endisset

    <script>
        function collapseSidebar() {
            let sidebar = document.getElementById('sidebar');
            let mainContent = document.querySelector('main');
            let headerContent = document.querySelector('header');
            let toggle = document.getElementById('toggle-button');
            let titles = sidebar.querySelectorAll('span');

            if (sidebar.classList.contains('lg:w-[240px]')) {
                //sidebar
                sidebar.classList.remove('lg:w-[240px]');
                sidebar.classList.add('w-[55px]');

                //content
                mainContent.classList.remove('lg:w-[100wh-250px]');
                mainContent.classList.remove('lg:ml-[240px]');
                mainContent.classList.add('lg:w-[100wh-100px]');
                mainContent.classList.add('ml-[55px]');

                //header
                headerContent.classList.remove('lg:ml-[240px]');
                headerContent.classList.add('ml-[55px]');

                //toggle
                toggle.classList.remove('rotate-180');
                toggle.classList.add('rotate-0');
            } else {
                //sidebar
                sidebar.classList.remove('w-[55px]');
                sidebar.classList.add('lg:w-[240px]');

                //content
                mainContent.classList.remove('lg:w-[100wh-100px]');
                mainContent.classList.remove('ml-[55px]');
                mainContent.classList.add('lg:w-[100wh-250px]');
                mainContent.classList.add('lg:ml-[240px]');

                //header
                headerContent.classList.remove('ml-[55px]');
                headerContent.classList.add('lg:ml-[240px]');

                //toggle
                toggle.classList.remove('rotate-0');
                toggle.classList.add('rotate-180');
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="bg-gradient-to-r from-brand-light to-brand-dark"> @include('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-10xl mx-auto py-6 px-4 sm:px-6 lg:px-8 mt-[55px] ml-[55px]">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class = "ml-[55px] lg:w-[100wh-100px] mt-[55px]">
            @if (isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>


</html>
