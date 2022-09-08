<?php
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');

$user_id = $_POST['userId'];
$event_id = $_POST['eventId'];


$stmt = $db->prepare('UPDATE event_attendance SET status_id =2 WHERE user_id=:user_id AND event_id=:event_id');
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_STR);
$stmt->execute();
