<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Search Result</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/search-result.css">
    
    <script src="js/clock.js"></script>
    <script src="js/sidebar.js"></script>

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
$_SESSION['comebackUrl']['search-result'] = $pathUrl;

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

$urlNextPage = 'details';
$urlBackPage = 'search';
$urlThisPage = 'search-result';

if(isset($_GET['content'])){
	
	$content = $_GET['content'];
	
}
else{
	
	$content = '';
	
}

if(!(($content=='flat')||($content=='room')||($content=='mess')||($content=='officespace')||($content=='shop'))){
	
	header('Location:/');
	exit;
	
}

if($content=='flat'){
	
	$searchContent = 'Flat';
	
}
else if($content=='room'){
	
	$searchContent = 'Room';
	
}
else if($content=='mess'){
	
	$searchContent = 'Mess';
	
}
else if($content=='officespace'){
	
	$searchContent = 'Office';
	
}
else if($content=='shop'){
	
	$searchContent = 'Shop';
	
}

$urlNextPage = $urlNextPage . '?content=' . $content;
$urlBackPage = $urlBackPage . '?content=' . $content;
$urlThisPage = $urlThisPage . '?content=' . $content;

if(isset($_GET['key'])){
	
	$rand = $_GET['key'];
	
	$randx = strip_tags($rand);
	$rand = str_replace(' ','',$randx);
	
	if(!preg_match("/^[A-Za-z0-9]+$/",$rand)){
		
		$rand =  '';
		
	}

}
else{
	
	$rand = '';
	
}

if(!isset($_SESSION['search'][$rand])){
		
	header('Location:' . $urlBackPage);
	exit;
	
}

$urlNextPage = $urlNextPage . '&key=' . $rand;
$urlBackPage = $urlBackPage . '&key=' . $rand;
$urlThisPage = $urlThisPage . '&key=' . $rand;

$searchRadius = 0.02;

if(isset($_GET['sr'])){
	
	$matched = 0;
	
	if(($_GET['sr'] == 0.7) || ($_GET['sr'] == 0.8) || ($_GET['sr'] == 0.82) || ($_GET['sr'] == 0.94)){
		
		$matched = 1;
		
	}
	else{
		
		for($l=0; $l<49; $l++){
		
			$mult = 0.02 * ($l + 2);
			
			if($_GET['sr'] == $mult){
				
				$matched = 1;
				break;
				
			}
			
		}
		
	}
	
	if($matched == 1){
		
		$searchRadius = $_GET['sr'];
		
	}
	else if($_GET['sr'] > 1){
		
		$searchRadius = 1;
		
	}
	else if($_GET['sr'] < 0.02){
		
		$searchRadius = 0.02;
		
	}
	
}

$urlNextPage = $urlNextPage . '&sr=' . $searchRadius;
$urlThisPage = $urlThisPage . '&sr=' . $searchRadius;

$type = 'All';
$typeShort = '';

if(isset($_GET['type'])){
	
	if($_GET['type'] == 'rt'){
		
		$type = 'Rent';
		$typeShort = 'rt';
		
	}
	else if($_GET['type'] == 'sl'){
		
		$type = 'Sale';
		$typeShort = 'sl';
		
	}
	
}

$urlNextPage = $urlNextPage . '&type=' . $typeShort;

$accoTypeChoicePartLink = '';

$maleCheckbox = 1;
$femaleCheckbox = 1;
$familyCheckbox = 1;

