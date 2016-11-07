	<?php
	
	@session_start();
	if(isset($_POST['id'])){
		$id = $_POST['id'];

		if(!isset($_SESSION[$id])){
			exit;
		}
		echo "<td colspan='2'> password <td colspan='5'> ".$_SESSION[$id]."</td>";

	}

	?>