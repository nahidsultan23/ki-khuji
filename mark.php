<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);
$_SESSION['comebackUrl']['mark'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=mark');
	exit;
	
}

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$displayEmail = $_SESSION['displayEmail'];

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

?>

<!DOCTYPE html>
<html>

<head>
	<title>Ki Khuji - Mark the Location</title>
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
            <a href="logout?cbp=mark">Log Out</a>
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
							
							header('Location:mark');
							exit;
							
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
								
								$error_message = 'Invalid latitude or longitude. Please try again.';
								
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
							<tr id="searchPlaceHeading"><td colspan="2">Find the exact location of the <?php
								
								if($content=='flat' || $content=='room'){
									
									echo 'house containing the ' . $content;
									
								}
								else if($content=='officespace'){
									
									echo 'building containing the office';
									
								}
								else{
									
									echo $content;
								
								}
								
								?> on the map
								</td>
							</tr>
							<tr id="searchInputRow">
								<td colspan="2"><input id="pac-input" type="text" placeholder="Type something to search on the map"></td>
							</tr>
							
						</table>
						
						<div id="map"></div>
						
						<form action="" method="post">
							<input type="hidden" name="latitude" id="latitude" value="<?php if(isset($_SESSION['mark'][$rand]['latitude'])){ echo $_SESSION['mark'][$rand]['latitude']; }else{ echo '23.810332'; } ?>">
							<input type="hidden" name="longitude" id="longitude" value="<?php if(isset($_SESSION['mark'][$rand]['longitude'])){ echo $_SESSION['mark'][$rand]['longitude']; }else{ echo '90.41251809999994'; } ?>">
							<table id="position">
							
								<tr id="currentPositionRow">
									<td id="currentPositionName">Current position :</td>
									<td><input type="text" name="current-place" id="current-place" value="<?php if(isset($_SESSION['mark'][$rand]['current-place'])){ echo $_SESSION['mark'][$rand]['current-place']; }else{ echo 'Dhaka, Bangladesh'; } ?>" readonly size="50"></td>
								</tr>
								<tr><td id="submitRow" colspan="2"><input type="submit" name="submit" id="startSearching" value="Proceed"></td></tr>
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
                                <div id="nameOnlyMainContent">Ki Khuji</div>
                            </div>
                            
                            <div id="siteMessageMainContent">
                                <div id="siteMessageOnlyMainContent">What are you advertising to rent or sale?</div>
                            </div>
                        
                            <div id="propertiesClose" class="propertiesCloseMainContent" onclick="closeNav()">
                                <div id="close"><div id="logoDiv"><img id="propertiesLogo" src="logo/icons/propertiesYellow.png"></div><div id="propertiesNameDiv">Properties <span id="arrow">&blacktriangle;</span></div></div>
                            </div>
                            
                            <div id="propertiesOpen" class="propertiesOpenMainContent" onclick="openNav()" style="display:none">
                                <div id="open"><div id="logoDiv"><img id="propertiesLogo" src="logo/icons/propertiesYellow.png"></div><div id="propertiesNameDiv">Properties <span id="arrow">&blacktriangledown;</span></div></div>
                            </div>
                            
                            <div id="propertiesList"  class="propertiesListMainContent">
                              <a href="mark?content=flat"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">Flat<input type="button" id="button_flat" value="?"><span id="sidenote_flat">Advertise for a whole apartment to sale or to rent. You can choose to make your flat available for single people who stay alone. You can also allow a group of single people to stay.</span></div></div></a>
                              <a href="mark?content=room"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">Room<input type="button" id="button_room" value="?"><span id="sidenote_room">Another name of this option is 'Sublet'. Advertise for a whole room for families or a single person to stay. You can also allow a group of single people. If more than one room in a flat is available, mention it in 'Other description'.</span></div></div></a>
                              <a href="mark?content=mess"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">Mess<input type="button" id="button_mess" value="?"><span id="sidenote_mess">Advertise for a space for individual single people (male or female) who won't rent or buy a whole flat or a whole room.</span></div></div></a>
                              <a href="mark?content=officespace"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">Office</div></div></a>
                              <a href="mark?content=shop"><div id="propertiesElement" class="propertiesElementMainContent"><div id="elementsName">Shop</div></div></a>
                            </div>
                        </div>
						<?php
						
					}
					
					ob_end_flush();
					
					?>
                </td>
                <td id="rightColumn">
                	<div id="searchSpecificDiv">
                    	<button id="searchSpecific" onClick="location.href='search'">Search in specific area</button>
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