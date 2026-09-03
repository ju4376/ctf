<?php
$path = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

$path = rtrim($path, '/');

if ($path === '') {
    $path = '/';
}

if ($path === '/') {

    $page = 'login';

} elseif ($path === '/admin') {

    $page = 'admin';

} elseif ($path === '/congrat') {

    $page = 'congrat';

} else {

    http_response_code(404);
    $page = 'not-found';
}

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
<?php if ($page === 'login'): ?>
        <link
            rel="stylesheet"
            href="/login/login.css"
        >

    <?php elseif ($page === 'admin'): ?>

        <link
            rel="stylesheet"
            href="/admin-page/admin.css"
        >

    <?php elseif ($page === 'congrat'): ?>

        <link
            rel="stylesheet"
            href="/congrat/congrat.css"
        >

    <?php endif; ?>

</head>

<body>

    <?php if ($page === 'login'): ?>

        <?php
        require __DIR__ . '/login/login.html';
        ?>

<?php elseif ($page === 'admin'): ?>
        <?php
        require __DIR__ . '/admin-page/admin.html';
        ?>

    <?php elseif ($page === 'congrat'): ?>

        <?php
        require __DIR__ . '/congrat/congrat.html';
        ?>

    <?php endif; ?>

        <?php if ($page === 'login'): ?>

        <script src="/login/login.js"></script>

    <?php elseif ($page === 'admin'): ?>

        <script src="/admin-page/admin.js"></script>

    <?php elseif ($page === 'congrat'): ?>

        <script
            src="/congrat/congrat.js"
        ></script>

    <?php endif; ?>

</body>
</html>
