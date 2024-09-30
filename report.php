<?php
session_start();
require_once("codelibrary/inc/variables.php");
require_once("codelibrary/inc/functions.php");
$navigateid='14';
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
	 mysqli_close($conn);
	 header("Location:index.php");
	 exit();
  }
  $id=(isset($_REQUEST['id']))?$_REQUEST['id']:"";
  if ($_POST['submitForm'] == "yes")
 {  
        $fromdate=$_POST['fromdate'];
  		$todate=$_POST['todate'];
		$habit=$_POST['habit'];
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
<script type="text/javascript">
    function videochange(id)
    {
        document.getElementById("video").src =id;
		tit=document.getElementById(id).title;
		document.getElementById("title").innerHTML = tit;
    }	
</script>
</head>
<body>
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
</div>
<div style="width:100%;float:left;">
<div style="border: medium none;" class="box-caption"><div style="margin: 0px 0px -1px -8px;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(255, 255, 255); border-width: 0pt 1px;"></div></div><?=$getNavigationData['menu_name'].'   ('.date("d-m-Y", strtotime($fromdate)). ' to '. date("d-m-Y", strtotime($todate)).'  )';?></div>
<div class="minmax white-open"></div>
<div style="display: block;" class="box-content">
<form name="suggest_listing" action="<?=$getNavigationData['menu_url'];?>?id=<?=$_GET['id'];?>" method="post" enctype="multipart/form-data" onsubmit="return validate_form(this);">	
	<input type="hidden" name="submitForm" value="yes">
   <div class="col-md-2">
   <input name="fromdate" type="date"  id="myLocalDate" class="form-control input-lg" value=<?=$trdate;?>  />
   </div>
      <div class="col-md-2">
   <input name="todate" type="date"  id="myLocalDate" class="form-control input-lg" value=<?=$trdate;?>  />
   </div>
      <div class="col-md-2">
		<?
        // Query to fetch options from the database
        $sql = "SELECT id, habbit_category FROM habbit_category";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // Output data of each row
            echo '<select name="habit" habbit_category="options" class="form-control input-lg">';
            while($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["habbit_category"] . '">' . $row["habbit_category"] . '</option>';
            }
            echo '</select>';
        } else {
            echo "0 results";
        }
        ?>
   </div>
   
      <div class="col-md-2">
   <input type="submit" name="submit" value="Submit" width="82" height="26" />
   </div>
</form>  
<br /> 
<div>&nbsp;</div>

<div style="clear:both;"></div>
<div style="width:50%;float:left;margin-top:30px;">
<div class="col-md-12 container">
    <div class="col-md-6">
          <div class="list-group" style="max-height:900px; overflow:scroll;">
                    <a class="list-group-item active"> <h3 style="color:#000;">Income</h3> </a>
                   <?	
					  $query = "select * from habit_trans where user_id='$user' and habit='$habit' and habit_date between '$fromdate' and '$todate'";
					  $result = mysqli_query($conn,$query);
			          $tot_income=0;
					  echo "<table>";
					   echo "<tr>";
						  echo "<th>Date----------- </th>";
						  echo "<th>Habit-------------- </th>";
						  echo "<th>Time Begin--------- </th>";
						  echo "<th>Time End</th>";
						  
					   echo "</tr>";
					   while($row = mysqli_fetch_array($result)) 
					   {
						  $td=date("d-m-Y", strtotime($row['trdate']));
						  echo "<tr>";
						  echo "<td> $row[habit_date]</td>";
						  echo "<td> $row[habit]</td>";
						  echo "<td> $row[time_begin]</td>";
						  echo "<td> $row[time_end]</td>";
						  
						  echo "</tr>";
					   }
					 echo "</table>";
 ?>
            
<!--                        <a href="#" class="list-group-item">Second item</a>
            <a href="#" class="list-group-item">Third item</a>
-->                      </div>
        </div>
            <!--script-->

<div class="col-md-6">
          <div class="list-group" style="max-height:900px; overflow:scroll;">
                    <a class="list-group-item active"> <h3 style="color:#000;">Analysis</h3> </a>
                   <?	

					  
					  $query = "select * from settings where user_id='$user'";
					  $result = mysqli_query($conn,$query);
					   while($row = mysqli_fetch_array($result)) 
					   {
						  echo $row['habbit'].'----> ';
						  $habbit=$row['habbit'];
						  $result1 = mysqli_query("select * FROM habit_trans where user_id='$user' and habit='$habbit' and habit_date between '$fromdate' and '$todate'");
						  $rowcount=mysqli_num_rows($result1);
						  if($$rowcount==0) 
							  {
							   echo 'Not Done'.'<br>';	  
							  } else {
							   echo 'Done'.'<br>'; 	  
							  }
					   }
					   
 ?>
            
<!--                        <a href="#" class="list-group-item">Second item</a>
            <a href="#" class="list-group-item">Third item</a>
-->                      </div>
        </div>s              
    </div>

</div>

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