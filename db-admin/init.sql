USE admin_auth;

-- =========================================================
-- Administrator Authentication Table
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


-- =========================================================
-- Challenge Administrator Account
--
-- Username:
-- web-sec-07-admin
--
-- Password:
-- debian12-apache24
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
-- Admin Application DB Account Privileges
-- =========================================================

REVOKE ALL PRIVILEGES, GRANT OPTION
FROM 'admin_app_user'@'%';

GRANT SELECT
ON admin_auth.*
TO 'admin_app_user'@'%';

FLUSH PRIVILEGES;
