<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

if(isset($_SESSION['id'])){
	
	header('Location:profile');
	exit;
	
}

$passkey = 'c2r';

if(isset($_GET['dis'])){
	
	$passkey = $_GET['dis'];
	
}

$passkeyx = strip_tags($passkey);
$passkey = str_replace(' ','',$passkeyx);

if(!preg_match("/^[A-Za-z0-9]+$/", $passkey)) {
		
	$message = 'Something went wrong! Your verification code may have expired. Please check again if you have clicked on the correct link.';
			
}
else{
	
	$match = 0;
	
	if(!file_exists('db/db.php')){
		
		session_destroy();
		
		header('Location:error-db');
		exit;
		
	}
	
	$_SESSION['db'] = 1;
	include('db/db.php');
	$_SESSION['db'] = NULL;
	
	$query = "SELECT id,email,passkey FROM users_temp";
	$result = mysqli_query($dbc,$query);
	$count = mysqli_num_rows($result);
	
	if($count){
		
		while($row = mysqli_fetch_array($result)){
		
			$dbPasskey = $row['passkey'];
			$pieces = explode(" ",$dbPasskey);
			
			if(($pieces[0] == $passkey) || ($pieces[1] == $passkey) || ($pieces[2] == $passkey) || ($pieces[3] == $passkey) || ($pieces[4] == $passkey)){
				
				$rowID = $row['id'];
				$email = $row['email'];
				
				date_default_timezone_set('UTC');
				$date = date("d-m-Y");
				$time = date("H:i:s");
		
				$match = 1;
				
				$query = "INSERT INTO users_final(email,password,date,time) SELECT email,password,timestamp,timestamp FROM users_temp WHERE id='$rowID'";
				$result = mysqli_query($dbcInsert,$query);
				
				$query = "UPDATE users_final SET date='$date',time='$time' WHERE email='$email'";
				$result = mysqli_query($dbcUpdate,$query);
				
				$query = "DELETE FROM users_temp WHERE id='$rowID'";
				$result = mysqli_query($dbcDelete,$query);
				
				$query = "SELECT id FROM info WHERE user_id='$email'";
				$result = mysqli_query($dbc,$query);
				$count = mysqli_num_rows($result);
				
				if($count){
					
					$query = "SELECT id FROM users_final WHERE email='$email'";
					$result = mysqli_query($dbc,$query);
					$row = mysqli_fetch_array($result);
					$userID = $row['id'];
					
					$query = "UPDATE info SET user_id='$userID',publish='1' WHERE user_id='$email'";
					$result = mysqli_query($dbcUpdate,$query);
					
				}
				
				break;
				
			}
			
		}
		
	}
	
	if($match == 0){
		
		$message = 'Something went wrong! Your verification code may have expired. Please check again if you have clicked on the correct link.';
		
	}
	else if($match == 1){
		
		$passkey = md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand()));
		$dbpasskey = $passkey . ' & & & &';
		$timestamp = time();
		
		$query = "SELECT passkey FROM users_forgot_password WHERE email='$email'";
		$result = mysqli_query($dbc,$query);
		$count = mysqli_num_rows($result);
		
		if($count == 1){
			
			$row = mysqli_fetch_array($result);
		
			$passkeyString = $row['passkey'];
			$pieces = explode(" ",$passkeyString);
						
			$dbPasskey = $passkey . ' ' . $pieces[0] . ' ' . $pieces[1] . ' ' . $pieces[2] . ' ' . $pieces[3];
			
			$query = "UPDATE users_forgot_password SET passkey='$dbPasskey',timestamp='$timestamp' WHERE email='$email'";
			$result = mysqli_query($dbcUpdate,$query);
			
		}
		else{
			
			$query = "INSERT INTO users_forgot_password(email,passkey,timestamp) VALUES('$email','$dbpasskey','$timestamp')";
			$result = mysqli_query($dbcInsert,$query);
			
		}
		
		header('Location:complete-recover-password?dis=' . $passkey);
		exit;
		
	}
	
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Complete Registration</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/complete-registration-by-admin.css">
    
    <script src="js/clock.js"></script>
</head>

<body onload="startTime()">
	<div class="topnav">
    	<img id="logo" src="logo/logo.png">
        <div class="topnav-left">
        	<a href="/">Ki Khuji</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/">Home</a>
            <a href="search">Search</a>
            <a href="mark">Advertise</a>
            <a href="profile" class="active">Profile</a>
            <a href="advertisements">Advertisements</a>
        </div>
        
        <div class="topnav-right">
            <a href="login">Log In</a>
            <a href="register">Register</a>
        </div>
    </div>
    
    <table id="lanClockTable">
    	<tr>
        	<td>
    		</td>
            <td>
    			<span id="clock"></span>
    		</td>
    	</tr>
    </table>
    
    <div id="nonFooter">
        <table id="bigLogoTable">
            <tr>
                <td><img id="bigLogo" src="logo/logo.png"></td>
            </tr>
        </table>
        
    <?php
    
    if(isset($message)){
        
        ?>
        <table id="registerTable">
            <tr><td><?php echo $message; ?></td></tr>
            <tr><td>If you want us to send the mail again, try to log in to your account and you will be redirected automatically to the Resend Verification Code page. <a href="login">Click here to go to Log In page</a></td></tr>
            <tr id="backRow"><td><a id="backLink" href="/">Go back to Home</a></td></tr>
        </table>
        <?php
        
    }
    
    ob_end_flush();
    
    ?>
    </div>
	<table id="bottomSpace">
    	<tr><td></td></tr>
    </table>
    
    <table id="bottomContents">
    	<tr><td id="bottomContentsFirst"></td>
        <td id="bottomContentsSecond">Contact us at <span id="helloEmail">hello@kikhuji.com</span></td>
        <td id="bottomContentsLast"></td></tr>
    </table>
</body>

</html>