<?php
session_start();
require('../dbconnect.php');

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: /auth/logout.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $form['start_at'] = filter_input(INPUT_POST, 'start_at', FILTER_SANITIZE_NUMBER_INT);
	$form['end_at'] = filter_input(INPUT_POST, 'end_at', FILTER_SANITIZE_NUMBER_INT);

	$stmt = $db->prepare('insert into events (name, start_at, end_at) VALUES (?, ?, ?)');
    $stmt->bindValue(1, $form['name']);
    $start_at = new DateTime($form['start_at']);
    $stmt->bindValue(2, $start_at->format('Y-m-d H:i:s'));
    $end_at = new DateTime($form['end_at']);
	$stmt->bindValue(3, $end_at->format('Y-m-d H:i:s'));
	$stmt->execute();
	header('Location: index.php');
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
                <div class="w-full mx-auto py-10 px-5">
                    <h2 class="text-md font-bold mb-5">イベント登録</h2>
                    <form action="" method="POST">
                        <input type="name" name="name" placeholder="イベント名" class="w-full p-4 text-sm mb-3" required>
                        <input type="datetime-local" name="start_at" placeholder="開始日時" class="w-full p-4 text-sm mb-3" required>
                        <input type="datetime-local" name="end_at" placeholder="終了日時" class="w-full p-4 text-sm mb-3" required>
                        <input type="submit" value="登録" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
                    </form>
                </div>
            </ul>
        </div>
    </main>
</body>

</html>