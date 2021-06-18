<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);
$_SESSION['comebackUrl']['mark'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=mark');
	exit;
	
}

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$displayEmail = $_SESSION['displayEmail'];

?>

<!DOCTYPE html>
<html>

<head>
	<title>কী খুঁজি - জায়গা চিহ্নিতকরণ</title>
    <meta charset="utf-8">
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/mark.css">
    
    <script src="js/jquery.js"></script>
	<script src="js/clock.js"></script>
    <script src="js/sidebar.js"></script>
	<script src="js/mark.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGb51N89hoOKbN2E7hrxSzRqAOZVgyi80&libraries=places&callback=initMap" async defer></script>
</head>

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
            <a href="advertisements">বিজ্ঞাপনসমূহ</a>
            <button id="lanButton" onClick="location.href='/<?php echo $pathUrl; ?>'">English</button>
        </div>
        
        <div class="topnav-right">
            <a href="profile"><?php echo $displayEmail; ?></a>
            <a href="logout?cbp=mark">লগ আউট</a>
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
		<table id="everythingInside">
        	<tr>
            	<td id="LeftColumn">
                	<?php
					
					if(isset($_GET['content'])){
						
						?>
                        <div id="sideNav">
                            <div id="siteName">
                                <div id="nameOnly">কী খুঁজি</div>
                            </div>
                            
                            <div id="siteMessage">
                                <div id="siteMessageOnly">ভাড়া বা কেনার জন্য আপনি কী খুঁজছেন?</div>
                            </div>
                        
                            <div id="propertiesClose" onclick="closeNav()">
                                <div id="close"><div id="logoDiv"><img id="propertiesLogo" src="../logo/icons/properties.png"></div><div id="propertiesNameDiv">প্রপার্টি <span id="arrow">&blacktriangle;</span></div></div>
                            </div>
                            
                            <div id="propertiesOpen" onclick="openNav()" style="display:none">
                                <div id="open"><div id="logoDiv"><img id="propertiesLogo" src="../logo/icons/properties.png"></div><div id="propertiesNameDiv">প্রপার্টি <span id="arrow">&blacktriangledown;</span></div></div>
                            </div>
                            
                            <div id="propertiesList">
                              <a href="search?content=flat"><div id="propertiesElement"><div id="elementsName">ফ্ল্যাট</div></div></a>
                              <a href="search?content=room"><div id="propertiesElement"><div id="elementsName">রুম</div></div></a>
                              <a href="search?content=mess"><div id="propertiesElement"><div id="elementsName">মেস</div></div></a>
                              <a href="search?content=officespace"><div id="propertiesElement"><div id="elementsName">অফিস</div></div></a>
                              <a href="search?content=shop"><div id="propertiesElement"><div id="elementsName">দোকান</div></div></a>
                            </div>
                        </div>
                        <?php
						
					}
					
					?>
                </td>
                <td id="middleColumn">
                	<?php
					
					if(isset($_GET['content'])){
						
						$content = $_GET['content'];
						
						if(!(($content=='flat')||($content=='room')||($content=='mess')||($content=='officespace')||($content=='shop'))){
							
							header('Location:mark');
							exit;
							
						}
						
						if($content=='flat'){
							
							$contentBengali = 'ফ্ল্যাট';
							
						}
						else if($content=='room'){
							
							$contentBengali = 'রুম';
							
						}
						else if($content=='mess'){
							
							$contentBengali = 'মেস';
							
						}
						else if($content=='officespace'){
							
							$contentBengali = 'অফিস';
							
						}
						else if($content=='shop'){
							
							$contentBengali = 'দোকান';
							
						}
						
						$urlNextPage = 'new-' . $content . '-info';
						
						if(isset($_GET['key'])){
							
							$rand = $_GET['key'];
							
							$randx = strip_tags($rand);
							$rand = str_replace(' ','',$randx);
							
							if(!preg_match("/^[A-Za-z0-9]+$/",$rand)){
								
								$rand =  md5(uniqid(rand()));
								
							}
							else if(!isset($_SESSION['mark-error'][$rand])){
								
								$rand =  md5(uniqid(rand()));
								
							}
							
						}
						else{
							
							$rand =  md5(uniqid(rand()));
							
						}
						
						$urlNextPage = $urlNextPage . '?key=' . $rand;
						
						if(isset($_GET['er'])){
							
							if(($_GET['er'] == 'lat') || ($_GET['er'] == 'lon')){
								
								$error_message = 'ভুল অক্ষাংশ ও দ্রাঘিমাংশ । দয়া করে আবার খুঁজুন ।';
								
							}
							
						}
						
						?>
						<input type="hidden" name="preLat" id="preLat" value="<?php if(isset($_SESSION['mark'][$rand]['latitude'])){ echo $_SESSION['mark'][$rand]['latitude']; }else{ echo '23.810332'; } ?>">
						<input type="hidden" name="preLong" id="preLong" value="<?php if(isset($_SESSION['mark'][$rand]['longitude'])){ echo $_SESSION['mark'][$rand]['longitude']; }else{ echo '90.41251809999994'; } ?>">
						
						<table id="searchPlace">
							<?php
							
							if(isset($error_message)){
								
								?>
								<tr id="errorRow"><td colspan="2"><?php echo $error_message; ?></td></tr>
								<?php
								
							}
							
							?>
							<tr id="searchPlaceHeading"><td colspan="2"><?php
								
								if($content=='flat' || $content=='room'){
									
									echo $contentBengali . 'টি যে বাড়িতে আছে, তার';
									
								}
								else if($content=='officespace'){
									
									echo 'অফিসটি যে দালানে অবস্থিত, তার';
									
								}
								else{
									
									echo $contentBengali . 'টির';
								
								}
								
								?> অবস্থান সঠিকভাবে মানচিত্রে চিহ্নিত করুন
								</td>
							</tr>
							<tr id="searchInputRow">
								<td colspan="2"><input id="pac-input" type="text" placeholder="মানচিত্রে খোঁজার জন্য কিছু লিখুন"></td>
							</tr>
							
						</table>
						
						<div id="map"></div>
						
						<form action="" method="post">
							<input type="hidden" name="latitude" id="latitude" value="<?php if(isset($_SESSION['mark'][$rand]['latitude'])){ echo $_SESSION['mark'][$rand]['latitude']; }else{ echo '23.810332'; } ?>">
							<input type="hidden" name="longitude" id="longitude" value="<?php if(isset($_SESSION['mark'][$rand]['longitude'])){ echo $_SESSION['mark'][$rand]['longitude']; }else{ echo '90.41251809999994'; } ?>">
							<table id="position">
							
								<tr id="currentPositionRow">
									<td id="currentPositionName">বর্তমান অবস্থান :</td>
									<td><input type="text" name="current-place" id="current-place" value="<?php if(isset($_SESSION['mark'][$rand]['current-place'])){ echo $_SESSION['mark'][$rand]['current-place']; }else{ echo 'Dhaka, Bangladesh'; } ?>" readonly size="50"></td>
								</tr>
								<tr><td id="submitRow" colspan="2"><input type="submit" name="submit" id="startSearching" value="পরের ধাপ"></td></tr>
							</table>
						</form>
						<?php
						
						if(isset($_POST['submit'])){
							
							$current_place = $_POST['current-place'];
							$_SESSION['mark-error'][$rand]['current-place'] = $current_place;
							
							$latitude = $_POST['latitude'];
							$_SESSION['mark-error'][$rand]['latitude'] = $latitude;
							
							$latitudex = strip_tags($latitude);
							$latitude = str_replace(' ','',$latitudex);
							
							$longitude = $_POST['longitude'];
							$_SESSION['mark-error'][$rand]['longitude'] = $longitude;
							
							$longitudex = strip_tags($longitude);
							$longitude = str_replace(' ','',$longitudex);
							
							if(!preg_match("/^[0-9.-]+$/",$latitude)){
								
								header('Location:mark?er=lat&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if(substr_count($latitude,'.') > 1){
								
								header('Location:mark?er=lat&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if((strlen($latitude) == 1) && ($latitude == '.')){
								
								header('Location:mark?er=lat&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if(substr_count($latitude,'-') > 1){
								
								header('Location:mark?er=lat&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if((strlen($latitude) == 1) && ($latitude == '-')){
								
								header('Location:mark?er=lat&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							
							if(!preg_match("/^[0-9.-]+$/",$longitude)){
								
								header('Location:mark?er=lon&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if(substr_count($longitude,'.') > 1){
								
								header('Location:mark?er=lon&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if((strlen($longitude) == 1) && ($longitude == '.')){
								
								header('Location:mark?er=lon&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if(substr_count($longitude,'-') > 1){
								
								header('Location:mark?er=lon&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if((strlen($longitude) == 1) && ($longitude == '-')){
								
								header('Location:mark?er=lon&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							
							$_SESSION['mark'][$rand]['current-place'] = $current_place;
							$_SESSION['mark'][$rand]['latitude'] = $latitude;
							$_SESSION['mark'][$rand]['longitude'] = $longitude;
							
							header('Location:' . $urlNextPage);
							exit;
							
						}
						
					}
					else{
						
						?>
                        <div id="sideNav" class="sideNaveMainContent">
                            <div id="siteNameMainContent">
                                <div id="nameOnlyMainContent">কী খুঁজি</div>
                            </div>
                            
                            <div id="siteMessageMainContent">
                                <div id="siteMessageOnlyMainContent">ভাড়া বা বিক্রির জন্য আপনি কীসের বিজ্ঞাপন প্রচার করতে চান?</div>
                            </div>
                        
                            <div id="propertiesClose" class="propertiesCloseMainContent" onclick="closeNav()">
                                <div id="close"><div id="logoDiv"><img id="propertiesLogo" src="../logo/icons/propertiesYellow.png"></div><div id="propertiesNameDiv">প্রপার্টি <span id="arrow">&blacktriangle;</span></div></div>
                            </div>
                            
                            <div id="propertiesOpen" class="propertiesOpenMainContent" onclick="openNav()" style="display:none">
                                <div id="open"><div id="logoDiv"><img id="propertiesLogo" src="../logo/icons/propertiesYellow.png"></div><div id="propertiesNameDiv">প্রপার্টি <span id="arrow">&blacktriangledown;</span></div></div>
                            </div>
                            
                            <div id="propertiesList"  class="propertiesListMainContent">
                              <a href="mark?content=flat"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">ফ্ল্যাট<input type="button" id="button_flat" value="?"><span id="sidenote_flat">একটি পুরো ফ্ল্যাট ভাড়া কিংবা বিক্রির বিজ্ঞাপন । আপনি চাইলে একজন সিঙ্গেল ব্যক্তিকে পুরো ফ্ল্যাট ভাড়া নিয়ে থাকার অনুমতি দিতে পারেন । আবার একাধিক সিঙ্গেল ব্যক্তিকেও থাকার অনুমতি দিতে পারেন ।</span></div></div></a>
                              <a href="mark?content=room"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">রুম<input type="button" id="button_room" value="?"><span id="sidenote_room">এটি 'সাবলেট' নামে বহুল পরিচিত । একটি পুরো রুমের বিজ্ঞাপন দিন, যেখানে একটি পরিবার কিংবা একজন সিঙ্গেল ব্যক্তি থাকবেন । আবার একাধিক সিঙ্গেল ব্যক্তি থাকারও অনুমতি দিতে পারেন । যদি একই ফ্ল্যাটের একাধিক রুম ভাড়া নেয়ার উপযুক্ত থাকে, তাহলে সেটা 'অন্যান্য বর্ণনা' তে উল্লেখ করুন ।</span></div></div></a>
                              <a href="mark?content=mess"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">মেস<input type="button" id="button_mess" value="?"><span id="sidenote_mess">একজন সিঙ্গেল ব্যক্তি (পুরুষ কিংবা মহিলা) থাকতে পারবেন এমন জায়গা (সহজ কথায় - মেসের সিট) । এটি তাদের জন্য, যারা একটি পুরো ফ্ল্যাট বা একটি পুরো রুম ভাড়া নিয়ে থাকবেন না ।</span></div></div></a>
                              <a href="mark?content=officespace"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">অফিস</div></div></a>
                              <a href="mark?content=shop"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">দোকান</div></div></a>
                            </div>
                        </div>
						<?php
						
					}
					
					ob_end_flush();
					
					?>
                </td>
                <td id="rightColumn">
                	<div id="searchSpecificDiv">
                    	<button id="searchSpecific" onClick="location.href='search'">নির্দিষ্ট এলাকায় খুঁজুন</button>
                    </div>
                </td>
            </tr>
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