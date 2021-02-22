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
	
	$user_id = $_POST['user_id'];
	$league_id = $_POST['league_id'];
	$fixture_id = $_POST['fixture_id'];

	$query = "SELECT u.name, f.status, t.team as selected_winner, o.name as selected_outcome, s.winner_pts, s.outcome_pts, s.total_pts FROM user_leagues l LEFT JOIN selections s on (l.user_id = s.user_id) LEFT JOIN users u on (s.user_id = u.user_id) LEFT JOIN fixtures f ON (s.fixture_id = f.fixture_id) LEFT JOIN teams t ON (s.selected_winner_id = t.team_id) LEFT JOIN outcomes o ON (s.selected_outcome_id = o.outcome_id) WHERE l.league_id = '".$league_id."' AND s.fixture_id = '".$fixture_id."' AND NOT s.user_id = '".$user_id."' ";

	$result = $conn->query($query);
	
	if (!$result) {

		$output['status']['code'] = "400";
		$output['status']['name'] = "executed";
		$output['status']['description'] = "query failed";

		mysqli_close($conn);

		echo json_encode($output); 

		exit;

	}
   
   	$data = [];

	while ($row = mysqli_fetch_assoc($result)) {

		array_push($data, $row);

	}

	$output['status']['code'] = "200";
	$output['status']['name'] = "ok";
	$output['status']['description'] = "success";
	$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
	$output['data'] = $data;
	
	mysqli_close($conn);

	echo json_encode($output); 

?>