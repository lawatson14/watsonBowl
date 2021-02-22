<?php

	$executionStartTime = microtime(true);

	include("config.php");
	include("validate.php");

	header('Content-Type: application/json; charset=UTF-8');

	$conn = new mysqli($cd_host, $cd_user, $cd_password, $cd_dbname, $cd_port, $cd_socket);

	if (mysqli_connect_errno()) {
		
		$output['status']['status'] = "300";
		$output['status']['name'] = "failure";
		$output['status']['description'] = "database unavailable";
		$output['status']['message'] = "<strong>Submission failed! Failed to connect to server.</strong>";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
		$output['data'] = [];

		mysqli_close($conn);

		echo json_encode($output);

		exit;

	}
	
	/*
	$_POST['user'] = [
		"user_id" => 1,
		"name" => "Lee",
		"email" => "leealexanderwatson@gmail.com",
		"pwd" => "test123",
		"current" => "test123",
	];
	*/

	$user_id = validate_input($_POST['user']['user_id']);
	$name = validate_input($_POST['user']['name']);
	$email = validate_input($_POST['user']['email']);


	if (ISSET($_POST['user']['pwd'])){
		$pwd = $_POST['user']['pwd'];
		$current = $_POST['user']['current'];

		$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
		$hashed_current = password_hash($current, PASSWORD_DEFAULT);

		$query = "SELECT * FROM `users` WHERE `email` = '".$email."'";
		$result = $conn->query($query);
		$row = mysqli_fetch_assoc($result);

		if (!password_verify($current, $row['pwd'])){

			$output['status']['status'] = "400";
			$output['status']['name'] = "executed";
			$output['status']['message'] = "<strong>Login failed!</strong> Current password does not match our records.";
			$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";

			mysqli_close($conn);

			echo json_encode($output);

			exit;

		} else {
			$query = "UPDATE `users` SET `name` = '".$name."', `email` = '".$email."', `pwd` = '".$hashed_pwd."' WHERE `user_id` = '".$user_id."'";
			$result = $conn->query($query);
			
			if (!$result) {

				$output['status']['status'] = "400";
				$output['status']['name'] = "executed";
				$output['status']['description'] = "query failed";
				$output['status']['message'] = "<strong>Submission failed! </strong>";
				$output['data'] = [];

				mysqli_close($conn);

				echo json_encode($output); 

				exit;

			}

			$output['status']['status'] = "200";
			$output['status']['name'] = "ok";
			$output['status']['description'] = "success";
			$output['status']['message'] = "<strong>Submission successful! </strong> Your details have been updated.";
			$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
			
			mysqli_close($conn);

			echo json_encode($output);

			exit;

		}
	} else {

		$query = "UPDATE `users` SET `name` = '".$name."', `email` = '".$email."' WHERE `user_id` = '".$user_id."'";

		$result = $conn->query($query);
		
		if (!$result) {

			$output['status']['status'] = "400";
			$output['status']['name'] = "executed";
			$output['status']['description'] = "query failed";
			$output['status']['message'] = "<strong>Submission failed! </strong>";
			$output['data'] = [];

			mysqli_close($conn);

			echo json_encode($output); 

			exit;

		}

		$output['status']['status'] = "200";
		$output['status']['name'] = "ok";
		$output['status']['description'] = "success";
		$output['status']['message'] = "<strong>Submission successful! </strong> Your details have been updated.";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
		
		mysqli_close($conn);

		echo json_encode($output);

	} 
?>