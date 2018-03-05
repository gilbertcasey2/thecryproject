<?php
	session_start();
    $_SESSION = array();
	if(session_destroy()) {
		echo "You have successfully logged out. You will be redirected home in a second.";
		?>
        <script>
		setTimeout(function() { 
			window.location = 'index.php';
		
		}, 2000);
		</script>
        <?php
	}
	?>