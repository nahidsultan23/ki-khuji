<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);
$_SESSION['comebackUrl']['actions'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=actions');
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
    <title>Ki Khuji - Actions</title>
    
    <link rel="stylesheet" href="css/jquery_ui.css">
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/actions.css">

	<script src="js/clock.js"></script>
	<script src="js/jquery.js"></script>
    <script src="js/jquery_ui.js"></script>
    <script src="js/actions.js"></script>
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
            <a href="mark">Advertise</a>
            <a href="profile">Profile</a>
            <a href="advertisements" class="active">Advertisements</a>
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
            <a href="logout?cbp=actions">Log Out</a>
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
		<?php
        
        $pageNum = 1;
        if(isset($_GET['pg'])){
            
            if(preg_match("/^[0-9]+$/",$_GET['pg'])){
                
                $pageNum = $_GET['pg'];
                
            }
            
        }
        
        $adID = 1;
        if(isset($_GET['ser']) && isset($_GET['act'])){
            
            if(preg_match("/^[0-9]+$/",$_GET['ser'])){
                
                $adID = $_GET['ser'];
                
            }
            
            $action = $_GET['act'];
            
            if(!(($action == 'stop') || ($action == 'start') || ($action == 'edit') || ($action == 'delete'))){
                
                header('Location:advertisements?page=' . $pageNum);
                exit;
                
            }
            
        }
        else{
            
            header('Location:advertisements?page=' . $pageNum);
            exit;
            
        }
        
        if(isset($_GET['key'])){
            
            $rand = $_GET['key'];
            
            if(!isset($_SESSION['actions'][$rand])){
                
                $rand =  md5(uniqid(rand()));
				
				
                
            }
            
        }
        else{
            
            $rand =  md5(uniqid(rand()));
            
        }
        
        if(!file_exists('db/db.php')){
            
            session_destroy();
            
            header('Location:error-db');
            exit;
            
        }
        
        $_SESSION['db'] = 1;
        include('db/db.php');
        $_SESSION['db'] = NULL;
        
        $query = "SELECT * FROM info WHERE (id='$adID' AND user_id='$id')";
        $result = mysqli_query($dbc,$query);
        $count = mysqli_num_rows($result);
        
        if($count == 0){
            
            header('Location:advertisements?page=' . $pageNum);
            exit;
            
        }
        
        $row = mysqli_fetch_array($result);
        
        $latitude =  $row['latitude'];
        $longitude = $row['longitude'];
        $sale = $row['sale'];
        $rent = $row['rent'];
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
        $rental_price = $row['rental_price'];
        $rental_price_nego = $row['rental_price_nego'];
        $security_money = $row['security_money'];
        $security_money_nego = $row['security_money_nego'];
        
        $full_address = $row['full_address'];
        $full_address = str_replace('*^*',' ',$full_address);
        
        $contact_no = $row['contact_no'];
        $contact_no_option = substr($contact_no, 0, 4);
        $contact_no = substr($contact_no, 4);
        
        $contact_email = $row['contact_email'];
        
        $flat_no = $row['flat_no'];
        $flat_no = str_replace('*^*',' ',$flat_no);
        
        $floor = $row['floor'];
        $size_of_flat = $row['size_of_flat'];
        $size_of_room = $row['size_of_room'];
        $number_of_rooms = $row['number_of_rooms'];
        $number_of_washrooms = $row['number_of_washrooms'];
        $washroom_attached = $row['washroom_attached'];
        $number_of_balconies = $row['number_of_balconies'];
        $balcony_attached = $row['balcony_attached'];
        $total_floors = $row['total_floors'];
        $lift = $row['lift'];
        $elevator =  $row['elevator'];
        $parking_facility = $row['parking_facility'];
        
        $other_description = $row['other_description'];
        $other_description = str_replace('*^*',' ',$other_description);
        
        $date = $row['date'];
        $screenDate = date('d F, Y',strtotime($date));
        
        $time = $row['time'];
        $publish = $row['publish'];
		$randomkey = $row['randomkey'];
		
		$spRand = $randomkey . 1;
		
		$_SESSION['mark'][$spRand]['current-place'] = 'Dhaka, Bangladesh';
		$_SESSION['mark'][$spRand]['latitude'] = '23.810332';
		$_SESSION['mark'][$spRand]['longitude'] = '90.41251809999994';
		
		for($i=1; $i<=5; $i++){
			
			$filePath = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
			
			if(!isset($_SESSION['mark'][$spRand]['photo_' . $i])){
				
				if($filePath){
					
					$_SESSION['mark'][$spRand]['photo_' . $i] = $filePath[0];
					$_SESSION['mark'][$spRand]['photo_' . $i . '_other'] = '../' . $filePath[0];
					
				}
				
			}
			
		}
        
        if($publish > 1){
            
            header('Location:advertisements?page=' . $pageNum);
            exit;
            
        }
        
        if($action == 'stop'){
            
            $query = "UPDATE info SET publish='0' WHERE id='$adID'";
            $result = mysqli_query($dbcUpdate,$query);
            
            header('Location:advertisements?act-suc=stop&page=' . $pageNum);
            exit;
            
        }
        else if($action == 'start'){
            
            $query = "UPDATE info SET publish='1' WHERE id='$adID'";
            $result = mysqli_query($dbcUpdate,$query);
            
            header('Location:advertisements?act-suc=start&page=' . $pageNum);
            exit;
            
        }
        else if($action == 'edit'){
            
            if($flat == 1){
                
                if(isset($_SESSION['actions'][$rand]['flat-info-edit'])){
                    
                    $mess = $_SESSION['actions'][$rand]['flat-info-edit']['mess'];
                    $available_from = $_SESSION['actions'][$rand]['flat-info-edit']['available_from'];
                    $male = $_SESSION['actions'][$rand]['flat-info-edit']['male'];
                    $female = $_SESSION['actions'][$rand]['flat-info-edit']['female'];
                    $family = $_SESSION['actions'][$rand]['flat-info-edit']['family'];
                    $max_people = $_SESSION['actions'][$rand]['flat-info-edit']['max_people'];
                    $rental_price = $_SESSION['actions'][$rand]['flat-info-edit']['rental_price'];
                    $rental_price_nego = $_SESSION['actions'][$rand]['flat-info-edit']['rental_price_nego'];
                    $security_money = $_SESSION['actions'][$rand]['flat-info-edit']['security_money'];
                    $security_money_nego = $_SESSION['actions'][$rand]['flat-info-edit']['security_money_nego'];
                    $full_address = $_SESSION['actions'][$rand]['flat-info-edit']['full_address'];
                    $contact_no_option = $_SESSION['actions'][$rand]['flat-info-edit']['contact_no_option'];
                    $contact_no = $_SESSION['actions'][$rand]['flat-info-edit']['contact_no'];
                    $contact_email = $_SESSION['actions'][$rand]['flat-info-edit']['contact_email'];
                    $flat_no = $_SESSION['actions'][$rand]['flat-info-edit']['flat_no'];
                    $floor = $_SESSION['actions'][$rand]['flat-info-edit']['floor'];
                    $size_of_flat = $_SESSION['actions'][$rand]['flat-info-edit']['size_of_flat'];
                    $number_of_rooms = $_SESSION['actions'][$rand]['flat-info-edit']['number_of_rooms'];
                    $number_of_washrooms = $_SESSION['actions'][$rand]['flat-info-edit']['number_of_washrooms'];
                    $number_of_balconies = $_SESSION['actions'][$rand]['flat-info-edit']['number_of_balconies'];
                    $total_floors = $_SESSION['actions'][$rand]['flat-info-edit']['total_floors'];
                    $lift = $_SESSION['actions'][$rand]['flat-info-edit']['lift'];
                    $parking_facility = $_SESSION['actions'][$rand]['flat-info-edit']['parking_facility'];
                    $other_description = $_SESSION['actions'][$rand]['flat-info-edit']['other_description'];
                    
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
                if(isset($_GET['av-fo'])){
                    
                    ?>
                    <style>
                        #av-fo{
                            
                            visibility:visible;
                            
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['mx-ppl'])){
                    
                    ?>
                    <style>
                        #mx-ppl{
                            
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
                if(isset($_GET['num-rm'])){
                    
                    ?>
                    <style>
                        #num-rm{
                            
                            visibility:visible;
                            
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['num-wsrm'])){
                    
                    ?>
                    <style>
                        #num-wsrm{
                            
                            visibility:visible;
                            
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['num-bal'])){
                    
                    ?>
                    <style>
                        #num-bal{
                            
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
                <form action="" method="post">
                    <table id="flatInfo">
                        <tr id="heading"><td colspan="2">Edit Flat Info</td></tr>
                        <tr><td>Advertisement type</td> <td><?php if($sale == 1){ echo 'Sale'; }else if($rent == 1){ echo 'Rent'; } ?></td></tr>
                        <tr>
                            <td id="firstColumn">Available from</td><td id="secondColumn"><input type="text" id="datepicker" name="available_from" value="<?php echo $available_from; ?>" readonly /> <span id="date" class="sidenote">Date formation is incorrect</span></td>
                        </tr>
                        <?php
                        
                        if($sale == 1){
                            
                            ?>
                            <tr>
                                <td>Price</td> <td><input type="text" name="rental-price" <?php if(isset($rental_price)){ ?>value="<?php echo $rental_price; ?>"<?php } ?> pattern="^[0-9.]+"> BDT <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> >Negotiable <span id="rent" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <tr>
                                <td>Booking money<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">Amount that will be taken initially to start the purchasing process.</span></td> <td><input type="text" name="security-money" <?php if(isset($security_money)){ ?>value="<?php echo $security_money; ?>"<?php } ?> pattern="^[0-9.]+"> BDT <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>>Negotiable <span id="sc" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <?php
                            
                        }
                        else if($rent == 1){
                            
                            ?>
                            <tr>
                                <td>Available for<input type="button" id="button_avfor" value="?"><span id="sidenote_avfor">People who can rent your flat. You can choose more than one option here. If the flat is available for a family, then choose only 'Family'. Sometimes one single person (male or female) looks for a whole flat to rent. If your flat is available for them, then choose the 'Single (Male)' and 'Single (Female)' options.</span></td> <td><input type="checkbox" onchange="oneChanged()" name="single-male" id="single-male" <?php if($male == 1){ echo 'checked'; } ?> > Single (Male)<br> <input type="checkbox" onchange="oneChanged()" name="single-female" id="single-female" <?php if($female == 1){ echo 'checked'; } ?> > Single (Female) <span id="av-fo" class="sidenote">Check at least one field</span><br> <input type="checkbox" name="family" id="family" <?php if($family == 1){ echo 'checked'; } ?> > Family</td>
                            </tr>
                            <tr id="messUse" <?php if(($male == 0) && ($female == 0)){ ?>style="display:none"<?php } ?> >
                                <td>Can this flat be used as a mess?<input type="button" id="button_messuse" value="?"><span id="sidenote_messuse">If the flat is available for a group of single people (male or female), then choose 'Yes'.</span></td> <td><input type="radio" onchange="changeMessInfo(this)" name="mess" value="yes" <?php if($mess == 1){ echo 'checked'; } ?> >Yes<br> <input type="radio" onchange="changeMessInfo(this)" name="mess" id="messUseNo" value="no" <?php if($mess == 0){ echo 'checked'; } ?> >No</td>
                            </tr>
                            <tr id="maxNumPeople" <?php if($mess == 0){ ?>style="display:none"<?php } ?> >
                                <td>Maximum number of people (in case of using as a mess)<input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">If a group of single people stay in the flat, maximum how many people can stay?</span></td> <td><input type="text" name="max-people-in-mess" value="<?php echo $max_people; ?>" pattern="^[0-9]+"> <span id="mx-ppl" class="sidenote">Use a valid number</span></td>
                            </tr>
                            <tr>
                                <td>Rental price per month</td> <td><input type="text" name="rental-price" <?php if(isset($rental_price)){ ?>value="<?php echo $rental_price; ?>"<?php } ?> pattern="^[0-9.]+"> BDT <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> >Negotiable <span id="rent" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <tr>
                                <td>Security money<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">Amount that will be taken before the person moves to the flat.</span></td> <td><input type="text" name="security-money" <?php if(isset($security_money)){ ?>value="<?php echo $security_money; ?>"<?php } ?> pattern="^[0-9.]+"> BDT <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>>Negotiable <span id="sc" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <?php
                            
                        }
                        
                        ?>
                        <tr>
                            <td>Full Address</td> <td><textarea name="full-address" placeholder="This part will be shown in your advertisement with big letters. Make sure you only write the full address here. e.g. House No : 30, Road No : 2/A, Bengali Street, Dhaka, Bangladesh. If you have any other information to mention, write it in 'Other description' field which you will find in the bottom of this form."><?php echo $full_address ?></textarea> <span id="address" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Contact no.</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >Bangladesh(+880)</option></select> <input type="text" name="contact-no" id="contact-no" value="<?php echo $contact_no; ?>" pattern="^[0-9]+"> <span id="cn" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Email</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" value="<?php echo $contact_email; ?>"> <span id="email" class="sidenote">Enter a valid Email</span></td>
                        </tr>
                        
                        <tr id="additionalHeading">
                            <td colspan="2">Additional Info</td>
                        </tr>
            
                        <tr>
                            <td>Flat no.</td> <td><input type="text" name="flat-no" value="<?php echo $flat_no; ?>"> <span id="flat" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Floor</td> <td><input type="text" name="floor" value="<?php echo $floor; ?>" pattern="^[0-9-]+"> <span id="floor" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Size of the flat</td> <td><input type="text" name="size" value="<?php echo $size_of_flat; ?>" pattern="^[0-9.]+"> square feet <span id="fl-sz" class="sidenote">Enter a valid size</span></td>
                        </tr>
                        <tr>
                            <td>Number of rooms</td> <td><input type="text" name="number-of-rooms" value="<?php echo $number_of_rooms; ?>" pattern="^[0-9]+"> <span id="num-rm" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Number of washrooms</td> <td><input type="text" name="number-of-washrooms" value="<?php echo $number_of_washrooms; ?>" pattern="^[0-9]+"> <span id="num-wsrm" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Number of balconies</td> <td><input type="text" name="number-of-balconies" value="<?php echo $number_of_balconies; ?>" pattern="^[0-9]+"> <span id="num-bal" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Total number of floors in the house</td> <td><input type="text" name="total-floor" value="<?php echo $total_floors; ?>" pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Is there any lift to reach this flat?</td> <td><select name="lift">
                                    <option value="Yes" <?php if($lift == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                                    <option value="No" <?php if($lift == 'No'){ echo 'selected'; } ?> >No</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Is there any parking facility in the building?</td> <td><select name="parking-facility">
                                    <option value="Yes" <?php if($parking_facility == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                                    <option value="No" <?php if($parking_facility == 'No'){ echo 'selected'; } ?> >No</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Other description</td> <td><textarea name="other-description" placeholder="Write any additional information you want to mention. e.g. The flat has a beautiful balcony on the south side. One of the washrooms contains commode facility and a bathtub........, etc. Additional phone number : 01............, 02........... Additional Email : no-reply@kikhuji.com"><?php echo $other_description; ?></textarea> <span id="oth-des" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Photos</td>
                            <td id="photos">
                                <div id="allForms">
                                    <form>
                                    </form>
                                    
                                    <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_1" id="key_1" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_1">+</button>
                                            <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                        </div>
                                        
                                        <div id="progressbarContainer_1" style="display:none">
                                            <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_1']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_1">
                                            <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_2" id="key_2" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_2">+</button>
                                            <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                        </div>
                                        
                                        <div id="progressbarContainer_2" style="display:none">
                                            <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_2']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_2">
                                            <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_3" id="key_3" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_3">+</button>
                                            <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                        </div>
                                        
                                        <div id="progressbarContainer_3" style="display:none">
                                            <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_3']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_3">
                                            <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_4" id="key_4" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_4">+</button>
                                            <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                        </div>
                                        
                                        <div id="progressbarContainer_4" style="display:none">
                                            <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_4']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_4">
                                            <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_5" id="key_5" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$spRand]['photo_5'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_5">+</button>
                                            <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                        </div>
                                        
                                        <div id="progressbarContainer_5" style="display:none">
                                            <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$spRand]['photo_5'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_5']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
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
                            <td colspan="2"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">Back to Advertisements</a></td>
                        </tr>
                    </table>
                </form>
                <?php
                
                if(isset($_POST['submit'])){
                    
                    $errorFound = 0;
                    $error_link = 'actions?key=' . $rand . '&act=edit&ser=' . $adID . '&pg=' . $pageNum; 
                    
                    $available_from = $_POST['available_from'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['available_from'] = $available_from;
                    
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
                    
                    $male = 0;
                    
                    if(isset($_POST['single-male'])){
                        
                        $male = 1;
                        
                    }
                    
                    $_SESSION['actions'][$rand]['flat-info-edit']['male'] = $male;
                    
                    $female = 0;
                    
                    if(isset($_POST['single-female'])){
                        
                        $female = 1;
                        
                    }
                    
                    $_SESSION['actions'][$rand]['flat-info-edit']['female'] = $female;
                    
                    $family = 0;
                    
                    if(isset($_POST['family'])){
                        
                        $family = 1;
                        
                    }
                    
                    $_SESSION['actions'][$rand]['flat-info-edit']['family'] = $family;
                    
                    if(($male == 0) && ($female == 0) && ($family == 0)){
                        
                        $errorFound = 1;
                        $error_link = $error_link . '&av-fo=0';
                        
                    }
                    
                    $mess = 0;
                    
                    if((($male == 1) || ($female == 1)) && ($_POST['mess'] == 'yes')){
                        
                        $mess = 1;
                        
                    }
                    
                    $_SESSION['actions'][$rand]['flat-info-edit']['mess'] = $mess;
                    
                    $max_people = '';
                    
                    if($mess == 1){
                        
                        $max_people = $_POST['max-people-in-mess'];
                        $_SESSION['actions'][$rand]['flat-info-edit']['max_people'] = $max_people;
                        
                        if($max_people != ''){
                            
                            $max_peoplex = strip_tags($max_people);
                            $max_people = str_replace(' ','',$max_peoplex);
                            
                            if(($max_people == 0) || (!preg_match("/^[0-9]+$/",$max_people))){
                            
                                $errorFound = 1;
                                $error_link = $error_link . '&mx-ppl=0';
                                
                            }	
                            
                        }
                        
                    }
                    else{
                        
                        $_SESSION['actions'][$rand]['flat-info-edit']['max_people'] = '';
                        
                    }
                    
                    $rental_price = $_POST['rental-price'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['rental_price'] = $rental_price;
                    
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
                    
                    $_SESSION['actions'][$rand]['flat-info-edit']['rental_price_nego'] = $rental_price_nego;
                    
                    $security_money = $_POST['security-money'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['security_money'] = $security_money;
                    
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
                    
                    $_SESSION['actions'][$rand]['flat-info-edit']['security_money_nego'] = $security_money_nego;
                    
                    $full_address = $_POST['full-address'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['full_address'] = $full_address;
                    
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
                        $full_address = str_replace(' ','*^*',$full_address);
                        
                    }
                    
                    $contact_no = $_POST['contact-no'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['contact_no'] = $contact_no;
                    $contact_no_option = $_POST['contact-no-option'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['contact_no_option'] = $contact_no_option;
                    
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
                    $_SESSION['actions'][$rand]['flat-info-edit']['contact_email'] = $contact_email;
                    
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
                    
                    $flat_no = $_POST['flat-no'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['flat_no'] = $flat_no;
                    
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
                        $flat_no = str_replace(' ','*^*',$flat_no);
                        
                    }
                    
                    $floor = $_POST['floor'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['floor'] = $floor;
                    $_SESSION['actions'][$rand]['flat-info-edit']['floorBengali'] = $floor;
                    
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
                            
                            $_SESSION['actions'][$rand]['flat-info-edit']['floorBengali'] = $floor + 1;
                            
                        }
                        
                    }
                    
                    $size_of_flat = $_POST['size'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['size_of_flat'] = $size_of_flat;
                    
                    if($size_of_flat != ''){
                        
                        $size_of_flatx = strip_tags($size_of_flat);
                        $size_of_flat = str_replace(' ','',$size_of_flatx);
                        
                        if(!preg_match("/^[0-9.]+$/",$size_of_flat)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&fl-sz=0';
                            
                        }
                        
                    }
                    
                    $number_of_rooms = $_POST['number-of-rooms'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['number_of_rooms'] = $number_of_rooms;
                    
                    if($number_of_rooms != ''){
                        
                        $number_of_roomsx = strip_tags($number_of_rooms);
                        $number_of_rooms = str_replace(' ','',$number_of_roomsx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_rooms)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&num-rm=0';
                            
                        }
                        
                    }
                    
                    $number_of_washrooms = $_POST['number-of-washrooms'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['number_of_washrooms'] = $number_of_washrooms;
                    
                    if($number_of_washrooms != ''){
                        
                        $number_of_washroomsx = strip_tags($number_of_washrooms);
                        $number_of_washrooms = str_replace(' ','',$number_of_washroomsx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_washrooms)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&num-wsrm=0';
                            
                        }
                        
                    }
        
                    
                    $number_of_balconies = $_POST['number-of-balconies'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['number_of_balconies'] = $number_of_balconies;
                    
                    if($number_of_balconies != ''){
                        
                        $number_of_balconiesx = strip_tags($number_of_balconies);
                        $number_of_balconies = str_replace(' ','',$number_of_balconiesx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_balconies)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&num-bal=0';
                            
                        }
                        
                    }
                    
                    $total_floors = $_POST['total-floor'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['total_floors'] = $total_floors;
                    $_SESSION['actions'][$rand]['flat-info-edit']['total_floorsBengali'] = $total_floors;
                    
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
                            
                            $_SESSION['actions'][$rand]['flat-info-edit']['total_floorsBengali'] = $total_floors + 1;
                            
                        }
                        
                    }
                    
                    $lift = $_POST['lift'];
                    
                    if(!(($lift == 'Yes') || ($lift == 'No'))){
                        
                        $lift = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['flat-info-edit']['lift'] = $lift;
                    
                    $parking_facility = $_POST['parking-facility'];
                    
                    if(!(($parking_facility == 'Yes') || ($parking_facility == 'No'))){
                        
                        $parking_facility = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['flat-info-edit']['parking_facility'] = $parking_facility;
                    
                    $other_description = $_POST['other-description'];
                    $_SESSION['actions'][$rand]['flat-info-edit']['other_description'] = $other_description;
                    
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
                        $other_description = str_replace(' ','*^*',$other_description);
                        
                    }
                    
                    if($errorFound == 1){
                        
                        header('Location:' . $error_link);
                        exit;
                        
                    }
                    
                    $query = "UPDATE info SET mess='$mess',available_from='$available_from',male='$male',female='$female',family='$family',max_people='$max_people',rental_price='$rental_price',rental_price_nego='$rental_price_nego',security_money='$security_money',security_money_nego='$security_money_nego',full_address='$full_address',contact_no='$contact_no',contact_email='$contact_email',flat_no='$flat_no',floor='$floor',size_of_flat='$size_of_flat',number_of_rooms='$number_of_rooms',number_of_washrooms='$number_of_washrooms',number_of_balconies='$number_of_balconies',total_floors='$total_floors',lift='$lift',parking_facility='$parking_facility',other_description='$other_description' WHERE id='$adID'";
                    $result = mysqli_query($dbcUpdate,$query);
					
					for($i=1; $i<=5; $i++){
						
						if(isset($_SESSION['mark'][$spRand]['photo_' . $i])){
							
							$filePath = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
							
							if(!$filePath){
								
								$explode = explode('.',$_SESSION['mark'][$spRand]['photo_' . $i]);
								$extension = $explode[1];
								$preAddress = 'uploadedPhotos/temp/' . $id . '_' . $spRand . '_' . $i . '.' . $extension;
								$newAddress = 'uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.' . $extension;
								
								rename($preAddress, $newAddress);
								
							}
							
						}
						
					}
                    
                    $_SESSION['mark'][$spRand] = NULL;
					$_SESSION['actions'][$rand]['flat-info-edit'] = NULL;
                    
                    header('Location:advertisements?act-suc=edit&page=' . $pageNum);
                    exit;
                    
                }
                
            }
            else if($room == 1){
                
                if(isset($_SESSION['actions'][$rand]['room-info-edit'])){
                    
                    $mess = $_SESSION['actions'][$rand]['room-info-edit']['mess'];
                    $available_from = $_SESSION['actions'][$rand]['room-info-edit']['available_from'];
                    $male = $_SESSION['actions'][$rand]['room-info-edit']['male'];
                    $female = $_SESSION['actions'][$rand]['room-info-edit']['female'];
                    $family = $_SESSION['actions'][$rand]['room-info-edit']['family'];
                    $max_people = $_SESSION['actions'][$rand]['room-info-edit']['max_people'];
                    $rental_price = $_SESSION['actions'][$rand]['room-info-edit']['rental_price'];
                    $rental_price_nego = $_SESSION['actions'][$rand]['room-info-edit']['rental_price_nego'];
                    $security_money = $_SESSION['actions'][$rand]['room-info-edit']['security_money'];
                    $security_money_nego = $_SESSION['actions'][$rand]['room-info-edit']['security_money_nego'];
                    $full_address = $_SESSION['actions'][$rand]['room-info-edit']['full_address'];
                    $contact_no_option = $_SESSION['actions'][$rand]['room-info-edit']['contact_no_option'];
                    $contact_no = $_SESSION['actions'][$rand]['room-info-edit']['contact_no'];
                    $contact_email = $_SESSION['actions'][$rand]['room-info-edit']['contact_email'];
                    $flat_no = $_SESSION['actions'][$rand]['room-info-edit']['flat_no'];
                    $floor = $_SESSION['actions'][$rand]['room-info-edit']['floor'];
                    $size_of_flat = $_SESSION['actions'][$rand]['room-info-edit']['size_of_flat'];
                    $size_of_room = $_SESSION['actions'][$rand]['room-info-edit']['size_of_room'];
                    $number_of_rooms = $_SESSION['actions'][$rand]['room-info-edit']['number_of_rooms'];
                    $number_of_washrooms = $_SESSION['actions'][$rand]['room-info-edit']['number_of_washrooms'];
                    $washroom_attached = $_SESSION['actions'][$rand]['room-info-edit']['washroom_attached'];
                    $number_of_balconies = $_SESSION['actions'][$rand]['room-info-edit']['number_of_balconies'];
                    $balcony_attached = $_SESSION['actions'][$rand]['room-info-edit']['balcony_attached'];
                    $total_floors = $_SESSION['actions'][$rand]['room-info-edit']['total_floors'];
                    $lift = $_SESSION['actions'][$rand]['room-info-edit']['lift'];
                    $parking_facility = $_SESSION['actions'][$rand]['room-info-edit']['parking_facility'];
                    $other_description = $_SESSION['actions'][$rand]['room-info-edit']['other_description'];
                    
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
                if(isset($_GET['av-fo'])){
                    
                    ?>
                    <style>
                        #av-fo{
                            
                            visibility:visible;
                            
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['mx-ppl'])){
                    
                    ?>
                    <style>
                        #mx-ppl{
                            
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
                if(isset($_GET['rm-sz'])){
                    
                    ?>
                    <style>
                        #rm-sz{
                            
                            visibility:visible;
                            
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['num-rm'])){
                    
                    ?>
                    <style>
                        #num-rm{
                            
                            visibility:visible;
                            
                
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['num-wsrm'])){
                    
                    ?>
                    <style>
                        #num-wsrm{
                            
                            visibility:visible;
                            
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['num-bal'])){
                    
                    ?>
                    <style>
                        #num-bal{
                            
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
                <form action="" method="post">
                    <table id="roomInfo">
                        <tr id="heading"><td colspan="2">Edit Room Info</td></tr>
                        <tr><td>Advertisement type</td> <td><?php if($sale == 1){ echo 'Sale'; }else if($rent == 1){ echo 'Rent'; } ?></td></tr>
                        <tr>
                            <td id="firstColumn">Available from</td><td id="secondColumn"><input type="text" id="datepicker" name="available_from" value="<?php echo $available_from; ?>" readonly /> <span id="date" class="sidenote">Date formation is incorrect</span></td>
                        </tr>
                        <tr>
                            <td>Available for<input type="button" id="button_avfor" value="?"><span id="sidenote_avfor">People who can rent the room. You can choose more than one option here. If the room is available for a family, then choose only 'Family'. Sometimes one single person (male or female) looks for a whole room to rent. If your flat is available for them, then choose the 'Single (Male)' and 'Single (Female)' options.</span></td> <td><input type="checkbox" onchange="oneChanged()" name="single-male" id="single-male" <?php if($male == 1){ echo 'checked'; } ?> > Single (Male)<br> <input type="checkbox" onchange="oneChanged()" name="single-female" id="single-female" <?php if($female == 1){ echo 'checked'; } ?> > Single (Female) <span id="av-fo" class="sidenote">Check at least one field</span><br> <input type="checkbox" name="family" <?php if($family == 1){ echo 'checked'; } ?> > Family</td>
                        </tr>
                        <tr id="messUse" <?php if(($male == 0) && ($female == 0)){ ?>style="display:none"<?php } ?> >
                            <td>Can this room be used as a mess?<input type="button" id="button_messuse" value="?"><span id="sidenote_messuse">If the room is available for a group of single people (male or female), then choose 'Yes'.</span></td> <td><input type="radio" onchange="changeMessInfo(this)" name="mess" value="yes" <?php if($mess == 1){ echo 'checked'; } ?> >Yes<br> <input type="radio" onchange="changeMessInfo(this)" name="mess" id="messUseNo" value="no" <?php if($mess == 0){ echo 'checked'; } ?> >No</td>
                        </tr>
                        <tr id="maxNumPeople" <?php if($mess == 0){ ?>style="display:none"<?php } ?> >
                            <td>Maximum number of people (in case of using as a mess)<input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">If a group of single people stay in the room, maximum how many people can stay?</span></td> <td><input type="text" name="max-people-in-mess" value="<?php echo $max_people; ?>" pattern="^[0-9]+"> <span id="mx-ppl" class="sidenote">Use a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Rental price per month</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> >Negotiable <span id="rent" class="sidenote">Enter a valid amount</span></td>
                        </tr>
                        <tr>
                            <td>Security money<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">Amount that will be taken before the person moves to the room.</span></td> <td><input type="text" name="security-money" value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>>Negotiable <span id="sc" class="sidenote">Enter a valid amount</span></td>
                        </tr>
                        <tr>
                            <td>Full Address</td> <td><textarea name="full-address" placeholder="This part will be shown in your advertisement with big letters. Make sure you only write the full address here. e.g. House No : 30, Road No : 2/A, Bengali Street, Dhaka, Bangladesh. If you have any other information to mention, write it in 'Other description' field which you will find in the bottom of this form."><?php echo $full_address; ?></textarea> <span id="address" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Contact no.</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >Bangladesh(+880)</option></select> <input type="text" name="contact-no" id="contact-no" value="<?php echo $contact_no; ?>" pattern="^[0-9]+"> <span id="cn" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Email</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" value="<?php echo $contact_email; ?>"> <span id="email" class="sidenote">Enter a valid Email</span></td>
                        </tr>
                        
                        <tr id="additionalHeading">
                            <td colspan="2">Additional Info</td>
                        </tr>
            
                        <tr>
                            <td>Flat no.</td> <td><input type="text" name="flat-no" value="<?php echo $flat_no; ?>"> <span id="flat" class="sidenote">Use valid characters</span></td></td>
                        </tr>
                        <tr>
                            <td>Floor</td> <td><input type="text" name="floor" value="<?php echo $floor; ?>" pattern="^[0-9-]+"> <span id="floor" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Size of the flat</td> <td><input type="text" name="size" value="<?php echo $size_of_flat; ?>" pattern="^[0-9.]+"> square feet <span id="fl-sz" class="sidenote">Enter a valid size</span></td>
                        </tr>
                        <tr>
                            <td>Size of the room</td> <td><input type="text" name="room-size" value="<?php echo $size_of_room; ?>" pattern="^[0-9.]+"> square feet <span id="rm-sz" class="sidenote">Enter a valid size</span></td>
                        </tr>
                        <tr>
                            <td>Number of rooms in the flat</td> <td><input type="text" name="number-of-rooms" value="<?php echo $number_of_rooms; ?>" pattern="^[0-9]+"> <span id="num-rm" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Number of washrooms in the flat</td> <td><input type="text" name="number-of-washrooms" value="<?php echo $number_of_washrooms; ?>" pattern="^[0-9]+"> <span id="num-wsrm" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Is there any washroom attached to this room?</td> <td><select name="washroom-attached">
                                    <option value="Yes" <?php if($washroom_attached == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                                    <option value="No" <?php if($washroom_attached == 'No'){ echo 'selected'; } ?> >No</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Number of balconies in the flat</td> <td><input type="text" name="number-of-balconies" value="<?php echo $number_of_balconies; ?>" pattern="^[0-9]+"> <span id="num-bal" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Is there any balcony attached to this room?</td> <td><select name="balcony-attached">
                                    <option value="Yes" <?php if($balcony_attached == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                                    <option value="No" <?php if($balcony_attached == 'No'){ echo 'selected'; } ?> >No</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Total number of floors in the house</td> <td><input type="text" name="total-floor" value="<?php echo $total_floors; ?>" pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Is there any lift to reach the flat containing this room?</td> <td><select name="lift">
                                    <option value="Yes" <?php if($lift == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                                    <option value="No" <?php if($lift == 'No'){ echo 'selected'; } ?> >No</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Is there any parking facility in the building?</td> <td><select name="parking-facility">
                                    <option value="Yes" <?php if($parking_facility == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                                    <option value="No" <?php if($parking_facility == 'No'){ echo 'selected'; } ?> >No</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Other description</td> <td><textarea name="other-description" placeholder="Write any additional information you want to mention. e.g. The room is spacious and well ventilated. It has two big windows........, etc. Additional phone number : 01............, 02........... Additional Email : no-reply@kikhuji.com"><?php echo $other_description; ?></textarea> <span id="oth-des" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Photos</td>
                            <td id="photos">
                                <div id="allForms">
                                    <form>
                                    </form>
                                    
                                    <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_1" id="key_1" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_1">+</button>
                                            <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                        </div>
                                        
                                        <div id="progressbarContainer_1" style="display:none">
                                            <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_1']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_1">
                                            <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_2" id="key_2" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_2">+</button>
                                            <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                        </div>
                                        
                                        <div id="progressbarContainer_2" style="display:none">
                                            <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_2']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_2">
                                            <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_3" id="key_3" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_3">+</button>
                                            <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                        </div>
                                        
                                        <div id="progressbarContainer_3" style="display:none">
                                            <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_3']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_3">
                                            <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_4" id="key_4" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_4">+</button>
                                            <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                        </div>
                                        
                                        <div id="progressbarContainer_4" style="display:none">
                                            <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_4']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_4">
                                            <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_5" id="key_5" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$spRand]['photo_5'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_5">+</button>
                                            <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                        </div>
                                        
                                        <div id="progressbarContainer_5" style="display:none">
                                            <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$spRand]['photo_5'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_5']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
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
                            <td colspan="2"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">Back to Advertisements</a></td>
                        </tr>
                    </table>
                </form>
                <?php
                
                if(isset($_POST['submit'])){
                    
                    $errorFound = 0;
                    $error_link = 'actions?key=' . $rand . '&act=edit&ser=' . $adID . '&pg=' . $pageNum;
                    
                    $available_from = $_POST['available_from'];
                    $_SESSION['actions'][$rand]['room-info-edit']['available_from'] = $available_from;
                    
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
                    
                    $male = 0;
                    
                    if(isset($_POST['single-male'])){
                        
                        $male = 1;
                        
                    }
                    
                    $_SESSION['actions'][$rand]['room-info-edit']['male'] = $male;
                    
                    $female = 0;
                    
                    if(isset($_POST['single-female'])){
                        
                        $female = 1;
                        
                    }
                    
                    $_SESSION['actions'][$rand]['room-info-edit']['female'] = $female;
                    
                    $family = 0;
                    
                    if(isset($_POST['family'])){
                        
                        $family = 1;
                        
                    }
                    
                    $_SESSION['actions'][$rand]['room-info-edit']['family'] = $family;
                    
                    if(($male == 0) && ($female == 0) && ($family == 0)){
                        
                        $errorFound = 1;
                        $error_link = $error_link . '&av-fo=0';
                        
                    }
                    
                    $mess = 0;
                    
                    if((($male == 1) || ($female == 1)) && ($_POST['mess'] == 'yes')){
                        
                        $mess = 1;
                        
                    }
                    
                    $_SESSION['actions'][$rand]['room-info-edit']['mess'] = $mess;
                    
                    $max_people = '';
                    
                    if($mess == 1){
                        
                        $max_people = $_POST['max-people-in-mess'];
                        $_SESSION['actions'][$rand]['room-info-edit']['max_people'] = $max_people;
                        
                        if($max_people != ''){
                            
                            $max_peoplex = strip_tags($max_people);
                            $max_people = str_replace(' ','',$max_peoplex);
                            
                            if(($max_people == 0) || (!preg_match("/^[0-9]+$/",$max_people))){
                            
                                $errorFound = 1;
                                $error_link = $error_link . '&mx-ppl=0';
                                
                            }	
                            
                        }
                        
                    }
                    else{
                        
                        $_SESSION['actions'][$rand]['room-info-edit']['max_people'] = '';
                        
                    }
                    
                    $rental_price = $_POST['rental-price'];
                    $_SESSION['actions'][$rand]['room-info-edit']['rental_price'] = $rental_price;
                    
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
                    
                    $_SESSION['actions'][$rand]['room-info-edit']['rental_price_nego'] = $rental_price_nego;
                    
                    $security_money = $_POST['security-money'];
                    $_SESSION['actions'][$rand]['room-info-edit']['security_money'] = $security_money;
                    
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
                    
                    $_SESSION['actions'][$rand]['room-info-edit']['security_money_nego'] = $security_money_nego;
                    
                    $full_address = $_POST['full-address'];
                    $_SESSION['actions'][$rand]['room-info-edit']['full_address'] = $full_address;
                    
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
                        $full_address = str_replace(' ','*^*',$full_address);
                        
                    }
                    
                    $contact_no = $_POST['contact-no'];
                    $_SESSION['actions'][$rand]['room-info-edit']['contact_no'] = $contact_no;
                    $contact_no_option = $_POST['contact-no-option'];
                    $_SESSION['actions'][$rand]['room-info-edit']['contact_no_option'] = $contact_no_option;
                    
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
                    $_SESSION['actions'][$rand]['room-info-edit']['contact_email'] = $contact_email;
                    
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
                    
                    $flat_no = $_POST['flat-no'];
                    $_SESSION['actions'][$rand]['room-info-edit']['flat_no'] = $flat_no;
                    
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
                        $flat_no = str_replace(' ','*^*',$flat_no);
                        
                    }
                    
                    $floor = $_POST['floor'];
                    $_SESSION['actions'][$rand]['room-info-edit']['floor'] = $floor;
                    $_SESSION['actions'][$rand]['room-info-edit']['floorBengali'] = $floor;
                    
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
                            
                            $_SESSION['actions'][$rand]['room-info-edit']['floorBengali'] = $floor + 1;
                            
                        }
                        
                    }
                    
                    $size_of_flat = $_POST['size'];
                    $_SESSION['actions'][$rand]['room-info-edit']['size_of_flat'] = $size_of_flat;
                    
                    if($size_of_flat != ''){
                        
                        $size_of_flatx = strip_tags($size_of_flat);
                        $size_of_flat = str_replace(' ','',$size_of_flatx);
                        
                        if(!preg_match("/^[0-9.]+$/",$size_of_flat)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&fl-sz=0';
                            
                        }
                        
                    }
                    
                    $size_of_room = $_POST['room-size'];
                    $_SESSION['actions'][$rand]['room-info-edit']['size_of_room'] = $size_of_room;
                    
                    if($size_of_room != ''){
                        
                        $size_of_roomx = strip_tags($size_of_room);
                        $size_of_room = str_replace(' ','',$size_of_roomx);
                        
                        if(!preg_match("/^[0-9.]+$/",$size_of_room)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&rm-sz=0';
                            
                        }
                        
                    }
                    
                    $number_of_rooms = $_POST['number-of-rooms'];
                    $_SESSION['actions'][$rand]['room-info-edit']['number_of_rooms'] = $number_of_rooms;
                    
                    if($number_of_rooms != ''){
                        
                        $number_of_roomsx = strip_tags($number_of_rooms);
                        $number_of_rooms = str_replace(' ','',$number_of_roomsx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_rooms)){
                        
                            $errorFound = 1;
                
                            $error_link = $error_link . '&num-rm=0';
                            
                        }
                        
                    }
                    
                    $number_of_washrooms = $_POST['number-of-washrooms'];
                    $_SESSION['actions'][$rand]['room-info-edit']['number_of_washrooms'] = $number_of_washrooms;
                    
                    if($number_of_washrooms != ''){
                        
                        $number_of_washroomsx = strip_tags($number_of_washrooms);
                        $number_of_washrooms = str_replace(' ','',$number_of_washroomsx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_washrooms)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&num-wsrm=0';
                            
                        }
                        
                    }
                    
                    $washroom_attached = $_POST['washroom-attached'];
                    
                    if(!(($washroom_attached == 'Yes') || ($washroom_attached == 'No'))){
                        
                        $washroom_attached = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['room-info-edit']['washroom_attached'] = $washroom_attached;
                    
                    $number_of_balconies = $_POST['number-of-balconies'];
                    $_SESSION['actions'][$rand]['room-info-edit']['number_of_balconies'] = $number_of_balconies;
                    
                    if($number_of_balconies != ''){
                        
                        $number_of_balconiesx = strip_tags($number_of_balconies);
                        $number_of_balconies = str_replace(' ','',$number_of_balconiesx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_balconies)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&num-bal=0';
                            
                        }
                        
                    }
                    
                    $balcony_attached = $_POST['balcony-attached'];
                    
                    if(!(($balcony_attached == 'Yes') || ($balcony_attached == 'No'))){
                        
                        $balcony_attached = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['room-info-edit']['balcony_attached'] = $balcony_attached;
                    
                    $total_floors = $_POST['total-floor'];
                    $_SESSION['actions'][$rand]['room-info-edit']['total_floors'] = $total_floors;
                    $_SESSION['actions'][$rand]['room-info-edit']['total_floorsBengali'] = $total_floors;
                    
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
                            
                            $_SESSION['actions'][$rand]['room-info-edit']['total_floorsBengali'] = $total_floors + 1;
                            
                        }
                        
                    }
                    
                    $lift = $_POST['lift'];
                    
                    if(!(($lift == 'Yes') || ($lift == 'No'))){
                        
                        $lift = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['room-info-edit']['lift'] = $lift;
                    
                    $parking_facility = $_POST['parking-facility'];
                    
                    if(!(($parking_facility == 'Yes') || ($parking_facility == 'No'))){
                        
                        $parking_facility = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['room-info-edit']['parking_facility'] = $parking_facility;
                    
                    $other_description = $_POST['other-description'];
                    $_SESSION['actions'][$rand]['room-info-edit']['other_description'] = $other_description;
                    
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
                        $other_description = str_replace(' ','*^*',$other_description);
                        
                    }
                    
                    if($errorFound == 1){
                        
                        header('Location:' . $error_link);
                        exit;
                        
                    }
                    
                    $query = "UPDATE info SET mess='$mess',available_from='$available_from',male='$male',female='$female',family='$family',max_people='$max_people',rental_price='$rental_price',rental_price_nego='$rental_price_nego',security_money='$security_money',security_money_nego='$security_money_nego',full_address='$full_address',contact_no='$contact_no',contact_email='$contact_email',flat_no='$flat_no',floor='$floor',size_of_flat='$size_of_flat',size_of_room='$size_of_room',number_of_rooms='$number_of_rooms',number_of_washrooms='$number_of_washrooms',washroom_attached='$washroom_attached',number_of_balconies='$number_of_balconies',balcony_attached='$balcony_attached',total_floors='$total_floors',lift='$lift',parking_facility='$parking_facility',other_description='$other_description' WHERE id='$adID'";
                    $result = mysqli_query($dbcUpdate,$query);
					
					for($i=1; $i<=5; $i++){
						
						if(isset($_SESSION['mark'][$spRand]['photo_' . $i])){
							
							$filePath = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
							
							if(!$filePath){
								
								$explode = explode('.',$_SESSION['mark'][$spRand]['photo_' . $i]);
								$extension = $explode[1];
								$preAddress = 'uploadedPhotos/temp/' . $id . '_' . $spRand . '_' . $i . '.' . $extension;
								$newAddress = 'uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.' . $extension;
								
								rename($preAddress, $newAddress);
								
							}
							
						}
						
					}
                    
                    $_SESSION['mark'][$spRand] = NULL;
                    $_SESSION['actions'][$rand]['room-info-edit'] = NULL;
                    
                    header('Location:advertisements?act-suc=edit&page=' . $pageNum);
                    exit;
                    
                }
                
            }
            else if($mess == 1){
                
                if(isset($_SESSION['actions'][$rand]['mess-info-edit'])){
                
                    $available_from = $_SESSION['actions'][$rand]['mess-info-edit']['available_from'];
                    $male = $_SESSION['actions'][$rand]['mess-info-edit']['male'];
                    $female = $_SESSION['actions'][$rand]['mess-info-edit']['female'];
                    $max_people = $_SESSION['actions'][$rand]['mess-info-edit']['max_people'];
                    $rental_price = $_SESSION['actions'][$rand]['mess-info-edit']['rental_price'];
                    $rental_price_nego = $_SESSION['actions'][$rand]['mess-info-edit']['rental_price_nego'];
                    $security_money = $_SESSION['actions'][$rand]['mess-info-edit']['security_money'];
                    $security_money_nego = $_SESSION['actions'][$rand]['mess-info-edit']['security_money_nego'];
                    $full_address = $_SESSION['actions'][$rand]['mess-info-edit']['full_address'];
                    $contact_no = $_SESSION['actions'][$rand]['mess-info-edit']['contact_no'];
                    $contact_email = $_SESSION['actions'][$rand]['mess-info-edit']['contact_email'];
                    $flat_no = $_SESSION['actions'][$rand]['mess-info-edit']['flat_no'];
                    $floor = $_SESSION['actions'][$rand]['mess-info-edit']['floor'];
                    $size_of_flat = $_SESSION['actions'][$rand]['mess-info-edit']['size_of_flat'];
                    $size_of_room = $_SESSION['actions'][$rand]['mess-info-edit']['size_of_room'];
                    $number_of_rooms = $_SESSION['actions'][$rand]['mess-info-edit']['number_of_rooms'];
                    $number_of_washrooms = $_SESSION['actions'][$rand]['mess-info-edit']['number_of_washrooms'];
                    $washroom_attached = $_SESSION['actions'][$rand]['mess-info-edit']['washroom_attached'];
                    $number_of_balconies = $_SESSION['actions'][$rand]['mess-info-edit']['number_of_balconies'];
                    $balcony_attached = $_SESSION['actions'][$rand]['mess-info-edit']['balcony_attached'];
                    $total_floors = $_SESSION['actions'][$rand]['mess-info-edit']['total_floors'];
                    $lift = $_SESSION['actions'][$rand]['mess-info-edit']['lift'];
                    $other_description = $_SESSION['actions'][$rand]['mess-info-edit']['other_description'];
                
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
                if(isset($_GET['av-fo'])){
                    
                    ?>
                    <style>
                        #av-fo{
                            
                            visibility:visible;
                            
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['mx-ppl'])){
                    
                    ?>
                    <style>
                        #mx-ppl{
                            
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
                if(isset($_GET['rm-sz'])){
                    
                    ?>
                    <style>
                        #rm-sz{
                            
                            visibility:visible;
                            
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['num-rm'])){
                    
                    ?>
                    <style>
                        #num-rm{
                            
                            visibility:visible;
                            
                
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['num-wsrm'])){
                    
                    ?>
                    <style>
                        #num-wsrm{
                            
                            visibility:visible;
                            
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['num-bal'])){
                    
                    ?>
                    <style>
                        #num-bal{
                            
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
                
                <form action="" method="post">
                    <table id="messInfo">
                        <tr id="heading"><td colspan="2">Edit Mess Info</td></tr>
                        <tr><td>Advertisement type</td> <td><?php if($sale == 1){ echo 'Sale'; }else if($rent == 1){ echo 'Rent'; } ?></td></tr>
                        <tr>
                            <td id="firstColumn">Available from</td><td id="secondColumn"><input type="text" id="datepicker" name="available_from" value="<?php echo $available_from; ?>" readonly /> <span id="date" class="sidenote">Date formation is incorrect</span></td>
                        </tr>
                        <tr>
                            <td>Available for</td> <td><input type="checkbox" name="single-male" <?php if($male == 1){ echo 'checked'; } ?> >Single (Male) <span id="av-fo" class="sidenote">Check at least one field</span><br> <input type="checkbox" name="single-female" <?php if($female == 1){ echo 'checked'; } ?> >Single (Female)</td>
                        </tr>
                        <tr id="maxNumPeople">
                            <td>Maximum number of people in the room<input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">Maximum number of people who will share the same room containing this mess space.</span></td> <td><input type="text" name="max-people-in-mess" value="<?php echo $max_people; ?>" pattern="^[0-9]+"> <span id="mx-ppl" class="sidenote">Use a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Rental price per month</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> >Negotiable <span id="rent" class="sidenote">Enter a valid amount</span></td>
                        </tr>
                        <tr>
                            <td>Security money<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">Amount that will be taken before the person moves to the mess.</span></td> <td><input type="text" name="security-money" value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>>Negotiable <span id="sc" class="sidenote">Enter a valid amount</span></td>
                        </tr>
                        <tr>
                            <td>Full Address</td> <td><textarea name="full-address" placeholder="This part will be shown in your advertisement with big letters. Make sure you only write the full address here. e.g. House No : 30, Road No : 2/A, Bengali Street, Dhaka, Bangladesh. If you have any other information to mention, write it in 'Other description' field which you will find in the bottom of this form."><?php echo $full_address; ?></textarea> <span id="address" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Contact no.</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >Bangladesh(+880)</option></select> <input type="text" name="contact-no" id="contact-no" value="<?php echo $contact_no; ?>" pattern="^[0-9]+"> <span id="cn" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Email</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" value="<?php echo $contact_email; ?>"> <span id="email" class="sidenote">Enter a valid Email</span></td>
                        </tr>
                        
                        <tr id="additionalHeading">
                            <td colspan="2">Additional Info</td>
                        </tr>
            
                        <tr>
                            <td>Flat no.</td> <td><input type="text" name="flat-no" value="<?php echo $flat_no; ?>"> <span id="flat" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Floor</td> <td><input type="text" name="floor" value="<?php echo $floor; ?>" pattern="^[0-9-]+"> <span id="floor" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Size of the flat</td> <td><input type="text" name="size" value="<?php echo $size_of_flat; ?>" pattern="^[0-9.]+"> square feet <span id="fl-sz" class="sidenote">Enter a valid size</span></td>
                        </tr>
                        <tr>
                            <td>Size of the room</td> <td><input type="text" name="room-size" value="<?php echo $size_of_room; ?>" pattern="^[0-9.]+"> square feet <span id="rm-sz" class="sidenote">Enter a valid size</span></td>
                        </tr>
                        <tr>
                            <td>Number of rooms in the flat</td> <td><input type="text" name="number-of-rooms" value="<?php echo $number_of_rooms; ?>" pattern="^[0-9]+"> <span id="num-rm" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Number of washrooms in the flat</td> <td><input type="text" name="number-of-washrooms" value="<?php echo $number_of_washrooms; ?>" pattern="^[0-9]+"> <span id="num-wsrm" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Is there any washroom attached to this room?</td> <td><select name="washroom-attached">
                                    <option value="Yes" <?php if($washroom_attached == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                                    <option value="No" <?php if($washroom_attached == 'No'){ echo 'selected'; } ?> >No</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Number of balconies in the flat</td> <td><input type="text" name="number-of-balconies" value="<?php echo $number_of_balconies; ?>" pattern="^[0-9]+"> <span id="num-bal" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Is there any balcony attached to this room?</td> <td><select name="balcony-attached">
                                    <option value="Yes" <?php if($balcony_attached == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                                    <option value="No" <?php if($balcony_attached == 'No'){ echo 'selected'; } ?> >No</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Total number of floors in the house</td> <td><input type="text" name="total-floor" value="<?php echo $total_floors; ?>" pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Is there any lift to reach the flat containing this room?</td> <td><select name="lift">
                                    <option value="Yes" <?php if($lift == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                                    <option value="No" <?php if($lift == 'No'){ echo 'selected'; } ?> >No</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Other description</td> <td><textarea name="other-description" placeholder="Write any additional information you want to mention. e.g. The room is spacious and big enough for four people to stay. It has two big windows. Students will have special facilities here......., etc. Additional phone number : 01............, 02........... Additional Email : no-reply@kikhuji.com"><?php echo $other_description; ?></textarea> <span id="oth-des" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Photos</td>
                            <td id="photos">
                                <div id="allForms">
                                    <form>
                                    </form>
                                    
                                    <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_1" id="key_1" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_1">+</button>
                                            <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                        </div>
                                        
                                        <div id="progressbarContainer_1" style="display:none">
                                            <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_1']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_1">
                                            <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_2" id="key_2" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_2">+</button>
                                            <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                        </div>
                                        
                                        <div id="progressbarContainer_2" style="display:none">
                                            <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_2']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_2">
                                            <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_3" id="key_3" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_3">+</button>
                                            <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                        </div>
                                        
                                        <div id="progressbarContainer_3" style="display:none">
                                            <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_3']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_3">
                                            <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_4" id="key_4" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_4">+</button>
                                            <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                        </div>
                                        
                                        <div id="progressbarContainer_4" style="display:none">
                                            <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_4']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_4">
                                            <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_5" id="key_5" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$spRand]['photo_5'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_5">+</button>
                                            <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                        </div>
                                        
                                        <div id="progressbarContainer_5" style="display:none">
                                            <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$spRand]['photo_5'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_5']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
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
                            <td colspan="2"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">Back to Advertisements</a></td>
                        </tr>
                    </table>
                </form>
                
                <?php
                
                if(isset($_POST['submit'])){
                    
                    $errorFound = 0;
                    $error_link = 'actions?key=' . $rand . '&act=edit&ser=' . $adID . '&pg=' . $pageNum;
                    
                    $available_from = $_POST['available_from'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['available_from'] = $available_from;
                    
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
                    
                    $male = 0;
                    
                    if(isset($_POST['single-male'])){
                        
                        $male = 1;
                        
                    }
                    
                    $_SESSION['actions'][$rand]['mess-info-edit']['male'] = $male;
                    
                    $female = 0;
                    
                    if(isset($_POST['single-female'])){
                        
                        $female = 1;
                        
                    }
                    
                    $_SESSION['actions'][$rand]['mess-info-edit']['female'] = $female;
                    
                    if(($male == 0) && ($female == 0)){
                        
                        $errorFound = 1;
                        $error_link = $error_link . '&av-fo=0';
                        
                    }
                    
                    $max_people = $_POST['max-people-in-mess'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['max_people'] = $max_people;
                    
                    if($max_people != ''){
                        
                        $max_peoplex = strip_tags($max_people);
                        $max_people = str_replace(' ','',$max_peoplex);
                        
                        if(($max_people == 0) || (!preg_match("/^[0-9]+$/",$max_people))){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&mx-ppl=0';
                            
                        }	
                        
                    }
                    
                    $rental_price = $_POST['rental-price'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['rental_price'] = $rental_price;
                    
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
                    
                    $_SESSION['actions'][$rand]['mess-info-edit']['rental_price_nego'] = $rental_price_nego;
                    
                    $security_money = $_POST['security-money'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['security_money'] = $security_money;
                    
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
                    
                    $_SESSION['actions'][$rand]['mess-info-edit']['security_money_nego'] = $security_money_nego;
                    
                    $full_address = $_POST['full-address'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['full_address'] = $full_address;
                    
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
                        $full_address = str_replace(' ','*^*',$full_address);
                        
                    }
                    
                    $contact_no = $_POST['contact-no'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['contact_no'] = $contact_no;
                    $contact_no_option = $_POST['contact-no-option'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['contact_no_option'] = $contact_no_option;
                    
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
                    $_SESSION['actions'][$rand]['mess-info-edit']['contact_email'] = $contact_email;
                    
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
                    
                    $flat_no = $_POST['flat-no'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['flat_no'] = $flat_no;
                    
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
                        $flat_no = str_replace(' ','*^*',$flat_no);
                        
                    }
                    
                    $floor = $_POST['floor'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['floor'] = $floor;
                    $_SESSION['actions'][$rand]['mess-info-edit']['floorBengali'] = $floor;
                    
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
                            
                            $_SESSION['actions'][$rand]['mess-info-edit']['floorBengali'] = $floor + 1;
                            
                        }
                        
                    }
                    
                    $size_of_flat = $_POST['size'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['size_of_flat'] = $size_of_flat;
                    
                    if($size_of_flat != ''){
                        
                        $size_of_flatx = strip_tags($size_of_flat);
                        $size_of_flat = str_replace(' ','',$size_of_flatx);
                        
                        if(!preg_match("/^[0-9.]+$/",$size_of_flat)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&fl-sz=0';
                            
                        }
                        
                    }
                    
                    $size_of_room = $_POST['room-size'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['size_of_room'] = $size_of_room;
                    
                    if($size_of_room != ''){
                        
                        $size_of_roomx = strip_tags($size_of_room);
                        $size_of_room = str_replace(' ','',$size_of_roomx);
                        
                        if(!preg_match("/^[0-9.]+$/",$size_of_room)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&rm-sz=0';
                            
                        }
                        
                    }
                    
                    $number_of_rooms = $_POST['number-of-rooms'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['number_of_rooms'] = $number_of_rooms;
                    
                    if($number_of_rooms != ''){
                        
                        $number_of_roomsx = strip_tags($number_of_rooms);
                        $number_of_rooms = str_replace(' ','',$number_of_roomsx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_rooms)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&num-rm=0';
                            
                        }
                        
                    }
                    
                    $number_of_washrooms = $_POST['number-of-washrooms'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['number_of_washrooms'] = $number_of_washrooms;
                    
                    if($number_of_washrooms != ''){
                        
                        $number_of_washroomsx = strip_tags($number_of_washrooms);
                        $number_of_washrooms = str_replace(' ','',$number_of_washroomsx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_washrooms)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&num-wsrm=0';
                            
                        }
                        
                    }
                    
                    $washroom_attached = $_POST['washroom-attached'];
                    
                    if(!(($washroom_attached == 'Yes') || ($washroom_attached == 'No'))){
                        
                        $washroom_attached = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['mess-info-edit']['washroom_attached'] = $washroom_attached;
                    
                    $number_of_balconies = $_POST['number-of-balconies'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['number_of_balconies'] = $number_of_balconies;
                    
                    if($number_of_balconies != ''){
                        
                        $number_of_balconiesx = strip_tags($number_of_balconies);
                        $number_of_balconies = str_replace(' ','',$number_of_balconiesx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_balconies)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&num-bal=0';
                            
                        }
                        
                    }
                    
                    $balcony_attached = $_POST['balcony-attached'];
                    
                    if(!(($balcony_attached == 'Yes') || ($balcony_attached == 'No'))){
                        
                        $balcony_attached = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['mess-info-edit']['balcony_attached'] = $balcony_attached;
                    
                    $total_floors = $_POST['total-floor'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['total_floors'] = $total_floors;
                    $_SESSION['actions'][$rand]['mess-info-edit']['total_floorsBengali'] = $total_floors;
                    
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
                            
                            $_SESSION['actions'][$rand]['mess-info-edit']['total_floorsBengali'] = $total_floors + 1;
                            
                        }
                        
                    }
                    
                    $lift = $_POST['lift'];
                    
                    if(!(($lift == 'Yes') || ($lift == 'No'))){
                        
                        $lift = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['mess-info-edit']['lift'] = $lift;
                    
                    $other_description = $_POST['other-description'];
                    $_SESSION['actions'][$rand]['mess-info-edit']['other_description'] = $other_description;
                    
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
                        $other_description = str_replace(' ','*^*',$other_description);
                        
                    }
                    
                    if($errorFound == 1){
                        
                        header('Location:' . $error_link);
                        exit;
                        
                    }
                    
                    $query = "UPDATE info SET available_from='$available_from',male='$male',female='$female',max_people='$max_people',rental_price='$rental_price',rental_price_nego='$rental_price_nego',security_money='$security_money',security_money_nego='$security_money_nego',full_address='$full_address',contact_no='$contact_no',contact_email='$contact_email',flat_no='$flat_no',floor='$floor',size_of_flat='$size_of_flat',size_of_room='$size_of_room',number_of_rooms='$number_of_rooms',number_of_washrooms='$number_of_washrooms',washroom_attached='$washroom_attached',number_of_balconies='$number_of_balconies',balcony_attached='$balcony_attached',total_floors='$total_floors',lift='$lift',other_description='$other_description' WHERE id='$adID'";
                    $result = mysqli_query($dbcUpdate,$query);
					
					for($i=1; $i<=5; $i++){
						
						if(isset($_SESSION['mark'][$spRand]['photo_' . $i])){
							
							$filePath = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
							
							if(!$filePath){
								
								$explode = explode('.',$_SESSION['mark'][$spRand]['photo_' . $i]);
								$extension = $explode[1];
								$preAddress = 'uploadedPhotos/temp/' . $id . '_' . $spRand . '_' . $i . '.' . $extension;
								$newAddress = 'uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.' . $extension;
								
								rename($preAddress, $newAddress);
								
							}
							
						}
						
					}
                    
                    $_SESSION['mark'][$spRand] = NULL;
                    $_SESSION['actions'][$rand]['mess-info-edit'] = NULL;
                    
                    header('Location:advertisements?act-suc=edit&page=' . $pageNum);
                    exit;
                    
                }
                
            }
            else if($officespace == 1){
                
                if(isset($_SESSION['actions'][$rand]['officespace-edit-info'])){
                    
                    $available_from = $_SESSION['actions'][$rand]['officespace-edit-info']['available_from'];
                    $rental_price = $_SESSION['actions'][$rand]['officespace-edit-info']['rental_price'];
                    $rental_price_nego = $_SESSION['actions'][$rand]['officespace-edit-info']['rental_price_nego'];
                    $security_money = $_SESSION['actions'][$rand]['officespace-edit-info']['security_money'];
                    $security_money_nego = $_SESSION['actions'][$rand]['officespace-edit-info']['security_money_nego'];
                    $full_address = $_SESSION['actions'][$rand]['officespace-edit-info']['full_address'];
                    $contact_no_option = $_SESSION['actions'][$rand]['officespace-edit-info']['contact_no_option'];
                    $contact_no = $_SESSION['actions'][$rand]['officespace-edit-info']['contact_no'];
                    $contact_email = $_SESSION['actions'][$rand]['officespace-edit-info']['contact_email'];
                    $flat_no = $_SESSION['actions'][$rand]['officespace-edit-info']['flat_no'];
                    $floor = $_SESSION['actions'][$rand]['officespace-edit-info']['floor'];
                    $size_of_flat = $_SESSION['actions'][$rand]['officespace-edit-info']['size_of_flat'];
                    $number_of_rooms = $_SESSION['actions'][$rand]['officespace-edit-info']['number_of_rooms'];
                    $number_of_washrooms = $_SESSION['actions'][$rand]['officespace-edit-info']['number_of_washrooms'];
                    $total_floors = $_SESSION['actions'][$rand]['officespace-edit-info']['total_floors'];
                    $lift = $_SESSION['actions'][$rand]['officespace-edit-info']['lift'];
                    $elevator = $_SESSION['actions'][$rand]['officespace-edit-info']['elevator'];
                    $parking_facility = $_SESSION['actions'][$rand]['officespace-edit-info']['parking_facility'];
                    $other_description = $_SESSION['actions'][$rand]['officespace-edit-info']['other_description'];
                    
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
                if(isset($_GET['num-rm'])){
                    
                    ?>
                    <style>
                        #num-rm{
                            
                            visibility:visible;
                            
                        }
                    </style>
                    <?php
                    
                }
                if(isset($_GET['num-wsrm'])){
                    
                    ?>
                    <style>
                        #num-wsrm{
                            
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
                
                <form action="" method="post">
                    <table id="officespaceInfo">
                        <tr id="heading"><td colspan="2">Edit Office Info</td></tr>
                        <tr><td>Advertisement type</td> <td><?php if($sale == 1){ echo 'Sale'; }else if($rent == 1){ echo 'Rent'; } ?></td></tr>
                        <tr>
                            <td id="firstColumn">Available from</td><td id="secondColumn"><input type="text" id="datepicker" name="available_from" value="<?php echo $available_from; ?>" readonly /> <span id="date" class="sidenote">Date formation is incorrect</span></td>
                        </tr>
                        <?php
                        
                        if($sale == 1){
                            
                            ?>
                            <tr>
                                <td>Price</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> >Negotiable <span id="rent" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <tr>
                                <td>Booking money<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">Amount that will be taken initially to start the purchasing process.</span></td> <td><input type="text" name="security-money" value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>>Negotiable <span id="sc" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <?php
                            
                        }
                        else if($rent == 1){
                            
                            ?>
                            <tr>
                                <td>Rental price per month</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> >Negotiable <span id="rent" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <tr>
                                <td>Security money<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">Amount that will be taken before the person start using the office space.</span></td> <td><input type="text" name="security-money" value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>>Negotiable <span id="sc" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <?php
                            
                        }
                        
                        ?>
                        <tr>
                            <td>Full Address</td> <td><textarea name="full-address" placeholder="This part will be shown in your advertisement with big letters. Make sure you only write the full address here. e.g. Building No : 30, Road No : 2/A, Bengali Street, Dhaka, Bangladesh. If you have any other information to mention, write it in 'Other description' field which you will find in the bottom of this form."><?php echo $full_address; ?></textarea> <span id="address" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Contact no.</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >Bangladesh(+880)</option></select> <input type="text" name="contact-no" id="contact-no" value="<?php echo $contact_no; ?>" pattern="^[0-9]+"> <span id="cn" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Email</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" value="<?php echo $contact_email; ?>"> <span id="email" class="sidenote">Enter a valid Email</span></td>
                        </tr>
                        
                        <tr id="additionalHeading">
                            <td colspan="2">Additional Info</td>
                        </tr>
            
                        <tr>
                            <td>Office space no.</td> <td><input type="text" name="office-no" value="<?php echo $flat_no; ?>"> <span id="flat" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Floor</td> <td><input type="text" name="floor" value="<?php echo $floor; ?>" pattern="^[0-9-]+"> <span id="floor" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Size of the space</td> <td><input type="text" name="office-size" value="<?php echo $size_of_flat; ?>" pattern="^[0-9.]+"> square feet <span id="fl-sz" class="sidenote">Enter a valid size</span></td>
                        </tr>
                        <tr>
                            <td>Number of rooms</td> <td><input type="text" name="number-of-rooms" value="<?php echo $number_of_rooms; ?>" pattern="^[0-9]+"> <span id="num-rm" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Number of washrooms</td> <td><input type="text" name="number-of-washrooms" value="<?php echo $number_of_washrooms; ?>" pattern="^[0-9]+"> <span id="num-wsrm" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Total number of floors in the building</td> <td><input type="text" name="total-floor" value="<?php echo $total_floors; ?>" pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Is there any lift to reach the floor containing this space?</td> <td><select name="lift">
                                    <option value="Yes" <?php if($lift == 'Yes'){ echo 'selected'; } ?> >Yes</option>
                                    <option value="No" <?php if($lift == 'No'){ echo 'selected'; } ?> >No</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Is there any elevator to reach the floor containing this space?</td> <td><select name="elevator">
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
                            <td>Other description</td> <td><textarea name="other-description" placeholder="Write any additional information you want to mention. e.g. The place is spacious and well ventilated. There are 3 rooms and 2 washrooms........, etc. Additional phone number : 01............, 02........... Additional Email : no-reply@kikhuji.com"><?php echo $other_description; ?></textarea> <span id="oth-des" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Photos</td>
                            <td id="photos">
                                <div id="allForms">
                                    <form>
                                    </form>
                                    
                                    <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_1" id="key_1" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_1">+</button>
                                            <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                        </div>
                                        
                                        <div id="progressbarContainer_1" style="display:none">
                                            <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_1']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_1">
                                            <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_2" id="key_2" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_2">+</button>
                                            <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                        </div>
                                        
                                        <div id="progressbarContainer_2" style="display:none">
                                            <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_2']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_2">
                                            <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_3" id="key_3" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_3">+</button>
                                            <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                        </div>
                                        
                                        <div id="progressbarContainer_3" style="display:none">
                                            <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_3']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_3">
                                            <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_4" id="key_4" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_4">+</button>
                                            <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                        </div>
                                        
                                        <div id="progressbarContainer_4" style="display:none">
                                            <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_4']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_4">
                                            <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_5" id="key_5" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$spRand]['photo_5'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_5">+</button>
                                            <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                        </div>
                                        
                                        <div id="progressbarContainer_5" style="display:none">
                                            <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$spRand]['photo_5'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_5']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
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
                            <td colspan="2"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">Back to Advertisements</a></td>
                        </tr>
                    </table>
                </form>
                
                <?php
                
                if(isset($_POST['submit'])){
                    
                    $errorFound = 0;
                    $error_link = 'actions?key=' . $rand . '&act=edit&ser=' . $adID . '&pg=' . $pageNum;
                    
                    $available_from = $_POST['available_from'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['available_from'] = $available_from;
                    
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
                    $_SESSION['actions'][$rand]['officespace-edit-info']['rental_price'] = $rental_price;
                    
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
                    
                    $_SESSION['actions'][$rand]['officespace-edit-info']['rental_price_nego'] = $rental_price_nego;
                    
                    $security_money = $_POST['security-money'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['security_money'] = $security_money;
                    
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
                    
                    $_SESSION['actions'][$rand]['officespace-edit-info']['security_money_nego'] = $security_money_nego;
                    
                    $full_address = $_POST['full-address'];
                    
                    $_SESSION['actions'][$rand]['officespace-edit-info']['full_address'] = $full_address;
                    
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
                        $full_address = str_replace(' ','*^*',$full_address);
                        
                    }
                    
                    $contact_no = $_POST['contact-no'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['contact_no'] = $contact_no;
                    $contact_no_option = $_POST['contact-no-option'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['contact_no_option'] = $contact_no_option;
                    
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
                    $_SESSION['actions'][$rand]['officespace-edit-info']['contact_email'] = $contact_email;
                    
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
                    
                    $flat_no = $_POST['office-no'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['flat_no'] = $flat_no;
                    
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
                        $flat_no = str_replace(' ','*^*',$flat_no);
                        
                    }
                    
                    $floor = $_POST['floor'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['floor'] = $floor;
                    $_SESSION['actions'][$rand]['officespace-edit-info']['floorBengali'] = $floor;
                    
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
                            
                            $_SESSION['actions'][$rand]['officespace-edit-info']['floorBengali'] = $floor + 1;
                            
                        }
                        
                    }
                    
                    $size_of_flat = $_POST['office-size'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['size_of_flat'] = $size_of_flat;
                    
                    if($size_of_flat != ''){
                        
                        $size_of_flatx = strip_tags($size_of_flat);
                        $size_of_flat = str_replace(' ','',$size_of_flatx);
                        
                        if(!preg_match("/^[0-9.]+$/",$size_of_flat)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&fl-sz=0';
                            
                        }
                        
                    }
                    
                    $number_of_rooms = $_POST['number-of-rooms'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['number_of_rooms'] = $number_of_rooms;
                    
                    if($number_of_rooms != ''){
                        
                        $number_of_roomsx = strip_tags($number_of_rooms);
                        $number_of_rooms = str_replace(' ','',$number_of_roomsx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_rooms)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&num-rm=0';
                            
                        }
                        
                    }
                    
                    $number_of_washrooms = $_POST['number-of-washrooms'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['number_of_washrooms'] = $number_of_washrooms;
                    
                    if($number_of_washrooms != ''){
                        
                        $number_of_washroomsx = strip_tags($number_of_washrooms);
                        $number_of_washrooms = str_replace(' ','',$number_of_washroomsx);
                        
                        if(!preg_match("/^[0-9]+$/",$number_of_washrooms)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&num-wsrm=0';
                            
                        }
                        
                    }
                    
                    $total_floors = $_POST['total-floor'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['total_floors'] = $total_floors;
                    $_SESSION['actions'][$rand]['officespace-edit-info']['total_floorsBengali'] = $total_floors;
                    
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
                            
                            $_SESSION['actions'][$rand]['officespace-edit-info']['total_floorsBengali'] = $total_floors + 1;
                            
                        }
                        
                    }
                    
                    $lift = $_POST['lift'];
                    
                    if(!(($lift == 'Yes') || ($lift == 'No'))){
                        
                        $lift = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['officespace-edit-info']['lift'] = $lift;
                    
                    $elevator = $_POST['elevator'];
                    
                    if(!(($elevator == 'Yes') || ($elevator == 'No'))){
                        
                        $elevator = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['officespace-edit-info']['elevator'] = $elevator;
                    
                    $parking_facility = $_POST['parking-facility'];
                    
                    if(!(($parking_facility == 'Yes') || ($parking_facility == 'No'))){
                        
                        $parking_facility = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['officespace-edit-info']['parking_facility'] = $parking_facility;
                    
                    $other_description = $_POST['other-description'];
                    $_SESSION['actions'][$rand]['officespace-edit-info']['other_description'] = $other_description;
                    
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
                        $other_description = str_replace(' ','*^*',$other_description);
                        
                    }
                    
                    if($errorFound == 1){
                        
                        header('Location:' . $error_link);
                        exit;
                        
                    }
                    
                    $query = "UPDATE info SET available_from='$available_from',rental_price='$rental_price',rental_price_nego='$rental_price_nego',security_money='$security_money',security_money_nego='$security_money_nego',full_address='$full_address',contact_no='$contact_no',contact_email='$contact_email',flat_no='$flat_no',floor='$floor',size_of_flat='$size_of_flat',number_of_rooms='$number_of_rooms',number_of_washrooms='$number_of_washrooms',total_floors='$total_floors',lift='$lift',elevator='$elevator',parking_facility='$parking_facility',other_description='$other_description' WHERE id='$adID'";
                    $result = mysqli_query($dbcUpdate,$query);
					
					for($i=1; $i<=5; $i++){
						
						if(isset($_SESSION['mark'][$spRand]['photo_' . $i])){
							
							$filePath = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
							
							if(!$filePath){
								
								$explode = explode('.',$_SESSION['mark'][$spRand]['photo_' . $i]);
								$extension = $explode[1];
								$preAddress = 'uploadedPhotos/temp/' . $id . '_' . $spRand . '_' . $i . '.' . $extension;
								$newAddress = 'uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.' . $extension;
								
								rename($preAddress, $newAddress);
								
							}
							
						}
						
					}
                    
                    $_SESSION['mark'][$spRand] = NULL;
                    $_SESSION['actions'][$rand]['officespace-edit-info'] = NULL;
                    
                    header('Location:advertisements?act-suc=edit&page=' . $pageNum);
                    exit;
                    
                }
                
            }
            else if($shop == 1){
                
                if(isset($_SESSION['actions'][$rand]['shop-info-edit'])){
                    
                    $available_from = $_SESSION['actions'][$rand]['shop-info-edit']['available_from'];
                    $rental_price = $_SESSION['actions'][$rand]['shop-info-edit']['rental_price'];
                    $rental_price_nego = $_SESSION['actions'][$rand]['shop-info-edit']['rental_price_nego'];
                    $security_money = $_SESSION['actions'][$rand]['shop-info-edit']['security_money'];
                    $security_money_nego = $_SESSION['actions'][$rand]['shop-info-edit']['security_money_nego'];
                    $full_address = $_SESSION['actions'][$rand]['shop-info-edit']['full_address'];
                    $contact_no = $_SESSION['actions'][$rand]['shop-info-edit']['contact_no'];
                    $contact_email = $_SESSION['actions'][$rand]['shop-info-edit']['contact_email'];
                    $flat_no = $_SESSION['actions'][$rand]['shop-info-edit']['flat_no'];
                    $floor = $_SESSION['actions'][$rand]['shop-info-edit']['floor'];
                    $size_of_flat = $_SESSION['actions'][$rand]['shop-info-edit']['size_of_flat'];
                    $total_floors = $_SESSION['actions'][$rand]['shop-info-edit']['total_floors'];
                    $lift = $_SESSION['actions'][$rand]['shop-info-edit']['lift'];
                    $elevator = $_SESSION['actions'][$rand]['shop-info-edit']['elevator'];
                    $parking_facility = $_SESSION['actions'][$rand]['shop-info-edit']['parking_facility'];
                    $other_description = $_SESSION['actions'][$rand]['shop-info-edit']['other_description'];
                    
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
                
                <form action="" method="post">
                    <table id="shopInfo">
                        <tr id="heading"><td colspan="2">Edit Shop Info</td></tr>
                        <tr><td>Advertisement type</td> <td><?php if($sale == 1){ echo 'Sale'; }else if($rent == 1){ echo 'Rent'; } ?></td></tr>
                        <tr>
                            <td id="firstColumn">Available from</td><td id="secondColumn"><input type="text" id="datepicker" name="available_from" value="<?php echo $available_from; ?>" readonly /> <span id="date" class="sidenote">Date formation is incorrect</span></td>
                        </tr>
                        <?php
                        
                        if($sale == 1){
                            
                            ?>
                            <tr>
                                <td>Price</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> >Negotiable <span id="rent" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <tr>
                                <td>Booking money<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">Amount that will be taken initially to start the purchasing process.</span></td> <td><input type="text" name="security-money" <value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>>Negotiable <span id="sc" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <?php
                            
                        }
                        else if($rent == 1){
                            
                            ?>
                            <tr>
                                <td>Rental price per month</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> >Negotiable <span id="rent" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <tr>
                                <td>Security money<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">Amount that will be taken before the space is being used.</span></td> <td><input type="text" name="security-money" <value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> BDT <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>>Negotiable <span id="sc" class="sidenote">Enter a valid amount</span></td>
                            </tr>
                            <?php
                            
                        }
                        
                        ?>
                        <tr>
                            <td>Full Address</td> <td><textarea name="full-address" placeholder="This part will be shown in your advertisement with big letters. Make sure you only write the full address here. e.g. Super Market, Road No : 2/A, Bengali Street, Dhaka, Bangladesh. If you have any other information to mention, write it in 'Other description' field which you will find in the bottom of this form."><?php echo $full_address; ?></textarea> <span id="address" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Contact no.</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >Bangladesh(+880)</option></select> <input type="text" name="contact-no" id="contact-no" value="<?php echo $contact_no; ?>" pattern="^[0-9]+"> <span id="cn" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Email</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" value="<?php echo $contact_email; ?>"> <span id="email" class="sidenote">Enter a valid Email</span></td>
                        </tr>
                        
                        <tr id="additionalHeading">
                            <td colspan="2">Additional Info</td>
                        </tr>
            
                        <tr>
                            <td>Shop no.</td> <td><input type="text" name="shop-no" value="<?php echo $flat_no; ?>"></td> <span id="flat" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Floor</td> <td><input type="text" name="floor" value="<?php echo $floor; ?>" pattern="^[0-9-]+"> <span id="floor" class="sidenote">Enter a valid number</span></td>
                        </tr>
                        <tr>
                            <td>Size of the shop</td> <td><input type="text" name="shop-size" value="<?php echo $size_of_flat; ?>" pattern="^[0-9.]+"> square feet <span id="fl-sz" class="sidenote">Enter a valid size</span></td>
                        </tr>
                        <tr>
                            <td>Total number of floors in the building</td> <td><input type="text" name="total-floor" value="<?php echo $total_floors; ?>" pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">Enter a valid number</span></td>
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
                            <td>Other description</td> <td><textarea name="other-description" placeholder="Write any additional information you want to mention. e.g. The shop is well decorated and well painted. It is in front of the market........, etc. Additional phone number : 01............, 02........... Additional Email : no-reply@kikhuji.com"><?php echo $other_description; ?></textarea> <span id="oth-des" class="sidenote">Use valid characters</span></td>
                        </tr>
                        <tr>
                            <td>Photos</td>
                            <td id="photos">
                                <div id="allForms">
                                    <form>
                                    </form>
                                    
                                    <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_1" id="key_1" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_1">+</button>
                                            <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                        </div>
                                        
                                        <div id="progressbarContainer_1" style="display:none">
                                            <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_1']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_1">
                                            <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_2" id="key_2" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_2">+</button>
                                            <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                        </div>
                                        
                                        <div id="progressbarContainer_2" style="display:none">
                                            <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_2']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_2">
                                            <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_3" id="key_3" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_3">+</button>
                                            <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                        </div>
                                        
                                        <div id="progressbarContainer_3" style="display:none">
                                            <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_3']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_3">
                                            <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_4" id="key_4" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_4">+</button>
                                            <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                        </div>
                                        
                                        <div id="progressbarContainer_4" style="display:none">
                                            <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_4']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_4">
                                            <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_5" id="key_5" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$spRand]['photo_5'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_5">+</button>
                                            <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                        </div>
                                        
                                        <div id="progressbarContainer_5" style="display:none">
                                            <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$spRand]['photo_5'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_5']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
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
                            <td colspan="2"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">Back to Advertisements</a></td>
                        </tr>
                    </table>
                </form>
                
                <?php
                
                if(isset($_POST['submit'])){
                    
                    $errorFound = 0;
                    $error_link = 'actions?key=' . $rand . '&act=edit&ser=' . $adID . '&pg=' . $pageNum;
                    
                    $available_from = $_POST['available_from'];
                    $_SESSION['actions'][$rand]['shop-info-edit']['available_from'] = $available_from;
                    
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
                    $_SESSION['actions'][$rand]['shop-info-edit']['rental_price'] = $rental_price;
                    
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
                    
                    $_SESSION['actions'][$rand]['shop-info-edit']['rental_price_nego'] = $rental_price_nego;
                    
                    $security_money = $_POST['security-money'];
                    $_SESSION['actions'][$rand]['shop-info-edit']['security_money'] = $security_money;
                    
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
                    
                    $_SESSION['actions'][$rand]['shop-info-edit']['security_money_nego'] = $security_money_nego;
                    
                    $full_address = $_POST['full-address'];
                    $_SESSION['actions'][$rand]['shop-info-edit']['full_address'] = $full_address;
                    
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
                        $full_address = str_replace(' ','*^*',$full_address);
                        
                    }
                    
                    $contact_no = $_POST['contact-no'];
                    $_SESSION['actions'][$rand]['shop-info-edit']['contact_no'] = $contact_no;
                    $contact_no_option = $_POST['contact-no-option'];
                    $_SESSION['actions'][$rand]['shop-info-edit']['contact_no_option'] = $contact_no_option;
                    
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
                    $_SESSION['actions'][$rand]['shop-info-edit']['contact_email'] = $contact_email;
                    
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
                    $_SESSION['actions'][$rand]['shop-info-edit']['flat_no'] = $flat_no;
                    
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
                        $flat_no = str_replace(' ','*^*',$flat_no);
                        
                    }
                    
                    $floor = $_POST['floor'];
                    $_SESSION['actions'][$rand]['shop-info-edit']['floor'] = $floor;
                    $_SESSION['actions'][$rand]['shop-info-edit']['floorBengali'] = $floor;
                    
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
                            
                            $_SESSION['actions'][$rand]['shop-info-edit']['floorBengali'] = $floor + 1;
                            
                        }
                        
                    }
                    
                    $size_of_flat = $_POST['shop-size'];
                    $_SESSION['actions'][$rand]['shop-info-edit']['size_of_flat'] = $size_of_flat;
                    
                    if($size_of_flat != ''){
                        
                        $size_of_flatx = strip_tags($size_of_flat);
                        $size_of_flat = str_replace(' ','',$size_of_flatx);
                        
                        if(!preg_match("/^[0-9.]+$/",$size_of_flat)){
                        
                            $errorFound = 1;
                            $error_link = $error_link . '&fl-sz=0';
                            
                        }
                        
                    }
                    
                    $total_floors = $_POST['total-floor'];
                    $_SESSION['actions'][$rand]['shop-info-edit']['total_floors'] = $total_floors;
                    $_SESSION['actions'][$rand]['shop-info-edit']['total_floorsBengali'] = $total_floors;
                    
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
                            
                            $_SESSION['actions'][$rand]['shop-info-edit']['total_floorsBengali'] = $total_floors + 1;
                            
                        }
                        
                    }
                    
                    $lift = $_POST['lift'];
                    
                    if(!(($lift == 'Yes') || ($lift == 'No'))){
                        
                        $lift = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['shop-info-edit']['lift'] = $lift;
                    
                    $elevator = $_POST['elevator'];
                    
                    if(!(($elevator == 'Yes') || ($elevator == 'No'))){
                        
                        $elevator = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['shop-info-edit']['elevator'] = $elevator;
                    
                    $parking_facility = $_POST['parking-facility'];
                    
                    if(!(($parking_facility == 'Yes') || ($parking_facility == 'No'))){
                        
                        $parking_facility = 'No';
                        
                    }
                    
                    $_SESSION['actions'][$rand]['shop-info-edit']['parking_facility'] = $parking_facility;
                    
                    $other_description = $_POST['other-description'];
                    $_SESSION['actions'][$rand]['shop-info-edit']['other_description'] = $other_description;
                    
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
                        $other_description = str_replace(' ','*^*',$other_description);
                        
                    }
                    
                    if($errorFound == 1){
                        
                        header('Location:' . $error_link);
                        exit;
                        
                    }
                    
                    $query = "UPDATE info SET available_from='$available_from',rental_price='$rental_price',rental_price_nego='$rental_price_nego',security_money='$security_money',security_money_nego='$security_money_nego',full_address='$full_address',contact_no='$contact_no',contact_email='$contact_email',flat_no='$flat_no',floor='$floor',size_of_flat='$size_of_flat',total_floors='$total_floors',lift='$lift',elevator='$elevator',parking_facility='$parking_facility',other_description='$other_description' WHERE id='$adID'";
                    $result = mysqli_query($dbcUpdate,$query);
					
					for($i=1; $i<=5; $i++){
						
						if(isset($_SESSION['mark'][$spRand]['photo_' . $i])){
							
							$filePath = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
							
							if(!$filePath){
								
								$explode = explode('.',$_SESSION['mark'][$spRand]['photo_' . $i]);
								$extension = $explode[1];
								$preAddress = 'uploadedPhotos/temp/' . $id . '_' . $spRand . '_' . $i . '.' . $extension;
								$newAddress = 'uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.' . $extension;
								
								rename($preAddress, $newAddress);
								
							}
							
						}
						
					}
                    
                    $_SESSION['mark'][$spRand] = NULL;
                    $_SESSION['actions'][$rand]['shop-info-edit'] = NULL;
                    
                    header('Location:advertisements?act-suc=edit&page=' . $pageNum);
                    exit;
                    
                }
                
            }
            
        }
        else if($action == 'delete'){
            
            $contact_no = $contact_no_option . $contact_no;
            
            ?>
            <table id="deleteConfirm">
                <tr>
                    <td id="deleteConfirmQuestion">Are you sure you want to delete it? Once you delete an advertisement, it can not be recovered.</td>
                </tr>
            </table>
            <form action="" method="post">
                <table id="deleteConfirm">
                    <tr><td id="deletePortion"><input type="submit" name="delete" id="deleteButton" value="Yes. Delete it."></td><td id="backPortion"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">No. Go back to advertisements.</a></td></tr>
                </table>
            </form>
            <?php
            
            if($flat == 1){
                
                ?>
                <table id="flatInfoDelete">
                    <tr id="heading"><td colspan="3">Advertisement Details</td></tr>
                    <tr id="postedOn"><td colspan="3">Posted on <?php echo $screenDate; ?> at <?php echo $time; ?></td></tr>
                    <tr>
                        <td id="firstColumnDelete">Status</td> <td id="secondColumnDelete" colspan="2"><?php
                        
                        if($publish == 1){
                            
                            echo 'Available';
                            
                        }
                        else{
                            
                            echo 'Not available';
                            
                        }
                        
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Accomodation Type</td><td>Flat<?php
                            
                        if($mess == 1){
                            
                            echo ', Mess';
                            
                        }
                            
                        ?>
                        </td>
                        <td id="photocolumn" rowspan="4">
                            <?php
                            
                            $photoNames = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                            
                            for($i=0; $i<5; $i++){
                                
                                if(isset($photoNames[$i])){
                                    
                                    ?>
                                    <img id="photo" src="<?php echo $photoNames[$i]; ?>">
                                    <div id="bigImage"><img id="bigPhoto" src="<?php echo $photoNames[$i]; ?>"></div>
                                    <?php
                                    
                                }
                                
                            }
                            
                            ?>
                        </td>
        			</tr>
                    <tr>
                        <td>Location</td> <td><a id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">Find on Google Map</a>
                        </td>
                    </tr>
                    <tr><td>Advertisement type</td> <td><?php if($sale == 1){ echo 'Sale'; }else if($rent == 1){ echo 'Rent'; } ?></td></tr>
                    <tr>
                        <td>Available from</td><td><?php echo $screenAvailableFrom ?></td>
                    </tr>
                    <?php
                    
                    if($sale == 1){
                        
                        ?>
                        <tr>
                            <td>Price</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' BDT';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Booking money</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' BDT';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <?php
                        
                    }
                    else if($rent == 1){
                        
                        ?>
                        <tr>
                            <td>Available for</td> <td colspan="2"><?php
                                
                            if($male == 1){
                                
                                echo 'Single (Male)';
                                
                            }
                            
                            if(($male == 0) && ($female == 1)){
                                
                                echo 'Single (Female)';
                                
                            }
                            else if(($male == 1) && ($female == 1)){
                                
                                echo ', Single (Female)';
                                
                            }
                            
                            if(($male == 0) && ($female == 0) && ($family == 1)){
                                
                                echo 'Family';
                                
                            }
                            else if((($male == 1) || ($female == 1)) && ($family == 1)){
                                
                                echo ', Family';
                                
                            }
                        
                            ?>
                            </td>
                        </tr>
                        
                    <?php
                    
                    if($mess == 1){
                        
                        ?>
                        
                        <tr id="maxNumPeople">
                            <td>Maximum number of people (in case of using as a mess)</td> <td colspan="2"><div id="maxPeople"><?php
                                    
                            if($max_people != ''){
                                
                                echo $max_people;
                                
                            }
                                
                            ?></div>
                            </td>
                        </tr>
                        
                        <?php
                        
                    }
                        
                    ?>
                    
                        <tr>
                            <td>Rental price per month</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' BDT';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Security money</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' BDT';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <?php
                        
                    }
                    
                    ?>
                    <tr>
                        <td>Full Address</td> <td colspan="2"><div id="fullAddress"><?php echo $full_address; ?></div></td>
                    </tr>
                    <tr>
                        <td>Contact no.</td> <td colspan="2"><div id="contactNo"><?php echo $contact_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>Email</td> <td colspan="2"><div id="email"><?php echo $contact_email; ?></div></td>
                    </tr>
                    
                    <tr id="additionalHeading">
                        <td colspan="3">Additional Info</td>
                    </tr>
                
                    <tr>
                        <td>Flat no.</td> <td colspan="2"><div id="flatNo"><?php echo $flat_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>Floor</td> <td colspan="2"><div id="situatingfloor"><?php echo $floor; ?></div></td>
                    </tr>
                    <tr>
                        <td>Size of the flat</td> <td colspan="2"><div id="flatSize"><?php
                        
                        if($size_of_flat != ''){
                            
                            echo $size_of_flat . ' square feet';
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Number of rooms</td> <td colspan="2"><div id="numRoom"><?php echo $number_of_rooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>Number of washrooms</td> <td colspan="2"><div id="numWashroom"><?php echo $number_of_washrooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>Number of balconies</td> <td colspan="2"><div id="numBalcony"><?php echo $number_of_balconies; ?></div></td>
                    </tr>
                    <tr>
                        <td>Total number of floors in the house</td> <td colspan="2"><div id="totalFloor"><?php echo $total_floors; ?></div></td>
                    </tr>
                    <tr>
                        <td>Is there any lift to reach this flat?</td> <td colspan="2"><?php echo $lift; ?></td>
                    </tr>
                    <tr>
                        <td>Is there any parking facility in the building?</td> <td colspan="2"><?php echo $parking_facility; ?></td>
                    </tr>
                    <tr>
                        <td>Other description</td> <td colspan="2"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                    </tr>
                
                </table>
                <?php
                
            }
            else if($room == 1){
                
                ?>
                <table id="roomInfoDelete">
                    <tr id="heading"><td colspan="3">Advertisement Details</td></tr>
                    <tr id="postedOn"><td colspan="3">Posted on <?php echo $screenDate; ?> at <?php echo $time; ?></td></tr>
                    <tr>
                        <td id="firstColumnDelete">Status</td> <td id="secondColumnDelete" colspan="2"><?php
                        
                        if($publish == 1){
                            
                            echo 'Available';
                            
                        }
                        else{
                            
                            echo 'Not available';
                            
                        }
                        
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Accomodation Type</td><td>Room<?php
                            
                                if($mess == 1){
                                    
                                    echo ', Mess';
                                    
                                }
                            
                            ?>
                        </td>
                        <td id="photocolumn" rowspan="4">
                            <?php
                            
                            $photoNames = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                            
                            for($i=0; $i<5; $i++){
                                
                                if(isset($photoNames[$i])){
                                    
                                    ?>
                                    <img id="photo" src="<?php echo $photoNames[$i]; ?>">
                                    <div id="bigImage"><img id="bigPhoto" src="<?php echo $photoNames[$i]; ?>"></div>
                                    <?php
                                    
                                }
                                
                            }
                            
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Location</td> <td><a id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">Find on Google Map</a>
                        </td>
                    </tr>
                    <tr><td>Advertisement type</td> <td><?php if($sale == 1){ echo 'Sale'; }else if($rent == 1){ echo 'Rent'; } ?></td></tr>
                    <tr>
                        <td>Available from</td><td><?php echo $screenAvailableFrom; ?></td>
                    </tr>
                    <tr>
                        <td>Available for</td> <td colspan="2"><?php
                            
                        if($male == 1){
                            
                            echo 'Single (Male)';
                            
                        }
                        
                        if(($male == 0) && ($female == 1)){
                            
                            echo 'Single (Female)';
                            
                        }
                        else if(($male == 1) && ($female == 1)){
                            
                            echo ', Single (Female)';
                            
                        }
                        
                        if(($male == 0) && ($female == 0) && ($family == 1)){
                            
                            echo 'Family';
                            
                        }
                        else if((($male == 1) || ($female == 1)) && ($family == 1)){
                            
                            echo ', Family';
                            
                        }
                            
                        ?>
                        </td>
                    </tr>
                
                <?php
                
                if($mess == 1){
                    
                    ?>
                    
                    <tr id="maxNumPeople" style="display:none">
                        <td>Maximum number of people (in case of using as a mess)</td> <td colspan="2"><div id="maxPeople"><?php
                                
                        if($max_people != ''){
                            
                            echo $max_people;
                            
                        }
                            
                        ?></div>
                        </td>
                    </tr>
                    
                    <?php
                    
                }
                    
                ?>
                
                    <tr>
                        <td>Rental price per month</td> <td colspan="2"><div id="rentalPrice"><?php
                        
                        if($rental_price != ''){
                            
                            echo $rental_price . ' BDT';
                            
                            if($rental_price_nego == 1){
                                
                                echo ' (Negotiable)';
                                
                            }
                            else{
                                
                                echo ' (Fixed)';
                                
                            }	
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Security money</td> <td colspan="2"><div id="securityMoney"><?php
                        
                        if($security_money != ''){
                            
                            echo $security_money . ' BDT';
                            
                            if($security_money_nego == 1){
                                
                                echo ' (Negotiable)';
                                
                            }
                            else{
                                
                                echo ' (Fixed)';
                                
                            }	
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Full Address</td> <td colspan="2"><div id="fullAddress"><?php echo $full_address; ?></div></td>
                    </tr>
                    <tr>
                        <td>Contact no.</td> <td colspan="2"><div id="contactNo"><?php echo $contact_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>Email</td> <td colspan="2"><div id="email"><?php echo $contact_email; ?></div></td>
                    </tr>
                    
                    <tr id="additionalHeading" >
                        <td colspan="3">Additional Info</td>
                    </tr>
            
                    <tr>
                        <td>Flat no.</td> <td colspan="2"><div id="flatNo"><?php echo $flat_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>Floor</td> <td colspan="2"><div id="situatingfloor"><?php echo $floor; ?></div></td>
                    </tr>
                    <tr>
                        <td>Size of the flat</td> <td colspan="2"><div id="flatSize"><?php
                            
                        if($size_of_flat != ''){
                            
                            echo $size_of_flat . ' square feet';
                            
                        }
                            
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Size of the room</td> <td colspan="2"><div id="roomSize"><?php
                        
                        if($size_of_room != ''){
                            
                            echo $size_of_room . ' square feet';
                            
                        }
                                
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Number of rooms in the flat</td> <td colspan="2"><div id="numRoom"><?php echo $number_of_rooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>Number of washrooms in the flat</td> <td colspan="2"><div id="numWashroom"><?php echo $number_of_washrooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>Is there any washroom attached to this room?</td> <td colspan="2"><?php echo $washroom_attached; ?></td>
                    </tr>
                    <tr>
                        <td>Number of balconies in the flat</td> <td colspan="2"><div id="numBalcony"><?php echo $number_of_balconies; ?></div></td>
                    </tr>
                    <tr>
                        <td>Is there any balcony attached to this room?</td> <td colspan="2"><?php echo $balcony_attached; ?></td>
                    </tr>
                    <tr>
                        <td>Total number of floors in the house</td> <td><div id="totalFloor"><?php echo $total_floors; ?></div></td>
                    </tr>
                    <tr>
                        <td>Is there any lift to reach the flat containing this room?</td> <td colspan="2"><?php echo $lift; ?></td>
                    </tr>
                    <tr>
                        <td>Is there any parking facility in the building?</td> <td colspan="2"><?php echo $parking_facility; ?></td>
                    </tr>
                    <tr>
                        <td>Other description</td> <td colspan="2"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                    </tr>
                
                </table>
                <?php
                
            }
            else if($mess == 1){
                
                ?>
                <table id="messInfoDelete">
                    <tr id="heading"><td colspan="3">Advertisement Details</td></tr>
                    <tr id="postedOn"><td colspan="3">Posted on <?php echo $screenDate; ?> at <?php echo $time; ?></td></tr>
                    <tr>
                        <td id="firstColumnDelete">Status</td> <td id="secondColumnDelete" colspan="2"><?php
                        
                        if($publish == 1){
                            
                            echo 'Available';
                            
                        }
                        else{
                            
                            echo 'Not available';
                            
                        }
                        
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Accomodation Type</td><td>Mess</td>
                        <td id="photocolumn" rowspan="4">
                            <?php
                            
                            $photoNames = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                            
                            for($i=0; $i<5; $i++){
                                
                                if(isset($photoNames[$i])){
                                    
                                    ?>
                                    <img id="photo" src="<?php echo $photoNames[$i]; ?>">
                                    <div id="bigImage"><img id="bigPhoto" src="<?php echo $photoNames[$i]; ?>"></div>
                                    <?php
                                    
                                }
                                
                            }
                            
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Location</td> <td><a id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">Find on Google Map</a>
                        </td>
                    </tr>
                    <tr><td>Advertisement type</td> <td><?php if($sale == 1){ echo 'Sale'; }else if($rent == 1){ echo 'Rent'; } ?></td></tr>
                    <tr>
                        <td>Available from</td><td><?php echo $screenAvailableFrom; ?></td>
                    </tr>
                    <tr>
                        <td>Available for</td> <td colspan="2"><?php
                            
                        if($male == 1){
                            
                            echo 'Single (Male)';
                            
                        }
                        
                        if(($male == 0) && ($female == 1)){
                            
                            echo 'Single (Female)';
                            
                        }
                        else if(($male == 1) && ($female == 1)){
                            
                            echo ', Single (Female)';
                            
                        }
                            
                        ?>
                        </td>
                    </tr>
                    <tr id="maxNumPeople">
                        <td>Maximum number of people in the room</td> <td colspan="2"><div id="maxPeople"><?php
                                
                        if($max_people != ''){
                            
                            echo $max_people;
                            
                        }
                            
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Rental price per month</td> <td colspan="2"><div id="rentalPrice"><?php
                        
                        if($rental_price != ''){
                            
                            echo $rental_price . ' BDT';
                            
                            if($rental_price_nego == 1){
                                
                                echo ' (Negotiable)';
                                
                            }
                            else{
                                
                                echo ' (Fixed)';
                                
                            }	
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Security money</td> <td colspan="2"><div id="securityMoney"><?php
                        
                        if($security_money != ''){
                            
                            echo $security_money . ' BDT';
                            
                            if($security_money_nego == 1){
                                
                                echo ' (Negotiable)';
                                
                            }
                            else{
                                
                                echo ' (Fixed)';
                                
                            }	
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Full Address</td> <td colspan="2"><div id="fullAddress"><?php echo $full_address; ?></div></td>
                    </tr>
                    <tr>
                        <td>Contact no.</td> <td colspan="2"><div id="contactNo"><?php echo $contact_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>Email</td> <td colspan="2"><div id="email"><?php echo $contact_email; ?></div></td>
                    </tr>
                    
                    <tr id="additionalHeading">
                        <td colspan="3">Additional Info</td>
                    </tr>
            
                    <tr>
                        <td>Flat no.</td> <td colspan="2"><div id="flatNo"><?php echo $flat_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>Floor</td> <td colspan="2"><div id="situatingfloor"><?php echo $floor; ?></div></td>
                    </tr>
                    <tr>
                        <td>Size of the flat</td> <td colspan="2"><div id="flatSize"><?php
                                
                        if($size_of_flat != ''){
                            
                            echo $size_of_flat . ' square feet';
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Size of the room</td> <td colspan="2"><div id="roomSize"><?php
                        
                        if($size_of_room != ''){
                            
                            echo $size_of_room . ' square feet';
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Number of rooms in the flat</td> <td colspan="2"><div id="numRoom"><?php echo $number_of_rooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>Number of washrooms in the flat</td> <td colspan="2"><div id="numWashroom"><?php echo $number_of_washrooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>Is there any washroom attached to this room?</td> <td colspan="2"><?php echo $washroom_attached; ?></td>
                    </tr>
                    <tr>
                        <td>Number of balconies in the flat</td> <td colspan="2"><div id="numBalcony"><?php echo $number_of_balconies; ?></div></td>
                    </tr>
                    <tr>
                        <td>Is there any balcony attached to this room?</td> <td colspan="2"><?php echo $balcony_attached; ?></td>
                    </tr>
                    <tr>
                        <td>Total number of floors in the house</td> <td colspan="2"><div id="totalFloor"><?php echo $total_floors; ?></div></td>
                    </tr>
                    <tr>
                        <td>Is there any lift to reach the flat containing this room?</td> <td colspan="2"><?php echo $lift; ?></td>
                    </tr>
                    <tr>
                        <td>Other description</td> <td colspan="2"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                    </tr>
                
                </table>
                <?php
                
            }
            else if($officespace == 1){
                
                ?>
                <table id="officespaceInfoDelete">
                    <tr id="heading"><td colspan="3">Advertisement Details</td></tr>
                    <tr id="postedOn"><td colspan="3">Posted on <?php echo $screenDate; ?> at <?php echo $time; ?></td></tr>
                    <tr>
                        <td id="firstColumnDelete">Status</td> <td id="secondColumnDelete" colspan="2"><?php
                        
                        if($publish == 1){
                            
                            echo 'Available';
                            
                        }
                        else{
                            
                            echo 'Not available';
                            
                        }
                        
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Accomodation Type</td><td>Office</td>
                        <td id="photocolumn" rowspan="4">
                            <?php
                            
                            $photoNames = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                            
                            for($i=0; $i<5; $i++){
                                
                                if(isset($photoNames[$i])){
                                    
                                    ?>
                                    <img id="photo" src="<?php echo $photoNames[$i]; ?>">
                                    <div id="bigImage"><img id="bigPhoto" src="<?php echo $photoNames[$i]; ?>"></div>
                                    <?php
                                    
                                }
                                
                            }
                            
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Location</td> <td><a id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">Find on Google Map</a>
                        </td>
                    </tr>
                    <tr><td>Advertisement type</td> <td><?php if($sale == 1){ echo 'Sale'; }else if($rent == 1){ echo 'Rent'; } ?></td></tr>
                    <tr>
                        <td>Available from</td><td><?php echo $screenAvailableFrom; ?></td>
                    </tr>
                    <?php
                    
                    if($sale == 1){
                        
                        ?>
                        <tr>
                            <td>Price</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' BDT';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Booking money</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' BDT';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <?php
                        
                    }
                    else if($rent == 1){
                        
                        ?>
                        <tr>
                            <td>Rental price per month</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' BDT';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Security money</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' BDT';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <?php
                        
                    }
                    
                    ?>
                    <tr>
                        <td>Full Address</td> <td colspan="2"><div id="fullAddress"><?php echo $full_address; ?></div></td>
                    </tr>
                    <tr>
                        <td>Contact no.</td> <td colspan="2"><div id="contactNo"><?php echo $contact_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>Email</td> <td colspan="2"><div id="email"><?php echo $contact_email; ?></div></td>
                    </tr>
                    
                    <tr id="additionalHeading">
                        <td colspan="3">Additional Info</td>
                    </tr>
            
                    <tr>
                        <td>Office space no.</td> <td colspan="2"><div id="flatNo"><?php echo $flat_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>Floor</td> <td colspan="2"><div id="situatingfloor"><?php echo $floor; ?></div></td>
                    </tr>
                    <tr>
                        <td>Size of the space</td> <td colspan="2"><div id="flatSize"><?php
                        
                        if($size_of_flat != ''){
                            
                            echo $size_of_flat . ' square feet';
                            
                        }
                                
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Number of rooms</td> <td colspan="2"><div id="numRoom"><?php echo $number_of_rooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>Number of washrooms</td> <td colspan="2"><div id="numWashroom"><?php echo $number_of_washrooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>Total number of floors in the building</td> <td colspan="2"><div id="totalFloor"><?php echo $total_floors; ?></div></td>
                    </tr>
                    <tr>
                        <td>Is there any lift to reach the floor containing this space?</td> <td colspan="2"><?php echo $lift; ?></td>
                    </tr>
                    <tr>
                        <td>Is there any elevator to reach the floor containing this space?</td> <td colspan="2"><?php echo $elevator; ?></td>
                    </tr>
                    <tr>
                        <td>Is there any parking facility in the building?</td> <td colspan="2"><?php echo $parking_facility; ?></td>
                    </tr>
                    <tr>
                        <td>Other description</td> <td colspan="2"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                    </tr>
                
                </table>
                <?php
                
            }
            else if($shop == 1){
                
                ?>
                <table id="shopInfoDelete">
                    <tr id="heading"><td colspan="3">Advertisement Details</td></tr>
                    <tr id="postedOn"><td colspan="3">Posted on <?php echo $screenDate; ?> at <?php echo $time; ?></td></tr>
                    <tr>
                        <td id="firstColumnDelete">Status</td> <td id="secondColumnDelete" colspan="2"><?php
                        
                        if($publish == 1){
                            
                            echo 'Available';
                            
                        }
                        else{
                            
                            echo 'Not available';
                            
                        }
                        
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Accomodation Type</td><td>Shop</td>
                        <td id="photocolumn" rowspan="4">
                            <?php
                            
                            $photoNames = glob('uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                            
                            for($i=0; $i<5; $i++){
                                
                                if(isset($photoNames[$i])){
                                    
                                    ?>
                                    <img id="photo" src="<?php echo $photoNames[$i]; ?>">
                                    <div id="bigImage"><img id="bigPhoto" src="<?php echo $photoNames[$i]; ?>"></div>
                                    <?php
                                    
                                }
                                
                            }
                            
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Location</td> <td><a id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">Find on Google Map</a>
                        </td>
                    </tr>
                    <tr><td>Advertisement type</td> <td><?php if($sale == 1){ echo 'Sale'; }else if($rent == 1){ echo 'Rent'; } ?></td></tr>
                    <tr>
                        <td>Available from</td><td><?php echo $screenAvailableFrom; ?></td>
                    </tr>
                    <?php
                    
                    if($sale == 1){
                        
                        ?>
                        <tr>
                            <td>Rental price per month</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' BDT';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Security money</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' BDT';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <?php
                        
                    }
                    else if($rent == 1){
                        
                        ?>
                        <tr>
                            <td>Rental price per month</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' BDT';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Security money</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' BDT';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (Negotiable)';
                                    
                                }
                                else{
                                    
                                    echo ' (Fixed)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <?php
                        
                    }
                    
                    ?>
                    <tr>
                        <td>Full Address</td> <td colspan="2"><div id="fullAddress"><?php echo $full_address; ?></div></td>
                    </tr>
                    <tr>
                        <td>Contact no.</td> <td colspan="2"><div id="contactNo"><?php echo $contact_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>Email</td> <td colspan="2"><div id="email"><?php echo $contact_email; ?></div></td>
                    </tr>
                    
                    <tr id="additionalHeading">
                        <td colspan="3">Additional Info</td>
                    </tr>
            
                    <tr>
                        <td>Shop no.</td> <td colspan="2"><div id="flatNo"><?php echo $flat_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>Floor</td> <td colspan="2"><div id="situatingfloor"><?php echo $floor; ?></div></td>
                    </tr>
                    <tr>
                        <td>Size of the shop</td> <td colspan="2"><div id="flatSize"><?php
                                
                        if($size_of_flat != ''){
                            
                            echo $size_of_flat . ' square feet';
                            
                        }
                                
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Total number of floors in the building</td> <td colspan="2"><div id="totalFloor"><?php echo $total_floors; ?></div></td>
                    </tr>
                    <tr>
                        <td>Is there any lift to reach the floor containing this shop?</td> <td colspan="2"><?php echo $lift; ?></td>
                    </tr>
                    <tr>
                        <td>Is there any elevator to reach the floor containing this shop?</td> <td colspan="2"><?php echo $elevator; ?></td>
                    </tr>
                    <tr>
                        <td>Is there any parking facility in the building?</td> <td colspan="2"><?php echo $parking_facility; ?></td>
                    </tr>
                    <tr>
                        <td>Other description</td> <td colspan="2"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                    </tr>
                
                </table>
                <?php
                
            }
            
            if(isset($_POST['delete'])){
                
                $query = "UPDATE info SET publish='3' WHERE id='$adID'";
                $result = mysqli_query($dbcUpdate,$query);
                
                if($result){
                    
                    header('Location:advertisements?act-suc=delete&page=' . $pageNum);
                    exit;
                    
                }
                else{
                    
                    header('Location:error?content=unsuccessful&frm=actions');
                    exit;
                    
                }
                
            }
            
        }
        
        ?>
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

ob_end_flush();

?>