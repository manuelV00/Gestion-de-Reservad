<?php
define('DB_HOST', 'db');
define('DB_NAME', 'sirese');
define('DB_USER', 'root');
define('DB_PASS', 'rootpassword');

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    return $pdo;
}
