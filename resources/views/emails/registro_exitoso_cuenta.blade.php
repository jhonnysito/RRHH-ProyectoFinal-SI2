<h2>Hola {{ $user->name }}</h2>

<p>¡Bienvenido al sistema! Tu cuenta ha sido creada con éxito.</p>

{{-- Imagen desde public/archivos --}}
<p style="text-align:center; margin:20px 0;">
    <img src="{{ $message->embed(public_path('archivos/logo2.jpg')) }}" alt="Bienvenido" width="300"
        style="max-width:100%; border-radius:8px;">
</p>

<ul>
    <li><strong>Email de acceso:</strong> {{ $user->email }}</li>
    <li><strong>Tenant ID:</strong> {{ $user->tenant->id }}</li>
</ul>

<p>Ya puedes ingresar al sistema y comenzar a usar tu espacio.</p>

<p>¡Gracias por confiar en nosotros!</p>
