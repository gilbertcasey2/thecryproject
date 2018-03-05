<?php 
	// include file to get database functions
	include 'dbFunctions.php';
	include 'user.php';
	session_start();
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Motion Models</title>

<!-- CSS stylesheet -->
<link rel="stylesheet" type="text/css" media="screen" href="style.css">

<!-- Use jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- fonts -->
<script src="https://use.typekit.net/kzy4xto.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<script src="js/main.js"></script>
<script src="js/modernizr-custom.js"></script>
<script>
"use strict"
</script>
<style>
body, html {
	height: 100%;
}
	#contribute {  position: absolute; height: 100%; top:0px; }
	h2 {top: 170px;}
	footer {height: 165px; background-color: #191919; top: 100vh; margin-top: -165px;}
	.title { margin-top: 140px; z-index: 1;}
	
	</style>
</head>

<body onResize="changeModelWidth()" >
	<container style="height:100wh;">	
		
		<section id="contribute" >		
			<h1 class="title" id="choose">Thank you!</h1>
            <img src="img/line-black.png" id="line" class="line">
			<p class="subcap">Your model has been successfully submitted.</p>
            <a href="index.php"><img src="img/home.png" onClick="upload()" id="contBut"></a>
		</section>
		
	</container>
</body>
</html>
