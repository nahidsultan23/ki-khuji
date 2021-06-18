<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pageToGo = 'profile';
$cbp = '';

if(isset($_GET['cbp'])){
	
	$cbp = $_GET['cbp'];
	
	if(isset($_SESSION['comebackUrl'][$cbp])){
		
		if($cbp == 'en'){
			
			$_SESSION['comebackUrl']['bn'] == $_SESSION['comebackUrl'][$cbp];
			$pageToGo = $_SESSION['comebackUrl']['bn'];
			
		}
		else{
			
			$pageToGo = $_SESSION['comebackUrl'][$cbp];
			
		}
		
	}
	
}

$al = '';

if(isset($_GET['al'])){
	
	$al = $_GET['al'];
	
}

$activeLink = '';

if(($cbp == 'en') || ($cbp == 'bn')){
	
	$activeLink = 'bn';
	
}
else if(($cbp == 'search') || ($cbp == 'search-result')){
	
	$activeLink = 'search';
	
}
else if(($cbp == 'mark') || ($cbp == 'new-flat-info') || ($cbp == 'new-flat-info-check-again') || ($cbp == 'new-room-info') || ($cbp == 'new-room-info-check-again') || ($cbp == 'new-mess-info') || ($cbp == 'new-mess-info-check-again') || ($cbp == 'new-officespace-info') || ($cbp == 'new-officespace-info-check-again') || ($cbp == 'new-shop-info') || ($cbp == 'new-flat-shop-check-again') || ($cbp == 'error') || ($cbp == 'successful')){
	
	$activeLink = 'mark';
	
}
else if($cbp == 'profile'){
	
	$activeLink = 'profile';
	
}
else if(($cbp == 'advertisements') || ($cbp == 'actions')){
	
	$activeLink = 'advertisements';
	
}
else if($cbp == 'details'){
	
	$activeLink = $al;
	
}

if(isset($_SESSION['id'])){
	
	header('Location:' . $pageToGo);
	exit;
	
}

if(isset($_SESSION['id'])){
	
	header('Location:' . $pageToGo);
	exit;
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);

$email = 'Unknown';

if(isset($_GET['dis'])){
	
	$rand = $_GET['dis'];
	
	$randx = strip_tags($rand);
	$rand = str_replace(' ','',$randx);
	
	if(!preg_match("/^[A-Za-z0-9]+$/",$rand)){
		
		$rand = md5(uniqid(rand()));
		
	}
	else if(!isset($_SESSION['recover-password-resend'][$rand])){
		
		$rand = md5(uniqid(rand()));
		
	}
	
	if(isset($_SESSION['recover-password-resend'][$rand]['email'])){
		
		$email = $_SESSION['recover-password-resend'][$rand]['email'];
		
	}
	
}
else{
	
	$rand = md5(uniqid(rand()));
	
}

$newPasskey = md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand()));

if($email != 'Unknown'){
	
	$email = $_SESSION['recover-password-resend'][$rand]['email'];
	
	if(!file_exists('../db/db.php')){
		
		session_destroy();
		
		header('Location:error-db');
		exit;
		
	}
	
	$_SESSION['db'] = 1;
	include('../db/db.php');
	$_SESSION['db'] = NULL;
	
	$query = "SELECT passkey FROM users_forgot_password WHERE email='$email'";
	$result = mysqli_query($dbc,$query);
	$count = mysqli_num_rows($result);
	
	if($count == 1){
		
		$row = mysqli_fetch_array($result);
	
		$passkeyString = $row['passkey'];
		$pieces = explode(" ",$passkeyString);
					
		$dbPasskey = $newPasskey . ' ' . $pieces[0] . ' ' . $pieces[1] . ' ' . $pieces[2] . ' ' . $pieces[3];
		
	}
	else{
		
		$dbPasskey = $newPasskey . ' & & & &';
		
	}
	
}

$try = 0;

if(isset($_GET['try'])){
	
	$try = 1;
	
}

$timestamp = time();

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>কী খুঁজি - পাসওয়ার্ড পুনরুদ্ধার</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/recover-password-resend.css">

    <script src="js/clock.js"></script>
</head>

