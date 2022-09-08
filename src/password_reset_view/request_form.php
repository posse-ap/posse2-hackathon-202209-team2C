<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="../password_reset/request.php" method="POST">
        <p>パスワードリセット</p>
        <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
        <label>
            メールアドレスを入力してください。リセット用URLをお送りします。
            <input type="email" name="email" value="">
        </label>
        <button type="submit">登録</button>
    </form>
</body>

</html>