if((isset($_GET['male'])) || (isset($_GET['female'])) || (isset($_GET['family']))){
	
	if(!((isset($_GET['male'])) && (isset($_GET['female'])) && (isset($_GET['family'])))){
		
		if((isset($_GET['male'])) && (isset($_GET['female']))){
			
			$urlNextPage = $urlNextPage . '&male=1&female=1';
			$urlThisPage = $urlThisPage . '&type=rt&male=1&female=1';
			$accoTypeChoicePartLink = '&type=rt&male=1&female=1';
			$availableForDatabaseQuery = '&& (male=1 || female=1)';
			$familyCheckbox = 0;
			
		}
		else if((isset($_GET['male'])) && (isset($_GET['family']))){
			
			if($content == 'mess'){
				
				$urlNextPage = $urlNextPage . '&male=1';
				$urlThisPage = $urlThisPage . '&type=rt&male=1';
				$accoTypeChoicePartLink = '&type=rt&male=1';
				$availableForDatabaseQuery = '&& male=1';
				
			}
			else{
				
				$urlNextPage = $urlNextPage . '&male=1&family=1';
				$urlThisPage = $urlThisPage . '&type=rt&male=1&family=1';
				$accoTypeChoicePartLink = '&type=rt&male=1&family=1';
				$availableForDatabaseQuery = '&& (male=1 || family=1)';
				
			}
			
			$femaleCheckbox = 0;
			
		}
		else if((isset($_GET['female'])) && (isset($_GET['family']))){
			
			if($content == 'mess'){
				
				$urlNextPage = $urlNextPage . '&female=1';
				$urlThisPage = $urlThisPage . '&type=rt&female=1';
				$accoTypeChoicePartLink = '&type=rt&female=1';
				$availableForDatabaseQuery = '&& female=1';
				
			}
			else{
				
				$urlNextPage = $urlNextPage . '&female=1&family=1';
				$urlThisPage = $urlThisPage . '&type=rt&female=1&family=1';
				$accoTypeChoicePartLink = '&type=rt&female=1&family=1';
				$availableForDatabaseQuery = '&& (female=1 || family=1)';
				
			}
			
			$maleCheckbox = 0;
			
		}
		else if(isset($_GET['male'])){
			
			$urlNextPage = $urlNextPage . '&male=1';
			$urlThisPage = $urlThisPage . '&type=rt&male=1';
			$accoTypeChoicePartLink = '&type=rt&male=1';
			$availableForDatabaseQuery = '&& male=1';
			$femaleCheckbox = 0;
			$familyCheckbox = 0;
			
		}
		else if(isset($_GET['female'])){
			
			$urlNextPage = $urlNextPage . '&female=1';
			$urlThisPage = $urlThisPage . '&type=rt&female=1';
			$accoTypeChoicePartLink = '&type=rt&female=1';
			$availableForDatabaseQuery = '&& female=1';
			$maleCheckbox = 0;
			$familyCheckbox = 0;
			
		}
		else if(($content != 'mess') && (isset($_GET['family']))){
			
			$urlNextPage = $urlNextPage . '&family=1';
			$urlThisPage = $urlThisPage . '&type=rt&family=1';
			$accoTypeChoicePartLink = '&type=rt&family=1';
			$availableForDatabaseQuery = '&& family=1';
			$maleCheckbox = 0;
			$femaleCheckbox = 0;
			
		}
		
	}
	else{
		
		$urlThisPage = $urlThisPage . '&type=rt';
		
	}
	
}
else{
	
	$urlThisPage = $urlThisPage . '&type=' . $typeShort;
	
}

$current_place = $_SESSION['search'][$rand]['current-place'];
$latitude = $_SESSION['search'][$rand]['latitude'];
$longitude = $_SESSION['search'][$rand]['longitude'];

if(!file_exists('db/db.php')){
	
	session_destroy();
	
	header('Location:error-db');
	exit;
	
}

$_SESSION['db'] = 1;
include('db/db.php');
$_SESSION['db'] = NULL;

