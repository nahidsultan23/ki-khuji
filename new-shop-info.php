<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);
$_SESSION['comebackUrl']['new-shop-info'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=new-shop-info');
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
    <title>Ki Khuji - New Shop Info</title>
    
    <link rel="stylesheet" href="css/jquery_ui.css">
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/new-shop-info.css">

	<script src="js/clock.js"></script>
	<script src="js/jquery.js"></script>
    <script src="js/jquery_ui.js"></script>
    <script src="js/new-shop-info.js"></script>
</head>

<?php

$urlNextPage = 'new-shop-info-check-again';
$urlBackPage = 'mark?content=shop';

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

if(!isset($_SESSION['mark'][$rand])){
		
	header('Location:' . $urlBackPage);
	exit;
	
}

$urlNextPage = $urlNextPage . '?key=' . $rand;
$urlBackPage = $urlBackPage . '&key=' . $rand;

$sale = 0;
$rent = 1;
$rental_price_nego = 0;
$security_money_nego = 0;
$contact_no_option = '+880';
$lift = 'No';
$elevator = 'No';
$parking_facility = 'No';

if(isset($_SESSION['new-shop-info-error'][$rand])){
	
	$sale = $_SESSION['new-shop-info-error'][$rand]['sale'];
	$rent = $_SESSION['new-shop-info-error'][$rand]['rent'];
	$available_from = $_SESSION['new-shop-info-error'][$rand]['available_from'];
	$rental_price = $_SESSION['new-shop-info-error'][$rand]['rental_price'];
	$rental_price_nego = $_SESSION['new-shop-info-error'][$rand]['rental_price_nego'];
	$security_money = $_SESSION['new-shop-info-error'][$rand]['security_money'];
	$security_money_nego = $_SESSION['new-shop-info-error'][$rand]['security_money_nego'];
	$full_address = $_SESSION['new-shop-info-error'][$rand]['full_address'];
	$contact_no = $_SESSION['new-shop-info-error'][$rand]['contact_no'];
	$contact_email = $_SESSION['new-shop-info-error'][$rand]['contact_email'];
	$flat_no = $_SESSION['new-shop-info-error'][$rand]['flat_no'];
	$floor = $_SESSION['new-shop-info-error'][$rand]['floor'];
	$size_of_flat = $_SESSION['new-shop-info-error'][$rand]['size_of_flat'];
	$total_floors = $_SESSION['new-shop-info-error'][$rand]['total_floors'];
	$lift = $_SESSION['new-shop-info-error'][$rand]['lift'];
	$elevator = $_SESSION['new-shop-info-error'][$rand]['elevator'];
	$parking_facility = $_SESSION['new-shop-info-error'][$rand]['parking_facility'];
	$other_description = $_SESSION['new-shop-info-error'][$rand]['other_description'];
	
}

if(isset($_GET['date'])){
	
	?>
    <style>
		#date{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
}
if(isset($_GET['rent'])){
	
	?>
    <style>
		#rent{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
}
if(isset($_GET['sc'])){
	
	?>
    <style>
		#sc{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
}
if(isset($_GET['address'])){
	
	?>
    <style>
		#address{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
}
if(isset($_GET['cn'])){
	
	?>
    <style>
		#cn{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
}
if(isset($_GET['email'])){
	
	?>
    <style>
		#email{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
}
if(isset($_GET['flat'])){
	
	?>
    <style>
		#flat{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
}
if(isset($_GET['floor'])){
	
	?>
    <style>
		#floor{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
}
if(isset($_GET['fl-sz'])){
	
	?>
    <style>
		#fl-sz{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
}
if(isset($_GET['tot-floor'])){
	
	?>
    <style>
		#tot-floor{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
}
if(isset($_GET['oth-des'])){
	
	?>
    <style>
		#oth-des{
			
			visibility:visible;
			
		}
	</style>
    <?php
	
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
                <button id="lanButton" onClick="location.href='/bn/<?php echo $pathUrl; ?>'">???????????????</button>
                <?php
				
			}
			
			?>
        </div>
        
        <div class="topnav-right">
            <a href="profile"><?php echo $displayEmail; ?></a>
            <a href="logout?cbp=new-shop-info">Log Out</a>
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
        <form action="" method="post">
            <table id="shopInfo">
                <tr id="heading"><td colspan="2">Enter some information about the Shop</td></tr>
                <tr>
                    <td id="firstColumn">Location (According to Google Map)</td><td id="secondColumn"><?php echo $_SESSION['mark'][$rand]['current-place']; ?></td>
                </tr>
                <tr><td>Advertisement type</td> <td><select name="adType"  onchange="changeAdType(this)">
                            <option value="sale" <?php if($sale == 1){ echo 'selected'; } ?> >Sale</option>
                            <option value="rent" <?php if($rent == 1){ echo 'selected'; } ?> >Rent</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Available from</td><td><input type="text" id="datepicker" name="available_from" value="<?php if(isset($available_from)){ echo $available_from; }else{ echo date("d-m-Y"); } ?>" readonly /> <span id="date" class="sidenote">Date formation is incorrect</span></td>
                </tr>
                <tr>
                    <td><span id="rentalPriceName" <?php if($sale == 1){ ?>style="display:none"<?php } ?> >Rental price per month</span><span id="priceName" <?php if($rent == 1){ ?>style="display:none"<?php } ?> >Price</span></td> <td><input type="text" name="rental-price" <?php if(isset($rental_price)){ ?>value="<?php echo $rental_price; ?>"<?php } ?> pattern="^[0-9.]+"> BDT <input type="checkbox" name="rental-price-checkbox" id="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> >Negotiable <span id="rent" class="sidenote">Enter a valid amount</span></td>
                </tr>
                <tr>
                    <td><span id="securityMoneyName" <?php if($sale == 1){ ?>style="display:none"<?php } ?> >Security money<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">Amount that will be taken before the space is being used and won't be returned before the shop is left.</span></span><span id="bookingMoneyName" <?php if($rent == 1){ ?>style="display:none"<?php } ?> >Booking money<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">Amount that will be taken initially to start the purchasing process.</span></span></td> <td><input type="text" name="security-money" <?php if(isset($security_money)){ ?>value="<?php echo $security_money; ?>"<?php } ?> pattern="^[0-9.]+"> BDT <input type="checkbox" name="security-money-checkbox" id="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>>Negotiable <span id="sc" class="sidenote">Enter a valid amount</span></td>
                </tr>
                <tr>
                    <td>Full Address</td> <td><textarea name="full-address" placeholder="This part will be shown in your advertisement with big letters. Make sure you only write the full address here. e.g. Super Market, Road No : 2/A, Bengali Street, Dhaka, Bangladesh. If you have any other information to mention, write it in 'Other description' field which you will find in the bottom of this form."><?php if(isset($full_address)){ echo $full_address; } ?></textarea> <span id="address" class="sidenote">Use valid characters</span></td>
                </tr>
                <tr>
                    <td>Contact no.</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >Bangladesh(+880)</option></select> <input type="text" name="contact-no" id="contact-no" <?php if(isset($contact_no)){ ?>value="<?php echo $contact_no; ?>"<?php } ?> pattern="^[0-9]+"> <span id="cn" class="sidenote">Enter a valid number</span></td>
                </tr>
                <tr>
                    <td>Email</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" <?php if(isset($contact_email)){ ?>value="<?php echo $contact_email; ?>"<?php } ?> > <span id="email" class="sidenote">Enter a valid Email</span></td>
                </tr>
                
                <tr id="additionalHeading">
                    <td colspan="2">Additional Info</td>
                </tr>
    
                <tr>
                    <td>Shop no.</td> <td><input type="text" name="shop-no" <?php if(isset($flat_no)){ ?>value="<?php echo $flat_no; ?>"<?php } ?> ></td> <span id="flat" class="sidenote">Use valid characters</span></td>
                </tr>
                <tr>
                    <td>Floor</td> <td><input type="text" name="floor" <?php if(isset($floor)){ ?>value="<?php echo $floor; ?>"<?php } ?> pattern="^[0-9-]+"> <span id="floor" class="sidenote">Enter a valid number</span></td>
                </tr>
                <tr>
                    <td>Size of the shop</td> <td><input type="text" name="shop-size" <?php if(isset($size_of_flat)){ ?>value="<?php echo $size_of_flat; ?>"<?php } ?> pattern="^[0-9.]+"> square feet <span id="fl-sz" class="sidenote">Enter a valid size</span></td>
                </tr>
                <tr>
                    <td>Total number of floors in the building</td> <td><input type="text" name="total-floor" <?php if(isset($total_floors)){ ?>value="<?php echo $total_floors; ?>"<?php } ?> pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">Enter a valid number</span></td>
                </tr>
                <tr>
                    <td>Is there any lift to reach the floor containing this shop?</td> <td><select name="lift">
                            <option value="Yes" <?php if($lift == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                            <option value="No" <?php if($lift == 'No'){ echo 'selected'; } ?> >No</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Is there any elevator to reach the floor containing this shop?</td> <td><select name="elevator">
                            <option value="Yes" <?php if($elevator == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                            <option value="No" <?php if($elevator == 'No'){ echo 'selected'; } ?> >No</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Is there any parking facility in the building?</td> <td><select name="parking-facility">
                            <option value="Yes" <?php if($parking_facility == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                            <option value="No" <?php if($parking_facility == 'No'){ echo 'selected'; } ?> >No</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Other description</td> <td><textarea name="other-description" placeholder="Write any additional information you want to mention. e.g. The shop is well decorated and well painted. It is in front of the market........, etc. Additional phone number : 01............, 02........... Additional Email : no-reply@kikhuji.com"><?php if(isset($other_description)){ echo $other_description; } ?></textarea> <span id="oth-des" class="sidenote">Use valid characters</span></td>
                </tr>
                <tr>
                	<td>Photos</td>
                    <td id="photos">
                        <div id="allForms">
                            <form>
                            </form>
                            
                            <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                <input type="hidden" name="key_1" id="key_1" value="<?php echo $rand; ?>">
                                
                                <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$rand]['photo_1'])){ ?>style="display:none"<?php } ?>>
                                    <button type="button" class="btn_1">+</button>
                                    <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                </div>
                                
                                <div id="progressbarContainer_1" style="display:none">
                                    <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                </div>
                                <h3 id="status"></h3>
                                <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$rand]['photo_1'])){ ?>src="<?php echo $_SESSION['mark'][$rand]['photo_1']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                
                                <div id="remove_1">
                                    <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                </div>
                            </form>
                            
                            <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                <input type="hidden" name="key_2" id="key_2" value="<?php echo $rand; ?>">
                                
                                <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$rand]['photo_2'])){ ?>style="display:none"<?php } ?>>
                                    <button type="button" class="btn_2">+</button>
                                    <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                </div>
                                
                                <div id="progressbarContainer_2" style="display:none">
                                    <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                </div>
                                <h3 id="status"></h3>
                                <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$rand]['photo_2'])){ ?>src="<?php echo $_SESSION['mark'][$rand]['photo_2']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                
                                <div id="remove_2">
                                    <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                </div>
                            </form>
                            
                            <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                <input type="hidden" name="key_3" id="key_3" value="<?php echo $rand; ?>">
                                
                                <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$rand]['photo_3'])){ ?>style="display:none"<?php } ?>>
                                    <button type="button" class="btn_3">+</button>
                                    <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                </div>
                                
                                <div id="progressbarContainer_3" style="display:none">
                                    <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                </div>
                                <h3 id="status"></h3>
                                <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$rand]['photo_3'])){ ?>src="<?php echo $_SESSION['mark'][$rand]['photo_3']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                
                                <div id="remove_3">
                                    <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                </div>
                            </form>
                            
                            <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                <input type="hidden" name="key_4" id="key_4" value="<?php echo $rand; ?>">
                                
                                <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$rand]['photo_4'])){ ?>style="display:none"<?php } ?>>
                                    <button type="button" class="btn_4">+</button>
                                    <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                </div>
                                
                                <div id="progressbarContainer_4" style="display:none">
                                    <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                </div>
                                <h3 id="status"></h3>
                                <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$rand]['photo_4'])){ ?>src="<?php echo $_SESSION['mark'][$rand]['photo_4']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                
                                <div id="remove_4">
                                    <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                </div>
                            </form>
                            
                            <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                <input type="hidden" name="key_5" id="key_5" value="<?php echo $rand; ?>">
                                
                                <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$rand]['photo_5'])){ ?>style="display:none"<?php } ?>>
                                    <button type="button" class="btn_5">+</button>
                                    <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                </div>
                                
                                <div id="progressbarContainer_5" style="display:none">
                                    <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                </div>
                                <h3 id="status"></h3>
                                <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$rand]['photo_5'])){ ?>src="<?php echo $_SESSION['mark'][$rand]['photo_5']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                
                                <div id="remove_5">
                                    <button type="button" class="remove_5" onClick="remove_5()">X</button>
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr id="submitRow">
                    <td colspan="2"><input type="submit" name="submit" id="submit" value="Proceed"></td>
                </tr>
                <tr id="backRow">
                    <td colspan="2"><a id="backLink" href="<?php echo $urlBackPage; ?>">Back to Advertise</a></td>
                </tr>
            </table>
        </form>
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
	
	$errorFound = 0;
	$error_link = 'new-shop-info?key=' . $rand;
	
	$sale = 0;
	$rent = 1;
	
	if($_POST['adType'] == 'sale'){
		
		$sale = 1;
		$rent = 0;
		
	}
	
	$_SESSION['new-shop-info-error'][$rand]['sale'] = $sale;
	$_SESSION['new-shop-info-error'][$rand]['rent'] = $rent;
	
	$available_from = $_POST['available_from'];
	$_SESSION['new-shop-info-error'][$rand]['available_from'] = $available_from;
	
	$available_fromx = strip_tags($available_from);
	$available_from = str_replace(' ','',$available_fromx);
	
	if(!preg_match("/^[0-9-]+$/", $available_from)){
	
		$errorFound = 1;
		$error_link = $error_link . '&date=0';
		
	}
	else{
		
		list($dd,$mm,$yyyy) = explode('-',$available_from);
		
		if(!checkdate($mm,$dd,$yyyy)){
			
			$errorFound = 1;
			$error_link = $error_link . '&date=0';
			
		}
		else if(!(($yyyy >= date("Y")-10) && ($yyyy <= date("Y")+10))){
			
			$errorFound = 1;
			$error_link = $error_link . '&date=0';
			
		}
		else if($yyyy == date("Y")+10){
			
			if($mm > date("m")){
				
				$errorFound = 1;
				$error_link = $error_link . '&date=0';
				
			}
			else if($mm == date("m")){
				
				if($dd > date("d")){
					
					$errorFound = 1;
					$error_link = $error_link . '&date=0';
					
				}
				
			}
			
		}
		else if($yyyy == date("Y")-10){
			
			if($mm < date("m")){
				
				$errorFound = 1;
				$error_link = $error_link . '&date=0';
				
			}
			else if($mm == date("m")){
				
				if($dd < date("d")){
					
					$errorFound = 1;
					$error_link = $error_link . '&date=0';
					
				}
				
			}
			
		}
		
	}
	
	$rental_price = $_POST['rental-price'];
	$_SESSION['new-shop-info-error'][$rand]['rental_price'] = $rental_price;
	
	if($rental_price != ''){
		
		$rental_pricex = strip_tags($rental_price);
		$rental_price = str_replace(' ','',$rental_pricex);
		
		if(!preg_match("/^[0-9.]+$/",$rental_price)){
		
			$errorFound = 1;
			$error_link = $error_link . '&rent=0';
			
		}
		
		$rental_price_nego = 0;
		
		if(isset($_POST['rental-price-checkbox'])){
			
			$rental_price_nego = 1;
			
		}
		
	}
	else{
		
		$rental_price_nego = 0;
		
	}
	
	$_SESSION['new-shop-info-error'][$rand]['rental_price_nego'] = $rental_price_nego;
	
	$security_money = $_POST['security-money'];
	$_SESSION['new-shop-info-error'][$rand]['security_money'] = $security_money;
	
	if($security_money != ''){
		
		$security_moneyx = strip_tags($security_money);
		$security_money = str_replace(' ','',$security_moneyx);
		
		if(!preg_match("/^[0-9.]+$/",$security_money)){
		
			$errorFound = 1;
			$error_link = $error_link . '&sc=0';
			
		}
		
		$security_money_nego = 0;
		
		if(isset($_POST['security-money-checkbox'])){
			
			$security_money_nego = 1;
			
		}
		
	}
	else{
		
		$security_money_nego = 0;
		
	}
	
	$_SESSION['new-shop-info-error'][$rand]['security_money_nego'] = $security_money_nego;
	
	$full_address = $_POST['full-address'];
	$_SESSION['new-shop-info-error'][$rand]['full_address'] = $full_address;
	
	if($full_address != ''){
		
		$partFullAddress1 = strstr($full_address,';');
		$partFullAddress2 = strstr($full_address,'"');
		$partFullAddress3 = strstr($full_address,"'");
		$partFullAddress4 = strstr($full_address,'*');
		$partFullAddress5 = strstr($full_address,'^');
		
		if((strlen($partFullAddress1) > 0) || (strlen($partFullAddress2) > 0) || (strlen($partFullAddress3) > 0) || (strlen($partFullAddress4) > 0) || (strlen($partFullAddress5) > 0)){
			
			$errorFound = 1;
			$error_link = $error_link . '&address=0';
			
		}
		
		$full_address = strip_tags($full_address);
		
	}
	
	$contact_no = $_POST['contact-no'];
	$_SESSION['new-shop-info-error'][$rand]['contact_no'] = $contact_no;
	$contact_no_option = $_POST['contact-no-option'];
	$_SESSION['new-shop-info-error'][$rand]['contact_no_option'] = $contact_no_option;
	
	if($contact_no != ''){
		
		$contact_nox = strip_tags($contact_no);
		$contact_no = str_replace(' ','',$contact_nox);
		
		$contact_no_optionx = strip_tags($contact_no_option);
		$contact_no_option = str_replace(' ','',$contact_no_optionx);
		
		if(!preg_match("/^[0-9]+$/",$contact_no)){
		
			$errorFound = 1;
			$error_link = $error_link . '&cn=0';
			
		}
		else if(!preg_match("/^[0-9+]+$/",$contact_no_option)){
		
			$errorFound = 1;
			$error_link = $error_link . '&cn=0';
			
		}
		
		$contact_no = $contact_no_option . $contact_no;
		
	}
	
	$contact_email = $_POST['contact-email'];
	$_SESSION['new-shop-info-error'][$rand]['contact_email'] = $contact_email;
	
	if($contact_email != ''){
		
		$contact_emailx = strip_tags($contact_email);
		$contact_email = str_replace(' ','',$contact_emailx);
		
		if(!preg_match("/^[A-Za-z0-9@._]+$/",$contact_email)){
			
			$errorFound = 1;
			$error_link = $error_link . '&email=0';
			
		}
		else if(strlen($contact_email) > 320){
			
			$errorFound = 1;
			$error_link = $error_link . '&email=0';
			
		}
		else if(!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
			
			$errorFound = 1;
			$error_link = $error_link . '&email=0';
			
		}
		
		$contact_email = strtolower($contact_email);
		
	}
	
	$flat_no = $_POST['shop-no'];
	$_SESSION['new-shop-info-error'][$rand]['flat_no'] = $flat_no;
	
	if($flat_no != ''){
		
		$partFlatNo1 = strstr($flat_no,';');
		$partFlatNo2 = strstr($flat_no,'"');
		$partFlatNo3 = strstr($flat_no,"'");
		$partFlatNo4 = strstr($flat_no,'*');
		$partFlatNo5 = strstr($flat_no,'^');
		
		if((strlen($partFlatNo1) > 0) || (strlen($partFlatNo2) > 0) || (strlen($partFlatNo3) > 0) || (strlen($partFlatNo4) > 0) || (strlen($partFlatNo5) > 0)){
			
			$errorFound = 1;
			$error_link = $error_link . '&flat=0';
			
		}
		
		$flat_no = strip_tags($flat_no);
		
	}
	
	$floor = $_POST['floor'];
	$_SESSION['new-shop-info-error'][$rand]['floor'] = $floor;
	$_SESSION['new-shop-info-error'][$rand]['floorBengali'] = $floor;
	
	if($floor != ''){
		
		$floorx = strip_tags($floor);
		$floor = str_replace(' ','',$floorx);
		
		if(!preg_match("/^[0-9-]+$/",$floor)){
		
			$errorFound = 1;
			$error_link = $error_link . '&floor=0';
			
		}
		else if(!is_numeric($floor)){
			
			$errorFound = 1;
			$error_link = $error_link . '&floor=0';
			
		}
		else{
			
			$_SESSION['new-shop-info-error'][$rand]['floorBengali'] = $floor + 1;
			
		}
		
	}
	
	$size_of_flat = $_POST['shop-size'];
	$_SESSION['new-shop-info-error'][$rand]['size_of_flat'] = $size_of_flat;
	
	if($size_of_flat != ''){
		
		$size_of_flatx = strip_tags($size_of_flat);
		$size_of_flat = str_replace(' ','',$size_of_flatx);
		
		if(!preg_match("/^[0-9.]+$/",$size_of_flat)){
		
			$errorFound = 1;
			$error_link = $error_link . '&fl-sz=0';
			
		}
		
	}
	
	$total_floors = $_POST['total-floor'];
	$_SESSION['new-shop-info-error'][$rand]['total_floors'] = $total_floors;
	$_SESSION['new-shop-info-error'][$rand]['total_floorsBengali'] = $total_floors;
	
	if($total_floors != ''){
		
		$total_floorsx = strip_tags($total_floors);
		$total_floors = str_replace(' ','',$total_floorsx);
		
		if(!preg_match("/^[0-9-]+$/",$total_floors)){
		
			$errorFound = 1;
			$error_link = $error_link . '&tot-floor=0';
			
		}
		else if(!is_numeric($total_floors)){
			
			$errorFound = 1;
			$error_link = $error_link . '&tot-floor=0';
			
		}
		else{
			
			$_SESSION['new-shop-info-error'][$rand]['total_floorsBengali'] = $total_floors + 1;
			
		}
		
	}
	
	$lift = $_POST['lift'];
	
	if(!(($lift == 'Yes') || ($lift == 'No'))){
		
		$lift = 'No';
		
	}
	
	$_SESSION['new-shop-info-error'][$rand]['lift'] = $lift;
	
	$elevator = $_POST['elevator'];
	
	if(!(($elevator == 'Yes') || ($elevator == 'No'))){
		
		$elevator = 'No';
		
	}
	
	$_SESSION['new-shop-info-error'][$rand]['elevator'] = $elevator;
	
	$parking_facility = $_POST['parking-facility'];
	
	if(!(($parking_facility == 'Yes') || ($parking_facility == 'No'))){
		
		$parking_facility = 'No';
		
	}
	
	$_SESSION['new-shop-info-error'][$rand]['parking_facility'] = $parking_facility;
	
	$other_description = $_POST['other-description'];
	$_SESSION['new-shop-info-error'][$rand]['other_description'] = $other_description;
	
	if($other_description != ''){
		
		$partOtherDescription1 = strstr($other_description,';');
		$partOtherDescription2 = strstr($other_description,'"');
		$partOtherDescription3 = strstr($other_description,"'");
		$partOtherDescription4 = strstr($other_description,'*');
		$partOtherDescription5 = strstr($other_description,'^');
		
		if((strlen($partOtherDescription1) > 0) || (strlen($partOtherDescription2) > 0) || (strlen($partOtherDescription3) > 0) || (strlen($partOtherDescription4) > 0) || (strlen($partOtherDescription5) > 0)){
			
			$errorFound = 1;
			$error_link = $error_link . '&oth-des=0';
			
		}
		
		$other_description = strip_tags($other_description);
		
	}
	
	if($errorFound == 1){
		
		header('Location:' . $error_link);
		exit;
		
	}
	
	$_SESSION['new-shop-info'][$rand]['sale'] = $sale;
	$_SESSION['new-shop-info'][$rand]['rent'] = $rent;
	$_SESSION['new-shop-info'][$rand]['available_from'] = $available_from;
	$_SESSION['new-shop-info'][$rand]['rental_price'] = $rental_price;
	$_SESSION['new-shop-info'][$rand]['rental_price_nego'] = $rental_price_nego;
	$_SESSION['new-shop-info'][$rand]['security_money'] = $security_money;
	$_SESSION['new-shop-info'][$rand]['security_money_nego'] = $security_money_nego;
	$_SESSION['new-shop-info'][$rand]['full_address'] = $full_address;
	$_SESSION['new-shop-info'][$rand]['contact_no'] = $contact_no;
	$_SESSION['new-shop-info'][$rand]['contact_email'] = $contact_email;
	$_SESSION['new-shop-info'][$rand]['flat_no'] = $flat_no;
	$_SESSION['new-shop-info'][$rand]['floor'] = $floor;
	$_SESSION['new-shop-info'][$rand]['floorBengali'] = $_SESSION['new-shop-info-error'][$rand]['floorBengali'];
	$_SESSION['new-shop-info'][$rand]['size_of_the_flat'] = $size_of_flat;
	$_SESSION['new-shop-info'][$rand]['total_floors'] = $total_floors;
	$_SESSION['new-shop-info'][$rand]['total_floorsBengali'] = $_SESSION['new-shop-info-error'][$rand]['total_floorsBengali'];
	$_SESSION['new-shop-info'][$rand]['lift'] = $lift;
	$_SESSION['new-shop-info'][$rand]['elevator'] = $elevator;
	$_SESSION['new-shop-info'][$rand]['parking_facility'] = $parking_facility;
	$_SESSION['new-shop-info'][$rand]['other_description'] = $other_description;
	
	header('Location:' . $urlNextPage);
	exit;
	
}

ob_end_flush();

?>