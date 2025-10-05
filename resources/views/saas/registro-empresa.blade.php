 {{-- resources/views/auth/register-company.blade.php --}}
 @extends('layouts.guest') {{-- Usamos el layout para invitados --}}

 @section('title', 'Registrar Empresa - HR Pro SaaS')

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
             background: linear-gradient(135deg, #667eea 0%, #2563eb 100%);
             min-height: 100vh;
             display: flex;
             align-items: center;
             justify-content: center;
             padding: 20px;
         }

         .register-container {
             background: white;
             border-radius: 20px;
             box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
             overflow: hidden;
             width: 100%;
             max-width: 1000px;
         }

         .form-step {
             display: none;
             animation: fadeIn 0.5s ease-in-out;
         }

         .form-step.active {
             display: block;
         }

         .progress-bar {
             transition: width 0.5s ease-in-out;
         }

         @keyframes fadeIn {
             from {
                 opacity: 0;
                 transform: translateY(20px);
             }

             to {
                 opacity: 1;
                 transform: translateY(0);
             }
         }

         .input-group {
             position: relative;
         }

         .input-group i {
             position: absolute;
             left: 15px;
             top: 50%;
             transform: translateY(-50%);
             color: #64748b;
         }

         .input-group input {
             padding-left: 45px;
         }

         .checkbox-label {
             display: flex;
             align-items: flex-start;
             gap: 12px;
         }

         .checkbox-label input[type="checkbox"] {
             margin-top: 2px;
         }

         .error-message {
             color: #ef4444;
             font-size: 0.875rem;
             margin-top: 0.25rem;
         }
     </style>
 @endsection

 @section('content')
     <div class="register-container">
         <div class="grid grid-cols-1 lg:grid-cols-2">
             <!-- Left Side - Form -->
             <div class="p-8 lg:p-12">
                 <div class="text-center mb-8">
                     <h1 class="text-3xl font-bold text-gray-800 mb-2">Crear Cuenta Empresarial</h1>
                     <p class="text-gray-600">Comienza a gestionar tus recursos humanos de manera eficiente</p>
                 </div>

                 <!-- Progress Steps -->
                 <div class="mb-8">
                     <div class="flex justify-between items-center mb-4">
                         <div class="flex items-center">
                             <div
                                 class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                 1</div>
                             <span class="ml-2 text-sm font-medium text-gray-700">Información Empresa</span>
                         </div>
                         <div class="flex items-center">
                             <div
                                 class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold">
                                 2</div>
                             <span class="ml-2 text-sm font-medium text-gray-500">Administrador</span>
                         </div>
                         <div class="flex items-center">
                             <div
                                 class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold">
                                 3</div>
                             <span class="ml-2 text-sm font-medium text-gray-500">Confirmación</span>
                         </div>
                     </div>
                     <div class="w-full bg-gray-200 rounded-full h-2">
                         <div class="progress-bar bg-blue-600 h-2 rounded-full" style="width: 33%"></div>
                     </div>
                 </div>

                 {{-- Form principal con CSRF --}}
                 <div id="registerForm">

                     {{--  <form id="registerForm" method="POST" action="{{ route('register.company') }}"  --}}
                     {{-- enctype="multipart/form-data"> --}}
                     @csrf

                     {{-- Step 1: Company Information --}}
                     <div class="form-step active" id="step1">
                         <h2 class="text-xl font-semibold text-gray-800 mb-6">Información de tu Empresa</h2>

                         <div class="space-y-6">
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Empresa *</label>
                                 <div class="input-group">
                                     <i class="fas fa-building"></i>
                                     <input type="text" name="company_name"
                                         class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                         placeholder="Ej: Mi Empresa S.A." value="{{ old('company_name') }}" required>
                                 </div>
                                 @error('company_name')
                                     <div class="error-message">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">RUC/RIF *</label>
                                     <div class="input-group">
                                         <i class="fas fa-id-card"></i>
                                         <input type="text" name="ruc"
                                             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                             placeholder="Número de identificación" value="{{ old('ruc') }}" required>
                                     </div>
                                     @error('ruc')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Industria *</label>
                                     <select name="industry"
                                         class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                         required>
                                         <option value="">Seleccionar industria</option>
                                         <option value="tech" {{ old('industry') == 'tech' ? 'selected' : '' }}>Tecnología
                                         </option>
                                         <option value="finance" {{ old('industry') == 'finance' ? 'selected' : '' }}>
                                             Finanzas</option>
                                         <option value="healthcare" {{ old('industry') == 'healthcare' ? 'selected' : '' }}>
                                             Salud</option>
                                         <option value="education" {{ old('industry') == 'education' ? 'selected' : '' }}>
                                             Educación</option>
                                         <option value="retail" {{ old('industry') == 'retail' ? 'selected' : '' }}>Retail
                                         </option>
                                         <option value="manufacturing"
                                             {{ old('industry') == 'manufacturing' ? 'selected' : '' }}>Manufactura</option>
                                         <option value="other" {{ old('industry') == 'other' ? 'selected' : '' }}>Otra
                                         </option>
                                     </select>
                                     @error('industry')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>

                             <div>
                                 <label class="block text-sm font-medium text-gray-700 mb-2">Dirección *</label>
                                 <div class="input-group">
                                     <i class="fas fa-map-marker-alt"></i>
                                     <input type="text" name="address"
                                         class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                         placeholder="Dirección completa" value="{{ old('address') }}" required>
                                 </div>
                                 @error('address')
                                     <div class="error-message">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">País *</label>
                                     <select name="country"
                                         class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                         required>
                                         <option value="">Seleccionar país</option>
                                         <option value="mx" {{ old('country') == 'mx' ? 'selected' : '' }}>México
                                         </option>
                                         <option value="es" {{ old('country') == 'es' ? 'selected' : '' }}>España
                                         </option>
                                         <option value="co" {{ old('country') == 'co' ? 'selected' : '' }}>Colombia
                                         </option>
                                         <option value="ar" {{ old('country') == 'ar' ? 'selected' : '' }}>Argentina
                                         </option>
                                         <option value="pe" {{ old('country') == 'pe' ? 'selected' : '' }}>Perú
                                         </option>
                                         <option value="cl" {{ old('country') == 'cl' ? 'selected' : '' }}>Chile
                                         </option>
                                     </select>
                                     @error('country')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad *</label>
                                     <input type="text" name="city"
                                         class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                         placeholder="Ciudad" value="{{ old('city') }}" required>
                                     @error('city')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Código Postal</label>
                                     <input type="text" name="postal_code"
                                         class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                         placeholder="C.P." value="{{ old('postal_code') }}">
                                     @error('postal_code')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>

                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                                     <div class="input-group">
                                         <i class="fas fa-phone"></i>
                                         <input type="tel" name="phone"
                                             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                             placeholder="+1 (555) 000-0000" value="{{ old('phone') }}" required>
                                     </div>
                                     @error('phone')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad de Empleados
                                         *</label>
                                     <select name="employee_count"
                                         class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                         required>
                                         <option value="">Seleccionar rango</option>
                                         <option value="1-10" {{ old('employee_count') == '1-10' ? 'selected' : '' }}>
                                             1-10 empleados</option>
                                         <option value="11-50" {{ old('employee_count') == '11-50' ? 'selected' : '' }}>
                                             11-50 empleados</option>
                                         <option value="51-200" {{ old('employee_count') == '51-200' ? 'selected' : '' }}>
                                             51-200 empleados</option>
                                         <option value="201-500"
                                             {{ old('employee_count') == '201-500' ? 'selected' : '' }}>201-500 empleados
                                         </option>
                                         <option value="501+" {{ old('employee_count') == '501+' ? 'selected' : '' }}>
                                             501+ empleados</option>
                                     </select>
                                     @error('employee_count')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>
                         </div>

                         <div class="mt-8 flex justify-end">
                             <button type="button" onclick="nextStep(2)"
                                 class="bg-blue-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                 Siguiente <i class="fas fa-arrow-right ml-2"></i>
                             </button>
                         </div>
                     </div>

                     {{-- Step 2: Admin Information --}}
                     <div class="form-step" id="step2">
                         <h2 class="text-xl font-semibold text-gray-800 mb-6">Información del Administrador</h2>

                         <div class="space-y-6">
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                                     <div class="input-group">
                                         <i class="fas fa-user"></i>
                                         <input type="text" name="first_name"
                                             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                             placeholder="Nombre" value="{{ old('first_name') }}" required>
                                     </div>
                                     @error('first_name')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Apellido *</label>
                                     <div class="input-group">
                                         <i class="fas fa-user"></i>
                                         <input type="text" name="last_name"
                                             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                             placeholder="Apellido" value="{{ old('last_name') }}" required>
                                     </div>
                                     @error('last_name')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>

                             <div>
                                 <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico *</label>
                                 <div class="input-group">
                                     <i class="fas fa-envelope"></i>
                                     <input type="email" name="email"
                                         class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                         placeholder="tu@empresa.com" value="{{ old('email') }}" required>
                                 </div>
                                 @error('email')
                                     <div class="error-message">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña *</label>
                                     <div class="input-group">
                                         <i class="fas fa-lock"></i>
                                         <input type="password" name="password"
                                             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                             placeholder="Mínimo 8 caracteres" required>
                                     </div>
                                     @error('password')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                     <p class="text-xs text-gray-500 mt-1">Incluye mayúsculas, números y símbolos</p>
                                 </div>
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña
                                         *</label>
                                     <div class="input-group">
                                         <i class="fas fa-lock"></i>
                                         <input type="password" name="password_confirmation"
                                             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                             placeholder="Repite tu contraseña" required>
                                     </div>
                                     @error('password_confirmation')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>

                             <div>
                                 <label class="block text-sm font-medium text-gray-700 mb-2">Cargo en la Empresa *</label>
                                 <select name="position"
                                     class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                     required>
                                     <option value="">Seleccionar cargo</option>
                                     <option value="ceo" {{ old('position') == 'ceo' ? 'selected' : '' }}>CEO/Director
                                     </option>
                                     <option value="hr" {{ old('position') == 'hr' ? 'selected' : '' }}>Gerente de RH
                                     </option>
                                     <option value="finance" {{ old('position') == 'finance' ? 'selected' : '' }}>Gerente
                                         Financiero</option>
                                     <option value="admin" {{ old('position') == 'admin' ? 'selected' : '' }}>
                                         Administrador</option>
                                     <option value="other" {{ old('position') == 'other' ? 'selected' : '' }}>Otro
                                     </option>
                                 </select>
                                 @error('position')
                                     <div class="error-message">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono de Contacto
                                         *</label>
                                     <div class="input-group">
                                         <i class="fas fa-mobile-alt"></i>
                                         <input type="tel" name="admin_phone"
                                             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                             placeholder="+1 (555) 000-0000" value="{{ old('admin_phone') }}" required>
                                     </div>
                                     @error('admin_phone')
                                         <div class="error-message">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-2">Extensión</label>
                                     <input type="text" name="extension" class
                                         class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                         placeholder="Opcional" value="{{ old('extension') }}">
                                 </div>
                             </div>
                         </div>

                         <div class="mt-8 flex justify-between">
                             <button type="button" onclick="prevStep(1)"
                                 class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                                 <i class="fas fa-arrow-left mr-2"></i> Anterior
                             </button>
                             <button type="button" onclick="nextStep(3)"
                                 class="bg-blue-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                 Siguiente <i class="fas fa-arrow-right ml-2"></i>
                             </button>
                         </div>
                     </div>

                     {{-- Step 3: Confirmation --}}
                     <div class="form-step" id="step3">
                         <h2 class="text-xl font-semibold text-gray-800 mb-6">Confirmación y Términos</h2>

                         <div class="space-y-6">
                             <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                 <h3 class="font-semibold text-gray-800 mb-4">Revisa la información:</h3>
                                 <p class="text-sm text-gray-600">Estás a punto de crear una cuenta para <strong
                                         id="confirm-company-name" class="text-gray-900"></strong> con el correo de
                                     administrador <strong id="confirm-email" class="text-gray-900"></strong>.</p>
                                 <p class="text-sm text-gray-600 mt-2">Al registrarte, se creará un subdominio único para
                                     tu empresa.</p>
                             </div>

                             <div class="checkbox-label">
                                 <input type="checkbox" name="terms" id="terms"
                                     class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" required>
                                 <label for="terms" class="text-sm text-gray-600">
                                     He leído y acepto los <a href="#"
                                         class="text-blue-600 hover:underline font-medium">Términos de Servicio</a> y la
                                     <a href="#" class="text-blue-600 hover:underline font-medium">Política de
                                         Privacidad</a>.
                                 </label>
                             </div>
                             @error('terms')
                                 <div class="error-message">{{ $message }}</div>
                             @enderror
                         </div>

                         <div class="mt-8 flex justify-between items-center">
                             <button type="button" onclick="prevStep(2)"
                                 class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                                 <i class="fas fa-arrow-left mr-2"></i> Anterior
                             </button>
                             <button type="submit"
                                 class="bg-green-500 text-white px-8 py-3 rounded-lg font-medium hover:bg-green-600 transition-all transform hover:scale-105 shadow-lg">
                                 <i class="fas fa-check-circle mr-2"></i> Finalizar Registro
                             </button>
                         </div>
                     </div>
                     {{-- </form> --}}
                 </div>
             </div>

             <!-- Right Side - Image -->
             <div class="hidden lg:block bg-cover bg-center"
                 style="background-image: url('https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80');">
                 <div class="h-full bg-black bg-opacity-40 flex flex-col justify-end p-12">
                     <h2 class="text-3xl font-bold text-white leading-tight">La plataforma que tu equipo merece.</h2>
                     <p class="text-gray-200 mt-4">Simplifica, automatiza y crece con HRSuite.</p>
                 </div>
             </div>
         </div>
     </div>
 @endsection

 @section('scripts')
     <script>
         let currentStep = 1;
         const formSteps = document.querySelectorAll('.form-step');
         const progressSteps = document.querySelectorAll('.progress-bar-container .flex.items-center');
         const progressBar = document.querySelector('.progress-bar');

         function showStep(step) {
             formSteps.forEach((formStep, index) => {
                 formStep.classList.toggle('active', index + 1 === step);
             });

             const progressWidth = ((step - 1) / (formSteps.length - 1)) * 100;
             progressBar.style.width = `${progressWidth}%`;

             currentStep = step;
         }

         function nextStep(step) {
             showStep(step);
         }

         function prevStep(step) {
             showStep(step);
         }

         document.addEventListener('DOMContentLoaded', () => {
             showStep(1);
         });
     </script>
 @endsection
