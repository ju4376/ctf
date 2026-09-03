USE public_app;

-- =========================================================
-- TABLE A
-- =========================================================

CREATE TABLE A (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    message VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO A (message)
VALUES ('그동안 고생 많으셨습니다.');


-- =========================================================
-- TABLE B
-- =========================================================

CREATE TABLE B (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    message VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO B (message)
VALUES ('취약점을 찾고');


-- =========================================================
-- TABLE C
-- =========================================================

CREATE TABLE C (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    message VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO C (message)
VALUES ('원인을 이해하고');


-- =========================================================
-- TABLE D
-- =========================================================

CREATE TABLE D (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    message VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO D (message)
VALUES ('끝까지 추적하는 것이 보안의 시작입니다.');


-- =========================================================
-- TABLE E
-- 다음 단계로 진행하기 위한 관리자 페이지 정보
-- =========================================================

CREATE TABLE E (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL,
    value VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO E (category, value)
VALUES ('admin_path', '/goodjob/secret-admin-page');


-- =========================================================
-- TABLE F
-- =========================================================

CREATE TABLE F (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    message VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO F (message)
VALUES ('여러분의 미래를 응원합니다.');


-- =========================================================
-- Public Web DB 계정 권한 제한
-- SQL Injection 성공 시 조회만 가능하도록 SELECT만 허용
-- =========================================================

REVOKE ALL PRIVILEGES, GRANT OPTION
FROM 'public_app_user'@'%';

GRANT SELECT
ON public_app.*
TO 'public_app_user'@'%';

FLUSH PRIVILEGES;
