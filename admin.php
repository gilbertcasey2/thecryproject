<?php 
ob_start();	
	// include file to get databast functions
	include 'dbFunctions.php';
	include 'download.php';
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
<style>
	.viewBut {
		position: absolute;
		top: 385px;
		color:white;
		width: 100vw;
		text-align:center;
		opacity:.6;
	}
</style>
</head>
<!--- ADMIN PAGE FOR DISPLAYING AND DELETING ALL MODELS ---->
<body onResize="changeModelWidth()">
	<container>
	
		<section id="top">
		<nav class="nav">
			<ul>
				<a href="index.php"><li onMouseOver="navHover(this)" onMouseOut="navUnhover(this)"><img src="img/navline2.jpg" class="anav" >VIEW PAGE</li></a>
			</ul>
		</nav>
			<h1 class="title">Admin</h1>
			<img src="img/top-face.png" id="topFace">
			<img src="img/line-black.png" id="line" class="line">
			<p class="subcap">TAKE CONTROL OF YOUR STUFF.</p>
            <p class="viewBut">VIEW PAGE</p>
            <a href="index.php"><img src="img/contBut.png" onClick="upload()" id="contBut" style="top: 200px;"></a>
		</section>
        
		<section id="selection">
			<h1 class="title" id="choose">The Database</h1>
			<img src="img/line-white.png" id="line2" class="line">
			<p class="subcap">CHECK OUT WHO IS CONTRIBUTING. DELETE IF YOU PLEASE.</p>
			<!--- Here is the grid of models. The image is what shows. --->
			<section id="models">
				<!--for loop looping through all models -->
				<?php 
				$sql = "SELECT * FROM `models` WHERE 1";
				$result = $db->query($sql);
				$entry_count = $result->num_rows;
				while($row = $result->fetch_assoc()) {
						?>
                      <div class="model" style='background-image: url(" <?php echo $row['Image']; ?> ");'>
						<p class="mtitle" style="display: block;"><?php echo strtoupper($row['Name']); ?></p>
                        <img src="img/thumbhover.png" style="height: 100%;" class="thumbH" alt="thumb" >
                         <form method="post">
                          <input type="hidden" name="goatnum" value="<?php echo $row['ID']; ?>">
							<!--<p>Delete Model <?php echo $row['ID']; ?></p>--> 				
                        	<input type="submit" name="deleteSubmit" class='deleteGoat' value="Delete Model <?php echo $row['ID']; ?>">
                            <!--<input type="submit" name="download" class='deleteGoat' value="Download Model <?php /*echo $row['ID']; */?>">
                            <input type="submit" name="downloadImg" class='deleteGoat' value="Download Image <?php /*echo $row['ID']; */?>">-->
							</div>
                    	</form>
						<?php
						}
					?></div>
               
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

