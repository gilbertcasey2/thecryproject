<?php
ob_start();
//include 'index.php';
/**
* Name: insert
* Purpose: To insert entries into the database
* @peram: $name the name of the model
* @peram: $number the number of entries already in the database
* @peram: $data the path to the model file
* @peram: $img the path to the image file
*/
	
	// load information
	$host = 'localhost';
	$user = 'ceg5887';
	$password = 'caseygilbertmotion';
	$folder = 'caseyegi_MotionModels';
	
	// try to connect 
	$db = new MySQLi($host, $user, $password, $folder);
	$message = '';
	if ($db -> connect_error) {
		$message = 'CONNECTION FAILED' + $db->error;
	}
	
	echo $message;
	
	// Now check for database 
	$message2 = '';
	$sql  = 'SELECT * FROM `models`';
	$result = $db->query( $sql );
	if ($db->error ) {
		$message2 = "Couldn't create database" . $db->error;
		//echo $message2;	
	}
	else {
		$message2 = "Database created successfully!";
	}
	
	// the number of entries:
	
	$sql  = 'SELECT * FROM `models`';
	$result = $db->query( $sql ); 
	$entry_count = $result->num_rows;
	//echo "Total entries: " . $entry_count . "<br>";
	
function insert($name, $number, $data, $img, $db) {
	$sql = "INSERT INTO `models`(`Name`, `ID`, `data`, `image`) VALUES ('$name',$number,'$data','$img')";

	if($db->query($sql) === TRUE) {
		//echo "New record created.<br>";
	} else {
		//echo "Error: " . $db->error . "<br>";
	}
}

