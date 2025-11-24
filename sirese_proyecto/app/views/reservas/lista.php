<?php ob_start(); ?>
<h2>Reservas</h2>

<section id="reservas-section">
    <p>Desplázate hacia acá para cargar las reservas...</p>
</section>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
