DROP SCHEMA IF EXISTS posse;

CREATE SCHEMA posse;

USE posse;

DROP TABLE IF EXISTS events;

CREATE TABLE
    events (
        id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
        name VARCHAR(10) NOT NULL,
        start_at DATETIME,
        end_at DATETIME,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at DATETIME
    );

DROP TABLE IF EXISTS event_attendance;

CREATE TABLE
    event_attendance (
        id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
        event_id INT NOT NULL,
        user_id INT,
        status_id INT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at DATETIME
    );

INSERT INTO events
SET
    name = '縦モク',
    start_at = '2021/08/01 21:00',
    end_at = '2021/08/01 23:00';

INSERT INTO events
SET
    name = '横モク',
    start_at = '2021/08/02 21:00',
    end_at = '2021/08/02 23:00';

INSERT INTO events
SET
    name = 'スペモク',
    start_at = '2021/08/03 20:00',
    end_at = '2021/08/03 22:00';

INSERT INTO events
SET
    name = '縦モク',
    start_at = '2021/08/08 21:00',
    end_at = '2021/08/08 23:00';

INSERT INTO events
SET
    name = '横モク',
    start_at = '2021/08/09 21:00',
    end_at = '2021/08/09 23:00';

INSERT INTO events
SET
    name = 'スペモク',
    start_at = '2021/08/10 20:00',
    end_at = '2021/08/10 22:00';

INSERT INTO events
SET
    name = '縦モク',
    start_at = '2021/08/15 21:00',
    end_at = '2021/08/15 23:00';

INSERT INTO events
SET
    name = '横モク',
    start_at = '2021/08/16 21:00',
    end_at = '2021/08/16 23:00';

INSERT INTO events
SET
    name = 'スペモク',
    start_at = '2021/08/17 20:00',
    end_at = '2021/08/17 22:00';

INSERT INTO events
SET
    name = '縦モク',
    start_at = '2021/08/22 21:00',
    end_at = '2021/08/22 23:00';

INSERT INTO events
SET
    name = '横モク',
    start_at = '2021/08/23 21:00',
    end_at = '2021/08/23 23:00';

INSERT INTO events
SET
    name = 'スペモク',
    start_at = '2021/08/24 20:00',
    end_at = '2021/08/24 22:00';

INSERT INTO events
SET
    name = '遊び',
    start_at = '2021/09/22 18:00',
    end_at = '2021/09/22 22:00';

INSERT INTO events
SET
    name = 'ハッカソン',
    start_at = '2021/09/03 10:00',
    end_at = '2021/09/03 22:00';

INSERT INTO events
SET
    name = '遊び',
    start_at = '2021/09/06 18:00',
    end_at = '2021/09/06 22:00';

INSERT INTO events
SET
    name = '縦モク',
    start_at = '2022/09/11 00:00',
    end_at = '2022/09/11 23:00';

INSERT INTO events
SET
    name = 'テストもくもく',
    start_at = '2022/09/12 00:00',
    end_at = '2022/09/12 23:00';

INSERT INTO events
SET
    name = 'テストもくもく',
    start_at = '2022/10/12 00:00',
    end_at = '2022/10/12 23:00';

INSERT INTO events
SET
    name = 'テストもくもく',
    start_at = '2022/11/12 10:00',
    end_at = '2022/11/12 13:00';

INSERT INTO event_attendance SET event_id=1;

INSERT INTO event_attendance SET event_id=1;

INSERT INTO event_attendance SET event_id=1;

INSERT INTO event_attendance SET event_id=2;

INSERT INTO event_attendance SET event_id=2;

INSERT INTO event_attendance SET event_id=3;

-- phpMyAdmin SQL Dump

-- version 5.2.0

-- https://www.phpmyadmin.net/

--

-- ホスト: mysql

-- 生成日時: 2022 年 9 月 06 日 14:51

-- サーバのバージョン： 8.0.29

-- PHP のバージョン: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */

;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */

;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */

;

/*!40101 SET NAMES utf8mb4 */

;

--

-- データベース: `posse`

--

-- --------------------------------------------------------

--

-- テーブルの構造 `users`

--

CREATE TABLE
    `users` (
        `id` int NOT NULL,
        `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8_unicode_ci;

--

-- テーブルのデータのダンプ `users`

--

INSERT INTO
    `users` (
        `id`,
        `email`,
        `password`,
        `created`
    )
VALUES (
        1,
        'email@email',
        'pass',
        '2022-09-06 14:18:11'
    );

--

-- ダンプしたテーブルのインデックス

--

--

-- テーブルのインデックス `users`

--

ALTER TABLE `users` ADD PRIMARY KEY (`id`);

--

-- ダンプしたテーブルの AUTO_INCREMENT

--

--

-- テーブルの AUTO_INCREMENT `users`

--

ALTER TABLE
    `users` MODIFY `id` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */

;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */

;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */

;