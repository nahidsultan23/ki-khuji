<?php

if(!isset($_SESSION)){
	
	session_start();
	
}

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Invalid URL</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="/css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="/css/m/mtopbar.css" />
    <link rel="stylesheet" href="/css/error.css">
    
    <script src="/js/clock.js"></script>
</head>

<body onload="startTime()">
	<div class="topnav">
    	<img id="logo" src="/logo/logo.png">
        <div class="topnav-left">
        	<a href="/">Ki Khuji</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/">Home</a>
            <a href="/search">Search</a>
            <a href="/mark">Advertise</a>
            <a href="/profile">Profile</a>
            <a href="/advertisements">Advertisements</a>
        </div>
        
        <?php
		if(isset($_SESSION['id'])){
			
			$id = $_SESSION['id'];
			$email = $_SESSION['email'];
			$displayEmail = $_SESSION['displayEmail'];
			
			?>
            <div class="topnav-right">
                <a href="/profile"><?php echo $displayEmail; ?></a>
                <a href="/logout?cbp=en">Log Out</a>
            </div>
            <?php
			
		}
		else{
			
			?>
            <div class="topnav-right">
                <a href="/login?cbp=en">Log In</a>
                <a href="/register?cbp=en">Register</a>
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
    
    <table id="bigLogoTable">
    	<tr>
        	<td><img id="bigLogo" src="/logo/logo.png"></td>
        </tr>
    </table>
    
	<table id="error">
    	<tr><td id="description">This URL does not exist !!</td></tr>
        <tr id="backLinkRow"><td><a id="backLink" href="/">Back to Home</a></td></tr>
    </table>

	<table id="bottomSpace">
    	<tr><td></td></tr>
    </table>
</body>
</html>