<?php 

	$executionStartTime = microtime(true);

	header('Content-Type: application/json; charset=UTF-8');

	include("config.php");
	include("validate.php");

	$conn = new mysqli($cd_host, $cd_user, $cd_password, $cd_dbname, $cd_port, $cd_socket);

	if (mysqli_connect_errno()) {

		$output['status']['code'] = "300";
		$output['status']['name'] = "failure";
		$output['status']['description'] = "database unavailable";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
		$output['data'] = [];

		mysqli_close($conn);

		echo json_encode($output);

		exit;

	}

	$name = validate_input($_POST['register']['name']);
	$email = validate_input($_POST['register']['email']);
	$pwd = validate_input($_POST['register']['pwd']);

	$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);

	$query = 'SELECT COUNT(`email`) FROM `users` WHERE `email` = "'.$email.'"';
	$result = $conn->query($query);
	$row = mysqli_fetch_assoc($result);

	if ($row['COUNT(`email`)'] > 0 ){

		$output['status']['code'] = "400";
		$output['status']['name'] = "executed";
		$output['status']['description'] = "<strong>Register failed!</strong> Account already exists.";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
		$output['data'] = [];
		$output['hashed'] = $hashed_pwd;

		mysqli_close($conn);

		echo json_encode($output);

		exit;
	
	}

	$query = "INSERT INTO `users` (`email`, `pwd`, `name`, `date_register`) VALUES ('".$email."', '".$hashed_pwd."', '".$name."', '".date("Y/m/d")."')";
	$result = $conn->query($query);

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "<strong>Register Successful!</strong> You can now go back and login.";
	$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
	$output['query'] = $query;

	mysqli_close($conn);

	echo json_encode($output);
	
?>