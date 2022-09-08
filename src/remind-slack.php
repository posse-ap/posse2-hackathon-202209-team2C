<?php
require('dbconnect.php');

// ユーザー全部取ってくる
$stmt = $db->prepare(
    'SELECT events.id AS event_id, events.name AS event_name,users.slack_id, users.name AS user_name, users.email,events.message, events.start_at 
    FROM event_attendance LEFT OUTER JOIN events ON event_attendance.event_id = events.id 
    RIGHT OUTER JOIN users ON event_attendance.user_id = users.id 
    WHERE start_at < now() + interval 24 hour and start_at > now() and status_id = 1'
);
$stmt->execute();
$users = $stmt->fetchAll();

foreach ($users as $user) :
    // 実際の値は$set[0];$set[1];
    $set[$user['event_id']]['event_name'] = $user['event_name'];
    $set[$user['event_id']]['message'] = $user['message'];
    $set[$user['event_id']]['start_at'] = $user['start_at'];
    $set[$user['event_id']]['participants'][] = $user['slack_id'];
endforeach;

// echo '<pre>';
// var_dump($set);
// echo '</pre>';

foreach ($set as $s) :
    $invite_events = '';
    foreach ($s['participants'] as $p) :
        $invite_events .= "・<@" . $p . "> \n  ";
    endforeach;
    $text = "明日のイベントのリマインド \n イベント名:" . $s['event_name'] . "\n 開催日時:" . $s['start_at'] . "\n 詳細:" . $s['message'] .  "\n 参加者: \n" . $invite_events;

    $url = "https://hooks.slack.com/services/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";
    $message = [
        "channel" => "#slackbot-posse2-hackathon-202209-team2c",
        "text" => $text
    ];

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
endforeach;
echo "メールを送信しました";


// $url = "https://hooks.slack.com/services/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";
// $message = [
//   "channel" => "#slackbot-posse2-hackathon-202209-team2c",
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