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
                    <a href="../index.php" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">ユーザー画面へ</a>
                <?php endif; ?>
                <a href="/auth/logout.php" class="">ログアウト</a>
            </div>
        </div>
    </header>

    <main class="bg-gray-100 h-screen">
        <div class="w-full mx-auto py-10 px-5">
            <?php
            $stmt = $db->prepare('select id, name, message, start_at, end_at from events  order by start_at asc');
            $stmt->execute();

            $events = $stmt->fetchAll();
            foreach ($events as $event) : ?>
                <?php
                $start_date = strtotime($event['start_at']);
                $end_date = strtotime($event['end_at']);
                ?>
                <div class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-<?php echo $event['id']; ?>">
                    <div>
                        <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
                        <p><?php echo h($event['start_at']); ?> ~ <?php echo h($event['end_at']); ?></p>
                        <?php if ($event['message']) : ?>
                            <div><?php echo ($event['message']); ?></div>
                        <?php endif; ?>
                        <p class="text-xs text-gray-600">
                            [<a href="event-edit.php?id=<?php echo h($event['id']); ?>" style="color: #F33;">編集</a>]
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>