<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRSuite - Gestión de Recursos Humanos Simplificada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        primary: {
                            DEFAULT: 'hsl(var(--primary))',
                            foreground: 'hsl(var(--primary-foreground))',
                        },
                        // Asumiendo un tema Shadcn-like: primary blue
                        // Puedes ajustar en tu CSS global si usas variables CSS
                    }
                }
            }
        }
    </script>
    <style>
        /* Variables CSS para emular Shadcn theme (ajusta según tu tema) */
        :root {
            --background: 0 0% 100%;
            --foreground: 222.2 84% 4.9%;
            --primary: 221.2 83.2% 53.3%;
            --primary-foreground: 210 40% 98%;
            --muted: 210 40% 96%;
            --muted-foreground: 215.4 16.3% 46.9%;
            --border: 214.3 31.8% 91.4%;
            --border-color: hsl(var(--border));
        }

        [data-theme="dark"] {
            --background: 222.2 84% 4.9%;
            --foreground: 210 40% 98%;
            --primary: 217.2 91.2% 59.8%;
            --primary-foreground: 222.2 84% 4.9%;
            --muted: 217.2 32.6% 17.5%;
            --muted-foreground: 215 20.2% 65.1%;
            --border: 217.2 32.6% 17.5%;
        }

        /* Gradientes y efectos */
        .bg-primary {
            background-color: hsl(var(--primary));
        }

        .text-primary {
            color: hsl(var(--primary));
        }

        .bg-primary-foreground {
            background-color: hsl(var(--primary-foreground));
        }

        .text-primary-foreground {
            color: hsl(var(--primary-foreground));
        }

        .bg-background {
            background-color: hsl(var(--background));
        }

        .text-foreground {
            color: hsl(var(--foreground));
        }

        .text-muted-foreground {
            color: hsl(var(--muted-foreground));
        }

        .border-border {
            border-color: hsl(var(--border));
        }

        .bg-muted {
            background-color: hsl(var(--muted));
        }
    </style>
</head>

