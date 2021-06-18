<?php

if(!isset($_SESSION)){
	
	session_start();
	
}

if(!file_exists('../db/db.php')){
	
	session_destroy();
	
	header('Location:/error-db');
	exit;
	
}

$_SESSION['db'] = 1;
include('../db/db.php');
$_SESSION['db'] = NULL;

date_default_timezone_set('UTC');
$timestamp = time();

if(isset($_POST['randomNum_1']) && isset($_POST['key_1'])){
	
	$id = $_SESSION['id'];
	$key = $_POST['key_1'];
	
	if(isset($_SESSION['mark'][$key]['current-place'])){
		
		$fileName = $_FILES["image_1"]["name"];
		$fileTmpLoc = $_FILES["image_1"]["tmp_name"];
		
		function is_image($path){
			
			$a = getimagesize($path);
			$image_type = $a[2];
			
			if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP))){
				
				return 1;
				
			}
			return 0;
			
		}
		
		$x = is_image($fileTmpLoc);
		
		if($x == 0){
			
			exit;
			
		}
		
		$fileType = $_FILES["image_1"]["type"];
		$fileSize = $_FILES["image_1"]["size"];
		$fileErrorMsg = $_FILES["image_1"]["error"];
		
		$path_parts = pathinfo($_FILES["image_1"]["name"]);
		$extension = $path_parts['extension'];
		
		if(!(($extension == 'jpg') || ($extension == 'jpeg') || ($extension == 'png') ||($extension == 'JPG') || ($extension == 'JPEG') || ($extension == 'PNG'))){
			
			exit;
			
		}
		
		if($fileSize > 5242880){
			
			exit;
			
		}
		
		$fileTempName = '../uploadedPhotos/temp/' . $id . '_' . $key . '_' . '1.' . $extension;
		
		if(file_exists($fileTempName)){
			
			unlink($fileTempName);
			
		}
		
		move_uploaded_file($fileTmpLoc, $fileTempName);
		
		//start to resize the file
		
		function compress($source, $destination, $quality) {
		
			$info = getimagesize($source);
		
			if($info['mime'] == 'image/jpeg') 
				$image = imagecreatefromjpeg($source);
		
			elseif($info['mime'] == 'image/gif') 
				$image = imagecreatefromgif($source);
		
			elseif($info['mime'] == 'image/png') 
				$image = imagecreatefrompng($source);
		
			imagejpeg($image,$destination,$quality);
		
			return $destination;
		}
		
		$source_img = '../uploadedPhotos/temp/' . $id . '_' . $key . '_' . '1.' . $extension;
		$destination_img = '../uploadedPhotos/temp/' . $id . '_' . $key . '_' . '1_1.' . $extension;
		
		$fileSize = filesize($source_img);
		
		compress($source_img, $destination_img, 90);
		
		$fileSize = filesize($destination_img);
		
		$x = 80;
		
		while($fileSize > 307200){
			
			unlink($destination_img);
			
			compress($source_img, $destination_img, $x);
			
			$fileSize = filesize($destination_img);
			
			if($x == 50){
				
				break;
				
			}
			else{
				
				$x = $x - 10;
				
			}
			
		}
		
		unlink($source_img);
		rename($destination_img,$source_img);
		
		//end of resizing
		
		$_SESSION['mark'][$key]['photo_1'] = 'uploadedPhotos/temp/' . $id . '_' . $key . '_' . '1.' . $extension;
		$_SESSION['mark'][$key]['photo_1_other'] = '../' . $_SESSION['mark'][$key]['photo_1'];
		
		$fileOnlyName = $id . '_' . $key . '_' . '1.' . $extension;
		
		$query = "SELECT id FROM uploadedphoto WHERE name='$fileOnlyName'";
		$result = mysqli_query($dbc,$query);
		$count = mysqli_num_rows($result);
		
		if($count == 0){
			
			$query = "INSERT INTO uploadedphoto(user_id,randomkey,name,timestamp) VALUES('$id','$key','$fileOnlyName','$timestamp')";
			$result = mysqli_query($dbcInsert,$query);
			
		}
		else{
			
			$row = mysqli_fetch_array($result);
			$photoID = $row['id'];
			
			$query = "UPDATE uploadedphoto SET timestamp='$timestamp' WHERE id='$photoID'";
			$result = mysqli_query($dbcUpdate,$query);
			
		}
		
	}
	
}
else if(isset($_POST['randomNum_2']) && isset($_POST['key_2'])){
	
	$id = $_SESSION['id'];
	$key = $_POST['key_2'];
	
	if(isset($_SESSION['mark'][$key]['current-place'])){
		
		$fileName = $_FILES["image_2"]["name"];
		$fileTmpLoc = $_FILES["image_2"]["tmp_name"];
		$fileType = $_FILES["image_2"]["type"];
		$fileSize = $_FILES["image_2"]["size"];
		$fileErrorMsg = $_FILES["image_2"]["error"];
		
		$path_parts = pathinfo($_FILES["image_2"]["name"]);
		$extension = $path_parts['extension'];
		
		if(!(($extension == 'jpg') || ($extension == 'jpeg') || ($extension == 'png') ||($extension == 'JPG') || ($extension == 'JPEG') || ($extension == 'PNG'))){
			
			exit;
			
		}
		
		if($fileSize > 5242880){
			
			exit;
			
		}
		
		$fileTempName = '../uploadedPhotos/temp/' . $id . '_' . $key . '_' . '2.' . $extension;
		
		if(file_exists($fileTempName)){
			
			unlink($fileTempName);
			
		}
		
		move_uploaded_file($fileTmpLoc, $fileTempName);
		
		$_SESSION['mark'][$key]['photo_2'] = 'uploadedPhotos/temp/' . $id . '_' . $key . '_' . '2.' . $extension;
		$_SESSION['mark'][$key]['photo_2_other'] = '../' . $_SESSION['mark'][$key]['photo_2'];
		
		$fileOnlyName = $id . '_' . $key . '_' . '2.' . $extension;
		
		$query = "SELECT id FROM uploadedphoto WHERE name='$fileOnlyName'";
		$result = mysqli_query($dbc,$query);
		$count = mysqli_num_rows($result);
		
		if($count == 0){
			
			$query = "INSERT INTO uploadedphoto(user_id,randomkey,name,timestamp) VALUES('$id','$key','$fileOnlyName','$timestamp')";
			$result = mysqli_query($dbcInsert,$query);
			
		}
		else{
			
			$row = mysqli_fetch_array($result);
			$photoID = $row['id'];
			
			$query = "UPDATE uploadedphoto SET timestamp='$timestamp' WHERE id='$photoID'";
			$result = mysqli_query($dbcUpdate,$query);
			
		}
	
	}
	
}
else if(isset($_POST['randomNum_3']) && isset($_POST['key_3'])){
	
	$id = $_SESSION['id'];
	$key = $_POST['key_3'];
	
	if(isset($_SESSION['mark'][$key]['current-place'])){
		
		$fileName = $_FILES["image_3"]["name"];
		$fileTmpLoc = $_FILES["image_3"]["tmp_name"];
		$fileType = $_FILES["image_3"]["type"];
		$fileSize = $_FILES["image_3"]["size"];
		$fileErrorMsg = $_FILES["image_3"]["error"];
		
		$path_parts = pathinfo($_FILES["image_3"]["name"]);
		$extension = $path_parts['extension'];
		
		if(!(($extension == 'jpg') || ($extension == 'jpeg') || ($extension == 'png') ||($extension == 'JPG') || ($extension == 'JPEG') || ($extension == 'PNG'))){
			
			exit;
			
		}
		
		if($fileSize > 5242880){
			
			exit;
			
		}
		
		$fileTempName = '../uploadedPhotos/temp/' . $id . '_' . $key . '_' . '3.' . $extension;
		
		if(file_exists($fileTempName)){
			
			unlink($fileTempName);
		
		}
		
		move_uploaded_file($fileTmpLoc, $fileTempName);
		
		$_SESSION['mark'][$key]['photo_3'] = 'uploadedPhotos/temp/' . $id . '_' . $key . '_' . '3.' . $extension;
		$_SESSION['mark'][$key]['photo_3_other'] = '../' . $_SESSION['mark'][$key]['photo_3'];
		
		$fileOnlyName = $id . '_' . $key . '_' . '3.' . $extension;
		
		$query = "SELECT id FROM uploadedphoto WHERE name='$fileOnlyName'";
		$result = mysqli_query($dbc,$query);
		$count = mysqli_num_rows($result);
		
		if($count == 0){
			
			$query = "INSERT INTO uploadedphoto(user_id,randomkey,name,timestamp) VALUES('$id','$key','$fileOnlyName','$timestamp')";
			$result = mysqli_query($dbcInsert,$query);
			
		}
		else{
			
			$row = mysqli_fetch_array($result);
			$photoID = $row['id'];
			
			$query = "UPDATE uploadedphoto SET timestamp='$timestamp' WHERE id='$photoID'";
			$result = mysqli_query($dbcUpdate,$query);
			
		}
		
	}
	
}
else if(isset($_POST['randomNum_4']) && isset($_POST['key_4'])){
	
	$id = $_SESSION['id'];
	$key = $_POST['key_4'];
	
	if(isset($_SESSION['mark'][$key]['current-place'])){
		
		$fileName = $_FILES["image_4"]["name"];
		$fileTmpLoc = $_FILES["image_4"]["tmp_name"];
		$fileType = $_FILES["image_4"]["type"];
		$fileSize = $_FILES["image_4"]["size"];
		$fileErrorMsg = $_FILES["image_4"]["error"];
		
		$path_parts = pathinfo($_FILES["image_4"]["name"]);
		$extension = $path_parts['extension'];
		
		if(!(($extension == 'jpg') || ($extension == 'jpeg') || ($extension == 'png') ||($extension == 'JPG') || ($extension == 'JPEG') || ($extension == 'PNG'))){
			
			exit;
			
		}
		
		if($fileSize > 5242880){
			
			exit;
			
		}
		
		$fileTempName = '../uploadedPhotos/temp/' . $id . '_' . $key . '_' . '4.' . $extension;
		
		if(file_exists($fileTempName)){
			
			unlink($fileTempName);
			
		}
		
		move_uploaded_file($fileTmpLoc, $fileTempName);
		
		$_SESSION['mark'][$key]['photo_4'] = 'uploadedPhotos/temp/' . $id . '_' . $key . '_' . '4.' . $extension;
		$_SESSION['mark'][$key]['photo_4_other'] = '../' . $_SESSION['mark'][$key]['photo_4'];
		
		$fileOnlyName = $id . '_' . $key . '_' . '4.' . $extension;
		
		$query = "SELECT id FROM uploadedphoto WHERE name='$fileOnlyName'";
		$result = mysqli_query($dbc,$query);
		$count = mysqli_num_rows($result);
		
		if($count == 0){
			
			$query = "INSERT INTO uploadedphoto(user_id,randomkey,name,timestamp) VALUES('$id','$key','$fileOnlyName','$timestamp')";
			$result = mysqli_query($dbcInsert,$query);
			
		}
		else{
			
			$row = mysqli_fetch_array($result);
			$photoID = $row['id'];
			
			$query = "UPDATE uploadedphoto SET timestamp='$timestamp' WHERE id='$photoID'";
			$result = mysqli_query($dbcUpdate,$query);
			
		}
		
	}
	
}
else if(isset($_POST['randomNum_5']) && isset($_POST['key_5'])){
	
	$id = $_SESSION['id'];
	$key = $_POST['key_5'];
	
	if(isset($_SESSION['mark'][$key]['current-place'])){
		
		$fileName = $_FILES["image_5"]["name"];
		$fileTmpLoc = $_FILES["image_5"]["tmp_name"];
		$fileType = $_FILES["image_5"]["type"];
		$fileSize = $_FILES["image_5"]["size"];
		$fileErrorMsg = $_FILES["image_5"]["error"];
		
		$path_parts = pathinfo($_FILES["image_5"]["name"]);
		$extension = $path_parts['extension'];
		
		if(!(($extension == 'jpg') || ($extension == 'jpeg') || ($extension == 'png') ||($extension == 'JPG') || ($extension == 'JPEG') || ($extension == 'PNG'))){
			
			exit;
			
		}
		
		if($fileSize > 5242880){
			
			exit;
			
		}
		
		$fileTempName = '../uploadedPhotos/temp/' . $id . '_' . $key . '_' . '5.' . $extension;
		
		if(file_exists($fileTempName)){
			
			unlink($fileTempName);
			
		}
		
		move_uploaded_file($fileTmpLoc, $fileTempName);
		
		$_SESSION['mark'][$key]['photo_5'] = 'uploadedPhotos/temp/' . $id . '_' . $key . '_' . '5.' . $extension;
		$_SESSION['mark'][$key]['photo_5_other'] = '../' . $_SESSION['mark'][$key]['photo_5'];
		
		$fileOnlyName = $id . '_' . $key . '_' . '5.' . $extension;
		
		$query = "SELECT id FROM uploadedphoto WHERE name='$fileOnlyName'";
		$result = mysqli_query($dbc,$query);
		$count = mysqli_num_rows($result);
		
		if($count == 0){
			
			$query = "INSERT INTO uploadedphoto(user_id,randomkey,name,timestamp) VALUES('$id','$key','$fileOnlyName','$timestamp')";
			$result = mysqli_query($dbcInsert,$query);
			
		}
		else{
			
			$row = mysqli_fetch_array($result);
			$photoID = $row['id'];
			
			$query = "UPDATE uploadedphoto SET timestamp='$timestamp' WHERE id='$photoID'";
			$result = mysqli_query($dbcUpdate,$query);
			
		}
		
	}
	
}
else{
	
	include('index.php');
	
}

?>