<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

// Usamos el nombre de tu archivo: ReporteDinamicoExport
class ReporteDinamicoExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $datos;
    protected $titulos;

    /**
    * @param Collection $datos Los datos del reporte.
    * @param array $titulos Los nombres de las columnas.
    */
    public function __construct(Collection $datos, array $titulos)
    {
        $this->datos = $datos;
        $this->titulos = $titulos;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Retornamos los datos que pasamos desde el controlador
        return $this->datos;
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        // Retornamos los títulos de las columnas
        return $this->titulos;
    }
}
