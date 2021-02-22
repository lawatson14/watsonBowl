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
		$output['data'] = [];

		mysqli_close($conn);

		echo json_encode($output);

		exit;

	}

	$week_id = 17;
	
	$query = "SELECT `fixture_id`, `away_id`, `away_score`, `home_id`, `home_score` FROM `fixtures` WHERE `week` = '".$week_id."'";

	$result = $conn->query($query);
	
	if (!$result) {

		$output['status']['code'] = "400";
		$output['status']['name'] = "executed";
		$output['status']['description'] = "query failed to get weekly fixtures";

		mysqli_close($conn);

		echo json_encode($output); 

		exit;

	}

	$len = mysqli_num_rows($result);
	
	for ($i=0; $i<$len; $i++){
		$row = mysqli_fetch_array($result);
		$fixture_id = $row['fixture_id'];

		// winning team id
		if ($row['away_score'] > $row['home_score']){
			$winner_id = $row['away_id'];
		} else if ($row['away_score'] < $row['home_score']){
			$winner_id = $row['home_id'];
		}  else {
			$winner_id = 1;
		}

		// outcome id
		if ($row['away_score'] + $row['home_score'] >= 42){
			$outcome_id = 2;
		} else {
			$outcome_id = 3;
		}

		/*
		$data = [
			"fixture_id" => $fixture_id,
			"away_id" => $row['away_id'],
			"away_score" => $row['away_score'],
			"home_score" => $row['home_score'],
			"home_id" => $row['home_id'],
			"winner_id" => $winner_id,
			"outcome_id" => $outcome_id,
		];

		//print_r($data);
		//echo "\n";
		*/

		$query2 = "UPDATE `selections` SET `winner_pts` = CASE WHEN `selected_winner_id` = '".$winner_id."' THEN 2 ELSE 0 END, `outcome_pts` = CASE WHEN `selected_outcome_id` = '".$outcome_id."' AND `selected_winner_id` = '".$winner_id."' THEN 1 ELSE 0 END, `total_pts` = `winner_pts` + `outcome_pts` WHERE `fixture_id` = '".$fixture_id."'";

		$result2 = $conn->query($query2);


	}

?>