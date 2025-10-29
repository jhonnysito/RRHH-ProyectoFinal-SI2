<?php

// app/Http/Middleware/ApplyTenantStyles.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Models\TenantCustomization;
use Illuminate\Support\Facades\Storage;

class ApplyTenantStyles
{
    public function handle($request, Closure $next)
    {
        $customization = TenantCustomization::where('tenant_id', tenant('id'))->first();

        if ($customization) {
            $primaryColor = $customization->primary_color ?? '#FFFFFF';
            $secondaryColor = $customization->secondary_color ?? '#FFFFFF';
            $fontFamily = $customization->font_family ?? 'sans-serif';
            $logoUrl = $customization->logo ? Storage::disk('tenant')->url($customization->logo) : null;

            $dynamicCss = "
                :root {
                    --primary-color: {$primaryColor};
                    --secondary-color: {$secondaryColor};
                    --font-family: {$fontFamily};
                }
            ";

            View::share('primaryColor', $primaryColor);
            View::share('secondaryColor', $secondaryColor);
            View::share('fontFamily', $fontFamily);
            View::share('logoUrl', $logoUrl);
            View::share('dynamicCss', $dynamicCss);
        }

        return $next($request);
    }
}