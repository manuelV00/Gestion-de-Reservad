<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SIRESE - Reservas</title>
    <link rel="stylesheet" href="/css/estilos.css">
</head>
<body>
<header>
    <h1>SIRESE - Sistema de Reservas</h1>
    <nav>
        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="/?route=reserva_crear">Crear reserva</a>
            <a href="/?route=reserva_lista">Ver reservas</a>
            <a href="/?route=logout">Cerrar sesión</a>
        <?php else: ?>
            <a href="/?route=login">Ingresar</a>
            <a href="/?route=register">Registrarse</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <?php if (!empty($_SESSION['mensaje'])): ?>
        <div class="alert success"><?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert error"><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php echo $content ?? ''; ?>
</main>

<script src="/js/lazy.js"></script>
</body>
</html>
