<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);
$_SESSION['comebackUrl']['new-room-info-check-again'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=new-room-info');
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
    <title>কী খুঁজি - আরেকবার দেখুন</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/new-room-info-check-again.css">
    
    <script src="js/clock.js"></script>
    <script src="js/details.js"></script>
</head>

<?php

$urlNextPage = 'successful?content=new-room';
$urlBackPage = 'new-room-info';

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

if(!isset($_SESSION['new-room-info'][$rand])){
		
	header('Location:' . $urlBackPage);
	exit;
	
}

$urlBackPage = $urlBackPage . '?key=' . $rand;

$screenAvailableFrom = date('d F, Y',strtotime($_SESSION['new-room-info'][$rand]['available_from']));

$max_people = $_SESSION['new-room-info'][$rand]['max_people'];

if($max_people != ''){
	
	if(strlen($max_people) > 3){
		
		$max_people_original = $max_people;
		$max_people = '999+';
		
	}
	
}

$rental_price = $_SESSION['new-room-info'][$rand]['rental_price'];
$rental_price_nego = $_SESSION['new-room-info'][$rand]['rental_price_nego'];

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

$security_money = $_SESSION['new-room-info'][$rand]['security_money'];
$security_money_nego = $_SESSION['new-room-info'][$rand]['security_money_nego'];

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

$full_address = $_SESSION['new-room-info'][$rand]['full_address'];

if($full_address != ''){
	
	if(strlen($full_address) > 500){
		
		$full_address_original = $full_address;
		$full_address = substr($full_address, 0, 450) . '....';
		
	}
	
}

$contact_no = $_SESSION['new-room-info'][$rand]['contact_no'];

if($contact_no != ''){
	
	$contact_no_original = $contact_no;
	$contact_no = substr($contact_no, 0, 6) . '....';
	
}

$contact_email = $_SESSION['new-room-info'][$rand]['contact_email'];

if($contact_email != ''){
	
	$contact_email_original = $contact_email;
	$contact_email = substr($contact_email, 0, 4) . '....';
	
}

$flat_no = $_SESSION['new-room-info'][$rand]['flat_no'];

if($flat_no != ''){
	
	if(strlen($flat_no) > 10){
		
		$flat_no_original = $flat_no;
		$flat_no = substr($flat_no, 0, 5) . '....';
		
	}
	
}

$floor = $_SESSION['new-room-info'][$rand]['floor'];

if($floor != ''){
	
	if(strlen($floor) > 3){
		
		$floor_original = number_format($floor);
		$floor = '999+';
		
	}
	else{
		
		$floor = $floor + 1;
		
	}
	
}

$size_of_flat = $_SESSION['new-room-info'][$rand]['size_of_flat'];

if($size_of_flat != ''){
	
	if(strlen($size_of_flat) > 12){
		
		$size_of_flat_original = number_format($size_of_flat)  . ' বর্গফুট';
		$size_of_flat = '999,999,999,999+ square feet';
		
	}
	else{
		
		$size_of_flat = number_format($size_of_flat)  . ' বর্গফুট';
		
	}
	
}

$size_of_room = $_SESSION['new-room-info'][$rand]['size_of_room'];

if($size_of_room != ''){
	
	if(strlen($size_of_room) > 12){
		
		$size_of_room_original = number_format($size_of_room)  . ' বর্গফুট';
		$size_of_room = '999,999,999,999+ square feet';
		
	}
	else{
		
		$size_of_room = number_format($size_of_room)  . ' বর্গফুট';
		
	}
	
}

$number_of_rooms = $_SESSION['new-room-info'][$rand]['number_of_rooms'];

if($number_of_rooms != ''){
	
	if(strlen($number_of_rooms) > 3){
		
		$number_of_rooms_original = number_format($number_of_rooms);
		$number_of_rooms = '999+';
		
	}
	
}

$number_of_washrooms = $_SESSION['new-room-info'][$rand]['number_of_washrooms'];

if($number_of_washrooms != ''){
	
	if(strlen($number_of_washrooms) > 3){
		
		$number_of_washrooms_original = number_format($number_of_washrooms);
		$number_of_washrooms = '999+';
		
	}
	
}

$washroom_attached = $_SESSION['new-room-info'][$rand]['washroom_attached'];

if($washroom_attached == 'Yes'){
	
	$washroom_attachedBengali = 'হ্যাঁ';
	
}
else{
	
	$washroom_attachedBengali = 'না';
	
}

$number_of_balconies = $_SESSION['new-room-info'][$rand]['number_of_balconies'];

if($number_of_balconies != ''){
	
	if(strlen($number_of_balconies) > 3){
		
		$number_of_balconies_original = number_format($number_of_balconies);
		$number_of_balconies = '999+';
		
	}
	
}

$balcony_attached = $_SESSION['new-room-info'][$rand]['balcony_attached'];

if($balcony_attached == 'Yes'){
	
	$balcony_attachedBengali = 'হ্যাঁ';
	
}
else{
	
	$balcony_attachedBengali = 'না';
	
}

$total_floors = $_SESSION['new-room-info'][$rand]['total_floors'];

if($total_floors != ''){
	
	if(strlen($total_floors) > 3){
		
		$total_floors_original = number_format($total_floors);
		$total_floors = '999+';
		
	}
	else{
		
		$total_floors = $total_floors + 1;
		
	}
	
}

if($_SESSION['new-room-info'][$rand]['lift'] == 'Yes'){
	
	$liftBengali = 'হ্যাঁ';
	
}
else{
	
	$liftBengali = 'না';
	
}

if($_SESSION['new-room-info'][$rand]['parking_facility'] == 'Yes'){
	
	$parking_facilityBengali = 'হ্যাঁ';
	
}
else{
	
	$parking_facilityBengali = 'না';
	
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
            <a href="advertisements">বিজ্ঞাপনসমূহ</a>
            <button id="lanButton" onClick="location.href='/<?php echo $pathUrl; ?>'">English</button>
        </div>
        
        <div class="topnav-right">
            <a href="profile"><?php echo $displayEmail; ?></a>
            <a href="logout?cbp=new-room-info-check-again">লগ আউট</a>
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
                <td id="everythingFirst"></td>
                <td id="everythingMiddle">
                	<div id="checkAgain">
						আপনার প্রদত্ত তথ্য আরেকবার দেখুন
					</div>
                	<?php
					
					$j = 0;
					
					for($i=1; $i<=5; $i++){
						
						if(isset($_SESSION['mark'][$rand]['photo_' . $i])){
							
							$photoNames[$j] = '../' . $_SESSION['mark'][$rand]['photo_' . $i];
							$j++;
							
						}
						
					}
					
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
                            <td colspan="2" id="adDetailsTableFirstColspan">
                                <table id="adDetailsTableLeft">
                                    <tr>
                                        <td>অবস্থা</td>
                                        <td>
                                            <span id="available">সক্রিয়</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>জায়গার প্রকার</td>
                                        <td>
                                            রুম<?php
                                            
                                                if($_SESSION['new-room-info'][$rand]['mess'] == 1){
                                                    
                                                    echo ', মেস';
                                                    
                                                }
                                            
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>বিজ্ঞাপনের প্রকার</td>
                                        <td>ভাড়া</td>
                                    </tr>
                                    <tr>
                                        <td>হস্তান্তরযোগ্যতার সময়</td>
                                        <td><?php echo $screenAvailableFrom ?></td>
                                    </tr>
                                    <tr>
                                        <td>যে বা যারা নিতে পারবে</td>
                                        <td>
                                            <?php
                                                
                                            if($_SESSION['new-room-info'][$rand]['male'] == 1){
                                                
                                                echo 'সিঙ্গেল (পুরুষ)';
                                                
                                            }
                                            
                                            if(($_SESSION['new-room-info'][$rand]['male'] == 0) && ($_SESSION['new-room-info'][$rand]['female'] == 1)){
                                                
                                                echo 'সিঙ্গেল (মহিলা)';
                                                
                                            }
                                            else if(($_SESSION['new-room-info'][$rand]['male'] == 1) && ($_SESSION['new-room-info'][$rand]['female'] == 1)){
                                                
                                                echo ',<br>সিঙ্গেল (মহিলা)';
                                                
                                            }
                                            
                                            if(($_SESSION['new-room-info'][$rand]['male'] == 0) && ($_SESSION['new-room-info'][$rand]['female'] == 0) && ($_SESSION['new-room-info'][$rand]['family'] == 1)){
                                                
                                                echo 'পরিবার';
                                                
                                            }
                                            else if((($_SESSION['new-room-info'][$rand]['male'] == 1) || ($_SESSION['new-room-info'][$rand]['female'] == 1)) && ($_SESSION['new-room-info'][$rand]['family'] == 1)){
                                                
                                                echo ',<br>পরিবার';
                                                
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
                                        <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $_SESSION['mark'][$rand]['latitude'] . ',' . $_SESSION['mark'][$rand]['longitude']; ?>">গুগল ম্যাপে দেখুন</a></td>
                                    </tr>
                                    <?php
                                    
                                    if($_SESSION['new-room-info'][$rand]['mess'] == 1){
                                        
                                        ?>
                                        <tr>
                                            <td>সর্বাধিক জনসংখ্যা (যদি মেস হিসেবে ব্যবহার করা হয়)</td>
                                            <td>
                                                <?php
                                                        
                                                if($_SESSION['new-room-info'][$rand]['max_people'] != ''){
                                                    
                                                    echo $max_people;
                                                    
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
                            <td colspan="3"><?php echo $security_money; if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">দেখান</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'জমা মূল্য: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">বন্ধ</button></div><?php } ?></td>
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
                            <td colspan="3"><div id="otherDescription"><?php echo $_SESSION['new-room-info'][$rand]['other_description']; ?></div></td>
                        </tr>
                    </table>
                    <form action="" method="post">
                    	<div id="submitDiv"><input type="submit" name="submit" id="submit" value="সম্পন্ন করুন"></div>
                        <div id="backDiv"><a id="backLink" href="<?php echo $urlBackPage; ?>">রুম-এর তথ্য এ ফিরে চলুন</a></div>
                    </form>
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

<?php

if(isset($_POST['submit'])){
	
	$latitude = $_SESSION['mark'][$rand]['latitude'];
	$longitude = $_SESSION['mark'][$rand]['longitude'];
	
	$flat = 0;
	$room = 1;
	$mess = $_SESSION['new-room-info'][$rand]['mess'];
	$officespace = 0;
	$shop = 0;
	$available_from = $_SESSION['new-room-info'][$rand]['available_from'];
	$male = $_SESSION['new-room-info'][$rand]['male'];
	$female = $_SESSION['new-room-info'][$rand]['female'];
	$family = $_SESSION['new-room-info'][$rand]['family'];
	$max_people = $_SESSION['new-room-info'][$rand]['max_people'];
	$rental_price = $_SESSION['new-room-info'][$rand]['rental_price'];
	$rental_price_nego = $_SESSION['new-room-info'][$rand]['rental_price_nego'];
	$security_money = $_SESSION['new-room-info'][$rand]['security_money'];
	$security_money_nego = $_SESSION['new-room-info'][$rand]['security_money_nego'];
	
	$full_address = $_SESSION['new-room-info'][$rand]['full_address'];
	$full_address = str_replace(' ','*^*',$full_address);
	
	$contact_no = $_SESSION['new-room-info'][$rand]['contact_no'];
	$contact_email = $_SESSION['new-room-info'][$rand]['contact_email'];
	
	$flat_no = $_SESSION['new-room-info'][$rand]['flat_no'];
	$flat_no = str_replace(' ','*^*',$flat_no);
	
	$floor = $_SESSION['new-room-info'][$rand]['floor'];
	$size_of_flat = $_SESSION['new-room-info'][$rand]['size_of_flat'];
	$size_of_room = $_SESSION['new-room-info'][$rand]['size_of_room'];
	$number_of_rooms = $_SESSION['new-room-info'][$rand]['number_of_rooms'];
	$number_of_washrooms = $_SESSION['new-room-info'][$rand]['number_of_washrooms'];
	$washroom_attached = $_SESSION['new-room-info'][$rand]['washroom_attached'];
	$number_of_balconies = $_SESSION['new-room-info'][$rand]['number_of_balconies'];
	$balcony_attached = $_SESSION['new-room-info'][$rand]['balcony_attached'];
	$total_floors = $_SESSION['new-room-info'][$rand]['total_floors'];
	$lift = $_SESSION['new-room-info'][$rand]['lift'];
	$parking_facility = $_SESSION['new-room-info'][$rand]['parking_facility'];
	
	$other_description = $_SESSION['new-room-info'][$rand]['other_description'];
	$other_description = str_replace(' ','*^*',$other_description);
	
	if(!file_exists('../db/db.php')){
		
		session_destroy();
		
		header('Location:error-db');
		exit;
		
	}
	
	$_SESSION['db'] = 1;
	include('../db/db.php');
	$_SESSION['db'] = NULL;
	
	date_default_timezone_set('UTC');
	$date = date("d-m-Y");
	$time = date("H:i:s");
	$timestamp = time();
	$randomkey = $id . '_' . $rand;
	
	$query = "INSERT INTO info(user_id,latitude,longitude,flat,room,mess,officespace,shop,available_from,male,female,family,max_people,rental_price,rental_price_nego,security_money,security_money_nego,full_address,contact_no,contact_email,flat_no,floor,size_of_flat,size_of_room,number_of_rooms,number_of_washrooms,washroom_attached,number_of_balconies,balcony_attached,total_floors,lift,parking_facility,other_description,date,time,timestamp,publish,randomkey) VALUES('$id','$latitude','$longitude','$flat','$room','$mess','$officespace','$shop','$available_from','$male','$female','$family','$max_people','$rental_price','$rental_price_nego','$security_money','$security_money_nego','$full_address','$contact_no','$contact_email','$flat_no','$floor','$size_of_flat','$size_of_room','$number_of_rooms','$number_of_washrooms','$washroom_attached','$number_of_balconies','$balcony_attached','$total_floors','$lift','$parking_facility','$other_description','$date','$time','$timestamp','1','$randomkey') ";
	$result = mysqli_query($dbcInsert,$query);
	
	if($result){
		
		$_SESSION['new-room-info-error'][$rand] = NULL;
		$_SESSION['new-room-info'][$rand] = NULL;
		
		$query = "SELECT id FROM info WHERE randomkey='$randomkey'";
		$result = mysqli_query($dbc,$query);
		$row = mysqli_fetch_array($result);
		
		$adID = $row['id'];
		
		$imageAddress = $adID . '_' . $rand;
		
		if(isset($_SESSION['mark'][$rand]['photo_1'])){
			
			$explode = explode('.',$_SESSION['mark'][$rand]['photo_1']);
			$extension = $explode[1];
			$preAddress = '../uploadedPhotos/temp/' . $randomkey . '_1.' . $extension;
			$newAddress = '../uploadedPhotos/' . $imageAddress . '_1.' . $extension;
			
			rename($preAddress, $newAddress);
			
		}
		
		if(isset($_SESSION['mark'][$rand]['photo_2'])){
			
			$explode = explode('.',$_SESSION['mark'][$rand]['photo_2']);
			$extension = $explode[1];
			$preAddress = '../uploadedPhotos/temp/' . $randomkey . '_2.' . $extension;
			$newAddress = '../uploadedPhotos/' . $imageAddress . '_2.' . $extension;
			
			rename($preAddress, $newAddress);
			
		}
		
		if(isset($_SESSION['mark'][$rand]['photo_3'])){
			
			$explode = explode('.',$_SESSION['mark'][$rand]['photo_3']);
			$extension = $explode[1];
			$preAddress = '../uploadedPhotos/temp/' . $randomkey . '_3.' . $extension;
			$newAddress = '../uploadedPhotos/' . $imageAddress . '_3.' . $extension;
			
			rename($preAddress, $newAddress);
			
		}
		
		if(isset($_SESSION['mark'][$rand]['photo_4'])){
			
			$explode = explode('.',$_SESSION['mark'][$rand]['photo_4']);
			$extension = $explode[1];
			$preAddress = '../uploadedPhotos/temp/' . $randomkey . '_4.' . $extension;
			$newAddress = '../uploadedPhotos/' . $imageAddress . '_4.' . $extension;
			
			rename($preAddress, $newAddress);
			
		}
		
		if(isset($_SESSION['mark'][$rand]['photo_5'])){
			
			$explode = explode('.',$_SESSION['mark'][$rand]['photo_5']);
			$extension = $explode[1];
			$preAddress = '../uploadedPhotos/temp/' . $randomkey . '_5.' . $extension;
			$newAddress = '../uploadedPhotos/' . $imageAddress . '_5.' . $extension;
			
			rename($preAddress, $newAddress);
			
		}
		
		$_SESSION['mark'][$rand] = NULL;
		
		$query = "UPDATE info SET randomkey='$rand' WHERE id='$adID'";
		$result = mysqli_query($dbcUpdate,$query);
		
		$query = "DELETE FROM uploadedphoto WHERE user_id='$id' AND randomkey='$rand'";
		$result = mysqli_query($dbcDelete,$query);
		
		header('Location:' . $urlNextPage);
		exit;
		
	}
	else{
		
		header('Location:error?frm=new-room-info-check-again&content=new-room&key' . $rand);
		exit;
		
	}
	
}

ob_end_flush();

?>

</html>