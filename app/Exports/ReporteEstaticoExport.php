<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteEstaticoExport implements FromCollection, WithHeadings
{
    protected $datos;
    protected $titulos;

    public function __construct($datos, $titulos)
    {
        $this->datos = $datos;
        $this->titulos = $titulos;
    }

    // Devuelve la colección de datos que se exportará
    public function collection()
    {
        return collect($this->datos);
    }

    // Devuelve los encabezados del Excel
    public function headings(): array
    {
        return $this->titulos;
    }
}
