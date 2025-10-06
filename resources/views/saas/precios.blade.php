 {{-- resources/views/subscription/pricing.blade.php --}}
 @extends('layouts.central.guest') {{-- Usamos el layout para invitados para que sea accesible públicamente --}}

 @section('title', 'Planes de Suscripción - HR Pro SaaS')

 @section('styles')
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <style>
         :root {
             --primary: #2563eb;
             --secondary: #64748b;
             --accent: #10b981;
             --dark: #1e293b;
             --light: #f8fafc;
         }

         body {
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
             background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
             min-height: 100vh;
         }

         .pricing-container {
             max-width: 1200px;
             margin: 0 auto;
             padding: 2rem;
         }

         .plan-card {
             transition: all 0.3s ease;
             border-radius: 20px;
             position: relative;
         }

         .plan-card:hover {
             transform: translateY(-10px);
             box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
         }

         .plan-card.popular {
             transform: scale(1.05);
             box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.3);
         }

         .plan-card.popular::before {
             content: 'POPULAR';
             position: absolute;
             top: -10px;
             right: 20px;
             background: linear-gradient(135deg, #10b981, #059669);
             color: white;
             padding: 0.5rem 1rem;
             border-radius: 20px;
             font-size: 0.75rem;
             font-weight: bold;
             z-index: 10;
         }

         .price-toggle {
             background: white;
             border-radius: 50px;
             padding: 0.25rem;
             display: inline-flex;
             align-items: center;
             box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
         }

         .price-toggle button {
             padding: 0.5rem 1.5rem;
             border-radius: 50px;
             border: none;
             background: transparent;
             font-weight: 500;
             transition: all 0.3s ease;
         }

         .price-toggle button.active {
             background: var(--primary);
             color: white;
         }

         .feature-list {
             list-style: none;
             padding: 0;
         }

         .feature-list li {
             padding: 0.5rem 0;
             display: flex;
             align-items: center;
         }

         .feature-list li i {
             color: var(--accent);
             margin-right: 0.75rem;
             width: 20px;
         }

         .feature-list li.disabled {
             color: #9ca3af;
         }

         .feature-list li.disabled i {
             color: #d1d5db;
         }

         .btn-subscribe {
             transition: all 0.3s ease;
             border-radius: 12px;
             font-weight: 600;
             padding: 1rem 2rem;
         }

         .btn-subscribe:hover {
             transform: translateY(-2px);
             box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
         }

         .fade-in {
             animation: fadeInUp 0.6s ease-out;
         }

         @keyframes fadeInUp {
             from {
                 opacity: 0;
                 transform: translateY(30px);
             }

             to {
                 opacity: 1;
                 transform: translateY(0);
             }
         }

         .error-message {
             color: #ef4444;
             font-size: 0.875rem;
             margin-top: 0.25rem;
         }

         .success-message {
             color: #10b981;
             font-size: 0.875rem;
             margin-top: 0.25rem;
         }
     </style>
 @endsection

 @section('content')
     <div class="pricing-container">
         <!-- Header Section -->
         <div class="text-center mb-16 fade-in">
             <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Elige el Plan Perfecto para tu Empresa</h1>
             <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                 Gestiona tus recursos humanos con la flexibilidad que necesitas. Todos los planes incluyen
                 seguridad de nivel empresarial y soporte técnico prioritario.
             </p>

             <!-- Price Toggle -->
             <div class="price-toggle mb-8">
                 <button class="active" data-period="monthly" onclick="togglePricing('monthly')">
                     Mensual
                 </button>
                 <button data-period="yearly" onclick="togglePricing('yearly')">
                     Anual (Ahorra 20%)
                 </button>
             </div>

             <div class="flex justify-center items-center space-x-2 text-sm text-gray-500">
                 <i class="fas fa-lock text-accent"></i>
                 <span>Pago seguro con encriptación SSL</span>
             </div>
         </div>

         <!-- Plans Grid -->
         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
             <!-- Free Plan -->
             <div class="plan-card bg-white p-8 text-center fade-in" data-aos="fade-up">
                 <div class="mb-6">
                     <h3 class="text-2xl font-bold text-gray-800 mb-2">BASICO</h3>
                     <p class="text-gray-600">Para startups pequeñas</p>
                 </div>

                 <div class="mb-8">
                     <div class="text-4xl font-bold text-gray-800 mb-2">$15</div>
                     <div class="text-gray-500 text-sm" id="free-period">por mes</div>
                 </div>

                 <ul class="feature-list mb-8 space-y-3">
                     <li><i class="fas fa-check"></i> Hasta 10 empleados</li>
                     <li><i class="fas fa-check"></i> Gestión básica de empleados</li>
                     <li><i class="fas fa-check"></i> Reportes simples</li>
                     <li><i class="fas fa-check"></i> Soporte por email</li>
                     <li class="disabled"><i class="fas fa-times"></i> Nóminas automáticas</li>
                     <li class="disabled"><i class="fas fa-times"></i> Integraciones avanzadas</li>
                 </ul>

                 <a href="/register?plan=basico" class="btn-subscribe block w-full bg-primary text-white hover:bg-blue-700">
                     Suscribirse
                 </a>
             </div>

             <!-- Basic Plan (Popular) -->
             <div class="plan-card bg-white p-8 text-center popular fade-in" data-aos="fade-up" data-aos-delay="100">
                 <div class="mb-6">
                     <h3 class="text-2xl font-bold text-gray-800 mb-2">PROFESIONAL</h3>
                     <p class="text-gray-600">Para equipos en crecimiento</p>
                 </div>

                 <div class="mb-8">
                     <div class="text-4xl font-bold text-primary mb-2" id="basic-price">$25</div>
                     <div class="text-gray-500 text-sm" id="basic-period">por mes</div>
                     <div class="text-xs text-green-600 mt-1" id="basic-savings" style="display: none;">Ahorra $70 al año
                     </div>
                 </div>

                 <ul class="feature-list mb-8 space-y-3">
                     <li><i class="fas fa-check"></i> Hasta 50 empleados</li>
                     <li><i class="fas fa-check"></i> Gestión completa de empleados</li>
                     <li><i class="fas fa-check"></i> Nóminas básicas</li>
                     <li><i class="fas fa-check"></i> Reportes avanzados</li>
                     <li><i class="fas fa-check"></i> Soporte prioritario</li>
                     <li class="disabled"><i class="fas fa-times"></i> Evaluaciones de desempeño</li>
                     <li class="disabled"><i class="fas fa-times"></i> API personalizada</li>
                 </ul>

                 <a href="/register?plan=profesional"
                     class="btn-subscribe block w-full bg-primary text-white hover:bg-blue-700">
                     Suscribirse
                 </a>
             </div>

             <!-- Pro Plan -->
             <div class="plan-card bg-white p-8 text-center fade-in" data-aos="fade-up" data-aos-delay="200">
                 <div class="mb-6">
                     <h3 class="text-2xl font-bold text-gray-800 mb-2">PREMIUM</h3>
                     <p class="text-gray-600">Para empresas medianas</p>
                 </div>

                 <div class="mb-8">
                     <div class="text-4xl font-bold text-primary mb-2" id="pro-price">$40</div>
                     <div class="text-gray-500 text-sm" id="pro-period">por mes</div>
                     <div class="text-xs text-green-600 mt-1" id="pro-savings" style="display: none;">Ahorra $238 al año
                     </div>
                 </div>

                 <ul class="feature-list mb-8 space-y-3">
                     <li><i class="fas fa-check"></i> Hasta 200 empleados</li>
                     <li><i class="fas fa-check"></i> Todas las funciones Basic</li>
                     <li><i class="fas fa-check"></i> Nóminas automáticas completas</li>
                     <li><i class="fas fa-check"></i> Evaluaciones de desempeño</li>
                     <li><i class="fas fa-check"></i> Integraciones con 20+ apps</li>
                     <li><i class="fas fa-check"></i> Soporte 24/7</li>
                     <li class="disabled"><i class="fas fa-times"></i> Soporte dedicado</li>
                 </ul>

                 <a href="/registro-empresa?plan=pro"
                     class="btn-subscribe block w-full bg-accent text-white hover:bg-green-700">
                     Suscribirse
                 </a>
             </div>


         </div>

         <!-- Features Comparison Table -->
         <div class="bg-white rounded-2xl shadow-lg p-8 mb-16 fade-in">
             <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">Comparación de Características</h2>
             <div class="overflow-x-auto">
                 <table class="w-full text-sm">
                     <thead>
                         <tr class="border-b-2 border-gray-200">
                             <th class="text-left py-4 font-semibold text-gray-700">Característica</th>
                             <th class="text-center py-4 font-semibold text-gray-700">BASICO</th>
                             <th class="text-center py-4 font-semibold text-gray-700">PROFESIONAL</th>
                             <th class="text-center py-4 font-semibold text-gray-700">PREMIUM</th>
                         </tr>
                     </thead>
                     <tbody class="divide-y divide-gray-200">
                         <tr>
                             <td class="py-4 font-medium text-gray-700">Número de Empleados</td>
                             <td class="text-center">10</td>
                             <td class="text-center">50</td>
                             <td class="text-center">200</td>
                         </tr>
                         <tr>
                             <td class="py-4 font-medium text-gray-700">Gestión de Nóminas</td>
                             <td class="text-center"><i class="fas fa-times text-red-500"></i></td>
                             <td class="text-center"><i class="fas fa-check text-green-500"></i></td>
                             <td class="text-center"><i class="fas fa-check text-green-500"></i></td>
                         </tr>
                         <tr>
                             <td class="py-4 font-medium text-gray-700">Reportes Avanzados</td>
                             <td class="text-center"><i class="fas fa-check text-green-500"></i></td>
                             <td class="text-center"><i class="fas fa-check text-green-500"></i></td>
                             <td class="text-center"><i class="fas fa-check text-green-500"></i></td>
                         </tr>
                         <tr>
                             <td class="py-4 font-medium text-gray-700">Evaluaciones de Desempeño</td>
                             <td class="text-center"><i class="fas fa-times text-red-500"></i></td>
                             <td class="text-center"><i class="fas fa-times text-red-500"></i></td>
                             <td class="text-center"><i class="fas fa-check text-green-500"></i></td>
                         </tr>
                         <tr>
                             <td class="py-4 font-medium text-gray-700">Integraciones</td>
                             <td class="text-center">Básicas</td>
                             <td class="text-center">10+</td>
                             <td class="text-center">20+</td>
                         </tr>
                         <tr>
                             <td class="py-4 font-medium text-gray-700">Soporte</td>
                             <td class="text-center">Email</td>
                             <td class="text-center">Prioritario</td>
                             <td class="text-center">24/7</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
