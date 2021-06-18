<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

if(!isset($_SESSION['id'])){
	
	header('Location:/');
	exit;
	
}

$id = $_SESSION['id'];

if(!($id == 1)){
	
	header('Location:/');
	exit;
	
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ki Khuji - Check Again</title>
    
    <link rel="stylesheet" href="css/new-flat-info-check-again.css">
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

?>

<body>
    
	<form action="" method="post">
    	<table id="flatInfo">
        	<tr id="heading"><td colspan="2">Check your given info again</td></tr>
            <tr>
            	<td id="firstColumn">Accommodation Type</td><td id="secondColumn">Flat<?php
					
				if($_SESSION['new-flat-info'][$rand]['mess'] == 1){
					
					echo ', Mess';
					
				}
					
				?>
                </td>
        	</tr>
            <tr>
            	<td>Location (According to Google Map)</td><td><?php echo $_SESSION['mark'][$rand]['current-place']; ?></td>
        	</tr>
            <tr>
            	<td>Advertisement type</td><td><?php if($_SESSION['new-flat-info'][$rand]['sale'] == 1){ echo 'Sale'; }else if($_SESSION['new-flat-info'][$rand]['rent'] == 1){ echo 'Rent'; } ?></td>
            </tr>
            <tr>
            	<td>Available from</td><td><?php echo $screenAvailableFrom; ?></td>
            </tr>
            <?php
			
			if($_SESSION['new-flat-info'][$rand]['rent'] == 1){
				
				?>
                <tr>
                    <td>Available for</td> <td><?php
                        
                    if($_SESSION['new-flat-info'][$rand]['male'] == 1){
                        
                        echo 'Single (Male)';
                        
                    }
                    
                    if(($_SESSION['new-flat-info'][$rand]['male'] == 0) && ($_SESSION['new-flat-info'][$rand]['female'] == 1)){
                        
                        echo 'Single (Female)';
                        
                    }
                    else if(($_SESSION['new-flat-info'][$rand]['male'] == 1) && ($_SESSION['new-flat-info'][$rand]['female'] == 1)){
                        
                        echo ', Single (Female)';
                        
                    }
                    
                    if(($_SESSION['new-flat-info'][$rand]['male'] == 0) && ($_SESSION['new-flat-info'][$rand]['female'] == 0) && ($_SESSION['new-flat-info'][$rand]['family'] == 1)){
                        
                        echo 'Family';
                        
                    }
                    else if((($_SESSION['new-flat-info'][$rand]['male'] == 1) || ($_SESSION['new-flat-info'][$rand]['female'] == 1)) && ($_SESSION['new-flat-info'][$rand]['family'] == 1)){
                        
                        echo ', Family';
                        
                    }
                
                    ?>
                    </td>
                </tr>
                
            <?php
            
            if($_SESSION['new-flat-info'][$rand]['mess'] == 1){
                
                ?>
                
                <tr id="maxNumPeople">
                    <td>Maximum number of people (in case of using as a mess)</td> <td><?php
                            
                    if($_SESSION['new-flat-info'][$rand]['max_people'] != ''){
                        
                        echo $_SESSION['new-flat-info'][$rand]['max_people'];
                        
                    }
                        
                    ?>
                    </td>
                </tr>
                
                <?php
                
            }
                
            ?>
            
                <tr>
                    <td>Rental price per month</td> <td><?php
                    
                    if($_SESSION['new-flat-info'][$rand]['rental_price'] != ''){
                        
                        echo $_SESSION['new-flat-info'][$rand]['rental_price'] . ' BDT';
                        
                        if($_SESSION['new-flat-info'][$rand]['rental_price_nego'] == 1){
                            
                            echo ' (Negotiable)';
                            
                        }
                        else{
                            
                            echo ' (Fixed)';
                            
                        }
                        
                    }
                    
                    ?>
                    </td>
                </tr>
                <tr>
                    <td>Security money</td> <td><?php
                    
                    if($_SESSION['new-flat-info'][$rand]['security_money'] != ''){
                        
                        echo $_SESSION['new-flat-info'][$rand]['security_money'] . ' BDT';
                        
                        if($_SESSION['new-flat-info'][$rand]['security_money_nego'] == 1){
                            
                            echo ' (Negotiable)';
                            
                        }
                        else{
                            
                            echo ' (Fixed)';
                            
                        }
                        
                    }
                    
                    ?>
                    </td>
                </tr>
                <?php
				
			}
			else{
				
				?>
                <tr>
                    <td>Price</td> <td><?php
                    
                    if($_SESSION['new-flat-info'][$rand]['rental_price'] != ''){
                        
                        echo $_SESSION['new-flat-info'][$rand]['rental_price'] . ' BDT';
                        
                        if($_SESSION['new-flat-info'][$rand]['rental_price_nego'] == 1){
                            
                            echo ' (Negotiable)';
                            
                        }
                        else{
                            
                            echo ' (Fixed)';
                            
                        }
                        
                    }
                    
                    ?>
                    </td>
                </tr>
                <tr>
                    <td>Booking money</td> <td><?php
                    
                    if($_SESSION['new-flat-info'][$rand]['security_money'] != ''){
                        
                        echo $_SESSION['new-flat-info'][$rand]['security_money'] . ' BDT';
                        
                        if($_SESSION['new-flat-info'][$rand]['security_money_nego'] == 1){
                            
                            echo ' (Negotiable)';
                            
                        }
                        else{
                            
                            echo ' (Fixed)';
                            
                        }
                        
                    }
                    
                    ?>
                    </td>
                </tr>
                <?php
				
			}
			
			?>
            <tr>
            	<td>Full Address</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['full_address']; ?></td>
            </tr>
			<tr>
            	<td>Contact no.</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['contact_no']; ?></td>
            </tr>
            <tr>
            	<td>Email</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['contact_email']; ?></td>
            </tr>
            
            <tr id="additionalHeading">
            	<td colspan="2">Additional Info</td>
            </tr>

			<tr>
            	<td>Flat no.</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['flat_no']; ?></td>
            </tr>
			<tr>
            	<td>Floor</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['floor']; ?></td>
            </tr>
			<tr>
            	<td>Size of the flat</td> <td><?php
				
				if($_SESSION['new-flat-info'][$rand]['size_of_flat'] != ''){
					
					echo $_SESSION['new-flat-info'][$rand]['size_of_flat'] . ' square feet';
					
				}
				
				?>
                </td>
            </tr>
			<tr>
            	<td>Number of rooms</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['number_of_rooms']; ?></td>
            </tr>
			<tr>
            	<td>Number of washrooms</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['number_of_washrooms']; ?></td>
            </tr>
			<tr>
            	<td>Number of balconies</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['number_of_balconies']; ?></td>
            </tr>
            <tr>
            	<td>Total number of floors in the house</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['total_floors']; ?></td>
            </tr>
            <tr>
            	<td>Is there any lift to reach this flat?</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['lift']; ?></td>
            </tr>
            <tr>
            	<td>Is there any parking facility in the building?</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['parking_facility']; ?></td>
            </tr>
			<tr>
            	<td>Other description</td> <td><?php echo $_SESSION['new-flat-info'][$rand]['other_description']; ?></td>
            </tr>
            <tr id="submitRow">
            	<td colspan="2"><input type="submit" name="submit" id="submit" value="Proceed"></td>
            </tr>
        	<tr id="backRow"><td colspan="2"><a id="backLink" href="<?php echo $urlBackPage; ?>">Back to New Flat Info</a></td></tr>
        </table>
    </form>

	<table id="bottomSpace">
    	<tr><td></td></tr>
    </table>
</body>

</html>

<?php

if(isset($_POST['submit'])){
	
	$latitude = $_SESSION['mark'][$rand]['latitude'];
	$longitude = $_SESSION['mark'][$rand]['longitude'];
	
	$_SESSION['mark'][$rand] = NULL;
	
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
	
	if($contact_email == ''){
		
		$query = "INSERT INTO info(user_id,latitude,longitude,sale,rent,flat,room,mess,officespace,shop,available_from,male,female,family,max_people,rental_price,rental_price_nego,security_money,security_money_nego,full_address,contact_no,contact_email,flat_no,floor,size_of_flat,number_of_rooms,number_of_washrooms,number_of_balconies,total_floors,lift,parking_facility,other_description,date,time,timestamp,publish,randomkey) VALUES('$id','$latitude','$longitude','$sale','$rent','$flat','$room','$mess','$officespace','$shop','$available_from','$male','$female','$family','$max_people','$rental_price','$rental_price_nego','$security_money','$security_money_nego','$full_address','$contact_no','$contact_email','$flat_no','$floor','$size_of_flat','$number_of_rooms','$number_of_washrooms','$number_of_balconies','$total_floors','$lift','$parking_facility','$other_description','$date','$time','$timestamp','1','$rand')";
		$result = mysqli_query($dbcInsert,$query);
		
	}
	else{
		
		$query = "SELECT id FROM users_final WHERE email='$contact_email'";
		$result = mysqli_query($dbc,$query);
		$count = mysqli_num_rows($result);
		
		if($count){
			
			$row = mysqli_fetch_array($result);
			$user_ID = $row['id'];
			
			$query = "INSERT INTO info(user_id,latitude,longitude,sale,rent,flat,room,mess,officespace,shop,available_from,male,female,family,max_people,rental_price,rental_price_nego,security_money,security_money_nego,full_address,contact_no,contact_email,flat_no,floor,size_of_flat,number_of_rooms,number_of_washrooms,number_of_balconies,total_floors,lift,parking_facility,other_description,date,time,timestamp,publish,randomkey) VALUES('$user_ID','$latitude','$longitude','$sale','$rent','$flat','$room','$mess','$officespace','$shop','$available_from','$male','$female','$family','$max_people','$rental_price','$rental_price_nego','$security_money','$security_money_nego','$full_address','$contact_no','$contact_email','$flat_no','$floor','$size_of_flat','$number_of_rooms','$number_of_washrooms','$number_of_balconies','$total_floors','$lift','$parking_facility','$other_description','$date','$time','$timestamp','1','$rand')";
			$result = mysqli_query($dbcInsert,$query);
			
		}
		else{
			
			$query = "INSERT INTO info(user_id,latitude,longitude,sale,rent,flat,room,mess,officespace,shop,available_from,male,female,family,max_people,rental_price,rental_price_nego,security_money,security_money_nego,full_address,contact_no,contact_email,flat_no,floor,size_of_flat,number_of_rooms,number_of_washrooms,number_of_balconies,total_floors,lift,parking_facility,other_description,date,time,timestamp,publish,randomkey) VALUES('$contact_email','$latitude','$longitude','$sale','$rent','$flat','$room','$mess','$officespace','$shop','$available_from','$male','$female','$family','$max_people','$rental_price','$rental_price_nego','$security_money','$security_money_nego','$full_address','$contact_no','$contact_email','$flat_no','$floor','$size_of_flat','$number_of_rooms','$number_of_washrooms','$number_of_balconies','$total_floors','$lift','$parking_facility','$other_description','$date','$time','$timestamp','2','$rand')";
			$result = mysqli_query($dbcInsert,$query);
			
			$passkey = md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand())).md5(uniqid(rand()));
			
			$query = "SELECT id,passkey FROM users_temp WHERE email='$contact_email'";
			$result = mysqli_query($dbc,$query);
			$count = mysqli_num_rows($result);
			
			if($count){
				
				$row = mysqli_fetch_array($result);
				$adID = $row['id'];
			
				$passkeyString = $row['passkey'];
				$pieces = explode(" ",$passkeyString);
							
				$dbPasskey = $passkey . ' ' . $pieces[0] . ' ' . $pieces[1] . ' ' . $pieces[2] . ' ' . $pieces[3];
				
				$query = "UPDATE users_temp SET passkey='$dbPasskey' WHERE id='$adID'";
				$result = mysqli_query($dbcUpdate,$query);
				
			}
			else{
				
				$password = md5(uniqid(rand()));
				
				$salt = hash('sha512', $contact_email);
				$passwordx = hash('sha512', $password);
				$passwordy = $salt.$passwordx;
				$password = hash('sha512', $passwordy);
				
				$dbpasskey = $passkey . ' & & & &';
				
				$query = "INSERT INTO users_temp(email,password,passkey,timestamp) VALUES('$contact_email','$password','$dbpasskey','$timestamp')";
				$result = mysqli_query($dbcInsert,$query);
				
			}
			
			require("../../phpmailer/class.phpmailer.php");
			
			$mail = new phpmailer();
			
			$mail->From     = "no-reply@kikhuji.com";
			$mail->FromName = "Ki Khuji";
			$mail->Host     = "gator4256.hostgator.com";
			$mail->Mailer   = "smtp";
			$mail->Port   = "465";
			$mail->SMTPSecure   = "ssl";
			$mail->SMTPAuth   = true;
			$mail->Username   = "no-reply@kikhuji.com";
			$mail->Password   = "Ojhikp1VB%3drx@qV1Fa%q?60Td^C4cxh&q";
			$mail->isHTML();
			$mail->Subject = 'Complete your registration';
		
			$link = 'https://kikhuji.com/complete-registration-by-admin?dis=' . $passkey;
		
			$message = '<html>
			<head>
			<link href="http://linktocss/.../etc" rel="stylesheet" type="text/css" />
			<style>
			.button{
				
				font-size:25px;
				text-decoration:none;
				border: none;
				color: white;
				padding: 14px 28px;
				cursor: pointer;
				background-color: #2196F3;
				
			}
			.button:hover{
				
				background-color: blue;
				
			}
			.text{
				
				font-size:20px;
				font-family:arial;
				
			}
			</style>
			</head>
			<span class="text">We have recorded your information successfully. Now you\'ll need to click on the blue button below to complete the registration.</span> <a href="';
			
			$message .= $link;
			
			$message .='"><button class="button">Click here to complete registration</button></a>
			<body>
			</body>
			</html>
			';
		
			$mail->Body    = $message;
			$mail->AddAddress($contact_email);
				
			$mail->Send();
			
		}
		
	}
	
	if($result){
		
		$_SESSION['new-flat-info-error'][$rand] = NULL;
		$_SESSION['new-flat-info'][$rand] = NULL;
		
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