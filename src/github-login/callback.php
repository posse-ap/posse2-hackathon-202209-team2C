<?php
session_start();
$code = $_GET['code'];
if ($code == "") {
  header('Location:http://localhost/mailtest.php');
  exit;
}
$CLIENT_ID = 'b7285b4dac56187b2376';
$CLIENT_SECRET = '88f106d2ec894e4b7cbe3bb280dc1d39d7f176bb';
$URL = 'https://github.com/login/oauth/accesstoken';

$postParams = [
  'client_id' => $CLIENT_ID,
  'client_secret' => $CLIENT_SECRET,
  'code' => $code
];


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
$response = curl_exec($ch);
curl_close($ch);

$data = json_encode($response);

// var_dump($data);

// token保持
if ($data !== "") {
  $_SESSION['my_access_token_accessToken'] = $data;
  header('Location:http://localhost/remind-slack.php');
  exit;
}
echo 'ERROR';
