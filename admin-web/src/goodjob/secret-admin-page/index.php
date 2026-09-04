<?php

declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {

        $pdo = getAdminPDO();

        $stmt = $pdo->prepare(
            'SELECT id, username, password_hash, role
             FROM admin_users
             WHERE username = :username
             LIMIT 1'
        );

        $stmt->execute([
            ':username' => $username
        ]);

        $admin = $stmt->fetch();

        if (
            $admin &&
            password_verify(
                $password,
                $admin['password_hash']
            )
        ) {

            session_regenerate_id(true);

            $_SESSION['admin_authenticated'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_role'] = $admin['role'];

            header(
                'Location: /goodjob/secret-admin-page/success.php'
            );

            exit;
        }

        $error = 'Invalid username or password.';

    } catch (PDOException $e) {

        $error = 'Authentication service unavailable.';
    }
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>관리자 로그인</title>
    <link rel="stylesheet" href="./admin.css">
</head>

<body>
            <?php
        require __DIR__ . '/../../admin-page/admin.html';;
        ?>

</body>
</html>
