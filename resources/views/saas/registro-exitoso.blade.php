<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Suscripción Exitosa' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }



        header h1 {
            margin: 0;
            font-size: 2.8em;
            font-weight: 300;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #00b894, #00cec9, #0984e3);
        }

        .success-section {
            text-align: center;
            padding: 50px 20px;
            position: relative;
        }

        .success-icon {
            font-size: 5em;
            color: #00b894;
            margin-bottom: 25px;
            animation: bounce 1s ease-in-out;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        .success-section h2 {
            color: #00b894;
            margin-bottom: 25px;
            font-size: 2.2em;
            font-weight: 400;
        }

        .success-section p {
            margin-bottom: 35px;
            font-size: 1.2em;
            color: #636e72;
        }

        .details {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 35px;
            border-left: 6px solid #00b894;
            display: inline-block;
            text-align: left;
            max-width: 500px;
        }

        .details p {
            margin: 12px 0;
            font-size: 1em;
            color: #2d3436;
        }

        .details p strong {
            color: #0984e3;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        button,
        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #0984e3;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0652dd;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #495057;
            transform: translateY(-2px);
        }

        footer {
            background-color: #2d3436;
            color: white;
            text-align: center;
            padding: 25px;
            margin-top: 50px;
        }

        footer p {
            margin: 0;
            font-size: 0.9em;
        }

        .confetti {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2em;
            color: #ffeaa7;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>


    <div class="container">
        <i class="fas fa-confetti confetti"></i>
        <div class="success-section">
            <i class="fas fa-check-circle success-icon"></i>
            <h2>¡Suscripción Exitosa!</h2>
            <p>¡Enhorabuena! Tu suscripción ha sido procesada correctamente. Pronto recibirás un correo electrónico con
                toda la información necesaria para comenzar a disfrutar de nuestros servicios.</p>

            <div class="details">
                <p><strong>Nombre:</strong> {{ $user->name ?? 'Usuario' }}</p>
                <p><strong>Correo:</strong> {{ $user->email ?? 'No disponible' }}</p>
                <p><strong>Fecha de Suscripción:</strong> {{ $subscriptionDate ?? now()->format('d/m/Y') }}</p>
                <p><strong>Plan Seleccionado:</strong> {{ $plan ?? 'Básico' }}</p>
            </div>

            <div class="buttons">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver Atrás</a>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Acceder al Panel</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Todos los derechos reservados.</p>
    </footer>
</body>

</html>
