<?php
session_start();
require('../../dbconnect.php');

//  ダミーデータ挿入 passwordハッシュ化
// $form = [
//   'email' => 'email@email',
//   'password' => 'pass'
// ];
// $stmt = $db->prepare('insert into users (email, password) VALUES (?, ?)');
// $password = password_hash($form['password'], PASSWORD_DEFAULT);
// $stmt->bindValue(1, $form['email']);
// $stmt->bindValue(2, $password);
// $stmt->execute();

$error = [];
$email = '';
$password = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
  if ($email != '' && $password != '') {
  }
  // ログインチェック
  $stmt = $db->prepare('select id, password from users where email=? limit 1');
  $stmt->bindValue(1, $email);
  $stmt->execute();
  $result = $stmt->fetch();

  if (isset($result['password']) && password_verify($password, $result['password'])) {
    // ログイン成功
    session_regenerate_id();
    $_SESSION['id'] = $result['id'];
    header('Location: ../../index.php');
    exit();
  } else {
    $error['login'] = 'failed';
    // echo '失敗';
  }
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
        <img src="/img/header-logo.png" alt="" class="h-full">
      </div>
    </div>
  </header>

  <main class="bg-gray-100 h-screen">
    <div class="w-full mx-auto py-10 px-5">
      <h2 class="text-md font-bold mb-5">ログイン</h2>
      <form action="" method="POST">
        <input type="email" name="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3" value="<?php echo h($email); ?>" required>
        <input type="password" name="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3" required>
        <?php if (isset($error['login']) && $error['login'] === 'failed') : ?>
          <p class="error">* ログインに失敗しました。正しくご記入ください。</p>
        <?php endif; ?>
        <input type="submit" value="ログイン" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
      <div class="text-center text-xs text-gray-400 mt-6">
        <a class="a_link text-xs" href="../../password_reset/show_request_form.php" class="text-xs">パスワードを忘れた方へ</a>
      </div>

    </div>
    </div>
  </main>
</body>

</html>