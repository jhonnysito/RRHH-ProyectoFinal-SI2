<?php
// app/Http/Controllers/OnboardingController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant;
use App\Models\User;
use Stancl\Tenancy\Database\Models\Domain;
use Illuminate\Support\Facades\Log;

class OnboardingController extends Controller
{
    public function showForm(Request $request)
    {
        $plan = $request->query('plan'); // "basic"

        return view('saas.form-registro', compact('plan'));
        // return view('saas.form-registro');
    }

    public function register(Request $request)
    {
        /*
        // DEBUG: Verificar que las claves estén cargadas
        dd([
            'stripe_key' => env('STRIPE_KEY'),
            'stripe_secret' => env('STRIPE_SECRET'),
            'stripe_secret_length' => strlen(env('STRIPE_SECRET')),
        ]);
        */
        $request->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {

            $plan = $request->input('plan'); // "profesional"
            $priceMap = [
                'basic'        => env('STRIPE_PRICE_BASICO'),
                'profesional'  => env('STRIPE_PRICE_PROFESIONAL'),
                'premium'      => env('STRIPE_PRICE_PREMIUM'),
            ];
            $stripePriceId = $priceMap[$plan] ?? env('STRIPE_PRICE_BASICO');

            // 1. Crear tenant
            $tenantId = Str::slug($request->company_name);
            Log::info("Creando tenant con ID: {$tenantId}");

            $tenant = Tenant::create([
                'id'   => $tenantId,
                'data' => [
                    'nombre'     => $request->company_name,
                    'email'      => $request->email,
                    'admin_name' => $request->name,
                    'plan'       => 'trial',
                ],
            ]);
            Log::info("Tenant creado: {$tenant->id}");



            // 2. Crear dominio
            $domain = Domain::create([
                'tenant_id' => $tenant->id,
                'domain'    => $tenantId . '.mi-saas.com',
            ]);

            Log::info("Dominio creado: {$domain->domain}");

            // 3. Crear usuario admin
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'tenant_id' => $tenant->id,
            ]);
            Log::info("Usuario admin creado: {$user->email}");


            // 4. Crear customer en Stripe
            $tenant->createAsStripeCustomer();
            Log::info("Customer de Stripe creado para tenant {$tenant->id}, stripe_id={$tenant->stripe_id}");

            // 5. Redirigir a CHECKOUT de Stripe (aquí pedirá la tarjeta)
            return $tenant->newSubscription('default', $stripePriceId)
                ->checkout([
                    'success_url' => $tenant->url('/dashboard') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('onboarding.form') . '?canceled=true',
                    //  'customer_email' => $request->email,
                ]);
        } catch (\Exception $e) {
            return redirect()->route('onboarding.form')
                ->with('error', 'Error en el registro: ' . $e->getMessage());
        }
    }

    public function success()
    {
        return view('onboarding.success');
    }
}
