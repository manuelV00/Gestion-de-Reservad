<?php
require_once __DIR__ . '/../config/config.php';

class AuthController {
    public function showLogin() {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister() {
        include __DIR__ . '/../views/auth/register.php';
    }

    public function register() {
        session_start();

        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';

        if ($password !== $password2) {
            $_SESSION['error'] = 'Las contraseñas no coinciden.';
            header('Location: /?route=register');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = db()->prepare("INSERT INTO usuarios (nombre_completo, email, telefono, password_hash, rol_id)
                               VALUES (:n, :e, :t, :p, 3)");
        $stmt->execute([
            ':n' => $nombre,
            ':e' => $email,
            ':t' => $telefono,
            ':p' => $hash
        ]);

        $_SESSION['mensaje'] = 'Registro exitoso. Inicia sesión.';
        header('Location: /?route=login');
        exit;
    }

    public function login() {
        session_start();

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        $stmt = db()->prepare("SELECT * FROM usuarios WHERE email = :e");
        $stmt->execute([':e' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['error'] = 'Credenciales inválidas.';
            header('Location: /?route=login');
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nombre'] = $user['nombre_completo'];
        $_SESSION['user_rol'] = $user['rol_id'];

        if ($remember) {
            setcookie('remember_email', $email, time() + 86400 * 30, '/', '', false, true);
        }

        header('Location: /?route=reserva_crear');
        exit;
    }

    public function logout() {
        session_start();
        session_destroy();
        setcookie('remember_email', '', time() - 3600, '/');
        header('Location: /?route=login');
        exit;
    }
}
