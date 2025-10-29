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
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistroExitosoCuentaMail;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;


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
        $request->validate([
            'company_name' => 'required|string|max:255',
            'name'         => 'required|string|max:255',
            'email'        => 'required|email',
            'password'     => 'required|min:8|confirmed',
        ]);

        try {
            $plan = $request->input('plan');
            $priceMap = [
                'basic'       => env('STRIPE_PRICE_BASICO'),
                'profesional' => env('STRIPE_PRICE_PROFESIONAL'),
                'premium'     => env('STRIPE_PRICE_PREMIUM'),
            ];
            $stripePriceId = $priceMap[$plan] ?? env('STRIPE_PRICE_BASICO');

            Stripe::setApiKey(env('STRIPE_SECRET'));



            // ⚡ Solo crear la sesión de Checkout
            $session = \Stripe\Checkout\Session::create([
                'mode'        => 'subscription',
                'line_items'  => [[
                    'price'    => $stripePriceId,
                    'quantity' => 1,
                ]],
                'customer_email' => $request->email,
                'success_url'    => route('onboarding.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'     => route('onboarding.form') . '?canceled=true',
                'metadata'       => [
                    'company_name' => $request->company_name,
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'password'     => $request->password, // ⚠️ mejor encriptar o regenerar luego
                    'plan'         => $plan,
                ],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return redirect()->route('onboarding.form')
                ->with('error', 'Error en el registro: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('onboarding.form')
                ->with('error', 'No se encontró la sesión de Stripe.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = StripeSession::retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return redirect()->route('onboarding.form')
                ->with('error', 'El pago no fue confirmado.');
        }

        // Recuperar metadata
        $companyName = $session->metadata->company_name;
        $name        = $session->metadata->name;
        $email       = $session->metadata->email;
        $password    = $session->metadata->password;
        $plan        = $session->metadata->plan;

        // Crear tenant
        $tenantId = Str::slug($companyName);
        $tenant = Tenant::create([
            'id'   => $tenantId,
            'data' => [
                'nombre'     => $companyName,
                'email'      => $email,
                'admin_name' => $name,
                'plan'       => $plan,
            ],
        ]);

        // Crear dominio
        Domain::create([
            'tenant_id' => $tenant->id,
            'domain'    => $tenantId . '.mi-saas.com',
        ]);

        // Crear usuario admin
        $user = User::create([
            'name'      => $name,
            'email'     => $email,
            'password'  => Hash::make($password),
            'tenant_id' => $tenant->id,
        ]);


        // Enviar correo
        Mail::to($user->email)->send(new RegistroExitosoCuentaMail($user));


        return view('saas.registro-exitoso', compact('tenant', 'user'));
    }
}
