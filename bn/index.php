<?php

ob_start();

if(!isset($_SESSION)){
	
	session_start();
	
}

$pathUrl = $_SERVER['REQUEST_URI'];
$pathUrl = substr($pathUrl,4);

$_SESSION['comebackUrl']['bn'] = '../bn/' . $pathUrl;

$_SESSION['getip'] = 1;
include('../getip.php');
$_SESSION['getip'] = NULL;

?>
<!DOCTYPE html>
<html>

<head>
	<title>কী খুঁজি - কিনুন অথবা ভাড়া নিন খুব সহজে</title>
    <meta charset="utf-8">
    
    <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 480px)" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="css/m/mtopbar.css" />
    <link rel="stylesheet" href="css/index.css">
    
    <script src="js/clock.js"></script>
    <script src="js/sidebar.js"></script>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-9774916541464828",
        enable_page_level_ads: true
      });
    </script>
</head>

<?php

if(!file_exists('../db/db.php')){
	
	session_destroy();
	
	header('Location:error-db');
	exit;
	
}

$_SESSION['db'] = 1;
include('../db/db.php');
$_SESSION['db'] = NULL;

$query = "SELECT id,user_id,rent,sale,flat,room,mess,officespace,shop,available_from,rental_price ,full_address,size_of_flat,size_of_room,number_of_rooms,number_of_washrooms,number_of_balconies,date,time,timestamp,publish,randomkey FROM info WHERE publish = 1 ORDER BY timestamp DESC,id DESC";
$result = mysqli_query($dbc,$query);
$count = mysqli_num_rows($result);
$numAdEachPage = 10;
$numOfPage = floor($count/$numAdEachPage);
$extraPage = 0;

if(($count%$numAdEachPage) > 0){
	
	$extraPage = 1;
	
}

$totalPage = $numOfPage + $extraPage;

$pageNum = 1;

if(isset($_GET['page'])){
	
	if(preg_match("/^[0-9]+$/",$_GET['page'])){
		
		$pageNum = $_GET['page'];
		
	}
	
}

if(($totalPage != 0) && ($pageNum > $totalPage)){
	
	header('Location:/bn/?page=' . $totalPage);
	exit;
	
}
else if($pageNum < 1){
	
	header('Location:/bn/?page=1');
	exit;
	
}

$totalResultNumber = $count;
$firstResultNumber = ($pageNum - 1) * $numAdEachPage + 1;
$lastResultNumber = $firstResultNumber + $numAdEachPage - 1;

if($lastResultNumber>$count){
	
	$lastResultNumber = $count;
	
}

?>

