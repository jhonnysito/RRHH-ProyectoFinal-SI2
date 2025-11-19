<?php

// app/Http/Controllers/Api/LocationRecordController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\LocationRecord;
use Illuminate\Support\Facades\Validator;

class LocationRecordController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'recorded_at' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $record = LocationRecord::create($validator->validated());

        return response()->json([
            'message' => 'Location record created successfully.',
            'data' => $record
        ], 201);
    }

    public function corregir(Request $request)
    {
        $request->validate([
            'empleado' => 'required|exists:users,id',
            'dia' => 'required|date',
        ]);

        $empleadoId = $request->empleado;
        $dia = $request->dia;

        $empleado = User::findOrFail($empleadoId);

        // Buscar registros de asistencia de ese día
        $asistencias = LocationRecord::where('name', $empleado->name)
            ->whereDate('recorded_at', $dia)
            ->get();

        // Lógica de corrección: aquí podrías agregar entradas/salidas faltantes
        // Ejemplo simple: si falta entrada, crear registro a las 08:00
        if ($asistencias->count() < 2) {
            if (!$asistencias->where('recorded_at', '<=', $dia.' 12:00:00')->first()) {
                LocationRecord::create([
                    'name' => $empleado->name,
                    'latitude' => 0,  // por defecto
                    'longitude' => 0, // por defecto
                    'recorded_at' => Carbon::parse($dia.' 08:00:00'),
                ]);
            }

            if (!$asistencias->where('recorded_at', '>=', $dia.' 12:00:00')->first()) {
                LocationRecord::create([
                    'name' => $empleado->name,
                    'latitude' => 0,
                    'longitude' => 0,
                    'recorded_at' => Carbon::parse($dia.' 17:00:00'),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Asistencia corregida correctamente.');
    }
}
