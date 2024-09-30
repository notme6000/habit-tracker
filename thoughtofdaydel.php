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
		$delData=getAll("SELECT * FROM thoughtofday where id in ($str_rest_refs)");
		foreach($delData as $delKey => $delVal)
		{
			$preacher_icon=trim($delVal['preacher_icon']);
			if($preacher_icon<>'')
			{
			
			}			
		}
		$sql="delete from thoughtofday where id in ($str_rest_refs)"; 
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Deleted Successfully";
		$_SESSION['sess_msg']=$sess_msg;
    }
	elseif($Submit=='Activate')
	{
		$sql="update thoughtofday set status='A' where id in ($str_rest_refs)";
		executeUpdate($sql);
		$sess_msg="Selected Record(s) Activate Successfully";
		$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Deactivate')
	{
		$sql="update thoughtofday set status='D' where id in ($str_rest_refs)"; 
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