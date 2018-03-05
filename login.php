<?php 
	// include file to get database functions
	include 'dbFunctions.php';
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
	#contribute {  position: absolute; min-height: 100%; height: 900px; top:0px; }
	h2 {top: 170px;}
	footer {height: 165px; background-color: #191919; top: 100vh; margin-top: -165px;}
	.title { margin-top: 140px; z-index: 1;}
	
	#loginL, #loginR { top: 0px; }
	
	.sub2 { position: relative; top: 0px; left: 50%; width: 404px; margin-left: -192px; opacity: 1; cursor: pointer;}
	
	#formHid { display: block; padding-top: 0px; top: 0px; z-index: 1;}
	#cover{height: 100%; width: 100%; background: #191919; opacity: .8; position: absolute; top: 0px;}
	#back {height: 30px; padding: 0px; position: absolute;padding-top: 10px; top: 580px; opacity: .9}
	</style>
</head>

<body onResize="changeModelWidth()" >
	<container style="height:100wh;">	
		
					<section id="contribute" >
						<!-- All of the forms for logging in and creating an account --->
						<h1 class="title" id="choose">Welcome!</h1>
						<div id="formHid">
						<form  class="formy" method="post" enctype="multipart/form-data">
						<div id="loginL">
						<p class="little">Newcomers</p>
							<p class="lab">Name:</p>
							<input type="text" name="userName"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
							<p class="lab">Email:</p>
							<input type="text" name="email"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
							<p class="lab">Password:</p>
							<input type="password" name="password"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
							<input type="submit" name="signUp" value="SIGN UP" class="sub2">
						</div>  
                        
						<div id="loginR">
						<p class="little">Old friends</p>
							<p class="lab">Username:</p>
							<input type="text" name="signName"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
							<p class="lab">Password:</p>
							<input type="password" name="signPassword"  id="nameBox" class="boxText" onClick="nameText(this)"><br>
							<input type="submit" name="signIn" value="LOG IN" class="sub2">

						</div>
						</form>
						<a href="index.php"><div class="sub2" id="back">BACK TO MOTIONMODELS</div></a>
						</div>
						<div id="cover"></div>
					</section>
				</div>
                
               <?php
			   // The code for signing in 
			   if(isset($_POST['signIn'])) {
					echo "SIGNING IN";
					$name = $_POST['signName'];
					$password = $_POST['signPassword'];
					$sql = "SELECT * FROM `Users` WHERE 1";
					$result = $db->query($sql);
					$addUser = 1;
					while($row = $result->fetch_assoc()) {	
						if($row['UserName'] == $name) {
								if(password_verify($password, $row['Password'])) {
									 $_SESSION['loggedin'] = true;
									 $_SESSION['username'] = $name; ?>
									 <script>
									window.location = 'index.php';
									</script> <?php	
								}
						}
					}
		
			}
			// the code for signing up
			if(isset($_POST['signUp'])) {
				echo "THINGS ARE SET! <br>";
				$name = $_POST['userName'];
				$email = $_POST['email'];
				$pw = $_POST['password'];
				$password = password_hash($pw, PASSWORD_DEFAULT);
				$sql = "SELECT * FROM `Users` WHERE 1";
				$result = $db->query($sql);
				$addUser = 1;
				while($row = $result->fetch_assoc()) {	
					if($row['UserName'] == $name) {
							$addUser = 0;
					}
				}
				if($name == null || $password == null || $email == null) {
					?><p>Please fill out all fields.</p><?php
				} else if($addUser == 0) {
					?><p>That user already exists.</p><?php
				}
				else {
					mkdir("users/" . $name);
					mkdir("users/" . $name . "/videos/");
					$dir = "users/" . $name .  "/videos/";
					$sql = "INSERT INTO `Users`(`UserName`, `Password`, `VideoNum`, `VideoPath`, `Email`) VALUES ('$name','$password',0,'$dir', '$email')";
					if ($db->query($sql) === TRUE) {
									echo "Record updated successfully";
								} else {
									echo "Error updating record: " . $db->error;
								}
					$_SESSION['loggedin'] = true;
					$_SESSION['username'] = $name;
					echo "SEssion status: " . $_SESSION['loggedin']; ?>
					<script>
									window.location = 'index.php';
					</script> <?php
				}
		}
?> 
                
	</container>
</body>
</html>
