<?php

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>কী খুঁজি - গোলমাল</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/error.css">
    
    <script src="js/clock.js"></script>
</head>

<?php

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);
$_SESSION['comebackUrl']['error'] = $pathUrl;

$back = '/bn/';

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
		$description = 'কিছু একটা গড়মিল হয়েছে! আপনার ফ্ল্যাটের বিজ্ঞাপনটি প্রকাশিত হয় নি । দয়া করে আবার চেষ্টা করুন ।';
		
	}
	else if($content == 'new-room'){
		
		$urlBackPage = $urlBackPage . '?content=room';
		$description = 'কিছু একটা গড়মিল হয়েছে! আপনার রুমের বিজ্ঞাপনটি প্রকাশিত হয় নি । দয়া করে আবার চেষ্টা করুন ।';
		
	}
	else if($content == 'new-mess'){
		
		$urlBackPage = $urlBackPage . '?content=mess';
		$description = 'কিছু একটা গড়মিল হয়েছে! আপনার মেসের বিজ্ঞাপনটি প্রকাশিত হয় নি । দয়া করে আবার চেষ্টা করুন ।';
		
	}
	else if($content == 'new-officespace'){
		
		$urlBackPage = $urlBackPage . '?content=officespace';
		$description = 'কিছু একটা গড়মিল হয়েছে! আপনার অফিসের বিজ্ঞাপনটি প্রকাশিত হয় নি । দয়া করে আবার চেষ্টা করুন ।';
		
	}
	else if($content == 'new-shop'){
		
		$urlBackPage = $urlBackPage . '?content=shop';
		$description = 'কিছু একটা গড়মিল হয়েছে! আপনার দোকানের বিজ্ঞাপনটি প্রকাশিত হয় নি । দয়া করে আবার চেষ্টা করুন ।';
		
	}
	else{
		
		$description = 'কিছু একটা গড়মিল হয়েছে! দয়া করে আবার চেষ্টা করুন ।';
		
	}
	
}
else{
	
	$description = 'কিছু একটা গড়মিল হয়েছে! দয়া করে আবার চেষ্টা করুন ।';
	
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
    	<img id="logo" src="../logo/logo.png">
        <div class="topnav-left">
        	<a href="/bn/">কী খুঁজি</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/bn/" <?php if($activeLink == ''){ ?>class="active"<?php } ?> >হোম</a>
            <a href="search" <?php if($activeLink == 'search'){ ?>class="active"<?php } ?> >অনুসন্ধান</a>
            <a href="mark" <?php if($activeLink == 'mark'){ ?>class="active"<?php } ?> >প্রচার</a>
            <a href="profile" <?php if($activeLink == 'profile'){ ?>class="active"<?php } ?> >প্রোফাইল</a>
            <a href="advertisements" <?php if($activeLink == 'advertisements'){ ?>class="active"<?php } ?> >বিজ্ঞাপনসমূহ</a>
            <button id="lanButton" onClick="location.href='/<?php echo $pathUrl; ?>'">English</button>
        </div>
        
        <?php
		if(isset($_SESSION['id'])){
			
			$id = $_SESSION['id'];
			$email = $_SESSION['email'];
			$displayEmail = $_SESSION['displayEmail'];
			
			?>
            <div class="topnav-right">
                <a href="profile"><?php echo $displayEmail; ?></a>
                <a href="logout?cbp=error">লগ আউট</a>
            </div>
            <?php
			
		}
		else{
			
			?>
            <div class="topnav-right">
                <a href="login?cbp=error">লগ ইন</a>
                <a href="register?cbp=error">নিবন্ধন</a>
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
                <td><img id="bigLogo" src="../logo/logo.png"></td>
            </tr>
        </table>
        
        <table id="error">
            <tr><td id="description"><?php echo $description ?></td></tr>
            <tr id="backLinkRow"><td><a id="backLink" href="<?php echo $urlBackPage; ?>">ফিরে চলুন</a></td></tr>
        </table>
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