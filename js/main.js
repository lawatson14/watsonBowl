// ======= Scripts on page load ======
$(document).ready(function(){
	// ====== SCRIPTS ON PAGE LOAD ======
	if ("serviceWorker" in navigator){
		navigator.serviceWorker.register("serviceWorker.js").then(registration => {
			console.log("Service Worker Registered");
			console.log(registration);	
		}).catch(error => {
			console.log("Service Worker registration failed!");
			console.log(error);
		});
	} else {
		console("Browser does not support application");
	}

	let league_id = 1;
	let week_id = getActiveWeek();
	if (week_id == null){
		week_id = 18;
	}
	let season_id = getSeason();

	getUser(user_id);
	if (week_id == 18){
		getWeeks(17);
		getUserSelections(user_id, season_id, 17);
	} else {
		getWeeks(week_id);
		getUserSelections(user_id, season_id, week_id);
	}	
	getStandings(league_id);
	getHistory(league_id);
	// ====== SCRIPTS ON PAGE LOAD END ======
	
	// ====== MENU ======
	$("#menu-btn").click(function(){
		$("#main-nav-toggler").toggleClass("d-none");
		$("#menu-btn i").toggleClass("fa-bars fa-times");
	});
	$("#main-nav li").click(function(){
		$("#main-nav-toggler").toggleClass("d-none");
		$("#menu-btn i").toggleClass("fa-bars fa-times");
	});
	// ====== MENU END ======


	// ====== LOGOUT ======
	$(".logout-btn").click(function(){
		window.location.href = "https://leealexanderwatson.co.uk/demo/watson_bowl/logout.php";
	});
	// ====== LOGOUT End ======


	// ====== USER MODAL ======
	// Show user modal on click
	$(".user-btn").click(function(){
		//Ensure form reset incase user changes styles
		$("#user-alert").hide();
		$(`#user-form .form-control`).prop("disabled", true);
		$(`#pwd-form .form-control`).prop("disabled", true);
		$("#user-submit").hide();
		$("#user-cancel").hide();
		$("#user-edit").show();
		$("#pwd-form-btn").removeClass("d-none").addClass("d-none");
		$("#pwd-form").removeClass("show");

		$("#user-modal").modal("show");
	});

	// Edit user modal
	$("#user-edit").click(function(){
		resetForm("user");
		$("#user-alert").hide();

		$(`#user-form .form-control`).prop("disabled", false);
		$("#user-submit").show();
		$("#user-cancel").show();
		$("#user-edit").hide();
		$("#pwd-form-btn").toggleClass("d-none");
	});

	// Cancel user modal
	$("#user-cancel").click(function(){
		resetForm("user");
		$("#user-alert").hide();
		getUser(user_id);

		$(`#user-form .form-control`).prop("disabled", true);
		$(`#pwd-form .form-control`).prop("disabled", true);
		$("#user-submit").hide();
		$("#user-cancel").hide();
		$("#user-edit").show();
		$("#pwd-form-btn").removeClass("d-none").addClass("d-none");
		$("#pwd-form").removeClass("show");
	});

	$("#pwd-form-btn").click(function(){
		$(`#pwd-form .form-control`).prop("disabled", false);
	});

	// Toggle password view
	$("#user-pwd-icon").click(function(){
		togglePassword("user-pwd");
	});
	$("#user-current-icon").click(function(){
		togglePassword("user-current");
	});
	

	// Submit user modal
	$("#user-submit").click(function(){

		validateForm2("user");

		if ( $("#pwd-form").hasClass("show")){
			validateForm("pwd");
		}
		
		let errors = $("#user-form .form-error").length;

		if (errors == 0){

			$(`#user-form .form-control`).prop("disabled", true);
			$(`#pwd-form .form-control`).prop("disabled", true);
			$("#user-submit").hide();
			$("#user-cancel").hide();
			$("#user-edit").show();
			$("#pwd-form-btn").removeClass("d-none").addClass("d-none");
			$("#pwd-form").removeClass("show");

			displayAlert("user-alert", {"status": 300, "message": "<strong>Feature Disabled! </strong> This functional is disabled on demo site."});

		}
	});
	// ====== USER MODAL END ======



	// ====== SELECTION SCRIPTS ======
	// Selections on week change
	$("#week").change(function(){
		let week = $(this).val();
		getUserSelections(user_id, season_id, week);

		if (parseInt(week) < parseInt(week_id)){
			$("#submit-all-btn").hide();
			$("#report-btn").show();
		} else {
			$("#submit-all-btn").show();
			$("#report-btn").hide();
		}
	});

	// Get league selections
	$(document).on("click", ".league-selection-btn", function(){
		let fixture_id = $(this).siblings().closest('.fixture-id').html();
		getLeagueSelections(user_id, league_id, fixture_id);

		$("#league-selections-timestamp").html( getNow() );
		$("#league-selections-modal").modal("show");

	});

	// Submit fixture selection
	$(document).on("click", ".selection-submit-btn", function(){
		let fixture_id = $(this).siblings().closest('.fixture-id').html();
		let week = $("#week").val();
		
		let selection = {
			"user_id": user_id,
			"season_id": season_id,
			"week_id": week,
			"fixture_id": fixture_id,
			"winner_id": $(`#winner-selection-${fixture_id}`).val(),
			"outcome_id": $(`#outcome-selection-${fixture_id}`).val(),
		}

		editUserSelection(selection);

	});

	// Submit all fixture selections
	$("#submit-all-btn").click(function(){
		fixture_ids = $('.fixture-id');
		let week = $("#week").val();

		selection = {
			"user_id": user_id,
			"season_id": season_id,
			"week_id": week,
			"fixtures": {

			},
		}

		for (let i = 0; i < fixture_ids.length; i++){
			let fixture_id = fixture_ids[i].innerHTML;

			if ($(`#winner-selection-${fixture_id}`).val() != ""){
				selection.fixtures[i] = {
					"fixture_id": fixture_id,
					"winner_id": $(`#winner-selection-${fixture_id}`).val(),
					"outcome_id": $(`#outcome-selection-${fixture_id}`).val(),
				}	
			}

		}

		editAllUserSelections(selection);

	});

	// ====== SELECTION SCRIPTS END ======


	// ====== WEEKLY REPORT ======
	$("#report-btn").click(function(){
		let week = $("#week").val();
		getWeeklyStandings(league_id, week);
		getLeagueUsers(league_id, season_id, week);

		$("#report-modal").modal("show");
	});

	$("#weekly-users").change(function(){
		let week = $("#week").val();
		let user = $("#weekly-users").val();
		getLeagueUserSelections(user, season_id, week);
	});
	// ====== WEEKLY REPORT END ======

	
});