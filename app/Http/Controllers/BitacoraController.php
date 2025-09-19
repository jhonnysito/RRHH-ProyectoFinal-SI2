<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;

class BitacoraController extends Controller
{
    public function inicio($id)
    {
        $usuario = User::where('id', '=', $id)->first();
        $bitacoras = Bitacora::where('ID_Usuario', '=', $id)->get();
        return view('bitacora.inicio', compact('bitacoras', 'usuario'));
    }

    public function rinicio()
    {
        $bitacoras = Bitacora::all();
        return view('bitacora.rinicio', compact('bitacoras'));
    }
}
