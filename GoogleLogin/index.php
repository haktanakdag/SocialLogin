<?php
	session_start();
	if(isset($_SESSION['logincust']))
	{
		header('Location: ../index.php');
	}
	else
	{
		session_unset();
	}
?>
<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
	<head>
		<title>Login with Facebook and Google | Login</title>
	</head>
	<body>
        <?php
        include_once 'src/Google_Client.php';
	include_once 'src/contrib/Google_Oauth2Service.php';
	
	// Edit Following 3 Lines
	$clientId = '###'; //Application client ID
	$clientSecret = '###'; //Application client secret
	$redirectURL = '###'; //Application Callback URL
	
	$gClient = new Google_Client();
	$gClient->setApplicationName('Voidev Login');
	$gClient->setClientId($clientId);
	$gClient->setClientSecret($clientSecret);
	$gClient->setRedirectUri($redirectURL);
	$google_oauthV2 = new Google_Oauth2Service($gClient);
        
        if(isset($_GET['code'])){
                $gClient->authenticate($_GET['code']);
                $_SESSION['token'] = $gClient->getAccessToken();
                header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
        }
        if (isset($_SESSION['token'])) {
                $gClient->setAccessToken($_SESSION['token']);
        }
        if ($gClient->getAccessToken()) 
        {
                $gpUserProfile = $google_oauthV2->userinfo->get();
                $_SESSION['oauth_provider'] = 'Google'; 
                $_SESSION['oauth_uid'] = $gpUserProfile['id']; 
                $_SESSION['first_name'] = $gpUserProfile['given_name']; 
                $_SESSION['last_name'] = $gpUserProfile['family_name']; 
                $_SESSION['email'] = $gpUserProfile['email'];
                $_SESSION['gender'] = $gpUserProfile['gender'];
                $_SESSION['logincust']='yes';
        print_r($gpUserProfile);
        } else {
                $authUrl = $gClient->createAuthUrl();
                //echo 'Location: '.filter_var($authUrl, FILTER_SANITIZE_URL);
                header('Location: '.filter_var($authUrl, FILTER_SANITIZE_URL));
                //$output= '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/loging.png" alt="Sign in with Google+" width=222/></a>';
        }
        echo $output;
?>
	</body>
</html>