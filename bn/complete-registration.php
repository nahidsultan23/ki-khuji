<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

if(isset($_SESSION['id'])){
	
	header('Location:profile');
	exit;
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);

$passkey = 'c2r';

if(isset($_GET['dis'])){
	
	$passkey = $_GET['dis'];
	
}

$passkeyx = strip_tags($passkey);
$passkey = str_replace(' ','',$passkeyx);

if(!preg_match("/^[A-Za-z0-9]+$/", $passkey)) {
		
	$message = 'কিছু একটা গড়মিল হয়েছে! আপনার ভেরিফিকেশন কোডের মেয়াদ সম্ভবত শেষ হয়ে গিয়েছে । দয়া করে আরেকবার দেখুন আপনি সঠিক লিঙ্কে ক্লিক করেছেন কিনা ।';
			
}
else{
	
	$match = 0;
	
	if(!file_exists('../db/db.php')){
		
		session_destroy();
		
		header('Location:error-db');
		exit;
		
	}
	
	$_SESSION['db'] = 1;
	include('../db/db.php');
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
				
				break;
				
			}
			
		}
		
	}
	
	if($match == 0){
		
		$message = 'কিছু একটা গড়মিল হয়েছে! আপনার ভেরিফিকেশন কোডের মেয়াদ সম্ভবত শেষ হয়ে গিয়েছে । দয়া করে আরেকবার দেখুন আপনি সঠিক লিঙ্কে ক্লিক করেছেন কিনা ।';
		
	}
	else if($match == 1){
		
		header('Location:login?er=reg-sc');
		exit;
		
	}
	
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>কী খুঁজি - নিবন্ধন সম্পন্ন করুন</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/complete-registration.css">

    <script src="js/clock.js"></script>
</head>

<body onload="startTime()">
	<div class="topnav">
    	<img id="logo" src="../logo/logo.png">
        <div class="topnav-left">
        	<a href="/bn/">কী খুঁজি</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="../bn/">হোম</a>
            <a href="search">অনুসন্ধান</a>
            <a href="mark">প্রচার</a>
            <a href="profile" class="active">প্রোফাইল</a>
            <a href="advertisements">বিজ্ঞাপন</a>
            <button id="lanButton" onClick="location.href='/<?php echo $pathUrl; ?>'">English</button>
        </div>
        
        <div class="topnav-right">
            <a href="login">লগ ইন</a>
            <a href="register">নিবন্ধন</a>
        </div>
    </div>
    
	<table id="clockTable">
    	<tr>
            <td>
    			<span id="clock"></span>
    		</td>
    	</tr>
    </table>
    
    <div id="nonFooter">
        <table id="bigLogoTable">
            <tr>
                <td><img id="bigLogo" src="../logo/logo.png"></td>
            </tr>
        </table>
        
        <?php
        
        if(isset($message)){
            
            ?>
            <table id="registerTable">
                <tr><td><?php echo $message; ?></td></tr>
                <tr><td>যদি আপনি চান আমরা আবার আপনাকে মেইলটি পাঠাই, আপনার একাউন্টে লগ ইন করার চেষ্টা করুন এবং আপনি স্বয়ংক্রিয়ভাবে Resend Verification Code পাতায় চলে যাবেন । <a href="login">Log In পাতায় যেতে ক্লিক করুন</a></td></tr>
                <tr id="backRow"><td><a id="backLink" href="/">হোম এ ফিরে চলুন</a></td></tr>
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
        <td id="bottomContentsSecond">আমাদের ইমেইল ঠিকানা <span id="helloEmail">hello@kikhuji.com</span></td>
        <td id="bottomContentsLast"></td></tr>
    </table>
</body>

</html>