if($type == 'All'){
	
	$query = "SELECT id,latitude,longitude,rent,sale,flat,room,timestamp,publish FROM info WHERE ($content='1' && publish='1')";
	$result = mysqli_query($dbc,$query);
	
}
else if($type == 'Rent'){
	
	if(($content == 'flat') || ($content == 'room') || ($content == 'mess')){
		
		if(isset($availableForDatabaseQuery)){
			
			$query = "SELECT id,latitude,longitude,rent,sale,flat,room,timestamp,publish FROM info WHERE (rent='1' && $content='1' " . $availableForDatabaseQuery . " && publish='1')";
			$result = mysqli_query($dbc,$query);
			
		}
		else{
			
			$query = "SELECT id,latitude,longitude,rent,sale,flat,room,timestamp,publish FROM info WHERE (rent='1' && $content='1' && publish='1')";
			$result = mysqli_query($dbc,$query);
			
		}
		
	}
	else{
		
		$query = "SELECT id,latitude,longitude,rent,sale,flat,room,timestamp,publish FROM info WHERE (rent='1' && $content='1' && publish='1')";
		$result = mysqli_query($dbc,$query);
		
	}
	
}
else if($type == 'Sale'){
	
	$query = "SELECT id,latitude,longitude,rent,sale,flat,room,timestamp,publish FROM info WHERE (sale='1' && $content='1' && publish='1')";
	$result = mysqli_query($dbc,$query);
	
}

$numAdEachPage = 10;

function distance($lat1, $lon1, $lat2, $lon2){
	
	if(($lat1 == $lat2) && ($lon1 == $lon2)){
		
		return 0;
		
	}
	else{
		
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		return $dist;
		
	}
	
}

$i = 0;

while($row = mysqli_fetch_array($result)){
	
	if($content == 'mess'){
		
		$flat = $row['flat'];
		$room = $row['room'];
		
		if(($flat == 1) || ($room == 1)){
			
			continue;
			
		}
		
	}
	
	$adID = $row['id'];
	$adLatitude = $row['latitude'];
	$adLongitude = $row['longitude'];
	$timestamp = $row['timestamp'];
	
	if(($adLatitude == '') || ($adLongitude == '')){
		
		continue;
		
	}
	
	$difference = distance($latitude, $longitude, $adLatitude, $adLongitude);
	
	if($difference <= $searchRadius){
		
		$resultArray[$i][0] = $timestamp;
		$resultArray[$i][1] = $difference;
		$resultArray[$i][2] = $adID;
		
		$i++;
		
	}
	
}

$count = $i;

function sortByDifference($a, $b){
	
    $compare = $a[1] - $b[1];
	
	if($compare < 0){
		
		return -1;
		
	}
	else{
		
		return 1;
		
	}
	
	return 1;
	
}

if(isset($resultArray)){
	
	usort($resultArray, 'sortByDifference');
	
}

$numOfPage = floor($count/$numAdEachPage);

$extraPage = 0;

if(($count%$numAdEachPage) > 0){
	
	$extraPage = 1;
	
}

$totalPage = $numOfPage + $extraPage;

if($totalPage == 0){
	
	$totalPage = 1;
	
}

$pageNum = 1;

if(isset($_GET['page'])){
	
	if(preg_match("/^[0-9]+$/",$_GET['page'])){
		
		$pageNum = $_GET['page'];
		
	}
	
}

if($pageNum > $totalPage){
	
	$pageNum = $totalPage;
	
	header('Location:search-result?content=' . $content . '&type=' . $typeShort . '&page=' . $pageNum . '&sr=' . $searchRadius .'&key=' . $rand . $accoTypeChoicePartLink);
	exit;
	
}
else if($pageNum < 1){
	
	$pageNum = 1;
	
	header('Location:search-result?content=' . $content . '&type=' . $typeShort . '&page=1&sr=' . $searchRadius . '&key=' . $rand . $accoTypeChoicePartLink);
	exit;
	
}

$urlNextPage = $urlNextPage . '&pg=' . $pageNum . '&frm=srcrlt';

$totalResultNumber = $count;
$firstResultNumber = ($pageNum - 1) * $numAdEachPage + 1;
$lastResultNumber = $firstResultNumber + $numAdEachPage - 1;

if($firstResultNumber>$count){
	
	$firstResultNumber = $count;
	
}

