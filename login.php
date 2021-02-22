<?php

session_start();

if (isset($_SESSION['user_id'])){
	header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Watson Bowl - v2</title>

	<meta name="author" content="Lee Watson">
	<meta name="description" content="">
	<meta name="keywords" content="">

	<!-- Favicons -->
	<link href="images/favicons/favicon-16x16.png" rel="icon">
	<link href="images/favicons/apple-touch-icon.png" rel="apple-touch-icon">

	<!-- Vendor CSS Files -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

	<style>

		body{
			height: 100vh;
			width: 100vw;
		}

		.container{
			height: 100%;
		}

		#boundary{
			height: 100%;
		}

		#login, #register{
			background: inherit;
			border: none;
			min-width: 50%;
		}
		#register{
			display: none;
		}
	</style>
</head>

<body class="bg-info">
	<div class="container">
		<div id="boundary" class="d-flex flex-column justify-content-center align-items-center">
			<!-- ====== LOGIN FORM ====== -->
			<div id="login" class="card">
				<div class="card-body">
					<div id="login-alert"></div>
					<form id="login-form" class="form" action="" method="post">
						<div class="form-group">
							<label for="login-email" class="text-white">Email:</label>
							<input type="email" id="login-email" class="form-control">
						</div>
						<div class="form-group">
							<label for="login-pwd" class="text-white">Password:</label>
							<div class="input-group mb-3">
								<input type="password" id="login-pwd" class="form-control">
								<div class="input-group-append">
									<span id="login-pwd-icon" class="input-group-text unlock" style="cursor: pointer;"><i class="fas fa-eye"></i></span>
								</div>
							</div>
						</div>
						<a href="#" id="login-forgotten" class="text-white" style="display: block; margin-bottom: 1rem;">Forgot Password?</a>
						<div class="d-flex justify-content-between">
							<button type="button" id="login-submit" class="btn btn-success flex-fill mr-3">Login</button>
							<button type="button" id="login-register" class="btn btn-primary flex-fill">Register</button>
						</div>
					</form>
				</div>
			</div>
			<!-- ====== LOGIN FORM END ====== -->

			<!-- ======= REGISTER FORM ====== -->
			<div id="register" class="card">
				<div class="card-header">
					<h6 class="text-info">Register</h6>
				</div>
				<div class="card-body">
					<div id="register-alert"></div>
					<form id="register-form" class="form">
						<div class="form-group">
							<label for="register-name" class="text-info">Name:</label>
							<input type="text" id="register-name" class="form-control">
						</div>
						<div class="form-group">
							<label for="register-email" class="text-info">Email:</label>
							<input type="email" id="register-email" class="form-control">
						</div>
						<div class="form-group">
							<label for="register-pwd" class="text-info">Password:</label>
							<div class="input-group mb-3">
								<input type="password" id="register-pwd" class="form-control">
								<div class="input-group-append">
									<span id="register-pwd-icon" class="input-group-text unlock" style="cursor: pointer;"><i class="fas fa-eye"></i></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="register-confirm" class="text-info">Confirm Password:</label>
							<div class="input-group mb-3">
								<input type="password" id="register-confirm" class="form-control">
								<div class="input-group-append">
									<span id="register-confirm-icon" class="input-group-text unlock" style="cursor: pointer;"><i class="fas fa-eye"></i></span>
								</div>
							</div>
						</div>
						<ul>
							<li>Password must be at least 6 characters</li>
							<li>Password must include at least 1 uppercase</li>
							<li>Password must be at least 1 lowecase</li>
							<li>Password must be at least 1 number</li>
						</ul>
						<div class="d-flex justify-content-between">
							<button type="button" id="register-submit" class="btn btn-success flex-fill mr-3">Submit</button>
							<button type="button" id="register-cancel" class="btn btn-danger flex-fill">Cancel</button>
						</div>
					</form>
				</div>
			</div>
			<!-- ======= REGISTER FORM END ======= -->

		</div>
	</div>

	<!-- Vendor JS Files -->
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

	<!-- Custom Scripts -->
	<script type="text/javascript" src="js/login.js"></script>

</body>