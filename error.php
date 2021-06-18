<?php

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Error</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/error.css">
    
    <script src="js/clock.js"></script>
</head>

<?php

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);
$_SESSION['comebackUrl']['error'] = $pathUrl;

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

$back = '/';

if(isset($_GET['frm'])){
	
	$back = $_GET['frm'];
	
}

$urlBackPage = $back;

if(isset($_SESSION['comebackUrl'][$back])){
	
	$_SESSION['comebackUrl']['error'] = $_SESSION['comebackUrl'][$back];
	
}

if(isset($_GET['content'])){
	
	$content = $_GET['content'];
	$pageContents = '&content=' . $content;
	
	if($content == 'new-flat'){
		
		$urlBackPage = $urlBackPage . '?content=flat';
		$description = 'Something went wrong! Your advertisement for the flat was not published. Please try again.';
		
	}
	else if($content == 'new-room'){
		
		$urlBackPage = $urlBackPage . '?content=room';
		$description = 'Something went wrong! Your advertisement for the room was not published. Please try again.';
		
	}
	else if($content == 'new-mess'){
		
		$urlBackPage = $urlBackPage . '?content=mess';
		$description = 'Something went wrong! Your advertisement for the mess was not published. Please try again.';
		
	}
	else if($content == 'new-officespace'){
		
		$urlBackPage = $urlBackPage . '?content=officespace';
		$description = 'Something went wrong! Your advertisement for the office space was not published. Please try again.';
		
	}
	else if($content == 'new-shop'){
		
		$urlBackPage = $urlBackPage . '?content=shop';
		$description = 'Something went wrong! Your advertisement for the shop was not published. Please try again.';
		
	}
	else{
		
		$description = 'Something went wrong! Please try again.';
		
	}
	
}
else{
	
	$description = 'Something went wrong! Please try again.';
	
}

if(isset($_GET['key'])){
	
	$rand = $_GET['key'];
	$urlBackPage = $urlBackPage . '&key=' . $rand;
	
}

if($back == '/'){
	
	$urlBackPage = $back;
	
}

$activeLink = '';

if($back == 'new-flat-info-check-again'){
	
	$activeLink = 'mark';
	
}
else if($back == 'new-room-info-check-again'){
	
	$activeLink = 'mark';
	
}
else if($back == 'new-mess-info-check-again'){
	
	$activeLink = 'mark';
	
}
else if($back == 'new-officespace-info-check-again'){
	
	$activeLink = 'mark';
	
}
else if($back == 'new-shop-info-check-again'){
	
	$activeLink = 'mark';
	
}

?>

<body onload="startTime()">
	<div class="topnav">
    	<img id="logo" src="logo/logo.png">
        <div class="topnav-left">
        	<a href="/">Ki Khuji</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/" <?php if($activeLink == 'en'){ ?>class="active"<?php } ?> >Home</a>
            <a href="search" <?php if($activeLink == 'search'){ ?>class="active"<?php } ?> >Search</a>
            <a href="mark" <?php if($activeLink == 'mark'){ ?>class="active"<?php } ?> >Advertise</a>
            <a href="profile" <?php if($activeLink == 'profile'){ ?>class="active"<?php } ?> >Profile</a>
            <a href="advertisements" <?php if($activeLink == 'advertisements'){ ?>class="active"<?php } ?> >Advertisements</a>
            <?php
			
			if($ip_location == 'Bangladesh'){
				
				?>
                <button id="lanButton" onClick="location.href='/bn/<?php echo $pathUrl; ?>'">বাংলা</button>
                <?php
				
			}
			
			?>
        </div>
        
        <?php
		if(isset($_SESSION['id'])){
			
			$id = $_SESSION['id'];
			$email = $_SESSION['email'];
			$displayEmail = $_SESSION['displayEmail'];
			
			?>
            <div class="topnav-right">
                <a href="profile"><?php echo $displayEmail; ?></a>
                <a href="logout?cbp=error">Log Out</a>
            </div>
            <?php
			
		}
		else{
			
			?>
            <div class="topnav-right">
                <a href="login?cbp=error">Log In</a>
                <a href="register?cbp=error">Register</a>
            </div>
            <?php
			
		}
		?>
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
        
        <table id="error">
            <tr><td id="description"><?php echo $description ?></td></tr>
            <tr id="backLinkRow"><td><a id="backLink" href="<?php echo $urlBackPage; ?>">Back</a></td></tr>
        </table>
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