<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Ki Khuji - Search</title>
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
$pathUrl = substr($pathUrl,1);
$_SESSION['comebackUrl']['search'] = $pathUrl;

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

$urlNextPage = 'search-result';

?>
<body onload="startTime()">
	<div class="topnav">
    	<img id="logo" src="logo/logo.png">
        <div class="topnav-left">
        	<a href="/">Ki Khuji</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/">Home</a>
            <a href="search" class="active">Search</a>
            <a href="mark">Advertise</a>
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
        
        <?php
		
		if(isset($_SESSION['id'])){
			
			$id = $_SESSION['id'];
			$email = $_SESSION['email'];
			$displayEmail = $_SESSION['displayEmail'];
			
			?>
            <div class="topnav-right">
                <a href="profile"><?php echo $displayEmail; ?></a>
                <a href="logout?cbp=search">Log Out</a>
            </div>
            <?php
			
		}
		else{
			
			?>
            <div class="topnav-right">
                <a href="login?cbp=search">Log In</a>
                <a href="register?cbp=search">Register</a>
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
                                <div id="nameOnly">Ki Khuji</div>
                            </div>
                            
                            <div id="siteMessage">
                                <div id="siteMessageOnly">What are you searching to rent or buy?</div>
                            </div>
                        
                            <div id="propertiesClose" onclick="closeNav()">
                                <div id="close"><div id="logoDiv"><img id="propertiesLogo" src="logo/icons/properties.png"></div><div id="propertiesNameDiv">Properties <span id="arrow">&blacktriangle;</span></div></div>
                            </div>
                            
                            <div id="propertiesOpen" onclick="openNav()" style="display:none">
                                <div id="open"><div id="logoDiv"><img id="propertiesLogo" src="logo/icons/properties.png"></div><div id="propertiesNameDiv">Properties <span id="arrow">&blacktriangledown;</span></div></div>
                            </div>
                            
                            <div id="propertiesList">
                              <a href="search?content=flat"><div id="propertiesElement"><div id="elementsName">Flat</div></div></a>
                              <a href="search?content=room"><div id="propertiesElement"><div id="elementsName">Room</div></div></a>
                              <a href="search?content=mess"><div id="propertiesElement"><div id="elementsName">Mess</div></div></a>
                              <a href="search?content=officespace"><div id="propertiesElement"><div id="elementsName">Office</div></div></a>
                              <a href="search?content=shop"><div id="propertiesElement"><div id="elementsName">Shop</div></div></a>
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
								
								$error_message = 'Invalid latitude or longitude. Please search again.';
								
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
							<tr id="searchPlaceHeading"><td colspan="2">Choose a location on the map where you want to search nearby</td></tr>
							<tr id="searchInputRow">
								<td colspan="2"><input id="pac-input" type="text" placeholder="Type something to search on the map"></td>
							</tr>
						</table>
						
						<div id="map"></div>
						
						<form action="" method="post">
							<input type="hidden" name="latitude" id="latitude" value="<?php if(isset($_SESSION['search'][$rand]['latitude'])){ echo $_SESSION['search'][$rand]['latitude']; }else{ echo '23.810332'; } ?>">
							<input type="hidden" name="longitude" id="longitude" value="<?php if(isset($_SESSION['search'][$rand]['longitude'])){ echo $_SESSION['search'][$rand]['longitude']; }else{ echo '90.41251809999994'; } ?>">
							<table id="position">
								<tr id="currentPositionRow">
									<td id="currentPositionName">Current position :</td>
									<td><input type="text" name="current-place" id="current-place" value="<?php if(isset($_SESSION['search'][$rand]['current-place'])){ echo $_SESSION['search'][$rand]['current-place']; }else{ echo 'Dhaka, Bangladesh'; } ?>" readonly size="50"></td>
								</tr>
								<tr><td id="submitRow" colspan="2"><input type="submit" name="submit" id="startSearching" value="Start searching"></td></tr>
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
                                <div id="nameOnlyMainContent">Ki Khuji</div>
                            </div>
                            
                            <div id="siteMessageMainContent">
                                <div id="siteMessageOnlyMainContent">What are you searching to rent or buy?</div>
                            </div>
                        
                            <div id="propertiesClose" class="propertiesCloseMainContent" onclick="closeNav()">
                                <div id="close"><div id="logoDiv"><img id="propertiesLogo" src="logo/icons/propertiesYellow.png"></div><div id="propertiesNameDiv">Properties <span id="arrow">&blacktriangle;</span></div></div>
                            </div>
                            
                            <div id="propertiesOpen" class="propertiesOpenMainContent" onclick="openNav()" style="display:none">
                                <div id="open"><div id="logoDiv"><img id="propertiesLogo" src="logo/icons/propertiesYellow.png"></div><div id="propertiesNameDiv">Properties <span id="arrow">&blacktriangledown;</span></div></div>
                            </div>
                            
                            <div id="propertiesList"  class="propertiesListMainContent">
                              <a href="search?content=flat"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">Flat<input type="button" id="button_flat" value="?"><span id="sidenote_flat">Some flats are only for families while some flats are also available for those single people who will stay alone in the flat. Sometimes owners allow more than one single person to stay. To know which options are available - click on the link 'Details' in 'Search Result' page which will appear after you start your search from this page. If the flat is for sale, these restrictions may not apply.</span></div></div></a>
                              <a href="search?content=room"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">Room<input type="button" id="button_room" value="?"><span id="sidenote_room">Another name of this option is 'Sublet'. Some rooms are available for a family or only one single person while some rooms can be available for a group of single people. To know which options are available - click on the link 'Details' in 'Search Result' page which will appear after you start your search from this page.</span></div></div></a>
                              <a href="search?content=mess"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">Mess<input type="button" id="button_mess" value="?"><span id="sidenote_mess">A place in a room for one single person. The room may contain more than one place like this for other single people.</span></div></div></a>
                              <a href="search?content=officespace"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">Office</div></div></a>
                              <a href="search?content=shop"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">Shop</div></div></a>
                            </div>
                        </div>
						<?php
						
					}
					
					ob_end_flush();
					
					?>
                </td>
                <td id="rightColumn">
                	<div id="createNewDiv">
                    	<button id="createNew" onClick="location.href='mark'">Create an advertisement</button>
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
        <td id="bottomContentsSecond">Contact us at <span id="helloEmail">hello@kikhuji.com</span></td>
        <td id="bottomContentsLast"></td></tr>
    </table>
</body>

</html>