<body class="bg-background text-foreground min-h-screen">
    <!-- Navigation -->
    <nav
        class="bg-background/95 backdrop-blur-sm border-b border-border/40 px-4 sm:px-6 lg:px-8 py-4 fixed w-full top-0 z-50">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center">
                <div
                    class="h-10 w-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md">
                    <span class="text-white font-bold text-lg">SA</span>
                </div>
                <span
                    class="ml-3 text-xl font-semibold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                    Saas RRHH
                </span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex space-x-8">
                <a href="#" class="text-foreground hover:text-blue-500 transition-colors">Inicio</a>
                <a href="#" class="text-gray-500 hover:text-blue-500 transition-colors">Características</a>
                <a href="/precios" class="text-gray-500 hover:text-blue-500 transition-colors">Precios</a>
                <a href="#" class="text-gray-500 hover:text-blue-500 transition-colors">Contacto</a>
            </div>

            <div class="hidden md:flex space-x-4">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-transparent border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    Iniciar Sesión
                </a>
                <a href="/registro-empresa"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 transition-colors">
                    Registrarse
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden" onclick="toggleMobileMenu()">
                <div class="w-6 h-6 flex flex-col justify-center space-y-1">
                    <div class="h-0.5 w-6 bg-gray-900"></div>
                    <div class="h-0.5 w-6 bg-gray-900"></div>
                    <div class="h-0.5 w-6 bg-gray-900"></div>
                </div>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden hidden mt-4 py-4 space-y-4 border-t border-gray-200">
            <a href="#" class="block text-gray-900 hover:text-blue-500">Inicio</a>
            <a href="#" class="block text-gray-500 hover:text-blue-500">Características</a>
            <a href="/" class="block text-gray-500 hover:text-blue-500">Precios</a>
            <a href="#" class="block text-gray-500 hover:text-blue-500">Contacto</a>
            <div class="pt-4 space-y-2">
                <a href="{{ route('login') }}"
                    class="block w-full text-center px-4 py-2 text-sm font-medium text-gray-700 bg-transparent border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    Iniciar Sesión
                </a>
                <a href="/registro-empresa"
                    class="block w-full text-center px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 transition-colors">
                    Registrarse
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-gray-50 pt-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight">
                        Gestión de Recursos Humanos
                        <span class="bg-gradient-to-r from-blue-500 to-blue-400 bg-clip-text text-transparent">
                            Simplificada</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 max-w-2xl">
                        Optimiza la gestión de tu equipo humano con nuestra plataforma todo-en-uno.
                        Desde nóminas y gestión de talento hasta análisis de rendimiento, todo en un solo lugar.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <button
                            class="text-lg py-6 px-8 bg-gradient-to-r from-blue-500 to-blue-400 hover:from-blue-600 hover:to-blue-500 shadow-lg hover:shadow-blue-200 text-white rounded-md transition-all">
                            Comenzar Gratis
                        </button>
                        <button
                            class="text-lg py-6 px-8 border-2 border-blue-500 text-blue-500 hover:bg-blue-50 rounded-md transition-all">
                            Ver Demo
                        </button>
                    </div>
                </div>

                <div class="relative">
                    {{-- Asumiendo que guardaste tu imagen en public/images/saas/dashboard-hero.png --}}
                    <img src="{{ asset('archivos/rrhh.png') }}"
                        alt="Dashboard de HRSuite mostrando análisis de empleados"
                        class="rounded-lg shadow-2xl w-full" />
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                    Todo lo que necesitas para gestionar tu equipo
                </h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Características diseñadas para simplificar la gestión de recursos humanos y mejorar la productividad
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="border-none shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 rounded-lg p-6 bg-white">
                    <div
                        class="h-12 w-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Gestión de Empleados</h3>
                    <p class="text-gray-500 text-sm">
                        Administra toda la información de tus empleados en un solo lugar
                    </p>
                    <img src="https://placeholder-image-service.onrender.com/image/300x200?prompt=Employee%20management%20interface%20showing%20team%20profiles%20and%20details&id=erp-feature-1"
                        alt="Interfaz de gestión de empleados mostrando perfiles de equipo y detalles organizativos"
                        class="rounded-lg w-full mt-4" />
                </div>

                <!-- Feature 2 -->
                <div
                    class="border-none shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 rounded-lg p-6 bg-white">
                    <div
                        class="h-12 w-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Nóminas Automáticas</h3>
                    <p class="text-gray-500 text-sm">
                        Calcula y procesa nóminas de forma automática y sin errores
                    </p>
                    <img src="https://placeholder-image-service.onrender.com/image/300x200?prompt=Payroll%20management%20dashboard%20with%20salary%20calculations%20and%20reports&id=erp-feature-2"
                        alt="Dashboard de gestión de nóminas con cálculos salariales y reportes financieros"
                        class="rounded-lg w-full mt-4" />
                </div>

                <!-- Feature 3 -->
                <div
                    class="border-none shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 rounded-lg p-6 bg-white">
                    <div
                        class="h-12 w-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Análisis de Rendimiento</h3>
                    <p class="text-gray-500 text-sm">
                        Obtén insights detallados sobre el rendimiento de tu equipo
                    </p>
                    <img src="https://placeholder-image-service.onrender.com/image/300x200?prompt=Performance%20analytics%20dashboard%20with%20charts%20and%20metrics&id=erp-feature-3"
                        alt="Dashboard de análisis de rendimiento con gráficos y métricas de desempeño laboral"
                        class="rounded-lg w-full mt-4" />
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gradient-to-b from-white to-gray-100 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                    Confiado por empresas líderes
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Descubre por qué miles de empresas eligen nuestra plataforma
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="text-center border-none shadow-md hover:shadow-lg transition-all duration-300 rounded-lg p-6 bg-white">
                    <div class="w-16 h-16 mx-auto mb-4 ring-2 ring-blue-100 rounded-full p-0.5">
                        <img src="https://placeholder-image-service.onrender.com/image/64x64?prompt=Professional%20headshot%20of%40female%20executive%20in%20business%20attire&id=testimonial-1"
                            alt="Fotografía profesional de ejecutiva con traje de negocios sonriendo"
                            class="rounded-full w-full h-full object-cover" />
                    </div>
                    <p class="text-gray-600 italic text-sm">
                        "HRSuite ha transformado nuestra gestión de recursos humanos. Ahorramos 20 horas semanales en
                        procesos administrativos."
                    </p>
                    <p class="font-semibold mt-4 text-gray-900">María López</p>
                    <p class="text-sm text-gray-500">Directora de RH, TechCorp</p>
                </div>

                <div
                    class="text-center border-none shadow-md hover:shadow-lg transition-all duration-300 rounded-lg p-6 bg-white">
                    <div class="w-16 h-16 mx-auto mb-4 ring-2 ring-blue-100 rounded-full p-0.5">
                        <img src="https://placeholder-image-service.onrender.com/image/64x64?prompt=Professional%20headshot%20of%20male%20CEO%20in%20suit&id=testimonial-2"
                            alt="Fotografía profesional de CEO masculino con traje formal y sonrisa confiada"
                            class="rounded-full w-full h-full object-cover" />
                    </div>
                    <p class="text-gray-600 italic text-sm">
                        "La plataforma es intuitiva y poderosa. Los reportes analytics nos han ayudado a tomar mejores
                        decisiones."
                    </p>
                    <p class="font-semibold mt-4 text-gray-900">Carlos Mendoza</p>
                    <p class="text-sm text-gray-500">CEO, InnovateStartup</p>
                </div>

                <div
                    class="text-center border-none shadow-md hover:shadow-lg transition-all duration-300 rounded-lg p-6 bg-white">
                    <div class="w-16 h-16 mx-auto mb-4 ring-2 ring-blue-100 rounded-full p-0.5">
                        <img src="https://placeholder-image-service.onrender.com/image/64x64?prompt=Professional%20headshot%20of%20female%20HR%20manager%20smiling&id=testimonial-3"
                            alt="Fotografía profesional de gerente de recursos humanos sonriendo con confianza"
                            class="rounded-full w-full h-full object-cover" />
                    </div>
                    <p class="text-gray-600 italic text-sm">
                        "El soporte al cliente es excepcional. Siempre están disponibles para ayudar y las
                        actualizaciones son constantes."
                    </p>
                    <p class="font-semibold mt-4 text-gray-900">Ana Rodríguez</p>
                    <p class="text-sm text-gray-500">Gerente de RH, GlobalServices</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-500 to-blue
