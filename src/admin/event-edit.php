<?php
session_start();
require('../dbconnect.php');

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: /auth/logout.php');
    exit();
}
$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$post_id) {
    header('Location: index.php');
    exit();
}

$stmt = $db->prepare('select * from events where id = ?');
$stmt->bindValue(1, $post_id);
$stmt->execute();
$event = $stmt->fetch();
$start_at = new DateTime($event['start_at']);
$end_at = new DateTime($event['end_at']);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $form['message'] = filter_input(INPUT_POST, 'message', FILTER_UNSAFE_RAW);
    $form['start_at'] = filter_input(INPUT_POST, 'start_at', FILTER_SANITIZE_NUMBER_INT);
	$form['end_at'] = filter_input(INPUT_POST, 'end_at', FILTER_SANITIZE_NUMBER_INT);

	$stmt = $db->prepare('update events set name=?, message=?, start_at=?, end_at=? where id=?');
    $stmt->bindValue(1, $form['name']);
    $stmt->bindValue(2, $form['message']);
    $start_at = new DateTime($form['start_at']);
    $stmt->bindValue(3, $start_at->format('Y-m-d H:i:s'));
    $end_at = new DateTime($form['end_at']);
	$stmt->bindValue(4, $end_at->format('Y-m-d H:i:s'));
    $stmt->bindValue(5, $post_id, PDO::PARAM_INT);
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
                    <a href="../index.php" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">ユーザー画面へ</a>
                <?php endif; ?>
                <a href="/auth/logout.php" class="">ログアウト</a>
            </div>
        </div>
    </header>


    <main class="bg-gray-100 h-screen">
        <div class="w-full mx-auto py-10 px-5">
            <ul>
                <div class="w-full mx-auto py-10 px-5">
                    <h2 class="text-md font-bold mb-5">イベント編集</h2>
                    <form action="" method="POST">
                        <input type="name" name="name" placeholder="イベント名" class="w-full p-4 text-sm mb-3" value=<?= h($event['name']) ?> required>
                        <input type="datetime-local" name="start_at" placeholder="開始日時" class="w-full p-4 text-sm mb-3"  value=<?= h($start_at->format('Y-m-d\TH:i')) ?> required>
                        <input type="datetime-local" name="end_at" placeholder="終了日時" class="w-full p-4 text-sm mb-3"  value=<?= h($end_at->format('Y-m-d\TH:i')) ?> required>
                        <input type="text" name="message" placeholder="イベント内容" class="w-full p-4 text-sm mb-3"  value=<?= h($event['message']) ?>>
                        <input type="submit" value="編集" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
                    </form>
                </div>
            </ul>
        </div>
    </main>
</body>

</html>