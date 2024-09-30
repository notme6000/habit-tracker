<?php 
session_start();
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
validate_admin();
$arr =$_POST['ids'];
$Submit =$_POST['Submit'];
if(count($arr)>0){
$str_rest_refs=implode(",",$arr);
	if($Submit=='Delete')
	{
		$sql="delete from subcity where city_id in ($str_rest_refs)"; 
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Deleted Successfully";
		$_SESSION['sess_msg']=$sess_msg;
    }
	elseif($Submit=='Activate')
	{
		$sql="update subcity set city_status='A' where city_id in ($str_rest_refs)";
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Activate Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Deactivate')
	{
		$sql="update subcity set city_status='D' where city_id in ($str_rest_refs)"; 
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Deactivate Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
}
else{
	$sess_msg="Please select Check Box";
	$_SESSION['sess_msg']=$sess_msg;
	 mysql_close($con);
	   header("Location: ".$_SERVER['HTTP_REFERER']);
	exit();
}
 mysql_close($con);
	   header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>