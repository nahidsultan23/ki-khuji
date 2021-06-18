<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);
$_SESSION['comebackUrl']['profile'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=profile');
	exit;
	
}

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$displayEmail = $_SESSION['displayEmail'];

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

$edit = '';

if(isset($_GET['chg'])){
	
	if($_GET['chg'] == 'pss'){
		
		$edit = 'password';
		
	}
	
}

if(isset($_GET['er'])){
	
	if($_GET['er'] == 'wrng-pass'){
		
		$messageRed = 'Current password is incorrect.';
		
		?>
        <style>
		#password{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'new-pass'){
		
		$messageRed = 'Please use defined characters in your Password.';
		
		?>
        <style>
		#new-password{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'password-len'){
		
		$messageRed = 'Maximum 200 characters can be used for Password.';
		
		?>
        <style>
		#new-password{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'password-dif'){
		
		$messageRed = 'Passwords do not match. Please use same password in both fields.';
		
		?>
        <style>
		#new-password{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'pass-chnged'){
		
		$messageGreen = 'You have successfully changed your password.';
		
	}
	
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Profile</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/profile.css">
    
    <script src="js/clock.js"></script>
</head>

<?php

if(!file_exists('db/db.php')){
	
	session_destroy();
	
	header('Location:error-db');
	exit;
	
}

$_SESSION['db'] = 1;
include('db/db.php');
$_SESSION['db'] = NULL;

$query = "SELECT * FROM users_final WHERE id='$id'";
$result = mysqli_query($dbc,$query);
$row = mysqli_fetch_array($result);

$originalPassword = $row['password'];

$date = $row['date'];
$screenDate = date('d F, Y',strtotime($date));

$time = $row['time'];

?>

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
            <a href=""><?php echo $displayEmail; ?></a>
            <a href="logout?cbp=profile">Log Out</a>
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
        <form action="" method="post">
            <table id="profile">
                <?php
                
                if(isset($messageRed)){
                    
                    ?>
                    <tr id="redMessageRow"><td colspan="2"><?php echo $messageRed; ?></td></tr>
                    <?php
                    
                }
                else if(isset($messageGreen)){
                    
                    ?>
                    <tr id="greenMessageRow"><td colspan="2"><?php echo $messageGreen; ?></td></tr>
                    <?php
                    
                }
                
                if($edit == 'password'){
                    
                    ?>
                    <tr id="heading"><td colspan="2">Change Password</td></tr>
                    <tr id="blankRow"></tr>
                    <tr><td id="firstColumn">Current Password</td><td><input type="password" name="password" id="password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                    <tr id="recoverRow"><td colspan="2"><a id="recoverLink" href="recover-password">Forgot password? Click here to recover.</a></td></tr>
                    <tr id="blankRow"></tr>
                    <tr><td>New Password</td><td><input type="password" name="new-password" id="new-password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                    <tr><td>Retype New Password</td><td><input type="password" name="retype-new-password" id="new-password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                    <tr id="submitRow"><td colspan="2"><input type="submit" name="submit" id="submit" value="Change Password"></td></tr>
                    <tr id="backRow"><td colspan="2"><a id="backLink" href="profile">Back to Profile</a></td></tr>
                    <?php
                    
                    if(isset($_POST['submit'])){
                        
                        $currentPasswordx = $_POST['password'];
                        $currentPassword = str_replace(' ','',$currentPasswordx);
                        
                        $newPasswordx = $_POST['new-password'];
                        $newPassword = str_replace(' ','',$newPasswordx);
                        
                        $retypeNewPasswordx = $_POST['retype-new-password'];
                        $retypeNewPassword = str_replace(' ','',$retypeNewPasswordx);
                        
                        if(!preg_match("/^[A-Za-z0-9@_]+$/",$currentPassword)){
                            
                            header('Location:profile?chg=pss&er=wrng-pass');
                            exit;
                            
                        }
                        else if(strlen($currentPassword) > 200){
                            
                            header('Location:profile?chg=pss&er=wrng-pass');
                            exit;
                            
                        }
                        
                        $salt = hash('sha512', $email);
                        $currentPasswordx = hash('sha512', $currentPassword);
                        $currentPasswordy = $salt.$currentPasswordx;
                        $currentPassword = hash('sha512', $currentPasswordy);
                        
                        if($currentPassword != $originalPassword){
                            
                            header('Location:profile?chg=pss&er=wrng-pass');
                            exit;
                            
                        }
                        
                        if(!preg_match("/^[A-Za-z0-9@_]+$/",$newPassword)){
                            
                            header('Location:profile?chg=pss&er=new-pass');
                            exit;
                            
                        }
                        
                        if(strlen($newPassword) > 200){
                            
                            header('Location:profile?chg=pss&er=password-len');
                            exit;
                            
                        }
                        else if((strlen($retypeNewPassword) > 200) || ($retypeNewPassword != $newPassword)){
                            
                            header('Location:profile?chg=pss&er=password-dif');
                            exit;
                            
                        }
                        
                        $newPasswordx = hash('sha512', $newPassword);
                        $newPasswordy = $salt.$newPasswordx;
                        $newPassword = hash('sha512', $newPasswordy);
                        
                        $query = "UPDATE users_final SET password='$newPassword' WHERE id='$id'";
                        $result = mysqli_query($dbcUpdate,$query);
                        
                        header('Location:profile?er=pass-chnged');
                        exit;
                        
                    }
                    
                }
                else{
                    
                    ?>
                    <tr id="heading"><td colspan="2">User Profile</td></tr>
                    <tr id="emailRow"><td id="firstColumn">Email</td> <td><?php echo $email; ?></td></tr>
                    <tr id="passwordRow"><td>Password</td> <td>*************** <a id="changePasswordLink" href="profile?chg=pss">Change password</a></td></tr>
                    <?php
                    
                }
                
                ob_end_flush();
                
                ?>
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