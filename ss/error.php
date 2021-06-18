<?php

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
    <title>Ki Khuji - Error</title>
    
    <link rel="stylesheet" href="css/error.css">
</head>

<?php

$back = 'index';

if(isset($_GET['frm'])){
	
	$back = $_GET['frm'];
	
}

$urlBackPage = $back;

if(isset($_GET['content'])){
	
	$content = $_GET['content'];
	$pageContents = '&content=' . $content;
	
	if($content == 'new-flat'){
		
		$urlBackPage = $urlBackPage . '?content=flat';
		$description = 'Something went wrong! Your advertisement for the flat was not published. Please try again.';
		
	}
	else if($content == 'new-room'){
		
		$urlBackPage = $urlBackPage . '?content=room';
		$description = 'Something went wrong! Your advertisement for the room was not published. Please try again.';
		
	}
	else if($content == 'new-mess'){
		
		$urlBackPage = $urlBackPage . '?content=mess';
		$description = 'Something went wrong! Your advertisement for the mess was not published. Please try again.';
		
	}
	else if($content == 'new-officespace'){
		
		$urlBackPage = $urlBackPage . '?content=officespace';
		$description = 'Something went wrong! Your advertisement for the office space was not published. Please try again.';
		
	}
	else if($content == 'new-shop'){
		
		$urlBackPage = $urlBackPage . '?content=shop';
		$description = 'Something went wrong! Your advertisement for the shop was not published. Please try again.';
		
	}
	else{
		
		$description = 'Something went wrong! Please try again.';
		
	}
	
}
else{
	
	$description = 'Something went wrong! Please try again.';
	
}

if(isset($_GET['key'])){
	
	$rand = $_GET['key'];
	$urlBackPage = $urlBackPage . '&key=' . $rand;
	
}

if($back == 'index'){
	
	$urlBackPage = $back;
	
}

?>

<body>
    
	<table id="error">
    	<tr><td id="description"><?php echo $description ?></td></tr>
        <tr><td><a id="backLink" href="<?php echo $urlBackPage; ?>">Back</a></td></tr>
    </table>

	<table id="bottomSpace">
    	<tr><td></td></tr>
    </table>
</body>
</html>