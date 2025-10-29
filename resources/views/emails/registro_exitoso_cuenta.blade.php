<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bienvenido al sistema</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        {{-- Encabezado SOLO con la imagen --}}
        <tr>
            <td align="center" style="padding:30px 0; background-color:#004aad;">
                <img src="{{ $message->embed(public_path('archivos/logo2.jpg')) }}" alt="Logo" width="150"
                    style="display:block; margin:0 auto;">
            </td>
        </tr>

        {{-- Caja blanca central --}}
        <tr>
            <td align="center" style="padding:40px 15px;">
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff; border-radius:8px; padding:30px;">
                    <tr>
                        <td>
                            <h2 style="color:#333; margin-top:0;">Hola {{ $user->name }}</h2>
                            <p style="font-size:15px; color:#555; line-height:1.5;">
                                ¡Tu cuenta ha sido creada con éxito! Ya puedes ingresar al sistema y comenzar a usar tu
                                espacio.
                            </p>

                            {{-- Datos de acceso --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0;">
                                <tr>
                                    <td style="padding:6px 0; font-size:14px; color:#333;">
                                        <strong>Email de acceso:</strong> {{ $user->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0; font-size:14px; color:#333;">
                                        <strong>Tenant ID:</strong> {{ $user->tenant->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0; font-size:14px; color:#333;">
                                        <strong>Plan:</strong>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:15px; color:#555; margin-top:25px;">
                                ¡Gracias por confiar en nosotros!
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- Footer --}}
        <tr>
            <td align="center" style="padding:20px; font-size:12px; color:#999;">
                © {{ date('Y') }} Tu Empresa — Todos los derechos reservados
            </td>
        </tr>
    </table>
</body>

</html>