<body onload="startTime()">
	<div class="topnav">
    	<img id="logo" src="../logo/logo.png">
        <div class="topnav-left">
        	<a href="/bn/">কী খুঁজি</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="../bn/" <?php if($activeLink == 'en'){ ?>class="active"<?php } ?>>হোম</a>
            <a href="search" <?php if($activeLink == 'search'){ ?>class="active"<?php } ?>>অনুসন্ধান</a>
            <a href="mark" <?php if($activeLink == 'mark'){ ?>class="active"<?php } ?>>প্রচার</a>
            <a href="profile" <?php if($activeLink == 'profile'){ ?>class="active"<?php } ?>>প্রোফাইল</a>
            <a href="advertisements" <?php if($activeLink == 'advertisements'){ ?>class="active"<?php } ?>>বিজ্ঞাপনসমূহ</a>
            <button id="lanButton" onClick="location.href='/<?php echo $pathUrl; ?>'">English</button>
        </div>
        
        <div class="topnav-right">
            <a href="login?cbp=<?php echo $cbp; ?>&al=<?php echo $al; ?>&dis=<?php echo $rand; ?>">লগ ইন</a>
            <a href="register?cbp=<?php echo $cbp; ?>&al=<?php echo $al; ?>&dis=<?php echo $rand; ?>">নিবন্ধন</a>
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
        
        <form action="" method="post">
            <table id="recoverTable">
                <?php
                
                if($email == 'Unknown'){
                    
                    ?>
                    <tr><td>কিছু একটা গড়মিল হয়েছে! নিশ্চিতকরণ কোডটি পাঠানোর জন্য আপনার ইমেইলটি খুঁজে পাওয়া যাচ্ছে না ।</td></tr>
                    <?php
                    
                }
                else{
                    
                    if($try == 0){
                        
                        ?>
                        <tr><td>আমরা <span id="emailID"><?php echo $email; ?></span> এ একটি মেইল পাঠিয়েছি ।</td></tr>
                        <?php
                        
                    }
                    else{
                        
                        ?>
                        <tr><td>আমরা আবার <span id="emailID"><?php echo $email; ?></span> এ একটি মেইল পাঠিয়ে দিয়েছি ।</td></tr>
                        <?php
                        
                    }
                    
                    ?>
                    <tr><td>আপনার ইমেইল ঠিকানাটি নিশ্চিত করতে আমাদের পাঠানো মেইলের ভেতরের লিঙ্কটিতে ক্লিক করুন । লিঙ্কে ক্লিক করলে আপনাকে একটি পাতায় নিয়ে যাওয়া হবে, যেখানে আপনি আপনার একাউন্টের জন্য পছন্দমত পাসওয়ার্ড বসাতে পারবেন ।</td></tr>
                    <tr><td>কখনও কখনও মেইলটি spam folder এ পাওয়া যায় । তাই <span id="spanEm">spam messages</span> এ খুঁজে দেখতে ভুলবেন না ।</td></tr>
                    <tr><td>যদি আপনি আগের মেইল খুঁজে না পান, তাহলে নীচের "নিশ্চিতকরণ মেইলটি পুনরায় পাঠান" বোতামে ক্লিক করুন । আমরা আবার আপনাকে মেইলটি পাঠিয়ে দেব ।</td></tr>
                    <tr id="submitRow"><td><input type="submit" name="submit" id="submit" value="নিশ্চিতকরণ মেইলটি পুনরায় পাঠান"></td></tr>
                    <?php
                        
                }
                    
                ?>
                <tr id="backRow"><td><a id="backLink" href="login?cbp=<?php echo $cbp; ?>&dis=<?php $rand; ?>">লগ ইন এ ফিরে চলুন</a></td></tr>
            </table>
        </form>
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

<?php

if(isset($_POST['submit'])){
	
	$query = "SELECT id FROM users_forgot_password WHERE email='$email'";
	$result = mysqli_query($dbc,$query);
	$count = mysqli_num_rows($result);
	
	if($count == 0){
		
		$query = "INSERT INTO users_forgot_password(email,passkey,timestamp) VALUES('$email','$dbPasskey','$timestamp')";
		$result = mysqli_query($dbcInsert,$query);
		
	}
	else{
		
		$query = "UPDATE users_forgot_password SET passkey='$dbPasskey',timestamp='$timestamp' WHERE email='$email'";
		$result = mysqli_query($dbcUpdate,$query);
		
	}
	
	require("../../phpmailer/class.phpmailer.php");
    
    $mail = new phpmailer();
    
    $mail->From     = "no-reply@kikhuji.com";
    $mail->FromName = "Ki Khuji";
    $mail->Host     = "gator4256.hostgator.com";
    $mail->Mailer   = "smtp";
	$mail->Port   = "465";
	$mail->SMTPSecure   = "ssl";
	$mail->SMTPAuth   = true;
	$mail->Username   = "no-reply@kikhuji.com";
	$mail->Password   = "Ojhikp1VB%3drx@qV1Fa%q?60Td^C4cxh&q";
    $mail->isHTML();
    $mail->Subject = 'Recover Password';

    $link = 'https://kikhuji.com/bn/complete-recover-password?dis=' . $newPasskey;

    $message = '<html>
	<head>
	<link href="http://linktocss/.../etc" rel="stylesheet" type="text/css" />
	<style>
	.button{
		
		font-size:25px;
		text-decoration:none;
		border: none;
		color: white;
		padding: 14px 28px;
		cursor: pointer;
		background-color: #2196F3;
		
	}
	.button:hover{
		
		background-color: blue;
		
	}
	.text{
		
		font-size:20px;
		font-family:arial;
		
	}
	</style>
	</head>
	<span class="text">Click on the blue button to set a new password in your account.</span> <a href="';
	
	$message .= $link;
	
	$message .='"><button class="button">Click here to set a new password</button></a>
	<body>
	</body>
	</html>
	';

    $mail->Body    = $message;
    $mail->AddAddress($email);
        
    $mail->Send();
	
	header('Location:recover-password-resend?cbp=' . $cbp . '&dis=' . $rand . '&try=1');
	exit;
	
}

ob_end_flush();

?>