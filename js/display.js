// ====== BASIC DISPLAYS ======
function displayAlert(alertId, alertObj){
	if( alertObj.status != 200){
		$(`#${alertId}`).addClass("alert-danger").html(alertObj.message);
	} else {
		$(`#${alertId}`).addClass("alert-success").html(alertObj.message);
	}
	$(`#${alertId}`).show();
}

function getNow(){
	let now = new Date();
	const month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	let hours = now.getHours();
	if (parseInt(hours) < 10){
		hours = '0' + hours;
	}
	let minutes = now.getMinutes();
	if (parseInt(minutes) < 10){
		minutes = '0' + minutes;
	}
	let date =  `${now.getDate()} ${month[now.getMonth()]} ${now.getFullYear()} ${hours}:${minutes}`;
	return date;
}
// ====== BASIC DISPLAYS END ======



function displayUser(obj){
	$("#user-email").val(obj.email);
	$("#user-name").val(obj.name);
}

function displayWeeks(obj, selected){
	content = "";

	for (const [key, value] of Object.entries(obj)) {
		if (parseInt(value.week_id) == selected){
			content += `<option value="${value.week_id}" selected>${value.week}</option>`;	
		} else {
			content += `<option value="${value.week_id}">${value.week}</option>`;
		}
	}
	$(".weeks").html(content);
}

function displayLeagueUsers(obj){
	content = "";

	for (const [key, value] of Object.entries(obj)) {
		content += `<option value="${value.user_id}">${value.name}</option>`;	
	}
	$("#weekly-users").html(content);

}


function displayPts(obj){
	let content = "";

	if(obj.status == "final"){
		if (parseInt(obj.total_pts) > 0){
			content += `<div class="badge badge-success">${obj.total_pts} Pts</div>`;
		} else {
			content += `<div class="badge badge-secondary">${obj.total_pts} Pts</div>`;
		}
	}

	return content;

}

function displayStatus(status){
	let content = "";

	if (status == "in-play"){
		content += `<span class="badge badge-success">${status}</span>`;
	} else if (status == "scheduled"){
		content += `<span class="badge badge-info">${status}</span>`;
	} else {
		content += `<span class="badge badge-danger">${status}</span>`;
	}

	return content;
}

function displayLeagueSelections(obj){
	let content = "";

	for (const [key, value] of Object.entries(obj)) {
		if (value.status == "in-play"){
			content += `
				<tr>
					<td>${value.name}</td>
					<td> ${value.selected_winner}</td>
					<td>${value.selected_outcome}</td>
					<td><span class="badge badge-success">in-play</span></td>
				</tr>`;
		} else {
			if( value.total_pts > 0){
				content += `
					<tr>
						<td>${value.name}</td>
						<td> ${value.selected_winner}</td>
						<td>${value.selected_outcome}</td>
						<td><span class="badge badge-success">${value.total_pts} pts</span></td>
					</tr>`;	
			} else {
				content += `
					<tr>
						<td>${value.name}</td>
						<td> ${value.selected_winner}</td>
						<td>${value.selected_outcome}</td>
						<td><span class="badge badge-secondary">${value.total_pts} pts</span></td>
					</tr>`;
			}
			
		}
	}
	$("#league-selections-table tbody").html(content);
}

function displayLeagueUserSelections(obj){
	let content = "";

	for (const [key, value] of Object.entries(obj)) {
		content += `
			<tr>
				<td> ${value.selected_winner}</td>
				<td>${value.selected_outcome}</td>
				<td><span class="badge ${(value.total_pts > 0) ? "badge-success" : "badge-secondary"}">${value.total_pts} Pts</span></td>
			</tr>`;
	}

	$("#weekly-selections-table tbody").html(content);

}

// ====== MODAL SCRIPTS ======

// Confirmation Modal
function displayConfirmationSelections(obj){
	let content = "";

	for (const [key, value] of Object.entries(obj)) {
		content += `
			<tr>
				<td>${value.away_team} @ ${value.home_team}</td>
				<td> ${value.selected_winner}</td>
				<td>${value.selected_outcome}</td>
			</tr>`;
	}

	$("#selection-confirmation-table tbody").html(content);
	$("#selections-confirmation-timestamp").html( getNow() );
	$("#selections-confirmation-modal").modal("show");
}
// Confirmation Modal End
// ====== MODAL SCRIPTS ======



