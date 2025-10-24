<?php

// app/Http/Controllers/LocationRecordController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LocationRecord;
use Illuminate\Http\Request;

class LocationRecordController extends Controller
{
    public function index()
    {
        // Ordenamos por el más reciente primero
        $records = LocationRecord::orderBy('recorded_at', 'desc')->paginate(15);

        return view('location_records.index', compact('records'));
    }
}
