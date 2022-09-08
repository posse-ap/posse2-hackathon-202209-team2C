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


// 三日後にあるイベントを取得
$stmt = $db->prepare(
    'SELECT name,message,start_at FROM events 
    WHERE  start_at < now() + interval 72 hour and start_at > now() + interval 48 hour;'
);
$stmt->execute();
$events = $stmt->fetchAll();

// echo '<pre>'; 
//     var_dump($events);
// echo '</pre>';

// 全ユーザーを取得
$userstmt = $db->prepare(
    'SELECT name,email FROM users;'
);
$userstmt->execute();
$userlists = $userstmt->fetchAll();



// 配列の生成
// 空の配列準備 エラーの予防
// $set = [];

// foreach ($users as $user) :
//     // 実際の値は$set[0];$set[1];
//     $set[$user['user_id']]['user_name'] = $user['users_name'];
//     $set[$user['user_id']]['email'] = $user['email'];
//     $set[$user['user_id']]['event_tomorrow']['event_id']['event_name'] = $user['event_name'];
//     $set[$user['user_id']]['event_tomorrow']['event_id']['event_detail'] = $user['message'];
// endforeach;

// echo '<pre>'; 
//     var_dump($userlists);
// echo '</pre>';

// ここからメール

mb_language('ja');
mb_internal_encoding('UTF-8');

$invite_events = '';
foreach ($events as $invite_event) :
    $invite_events .= "・" . $invite_event['name'] . " 詳細：".  $invite_event['message'] ."\n  ";
endforeach;

// 人物ごとに送るためにforeach
foreach ($userlists as $user) :

    // foreach ([$user['user_id']]['event_tomorrow'] as $event) :
    //         $s_message .= "・".$user['events_name']."\n  ";

    //         var_dump($event);
    // endforeach;


    $to_array = [$user['email']];
    $to = implode(',', $to_array);
    // $to = $to_array . '';
    $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];
    $subject = "三日後のイベントについて回答をお願いします！";
    $name_array = [$user['name']];
    $name = implode($name_array);
    $date = date('Y-m-d', strtotime('+3 day'));
    $url = "http://localhost";


    $body = <<<EOT
    {$name}さん${date}に
    {$invite_events}
    を開催します。こちらのURLより参加不参加の回答をよろしくお願いします。
    {$url}
    EOT;

    mb_send_mail($to, $subject, $body, $headers);
endforeach;
echo "メールを送信しました";
