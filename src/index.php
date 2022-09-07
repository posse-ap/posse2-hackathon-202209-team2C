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

// $status_id = $_GET['status_id'];

$stmt = $db->query('SELECT events.id, events.name, events.start_at, events.end_at, count(event_attendance.id) AS total_participants FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id GROUP BY events.id');
$events = $stmt->fetchAll();
$today = date("Y/m/d");
// 当日以降のイベントを取得する
$from_now_events =
  $db->prepare(
    'SELECT events.id, events.name, events.start_at, events.end_at, count(event_attendance.id) AS total_participants FROM events LEFT OUTER JOIN event_attendance ON events.id = event_attendance.event_id WHERE start_at > now() GROUP BY events.id ORDER BY start_at ASC'
  );
$from_now_events->execute();
$from_now_events = $from_now_events->fetchAll();


// ユーザーの参加するイベント
$participating_events = $db->prepare(
  'SELECT events.id, events.name, events.start_at, events.end_at, count(event_attendance.id) AS total_participants 
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



// 未回答者一覧
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

// 参加者一覧
$participating_users = $db->prepare(
  'SELECT events.name AS events_name,users.name AS users_name, events.start_at
  FROM event_attendance
  LEFT OUTER JOIN events
  ON event_attendance.event_id = events.id
  RIGHT OUTER JOIN users
  ON event_attendance.user_id = users.id
  WHERE start_at > now()
  AND status_id=1
  ORDER BY events.id
  '
);
$participating_users->execute();
$participating_users = $participating_users->fetchAll();



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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
          <button class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-blue-600 text-white status" type="button" class="button1" value="all" onclick="clicked() "> 全て</button>
          <button class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white status" type="button" class="button1" value="1" onclick="clicked() ">参加</button>

          <button class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white status" type="button" class="button1" value="2" onclick="clicked() "> 不参加
          </button>
          <button class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white status" type="button" class="button1" value="0" onclick="clicked() "> 未回答</button>
        </div>
      </div>

      <div id="events-list">
        <div class="flex justify-between items-center mb-3">
          <h2 class="text-sm font-bold">一覧</h2>
        </div>
        <div id="return">
          <?php foreach ($from_now_events as $event) : ?>
            <?php
            $start_date = strtotime($event['start_at']);
            $end_date = strtotime($event['end_at']);
            $day_of_week = get_day_of_week(date("w", $start_date));
            ?>
            <div class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-<?php echo $event['id']; ?>">
              <div>
                <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
                <p><?php echo date("Y年m月d日（${day_of_week}）", $start_date); ?></p>
                <p class="text-xs text-gray-600">
                  <?php echo date("H:i", $start_date) . "~" . date("H:i", $end_date); ?>
                </p>
              </div>
              <div class="flex flex-col justify-between text-right">
                <div>
                  <?php if ($event['id'] % 3 === 1) : ?>
                    <!--
                  <p class="text-sm font-bold text-yellow-400">未回答</p>
                  <p class="text-xs text-yellow-400">期限 <?php echo date("m月d日", strtotime('-3 day', $end_date)); ?></p>
                  -->
                  <?php elseif ($event['id'] % 3 === 2) : ?>
                    <!-- 
                  <p class="text-sm font-bold text-gray-300">不参加</p>
                  -->
                  <?php else : ?>
                    <!-- 
                  <p class="text-sm font-bold text-green-400">参加</p>
                  -->
                  <?php endif; ?>
                </div>
                <p class="text-sm"><span class="text-xl"><?php echo $event['total_participants']; ?></span>人参加 ></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
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

  <?php
  $from_now_events_json = json_encode($from_now_events);
  $participating_events_json = json_encode($participating_events);
  ?>
  <script>
    function clicked() {
      buttonNum = event.target.value;
    };
    $(function() {
      $(".status").on("click", function(event) {
        let from_now_events_json = <?php echo $from_now_events_json; ?>;
        let participating_events_json = <?php echo $participating_events_json; ?>;
        let status_id_json = buttonNum
        $.ajax({
          type: "POST",
          url: "back.php",
          data: {
            "from_now_events": from_now_events_json,
            "participating_events": participating_events_json,
            "status_id": status_id_json
          },
          dataType: "json"
        }).done(function(data) {
          $("#return").empty();
          $.each(data.events, function(index, element) {
            $("#return").html(
              `<div class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-${element['id']}">
                <div>
                  <h3 class="font-bold text-lg mb-2">${element['name']}</h3>
                </div>
                <div class="flex flex-col justify-between text-right">
                  <div>
                  </div>
                  <p class="text-sm"><span class="text-xl">${element['total_participants']} </span>人参加 ></p>
                </div>
              </div>`
            );

            $(document).on("click", `#event-${element['id']}`, function() {
              const openModalClassList = document.querySelectorAll('.modal-open')
              console.log(openModalClassList)
              const closeModalClassList = document.querySelectorAll('.modal-close')
              const overlay = document.querySelector('.modal-overlay')
              const body = document.querySelector('body')
              const modal = document.querySelector('.modal')
              const modalInnerHTML = document.getElementById('modalInner')

            });
            for (let i = 0; i < openModalClassList.length; i++) {
              openModalClassList[i].addEventListener('click', (e) => {
                e.preventDefault()
                let eventId = parseInt(e.currentTarget.id.replace('event-', ''))
                openModal(eventId)
              }, false)
            }

            for (var i = 0; i < closeModalClassList.length; i++) {
              closeModalClassList[i].addEventListener('click', closeModal)
            }

            overlay.addEventListener('click', closeModal)


            async function openModal(eventId) {
              try {
                const url = '/api/getModalInfo.php?eventId=' + eventId
                const res = await fetch(url)
                const event = await res.json()
                let modalHTML = `
      <h2 class="text-md font-bold mb-3">${event.name}</h2>
      <p class="text-sm">${event.date}（${event.day_of_week}）</p>
      <p class="text-sm">${event.start_at} ~ ${event.end_at}</p>

      <hr class="my-4">

      <p class="text-md">
        ${event.message}
      </p>

      <hr class="my-4">

      <p class="text-sm"><span class="text-xl">${event.total_participants}</span>人参加 ></p>
    `
                switch (0) {
                  case 0:
                    modalHTML += `
          <div class="text-center mt-6">
            <!--
            <p class="text-lg font-bold text-yellow-400">未回答</p>
            <p class="text-xs text-yellow-400">期限 ${event.deadline}</p>
            -->
          </div>
          <div class="flex mt-5">
            <button class="flex-1 bg-blue-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId})">参加する</button>
            <!-- 
            <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold">参加しない</button>
            -->
          </div>
        `
                    break;
                  case 1:
                    modalHTML += `
          <div class="text-center mt-10">
            <p class="text-xl font-bold text-gray-300">不参加</p>
          </div>
        `
                    break;
                  case 2:
                    modalHTML += `
          <div class="text-center mt-10">
            <p class="text-xl font-bold text-green-400">参加</p>
          </div>
        `
                    break;
                }
                modalInnerHTML.insertAdjacentHTML('afterbegin', modalHTML)
              } catch (error) {
                console.log(error)
              }
              toggleModal()
            }

            function closeModal() {
              modalInnerHTML.innerHTML = ''
              toggleModal()
            }

            function toggleModal() {
              modal.classList.toggle('opacity-0')
              modal.classList.toggle('pointer-events-none')
              body.classList.toggle('modal-active')
            }

            async function participateEvent(eventId) {
              try {
                let formData = new FormData();
                formData.append('eventId', eventId)
                const url = '/api/postEventAttendance.php'
                await fetch(url, {
                  method: 'POST',
                  body: formData
                }).then((res) => {
                  if (res.status !== 200) {
                    throw new Error("system error");
                  }
                  return res.text();
                })
                closeModal()
                location.reload()
              } catch (error) {
                console.log(error)
              }
            }
          });
          console.dir(data.events);
        }).fail(function(XMLHttpRequest, status, e) {
          alert(e);
        });
      });

    });
  </script>
  <!-- <script src="./js//main.js"></script> -->

</html>