<?php
require_once('config.php');
require_once('vendor/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

$sonsumer_key = "jniNzn5q8fh78FNBxm9rKjLDa";
$consumer_secret = "ZOzz3DG2kuVyqILN4UB6OtfTJHTGRHuLfmDHChLtmLW6ufb2Vs";

$connection = new TwitterOAuth($sonsumer_key, $consumer_secret, $_SESSION['twitter_access_token']['oauth_token'], $_SESSION['twitter_access_token']['oauth_token_secret']);

$params = array(
	'include_email' => 'true',
	'include_entities' => 'false',
	'skip_status' => 'true'
);

$user = $connection->get("account/verify_credentials",$params);

?>

<p>Name: <?php echo $user->name ?></p>
<p>Screen Name: <?php echo $user->screen_name ?></p>
<p>Email: <?php echo $user->email ?></p>
<img src="<?php echo $user->profile_image_url ?>" width="100px">
<br>
<a href="logout.php">Log Out</a>
