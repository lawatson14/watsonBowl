<?php

session_start();

if (!isset($_SESSION['user_id'])){
	header("Location: login.php");
} else {
	$user_id = $_SESSION['user_id'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Watson Bowl</title>

	<meta name="author" content="Lee Watson">
	<meta name="description" content="">
	<meta name="keywords" content="">

	<!-- Favicons -->
	<link rel="icon" href="images/favicons/favicon-16x16.png">
	<link rel="apple-touch-icon" href="images/favicons/apple-touch-icon.png">
	
	<!-- PWA Info -->
	<link rel="manifest" href="manifest.json">
	<meta name="theme-color" content="#17a2b8">
	

	<!-- Vendor CSS Files -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

	<!-- Template Main CSS File -->
	<link rel="stylesheet" href="css/stylesheet.css">
</head>
<body>

	<!-- ====== Nav Bar ====== navbar-expand-lg -->
	<header class="navbar navbar-dark bg-info justify-space-around">
		
		<!-- Responsive Button -->
		<button type="button" id="menu-btn" class="btn btn-info text-white d-block d-md-none" title="menu">
			<i class="fas fa-bars"></i>
		</button>
		<!-- Responsive Button End -->
		<a href="" class="navbar-brand d-none d-md-inline-block">Watson Bowl</a>

		<!-- Nav Links -->
		<nav id="main-nav-toggler" class="d-none d-md-block bg-info">
			
			
			<h5 class="d-md-none text-center text-white">Watson Bowl</h6>
			<div class="d-md-none text-center">
				<!--<img src="images/logo.jpg" height="auto" width="40%" alt="Watson Bowl" style="border-radius: 500px;">-->	
			</div>

			
			<ul id="main-nav" class="nav d-flex flex-column text-center flex-md-row justify-content-around justify-content-md-start" role="tablist">
				<li class="nav-item text-center">
					<a href="#selections" id="selections-tab" class="nav-link active" data-toggle="tab" role="tab" aria-controls="selections" aria-selected="true">Selections</a>
				</li>
				<li class="nav-item">
					<a href="#standings" id="standings-tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="standings" aria-selected="false">Standings</a>
				</li>
				<li class="nav-item">
					<a href="#history" id="history-tab" class="nav-link" data-toggle="tab" role="tab" aria-controls="history" aria-selected="false">History</a>
				</li>
			</ul>

			<footer class="text-white text-center d-md-none p-3">
				<p>Copyright <strong>Watson Bowl</strong>. All rights reserved</p>
				<p>Designed by <strong><a href="https://leealexanderwatson.co.uk">Lee Watson</a></strong></p>
			</footer>
		</nav>
		<!-- Nav Links End -->

		<!-- User Actions (Desktop View) class="d-none d-md-inline-block" -->
		<div>
			<button class="btn btn-info text-white user-btn" title="user account"><i class="fas fa-user"></i></button>
			<button class="btn btn-info text-white logout-btn" title="logout"><i class="fas fa-sign-out-alt"></i></button>
		</div>
		<!-- User Actions (Desktop View) End -->

	</header>
	<!--Header End -->

	<main class="container py-3">

		<!-- ====== Tab Panels ====== -->
		<div class="tab-content" id="myTabContent">

			<!-- ====== Selections Tab Panel ====== -->
			<section id="selections" class="tab-pane fade show active" role="tabpanel" aria-labelledby="selections-tab">
				<div class="card">
					<div class="card-header d-flex justify-content-between bg-info text-white">
						<h5 class="mr-3">Selections</h5>

						<!-- Week Select -->
						<form>
							<select id="week" class="form-control weeks m-0 text-wrap"></select>	
						</form>
						<!-- Week Select End -->
					</div>
					<div class="tab-body card-body pt-0"></div>
					<div class="card-footer d-flex justify-content-between">
						<button type="button" id="submit-all-btn" class="btn btn-info" style="display: none;">Submit All</button>
						<button type="button" id="report-btn" class="btn btn-info" >Weekly Report</button>
					</div>
				</div>
			</section>
			<!-- Selections Tab End -->


			<!-- ====== Standings Panel Tab ====== -->
			<section id="standings" class="card tab-pane fade" role="tabpanel" aria-labelledby="standings-tab">
				<div class="card-header d-flex justify-content-between bg-info text-white">
					<h5 class="">Standings</h5>
				</div>
				<div class="tab-body card-body">
					<table id="standings-table" class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="id" scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Winner Pts</th>
								<th scope="col">Outcome Pts</th>
								<th scope="col">Total Pts</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="card-footer d-flex justify-content-between">
					<small class="text-muted updated">Pts = Points</small>
				</div>
			</section>
			<!-- Personnel Tab Panel End -->

			<!-- ====== History Tab Panel ====== -->
			<section id="history" class="card tab-pane fade" role="tabpanel" aria-labelledby="history-tab">
				<div class="card-header d-flex justify-content-between bg-info text-white">
					<h5 class="">History</h5>
				</div>
				<div class="tab-body card-body">
					<table id="history-table" class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Year</th>
								<th>Winner</th>
								<th>Pts</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="card-footer d-flex justify-content-between">
					<small class="text-muted updated">Pts = Points</small>
				</div>
			</section>
			<!-- History Tab Panel End -->

		</div>
		<!-- Tabs Panels End -->
	</main>





	<!-- ====== MODALS SECTION ====== -->
	<!-- ====== User Modal ====== -->
	<div id="user-modal" class="modal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-info text-white">
					<h5 class="modal-title">User Account</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					
					<!-- ====== User Modal Alert ====== -->
					<div id="user-alert" class="alert" role="alert"></div>
					<!-- User Modal Alert End -->

					<form id="user-form" class="locked">
						<div class="form-group">
							<label for="user-name" class="text-info">Name</label>
							<input type="text" id="user-name" class="form-control form-required" placeholder="Name for app" aria-label="Name" aria-describedby="addon3" disabled>
						</div>
						<div class="form-group">
							<label for="user-email" class="text-info">Email</label>
							<input type="text" id="user-email" class="form-control form-required" placeholder="Email" aria-label="Email" aria-describedby="addon1" disabled>
						</div>
					</form>

					<!-- Collapse Password Button -->
					<button type="button" id="pwd-form-btn" class="d-none btn btn-info" data-toggle="collapse" data-target="#pwd-form" aria-expanded="false" aria-controls="pwd-form">Change Password</button>
					<!-- Collapse Password Button End -->

					<!-- Collapsable Password Form -->
					<form id="pwd-form" class="collapse mt-3">
						<div id="user-pwd-input" class="form-group">
							<label for="user-pwd" class="text-info">New Password</label>
							<div class="input-group mb-3">
								<input type="password" id="user-pwd" class="form-control form-required" placeholder="Password" disabled>
								<div class="input-group-append">
									<span id="user-pwd-icon" class="input-group-text unlock" style="cursor: pointer;"><i class="fas fa-eye"></i></span>
								</div>
							</div>
						</div>
						<div id="user-current-input" class="form-group">
							<label for="user-current" class="text-info">Current Password</label>
							<div class="input-group mb-3">
								<input type="password" id="user-current" class="form-control form-required" placeholder="Current Password" disabled>
								<div class="input-group-append">
									<span id="user-current-icon" class="input-group-text unlock" style="cursor: pointer;"><i class="fas fa-eye"></i></span>
								</div>
							</div>
						</div>
					</form>
					<!-- Collapseable Pwd Form End -->
				</div>
				<div class="modal-footer">
					<button id="user-edit" class="btn btn-info">Edit</button>
					<button id="user-submit" class="btn btn-success" style="display: none;">Submit</button>
					<button id="user-cancel" class="btn btn-danger" style="display: none;">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<!-- User Modal End -->

	<!-- ====== Selection Confirmation Modal ====== -->
	<div id="selections-confirmation-modal" class="modal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-info text-white">
					<h5 class="modal-title">Selection Confirmation</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table id="selection-confirmation-table" class="table table-striped">
						<thead>
							<tr>
								<th>Fixture</th>
								<th>Winner</th>
								<th>Outcome</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

				</div>
				<div class="modal-footer d-flex justify-content-between">
					<span class="text-muted">Selections as at <span id="selections-confirmation-timestamp"></span></span>
				</div>
			</div>
		</div>
	</div>
	<!-- Selection Confirmtation Modal End -->

	<!-- ====== League Selections Modal ====== -->
	<div id="league-selections-modal" class="modal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-info text-white">
					<h5 class="modal-title">League Selections</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table id="league-selections-table" class="table table-striped">
						<thead>
							<tr>
								<th>User</th>
								<th>Winner</th>
								<th>Outcome</th>
								<th>Pts</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer d-flex justify-content-between">
					<span class="text-muted">Selections as at <span id="league-selections-timestamp"></span></span>
					<span class="text-muted text-right">Pts = Points</span>
				</div>
			</div>
		</div>
	</div>
	<!-- League Selections Modal End -->

	<!-- ====== Weekly Report Modal ====== -->
	<div id="report-modal" class="modal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-info text-white">
					<h5 class="modal-title">Weekly Report</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<ul class="nav nav-tabs text-center" role="tablist">
						<li class="nav-item flex-fill" roe="presentation">
							<a href="#weekly-standings" id="weekly-standings-tab" class="nav-link active" data-toggle="tab" role="tab" aria-controlls="weekly-standings" aria-selected="true">Weekly Standings</a>
						</li>
						<li class="nav-item flex-fill" roe="presentation">
							<a href="#report-selections" id="report-selections-tab" class="nav-link" data-toggle="tab" role="tab" aria-controlls="report-selections" aria-selected="false">League Selections</a>
						</li>
					</ul>

					<div class="tab-content mt-3">
						
						<!-- Weekly Standings -->
						<div id="weekly-standings" class="tab-pane fade show active" role="tabpanel" aria-labelledby="weekly-standings-tab">
							<table id="weekly-standings-table" class="table table-striped">
								<thead>
									<tr>
										<th class="id" scope="col">#</th>
										<th scope="col">Name</th>
										<th scope="col">Winner Pts</th>
										<th scope="col">Outcome Pts</th>
										<th scope="col">Total Pts</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<!-- Weekly Standings End -->

						<!-- Weekly Selections -->
						<div id="report-selections" class="tab-pane fade" role="tabpanel" aria-labelledby="report-selections-tab">
							<form>
								<select id="weekly-users" class="form-control"></select>
							</form>
							<table id="weekly-selections-table" class="table table-striped">
								<thead>
									<tr>
										<th>Winner</th>
										<th>Outcome</th>
										<th>Pts</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<!-- Weekly Selections End -->
					
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-between">
					<span class="text-muted text-right">Pts = Points</span>
				</div>
			</div>
		</div>
	</div>
	<!-- Weekly Report Modal End -->
	<!-- ====== MODALS SECTION END ====== -->


	<!-- Vendor JS Files -->
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	

	<!-- Custom Scripts -->
	<script type="text/javascript">
		// converting PHP to JS
		const user_id = <?= $user_id ?>;
	</script>
	<script type="text/javascript" src = "js/display.js"></script>
	<script type="text/javascript" src = "js/form.js"></script>
	<script type="text/javascript" src = "js/ajax.js"></script>
	<script type="text/javascript" src = "js/main.js"></script>
</body>
</html>