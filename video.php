<?php 
	ob_start();	
	session_start();
	// include file to get databast functions
	include 'dbFunctions.php';
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>The Cry Project</title>

<!-- CSS stylesheet -->
<link rel="stylesheet" type="text/css" media="screen" href="style.css">
<link rel="stylesheet" href="dropzone.css">

<!-- Use jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>


<!-- fonts -->
<script src="https://use.typekit.net/kzy4xto.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<script src="js/main.js" type="text/javascript"></script>
<script src="https://code.createjs.com/tweenjs-0.6.2.min.js"></script>
<script src="js/modernizr-custom.js"></script>
<!--<script type="text/javascript" src="js/dropzone.js"></script>-->
<script>
"use strict"

</script>
</head>

<body onLoad="showVideo()" onResize="showVideo()">
	<container>
    		<!---Here we display the video that the user wants. 
            
            	THE VIDEO FROM THE BLACK BOX GOES HERE
            
            --->
    		<h1 class="title" id="yourVid">Your Video</h1>
            <img src="img/line-white.png" id="vidLine" class="line">
            
            <a href="index.php#selection"><img src="img/savevid.png" id="savebut" alt="Save Video"></a>
            
			<section  id="video" style="margin-bottom: 100px;">
				<a href="#" onClick="return false" ><img src="img/playMain.png" alt="PLAY"  id="playBut">
				<div id="seek"><input type="range" id="seek-bar" value="0"></div>
				<img id="vol" alt="Volume" src="img/vol.png">	
				<div id="volume"><input type="range" id="volume-bar" value=".5" min="0" max="1" step="0.1" value="1"></div>
				<img src="img/videocover.png" onClick="playVideo()" onMouseEnter="bringBack()" onMouseLeave="goAway()" id="vidcover"></a>
				<video width="100%" height="auto" id="mainVid">
					<source src="movie/movie.mp4" type="video/mp4">
					Sorry! Your browser does not support this video tag.
				</video>
                <!---- If the user is logged in, they can save the video ---->
                <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                <form method="post" class="formy" enctype="multipart/form-data" >
              		<label for="vidSubmit2" id="saveBut"> 
                    <input type="submit" name="saveVideo"  id="vidSubmit2">
                   <img src="img/savevideo.png"  alt="View Video">
               </label>
               </form>
               <?php } ?>
			</section>
            
	</container>
</body>

	
</html>

