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
<title><?php echo $_SESSION['username'] ?>'s Videos</title>

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

	/**
	*	This is all the same functions for displaying video
	* 	as seen in main.js, but they are updated slightly to 
	*	be able to play multiple videos in one page.
	*/
	function show() {
			var vidH = (window.innerWidth*1080)/1920;
			var playTop = vidH/2 - 20;
			$('.playBut').css("top", playTop + "px");
			$('.vidcover').css("height", vidH);
	}

	function showVideo2(num) {
			console.log("showing video");
			console.log("after submission");
			$('#models').css("display", "none");
			$('#viewbut').css("display", "none");
			$('#video').css("display", "inline-block");
			var string = '#mainVid' + num;
			var video = $(string);
			var vidH = (window.innerWidth*1080)/1920;
			var playTop = vidH/2 - 20;
			$('#playBut' + num).css("top", playTop + "px");
			$('#vidcover' + num).css("height", vidH);
			$('#savebut' + num).css("display", "inline");
			
			string = "seek-bar" + num;
			var seek = document.getElementById(string);
			console.log("String: " + string);
			string = "mainVid"+ num;
			var video = document.getElementById(string);
			string = "volume-bar"+ num;
			var volume = document.getElementById(string);
			console.log("seek: " + seek);
			// change the video time when seek bar is changed
			seek.addEventListener("change", function() {
				var time = video.duration * (seek.value/100);
				video.currentTime = time;
			});
			console.log("showing video2");
	
			// change where the seek bar handle is
			video.addEventListener("timeupdate", function() {
				var value = (100/video.duration) * video.currentTime;
				seek.value = value;
			});
			
			// make the video not try to play as seek handle moves
			seek.addEventListener("mousedown", function() {
				video.pause();
				playing = false;
				$('#playBut'+ num).attr("src", "img/play.png");
				$('#vidcover'+ num).css("opacity", 1);
				$('#seek'+ num).css("opacity", 1);
				$('#volume'+ num).css("opacity", 1);
			});
			
			// now the volume
			volume.addEventListener("change", function() {
				video.volume = volume.value;
			});
	}
	
	function playVideo2(num) {
		var seek = document.getElementById("seek-bar"+ num);
		var volume = document.getElementById("volume-bar"+ num);
		
		var vid = document.getElementById("mainVid"+ num);
		if (vid.paused) {
			vid.play();
			playing = true;
			$('#playBut'+num).attr("src", "img/pause.png");
			var id = setInterval(frame, 5);
			var op = 1;
			function frame() {
				if (op <= 0) {
					clearInterval(id);
				} else {
					op = op - .1;
					$('#vidcover' + num).css("opacity", op);
					$('#playBut' + num).css("opacity", op);
				}
			}
			$('#seek'+ num).css("opacity", 0);
			$('#volume'+ num).css("opacity", 0);
			
		} else {
			vid.pause();
			playing = false;
			$('#playBut'+ num).attr("src", "img/play.png");
			$('#vidcover'+ num).css("opacity", 1);
			bringBackPaused2(num);
		}
		
		
	}
	function bringBack2(num) {
		var vid = document.getElementById("mainVid"+ num);

		if (playing && ($('#vidcover'+ num).css("opacity") != 1)) {
			var id = setInterval(frame, 5);
			var op = 0;
			$('#playBut' + num).attr("src", "img/pause.png");
			function frame() {
				if (op >= 1) {
					clearInterval(id);
				} else {
					op = op + .1;
					$('#vidcover'+ num).css("opacity", op);
					$('#playBut'+ num).css("opacity", op);
				}
			}
			$('#seek'+ num).css("opacity", 1);
			$('#volume'+ num).css("opacity", 1);
		}
	}

	function bringBackPaused2(num) {
		$('#playBut'+ num).attr("src", "img/play.png");
		$('#vidcover'+ num).css("opacity", 1);
		$('#playBut'+ num).css("opacity", 1);
		var seek = document.getElementById("seek-bar"+ num);
		var volume = document.getElementById("volume-bar"+ num);
		$('#seek'+ num).css("opacity", 1);
		$('#volume'+ num).css("opacity", 1);
	}

	function goAway2(num) {
		var vid = document.getElementById("mainVid"+ num);
		if (playing && ($('#vidcover'+ num).css("opacity") == 1)) {
			var id = setInterval(frame, 5);
			var op = 1;
			function frame() {
				if (op <= 0) {
					clearInterval(id);
				} else {
					op = op - .1;
					$('#vidcover'+ num).css("opacity", op);
					$('#playBut'+ num).css("opacity", op);
				}
			}
			$('#seek'+ num).css("opacity", 0);
			$('#volume'+ num).css("opacity", 0);
		}
		
	}

</script>
<style>
/*

	Again, same deal, the CSS had to be updated to play multiple videos in one page.

*/
.playBut {
	position: absolute;
	left: 50%;
	margin-left: -50px;
	z-index: 2;
	width: 80px;
	height: 80px;
	pointer-events: none;
}
.vidcover {
	position: absolute;
	width: 100%;
	z-index: 1;
	opacity=1;
}

.seek-bar {
	position: absolute;
	bottom: 45px;
	width: 80%;
	left: 0px;
	z-index: 2;
}

.seek {
	z-index: 3;
	opacity: 1;
}
/* now give it our own */
.seek input[type=range]::-webkit-slider-thumb  {
	-webkit-appearance: none;
	border: 1px solid #cccbcb;
	border-radius: 6px;
	margin-top: -6px;
	width: 13px;
	background:  #feeb4c;
	height: 13px;
}

