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

if(isset($_POST['randomNum_1']) && isset($_POST['key_1'])){
	
	$id = $_SESSION['id'];
	$key = $_POST['key_1'];
	
	if(isset($_SESSION['mark'][$key]['photo_1'])){
		
		$fileTempName = '../' . $_SESSION['mark'][$key]['photo_1'];
		
		$_SESSION['mark'][$key]['photo_1'] = NULL;
		$_SESSION['mark'][$key]['photo_1_other'] = NULL;
		
		if(file_exists($fileTempName)){
			
			unlink($fileTempName);
			
		}
		
		$fileOnlyName = str_replace('../uploadedPhotos/temp/','',$fileTempName);
		
		$query = "DELETE FROM uploadedphoto WHERE name='$fileOnlyName'";
		$result = mysqli_query($dbcDelete,$query);
		
	}
	
}
else if(isset($_POST['randomNum_2']) && isset($_POST['key_2'])){
	
	$id = $_SESSION['id'];
	$key = $_POST['key_2'];
	
	if(isset($_SESSION['mark'][$key]['photo_2'])){
		
		$fileTempName = '../' . $_SESSION['mark'][$key]['photo_2'];
		
		$_SESSION['mark'][$key]['photo_2'] = NULL;
		$_SESSION['mark'][$key]['photo_2_other'] = NULL;
		
		if(file_exists($fileTempName)){
			
			unlink($fileTempName);
			
		}
		
		$fileOnlyName = str_replace('../uploadedPhotos/temp/','',$fileTempName);
		
		$query = "DELETE FROM uploadedphoto WHERE name='$fileOnlyName'";
		$result = mysqli_query($dbcDelete,$query);
		
	}
	
}
else if(isset($_POST['randomNum_3']) && isset($_POST['key_3'])){
	
	$id = $_SESSION['id'];
	$key = $_POST['key_3'];
	
	if(isset($_SESSION['mark'][$key]['photo_3'])){
		
		$fileTempName = '../' . $_SESSION['mark'][$key]['photo_3'];
		
		$_SESSION['mark'][$key]['photo_3'] = NULL;
		$_SESSION['mark'][$key]['photo_3_other'] = NULL;
		
		if(file_exists($fileTempName)){
			
			unlink($fileTempName);
			
		}
		
		$fileOnlyName = str_replace('../uploadedPhotos/temp/','',$fileTempName);
		
		$query = "DELETE FROM uploadedphoto WHERE name='$fileOnlyName'";
		$result = mysqli_query($dbcDelete,$query);
		
	}
	
}
else if(isset($_POST['randomNum_4']) && isset($_POST['key_4'])){
	
	$id = $_SESSION['id'];
	$key = $_POST['key_4'];
	
	if(isset($_SESSION['mark'][$key]['photo_4'])){
		
		$fileTempName = '../' . $_SESSION['mark'][$key]['photo_4'];
		
		$_SESSION['mark'][$key]['photo_4'] = NULL;
		$_SESSION['mark'][$key]['photo_4_other'] = NULL;
		
		if(file_exists($fileTempName)){
			
			unlink($fileTempName);
			
		}
		
		$fileOnlyName = str_replace('../uploadedPhotos/temp/','',$fileTempName);
		
		$query = "DELETE FROM uploadedphoto WHERE name='$fileOnlyName'";
		$result = mysqli_query($dbcDelete,$query);
		
	}
	
}
else if(isset($_POST['randomNum_5']) && isset($_POST['key_5'])){
	
	$id = $_SESSION['id'];
	$key = $_POST['key_5'];
	
	if(isset($_SESSION['mark'][$key]['photo_5'])){
		
		$fileTempName = '../' . $_SESSION['mark'][$key]['photo_5'];
		
		$_SESSION['mark'][$key]['photo_5'] = NULL;
		$_SESSION['mark'][$key]['photo_5_other'] = NULL;
		
		if(file_exists($fileTempName)){
			
			unlink($fileTempName);
			
		}
		
		$fileOnlyName = str_replace('../uploadedPhotos/temp/','',$fileTempName);
		
		$query = "DELETE FROM uploadedphoto WHERE name='$fileOnlyName'";
		$result = mysqli_query($dbcDelete,$query);
		
	}
	
}
else{
	
	include('index.php');
	
}

?>