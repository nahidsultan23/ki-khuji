<?php

if(!isset($_SESSION)){
	
	session_start();
	
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Details</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/details.css">
    
    <script src="js/clock.js"></script>
    <script src="js/details.js"></script>

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
$_SESSION['comebackUrl']['details'] = $pathUrl;

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

$from = '/';

if(isset($_GET['frm'])){
	
	if($_GET['frm'] == 'adv'){
		
		$from = 'advertisements';
		
	}
	else if($_GET['frm'] == 'srcrlt'){
		
		$from = 'search-result';
		
	}
	
}

$urlBackPage = $from;

$pageNum = 1;

if(isset($_GET['pg'])){
	
	if(preg_match("/^[0-9]+$/",$_GET['pg'])){
		
		$pageNum = $_GET['pg'];
		
	}
	
}

$urlBackPage = $from . '?page=' . $pageNum;
$urlBackPageAdv = $urlBackPage;

if(isset($_GET['content'])){
	
	$content = $_GET['content'];
	
	if(($content=='flat')||($content=='room')||($content=='mess')||($content=='officespace')||($content=='shop')){
		
		$urlBackPage = $urlBackPage . '&content=' . $content;
		
	}
	
}

if(isset($_GET['key'])){
	
	$rand = $_GET['key'];
	
	$randx = strip_tags($rand);
	$rand = str_replace(' ','',$randx);
	
	if(!preg_match("/^[A-Za-z0-9]+$/",$rand)){
		
		$rand =  '';
		
	}
	else if(!isset($_SESSION['search'][$rand])){
		
		$rand =  '';
		
	}
	else{
		
		$urlBackPage = $urlBackPage . '&key=' . $rand;
		
	}
	
}

$searchRadius = 0.02;

if(isset($_GET['sr'])){
	
	$searchRadius = $_GET['sr'];
	
}

$urlBackPage = $urlBackPage . '&sr=' . $searchRadius;

$typeShort = '';

if(isset($_GET['type'])){
	
	if($_GET['type'] == 'rt'){
		
		$typeShort = 'rt';
		
	}
	else if($_GET['type'] == 'sl'){
		
		$typeShort = 'sl';
		
	}
	
}

$urlBackPage = $urlBackPage . '&type=' . $typeShort;

if(isset($_GET['ser'])){
	
	if(($_GET['ser'] != 0) && (preg_match("/^[0-9]+$/",$_GET['ser']))){
		
		$adID = $_GET['ser'];
		
	}
	
}

if($from == '/'){
	
	$urlBackPage = $urlBackPageAdv;
	
}
else if($from == 'advertisements'){
	
	$urlBackPage = $urlBackPageAdv;
	
}

if(!isset($adID)){
	
	header('Location:' . $urlBackPage);
	exit;
	
}

if(!file_exists('db/db.php')){
	
	session_destroy();
	
	header('Location:error-db');
	exit;
	
}

$_SESSION['db'] = 1;
include('db/db.php');
$_SESSION['db'] = NULL;

$query = "SELECT * FROM info WHERE id='$adID'";
$result = mysqli_query($dbc,$query);
$count = mysqli_num_rows($result);

if($count){
	
	$row = mysqli_fetch_array($result);
	$latitude = $row['latitude'];
	$longitude = $row['longitude'];
	$rent = $row['rent'];
	$sale = $row['sale'];
	$flat =  $row['flat'];
	$room = $row['room'];
	$mess = $row['mess'];
	$officespace = $row['officespace'];
	$shop = $row['shop'];
	
	$available_from = $row['available_from'];
	$screenAvailableFrom = date('d F, Y',strtotime($available_from));
	
	$male = $row['male'];
	$female = $row['female'];
	$family = $row['family'];
	
	$max_people = $row['max_people'];
	
	if($max_people != ''){
		
		if(strlen($max_people) > 3){
			
			$max_people_original = $max_people;
			$max_people = '999+';
			
		}
		
	}
	
	$rental_price = $row['rental_price'];
	$rental_price_nego = $row['rental_price_nego'];
	
	if($rental_price != ''){
		
		if(strlen($rental_price) > 12){
			
			$rental_price_original = number_format($rental_price);
			$rental_price = '999,999,999,999+';
			
		}
		else{
			
			$rental_price = number_format($rental_price);
			
		}
		
		if($rental_price_nego == 1){
			
			$rental_price = $rental_price . ' BDT (Negotiable)';
			
			if(isset($rental_price_original)){
				
				$rental_price_original = $rental_price_original . ' BDT (Negotiable)';
				
			}
			
		}
		else{
			
			$rental_price = $rental_price . ' BDT (Fixed)';
			
			if(isset($rental_price_original)){
				
				$rental_price_original = $rental_price_original . ' BDT (Fixed)';
				
			}
			
		}
		
	}
	
	$security_money = $row['security_money'];
	$security_money_nego = $row['security_money_nego'];
	
	if($security_money != ''){
		
		if(strlen($security_money) > 12){
			
			$security_money_original = number_format($security_money);
			$security_money = '999,999,999,999+';
			
		}
		else{
			
			$security_money = number_format($security_money);
			
		}
		
		if($security_money_nego == 1){
			
			$security_money = $security_money . ' BDT (Negotiable)';
			
			if(isset($security_money_original)){
				
				$security_money_original = $security_money_original . ' BDT (Negotiable)';
				
			}
			
		}
		else{
			
			$security_money = $security_money . ' BDT (Fixed)';
			
			if(isset($security_money_original)){
				
				$security_money_original = $security_money_original . ' BDT (Fixed)';
				
			}
			
		}
		
	}
	
	$full_address = $row['full_address'];
	$full_address = str_replace('*^*',' ',$full_address);
	
	if($full_address != ''){
		
		if(strlen($full_address) > 500){
			
			$full_address_original = $full_address;
			$full_address = substr($full_address, 0, 450) . '....';
			
		}
		
	}
	
	$contact_no = $row['contact_no'];
	
	if($contact_no != ''){
		
		$contact_no_original = $contact_no;
		$contact_no = substr($contact_no, 0, 6) . '....';
		
	}
	
	$contact_email = $row['contact_email'];
	
	if($contact_email != ''){
		
		$contact_email_original = $contact_email;
		$contact_email = substr($contact_email, 0, 4) . '....';
		
	}
	
	$flat_no = $row['flat_no'];
	$flat_no = str_replace('*^*',' ',$flat_no);
	
	if($flat_no != ''){
		
		if(strlen($flat_no) > 10){
			
			$flat_no_original = $flat_no;
			$flat_no = substr($flat_no, 0, 5) . '....';
			
		}
		
	}
	
	$floor = $row['floor'];
	
	if($floor != ''){
		
		if(strlen($floor) > 3){
			
			$floor_original = number_format($floor);
			$floor = '999+';
			
		}
		
	}
	
	$size_of_flat = $row['size_of_flat'];
	
	if($size_of_flat != ''){
		
		if(strlen($size_of_flat) > 12){
			
			$size_of_flat_original = number_format($size_of_flat)  . ' square feet';
			$size_of_flat = '999,999,999,999+ square feet';
			
		}
		else{
			
			$size_of_flat = number_format($size_of_flat)  . ' square feet';
			
		}
		
	}
	
	$size_of_room = $row['size_of_room'];
	
	if($size_of_room != ''){
		
		if(strlen($size_of_room) > 12){
			
			$size_of_room_original = number_format($size_of_room)  . ' square feet';
			$size_of_room = '999,999,999,999+ square feet';
			
		}
		else{
			
			$size_of_room = number_format($size_of_room)  . ' square feet';
			
		}
		
	}
	
	$number_of_rooms = $row['number_of_rooms'];
	
	if($number_of_rooms != ''){
		
		if(strlen($number_of_rooms) > 3){
			
			$number_of_rooms_original = number_format($number_of_rooms);
			$number_of_rooms = '999+';
			
		}
		
	}
	
	$number_of_washrooms = $row['number_of_washrooms'];
	
	if($number_of_washrooms != ''){
		
		if(strlen($number_of_washrooms) > 3){
			
			$number_of_washrooms_original = number_format($number_of_washrooms);
			$number_of_washrooms = '999+';
			
		}
		
	}
	
	$washroom_attached = $row['washroom_attached'];
	
	$number_of_balconies = $row['number_of_balconies'];
	
	if($number_of_balconies != ''){
		
		if(strlen($number_of_balconies) > 3){
			
			$number_of_balconies_original = number_format($number_of_balconies);
			$number_of_balconies = '999+';
			
		}
		
	}
	
	$balcony_attached = $row['balcony_attached'];
	
	$total_floors = $row['total_floors'];
	
	if($total_floors != ''){
		
		if(strlen($total_floors) > 3){
			
			$total_floors_original = number_format($total_floors);
			$total_floors = '999+';
			
		}
		
	}
	
	$lift = $row['lift'];
	$elevator =  $row['elevator'];
	$parking_facility = $row['parking_facility'];
	
	$other_description = $row['other_description'];
	$other_description = str_replace('*^*',' ',$other_description);
	
	$date = $row['date'];
	$time = $row['time'];
	$dateTime = $date . ' ' . $time;
	$userDateTime = strtotime($dateTime) + $timeDifference;
	
	$screenDate = date('d F, Y',$userDateTime);
	$screenTime = date('H:i:s',$userDateTime);
	$publish = $row['publish'];
	$randomkey = $row['randomkey'];
	
}
else{
	
	$publish = 3;
	
}

if($from == '/'){
	
	$activeLink = 'en';
	
}
else if($from == 'search-result'){
	
	$activeLink = 'search';
	
}
else if($from == 'advertisements'){
	
	$activeLink = 'advertisements';
	
}

?>

<body onload="startTime()">
	<div class="topnav">
    	<img id="logo" src="logo/logo.png">
        <div class="topnav-left">
        	<a href="/">Ki Khuji</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/" <?php if($from == '/'){ ?>class="active"<?php } ?>>Home</a>
            <a href="search" <?php if($from == 'search-result'){ ?>class="active"<?php } ?>>Search</a>
            <a href="mark">Advertise</a>
            <a href="profile">Profile</a>
            <a href="advertisements" <?php if($from == 'advertisements'){ ?>class="active"<?php } ?>>Advertisements</a>
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
                <a href="logout?cbp=details&al=<?php echo $activeLink; ?>">Log Out</a>
            </div>
            <?php
			
		}
		else{
			
			?>
            <div class="topnav-right">
                <a href="login?cbp=details&al=<?php echo $activeLink; ?>">Log In</a>
                <a href="register?cbp=details&al=<?php echo $activeLink; ?>">Register</a>
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
                <td id="everythingFirst"></td>
                <td id="everythingMiddle">
                	<?php
					
					if(($publish == 0) || ($publish == 1) || ($publish == 2)){ 
						
						$photoNames = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
						if(isset($photoNames[0])){
						
						?>
						<div id="bigPhotoContainer">
							<img id="bigPhoto" src="<?php echo $photoNames[0]; ?>">
						</div>
                        
                        <div id="previousContainer">
							<?php
                            
                            if(isset($photoNames[1])){
                                
                                ?>
                                <button id="previous" style="display:none"  onclick="preNext('previous')">&laquo; Previous</button>
                                <?php
                                
                            }
                            
                            ?>
                        </div>
                        
                        <div id="nextContainer">
							<?php
                            
                            if(isset($photoNames[1])){
                                
                                ?>
                                <button id="next"  onclick="preNext('next')">Next &raquo;</button>
                                <?php
                                
                            }
                            
                            ?>
                        </div>
						
						<div id="smallPhotoContainer">
							<div id="smallPhoto">
								<img id="photoInside1" src="<?php echo $photoNames[0]; ?>" onClick="showIt(0)">
								<?php
								
								if(isset($photoNames[1])){
									
									?>
									<img id="photoInside2" class="" src="<?php echo $photoNames[1]; ?>" onClick="showIt(1)">
									<?php
									
								}
								if(isset($photoNames[2])){
									
									?>
									<img id="photoInside3" class="" src="<?php echo $photoNames[2]; ?>" onClick="showIt(2)">
									<?php
									
								}
								if(isset($photoNames[3])){
									
									?>
									<img id="photoInside4" class="" src="<?php echo $photoNames[3]; ?>" onClick="showIt(3)">
									<?php
									
								}
								if(isset($photoNames[4])){
									
									?>
									<img id="photoInside5" class="" src="<?php echo $photoNames[4]; ?>" onClick="showIt(4)">
									<?php
									
								}
								
								?>
							</div>
						</div>
						<?php
						
						}
						
						if($flat == 1){
							
							?>
                            <table id="advertisementDetailsTable">
                            	<tr>
                                	<td id="adDetailsTableFirstColumn"></td>
                                    <td id="adDetailsTableSecondColumn"></td>
                                    <td id="adDetailsTableThirdColumn"></td>
                                    <td id="adDetailsTableLastColumn"></td>
                                </tr>
                                <tr id="headingRow">
                                	<td colspan="4">Advertisement Details</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><span id="postedOn">Posted on <?php echo $screenDate; ?> at <?php echo $screenTime; ?></span></td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="adDetailsTableFirstColspan">
                                    	<table id="adDetailsTableLeft">
                                        	<tr>
                                            	<td>Status</td>
                                                <td>
                                                	<?php
													
													if($publish == 1){
														
														echo '<span id="available">Available</span>';
														
													}
													else if($publish == 2){
														
														echo '<span id="notConfirmed">Not confirmed</span>';
														
													}
													else{
														
														echo '<span id="unavailable">Not available</span>';
														
													}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>Accommodation type</td>
                                                <td>
                                                	Flat<?php
														
													if($mess == 1){
														
														echo ', Mess';
														
														?>
														<input type="button" id="button_acotype" value="?"><span id="sidenote_acotype">Whole flat is also available for a group of single people.</span>
														<?php
														
													}
														
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>Advertisement for</td>
                                                <td><?php if($rent == 1){ echo 'Rent'; }else if($sale == 1){ echo 'Sale'; } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Available from</td>
                                                <td><?php echo $screenAvailableFrom ?></td>
                                            </tr>
                                            <?php
											
											if($rent == 1){
												
												?>
                                                <tr>
                                                    <td>Available for</td>
                                                    <td>
                                                    	<?php
															
														if($male == 1){
															
															echo 'Single (Male)';
															
														}
														
														if(($male == 0) && ($female == 1)){
															
															echo 'Single (Female)';
															
														}
														else if(($male == 1) && ($female == 1)){
															
															echo ',<br>Single (Female)';
															
														}
														
														if(($male == 0) && ($female == 0) && ($family == 1)){
															
															echo 'Family';
															
														}
														else if((($male == 1) || ($female == 1)) && ($family == 1)){
															
															echo ',<br>Family';
															
														}
														
														if(($male == 1) || ($female == 1)){
															
															?>
															<input type="button" id="button_single" value="?"><span id="sidenote_single">One single person can also rent the whole flat if he or she chooses to stay alone.</span>
															<?php
															
														}
													
														?>
                                                    </td>
                                                </tr>
                                                <?php
												
											}
											
											?>
                                        </table>
                                    </td>
                                    <td colspan="2" id="adDetailsTableLastColspan">
                                    	<table id="adDetailsTableRight">
                                        	<tr>
                                            	<td>Location</td>
                                                <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">Find on Google Map</a></td>
                                            </tr>
                                            <?php
											
											if($mess == 1){
												
												?>
                                                <tr>
                                                    <td>Maximum number of people (in case of using as a mess)</td>
                                                    <td>
                                                    	<?php
																
														if($max_people != ''){
															
															echo $max_people;
															
															?>
															<input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">Number of people must not exceed this number in case of staying with a group of single people. There can also be less number of people.</span>
															<?php
															
															if(isset($max_people_original)){
																
																?>
                                                                <a id="fullLengthViewLink" onClick="popUp('maxPeopleDiv')">Show</a><div id="maxPeopleDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Maximum number of people: ' . $max_people_original; ?><button id="closeButton" onClick="popDown('maxPeopleDiv')">close</button></div>
                                                                <?php
																
															}
															
														}
															
														?>
                                                    </td>
                                                </tr>
                                                <?php
												
											}
											
											?>
                                            <tr>
                                            	<td>Contact no.</td>
                                                <td><?php echo $contact_no; if(isset($contact_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactNoDiv')">Show</a><div id="contactNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Contact no. ' . $contact_no_original; ?><button id="closeButton" onClick="popDown('contactNoDiv')">close</button></div><?php }?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Email</td>
                                                <td><?php echo $contact_email; if(isset($contact_email_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactEmailDiv')">Show</a><div id="contactEmailDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Email: ' . $contact_email_original; ?><button id="closeButton" onClick="popDown('contactEmailDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="rentalPricePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <?php
								
								if($sale == 1){
									
									?>
									<tr>
										<td><span id="paddingToAlign">Price</span></td>
										<td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">Show</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Price: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">close</button></div><?php } ?></td>
									</tr>
									<tr>
										<td><span id="paddingToAlign">Booking money</span></td>
										<td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">You will need to pay this minimum amount initially to start the procedure of purchasing.</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">Show</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Booking money: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">close</button></div><?php } ?></td>
									</tr>
									<?php
									
								}
								else if($rent == 1){
									
									?>
									<tr>
										<td><span id="paddingToAlign">Rental price per month</span></td>
										<td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">Show</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Rental price per month: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">close</button></div><?php } ?></td>
									</tr>
									<tr>
										<td><span id="paddingToAlign">Security money</span></td>
										<td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">This amount will be taken from you by the owner before you move to the flat and won't be returned until the flat is left.</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">Show</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Security money: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">close</button></div><?php } ?></td>
									</tr>
									<?php
									
								}
								
								?>
                                <tr>
                                	<td><span id="paddingToAlign">Full Address</span></td>
                                    <td colspan="3"><div id="fullAddress"><?php echo $full_address; ?></div><?php if(isset($full_address_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('fullAddressDiv')">Show</a><div id="fullAddressDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Full address: ' . $full_address_original; ?><button id="closeButton" onClick="popDown('fullAddressDiv')">close</button></div><?php } ?></td>
                                </tr>
                            </table>
                            
                            <table id="additionalInfoTable">
                            	<tr>
                                	<td id="addInfoTableFirstColumn"></td>
                                    <td id="addInfoTableSecondColumn"></td>
                                    <td id="addInfoTableThirdColumn"></td>
                                    <td id="addInfoTableLastColumn"></td>
                                </tr>
                                <tr id="additionalHeadingRow">
                                	<td colspan="4">Additional Info</td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="addInfoTableFirstColspan">
                                    	<table id="addInfoTableLeft">
                                        	<tr>
                                            	<td>Flat no.</td>
                                                <td><?php echo $flat_no; if(isset($flat_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatNoDiv')">Show</a><div id="flatNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Flat no. ' . $flat_no_original; ?><button id="closeButton" onClick="popDown('flatNoDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Floor</td>
                                                <td><?php echo $floor; if(isset($floor_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('floorDiv')">Show</a><div id="floorDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Floor: ' . $floor_original; ?><button id="closeButton" onClick="popDown('floorDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Number of rooms</td>
                                                <td><?php echo $number_of_rooms; if(isset($number_of_rooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberRoomsDiv')">Show</a><div id="numberRoomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of rooms: ' . $number_of_rooms_original; ?><button id="closeButton" onClick="popDown('numberRoomsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Number of washrooms</td>
                                                <td><?php echo $number_of_washrooms; if(isset($number_of_washrooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberWashroomsDiv')">Show</a><div id="numberWashroomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of washrooms: ' . $number_of_washrooms_original; ?><button id="closeButton" onClick="popDown('numberWashroomsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="addInfoTableLastColspan">
                                    	<table id="addInfoTableRight">
                                        	<tr>
                                            	<td>Number of balconies</td>
                                                <td><?php echo $number_of_balconies; if(isset($number_of_balconies_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberBalconiesDiv')">Show</a><div id="numberBalconiesDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of balconies: ' . $number_of_balconies_original; ?><button id="closeButton" onClick="popDown('numberBalconiesDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Total number of floors in the house</td>
                                                <td><?php echo $total_floors; if(isset($total_floors_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('totalFloorsDiv')">Show</a><div id="totalFloorsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Total number of floors: ' . $total_floors_original; ?><button id="closeButton" onClick="popDown('totalFloorsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Lift</td>
                                                <td><?php echo $lift; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Parking facility</td>
                                                <td><?php echo $parking_facility; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="flatSizePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Size of the flat</span></td>
                                    <td colspan="3"><?php echo $size_of_flat; if(isset($size_of_flat_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatSizeDiv')">Show</a><div id="flatSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Size of the flat: ' . $size_of_flat_original; ?><button id="closeButton" onClick="popDown('flatSizeDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">Other Description</span></td>
                                    <td colspan="3"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                                </tr>
                                <tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>">Back to <?php if($from == 'search-result'){ echo 'Search Result'; }else if($from == 'advertisements'){ echo 'Advertisements'; }else{ echo 'Home'; } ?></a></td></tr>
                            </table>
                            <?php
							
						}
						else if($room == 1){
							
							?>
                            <table id="advertisementDetailsTable">
                            	<tr>
                                	<td id="adDetailsTableFirstColumn"></td>
                                    <td id="adDetailsTableSecondColumn"></td>
                                    <td id="adDetailsTableThirdColumn"></td>
                                    <td id="adDetailsTableLastColumn"></td>
                                </tr>
                                <tr id="headingRow">
                                	<td colspan="4">Advertisement Details</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><span id="postedOn">Posted on <?php echo $screenDate; ?> at <?php echo $screenTime; ?></span></td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="adDetailsTableFirstColspan">
                                    	<table id="adDetailsTableLeft">
                                        	<tr>
                                            	<td>Status</td>
                                                <td>
                                                	<?php
													
													if($publish == 1){
														
														echo '<span id="available">Available</span>';
														
													}
													else if($publish == 2){
														
														echo '<span id="notConfirmed">Not confirmed</span>';
														
													}
													else{
														
														echo '<span id="unavailable">Not available</span>';
														
													}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>Accommodation type</td>
                                                <td>
                                                	Room<?php
													
														if($mess == 1){
															
															echo ', Mess';
													
															?>
															<input type="button" id="button_acotype" value="?"><span id="sidenote_acotype">Whole room is available for a group of single people.</span>
															<?php
															
														}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>Advertisement for</td>
                                                <td><?php if($rent == 1){ echo 'Rent'; }else if($sale == 1){ echo 'Sale'; } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Available from</td>
                                                <td><?php echo $screenAvailableFrom ?></td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Available for</td>
                                                <td>
                                                    <?php
                                                        
                                                    if($male == 1){
                                                        
                                                        echo 'Single (Male)';
                                                        
                                                    }
                                                    
                                                    if(($male == 0) && ($female == 1)){
                                                        
                                                        echo 'Single (Female)';
                                                        
                                                    }
                                                    else if(($male == 1) && ($female == 1)){
                                                        
                                                        echo ',<br>Single (Female)';
                                                        
                                                    }
                                                    
                                                    if(($male == 0) && ($female == 0) && ($family == 1)){
                                                        
                                                        echo 'Family';
                                                        
                                                    }
                                                    else if((($male == 1) || ($female == 1)) && ($family == 1)){
                                                        
                                                        echo ',<br>Family';
                                                        
                                                    }
                                                    
                                                    if(($male == 1) || ($female == 1)){
                                                        
                                                        ?>
                                                        <input type="button" id="button_single" value="?"><span id="sidenote_single">One single person can also rent the whole room if he or she chooses to stay alone in the room.</span>
                                                        <?php
                                                        
                                                    }
                                                
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="adDetailsTableLastColspan">
                                    	<table id="adDetailsTableRight">
                                        	<tr>
                                            	<td>Location</td>
                                                <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">Find on Google Map</a></td>
                                            </tr>
                                            <?php
											
											if($mess == 1){
												
												?>
                                                <tr>
                                                    <td>Maximum number of people (in case of using as a mess)</td>
                                                    <td>
                                                    	<?php
																
														if($max_people != ''){
															
															echo $max_people;
															
															?>
															<input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">Number of people must not exceed this number in case of staying with a group of single people. Also you can choose to stay with less number of people.</span>
															<?php
															
															if(isset($max_people_original)){
																
																?>
                                                                <a id="fullLengthViewLink" onClick="popUp('maxPeopleDiv')">Show</a><div id="maxPeopleDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Maximum number of people: ' . $max_people_original; ?><button id="closeButton" onClick="popDown('maxPeopleDiv')">close</button></div>
                                                                <?php
																
															}
															
														}
															
														?>
                                                    </td>
                                                </tr>
                                                <?php
												
											}
											
											?>
                                            <tr>
                                            	<td>Contact no.</td>
                                                <td><?php echo $contact_no; if(isset($contact_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactNoDiv')">Show</a><div id="contactNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Contact no. ' . $contact_no_original; ?><button id="closeButton" onClick="popDown('contactNoDiv')">close</button></div><?php }?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Email</td>
                                                <td><?php echo $contact_email; if(isset($contact_email_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactEmailDiv')">Show</a><div id="contactEmailDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Email: ' . $contact_email_original; ?><button id="closeButton" onClick="popDown('contactEmailDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="rentalPricePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Rental price per month</span></td>
                                    <td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">Show</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Rental price per month: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Security money</span></td>
                                    <td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">This amount will be taken from you by the owner or the person who rented the whole flat before you move to the room.</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">Show</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Security money: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">Full Address</span></td>
                                    <td colspan="3"><div id="fullAddress"><?php echo $full_address; ?></div><?php if(isset($full_address_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('fullAddressDiv')">Show</a><div id="fullAddressDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Full address: ' . $full_address_original; ?><button id="closeButton" onClick="popDown('fullAddressDiv')">close</button></div><?php } ?></td>
                                </tr>
                            </table>
                            
                            <table id="additionalInfoTable">
                            	<tr>
                                	<td id="addInfoTableFirstColumn"></td>
                                    <td id="addInfoTableSecondColumn"></td>
                                    <td id="addInfoTableThirdColumn"></td>
                                    <td id="addInfoTableLastColumn"></td>
                                </tr>
                                <tr id="additionalHeadingRow">
                                	<td colspan="4">Additional Info</td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="addInfoTableFirstColspan">
                                    	<table id="addInfoTableLeft">
                                        	<tr>
                                            	<td>Flat no.</td>
                                                <td><?php echo $flat_no; if(isset($flat_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatNoDiv')">Show</a><div id="flatNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Flat no. ' . $flat_no_original; ?><button id="closeButton" onClick="popDown('flatNoDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Floor</td>
                                                <td><?php echo $floor; if(isset($floor_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('floorDiv')">Show</a><div id="floorDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Floor: ' . $floor_original; ?><button id="closeButton" onClick="popDown('floorDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Number of rooms in the flat</td>
                                                <td><?php echo $number_of_rooms; if(isset($number_of_rooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberRoomsDiv')">Show</a><div id="numberRoomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of rooms: ' . $number_of_rooms_original; ?><button id="closeButton" onClick="popDown('numberRoomsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Number of washrooms in the flat</td>
                                                <td><?php echo $number_of_washrooms; if(isset($number_of_washrooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberWashroomsDiv')">Show</a><div id="numberWashroomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of washrooms: ' . $number_of_washrooms_original; ?><button id="closeButton" onClick="popDown('numberWashroomsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Attached washroom</td>
                                                <td><?php echo $washroom_attached; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="addInfoTableLastColspan">
                                    	<table id="addInfoTableRight">
                                            <tr>
                                            	<td>Number of balconies in the flat</td>
                                                <td><?php echo $number_of_balconies; if(isset($number_of_balconies_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberBalconiesDiv')">Show</a><div id="numberBalconiesDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of balconies: ' . $number_of_balconies_original; ?><button id="closeButton" onClick="popDown('numberBalconiesDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                            <tr>
                                            	<td>Attached balcony</td>
                                                <td><?php echo $balcony_attached; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Total number of floors in the house</td>
                                                <td><?php echo $total_floors; if(isset($total_floors_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('totalFloorsDiv')">Show</a><div id="totalFloorsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Total number of floors: ' . $total_floors_original; ?><button id="closeButton" onClick="popDown('totalFloorsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Lift</td>
                                                <td><?php echo $lift; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Parking facility</td>
                                                <td><?php echo $parking_facility; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="flatSizePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Size of the flat</span></td>
                                    <td colspan="3"><?php echo $size_of_flat; if(isset($size_of_flat_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatSizeDiv')">Show</a><div id="flatSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Size of the flat: ' . $size_of_flat_original; ?><button id="closeButton" onClick="popDown('flatSizeDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Size of the room</span></td>
                                    <td colspan="3"><?php echo $size_of_room; if(isset($size_of_room_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('roomSizeDiv')">Show</a><div id="roomSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Size of the room: ' . $size_of_room_original; ?><button id="closeButton" onClick="popDown('roomSizeDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">Other Description</span></td>
                                    <td colspan="3"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                                </tr>
                                <tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>">Back to <?php if($from == 'search-result'){ echo 'Search Result'; }else if($from == 'advertisements'){ echo 'Advertisements'; }else{ echo 'Home'; } ?></a></td></tr>
                            </table>
                            <?php
							
						}
						else if($mess == 1){
							
							?>
                            <table id="advertisementDetailsTable">
                            	<tr>
                                	<td id="adDetailsTableFirstColumn"></td>
                                    <td id="adDetailsTableSecondColumn"></td>
                                    <td id="adDetailsTableThirdColumn"></td>
                                    <td id="adDetailsTableLastColumn"></td>
                                </tr>
                                <tr id="headingRow">
                                	<td colspan="4">Advertisement Details</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><span id="postedOn">Posted on <?php echo $screenDate; ?> at <?php echo $screenTime; ?></span></td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="adDetailsTableFirstColspan">
                                    	<table id="adDetailsTableLeft">
                                        	<tr>
                                            	<td>Status</td>
                                                <td>
                                                	<?php
													
													if($publish == 1){
														
														echo '<span id="available">Available</span>';
														
													}
													else if($publish == 2){
														
														echo '<span id="notConfirmed">Not confirmed</span>';
														
													}
													else{
														
														echo '<span id="unavailable">Not available</span>';
														
													}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>Accommodation type</td>
                                                <td>Mess<input type="button" id="button_acotype" value="?"><span id="sidenote_acotype">A space or the whole room for one single person.</span></td>
                                            </tr>
                                        	<tr>
                                            	<td>Advertisement for</td>
                                                <td><?php if($rent == 1){ echo 'Rent'; }else if($sale == 1){ echo 'Sale'; } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Available from</td>
                                                <td><?php echo $screenAvailableFrom ?></td>
                                            </tr>
                                            <tr>
                                                <td>Available for</td>
                                                <td>
                                                    <?php
                                                        
                                                    if($male == 1){
                                                        
                                                        echo 'Single (Male)';
                                                        
                                                    }
                                                    
                                                    if(($male == 0) && ($female == 1)){
                                                        
                                                        echo 'Single (Female)';
                                                        
                                                    }
                                                    else if(($male == 1) && ($female == 1)){
                                                        
                                                        echo ',<br>Single (Female)';
                                                        
                                                    }
                                                
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="adDetailsTableLastColspan">
                                    	<table id="adDetailsTableRight">
                                        	<tr>
                                            	<td>Location</td>
                                                <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">Find on Google Map</a></td>
                                            </tr>
                                            <tr>
                                                <td>Maximum number of people in the room</td>
                                                <td>
                                                    <?php
                                                            
                                                    if($max_people != ''){
                                                        
                                                        echo $max_people;
                                                        
                                                        ?>
                                                        <input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">Number of people will not exceed this number in the room containing this space. Number of people can also be less if the owner wishes.</span>
                                                        <?php
                                                        
                                                        if(isset($max_people_original)){
                                                            
                                                            ?>
                                                            <a id="fullLengthViewLink" onClick="popUp('maxPeopleDiv')">Show</a><div id="maxPeopleDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Maximum number of people: ' . $max_people_original; ?><button id="closeButton" onClick="popDown('maxPeopleDiv')">close</button></div>
                                                            <?php
                                                            
                                                        }
                                                        
                                                    }
                                                        
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td>Contact no.</td>
                                                <td><?php echo $contact_no; if(isset($contact_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactNoDiv')">Show</a><div id="contactNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Contact no. ' . $contact_no_original; ?><button id="closeButton" onClick="popDown('contactNoDiv')">close</button></div><?php }?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Email</td>
                                                <td><?php echo $contact_email; if(isset($contact_email_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactEmailDiv')">Show</a><div id="contactEmailDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Email: ' . $contact_email_original; ?><button id="closeButton" onClick="popDown('contactEmailDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="rentalPricePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Rental price per month</span></td>
                                    <td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">Show</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Rental price per month: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Security money</span></td>
                                    <td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">This amount will be taken from you by the owner before you move to the mess.</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">Show</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Security money: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">Full Address</span></td>
                                    <td colspan="3"><div id="fullAddress"><?php echo $full_address; ?></div><?php if(isset($full_address_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('fullAddressDiv')">Show</a><div id="fullAddressDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Full address: ' . $full_address_original; ?><button id="closeButton" onClick="popDown('fullAddressDiv')">close</button></div><?php } ?></td>
                                </tr>
                            </table>
                            
                            <table id="additionalInfoTable">
                            	<tr>
                                	<td id="addInfoTableFirstColumn"></td>
                                    <td id="addInfoTableSecondColumn"></td>
                                    <td id="addInfoTableThirdColumn"></td>
                                    <td id="addInfoTableLastColumn"></td>
                                </tr>
                                <tr id="additionalHeadingRow">
                                	<td colspan="4">Additional Info</td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="addInfoTableFirstColspan">
                                    	<table id="addInfoTableLeft">
                                        	<tr>
                                            	<td>Flat no.</td>
                                                <td><?php echo $flat_no; if(isset($flat_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatNoDiv')">Show</a><div id="flatNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Flat no. ' . $flat_no_original; ?><button id="closeButton" onClick="popDown('flatNoDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Floor</td>
                                                <td><?php echo $floor; if(isset($floor_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('floorDiv')">Show</a><div id="floorDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Floor: ' . $floor_original; ?><button id="closeButton" onClick="popDown('floorDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Number of rooms in the flat</td>
                                                <td><?php echo $number_of_rooms; if(isset($number_of_rooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberRoomsDiv')">Show</a><div id="numberRoomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of rooms: ' . $number_of_rooms_original; ?><button id="closeButton" onClick="popDown('numberRoomsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Number of washrooms in the flat</td>
                                                <td><?php echo $number_of_washrooms; if(isset($number_of_washrooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberWashroomsDiv')">Show</a><div id="numberWashroomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of washrooms: ' . $number_of_washrooms_original; ?><button id="closeButton" onClick="popDown('numberWashroomsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Attached washroom</td>
                                                <td><?php echo $washroom_attached; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="addInfoTableLastColspan">
                                    	<table id="addInfoTableRight">
                                            <tr>
                                            	<td>Number of balconies in the flat</td>
                                                <td><?php echo $number_of_balconies; if(isset($number_of_balconies_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberBalconiesDiv')">Show</a><div id="numberBalconiesDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of balconies: ' . $number_of_balconies_original; ?><button id="closeButton" onClick="popDown('numberBalconiesDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                            <tr>
                                            	<td>Attached balcony</td>
                                                <td><?php echo $balcony_attached; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Total number of floors in the house</td>
                                                <td><?php echo $total_floors; if(isset($total_floors_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('totalFloorsDiv')">Show</a><div id="totalFloorsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Total number of floors: ' . $total_floors_original; ?><button id="closeButton" onClick="popDown('totalFloorsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Lift</td>
                                                <td><?php echo $lift; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="flatSizePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Size of the flat</span></td>
                                    <td colspan="3"><?php echo $size_of_flat; if(isset($size_of_flat_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatSizeDiv')">Show</a><div id="flatSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Size of the flat: ' . $size_of_flat_original; ?><button id="closeButton" onClick="popDown('flatSizeDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Size of the room</span></td>
                                    <td colspan="3"><?php echo $size_of_room; if(isset($size_of_room_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('roomSizeDiv')">Show</a><div id="roomSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Size of the room: ' . $size_of_room_original; ?><button id="closeButton" onClick="popDown('roomSizeDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">Other Description</span></td>
                                    <td colspan="3"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                                </tr>
                                <tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>">Back to <?php if($from == 'search-result'){ echo 'Search Result'; }else if($from == 'advertisements'){ echo 'Advertisements'; }else{ echo 'Home'; } ?></a></td></tr>
                            </table>
                            <?php
							
						}
						else if($officespace == 1){
							
							?>
                            <table id="advertisementDetailsTable">
                            	<tr>
                                	<td id="adDetailsTableFirstColumn"></td>
                                    <td id="adDetailsTableSecondColumn"></td>
                                    <td id="adDetailsTableThirdColumn"></td>
                                    <td id="adDetailsTableLastColumn"></td>
                                </tr>
                                <tr id="headingRow">
                                	<td colspan="4">Advertisement Details</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><span id="postedOn">Posted on <?php echo $screenDate; ?> at <?php echo $screenTime; ?></span></td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="adDetailsTableFirstColspan">
                                    	<table id="adDetailsTableLeft">
                                        	<tr>
                                            	<td>Status</td>
                                                <td>
                                                	<?php
													
													if($publish == 1){
														
														echo '<span id="available">Available</span>';
														
													}
													else if($publish == 2){
														
														echo '<span id="notConfirmed">Not confirmed</span>';
														
													}
													else{
														
														echo '<span id="unavailable">Not available</span>';
														
													}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>Accommodation type</td>
                                                <td>Office</td>
                                            </tr>
                                        	<tr>
                                            	<td>Advertisement for</td>
                                                <td><?php if($rent == 1){ echo 'Rent'; }else if($sale == 1){ echo 'Sale'; } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Available from</td>
                                                <td><?php echo $screenAvailableFrom ?></td>
                                            </tr>
                                            
                                        </table>
                                    </td>
                                    <td colspan="2" id="adDetailsTableLastColspan">
                                    	<table id="adDetailsTableRight">
                                        	<tr>
                                            	<td>Location</td>
                                                <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">Find on Google Map</a></td>
                                            </tr>
                                            <tr>
                                            	<td>Contact no.</td>
                                                <td><?php echo $contact_no; if(isset($contact_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactNoDiv')">Show</a><div id="contactNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Contact no. ' . $contact_no_original; ?><button id="closeButton" onClick="popDown('contactNoDiv')">close</button></div><?php }?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Email</td>
                                                <td><?php echo $contact_email; if(isset($contact_email_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactEmailDiv')">Show</a><div id="contactEmailDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Email: ' . $contact_email_original; ?><button id="closeButton" onClick="popDown('contactEmailDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="rentalPricePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <?php
								
								if($sale == 1){
									
									?>
									<tr>
										<td><span id="paddingToAlign">Price</span></td>
										<td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">Show</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Price: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">close</button></div><?php } ?></td>
									</tr>
									<tr>
										<td><span id="paddingToAlign">Booking money</span></td>
										<td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">You will need to pay this minimum amount initially to start the procedure of purchasing.</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">Show</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Booking money: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">close</button></div><?php } ?></td>
									</tr>
									<?php
									
								}
								else if($rent == 1){
									
									?>
									<tr>
										<td><span id="paddingToAlign">Rental price per month</span></td>
										<td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">Show</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Rental price per month: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">close</button></div><?php } ?></td>
									</tr>
									<tr>
										<td><span id="paddingToAlign">Security money</span></td>
										<td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">This amount will be taken from you by the owner before you have the space for your office and won't be returned until the space is left.</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">Show</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Security money: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">close</button></div><?php } ?></td>
									</tr>
									<?php
									
								}
								
								?>
                                <tr>
                                	<td><span id="paddingToAlign">Full Address</span></td>
                                    <td colspan="3"><div id="fullAddress"><?php echo $full_address; ?></div><?php if(isset($full_address_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('fullAddressDiv')">Show</a><div id="fullAddressDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Full address: ' . $full_address_original; ?><button id="closeButton" onClick="popDown('fullAddressDiv')">close</button></div><?php } ?></td>
                                </tr>
                            </table>
                            
                            <table id="additionalInfoTable">
                            	<tr>
                                	<td id="addInfoTableFirstColumn"></td>
                                    <td id="addInfoTableSecondColumn"></td>
                                    <td id="addInfoTableThirdColumn"></td>
                                    <td id="addInfoTableLastColumn"></td>
                                </tr>
                                <tr id="additionalHeadingRow">
                                	<td colspan="4">Additional Info</td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="addInfoTableFirstColspan">
                                    	<table id="addInfoTableLeft">
                                        	<tr>
                                            	<td>Office space no.</td>
                                                <td><?php echo $flat_no; if(isset($flat_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatNoDiv')">Show</a><div id="flatNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Office space no. ' . $flat_no_original; ?><button id="closeButton" onClick="popDown('flatNoDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Floor</td>
                                                <td><?php echo $floor; if(isset($floor_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('floorDiv')">Show</a><div id="floorDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Floor: ' . $floor_original; ?><button id="closeButton" onClick="popDown('floorDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Number of rooms</td>
                                                <td><?php echo $number_of_rooms; if(isset($number_of_rooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberRoomsDiv')">Show</a><div id="numberRoomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of rooms: ' . $number_of_rooms_original; ?><button id="closeButton" onClick="popDown('numberRoomsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Number of washrooms</td>
                                                <td><?php echo $number_of_washrooms; if(isset($number_of_washrooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberWashroomsDiv')">Show</a><div id="numberWashroomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Number of washrooms: ' . $number_of_washrooms_original; ?><button id="closeButton" onClick="popDown('numberWashroomsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="addInfoTableLastColspan">
                                    	<table id="addInfoTableRight">
                                        	<tr>
                                            	<td>Total number of floors in the building</td>
                                                <td><?php echo $total_floors; if(isset($total_floors_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('totalFloorsDiv')">Show</a><div id="totalFloorsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Total number of floors: ' . $total_floors_original; ?><button id="closeButton" onClick="popDown('totalFloorsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Lift</td>
                                                <td><?php echo $lift; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Elevator</td>
                                                <td><?php echo $elevator; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Parking facility</td>
                                                <td><?php echo $parking_facility; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="flatSizePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Size of the space</span></td>
                                    <td colspan="3"><?php echo $size_of_flat; if(isset($size_of_flat_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatSizeDiv')">Show</a><div id="flatSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Size of the space: ' . $size_of_flat_original; ?><button id="closeButton" onClick="popDown('flatSizeDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">Other Description</span></td>
                                    <td colspan="3"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                                </tr>
                                <tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>">Back to <?php if($from == 'search-result'){ echo 'Search Result'; }else if($from == 'advertisements'){ echo 'Advertisements'; }else{ echo 'Home'; } ?></a></td></tr>
                            </table>
                            <?php
							
						}
						else if($shop == 1){
							
							?>
                            <table id="advertisementDetailsTable">
                            	<tr>
                                	<td id="adDetailsTableFirstColumn"></td>
                                    <td id="adDetailsTableSecondColumn"></td>
                                    <td id="adDetailsTableThirdColumn"></td>
                                    <td id="adDetailsTableLastColumn"></td>
                                </tr>
                                <tr id="headingRow">
                                	<td colspan="4">Advertisement Details</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><span id="postedOn">Posted on <?php echo $screenDate; ?> at <?php echo $screenTime; ?></span></td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="adDetailsTableFirstColspan">
                                    	<table id="adDetailsTableLeft">
                                        	<tr>
                                            	<td>Status</td>
                                                <td>
                                                	<?php
													
													if($publish == 1){
														
														echo '<span id="available">Available</span>';
														
													}
													else if($publish == 2){
														
														echo '<span id="notConfirmed">Not confirmed</span>';
														
													}
													else{
														
														echo '<span id="unavailable">Not available</span>';
														
													}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>Accommodation type</td>
                                                <td>Shop</td>
                                            </tr>
                                        	<tr>
                                            	<td>Advertisement for</td>
                                                <td><?php if($rent == 1){ echo 'Rent'; }else if($sale == 1){ echo 'Sale'; } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Available from</td>
                                                <td><?php echo $screenAvailableFrom ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="adDetailsTableLastColspan">
                                    	<table id="adDetailsTableRight">
                                        	<tr>
                                            	<td>Location</td>
                                                <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">Find on Google Map</a></td>
                                            </tr>
                                            <tr>
                                            	<td>Contact no.</td>
                                                <td><?php echo $contact_no; if(isset($contact_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactNoDiv')">Show</a><div id="contactNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Contact no. ' . $contact_no_original; ?><button id="closeButton" onClick="popDown('contactNoDiv')">close</button></div><?php }?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Email</td>
                                                <td><?php echo $contact_email; if(isset($contact_email_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactEmailDiv')">Show</a><div id="contactEmailDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Email: ' . $contact_email_original; ?><button id="closeButton" onClick="popDown('contactEmailDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="rentalPricePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <?php
								
								if($sale == 1){
									
									?>
									<tr>
										<td><span id="paddingToAlign">Price</span></td>
										<td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">Show</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Price: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">close</button></div><?php } ?></td>
									</tr>
									<tr>
										<td><span id="paddingToAlign">Booking money</span></td>
										<td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">You will need to pay this minimum amount initially to start the procedure of purchasing.</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">Show</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Booking money: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">close</button></div><?php } ?></td>
									</tr>
									<?php
									
								}
								else if($rent == 1){
									
									?>
									<tr>
										<td><span id="paddingToAlign">Rental price per month</span></td>
										<td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">Show</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Rental price per month: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">close</button></div><?php } ?></td>
									</tr>
									<tr>
										<td><span id="paddingToAlign">Security money</span></td>
										<td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">This amount will be taken from you by the owner before you have the space for your shop and won't be returned until the space is left.</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">Show</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Security money: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">close</button></div><?php } ?></td>
									</tr>
									<?php
									
								}
								
								?>
                                <tr>
                                	<td><span id="paddingToAlign">Full Address</span></td>
                                    <td colspan="3"><div id="fullAddress"><?php echo $full_address; ?></div><?php if(isset($full_address_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('fullAddressDiv')">Show</a><div id="fullAddressDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Full address: ' . $full_address_original; ?><button id="closeButton" onClick="popDown('fullAddressDiv')">close</button></div><?php } ?></td>
                                </tr>
                            </table>
                            
                            <table id="additionalInfoTable">
                            	<tr>
                                	<td id="addInfoTableFirstColumn"></td>
                                    <td id="addInfoTableSecondColumn"></td>
                                    <td id="addInfoTableThirdColumn"></td>
                                    <td id="addInfoTableLastColumn"></td>
                                </tr>
                                <tr id="additionalHeadingRow">
                                	<td colspan="4">Additional Info</td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="addInfoTableFirstColspan">
                                    	<table id="addInfoTableLeft">
                                        	<tr>
                                            	<td>Shop no.</td>
                                                <td><?php echo $flat_no; if(isset($flat_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatNoDiv')">Show</a><div id="flatNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Shop no. ' . $flat_no_original; ?><button id="closeButton" onClick="popDown('flatNoDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Floor</td>
                                                <td><?php echo $floor; if(isset($floor_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('floorDiv')">Show</a><div id="floorDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Floor: ' . $floor_original; ?><button id="closeButton" onClick="popDown('floorDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                            <tr>
                                            	<td>Total number of floors in the building</td>
                                                <td><?php echo $total_floors; if(isset($total_floors_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('totalFloorsDiv')">Show</a><div id="totalFloorsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Total number of floors: ' . $total_floors_original; ?><button id="closeButton" onClick="popDown('totalFloorsDiv')">close</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="addInfoTableLastColspan">
                                    	<table id="addInfoTableRight">
                                        	<tr>
                                            	<td>Lift</td>
                                                <td><?php echo $lift; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Elevator</td>
                                                <td><?php echo $elevator; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>Parking facility</td>
                                                <td><?php echo $parking_facility; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="flatSizePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">Size of the shop</span></td>
                                    <td colspan="3"><?php echo $size_of_flat; if(isset($size_of_flat_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatSizeDiv')">Show</a><div id="flatSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Size of the shop: ' . $size_of_flat_original; ?><button id="closeButton" onClick="popDown('flatSizeDiv')">close</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">Other Description</span></td>
                                    <td colspan="3"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                                </tr>
                                <tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>">Back to <?php if($from == 'search-result'){ echo 'Search Result'; }else if($from == 'advertisements'){ echo 'Advertisements'; }else{ echo 'Home'; } ?></a></td></tr>
                            </table>
                            <?php
							
						}
					
					}
					else{
						
						?>
                        <table id="advertisementDetailsTable">
                            <tr id="headingRow">
                                <td>Advertisement Details</td>
                            </tr>
                            <tr id="noAdMessageRow"><td>This advertisement has been deleted.</td></tr>
							<tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>">Back to <?php if($from == 'search-result'){ echo 'Search Result'; }else if($from == 'advertisements'){ echo 'Advertisements'; }else{ echo 'Home'; } ?></a></td></tr>
						</table>
                        <?php
						
					}
					
					?>
                </td>
                <td id="everythingLast"></td>
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