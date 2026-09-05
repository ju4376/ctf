<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';


const BOARD_VISITOR_COOKIE = 'ctf_visitor_id';


/**
 * UUID v4 생성
 */
function createBoardVisitorId(): string
{
    $data = random_bytes(16);

    // UUID version 4
    $data[6] = chr(
        (ord($data[6]) & 0x0f) | 0x40
    );

    // RFC 4122 variant
    $data[8] = chr(
        (ord($data[8]) & 0x3f) | 0x80
    );

    return vsprintf(
        '%s%s-%s-%s-%s-%s%s%s',
        str_split(bin2hex($data), 4)
    );
}


/**
 * UUID v4 형식 검증
 */
function isValidBoardVisitorId(
    string $visitorId
): bool {
    return preg_match(
        '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
        $visitorId
    ) === 1;
}


/**
 * 현재 브라우저 visitor_id 가져오기.
 *
 * 쿠키가 없다면 새 UUID를 생성해서 발급한다.
 */
function getBoardVisitorId(): string
{
    $visitorId =
        $_COOKIE[BOARD_VISITOR_COOKIE] ?? '';

    if (
        is_string($visitorId) &&
        isValidBoardVisitorId($visitorId)
    ) {
        return $visitorId;
    }

    $visitorId = createBoardVisitorId();

    setcookie(
        BOARD_VISITOR_COOKIE,
        $visitorId,
        [
            'expires'  => time() + (60 * 60 * 24 * 30),
            'path'     => '/goodjob/secret-admin-page/',
            'secure'   => false,
            'httponly' => true,
            'samesite' => 'Lax'
        ]
    );

    /*
     * setcookie()는 다음 HTTP 요청부터
     * $_COOKIE에 나타나므로 현재 요청에서도
     * 사용할 수 있도록 직접 넣는다.
     */
    $_COOKIE[BOARD_VISITOR_COOKIE] =
        $visitorId;

    return $visitorId;
}


/**
 * 전체 게시글 조회
 */
function getBoardPosts(): array
{
    $pdo = getAdminPDO();

    $stmt = $pdo->query(
        'SELECT
            id,
            name,
            content,
            created_at,
            updated_at
         FROM board_posts
         ORDER BY id ASC'
    );

    return $stmt->fetchAll();
}


/**
 * 특정 visitor_id의 게시글 조회
 */
function getBoardPostByVisitorId(
    string $visitorId
): ?array {
    $pdo = getAdminPDO();

    $stmt = $pdo->prepare(
        'SELECT
            id,
            name,
            content,
            created_at,
            updated_at
         FROM board_posts
         WHERE visitor_id = :visitor_id
         LIMIT 1'
    );

    $stmt->execute([
        ':visitor_id' => $visitorId
    ]);

    $post = $stmt->fetch();

    return $post ?: null;
}


/**
 * 게시글 저장
 *
 * 최초 작성 → INSERT
 * 기존 visitor_id → UPDATE
 */
function saveBoardPost(
    string $visitorId,
    string $name,
    string $content
): void {
    $pdo = getAdminPDO();

    $stmt = $pdo->prepare(
        'INSERT INTO board_posts (
            visitor_id,
            name,
            content
        )
        VALUES (
            :visitor_id,
            :name,
            :content
        )
        ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            content = VALUES(content)'
    );

    $stmt->execute([
        ':visitor_id' => $visitorId,
        ':name'       => $name,
        ':content'    => $content
    ]);
}


/**
 * 게시판 CSRF 토큰 생성
 */
function getBoardCsrfToken(): string
{
    if (
        !isset($_SESSION['board_csrf_token']) ||
        !is_string($_SESSION['board_csrf_token'])
    ) {
        $_SESSION['board_csrf_token'] =
            bin2hex(random_bytes(32));
    }

    return $_SESSION['board_csrf_token'];
}


/**
 * 게시판 CSRF 토큰 검증
 */
function verifyBoardCsrfToken(
    string $token
): bool {
    $sessionToken =
        $_SESSION['board_csrf_token'] ?? '';

    if (!is_string($sessionToken)) {
        return false;
    }

    return hash_equals(
        $sessionToken,
        $token
    );
}
