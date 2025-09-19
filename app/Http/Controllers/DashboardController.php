<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Muestra la vista principal del dashboard.
     */
    public function index(): View
    {


        // En cualquier controlador o vista, pon esto:
        dd([
            'bitacora_id_session' => session('bitacora_id'),
            'usuario_logueado' => auth()->user()->name ?? 'No hay usuario'
        ]);
        return view('dashboard');
    }
}
