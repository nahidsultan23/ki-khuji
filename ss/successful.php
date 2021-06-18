<?php

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,1);
$_SESSION['comebackUrl']['successful'] = $pathUrl;

if(!isset($_SESSION['id'])){
	
	header('Location:login?er=login-need&cbp=successful');
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
    <title>Ki Khuji - Successful</title>
    
    <link rel="stylesheet" href="css/successful.css">
</head>

<?php

if(isset($_GET['content'])){
	
	$content = $_GET['content'];
	
	if($content == 'new-flat'){
		
		$description = 'Your advertisement has been published successfully. Anyone searching for a flat near the area can find your flat now.';
		
	}
	else if($content == 'new-room'){
		
		$description = 'Your advertisement has been published successfully. Anyone searching for a room near the area can find your room now.';
		
	}
	else if($content == 'new-mess'){
		
		$description = 'Your advertisement has been published successfully. Anyone searching for a mess near the area can find your mess now.';
		
	}
	else if($content == 'new-officespace'){
		
		$description = 'Your advertisement has been published successfully. Anyone searching for an office space near the area can find your office space now.';
		
	}
	else if($content == 'new-shop'){
		
		$description = 'Your advertisement has been published successfully. Anyone searching for a shop near the area can find your shop now.';
		
	}
	else{
		
		header('Location:/ss/');
		exit;
		
	}
	
}
else{
	
	header('Location:/ss/');
	exit;
	
}

?>

<body>
	<table id="successful">
    	<tr><td id="description"><?php echo $description ?></td></tr>
        <tr><td><a id="backLink" href="index">Back</a></td></tr>
    </table>

	<table id="bottomSpace">
    	<tr><td></td></tr>
    </table>
</body>

</html>