<?php
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
$navigateid='2';
$getNavigationData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$navigateid'");
$parent_id=$getNavigationData['parent_id'];
$getNavigationParentData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$parent_id'");
//$getNavigationParentData=mysql_fetch_assoc($getNavigationParentDataQuery);
if(!isset($_SESSION['sess_admin_id']))
  {
  	 $_SESSION['error']="Login Again!!!";
	 mysql_close($con);
	 header("Location:index.php");
	 exit();
  }
  
  $pid=$_SESSION['sess_admin_id'];
  if ($_POST['submitForm'] == "yes")
 {
        $query=mysql_query("select * from admin where id='$pid'");
		$result=mysql_fetch_array($query);
		if($_POST['old_password']==''){
		$_SESSION['error']='Please Enter Old Password';
		header("Location:changepassword.php");
	    exit();
		}
		else if($_POST['new_password']==''){
		$_SESSION['error']='Please Enter New Password';
		header("Location:changepassword.php");
	    exit();
		}
		else if($_POST['confirm_password']==''){
		$_SESSION['error']='Please Enter Confirm Password';
		header("Location:changepassword.php");
	    exit();
		}
		else if($_POST['new_password']!=$_POST['confirm_password']){
    	$_SESSION['error']='Confirm Pssword does not match';
		header("Location:changepassword.php");
	    exit();
		}
		else if(md5($_POST['old_password'])!=$result['password']){
		$_SESSION['error']='Old Password is Wrong';
		header("Location:changepassword.php");
	    exit();
		}
		else{
		  if(mysql_query("update admin set password='".md5($_POST['new_password'])."',name='".$_POST['name']."',phone='".$_POST['phone']."',address='".$_POST['address']."',ip_from='".$_POST['ip_from']."',password_change='2' where id='$pid'"))
		  {
			session_unregister("sess_msg");
			session_unregister("sess_admin_id");
			session_unregister("sess_username");
			session_destroy();
			session_register('success');
			$_SESSION['success']='Password updated successfully,<br>Please login Again';
			header("Location:index.php");
	   		exit();
		  }
		  else
		  {
			 $_SESSION['error']='Password Not Updated.'; 
			 header("Location:changepassword.php");
	   		 exit();
		  }
		}
}
$query1=mysql_query("select * from admin where id='$pid'");
$result1=mysql_fetch_array($query1);
$mpp=123;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Admin Panel&nbsp;:: Powered by <?=POWERED_BY_NAME;?></title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<base href="<?=SITE_URL;?>admin/" />
<link rel="shortcut icon" href="<?=POWERED_BY_LINK;?>favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript" src="highslide/highslide.js"></script>
<script type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
</head>
<body>
<script type="text/javascript">
intelli.admin.lang = intelli.admin.lang['en'];
</script>
<script language="javascript">
function validate_form(obj)
{
  /*if(obj.link_type.value =='') 
	{
	 alert("Please select Link Type.");
	 obj.link_type.focus();
	 return false;
   }
  if(obj.link_name.value =='') 
	{
	 alert("Please select Link Name.");
	 obj.link_name.focus();
	 return false;
   }
   if(obj.link_url.value =='') 
	{
	 alert("Please select Link URL.");
	 obj.link_url.focus();
	 return false;
   }*/
  return true;
}	
</script>
<? include("header.inc.php"); ?>
<div class="top-menu" id="top_menu"></div>

<!-- content start -->
<div class="content" id="mainCon">

	<? include("left.inc.php");?>

	<!-- right column start -->
	<div class="right-column">
	<div class="breadcrumb"><a href="home.php">Admin Panel</a><div class="arrow"></div><?=$getNavigationParentData['menu_name'];?></div>

<h1 class="common" style="background-image: url('<?=(trim($getNavigationData['icon'])<>'')?trim($getNavigationData['icon']):DEFAULT_IMAGE;?>');"><?=$getNavigationData['menu_name'];?></h1>
	<div class="buttons">
	</div>

	<div style="clear:right; overflow:hidden;"></div>
	<div>&nbsp;</div>

<? 
if($_SESSION['success']!='')
{
greenMessage($_SESSION['success']);unset($_SESSION['success']);
}
if($_SESSION['error']!='')
{
redMessage($_SESSION['error']);unset($_SESSION['error']);
}
if($_SESSION['warning']!='')
{
orangeMessage($_SESSION['warning']);unset($_SESSION['warning']);
}

