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
		
		if($cbp == 'bn'){
			
			$_SESSION['comebackUrl']['en'] == $_SESSION['comebackUrl'][$cbp];
			$pageToGo = $_SESSION['comebackUrl']['en'];
			
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

if(isset($_SESSION['id'])){
	
	header('Location:' . $pageToGo);
	exit;
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

$error_email = '';

if(isset($_GET['dis'])){
	
	$rand = $_GET['dis'];
	
	$randx = strip_tags($rand);
	$rand = str_replace(' ','',$randx);
	
	if(!preg_match("/^[A-Za-z0-9]+$/",$rand)){
		
		$rand = md5(uniqid(rand()));
		
	}
	else if(!isset($_SESSION['register'][$rand])){
		
		$rand = md5(uniqid(rand()));
		
	}
	
	if(isset($_SESSION['register'][$rand]['error-email'])){
		
		$error_email = $_SESSION['register'][$rand]['error-email'];
		
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
    <title>Ki Khuji - Register</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/register.css">
    
    <script src="js/clock.js"></script>
</head>

<?php

if(isset($_GET['er'])){
	
	if($_GET['er'] == 'email'){
		
		$message = 'Please use defined characters in your Email address.';
		
		?>
        <style>
		input[type=email]{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'email-format'){
		
		$message = 'Please enter a valid Email address.';
		
		?>
        <style>
		input[type=email]{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'password'){
		
		$message = 'Please use defined characters in your Password.';
		
		?>
        <style>
		input[type=password]{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'email-len'){
		
		$message = 'Maximum 320 characters can be used for Email.';
		
		?>
        <style>
		input[type=email]{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'password-len'){
		
		$message = 'Maximum 200 characters can be used for Password.';
		
		?>
        <style>
		input[type=password]{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'password-dif'){
		
		$message = 'Passwords do not match. Please use same password in both fields.';
		
		?>
        <style>
		input[type=password]{
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
            <a href="">Register</a>
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
            <table id="registerTable">
                <?php
                
                if(isset($message)){
                    
                    ?>
                    <tr id="message"><td colspan="2"><?php echo $message ?></td></tr>
                    <?php
                    
                }
                
                ?>
                <tr id="heading"><td colspan="2">Fill up the form to register</td></tr>
                <tr><td><span id="emailName">Email</span></td><td id="secondColumn"><input type="email" name="email" maxlength="320" required pattern="^[A-Za-z0-9@._]+" value="<?php echo $error_email; ?>"></td></tr>
                <tr><td><span id="passwordName">Password</span></td><td><input type="password" name="password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                <tr><td><span id="passwordName">Retype Password</span></td><td><input type="password" name="retype-password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                <tr><td colspan="2"><a id="backLink" href="login?cbp=<?php echo $cbp; ?>&al=<?php echo $al; ?>&dis=<?php echo $rand; ?>">Already have an account? Click here to log in.</a></td></tr>
                <tr id="submitRow"><td colspan="2"><input type="submit" name="submit" id="submit" value="Register"></td></tr>
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
	$password = $_POST['password'];
	$retypePassword = $_POST['retype-password'];
	
	$emailx = strip_tags($email);
	$email = str_replace(' ','',$emailx);
	
	$passwordx = strip_tags($password);
	$password = str_replace(' ','',$passwordx);
	
	$retypePasswordx = strip_tags($retypePassword);
	$retypePassword = str_replace(' ','',$retypePasswordx);
	
	if(!isset($_SESSION['register'][$rand])){
		
		$rand =  md5(uniqid(rand()));
		
	}
	
	if(!preg_match("/^[A-Za-z0-9@._]+$/",$email)){
		
		header('Location:register?er=email&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	if(strlen($email) > 320){
		
		header('Location:register?er=email-len&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	$email = strtolower($email);
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
		header('Location:register?er=email-format&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	if(!file_exists('db/db.php')){
		
		session_destroy();
		
		header('Location:error-db');
		exit;
		
	}
	
	$_SESSION['db'] = 1;
	include('db/db.php');
	$_SESSION['db'] = NULL;
	
	$query = "SELECT email FROM users_final WHERE email='$email'";
	$result = mysqli_query($dbc,$query);
	$count = mysqli_num_rows($result);
	
	if($count == 1){
		
		$_SESSION['register'][$rand] = NULL;
		$_SESSION['login']['email'] = $email;
		
		header('Location:login?cbp=' . $cbp . '&er=reg-al');
		exit;
		
	}
	
	$_SESSION['register'][$rand]['error-email'] = $email;
	
	if(!preg_match("/^[A-Za-z0-9@_]+$/",$password)){
		
		header('Location:register?er=password&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	if(strlen($password) > 200){
		
		header('Location:register?er=password-len&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	else if((strlen($retypePassword) > 200) || ($retypePassword != $password)){
		
		header('Location:register?er=password-dif&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	$_SESSION['register'][$rand] = NULL;
	$_SESSION['resend-verification-code'][$rand]['email'] = $email;
	
	$query = "SELECT email FROM users_temp WHERE email='$email'";
	$result = mysqli_query($dbc,$query);
	$count = mysqli_num_rows($result);
	
	if($count == 1){
		
		header('Location:resend-verification-code?frm=reg-al&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	$salt = hash('sha512', $email);
	$passwordx = hash('sha512', $password);
	$passwordy = $salt.$passwordx;
	$password = hash('sha512', $passwordy);
	
	$passkey = md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand()));
	$dbpasskey = $passkey . ' & & & &';
	$timestamp = time();
	
	$query = "INSERT INTO users_temp(email,password,passkey,timestamp) VALUES('$email','$password','$dbpasskey','$timestamp')";
	$result = mysqli_query($dbcInsert,$query);
	
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
    $mail->Subject = 'Complete your registration';

    $link = 'https://kikhuji.com/complete-registration?dis=' . $passkey;

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
	<span class="text">We have recorded your information successfully. Now you\'ll need to click on the blue button below to complete the registration.</span> <a href="';
	
	$message .= $link;
	
	$message .='"><button class="button">Click here to complete registration</button></a>
	<body>
	</body>
	</html>
	';

    $mail->Body    = $message;
    $mail->AddAddress($email);
        
    $mail->Send();
	
	header('Location:resend-verification-code?frm=reg&cbp=' . $cbp . '&dis=' . $rand);
	exit;
	
}

ob_end_flush();

?>