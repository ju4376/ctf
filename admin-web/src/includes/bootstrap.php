<?php

declare(strict_types=1);

ini_set('session.use_strict_mode', '1');

session_name('ADMIN_LAB_SESSION');

session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure'   => false
]);

session_start();


function getAdminPDO(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dbHost = getenv('DB_HOST');
    $dbName = getenv('DB_NAME');
    $dbUser = getenv('DB_USER');
    $dbPass = getenv('DB_PASSWORD');

    $pdo = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ]
    );

    return $pdo;
}


function requireAdminLogin(): void
{
    if (
        !isset($_SESSION['admin_authenticated']) ||
        $_SESSION['admin_authenticated'] !== true
    ) {
        header(
            'Location: /goodjob/secret-admin-page/'
        );
        exit;
    }
}
