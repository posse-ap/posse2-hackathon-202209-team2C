<?php
session_start();

$csrfToken = filter_input(INPUT_POST, '_csrf_token');

// csrf tokenを検証
if (
    empty($csrfToken)
    || empty($_SESSION['_csrf_token'])
    || $csrfToken !== $_SESSION['_csrf_token']
) {
    exit('不正なリクエストです');
}

// 本来はここでemailのバリデーションもかける
$email = filter_input(INPUT_POST, 'email');


require_once '../dbconnect.php';

// emailがusersテーブルに登録済みか確認
$sql = 'SELECT * FROM users WHERE `email` = :email AND `status` = :status';
$stmt = $db->prepare($sql);
$stmt->bindValue(':email', $email, \PDO::PARAM_STR);
$stmt->bindValue(':status', 'public', \PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(\PDO::FETCH_OBJ);

// 未登録のメールアドレスであっても、送信完了画面を表示
// 「未登録です」と表示すると、万が一そのメールアドレスを知っている別人が入力していた場合、「このメールアドレスは未登録である」と情報を与えてしまう
if (!$user) {
    require_once '../password_reset/email_sent.php';
    exit();
}
// 既にパスワードリセットのフロー中（もしくは有効期限切れ）かどうかを確認
// $passwordResetUserが取れればフロー中、取れなければ新規のリクエストということ
$sql = 'SELECT * FROM `password_resets` WHERE `email` = :email';
$stmt = $db->prepare($sql);
$stmt->bindValue(':email', $email, \PDO::PARAM_STR);
$stmt->execute();
$passwordResetUser = $stmt->fetch(\PDO::FETCH_OBJ);

if (!$passwordResetUser) {
    // $passwordResetUserがいなければ、仮登録としてテーブルにインサート
    $sql = 'INSERT INTO `password_resets`(`email`, `token`, `token_sent_at`) VALUES(:email, :token, :token_sent_at)';
} else {
    // 既にフロー中の$passwordResetUserがいる場合、tokenの再発行と有効期限のリセットを行う
    $sql = 'UPDATE `password_resets` SET `token` = :token, `token_sent_at` = :token_sent_at WHERE `email` = :email';
}

// password reset token生成
$passwordResetToken = bin2hex(random_bytes(32));

// password_resetsテーブルへの変更とメール送信は原子性を保ちたいため、トランザクションを設置する
// メール送信に失敗した場合は、パスワードリセット処理自体も失敗させる
try {
    $db->beginTransaction();

    // ユーザーを仮登録
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
    $stmt->bindValue(':token', $passwordResetToken, \PDO::PARAM_STR);
    $stmt->bindValue(':token_sent_at', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
    $stmt->execute();


    // 以下、mail関数でパスワードリセット用メールを送信
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");

    // URLはご自身の環境に合わせてください
    $url = "http://localhost/password_reset/show_reset_form.php?token={$passwordResetToken}";

    $subject =  'パスワードリセット用URLをお送りします';

    $body = <<<EOD
        24時間以内に下記URLへアクセスし、パスワードの変更を完了してください。
        {$url}
        EOD;

    $headers = ['From' => 'テスト<foo@example.jp>', 'Content-Type' => 'text/plain; charset=UTF-8', 'Content-Transfer-Encoding' => '8bit'];

    // mb_send_mailは成功したらtrue、失敗したらfalseを返す
    // $to = "hackathon-teamX@posse-ap.com";
    // $subject = "PHPからメール送信サンプル";
    // $body = "本文";
    // $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];
    $isSent = mb_send_mail($email, $subject, $body, $headers);

    if (!$isSent) throw new \Exception('メール送信に失敗しました。');

    // メール送信まで成功したら、password_resetsテーブルへの変更を確定
    $db->commit();
} catch (\Exception $e) {
    $db->rollBack();

    exit($e->getMessage());
}


// 送信済み画面を表示
require_once '../password_reset_view/email_sent.php';
