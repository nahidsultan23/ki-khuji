<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$_SESSION['id'] = NULL;
$_SESSION['email'] = NULL;
$_SESSION['displayEmail'] = NULL;

if(isset($_GET['cbp'])){
	
	$cbp = $_GET['cbp'];
	
	if(isset($_SESSION['comebackUrl'][$cbp])){
		
		header('Location:/bn/' . $_SESSION['comebackUrl'][$cbp]);
		exit;
		
	}
	
}

header('Location:/bn/');
exit;

ob_end_flush();

?>