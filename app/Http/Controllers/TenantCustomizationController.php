<?php

namespace App\Http\Controllers;

use App\Models\TenantCustomization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantCustomizationController extends Controller
{
    public function edit()
    {
        $customization = TenantCustomization::firstOrCreate(['tenant_id' => tenant('id')]);
        return view('tenant.customization.edit', compact('customization'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'primary_color' => 'nullable|string|size:7',
            'secondary_color' => 'nullable|string|size:7',
            'font_family' => 'nullable|string',
            'custom_css' => 'nullable|string',
        ]);

        $customization = TenantCustomization::firstOrCreate(['tenant_id' => tenant('id')]);

        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if ($customization->logo) {
                Storage::disk('tenant')->delete($customization->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'tenant');
            $customization->logo = $logoPath;
        }

        $customization->primary_color = $request->primary_color;
        $customization->secondary_color = $request->secondary_color;
        $customization->font_family = $request->font_family;
        $customization->custom_css = $request->custom_css;
        $customization->save();

        return redirect()->route('tenant.customization.edit')->with('success', 'Personalización guardada.');
    }
}