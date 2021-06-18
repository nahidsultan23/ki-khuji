<?php

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);
$_SESSION['comebackUrl']['successful'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=successful');
	exit;
	
}

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$displayEmail = $_SESSION['displayEmail'];

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Successful</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/successful.css">
    
    <script src="js/clock.js"></script>
</head>

<?php

if(isset($_GET['content'])){
	
	$content = $_GET['content'];
	
	if($content == 'new-flat'){
		
		$description = 'Your advertisement has been published successfully. Anyone searching for a flat near the area can find your flat now.';
		
	}
	else if($content == 'new-room'){
		
		$description = 'Your advertisement has been published successfully. Anyone searching for a room near the area can find your room now.';
		
	}
	else if($content == 'new-mess'){
		
		$description = 'Your advertisement has been published successfully. Anyone searching for a mess near the area can find your mess now.';
		
	}
	else if($content == 'new-officespace'){
		
		$description = 'Your advertisement has been published successfully. Anyone searching for an office space near the area can find your office space now.';
		
	}
	else if($content == 'new-shop'){
		
		$description = 'Your advertisement has been published successfully. Anyone searching for a shop near the area can find your shop now.';
		
	}
	else{
		
		header('Location:/');
		exit;
		
	}
	
}
else{
	
	header('Location:/');
	exit;
	
}

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
            <a href="mark" class="active">Advertise</a>
            <a href="profile">Profile</a>
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
            <a href="profile"><?php echo $displayEmail; ?></a>
            <a href="logout?cbp=successful">Log Out</a>
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
        <table id="successful">
            <tr><td id="description"><?php echo $description ?></td></tr>
            <tr><td><a id="backLink" href="/">Back to Home</a></td></tr>
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