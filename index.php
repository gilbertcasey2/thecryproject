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

<body onResize="changeModelWidth()">
	<container>
	
    	<!-- Welcome the person if they are logged in --->
		<section id="top">
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
					?><div id="welcome"><p>Hello, <?php echo $_SESSION['username'] ?>!</p></div><?php
			} ?> 
            
        <!-- The nav bar --->
		<nav class="nav" <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {?>style=""<?php }?> >
			<ul>
            	 <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
            	<a href="videos.php" ><li onMouseOver="navHover(this)" onMouseOut="navUnhover(this)"><img src="img/navline.jpg" class="anav">MY VIDEOS</li></a>
                <?php } ?>
				<a href="#selection" ><li onMouseOver="navHover(this)" onMouseOut="navUnhover(this)"><img src="img/navline.jpg" class="anav">CHOOSE MODELS</li></a>
				<a href="#contribute"><li onMouseOver="navHover(this)" onMouseOut="navUnhover(this)"><img src="img/navline.jpg" class="anav">CONTRIBUTE</li></a>
				<a href="#about"><li onMouseOver="navHover(this)" onMouseOut="navUnhover(this)"><img src="img/navline.jpg" class="anav">ABOUT THE PROJECT</li></a>
                
                <!-- If not logged in, give option to log in. Else, option to log out. --->
				<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
					?><a href="logout.php"><li onMouseOver="navHover(this)" onMouseOut="navUnhover(this)"><img src="img/navline2.jpg" class="anav" >LOG OUT </li></a><?php
			} else {
				?> <a href="login.php"><li onMouseOver="navHover(this)" onMouseOut="navUnhover(this)"><img src="img/navline.jpg" class="anav" >LOGIN / SIGN UP </li></a> <?php 
			} ?>
			
			</ul>
		</nav>
        
        	<!-- The top of the page, image, ect --->
			<h1 class="title">The Cry Project</h1>
			<img src="img/top-face.png" id="topFace">
			<img src="img/line-black.png" id="line" class="line">
			<p class="subcap">A COMMUNITY SOURCED REINTERPRETATION OF THE GODLEY AND CREME CLASSIC VIDEO.</p>
			<a href="#selection"><img src="img/selectmodels.png" onClickalt="Select Models" id="select"></a>
		</section>
        
        <!-- Section to select the models --->
		<section id="selection">
			<h1 class="title" id="choose">Choose</h1>
			<img src="img/line-white.png" id="line2" class="line">
			<p class="subcap">WHICH MODELS DO YOU WANT IN YOUR VIDEO?</p>
			<img id="Rarrow" onClick="moveLeft()" src="img/goRight.png" alt="See next batch">
			<img id="Larrow" onClick="moveRight()" src="img/goLeft.png" alt="See prev batch">
            
			<!--- Here is the grid of models. The image is what shows. --->
			<section id="models">
				<form method="post" enctype="multipart/form-data" id="selectForm" action="video.php">
				<!--for loop looping through all models -->
				<?php 
				$sql = "SELECT * FROM `models` WHERE 1";
				$result = $db->query($sql);
				$entry_count = $result->num_rows;
				// if we have entries, then count and display them
				if ($entry_count > 0) {
					$count = 0;
					$loop = 0;
					?><div id="loop0"><?php
						// loop through every model in database
						while($row = $result->fetch_assoc()) {
							// if we're at %9, then we have a new section to scroll through
							// only nine show at a time
							if ($count >= 9) {
								$loop = $loop +1;
								$count = 0;
								?>
                                </div><div id="loop<?php echo $loop ?>">
                                <script>
									// we count how many loops we have so javascript can act appropriately
									countLoops();
                                </script>
								<?php
							}
							?><!---->
                            <!-- Now we display a thumb image of each model and give it functionality --->
                            <!-- Each one is a check box to select it --->
                            <div class="thumb">
                            <input type="checkbox" class='selectModel' id="check<?php echo $row['ID'];?>" 
                            name="check<?php echo $row['ID'];?>" value="on"><br>
                            
                            <!-- Label used to style them--->
                            <label for="check<?php echo $row['ID'];?>"  class="modelLabel">
                            <div class="model" id="<?php $count ?>" onMouseEnter='thumbHover(this)' onMouseLeave='thumbUnhover(this)' onClick='thumbClick(this)' style='background-image: url(" <?php echo $row['image']; ?> ");'>
                            <p class="mtitle"><?php echo strtoupper($row['Name']); ?></p><img src="img/thumbhover.png" class="thumbH" alt="thumb" ><script>countEntries()</script></span>
							</label><!---->
							</div>
                            </div>
							<?php
							// increment count
							$count = $count + 1;
						}
					?></div><?php
				}
				?>
                <!-- our submit button --->
                <label for="vidSubmit" id="viewbut"> 
                    <input type="submit" name="subVideo" id="vidSubmit">
                   <img src="img/viewvideo.png"  alt="View Video">
               </label>
               </form>
				<script>
				calcLoops()
                </script>	
			</section>
			</section>
	
    		<!-- Form to contribute a model --->
      		<section id="contribute">
				<div id="inner">
					<h1 class="title" id="choose">Choose</h1>
					<img src="img/line-black.png" id="line2" class="line">
					<p class="subcap" id="contText">WHICH MODELS DO YOU WANT IN YOUR VIDEO?</p>
					<a href="#formHid" onClick="return false" id="upl"><img src="img/upload2.png" onClick="upload()" id="contBut"></a>
					<section id="formHid">
					<!-- Start the form --->
					<form  class="formy" id='formy' method="post" enctype="multipart/form-data">
						
						<p class="lab">Model Name:</p>
					<input type="text" name="modelname" value="What is your model called?"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
                    	<!-- Upload image for thumbnail --->
						<div id="uploadL">
						<p class="lab">Upload image of model:</p>
                      <div id="upload"></div>
						<div class="box">
							<input class="box__file" type="file" id="file" name="file" value="modelpic" multiple><br>
							<label for="file" id="inLab"><div class="chooseImg">CHOOSE FILE</span></label>
						</div>
						</div>
						</div>
                        
                        <!-- Upload the model file itself (XML)--->
						<div id="uploadR">
						<p class="lab">Upload the model file (XML):</p>
						<div class="box2">
							<input class="box2__file" type="file" id="file2" name="modelfile" value="modelpic"><br>
							<label for="file2"><span class="chooseImg" >CHOOSE FILE</span></label>
						</div>
						</div>
                        
                        <!-- If person is not logged in, encourage them to login or make an account
                        otherwise, just thank them for entering a model!
                         --->
						<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                        	<div class = "what">THANKS FOR CONTRIBUTING, <?php echo strtoupper($_SESSION['username']) ?>!</div>
                            <?php } else { ?>
						<div class = "what">LETS GET TO KNOW YOU.</div>
						<input type="submit" name="sub1" value="No thanks, just enter the model!" class="sub1">
						
                        <!-- The sign up form --->
						<div id="loginL">
						<p class="little">Newcomers</p>
							<p class="lab">Name:</p>
							<input type="text" name="myName"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
							<p class="lab">Email:</p>
							<input type="text" name="myEmail"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
							<p class="lab">Password:</p>
							<input type="password" name="myPassword"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
						</div>
						<!-- The login form --->
						<div id="loginR">
						<p class="little">Old friends</p>
							<p class="lab">Username:</p>
							<input type="text" name="userName"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
							<p class="lab">Password:</p>
							<input type="password" name="password"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
						</div>
						<?php } ?>
                        <!-- Submit the form here! --->
						<input type="submit" name="sub2" value="ENTER MODEL" class="sub2">
						</form>
					</section>
				</div>
			</section>
            
            <!-- The about section of the program
            
            ------!!!!!!! JOE EDIT THIS SECTION!!!!!!!!! ----------
            
             --->
			<section id="about">
				<h1 class="title">About the Project</h1>
				<img src="img/line-white.png" id="line2" class="line">
				<p class="text">This is a bunch of text about the project. Basically people upload 3D models for fun and then other people pick them to make cusomized videos. The idea cam from that video and it is fun to play with technology so we are doing this. We hope you are really enjoying yourself at this site and that you tell all of your friends and then come right back please, and when you do please bring some awesome 3D models with you.</p>
			</section>
			
            <!-- Our page has feet. Well, it has foot. --->
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