?>
<!-- MESSAGE -->
<div id="box_categories" style="margin-top: 15px;"></div>

<div style="width:100%;float:left;">
<div style="border: medium none;" class="box-caption"><div style="margin: 0px 0px -1px -8px;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0pt 1px;"></div></div><?=$getNavigationData['menu_name'];?></div>
<div class="minmax white-open"></div>
<div style="display: block;" class="box-content">
<form name="suggest_listing" action="changepassword.php" method="post" enctype="multipart/form-data" onsubmit="return validate_form(this);">
<input type="hidden" name="submitForm" value="yes">
<input type="hidden" name="id" class="txtfld" value="<?=$id?>">
<table width="100%" border="0" cellspacing="0" cellpadding="4" align=center  bgcolor="#FFFFFF" class="greyBorder">
<tr class="oddRow">
<td class="txt" align="right" colspan="2" style="border-bottom:3px solid #DADADA;border-top:1px solid #DADADA;"><span class="warning">*</span> - Required Fields</td>
</tr>
<tr class="oddRow">
<td align="left" class="txt" valign="top">
<!-- Inner table -->
<table width="100%" border="0" cellspacing="0" cellpadding="4" align=center  bgcolor="#FFFFFF" class="greyBorder">
<tr class="oddRow">
<td width="35%" align="right" valign="top" class="bldTxt">Username:</td>
<td align="left" width="65%" class="txt"><strong><?=$result1['username'];?></strong></td>
</tr>				
<tr class="evenRow">
<td align="right" valign="top" class="bldTxt"><span class="warning">*</span>Old Password :</td>
<td align="left"><input type="password" name="old_password" size="45" class="txtfld" tmt:required="true" tmt:message="Please Enter Old Password" /> </td>
</tr>
<tr class="oddRow">
<td align="right" valign="top" class="bldTxt"><span class="warning">*</span>New Password :</td>
<td align="left"><input type="password" name="new_password" size="45" class="txtfld" tmt:required="true" tmt:message="Please Enter New Password" /> </td>
</tr>				
<tr class="evenRow">
<td align="right" valign="top" class="bldTxt"><span class="warning">*</span>Confirm Password :</td>
<td align="left"><input type="password" name="confirm_password" size="45" class="txtfld" tmt:equalto="new_password"  tmt:required="true" tmt:message="Please Enter Confirm Password" /> </td>
</tr>
<tr class="evenRow">
<td align="right" valign="top" class="bldTxt"><span class="warning">*</span>Name :</td>
<td align="left"><input type="text" name="name" size="45" class="txtfld" tmt:equalto="name" value="<?=$result1['name'];?>"  tmt:required="true" tmt:message="Your Name" /> </td>
</tr>
<tr class="evenRow">
<td align="right" valign="top" class="bldTxt">Address :</td>
<td align="left">
<textarea name="address" id="address" cols="40" rows="3"><?=$result1['address'];?></textarea></td>
</tr>
<tr class="evenRow">
<td align="right" valign="top" class="bldTxt"><span class="warning">*</span>Phone :</td>
<td align="left"><input type="text" name="phone" size="45" class="txtfld" tmt:equalto="phone" value="<?=$result1['phone'];?>"  tmt:required="true" tmt:message="Your Name" /> </td>
</tr>
<tr class="evenRow">
<td align="right" valign="top" class="bldTxt"><span class="warning">*</span>IP ADDRESS :</td>
<td align="left">
<textarea name="ip_from" id="ip_from" cols="40" rows="3"><?=$result1['ip_from'];?></textarea><br />
<a href="http://www.whatismyip.com" target="_blank">Click Here </a> to know your ip address,<br /> if using morethan one IP ADDRESS then please specify all separated by commas.</td>
</tr>

<tr class="oddRow">
<td align=center colspan=101><input type="submit" name="submit" value="Submit" width="82" height="26" /></td>
</tr>
</table>
<!-- Inner table Ends -->
</td>
</tr>
</table>
</form>
</div>
</div>


</div>

	<!-- right column end -->
<div style="clear:both;"></div>

</div>
<!-- content end -->
<? include("footer.inc.php");?>
</body>
</html>