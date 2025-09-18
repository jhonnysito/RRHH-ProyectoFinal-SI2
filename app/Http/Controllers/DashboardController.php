<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Muestra la vista principal del dashboard.
     */
    public function index(): View
    {
        return view('dashboard');
    }
}