if($lastResultNumber>$count){
	
	$lastResultNumber = $count;
	
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
                <a href="logout?cbp=search-result">Log Out</a>
            </div>
            <?php
			
		}
		else{
			
			?>
            <div class="topnav-right">
                <a href="login?cbp=search-result">Log In</a>
                <a href="register?cbp=search-result">Register</a>
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
                          <a href="search-result?content=flat&type=<?php echo $typeShort; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand; ?>"><div id="propertiesElement"><div id="elementsName">Flat</div></div></a>
                          <a href="search-result?content=room&type=<?php echo $typeShort; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand; ?>"><div id="propertiesElement"><div id="elementsName">Room</div></div></a>
                          <a href="search-result?content=mess&type=<?php echo $typeShort; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand; ?>"><div id="propertiesElement"><div id="elementsName">Mess</div></div></a>
                          <a href="search-result?content=officespace&type=<?php echo $typeShort; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand; ?>"><div id="propertiesElement"><div id="elementsName">Office</div></div></a>
                          <a href="search-result?content=shop&type=<?php echo $typeShort; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand; ?>"><div id="propertiesElement"><div id="elementsName">Shop</div></div></a>
                        </div>
                    </div>
                </td>
                <td id="middleColumn">
                    <table id="InfoAndPhoto">
                        <tr id="headingRow"><td colspan="3">Search Result for <?php echo $searchContent; ?></td></tr>
                        <tr id="currentPlaceRow"><td colspan="3"><div id="currentPlaceDiv"><?php echo $current_place; ?></div><div id="changePlaceDiv"><a id="changePlaceLink" href="<?php echo $urlBackPage; ?>">Change</a></div></td></tr>
                        <tr id="searchRadiusRow">
                        	<td colspan="3">
                            	<span id="searchRadius">Search radius <?php echo $searchRadius; ?></span>
                                <?php
								
								if($searchRadius != '0.02'){
									
									?>
									<a id="decrease" href="search-result?content=<?php echo $content; ?>&type=<?php echo $typeShort; ?>&page=<?php echo $pageNum; ?>&sr=<?php echo ($searchRadius - 0.02); ?>&key=<?php echo $rand . $accoTypeChoicePartLink; ?>">Decrease</a>
									<?php
									
								}
								if($searchRadius != '1'){
									
									?>
									<a id="increase" href="search-result?content=<?php echo $content; ?>&type=<?php echo $typeShort; ?>&page=<?php echo $pageNum; ?>&sr=<?php echo ($searchRadius + 0.02); ?>&key=<?php echo $rand . $accoTypeChoicePartLink; ?>">Increase</a>
									<?php
									
								}
								
								?>
                            </td>
                        </tr>
                        <?php
						
						if(($content == 'flat') || ($content == 'room') || ($content == 'mess')){
							
							if(($type == 'All') || ($type == 'Rent')){
								
								$nextMaleCheckboxLink = $urlThisPage;
								$nextFemaleCheckboxLink = $urlThisPage;
								$nextFamilyCheckboxLink = $urlThisPage;
								
								if($type == 'All'){
									
									$nextMaleCheckboxLink = str_replace('&type=','&type=rt',$nextMaleCheckboxLink);
									$nextFemaleCheckboxLink = str_replace('&type=','&type=rt',$nextFemaleCheckboxLink);
									$nextFamilyCheckboxLink = str_replace('&type=','&type=rt',$nextFamilyCheckboxLink);
									
								}
								
								if(strpos($urlThisPage, '&male=1') || strpos($urlThisPage, '&female=1') || strpos($urlThisPage, '&family=1')){
									
									if(strpos($urlThisPage, '&male=1')){
										
										$nextMaleCheckboxLink = str_replace('&male=1','',$nextMaleCheckboxLink);
										
									}
									else{
										
										$nextMaleCheckboxLink = $nextMaleCheckboxLink . '&male=1';
										
									}
									
									if(strpos($urlThisPage, '&female=1')){
										
										$nextFemaleCheckboxLink = str_replace('&female=1','',$nextFemaleCheckboxLink);
										
									}
									else{
										
										$nextFemaleCheckboxLink = $nextFemaleCheckboxLink . '&female=1';
										
									}
									
									if(strpos($urlThisPage, '&family=1')){
										
										$nextFamilyCheckboxLink = str_replace('&family=1','',$nextFamilyCheckboxLink);
										
									}
									else{
										
										$nextFamilyCheckboxLink = $nextFamilyCheckboxLink . '&family=1';
										
									}
									
								}
								else{
									
									$nextMaleCheckboxLink = $nextMaleCheckboxLink . '&female=1&family=1';
									$nextFemaleCheckboxLink = $nextFemaleCheckboxLink . '&male=1&family=1';
									$nextFamilyCheckboxLink = $nextFamilyCheckboxLink . '&male=1&female=1';
									
								}
								
								?>
                                <tr id="availableForRow">
                                    <td colspan="3">
                                    	<a id="accoTypeChoiceLink" href="<?php echo $nextMaleCheckboxLink; ?>"><input id="accoTypeChoice" type="checkbox" <?php if($maleCheckbox == 1){ echo 'checked'; } ?> onchange="location.href='<?php echo $nextMaleCheckboxLink; ?>'"><img id="accoTypeiconsChoiceMale" src="logo/icons/male.png"></a>
                                        <a id="accoTypeChoiceLink" href="<?php echo $nextFemaleCheckboxLink; ?>"><input id="accoTypeChoice" type="checkbox" <?php if($femaleCheckbox == 1){ echo 'checked'; } ?> onchange="location.href='<?php echo $nextFemaleCheckboxLink; ?>'"><img id="accoTypeiconsChoiceFemale" src="logo/icons/female.png"></a>
                                        <?php
										
										if(!($content == 'mess')){
											
											?>
                                            <a id="accoTypeChoiceLink" href="<?php echo $nextFamilyCheckboxLink; ?>"><input id="accoTypeChoice" type="checkbox" <?php if($familyCheckbox == 1){ echo 'checked'; } ?> onchange="location.href='<?php echo $nextFamilyCheckboxLink; ?>'"><img id="accoTypeiconsChoiceFamily" src="logo/icons/family.png"></a>
                                            <?php
											
										}
										
										?>
                                    </td>
                                </tr>
                                <?php
								
							}
							
						}
						
						?>
                        <tr id="showingResultRow"><td colspan="3"><div id="showingResult">Showing results <?php echo $firstResultNumber . '-' . $lastResultNumber ?> out of <?php echo $totalResultNumber ?></div><div id="typeDiv"><a id="typeAllLink" <?php if($type == 'All'){ ?>class="activeTypeAll"<?php } ?> href="search-result?content=<?php echo $content; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand; ?>">All</a> <a id="typeRentLink" <?php if($type == 'Rent'){ ?>class="activeTypeRent"<?php } ?> href="search-result?content=<?php echo $content; ?>&type=rt&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand; ?>">Rent</a> <a id="typeSaleLink" <?php if($type == 'Sale'){ ?>class="activeTypeSale"<?php } ?> href="search-result?content=<?php echo $content; ?>&type=sl&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand; ?>">Sale</a></div></td></tr>
                        <tr id="blankRowTop"><td colspan="3"></td></tr>
                        <?php
						
						if($count == 0){
							
							?>
							<tr>
                            	<td colspan="3">
                                	<div id="InfoAndPhotoContainerNothing">
                                    	<div id="nothingDiv">
                                        	Sorry! We could not find any result that matches your criteria.
											<?php
											
                                            if($searchRadius != '1'){ 
                                            
                                                ?>
                                                You may try again by increasing search radius.
                                                <div id="currentRadius"><span id="searchRadiusInContainer">Current search radius <?php echo $searchRadius; ?></span>
                                                <?php
                                                
                                                if($searchRadius != '0.02'){
                                                    
                                                    ?>
                                                    <a id="decrease" href="search-result?content=<?php echo $content; ?>&type=<?php echo $typeShort; ?>&page=<?php echo $pageNum; ?>&sr=<?php echo ($searchRadius - 0.02); ?>&key=<?php echo $rand . $accoTypeChoicePartLink; ?>">Decrease</a>
                                                    <?php
                                                    
                                                }
                                                if($searchRadius != '1'){
                                                    
                                                    ?>
                                                    <a id="increase" href="search-result?content=<?php echo $content; ?>&type=<?php echo $typeShort; ?>&page=<?php echo $pageNum; ?>&sr=<?php echo ($searchRadius + 0.02); ?>&key=<?php echo $rand . $accoTypeChoicePartLink; ?>">Increase</a>
                                                    <?php
                                                    
                                                }
												
												?>
                                                </div>
                                                <?php
                                            
                                            }
                                            
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
							<?php
							
						}
						else{
							
							$j = 0;
							$k = 0;
							
							for($i=0; $i<$count; $i++){
								
								if($k >= $numAdEachPage){
									
									break;
									
								}
								
								$skipNum = ($pageNum - 1) * $numAdEachPage;
								
								if($j < $skipNum){
								
									$j++;
									continue;
									
								}
								
								$adID = $resultArray[$i][2];
								$distance = $resultArray[$i][1] * 60 * 1.1515 * 1.609344;
								$distance = round($distance, 2);
								
								$query = "SELECT id,user_id,latitude,longitude,rent,sale,flat,room,mess,officespace,shop,available_from,male,female,family,rental_price ,full_address,size_of_flat,size_of_room,number_of_rooms,number_of_washrooms,number_of_balconies,date,time,timestamp,publish,randomkey FROM info WHERE id='$adID'";
								$result = mysqli_query($dbc,$query);
								$row = mysqli_fetch_array($result);
								
								$adID = $row['id'];
								
								$rent = $row['rent'];
								$sale = $row['sale'];
								
								if($rent == 1){
									
									$for = 'rent';
									
								}
								else if($sale == 1){
									
									$for = 'sale';
									
								}
								
								$flat = $row['flat'];
								$room = $row['room'];
								$mess = $row['mess'];
								$officespace = $row['officespace'];
								$shop = $row['shop'];
								
								$available_from = $row['available_from'];
								$screenAvailableFrom = date('d F, Y',strtotime($available_from));
								
								$male = $row['male'];
								$female = $row['female'];
								$family = $row['family'];
								$rental_price = $row['rental_price'];
								
								if(strlen($rental_price) > 0){
									
									if(strlen($rental_price) < 13){
										
										$rental_price = number_format($rental_price);
										
									}
									else{
										
										$rental_price = '999,999,999,999+';
										
									}
									
								}
								
								$fullAddress = $row['full_address'];
								$fullAddress = str_replace('*^*',' ',$fullAddress);
								
								if($fullAddress == ''){
									
									$fullAddress = 'No address was provided.';
									
								}
								
								$size_of_flat = $row['size_of_flat'];
								
								if(strlen($size_of_flat) > 0){
									
									if(strlen($size_of_flat) < 8){
										
										$size_of_flat = number_format($size_of_flat);
										
									}
									else{
										
										$size_of_flat = '9,999,999+';
										
									}
									
								}
								
								$size_of_room = $row['size_of_room'];
								
								if(strlen($size_of_room) > 0){
									
									if(strlen($size_of_room) < 8){
										
										$size_of_room = number_format($size_of_room);
										
									}
									else{
										
										$size_of_room = '9,999,999+';
										
									}
									
								}
								
								$number_of_rooms = $row['number_of_rooms'];
								
								if(strlen($number_of_rooms) > 0){
									
									if(strlen($number_of_rooms) > 2){
										
										$number_of_rooms = '99+';
										
									}
									
								}
								
								$number_of_washrooms = $row['number_of_washrooms'];
								
								if(strlen($number_of_washrooms) > 0){
									
									if(strlen($number_of_washrooms) > 2){
										
										$number_of_washrooms = '99+';
										
									}
									
								}
								
								$number_of_balconies = $row['number_of_balconies'];
								
								if(strlen($number_of_balconies) > 0){
									
									if(strlen($number_of_balconies) > 2){
										
										$number_of_balconies = '99+';
										
									}
									
								}
								
								$date = $row['date'];
								$time = $row['time'];
								$dateTime = $date . ' ' . $time;
								$userDateTime = strtotime($dateTime) + $timeDifference;
								
								$screenDate = date('d F, Y',$userDateTime);
								$screenTime = date('H:i:s',$userDateTime);
								$publish = $row['publish'];
								$randomkey = $row['randomkey'];
								
								?>
                                <tr id="infoAndPhotoRow">
                                    <td colspan="3">
                                        <a href="<?php echo $urlNextPage; ?>&ser=<?php echo $adID; ?>">
                                            <div id="InfoAndPhotoContainer">
                                                <div id="infoDiv">
                                                    <div id="accoType">
                                                        <?php
                                                        if($flat == 1){
                                                            
                                                            echo 'Flat';
                                                            
                                                            if($mess == 1){
                                                                
                                                                echo ', Mess';
                                                                
                                                            }
                                                            
                                                        }
                                                        else if($room == 1){
                                                            
                                                            echo 'Room';
                                                            
                                                            if($mess == 1){
                                                                
                                                                echo ', Mess';
                                                                
                                                            }
                                                            
                                                        }
                                                        else if($mess == 1){
                                                            
                                                            echo 'Mess';
                                                            
                                                        }
                                                        else if($officespace == 1){
                                                            
                                                            echo 'Office';
                                                            
                                                        }
                                                        else if($shop == 1){
                                                            
                                                            echo 'Shop';
                                                            
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
													
													if($rent == 1){
														
														?>
                                                        <div id="accoTypeIconsDiv">
															<?php
                                                            
                                                            if($male == 1){
                                                                
                                                                ?>
                                                                <img id="accoTypeiconsMale" src="logo/icons/male.png">
                                                                <?php
                                                                
                                                            }
                                                            
                                                            if($female == 1){
                                                                
                                                                ?>
                                                                <img id="accoTypeiconsFemale" src="logo/icons/female.png">
                                                                <?php
                                                                
                                                            }
                                                            
                                                            if($family == 1){
                                                                
                                                                ?>
                                                                <img id="accoTypeiconsFamily" src="logo/icons/family.png">
                                                                <?php
                                                                
                                                            }
                                                            
                                                            ?>
                                                        </div>
                                                        <?php
														
													}
                                                    
                                                    if($rent == 1){
                                                        
                                                        ?>
                                                        <div id="typeRent">Rent</div>
                                                        <?php
                                                        
                                                    }
                                                    else if($sale == 1){
                                                        
                                                        ?>
                                                        <div id="typeSale">Sale</div>
                                                        <?php
                                                        
                                                    }
                                                    
                                                    if($rental_price != ''){
                                                        
                                                        ?>
                                                        <div id="price">BDT <span id="priceAmount"><?php echo $rental_price; ?></span></div>
                                                        <?php
                                                        
                                                    }
                                                    
                                                    ?>
                                                    <div id="address"><?php echo $fullAddress; ?></div>
                                                    <div id="icons">
                                                        <?php if($number_of_rooms != ''){ ?><img id="roomIcon" src="logo/icons/room.png"><div id="roomIconNumber"><?php echo $number_of_rooms; ?></div><?php } ?>
                                                        <?php if($number_of_washrooms != ''){ ?><img id="bathroomIcon" src="logo/icons/bathroom.png"><div id="bathroomIconNumber"><?php echo $number_of_washrooms; ?></div><?php } ?>
                                                        <?php if($number_of_balconies != ''){ ?><img id="balconyIcon" src="logo/icons/balcony.png"><div id="balconyIconNumber"><?php echo $number_of_balconies; ?></div><?php } ?>
                                                        <?php if($size_of_room != ''){ ?><div id="accoSize"><?php echo $size_of_room; ?> sq.ft.</div><?php }else if($size_of_flat != ''){ ?><div id="accoSize"><?php echo $size_of_flat; ?> sq.ft.</div><?php } ?>
                                                    </div>
                                                    <div id="distance">Distance about <?php echo $distance ?> kms</div>
                                                    <div id="availability">Available from <?php echo $screenAvailableFrom ?></div>
                                                    <div id="posted">Posted on <?php echo $screenDate ?> at <?php echo $screenTime; ?></div>
                                                </div>
                                                <?php
                                                
                                                $photoNames = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                                                    
                                                if(isset($photoNames[0])){
                                                    
                                                    ?>
                                                    <img id="photo" src="<?php echo $photoNames[0]; ?>">
                                                    <?php
                                                    
                                                }
                                                else{
                                                    
                                                    ?>
                                                    <img id="photo" src="logo/noPhoto/no-photo.png">
                                                    <?php
                                                    
                                                }
                                                
                                                ?>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr id="blankRowBottom"><td colspan="3"></td></tr>
                                <?php
								
								$j++;
								$k++;
								
							}
							
							?>
                            <tr id="pageNumberRow">
                                <td colspan="3">
                                    <div id="pageNumContainer">
                                        <?php
                                        
                                        $minPageNum = $pageNum - 2;
                                        $maxPageNum = $pageNum + 2;
                                        
                                        if($minPageNum < 1){
                                            
                                            $maxPageNum = $maxPageNum + (1 - $minPageNum);
                                            $minPageNum = 1;
										
											if($maxPageNum > $totalPage){
												
												$maxPageNum = $totalPage;
												
											}
                                            
                                        }
                                        else if($maxPageNum > $totalPage){
                                            
                                            $minPageNum = $minPageNum - ($maxPageNum - $totalPage);
                                            $maxPageNum = $totalPage;
										
											if($minPageNum < 1){
												
												$minPageNum = 1;
												
											}
                                            
                                        }
                                        
                                        if($minPageNum > 6){
                                            
                                            ?>
                                            <button id="page" onClick="location.href='search-result?content=<?php echo $content; ?>&type=<?php echo $typeShort; ?>&page=1&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand . $accoTypeChoicePartLink; ?>'">&laquo;</button>
                                            <?php
                                            
                                        }
                                        
                                        if($minPageNum > 1){
                                            
                                            ?>
                                            <button id="page" onClick="location.href='search-result?content=<?php echo $content; ?>&type=<?php echo $typeShort; ?>&page=<?php echo $minPageNum-3; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand . $accoTypeChoicePartLink; ?>'">&lsaquo;</button>
                                            <?php
                                            
                                        }
                                        
                                        for($k = $minPageNum; $k <= $maxPageNum; $k++){
                                        
                                            ?>
                                            <button id="page" <?php if($pageNum == $k){ ?>class="activePage"<?php } ?> onClick="location.href='search-result?content=<?php echo $content; ?>&type=<?php echo $typeShort; ?>&page=<?php echo $k; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand . $accoTypeChoicePartLink; ?>'"><?php echo $k; ?></button>
                                            <?php
                                            
                                        }
                                        
                                        if($maxPageNum < $totalPage){
                                            
                                            ?>
                                            <button id="page" onClick="location.href='search-result?content=<?php echo $content; ?>&type=<?php echo $typeShort; ?>&page=<?php echo $maxPageNum+3; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand . $accoTypeChoicePartLink; ?>'">&rsaquo;</button>
                                            <?php
                                            
                                        }
                                            
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr id="preNextRow">
                                <td id="prePageColumn">
                                	<?php
									
									if($pageNum > 1){
										
										?>
                                        <button id="previous" onClick="location.href='search-result?content=<?php echo $content; ?>&type=<?php echo $typeShort; ?>&page=<?php echo $pageNum-1; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand . $accoTypeChoicePartLink; ?>'">Previous page</button>
                                        <?php
										
									}
									
									?>
                                </td>
                                <td id="middlePreNextPageColumn"></td>
                                <td id="nextPageColumn">
                                	<?php
									
									if($pageNum < $totalPage){
										
										?>
                                        <button id="next" onClick="location.href='search-result?content=<?php echo $content; ?>&type=<?php echo $typeShort; ?>&page=<?php echo $pageNum+1; ?>&sr=<?php echo $searchRadius; ?>&key=<?php echo $rand . $accoTypeChoicePartLink; ?>'">Next page</button>
                                        <?php
										
									}
									
									?>
                                </td>
                            </tr>
                            <?php
							
						}
						
						ob_end_flush();
						
						?>
					</table>
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