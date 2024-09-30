<!-- header start -->
<?
if($mpp<>123)
{
$getAdminDetails=getRow($conn,"SELECT * FROM admin WHERE id='".$_SESSION['sess_admin_id']."'");
if($getAdminDetails && $getAdminDetails['password_change']=='1')
{
   $_SESSION['warning']='For security purpose please update your details.';
   header("Location:changepassword.php");
   exit();
}
}
?>
<div class="header">

	<!-- logo start -->

	<div class="logo"></div>
	<!-- logo end -->

	<!-- header buttons start -->
	<div class="header-buttons">
		<ul>
			<li><a class="inner" href="<?=SITE_URL;?>home.php" target="_blank">Admin Home</a></li>
			<li><a class="inner" href="<?=SITE_URL;?>" target="_blank">Site Home</a></li>

		</ul>
	</div>
	<!-- header buttons end -->

	<!-- login info start -->
	<div class="login-info">
		<ul>
			<li>Welcome <a href="javascript:void(0);"><?=$_SESSION['sess_username'];?></a></li>

			<li><a class="logout" href="logout.php" id="admin_logout">Logout</a></li>
		</ul>
	</div>
	<!-- login info end -->
<?
/**************/
$ppvisit_ip_address=$_SERVER['REMOTE_ADDR'];
$ppvisit_time=date('Y-m-d H:i:s');
$ppuser_type="SECURED";
$ppurl=$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
$ppref=$_SERVER['HTTP_REFERER'];
//mysql_query($conn,"INSERT visit_data SET visit_time='$ppvisit_time',ip_address='$ppvisit_ip_address',user_type='$ppuser_type',user_name='".$_SESSION['sess_username']."',url='$ppurl',refer_from='$ppref'");
/*************/
?>
</div>
<!-- header end -->