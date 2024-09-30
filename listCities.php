<?php
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
$navigateid='169';
$delUrl="citiesdel.php";
$getNavigationData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$navigateid'");
$nextNavigateId=$navigateid-1;
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
<script type="text/javascript">
intelli.admin.lang = intelli.admin.lang['en'];
</script>
<script language="JavaScript" type="text/JavaScript">
/*function changeCategory(val)
{
	mybookinstance.selectpage(0);
	window.location="listPhotos.php?gallery_id="+val;
}*/
function checkall(objForm)
{
	len = objForm.elements.length;
	var i=0;
	for( i=0 ; i<len ; i++){
		if (objForm.elements[i].type=='checkbox') 
			objForm.elements[i].checked=objForm.check_all.checked;
	}
}

function del_prompt(frmobj,comb)
{
	if(comb=='Delete'){
		if(confirm ("Are you sure you want to delete Record(s)")){
			frmobj.action = "<?=$delUrl;?>";
			frmobj.submit();
		}
		else{ 
			return false;
		}
	}
	
	else if(comb=='Deactivate'){
		frmobj.action = "<?=$delUrl;?>";
		frmobj.submit();
	}
	else if(comb=='Activate'){
		frmobj.action = "<?=$delUrl;?>";
		frmobj.submit();
	
	}
}
function setNumber()
{
	var num=document.getElementById('num').value;
	setCookie('c_num',num,'7');
	window.location="<?=$delUrl;?>";
}
function setCookie(c_name,value,expiredays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate()+expiredays);
document.cookie=c_name+ "=" +escape(value)+
((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}
// added on 18/03/18
function changeValue()
{
	var sid=document.getElementById('state_id').value;
	//var pageno=document.getElementById('pageno').value;
	window.location = 'listCities.php?sid='+sid; 
}
</script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript" src="highslide/highslide.js"></script>
<link rel="stylesheet" type="text/css" href="paginate/ajaxpagination.css" />
<script src="paginate/ajaxpagination.js" type="text/javascript"></script>
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
<div style="text-align:right;padding-bottom:4px;">
No Rows :&nbsp;<?
if(isset($_COOKIE['c_num']) && $_COOKIE['c_num']<>'')
{
 $numSize=$_COOKIE['c_num']; 
}
else
{
 $numSize=PAGING_SIZE;
}
?>
<input type="text" name="num" id="num" value="<?=$numSize;?>" maxlength="3" size="3"/>&nbsp;<input type="button" name="setnumber" id="setnumber" value="SET" onclick="setNumber();" />
</div>
<div style="text-align: left;padding-bottom:4px;">
<select name="state_id" id="state_id" onchange="changeValue()">
	   <option value="">Select State</option>
	   <?php
		 $ctry_sql="SELECT * FROM states where status='A' order by state";
		 $result_ctry=executequery($ctry_sql);
		 while($ctry_array=ms_stripslashes(mysql_fetch_array($result_ctry)))
		   {
			 $sel_ctry=($line['state_id'])?$line['state_id']:$_REQUEST['sid'];
			 $sel_cny=($ctry_array['state_id']==$sel_ctry)? " selected='selected'" : " ";
			 echo '<option value='.$ctry_array['state_id'].''.$sel_cny.'>'.$ctry_array['state'].'</option>';
		   }
	  ?>
	  </select>
</div>

<div id="paginate-top"></div>
<div id="bookcontent"></div>
<div id="paginate-bottom"></div>
<?
$sid=(isset($_REQUEST['sid']))?$_REQUEST['sid']:"";
$where="WHERE state_id='$sid'";
$pageArray=array();
$dataQuery=mysql_query("select * from cities

 ".$where);
$dataCount=mysql_num_rows($dataQuery);
if($dataCount)
{
$pagesize=$numSize;
$pages=ceil($dataCount/$pagesize);
for($i=0;$i<$pages;$i++)
{
array_push($pageArray,'"templateListCities.php?start='.$i.'&pagesize='.$pagesize.'&where='.$where.'&navigateid='.$navigateid.'"');
}
}
else
{
array_push($pageArray,'"noData.php"');
}
?>
<script type="text/javascript">
var bookcombo={
pages: [<?=implode(',',$pageArray);?>],
selectedpage: 0 //set page shown by default (0=1st page)
}
var mybookinstance=new ajaxpageclass.createBook(bookcombo, "bookcontent", ["paginate-top", "paginate-bottom"])
</script>
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