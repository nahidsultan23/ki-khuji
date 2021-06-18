<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);
$_SESSION['comebackUrl']['new-flat-info-check-again'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=new-flat-info');
	exit;
	
}

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$displayEmail = $_SESSION['displayEmail'];

$_SESSION['getip'] = 1;
include('getip.php');
$_SESSION['getip'] = NULL;

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Check Again</title>
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/new-flat-info-check-again.css">
    
    <script src="js/clock.js"></script>
    <script src="js/details.js"></script>
</head>

<?php

$urlNextPage = 'successful?content=new-flat';
$urlBackPage = 'new-flat-info';

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

if(!isset($_SESSION['new-flat-info'][$rand])){
		
	header('Location:' . $urlBackPage);
	exit;
	
}

$urlBackPage = $urlBackPage . '?key=' . $rand;

$screenAvailableFrom = date('d F, Y',strtotime($_SESSION['new-flat-info'][$rand]['available_from']));

$max_people = $_SESSION['new-flat-info'][$rand]['max_people'];

if($max_people != ''){
	
	if(strlen($max_people) > 3){
		
		$max_people_original = $max_people;
		$max_people = '999+';
		
	}
	
}

$rental_price = $_SESSION['new-flat-info'][$rand]['rental_price'];
$rental_price_nego = $_SESSION['new-flat-info'][$rand]['rental_price_nego'];

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

$security_money = $_SESSION['new-flat-info'][$rand]['security_money'];
$security_money_nego = $_SESSION['new-flat-info'][$rand]['security_money_nego'];

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

$full_address = $_SESSION['new-flat-info'][$rand]['full_address'];

if($full_address != ''){
	
	if(strlen($full_address) > 500){
		
		$full_address_original = $full_address;
		$full_address = substr($full_address, 0, 450) . '....';
		
	}
	
}

$contact_no = $_SESSION['new-flat-info'][$rand]['contact_no'];

if($contact_no != ''){
	
	$contact_no_original = $contact_no;
	$contact_no = substr($contact_no, 0, 6) . '....';
	
}

$contact_email = $_SESSION['new-flat-info'][$rand]['contact_email'];

if($contact_email != ''){
	
	$contact_email_original = $contact_email;
	$contact_email = substr($contact_email, 0, 4) . '....';
	
}

$flat_no = $_SESSION['new-flat-info'][$rand]['flat_no'];

if($flat_no != ''){
	
	if(strlen($flat_no) > 10){
		
		$flat_no_original = $flat_no;
		$flat_no = substr($flat_no, 0, 5) . '....';
		
	}
	
}

$floor = $_SESSION['new-flat-info'][$rand]['floor'];

if($floor != ''){
	
	if(strlen($floor) > 3){
		
		$floor_original = number_format($floor);
		$floor = '999+';
		
	}
	
}

$size_of_flat = $_SESSION['new-flat-info'][$rand]['size_of_flat'];

if($size_of_flat != ''){
	
	if(strlen($size_of_flat) > 12){
		
		$size_of_flat_original = number_format($size_of_flat)  . ' square feet';
		$size_of_flat = '999,999,999,999+ square feet';
		
	}
	else{
		
		$size_of_flat = number_format($size_of_flat)  . ' square feet';
		
	}
	
}

$number_of_rooms = $_SESSION['new-flat-info'][$rand]['number_of_rooms'];

if($number_of_rooms != ''){
	
	if(strlen($number_of_rooms) > 3){
		
		$number_of_rooms_original = number_format($number_of_rooms);
		$number_of_rooms = '999+';
		
	}
	
}

$number_of_washrooms = $_SESSION['new-flat-info'][$rand]['number_of_washrooms'];

if($number_of_washrooms != ''){
	
	if(strlen($number_of_washrooms) > 3){
		
		$number_of_washrooms_original = number_format($number_of_washrooms);
		$number_of_washrooms = '999+';
		
	}
	
}

$number_of_balconies = $_SESSION['new-flat-info'][$rand]['number_of_balconies'];

if($number_of_balconies != ''){
	
	if(strlen($number_of_balconies) > 3){
		
		$number_of_balconies_original = number_format($number_of_balconies);
		$number_of_balconies = '999+';
		
	}
	
}

