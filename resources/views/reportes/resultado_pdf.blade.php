<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de {{ $tipoReporte }}</title>
    <!-- Estilos muy básicos para el PDF -->
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 6px;
        }
        th {
            background-color: #f2f2f2;
            font-size: 11px;
            font-weight: bold;
        }
        h1 {
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Reporte de {{ ucfirst($tipoReporte) }}</h1>
    
    <table>
        <thead>
            <tr>
                @foreach ($titulos as $titulo)
                    <th>{{ $titulo }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($datos as $dato)
                <tr>
                    @foreach ($dato->getAttributes() as $valor)
                        <td>{{ $valor }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($titulos) }}" style="text-align: center;">
                        No se encontraron datos para este reporte.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

