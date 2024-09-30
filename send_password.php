<?php
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
$navigateid='6';
$getNavigationData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$navigateid'");
$parent_id=$getNavigationData['parent_id'];
$getNavigationParentData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$parent_id'");
//$getNavigationParentData=mysql_fetch_assoc($getNavigationParentDataQuery);
if(isset($_SESSION['sess_admin_id']))
  {
	if(!checkPermission($navigateid))
	 {
	   $_SESSION['sess_msg']="Access Denied!!!";
	    mysql_close($con);
	   header("Location:index.php");
	   exit();
	 }
  }
else
  {
  	 $_SESSION['sess_msg']="Login Again!!!";
	  mysql_close($con);
	   header("Location:index.php");
	 exit();
  }
  $id=(isset($_REQUEST['id']))?$_REQUEST['id']:"";
  if ($_POST['submitForm'] == "yes")
 {
 	$email_to=$_POST['to'];
	$email_subject=$_POST['subject'];
	$email_body=$_POST['mail_message'];
	$email_from=SITE_TITLE." <".$_POST['from'].">";
	$reply_to=$_POST['from'];
	$headers = "From: ".$email_from;
	if(mail($email_to,$email_subject,$email_body,"$headers\r\nContent-type: text/html; charset=us-ascii"))
	{
		$sess_msg="Login details(".$emailto_name.") send successfully.";
		$_SESSION['success']=$sess_msg;
		 mysql_close($con);
	   header("Location: listAdmin.php");
	}
	else
	{
		$sess_msg="Login details(".$emailto_name.") sending failed.";
		$_SESSION['error']=$sess_msg;
		 mysql_close($con);
	   header("Location: listAdmin.php");
	}
 }
$sql_admin=mysql_query("select * from admin WHERE id='$id'");
$result_admin=mysql_fetch_assoc($sql_admin);
$num=mysql_num_rows($sql_admin);
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
<form name="suggest_listing" action="<?=$getNavigationData['menu_url'];?>" method="post" enctype="multipart/form-data" onsubmit="return validate_form(this);">
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
<td width="41%" align="right" valign="top" class="txt"><strong>Email to : </strong></td>
<td width="59%" align="left"><input name="to" type="text" class="txtfld" id="to"  value="<?=$result_admin['email'];?>" style="width:280px;"/></td>
</tr>
<tr class="evenRow">
<td align="right" valign="top" class="txt"><strong>Email From : </strong></td>
<td align="left"><input name="from" type="text" class="txtfld" id="from" value="noreply@<?=strtolower(SITE_TITLE);?>.com"  style="width:280px;"/></td>
</tr>
<tr class="oddRow">
<td align="right" valign="top" class="txt"><strong>Subject : </strong></td>
<td align="left"><input name="subject" type="text" class="txtfld" id="subject" value="Admin Panel - Login Details of <?=strtolower(SITE_TITLE);?>"  style="width:280px;"/></td>
</tr>
<tr class="evenRow">
<td align="right" valign="top" class="txt"><strong>Message : </strong></td>
<td align="left" valign="top" class="txt">
<?
$message="Dear Customer,<br />Your login Details to login and manage deals in ".SITE_TITLE.".<a href='".COPY_BY_LINK."admin/index.php'>Click Here</a> to Login.<br /><br />Username : <strong>".$result_admin['username']."</strong><br />Password : <strong>".$result_admin['password']."</strong><br /><br />Thanks and Regards,<br />Admin";
?>
<textarea name="mail_message" id="mail_message" rows="5" cols="40"><?=$message;?></textarea>
 
</td>
</tr>
<tr class="oddRow">
<td align=center colspan=101><?php if((checkPermission($navigateid,'EDIT') && $_REQUEST['id']) || checkPermission($navigateid,'ADD')){?><input type="submit" name="submit" value="Submit" width="82" height="26" /><? }?></td>
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
<script language="javascript">
function changePath(val)
{
if(val=='URL')
{
document.getElementById('tr_page_dance_video_url_gr').style.display='';
document.getElementById('tr_page_dance_video_url_en').style.display='';
document.getElementById('tr_page_dance_video_file_gr').style.display='none';
document.getElementById('tr_page_dance_video_file_en').style.display='none';
}
else
{
document.getElementById('tr_page_dance_video_url_gr').style.display='none';
document.getElementById('tr_page_dance_video_url_en').style.display='none';
document.getElementById('tr_page_dance_video_file_gr').style.display='';
document.getElementById('tr_page_dance_video_file_en').style.display='';
}
}
</script>
<!-- content end -->
<? include("footer.inc.php");?>
</body>
</html>