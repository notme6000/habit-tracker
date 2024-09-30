<?php
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
$navigateid='28';
$getNavigationData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$navigateid'");
$parent_id=$getNavigationData['parent_id'];
$getNavigationParentData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$parent_id'");
//$getNavigationParentData=mysql_fetch_assoc($getNavigationParentDataQuery);
//mysql_query("ALTER TABLE 'settings' ADD 'gbanner' VARCHAR( 50 ) NOT NULL AFTER 'tab_news_count'");
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
	$innerSqlQuery='';
	if($_FILES['gbanner']['name']<>'')
	{
	if($_FILES["gbanner"]["size"] < 50000 && ($_FILES["gbanner"]["type"] == "image/gif" || $_FILES["gbanner"]["type"] == "image/jpeg" || $_FILES["gbanner"]["type"] == "image/pjpeg" || $_FILES["gbanner"]["type"] == "image/png"))
	{
		$arr1=array_reverse(explode('.',$_FILES['gbanner']['name']));
		$ty1=$arr1[0];
		$filename1="b1_".date('Ymdhis').".".$ty1; 
		$path1="../galleries/".$filename1;
		if(!move_uploaded_file($_FILES["gbanner"]["tmp_name"], $path1))
		{
			$sess_msg="Gallery Banner uploading Failed, Try to use JPG, GIF or PNG.";
			$_SESSION['error']=$sess_msg;
			header("Location:".$getNavigationData['menu_url']."?id=".$_REQUEST['id']);
			exit();
		}
		else
		{
			$innerSqlQuery.=",gbanner='$filename1'";
		}
	}
	else
	{
		  $sess_msg="Image type or size mismatching.";
		  $_SESSION['error']=$sess_msg;
		  mysql_close($con);
		  header("Location:".$getNavigationData['menu_url']."?id=".$_REQUEST['id']);
		  exit();
	}
	}
	if(mysql_query("UPDATE settings SET meta_title='".addslashes($_POST['meta_title'])."',meta_keywords='".addslashes($_POST['meta_keywords'])."',meta_description='".addslashes($_POST['meta_description'])."',main_news_title_length1='".$_POST['main_news_title_length1']."',main_news_title_length2='".$_POST['main_news_title_length2']."', main_news_description_length1='".$_POST['main_news_description_length1']."', main_news_description_length2='".$_POST['main_news_description_length2']."', sub_news_title_length='".$_POST['sub_news_title_length']."', sub_news_description_length='".$_POST['sub_news_description_length']."', other_news_title_length='".$_POST['other_news_title_length']."', tab_main_news_title_length='".$_POST['tab_main_news_title_length']."', tab_main_news_description_length='".$_POST['tab_main_news_description_length']."', tab_sub_news_title_length='".$_POST['tab_sub_news_title_length']."', sub_news_count='".$_POST['sub_news_count']."', other_news_count='".$_POST['other_news_count']."', tab_news_count='".$_POST['tab_news_count']."',gurl='".$_POST['gurl']."'".$innerSqlQuery." WHERE id='1'"))
	{
		$_SESSION['success']="Settings Updated.";
		 mysql_close($con);
	   header("Location:".$getNavigationData['menu_url']);
		exit();
	}
	else
	{
		$_SESSION['error']="Settings Not Updated";
		 mysql_close($con);
	   header("Location:".$getNavigationData['menu_url']);
		exit();
	
	}
 }
