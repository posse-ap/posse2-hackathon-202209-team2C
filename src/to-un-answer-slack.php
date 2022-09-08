<?php
require('dbconnect.php');


// 三日後にあるイベント、それに対して未回答な人も取得
$stmt = $db->prepare(
    'SELECT events.id AS event_id,users.id AS user_id,users.slack_id,users.email,events.name AS event_name,events.message,events.start_at 
    FROM `event_attendance` INNER JOIN users ON event_attendance.user_id = users.id 
    INNER JOIN events ON event_attendance.event_id = events.id 
    WHERE status_id = 0 AND start_at < now() + interval 72 hour and start_at > now() + interval 48 hour;'
);
$stmt->execute();
$users = $stmt->fetchAll();




// 配列の生成
// 空の配列準備 エラーの予防
$set = [];

foreach ($users as $user) :
    // 実際の値は$set[0];$set[1];
    $set[$user['event_id']]['event_name'] = $user['event_name'];
    $set[$user['event_id']]['message'] = $user['message'];
    $set[$user['event_id']]['start_at'] = $user['start_at'];
    $set[$user['event_id']]['un-answer'][] = $user['slack_id'];
endforeach;

echo '<pre>';
var_dump($set);
echo '</pre>';

$text = "三日後のイベントについて回答をお願いします！ \n";
foreach ($set as $s) :
    $unAnswers = '';
    foreach ($s['un-answer'] as $p) :
        $unAnswers .= "・<@" . $p . "> \n  ";
    endforeach;
    $text .= "イベント名:" . $s['event_name'] . "\n 開催日時:" . $s['start_at'] . "\n 詳細:" . $s['message'] .  "\n 未回答者: \n" . $unAnswers. "\n\n";
endforeach;

    $url = "https://hooks.slack.com/services/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";
    $message = [
        "channel" => "#slackbot-posse2-hackathon-202209-team2c",
        "text" => $text
    ];
// echo $text;

    $ch = curl_init();

    $options = [
        CURLOPT_URL => $url,
        // 返り値を文字列で返す
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        // POST
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'payload' => json_encode($message)
        ])
    ];

    curl_setopt_array($ch, $options);
    curl_exec($ch);
    curl_close($ch);

echo "メールを送信しました";


// $url = "https://hooks.slack.com/services/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";
// $message = [
//     "channel" => "#slackbot-posse2-hackathon-202209-team2c",
//     "text" => "メッセージ内容"
// ];

// $ch = curl_init();

// $options = [
//     CURLOPT_URL => $url,
//     // 返り値を文字列で返す
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_SSL_VERIFYPEER => false,
//     // POST
//     CURLOPT_POST => true,
//     CURLOPT_POSTFIELDS => http_build_query([
//         'payload' => json_encode($message)
//     ])
// ];

// curl_setopt_array($ch, $options);
// curl_exec($ch);
// curl_close($ch);