// ====== STANDINGS SCRIPTS ======
function displayStandings(id, obj){
	let content = "";
	for ( let i = 0; i < obj.length; i++){
		content += `
			<tr>
				<td>${i + 1}</td>
				<td> ${obj[i].name}</td>
				<td>${obj[i].winner_pts}</td>
				<td>${obj[i].outcome_pts}</td>
				<td>${obj[i].total_pts}</td>
			</tr>`;
	}

	$(`#${id} tbody`).html(content);
}
// ====== STANDINGS SCRIPTS END ======



// ====== HISTORY SCRIPTS ======
function displayHistory(obj){
	let content = "";
	for (const [key, value] of Object.entries(obj)) {
		content += `
			<tr>
				<td>${value.year}</td>
				<td>${value.winner}</td>
				<td>${value.pts}</td>
			</tr>`;
	}

	$("#history-table tbody").html(content);
}
// ====== HISTORY SCRIPTS END ======













// ======= NEW TESTING SCRIPTS 

function displaySelectedWinner(obj){
	let content = "";

	if (obj.selected_winner == obj.home_team){
		content += `
			<option value="${obj.home_id}" selected>${obj.home_team}</option>
			<option value="${obj.away_id}">${obj.away_team}</option>`;
	} else if (obj.selected_winner == obj.away_team){
		content += `
			<option value="${obj.home_id}">${obj.home_team}</option>
			<option value="${obj.away_id}" selected>${obj.away_team}</option>`;
	} else {
		content += `
			<option selected hidden value="">Winner</option>
			<option value="${obj.home_id}">${obj.home_team}</option>
			<option value="${obj.away_id}">${obj.away_team}</option>`;
	}

	return content;
}

function displaySelectedOutcome(obj){
	let content = "";

	if (obj.selected_outcome == "Over"){
		content += `
			<option value="2" selected>${obj.selected_outcome}</option>
			<option value="3">Under</option>`;
	} else if (obj.selected_outcome == "Under"){
		content += `
			<option value="2">Over</option>
			<option value="3" selected>${obj.selected_outcome}</option>`;
	} else {
		content += `
			<option selected hidden value="">Outcome</option>
			<option value="2">Over</option>
			<option value="3">Under</option>`;
	}

	return content;
}

