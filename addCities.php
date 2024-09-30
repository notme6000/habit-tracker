<?php
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
$navigateid='168';
$getNavigationData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$navigateid'");
$nextNavigateId=$navigateid+1;
$getNavigationDataNext=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$nextNavigateId'");
//$getNavigationData=mysql_fetch_assoc($getNavigationDataQuery);
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
	    if($id==''){
			  $state_id=$_POST['state_id'];
			  $string=trim($_POST['city']);
			  $string=preg_replace('/\s+/', ' ', $string);
			  $string=str_replace(";","|",$string);
			  $string=str_replace(",","|",$string);
			  /*$string=str_replace("'","|",$string);
			  $string=str_replace('"','|',$string);
			  $string=str_replace('>','|',$string);
			  $string=str_replace('<','|',$string);
			  $string=str_replace(" ","|",$string);*/
			  $string=str_replace(";","|",$string);
			  $email_arr=explode("|",$string);
			  $counts=0;
				foreach($email_arr as $key => $val)
				{
						   /*$exist=$objuserdetails->getIndexedRow("email='$val'");*/
						   $exist=mysql_num_rows(mysql_query("select * from cities where state_id='$state_id' and city='$val'"));
						   if($exist==0)
						   {
								if(mysql_query("insert into cities set state_id='$state_id',city='$val'"))
								$counts++;
						   }
				}
				/*echo $counts." Inserted";*/
				$_SESSION['success']=$counts." Cities Added";
				mysql_close($con);
				header("Location:".$getNavigationData['menu_url']);
				exit();
		} else {
			  $state_id=$_POST['state_id'];
			  $city=trim($_POST['city']);
				if(mysql_query("update cities set state_id='$state_id',city='$city' where id='$id'"))
				{
					/*echo $counts." Inserted";*/
					$_SESSION['success']=$counts." Cities Updated...";
					mysql_close($con);
					header("Location:".$getNavigationData['menu_url']."?id=".$id);
					exit();
				}
		}
  }
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
</head>
<body>
<script type="text/javascript">
intelli.admin.lang = intelli.admin.lang['en'];
</script>
<script language="javascript">
function validate_form(obj)
{
  if(obj.tdate.value =='') 
	{
	 alert("Please enter date.");
	 obj.tdate.focus();
	 return false;
   }
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
	<a href="<?=$getNavigationDataNext['menu_url'];?>" ><img src="<?=($getNavigationDataNext['icon']<>'')?$getNavigationDataNext['icon']:DEFAULT_IMAGE;?>" title="<?=$getNavigationDataNext['menu_name'];?>" alt="<?=$getNavigationDataNext['menu_name'];?>" /></a>
	<?
	if($id<>'')
	{
	?>
	<a href="<?=$getNavigationData['menu_url'];?>" ><img src="<?=($getNavigationData['icon']<>'')?$getNavigationData['icon']:DEFAULT_IMAGE;?>" title="<?=$getNavigationData['menu_name'];?>" alt="<?=$getNavigationData['menu_name'];?>" /></a>
	<?
	}
	?>
	</div>

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
<!--<tr class="oddRow">
<td width="22%" align="right" class="txt">Date:</td>
<td align="left" colspan="3">
<?
if($id<>'')
{
$tdate=date('m-d-Y',strtotime($line['tdate']));
}
else
{
$tdate=date('m-d-Y');
}
?>
<input name="tdate" type="text" class="txtfld" id="tdate" value="<?=$tdate;?>" size="12" maxlength="12" /></td>
</tr>-->
<tr class="oddRow">
<td width="17%" align="right" class="txt">State:</td>
<td width="83%" colspan="3" align="left">
<select name="state_id" id="state_id" class="listxbx">
<option value="" selected>Select State</option>
<?php
$data=getRow($conn,"select * from cities where id='$id'");
$result_state=mysqli_query($conn,"select * from states where status='A'");
while($state_array=ms_stripslashes(mysql_fetch_array($result_state)))
{
$sel_con=($state_array['state_id']==$data['state_id'])? " selected='selected'" : " ";
echo '<option value='.$state_array['state_id'].''.$sel_con.'>'.$state_array['state'].'</option>';
}
?>
</select>
</td>
</tr>
<tr class="oddRow" id="tr_page_title_gr">
<td width="17%" align="right" class="txt">Cities (seperate by commas):</td>
<td width="83%" colspan="3" align="left">
<textarea name="city" cols="100" <? if($id<>'') {?> row="1" <? } else {?>rows="20" <? }?>><?=$data['city'];?></textarea>
</td> 
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2">&nbsp;</td>
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
<!-- content end -->
<? include("footer.inc.php");?>
</body>
</html>