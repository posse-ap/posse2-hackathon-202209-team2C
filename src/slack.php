<?php

// mb_language('ja');
// mb_internal_encoding('UTF-8');

// $to = "hackathon-teamX@posse-ap.com";
// $subject = "PHPからメール送信サンプル";
// $body = "本文";
// $headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];

// $name = "テスト";
// $date = "2021年08月01日（日） 21:00~23:00";
// $event = "縦モク";
// $body = <<<EOT
// {$name}さん
// ${date}に${event}を開催します。
// 参加／不参加の回答をお願いします。
// http://localhost/
// EOT;

// mb_send_mail($to, $subject, $body, $headers);
// echo "メールを送信しました";

$headers = [
    'Authorization: Bearer xoxb-1030735452658-2430137901444-RuYFtS6N6zl4uZQSah0CLJ0b', //（1)
    'Content-Type: application/json;charset=utf-8'
];

$url = "https://slack.com/api/chat.postMessage"; //(2)

//(3)
$post_fields = [
    "channel" => "posse2-hackathon-202209-team2c",
    "text" => "初めてのSlack Web APIからのメッセージ",
    "as_user" => true
];

$options = [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($post_fields)
];

$ch = curl_init();

curl_setopt_array($ch, $options);

$result = curl_exec($ch);

curl_close($ch);

echo "メールを送信しました";
