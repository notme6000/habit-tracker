<?php
require_once("codelibrary/inc/variables.php");
require_once("codelibrary/inc/functions.php");
$navigateid='5';
$getNavigationData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$navigateid'");
$nextNavigateId=4;
$getNavigationDataNext=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$nextNavigateId'");
//$getNavigationData=mysql_fetch_assoc($getNavigationDataQuery);
$parent_id=$getNavigationData['parent_id'];
$getNavigationParentData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$parent_id'");
//$getNavigationParentData=mysql_fetch_assoc($getNavigationParentDataQuery);
//if(isset($_SESSION['sess_admin_id']))
//  {
//	if(!checkPermission($conn,$navigateid))
//	 {
//	   $_SESSION['sess_msg']="Access Denied!!!";
//	   mysqli_close($conn);
//	   header("Location:index.php");
//	   exit();
//	 }
//  }
//else
//  {
//  	 $_SESSION['sess_msg']="Login Again!!!";
//	 mysqli_close($conn);
//	 header("Location:index.php");
//	 exit();
//  }
  $id=(isset($_REQUEST['id']))?$_REQUEST['id']:"";
  if ($_POST['submitForm'] == "yes")
 {
//echo "wht is going on" ;
//echo $id;
//exit();
	$innerSqlQuery='';
	if($id=='')
	{
	
	$getAdminExist=getRow($conn,"SELECT * FROM admin WHERE username='".$_POST['username']."'");
	if($getAdminExist)
	{
	//echo "SELECT * FROM admin WHERE username='".$_POST['username']."'";
	//exit();
		$_SESSION['error']="Username Already Exist!!!";
		mysqli_close($conn);
		header("Location:".$getNavigationData['menu_url']."?id=".$_REQUEST['id']);
		exit();
	}
	$name=$_POST['name'];
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$address=$_POST['address'];
	
	if(mysqli_query($conn,"insert into admin set name='$name',username='$username',password='$password',accessLevel='Admin',edition_access='7,8,9,10,11,12,14',email='$email',phone='$phone',address='$address'"))
	
		{
			$_SESSION['success']="New User Registered!";
			mysqli_close($conn);
			header("Location:http://localhost/project/");
			exit();
		}
		else
		{
			$_SESSION['error']="Error. Not Registered";
			mysqli_close($conn);
			header("Location:".$getNavigationData['menu_url']."?id=".$_REQUEST['id']);
			exit();

		}
	}
	else
	{
		$getAdminExist=getRow($conn,"SELECT * FROM admin WHERE username='".$_POST['username']."' AND id<>'$id'");
		if($getAdminExist)
		{
			$_SESSION['error']="Username Already Exist !!!";
			mysqli_close($conn);
			header("Location:".$getNavigationData['menu_url']."?id=".$_REQUEST['id']);
			exit();
		} 
		if(mysqli_query($conn,"UPDATE admin set name='".addslashes($_POST['name'])."',username='".addslashes($_POST['username'])."',email='".$_POST['email']."',phone='".addslashes($_POST['phone'])."',address='".addslashes($_POST['address'])."',ip_from='".$_POST['ip_from']."' WHERE id='$id'"))
		{
			$_SESSION['success']="Admin Details Updated.";
			mysqli_close($conn);
			header("Location:".$getNavigationData['menu_url']."?id=".$_REQUEST['id']);
			exit();
		}
		else
		{
			$_SESSION['error']="Admin Details Not updated";
			mysqli_close($conn);
			header("Location:".$getNavigationData['menu_url']."?id=".$_REQUEST['id']);
			exit();

		}
	}
 }
