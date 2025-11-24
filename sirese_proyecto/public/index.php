<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ReservaController.php';

$route = $_GET['route'] ?? 'login';

$authController = new AuthController();
$reservaController = new ReservaController();

switch ($route) {
    case 'login':
        $authController->showLogin();
        break;
    case 'login_post':
        $authController->login();
        break;
    case 'register':
        $authController->showRegister();
        break;
    case 'register_post':
        $authController->register();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'reserva_crear':
        $reservaController->showCrear();
        break;
    case 'reserva_guardar':
        $reservaController->guardar();
        break;
    case 'reserva_lista':
        $reservaController->lista();
        break;
    case 'reserva_lista_parcial':
        $reservaController->listaParcial();
        break;
    default:
        $authController->showLogin();
        break;
}
