<?php
require_once("codelibrary/inc/variables.php");
require_once("codelibrary/inc/functions.php");
$navigateid='4';
$getNavigationData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$navigateid'");
$parent_id=$getNavigationData['parent_id'];
$getNavigationParentData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$parent_id'");
//$getNavigationParentData=mysql_fetch_assoc($getNavigationParentDataQuery);
if(isset($_SESSION['sess_admin_id']))
  {
	if(!checkPermission($conn,$navigateid))
	 {
	   $_SESSION['sess_msg']="Access Denied!!!";
	    mysqli_close($conn);
	   header("Location:index.php");
	   exit();
	 }
  }
else
  {
  	 $_SESSION['sess_msg']="Login Again!!!";
	  mysqli_close($conn);
	   header("Location:index.php");
	 exit();
  }
$id=(isset($_REQUEST['id']))?$_REQUEST['id']:"";
$sqlAdminLogin ="select * from admin where id<>'1' AND id<>'{$_SESSION['sess_admin_id']}'";
$sqlMenuSettings = mysqli_query($conn,"select * from admin_menu_settings where parent_id='-1' AND menu_status='A' order by menu_priority");
if(isset($_POST['submit']))
{
mysqli_query($conn,"UPDATE admin_menu_permissions SET menu_permission='NNNNN',delete_status='-1' WHERE user_id='$id'");
$post_cat_array=array();
$post_edi_array=array();
foreach($_POST as $pKey =>$pVal)
{
$pArr=explode("_",$pKey);
//pree($_POST);
if($pArr[0]=='child')
{
$tpid=$pArr[1];
$tid=$pArr[2];
$tper=array();
for($i=1;$i<=5;$i++)
{
if(isset($_POST['childEach_'.$tpid.'_'.$tid.'_'.$i]))
{
array_push($tper,'Y');
}
else
{
array_push($tper,'N');
}
}
$tpermission=implode('',$tper);
$qry_prmsn=mysqli_query($conn,"select * from admin_menu_permissions where user_id='$id' AND menu_parent_id='$tpid' AND menu_id='$tid'");
$getExistCount=mysqli_num_rows($conn,$qry_prmsn);
if($getExistCount>0)
{
mysqli_query($conn,"UPDATE admin_menu_permissions SET menu_permission='$tpermission',delete_status='1' WHERE user_id='$id' AND menu_parent_id='$tpid' AND menu_id='$tid'");
}
else
{
mysqli_query($conn,"INSERT INTO admin_menu_permissions SET user_id='$id',menu_parent_id='$tpid',menu_id='$tid',menu_permission='$tpermission',delete_status='1'");
}
}
/****************/
if($pArr[0]=='category')
{
if($pVal=='Yes')
{
array_push($post_cat_array,$pArr[1]);
}
}
/*************************/
if($pArr[0]=='edition')
{
if($pVal=='Yes')
{
array_push($post_edi_array,$pArr[1]);
}
}
/*************************/
}
$post_cat_val=implode(",",$post_cat_array);
$post_edi_val=implode(",",$post_edi_array);
mysqli_query($conn,"UPDATE admin SET category_access='$post_cat_val',edition_access='$post_edi_val' WHERE id='$id'");
mysqli_query($conn,"DELETE FROM admin_menu_permissions WHERE delete_status='-1' AND user_id='$id'");
$_SESSION['success']="Permission Updated!!!";
 mysqli_close($conn);
	   header("location:menuPermission.php?id=".$id);
exit();
}

