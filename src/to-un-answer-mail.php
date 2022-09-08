<?php
require('dbconnect.php');


// 三日後にあるイベント、それに対して未回答な人も取得
$stmt = $db->prepare(
    'SELECT events.id AS event_id,users.id AS user_id,users.name AS users_name,users.email,events.name AS events_name,events.message,events.start_at 
    FROM `event_attendance` INNER JOIN users ON event_attendance.user_id = users.id 
    INNER JOIN events ON event_attendance.event_id = events.id 
    WHERE status_id = 0 AND start_at < now() + interval 72 hour and start_at > now() + interval 48 hour;'
);
$stmt->execute();
$events = $stmt->fetchAll();




// 配列の生成
// 空の配列準備 エラーの予防
$set = [];

foreach ($events as $event) :
    // 実際の値は$set[0];$set[1];
    $set[$event['user_id']]['email'] = $event['email'];
    $set[$event['user_id']]['user_name'] = $event['users_name'];
    $set[$event['user_id']]['events'][$event['event_id']]['event_name'] = $event['events_name'];
    $set[$event['user_id']]['events'][$event['event_id']]['event_detail'] = $event['message'];
    $set[$event['user_id']]['events'][$event['event_id']]['event_time'] = $event['start_at'];
endforeach;




mb_language('ja');
mb_internal_encoding('UTF-8');

// 人物ごとに送るためにforeach
foreach ($set as $event) :
    // 初期化するタイミングは一回ユーザーに送った後でなければならない
    $no_events = '';
    foreach ($event['events'] as $e) :
        $no_events .= "・" . $e['event_name']  . "\n " . "詳細：" .  $e['event_detail'] . " 時間：" . $e['event_time'] . "\n  ";
    endforeach;
    $to_array = [$event['email']];
    $to = implode(',', $to_array);
    $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];
    $subject = "三日後のイベントについて回答をお願いします！";
    $name_array = [$event['user_name']];
    $name = implode($name_array);
    $date = date('Y-m-d', strtotime('+3 day'));
    $url = "http://localhost";


    $body = <<<EOT
    {$event['user_name']}さんに
    {$no_events}
    を開催します。{$event['user_name']}さんはこちらのイベントに未回答となっております。
    こちらのURLより参加不参加の回答をよろしくお願いします。
    {$url}
    EOT;

    mb_send_mail($to, $subject, $body, $headers);
endforeach;
echo "メールを送信しました";
