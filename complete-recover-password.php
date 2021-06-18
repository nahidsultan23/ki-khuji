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
$pathUrl = substr($pathUrl,1);

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

$passkey = 'c2r';

if(isset($_GET['dis'])){
	
	$passkey = $_GET['dis'];
	
}

$passkeyx = strip_tags($passkey);
$passkey = str_replace(' ','',$passkeyx);

if(!preg_match("/^[A-Za-z0-9]+$/", $passkey)) {
		
	$messageWrong = 'Something went wrong! Your verification code may have expired. Please check again if you have clicked on the correct link.';
			
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
	
	$query = "SELECT id,email,passkey FROM users_forgot_password";
	$result = mysqli_query($dbc,$query);
	$count = mysqli_num_rows($result);
	
	if($count){
		
		while($row = mysqli_fetch_array($result)){
		
			$dbPasskey = $row['passkey'];
			$pieces = explode(" ",$dbPasskey);
			
			if(($pieces[0] == $passkey) || ($pieces[1] == $passkey) || ($pieces[2] == $passkey) || ($pieces[3] == $passkey) || ($pieces[4] == $passkey)){
				
				$rowID = $row['id'];
				$email = $row['email'];
		
				$match = 1;
				
				break;
				
			}
			
		}
		
	}
	
	if($match == 0){
		
		$messageWrong = 'Something went wrong! Your verification code may have expired. Please check again if you have clicked on the correct link.';
		
	}
	
}

if(isset($_GET['er'])){
	
	if($_GET['er'] == 'password-len'){
		
		$messageNeg = 'Maximum 200 characters can be used for Password.';
		
	}
	else if($_GET['er'] == 'password-dif'){
		
		$messageNeg = 'Passwords do not match. Please use same password in both fields.';
		
	}
	else if($_GET['er'] == 'password'){
		
		$messageNeg = 'Please use defined characters in your Password.';
		
	}
	
}

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Complete Recover Password</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/complete-recover-password.css">
    
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
            <?php
			
			if($ip_location == 'Bangladesh'){
				
				?>
                <button id="lanButton" onClick="location.href='/bn/<?php echo $pathUrl; ?>'">বাংলা</button>
                <?php
				
			}
			
			?>
        </div>
        
        <div class="topnav-right">
            <a href="login">Log In</a>
            <a href="register">Register</a>
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
        
        <?php
        
        if(isset($messageWrong)){
            
            ?>
            <table id="recoverTable">
                <tr><td><?php echo $messageWrong; ?></td></tr>
                <tr><td>If you want us to send the mail again, start the procedure from the beginning. <a href="recover-password">Click here to go to Recover Password page</a></td></tr>
                <tr id="backRow"><td><a id="backLink" href="/">Go back to Home</a></td></tr>
            </table>
            <?php
            
        }
        else{
            
            ?>
            <form action="" method="post">
                <table id="recoverTable">
                    <?php
                    
                    if(isset($messageNeg)){
                        
                        ?>
                        <tr id="messageNeg"><td colspan="2"><?php echo $messageNeg; ?></td></tr>
                        <?php
                        
                    }
                    
                    ?>
                    <tr id="heading"><td colspan="2">Set up a new password</td></tr>
                    <tr><td><span id="emailName">Email</span></td><td id="secondColumn"><span id="emailID"><?php echo $email; ?></span></td></tr>
                    <tr><td><span id="passwordName">Password</span></td><td><input type="password" name="password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                    <tr><td><span id="passwordName">Retype Password</span></td><td><input type="password" name="retype-password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                    <tr id="submitRow"><td colspan="2"><input type="submit" name="submit" id="submit" value="Update Password"></td></tr>
                    <tr id="backRow"><td colspan="2"><a id="backLink" href="/">Go back to Home</a></td></tr>
                </table>
            </form>
            <?php
            
            if(isset($_POST['submit'])){
                
                $password = $_POST['password'];
                $retypePassword = $_POST['retype-password'];
                
                $passwordx = strip_tags($password);
                $password = str_replace(' ','',$passwordx);
                
                $retypePasswordx = strip_tags($retypePassword);
                $retypePassword = str_replace(' ','',$retypePasswordx);
                
                if(!preg_match("/^[A-Za-z0-9@_]+$/",$password)){
                    
                    header('Location:complete-recover-password?er=password&dis=' . $passkey);
                    exit;
                    
                }
                
                if(strlen($password) > 200){
                
                    header('Location:complete-recover-password?er=password-len&dis=' . $passkey);
                    exit;
                    
                }
                else if((strlen($retypePassword) > 200) || ($retypePassword != $password)){
                    
                    header('Location:complete-recover-password?er=password-dif&dis=' . $passkey);
                    exit;
                    
                }
                
                $salt = hash('sha512', $email);
                $passwordx = hash('sha512', $password);
                $passwordy = $salt.$passwordx;
                $password = hash('sha512', $passwordy);
                
                $query = "UPDATE users_final SET password='$password' WHERE email='$email'";
                $result = mysqli_query($dbcUpdate,$query);
                
                $query = "DELETE FROM users_forgot_password WHERE id='$rowID'";
                $result = mysqli_query($dbcDelete,$query);
                
                $query = "SELECT id FROM info WHERE user_id='$email'";
                $result = mysqli_query($dbc,$query);
                $count = mysqli_num_rows($result);
                
                if($count){
                    
                    $row = mysqli_fetch_array($result);
                    $adID = $row['id'];
                    
                    $query = "SELECT id FROM users_final WHERE email='$email'";
                    $result = mysqli_query($dbc,$query);
                    $row = mysqli_fetch_array($result);
                    $userID = $row['id'];
                    
                    $query = "UPDATE info SET user_id='$userID',publish='1' WHERE id='$adID'";
                    $result = mysqli_query($dbcUpdate,$query);
                    
                }
                
                header('Location:login?er=pass-rc');
                exit;
                
            }
            
        }
        
        ob_end_flush();
        
        ?>
    
        <table id="bottomSpace">
            <tr><td></td></tr>
        </table>
    </div>  
  
    <table id="bottomContents">
    	<tr><td id="bottomContentsFirst"></td>
        <td id="bottomContentsSecond">Contact us at <span id="helloEmail">hello@kikhuji.com</span></td>
        <td id="bottomContentsLast"></td></tr>
    </table>
</body>

</html>