function displayUserSelections(obj){
	let content = '';

	for (const [key, value] of Object.entries(obj)) {
		if ( value.status == "scheduled"){
			content += `
			<div class="card mt-3">
				<div class="card-header d-flex justify-content-between">
					<h6 class="text-wrap mr-3">${value.stadium}</h6>
					<h6 class="text-right">${value.ko}</h6>
				</div>
				
				<div class="card-body">
					<div class="d-flex justify-content-around">

						<div class="text-center align-self-center mr-2">
							<picture>
								<source media="(max-width: 758px)" srcset="${value.away_logo}" height="25px" width="auto">
								<img src="${value.away_logo}" height="50px" width="auto">
							</picture>
							<h6 class="mt-2 d-none d-md-block">${value.away_team}</h6>
							<h6 class="mt-2 d-md-none">${value.away_abv}</h6>
						</div>

						<form>
							<div class="form-row">
								<div class="form-group col-6">
									<input type="number" class="form-control text-center" disabled value="${value.away_score}">
								</div>
								<div class="form-group col-6">
									<input type="number" class="form-control text-center" disabled value="${value.home_score}">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-12 col-md-6">
									<select id="winner-selection-${value.fixture_id}" class="form-control">${displaySelectedWinner(value)}</select>
								</div>
								<div class="form-group col-12 col-md-6">
									<select id="outcome-selection-${value.fixture_id}" class="form-control">${displaySelectedOutcome(value)}</select>
								</div>
							</div>
						</form>

						<div class="text-center align-self-center ml-2">
							<picture>
								<source media="(max-width: 758px)" srcset="${value.home_logo}" height="25px" width="auto">
								<img src="${value.home_logo}" height="50px" width="auto">
							</picture>
							<h6 class="mt-2 d-none d-md-block">${value.home_team}</h6>
							<h6 class="mt-2 d-md-none">${value.home_abv}</h6>
						</div>
					</div>
				</div>

				<div class="card-footer d-flex justify-content-between">
					<span class="d-none fixture-id">${value.fixture_id}</span>
					<div> ${displayStatus(value.status)}</span></div>
					<button type="button" class="btn btn-info selection-submit-btn">Submit</button>
				</div>

			</div>
			`;
		} else if (value.status == "in-play"){
			content += `
			<div class="card mt-3">
				<div class="card-header d-flex justify-content-between">
					<h6 class="text-wrap mr-3">${value.stadium}</h6>
					<h6 class="text-right">${value.ko}</h6>
				</div>
				
				<div class="card-body">
					<div class="d-flex justify-content-around">

						<div class="text-center align-self-center mr-2">
							<picture>
								<source media="(max-width: 758px)" srcset="${value.away_logo}" height="25px" width="auto">
								<img src="${value.away_logo}" height="50px" width="auto">
							</picture>
							<h6 class="mt-2 d-none d-md-block">${value.away_team}</h6>
							<h6 class="mt-2 d-md-none">${value.away_abv}</h6>
						</div>

						<form>
							<div class="form-row">
								<div class="form-group col-6">
									<input type="number" class="form-control text-center" disabled value="${value.away_score}">
								</div>
								<div class="form-group col-6">
									<input type="number" class="form-control text-center" disabled value="${value.home_score}">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-12 col-md-6">
									<select id="winner-selection-${value.fixture_id}" class="form-control" disabled>${displaySelectedWinner(value)}</select>
								</div>
								<div class="form-group col-12 col-md-6">
									<select id="outcome-selection-${value.fixture_id}" class="form-control" disabled>${displaySelectedOutcome(value)}</select>
								</div>
							</div>
						</form>

						<div class="text-center align-self-center ml-2">
							<picture>
								<source media="(max-width: 758px)" srcset="${value.home_logo}" height="25px" width="auto">
								<img src="${value.home_logo}" height="50px" width="auto">
							</picture>
							<h6 class="mt-2 d-none d-md-block">${value.home_team}</h6>
							<h6 class="mt-2 d-md-none">${value.home_abv}</h6>
						</div>
					</div>
				</div>

				<div class="card-footer d-flex justify-content-between">
					<span class="d-none fixture-id">${value.fixture_id}</span>
					<div> ${displayStatus(value.status)}</span></div>
					<button type="button" class="btn btn-info league-selection-btn">League Selections</button>
				</div>

			</div>
			`;
		} else if (value.status == "final") {
			content += `
			<div class="card mt-3">
				<div class="card-header d-flex justify-content-between">
					<h6 class="text-wrap mr-3">${value.stadium}</h6>
					<h6 class="text-right">${value.ko}</h6>
				</div>
				
				<div class="card-body">
					<div class="d-flex justify-content-around">

						<div class="text-center align-self-center mr-2">
							<picture>
								<source media="(max-width: 758px)" srcset="${value.away_logo}" height="25px" width="auto">
								<img src="${value.away_logo}" height="50px" width="auto">
							</picture>
							<h6 class="mt-2 d-none d-md-block">${value.away_team}</h6>
							<h6 class="mt-2 d-md-none">${value.away_abv}</h6>
						</div>

						<form>
							<div class="form-row">
								<div class="form-group col-6">
									<input type="number" class="form-control text-center" disabled value="${value.away_score}">
								</div>
								<div class="form-group col-6">
									<input type="number" class="form-control text-center" disabled value="${value.home_score}">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-12 col-md-6">
									<select id="winner-selection-${value.fixture_id}" class="form-control" disabled>${displaySelectedWinner(value)}</select>
								</div>
								<div class="form-group col-12 col-md-6">
									<select id="outcome-selection-${value.fixture_id}" class="form-control" disabled>${displaySelectedOutcome(value)}</select>
								</div>
							</div>
						</form>

						<div class="text-center align-self-center ml-2">
							<picture>
								<source media="(max-width: 758px)" srcset="${value.home_logo}" height="25px" width="auto">
								<img src="${value.home_logo}" height="50px" width="auto">
							</picture>
							<h6 class="mt-2 d-none d-md-block">${value.home_team}</h6>
							<h6 class="mt-2 d-md-none">${value.home_abv}</h6>
						</div>
					</div>
					<div class="text-center">
						${displayPts(value)}
					</div>
				</div>

				<div class="card-footer d-flex justify-content-between">
					<span class="d-none fixture-id">${value.fixture_id}</span>
					<div> ${displayStatus(value.status)}</span></div>
					<button type="button" class="btn btn-info league-selection-btn">League Selections</button>
				</div>

			</div>
			`;
		}
	}
	$("#selections .card-body").html(content);
}

