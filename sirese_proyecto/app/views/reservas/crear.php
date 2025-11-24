<?php ob_start(); ?>
<h2>Nueva reserva</h2>

<form method="post" action="/?route=reserva_guardar">
    <label>Tipo de reserva:</label>
    <select name="tipo_reserva" required>
        <option value="EVENTO">Evento</option>
        <option value="RESTAURANTE">Restaurante</option>
    </select>

    <?php $isAdmin = ($_SESSION['user_rol'] == 1 || $_SESSION['user_rol'] == 2); ?>
    <?php if ($isAdmin): ?>
        <label>Cliente:</label>
        <select name="cliente_id">
            <option value="">(Seleccionar cliente)</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?php echo (int)$c['id']; ?>">
                    <?php echo htmlspecialchars($c['nombre_completo'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
    <?php else: ?>
        <input type="hidden" name="cliente_id" value="<?php echo (int)$_SESSION['user_id']; ?>">
        <p>Cliente: <?php echo htmlspecialchars($_SESSION['user_nombre'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <label>Tipo de evento (solo si es EVENTO):</label>
    <select name="tipo_evento_id">
        <option value="">(Seleccione)</option>
        <?php foreach ($tipos_evento as $te): ?>
            <option value="<?php echo (int)$te['id']; ?>">
                <?php echo htmlspecialchars($te['nombre'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Plato (solo RESTAURANTE):</label>
    <select name="plato_id">
        <option value="">(Seleccione)</option>
        <?php foreach ($platos as $p): ?>
            <option value="<?php echo (int)$p['id']; ?>">
                <?php echo htmlspecialchars($p['nombre'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Término del churrasco (si aplica):</label>
    <select name="termino_churrasco">
        <option value="">(No aplica)</option>
        <option value="3/4">3/4</option>
        <option value="MEDIO">Término medio</option>
        <option value="BIEN ASADO">Bien asado</option>
        <option value="AZUL">Término azul</option>
    </select>

    <label>Fecha:</label>
    <input type="date" name="fecha" required>

    <label>Hora:</label>
    <input type="time" name="hora" required>

    <label>Número de personas:</label>
    <input type="number" name="numero_personas" min="1" required>

    <label>Especificaciones del cliente:</label>
    <textarea name="especificaciones_cliente" rows="4"></textarea>

    <?php
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    ?>
    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">

    <button type="submit">Guardar reserva</button>
</form>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
