<?php
require_once("codelibrary/inc/variables.php");
require_once("codelibrary/inc/functions.php");
/**************/
$ppvisit_ip_address=$_SERVER['REMOTE_ADDR'];
$ppvisit_time=date('Y-m-d H:i:s');
$ppuser_type="ADMIN";
$ppurl=$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
$ppref=$_SERVER['HTTP_REFERER'];
mysqli_query("INSERT visit_data SET visit_time='$ppvisit_time',ip_address='$ppvisit_ip_address',user_type='$ppuser_type',url='$ppurl',refer_from='$ppref'");
/*************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Login To <?=COPY_BY_NAME;?> Admin Panel</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<base href="<?=SITE_URL;?>" />
	<link rel="stylesheet" type="text/css" href="css/login.css" />
</head>

<body>

	<!-- login start -->

	<div class="login">

		<!-- logo start -->
		<div class="logo" style="text-align:center;"><h2>Habit Tracker</h2></div>
		<!-- logo end -->

		<!-- text start -->
		<div class="text">
			Enter the login name into "Login" and password into the "Password" fields.
Then click "Login".
		</div>

		<!-- text end -->
		<!-- login form start -->
		<div class="form">
		<?
		if(isset($_SESSION['success']))
		{
		echo "<div style='text-align:left;color:#060;padding-left:80px;'>".$_SESSION['success']."</div>"; $_SESSION['success']='';
		}
		if(isset($_SESSION['error']))
		{
		echo "<div style='text-align:left;color:#CC0000;padding-left:80px;'>".$_SESSION['error']."</div>"; $_SESSION['error']='';
		}
		?>
			<form action="login.php" method="post" name="login_form" id="login_form">
			<ul>
				<li><label for="username"><strong>Login</strong></label></li>

				<li style="width:200px;">
					<input type="text" id="username" name="username" tabindex="1" value="" />
				</li>

				<li style="clear:both;"><label for="dummy_password"><strong>Password</strong></label></li>

				<li>
					<input type="password" id="password" name="password" value="" tabindex="2" />

				</li>

				<li style="clear:both;padding-left:80px;">
					<input type="submit" id="login" name="login" value="Login" tabindex="3" />
				</li>
			</ul>
			</form>

			<div style="clear:both;"></div>

			
		</div>
		<!-- login form end -->

		<!-- copyrights start -->
		<div class="copy">
			<a  style="color:white;" href="addAdmin.php" target="_blank"><h2>New User Register Here!</h2> </a>
		</div>
		<!-- copyrights end -->

		<div class="forgot">
			<br /><!--<a href="#" id="forgot_password">Forgot your password?</a>-->
		</div>

	</div>
	<!-- login end -->

</body>
</html>