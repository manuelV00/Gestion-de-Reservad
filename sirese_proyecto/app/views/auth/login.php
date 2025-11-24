<?php ob_start(); ?>
<h2>Iniciar sesión</h2>

<form method="post" action="/?route=login_post">
    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <label>
        <input type="checkbox" name="remember"> Recuérdame
    </label>

    <button type="submit">Ingresar</button>
</form>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