$total_floors = $_SESSION['new-flat-info'][$rand]['total_floors'];

if($total_floors != ''){
	
	if(strlen($total_floors) > 3){
		
		$total_floors_original = number_format($total_floors);
		$total_floors = '999+';
		
	}
	
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
            <a href="logout?cbp=new-flat-info-check-again">Log Out</a>
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
						Check your given info again
					</div>
                	<?php
					
					$j = 0;
					
					for($i=1; $i<=5; $i++){
						
						if(isset($_SESSION['mark'][$rand]['photo_' . $i])){
							
							$photoNames[$j] = $_SESSION['mark'][$rand]['photo_' . $i];
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
                            <td colspan="2" id="adDetailsTableFirstColspan">
                                <table id="adDetailsTableLeft">
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            <span id="available">Available</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Accommodation type</td>
                                        <td>
                                            Flat<?php
                                                
                                            if($_SESSION['new-flat-info'][$rand]['mess'] == 1){
                                                
                                                echo ', Mess';
                                                
                                            }
                                                
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Advertisement for</td>
                                        <td><?php if($_SESSION['new-flat-info'][$rand]['rent'] == 1){ echo 'Rent'; }else if($sale == 1){ echo 'Sale'; } ?></td>
                                    </tr>
                                    <tr>
                                        <td>Available from</td>
                                        <td><?php echo $screenAvailableFrom ?></td>
                                    </tr>
                                    <?php
                                    
                                    if($_SESSION['new-flat-info'][$rand]['rent'] == 1){
                                        
                                        ?>
                                        <tr>
                                            <td>Available for</td>
                                            <td>
                                                <?php
                                                    
                                                if($_SESSION['new-flat-info'][$rand]['male'] == 1){
                                                    
                                                    echo 'Single (Male)';
                                                    
                                                }
                                                
                                                if(($_SESSION['new-flat-info'][$rand]['male'] == 0) && ($_SESSION['new-flat-info'][$rand]['female'] == 1)){
                                                    
                                                    echo 'Single (Female)';
                                                    
                                                }
                                                else if(($_SESSION['new-flat-info'][$rand]['male'] == 1) && ($_SESSION['new-flat-info'][$rand]['female'] == 1)){
                                                    
                                                    echo ',<br>Single (Female)';
                                                    
                                                }
                                                
                                                if(($_SESSION['new-flat-info'][$rand]['male'] == 0) && ($_SESSION['new-flat-info'][$rand]['female'] == 0) && ($_SESSION['new-flat-info'][$rand]['family'] == 1)){
                                                    
                                                    echo 'Family';
                                                    
                                                }
                                                else if((($_SESSION['new-flat-info'][$rand]['male'] == 1) || ($_SESSION['new-flat-info'][$rand]['female'] == 1)) && ($_SESSION['new-flat-info'][$rand]['family'] == 1)){
                                                    
                                                    echo ',<br>Family';
                                                    
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
                                        <td id="adDetailsTableRightRightColumn"><a target="_blank" id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $_SESSION['mark'][$rand]['latitude'] . ',' . $_SESSION['mark'][$rand]['longitude']; ?>">Find on Google Map</a></td>
                                    </tr>
                                    <?php
                                    
                                    if($_SESSION['new-flat-info'][$rand]['mess'] == 1){
                                        
                                        ?>
                                        <tr>
                                            <td>Maximum number of people (in case of using as a mess)</td>
                                            <td>
                                                <?php
                                                        
                                                if($max_people != ''){
                                                    
                                                    echo $max_people;
                                                    
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
                        
                        if($_SESSION['new-flat-info'][$rand]['sale'] == 1){
                            
                            ?>
                            <tr>
                                <td><span id="paddingToAlign">Price</span></td>
                                <td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">Show</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Price: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">close</button></div><?php } ?></td>
                            </tr>
                            <tr>
                                <td><span id="paddingToAlign">Booking money</span></td>
                                <td colspan="3"><?php echo $security_money; if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">Show</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Booking money: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">close</button></div><?php } ?></td>
                            </tr>
                            <?php
                            
                        }
                        else if($_SESSION['new-flat-info'][$rand]['rent'] == 1){
                            
                            ?>
                            <tr>
                                <td><span id="paddingToAlign">Rental price per month</span></td>
                                <td colspan="3"><?php echo $rental_price; if(isset($rental_price_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('rentalPriceDiv')">Show</a><div id="rentalPriceDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Rental price per month: ' . $rental_price_original; ?><button id="closeButton" onClick="popDown('rentalPriceDiv')">close</button></div><?php } ?></td>
                            </tr>
                            <tr>
                                <td><span id="paddingToAlign">Security money</span></td>
                                <td colspan="3"><?php echo $security_money; if(isset($security_money_original)){ ?> <a id="fullLengthViewLink" onClick="popUp('securityMoneyDiv')">Show</a><div id="securityMoneyDiv" class="fullLengthViewDiv" style="display:none"><?php echo 'Security money: ' . $security_money_original; ?><button id="closeButton" onClick="popDown('securityMoneyDiv')">close</button></div><?php } ?></td>
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
                                        <td><?php echo $_SESSION['new-flat-info'][$rand]['lift']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Parking facility</td>
                                        <td><?php echo $_SESSION['new-flat-info'][$rand]['parking_facility']; ?></td>
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
                            <td colspan="3"><div id="otherDescription"><?php echo $_SESSION['new-flat-info'][$rand]['other_description']; ?></div></td>
                        </tr>
                    </table>
					<form action="" method="post">
                    	<div id="submitDiv"><input type="submit" name="submit" id="submit" value="Proceed"></div>
                        <div id="backDiv"><a id="backLink" href="<?php echo $urlBackPage; ?>">Back to New Flat Info</a></div>
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
        <td id="bottomContentsSecond">Contact us at <span id="helloEmail">hello@kikhuji.com</span></td>
        <td id="bottomContentsLast"></td></tr>
    </table>
</body>

</html>

<?php

if(isset($_POST['submit'])){
	
	$latitude = $_SESSION['mark'][$rand]['latitude'];
	$longitude = $_SESSION['mark'][$rand]['longitude'];
	
	$flat = 1;
	$room = 0;
	$mess = $_SESSION['new-flat-info'][$rand]['mess'];
	$officespace = 0;
	$shop = 0;
	$sale = $_SESSION['new-flat-info'][$rand]['sale'];
	$rent = $_SESSION['new-flat-info'][$rand]['rent'];
	$available_from = $_SESSION['new-flat-info'][$rand]['available_from'];
	$male = $_SESSION['new-flat-info'][$rand]['male'];
	$female = $_SESSION['new-flat-info'][$rand]['female'];
	$family = $_SESSION['new-flat-info'][$rand]['family'];
	$max_people = $_SESSION['new-flat-info'][$rand]['max_people'];
	$rental_price = $_SESSION['new-flat-info'][$rand]['rental_price'];
	$rental_price_nego = $_SESSION['new-flat-info'][$rand]['rental_price_nego'];
	$security_money = $_SESSION['new-flat-info'][$rand]['security_money'];
	$security_money_nego = $_SESSION['new-flat-info'][$rand]['security_money_nego'];
	
	$full_address = $_SESSION['new-flat-info'][$rand]['full_address'];
	$full_address = str_replace(' ','*^*',$full_address);
	
	$contact_no = $_SESSION['new-flat-info'][$rand]['contact_no'];
	$contact_email = $_SESSION['new-flat-info'][$rand]['contact_email'];
	
	$flat_no = $_SESSION['new-flat-info'][$rand]['flat_no'];
	$flat_no = str_replace(' ','*^*',$flat_no);
	
	$floor = $_SESSION['new-flat-info'][$rand]['floor'];
	$size_of_flat = $_SESSION['new-flat-info'][$rand]['size_of_flat'];
	$number_of_rooms = $_SESSION['new-flat-info'][$rand]['number_of_rooms'];
	$number_of_washrooms = $_SESSION['new-flat-info'][$rand]['number_of_washrooms'];
	$number_of_balconies = $_SESSION['new-flat-info'][$rand]['number_of_balconies'];
	$total_floors = $_SESSION['new-flat-info'][$rand]['total_floors'];
	$lift = $_SESSION['new-flat-info'][$rand]['lift'];
	$parking_facility = $_SESSION['new-flat-info'][$rand]['parking_facility'];
	
	$other_description = $_SESSION['new-flat-info'][$rand]['other_description'];
	$other_description = str_replace(' ','*^*',$other_description);
	
	if(!file_exists('db/db.php')){
		
		session_destroy();
		
		header('Location:error-db');
		exit;
		
	}

	$_SESSION['db'] = 1;
	include('db/db.php');
	$_SESSION['db'] = NULL;
	
	date_default_timezone_set('UTC');
	$date = date("d-m-Y");
	$time = date("H:i:s");
	$timestamp = time();
	$randomkey = $id . '_' . $rand;
	
	$query = "INSERT INTO info(user_id,latitude,longitude,sale,rent,flat,room,mess,officespace,shop,available_from,male,female,family,max_people,rental_price,rental_price_nego,security_money,security_money_nego,full_address,contact_no,contact_email,flat_no,floor,size_of_flat,number_of_rooms,number_of_washrooms,number_of_balconies,total_floors,lift,parking_facility,other_description,date,time,timestamp,publish,randomkey) VALUES('$id','$latitude','$longitude','$sale','$rent','$flat','$room','$mess','$officespace','$shop','$available_from','$male','$female','$family','$max_people','$rental_price','$rental_price_nego','$security_money','$security_money_nego','$full_address','$contact_no','$contact_email','$flat_no','$floor','$size_of_flat','$number_of_rooms','$number_of_washrooms','$number_of_balconies','$total_floors','$lift','$parking_facility','$other_description','$date','$time','$timestamp','1','$randomkey')";
	$result = mysqli_query($dbcInsert,$query);
	
	if($result){
		
		$_SESSION['new-flat-info-error'][$rand] = NULL;
		$_SESSION['new-flat-info'][$rand] = NULL;
		
		$query = "SELECT id FROM info WHERE randomkey='$randomkey'";
		$result = mysqli_query($dbc,$query);
		$row = mysqli_fetch_array($result);
		
		$adID = $row['id'];
		
		$imageAddress = $adID . '_' . $rand;
		
		if(isset($_SESSION['mark'][$rand]['photo_1'])){
			
			$explode = explode('.',$_SESSION['mark'][$rand]['photo_1']);
			$extension = $explode[1];
			$preAddress = 'uploadedPhotos/temp/' . $randomkey . '_1.' . $extension;
			$newAddress = 'uploadedPhotos/' . $imageAddress . '_1.' . $extension;
			
			rename($preAddress, $newAddress);
			
		}
		
		if(isset($_SESSION['mark'][$rand]['photo_2'])){
			
			$explode = explode('.',$_SESSION['mark'][$rand]['photo_2']);
			$extension = $explode[1];
			$preAddress = 'uploadedPhotos/temp/' . $randomkey . '_2.' . $extension;
			$newAddress = 'uploadedPhotos/' . $imageAddress . '_2.' . $extension;
			
			rename($preAddress, $newAddress);
			
		}
		
		if(isset($_SESSION['mark'][$rand]['photo_3'])){
			
			$explode = explode('.',$_SESSION['mark'][$rand]['photo_3']);
			$extension = $explode[1];
			$preAddress = 'uploadedPhotos/temp/' . $randomkey . '_3.' . $extension;
			$newAddress = 'uploadedPhotos/' . $imageAddress . '_3.' . $extension;
			
			rename($preAddress, $newAddress);
			
		}
		
		if(isset($_SESSION['mark'][$rand]['photo_4'])){
			
			$explode = explode('.',$_SESSION['mark'][$rand]['photo_4']);
			$extension = $explode[1];
			$preAddress = 'uploadedPhotos/temp/' . $randomkey . '_4.' . $extension;
			$newAddress = 'uploadedPhotos/' . $imageAddress . '_4.' . $extension;
			
			rename($preAddress, $newAddress);
			
		}
		
		if(isset($_SESSION['mark'][$rand]['photo_5'])){
			
			$explode = explode('.',$_SESSION['mark'][$rand]['photo_5']);
			$extension = $explode[1];
			$preAddress = 'uploadedPhotos/temp/' . $randomkey . '_5.' . $extension;
			$newAddress = 'uploadedPhotos/' . $imageAddress . '_5.' . $extension;
			
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
		
		header('Location:error?frm=new-flat-info-check-again&content=new-flat&key=' . $rand);
		exit;
		
	}
	
}

ob_end_flush();

?>