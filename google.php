<?php
require_once('config.php');
require_once('vendor/autoload.php');

$client = new Google_Client();
$client->setClientId('888194408667-o8adrft7ktb2635ehcsahofhdhg8brem.apps.googleusercontent.com');
$client->setClientSecret('pJ_MA7k2B_-H3VzSaiCZwyKP');
$client->setRedirectUri(BASE_URL.'google.php');
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);


if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var(BASE_URL.'google.php', FILTER_SANITIZE_URL));
  exit;
}

//if we have access_token continue, or else get login URL for user
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);

  $user = $service->userinfo->get();
  
  echo "Name : {$user->name}<br>";
  echo "Gender : {$user->gender}<br>";
  echo "Email : {$user->email}<br>";

  echo "<img src='{$user->picture}' width='100px'><br>";

  echo "<a href='logout.php'>Log Out</a>";
}