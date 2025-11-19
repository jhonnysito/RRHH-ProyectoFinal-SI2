<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\BillingPortal\Session as PortalSession;
use App\Models\User;

class SuscripcionController extends Controller
{
    public function __construct()
    {
        // Configurar la API key globalmente
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Muestra la vista de precios (si no tiene plan).
     */
    public function index()
    {
        return view('suscripcion.planes'); // Tienes que crear esta vista
    }

    /**
     * Inicia el proceso de pago (Checkout) para un plan nuevo.
     * Se llama cuando el usuario hace clic en "Comprar Plan Básico".
     */
    public function suscribirse(Request $request, $planId)
    {
        $user = Auth::user();
        $tenant = $user->tenant; 
        // 1. Crear cliente en Stripe si no existe
        if (!$tenant->stripe_id) {
            $customer = Customer::create([
                'email' => $user->email,
                'name' => $tenant->id, 
            ]);
           $tenant->update(['stripe_id' => $customer->id]);
        }

        // 2. Crear sesión de Checkout
     
        $priceId = match($planId) {
            'basico' => 'price_1SPufq8jtgmTdLPBaEwIzDQw', // Pega aquí tu ID de precio Básico
            'medio' => 'price_1SPuh78jtgmTdLPBj82pakiJ',  // Pega aquí tu ID de precio Medio
            'avanzado' => 'price_1SPui88jtgmTdLPBVIwhRLVW', // Pega aquí tu ID de precio Avanzado
        };

        $session = CheckoutSession::create([
            'customer' => $tenant->stripe_id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' =>route('suscripcion.exito'),
            'cancel_url' => route('suscripcion.index'),
        ]);

        return redirect($session->url);
    }

    /**
     * Redirige al Portal de Cliente (para cambiar plan o cancelar).
     * Se llama desde el botón "Administrar Suscripción" del menú.
     */
    public function portal()
    {
        $user = Auth::user();

        // Si el usuario no tiene ID de Stripe, no puede entrar al portal.
        // Debería ir a comprar un plan primero.
        if (!$user->stripe_id) {
            return redirect()->route('suscripcion.index')->with('error', 'Primero debes suscribirte a un plan.');
        }

        // Crear sesión del portal
        $session = PortalSession::create([
            'customer' => $user->stripe_id,
            'return_url' => route('dashboard'), // A donde vuelve al salir
        ]);

        return redirect($session->url);
    }
     public function exito()
    {
        return view('suscripcion.exito');
    }
}