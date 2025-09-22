<?php

namespace App\Http\Controllers;

use App\Models\Postulante;
use App\Models\Puesto_Disponible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Puesto_DisponibleController extends Controller
{
    public function inicio(){
        $puesto_disponibles = Puesto_Disponible::all();
        return view ('puesto_disponibles.inicio', compact('puesto_disponibles'));
    }

    public function crear()
    {
        return view('puesto_disponibles.crear');
    }

    public function guardar(REQUEST $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'informacion' => 'required|string',
            'disponible' => 'required|integer|min:0',
        ]);
        $puesto_disponibles = new Puesto_Disponible();
        $puesto_disponibles->nombre = $request->nombre;
        $puesto_disponibles->informacion = $request->informacion;
        $puesto_disponibles->disponible = $request->disponible;
        $puesto_disponibles->save();

        return redirect(route('puesto_disponibles.inicio'))->with('creado', 'Puesto Disponible creado exitosamente');
    }

    public function editar($id)
    {
        $puesto_disponibles = Puesto_Disponible::where('id', '=', $id)->first();
        return view('puesto_disponibles.editar', compact('puesto_disponibles'));
    }

    public function actualizar(REQUEST $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'informacion' => 'required|string',
            'disponible' => 'required|integer|min:0',
        ]);
        $puesto_disponibles = Puesto_Disponible::where('id', '=', $id)->first();
        $puesto_disponibles->nombre = $request->nombre;
        $puesto_disponibles->informacion = $request->informacion;
        $puesto_disponibles->disponible = $request->disponible;
        $puesto_disponibles->save();

        
        return redirect(route('puesto_disponibles.inicio'))->with('actualizado', 'Puesto Disponible actualizada exitosamente');
    }

    public function eliminar($id)
    {
        $puesto_disponibles = Puesto_Disponible::where('id', '=', $id)->first();
        $nombre = $puesto_disponibles->nombre;
        $puesto_disponibles->delete();


        return redirect(route('puesto_disponibles.inicio'))->with('eliminado', 'Puesto_Disponible ' . $nombre . ' eliminado exitosamente');
    }

    public function disponibles(){
        $puesto_disponibles = Puesto_Disponible::where('disponible', '>', 0)->get();
        return view ('puesto_disponibles.puestos', compact('puesto_disponibles'));
    }

    public function postularse($idpuesto){
        $id = Auth::user()->id;
        $postulante = Postulante::where('ID_Usuario', '=', $id)->first();
        $postulante->ID_Puesto_Disponible = $idpuesto;
        $postulante->estado = null;
        $postulante->save();
        return redirect(route('puesto_disponibles.disponibles'))->with('actualizado', 'Has pustulado al puesto exitosamente');
    }
}
