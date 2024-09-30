<?php
require_once("codelibrary/inc/variables.php");
require_once("codelibrary/inc/functions.php");
$navigateid='';
if(!isset($_SESSION['sess_admin_id']))
  {
  	 $_SESSION['error']="Login Again!!!";
	 mysqli_close($con);
	 header("Location:index.php");
	 exit();
  }
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Admin Panel&nbsp;:: Powered by <?=POWERED_BY_NAME;?></title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<base href="<?=SITE_URL;?>" />
<link rel="shortcut icon" href="<?=POWERED_BY_LINK;?>favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
</head>
<body>
<script type="text/javascript">
intelli.admin.lang = intelli.admin.lang['en'];
</script>
<? include("header.inc.php"); ?>
<div class="top-menu" id="top_menu"></div>

<!-- content start -->
<div class="content" id="mainCon">

	<? include("left.inc.php");?>

	<!-- right column start -->
	<div class="right-column">
	<div class="breadcrumb"><a href="home.php">Admin Panel</a><div class="arrow"></div>Admin Panel</div>

<h1 class="common" style="background-image: url('img/icons/h1.gif');">Admin Panel</h1>

	<div style="clear:right; overflow:hidden;"></div>



<!-- MESSAGE -->
<div id="box_categories" style="margin-top: 15px;"></div>

<div style="width:100%;float:left;">Welcome to Administrative Console of <?=SITE_TITLE;?></div>
</div>

	<!-- right column end -->
<div style="clear:both;"></div>

</div>
<!-- content end -->
<? include("footer.inc.php");?>
</body>
</html>