<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Número de personas</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservas as $r): ?>
            <tr>
                <td><?php echo (int)$r['id']; ?></td>
                <td><?php echo htmlspecialchars($r['tipo_reserva'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($r['cliente_nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($r['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($r['hora'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo (int)$r['numero_personas']; ?></td>
                <td><?php echo htmlspecialchars($r['estado'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
