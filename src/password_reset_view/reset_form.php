<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>パスワードリセット</p>
    <form action="../password_reset/reset.php" method="POST">
        <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
        <input type="hidden" name="password_reset_token" value="<?= $passwordResetToken ?>">

        <label>
            新しいパスワード
            <input type="password" name="password">
        </label>
        <br>
        <label>
            パスワード（確認用）
            <input type="password" name="password_confirmation">
        </label>
        <br>

        <button type="submit">送信する</button>
    </form>
</body>

</html>