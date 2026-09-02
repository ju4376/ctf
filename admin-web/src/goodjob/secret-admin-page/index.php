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
    <title>Administrator Login</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 520px;
            margin: 80px auto;
            padding: 20px;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin: 8px 0 16px;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }

        .error {
            color: #b00020;
        }

        .info {
            margin-top: 35px;
            font-size: 14px;
        }
    </style>
</head>

<body>

<h1>Administrator Login</h1>

<p>Authorized administrators only.</p>

<?php if ($error !== ''): ?>

    <p class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>

<?php endif; ?>

<form method="POST">

    <label for="username">Username</label>

    <input
        type="text"
        id="username"
        name="username"
        autocomplete="username"
        required
    >

    <label for="password">Password</label>

    <input
        type="password"
        id="password"
        name="password"
        autocomplete="current-password"
        required
    >

    <button type="submit">
        Login
    </button>

</form>

<!-- TODO: disable diagnostics link before production
<a href="/goodjob/secret-admin-page/system.php">
    System Information
</a>
-->

<!--
<div class="hidden">
    <a href="/goodjob/secret-admin-page/system.php">
        System Information
    </a>
</div>
-->

</body>
</html>
