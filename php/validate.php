<?php

function validate_input($input){
	//Strips excess whitespace
	$input = trim($input);

	//remove backslashes
	$input = stripslashes($input);
	
	//convert html entities to special charactes
	$input = htmlspecialchars($input);
	return $input;
}

?>