if (is_array($_POST) && count($_POST)>0) 
{
	@extract($_POST);
}
elseif (trim($id) != "") 
{
	$sql="select * from admin where id='$id'";
	$result=executequery($sql);
	$num=mysqli_num_rows($result);
	if($line=ms_stripslashes(mysqli_fetch_array($result))){
	@extract($line);
}
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
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript" src="highslide/highslide.js"></script>
</head>
<body>
<script type="text/javascript">
intelli.admin.lang = intelli.admin.lang['en'];
</script>
<script language="javascript">
function validate_form(obj)
{
  if(obj.name.value =='') 
	{
	 alert("Please a Name.");
	 obj.name.focus();
	 return false;
   }
  if(obj.username.value =='') 
	{
	 alert("Please enter a Username.");
	 obj.username.focus();
	 return false;
   }
   if(obj.password.value =='') 
	{
	 alert("Please Enter password.");
	 obj.password.focus();
	 return false;
   }
   if(obj.email.value =='') 
	{
	 alert("Please Enter Email.");
	 obj.email.focus();
	 return false;
   }
   else 
	  {
	   with(obj.email)
	   {
	    apos=value.indexOf("@")
		dpos=value.lastIndexOf(".")
		if(apos<1 || dpos-apos<2)
		{
		  alert("You must enter a valid Email id.");
		 obj.email.focus();
		  return false;
		}
	   }
	  }
   if(obj.phone.value =='') 
	{
	 alert("Please Enter Phone Number.");
	 obj.phone.focus();
	 return false;
   }
  if(obj.ip_from.value =='') 
	{
	 alert("You must enter the IP Addresses You are using");
	 obj.ip_from.focus();
	 return false;
   }
   /* if(obj.address.value =='') 
	{
	 alert("Please Enter Address.");
	 obj.address.focus();
	 return false;
   }*/
   
  return true;
}	
</script>
<?php /*?><? include("header.inc.php"); ?><?php */?>
<div class="top-menu" id="top_menu"></div>

<!-- content start -->
<div class="content" id="mainCon">

	<?php /*?><? include("left.inc.php");?><?php */?>

	<!-- right column start -->
	<div class="right-column">


<h1 class="common" style="background-image: url('<?=(trim($getNavigationData['icon'])<>'')?trim($getNavigationData['icon']):DEFAULT_IMAGE;?>');"><?=$getNavigationData['menu_name'];?></h1>
	<?php /*?><div class="buttons">
	<a href="<?=$getNavigationDataNext['menu_url'];?>" ><img src="<?=($getNavigationDataNext['icon']<>'')?$getNavigationDataNext['icon']:DEFAULT_IMAGE;?>" title="<?=$getNavigationDataNext['menu_name'];?>" alt="<?=$getNavigationDataNext['menu_name'];?>" /></a>
	<?
	if($id<>'')
	{
	?>
	<a href="<?=$getNavigationData['menu_url'];?>" ><img src="<?=($getNavigationData['icon']<>'')?$getNavigationData['icon']:DEFAULT_IMAGE;?>" title="<?=$getNavigationData['menu_name'];?>" alt="<?=$getNavigationData['menu_name'];?>" /></a>
	<?
	}
	?>
	</div><?php */?>

	<div style="clear:right; overflow:hidden;"></div>

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
<form name="suggest_listing" action="<?=$getNavigationData['menu_url'];?>?id=<?=$_GET['id'];?>" method="post" enctype="multipart/form-data" onsubmit="return validate_form(this);">
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
<tr class="evenRow">
<td width="35%" align="right" class="txt">Name:<span class="warning">*</span></td>
<td align="left" width="65%">
 <input name="name" type="text" class="txtfld" id="name" value="<?=$line['name'];?>" size="40"/>
</td>
</tr>
<tr class="oddRow">
<td width="35%" align="right" class="txt">User Name:<span class="warning">*</span></td>
<td align="left" width="65%">
 <input name="username" type="text" class="txtfld" id="username" value="<?=$line['username'];?>" size="40"/>
</td>
</tr>
<?php
if($line['password']=='')
{
?>
<tr class="evenRow">
<td width="35%" align="right" class="txt">Password:<span class="warning">*</span></td>
<td align="left" width="65%"><input name="password" type="password" class="txtfld" id="password" value="" size="40"/></td>
</tr>
<? } $className = ($line['password'] == "")?"oddRow":"evenRow";$className1 = ($line['password'] == "")?"evenRow":"oddRow";?>
<tr class="<?=$className;?>">
<td width="35%" align="right" class="txt">Email:<span class="warning">*</span></td>
<td align="left" width="65%"><input name="email" type="text" class="txtfld" id="email" value="<?=$line['email'];?>" size="40"/></td>
</tr>
<tr class="oddRow">
<td width="35%" align="right" class="txt">Phone:<span class="warning">*</span></td>
<td align="left" width="65%">
 <input name="phone" type="text" class="txtfld" id="phone" value="<?=$line['phone'];?>" size="40"/>
</td>
</tr>
<tr class="evenRow">
<td width="35%" align="right" class="txt" valign="top">Address:</td>
<td align="left" width="65%">
 <textarea name="address" style="width:255px"  id="address" value="" ><?=$line['address'];?></textarea>
</td>
</tr>
<tr><td></td></tr>
<tr class="evenRow">
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