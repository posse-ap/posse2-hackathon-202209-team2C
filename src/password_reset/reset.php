<?php
session_start();

$request = filter_input_array(INPUT_POST);

// csrf tokenが正しければOK
if (
    empty($request['_csrf_token'])
    || empty($_SESSION['_csrf_token'])
    || $request['_csrf_token'] !== $_SESSION['_csrf_token']
) {
    exit('不正なリクエストです');
}

// 本来はここでパスワードのバリデーションをする

// pdoオブジェクトを取得
require_once '../dbconnect.php';

// tokenに合致するユーザーを取得
$sql = 'SELECT * FROM `password_resets` WHERE `token` = :token';
$stmt = $db->prepare($sql);
$stmt->bindValue(':token', $request['password_reset_token'], \PDO::PARAM_STR);
$stmt->execute();
$passwordResetuser = $stmt->fetch(\PDO::FETCH_OBJ);

// どのレコードにも合致しない無効なtokenであれば、処理を中断
if (!$passwordResetuser) exit('無効なURLです');

// テーブルに保存するパスワードをハッシュ化
$hashedPassword = password_hash($request['password'], PASSWORD_DEFAULT);

// usersテーブルとpassword_resetsテーブルの原子性を原始性を保証するため、トランザクションを設置
try {
    $db->beginTransaction();

    // 該当ユーザーのパスワードを更新
    $sql = 'UPDATE `users` SET `password` = :password WHERE `email` = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':password', $hashedPassword, \PDO::PARAM_STR);
    $stmt->bindValue(':email', $passwordResetuser->email, \PDO::PARAM_STR);
    $stmt->execute();

    // 用が済んだので、パスワードリセットテーブルから削除
    $sql = 'DELETE FROM `password_resets` WHERE `email` = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $passwordResetuser->email, \PDO::PARAM_STR);
    $stmt->execute();

    $db->commit();
} catch (\Exception $e) {
    $db->rollBack();

    exit($e->getMessage());
}

echo 'パスワードの変更が完了しました。';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="/src/auth/login/index.php"></a>
</body>

</html>