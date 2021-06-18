<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>কী খুঁজি - অনুসন্ধান</title>
    <meta charset="utf-8">
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/search.css">
    
    <script src="js/jquery.js"></script>
	<script src="js/clock.js"></script>
    <script src="js/sidebar.js"></script>
	<script src="js/search.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGb51N89hoOKbN2E7hrxSzRqAOZVgyi80&libraries=places&callback=initMap" async defer></script>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-9774916541464828",
        enable_page_level_ads: true
      });
    </script>
</head>

<?php

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);
$_SESSION['comebackUrl']['search'] = $pathUrl;

$urlNextPage = 'search-result';

?>
<body onload="startTime()">
	<div class="topnav">
    	<img id="logo" src="../logo/logo.png">
        <div class="topnav-left">
        	<a href="/bn/">কী খুঁজি</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/bn/">হোম</a>
            <a href="search" class="active">অনুসন্ধান</a>
            <a href="mark">প্রচার</a>
            <a href="profile">প্রোফাইল</a>
            <a href="advertisements">বিজ্ঞাপনসমূহ</a>
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
                <a href="logout?cbp=search">লগ আউট</a>
            </div>
            <?php
			
		}
		else{
			
			?>
            <div class="topnav-right">
                <a href="login?cbp=search">লগ ইন</a>
                <a href="register?cbp=search">নিবন্ধন</a>
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
							
							header('Location:search');
							exit;
							
						}
						
						$urlNextPage = $urlNextPage . '?content=' . $content;
						
						if(isset($_GET['key'])){
							
							$rand = $_GET['key'];
							
							$randx = strip_tags($rand);
							$rand = str_replace(' ','',$randx);
							
							if(!preg_match("/^[A-Za-z0-9]+$/",$rand)){
								
								$rand =  md5(uniqid(rand()));
								
							}
							else if(!isset($_SESSION['search-error'][$rand])){
								
								$rand =  md5(uniqid(rand()));
								
							}
							
						}
						else{
							
							$rand =  md5(uniqid(rand()));
							
						}
						
						$urlNextPage = $urlNextPage . '&key=' . $rand;
						
						if(isset($_GET['er'])){
							
							if(($_GET['er'] == 'lat') || ($_GET['er'] == 'lon')){
								
								$error_message = 'ভুল অক্ষাংশ ও দ্রাঘিমাংশ । দয়া করে আবার খুঁজুন ।';
								
							}
							
						}
						
						?>
						<input type="hidden" name="preLat" id="preLat" value="<?php if(isset($_SESSION['search'][$rand]['latitude'])){ echo $_SESSION['search'][$rand]['latitude']; }else{ echo '23.810332'; } ?>">
						<input type="hidden" name="preLong" id="preLong" value="<?php if(isset($_SESSION['search'][$rand]['longitude'])){ echo $_SESSION['search'][$rand]['longitude']; }else{ echo '90.41251809999994'; } ?>">
						
						<table id="searchPlace">
							<?php
							
							if(isset($error_message)){
								
								?>
								<tr id="errorRow"><td colspan="2"><?php echo $error_message; ?></td></tr>
								<?php
								
							}
							
							?>
							<tr id="searchPlaceHeading"><td colspan="2">মানচিত্রে একটি জায়গা পছন্দ করুন, যে জায়গার আশেপাশে আপনি অনুসন্ধান করতে চান</td></tr>
							<tr id="searchInputRow">
								<td colspan="2"><input id="pac-input" type="text" placeholder="মানচিত্রে খোঁজার জন্য কিছু লিখুন"></td>
							</tr>
						</table>
						
						<div id="map"></div>
						
						<form action="" method="post">
							<input type="hidden" name="latitude" id="latitude" value="<?php if(isset($_SESSION['search'][$rand]['latitude'])){ echo $_SESSION['search'][$rand]['latitude']; }else{ echo '23.810332'; } ?>">
							<input type="hidden" name="longitude" id="longitude" value="<?php if(isset($_SESSION['search'][$rand]['longitude'])){ echo $_SESSION['search'][$rand]['longitude']; }else{ echo '90.41251809999994'; } ?>">
							<table id="position">
								<tr id="currentPositionRow">
									<td id="currentPositionName">বর্তমান অবস্থান :</td>
									<td><input type="text" name="current-place" id="current-place" value="<?php if(isset($_SESSION['search'][$rand]['current-place'])){ echo $_SESSION['search'][$rand]['current-place']; }else{ echo 'Dhaka, Bangladesh'; } ?>" readonly size="50"></td>
								</tr>
								<tr><td id="submitRow" colspan="2"><input type="submit" name="submit" id="startSearching" value="অনুসন্ধান শুরু করুন"></td></tr>
							</table>
						</form>
						<?php
						
						if(isset($_POST['submit'])){
							
							$current_place = $_POST['current-place'];
							$_SESSION['search-error'][$rand]['current-place'] = $current_place;
							
							$latitude = $_POST['latitude'];
							$_SESSION['search-error'][$rand]['latitude'] = $latitude;
							
							$latitudex = strip_tags($latitude);
							$latitude = str_replace(' ','',$latitudex);
							
							$longitude = $_POST['longitude'];
							$_SESSION['search-error'][$rand]['longitude'] = $longitude;
							
							$longitudex = strip_tags($longitude);
							$longitude = str_replace(' ','',$longitudex);
							
							if(!preg_match("/^[0-9.-]+$/",$latitude)){
								
								header('Location:search?er=lat&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if(substr_count($latitude,'.') > 1){
								
								header('Location:search?er=lat&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if((strlen($latitude) == 1) && ($latitude == '.')){
								
								header('Location:search?er=lat&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if(substr_count($latitude,'-') > 1){
								
								header('Location:search?er=lat&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if((strlen($latitude) == 1) && ($latitude == '-')){
								
								header('Location:search?er=lat&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							
							if(!preg_match("/^[0-9.-]+$/",$longitude)){
								
								header('Location:search?er=lon&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if(substr_count($longitude,'.') > 1){
								
								header('Location:search?er=lon&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if((strlen($longitude) == 1) && ($longitude == '.')){
								
								header('Location:search?er=lon&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if(substr_count($longitude,'-') > 1){
								
								header('Location:search?er=lon&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							else if((strlen($longitude) == 1) && ($longitude == '-')){
								
								header('Location:search?er=lon&content=' . $content . '&key=' . $rand);
								exit;
								
							}
							
							$_SESSION['search'][$rand]['current-place'] = $current_place;
							$_SESSION['search'][$rand]['latitude'] = $latitude;
							$_SESSION['search'][$rand]['longitude'] = $longitude;
							
							if(($latitude == '23.810332') && ($longitude == '90.41251809999994')){
								
								$urlNextPage = $urlNextPage . '&sr=0.1';
								
							}
							else{
								
								$urlNextPage = $urlNextPage . '&sr=0.04';
								
							}
							
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
                                <div id="siteMessageOnlyMainContent">ভাড়া বা কেনার জন্য আপনি কী খুঁজছেন?</div>
                            </div>
                        
                            <div id="propertiesClose" class="propertiesCloseMainContent" onclick="closeNav()">
                                <div id="close"><div id="logoDiv"><img id="propertiesLogo" src="../logo/icons/propertiesYellow.png"></div><div id="propertiesNameDiv">প্রপার্টি <span id="arrow">&blacktriangle;</span></div></div>
                            </div>
                            
                            <div id="propertiesOpen" class="propertiesOpenMainContent" onclick="openNav()" style="display:none">
                                <div id="open"><div id="logoDiv"><img id="propertiesLogo" src="../logo/icons/propertiesYellow.png"></div><div id="propertiesNameDiv">প্রপার্টি <span id="arrow">&blacktriangledown;</span></div></div>
                            </div>
                            
                            <div id="propertiesList"  class="propertiesListMainContent">
                              <a href="search?content=flat"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">ফ্ল্যাট<input type="button" id="button_flat" value="?"><span id="sidenote_flat">কিছু ফ্ল্যাট শুধু পরিবারের জন্য । আবার কিছু ফ্ল্যাট আছে সেসব সিঙ্গেল মানুষের জন্য, যারা পুরো ফ্ল্যাট ভাড়া নিয়ে একাই থাকবেন । মাঝে মাঝে ফ্ল্যাটের মালিক একাধিক সিঙ্গেল ব্যক্তিকেও একটি ফ্ল্যাট ভাড়া নিয়ে থাকার অনুমতি দিয়ে থাকেন । ফ্ল্যাটটি এগুলোর মধ্যে কোন প্রকারের - তা জানতে এই পাতা থেকে অনুসন্ধান শুরু করার পর 'অনুসন্ধানের ফলাফল' নামক যে পাতাটি আসবে, সেখানে 'বিস্তারিত' লিঙ্কটিতে ক্লিক করুন । অবশ্য ফ্ল্যাটটি বিক্রির জন্য হলে এসব নিষেধাজ্ঞা প্রযোজ্য নাও হতে পারে ।</span></div></div></a>
                              <a href="search?content=room"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">রুম<input type="button" id="button_room" value="?"><span id="sidenote_room">এই অপশনটির একটি বিকল্প নাম 'সাবলেট' । কিছু কিছু রুম শুধু পরিবার বা শুধু একজন সিঙ্গেল ব্যক্তির জন্য হয় । আবার কিছু কিছু রুম থাকে একাধিক সিঙ্গেল ব্যক্তির থাকার জন্য । রুমটি এগুলোর মধ্যে কোন প্রকারের - তা জানতে এই পাতা থেকে অনুসন্ধান শুরু করার পর 'অনুসন্ধানের ফলাফল' নামক যে পাতাটি আসবে, সেখানে 'বিস্তারিত' লিঙ্কটিতে ক্লিক করুন ।</span></div></div></a>
                              <a href="search?content=mess"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">মেস<input type="button" id="button_mess" value="?"><span id="sidenote_mess">এই অপশনের পরিপূরক নাম হল 'মেসের একটি সিট' । মূলত এটি হল একটি রুমে একজন সিঙ্গেল ব্যক্তির থাকার জায়গা । ঐ রুমটিতে একাধিক সিঙ্গেল ব্যক্তির থাকার জায়গা থাকতে পারে ।</span></div></div></a>
                              <a href="search?content=officespace"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">অফিস</div></div></a>
                              <a href="search?content=shop"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">দোকান</div></div></a>
                            </div>
                        </div>
						<?php
						
					}
					
					ob_end_flush();
					
					?>
                </td>
                <td id="rightColumn">
                	<div id="createNewDiv">
                    	<button id="createNew" onClick="location.href='mark'">বিজ্ঞাপন তৈরি করুন</button>
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

</html>