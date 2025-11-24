<?php ob_start(); ?>
<h2>Registro de cliente</h2>

<form method="post" action="/?route=register_post">
    <label>Nombre completo:</label>
    <input type="text" name="nombre" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Teléfono:</label>
    <input type="text" name="telefono">

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <label>Repetir contraseña:</label>
    <input type="password" name="password2" required>

    <button type="submit">Registrarse</button>
</form>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
