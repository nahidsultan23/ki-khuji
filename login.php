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

if(isset($_GET['dis'])){
	
	$rand = $_GET['dis'];
	
	$randx = strip_tags($rand);
	$rand = str_replace(' ','',$randx);
	
	if(!preg_match("/^[A-Za-z0-9]+$/",$rand)){
		
		$rand = md5(uniqid(rand()));
		
	}
	else if((!isset($_SESSION['register'][$rand])) && (!isset($_SESSION['recover-password'][$rand]))){
		
		$rand = md5(uniqid(rand()));
		
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
    <title>Ki Khuji - Log In</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/login.css">
    
    <script src="js/clock.js"></script>
</head>

<?php

if(isset($_GET['er'])){
	
	if(($_GET['er'] == 'email') || ($_GET['er'] == 'password')){
		
		$messageRed = 'You may have entered a wrong email address or the password is incorrect. Try again.';
		
	}
	else if($_GET['er'] == 'email-len'){
		
		$messageRed = 'Email length should not exceed 320 characters.';
		
		?>
        <style>
		input[type=email]{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'password-len'){
		
		$messageRed = 'Password length should not exceed 200 characters.';
		
		?>
        <style>
		input[type=password]{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'login-need'){
		
		$messageRed = 'You need to log in to see this page.';
		
	}
	else if($_GET['er'] == 'reg-al'){
		
		$messageGreen = 'You have already registered with this email.';
		
	}
	else if($_GET['er'] == 'reg-sc'){
		
		$messageGreen = 'Congratulations! You have successfully registered. Now you can log in to your account.';
		
	}
	else if($_GET['er'] == 'pass-rc'){
		
		$messageGreen = 'You have successfully set up your password.';
		
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
            <a href="">Log In</a>
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
            <table id="loginTable">
                <?php
                
                if(isset($messageGreen)){
                    
                    ?>
                    <tr id="greenMessage"><td colspan="2"><?php echo $messageGreen; ?></td></tr>
                    <?php
                    
                }
                else if(isset($messageRed)){
                    
                    ?>
                    <tr id="redMessage"><td colspan="2"><?php echo $messageRed; ?></td></tr>
                    <?php
                    
                }
                
                ?>
                <tr id="heading"><td colspan="2">Type your Email and Password to log in</td></tr>
                <tr><td><span id="emailName">Email</span></td><td id="secondColumn"><input type="email" name="email" maxlength="320" required pattern="^[A-Za-z0-9@._]+" <?php if(isset($_SESSION['login']['email'])){ ?>value="<?php echo $_SESSION['login']['email']; ?>"<?php } ?>></td></tr>
                <tr><td><span id="passwordName">Password</span></td><td><input type="password" name="password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                <tr><td colspan="2"><a id="backLink" href="recover-password?cbp=<?php echo $cbp; ?>&al=<?php echo $al; ?>&dis=<?php echo $rand; ?>">Forgot your password? Click here to recover.</a></td></tr>
                <tr><td colspan="2"><a id="backLink" href="register?cbp=<?php echo $cbp; ?>&al=<?php echo $al; ?>&dis=<?php echo $rand; ?>">Don't have an account? Click here to register.</a></td></tr>
                <tr id="submitRow"><td colspan="2"><input type="submit" name="submit" id="submit" value="Log In"></td></tr>
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
	
	$emailx = strip_tags($email);
	$email = str_replace(' ','',$emailx);
	
	$passwordx = strip_tags($password);
	$password = str_replace(' ','',$passwordx);
	
	if(!preg_match("/^[A-Za-z0-9@._]+$/",$email)){
		
		header('Location:login?er=email&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	if(strlen($email) > 320){
		
		header('Location:login?er=email-len&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	$email = strtolower($email);
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
		header('Location:login?er=email&cbp=' . $cbp . '&dis=' . $rand);
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
	
	$query = "SELECT id FROM users_temp WHERE email='$email'";
	$result = mysqli_query($dbc,$query);
	$count = mysqli_num_rows($result);
	
	if($count == 1){
		
		$_SESSION['login'] = NULL;
		
		$_SESSION['resend-verification-code'][$rand]['email'] = $email;
		
		header('Location:resend-verification-code?frm=login&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	$_SESSION['login']['email'] = $email;
	
	if(!preg_match("/^[A-Za-z0-9@_]+$/",$password)){
		
		header('Location:login?er=password&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	if(strlen($password) > 200){
		
		header('Location:login?er=password-len&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	
	$salt = hash('sha512', $email);
	$passwordx = hash('sha512', $password);
	$passwordy = $salt.$passwordx;
	$password = hash('sha512', $passwordy);
	
	if(!file_exists('db/db.php')){
		
		session_destroy();
		
		header('Location:error-db');
		exit;
		
	}
	
	$query = "SELECT id FROM users_final WHERE (email='$email' AND password='$password')";
	$result = mysqli_query($dbc,$query);
	$count = mysqli_num_rows($result);
	
	if($count == 0){
		
		header('Location:login?er=email&cbp=' . $cbp . '&dis=' . $rand);
		exit;
		
	}
	else if($count == 1){
		
		$row = mysqli_fetch_array($result);
		
		$id = $row['id'];
		
		$pieces = explode('@',$email);

		if(strlen($pieces[0]) > 20){
			
			$str1 = substr($pieces[0], 0, 15) . '....';
			
		}
		else{
			
			$str1 = $pieces[0];
			
		}
		
		if(strlen($pieces[1]) > 15){
			
			$str2 = '....' . substr($pieces[1], -10);
			
		}
		else{
			
			$str2 = $pieces[1];
			
		}
		
		$displayEmail = $str1 . '@' . $str2;
		
		$_SESSION['login'] = NULL;
		$_SESSION['register'] = NULL;
		$_SESSION['resend-verification-code'] = NULL;
		$_SESSION['recover-password'] = NULL;
		$_SESSION['recover-password-resend'] = NULL;
		
		$_SESSION['id'] = $id;
		$_SESSION['email'] = $email;
		$_SESSION['displayEmail'] = $displayEmail;
		
		header('Location:' . $pageToGo);
		exit;
		
	}
	
	
}

ob_end_flush();

?>