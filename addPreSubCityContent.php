<?php
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
$navigateid='171';
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
	if($id=='')
	{
	 $city_content=addslashes($_POST['city_content']);
	if(mysql_query("INSERT INTO pre_content SET subcity_content='$city_content'"))
		{
			$_SESSION['success']="Sub City Content Added.";
			mysql_close($con);
			header("Location:".$getNavigationData['menu_url']."?id=".mysql_insert_id());
			exit();
		}
		else
		{
			$_SESSION['error']="Sub City Content Not added";
			mysql_close($con);
			header("Location:".$getNavigationData['menu_url']."?id=".$_REQUEST['id']);
			exit();
		}
	}
	else
	{
		 $city_content=addslashes($_POST['city_content']);
		if(mysql_query("UPDATE pre_content SET 	subcity_content='$city_content' WHERE id='$id'"))
		{
			$_SESSION['success']="Sub City Content Updated.";
			mysql_close($con);
			header("Location:".$getNavigationData['menu_url']."?id=".$_REQUEST['id']);
			exit();
		}
		else
		{
			$_SESSION['error']="Sub City Content Not Updated";
			mysql_close($con);
			header("Location:".$getNavigationData['menu_url']."?id=".$_REQUEST['id']);
			exit();

		}
	}
 }
if (is_array($_POST) && count($_POST)>0) 
{
	@extract($_POST);
}
	$sql="select * from pre_content";
	$result=executequery($sql);
	$num=mysql_num_rows($result);
	if($line=ms_stripslashes(mysql_fetch_array($result))){
	@extract($line);
	$content=stripslashes(htmlspecialchars_decode($line['subcity_content']));
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

<link type="text/css" href="dtpicker/css/ui-lightness/jquery-ui-1.8.7.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="dtpicker/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="dtpicker/js/jquery-ui-1.8.7.custom.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	$(function() {
		var dates = $( "#tdate, #todate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "tdate" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" );
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
		$( "#newspaper_date" ).datepicker();
	});
	
</script>
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
<tr class="oddRow" id="tr_page_title_gr">
  <td width="30%" align="right" class="txt"><table width="100%" border="0" cellspacing="0" cellpadding="4" align=center  bgcolor="#FFFFFF" class="greyBorder">
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
    <tr></tr>
    <tr class="oddRow" id="tr_page_title_gr2">
      <td width="10%" align="right" class="txt">Subcity Content:</td>
      <td align="left" colspan="2"><?php
//if($_POST['submitFirstForm'])
//{
//$news_description=stripslashes($_POST['city_content']);
//}
//else
//{						   	
//$news_description=stripslashes($line['city_content']);
//}
//$sBasePath ="fckeditor/";
//$oFCKeditor = new FCKeditor('city_content') ;
//$oFCKeditor->BasePath	= $sBasePath ;
//$oFCKeditor->Value		= stripslashes(htmlspecialchars_decode($city_content));
//$oFCKeditor->Width		= "850px";
//$oFCKeditor->Height		= "350px";
//$oFCKeditor->Create() ;
?>
        <textarea name="city_content" rows="10" cols="100"><?=$content;?>
    </textarea>
        <script>
    CKEDITOR.replace( 'city_content' );
    </script></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr class="oddRow">
      <td align=center colspan=101><?php if((checkPermission($navigateid,'EDIT') && $_REQUEST['id']) || checkPermission($navigateid,'ADD')){?>
        <input type="submit" name="submit" value="Submit" width="82" height="26" />
        <? }?></td>
    </tr>
  </table></td>
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