<?php

declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT']
    . '/includes/bootstrap.php';

require_once $_SERVER['DOCUMENT_ROOT']
    . '/includes/board.php';


requireAdminLogin();


/*
 * =========================================================
 * Visitor
 * =========================================================
 */

$visitorId = getBoardVisitorId();


/*
 * =========================================================
 * Message
 * =========================================================
 */

$boardError = '';
$boardMessage = '';


/*
 * =========================================================
 * POST - 게시글 작성 / 수정
 * =========================================================
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $csrfToken =
        isset($_POST['csrf_token']) &&
        is_string($_POST['csrf_token'])
            ? $_POST['csrf_token']
            : '';

    $name =
        isset($_POST['name']) &&
        is_string($_POST['name'])
            ? trim($_POST['name'])
            : '';

    $content =
        isset($_POST['content']) &&
        is_string($_POST['content'])
            ? trim($_POST['content'])
            : '';


    if (!verifyBoardCsrfToken($csrfToken)) {

        $boardError =
            '잘못된 요청입니다.';

    } elseif ($name === '') {

        $boardError =
            '이름을 입력해주세요.';

    } elseif ($content === '') {

        $boardError =
            '내용을 입력해주세요.';

    } else {

        try {

            saveBoardPost(
                $visitorId,
                $name,
                $content
            );

            /*
             * POST → Redirect → GET
             *
             * 새로고침 시 동일 POST 요청이
             * 다시 실행되는 것을 방지한다.
             */
            $_SESSION['board_message'] =
                '게시글이 저장되었습니다.';

            header(
                'Location: '
                . '/goodjob/secret-admin-page/success.php'
            );

            exit;

        } catch (PDOException $e) {

            $boardError =
                '게시글을 저장할 수 없습니다.';
        }
    }
}


/*
 * =========================================================
 * Flash Message
 * =========================================================
 */

if (
    isset($_SESSION['board_message']) &&
    is_string($_SESSION['board_message'])
) {
    $boardMessage =
        $_SESSION['board_message'];

    unset($_SESSION['board_message']);
}


/*
 * =========================================================
 * success-page Data
 * =========================================================
 */

$myPost =
    getBoardPostByVisitorId($visitorId);

$posts =
    getBoardPosts();

$csrfToken =
    getBoardCsrfToken();


/*
 * =========================================================
 * HTML Escape Helper
 * =========================================================
 */

function h(
    string $value
): string {
    return htmlspecialchars(
        $value,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}


/*
 * =========================================================
 * View
 * =========================================================
 */

require __DIR__ . '/success-page/success.html';
