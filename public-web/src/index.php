<?php

$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASSWORD');

$resultRows = [];
$error = '';
$loginError = '';

try {
    $pdo = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
        ]
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
   

        $sql = "SELECT id, message FROM A WHERE id = '$username' AND message = '$password'";
       
	$stmt = $pdo->query($sql);
        $resultRows = $stmt->fetchAll();

	if (empty($resultRows)) {
	    $loginError = '아이디 또는 비밀번호가 올바르지 않습니다.';
    	}
    }

} catch (PDOException $e) {

    $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Public Web Login</title>

<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    min-height: 100vh;
    background: #101010;
    color: #eeeeee;
    font-family: Arial, sans-serif;

    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    width: 520px;
}

.login-box {
    padding: 35px;
    background: #191919;
    border: 1px solid #333;
    border-radius: 10px;
}

h1 {
    text-align: center;
    margin-top: 0;
}

.subtitle {
    text-align: center;
    color: #888;
    margin-bottom: 30px;
}

label {
    display: block;
    margin-bottom: 7px;
}

input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;

    background: #0e0e0e;
    color: white;

    border: 1px solid #444;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 13px;

    border: 0;
    border-radius: 5px;

    background: #eee;
    color: #111;

    font-weight: bold;
    cursor: pointer;
}

.result {
    margin-top: 20px;
    padding: 20px;

    background: #191919;
    border: 1px solid #333;
    border-radius: 10px;
}

.error {
    color: #ff7777;
    white-space: pre-wrap;
    word-break: break-all;
}

table {
    width: 100%;
    border-collapse: collapse;
}

td, th {
    border: 1px solid #444;
    padding: 8px;
    text-align: left;
}
</style>

</head>

<body>

<div class="container">

<div class="login-box">

    <h1>LOGIN</h1>
    <div class="subtitle">Public Web Authentication</div>

    <form method="POST">

        <label>ID</label>

        <input
            type="text"
            name="username"
            autocomplete="off"
            placeholder="ID"
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Password"
        >

        <button type="submit">
            LOGIN
        </button>

    </form>

</div>


<?php if ($error !== ''): ?>

<div class="result">

    <strong>Database Error</strong>

    <div class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </div>

</div>

<?php endif; ?>


<?php if ($loginError !== ''): ?>

<div class="result">
    <div class="error">
        <?= htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8') ?>
    </div>
</div>

<?php endif; ?>


<?php if (!empty($resultRows)): ?>

<div class="result">

<table>

<thead>
<tr>

<?php foreach (array_keys($resultRows[0]) as $column): ?>

    <th>
        <?= htmlspecialchars($column, ENT_QUOTES, 'UTF-8') ?>
    </th>

<?php endforeach; ?>

</tr>
</thead>


<tbody>

<?php foreach ($resultRows as $row): ?>

<tr>

<?php foreach ($row as $value): ?>

<td>
    <?= htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') ?>
</td>

<?php endforeach; ?>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<?php endif; ?>

</div>

</body>
</html>
