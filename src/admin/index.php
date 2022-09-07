<?php
session_start();
require('../dbconnect.php');

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: /auth/logout.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Schedule | POSSE</title>
</head>

<body>
    <header class="h-16">
        <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
            <div class="h-full">
                <img src="../img/header-logo.png" alt="" class="h-full">
            </div>
            <div>
                <?php if ($_SESSION['admin']) : ?>
                    <a href="/admin" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">ユーザー画面へ</a>
                <?php endif; ?>
                <a href="/auth/logout.php" class="">ログアウト</a>
            </div>
        </div>
    </header>


    <main class="bg-gray-100 h-screen">
        <div class="w-full mx-auto py-10 px-5">
            <ul>
                <li><a href="user-register.php">・ユーザー登録</a></li>
                <li><a href="event-register.php">・イベント登録</a></li>
            </ul>
        </div>
    </main>
</body>

</html>