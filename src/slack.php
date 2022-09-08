<?php

$headers = [
    'Authorization: Bearer xoxb-1030735452658-2430137901444-RuYFtS6N6zl4uZQSah0CLJ0b', //（1)
    'Content-Type: application/json;charset=utf-8'
];

$url = "https://slack.com/api/chat.postMessage"; //(2)

//(3)
$post_fields = [
    "channel" => "#posse2-hackathon-202209-team2c",
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

// $url = "https://hooks.slack.com/services/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";
// $message = [
//   "channel" => "#posse2-hackathon-202209-team2c",
//   "text" => "メッセージ内容"
// ];

// $ch = curl_init();

// $options = [
//   CURLOPT_URL => $url,
//   // 返り値を文字列で返す
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_SSL_VERIFYPEER => false,
//   // POST
//   CURLOPT_POST => true,
//   CURLOPT_POSTFIELDS => http_build_query([
//     'payload' => json_encode($message)
//   ])
// ];

// curl_setopt_array($ch, $options);
// curl_exec($ch);
// curl_close($ch);