<?php
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
$navigateid='112';
$getNavigationData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$navigateid'");
$parent_id=$getNavigationData['parent_id'];
$getNavigationParentData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$parent_id'");
//$getNavigationParentData=mysql_fetch_assoc($getNavigationParentDataQuery);
if(isset($_SESSION['sess_admin_id']))
  {
	if(!checkPermission($navigateid))
	 {
	   $_SESSION['sess_msg']="Access Denied!!!";
	    mysqli_close($con);
	   header("Location:index.php");
	   exit();
	 }
  }
else
  {
  	 $_SESSION['sess_msg']="Login Again!!!";
	  mysqli_close($con);
	   header("Location:index.php");
	 exit();
  }
  $id=(isset($_REQUEST['id']))?$_REQUEST['id']:"";
  if ($_POST['submitForm'] == "yes")
 {
	$innerSqlQuery='';
	if(mysql_query($conn,"UPDATE popup_settings SET bg_color='".$_POST['bg_color']."',title_size='".$_POST['title_size']."',title_color='".$_POST['title_color']."',title_bg='".$_POST['title_bg']."',content_size='".$_POST['content_size']."', content_color='".$_POST['content_color']."'".$innerSqlQuery." WHERE id='1'"))
	{
		$_SESSION['success']="PopUp Settings Updated.";
		 mysqli_close($con);
	   header("Location:".$getNavigationData['menu_url']);
		exit();
	}
	else
	{
		$_SESSION['error']="PopUp Settings Not Updated";
		 mysqli_close($con);
	   header("Location:".$getNavigationData['menu_url']);
		exit();
	
	}
 }
$sql="select * from popup_settings where id='1'";
$result=executequery($sql);
$num=mysqli_num_rows($result);
if($line=ms_stripslashes(mysqli_fetch_array($result))){
@extract($line);
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
</head>
<body>
<!-- YUI Dependencies -->  
<script type="text/javascript" src="http://yui.yahooapis.com/2.5.1/build/utilities/utilities.js" ></script> 
<script type="text/javascript" src="http://yui.yahooapis.com/2.5.1/build/slider/slider-min.js" ></script> 
 
<!-- Color Picker source files for CSS and JavaScript --> 
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.5.1/build/colorpicker/assets/skins/sam/colorpicker.css"> 
<script type="text/javascript" src="http://yui.yahooapis.com/2.5.1/build/colorpicker/colorpicker-min.js" ></script>

<script type="text/javascript" src="windowfiles/dhtmlwindow.js"></script>
<link rel="stylesheet" type="text/css" href="windowfiles/dhtmlwindow.css" />

<script type="text/javascript" src="windowfiles/ddcolorpicker.js"></script>
<style type="text/css">

* html .yui-picker-bg{ /*Requires CSS. Do not edit/ remove*/
filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='http://yui.yahooapis.com/2.5.1/build/colorpicker/assets/skins/sam/picker_mask.png',sizingMethod='scale');
}

/*Style used in demos below. Edit if desired*/

.colorpreview{ /*CSS for sample Preview Control*/
border: 1px solid black;
padding: 1px 10px;
cursor: hand;
cursor: pointer;
}

form div{
margin-bottom: 5px;
}

</style>
<!-- YI Color Picker-->
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
<tr class="oddRow" id="tr_page_title_gr">
<td align="left" class="txt" colspan="100%" style="background:#DBDBDB;"><strong>PopUp Settings</strong></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Page Background Color : </td>
<td width="53%" colspan="2" align="left"><input name="bg_color" type="text" class="txtfld" id="bg_color" value="<?php echo ($line['bg_color'])?stripslashes($line['bg_color']):stripslashes($_POST['bg_color']);?>" size="10"/>&nbsp;<span id="control1" class="colorpreview">&nbsp;</span></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Title Background Color : </td>
<td width="53%" colspan="2" align="left"><input name="title_bg" type="text" class="txtfld" id="title_bg" value="<?php echo ($line['title_bg'])?stripslashes($line['title_bg']):stripslashes($_POST['title_bg']);?>" size="10"/>&nbsp;<span id="control2" class="colorpreview">&nbsp;</span></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Title Font Size : </td>
<td width="53%" colspan="2" align="left"><input name="title_size" type="text" class="txtfld" id="title_size" value="<?php echo ($line['title_size'])?stripslashes($line['title_size']):stripslashes($_POST['title_size']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Title Font Color : </td>
<td width="53%" colspan="2" align="left"><input name="title_color" type="text" class="txtfld" id="title_color" value="<?php echo ($line['title_color'])?stripslashes($line['title_color']):stripslashes($_POST['title_color']);?>" size="10"/>&nbsp;<span id="control3" class="colorpreview">&nbsp;</span></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Content Font Size : </td>
<td width="53%" colspan="2" align="left"><input name="content_size" type="text" class="txtfld" id="content_size" value="<?php echo ($line['content_size'])?stripslashes($line['content_size']):stripslashes($_POST['content_size']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Content Font Color : </td>
<td width="53%" colspan="2" align="left"><input name="content_color" type="text" class="txtfld" id="content_color" value="<?php echo ($line['content_color'])?stripslashes($line['content_color']):stripslashes($_POST['content_color']);?>" size="10"/>&nbsp;<span id="control4" class="colorpreview">&nbsp;</span></td>
</tr>
<tr class="oddRow">
<td>&nbsp;</td>
<td align="left"><?php if((checkPermission($navigateid,'EDIT') && $_REQUEST['id']) || checkPermission($navigateid,'ADD')){?><input type="submit" name="submit" value="Submit" width="82" height="26" /><? }?></td>
</tr>
</table>
<!-- Inner table Ends -->
</td>
</tr>
</table>
</form>
<div id="ddcolorwidget">
Please choose a color:
<div id="ddcolorpicker" style="position:relative; height:205px"></div>
<a href="http://norfolkllc.com" style="margin-left:5px; font-size:90%">Norfolk Color Widget</a>
</div>
</div>
</div>


</div>

	<!-- right column end -->
<div style="clear:both;"></div>

</div>
<!-- content end -->
<? include("footer.inc.php");?>
<script type="text/javascript">

ddcolorpicker.init({
	colorcontainer: ['ddcolorwidget', 'ddcolorpicker'], //id of widget DIV, id of inner color picker DIV
	displaymode: 'float', //'float' or 'inline'
	floatattributes: ['DD Color Picker Widget', 'width=390px,height=250px,resize=1,scrolling=1,center=1'], //'float' window attributes
	fields: ['bg_color:control1', 'title_bg:control2', 'title_color:control3', 'content_color:control4'] //[fieldAid[:optionalcontrolAid], fieldBid[:optionalcontrolBid], etc]
})

</script>
</body>
</html>