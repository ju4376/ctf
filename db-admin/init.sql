USE admin_auth;

-- =========================================================
-- 테이블 분리 
-- =========================================================

CREATE TABLE admin_users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'administrator',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_admin_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE board_posts (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    visitor_id CHAR(36) NOT NULL,
    name VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_board_posts_visitor_id (visitor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- =========================================================
-- 어드민 계정
--
-- Username:
-- the-end-and-the-beginning-admin
--
-- Password:
-- goodluck
--
-- 실제 비밀번호는 DB에 저장하지 않고
-- PHP password_hash() 결과만 저장한다.
-- =========================================================

INSERT INTO admin_users (
    username,
    password_hash,
    role
)
VALUES (
    'the-end-and-the-beginning-admin',
    '$2y$10$U4eu/.lrRtt7rCU5UWGeAO0l70xk2ITTRIfbWktZbeETdOTXludwq',
    'administrator'
);


-- =========================================================
-- 계정 권한
-- =========================================================

REVOKE ALL PRIVILEGES, GRANT OPTION
FROM 'admin_app_user'@'%';

GRANT SELECT
ON admin_auth.admin_users
TO 'admin_app_user'@'%';

GRANT SELECT, INSERT, UPDATE
ON admin_auth.board_posts
TO 'admin_app_user'@'%';

FLUSH PRIVILEGES;
