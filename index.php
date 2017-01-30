<?php
session_start();
require_once('vendor/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

$fb = new Facebook\Facebook([
  'app_id' => '760909530727084', // Replace {app-id} with your app id
  'app_secret' => '07869039a09ce0b4214092e1689d13f1',
  'default_graph_version' => 'v2.2',
  'persistent_data_handler'=>'session'
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$fb_loginUrl = $helper->getLoginUrl('http://localhost/facebook-login/endpoint.php', $permissions);

//++++++++++++++++++++++++++++ Google Script ++++++++++++++++++++++++++++++++++=

$client = new Google_Client();
$client->setClientId('888194408667-o8adrft7ktb2635ehcsahofhdhg8brem.apps.googleusercontent.com');
$client->setClientSecret('pJ_MA7k2B_-H3VzSaiCZwyKP');
$client->setRedirectUri('http://localhost/facebook-login/google.php');
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);


//+++++++++++++++++++++++++++++ Twitter +++++++++++++++++++++++++++++++++++++++++

$sonsumer_key = "jniNzn5q8fh78FNBxm9rKjLDa";
$consumer_secret = "ZOzz3DG2kuVyqILN4UB6OtfTJHTGRHuLfmDHChLtmLW6ufb2Vs";
$auth_callback = "http://localhost/facebook-login/twitter_endpoint.php";

$connection = new TwitterOAuth($sonsumer_key, $consumer_secret);
$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => $auth_callback));

$_SESSION['twitter_oauth_token'] = $request_token['oauth_token'];
$_SESSION['twitter_oauth_token_secret'] = $request_token['oauth_token_secret'];

$twitter_url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

?>
<!DOCTYPE html>
<html>
<head>
	<title>Social Signup Demo</title>
</head>
<body>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap-theme.min.css">
<script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/main.css">

<div class="container">
    

    <div class="omb_login">
    	<h3 class="omb_authTitle">Login or <a href="#">Sign up</a></h3>
		<div class="row omb_row-sm-offset-3 omb_socialButtons">
    	    <div class="col-xs-4 col-sm-2">
		        <a href="<?php echo !isset($_SESSION['fb_access_token'])?htmlspecialchars($fb_loginUrl): 'show-profile.php' ?>" class="btn btn-lg btn-block omb_btn-facebook">
			        <i class="fa fa-facebook"></i>
			        <span class="hidden-xs">Facebook</span>
		        </a>
	        </div>
        	<div class="col-xs-4 col-sm-2">
		        <a href="<?php echo !isset($_SESSION['twitter_access_token'])? $twitter_url : 'twitter_profile.php' ?>" class="btn btn-lg btn-block omb_btn-twitter">
			        <i class="fa fa-twitter"></i>
			        <span class="hidden-xs">Twitter</span>
		        </a>
	        </div>	
        	<div class="col-xs-4 col-sm-2">
		        <a href="<?php echo $client->createAuthUrl() ?>" class="btn btn-lg btn-block omb_btn-google">
			        <i class="fa fa-google-plus"></i>
			        <span class="hidden-xs">Google+</span>
		        </a>
	        </div>	
		</div>

		<div class="row omb_row-sm-offset-3 omb_loginOr">
			<div class="col-xs-12 col-sm-6">
				<hr class="omb_hrOr">
				<span class="omb_spanOr">or</span>
			</div>
		</div>

		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-6">	
			    <form class="omb_loginForm" action="" autocomplete="off" method="POST">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" name="username" placeholder="email address">
					</div>
					<span class="help-block"></span>
										
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input  type="password" class="form-control" name="password" placeholder="Password">
					</div>
                    <!-- <span class="help-block">Password error</span> -->

					<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
				</form>
			</div>
    	</div>
		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-3">
				<label class="checkbox">
					<input type="checkbox" value="remember-me">Remember Me
				</label>
			</div>
			<div class="col-xs-12 col-sm-3">
				<p class="omb_forgotPwd">
					<a href="#">Forgot password?</a>
				</p>
			</div>
		</div>	    	
	</div>



        </div>
</body>
</html>