<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
  $user_id = $_SESSION['id']; //usersのid
  if ($user_id === 1) {
    $_SESSION['admin'] = true;
  } else {
    $_SESSION['admin'] = false;
  }
} else {
  header('Location: auth/login/index.php');
  exit();
}


// $stmt = $db->query('SELECT events.id, events.name, events.start_at, events.end_at, count(event_attendance.id) AS total_participants FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id GROUP BY events.id');
// $events = $stmt->fetchAll();
$today = date("Y/m/d");

/* 最大ページ数を求める */
$counts = $db->query('SELECT COUNT(*) as cnt FROM events WHERE start_at > now()');
$counts->execute();
$count = $counts->fetch();
$max_page = floor(($count['cnt'] + 1) / 10 + 1);


// 当日以降のイベントを取得する
$from_now_events =
  $db->prepare(
    'SELECT events.id, events.name, events.start_at, events.end_at, events.deadline_at, count(event_attendance.id) AS total_participants FROM events LEFT OUTER JOIN event_attendance ON events.id = event_attendance.event_id WHERE start_at > now() AND event_attendance.user_id=:users_id GROUP BY events.id ORDER BY start_at ASC limit :start, 10'
  );
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
$page = ($page ?: 1);
$start = ($page - 1) *  10;
$from_now_events->bindValue(':start', $start, PDO::PARAM_INT);
$from_now_events->bindValue(':users_id', $user_id, PDO::PARAM_STR);
$from_now_events->execute();
$from_now_events = $from_now_events->fetchAll();
$cnt = count($from_now_events);
// var_dump($cnt);



// ユーザーの参加するイベント
$participating_events = $db->prepare(
  'SELECT events.id, events.name, events.start_at, event_attendance.status_id, events.end_at, events.deadline_at, count(event_attendance.id) AS total_participants 
  FROM events 
  LEFT OUTER JOIN event_attendance 
  ON events.id = event_attendance.event_id 
  WHERE start_at > now() 
  AND event_attendance.user_id=:users_id
  AND event_attendance.status_id=1
  GROUP BY events.id ORDER BY start_at ASC
  '
);
$participating_events->bindValue(':users_id', $user_id, PDO::PARAM_STR);
$participating_events->execute();
$participating_events = $participating_events->fetchAll();


// ユーザーの参加しないイベント
$un_participating_events = $db->prepare(
  'SELECT events.id, events.name, events.start_at, event_attendance.status_id, events.end_at,events.deadline_at, count(event_attendance.id) AS total_participants 
  FROM events 
  LEFT OUTER JOIN event_attendance 
  ON events.id = event_attendance.event_id 
  WHERE start_at > now() 
  AND event_attendance.user_id=:users_id
  AND event_attendance.status_id=2
  GROUP BY events.id ORDER BY start_at ASC
  '
);
$un_participating_events->bindValue(':users_id', $user_id, PDO::PARAM_STR);
$un_participating_events->execute();
$un_participating_events = $un_participating_events->fetchAll();


// ユーザーの未解答のイベント
$unanswered_events = $db->prepare(
  'SELECT events.id, events.name, events.start_at, events.end_at,events.deadline_at, event_attendance.status_id, count(event_attendance.id) AS total_participants 
  FROM events 
  LEFT OUTER JOIN event_attendance 
  ON events.id = event_attendance.event_id 
  WHERE start_at > now() 
  AND event_attendance.user_id=:users_id
  AND event_attendance.status_id=0
  GROUP BY events.id ORDER BY start_at ASC
  '
);
$unanswered_events->bindValue(':users_id', $user_id, PDO::PARAM_STR);
$unanswered_events->execute();
$unanswered_events = $unanswered_events->fetchAll();



$events = [];


if (isset($_POST['participating'])) {
  $events = $participating_events;
  $background_all = 'bg-gray-800';
  $background_participating = 'bg-blue-600';
  $background_unparticipating = 'bg-gray-800';
  $background_unanswerd = 'bg-gray-800';
} elseif (isset($_POST['un_participating'])) {
  $events = $un_participating_events;
  $background_all = 'bg-gray-800';
  $background_participating = 'bg-gray-800';
  $background_unparticipating = 'bg-blue-600';
  $background_unanswerd = 'bg-gray-800';
} elseif (isset($_POST['unanswered'])) {
  $events = $unanswered_events;
  $background_all = 'bg-gray-800';
  $background_participating = 'bg-gray-800';
  $background_unparticipating = 'bg-gray-800';
  $background_unanswerd = 'bg-blue-600';
} else {
  $events = $from_now_events;
  $background_all = 'bg-blue-600';
  $background_participating = 'bg-gray-800';
  $background_unparticipating = 'bg-gray-800';
  $background_unanswerd = 'bg-gray-800';
}
// 未回答者
$unanswered_users = $db->prepare(
  'SELECT events.name AS events_name,users.name AS users_name, events.start_at
  FROM event_attendance
  LEFT OUTER JOIN events
  ON event_attendance.event_id = events.id
  RIGHT OUTER JOIN users
  ON event_attendance.user_id = users.id
  WHERE start_at > now()
  AND status_id=0
  ORDER BY events.id
  '
);
$unanswered_users->execute();
$unanswered_users = $unanswered_users->fetchAll();


function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>Schedule | POSSE</title>
</head>