/**
*	ALL CODE TO SEND XML TO BLACK BOX GOES IN THIS FUNCTION
*	When a user selects the appropriate models and wants to view
*	the video, PHP grabs all XML files of selected models.
*	And here they are.
*/
 if (isset($_POST['subVideo'])) {
				?><!--<p>The selected goats are: </p> --><?php
				$sql = "SELECT * FROM `models` WHERE 1";
				$result = $db->query($sql);
				// loop through all models
				while($row = $result->fetch_assoc()) {
					$name = 'check' . $row['ID'];
					// if they are selected do a thing
					if(isset($_POST[$name])  == "on") {
						?>
                        <!--<p>Name: -->
						<?php //echo $row['Name'];?>
                        <!--</p> -->
						<?php
						// CODE TO SEND XML TO BLACK BOX GOES HERE
					}
				}
				
			}
	
	/**
	*	This function handles submitting of the model files
	*	if the user doesn't want to log in.
	* 	(The 'No thanks, just enter the model!' button)
	*/
	if (isset($_POST['sub1'])) {
		//echo "In subitting";
		?><script>console.log("submitting")</script><?php
		
		// get number of entries
		$entry_count = $result->num_rows;
		$modelname = $_POST['modelname'];
		$success = false;
		//echo "Modelname: " . $modelname . "<br>";

	/** ---------------- UPLOAD FILE PHP ------------------*/
	
		// Build the path where the image will be 
		mkdir("img/uploads/" . $entry_count . "/");
		$target_dir = "img/uploads/" . $entry_count . "/";
		$target_file = $target_dir . basename($_FILES['file']['name']);
		
		$uploadOk = 1;
		$targetmodel = $target_dir . basename($_FILES['modelfile']['name']);
		$muploadOk = 1;
		
		// Check if user entered a goat photo
		if ($modelname == NULL) {
			echo "Please name your poor goat." ;
		}
		
		if(($_FILES["file"]["tmp_name"] == NULL)) {
			echo "Please enter a goat photo!";
		}
		if($_FILES["modelfile"]["tmp_name"] == NULL) {
			echo "BUT WHERE IS THE GOAT????";
		} 
		else {
			// get the file type
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			$mimageFileType = pathinfo($targetmodel, PATHINFO_EXTENSION);
			//echo "The image type: " . $imageFileType . "<br>";
			//echo "The model type: " . $mimageFileType . "<br>";
			
			// Check if image is a real image or a fakesie
				$check = getimagesize($_FILES["file"]["tmp_name"]);
			
				if($check !== false) {
					//echo "File is an image: " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image, you goof.";
					$uploadOk = 0;
				}
			
			
			// Check if the file already exists
			if (file_exists($target_file)) {
				echo "The file is already there, you meathead.";
				$uploadOk = 0;	
			}
			
			// Check if model already exists
			if (file_exists($targetmodel)) {
				echo "The model has already been uploaded. Give it a new name.";
				$muploadOk = 0;
			}
			
			/*// Check the image size
			if ($_FILES["file"]["size"] > 1000000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;	
			} */
			
			// Allow only certain types of file types
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;	
			}
			
			// Make sure the model is an XML file
			if ($mimageFileType != "xml") {
				echo "The model must be of the XML file format.";
				$muploadOk = 0;
			}
				$image = $_FILES["file"]["tmp_name"];
			 
			// Now, if the file is good to upload then upload it!
			if ($uploadOk === 0) {
				echo "We cannot, unfortunately, upload the file. Perhaps you did something extremely wrong.";
				rmdir($target_dir);
			} else if ($muploadOk === 0) {
				echo "The model failed to upload at this time. It's probably because you messed something up
				very badly.";
				rmdir($target_dir);
			} 
			else if(move_uploaded_file($image, $target_file) && move_uploaded_file($_FILES["modelfile"]["tmp_name"], $targetmodel)) {
					//echo "The file " . basename($image) . " and the file " . basename($image) . " has been uploaded.";
					if ($target_file != NULL && $targetmodel != NULL) {
						insert($modelname, $entry_count, $targetmodel, $target_file, $db);
						$success = true;
					}
					else {
						echo "We could not insert an entry at this time.";	
						rmdir($target_dir);
					}
			} else {
						echo "There has been an error uploading your file.";
						rmdir($target_dir);
				}
			// update the entry count
			$entry_count = $result->num_rows;
		}
		if ($success) {
		?>
		<script>
		window.location = 'submitted.php';
		</script> <?php	
	}
		
		
	}
	
	/**
	* 	This function handles enter of model data as well as a potential log in
	*/
	if (isset($_POST['sub2'])) {
		$success = false;
		//echo "In subitting";
		?><script>console.log("submitting")</script><?php
		$entry_count = $result->num_rows;
		$modelname = $_POST['modelname'];
		//echo "Modelname: " . $modelname . "<br>";

	/** ---------------- UPLOAD FILE PHP ------------------*/
	
		// Build the path where the image will be 
		mkdir("img/uploads/" . $entry_count . "/");
		$target_dir = "img/uploads/" . $entry_count . "/";
			$target_file = $target_dir . basename($_FILES['file']['name']);
		
		$uploadOk = 1;
		$targetmodel = $target_dir . basename($_FILES['modelfile']['name']);
		$muploadOk = 1;
		
		// Check if user entered a goat photo
		if ($modelname == NULL) {
			echo "Please name your poor goat." ;
		}
		
		if(!$goatImage && ($_FILES["file"]["tmp_name"] == NULL)) {
			echo "Please enter a goat photo!";
		}
		if($_FILES["modelfile"]["tmp_name"] == NULL) {
			echo "BUT WHERE IS THE GOAT????";
		} 
		else {
			// get the file type
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			$mimageFileType = pathinfo($targetmodel, PATHINFO_EXTENSION);
			//echo "The image type: " . $imageFileType . "<br>";
			//echo "The model type: " . $mimageFileType . "<br>";
			
			// Check if image is a real image or a fakesie
				if (!$goatImage) {
					$check = getimagesize($_FILES["file"]["tmp_name"]);
				} else {
					$check = getimagesize($image);
				}
				if($check !== false) {
					//echo "File is an image: " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image, you goof.";
					$uploadOk = 0;
				}
			
			
			// Check if the file already exists
			if (file_exists($target_file)) {
				echo "The file is already there, you meathead.";
				$uploadOk = 0;	
			}
			
			// Check if model already exists
			if (file_exists($targetmodel)) {
				echo "The model has already been uploaded. Give it a new name.";
				$muploadOk = 0;
			}
			
			/*// Check the image size
			if ($_FILES["file"]["size"] > 1000000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;	
			} */
			
			// Allow only certain types of file types
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;	
			}
			
			// Make sure the model is an XML file
			if ($mimageFileType != "xml") {
				echo "The model must be of the XML file format.";
				$muploadOk = 0;
			}
			if(!$goatImage) {
				$image = $_FILES["file"]["tmp_name"];
			} 
			// Now, if the file is good to upload then upload it!
			if ($uploadOk === 0) {
				echo "We cannot, unfortunately, upload the file. Perhaps you did something extremely wrong.";
				rmdir($target_dir);
			} else if ($muploadOk === 0) {
				echo "The model failed to upload at this time. It's probably because you messed something up
				very badly.";
				rmdir($target_dir);
			} 
			else if(move_uploaded_file($image, $target_file) && move_uploaded_file($_FILES["modelfile"]["tmp_name"], $targetmodel)) {
					//echo "The file " . basename($image) . " and the file " . basename($image) . " has been uploaded.";
					if ($target_file != NULL && $targetmodel != NULL) {
						insert($modelname, $entry_count, $targetmodel, $target_file, $db);
						$success = true;
					}
					else {
						echo "We could not insert an entry at this time.";	
						rmdir($target_dir);
					}
			} else {
						echo "There has been an error uploading your file.";
						rmdir($target_dir);
				}
					
			$entry_count = $result->num_rows;
		}
		
		// If a user name and password were entered
		if($_POST['userName'] != NULL && $_POST['password'] != NULL) {
			$name = 	$_POST['userName'];
			$password = $_POST['password'];
			$sql = "SELECT * FROM `Users` WHERE 1";
			$result = $db->query($sql);
			$addUser = 1;
			// loop through all users and figure out who you are
			while($row = $result->fetch_assoc()) {	
				if($row['UserName'] == $name) {
						// check that password is correct
						// ENCRYPTION SHOULD HAPPEN HERE
						if(password_verify($password, $row['Password'])) {
							// begin their session
							$_SESSION['loggedin'] = true;
							$_SESSION['username'] = $name; 
							?>
							<script>
								// redirect to submitted page
								window.location = 'submitted.php';
							</script> <?php	
						}
				}
			} // Here check if the user wants to create an account
		} else if ( $_POST['myName'] != NULL && $_POST['myEmail'] != NULL && $_POST['myPassword'] != NULL) {
			// get info entered
			$name = $_POST['myName'];
			$pw = $_POST['myPassword'];
			$password = password_hash($pw, PASSWORD_DEFAULT);
			$email = $_POST['myEmail'];
		$sql = "SELECT * FROM `Users` WHERE 1";
		$result = $db->query($sql);
		$addUser = 1;
		// make sure username isn't already in use
		while($row = $result->fetch_assoc()) {	
			if($row['UserName'] == $name) {
					$addUser = 0;
			}
		}
		if($addUser == 0) {
			?><p>That user already exists.</p><?php
		}
		else {
			// build their directory, ect, and insert them into the database
			mkdir("users/" . $name);
			mkdir("users/" . $name . "/videos/");
			$dir = "users/" . $name .  "/videos/";
			$sql = "INSERT INTO `Users`(`UserName`, `Password`, `VideoNum`, `VideoPath`, `Email`) VALUES ('$name','$password',0,'$dir', '$email')";
			if ($db->query($sql) === TRUE) {
							//echo "Record updated successfully";
						} else {
							echo "Error updating record: " . $db->error;
						}
			// begin their session
			$_SESSION['loggedin'] = true;
    		$_SESSION['username'] = $name;
			?>
			<script>
			// redirect to submitted page
			window.location = 'submitted.php';
			</script> <?php	
		}
		}
		
	if ($success) {
		?>
		<script>
		window.location = 'submitted.php';
		</script> <?php	
	}
	}
	
	// debug to console function
	function debug_to_console( $data ) {
	    $output = $data;
	    	if ( is_array( $output ) )
	       	 	$output = implode( ',', $output);

	   	 		echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	}
	
	/**
	* This function deletes model from database
	*/
	function delete($number, $db, $result) {
		$sql  = 'SELECT * FROM `models`';
		$sql = "SELECT * FROM `models` WHERE ID = $number";
		$result = $db->query( $sql );
		$p = $result->fetch_assoc();
		$path = $p['Image'];
		$path2 = $p['Data'];
		$path3 = $p['ID'];
		$sql = "DELETE FROM `models` WHERE ID = $number";
		$retval = $db->query($sql);
		if ($db->error ) { 
			$message = "Bad " . $db ->error;
			//echo $message;
		} else { 
			//$message = "Good " . $db ->error;
		}
		unlink($path);
		unlink($path2);
		rmdir("img/uploads/" . $p['ID']);
					
	}	
	
	/**
	*	This function calls delete
	* 	if the delete button was hit on admin page.
	*	It also updates all paths and directories afterwards
	*/
	if(isset($_POST['deleteSubmit'])) {
		$goatnum = $_POST['goatnum'];
		delete($goatnum, $db, $result);
		$entry_count = $result->num_rows;
		$sql = "SELECT * FROM `models` WHERE 1";
			$result = $db->query($sql);
			$entry_count = $result->num_rows;
			// loop through all models
			while($row = $result->fetch_assoc()) {
				// if they after the deleted item, they need updating
				if($row['ID'] > $goatnum) {
					$number = $row['ID'];
					$old = $number;
					$number = $number - 1;
					// update the IDs on all the other entries
					$sql = "UPDATE `models` SET ID = $number WHERE ID = $old";
					if ($db->query($sql) === TRUE) {
						//echo "Record updated successfully";
					} else {
						//echo "Error updating record: " . $db->error;
					}
					// renmae all directory names
					$oldDir = "img/uploads/" . $old . "/";
					$newDir = "img/uploads/" . $number . "/";
					rename($oldDir, $newDir);
					
					$namey = $row['Name'];
					
					// update the image paths
					$oldImg = $row['Image'];
					$find = '/' . $old . '/'; 
					$replace = '/' . $number . '/';
					$new = str_replace($find, $replace, $oldImg);
					$sql = "UPDATE `models` SET Image = '$new' WHERE Name = '$namey'";
					if ($db->query($sql) === TRUE) {
						//echo "Record updated successfully";
					} else {
						//echo "Error updating record: " . $db->error;
					}
					
					// update the model paths
					$oldData = $row['Data'];
					$find = '/' . $old . '/'; 
					$replace = '/' . $number . '/';
					$new = str_replace($find, $replace, $oldData);
					$sql = "UPDATE `models` SET Data = '$new' WHERE Name = '$namey'";
					if ($db->query($sql) === TRUE) {
						//echo "Record updated successfully";
					} else {
						//echo "Error updating record: " . $db->error;
					}
				}
			}
	}
	
	/**
	*	This function saves a video to a user's folder
	*	of videos
	*/
	 if(isset($_POST['saveVideo'])) {
		 // who is the user?
		$name = $_SESSION['username'];
		$sql = "SELECT * FROM `Users` WHERE UserName = '$name'";
		$result = $db->query($sql);
		if ($db->error ) {
			echo "THe error: " . $db -> error;
		}
		$user = $result->fetch_assoc();
		// get the number of videos they have already
		$currNum = $user['VideoNum'];
		// this will be the name of this next video
		$newNum = $currNum + 1;
		// update their video num
		$sql = "UPDATE `Users` SET VideoNum = '$newNum' WHERE UserName = '$name'";
		$result = $db->query($sql);
		if ($db->error ) {
			echo "THe error: " . $db -> error;
		}
		// build path to videos
		$vidPath = $user['VideoPath'];
		$path = $vidPath . $newNum . ".mp4";
		// move the video to that path
		copy('movie/movie.mp4', $path);
		
		?>
		<script>
		// go to saved page
		window.location = 'saved.php';
		</script> <?php	
		
	} 
	
?>
