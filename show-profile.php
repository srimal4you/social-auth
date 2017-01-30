<?php
session_start();
require_once('vendor/autoload.php');
$fb = new Facebook\Facebook([
  'app_id' => '760909530727084',
  'app_secret' => '07869039a09ce0b4214092e1689d13f1',
  'default_graph_version' => 'v2.2',
  'persistent_data_handler'=>'session'
  ]);

try {
  	// Returns a `Facebook\FacebookResponse` object
  	$response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
}

$user = $response->getGraphUser();
$id = $user['id'];

echo "<img src='//graph.facebook.com/{$id}/picture'>";
echo "<br>";
echo $user['name'];
echo "<br>";
echo $user['email'];
echo "<br>";
echo "<a href='logout.php'>Log Out</a>";