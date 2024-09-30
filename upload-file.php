<?php
$ddate=$_GET['ddate'];
$pageno=$_GET['pageno'];
$edition_id=$_GET['edition_id'];
$uploaddir = '../epaper/'; 
$file = $uploaddir .$ddate.basename($_FILES['uploadfile']['name']); 
$size=$_FILES['uploadfile']['size'];
if($size>(1048576*10))
{
	echo "error file size > 10 MB";
	unlink($_FILES['uploadfile']['tmp_name']);
	exit;
}
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
  echo "success"; 
} else {
	echo "error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
}
?>