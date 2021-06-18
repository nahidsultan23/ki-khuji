<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);
$_SESSION['comebackUrl']['actions'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=actions');
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
    <title>কী খুঁজি - প্রক্রিয়া</title>
    
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
    	<img id="logo" src="../logo/logo.png">
        <div class="topnav-left">
        	<a href="/bn/">কী খুঁজি</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/bn/">হোম</a>
            <a href="search">অনুসন্ধান</a>
            <a href="mark">প্রচার</a>
            <a href="profile">প্রোফাইল</a>
            <a href="advertisements" class="active">বিজ্ঞাপনসমূহ</a>
            <button id="lanButton" onClick="location.href='/<?php echo $pathUrl; ?>'">English</button>
        </div>
        
        <div class="topnav-right">
            <a href="profile"><?php echo $displayEmail; ?></a>
            <a href="logout?cbp=actions">লগ আউট</a>
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
        
        if(!file_exists('../db/db.php')){
            
            session_destroy();
            
            header('Location:error-db');
            exit;
            
        }
        
        $_SESSION['db'] = 1;
        include('../db/db.php');
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
        
        if($floor != ''){
            
            $floor = $floor + 1;
            
        }
        
        $size_of_flat = $row['size_of_flat'];
        $size_of_room = $row['size_of_room'];
        $number_of_rooms = $row['number_of_rooms'];
        $number_of_washrooms = $row['number_of_washrooms'];
        $washroom_attached = $row['washroom_attached'];
        $number_of_balconies = $row['number_of_balconies'];
        $balcony_attached = $row['balcony_attached'];
        
        $total_floors = $row['total_floors'];
        
        if($total_floors != ''){
            
            $total_floors = $total_floors + 1;
            
        }
        
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
			
			$filePath = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
			
			if(!isset($_SESSION['mark'][$spRand]['photo_' . $i . '_other'])){
				
				if($filePath){
					
					$_SESSION['mark'][$spRand]['photo_' . $i] = str_replace('../','',$filePath[0]);
					$_SESSION['mark'][$spRand]['photo_' . $i . '_other'] = $filePath[0];
					
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
                    $floor = $_SESSION['actions'][$rand]['flat-info-edit']['floorBengali'];
                    $size_of_flat = $_SESSION['actions'][$rand]['flat-info-edit']['size_of_flat'];
                    $number_of_rooms = $_SESSION['actions'][$rand]['flat-info-edit']['number_of_rooms'];
                    $number_of_washrooms = $_SESSION['actions'][$rand]['flat-info-edit']['number_of_washrooms'];
                    $number_of_balconies = $_SESSION['actions'][$rand]['flat-info-edit']['number_of_balconies'];
                    $total_floors = $_SESSION['actions'][$rand]['flat-info-edit']['total_floorsBengali'];
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
                        <tr id="heading"><td colspan="2">ফ্ল্যাট-এর তথ্য সম্পাদনা</td></tr>
                        <tr><td>বিজ্ঞাপনের প্রকার</td> <td><?php if($sale == 1){ echo 'বিক্রয়'; }else if($rent == 1){ echo 'ভাড়া'; } ?></td></tr>
                        <tr>
                            <td id="firstColumn">হস্তান্তরযোগ্যতার সময়</td><td id="secondColumn"><input type="text" id="datepicker" name="available_from" value="<?php echo $available_from; ?>" readonly /> <span id="date" class="sidenote">তারিখের গঠনটি ভুল</span></td>
                        </tr>
                        <?php
                        
                        if($sale == 1){
                            
                            ?>
                            <tr>
                                <td>বিক্রয়মূল্য</td> <td><input type="text" name="rental-price" <?php if(isset($rental_price)){ ?>value="<?php echo $rental_price; ?>"<?php } ?> pattern="^[0-9.]+"> টাকা <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> >আলোচনাসাপেক্ষ <span id="rent" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <tr>
                                <td>বুকিং মূল্য<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">কেনার প্রক্রিয়া শুরু করার জন্য শুরুতেই যে পরিমাণ অর্থ দিতে হবে ।</span></td> <td><input type="text" name="security-money" <?php if(isset($security_money)){ ?>value="<?php echo $security_money; ?>"<?php } ?> pattern="^[0-9.]+"> টাকা <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>>আলোচনাসাপেক্ষ <span id="sc" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <?php
                            
                        }
                        else if($rent == 1){
                            
                            ?>
                            <tr>
                                <td>যে বা যারা নিতে পারবে<input type="button" id="button_avfor" value="?"><span id="sidenote_avfor">যে বা যারা আপনার ফ্ল্যাটটি ভাড়া নিতে পারবে । আপনি এখানে একের বেশি অপশন রাখতে পারবেন । যদি আপনার ফ্ল্যাটটি শুধু পরিবারের জন্য হয়, তাহলে শুধু 'পরিবার' অপশনটিতে টিক দিন । মাঝে মাঝে একজন সিঙ্গেল ব্যক্তি (পুরুষ কিংবা মহিলা) পুরো ফ্ল্যাট ভাড়া নিয়ে থাকতে চান় । আপনি যদি তাদেরও ভাড়া দিতে চান, তাহলে 'সিঙ্গেল (পুরুষ)' এবং 'সিঙ্গেল (মহিলা)' অপশন দুটির একটি বা দুটিতেই টিক দিতে পারেন ।</span></td> <td><input type="checkbox" onchange="oneChanged()" name="single-male" id="single-male" <?php if($male == 1){ echo 'checked'; } ?> > সিঙ্গেল (পুরুষ)<br> <input type="checkbox" onchange="oneChanged()" name="single-female" id="single-female" <?php if($female == 1){ echo 'checked'; } ?> > সিঙ্গেল (মহিলা) <span id="av-fo" class="sidenote">অন্তত একটি অপশনে টিক দিন</span><br> <input type="checkbox" name="family" id="family" <?php if($family == 1){ echo 'checked'; } ?> > পরিবার</td>
                            </tr>
                            <tr id="messUse" <?php if(($male == 0) && ($female == 0)){ ?>style="display:none"<?php } ?> >
                                <td>ফ্ল্যাটটি কী মেস হিসেবে ব্যবহার করা যাবে?<input type="button" id="button_messuse" value="?"><span id="sidenote_messuse">যদি ফ্ল্যাটটিতে একাধিক সিঙ্গেল ব্যক্তি (পুরুষ বা মহিলা) থাকার অনুমতি থাকে, তাহলে 'হ্যাঁ' সিলেক্ট করুন ।</span></td> <td><input type="radio" onchange="changeMessInfo(this)" name="mess" value="yes" <?php if($mess == 1){ echo 'checked'; } ?> >হ্যাঁ<br> <input type="radio" onchange="changeMessInfo(this)" name="mess" id="messUseNo" value="no" <?php if($mess == 0){ echo 'checked'; } ?> >না</td>
                            </tr>
                            <tr id="maxNumPeople" <?php if($mess == 0){ ?>style="display:none"<?php } ?> >
                                <td>সর্বাধিক জনসংখ্যা (যদি মেস হিসেবে ব্যবহার করা হয়)<input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">যদি সিঙ্গেল ব্যক্তিরা ফ্ল্যাটটি ভাড়া নেয়, তাহলে সর্বোচ্চ যতজন থাকতে পারবে</span></td> <td><input type="text" name="max-people-in-mess" value="<?php echo $max_people; ?>" pattern="^[0-9]+"> <span id="mx-ppl" class="sidenote">একটি সঠিক সংখ্যা ব্যবহার করুন</span></td>
                            </tr>
                            <tr>
                                <td>মাসিক ভাড়া</td> <td><input type="text" name="rental-price" <?php if(isset($rental_price)){ ?>value="<?php echo $rental_price; ?>"<?php } ?> pattern="^[0-9.]+"> টাকা <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> > আলোচনাসাপেক্ষ <span id="rent" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <tr>
                                <td>জমা মূল্য<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">ফ্ল্যাটে ওঠার আগে যে পরিমাণ টাকা দিতে হবে, যা ফ্ল্যাট ছাড়ার পূর্ব পর্যন্ত জমা থাকবে ।</span></td> <td><input type="text" name="security-money" <?php if(isset($security_money)){ ?>value="<?php echo $security_money; ?>"<?php } ?> pattern="^[0-9.]+"> টাকা <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>> আলোচনাসাপেক্ষ <span id="sc" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <?php
                            
                        }
                        
                        ?>
                        <tr>
                            <td>পুরো ঠিকানা</td> <td><textarea name="full-address" placeholder="এই অংশটি বড় করে আপনার বিজ্ঞাপনে দেখানো হবে । এখানে আপনার ঠিকানা ব্যাতীত অন্য কিছু লিখবেন না । যেমনঃ বাসা নং : ৩০, রোড নং : ২/ক, বাংলা রোড, ঢাকা, বাংলাদেশ । অন্য যেকোনো অতিরিক্ত তথ্য 'অন্যান্য বর্ণনা' ঘরটিতে লিখতে পারেন - যেটি এই ফর্মটির নিচেই খুঁজে পাবেন ।"><?php echo $full_address ?></textarea> <span id="address" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>ফোন নম্বর</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >বাংলাদেশ(+880)</option></select> <input type="text" name="contact-no" id="contact-no" value="<?php echo $contact_no; ?>" pattern="^[0-9]+"> <span id="cn" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ইমেইল</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" value="<?php echo $contact_email; ?>"> <span id="email" class="sidenote">একটি সঠিক ইমেইল লিখুন</span></td>
                        </tr>
                        
                        <tr id="additionalHeading">
                            <td colspan="2">অতিরিক্ত তথ্য</td>
                        </tr>
            
                        <tr>
                            <td>ফ্ল্যাট নম্বর</td> <td><input type="text" name="flat-no" value="<?php echo $flat_no; ?>"> <span id="flat" class="sidenote">সঠিক চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>তলা</td> <td><input type="text" name="floor" value="<?php echo $floor; ?>" pattern="^[0-9-]+"> <span id="floor" class="sidenote">একটি সঠিক সংখ্যা লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ফ্ল্যাটের আকার</td> <td><input type="text" name="size" value="<?php echo $size_of_flat; ?>" pattern="^[0-9.]+"> বর্গফুট <span id="fl-sz" class="sidenote">একটি সঠিক আকার লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ঘরের সংখ্যা</td> <td><input type="text" name="number-of-rooms" value="<?php echo $number_of_rooms; ?>" pattern="^[0-9]+"> <span id="num-rm" class="sidenote">একটি সঠিক সংখ্যা লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>বাথরুমের সংখ্যা</td> <td><input type="text" name="number-of-washrooms" value="<?php echo $number_of_washrooms; ?>" pattern="^[0-9]+"> <span id="num-wsrm" class="sidenote">একটি সঠিক সংখ্যা লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>বারান্দার সংখ্যা</td> <td><input type="text" name="number-of-balconies" value="<?php echo $number_of_balconies; ?>" pattern="^[0-9]+"> <span id="num-bal" class="sidenote">একটি সঠিক সংখ্যা লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>বাড়িটিতে মোট তলার সংখ্যা</td> <td><input type="text" name="total-floor" value="<?php echo $total_floors; ?>" pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">একটি সঠিক সংখ্যা লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ফ্ল্যাটে যাবার জন্য কী কোনো লিফট আছে?</td> <td><select name="lift">
                                    <option value="Yes" <?php if($lift == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($lift == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>দালানটিতে কী গাড়ি রাখার ব্যবস্থা আছে?</td> <td><select name="parking-facility">
                                    <option value="Yes" <?php if($parking_facility == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($parking_facility == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>অন্যান্য বর্ণনা</td> <td><textarea name="other-description" placeholder="যেকোনো অতিরিক্ত তথ্য এখানে লিখতে পারেন । যেমনঃ ফ্ল্যাটটির দক্ষিণ দিকে একটি বারান্দা আছে । একটি বাথরুমে কমোড আর বাথটাব আছে........, ইত্যাদি । অতিরিক্ত ফোন নম্বরঃ 01..........., 02........... অতিরিক্ত ইমেইলঃ no-reply@kikhuji.com"><?php echo $other_description; ?></textarea> <span id="oth-des" class="sidenote">সঠিক চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>ছবি</td>
                            <td id="photos">
                                <div id="allForms">
                                    <form>
                                    </form>
                                    
                                    <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_1" id="key_1" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_1">+</button>
                                            <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                        </div>
                                        
                                        <div id="progressbarContainer_1" style="display:none">
                                            <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_1_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_1">
                                            <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_2" id="key_2" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_2">+</button>
                                            <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                        </div>
                                        
                                        <div id="progressbarContainer_2" style="display:none">
                                            <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_2_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_2">
                                            <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_3" id="key_3" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_3">+</button>
                                            <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                        </div>
                                        
                                        <div id="progressbarContainer_3" style="display:none">
                                            <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_3_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_3">
                                            <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_4" id="key_4" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_4">+</button>
                                            <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                        </div>
                                        
                                        <div id="progressbarContainer_4" style="display:none">
                                            <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_4_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_4">
                                            <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_5" id="key_5" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$spRand]['photo_5_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_5">+</button>
                                            <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                        </div>
                                        
                                        <div id="progressbarContainer_5" style="display:none">
                                            <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$spRand]['photo_5_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_5_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_5">
                                            <button type="button" class="remove_5" onClick="remove_5()">X</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr id="submitRow">
                            <td colspan="2"><input type="submit" name="submit" id="submit" value="সম্পন্ন করুন"></td>
                        </tr>
                        <tr id="backRow">
                            <td colspan="2"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">বিজ্ঞাপনসমূহ এ ফিরে চলুন</a></td>
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
                            
                            $_SESSION['actions'][$rand]['flat-info-edit']['floor'] = $floor - 1;
                            $floor = $floor - 1;
                            
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
                            
                            $_SESSION['actions'][$rand]['flat-info-edit']['total_floors'] = $total_floors - 1;
                            $total_floors = $total_floors - 1;
                            
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
							
							$filePath = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
							
							if(!$filePath){
								
								$explode = explode('.',$_SESSION['mark'][$spRand]['photo_' . $i]);
								$extension = $explode[1];
								$preAddress = '../uploadedPhotos/temp/' . $id . '_' . $spRand . '_' . $i . '.' . $extension;
								$newAddress = '../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.' . $extension;
								
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
                        <tr id="heading"><td colspan="2">রুম-এর তথ্য সম্পাদনা</td></tr>
                        <tr><td>বিজ্ঞাপনের প্রকার</td> <td><?php if($sale == 1){ echo 'বিক্রয়'; }else if($rent == 1){ echo 'ভাড়া'; } ?></td></tr>
                        <tr>
                            <td id="firstColumn">হস্তান্তরযোগ্যতার সময়</td><td id="secondColumn"><input type="text" id="datepicker" name="available_from" value="<?php echo $available_from; ?>" readonly /> <span id="date" class="sidenote">তারিখের গঠনটি ভুল</span></td>
                        </tr>
                        <tr>
                            <td>যে বা যারা নিতে পারবে<input type="button" id="button_avfor" value="?"><span id="sidenote_avfor">যে বা যারা আপনার ঘরটি ভাড়া নিতে পারবে । আপনি এখানে একের বেশি অপশন রাখতে পারবেন । যদি আপনার ঘরটি শুধু পরিবারের জন্য হয়, তাহলে শুধু 'পরিবার' অপশনটিতে টিক দিন । মাঝে মাঝে একজন সিঙ্গেল ব্যক্তি (পুরুষ কিংবা মহিলা) পুরো ঘর ভাড়া নিয়ে থাকতে চান় । আপনি যদি তাদেরও ভাড়া দিতে চান, তাহলে 'সিঙ্গেল (পুরুষ)' এবং 'সিঙ্গেল (মহিলা)' অপশন দুটির একটি বা দুটিতেই টিক দিতে পারেন ।</span></td> <td><input type="checkbox" onchange="oneChanged()" name="single-male" id="single-male" <?php if($male == 1){ echo 'checked'; } ?> > সিঙ্গেল (পুরুষ)<br> <input type="checkbox" onchange="oneChanged()" name="single-female" id="single-female" <?php if($female == 1){ echo 'checked'; } ?> > সিঙ্গেল (মহিলা) <span id="av-fo" class="sidenote"> অন্তত একটি অপশনে টিক দিন</span><br> <input type="checkbox" name="family" <?php if($family == 1){ echo 'checked'; } ?> > পরিবার</td>
                        </tr>
                        <tr id="messUse" <?php if(($male == 0) && ($female == 0)){ ?>style="display:none"<?php } ?> >
                            <td>ঘরটি কী মেস হিসেবে ব্যবহার করা যাবে?<input type="button" id="button_messuse" value="?"><span id="sidenote_messuse">যদি ঘরটিতে একাধিক সিঙ্গেল ব্যক্তি (পুরুষ বা মহিলা) থাকার অনুমতি থাকে, তাহলে 'হ্যাঁ' সিলেক্ট করুন ।</span></td> <td><input type="radio" onchange="changeMessInfo(this)" name="mess" value="yes" <?php if($mess == 1){ echo 'checked'; } ?> >হ্যাঁ<br> <input type="radio" onchange="changeMessInfo(this)" name="mess" id="messUseNo" value="no" <?php if($mess == 0){ echo 'checked'; } ?> >না</td>
                        </tr>
                        <tr id="maxNumPeople" <?php if($mess == 0){ ?>style="display:none"<?php } ?> >
                            <td>সর্বাধিক জনসংখ্যা (যদি মেস হিসেবে ব্যবহার করা হয়)<input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">যদি সিঙ্গেল ব্যক্তিরা ঘরটি ভাড়া নেয়, তাহলে সর্বোচ্চ যতজন থাকতে পারবে</span></td> <td><input type="text" name="max-people-in-mess" value="<?php echo $max_people; ?>" pattern="^[0-9]+"> <span id="mx-ppl" class="sidenote">একটি সঠিক সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>মাসিক ভাড়া</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> > আলোচনাসাপেক্ষ <span id="rent" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                        </tr>
                        <tr>
                            <td>জমা মূল্য<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">রুমে ওঠার আগে যে পরিমাণ টাকা দিতে হবে, যা রুম ছাড়ার পূর্ব পর্যন্ত জমা থাকবে ।</span></td> <td><input type="text" name="security-money" value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>> আলোচনাসাপেক্ষ <span id="sc" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                        </tr>
                        <tr>
                            <td>পুরো ঠিকানা</td> <td><textarea name="full-address" placeholder="এই অংশটি বড় করে আপনার বিজ্ঞাপনে দেখানো হবে । এখানে আপনার ঠিকানা ব্যাতীত অন্য কিছু লিখবেন না । যেমনঃ বাসা নং : ৩০, রোড নং : ২/ক, বাংলা রোড, ঢাকা, বাংলাদেশ । অন্য যেকোনো অতিরিক্ত তথ্য 'অন্যান্য বর্ণনা' ঘরটিতে লিখতে পারেন - যেটি এই ফর্মটির নিচেই খুঁজে পাবেন ।"><?php echo $full_address; ?></textarea> <span id="address" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>ফোন নম্বর</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >বাংলাদেশ(+880)</option></select> <input type="text" name="contact-no" id="contact-no" value="<?php echo $contact_no; ?>" pattern="^[0-9]+"> <span id="cn" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ইমেইল</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" value="<?php echo $contact_email; ?>"> <span id="email" class="sidenote">একটি সঠিক ইমেইল লিখুন</span></td>
                        </tr>
                        
                        <tr id="additionalHeading">
                            <td colspan="2">অতিরিক্ত তথ্য</td>
                        </tr>
            
                        <tr>
                            <td>ফ্ল্যাট নম্বর</td> <td><input type="text" name="flat-no" value="<?php echo $flat_no; ?>"> <span id="flat" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td></td>
                        </tr>
                        <tr>
                            <td>তলা</td> <td><input type="text" name="floor" value="<?php echo $floor; ?>" pattern="^[0-9-]+"> <span id="floor" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ফ্ল্যাটের আকার</td> <td><input type="text" name="size" value="<?php echo $size_of_flat; ?>" pattern="^[0-9.]+"> বর্গফুট <span id="fl-sz" class="sidenote">একটি সঠিক আকার লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ঘরের আকার</td> <td><input type="text" name="room-size" value="<?php echo $size_of_room; ?>" pattern="^[0-9.]+"> বর্গফুট <span id="rm-sz" class="sidenote">একটি সঠিক আকার লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ফ্ল্যাটটিতে ঘরের সংখ্যা</td> <td><input type="text" name="number-of-rooms" value="<?php echo $number_of_rooms; ?>" pattern="^[0-9]+"> <span id="num-rm" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ফ্ল্যাটটিতে বাথরুমের সংখ্যা</td> <td><input type="text" name="number-of-washrooms" value="<?php echo $number_of_washrooms; ?>" pattern="^[0-9]+"> <span id="num-wsrm" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ঘরটির সাথে কী এটাচড বাথরুম আছে?</td> <td><select name="washroom-attached">
                                    <option value="Yes" <?php if($washroom_attached == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($washroom_attached == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>ফ্ল্যাটটিতে বারান্দার সংখ্যা</td> <td><input type="text" name="number-of-balconies" value="<?php echo $number_of_balconies; ?>" pattern="^[0-9]+"> <span id="num-bal" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ঘরটির সাথে কী এটাচড বারান্দা আছে?</td> <td><select name="balcony-attached">
                                    <option value="Yes" <?php if($balcony_attached == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($balcony_attached == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>বাড়িটিতে মোট তলার সংখ্যা</td> <td><input type="text" name="total-floor" value="<?php echo $total_floors; ?>" pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>এই রুম সম্বলিত ফ্ল্যাটে যাবার জন্য কী কোনো লিফট আছে?</td> <td><select name="lift">
                                    <option value="Yes" <?php if($lift == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($lift == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>দালানে কী গাড়ি রাখার ব্যবস্থা আছে?</td> <td><select name="parking-facility">
                                    <option value="Yes" <?php if($parking_facility == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($parking_facility == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>অন্যান্য বর্ণনা</td> <td><textarea name="other-description" placeholder="যেকোনো অতিরিক্ত তথ্য এখানে লিখতে পারেন । যেমনঃ ঘরটি আলো-বাতাসপূর্ণ । ঘরটিতে দুটি বড় বড় জানালা আছে........, ইত্যাদি । অতিরিক্ত ফোন নম্বরঃ 01..........., 02........... অতিরিক্ত ইমেইলঃ no-reply@kikhuji.com"><?php echo $other_description; ?></textarea> <span id="oth-des" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>ছবি</td>
                            <td id="photos">
                                <div id="allForms">
                                    <form>
                                    </form>
                                    
                                    <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_1" id="key_1" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_1">+</button>
                                            <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                        </div>
                                        
                                        <div id="progressbarContainer_1" style="display:none">
                                            <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_1_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_1">
                                            <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_2" id="key_2" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_2">+</button>
                                            <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                        </div>
                                        
                                        <div id="progressbarContainer_2" style="display:none">
                                            <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_2_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_2">
                                            <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_3" id="key_3" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_3">+</button>
                                            <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                        </div>
                                        
                                        <div id="progressbarContainer_3" style="display:none">
                                            <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_3_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_3">
                                            <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_4" id="key_4" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_4">+</button>
                                            <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                        </div>
                                        
                                        <div id="progressbarContainer_4" style="display:none">
                                            <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_4_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_4">
                                            <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_5" id="key_5" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$spRand]['photo_5_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_5">+</button>
                                            <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                        </div>
                                        
                                        <div id="progressbarContainer_5" style="display:none">
                                            <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$spRand]['photo_5_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_5_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_5">
                                            <button type="button" class="remove_5" onClick="remove_5()">X</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr id="submitRow">
                            <td colspan="2"><input type="submit" name="submit" id="submit" value="সম্পন্ন করুন"></td>
                        </tr>
                        <tr id="backRow">
                            <td colspan="2"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">বিজ্ঞাপনসমূহ এ ফিরে চলুন</a></td>
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
                            
                            $_SESSION['actions'][$rand]['room-info-edit']['floor'] = $floor - 1;
                            $floor = $floor - 1;
                            
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
                            
                            $_SESSION['actions'][$rand]['room-info-edit']['total_floors'] = $total_floors - 1;
                            $total_floors = $total_floors - 1;
                            
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
							
							$filePath = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
							
							if(!$filePath){
								
								$explode = explode('.',$_SESSION['mark'][$spRand]['photo_' . $i]);
								$extension = $explode[1];
								$preAddress = '../uploadedPhotos/temp/' . $id . '_' . $spRand . '_' . $i . '.' . $extension;
								$newAddress = '../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.' . $extension;
								
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
                        <tr id="heading"><td colspan="2">মেস এর তথ্য সম্পাদনা</td></tr>
                        <tr><td>বিজ্ঞাপনের প্রকার</td> <td><?php if($sale == 1){ echo 'বিক্রয়'; }else if($rent == 1){ echo 'ভাড়া'; } ?></td></tr>
                        <tr>
                            <td id="firstColumn">হস্তান্তরযোগ্যতার সময়</td><td id="secondColumn"><input type="text" id="datepicker" name="available_from" value="<?php echo $available_from; ?>" readonly /> <span id="date" class="sidenote">তারিখের গঠনটি ভুল</span></td>
                        </tr>
                        <tr>
                            <td>যে বা যারা নিতে পারবে</td> <td><input type="checkbox" name="single-male" <?php if($male == 1){ echo 'checked'; } ?> >সিঙ্গেল (পুরুষ) <span id="av-fo" class="sidenote"> অন্তত একটি অপশনে টিক দিন</span><br> <input type="checkbox" name="single-female" <?php if($female == 1){ echo 'checked'; } ?> >সিঙ্গেল (মহিলা)</td>
                        </tr>
                        <tr id="maxNumPeople">
                            <td>রুমে সর্বাধিক জনসংখ্যা<input type="button" id="button_maxppl" value="?"><span id="sidenote_maxppl">সর্বোচ্চ জনসংখ্যা যারা মেসের এই রুমটিতে থাকবে ।</span></td> <td><input type="text" name="max-people-in-mess" value="<?php echo $max_people; ?>" pattern="^[0-9]+"> <span id="mx-ppl" class="sidenote">একটি সঠিক সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>মাসিক ভাড়া</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> > আলোচনাসাপেক্ষ <span id="rent" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                        </tr>
                        <tr>
                            <td>জমা মূল্য<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">মেসে ওঠার আগে যে পরিমাণ টাকা দিতে হবে, যা মেস ছাড়ার পূর্ব পর্যন্ত জমা থাকবে ।</span></td> <td><input type="text" name="security-money" value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>> আলোচনাসাপেক্ষ <span id="sc" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                        </tr>
                        <tr>
                            <td>পুরো ঠিকানা</td> <td><textarea name="full-address" placeholder="এই অংশটি বড় করে আপনার বিজ্ঞাপনে দেখানো হবে । এখানে আপনার ঠিকানা ব্যাতীত অন্য কিছু লিখবেন না । যেমনঃ বাসা নং : ৩০, রোড নং : ২/ক, বাংলা রোড, ঢাকা, বাংলাদেশ । অন্য যেকোনো অতিরিক্ত তথ্য 'অন্যান্য বর্ণনা' ঘরটিতে লিখতে পারেন - যেটি এই ফর্মটির নিচেই খুঁজে পাবেন ।"><?php echo $full_address; ?></textarea> <span id="address" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>ফোন নম্বর</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >বাংলাদেশ(+880)</option></select> <input type="text" name="contact-no" id="contact-no" value="<?php echo $contact_no; ?>" pattern="^[0-9]+"> <span id="cn" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ইমেইল</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" value="<?php echo $contact_email; ?>"> <span id="email" class="sidenote">একটি সঠিক ইমেইল লিখুন</span></td>
                        </tr>
                        
                        <tr id="additionalHeading">
                            <td colspan="2">অতিরিক্ত তথ্য</td>
                        </tr>
            
                        <tr>
                            <td>ফ্ল্যাট নম্বর</td> <td><input type="text" name="flat-no" value="<?php echo $flat_no; ?>"> <span id="flat" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>তলা</td> <td><input type="text" name="floor" value="<?php echo $floor; ?>" pattern="^[0-9-]+"> <span id="floor" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ফ্ল্যাটের আকার</td> <td><input type="text" name="size" value="<?php echo $size_of_flat; ?>" pattern="^[0-9.]+"> বর্গফুট <span id="fl-sz" class="sidenote">একটি সঠিক আকার লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ঘরের আকার</td> <td><input type="text" name="room-size" value="<?php echo $size_of_room; ?>" pattern="^[0-9.]+"> বর্গফুট <span id="rm-sz" class="sidenote">একটি সঠিক আকার লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ফ্ল্যাটটিতে ঘরের সংখ্যা</td> <td><input type="text" name="number-of-rooms" value="<?php echo $number_of_rooms; ?>" pattern="^[0-9]+"> <span id="num-rm" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ফ্ল্যাটটিতে বাথরুমের সংখ্যা</td> <td><input type="text" name="number-of-washrooms" value="<?php echo $number_of_washrooms; ?>" pattern="^[0-9]+"> <span id="num-wsrm" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ঘরটির সাথে কী এটাচড বাথরুম আছে?</td> <td><select name="washroom-attached">
                                    <option value="Yes" <?php if($washroom_attached == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($washroom_attached == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>ফ্ল্যাটটিতে বারান্দার সংখ্যা</td> <td><input type="text" name="number-of-balconies" value="<?php echo $number_of_balconies; ?>" pattern="^[0-9]+"> <span id="num-bal" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ঘরটির সাথে কী এটাচড বারান্দা আছে?</td> <td><select name="balcony-attached">
                                    <option value="Yes" <?php if($balcony_attached == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($balcony_attached == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>বাড়িটিতে মোট তলার সংখ্যা</td> <td><input type="text" name="total-floor" value="<?php echo $total_floors; ?>" pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>এই রুম সম্বলিত ফ্ল্যাটে যাবার জন্য কী কোনো লিফট আছে?</td> <td><select name="lift">
                                    <option value="Yes" <?php if($lift == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($lift == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>অন্যান্য বর্ণনা</td> <td><textarea name="other-description" placeholder="যেকোনো অতিরিক্ত তথ্য এখানে লিখতে পারেন । যেমনঃ রুমটি আলো-বাতাসপূর্ণ এবং প্রায় চারজন মানুষের থাকার জায়গা আছে । রুমে দুটি বড় বড় জানালা আছে........, ইত্যাদি । অতিরিক্ত ফোন নম্বরঃ 01..........., 02........... অতিরিক্ত ইমেইলঃ no-reply@kikhuji.com"><?php echo $other_description; ?></textarea> <span id="oth-des" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>ছবি</td>
                            <td id="photos">
                                <div id="allForms">
                                    <form>
                                    </form>
                                    
                                    <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_1" id="key_1" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_1">+</button>
                                            <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                        </div>
                                        
                                        <div id="progressbarContainer_1" style="display:none">
                                            <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_1_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_1">
                                            <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_2" id="key_2" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_2">+</button>
                                            <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                        </div>
                                        
                                        <div id="progressbarContainer_2" style="display:none">
                                            <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_2_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_2">
                                            <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_3" id="key_3" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_3">+</button>
                                            <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                        </div>
                                        
                                        <div id="progressbarContainer_3" style="display:none">
                                            <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_3_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_3">
                                            <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_4" id="key_4" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_4">+</button>
                                            <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                        </div>
                                        
                                        <div id="progressbarContainer_4" style="display:none">
                                            <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_4_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_4">
                                            <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_5" id="key_5" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$spRand]['photo_5_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_5">+</button>
                                            <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                        </div>
                                        
                                        <div id="progressbarContainer_5" style="display:none">
                                            <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$spRand]['photo_5_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_5_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_5">
                                            <button type="button" class="remove_5" onClick="remove_5()">X</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr id="submitRow">
                            <td colspan="2"><input type="submit" name="submit" id="submit" value="সম্পন্ন করুন"></td>
                        </tr>
                        <tr id="backRow">
                            <td colspan="2"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">বিজ্ঞাপনসমূহ এ ফিরে চলুন</a></td>
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
                            
                            $_SESSION['actions'][$rand]['mess-info-edit']['floor'] = $floor - 1;
                            $floor = $floor - 1;
                            
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
                            
                            $_SESSION['actions'][$rand]['mess-info-edit']['total_floors'] = $total_floors - 1;
                            $total_floors = $total_floors - 1;
                            
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
							
							$filePath = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
							
							if(!$filePath){
								
								$explode = explode('.',$_SESSION['mark'][$spRand]['photo_' . $i]);
								$extension = $explode[1];
								$preAddress = '../uploadedPhotos/temp/' . $id . '_' . $spRand . '_' . $i . '.' . $extension;
								$newAddress = '../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.' . $extension;
								
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
                        <tr id="heading"><td colspan="2">অফিস-এর তথ্য সম্পাদনা</td></tr>
                        <tr><td>বিজ্ঞাপনের প্রকার</td> <td><?php if($sale == 1){ echo 'বিক্রয়'; }else if($rent == 1){ echo 'ভাড়া'; } ?></td></tr>
                        <tr>
                            <td id="firstColumn">হস্তান্তরযোগ্যতার সময়</td><td id="secondColumn"><input type="text" id="datepicker" name="available_from" value="<?php echo $available_from; ?>" readonly /> <span id="date" class="sidenote">তারিখের গঠনটি ভুল</span></td>
                        </tr>
                        <?php
                        
                        if($sale == 1){
                            
                            ?>
                            <tr>
                                <td>বিক্রয়মূল্য</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> > আলোচনাসাপেক্ষ <span id="rent" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <tr>
                                <td>বুকিং মূল্য<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">কেনার প্রক্রিয়া শুরু করার জন্য শুরুতেই যে পরিমাণ অর্থ দিতে হবে ।</span></td> <td><input type="text" name="security-money" value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>> আলোচনাসাপেক্ষ <span id="sc" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <?php
                            
                        }
                        else if($rent == 1){
                            
                            ?>
                            <tr>
                                <td>মাসিক ভাড়া</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> > আলোচনাসাপেক্ষ <span id="rent" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <tr>
                                <td>জমা মূল্য<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">অফিসটি ব্যবহার শুরুর আগে যে পরিমাণ টাকা দিতে হবে, যা অফিসটি ছাড়ার পূর্ব পর্যন্ত জমা থাকবে ।</span></td> <td><input type="text" name="security-money" value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>> আলোচনাসাপেক্ষ <span id="sc" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <?php
                            
                        }
                        
                        ?>
                        <tr>
                            <td>পুরো ঠিকানা</td> <td><textarea name="full-address" placeholder="এই অংশটি বড় করে আপনার বিজ্ঞাপনে দেখানো হবে । এখানে আপনার ঠিকানা ব্যাতীত অন্য কিছু লিখবেন না । যেমনঃ দালান নং : ৩০, রোড নং : ২/ক, বাংলা রোড, ঢাকা, বাংলাদেশ । অন্য যেকোনো অতিরিক্ত তথ্য 'অন্যান্য বর্ণনা' ঘরটিতে লিখতে পারেন - যেটি এই ফর্মটির নিচেই খুঁজে পাবেন ।"><?php echo $full_address; ?></textarea> <span id="address" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>ফোন নম্বর</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >বাংলাদেশ(+880)</option></select> <input type="text" name="contact-no" id="contact-no" value="<?php echo $contact_no; ?>" pattern="^[0-9]+"> <span id="cn" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ইমেইল</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" value="<?php echo $contact_email; ?>"> <span id="email" class="sidenote">একটি সঠিক ইমেইল লিখুন</span></td>
                        </tr>
                        
                        <tr id="additionalHeading">
                            <td colspan="2">অতিরিক্ত তথ্য</td>
                        </tr>
            
                        <tr>
                            <td>অফিস নম্বর</td> <td><input type="text" name="office-no" value="<?php echo $flat_no; ?>"> <span id="flat" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>তলা</td> <td><input type="text" name="floor" value="<?php echo $floor; ?>" pattern="^[0-9-]+"> <span id="floor" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>অফিসটির আকার</td> <td><input type="text" name="office-size" value="<?php echo $size_of_flat; ?>" pattern="^[0-9.]+"> বর্গফুট <span id="fl-sz" class="sidenote">একটি সঠিক আকার লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ঘরের সংখ্যা</td> <td><input type="text" name="number-of-rooms" value="<?php echo $number_of_rooms; ?>" pattern="^[0-9]+"> <span id="num-rm" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>বাথরুমের সংখ্যা</td> <td><input type="text" name="number-of-washrooms" value="<?php echo $number_of_washrooms; ?>" pattern="^[0-9]+"> <span id="num-wsrm" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>দালানটিতে মোট তলার সংখ্যা</td> <td><input type="text" name="total-floor" value="<?php echo $total_floors; ?>" pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>অফিসে যাবার জন্য কী কোনো লিফট আছে?</td> <td><select name="lift">
                                    <option value="Yes" <?php if($lift == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($lift == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>অফিসে যাবার জন্য কী কোনো চলন্ত সিঁড়ি আছে?</td> <td><select name="elevator">
                                    <option value="Yes" <?php if($elevator == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($elevator == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>দালানে কী গাড়ি রাখার ব্যবস্থা আছে?</td> <td><select name="parking-facility">
                                    <option value="Yes" <?php if($parking_facility == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($parking_facility == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>অন্যান্য বর্ণনা</td> <td><textarea name="other-description" placeholder="যেকোনো অতিরিক্ত তথ্য এখানে লিখতে পারেন । যেমনঃ জায়গাটি আলো-বাতাস সমৃদ্ধ । এখানে ৩ টি ঘর এবং ২টি বাথরুম আছে........, ইত্যাদি । অতিরিক্ত ফোন নম্বরঃ 01..........., 02........... অতিরিক্ত ইমেইলঃ no-reply@kikhuji.com"><?php echo $other_description; ?></textarea> <span id="oth-des" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>ছবি</td>
                            <td id="photos">
                                <div id="allForms">
                                    <form>
                                    </form>
                                    
                                    <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_1" id="key_1" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_1">+</button>
                                            <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                        </div>
                                        
                                        <div id="progressbarContainer_1" style="display:none">
                                            <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_1_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_1">
                                            <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_2" id="key_2" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_2">+</button>
                                            <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                        </div>
                                        
                                        <div id="progressbarContainer_2" style="display:none">
                                            <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_2_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_2">
                                            <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_3" id="key_3" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_3">+</button>
                                            <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                        </div>
                                        
                                        <div id="progressbarContainer_3" style="display:none">
                                            <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_3_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_3">
                                            <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_4" id="key_4" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_4">+</button>
                                            <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                        </div>
                                        
                                        <div id="progressbarContainer_4" style="display:none">
                                            <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_4_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_4">
                                            <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_5" id="key_5" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$spRand]['photo_5_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_5">+</button>
                                            <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                        </div>
                                        
                                        <div id="progressbarContainer_5" style="display:none">
                                            <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$spRand]['photo_5_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_5_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_5">
                                            <button type="button" class="remove_5" onClick="remove_5()">X</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr id="submitRow">
                            <td colspan="2"><input type="submit" name="submit" id="submit" value="সম্পন্ন করুন"></td>
                        </tr>
                        <tr id="backRow">
                            <td colspan="2"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">বিজ্ঞাপনসমূহ এ ফিরে চলুন</a></td>
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
                            
                            $_SESSION['actions'][$rand]['officespace-edit-info']['floor'] = $floor - 1;
                            $floor = $floor - 1;
                            
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
                            
                            $_SESSION['actions'][$rand]['officespace-edit-info']['total_floors'] = $total_floors - 1;
                            $total_floors = $total_floors - 1;
                            
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
							
							$filePath = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
							
							if(!$filePath){
								
								$explode = explode('.',$_SESSION['mark'][$spRand]['photo_' . $i]);
								$extension = $explode[1];
								$preAddress = '../uploadedPhotos/temp/' . $id . '_' . $spRand . '_' . $i . '.' . $extension;
								$newAddress = '../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.' . $extension;
								
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
                        <tr id="heading"><td colspan="2">দোকান এর তথ্য সম্পাদনা</td></tr>
                        <tr><td>বিজ্ঞাপনের প্রকার</td> <td><?php if($sale == 1){ echo 'বিক্রয়'; }else if($rent == 1){ echo 'ভাড়া'; } ?></td></tr>
                        <tr>
                            <td id="firstColumn">হস্তান্তরযোগ্যতার সময়</td><td id="secondColumn"><input type="text" id="datepicker" name="available_from" value="<?php echo $available_from; ?>" readonly /> <span id="date" class="sidenote">তারিখের গঠনটি ভুল</span></td>
                        </tr>
                        <?php
                        
                        if($sale == 1){
                            
                            ?>
                            <tr>
                                <td>বিক্রয়মূল্য</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> > আলোচনাসাপেক্ষ <span id="rent" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <tr>
                                <td>বুকিং মূল্য<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">কেনার প্রক্রিয়া শুরু করার জন্য শুরুতেই যে পরিমাণ অর্থ দিতে হবে ।</span></td> <td><input type="text" name="security-money" <value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>> আলোচনাসাপেক্ষ <span id="sc" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <?php
                            
                        }
                        else if($rent == 1){
                            
                            ?>
                            <tr>
                                <td>মাসিক ভাড়া</td> <td><input type="text" name="rental-price" value="<?php echo $rental_price; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="rental-price-checkbox" <?php if($rental_price_nego == 1){ echo 'checked'; } ?> > আলোচনাসাপেক্ষ <span id="rent" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <tr>
                                <td>জমা মূল্য<input type="button" id="button_scmoney" value="?"><span id="sidenote_scmoney">দোকানটি ভাড়া নেবার আগে যে পরিমাণ টাকা দিতে হবে, যা দোকানটি ছাড়ার পূর্ব পর্যন্ত জমা থাকবে ।</span></td> <td><input type="text" name="security-money" <value="<?php echo $security_money; ?>" pattern="^[0-9.]+"> টাকা <input type="checkbox" name="security-money-checkbox" <?php if($security_money_nego == 1){ echo 'checked'; } ?>> আলোচনাসাপেক্ষ <span id="sc" class="sidenote">একটি সঠিক পরিমাণ উল্লেখ করুন</span></td>
                            </tr>
                            <?php
                            
                        }
                        
                        ?>
                        <tr>
                            <td>পুরো ঠিকানা</td> <td><textarea name="full-address" placeholder="এই অংশটি বড় করে আপনার বিজ্ঞাপনে দেখানো হবে । এখানে আপনার ঠিকানা ব্যাতীত অন্য কিছু লিখবেন না । যেমনঃ সুপার মার্কেট, রোড নং : ২/ক, বাংলা রোড, ঢাকা, বাংলাদেশ । অন্য যেকোনো অতিরিক্ত তথ্য 'অন্যান্য বর্ণনা' ঘরটিতে লিখতে পারেন - যেটি এই ফর্মটির নিচেই খুঁজে পাবেন ।"><?php echo $full_address; ?></textarea> <span id="address" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>ফোন নম্বর</td> <td><select name="contact-no-option"><option value="+880" <?php if($contact_no_option == '+880'){ echo 'selected'; } ?> >বাংলাদেশ(+880)</option></select> <input type="text" name="contact-no" id="contact-no" value="<?php echo $contact_no; ?>" pattern="^[0-9]+"> <span id="cn" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>ইমেইল</td> <td><input type="email" name="contact-email" maxlength="320" pattern="^[A-Za-z0-9@._]+" value="<?php echo $contact_email; ?>"> <span id="email" class="sidenote">একটি সঠিক ইমেইল লিখুন</span></td>
                        </tr>
                        
                        <tr id="additionalHeading">
                            <td colspan="2">অতিরিক্ত তথ্য</td>
                        </tr>
            
                        <tr>
                            <td>দোকান  নম্বর</td> <td><input type="text" name="shop-no" value="<?php echo $flat_no; ?>"></td> <span id="flat" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>তলা</td> <td><input type="text" name="floor" value="<?php echo $floor; ?>" pattern="^[0-9-]+"> <span id="floor" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>দোকানের আকার</td> <td><input type="text" name="shop-size" value="<?php echo $size_of_flat; ?>" pattern="^[0-9.]+"> বর্গফুট <span id="fl-sz" class="sidenote">একটি সঠিক আকার লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>দালানটিতে মোট তলার সংখ্যা</td> <td><input type="text" name="total-floor" value="<?php echo $total_floors; ?>" pattern="^[0-9-]+"> <span id="tot-floor" class="sidenote">একটি সঠিক নম্বর লিখুন</span></td>
                        </tr>
                        <tr>
                            <td>দোকানে যাবার জন্য কী কোনো লিফট আছে?</td> <td><select name="lift">
                                    <option value="Yes" <?php if($lift == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($lift == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>দোকানে যাবার জন্য কী চলন্ত সিঁড়ি আছে?</td> <td><select name="elevator">
                                    <option value="Yes" <?php if($elevator == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($elevator == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>দালানে কী গাড়ি রাখার ব্যবস্থা আছে?</td> <td><select name="parking-facility">
                                    <option value="Yes" <?php if($parking_facility == 'Yes'){ echo 'selected'; } ?> >হ্যাঁ</option>
                                    <option value="No" <?php if($parking_facility == 'No'){ echo 'selected'; } ?> >না</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>অন্যান্য বর্ণনা</td> <td><textarea name="other-description" placeholder="যেকোনো অতিরিক্ত তথ্য এখানে লিখতে পারেন । যেমনঃ দোকানটি সুন্দরভাবে রং করা । এটি মার্কেটের সামনের দিকের অংশে অবস্থিত........, ইত্যাদি । অতিরিক্ত ফোন নম্বরঃ 01..........., 02........... অতিরিক্ত ইমেইলঃ no-reply@kikhuji.com"><?php echo $other_description; ?></textarea> <span id="oth-des" class="sidenote">যথাযথ চিহ্ন বা সংখ্যা ব্যবহার করুন</span></td>
                        </tr>
                        <tr>
                            <td>ছবি</td>
                            <td id="photos">
                                <div id="allForms">
                                    <form>
                                    </form>
                                    
                                    <form id="uploadForm_1" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_1" id="randomNum_1" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_1" id="key_1" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_1">+</button>
                                            <input type="file" name="image_1" id="image_1"  onchange="uploadFile_1()">
                                        </div>
                                        
                                        <div id="progressbarContainer_1" style="display:none">
                                            <span><progress id="progressBar_1" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_1" <?php if(isset($_SESSION['mark'][$spRand]['photo_1_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_1_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_1">
                                            <button type="button" class="remove_1" onClick="remove_1()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_2" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_2" id="randomNum_2" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_2" id="key_2" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_2">+</button>
                                            <input type="file" name="image_2" id="image_2"  onchange="uploadFile_2()">
                                        </div>
                                        
                                        <div id="progressbarContainer_2" style="display:none">
                                            <span><progress id="progressBar_2" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_2" <?php if(isset($_SESSION['mark'][$spRand]['photo_2_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_2_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_2">
                                            <button type="button" class="remove_2" onClick="remove_2()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_3" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_3" id="randomNum_3" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_3" id="key_3" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_3">+</button>
                                            <input type="file" name="image_3" id="image_3"  onchange="uploadFile_3()">
                                        </div>
                                        
                                        <div id="progressbarContainer_3" style="display:none">
                                            <span><progress id="progressBar_3" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_3" <?php if(isset($_SESSION['mark'][$spRand]['photo_3_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_3_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_3">
                                            <button type="button" class="remove_3" onClick="remove_3()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_4" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_4" id="randomNum_4" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_4" id="key_4" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_4">+</button>
                                            <input type="file" name="image_4" id="image_4"  onchange="uploadFile_4()">
                                        </div>
                                        
                                        <div id="progressbarContainer_4" style="display:none">
                                            <span><progress id="progressBar_4" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_4" <?php if(isset($_SESSION['mark'][$spRand]['photo_4_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_4_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_4">
                                            <button type="button" class="remove_4" onClick="remove_4()">X</button>
                                        </div>
                                    </form>
                                    
                                    <form id="uploadForm_5" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="randomNum_5" id="randomNum_5" value="<?php echo $id; ?>">
                                        <input type="hidden" name="key_5" id="key_5" value="<?php echo $spRand; ?>">
                                        
                                        <div id="upload-btn-wrapper_5"<?php if(isset($_SESSION['mark'][$spRand]['photo_5_other'])){ ?>style="display:none"<?php } ?>>
                                            <button type="button" class="btn_5">+</button>
                                            <input type="file" name="image_5" id="image_5"  onchange="uploadFile_5()">
                                        </div>
                                        
                                        <div id="progressbarContainer_5" style="display:none">
                                            <span><progress id="progressBar_5" value="0" max="100"></progress></span>
                                        </div>
                                        <h3 id="status"></h3>
                                        <img id="uploadedImage_5" <?php if(isset($_SESSION['mark'][$spRand]['photo_5_other'])){ ?>src="<?php echo $_SESSION['mark'][$spRand]['photo_5_other']; ?>"<?php }else{ ?>style="display:none" src=""<?php } ?>>
                                        
                                        <div id="remove_5">
                                            <button type="button" class="remove_5" onClick="remove_5()">X</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr id="submitRow">
                            <td colspan="2"><input type="submit" name="submit" id="submit" value="সম্পন্ন করুন"></td>
                        </tr>
                        <tr id="backRow">
                            <td colspan="2"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">বিজ্ঞাপনসমূহ এ ফিরে চলুন</a></td>
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
                            
                            $_SESSION['actions'][$rand]['shop-info-edit']['floor'] = $floor - 1;
                            $floor = $floor - 1;
                            
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
                            
                            $_SESSION['actions'][$rand]['shop-info-edit']['total_floors'] = $total_floors - 1;
                            $total_floors = $total_floors - 1;
                            
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
							
							$filePath = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.*');
							
							if(!$filePath){
								
								$explode = explode('.',$_SESSION['mark'][$spRand]['photo_' . $i]);
								$extension = $explode[1];
								$preAddress = '../uploadedPhotos/temp/' . $id . '_' . $spRand . '_' . $i . '.' . $extension;
								$newAddress = '../uploadedPhotos/' . $adID . '_' . $randomkey . '_' . $i . '.' . $extension;
								
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
            
            if($washroom_attached == 'Yes'){
                
                $washroom_attachedBengali = 'হ্যাঁ';
                
            }
            else{
                
                $washroom_attachedBengali = 'না';
                
            }
            
            if($balcony_attached == 'Yes'){
                
                $balcony_attachedBengali = 'হ্যাঁ';
                
            }
            else{
                
                $balcony_attachedBengali = 'না';
                
            }
            
            if($lift == 'Yes'){
                
                $liftBengali = 'হ্যাঁ';
                
            }
            else{
                
                $liftBengali = 'না';
                
            }
            
            if($elevator == 'Yes'){
                
                $elevatorBengali = 'হ্যাঁ';
                
            }
            else{
                
                $elevatorBengali = 'না';
                
            }
            
            if($parking_facility == 'Yes'){
                
                $parking_facilityBengali = 'হ্যাঁ';
                
            }
            else{
                
                $parking_facilityBengali = 'না';
                
            }
            
            
            ?>
            <table id="deleteConfirm">
                <tr>
                    <td id="deleteConfirmQuestion">আপনি কী এই বিজ্ঞাপনটি মুছে ফেলার ব্যাপারে নিশ্চিত? একবার মুছে ফেললে এটি আর ফিরে পাওয়া যাবে না ।</td>
                </tr>
            </table>
            <form action="" method="post">
                <table id="deleteConfirm">
                    <tr><td id="deletePortion"><input type="submit" name="delete" id="deleteButton" value="হ্যাঁ । মুছে ফেলুন ।"></td><td id="backPortion"><a id="backLink" href="advertisements?page=<?php echo $pageNum; ?>">না । বিজ্ঞাপনসমূহ এ ফিরে চলুন ।</a></td></tr>
                </table>
            </form>
            <?php
            
            if($flat == 1){
                
                ?>
                <table id="flatInfoDelete">
                    <tr id="heading"><td colspan="3">বিস্তারিত বিজ্ঞাপন</td></tr>
                    <tr id="postedOn"><td colspan="3">পোস্ট করা হয়েছে <?php echo $screenDate; ?> তারিখে <?php echo $time; ?> টার সময়</td></tr>
                    <tr>
                        <td id="firstColumnDelete">অবস্থা</td> <td id="secondColumnDelete" colspan="2"><?php
                        
                        if($publish == 1){
                            
                            echo 'সক্রিয়';
                            
                        }
                        else{
                            
                            echo 'নিষ্ক্রিয়';
                            
                        }
                        
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>জায়গার প্রকার</td><td>ফ্ল্যাট<?php
                            
                        if($mess == 1){
                            
                            echo ', মেস';
                            
                        }
                            
                        ?>
                        </td>
                        <td id="photocolumn" rowspan="4">
                            <?php
                            
                            $photoNames = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                            
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
                        <td>অবস্থান</td> <td><a id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">গুগল ম্যাপে দেখুন</a>
                        </td>
                    </tr>
                    <tr><td>বিজ্ঞাপনের প্রকার</td> <td><?php if($sale == 1){ echo 'বিক্রয়'; }else if($rent == 1){ echo 'ভাড়া'; } ?></td></tr>
                    <tr>
                        <td>হস্তান্তরযোগ্যতার সময়</td><td><?php echo $screenAvailableFrom ?></td>
                    </tr>
                    <?php
                    
                    if($sale == 1){
                        
                        ?>
                        <tr>
                            <td>বিক্রয়মূল্য</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' টাকা';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
                                }
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>বুকিং মূল্য</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' টাকা';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
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
                            <td>যে বা যারা নিতে পারবে</td> <td colspan="2"><?php
                                
                            if($male == 1){
                                
                                echo 'সিঙ্গেল (পুরুষ)';
                                
                            }
                            
                            if(($male == 0) && ($female == 1)){
                                
                                echo 'সিঙ্গেল (মহিলা)';
                                
                            }
                            else if(($male == 1) && ($female == 1)){
                                
                                echo ', সিঙ্গেল (মহিলা)';
                                
                            }
                            
                            if(($male == 0) && ($female == 0) && ($family == 1)){
                                
                                echo 'পরিবার';
                                
                            }
                            else if((($male == 1) || ($female == 1)) && ($family == 1)){
                                
                                echo ', পরিবার';
                                
                            }
                        
                            ?>
                            </td>
                        </tr>
                        
                    <?php
                    
                    if($mess == 1){
                        
                        ?>
                        
                        <tr id="maxNumPeople">
                            <td>সর্বাধিক জনসংখ্যা (যদি মেস হিসেবে ব্যবহার করা হয়)</td> <td colspan="2"><div id="maxPeople"><?php
                                    
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
                            <td>মাসিক ভাড়া</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' টাকা';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
                                }
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>জমা মূল্য</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' টাকা';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
                                }
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <?php
                        
                    }
                    
                    ?>
                    <tr>
                        <td>পুরো ঠিকানা</td> <td colspan="2"><div id="fullAddress"><?php echo $full_address; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফোন নম্বর</td> <td colspan="2"><div id="contactNo"><?php echo $contact_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>ইমেইল</td> <td colspan="2"><div id="email"><?php echo $contact_email; ?></div></td>
                    </tr>
                    
                    <tr id="additionalHeading">
                        <td colspan="3">অতিরিক্ত তথ্য</td>
                    </tr>
                
                    <tr>
                        <td>ফ্ল্যাট নম্বর</td> <td colspan="2"><div id="flatNo"><?php echo $flat_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>তলা</td> <td colspan="2"><div id="situatingfloor"><?php echo $floor; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফ্ল্যাটের আকার</td> <td colspan="2"><div id="flatSize"><?php
                        
                        if($size_of_flat != ''){
                            
                            echo $size_of_flat . ' বর্গফুট';
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>ঘরের সংখ্যা</td> <td colspan="2"><div id="numRoom"><?php echo $number_of_rooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>বাথরুমের সংখ্যা</td> <td colspan="2"><div id="numWashroom"><?php echo $number_of_washrooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>বারান্দার সংখ্যা</td> <td colspan="2"><div id="numBalcony"><?php echo $number_of_balconies; ?></div></td>
                    </tr>
                    <tr>
                        <td>বাড়িটিতে মোট তলার সংখ্যা</td> <td colspan="2"><div id="totalFloor"><?php echo $total_floors; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফ্ল্যাটে যাবার জন্য কী কোনো লিফট আছে?</td> <td colspan="2"><?php echo $liftBengali; ?></td>
                    </tr>
                    <tr>
                        <td>দালানে কী গাড়ি রাখার ব্যবস্থা আছে?</td> <td colspan="2"><?php echo $parking_facilityBengali; ?></td>
                    </tr>
                    <tr>
                        <td>অন্যান্য বর্ণনা</td> <td colspan="2"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                    </tr>
                
                </table>
                <?php
                
            }
            else if($room == 1){
                
                ?>
                <table id="roomInfoDelete">
                    <tr id="heading"><td colspan="3">বিস্তারিত বিজ্ঞাপন</td></tr>
                    <tr id="postedOn"><td colspan="3">পোস্ট করা হয়েছে <?php echo $screenDate; ?> তারিখে <?php echo $time; ?> টার সময়</td></tr>
                    <tr>
                        <td id="firstColumnDelete">অবস্থা</td> <td id="secondColumnDelete" colspan="2"><?php
                        
                        if($publish == 1){
                            
                            echo 'সক্রিয়';
                            
                        }
                        else{
                            
                            echo 'নিষ্ক্রিয়';
                            
                        }
                        
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>জায়গার প্রকার</td><td>রুম<?php
                            
                                if($mess == 1){
                                    
                                    echo ', মেস';
                                    
                                }
                            
                            ?>
                        </td>
                        <td id="photocolumn" rowspan="4">
                            <?php
                            
                            $photoNames = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                            
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
                        <td>অবস্থান</td> <td><a id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">গুগল ম্যাপে দেখুন</a>
                        </td>
                    </tr>
                    <tr><td>বিজ্ঞাপনের প্রকার</td> <td><?php if($sale == 1){ echo 'বিক্রয়'; }else if($rent == 1){ echo 'ভাড়া'; } ?></td></tr>
                    <tr>
                        <td>হস্তান্তরযোগ্যতার সময়</td><td><?php echo $screenAvailableFrom; ?></td>
                    </tr>
                    <tr>
                        <td>যে বা যারা নিতে পারবে</td> <td colspan="2"><?php
                            
                        if($male == 1){
                            
                            echo 'সিঙ্গেল (পুরুষ)';
                            
                        }
                        
                        if(($male == 0) && ($female == 1)){
                            
                            echo 'সিঙ্গেল (মহিলা)';
                            
                        }
                        else if(($male == 1) && ($female == 1)){
                            
                            echo ', সিঙ্গেল (মহিলা)';
                            
                        }
                        
                        if(($male == 0) && ($female == 0) && ($family == 1)){
                            
                            echo 'পরিবার';
                            
                        }
                        else if((($male == 1) || ($female == 1)) && ($family == 1)){
                            
                            echo ', পরিবার';
                            
                        }
                            
                        ?>
                        </td>
                    </tr>
                
                <?php
                
                if($mess == 1){
                    
                    ?>
                    
                    <tr id="maxNumPeople" style="display:none">
                        <td>সর্বাধিক জনসংখ্যা (যদি মেস হিসেবে ব্যবহার করা হয়)</td> <td colspan="2"><div id="maxPeople"><?php
                                
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
                        <td>মাসিক ভাড়া</td> <td colspan="2"><div id="rentalPrice"><?php
                        
                        if($rental_price != ''){
                            
                            echo $rental_price . ' টাকা';
                            
                            if($rental_price_nego == 1){
                                
                                echo ' (আলোচনাসাপেক্ষ)';
                                
                            }
                            else{
                                
                                echo ' (অপরিবর্তনীয়)';
                                
                            }	
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>জমা মূল্য</td> <td colspan="2"><div id="securityMoney"><?php
                        
                        if($security_money != ''){
                            
                            echo $security_money . ' টাকা';
                            
                            if($security_money_nego == 1){
                                
                                echo ' (আলোচনাসাপেক্ষ)';
                                
                            }
                            else{
                                
                                echo ' (অপরিবর্তনীয়)';
                                
                            }	
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>পুরো ঠিকানা</td> <td colspan="2"><div id="fullAddress"><?php echo $full_address; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফোন নম্বর</td> <td colspan="2"><div id="contactNo"><?php echo $contact_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>ইমেইল</td> <td colspan="2"><div id="email"><?php echo $contact_email; ?></div></td>
                    </tr>
                    
                    <tr id="additionalHeading">
                        <td colspan="3">অতিরিক্ত তথ্য</td>
                    </tr>
            
                    <tr>
                        <td>ফ্ল্যাট নম্বর</td> <td colspan="2"><div id="flatNo"><?php echo $flat_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>তলা</td> <td colspan="2"><div id="situatingfloor"><?php echo $floor; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফ্ল্যাটের আকার</td> <td colspan="2"><div id="flatSize"><?php
                            
                        if($size_of_flat != ''){
                            
                            echo $size_of_flat . ' বর্গফুট';
                            
                        }
                            
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>ঘরের আকার</td> <td colspan="2"><div id="roomSize"><?php
                        
                        if($size_of_room != ''){
                            
                            echo $size_of_room . ' বর্গফুট';
                            
                        }
                                
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>ফ্ল্যাটটিতে ঘরের সংখ্যা</td> <td colspan="2"><div id="numRoom"><?php echo $number_of_rooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফ্ল্যাটটিতে বাথরুমের সংখ্যা</td> <td colspan="2"><div id="numWashroom"><?php echo $number_of_washrooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>ঘরটির সাথে কী এটাচড বাথরুম আছে?</td> <td colspan="2"><?php echo $washroom_attachedBengali; ?></td>
                    </tr>
                    <tr>
                        <td>ফ্ল্যাটটিতে বারান্দার সংখ্যা</td> <td colspan="2"><div id="numBalcony"><?php echo $number_of_balconies; ?></div></td>
                    </tr>
                    <tr>
                        <td>ঘরটির সাথে কী এটাচড বারান্দা আছে?</td> <td colspan="2"><?php echo $balcony_attachedBengali; ?></td>
                    </tr>
                    <tr>
                        <td>বাড়িটিতে মোট তলার সংখ্যা</td> <td colspan="2"><div id="totalFloor"><?php echo $total_floors; ?></div></td>
                    </tr>
                    <tr>
                        <td>এই রুম সম্বলিত ফ্ল্যাটে যাবার জন্য কী কোনো লিফট আছে?</td> <td colspan="2"><?php echo $liftBengali; ?></td>
                    </tr>
                    <tr>
                        <td>দালানে কী গাড়ি রাখার ব্যবস্থা আছে?</td> <td colspan="2"><?php echo $parking_facilityBengali; ?></td>
                    </tr>
                    <tr>
                        <td>অন্যান্য বর্ণনা</td> <td colspan="2"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                    </tr>
                
                </table>
                <?php
                
            }
            else if($mess == 1){
                
                ?>
                <table id="messInfoDelete">
                    <tr id="heading"><td colspan="3">বিস্তারিত বিজ্ঞাপন</td></tr>
                    <tr id="postedOn"><td colspan="3">পোস্ট করা হয়েছে <?php echo $screenDate; ?> তারিখে <?php echo $time; ?> টার সময়</td></tr>
                    <tr>
                        <td id="firstColumnDelete">অবস্থা</td> <td id="secondColumnDelete" colspan="2"><?php
                        
                        if($publish == 1){
                            
                            echo 'সক্রিয়';
                            
                        }
                        else{
                            
                            echo 'নিষ্ক্রিয়';
                            
                        }
                        
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>জায়গার প্রকার</td><td>মেস</td>
                        <td id="photocolumn" rowspan="4">
                            <?php
                            
                            $photoNames = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                            
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
                        <td>অবস্থান</td> <td><a id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">গুগল ম্যাপে দেখুন</a>
                        </td>
                    </tr>
                    <tr><td>বিজ্ঞাপনের প্রকার</td> <td><?php if($sale == 1){ echo 'বিক্রয়'; }else if($rent == 1){ echo 'ভাড়া'; } ?></td></tr>
                    <tr>
                        <td>হস্তান্তরযোগ্যতার সময়</td><td><?php echo $screenAvailableFrom; ?></td>
                    </tr>
                    <tr>
                        <td>যে বা যারা নিতে পারবে</td> <td colspan="2"><?php
                            
                        if($male == 1){
                            
                            echo 'সিঙ্গেল (পুরুষ)';
                            
                        }
                        
                        if(($male == 0) && ($female == 1)){
                            
                            echo 'সিঙ্গেল (মহিলা)';
                            
                        }
                        else if(($male == 1) && ($female == 1)){
                            
                            echo ', সিঙ্গেল (মহিলা)';
                            
                        }
                            
                        ?>
                        </td>
                    </tr>
                    <tr id="maxNumPeople">
                        <td>রুমে সর্বাধিক জনসংখ্যা</td> <td colspan="2"><div id="maxPeople"><?php
                                
                        if($max_people != ''){
                            
                            echo $max_people;
                            
                        }
                            
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>মাসিক ভাড়া</td> <td colspan="2"><div id="rentalPrice"><?php
                        
                        if($rental_price != ''){
                            
                            echo $rental_price . ' টাকা';
                            
                            if($rental_price_nego == 1){
                                
                                echo ' (আলোচনাসাপেক্ষ)';
                                
                            }
                            else{
                                
                                echo ' (অপরিবর্তনীয়)';
                                
                            }	
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>জমা মূল্য</td> <td colspan="2"><div id="securityMoney"><?php
                        
                        if($security_money != ''){
                            
                            echo $security_money . ' টাকা';
                            
                            if($security_money_nego == 1){
                                
                                echo ' (আলোচনাসাপেক্ষ)';
                                
                            }
                            else{
                                
                                echo ' (অপরিবর্তনীয়)';
                                
                            }	
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>পুরো ঠিকানা</td> <td colspan="2"><div id="fullAddress"><?php echo $full_address; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফোন নম্বর</td> <td colspan="2"><div id="contactNo"><?php echo $contact_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>ইমেইল</td> <td colspan="2"><div id="email"><?php echo $contact_email; ?></div></td>
                    </tr>
                    
                    <tr id="additionalHeading">
                        <td colspan="3">অতিরিক্ত তথ্য</td>
                    </tr>
            
                    <tr>
                        <td>ফ্ল্যাট নম্বর</td> <td colspan="2"><div id="flatNo"><?php echo $flat_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>তলা</td> <td colspan="2"><div id="situatingfloor"><?php echo $floor; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফ্ল্যাটের আকার</td> <td colspan="2"><div id="flatSize"><?php
                                
                        if($size_of_flat != ''){
                            
                            echo $size_of_flat . ' বর্গফুট';
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>ঘরের আকার</td> <td colspan="2"><div id="roomSize"><?php
                        
                        if($size_of_room != ''){
                            
                            echo $size_of_room . ' বর্গফুট';
                            
                        }
                        
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>ফ্ল্যাটটিতে ঘরের সংখ্যা</td> <td colspan="2"><div id="numRoom"><?php echo $number_of_rooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফ্ল্যাটটিতে বাথরুমের সংখ্যা</td> <td colspan="2"><div id="numWashroom"><?php echo $number_of_washrooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>ঘরটির সাথে কী এটাচড বাথরুম আছে?</td> <td colspan="2"><?php echo $washroom_attachedBengali; ?></td>
                    </tr>
                    <tr>
                        <td>ফ্ল্যাটটিতে বারান্দার সংখ্যা</td> <td colspan="2"><div id="numBalcony"><?php echo $number_of_balconies; ?></div></td>
                    </tr>
                    <tr>
                        <td>ঘরটির সাথে কী এটাচড বারান্দা আছে?</td> <td colspan="2"><?php echo $balcony_attachedBengali; ?></td>
                    </tr>
                    <tr>
                        <td>বাড়িটিতে মোট তলার সংখ্যা</td> <td colspan="2"><div id="totalFloor"><?php echo $total_floors; ?></div></td>
                    </tr>
                    <tr>
                        <td>এই রুম সম্বলিত ফ্ল্যাটে যাবার জন্য কী কোনো লিফট আছে?</td> <td colspan="2"><?php echo $liftBengali; ?></td>
                    </tr>
                    <tr>
                        <td>অন্যান্য বর্ণনা</td> <td colspan="2"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                    </tr>
                
                </table>
                <?php
                
            }
            else if($officespace == 1){
                
                ?>
                <table id="officespaceInfoDelete">
                    <tr id="heading"><td colspan="3">বিস্তারিত বিজ্ঞাপন</td></tr>
                    <tr id="postedOn"><td colspan="3">পোস্ট করা হয়েছে <?php echo $screenDate; ?> তারিখে <?php echo $time; ?> টার সময়</td></tr>
                    <tr>
                        <td id="firstColumnDelete">অবস্থা</td> <td id="secondColumnDelete" colspan="2"><?php
                        
                        if($publish == 1){
                            
                            echo 'সক্রিয়';
                            
                        }
                        else{
                            
                            echo 'নিষ্ক্রিয়';
                            
                        }
                        
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>জায়গার প্রকার</td><td>অফিস</td>
                        <td id="photocolumn" rowspan="4">
                            <?php
                            
                            $photoNames = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                            
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
                        <td>অবস্থান</td> <td><a id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">গুগল ম্যাপে দেখুন</a>
                        </td>
                    </tr>
                    <tr><td>বিজ্ঞাপনের প্রকার</td> <td><?php if($sale == 1){ echo 'বিক্রয়'; }else if($rent == 1){ echo 'ভাড়া'; } ?></td></tr>
                    <tr>
                        <td>হস্তান্তরযোগ্যতার সময়</td><td><?php echo $screenAvailableFrom; ?></td>
                    </tr>
                    <?php
                    
                    if($sale == 1){
                        
                        ?>
                        <tr>
                            <td>বিক্রয়মূল্য</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' টাকা';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>বুকিং মূল্য</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' টাকা';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
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
                            <td>মাসিক ভাড়া</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' টাকা';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>জমা মূল্য</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' টাকা';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <?php
                        
                    }
                    
                    ?>
                    <tr>
                        <td>পুরো ঠিকানা</td> <td colspan="2"><div id="fullAddress"><?php echo $full_address; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফোন নম্বর</td> <td colspan="2"><div id="contactNo"><?php echo $contact_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>ইমেইল</td> <td colspan="2"><div id="email"><?php echo $contact_email; ?></div></td>
                    </tr>
                    
                    <tr id="additionalHeading">
                        <td colspan="3">অতিরিক্ত তথ্য</td>
                    </tr>
            
                    <tr>
                        <td>অফিস নম্বর</td> <td colspan="2"><div id="flatNo"><?php echo $flat_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>তলা</td> <td colspan="2"><div id="situatingfloor"><?php echo $floor; ?></div></td>
                    </tr>
                    <tr>
                        <td>অফিসটির আকার</td> <td colspan="2"><div id="flatSize"><?php
                        
                        if($size_of_flat != ''){
                            
                            echo $size_of_flat . ' বর্গফুট';
                            
                        }
                                
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>ঘরের সংখ্যা</td> <td colspan="2"><div id="numRoom"><?php echo $number_of_rooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>বাথরুমের সংখ্যা</td> <td colspan="2"><div id="numWashroom"><?php echo $number_of_washrooms; ?></div></td>
                    </tr>
                    <tr>
                        <td>দালানটিতে মোট তলার সংখ্যা</td> <td colspan="2"><div id="totalFloor"><?php echo $total_floors; ?></div></td>
                    </tr>
                    <tr>
                        <td>অফিসে যাবার জন্য কী কোনো লিফট আছে?</td> <td colspan="2"><?php echo $liftBengali; ?></td>
                    </tr>
                    <tr>
                        <td>অফিসে যাবার জন্য কী চলন্ত সিড়ি আছে?</td> <td colspan="2"><?php echo $elevatorBengali; ?></td>
                    </tr>
                    <tr>
                        <td>দালানে কী গাড়ি রাখার ব্যবস্থা আছে?</td> <td colspan="2"><?php echo $parking_facilityBengali; ?></td>
                    </tr>
                    <tr>
                        <td>অন্যান্য বর্ণনা</td> <td colspan="2"><div id="otherDescription"><?php echo $other_description; ?></div></td>
                    </tr>
                
                </table>
                <?php
                
            }
            else if($shop == 1){
                
                ?>
                <table id="shopInfoDelete">
                    <tr id="heading"><td colspan="3">বিস্তারিত বিজ্ঞাপন</td></tr>
                    <tr id="postedOn"><td colspan="3">পোস্ট করা হয়েছে <?php echo $screenDate; ?> তারিখে <?php echo $time; ?> টার সময়</td></tr>
                    <tr>
                        <td id="firstColumnDelete">অবস্থা</td> <td id="secondColumnDelete" colspan="2"><?php
                        
                        if($publish == 1){
                            
                            echo 'সক্রিয়';
                            
                        }
                        else{
                            
                            echo 'নিষ্ক্রিয়';
                            
                        }
                        
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td>জায়গার প্রকার</td><td>দোকান</td>
                        <td id="photocolumn" rowspan="4">
                            <?php
                            
                            $photoNames = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
                            
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
                        <td>অবস্থান</td> <td><a id="googleMapLink" href="https://www.google.com/maps/place/<?php echo $latitude . ',' . $longitude; ?>">গুগল ম্যাপে দেখুন</a>
                        </td>
                    </tr>
                    <tr><td>বিজ্ঞাপনের প্রকার</td> <td><?php if($sale == 1){ echo 'বিক্রয়'; }else if($rent == 1){ echo 'ভাড়া'; } ?></td></tr>
                    <tr>
                        <td>হস্তান্তরযোগ্যতার সময়</td><td><?php echo $screenAvailableFrom; ?></td>
                    </tr>
                    <?php
                    
                    if($sale == 1){
                        
                        ?>
                        <tr>
                            <td>বিক্রয়মূল্য</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' টাকা';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>বুকিং মূল্য</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' টাকা';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
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
                            <td>মাসিক ভাড়া</td> <td colspan="2"><div id="rentalPrice"><?php
                            
                            if($rental_price != ''){
                                
                                echo $rental_price . ' টাকা';
                                
                                if($rental_price_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>জমা মূল্য</td> <td colspan="2"><div id="securityMoney"><?php
                            
                            if($security_money != ''){
                                
                                echo $security_money . ' টাকা';
                                
                                if($security_money_nego == 1){
                                    
                                    echo ' (আলোচনাসাপেক্ষ)';
                                    
                                }
                                else{
                                    
                                    echo ' (অপরিবর্তনীয়)';
                                    
                                }	
                                
                            }
                            
                            ?></div>
                            </td>
                        </tr>
                        <?php
                        
                    }
                    
                    ?>
                    <tr>
                        <td>পুরো ঠিকানা</td> <td colspan="2"><div id="fullAddress"><?php echo $full_address; ?></div></td>
                    </tr>
                    <tr>
                        <td>ফোন নম্বর</td> <td colspan="2"><div id="contactNo"><?php echo $contact_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>ইমেইল</td> <td colspan="2"><div id="email"><?php echo $contact_email; ?></div></td>
                    </tr>
                    
                    <tr id="additionalHeading">
                        <td colspan="3">অতিরিক্ত তথ্য</td>
                    </tr>
            
                    <tr>
                        <td>দোকান নম্বর</td> <td colspan="2"><div id="flatNo"><?php echo $flat_no; ?></div></td>
                    </tr>
                    <tr>
                        <td>তলা</td> <td colspan="2"><div id="situatingfloor"><?php echo $floor; ?></div></td>
                    </tr>
                    <tr>
                        <td>দোকানের আকার</td> <td colspan="2"><div id="flatSize"><?php
                                
                        if($size_of_flat != ''){
                            
                            echo $size_of_flat . ' বর্গফুট';
                            
                        }
                                
                        ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>দালানটিতে মোট তলার সংখ্যা</td> <td colspan="2"><div id="totalFloor"><?php echo $total_floors; ?></div></td>
                    </tr>
                    <tr>
                        <td>দোকানে যাবার জন্য কী কোনো লিফট আছে?</td> <td colspan="2"><?php echo $liftBengali; ?></td>
                    </tr>
                    <tr>
                        <td>দোকানে যাবার জন্য কী চলন্ত সিড়ি আছে?</td> <td colspan="2"><?php echo $elevatorBengali; ?></td>
                    </tr>
                    <tr>
                        <td>দালানে কী গাড়ি রাখার ব্যবস্থা আছে?</td> <td colspan="2"><?php echo $parking_facilityBengali; ?></td>
                    </tr>
                    <tr>
                        <td>অন্যান্য বর্ণনা</td> <td colspan="2"><div id="otherDescription"><?php echo $other_description; ?></div></td>
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
        <td id="bottomContentsSecond">আমাদের ইমেইল ঠিকানা <span id="helloEmail">hello@kikhuji.com</span></td>
        <td id="bottomContentsLast"></td></tr>
    </table>
</body>
</html>
<?php

ob_end_flush();

?>