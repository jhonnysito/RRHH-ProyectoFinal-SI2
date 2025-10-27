<h2>Hola {{ $entrevista->postulante->nombres }} {{ $entrevista->postulante->apellidos }},</h2>

<p>Se ha programado tu entrevista con los siguientes detalles:</p>

<ul>
    <li><strong>Fecha:</strong> {{ $entrevista->fecha }}</li>
    <li><strong>Hora:</strong> {{ $entrevista->hora }}</li>
    <li><strong>Notas:</strong> {{ $entrevista->notas ?? 'N/A' }}</li>
</ul>

<p>¡Gracias por postular!</p>
