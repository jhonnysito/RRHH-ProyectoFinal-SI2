<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BitacoraController extends Controller
{
    /**
     * Muestra la lista de registros de la bitácora.
     */
    public function index(): View
    {
        // Obtenemos los registros de la bitácora, con sus detalles y el usuario asociado.
        // Ordenamos por el más reciente y paginamos los resultados.
        $bitacoras = Bitacora::with(['user', 'detalles'])
            ->latest()
            ->paginate(15);

        return view('bitacora.index', [
            'bitacoras' => $bitacoras,
        ]);
    }
}
