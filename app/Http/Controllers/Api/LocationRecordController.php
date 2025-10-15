<?php

// app/Http/Controllers/Api/LocationRecordController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}