<?php
function error($msg)
{
  $response = [];
  $response['success'] = false;
  $response['message'] = $msg;
  return json_encode($response);
}
session_start();
$accessToken = $_SESSION['my_acccess_token_accessToken'];


if ($accessToken == "") {
  die(error('Error:無効なアクセストークンです'));
}

$URL = "'https://github.com/user";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $authHeader));
$response = curl_exec($ch);
curl_close($ch);

$data = json_encode($response);

echo json_encode($data);
