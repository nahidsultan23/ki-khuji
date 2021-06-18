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

<!DOCTYPE html>
<html>

<head>
	<title>Ki Khuji - Mark the Location</title>
    <meta charset="utf-8">
    
    <link rel="stylesheet" href="css/mark.css">
    
    <script src="js/jquery.js"></script>
	<script src="js/mark.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGb51N89hoOKbN2E7hrxSzRqAOZVgyi80&libraries=places&callback=initMap" async defer></script>
</head>

<body>
    
	<?php
        
    if(isset($_GET['content'])){
        
        $content = $_GET['content'];
        
        if(!(($content=='flat')||($content=='room')||($content=='mess')||($content=='officespace')||($content=='shop'))){
            
            header('Location:index');
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
            <tr id="searchPlaceHeading"><th colspan="2">Find the exact location of the <?php
                
                if($content=='flat' || $content=='room'){
                    
                    echo 'house containing the ' . $content;
                    
                }
                else if($content=='officespace'){
                    
                    echo 'building containing the office space';
                    
                }
                else{
                    
                    echo $content;
                
                }
                
                ?> on the map
                </th>
            </tr>
            <tr>
                <td colspan="2"><input id="pac-input" type="text" placeholder="Type something to search on the map"></td>
            </tr>
            
        </table>
        
        <div id="map"></div>
        
        <form action="" method="post">
            <input type="hidden" name="latitude" id="latitude" value="<?php if(isset($_SESSION['mark'][$rand]['latitude'])){ echo $_SESSION['mark'][$rand]['latitude']; }else{ echo '23.810332'; } ?>">
            <input type="hidden" name="longitude" id="longitude" value="<?php if(isset($_SESSION['mark'][$rand]['longitude'])){ echo $_SESSION['mark'][$rand]['longitude']; }else{ echo '90.41251809999994'; } ?>">
            <table id="position">
            
                <tr>
                    <td style="min-width:170px" id="currentPositionName">Current position </td>
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
            
            if(!preg_match("/^[0-9.]+$/",$latitude)){
                
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
            
            if(!preg_match("/^[0-9.]+$/",$longitude)){
                
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
            
            $_SESSION['mark'][$rand]['current-place'] = $current_place;
            $_SESSION['mark'][$rand]['latitude'] = $latitude;
            $_SESSION['mark'][$rand]['longitude'] = $longitude;
            
            header('Location:' . $urlNextPage);
            exit;
            
        }
        
    }
    else{
        
        ?>
        <table id="searchAdTable">
            <tr id="topLine"><td>What are you advertising for?</td></tr>
            <tr><td><a href="index?content=flat">Flat</a></td></tr>
            <tr><td><a href="index?content=room">Room</a></td></tr>
            <tr><td><a href="index?content=mess">Mess</a></td></tr>
            <tr><td><a href="index?content=officespace">Office Space</a></td></tr>
            <tr><td><a href="index?content=shop">Shop</a></td></tr>
        </table>
        <?php
        
    }
	
	ob_end_flush();
    
    ?>

	<table id="bottomSpace">
    	<tr><td></td></tr>
    </table>
</body>