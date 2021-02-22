<?php

	$executionStartTime = microtime(true);

	include("config.php");
	include("validate.php");

	header('Content-Type: application/json; charset=UTF-8');

	$conn = new mysqli($cd_host, $cd_user, $cd_password, $cd_dbname, $cd_port, $cd_socket);

	if (mysqli_connect_errno()) {
		
		$output['status']['code'] = "300";
		$output['status']['name'] = "failure";
		$output['status']['description'] = "database unavailable";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";

		mysqli_close($conn);
		echo json_encode($output);

		exit;

	}
	
	$email = validate_input($_POST['login']['email']);
	$pwd = validate_input($_POST['login']['pwd']);
	$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)){

		$output['status']['code'] = "300";
		$output['status']['name'] = "failure";
		$output['status']['description'] = "<strong>Login failed!</strong> '".$email."' is not a valid email address.";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";

		mysqli_close($conn);
		echo json_encode($output);

		exit;

	}

	$query = 'SELECT COUNT(`email`) FROM `users` WHERE `email` = "'.$email.'"';
	$result = $conn->query($query);
	$row = mysqli_fetch_assoc($result);

	if ($row['COUNT(`email`)'] != 1 ){

		$output['status']['code'] = "400";
		$output['status']['name'] = "executed";
		$output['status']['description'] = "<strong>Login failed!</strong> Account does not exists.";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";

		mysqli_close($conn);
		echo json_encode($output);

		exit;
	
	}

	$query = 'SELECT * FROM `users` WHERE `email` = "'.$email.'"';
	$result = $conn->query($query);
	$row = mysqli_fetch_assoc($result);

	if (!password_verify($pwd, $row['pwd'])){

		$output['status']['code'] = "400";
		$output['status']['name'] = "executed";
		$output['status']['description'] = "<strong>Login failed!</strong> Email or password do not match our records.";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";

		mysqli_close($conn);
		echo json_encode($output);

		exit;

	} else {

		$query = 'UPDATE `users` SET `last_login` = "'.date("Y/m/d H:i:s").'" WHERE `email` = "'.$email.'"';
		$result = $conn->query($query);

		$output['status']['code'] = "200";
		$output['status']['name'] = "ok";
		$output['status']['description'] = "<strong>Login successful!</strong>";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";

		session_start();
		$_SESSION['user_id'] = $row['user_id'];		

		mysqli_close($conn);
		echo json_encode($output);
		
	}

?>