.seek input[type=range]:: -moz-range-thumb {
	border: 1px solid #cccbcb;
	border-radius: 6px;
	margin-top: -6px;
	width: 13px;
	background:  #feeb4c;
	height: 13px;
}

/** NOW we do the actual slider bar itself */
.seek input[type=range]::-webkit-slider-runnable-track {
	border-radius: 2px;
	-webkit-appearance: none;
	margin-top: -22px;
	width: 60%;
	height: 3px;
	margin-left: 20%;
	background:  #cccbcb;
}

.seek input[type=range]:focus::-webkit-slider-runnable-track {
	margin-top: -22px;
	width: 60%;
	height: 3px;
	margin-left: 20%;
	background:  #cccbcb;
}

.seek input[type=range]:: -moz-range-track {
	margin-top: -22px;
	width: 60%;
	height: 3px;
	margin-left: 20%;
	background:  #cccbcb;
}

/* Now for the volume bar */


.volume {
	z-index: 3;
	width: 20%;
	opacity: 1;
}

.volume input[type=range]::-webkit-slider-thumb  {
	-webkit-appearance: none;
	border: 1px solid #cccbcb;
	border-radius: 6px;
	margin-top: -4px;
	width: 10px;
	background:  #cccbcb;
	height: 10px;
}

.volume input[type=range]:: -moz-range-thumb {
	border: 1px solid #cccbcb;
	border-radius: 6px;
	margin-top: -4px;
	width: 10px;
	background:  #cccbcb;
	height: 10px;
}

/** NOW we do the actual slider bar itself */
.volume input[type=range]::-webkit-slider-runnable-track {
	border-radius: 2px;
	-webkit-appearance: none;
	margin-top: -22px;
	width: 20%;
	height: 2px;
	margin-left: 10%;
	background:  #cccbcb;
}

.volume input[type=range]:focus::-webkit-slider-runnable-track {
	margin-top: -22px;
	width:20%;
	height: 2px;
	margin-left: 10%;
	background:  #cccbcb;
}

.volume input[type=range]:: -moz-range-track {
	margin-top: -14px;
	width: 20%;
	height: 2px;
	margin-left: 10%;
	background:  #cccbcb;
}

/* The icon */
.vol {
	position: absolute;
	z-index: 3;
	bottom: 45px;
	left: 12px;
}
.volume-bar {
	position: absolute;
	bottom: 45px;
	width: 10%;
	left: 40px;
	z-index: 2;
}


</style>
</head>

<body onResize="show()">
	<container>
	
		<!----- And down here, we have a simple loop going through all of the user's saved videos. ---->
		<section id="selection">
        <?php 
				$name = $_SESSION['username'];
				$sql = "SELECT * FROM `Users` WHERE UserName = '$name'";
				$result = $db->query($sql);
				$user = $result->fetch_assoc();
				$videoNum = $user['VideoNum'];
				$path = $user['VideoPath'];
				?>
			<h1 class="title" id="choose">Hello, <?php echo $_SESSION['username'] ?></h1>
			<img src="img/line-white.png" id="line2" class="line">
            <?php if ($videoNum > 0) { ?>
				<p class="subcap">HERE ARE YOUR SAVED VIDEOS.</p>
			<?php } else { ?>
            	<p class="subcap">YOU HAVE NO SAVED VIDEOS.</p>
            <?php } ?>
            
            <a href="index.php"><img src="img/home.png" onClick="upload()" id="contBut" style="margin-top: 180px"></a>
            
			<!--- Here is the grid of models. The image is what shows. --->
			<section id="models2">
				<!--for loop looping through all models -->
				<?php
				for ($count = 1; $count <= $videoNum; $count++) { 
					$video = $path . $count . ".mp4";
				?>	
                
					<section  id="video" style="margin-bottom: 100px;">
						<a href="#" onClick="return false" ><img src="img/playMain.png" alt="PLAY" class="playBut" id="playBut<?php echo $count ?>">
						<div id="seek<?php echo $count ?>" class="seek"><input type="range" class="seek-bar" id="seek-bar<?php echo $count ?>" value="0"></div>
						<img id="vol<?php echo $count ?>" class="vol" alt="Volume" src="img/vol.png">	
						<div id="volume<?php echo $count ?>" class="volume"><input type="range" class="volume-bar" style="width: 10%;"id="volume-bar<?php echo $count ?>" value=".5" min="0" max="1" step="0.1" value="1"></div>
						<img src="img/videocover.png" onClick="playVideo2(<?php echo $count ?>)" onMouseEnter="bringBack2(<?php echo $count ?>)" onMouseLeave="goAway2(<?php echo $count ?>)" id="vidcover<?php echo $count ?>" class="vidcover"></a>
						<video width="100%" height="auto" id="mainVid<?php echo $count ?>" class="mainVid">
						<source src="<?php echo $video ?>" type="video/mp4">
						Sorry! Your browser does not support this video tag.
						</video>
					</section>
                    <script>showVideo2(<?php echo $count ?>);</script>	
				<?php			
				}
				?>
				
			</section>
			</section>
	
			
			<footer>
				<ul>
					<li>Contact</li>
					<li>Terms of Service</li>
					<li>Privacy</li>
				</ul>
				<div id="fline"></div>
				<p>&copy 2017 Rochester Institute of Technology</p>
			</footer>
		
	</container>
</body>

	
</html>

