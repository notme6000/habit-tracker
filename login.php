<?
require_once("codelibrary/inc/variables.php");
require_once("codelibrary/inc/functions.php");
if($_POST['login'] == "Login"){
	$uname=mysqli_real_escape_string($conn,$_POST['username']);
	$pw=md5(mysqli_real_escape_string($conn,$_POST['password']));
	$sql = "select * from admin where username='".$uname."' and password='".$pw."'";
	$rs = mysqli_query($conn,$sql) or die(mysqli_error());
	if((mysqli_num_rows($rs) > 0))
	{
		$rc = mysqli_fetch_array($rs);
		$_SESSION['sess_admin_id'] = $rc['id'];
		$_SESSION['sess_username'] = strtoupper($rc['username']);
		$_SESSION['sess_accessLevel']=$rc['accessLevel'];
		//include("writexml.php");
		/**************/
		/*if($_SESSION['sess_admin_id']=='1')
		{
		$getCategoryArray=array();
		$getTempCategories=getAll("SELECT * FROM category WHERE 1 ORDER BY priority,parent_id");
		if($getTempCategories)
		{
			foreach($getTempCategories as $gtCatKey => $gtCatVal)
			{
				array_push($getCategoryArray,$gtCatVal['id']);
			}
		}
		$catArrayValue=implode(",",$getCategoryArray);
		
		$getEditionsArray=array();
		$getTempEditions=getAll("SELECT * FROM editions WHERE 1 ORDER BY priority");
		if($getTempEditions)
		{
			foreach($getTempEditions as $gtEdiKey => $gtEdiVal)
			{
				array_push($getEditionsArray,$gtEdiVal['id']);
			}
		}
		$ediArrayValue=implode(",",$getEditionsArray);
		mysql_query("UPDATE admin SET category_access='$catArrayValue',edition_access='$ediArrayValue' WHERE id='".$_SESSION['sess_admin_id']."'");
		}*/
		/**************/
		$ppvisit_ip_address=$_SERVER['REMOTE_ADDR'];
		$ppvisit_time=date('Y-m-d H:i:s');
		$ppuser_type="SECURED";
		$ppurl=$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		$ppref=$_SERVER['HTTP_REFERER'];
		mysqli_query("INSERT visit_data SET visit_time='$ppvisit_time',ip_address='$ppvisit_ip_address',user_type='$ppuser_type',user_name='".$_SESSION['sess_username']."',url='$ppurl',refer_from='$ppref'");
		/*************/
		 mysqli_close($con);
	   	 header("Location: home.php");
		die();
	}
	$_SESSION['error'] = 'Invalid Username/Password';
	 mysqli_close($con);
	   header("Location: index.php");
	   exit();
}
?>