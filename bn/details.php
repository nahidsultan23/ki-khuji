<?php

if(!isset($_SESSION)){
	
	session_start();
	
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>কী খুঁজি - বিস্তারিত</title>
    
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

$_SESSION['getip'] = 1;
include('../getip.php');
$_SESSION['getip'] = NULL;

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);
$_SESSION['comebackUrl']['details'] = $pathUrl;

$from = '/bn/';

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

if($from == '/bn/'){
	
	$urlBackPage = $urlBackPageAdv;
	
}
else if($from == 'advertisements'){
	
	$urlBackPage = $urlBackPageAdv;
	
}

if(!isset($adID)){
	
	header('Location:' . $urlBackPage);
	exit;
	
}

if(!file_exists('../db/db.php')){
	
	session_destroy();
	
	header('Location:error-db');
	exit;
	
}

$_SESSION['db'] = 1;
include('../db/db.php');
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
			
			$rental_price = $rental_price . ' টাকা (আলোচনাসাপেক্ষ)';
			
			if(isset($rental_price_original)){
				
				$rental_price_original = $rental_price_original . ' টাকা (আলোচনাসাপেক্ষ)';
				
			}
			
		}
		else{
			
			$rental_price = $rental_price . ' টাকা (অপরিবর্তনীয়)';
			
			if(isset($rental_price_original)){
				
				$rental_price_original = $rental_price_original . ' টাকা (অপরিবর্তনীয়)';
				
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
			
			$security_money = $security_money . ' টাকা (আলোচনাসাপেক্ষ)';
			
			if(isset($security_money_original)){
				
				$security_money_original = $security_money_original . ' টাকা (আলোচনাসাপেক্ষ)';
				
			}
			
		}
		else{
			
			$security_money = $security_money . ' টাকা (অপরিবর্তনীয়)';
			
			if(isset($security_money_original)){
				
				$security_money_original = $security_money_original . ' টাকা (অপরিবর্তনীয়)';
				
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
		else{
			
			$floor = $floor + 1;
			
		}
		
	}
	
	$size_of_flat = $row['size_of_flat'];
	
	if($size_of_flat != ''){
		
		if(strlen($size_of_flat) > 12){
			
			$size_of_flat_original = number_format($size_of_flat)  . ' বর্গফুট';
			$size_of_flat = '999,999,999,999+ square feet';
			
		}
		else{
			
			$size_of_flat = number_format($size_of_flat)  . ' বর্গফুট';
			
		}
		
	}
	
	$size_of_room = $row['size_of_room'];
	
	if($size_of_room != ''){
		
		if(strlen($size_of_room) > 12){
			
			$size_of_room_original = number_format($size_of_room)  . ' বর্গফুট';
			$size_of_room = '999,999,999,999+ square feet';
			
		}
		else{
			
			$size_of_room = number_format($size_of_room)  . ' বর্গফুট';
			
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
	
	if($washroom_attached == 'Yes'){
		
		$washroom_attachedBengali = 'হ্যাঁ';
		
	}
	else{
		
		$washroom_attachedBengali = 'না';
		
	}
	
	$number_of_balconies = $row['number_of_balconies'];
	
	if($number_of_balconies != ''){
		
		if(strlen($number_of_balconies) > 3){
			
			$number_of_balconies_original = number_format($number_of_balconies);
			$number_of_balconies = '999+';
			
		}
		
	}
	
	$balcony_attached = $row['balcony_attached'];
	
	if($balcony_attached == 'Yes'){
		
		$balcony_attachedBengali = 'হ্যাঁ';
		
	}
	else{
		
		$balcony_attachedBengali = 'না';
		
	}
	
	$total_floors = $row['total_floors'];
	
	if($total_floors != ''){
		
		if(strlen($total_floors) > 3){
			
			$total_floors_original = number_format($total_floors);
			$total_floors = '999+';
			
		}
		else{
			
			$total_floors = $total_floors + 1;
			
		}
		
	}
	
	
	$lift = $row['lift'];
	
	if($lift == 'Yes'){
		
		$liftBengali = 'হ্যাঁ';
		
	}
	else{
		
		$liftBengali = 'না';
		
	}
	
	$elevator =  $row['elevator'];
	
	if($elevator == 'Yes'){
		
		$elevatorBengali = 'হ্যাঁ';
		
	}
	else{
		
		$elevatorBengali = 'না';
		
	}
	
	$parking_facility = $row['parking_facility'];
	
	if($parking_facility == 'Yes'){
		
		$parking_facilityBengali = 'হ্যাঁ';
		
	}
	else{
		
		$parking_facilityBengali = 'না';
		
	}
	
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

if($from == '/bn/'){
	
	$activeLink = 'bn';
	
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
    	<img id="logo" src="../logo/logo.png">
        <div class="topnav-left">
        	<a href="/bn/">কী খুঁজি</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/bn/" <?php if($from == '/bn/'){ ?>class="active"<?php } ?>>হোম</a>
            <a href="search" <?php if($from == 'search-result'){ ?>class="active"<?php } ?>>অনুসন্ধান</a>
            <a href="mark">প্রচার</a>
            <a href="profile">প্রোফাইল</a>
            <a href="advertisements" <?php if($from == 'advertisements'){ ?>class="active"<?php } ?>>বিজ্ঞাপনসমূহ</a>
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
                <a href="logout?cbp=details&al=<?php echo $activeLink; ?>">লগ আউট</a>
            </div>
            <?php
			
		}
		else{
			
			?>
            <div class="topnav-right">
                <a href="login?cbp=details&al=<?php echo $activeLink; ?>">লগ ইন</a>
                <a href="register?cbp=details&al=<?php echo $activeLink; ?>">নিবন্ধন</a>
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
						
						$photoNames = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
						if(isset($photoNames[0])){
						
						?>
						<div id="bigPhotoContainer">
							<img id="bigPhoto" src="<?php echo $photoNames[0]; ?>">
						</div>
                        
                        <div id="previousContainer">
							<?php
                            
                            if(isset($photoNames[1])){
                                
                                ?>
                                <button id="previous" style="display:none"  onclick="preNext('previous')">&laquo; পূর্ববর্তী</button>
                                <?php
                                
                            }
                            
                            ?>
                        </div>
                        
                        <div id="nextContainer">
							<?php
                            
                            if(isset($photoNames[1])){
                                
                                ?>
                                <button id="next"  onclick="preNext('next')">পরবর্তী &raquo;</button>
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
                                	<td colspan="4">বিস্তারিত বিজ্ঞাপন</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><span id="postedOn">পোস্ট করা হয়েছে <?php echo $screenDate; ?> তারিখে <?php echo $screenTime; ?> টার সময়</span></td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="adDetailsTableFirstColspan">
                                    	<table id="adDetailsTableLeft">
                                        	<tr>
                                            	<td>অবস্থা</td>
                                                <td>
                                                	<?php
													
													if($publish == 1){
														
														echo '<span id="available">সক্রিয়</span>';
														
													}
													else if($publish == 2){
														
														echo '<span id="notConfirmed">নিশ্চিত করা হয় নি</span>';
														
													}
													else{
														
														echo '<span id="unavailable">নিষ্ক্রিয়</span>';
														
													}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>জায়গার প্রকার</td>
                                                <td>
                                                	ফ্ল্যাট<?php
														
													if($mess == 1){
														
														echo ', মেস';
														
														?>
														<input type="button" id="button_acotype" value="?"><span id="sidenote_acotype">কিছু সিঙ্গেল মানুষ মিলেও পুরো ফ্ল্যাটটি ভাড়া নিতে পারবেন ।</span>
														<?php
														
													}
														
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>বিজ্ঞাপনের প্রকার</td>
                                                <td><?php if($rent == 1){ echo 'ভাড়া'; }else if($sale == 1){ echo 'বিক্রয়'; } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>হস্তান্তরযোগ্যতার সময়</td>
                                                <td><?php echo $screenAvailableFrom ?></td>
                                            </tr>
                                            <?php
											
											if($rent == 1){
												
												?>
                                                <tr>
                                                    <td>যে বা যারা নিতে পারবে</td>
                                                    <td>
                                                    	<?php
															
														if($male == 1){
															
															echo 'সিঙ্গেল (পুরুষ)';
															
														}
														
														if(($male == 0) && ($female == 1)){
															
															echo 'সিঙ্গেল (মহিলা)';
															
														}
														else if(($male == 1) && ($female == 1)){
															
															echo ',<br>সিঙ্গেল (মহিলা)';
															
														}
														
														if(($male == 0) && ($female == 0) && ($family == 1)){
															
															echo 'পরিবার';
															
														}
														else if((($male == 1) || ($female == 1)) && ($family == 1)){
															
															echo ',<br>পরিবার';
															
														}
														
														if(($male == 1) || ($female == 1)){
															
															?>
															<input type="button" id="button_single" value="?"><span id="sidenote_single">একজন সিঙ্গেল ব্যক্তি চাইলে পুরো ফ্ল্যাটটি ভাড়া নিয়ে থাকতে পারবেন যদি তিনি একা থাকেন ।</span>
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
                                            	<td>অবস্থান</td>
                                                <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">গুগল ম্যাপে দেখুন</a></td>
                                            </tr>
                                            <?php
											
											if($mess == 1){
												
												?>
                                                <tr>
                                                    <td>সর্বাধিক জনসংখ্যা (যদি মেস হিসেবে ব্যবহার করা হয়)</td>
                                                    <td>
                                                    	<?php
																
														if($max_people != ''){
															
															echo $max_people;
															
															?>
															<input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">ফ্ল্যাটে বসবাসকারী সিঙ্গেল ব্যক্তির সংখ্যা এর থেকে বেশি হওয়া যাবে না । তবে মানুষ এর থেকে কম সংখ্যকও হতে পারে ।</span>
															<?php
															
															if(isset($max_people_original)){
																
																?>
                                                                <a id="fullLengthViewLink" onClick="popUp('maxPeopleDiv')">দেখান</a><div id="maxPeopleDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'সর্বাধিক জনসংখ্যা: ' . $max_people_original; ?><button id="closeButton" onClick="popDown('maxPeopleDiv')">বন্ধ</button></div>
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
                                            	<td>ফোন নম্বর</td>
                                                <td><?php echo $contact_no; if(isset($contact_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactNoDiv')">দেখান</a><div id="contactNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফোন নম্বর: ' . $contact_no_original; ?><button id="closeButton" onClick="popDown('contactNoDiv')">বন্ধ</button></div><?php }?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ইমেইল</td>
                                                <td><?php echo $contact_email; if(isset($contact_email_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactEmailDiv')">দেখান</a><div id="contactEmailDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ইমেইল: ' . $contact_email_original; ?><button id="closeButton" onClick="popDown('contactEmailDiv')">বন্ধ</button></div><?php } ?></td>
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
										<td><span id="paddingToAlign">বিক্রয়মূল্য</span></td>
										<td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">দেখান</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বিক্রয়মূল্য: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">বন্ধ</button></div><?php } ?></td>
									</tr>
									<tr>
										<td><span id="paddingToAlign">বুকিং মূল্য</span></td>
										<td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">কেনার প্রক্রিয়া শুরু করার জন্য শুরুতে এই পরিমাণ অর্থ দিতে হবে ।</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">দেখান</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বুকিং মূল্য: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">বন্ধ</button></div><?php } ?></td>
									</tr>
									<?php
									
								}
								else if($rent == 1){
									
									?>
									<tr>
										<td><span id="paddingToAlign">মাসিক ভাড়া</span></td>
										<td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">দেখান</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'মাসিক ভাড়া: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">বন্ধ</button></div><?php } ?></td>
									</tr>
									<tr>
										<td><span id="paddingToAlign">জমা মূল্য</span></td>
										<td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">ফ্ল্যাটে ওঠার পূর্বে এই টাকা দিতে হবে, যেটা ফ্ল্যাট ছাড়ার পূর্ব পর্যন্ত জমা থাকবে ।</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">দেখান</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'জমা মূল্য: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">বন্ধ</button></div><?php } ?></td>
									</tr>
									<?php
									
								}
								
								?>
                                <tr>
                                	<td><span id="paddingToAlign">পুরো ঠিকানা</span></td>
                                    <td colspan="3"><div id="fullAddress"><?php echo $full_address; ?></div><?php if(isset($full_address_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('fullAddressDiv')">দেখান</a><div id="fullAddressDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'পুরো ঠিকানা: ' . $full_address_original; ?><button id="closeButton" onClick="popDown('fullAddressDiv')">বন্ধ</button></div><?php } ?></td>
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
                                	<td colspan="4">অতিরিক্ত তথ্য</td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="addInfoTableFirstColspan">
                                    	<table id="addInfoTableLeft">
                                        	<tr>
                                            	<td>ফ্ল্যাট নম্বর</td>
                                                <td><?php echo $flat_no; if(isset($flat_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatNoDiv')">দেখান</a><div id="flatNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফ্ল্যাট নম্বর: ' . $flat_no_original; ?><button id="closeButton" onClick="popDown('flatNoDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>তলা</td>
                                                <td><?php echo $floor; if(isset($floor_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('floorDiv')">দেখান</a><div id="floorDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'তলা: ' . $floor_original; ?><button id="closeButton" onClick="popDown('floorDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ঘরের সংখ্যা</td>
                                                <td><?php echo $number_of_rooms; if(isset($number_of_rooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberRoomsDiv')">দেখান</a><div id="numberRoomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ঘরের সংখ্যা: ' . $number_of_rooms_original; ?><button id="closeButton" onClick="popDown('numberRoomsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>বাথরুমের সংখ্যা</td>
                                                <td><?php echo $number_of_washrooms; if(isset($number_of_washrooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberWashroomsDiv')">দেখান</a><div id="numberWashroomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বাথরুমের সংখ্যা: ' . $number_of_washrooms_original; ?><button id="closeButton" onClick="popDown('numberWashroomsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="addInfoTableLastColspan">
                                    	<table id="addInfoTableRight">
                                        	<tr>
                                            	<td>বারান্দার সংখ্যা</td>
                                                <td><?php echo $number_of_balconies; if(isset($number_of_balconies_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberBalconiesDiv')">দেখান</a><div id="numberBalconiesDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বারান্দার সংখ্যা: ' . $number_of_balconies_original; ?><button id="closeButton" onClick="popDown('numberBalconiesDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>বাড়িটিতে মোট তলার সংখ্যা</td>
                                                <td><?php echo $total_floors; if(isset($total_floors_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('totalFloorsDiv')">দেখান</a><div id="totalFloorsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'মোট তলা: ' . $total_floors_original; ?><button id="closeButton" onClick="popDown('totalFloorsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>লিফট</td>
                                                <td><?php echo $liftBengali; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>গাড়ি রাখার ব্যবস্থা</td>
                                                <td><?php echo $parking_facilityBengali; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="flatSizePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">ফ্ল্যাটের আকার</span></td>
                                    <td colspan="3"><?php echo $size_of_flat; if(isset($size_of_flat_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatSizeDiv')">দেখান</a><div id="flatSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফ্ল্যাটের আকার: ' . $size_of_flat_original; ?><button id="closeButton" onClick="popDown('flatSizeDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">অন্যান্য বর্ণনা</span></td>
                                    <td colspan="3"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                                </tr>
                                <tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>"><?php if($from == 'search-result'){ echo 'অনুসন্ধানের ফলাফল'; }else if($from == 'advertisements'){ echo 'বিজ্ঞাপনসমূহ'; }else{ echo 'হোম'; } ?> এ ফিরে চলুন</a></td></tr>
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
                                	<td colspan="4">বিস্তারিত বিজ্ঞাপন</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><span id="postedOn">পোস্ট করা হয়েছে <?php echo $screenDate; ?> তারিখে <?php echo $screenTime; ?> টার সময়</span></td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="adDetailsTableFirstColspan">
                                    	<table id="adDetailsTableLeft">
                                        	<tr>
                                            	<td>অবস্থা</td>
                                                <td>
                                                	<?php
													
													if($publish == 1){
														
														echo '<span id="available">সক্রিয়</span>';
														
													}
													else if($publish == 2){
														
														echo '<span id="notConfirmed">নিশ্চিত করা হয় নি</span>';
														
													}
													else{
														
														echo '<span id="unavailable">নিষ্ক্রিয়</span>';
														
													}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>জায়গার প্রকার</td>
                                                <td>
                                                	রুম<?php
													
														if($mess == 1){
															
															echo ', মেস';
													
															?>
															<input type="button" id="button_acotype" value="?"><span id="sidenote_acotype">একাধিক সিঙ্গেল ব্যক্তি মিলেও পুরো ঘরটি ভাড়া নিতে পারবেন ।</span>
															<?php
															
														}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>বিজ্ঞাপনের প্রকার</td>
                                                <td><?php if($rent == 1){ echo 'ভাড়া'; }else if($sale == 1){ echo 'বিক্রয়'; } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>হস্তান্তরযোগ্যতার সময়</td>
                                                <td><?php echo $screenAvailableFrom ?></td>
                                            </tr>
                                            <tr>
                                                <td>যে বা যারা নিতে পারবে</td>
                                                <td>
                                                    <?php
                                                        
                                                    if($male == 1){
                                                        
                                                        echo 'সিঙ্গেল (পুরুষ)';
                                                        
                                                    }
                                                    
                                                    if(($male == 0) && ($female == 1)){
                                                        
                                                        echo 'সিঙ্গেল (মহিলা)';
                                                        
                                                    }
                                                    else if(($male == 1) && ($female == 1)){
                                                        
                                                        echo ',<br>সিঙ্গেল (মহিলা)';
                                                        
                                                    }
                                                    
                                                    if(($male == 0) && ($female == 0) && ($family == 1)){
                                                        
                                                        echo 'পরিবার';
                                                        
                                                    }
                                                    else if((($male == 1) || ($female == 1)) && ($family == 1)){
                                                        
                                                        echo ',<br>পরিবার';
                                                        
                                                    }
                                                    
                                                    if(($male == 1) || ($female == 1)){
                                                        
                                                        ?>
                                                        <input type="button" id="button_single" value="?"><span id="sidenote_single">একজন সিঙ্গেল ব্যক্তি পুরো রুমটিই ভাড়া নিয়ে থাকতে পারবেন যদি তিনি একা থাকেন ।</span>
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
                                            	<td>অবস্থান</td>
                                                <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">গুগল ম্যাপে দেখুন</a></td>
                                            </tr>
                                            <?php
											
											if($mess == 1){
												
												?>
                                                <tr>
                                                    <td>সর্বাধিক জনসংখ্যা (যদি মেস হিসেবে ব্যবহার করা হয়)</td>
                                                    <td>
                                                    	<?php
																
														if($max_people != ''){
															
															echo $max_people;
															
															?>
															<input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">রুমে বসবাসকারী সিঙ্গেল ব্যক্তির সংখ্যা এর থেকে বেশি হওয়া যাবে না । তবে মানুষ এর থেকে কম সংখ্যক হলেও চলবে ।</span>
															<?php
															
															if(isset($max_people_original)){
																
																?>
                                                                <a id="fullLengthViewLink" onClick="popUp('maxPeopleDiv')">দেখান</a><div id="maxPeopleDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'সর্বাধিক জনসংখ্যা: ' . $max_people_original; ?><button id="closeButton" onClick="popDown('maxPeopleDiv')">বন্ধ</button></div>
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
                                            	<td>ফোন নম্বর</td>
                                                <td><?php echo $contact_no; if(isset($contact_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactNoDiv')">দেখান</a><div id="contactNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফোন নম্বর: ' . $contact_no_original; ?><button id="closeButton" onClick="popDown('contactNoDiv')">বন্ধ</button></div><?php }?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ইমেইল</td>
                                                <td><?php echo $contact_email; if(isset($contact_email_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactEmailDiv')">দেখান</a><div id="contactEmailDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ইমেইল: ' . $contact_email_original; ?><button id="closeButton" onClick="popDown('contactEmailDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="rentalPricePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">মাসিক ভাড়া</span></td>
                                    <td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">দেখান</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'মাসিক ভাড়া: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">জমা মূল্য</span></td>
                                    <td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">রুমে ওঠার পূর্বে এটি দিতে হবে মালিককে কিংবা যিনি পুরো ফ্ল্যাটটি ভাড়া নিয়েছেন, তাকে এবং রুম ছাড়ার পূর্ব পর্যন্ত এটি ফেরত দেয়া হবে না ।</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">দেখান</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'জমা মূল্য: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">পুরো ঠিকানা</span></td>
                                    <td colspan="3"><div id="fullAddress"><?php echo $full_address; ?></div><?php if(isset($full_address_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('fullAddressDiv')">দেখান</a><div id="fullAddressDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'পুরো ঠিকানা: ' . $full_address_original; ?><button id="closeButton" onClick="popDown('fullAddressDiv')">বন্ধ</button></div><?php } ?></td>
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
                                	<td colspan="4">অতিরিক্ত তথ্য</td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="addInfoTableFirstColspan">
                                    	<table id="addInfoTableLeft">
                                        	<tr>
                                            	<td>ফ্ল্যাট নম্বর</td>
                                                <td><?php echo $flat_no; if(isset($flat_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatNoDiv')">দেখান</a><div id="flatNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফ্ল্যাট নম্বর: ' . $flat_no_original; ?><button id="closeButton" onClick="popDown('flatNoDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>তলা</td>
                                                <td><?php echo $floor; if(isset($floor_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('floorDiv')">দেখান</a><div id="floorDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'তলা: ' . $floor_original; ?><button id="closeButton" onClick="popDown('floorDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ফ্ল্যাটটিতে ঘরের সংখ্যা</td>
                                                <td><?php echo $number_of_rooms; if(isset($number_of_rooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberRoomsDiv')">দেখান</a><div id="numberRoomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ঘরের সংখ্যা: ' . $number_of_rooms_original; ?><button id="closeButton" onClick="popDown('numberRoomsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ফ্ল্যাটটিতে বাথরুমের সংখ্যা</td>
                                                <td><?php echo $number_of_washrooms; if(isset($number_of_washrooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberWashroomsDiv')">দেখান</a><div id="numberWashroomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বাথরুমের সংখ্যা: ' . $number_of_washrooms_original; ?><button id="closeButton" onClick="popDown('numberWashroomsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>এটাচড বাথরুম</td>
                                                <td><?php echo $washroom_attachedBengali; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="addInfoTableLastColspan">
                                    	<table id="addInfoTableRight">
                                            <tr>
                                            	<td>ফ্ল্যাটটিতে বারান্দার সংখ্যা</td>
                                                <td><?php echo $number_of_balconies; if(isset($number_of_balconies_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberBalconiesDiv')">দেখান</a><div id="numberBalconiesDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বারান্দার সংখ্যা: ' . $number_of_balconies_original; ?><button id="closeButton" onClick="popDown('numberBalconiesDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                            <tr>
                                            	<td>এটাচড বারান্দা</td>
                                                <td><?php echo $balcony_attachedBengali; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>বাড়িটিতে মোট তলার সংখ্যা</td>
                                                <td><?php echo $total_floors; if(isset($total_floors_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('totalFloorsDiv')">দেখান</a><div id="totalFloorsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'মোট তলা: ' . $total_floors_original; ?><button id="closeButton" onClick="popDown('totalFloorsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>লিফট</td>
                                                <td><?php echo $liftBengali; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>গাড়ি রাখার ব্যবস্থা</td>
                                                <td><?php echo $parking_facilityBengali; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="flatSizePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">ফ্ল্যাটের আকার</span></td>
                                    <td colspan="3"><?php echo $size_of_flat; if(isset($size_of_flat_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatSizeDiv')">দেখান</a><div id="flatSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফ্ল্যাটের আকার: ' . $size_of_flat_original; ?><button id="closeButton" onClick="popDown('flatSizeDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">রুমের আকার</span></td>
                                    <td colspan="3"><?php echo $size_of_room; if(isset($size_of_room_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('roomSizeDiv')">দেখান</a><div id="roomSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'রুমের আকার: ' . $size_of_room_original; ?><button id="closeButton" onClick="popDown('roomSizeDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">অন্যান্য বর্ণনা</span></td>
                                    <td colspan="3"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                                </tr>
                                <tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>"><?php if($from == 'search-result'){ echo 'অনুসন্ধানের ফলাফল'; }else if($from == 'advertisements'){ echo 'বিজ্ঞাপনসমূহ'; }else{ echo 'হোম'; } ?> এ ফিরে চলুন</a></td></tr>
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
                                	<td colspan="4">বিস্তারিত বিজ্ঞাপন</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><span id="postedOn">পোস্ট করা হয়েছে <?php echo $screenDate; ?> তারিখে <?php echo $screenTime; ?> টার সময়</span></td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="adDetailsTableFirstColspan">
                                    	<table id="adDetailsTableLeft">
                                        	<tr>
                                            	<td>অবস্থা</td>
                                                <td>
                                                	<?php
													
													if($publish == 1){
														
														echo '<span id="available">সক্রিয়</span>';
														
													}
													else if($publish == 2){
														
														echo '<span id="notConfirmed">নিশ্চিত করা হয় নি</span>';
														
													}
													else{
														
														echo '<span id="unavailable">নিষ্ক্রিয়</span>';
														
													}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>জায়গার প্রকার</td>
                                                <td>মেস<input type="button" id="button_acotype" value="?"><span id="sidenote_acotype">মেসের একটি সিট । পুরো রুম মিলেও একটি সিট হতে পারে ।</span></td>
                                            </tr>
                                        	<tr>
                                            	<td>বিজ্ঞাপনের প্রকার</td>
                                                <td><?php if($rent == 1){ echo 'ভাড়া'; }else if($sale == 1){ echo 'বিক্রয়'; } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>হস্তান্তরযোগ্যতার সময়</td>
                                                <td><?php echo $screenAvailableFrom ?></td>
                                            </tr>
                                            <tr>
                                                <td>যে বা যারা নিতে পারবে</td>
                                                <td>
                                                    <?php
                                                        
                                                    if($male == 1){
                                                        
                                                        echo 'সিঙ্গেল (পুরুষ)';
                                                        
                                                    }
                                                    
                                                    if(($male == 0) && ($female == 1)){
                                                        
                                                        echo 'সিঙ্গেল (মহিলা)';
                                                        
                                                    }
                                                    else if(($male == 1) && ($female == 1)){
                                                        
                                                        echo ',<br>সিঙ্গেল (মহিলা)';
                                                        
                                                    }
                                                
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="adDetailsTableLastColspan">
                                    	<table id="adDetailsTableRight">
                                        	<tr>
                                            	<td>অবস্থান</td>
                                                <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">গুগল ম্যাপে দেখুন</a></td>
                                            </tr>
                                            <tr>
                                                <td>রুমে সর্বাধিক জনসংখ্যা</td>
                                                <td>
                                                    <?php
                                                            
                                                    if($max_people != ''){
                                                        
                                                        echo $max_people;
                                                        
                                                        ?>
                                                        <input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">রুমের জনসংখ্যা এর থেকে বেশি হবে না । তবে এর থেকে কম হতে পারে ।</span>
                                                        <?php
                                                        
                                                        if(isset($max_people_original)){
                                                            
                                                            ?>
                                                            <a id="fullLengthViewLink" onClick="popUp('maxPeopleDiv')">দেখান</a><div id="maxPeopleDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'সর্বাধিক জনসংখ্যা: ' . $max_people_original; ?><button id="closeButton" onClick="popDown('maxPeopleDiv')">বন্ধ</button></div>
                                                            <?php
                                                            
                                                        }
                                                        
                                                    }
                                                        
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td>ফোন নম্বর</td>
                                                <td><?php echo $contact_no; if(isset($contact_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactNoDiv')">দেখান</a><div id="contactNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফোন নম্বর: ' . $contact_no_original; ?><button id="closeButton" onClick="popDown('contactNoDiv')">বন্ধ</button></div><?php }?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ইমেইল</td>
                                                <td><?php echo $contact_email; if(isset($contact_email_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactEmailDiv')">দেখান</a><div id="contactEmailDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ইমেইল: ' . $contact_email_original; ?><button id="closeButton" onClick="popDown('contactEmailDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="rentalPricePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">মাসিক ভাড়া</span></td>
                                    <td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">দেখান</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'মাসিক ভাড়া: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">জমা মূল্য</span></td>
                                    <td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">মেসে ওঠার পূর্বে এই পরিমাণ টাকা নিয়ে নেওয়া হবে যা মেস ছাড়ার পূর্ব পর্যন্ত জমা থাকবে ।</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">দেখান</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'জমা মূল্য: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">পুরো ঠিকানা</span></td>
                                    <td colspan="3"><div id="fullAddress"><?php echo $full_address; ?></div><?php if(isset($full_address_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('fullAddressDiv')">দেখান</a><div id="fullAddressDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'পুরো ঠিকানা: ' . $full_address_original; ?><button id="closeButton" onClick="popDown('fullAddressDiv')">বন্ধ</button></div><?php } ?></td>
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
                                	<td colspan="4">অতিরিক্ত তথ্য</td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="addInfoTableFirstColspan">
                                    	<table id="addInfoTableLeft">
                                        	<tr>
                                            	<td>ফ্ল্যাট নম্বর</td>
                                                <td><?php echo $flat_no; if(isset($flat_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatNoDiv')">দেখান</a><div id="flatNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফ্ল্যাট নম্বর: ' . $flat_no_original; ?><button id="closeButton" onClick="popDown('flatNoDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>তলা</td>
                                                <td><?php echo $floor; if(isset($floor_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('floorDiv')">দেখান</a><div id="floorDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'তলা: ' . $floor_original; ?><button id="closeButton" onClick="popDown('floorDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ফ্ল্যাটটিতে ঘরের সংখ্যা</td>
                                                <td><?php echo $number_of_rooms; if(isset($number_of_rooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberRoomsDiv')">দেখান</a><div id="numberRoomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ঘরের সংখ্যা: ' . $number_of_rooms_original; ?><button id="closeButton" onClick="popDown('numberRoomsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ফ্ল্যাটটিতে বাথরুমের সংখ্যা</td>
                                                <td><?php echo $number_of_washrooms; if(isset($number_of_washrooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberWashroomsDiv')">দেখান</a><div id="numberWashroomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বাথরুমের সংখ্যা: ' . $number_of_washrooms_original; ?><button id="closeButton" onClick="popDown('numberWashroomsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>এটাচড বাথরুম</td>
                                                <td><?php echo $washroom_attachedBengali; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="addInfoTableLastColspan">
                                    	<table id="addInfoTableRight">
                                            <tr>
                                            	<td>ফ্ল্যাটটিতে বারান্দার সংখ্যা</td>
                                                <td><?php echo $number_of_balconies; if(isset($number_of_balconies_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberBalconiesDiv')">দেখান</a><div id="numberBalconiesDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বারান্দার সংখ্যা: ' . $number_of_balconies_original; ?><button id="closeButton" onClick="popDown('numberBalconiesDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                            <tr>
                                            	<td>এটাচড বারান্দা</td>
                                                <td><?php echo $balcony_attachedBengali; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>বাড়িটিতে মোট তলার সংখ্যা</td>
                                                <td><?php echo $total_floors; if(isset($total_floors_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('totalFloorsDiv')">দেখান</a><div id="totalFloorsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'মোট তলা: ' . $total_floors_original; ?><button id="closeButton" onClick="popDown('totalFloorsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>লিফট</td>
                                                <td><?php echo $liftBengali; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="flatSizePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">ফ্ল্যাটের আকার</span></td>
                                    <td colspan="3"><?php echo $size_of_flat; if(isset($size_of_flat_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatSizeDiv')">দেখান</a><div id="flatSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফ্ল্যাটের আকার: ' . $size_of_flat_original; ?><button id="closeButton" onClick="popDown('flatSizeDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">রুমের আকার</span></td>
                                    <td colspan="3"><?php echo $size_of_room; if(isset($size_of_room_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('roomSizeDiv')">দেখান</a><div id="roomSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'রুমের আকার: ' . $size_of_room_original; ?><button id="closeButton" onClick="popDown('roomSizeDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">অন্যান্য বর্ণনা</span></td>
                                    <td colspan="3"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                                </tr>
                                <tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>"><?php if($from == 'search-result'){ echo 'অনুসন্ধানের ফলাফল'; }else if($from == 'advertisements'){ echo 'বিজ্ঞাপনসমূহ'; }else{ echo 'হোম'; } ?> এ ফিরে চলুন</a></td></tr>
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
                                	<td colspan="4">বিস্তারিত বিজ্ঞাপন</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><span id="postedOn">পোস্ট করা হয়েছে <?php echo $screenDate; ?> তারিখে <?php echo $screenTime; ?> টার সময়</span></td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="adDetailsTableFirstColspan">
                                    	<table id="adDetailsTableLeft">
                                        	<tr>
                                            	<td>অবস্থা</td>
                                                <td>
                                                	<?php
													
													if($publish == 1){
														
														echo '<span id="available">সক্রিয়</span>';
														
													}
													else if($publish == 2){
														
														echo '<span id="notConfirmed">নিশ্চিত করা হয় নি</span>';
														
													}
													else{
														
														echo '<span id="unavailable">নিষ্ক্রিয়</span>';
														
													}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>জায়গার প্রকার</td>
                                                <td>অফিস</td>
                                            </tr>
                                        	<tr>
                                            	<td>বিজ্ঞাপনের প্রকার</td>
                                                <td><?php if($rent == 1){ echo 'ভাড়া'; }else if($sale == 1){ echo 'বিক্রয়'; } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>হস্তান্তরযোগ্যতার সময়</td>
                                                <td><?php echo $screenAvailableFrom ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="adDetailsTableLastColspan">
                                    	<table id="adDetailsTableRight">
                                        	<tr>
                                            	<td>অবস্থান</td>
                                                <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">গুগল ম্যাপে দেখুন</a></td>
                                            </tr>
                                            <tr>
                                            	<td>ফোন নম্বর</td>
                                                <td><?php echo $contact_no; if(isset($contact_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactNoDiv')">দেখান</a><div id="contactNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফোন নম্বর: ' . $contact_no_original; ?><button id="closeButton" onClick="popDown('contactNoDiv')">বন্ধ</button></div><?php }?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ইমেইল</td>
                                                <td><?php echo $contact_email; if(isset($contact_email_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactEmailDiv')">দেখান</a><div id="contactEmailDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ইমেইল: ' . $contact_email_original; ?><button id="closeButton" onClick="popDown('contactEmailDiv')">বন্ধ</button></div><?php } ?></td>
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
                                        <td><span id="paddingToAlign">বিক্রয়মূল্য</span></td>
                                        <td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">দেখান</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বিক্রয়মূল্য: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">বন্ধ</button></div><?php } ?></td>
                                    </tr>
                                    <tr>
                                        <td><span id="paddingToAlign">বুকিং মূল্য</span></td>
                                        <td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">কেনার প্রক্রিয়া শুরু করার জন্য শুরুতে এই পরিমাণ অর্থ দিতে হবে ।</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">দেখান</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বুকিং মূল্য: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">বন্ধ</button></div><?php } ?></td>
                                    </tr>
                                    <?php
                                    
                                }
                                else if($rent == 1){
                                    
                                    ?>
                                    <tr>
                                        <td><span id="paddingToAlign">মাসিক ভাড়া</span></td>
                                        <td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">দেখান</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'মাসিক ভাড়া: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">বন্ধ</button></div><?php } ?></td>
                                    </tr>
                                    <tr>
                                        <td><span id="paddingToAlign">জমা মূল্য</span></td>
                                        <td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">অফিস ব্যবহার শুরুর পূর্বে এই টাকা দিতে হবে, যেটা অফিস ছাড়ার পূর্ব পর্যন্ত জমা থাকবে ।</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">দেখান</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'জমা মূল্য: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">বন্ধ</button></div><?php } ?></td>
                                    </tr>
                                    <?php
                                    
                                }
                                
                                ?>
                                <tr>
                                	<td><span id="paddingToAlign">পুরো ঠিকানা</span></td>
                                    <td colspan="3"><div id="fullAddress"><?php echo $full_address; ?></div><?php if(isset($full_address_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('fullAddressDiv')">দেখান</a><div id="fullAddressDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'পুরো ঠিকানা: ' . $full_address_original; ?><button id="closeButton" onClick="popDown('fullAddressDiv')">বন্ধ</button></div><?php } ?></td>
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
                                	<td colspan="4">অতিরিক্ত তথ্য</td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="addInfoTableFirstColspan">
                                    	<table id="addInfoTableLeft">
                                        	<tr>
                                            	<td>অফিস নম্বর</td>
                                                <td><?php echo $flat_no; if(isset($flat_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatNoDiv')">দেখান</a><div id="flatNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'অফিস নম্বর: ' . $flat_no_original; ?><button id="closeButton" onClick="popDown('flatNoDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>তলা</td>
                                                <td><?php echo $floor; if(isset($floor_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('floorDiv')">দেখান</a><div id="floorDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'তলা: ' . $floor_original; ?><button id="closeButton" onClick="popDown('floorDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ঘরের সংখ্যা</td>
                                                <td><?php echo $number_of_rooms; if(isset($number_of_rooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberRoomsDiv')">দেখান</a><div id="numberRoomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ঘরের সংখ্যা: ' . $number_of_rooms_original; ?><button id="closeButton" onClick="popDown('numberRoomsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>বাথরুমের সংখ্যা</td>
                                                <td><?php echo $number_of_washrooms; if(isset($number_of_washrooms_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('numberWashroomsDiv')">দেখান</a><div id="numberWashroomsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বাথরুমের সংখ্যা: ' . $number_of_washrooms_original; ?><button id="closeButton" onClick="popDown('numberWashroomsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="addInfoTableLastColspan">
                                    	<table id="addInfoTableRight">
                                        	<tr>
                                            	<td>দালানটিতে মোট তলার সংখ্যা</td>
                                                <td><?php echo $total_floors; if(isset($total_floors_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('totalFloorsDiv')">দেখান</a><div id="totalFloorsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'মোট তলা: ' . $total_floors_original; ?><button id="closeButton" onClick="popDown('totalFloorsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>লিফট</td>
                                                <td><?php echo $liftBengali; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>চলন্ত সিঁড়ি</td>
                                                <td><?php echo $elevatorBengali; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>গাড়ি রাখার ব্যবস্থা</td>
                                                <td><?php echo $parking_facilityBengali; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="flatSizePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">অফিসের আকার</span></td>
                                    <td colspan="3"><?php echo $size_of_flat; if(isset($size_of_flat_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatSizeDiv')">দেখান</a><div id="flatSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'অফিসের আকার: ' . $size_of_flat_original; ?><button id="closeButton" onClick="popDown('flatSizeDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">অন্যান্য বর্ণনা</span></td>
                                    <td colspan="3"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                                </tr>
                                <tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>"><?php if($from == 'search-result'){ echo 'অনুসন্ধানের ফলাফল'; }else if($from == 'advertisements'){ echo 'বিজ্ঞাপনসমূহ'; }else{ echo 'হোম'; } ?> এ ফিরে চলুন</a></td></tr>
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
                                	<td colspan="4">বিস্তারিত বিজ্ঞাপন</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><span id="postedOn">পোস্ট করা হয়েছে <?php echo $screenDate; ?> তারিখে <?php echo $screenTime; ?> টার সময়</span></td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="adDetailsTableFirstColspan">
                                    	<table id="adDetailsTableLeft">
                                        	<tr>
                                            	<td>অবস্থা</td>
                                                <td>
                                                	<?php
													
													if($publish == 1){
														
														echo '<span id="available">সক্রিয়</span>';
														
													}
													else if($publish == 2){
														
														echo '<span id="notConfirmed">নিশ্চিত করা হয় নি</span>';
														
													}
													else{
														
														echo '<span id="unavailable">নিষ্ক্রিয়</span>';
														
													}
													
													?>
                                                </td>
                                            </tr>
                                        	<tr>
                                            	<td>জায়গার প্রকার</td>
                                                <td>দোকান</td>
                                            </tr>
                                        	<tr>
                                            	<td>বিজ্ঞাপনের প্রকার</td>
                                                <td><?php if($rent == 1){ echo 'ভাড়া'; }else if($sale == 1){ echo 'বিক্রয়'; } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>হস্তান্তরযোগ্যতার সময়</td>
                                                <td><?php echo $screenAvailableFrom ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="adDetailsTableLastColspan">
                                    	<table id="adDetailsTableRight">
                                        	<tr>
                                            	<td>অবস্থান</td>
                                                <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">গুগল ম্যাপে দেখুন</a></td>
                                            </tr>
                                            <tr>
                                            	<td>ফোন নম্বর</td>
                                                <td><?php echo $contact_no; if(isset($contact_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactNoDiv')">দেখান</a><div id="contactNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ফোন নম্বর: ' . $contact_no_original; ?><button id="closeButton" onClick="popDown('contactNoDiv')">বন্ধ</button></div><?php }?></td>
                                            </tr>
                                        	<tr>
                                            	<td>ইমেইল</td>
                                                <td><?php echo $contact_email; if(isset($contact_email_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('contactEmailDiv')">দেখান</a><div id="contactEmailDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'ইমেইল: ' . $contact_email_original; ?><button id="closeButton" onClick="popDown('contactEmailDiv')">বন্ধ</button></div><?php } ?></td>
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
                                        <td><span id="paddingToAlign">বিক্রয়মূল্য</span></td>
                                        <td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">দেখান</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বিক্রয়মূল্য: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">বন্ধ</button></div><?php } ?></td>
                                    </tr>
                                    <tr>
                                        <td><span id="paddingToAlign">বুকিং মূল্য</span></td>
                                        <td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">কেনার প্রক্রিয়া শুরু করার জন্য শুরুতে এই পরিমাণ অর্থ দিতে হবে ।</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">দেখান</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'বুকিং মূল্য: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">বন্ধ</button></div><?php } ?></td>
                                    </tr>
                                    <?php
                                    
                                }
                                else if($rent == 1){
                                    
                                    ?>
                                    <tr>
                                        <td><span id="paddingToAlign">মাসিক ভাড়া</span></td>
                                        <td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">দেখান</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'মাসিক ভাড়া: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">বন্ধ</button></div><?php } ?></td>
                                    </tr>
                                    <tr>
                                        <td><span id="paddingToAlign">জমা মূল্য</span></td>
                                        <td colspan="3"><?php echo $security_money;  if($security_money != ''){ ?><input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">দোকান ব্যবহার শুরু করার পূর্বে এই টাকা দিতে হবে, যেটা দোকান ছাড়ার পূর্ব পর্যন্ত জমা থাকবে ।</span><?php } if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">দেখান</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'জমা মূল্য: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">বন্ধ</button></div><?php } ?></td>
                                    </tr>
                                    <?php
                                    
                                }
                                
                                ?>
                                <tr>
                                	<td><span id="paddingToAlign">পুরো ঠিকানা</span></td>
                                    <td colspan="3"><div id="fullAddress"><?php echo $full_address; ?></div><?php if(isset($full_address_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('fullAddressDiv')">দেখান</a><div id="fullAddressDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'পুরো ঠিকানা: ' . $full_address_original; ?><button id="closeButton" onClick="popDown('fullAddressDiv')">বন্ধ</button></div><?php } ?></td>
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
                                	<td colspan="4">অতিরিক্ত তথ্য</td>
                                </tr>
                                <tr>
                                	<td colspan="2" id="addInfoTableFirstColspan">
                                    	<table id="addInfoTableLeft">
                                        	<tr>
                                            	<td>দোকান নম্বর</td>
                                                <td><?php echo $flat_no; if(isset($flat_no_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatNoDiv')">দেখান</a><div id="flatNoDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'দোকান নম্বর: ' . $flat_no_original; ?><button id="closeButton" onClick="popDown('flatNoDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>তলা</td>
                                                <td><?php echo $floor; if(isset($floor_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('floorDiv')">দেখান</a><div id="floorDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'তলা: ' . $floor_original; ?><button id="closeButton" onClick="popDown('floorDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                            <tr>
                                            	<td>দালানটিতে মোট তলার সংখ্যা</td>
                                                <td><?php echo $total_floors; if(isset($total_floors_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('totalFloorsDiv')">দেখান</a><div id="totalFloorsDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'মোট তলা: ' . $total_floors_original; ?><button id="closeButton" onClick="popDown('totalFloorsDiv')">বন্ধ</button></div><?php } ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2" id="addInfoTableLastColspan">
                                    	<table id="addInfoTableRight">
                                        	<tr>
                                            	<td>লিফট</td>
                                                <td><?php echo $liftBengali; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>চলন্ত সিঁড়ি</td>
                                                <td><?php echo $elevatorBengali; ?></td>
                                            </tr>
                                        	<tr>
                                            	<td>গাড়ি রাখার ব্যবস্থা</td>
                                                <td><?php echo $parking_facilityBengali; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr id="flatSizePadding">
                                	<td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td><span id="paddingToAlign">দোকানের আকার</span></td>
                                    <td colspan="3"><?php echo $size_of_flat; if(isset($size_of_flat_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('flatSizeDiv')">দেখান</a><div id="flatSizeDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'দোকানের আকার: ' . $size_of_flat_original; ?><button id="closeButton" onClick="popDown('flatSizeDiv')">বন্ধ</button></div><?php } ?></td>
                                </tr>
                                <tr>
                                	<td><span id="paddingToAlign">অন্যান্য বর্ণনা</span></td>
                                    <td colspan="3"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                                </tr>
                                <tr id="backRow"><td colspan="4"><a id="backLink" href="<?php echo $urlBackPage; ?>"><?php if($from == 'search-result'){ echo 'অনুসন্ধানের ফলাফল'; }else if($from == 'advertisements'){ echo 'বিজ্ঞাপনসমূহ'; }else{ echo 'হোম'; } ?> এ ফিরে চলুন</a></td></tr>
                            </table>
                            <?php
							
						}
					
					}
					else{
						
						?>
                        <table id="advertisementDetailsTable">
                            <tr id="headingRow">
                                <td>বিস্তারিত বিজ্ঞাপন</td>
                            </tr>
                            <tr id="noAdMessageRow"><td>বিজ্ঞাপনটি মুছে ফেলা হয়েছে ।</td></tr>
							<tr id="backRow"><td><a id="backLink" href="<?php echo $urlBackPage; ?>"><?php if($from == 'search-result'){ echo 'অনুসন্ধানের ফলাফল'; }else if($from == 'advertisements'){ echo 'বিজ্ঞাপনসমূহ'; }else{ echo 'হোম'; } ?> এ ফিরে চলুন</a></td></tr>
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
        <td id="bottomContentsSecond">আমাদের ইমেইল ঠিকানা <span id="helloEmail">hello@kikhuji.com</span></td>
        <td id="bottomContentsLast"></td></tr>
    </table>
</body>

</html>