<body onload="startTime()">
	<div class="topnav">
    	<img id="logo" src="../logo/logo.png">
        <div class="topnav-left">
        	<a href="/bn/">কী খুঁজি</a>
        </div>
        
        <div class="topnav-centered">
        	<a href="/bn/" class="active">হোম</a>
            <a href="search">অনুসন্ধান</a>
            <a href="mark">প্রচার</a>
            <a href="profile">প্রোফাইল</a>
            <a href="advertisements">বিজ্ঞাপনসমূহ</a>
            <button id="lanButton" onClick="location.href='/<?php echo $pathUrl; ?>'">English</button>
        </div>
        
        <?php
		
		if(isset($_SESSION['id'])){
			
			$id = $_SESSION['id'];
			$email = $_SESSION['email'];
			$displayEmail = $_SESSION['displayEmail'];
			
			?>
            <div class="topnav-right">
                <a href="profile"><?php echo $displayEmail; ?></a>
                <a href="logout?cbp=bn">লগ আউট</a>
            </div>
            <?php
			
		}
		else{
			
			?>
            <div class="topnav-right">
                <a href="login?cbp=bn">লগ ইন</a>
                <a href="register?cbp=bn">নিবন্ধন</a>
            </div>
            <?php
			
		}
		
		?>
    </div>
    
    <table id="clockTable">
    	<tr>
            <td>
    			<span id="clock"></span>
    		</td>
    	</tr>
    </table>
    
    <div id="nonFooter">
        <table id="everythingInside">
            <tr>
                <td id="LeftColumn">
                    <div id="sideNav">
                        <div id="siteName">
                            <div id="nameOnly">কী খুঁজি</div>
                        </div>
                        
                        <div id="siteMessage">
                            <div id="siteMessageOnly">ভাড়া বা কেনার জন্য আপনি কী খুঁজছেন?</div>
                        </div>
                    
                        <div id="propertiesClose" onclick="closeNav()">
                            <div id="close"><div id="logoDiv"><img id="propertiesLogo" src="../logo/icons/properties.png"></div><div id="propertiesNameDiv">প্রপার্টি <span id="arrow">&blacktriangle;</span></div></div>
                        </div>
                        
                        <div id="propertiesOpen" onclick="openNav()" style="display:none">
                            <div id="open"><div id="logoDiv"><img id="propertiesLogo" src="../logo/icons/properties.png"></div><div id="propertiesNameDiv">প্রপার্টি <span id="arrow">&blacktriangledown;</span></div></div>
                        </div>
                        
                        <div id="propertiesList">
                          <a href="search?content=flat"><div id="propertiesElement"><div id="elementsName">ফ্ল্যাট</div></div></a>
                          <a href="search?content=room"><div id="propertiesElement"><div id="elementsName">রুম</div></div></a>
                          <a href="search?content=mess"><div id="propertiesElement"><div id="elementsName">মেস</div></div></a>
                          <a href="search?content=officespace"><div id="propertiesElement"><div id="elementsName">অফিস</div></div></a>
                          <a href="search?content=shop"><div id="propertiesElement"><div id="elementsName">দোকান</div></div></a>
                        </div>
                    </div>
                </td>
                <td id="middleColumn">
                    <table id="InfoAndPhoto">
                        <tr id="headingRow"><td colspan="3">সকল বিজ্ঞাপন</td></tr>
                        <tr id="showingResultRow"><td colspan="3"><span id="showingResult"><?php echo $firstResultNumber . '-' . $lastResultNumber ?> নম্বর ফলাফল দেখানো হচ্ছে মোট <?php echo $totalResultNumber ?> টির মধ্য থেকে</span></td></tr>
                        <tr id="blankRowTop"><td colspan="3"></td></tr>
                        <?php
                            
						$i = 0;
						$j = 0;
						
						while(($row = mysqli_fetch_array($result)) && ($i < $numAdEachPage)){
					
							$skipNum = ($pageNum - 1) * $numAdEachPage;
							
							if($j < $skipNum){
								
								$j++;
								continue;
								
							}
							
							$adID = $row['id'];
							
							$rent = $row['rent'];
							$sale = $row['sale'];
							
							if($rent == 1){
								
								$for = 'rent';
								
							}
							else if($sale == 1){
								
								$for = 'sale';
								
							}
							
							$flat = $row['flat'];
							$room = $row['room'];
							$mess = $row['mess'];
							$officespace = $row['officespace'];
							$shop = $row['shop'];
							
							$available_from = $row['available_from'];
							$screenAvailableFrom = date('d F, Y',strtotime($available_from));
							
							$rental_price = $row['rental_price'];
							
							if(strlen($rental_price) > 0){
								
								if(strlen($rental_price) < 13){
									
									$rental_price = number_format($rental_price);
									
								}
								else{
									
									$rental_price = '999,999,999,999+';
									
								}
								
							}
							
							$fullAddress = $row['full_address'];
							$fullAddress = str_replace('*^*',' ',$fullAddress);
							
							if($fullAddress == ''){
								
								$fullAddress = 'কোনো ঠিকানা সরবরাহ করা হয় নি ।';
								
							}
							
							$size_of_flat = $row['size_of_flat'];
							
							if(strlen($size_of_flat) > 0){
								
								if(strlen($size_of_flat) < 8){
									
									$size_of_flat = number_format($size_of_flat);
									
								}
								else{
									
									$size_of_flat = '9,999,999+';
									
								}
								
							}
							
							$size_of_room = $row['size_of_room'];
							
							if(strlen($size_of_room) > 0){
								
								if(strlen($size_of_room) < 8){
									
									$size_of_room = number_format($size_of_room);
									
								}
								else{
									
									$size_of_room = '9,999,999+';
									
								}
								
							}
							
							$number_of_rooms = $row['number_of_rooms'];
							
							if(strlen($number_of_rooms) > 0){
								
								if(strlen($number_of_rooms) > 2){
									
									$number_of_rooms = '99+';
									
								}
								
							}
							
							$number_of_washrooms = $row['number_of_washrooms'];
							
							if(strlen($number_of_washrooms) > 0){
								
								if(strlen($number_of_washrooms) > 2){
									
									$number_of_washrooms = '99+';
									
								}
								
							}
							
							$number_of_balconies = $row['number_of_balconies'];
							
							if(strlen($number_of_balconies) > 0){
								
								if(strlen($number_of_balconies) > 2){
									
									$number_of_balconies = '99+';
									
								}
								
							}
							
							$date = $row['date'];
							$time = $row['time'];
							$dateTime = $date . ' ' . $time;
							$userDateTime = strtotime($dateTime) + $timeDifference;
							
							$screenDate = date('d F, Y',$userDateTime);
							$screenTime = date('H:i:s',$userDateTime);
							$publish = $row['publish'];
							$randomkey = $row['randomkey'];
							
							?>
                            <tr id="infoAndPhotoRow">
                                <td colspan="3">
                                    <a href="details?ser=<?php echo $adID; ?>&pg=<?php echo $pageNum; ?>">
                                        <div id="InfoAndPhotoContainer">
                                            <div id="infoDiv">
                                                <div id="accoType">
                                                	<?php
													if($flat == 1){
														
														echo 'ফ্ল্যাট';
														
														if($mess == 1){
															
															echo ', মেস';
															
														}
														
													}
													else if($room == 1){
														
														echo 'রুম';
														
														if($mess == 1){
															
															echo ', মেস';
															
														}
														
													}
													else if($mess == 1){
														
														echo 'মেস';
														
													}
													else if($officespace == 1){
														
														echo 'অফিস';
														
													}
													else if($shop == 1){
														
														echo 'দোকান';
														
													}
													?>
                                                </div>
                                                <?php
												
												if($rent == 1){
													
													?>
                                                    <div id="typeRent">ভাড়া</div>
                                                    <?php
													
												}
												else if($sale == 1){
													
													?>
                                                    <div id="typeSale">বিক্রয়</div>
                                                    <?php
													
												}
												
												if($rental_price != ''){
													
													?>
                                                    <div id="price"><span id="priceAmount"><?php echo $rental_price; ?></span> টাকা</div>
                                                    <?php
													
												}
												
												?>
                                                <div id="address"><?php echo $fullAddress; ?></div>
                                                <div id="icons">
													<?php if($number_of_rooms != ''){ ?><img id="roomIcon" src="../logo/icons/room.png"><div id="roomIconNumber"><?php echo $number_of_rooms; ?></div><?php } ?>
                                                    <?php if($number_of_washrooms != ''){ ?><img id="bathroomIcon" src="../logo/icons/bathroom.png"><div id="bathroomIconNumber"><?php echo $number_of_washrooms; ?></div><?php } ?>
                                                    <?php if($number_of_balconies != ''){ ?><img id="balconyIcon" src="../logo/icons/balcony.png"><div id="balconyIconNumber"><?php echo $number_of_balconies; ?></div><?php } ?>
                                                    <?php if($size_of_room != ''){ ?><div id="accoSize"><?php echo $size_of_room; ?> বর্গফুট</div><?php }else if($size_of_flat != ''){ ?><div id="accoSize"><?php echo $size_of_flat; ?> বর্গফুট</div><?php } ?>
                                                </div>
                                                <div id="availability">হস্তান্তরযোগ্যতার সময় <?php echo $screenAvailableFrom ?></div>
                                                <div id="posted">পোস্ট করা হয়েছে <?php echo $screenDate ?> তারিখে <?php echo $screenTime; ?> টার সময়</div>
                                            </div>
                                            <?php
											
											$photoNames = glob('../uploadedPhotos/' . $adID . '_' . $randomkey . '_*.*');
												
											if(isset($photoNames[0])){
												
												?>
												<img id="photo" src="<?php echo $photoNames[0]; ?>">
												<?php
												
											}
											else{
												
												?>
                                                <img id="photo" src="../logo/noPhoto/no-photo.png">
                                                <?php
												
											}
											
											?>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            <tr id="blankRowBottom"><td colspan="3"></td></tr>
                        	<?php
							
							$i++;
							$j++;
							
						}
						
						?>
                        <tr id="pageNumberRow">
                            <td colspan="3">
                                <div id="pageNumContainer">
                                	<?php
									
									$minPageNum = $pageNum - 2;
                                	$maxPageNum = $pageNum + 2;
									
									if($minPageNum < 1){
										
										$maxPageNum = $maxPageNum + (1 - $minPageNum);
										$minPageNum = 1;
										
										if($maxPageNum > $totalPage){
											
											$maxPageNum = $totalPage;
											
										}
										
									}
									else if($maxPageNum > $totalPage){
										
										$minPageNum = $minPageNum - ($maxPageNum - $totalPage);
										$maxPageNum = $totalPage;
										
										if($minPageNum < 1){
											
											$minPageNum = 1;
											
										}
										
									}
									
									if($minPageNum > 6){
										
										?>
										<button id="page" onClick="location.href='/bn/?page=1'">&laquo;</button>
										<?php
										
									}
									
									if($minPageNum > 1){
										
										?>
										<button id="page" onClick="location.href='/bn/?page=<?php echo $minPageNum-3; ?>'">&lsaquo;</button>
										<?php
										
									}
									
									for($k = $minPageNum; $k <= $maxPageNum; $k++){
									
										?>
										<button id="page" <?php if($pageNum == $k){ ?>class="activePage"<?php } ?> onClick="location.href='/bn/?page=<?php echo $k; ?>'"><?php echo $k; ?></button>
										<?php
										
									}
									
									if($maxPageNum < $totalPage){
										
										?>
										<button id="page" onClick="location.href='/bn/?page=<?php echo $maxPageNum+3; ?>'">&rsaquo;</button>
										<?php
										
									}
										
									?>
                                </div>
                            </td>
                        </tr>
                        <tr id="preNextRow">
                            <td id="prePageColumn">
                            	<?php
								
								if($pageNum > 1){
									
									?>
                                    <button id="previous" onClick="location.href='/bn/?page=<?php echo $pageNum-1; ?>'">আগের পাতা</button>
                                    <?php
									
								}
								
								?>
                            </td>
                            <td id="middlePreNextPageColumn"></td>
                            <td id="nextPageColumn">
                            	<?php
								
								if($pageNum < $totalPage){
									
									?>
                                    <button id="next" onClick="location.href='/bn/?page=<?php echo $pageNum+1; ?>'">পরের পাতা</button>
                                    <?php
									
								}
								
								?>
                            </td>
                        </tr>
					</table>
                </td>
                <td id="rightColumn">
                	<div id="createNewDiv">
                    	<button id="createNew" onClick="location.href='mark'">বিজ্ঞাপন তৈরি করুন</button>
                    </div>
                    <div id="searchSpecificDiv">
                    	<button id="searchSpecific" onClick="location.href='search'">নির্দিষ্ট এলাকায় খুঁজুন</button>
                    </div>
                </td>
            </tr>
        </table>
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