<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title>
		<?php echo $title; 
		$keywords = "";
		$category = "";
		$page = "";
		?>
	</title>

		<meta name="description" content="<?php echo $description; ?>">
		<meta name="keywords" content="<?php echo $keywords; ?>">
		<meta property="og:title" content="<?php echo $title; ?>">
		<meta property="og:description" content="<?php echo $description; ?>">
		<meta property="og:image" content="<?php echo $image; ?>">
		<meta property="og:url" content="<?php echo $url; ?>">

		<?php
			if($pageCanonical)
			{
			echo '<link rel="canonical" href="' . $pageCanonical . '">';
			}
			if($pageRobots)
			{
			echo '<meta name="robots" content="' . $pageRobots . '">';
			}
		?>

		<link rel="icon" type="image/png" href="assets/images/fav.png">

	    <!-- Vendor CSS -->
	    <link rel="stylesheet" type="text/css" href="assets/vendor/fontawesome-free/css/all.min.css">

	    <!-- Plugins CSS -->
	    <link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/vendor/magnific-popup/magnific-popup.min.css">

	    <!-- Default CSS -->
   		<link rel="stylesheet" type="text/css" href="assets/css/demo12.min.css">
   		<link rel="stylesheet" type="text/css" href="assets/css/todaysstyle.css">
   		<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

   		<link rel="stylesheet" type="text/css" href="assets/font/font-awesome/css/font-awesome.min">
		
</head>


	