<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="img/header-logo.png" alt="" class="h-full">
      </div>
      <div>
        <?php if ($_SESSION['admin']) : ?>
          <a href="/admin" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">管理者画面へ</a>
        <?php endif; ?>
        <a href="/auth/logout.php" class="">ログアウト</a>
      </div>
    </div>
  </header>

  <main class="bg-gray-100">
    <div class="w-full mx-auto p-5">

      <div id="filter" class="mb-8">
        <h2 class="text-sm font-bold mb-3">フィルター</h2>
        <div class="flex">
          <form action="index.php" method="post">
            <button class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md text-white <?= $background_all ?>" type="submit" name="all">全て</button>
            <button class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md <?= $background_participating ?> text-white" type="submit" name="participating">参加</button>
            <button class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md <?= $background_unparticipating ?> text-white" type="submit" name="un_participating">不参加</button>
            <button class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md <?= $background_unanswerd ?> text-white" type="submit" name="unanswered">未解答</button>
          </form>
        </div>
      </div>

      <div id="events-list">
        <div class="flex justify-between items-center mb-3">
          <h2 class="text-sm font-bold">一覧</h2>
        </div>

        <?php foreach ($events as $event) : ?>

          <?php
          // 参加人数取得
          $participating_users_number = $db->prepare(
            'SELECT  count(event_attendance.id) AS total_participants 
              FROM event_attendance
              LEFT OUTER JOIN events
              ON event_attendance.event_id = events.id
              WHERE start_at > now()
              AND event_attendance.event_id=?
              AND status_id=1
              ORDER BY events.id
              '
          );
          $participating_users_number->execute(array($event['id']));
          $participating_users_number = $participating_users_number->fetch();

          // 参加する人取得

          $stmt = $db->prepare('SELECT event_attendance.user_id, users.name
            FROM events 
            LEFT JOIN event_attendance ON events.id = event_attendance.event_id 
            Right JOIN users ON event_attendance.user_id=users.id
            WHERE events.id =? AND status_id=1 ');
          $stmt->execute(array($event['id']));
          $participants_name = $stmt->fetchAll();
          ?>
          <?php
          $stmt = $db->prepare('SELECT user_id ,status_id ,events.id FROM events LEFT OUTER JOIN event_attendance ON events.id = event_attendance.event_id WHERE user_id=? AND event_attendance.event_id=?');
          $stmt->execute(array($user_id, $event['id']));
          $status_id = $stmt->fetch();
          ?>
          <?php
          $start_date = strtotime($event['start_at']);
          $end_date = strtotime($event['end_at']);
          $day_of_week = get_day_of_week(date("w", $start_date));
          ?>
          <div class="bg-white mb-3 p-4 flex rounded-md shadow-md">
            <div class="modal-open  cursor-pointer w-11/12" id="event-<?php echo $event['id']; ?>">
              <div>
                <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
                <p><?php echo date("Y年m月d日（${day_of_week}）", $start_date); ?></p>
                <p class="text-xs text-gray-600">
                  <?php echo date("H:i", $start_date) . "~" . date("H:i", $end_date); ?>
                </p>
              </div>
            </div>
            <div>
              <div class="text-center">
                <?php if ($status_id['status_id'] == 0) : ?>
                  <p class="text-sm font-bold text-yellow-400">未回答</p>
                  <p class="text-xs text-yellow-400">期限 <?php echo date("m月d日", strtotime($event['deadline_at'])); ?></p>

                <?php elseif ($status_id['status_id'] == 2) : ?>

                  <p class="text-sm inline-block font-bold text-gray-300">不参加</p>

                <?php else : ?>

                  <p class="text-sm font-bold inline-block text-green-400">参加</p>

                <?php endif; ?>
              </div>
              <div>
                <p class="text-sm w-24 nav-open inline-block cursor-pointer"><span class="text-xl"><?php echo $participating_users_number['total_participants']; ?></span>人参加 </p>
                <nav>
                  <ul class="text-center">
                    <?php
                    foreach ($participants_name as $participant_name) {
                    ?>
                      <li>
                        <?php
                        echo $participant_name['name']
                        ?>
                      </li>
                    <?php
                    }
                    ?>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <p>
        <?php if ($page > 1) : ?>
          <a href="?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?>ページ目へ</a> |
        <?php endif; ?>
        <?php if ($page < $max_page) : ?>
          <a href="?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>ページ目へ</a>
        <?php endif; ?>
      </p>
    </div>
  </main>

  <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-black opacity-80"></div>

    <div class="modal-container absolute bottom-0 bg-white w-screen h-4/5 rounded-t-3xl shadow-lg z-50">
      <div class="modal-content text-left py-6 pl-10 pr-6">
        <div class="z-50 text-right mb-5">
          <svg class="modal-close cursor-pointer inline bg-gray-100 p-1 rounded-full" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
          </svg>
        </div>

        <div id="modalInner"></div>

      </div>
    </div>
  </div>
  <script>
    $(function() {
      //クリックで動く
      $('.nav-open').click(function() {
        $(this).toggleClass('active');
        $(this).next('nav').slideToggle();
      });
    });
  </script>
  <script type="text/javascript">
    let userId = <?php echo $user_id ?>;
  </script>
  <script src="/js/main.js"></script>
</body>

</html>