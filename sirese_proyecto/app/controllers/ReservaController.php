<?php
require_once __DIR__ . '/../config/config.php';

class ReservaController {
    public function showCrear() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /?route=login');
            exit;
        }

        $stmt = db()->query("SELECT * FROM tipos_evento ORDER BY nombre");
        $tipos_evento = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = db()->query("SELECT * FROM platos WHERE tipo IN ('RESTAURANTE','AMBOS') ORDER BY nombre");
        $platos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $isAdmin = ($_SESSION['user_rol'] == 1 || $_SESSION['user_rol'] == 2);
        $clientes = [];
        if ($isAdmin) {
            $stmt = db()->query("SELECT id, nombre_completo FROM usuarios WHERE rol_id = 3 ORDER BY nombre_completo");
            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        include __DIR__ . '/../views/reservas/crear.php';
    }

    public function guardar() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /?route=login');
            exit;
        }

        if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
            $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Token CSRF inválido.');
        }

        $tipo_reserva = $_POST['tipo_reserva'] ?? '';
        $cliente_id = (int)($_POST['cliente_id'] ?? 0);
        $tipo_evento_id = !empty($_POST['tipo_evento_id']) ? (int)$_POST['tipo_evento_id'] : null;
        $plato_id = !empty($_POST['plato_id']) ? (int)$_POST['plato_id'] : null;
        $termino_churrasco = !empty($_POST['termino_churrasco']) ? $_POST['termino_churrasco'] : null;
        $fecha = $_POST['fecha'] ?? '';
        $hora = $_POST['hora'] ?? '';
        $numero_personas = (int)($_POST['numero_personas'] ?? 0);
        $especificaciones = $_POST['especificaciones_cliente'] ?? '';

        $creado_por_id = (int)$_SESSION['user_id'];

        $date = new DateTime($fecha);
        $dayOfWeek = (int)$date->format('N');

        if ($tipo_reserva === 'RESTAURANTE') {
            $esFinSemana = ($dayOfWeek === 6 || $dayOfWeek === 7);

            $stmt = db()->prepare("SELECT COUNT(*) FROM dias_festivos WHERE fecha = :f");
            $stmt->execute([':f' => $fecha]);
            $esFestivo = $stmt->fetchColumn() > 0;

            if (!$esFinSemana && !$esFestivo) {
                $_SESSION['error'] = 'Las reservas de restaurante solo se permiten sábados, domingos y festivos.';
                header('Location: /?route=reserva_crear');
                exit;
            }
        }

        if ($tipo_reserva === 'EVENTO' && !$tipo_evento_id) {
            $_SESSION['error'] = 'Debe seleccionar el tipo de evento.';
            header('Location: /?route=reserva_crear');
            exit;
        }

        $sql = "INSERT INTO reservas
            (tipo_reserva, cliente_id, creado_por_id, tipo_evento_id, plato_id,
             termino_churrasco, fecha, hora, numero_personas, especificaciones_cliente)
            VALUES
            (:tr, :cid, :cpid, :teid, :pid, :tc, :fe, :ho, :np, :esp)";

        $stmt = db()->prepare($sql);
        $stmt->execute([
            ':tr'  => $tipo_reserva,
            ':cid' => $cliente_id ?: $creado_por_id,
            ':cpid'=> $creado_por_id,
            ':teid'=> $tipo_evento_id,
            ':pid' => $plato_id,
            ':tc'  => $termino_churrasco,
            ':fe'  => $fecha,
            ':ho'  => $hora,
            ':np'  => $numero_personas,
            ':esp' => $especificaciones
        ]);

        $_SESSION['mensaje'] = 'Reserva creada correctamente.';
        header('Location: /?route=reserva_lista');
        exit;
    }

    public function lista() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /?route=login');
            exit;
        }

        $stmt = db()->prepare("SELECT r.*, u.nombre_completo AS cliente_nombre
                               FROM reservas r
                               JOIN usuarios u ON u.id = r.cliente_id
                               ORDER BY r.fecha DESC, r.hora DESC");
        $stmt->execute();
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/reservas/lista.php';
    }

    public function listaParcial() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo 'No autorizado';
            return;
        }

        $stmt = db()->prepare("SELECT r.*, u.nombre_completo AS cliente_nombre
                               FROM reservas r
                               JOIN usuarios u ON u.id = r.cliente_id
                               ORDER BY r.fecha DESC, r.hora DESC");
        $stmt->execute();
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/reservas/tabla_parcial.php';
    }
}
