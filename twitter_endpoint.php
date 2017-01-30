<?php
session_start();
require 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;


$request_token = [];
$request_token['oauth_token'] = $_SESSION['twitter_oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['twitter_oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    die('Tokens mismatched');
}

$sonsumer_key = "jniNzn5q8fh78FNBxm9rKjLDa";
$consumer_secret = "ZOzz3DG2kuVyqILN4UB6OtfTJHTGRHuLfmDHChLtmLW6ufb2Vs";
$auth_callback = "http://localhost/facebook-login/twitter_endpoint.php";

$connection = new TwitterOAuth($sonsumer_key, $consumer_secret, $request_token['oauth_token'], $request_token['oauth_token_secret']);

$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);

$_SESSION['twitter_access_token'] = $access_token;

var_dump($_SESSION);
header("Location:twitter_profile.php");