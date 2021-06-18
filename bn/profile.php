<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);
$_SESSION['comebackUrl']['profile'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=profile');
	exit;
	
}

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$displayEmail = $_SESSION['displayEmail'];

$edit = '';

if(isset($_GET['chg'])){
	
	if($_GET['chg'] == 'pss'){
		
		$edit = 'password';
		
	}
	
}

if(isset($_GET['er'])){
	
	if($_GET['er'] == 'wrng-pass'){
		
		$messageRed = 'বর্তমান পাসওয়ার্ডটি ভুল ।';
		
		?>
        <style>
		#password{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'new-pass'){
		
		$messageRed = 'দয়া করে পাসওয়ার্ডে উপযুক্ত চিহ্ন বা সংখ্যা ব্যবহার করুন ।';
		
		?>
        <style>
		#new-password{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'password-len'){
		
		$messageRed = 'পাসওয়ার্ডে সর্বোচ্চ 200 টি চিহ্ন বা সংখ্যা ব্যবহার করা যাবে ।';
		
		?>
        <style>
		#new-password{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'password-dif'){
		
		$messageRed = 'পাসওয়ার্ড দুটো মেলে নি । দয়া করে দুটো ঘরে একই পাসওয়ার্ড লিখুন ।';
		
		?>
        <style>
		#new-password{
			border: 2px solid red;
		}
		</style>
        <?php
		
	}
	else if($_GET['er'] == 'pass-chnged'){
		
		$messageGreen = 'আপনি সফলভাবে আপনার পাসওয়ার্ড পরিবর্তন করেছেন ।';
		
	}
	
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>কী খুঁজি - প্রোফাইল</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/profile.css">
    
    <script src="js/clock.js"></script>
</head>

<?php

if(!file_exists('../db/db.php')){
	
	session_destroy();
	
	header('Location:error-db');
	exit;
	
}

$_SESSION['db'] = 1;
include('../db/db.php');
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
    	<img id="logo" src="../logo/logo.png">
        <div class="topnav-left">
        	<a href="/bn/">কী খুঁজি</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/bn/">হোম</a>
            <a href="search">অনুসন্ধান</a>
            <a href="mark">প্রচার</a>
            <a href="profile" class="active">প্রোফাইল</a>
            <a href="advertisements">বিজ্ঞাপনসমূহ</a>
            <button id="lanButton" onClick="location.href='/<?php echo $pathUrl; ?>'">English</button>
        </div>
        
        <div class="topnav-right">
            <a href=""><?php echo $displayEmail; ?></a>
            <a href="logout?cbp=profile">লগ আউট</a>
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
                    <tr id="heading"><td colspan="2">পাসওয়ার্ড পরিবর্তন</td></tr>
                    <tr id="blankRow"></tr>
                    <tr><td id="firstColumn">বর্তমান পাসওয়ার্ড</td><td><input type="password" name="password" id="password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                    <tr id="recoverRow"><td colspan="2"><a id="recoverLink" href="recover-password">পাসওয়ার্ড ভুলে গিয়েছেন? পুনরুদ্ধার করতে এখানে ক্লিক করুন ।</a></td></tr>
                    <tr id="blankRow"></tr>
                    <tr><td>নতুন পাসওয়ার্ড</td><td><input type="password" name="new-password" id="new-password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                    <tr><td>নতুন পাসওয়ার্ডটি পুনরায় লিখুন</td><td><input type="password" name="retype-new-password" id="new-password" maxlength="200" required pattern="^[A-Za-z0-9@_]+"></td></tr>
                    <tr id="submitRow"><td colspan="2"><input type="submit" name="submit" id="submit" value="পাসওয়ার্ড পরিবর্তন করুন"></td></tr>
                    <tr id="backRow"><td colspan="2"><a id="backLink" href="profile">প্রোফাইল এ ফিরে চলুন</a></td></tr>
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
                    <tr id="heading"><td colspan="2">সদস্য প্রোফাইল</td></tr>
                    <tr id="emailRow"><td id="firstColumn">ইমেইল</td> <td><?php echo $email; ?></td></tr>
                    <tr id="passwordRow"><td>পাসওয়ার্ড</td> <td>*************** <a id="changePasswordLink" href="profile?chg=pss">পাসওয়ার্ড পরিবর্তন করুন</a></td></tr>
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
        <td id="bottomContentsSecond">আমাদের ইমেইল ঠিকানা <span id="helloEmail">hello@kikhuji.com</span></td>
        <td id="bottomContentsLast"></td></tr>
    </table>
</body>

</html>