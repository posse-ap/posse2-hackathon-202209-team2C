<?php
session_start();
$accessToken = $_SESSION['my_acccess_token_accessToken'];
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
  <p>
    <a href="https://github.com/login/oauth/authorize?client_id=b7285b4dac56187b2376">サインインする</a>
  </p>
  <?php
  if ($accessToken != "") {
    echo 'logged in';
  } else {
    echo ``;
  }
  ?>
</body>

</html>