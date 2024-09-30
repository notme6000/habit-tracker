<?php
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
$navigateid='130';
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
  $district_id=(isset($_REQUEST['district_id']))?$_REQUEST['district_id']:"";
  $constituency_id=(isset($_REQUEST['constituency_id']))?$_REQUEST['constituency_id']:"";
  if ($_POST['submitForm'] == "yes")
 {
	foreach($_POST as $pKey => $pVal)
	{
	$pcountArr=explode("_",$pKey);
	if($pcountArr[0]=='votecount')
	{
	$pid=$pcountArr[1];
	if($_POST['winner']=='-1')
	{
	$winner='No';
	}
	else
	{
	if($_POST['winner']==$pid)
	{
	$winner='Yes';
	}
	else
	{
	$winner='No';
	}
	}
	$pvotecount=$pVal;
	$ddate=date('Y-m-d H:i:s');
	mysql_query("UPDATE allcandidates SET vote_count='$pvotecount',winner='$winner',ddate='$ddate' WHERE id='$pid'");
	}
	}
	$_SESSION['success']="Vote Count Updated.";
	 mysql_close($con);
	   header("Location:".$getNavigationData['menu_url']."?district_id=".$district_id."&constituency_id=".$constituency_id);
	exit();
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
<form name="suggest_listing" action="<?=$getNavigationData['menu_url'];?>?district_id=<?=$district_id;?>&constituency_id=<?=$constituency_id;?>" method="post" enctype="multipart/form-data" onsubmit="return validate_form(this);">
<input type="hidden" name="submitForm" value="yes">
<input type="hidden" name="id" class="txtfld" value="<?=$id?>">
<table width="100%" border="0" cellspacing="0" cellpadding="4" align=center  bgcolor="#FFFFFF" class="greyBorder">
<tr class="oddRow">
<td class="txt" align="right" colspan="2" style="border-bottom:3px solid #DADADA;border-top:1px solid #DADADA;"><span class="warning">*</span> - Required Fields</td>
</tr>
<tr class="oddRow">
<td align="left" class="txt" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="4" align=center  bgcolor="#FFFFFF" class="greyBorder">
<tr class="oddRow" id="tr_page_title_gr">
<td align="right" class="txt" colspan="25%" style="background:#DBDBDB;"><strong>District</strong></td>
<td align="left" class="txt" colspan="25%" style="background:#DBDBDB;">
<select name="district_id" id="district_id" onchange="changeAll()" style="width:270px;">
<option value="">Select</option>
<?
$getDistrict=getAll("SELECT * FROM districts WHERE status='A' ORDER BY priority");
foreach($getDistrict as $fKey => $fVal)
{
?>
<option value="<?=$fVal['id'];?>" <?=($district_id==$fVal['id'])?'selected="selected"':'';?>><?=strip_tags($fVal['district_ml']);?></option>
<?
}
?>
</select>
</td>
<td align="right" class="txt" colspan="25%" style="background:#DBDBDB;"><strong>Constituency</strong></td>
<td align="left" class="txt" colspan="25%" style="background:#DBDBDB;">
<select name="constituency_id" id="constituency_id" onchange="changeAll()" style="width:270px;">
<option value="">Select</option>
<?
if($district_id<>'')
{
$getConstituency=getAll("SELECT * FROM constituencies WHERE status='A' AND district_id='$district_id' ORDER BY priority");
//foreach($getCategory as $gcKey => $gcVal)
foreach($getConstituency as $cKey => $cVal)
{
?>
<option value="<?=$cVal['id'];?>" <?=($constituency_id==$cVal['id'])?'selected="selected"':'';?>><?=strip_tags($cVal['constituency_ml']);?></option>
<?
}
}
?>
</select>
</td>
</tr>
<?
if($district_id<>'' && $constituency_id<>'')
{
$getCandidates=getAll("select * from allcandidates where district_id='$district_id' AND constituency_id='$constituency_id' AND status='A' ORDER BY vote_count DESC");
if($getCandidates)
{
?>
<tr class="oddRow" id="tr_page_title_ml">
<td colspan="5%" align="left" class="txt" style="background:#DBDBDB;"><strong>SI#</strong></td>
<td colspan="25%" align="center" class="txt" style="background:#DBDBDB;"><strong>Name[Party]</strong></td>
<td colspan="25%" align="center" class="txt" style="background:#DBDBDB;"><strong>Photo</strong></td>
<td colspan="25%" align="center" class="txt" style="background:#DBDBDB;"><strong>Votes</strong></td>
<td colspan="20%" align="left" class="txt" style="background:#DBDBDB;"><strong><input type="radio" name="winner" value="-1"  /></strong></td>
</tr>
<?
foreach($getCandidates as $cKey => $cVal)
{
?>
<tr class="oddRow" id="tr_page_title_ml">
<td colspan="5%" align="center" class="txt"><?=($cKey+1);?></td>
<td colspan="25%" align="left" class="txt"><?=$cVal['name']."[".$cVal['party']."]";?></td>
<td colspan="25%" align="center" class="txt"><a id="thumb1" href="../galleries/<?=$cVal['photo'];?>" class="highslide" onClick="return hs.expand(this)"><img src="../galleries/<?=$cVal['photo'];?>" width="40" height="25"></a></td>
<td colspan="25%" align="center" class="txt"><input type="text" name="votecount_<?=$cVal['id'];?>" id="votecount_<?=$cVal['id'];?>" value="<?=(trim($cVal['vote_count'])<>'')?$cVal['vote_count']:'0';?>" /></td>
<td colspan="20%" align="left" class="txt"><input type="radio" name="winner" value="<?=$cVal['id'];?>" <?=($cVal['winner']=='Yes')?'checked="checked"':'';?>/></td>
</tr>
<?
}
?>
<tr class="oddRow">
<td align="center" colspan="100%"><?php if((checkPermission($navigateid,'EDIT') && $_REQUEST['id']) || checkPermission($navigateid,'ADD')){?><input type="submit" name="submit" value="Submit" width="82" height="26" /><? }?></td>
</tr>
<?
}
else
{
?>
<tr class="evenRow" id="tr_page_title_gr">
<td align="center" class="txt" colspan="100%" style="border:1px solid #990000;text-align:center;"><strong>No Candidates Listed</strong></td>
</tr>
<?
}
}
else
{
?>
<tr class="evenRow" id="tr_page_title_gr">
<td align="center" class="txt" colspan="100%" style="border:1px solid #990000;text-align:center;"><strong>SELECT A DISTRICT AND CONSTITUENCY</strong></td>
</tr>
<?
}
?>
</table>
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
<script language="javascript">
function changeAll()
{
var district_id=document.getElementById('district_id').value;
var constituency_id=document.getElementById('constituency_id').value;
window.location="<?=$getNavigationData['menu_url'];?>?district_id="+district_id+'&constituency_id='+constituency_id;
}
</script>
</body>
</html>