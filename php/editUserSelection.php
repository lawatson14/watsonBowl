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

	$user_id = validate_input($_POST['selection']['user_id']);
	$fixture_id = validate_input($_POST['selection']['fixture_id']);
	$winner_id = validate_input($_POST['selection']['winner_id']);
	$outcome_id = validate_input($_POST['selection']['outcome_id']);

	$query = "SELECT `status` FROM `fixtures` WHERE `fixture_id` = '".$fixture_id."' ";
	$result = $conn->query($query);

	$row = mysqli_fetch_assoc($result);

	if ($row['status'] != 'scheduled' ){

		$output['status']['status'] = "300";
		$output['status']['name'] = "failure";
		$output['status']['description'] = "data unchangeable";
		$output['status']['message'] = "<strong>Submission failed! Selection locked due to game status.</strong>";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";

		mysqli_close($conn);

		echo json_encode($output);

		exit;

	}

	$query = "UPDATE `selections` SET `selected_winner_id` = '".$winner_id."', `selected_outcome_id` = '".$outcome_id."' WHERE `fixture_id` = '".$fixture_id."' AND `user_id` = '".$user_id."'";

	$result = $conn->query($query);
	
	if (!$result) {

		$output['status']['status'] = "400";
		$output['status']['name'] = "executed";
		$output['status']['description'] = "query failed";
		$output['data'] = [];

		mysqli_close($conn);

		echo json_encode($output); 

		exit;

	}

	$output['status']['status'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['message'] = "<strong>Submission successful! </strong>";
	$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
	
	mysqli_close($conn);

	echo json_encode($output); 

?>