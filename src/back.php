<?php
$from_now_events = $_POST['from_now_events'];
$participating_events = $_POST['participating_events'];
$status_id = $_POST['status_id'];
$from_now_events = array("events" => $from_now_events);
$participating_events = array("events" => $participating_events);
header("Content-type: application/json; charset=UTF-8");
if ($status_id == 1) {
  echo json_encode($participating_events);
} else {
  echo json_encode($from_now_events);
}
exit;
