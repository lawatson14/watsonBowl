// ====== Form Scripts ======
function resetForm(id){
	
	// Removes input response html & border.
	$(`#${id}-form .form-error`).remove();
	$(`#${id}-form .form-control`).removeClass("border-danger");
	
	// Removes form alert
	$(`#${id}-alert`).removeClass("alert-danger alert-success").html("");
}

function clearForm(id){
	$(`#${id}-form .form-control`).val("");
}


function validateForm(id){
	resetForm(id);
	let inputs = $(`#${id}-form .form-required`);
	let error = 0;

	// Checks if each required input is not blank
	for(let i = 0; i < inputs.length; i++){
		if(inputs[i].value == ""){
			$(`#${inputs[i].id}`).addClass("border-danger").parent().siblings().append('<span class="text-danger form-error"> Field is required</span>');
			error += 1;
		}
	}

	// if more than 0 errors displays form alert 
	if (error > 0){
		displayAlert(`${id}-alert`, {"status": 400, "message": "Form Invalid!"});
	}
}
// If input has a border icon group
function validateForm2(id){
	resetForm(id);
	let inputs = $(`#${id}-form .form-required`);
	let error = 0;

	// Checks if each required input is not blank
	for(let i = 0; i < inputs.length; i++){
		if(inputs[i].value == ""){
			$(`#${inputs[i].id}`).addClass("border-danger").siblings().append('<span class="text-danger form-error"> Field is required</span>');
			error += 1;
		}
	}

	// if more than 0 errors displays form alert 
	if (error > 0){
		displayAlert(`${id}-alert`, {"status": 400, "message": "Form Invalid!"});
	}
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