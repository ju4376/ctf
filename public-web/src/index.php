<?php
$path = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

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

<title>인프라보안 11기 야호</title>
        <link
            rel="stylesheet"
            href="/login/login.css"
/>

</head>

<body>

        <?php
        require __DIR__ . '/login/login.html';
        ?>

        <script src="/login/login.js"></script>

</body>
</html>
