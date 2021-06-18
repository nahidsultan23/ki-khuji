<?php

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);
$_SESSION['comebackUrl']['successful'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=successful');
	exit;
	
}

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$displayEmail = $_SESSION['displayEmail'];

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>কী খুঁজি - সফল</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/successful.css">
    
    <script src="js/clock.js"></script>
</head>

<?php

if(isset($_GET['content'])){
	
	$content = $_GET['content'];
	
	if($content == 'new-flat'){
		
		$description = 'আপনার বিজ্ঞাপনটি সফলভাবে প্রকাশিত হয়েছে । এখন থেকে যে কেউ ঐ এলাকার আশেপাশে ফ্ল্যাট খুঁজলে আপনার বিজ্ঞাপনটি দেখতে পারবে ।';
		
	}
	else if($content == 'new-room'){
		
		$description = 'আপনার বিজ্ঞাপনটি সফলভাবে প্রকাশিত হয়েছে । এখন থেকে যে কেউ ঐ এলাকার আশেপাশে রুম খুঁজলে আপনার বিজ্ঞাপনটি দেখতে পারবে ।';
		
	}
	else if($content == 'new-mess'){
		
		$description = 'আপনার বিজ্ঞাপনটি সফলভাবে প্রকাশিত হয়েছে । এখন থেকে যে কেউ ঐ এলাকার আশেপাশে মেস খুঁজলে আপনার বিজ্ঞাপনটি দেখতে পারবে ।';
		
	}
	else if($content == 'new-officespace'){
		
		$description = 'আপনার বিজ্ঞাপনটি সফলভাবে প্রকাশিত হয়েছে । এখন থেকে যে কেউ ঐ এলাকার আশেপাশে অফিসের জন্য জায়গা খুঁজলে আপনার বিজ্ঞাপনটি দেখতে পারবে ।';
		
	}
	else if($content == 'new-shop'){
		
		$description = 'আপনার বিজ্ঞাপনটি সফলভাবে প্রকাশিত হয়েছে । এখন থেকে যে কেউ ঐ এলাকার আশেপাশে দোকানের জন্য জায়গা খুঁজলে আপনার বিজ্ঞাপনটি দেখতে পারবে ।';
		
	}
	else{
		
		header('Location:/bn/');
		exit;
		
	}
	
}
else{
	
	header('Location:/bn/');
	exit;
	
}

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
            <a href="mark" class="active">প্রচার</a>
            <a href="profile">প্রোফাইল</a>
            <a href="advertisements">বিজ্ঞাপন</a>
            <button id="lanButton" onClick="location.href='/<?php echo $pathUrl; ?>'">English</button>
        </div>
        
        <div class="topnav-right">
            <a href="profile"><?php echo $displayEmail; ?></a>
            <a href="logout?cbp=successful">লগ আউট</a>
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
            <tr><td><a id="backLink" href="/bn/">হোম এ ফিরে চলুন</a></td></tr>
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