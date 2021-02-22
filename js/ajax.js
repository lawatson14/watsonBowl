// ====== READ SCRIPTS ======

// ====== BASIC LEAGUE SCRIPTS ======
function getUser(user_id){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/getUser.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"user_id": user_id,
		},
		success: function(results){
			displayUser(results.data[0]);
		}, error: function(){
			console.log("Error occured getting user!");
		}
	});
}

function getSeason(){
	let season;
	
	$.ajax({
		"async": false,
		"global": false,
		"url": "php/getSeason.php",
		"dataType": "json",
		success: function(results){
			season = results.data[0].season;
		}, error: function(){
			console.log("Error occured getting season!");
		}
	});
	return season;
}

function getActiveWeek(){
	let week;

	$.ajax({
		"async": false,
		"global": false,
		"url": "php/getActiveWeek.php",
		"dataType": "json",
		success: function(results){
			week = results.data[0].week;
		}, error: function(){
			console.log("Error occured getting active week!");
		}
	});

	return week;
}

function getWeeks(week_id){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/getWeeks.php",
		"dataType": "json",
		success: function(results){
			displayWeeks(results.data, week_id);
		}, error: function(){
			console.log("Error occured getting user!");
		}
	});
}
// ====== BASIC SCRIPTS END ======



// ====== SELECTION SCRIPTS ======
function getUserSelections(user_id, season, week){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/getUserSelections.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"user_id": user_id,
			"season": season,
			"week": week,
		},
		success: function(results){
			displayUserSelections(results.data);
		}, error: function(){
			console.log("Error occured getting selections!");
		}
	});
}

function getLeagueSelections(user_id, league_id, fixture_id){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/getLeagueSelections.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"user_id": user_id,
			"league_id": league_id,
			"fixture_id": fixture_id,
		},
		success: function(results){
			displayLeagueSelections(results.data);
		}, error: function(){
			console.log("Error occured getting league selections!");
		}
	});
}

function getWeeklyStandings(league_id, week_id){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/getWeeklyStandings.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"league_id": league_id,
			"week_id": week_id,
		},
		success: function(results){
			displayStandings('weekly-standings-table', results.data);
		}, error: function(){
			console.log("Error occured getting league weekly standings!");
		}
	});
}

function getLeagueUsers(league_id, season, week){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/getLeagueUsers.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"league_id": league_id,
		},
		success: function(results){
			displayLeagueUsers(results.data);
			getLeagueUserSelections(results.data[0].user_id, season, week);
		}, error: function(){
			console.log("Error occured getting league users!");
		}
	});
}

function getLeagueUserSelections(user_id, season, week){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/getUserSelections.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"user_id": user_id,
			"season": season,
			"week": week,
		},
		success: function(results){
			displayLeagueUserSelections(results.data);
		}, error: function(){
			console.log("Error occured getting selections!");
		}
	});
}

function getSelectionsConfirmation(user_id, season, week){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/getUserSelections.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"user_id": user_id,
			"season": season,
			"week": week,
		},
		success: function(results){
			displayConfirmationSelections(results.data);

		}, error: function(){
			console.log("Error occured getting selection confirmation!");
		}
	});
}
// ====== SELECTION SCRIPTS END ======



// ====== STANDINGS SCRIPTS ======
function getStandings(league_id){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/getStandings.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"league_id": league_id
		},
		success: function(results){
			displayStandings('standings-table', results.data);
		}, error: function(){
			console.log("Error occured getting standings!");
		}
	});
}
// ====== STANDINGS SCRIPTS END ======



// ====== HISTORY SCRIPTS ======
function getHistory(league_id){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/getHistory.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"league_id": league_id
		},
		success: function(results){
			displayHistory(results.data);
		}, error: function(){
			console.log("Error occured getting league history!");
		}
	});
}
// ====== HISTORY SCRIPTS END ======
// ====== READ SCRIPTS END ======



// ====== EDIT SCRIPTS ======
function editUser(user){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/editUser.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"user": user,
		},
		success: function(results){
			displayAlert("user-alert", results.status);
			getUser(user_id);
		}, error: function(){
			console.log("Error occured editting user!");
		}
	});
}

function editUserSelection(selection){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/editUserSelection.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"selection": selection,
		},
		success: function(results){
			console.log(results);
			getSelectionsConfirmation(selection.user_id, selection.season_id, selection.week_id);
		}, error: function(){
			console.log("Error occured submitting selections!");
		}
	});
}

function editAllUserSelections(selection){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/editAllUserSelections.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"selection": selection,
		},
		success: function(results){
			getSelectionsConfirmation(selection.user_id, selection.season_id, selection.week_id);
		}, error: function(){
			console.log("Error occured submitting all selections!");
		}
	});
}
