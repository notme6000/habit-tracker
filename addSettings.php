<?php
require_once("codelibrary/inc/variables.php");
require_once("codelibrary/inc/functions.php");
$navigateid='10';
$getNavigationData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$navigateid'");
$nextNavigateId=$navigateid+1;
$getNavigationDataNext=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$nextNavigateId'");
//$getNavigationData=mysql_fetch_assoc($getNavigationDataQuery);
$parent_id=$getNavigationData['parent_id'];
$getNavigationParentData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$parent_id'");
//$getNavigationParentData=mysql_fetch_assoc($getNavigationParentDataQuery);
$user=$_SESSION['sess_admin_id'];
if(isset($_SESSION['sess_admin_id']))
  {
	if(!checkPermission($conn,$navigateid))
	 {
	   $_SESSION['sess_msg']="Access Denied!!!";
	   mysql_close($conn);
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
 // $id=(isset($_REQUEST['id']))?$_REQUEST['id']:"";
  if ($_POST['submitForm'] == "yes")
 {  
      $habbit=$_POST['habbit'];
	  $habbit_time=$_POST['habbit_time'];
		
$sql="SELECT * from settings WHERE user_id='$user'";

	if ($result=mysqli_query($conn,$sql))
	  {
	  // Return the number of rows in result set
	  $rowcount=mysqli_num_rows($result);
	  //printf("Result set has %d rows.\n",$rowcount);
	  // Free result set
	  //mysqli_free_result($result);
	  }		
		if(mysqli_query($conn,"INSERT INTO settings (user_id, habbit, habbit_time) VALUES ('$user', '$habbit', '$habbit_time')"))
		{
			$_SESSION['success']=$counts."Settings updated !";
			mysqli_close($conn);
			header("Location:".$getNavigationData['menu_url']);
			exit();
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
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
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
<? include("header.inc.php");
 ?>
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
<div style="width:50%;float:left;">
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
<input name="tdate" type="text" class="txtfld" id="tdate" value="<?=$tdate;?>" size="12" maxlength="12" /></td>
</tr>-->
<tr class="oddRow">
<td width="17%" align="right" class="txt">Habbit:</td>
<td width="83%" colspan="3" align="left">
<?
// Query to fetch options from the database
$sql = "SELECT id, habbit_category FROM habbit_category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    echo '<select name="habbit" habbit_category="options" class="form-control input-lg">';
    while($row = $result->fetch_assoc()) {
        echo '<option value="' . $row["habbit_category"] . '">' . $row["habbit_category"] . '</option>';
    }
    echo '</select>';
} else {
    echo "0 results";
}
?>
</td>
</tr>
<tr class="oddRow" id="tr_page_title_gr">
<td width="17%" align="right" class="txt">Habbit Time:</td>
<td width="83%" colspan="3" align="left">
<input name="habbit_time" type="time"  id="myLocalTime" class="form-control input-lg" value=<?=$habbit_time;?>  />
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
<div style="width:45%;float:left;margin-left:10px;">
<div class="col-md-5 container">
    <div class="col-md-12">
          <div class="list-group" style="max-height:1000px; overflow:scroll;">
                    <a class="list-group-item active"> <h3 style="color:#000;">Settings</h3> </a>
                    <?	
					  $query = "select * from settings where user_id='$user'";
					  $result = mysqli_query($conn,$query);
			          $tot_expense = 0;
					  echo "<table>";
					   echo "<tr>";
						  echo '<th width=100>Habbit-- </th>';
						  echo '<th width=100>Habbit Time </th>';
					   echo "</tr>";
					   while($row = mysqli_fetch_array($result)) 
					   {
						  $td=date("d-m-Y", strtotime($row['trdate']));
						  echo "<tr>";
						  //echo "<td> $td </td>";
						  echo "<td width='100'>$row[habbit]</td>";
						  echo "<td width='100'> $row[habbit_time]</td>";
						  echo "</tr>";
					   }
 ?>
            
<!--                        <a href="#" class="list-group-item">Second item</a>
            <a href="#" class="list-group-item">Third item</a>
-->                      </div>
        </div>
            <!--script-->
        
    </div>

</div>

</div>

	<!-- right column end -->
<div style="clear:both;"></div>

</div>
<!-- content end -->
<div style="clear:both;"></div>
<? include("footer.inc.php");?>
</body>
</html>