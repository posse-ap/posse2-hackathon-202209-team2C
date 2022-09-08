<?php
require('dbconnect.php');

// 明日あるイベントを取ってくる
// $stmt = $db->prepare('SELECT name ,start_at from events where start_at < now() + interval 24 hour and start_at > now()');
// $stmt->execute();
// $tomorrow_events = $stmt->fetchAll();

// {
//     [0] => {
//         'neme' = '信田';
//         'email' = 'email1@email'
//         'event_tomorrow' = [
//             '縦もく' = '詳細です'
//             'neme' = 'テックもくもく'
//             'neme' = 'テックもくもく'
//             'neme' = 'テックもくもく'
//         ]
//     }
//     [1] => {
//         'neme' = '信田';
//         'email' = 'email1@email'
//         'event_tomorrow' = [
//             'neme' = '縦もく'
//             'neme' = 'テックもくもく'
//             'neme' = 'テックもくもく'
//             'neme' = 'テックもくもく'
//         ]
//     }
// }


// ユーザー全部取ってくる
$stmt = $db->prepare(
    'SELECT events.name AS event_name,users.id AS user_id, users.name AS users_name, users.email,events.message, events.start_at 
    FROM event_attendance LEFT OUTER JOIN events ON event_attendance.event_id = events.id 
    RIGHT OUTER JOIN users ON event_attendance.user_id = users.id 
    WHERE start_at < now() + interval 24 hour and start_at > now() and status_id = 1'
);
$stmt->execute();
$users = $stmt->fetchAll();

// 配列の生成
// 空の配列準備 エラーの予防
$set = [];

foreach ($users as $user) :
    // 実際の値は$set[0];$set[1];
    $set[$user['user_id']]['user_name'] = $user['users_name'];
    $set[$user['user_id']]['email'] = $user['email'];
    $set[$user['user_id']]['event_tomorrow']['event_id']['event_name'] = $user['event_name'];
    $set[$user['user_id']]['event_tomorrow']['event_id']['event_detail'] = $user['message'];
endforeach;

// echo '<pre>'; 
//     var_dump($set);
// echo '</pre>';

// ここからメール

mb_language('ja');
mb_internal_encoding('UTF-8');


// 人物ごとに送るためにforeach
foreach ($set as $s) :

    // foreach ([$user['user_id']]['event_tomorrow'] as $event) :
    //         $s_message .= "・".$user['events_name']."\n  ";

    //         var_dump($event);
    // endforeach;


    $to_array = [$s['email']];
    $to = implode(',', $to_array);
    $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];
    $subject = "明日のイベントのリマインド";
    $name_array = [$s['user_name']];
    $name = implode($name_array);
    $date = date('Y-m-d', strtotime('+1 day'));

    $invite_events = '';
    foreach ($s['event_tomorrow'] as $invite_event) :
        $invite_events .= "・" . $invite_event['event_name'] . " 詳細：" .  $invite_event['event_detail'] . "\n  ";
    endforeach;

    $body = <<<EOT
    {$name}さん${date}に
    {$invite_events}
    を開催します。把握よろしくお願いします。
    EOT;

    mb_send_mail($to, $subject, $body, $headers);
endforeach;
echo "メールを送信しました";
