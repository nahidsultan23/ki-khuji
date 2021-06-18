<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$cbp = '';

if(isset($_GET['cbp'])){
	
	$cbp = $_GET['cbp'];
	
}

$al = '';

if(isset($_GET['al'])){
	
	$al = $_GET['al'];
	
}

$activeLink = '';

if(($cbp == 'en') || ($cbp == 'bn')){
	
	$activeLink = 'en';
	
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

$_SESSION['id'] = NULL;
$_SESSION['email'] = NULL;
$_SESSION['displayEmail'] = NULL;

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

$error_email = '';

if(isset($_SESSION['login']['email'])){
	
	$error_email = $_SESSION['login']['email'];
	
}

if(isset($_GET['dis'])){
	
	$rand = $_GET['dis'];
	
	$randx = strip_tags($rand);
	$rand = str_replace(' ','',$randx);
	
	if(!preg_match("/^[A-Za-z0-9]+$/",$rand)){
		
		$rand = md5(uniqid(rand()));
		
	}
	else if(!isset($_SESSION['recover-password'][$rand])){
		
		$rand = md5(uniqid(rand()));
		
	}
	
	if(isset($_SESSION['recover-password'][$rand]['error-email'])){
		
		$error_email = $_SESSION['recover-password'][$rand]['error-email'];
		
	}
	
}
else{
	
	$rand = md5(uniqid(rand()));
	
}

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Recover Password</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/recover-password.css">
    
    <script src="js/clock.js"></script>
</head>

<?php

if(isset($_GET['er'])){
	
	if($_GET['er'] == 'email-len'){
		
		$message = 'Email length should not exceed 320 characters.';
		
		?>
        <style>
		input[type=email]{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'email'){
		
		$message = 'Sorry! We couldn\'t find any account containing this email.';
		
		?>
        <style>
		input[type=email]{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	
}

?>

<body onload="startTime()">
	<div class="topnav">
    	<img id="logo" src="logo/logo.png">
        <div class="topnav-left">
        	<a href="/">Ki Khuji</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/" <?php if($activeLink == 'en'){ ?>class="active"<?php } ?>>Home</a>
            <a href="search" <?php if($activeLink == 'search'){ ?>class="active"<?php } ?>>Search</a>
            <a href="mark" <?php if($activeLink == 'mark'){ ?>class="active"<?php } ?>>Advertise</a>
            <a href="profile" <?php if($activeLink == 'profile'){ ?>class="active"<?php } ?>>Profile</a>
            <a href="advertisements" <?php if($activeLink == 'advertisements'){ ?>class="active"<?php } ?>>Advertisements</a>
            <?php
			
			if($ip_location == 'Bangladesh'){
				
				?>
                <button id="lanButton" onClick="location.href='/bn/<?php echo $pathUrl; ?>'">বাংলা</button>
                <?php
				
			}
			
			?>
        </div>
        
        <div class="topnav-right">
            <a href="login?cbp=<?php echo $cbp; ?>&al=<?php echo $al; ?>&dis=<?php echo $rand; ?>">Log In</a>
            <a href="register?cbp=<?php echo $cbp; ?>&al=<?php echo $al; ?>&dis=<?php echo $rand; ?>">Register</a>
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
                <td><img id="bigLogo" src="logo/logo.png"></td>
            </tr>
        </table>
        
        <form action="" method="post">
            <table id="recoverTable">
                <?php
                if(isset($message)){
                    
                    ?>
                    <tr id="message"><td colspan="2"><?php echo $message; ?></td></tr>
                    <?php
                    
                }
                ?>
                <tr id="heading"><td colspan="2">Type your Email to recover Password</td></tr>
                <tr><td><span id="emailName">Email</span></td><td id="secondColumn"><input type="email" name="email" maxlength="320" required pattern="^[A-Za-z0-9@._]+" value="<?php echo $error_email; ?>"></td></tr>
                <tr id="submitRow"><td colspan="2"><input type="submit" name="submit" id="submit" value="Recover Password"></td></tr>
                <tr id="backRow"><td colspan="2"><a id="backLink" href="login?cbp=<?php echo $cbp; ?>&al=<?php echo $al; ?>&dis=<?php echo $rand; ?>">Back to Log In</a></td></tr>
            </table>
        </form>
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

<?php

if(isset($_POST['submit'])){
	
	$email = $_POST['email'];
	
	$emailx = strip_tags($email);
	$email = str_replace(' ','',$emailx);
	
	if(!preg_match("/^[A-Za-z0-9@._]+$/",$email)){
		
		header('Location:recover-password?er=email&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	if(strlen($email) > 320){
		
		header('Location:recover-password?er=email-len&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	$email = strtolower($email);
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
		header('Location:recover-password?er=email&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	$_SESSION['recover-password'][$rand]['error-email'] = $email;
	
	if(!file_exists('db/db.php')){
		
		session_destroy();
		
		header('Location:error-db');
		exit;
		
	}
	
	$_SESSION['db'] = 1;
	include('db/db.php');
	$_SESSION['db'] = NULL;
	
	$query = "SELECT id FROM users_final WHERE email='$email'";
	$result = mysqli_query($dbc,$query);
	$count = mysqli_num_rows($result);
	
	if($count == 0){
		
		header('Location:recover-password?er=email&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	$_SESSION['recover-password'][$rand] = NULL;
	$_SESSION['recover-password-resend'][$rand]['email'] = $email;
	
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
	
	require("../phpmailer/class.phpmailer.php");
    
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

    $link = 'https://kikhuji.com/complete-recover-password?dis=' . $passkey;

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
	
	header('Location:recover-password-resend?cbp=' . $cbp . '&dis=' . $rand);
	exit;
	
}

ob_end_flush();

?>