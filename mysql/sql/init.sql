DROP SCHEMA IF EXISTS posse;

CREATE SCHEMA posse;

USE posse;

DROP TABLE IF EXISTS events;

CREATE TABLE
    events (
        id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
        name VARCHAR(10) NOT NULL,
        message VARCHAR(100) NULL,
        start_at DATETIME,
        end_at DATETIME,
        deadline_at DATETIME,
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
    message = '縦モク詳細',
    start_at = '2021/08/01 21:00',
    end_at = '2021/08/01 23:00';

INSERT INTO events
SET
    name = '横モク',
    message = '横モク詳細',
    start_at = '2021/08/02 21:00',
    end_at = '2021/08/02 23:00';

INSERT INTO events
SET
    name = 'スペモク',
    message = 'スペモク詳細',
    start_at = '2021/08/03 20:00',
    end_at = '2021/08/03 22:00';

INSERT INTO events
SET
    name = '縦モク',
    message = '縦モクもくもくかい',
    start_at = '2021/08/08 21:00',
    end_at = '2021/08/08 23:00';

INSERT INTO events
SET
    name = '横モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/08/09 21:00',
    end_at = '2021/08/09 23:00';

INSERT INTO events
SET
    name = 'スペモク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/08/10 20:00',
    end_at = '2021/08/10 22:00';

INSERT INTO events
SET
    name = '縦モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/08/15 21:00',
    end_at = '2021/08/15 23:00';

INSERT INTO events
SET
    name = '横モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/08/16 21:00',
    end_at = '2021/08/16 23:00';

INSERT INTO events
SET
    name = 'スペモク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/08/17 20:00',
    end_at = '2021/08/17 22:00';

INSERT INTO events
SET
    name = '縦モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/08/22 21:00',
    end_at = '2021/08/22 23:00';

INSERT INTO events
SET
    name = '横モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/08/23 21:00',
    end_at = '2021/08/23 23:00';

INSERT INTO events
SET
    name = 'スペモク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/08/24 20:00',
    end_at = '2021/08/24 22:00';

INSERT INTO events
SET
    name = '遊び',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/09/22 18:00',
    end_at = '2021/09/22 22:00';

INSERT INTO events
SET
    name = 'ハッカソン',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/09/03 10:00',
    end_at = '2021/09/03 22:00';

INSERT INTO events
SET
    name = '遊び',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2021/09/06 18:00',
    end_at = '2021/09/06 22:00';

INSERT INTO events
SET
    name = '縦モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/09/11 00:00',
    end_at = '2022/09/11 23:00',
    deadline_at = '2022/09/10 09:00';

INSERT INTO events
SET
    name = 'テストもくもく',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/09/12 00:00',
    end_at = '2022/09/12 23:00',
    deadline_at = '2022/09/11 09:00';

INSERT INTO events
SET
    name = 'テストもくもく2',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/10/12 00:00',
    end_at = '2022/10/12 23:00',
    deadline_at = '2022/10/11 09:00';

INSERT INTO events
SET
    name = 'テストもくもく3',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/11/12 10:00',
    end_at = '2022/11/12 13:00',
    deadline_at = '2022/11/12 09:00';

INSERT INTO events
SET
    name = '縦モク',
    message = '縦モク詳細',
    start_at = '2022/11/13 21:00',
    end_at = '2022/11/14 23:00',
    deadline_at = '2022/11/12 09:00';


INSERT INTO events
SET
    name = '横モク',
    message = '横モク詳細',
    start_at = '2022/11/14 21:00',
    end_at = '2022/11/15 23:00',
    deadline_at = '2022/11/14 09:00';


INSERT INTO events
SET
    name = 'スペモク',
    message = 'スペモク詳細',
    start_at = '2022/11/15 20:00',
    end_at = '2022/11/15 22:00',
    deadline_at = '2022/11/15 09:00';

INSERT INTO events
SET
    name = '縦モク',
    message = '縦モクもくもくかい',
    start_at = '2022/11/16 21:00',
    end_at = '2022/11/16 23:00',
    deadline_at = '2022/11/16 09:00';

INSERT INTO events
SET
    name = '横モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/11/17 21:00',
    end_at = '2022/11/17 23:00',
    deadline_at = '2022/11/16 09:00';

INSERT INTO events
SET
    name = 'スペモク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/11/18 20:00',
    end_at = '2022/11/18 22:00',
    deadline_at = '2022/11/17 09:00';

INSERT INTO events
SET
    name = '縦モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/11/18 22:30',
    end_at = '2022/11/18 23:00',
    deadline_at = '2022/11/18 09:00';

INSERT INTO events
SET
    name = '横モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/11/19 21:00',
    end_at = '2021/11/19 23:00',
    deadline_at = '2022/11/19 09:00';

INSERT INTO events
SET
    name = 'スペモク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/11/20 20:00',
    end_at = '2022/11/20 22:00',
    deadline_at = '2022/11/19 09:00';

INSERT INTO events
SET
    name = '縦モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/11/21 21:00',
    end_at = '2022/11/22 23:00',
    deadline_at = '2022/12/10 09:00';

INSERT INTO events
SET
    name = '横モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/11/23 21:00',
    end_at = '2022/11/24 23:00',
    deadline_at = '2022/11/10 09:00';

INSERT INTO events
SET
    name = 'スペモク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/11/25 20:00',
    end_at = '2022/11/26 22:00',
    deadline_at = '2022/11/10 09:00';

INSERT INTO events
SET
    name = '遊び',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/11/28 18:00',
    end_at = '2022/11/28 22:00',
    deadline_at = '2022/11/10 09:00';

INSERT INTO events
SET
    name = 'ハッカソン',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/12/03 10:00',
    end_at = '2022/12/03 22:00',
    deadline_at = '2022/11/10 09:00';

INSERT INTO events
SET
    name = '遊び',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/12/20 18:00',
    end_at = '2022/12/20 22:00',
    deadline_at = '2022/11/10 09:00';

INSERT INTO events
SET
    name = '縦モク',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/12/23 00:00',
    end_at = '2022/12/23 23:00',
    deadline_at = '2022/11/10 09:00';

INSERT INTO events
SET
    name = 'テストもくもく',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/12/24 00:00',
    end_at = '2022/12/24 23:00',
    deadline_at = '2022/12/23 09:00';

INSERT INTO events
SET
    name = 'テストもくもく2',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/12/25 00:00',
    end_at = '2022/12/25 23:00',
    deadline_at = '2022/12/24 09:00';

INSERT INTO events
SET
    name = 'テストもくもく3',
    message = 'もくもくかい、開催楽しみにしててね',
    start_at = '2022/12/26 10:00',
    end_at = '2022/12/26 13:00',
    deadline_at = '2022/12/25 09:00';



INSERT INTO event_attendance
SET
    event_id = 16,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 16,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 16,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 16,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 17,
    user_id = 1,
    status_id = 1;

INSERT INTO event_attendance
SET
    event_id = 17,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 17,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 17,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 18,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 18,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 18,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 18,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 19,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 19,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 19,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 19,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 20,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 20,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 20,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 20,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 21,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 21,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 21,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 21,
    user_id = 4,
    status_id = 0;


INSERT INTO event_attendance
SET
    event_id = 22,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 22,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 22,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 22,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 23,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 23,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 23,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 23,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 24,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 24,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 24,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 24,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 25,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 25,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 25,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 25,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 26,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 26,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 26,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 26,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 27,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 27,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 27,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 27,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 28,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 28,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 28,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 28,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 29,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 29,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 29,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 29,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 30,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 30,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 30,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 30,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 31,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 31,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 31,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 31,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 32,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 32,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 32,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 32,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 33,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 33,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 33,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 33,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 34,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 34,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 34,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 34,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 35,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 35,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 35,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 35,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 36,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 36,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 36,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 36,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 37,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 37,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 37,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 37,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 38,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 38,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 38,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 38,
    user_id = 4,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 39,
    user_id = 1,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 39,
    user_id = 2,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 39,
    user_id = 3,
    status_id = 0;

INSERT INTO event_attendance
SET
    event_id = 39,
    user_id = 4,
    status_id = 0;




-- phpMyAdmin SQL Dump

-- version 5.2.0

-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

CREATE TABLE
    users (
        id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        slack_id varchar(100) COLLATE utf8_unicode_ci NULL,
        email varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
        password varchar(100) CHARACTER SET utf8mb3 COLLATE utf8_unicode_ci NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at DATETIME,
        register_token VARCHAR(255),
        register_token_sent_at DATETIME,
        register_token_verified_at DATETIME,
        status ENUM('tentative', 'public') DEFAULT 'tentative'
    )  DEFAULT CHARSET = utf8mb3 COLLATE = utf8_unicode_ci;

INSERT INTO users
SET
    name = '岩村',
    email = 'email1@email',
    slack_id = 'U041F0H9V0V',
    password = '$2y$10$T.op0EUdVRNXuXmfF1Az6e5f5AcCL/WmgPoSo1zUe05WXghRFQxvm',
    created_at = '2022/09/11 23:00',
    status = 'public';

INSERT INTO users
SET
    name = '小谷',
    email = 'email2@email',
    slack_id = 'U041LCR4VB6',
    password = '$2y$10$T.op0EUdVRNXuXmfF1Az6e5f5AcCL/WmgPoSo1zUe05WXghRFQxvm',
    created_at = '2022/09/11 23:00',
    status = 'public';

INSERT INTO users
SET
    name = '信田',
    email = 'email3@email',
    slack_id = 'U0427L687LY',
    password = '$2y$10$T.op0EUdVRNXuXmfF1Az6e5f5AcCL/WmgPoSo1zUe05WXghRFQxvm',
    created_at = '2022/09/11 23:00',
    status = 'tentative';

INSERT INTO users
SET
    name = 'のぶ',
    email = 'email4@email',
    slack_id = 'U041K7B5D6F',
    password = '$2y$10$T.op0EUdVRNXuXmfF1Az6e5f5AcCL/WmgPoSo1zUe05WXghRFQxvm',
    created_at = '2022/09/11 23:00',
    status = 'public';

DROP TABLE IF EXISTS passwords_reset;

CREATE TABLE
    password_resets (
        email varchar(50) PRIMARY KEY,
        token varchar(80) NOT NULL,
        token_sent_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );