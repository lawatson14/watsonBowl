// ====== DISPLAY SCRIPTS
function displayAlert(id, status, message){
	if( status != 200){
		$(`#${id}-alert`).addClass("alert alert-danger").html(message);
	} else {
		$(`#${id}-alert`).addClass("alert alert-success").html(message);
	}
	$(`#${id}-alert`).show();
}

function resetAlert(id){
	$(`#${id}-alert`).removeClass("alert alert-success alert-danger").html("");
}

function resetForm(id){
	$(`#${id}-form .form-control`).val("");
}

function togglePassword(id){
	let type = $(`#${id}`).attr('type');
	if (type == "password"){
		$(`#${id}`).attr('type', 'text');	
	} else {
		$(`#${id}`).attr('type', 'password');
	}
	$(`#${id}-icon i`).toggleClass("fa-eye fa-eye-slash");
}
// ====== DISPLAY SCRIPTS END ======



// ====== AJAX SCRIPTS =======
function login(obj){
	$.ajax({
		"async": true,
		"global": false,
		"url": "php/login.php",
		"type": "POST",
		"dataType": "json",
		"data": {
			"login": obj,
		},
		success: function(results){
			if(results.status.code != 200){
				$("#login-alert").addClass("alert alert-danger").html(results.status.description);
			} else {
				$("#login-alert").addClass("alert alert-success").html(results.status.description);
				window.location.href = "https://leealexanderwatson.co.uk/demo/watson_bowl/index.php";
			}
		}, error: function(){
			console.log("Error occured during login!");
		}
	});
}
// ====== AJAX SCRIPTS END ======



// ====== USER INTERACTIONS ======
$(document).ready(function(){

	// Login
	$("#login-submit").click(function(){
		$("#login-alert").removeClass("alert alert-success alert-danger").html("");
		
		let user = {
			"email": $("#login-email").val(),
			"pwd": $("#login-pwd").val(),
		}

		if ( user.email == "" ) {
			displayAlert("login", 400, "<strong>Form Invalid! </strong>Email cannot be blank.");
		} else if ( user.pwd == ""){
			displayAlert("login", 400, "<strong>Form Invalid! </strong>Password cannot be blank.");
		} else {
			login(user);
		}		

	});

	// Login Password Toggle
	$("#login-pwd-icon").click(function(){
		togglePassword("login-pwd");
	});


	// ====== DEMO FEATURES ======
	// Register
	$("#login-register").click(function(){
		displayAlert("login", 400, "<strong>Feature Disabled! </strong> This functional is disabled on demo site.");
	});

	// Forgotten Password
	$("#login-forgotten").click(function(){
		displayAlert("login", 400, "<strong>Feature Disabled! </strong> This functional is disabled on demo site.");
	});

	// ====== DEMO FEATURES END ======

});
// ====== USER INTERACTIONS END ======