if(checkPermission($navigateid,'EDIT') || checkPermission($navigateid,'VIEW') )
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Admin Panel&nbsp;:: Powered by <?=POWERED_BY_NAME;?></title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<base href="<?=SITE_URL;?>/" />
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
<tr bgcolor="#F2F2F2">
<td align="center" colspan="4" class="txt">Username :
<select name="id" id="id" class="listxbx" onChange="window.location='menuPermission.php?id='+this.value">
<option value="" selected>Select</option>
<?php
$result_login=executequery($conn,$sqlAdminLogin);
while($login_array=ms_stripslashes(mysqli_fetch_array($result_login)))
{
$sel_con=($login_array['id']==$_REQUEST['id'])? " selected='selected'" : " ";
echo '<option value='.$login_array['id'].''.$sel_con.'>'.$login_array['username'].'</option>';
}
?>
</select>
</td>
</tr>
<?
$getCategories=getAll($conn,"SELECT * FROM category WHERE 1 ORDER BY id,category");
if($getCategories && $id<>'')
{
$getAdminDetails=getRow($conn,"SELECT * FROM admin WHERE id='$id'");
?>
<tr class="oddRow">
<td width="18%" style="vertical-align:top;text-align:right;">&nbsp;</td>
<td width="82%">
<table class="subBox1" width="80%" border="0" cellspacing="1" cellpadding="2" bgcolor="#4096AF">
<tr height="25px" class="whitebackground" bgcolor="#6699CC">
<td width="70"><b>SI NO</b></td>
<td width="196"><b>CATEGORIES</b></td>
<td width="415" align="center"><b>ACCESS</b></td>
</tr>
<?
foreach($getCategories as $gCatKey => $gCatVal)
{
if($gCatVal['parent_id']=='1')
{
$color='#FCEBE0';
}
else if($gCatVal['parent_id']=='3')
{
$color='#DCF5CB';
}
else
{
$color='#F5F5F5';
}
?>
<tr bgcolor="<?=$color;?>">
<td style="padding-right:10px;text-align:center;"><?=($gCatKey+1);?></td>
<td style="padding-left:10px;text-align:left;"><?=strtoupper($gCatVal['category']);?></td>
<td width="415">
<?
$categoryAccessArray=explode(",",$getAdminDetails['category_access']);
$catTempVal=(in_array($gCatVal['id'],$categoryAccessArray))?"Yes":"No";
?>
&nbsp;&nbsp;Yes&nbsp;<input type="radio" name="category_<?=$gCatVal['id'];?>" value="Yes" <?=($catTempVal=='Yes')?'checked="checked"':'';?> />&nbsp;&nbsp;No&nbsp;<input type="radio" name="category_<?=$gCatVal['id'];?>" value="No" <?=($catTempVal=='No')?'checked="checked"':'';?> />
   
</td>
</tr>
<?
}
?>
</table>
</td>
</tr>        
<?
}
?>
<?
if($id<>'')
{
if((mysqli_num_rows($conn,$sqlMenuSettings))>0)
{
while($menuVal=mysqli_fetch_array($conn,$sqlMenuSettings))
{
?>
<tr bgcolor="#F2F2F2">
<td width="18%" style="vertical-align:top;text-align:right;">
<?
$qry_parent_prmsn=mysqli_query($conn,"select * from admin_menu_permissions where user_id='$id' AND menu_parent_id='{$menuVal['menu_id']}' AND menu_permission LIKE '%Y%'");
$getParentDataCount=mysqli_num_rows($conn,$qry_parent_prmsn);
?>
<input type="checkbox" name="parent_<?php echo $menuVal['menu_id'];?>" id="parent_<?php echo $menuVal['menu_id'];?>" value="<?php echo $menuVal['menu_id'];?>" onClick="parentClick('<?php echo $menuVal['menu_id'];?>')" <?=($getParentDataCount>0)?"checked='checked'":"";?>/></td>
<td width="82%" colspan="3" align="left" style="vertical-align:top;">
<?php
$mi=$menuVal['menu_id'];
$sqlSubMenu=mysqli_query($conn,"select * from admin_menu_settings where parent_id='$mi' AND menu_status='A' order by menu_priority");
$sqlSubMenucount=mysqli_num_rows($conn,$sqlSubMenu);
if($sqlSubMenucount)
{
?>
<table class="subBox1" width="80%" border="0" cellspacing="1" cellpadding="2" bgcolor="#4096AF">
<tr height="25px" class="whitebackground" bgcolor="#6699CC">
<td width="366"><b><?php echo strtoupper($menuVal['menu_name']);?></b></td>
<td width="42" align="center"><b>VIEW</b></td>
<td width="35" align="center"><b>ADD</b></td>
<td width="38" align="center"><b>EDIT</b></td>
<td width="62" align="center"><b>DELETE</b></td>
<td width="60" align="center"><b>STATUS</b></td>
</tr>
<?php
while($subMenuVal=mysqli_fetch_array($conn,$sqlSubMenu))
{
?>
<tr bgcolor="#F5F5F5">
<td style="vertical-align:top;" class="txt">
<?
$qry_child_prmsn=mysqli_query($conn,"select * from admin_menu_permissions where user_id='$id' AND menu_parent_id='{$subMenuVal['parent_id']}' AND menu_id='{$subMenuVal['menu_id']}' AND menu_permission LIKE '%Y%'");
$getChildDataCount=mysqli_num_rows($conn,$qry_child_prmsn);
?>
<input type="checkbox" name="child_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>" id="child_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>" value="<?php echo $subMenuVal['menu_id'];?>" onClick="childClick('<?php echo $subMenuVal['parent_id'];?>','<?php echo $subMenuVal['menu_id'];?>')" <?=($getChildDataCount>0)?"checked='checked'":"";?>/><?php echo $subMenuVal['menu_name'];?> </td>
<td  align="center" style="vertical-align:top;">
<?
$qry_child_each_data=mysqli_query($conn,"select * from admin_menu_permissions where user_id='$id' AND menu_parent_id='{$subMenuVal['parent_id']}' AND menu_id='{$subMenuVal['menu_id']}' AND menu_permission LIKE 'Y____'");
$getChildEachDataCount1=mysqli_num_rows($conn,$qry_child_each_data);
?>
<input type="checkbox" name="childEach_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>_1" id="childEach_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>_1" value="" onClick="childEachClick('<?php echo $subMenuVal['parent_id'];?>','<?php echo $subMenuVal['menu_id'];?>','1')" <?=($getChildEachDataCount1>0)?"checked='checked'":"";?>/></td>
<td  align="center" style="vertical-align:top;">
<?
$qry_child_each_data2=mysqli_query($conn,"select * from admin_menu_permissions where user_id='$id' AND menu_parent_id='{$subMenuVal['parent_id']}' AND menu_id='{$subMenuVal['menu_id']}' AND menu_permission LIKE '_Y___'");
$getChildEachDataCount2=mysqli_num_rows($conn,$qry_child_each_data2);
?>
<input type="checkbox" name="childEach_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>_2" id="childEach_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>_2" value="" onClick="childEachClick('<?php echo $subMenuVal['parent_id'];?>','<?php echo $subMenuVal['menu_id'];?>','2')" <?=($getChildEachDataCount2>0)?"checked='checked'":"";?>/></td>
<td  align="center" style="vertical-align:top;">
<?
$qry_child_each_data3=mysqli_query($conn,"select * from admin_menu_permissions where user_id='$id' AND menu_parent_id='{$subMenuVal['parent_id']}' AND menu_id='{$subMenuVal['menu_id']}' AND menu_permission LIKE '__Y__'");
$getChildEachDataCount3=mysqli_num_rows($conn,$qry_child_each_data3);
?>
<input type="checkbox" name="childEach_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>_3" id="childEach_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>_3" value="" onClick="childEachClick('<?php echo $subMenuVal['parent_id'];?>','<?php echo $subMenuVal['menu_id'];?>','3')" <?=($getChildEachDataCount3>0)?"checked='checked'":"";?>/></td>
<td  align="center" style="vertical-align:top;">
<?
$qry_child_each_data4=mysqli_query($conn,"select * from admin_menu_permissions where user_id='$id' AND menu_parent_id='{$subMenuVal['parent_id']}' AND menu_id='{$subMenuVal['menu_id']}' AND menu_permission LIKE '___Y_'");
$getChildEachDataCount4=mysqli_num_rows($conn,$qry_child_each_data4);
?>
<input type="checkbox" name="childEach_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>_4" id="childEach_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>_4" value="" onClick="childEachClick('<?php echo $subMenuVal['parent_id'];?>','<?php echo $subMenuVal['menu_id'];?>','4')" <?=($getChildEachDataCount4>0)?"checked='checked'":"";?>/></td>
<td  align="center" style="vertical-align:top;">
<?
$qry_child_each_data5=mysqli_query($conn,"select * from admin_menu_permissions where user_id='$id' AND menu_parent_id='{$subMenuVal['parent_id']}' AND menu_id='{$subMenuVal['menu_id']}' AND menu_permission LIKE '____Y'");
$getChildEachDataCount5=mysqli_num_rows($conn,$qry_child_each_data5);
?>
<input type="checkbox" name="childEach_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>_5" id="childEach_<?php echo $subMenuVal['parent_id'];?>_<?php echo $subMenuVal['menu_id'];?>_5" value="" onClick="childEachClick('<?php echo $subMenuVal['parent_id'];?>','<?php echo $subMenuVal['menu_id'];?>','5')" <?=($getChildEachDataCount5>0)?"checked='checked'":"";?>/></td>
</tr>
<?php
}
?>
</table>
<?php
}
?>
</td></tr>
<?php
}
}
}
?>  
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
<SCRIPT language="javascript">
function parentClick(id)
{	 
	var parentBox=document.getElementById('parent_'+id);
	if(parentBox.checked==true)
	{
		for(var i=1;i<=200;i++)
		{
			if(document.getElementById('child_'+id+'_'+i))
			{
				document.getElementById('child_'+id+'_'+i).checked=true;
				for(var j=1;j<=5;j++)
				{
					document.getElementById('childEach_'+id+'_'+i+'_'+j).checked=true;
				}
			}
		}
	}
	else
	{
		for(var i=1;i<=200;i++)
		{
			if(document.getElementById('child_'+id+'_'+i))
			{
				document.getElementById('child_'+id+'_'+i).checked=false;
				for(var j=1;j<=5;j++)
				{
					document.getElementById('childEach_'+id+'_'+i+'_'+j).checked=false;
				}
			}
		}
	}
}
function childClick(parentid,id)
{	 
	//alert(id+" - "+type);
	var activeChild=0;
	var parentBox=document.getElementById('parent_'+parentid);
	var childBox=document.getElementById('child_'+parentid+'_'+id);
	
	if(childBox.checked==true)
	{
		for(var i=1;i<=5;i++)
		{
			//alert('childEach_'+parentid+'_'+id+'_'+i);
			if(document.getElementById('childEach_'+parentid+'_'+id+'_'+i))
			{
				document.getElementById('childEach_'+parentid+'_'+id+'_'+i).checked=true
			}
		}
	}
	else
	{
		for(var i=1;i<=5;i++)
		{
			if(document.getElementById('childEach_'+parentid+'_'+id+'_'+i))
			{
				document.getElementById('childEach_'+parentid+'_'+id+'_'+i).checked=false
			}
		}

	}
	for(var i=1;i<=200;i++)
	{
		if(document.getElementById('child_'+parentid+'_'+i))
		{
			if(document.getElementById('child_'+parentid+'_'+i).checked==true)
			{
				activeChild++;
			}
		}
	}
	if(activeChild>0)
	{
		parentBox.checked=true;
	}
	else
	{
		parentBox.checked=false;
	}
}	
function childEachClick(parentid,id,type)
{	 
	//alert(id+" - "+type);
	var activeChild=0;
	var parentBox=document.getElementById('parent_'+parentid);
	var childBox=document.getElementById('child_'+parentid+'_'+id);
	if((type==3 || type==4 || type==5) && (document.getElementById('childEach_'+parentid+'_'+id+'_'+type).checked==true))
	{
		document.getElementById('childEach_'+parentid+'_'+id+'_1').checked=true;
	}
	if((type==2) && (document.getElementById('childEach_'+parentid+'_'+id+'_'+type).checked==true))
	{
		document.getElementById('childEach_'+parentid+'_'+id+'_1').checked=true;
	}
	if((type==1) && (document.getElementById('childEach_'+parentid+'_'+id+'_'+type).checked==false))
	{
		for(var i=2;i<=5;i++)
		{
			document.getElementById('childEach_'+parentid+'_'+id+'_'+i).checked=false;
		}
	}
	for(var i=1;i<=5;i++)
	{
		if(document.getElementById('childEach_'+parentid+'_'+id+'_'+i))
		{
			if(document.getElementById('childEach_'+parentid+'_'+id+'_'+i).checked==true)
			{
				activeChild++;
			}
		}
	}
	if(activeChild>0)
	{
		childBox.checked=true;
	}
	else
	{
		childBox.checked=false;
	}
	for(var i=1;i<=200;i++)
	{
		if(document.getElementById('child_'+parentid+'_'+i))
		{
			if(document.getElementById('child_'+parentid+'_'+i).checked==true)
			{
				activeSecondChild++;
			}
		}
	}
	if(activeSecondChild>0)
	{
		parentBox.checked=true;
	}
	else
	{
		parentBox.checked=false;
	}
}	
</SCRIPT>
<!-- content end -->
<? include("footer.inc.php");?>
</body>
</html>
<?
}
?>