$sql="select * from settings where id='1'";
$result=executequery($sql);
$num=mysql_num_rows($result);
if($line=ms_stripslashes(mysql_fetch_array($result))){
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
<tr class="oddRow" id="tr_page_title_gr">
<td align="left" class="txt" colspan="100%" style="background:#DBDBDB;"><strong>Global SEO</strong></td>
</tr>
<tr class="oddRow" id="tr_page_title_gr">
<td width="324" align="right" valign="top" class="txt">Meta Title:</td>
<td width="764" colspan="2" align="left"><textarea name="meta_title" id="meta_title" cols="35" rows="3"><?php echo ($line['meta_title'])?stripslashes($line['meta_title']):stripslashes($_POST['meta_title']);?></textarea></td>
</tr>
<tr class="oddRow" id="tr_page_title_gr">
<td width="324" align="right" valign="top" class="txt">Meta Keywords:</td>
<td align="left" colspan="2">
<textarea name="meta_keywords" id="meta_keywords" cols="35" rows="3"><?php echo ($line['meta_keywords'])?stripslashes($line['meta_keywords']):stripslashes($_POST['meta_keywords']);?></textarea></td>
</tr>
<tr class="oddRow" id="tr_page_title_gr">
<td width="324" align="right" valign="top" class="txt">Meta Description:</td>
<td align="left" colspan="2">
<textarea name="meta_description" id="meta_description" cols="35" rows="3"><?php echo ($line['meta_description'])?stripslashes($line['meta_description']):stripslashes($_POST['meta_description']);?></textarea></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Main News(1) Title Length:</td>
<td width="53%" colspan="2" align="left"><input name="main_news_title_length1" type="text" class="txtfld" id="main_news_title_length1" value="<?php echo ($line['main_news_title_length1'])?stripslashes($line['main_news_title_length1']):stripslashes($_POST['main_news_title_length1']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Main News(1) Description length:</td>
<td width="53%" colspan="2" align="left"><input name="main_news_description_length1" type="text" class="txtfld" id="main_news_description_length1" value="<?php echo ($line['main_news_description_length1'])?stripslashes($line['main_news_description_length1']):stripslashes($_POST['main_news_description_length1']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Main News(2) Title Length:</td>
<td width="53%" colspan="2" align="left"><input name="main_news_title_length2" type="text" class="txtfld" id="main_news_title_length2" value="<?php echo ($line['main_news_title_length2'])?stripslashes($line['main_news_title_length2']):stripslashes($_POST['main_news_title_length2']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Main News(2) Description length:</td>
<td width="53%" colspan="2" align="left"><input name="main_news_description_length2" type="text" class="txtfld" id="main_news_description_length2" value="<?php echo ($line['main_news_description_length2'])?stripslashes($line['main_news_description_length2']):stripslashes($_POST['main_news_description_length2']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Sub News Title Length:</td>
<td width="53%" colspan="2" align="left"><input name="sub_news_title_length" type="text" class="txtfld" id="sub_news_title_length" value="<?php echo ($line['sub_news_title_length'])?stripslashes($line['sub_news_title_length']):stripslashes($_POST['sub_news_title_length']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Sub News Descriptin Length:</td>
<td width="53%" colspan="2" align="left"><input name="sub_news_description_length" type="text" class="txtfld" id="sub_news_description_length" value="<?php echo ($line['sub_news_description_length'])?stripslashes($line['sub_news_description_length']):stripslashes($_POST['sub_news_description_length']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Other News Title Length:</td>
<td width="53%" colspan="2" align="left"><input name="other_news_title_length" type="text" class="txtfld" id="other_news_title_length" value="<?php echo ($line['other_news_title_length'])?stripslashes($line['other_news_title_length']):stripslashes($_POST['other_news_title_length']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Tab - Main News Title Length:</td>
<td width="53%" colspan="2" align="left"><input name="tab_main_news_title_length" type="text" class="txtfld" id="tab_main_news_title_length" value="<?php echo ($line['tab_main_news_title_length'])?stripslashes($line['tab_main_news_title_length']):stripslashes($_POST['tab_main_news_title_length']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Tab - Main News Description Length</td>
<td width="53%" colspan="2" align="left"><input name="tab_main_news_description_length" type="text" class="txtfld" id="tab_main_news_description_length" value="<?php echo ($line['tab_main_news_description_length'])?stripslashes($line['tab_main_news_description_length']):stripslashes($_POST['tab_main_news_description_length']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Tab-Sub News Title Length:</td>
<td width="53%" colspan="2" align="left"><input name="tab_sub_news_title_length" type="text" class="txtfld" id="tab_sub_news_title_length" value="<?php echo ($line['tab_sub_news_title_length'])?stripslashes($line['tab_sub_news_title_length']):stripslashes($_POST['tab_sub_news_title_length']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Sub News Count:</td>
<td width="53%" colspan="2" align="left"><input name="sub_news_count" type="text" class="txtfld" id="sub_news_count" value="<?php echo ($line['sub_news_count'])?stripslashes($line['sub_news_count']):stripslashes($_POST['sub_news_count']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Other News Count:</td>
<td width="53%" colspan="2" align="left"><input name="other_news_count" type="text" class="txtfld" id="other_news_count" value="<?php echo ($line['other_news_count'])?stripslashes($line['other_news_count']):stripslashes($_POST['other_news_count']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Tab News Count:</td>
<td width="53%" colspan="2" align="left"><input name="tab_news_count" type="text" class="txtfld" id="tab_news_count" value="<?php echo ($line['tab_news_count'])?stripslashes($line['tab_news_count']):stripslashes($_POST['tab_news_count']);?>" size="10"/></td>
</tr>
<tr class="oddRow" id="tr_image_title_ml">
<td width="19%" align="right" class="txt">Photo Gallery Banner(Width:355px, Height:Any):<span class="warning">*</span></td>
<td width="28%" align="left">
<input name="gbanner" id="gbanner" type="file" />							</td>
<td width="53%" align="left" class="txt" >
<? 
if($id<>'' && trim($line['gbanner'])<>'')
{
?>
<a id="thumb1" href="../galleries/<?=$line['gbanner'];?>" class="highslide" onClick="return hs.expand(this)"><img src="../galleries/<?=$line['gbanner'];?>" width="40" height="25"></a>
<? 
}
?>						    </td>
</tr>
<tr class="oddRow" id="tr_page_title_ml">
<td width="47%" align="right" class="txt">Photo Gallelry Url:</td>
<td width="53%" colspan="2" align="left"><input name="gurl" type="text" class="txtfld" id="gurl" value="<?php echo ($line['gurl'])?stripslashes($line['gurl']):stripslashes($_POST['gurl']);?>" size="50"/></td>
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