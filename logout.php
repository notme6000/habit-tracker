<?php
require_once("codelibrary/inc/variables.php");
require_once("codelibrary/inc/functions.php");
unset($_SESSION['sess_admin_id']);
unset($_SESSION['sess_username']);
unset($_SESSION['sess_accessLevel']);
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Logout</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/login.css" />
</head>

<body>

	<!-- logout start -->

	<div class="login">

		<!-- logo start -->
		<div class="logo" style="text-align:center;"><h2>Personal Management System</h2></div>
		<!-- logo end -->

		<!-- text start -->
		<div class="logout">

			Logged out. <a href="../" style="font-weight: bold;">Click here</a> to go to directory home.<br /><br />

<a href="index.php" style="font-weight: bold;">Click here</a> to go to directory admin panel again.<br />

		</div>
		<!-- text end -->

		<!-- copyrights start -->
		<div class="copy">
			<a style="color:white;" href="#"><h2>New User Register Here!</h2></a>
		</div>
		<!-- copyrights end -->

	</div>
	<!-- logout end -->

</body>

</html>