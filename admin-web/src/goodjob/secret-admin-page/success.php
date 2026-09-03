<?php

declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';

requireAdminLogin();

$username = htmlspecialchars(
    $_SESSION['admin_username'] ?? 'administrator',
    ENT_QUOTES,
    'UTF-8'
);

?>
<!DOCTYPE html>
<html lang="ko">
<head>

<meta charset="UTF-8">

<title>Challenge Completed</title>

<style>

body {
    font-family: Arial, sans-serif;
    max-width: 700px;
    margin: 80px auto;
    padding: 20px;
    text-align: center;
}

.flag {
    margin: 40px 0;
    padding: 20px;
    border: 2px solid #222;
    font-family: monospace;
    font-size: 20px;
}

.steps {
    text-align: left;
    margin-top: 40px;
}

</style>

</head>

<body>

<h1>수고많으셨습니다!</h1>

<p>
수료를 진심으로 축하드립니다!!
</p>

<p>
환영합니다,
<strong><?= "11기 이스트캠프 인프라보안 가디언즈" ?></strong>
</p>


<div class="flag">

FLAG{The_End_and_the_Beginning}

</div>


<div class="steps">

<h2>여러분의 모의해킹 진행은 아래와 같습니다!</h2>

<ol>
    <li>SQL Injection Discovery</li>
    <li>Database Enumeration</li>
    <li>Hidden Information Discovery</li>
    <li>Admin Endpoint Discovery</li>
    <li>Server Information Enumeration</li>
    <li>Credential Discovery</li>
    <li>Administrator Authentication</li>
</ol>

</div>


<p>
<a href="/goodjob/secret-admin-page/logout.php">
Logout
</a>
</p>

</body>
</html>
