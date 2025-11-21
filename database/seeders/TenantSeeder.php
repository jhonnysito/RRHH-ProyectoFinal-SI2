<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::create([
            'id' => 'empresa1',
            'data' => [
                'nombre' => 'Empresa Uno S.A.',
                'plan' => 'premium',
            ],
        ]);

        Domain::create([
            'tenant_id' => $tenant->id,
            'domain' => 'empresa1.test',
        ]);
    }
}
