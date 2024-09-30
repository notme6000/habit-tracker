<?php
/******************************************************************************
*		File : functions.php                                              *
*       Date Created : Wednesday 11 July 2007, 10:57 AM                       *
*       Date Modified : Wednesday 11 July 2007, 10:57 AM                      *
*       File Comment : This file contain functions which will use in coding.  *
*******************************************************************************/

// to format the textarea data on pages
function getCurrentDateTime()
{
	return date('Y-m-d H:i:s');	
}
function getCurrentDate()
{
	return date('Y-m-d');	
}
function format_paragraph($data)
{
	return "<br>".nl2br($data);
}
// For Executing Query. This function returns a argument which contain recordset 
// object through it user can retrieve values of table.
function executeQuery($con,$sql)
{
	$result = mysqli_query($con,$sql) or die("<span style='FONT-SIZE:11px; FONT-COLOR: #000000; font-family=tahoma;'><center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysqli_error()."'</center></FONT>");
	return $result;
} 
function getAll($con,$sql)
{
	$tempQuery=mysqli_query($con,$sql);
	$tempCount=mysqli_num_rows($con,$tempQuery);
	if($tempCount>0)
	{
	  while($row	=	mysqli_fetch_array($tempQuery))
	  {
		$tempArray[]	=	$row;
	  }
	  return $tempArray;
	}
	else
	{
		return $tempCount;
	}
}
function getRow($con,$sql)
{
	$tempQuery=mysqli_query($con,$sql);
	$tempCount=mysqli_num_rows($tempQuery);
	if($tempCount>0)
	{
	  $tempArray=mysqli_fetch_array($tempQuery);
	  return $tempArray;
	}
	else
	{
		return $tempCount;
	}
}
function getCount($sql)
{
	$tempQuery=mysqli_query($sql);
	$tempCount=mysqli_num_rows($tempQuery);
	return $tempCount;
}
function getField($id,$field)
{
	$qury=mysqli_query($conn,"SELECT * FROM users WHERE id='$id'");
	$quryCount=mysqli_num_rows($qury);
	if($quryCount>0)
	{
		$quryData=mysqli_fetch_assoc($qury);
		return stripslashes($quryData[$field]);
	}
	else
	{
		return "NA";
	}
}
function filterCharacters($text)
{
    $word = "! @ # $ % ^ & * ( ) + = - [ ] \ \\ ' ; / { } | \ : < > ?";
    $strs = explode(' ', $word);
        for($i=0; $i<sizeof($strs); $i++) 
           {   
            $str = $strs[$i];
            $text = str_replace($str,'_',$text);
           }
		   $text=trim($text); 
		   $text=str_replace('"','_',$text);
		   $text=str_replace(' ','_',$text);
		   $text=str_replace('__-','_',$text);
		   $text=str_replace('__','_',$text);
        return strtolower($text);
}  

// This function returns a recordset object that contain first record data.
function getSingleResult($con,$sql)
{
	$response = "";
	$result = mysqli_query($con,$sql) or die("<center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysqli_error()."'</center>");
	if ($line = mysqli_fetch_array($result)) {
		$response = $line['0'];
	} 
	return $response;
} 

// For Executing Query. This function update the table by desired data.
function executeUpdate($con,$sql)
{
	mysqli_query($con,$sql) or die("<center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysqli_error()."'</center>");
}

// It returns the path of current file.
function getCurrentPath()
{
	global $_SERVER;
	return "http://" . $_SERVER['HTTP_HOST'] . getFolder($_SERVER['PHP_SELF']);
}

// This function adjusts the decimal point of argumented parameter and return the adjusted value.
function adjustAfterDecimal($param)
{
	if(strpos($param,'.')== "")
	{
		$final_value=$param.".00";
		return  $final_value;
	}
	$after_decimal  = substr($param , strpos($param,'.')+1, strlen($param) );	
	$before_decimal = substr($param,0 ,  strpos($param,'.'));
	if(strlen($after_decimal)<2)
	{
		if(strlen($after_decimal)==1)
		{
			$final_value=$param."0";
		}
		if(strlen($after_decimal)==0)
		{
			$final_value.="$param.00";
		}
	}
	else
	{
		$trim_value = substr($after_decimal,0,2);
		$final_value.=$before_decimal.".".$trim_value;
	}
	return $final_value;
}	

// This funtion is used for validating the front side users that he is logged in or not.
function validate_user()
{
	if($_SESSION['sess_id']=='')
	{
		ms_redirect("login.php?back=$_SERVER[REQUEST_URI]");
	}
}

// This funtion is used for validating the admin side users that he is logged in or not.
function validate_admin()
{
	if($_SESSION['sess_admin_id']=='')
	{
		ms_redirect("index.php?back=$_SERVER[REQUEST_URI]");
	}
}

// This function is used for redirecting the file on desired file.
function ms_redirect($file, $exit=true, $sess_msg='')
{
	header("Location: $file");
	exit();
	
}
function redirect($url)
{
	/*print('<script type="text/javascript">window.location = "'.$url.'"</script>');*/
	header("location:".$url);
}
// This function is used by the paging functions.
function get_qry_str($over_write_key = array(), $over_write_value= array())
{
	global $_GET;
	$m = $_GET;
	if(is_array($over_write_key)){
		$i=0;
		foreach($over_write_key as $key){
			$m[$key] = $over_write_value[$i];
			$i++;
		}
	}else{
		$m[$over_write_key] = $over_write_value;
	}
	$qry_str = qry_str($m);
	return $qry_str;
} 
// This function is used by the paging functions.
function qry_str($arr, $skip = '')
{
	$s = "?";
	$i = 0;
	foreach($arr as $key => $value) {
		if ($key != $skip) {
			if(is_array($value)){
				foreach($value as $value2){
					if ($i == 0) {
						$s .= "$key%5B%5D=$value2";
					$i = 1;
					} else {
						$s .= "&$key%5B%5D=$value2";
					} 
				}		
			}else{
				if ($i == 0) {
					$s .= "$key=$value";
					$i = 1;
				} else {
					$s .= "&$key=$value";
				} 
			}
		} 
	} 
	return $s;
} 

function cust_send_mail($email_to,$emailto_name,$email_subject,$email_body,$email_from,$reply_to,$html=true)
{
	require_once "class.phpmailer.php";
	global $SITE_NAME;
	$mail = new PHPMailer();
	$mail->IsSMTP(); // send via SMTP
	$mail->Mailer   = "mail"; // SMTP servers

	$mail->From     = $email_from;
	$mail->FromName = $SITE_NAME;
	$mail->AddAddress($email_to,$emailto_name); 
	$mail->AddReplyTo($reply_to,$SITE_NAME);
	$mail->WordWrap = 50;                              // set word wrap
	$mail->IsHTML($html);                               // send as HTML
	$mail->Subject  =  $email_subject;
	$mail->Body     =  $email_body;
	$mail->Send();	
	return true;
	
}
function header1($id)
	{
		$parent=mysqli_query("select parent_id from admin_menu_settings where menu_id='$id'");
		$p_row=mysqli_fetch_assoc($parent);
		$parent_id=$p_row['parent_id'];
		$m_name=mysqli_query("select menu_name from admin_menu_settings where menu_id='$parent_id'");
		$m_row=mysqli_fetch_assoc($m_name);
		$menu_name=$m_row['menu_name'];
		$m_child=mysqli_query("select menu_name from admin_menu_settings where menu_id='$id'");
		$c_row=mysqli_fetch_assoc($m_child);
		$child_name=$c_row['menu_name'];
		return $menu_name." : ".$child_name;
	}
function getAdvertisement($id,$class)
{
$parent=mysqli_query("select * from advertisements where advcategory_id='$id' AND status='A'");
$p_row_count=mysqli_num_rows($parent);
if($p_row_count)
{
$p_row=mysqli_fetch_assoc($parent);
if(trim($p_row['channel'])<>'')
{
?>
<script src="DWConfiguration/ActiveContent/IncludeFiles/AC_RunActiveContent.js" type="text/javascript"></script>

<div class="ad" style="margin-bottom:10px;text-align:center;height:auto;"><?=$p_row['channel'];?></div>
<?
}
else
{
$image=$p_row['image'];
$url=$p_row['url'];
$name=$p_row['name'];
$imagename_array=array_reverse(explode(".",$image));
	if($imagename_array[0]<>'swf')
	{
	echo '<div class="ad" style="margin-bottom:10px;text-align:center;height:auto;"><a href="'.$url.'" target="_blank"><img src="advertisements/'.$image.'" border="0" title="'.$name.'" alt="'.$name.'" style="width:'.$p_row['width'].'px;height:'.$p_row['height'].'px;"></a></div>';
	}
	else
	{
	?>
	<div class="ad" style="margin:10px 0px; height:auto;">
	<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','<?=$p_row['width'];?>','height','<?=$p_row['height'];?>','src','advertisements/<?=$image;?>','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','advertisements/<?=$image;?>' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?=$p_row['width'];?>" height="<?=$p_row['height'];?>">
	<param name="movie" value="advertisements/<?=$image;?>" />
	<param name="quality" value="high" />
	<embed src="advertisements/<?=$image;?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$p_row['width'];?>" height="<?=$p_row['height'];?>"></embed>
</object></noscript>
	</object>
	<?
	}
}
}
else
{
echo '';
}
}
function getAdvertisements($id)
{
$parent=mysqli_query("select * from advertisements where advcategory_id='$id' AND status='A' ORDER BY priority");
$p_row_count=mysqli_num_rows($parent);
if($p_row_count)
{
while($p_row=mysqli_fetch_assoc($parent))
{
if(trim($p_row['channel'])<>'')
{
?>
<div class="ad" style="margin-bottom:10px;text-align:center;height:auto;"><?=$p_row['channel'];?></div>
<?
}
else
{
$image=$p_row['image'];
$url=$p_row['url'];
$name=$p_row['name'];
$imagename_array=array_reverse(explode(".",$image));
	if($imagename_array[0]<>'swf')
	{
	echo '<div class="ad" style="margin-bottom:10px;text-align:center;height:auto;"><a href="'.$url.'" target="_blank"><img src="advertisements/'.$image.'" border="0" title="'.$name.'" alt="'.$name.'" style="width:'.$p_row['width'].'px;height:'.$p_row['height'].'px;"></a></div>';
	}
	else
	{
	?>
	<div class="ad" style="margin-bottom:10px; height:auto;">
	<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','<?=$p_row['width'];?>','height','<?=$p_row['height'];?>','src','advertisements/<?=$image;?>','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','advertisements/<?=$image;?>' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?=$p_row['width'];?>" height="<?=$p_row['height'];?>">
	<param name="movie" value="advertisements/<?=$image;?>" />
	<param name="quality" value="high" />
	<embed src="advertisements/<?=$image;?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$p_row['width'];?>" height="<?=$p_row['height'];?>"></embed>
</object></noscript>
	</div>
	<?
	}
}
}
}
else
{
echo '';
}
}
function checkPermission($con,$menu_id,$type='VIEW')
   {
	if($type=="VIEW")
	{
		$typeId=0;
	}
	if($type=="ADD")
	{
		$typeId=1;
	}
	if($type=="EDIT")
	{
		$typeId=2;
	}
	if($type=="DELETE")
	{
		$typeId=3;
	}
	if($type=="STATUS")
	{
		$typeId=4;
	}
	$permission_type=substr_replace("_____",'Y',$typeId,'1');
	$checkQuery=mysqli_query($con,"SELECT * FROM admin_menu_permissions WHERE user_id='{$_SESSION['sess_admin_id']}' AND menu_id='$menu_id' AND menu_permission LIKE '$permission_type'");
	$getCheckChildDataCount=mysqli_num_rows($checkQuery);
	if($_SESSION['sess_admin_id']>='1' || $getCheckChildDataCount>0)
	{
		return true;
	}
	else
	{
		return false;
	}
  }
// This function is the replacement of the print_r function. It will work only on the local mode.
function ms_print_r($var)
{
	global $local_mode;
	if ($local_mode || $debug) {
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	}
} 
// This function is used to add slashes to a variable.
function add_slashes($param)
{
	$k_param = addslashes(stripslashes($param));
	return $k_param;
} 
// This function is used to strip slashes to a whole array.
function ms_stripslashes($text)
{
	if (is_array($text)) {
		$tmp_array = Array();
		foreach($text as $key => $value) {
			$tmp_array[$key] = ms_stripslashes($value);
			} 
		return $tmp_array;
	} else {
		return stripslashes($text);
	} 
} 
// This function is used to add slashes to whole array.
function ms_addslashes($text)
{
	if (is_array($text)) {
		$tmp_array = Array();
		foreach($text as $key => $value) {
			$tmp_array[$key] = ms_addslashes($value);
		} 
		return $tmp_array;
	} else {
		return addslashes(stripslashes($text));
	} 
} 
// This function is used to add strip html.
function html2text($html)
{
	$search = array ("'<head[^>]*?>.*?</head>'si", // Strip out javascript
		"'<script[^>]*?>.*?</script>'si", // Strip out javascript
		"'<[\/\!]*?[^<>]*?>'si", // Strip out html tags
		"'([\r\n])[\s]+'", // Strip out white space
		"'&(quot|#34);'i", // Replace html entities
		"'&(amp|#38);'i",
		"'&(lt|#60);'i",
		"'&(gt|#62);'i",
		"'&(nbsp|#160);'i",
		"'&(iexcl|#161);'i",
		"'&(cent|#162);'i",
		"'&(pound|#163);'i",
		"'&(copy|#169);'i",
		"'&#(\d+);'e"); // evaluate as php
	$replace = array ("",
		"",
		"",
		"\\1",
		"\"",
		"&",
		"<",
		">",
		" ",
		chr(161),
		chr(162),
		chr(163),
		chr(169),
		"chr(\\1)");
	$text = preg_replace ($search, $replace, $html); 
	return $text;
} 
// This function is used to generate sorting arrow in a listing.
function sort_arrows($column){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><IMG SRC="images/white_up.gif" BORDER="0"></A> <A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><IMG SRC="images/white_down.gif" BORDER="0"></A>';
}

function sort_arrows_front($column,$heading){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><img src="images/sort_up.gif" alt="Sort Up" border="0" title="Sort Up"></A>&nbsp;'.$heading.'&nbsp;<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><img src="images/sort_down.gif" alt="Sort Down" border="0" title="Sort Down"></A>';
}
// This function is used to unlink a file.
function unlink_file( $file_name , $folder_name )
{
	$file_path = $folder_name."/".$file_name;
	@chmod ($folder_name , 0777);
	@touch($file_path);
	@unlink($file_path);
	return true;	
}
// This function is used to show an image in listing.
function showImage($imageName,$type) {
	if($type=='member'){
		if(is_file(SITE_FS_PATH."/user_images/thumb/".$imageName)) {
			$rtVar = "<img src='../user_images/thumb/".$imageName."'>";
		} else {
			$rtVar ='<img src="images/no-image.jpg" width="107" height="105">';
		}
	}	
	return	$rtVar;
}

function dd_date_format($date) {
	if($date) {
		list($y,$m,$d)=explode("-",$date);		
		return "$m/$d/$y";
	}
}

function resize_img($imgPath, $maxWidth, $maxHeight, $directOutput = true, $quality = 90, $verbose,$imageType)
{
   // get image size infos (0 width and 1 height,
   //     2 is (1 = GIF, 2 = JPG, 3 = PNG)
  
     $size = getimagesize($imgPath);
		$arr=explode(".",$imgPath);		
   // break and return false if failed to read image infos
     if(!$size){
       if($verbose && !$directOutput)echo "<br />Not able to read image infos.<br />";
       return false;
     }

   // relation: width/height
     $relation = $size[0]/$size[1];
	 
	 $relation_original = $relation;
   
   
   // maximal size (if parameter == false, no resizing will be made)
     $maxSize = array($maxWidth?$maxWidth:$size[0],$maxHeight?$maxHeight:$size[1]);
   // declaring array for new size (initial value = original size)
     $newSize = $size;
   // width/height relation
     $relation = array($size[1]/$size[0], $size[0]/$size[1]);


	if(($newSize[0] > $maxWidth))
	{
		
		$newSize[0]=$maxWidth;
		$newSize[1]=$newSize[0]*$relation[0];		
		
	}
	
		//$newSize[0]=$maxWidth;
		//$newSize[1]=$newSize[0]*$relation[0];
		//$newSize[1]=$maxHeight;		
     // create image
       switch($size[2])
       {
         case 1:
           if(function_exists("imagecreatefromgif"))
           {
             $originalImage = imagecreatefromgif($imgPath);
           }else{
             if($verbose && !$directOutput)echo "<br />No GIF support in this php installation, sorry.<br />";
             return false;
           }
           break;
         case 2: $originalImage = imagecreatefromjpeg($imgPath); break;
         case 3: $originalImage = imagecreatefrompng($imgPath); break;
         default:
           if($verbose && !$directOutput)echo "<br />No valid image type.<br />";
           return false;
       }


     // create new image

       $resizedImage = imagecreatetruecolor($newSize[0], $newSize[1]); 

       imagecopyresampled($resizedImage, $originalImage,0, 0, 0, 0,$newSize[0], $newSize[1], $size[0], $size[1]);
		$rz=$imgPath;
     // output or save
       if($directOutput)
		{
         imagejpeg($resizedImage);
		 }
		 else
		{
			
			 $rz=preg_replace("/\.([a-zA-Z]{3,4})$/","".$imageType.".".$arr[count($arr)-1],$imgPath);
         		imagejpeg($resizedImage, $rz, $quality);
         }
     // return true if successfull
       return $rz;
}

// to search the result based on the argument
function search_result($field,$criteria,$keyword)
{
	if($criteria==1) // exact word
	{
		$sql=" and $field='$keyword'";
	}
	else if($criteria==2) // any word starting from it
	{
		$sql=" and $field like '%$keyword%'";
	}
	return $sql;
}

function calcDateDiff ($date1 = 0, $date2 = 0) { 

   // $date1 needs to be greater than $date2. 
   // Otherwise you'll get negative results. 
   
   if ($date2 > $date1) 
       return FALSE; 

    $seconds  = $date1 - $date2; 

   // Calculate each piece using simple subtraction 

  $weeks     = floor($seconds / 604800); 
   $seconds -= $weeks * 604800; 

   $days       = floor($seconds / 86400); 
   $seconds -= $days * 86400; 

   $hours      = floor($seconds / 3600); 
   $seconds -= $hours * 3600; 

   $minutes   = floor($seconds / 60); 
   $seconds -= $minutes * 60; 

   // Return an associative array of results 
   return array( "weeks" => $weeks, "days" => $days, "hours" => $hours, "minutes" => $minutes, "seconds" => $seconds); 
} 
function format_date($date) 
{
	return date('m-d-Y h:i A',strtotime($date));
}

function front_date_format($date) {
	/*if($date) {
		list($y,$m,$d)=explode("-",$date);		
		$front_date=date("d F Y",mktime(0,0,0,$m,$d,$y));
		return $front_date;
	}*/

	if($date!='' && $date!='0000-00-00') {
		//list($y,$m,$d)=explode("-",$date);		
		//return "$m/$d/$y";
		
		$diff = calcDateDiff(time(), $date);
if ($diff = calcDateDiff(time(), $date)) { 

if($diff['weeks']) {
	if($diff['weeks']==1) {
		echo $diff['weeks']." week ago";
	} else {
		echo $diff['weeks']." weeks ago";
	}
}else if($diff['days']) {
	if($diff['days']==1) {
		echo $diff['days']." day ago";
	} else {
		echo $diff['days']." days ago";
	}
} 
else if($diff['hours']){
	if($diff['hours']==1) {
	echo $diff['hours']. " hour ago";
	} else {
	echo $diff['hours']. " hours ago";
	}
} 
else if($diff['minutes']){
	if($diff['minutes']==1) {
	echo $diff['minutes']. " minute ago";
	} else {
	echo $diff['minutes']. " minutes ago";
	}
} 
else  {
 if($diff['seconds']==0)
 echo	"1 second ago";
 else
echo $diff['seconds']. " seconds ago";
}
} 

													
	}
}


function dd_date_format1($date) {
	if($date!='' && $date!='0000-00-00') {
		//list($y,$m,$d)=explode("-",$date);		
		//return "$m/$d/$y";
		
		
if ($diff = calcDateDiff(time(), $date)) { 
if($diff['weeks']) {
	if($diff['weeks']==1) {
		echo $diff['weeks']." week ago";
	} else {
		echo $diff['weeks']." weeks ago";
	}
}
else if($diff['days']) {
	if($diff['days']==1) {
		echo $diff['days']." day ago";
	} else {
		echo $diff['days']." days ago";
	}
} 
else if($diff['hours']){
	if($diff['hours']==1) {
	echo $diff['hours']. " hour ago";
	} else {
	echo $diff['hours']. " hours ago";
	}
}
else if($diff['minutes']){
	if($diff['minutes']==1) {
	echo $diff['minutes']. " minute ago";
	} else {
	echo $diff['minutes']. " minutes ago";
	}
}
 else  {
  if($diff['seconds']==0)
 echo	"1 second ago";
 else
echo	$diff['seconds']. "seconds ago";
}
} 

													
	}
}
	 function sentenceBreak($text,$length,$allowedTags=NULL,$closed=NULL)
	 {
		if($allowedTags==NULL)
		{
			$text=strip_tags(stripslashes($text));
		}
		else
		{
			$text=strip_tags(stripslashes($text),$allowedTags);
		}
		if(strlen($text)>$length)
		{
		  $textpiece=substr($text,0,$length);
		  $spacePos=strripos($textpiece," ");
		  $dotPos=strripos($textpiece,".");
		  $orginalPos=max($spacePos,$dotPos);
		  $orginalText=substr($textpiece,0,$orginalPos)."...";
		  if($closed!=NULL)
		  {
		  $orginalText=$orginalText."</p>";
		  }
		  return $orginalText;
		}
		else
		{
		  return $text;
		}
	 }
	 function sentenceBreakUnicode($text,$length,$allowedTags=NULL,$closed=NULL,$unicode=NULL)
	 {
		$length=($unicode=='Yes')?($length*3):($length*5);
		if($allowedTags==NULL)
		{
			$text=strip_tags(stripslashes($text));
		}
		else
		{
			$text=strip_tags(stripslashes($text),$allowedTags);
		}
		if(strlen($text)>$length)
		{
		  $textpiece=substr($text,0,$length);
		  $spacePos=strripos($textpiece," ");
		  $dotPos=strripos($textpiece,".");
		  $orginalPos=max($spacePos,$dotPos);
		  $orginalText=substr($textpiece,0,$orginalPos)."...";
		  if($closed!=NULL)
		  {
		  $orginalText=$orginalText."</p>";
		  }
		  return $orginalText;
		}
		else
		{
		  return $text;
		}
	 }
	 function sentenceFind($text,$length,$allowedTags=NULL,$search)
	 {
		if($allowedTags==NULL)
		{
			$text=strip_tags(stripslashes($text));
		}
		else
		{
			$text=strip_tags(stripslashes($text),$allowedTags);
		}
		if(strlen($text)>$length)
		{
		  if(stripos($text,$search))
		  {
		  	$textpiece=substr($text,stripos($text,$search),$length);
		  }
		  else
		  {
		  	$textpiece=substr($text,0,$length);
		  }
		  $textpiece=str_replace($search,"<b>".$search."</b>",$textpiece);
		  $spacePos=strripos($textpiece," ");
		  $dotPos=strripos($textpiece,".");
		  $orginalPos=max($spacePos,$dotPos);
		  $orginalText=substr($textpiece,0,$orginalPos)."...";
		  return $orginalText;
		}
		else
		{
		  return $text;
		}
	 }
	 function converttime($timeVal)
	 {
		$hour=floor($timeVal/3600);
		$hourRem=$timeVal%3600;
		$min=floor($hourRem/60);
		$sec=$timeVal%60;
		$newTime=str_pad($hour,2,"0",STR_PAD_LEFT).":".str_pad($min,2,"0",STR_PAD_LEFT).":".str_pad($sec,2,"0",STR_PAD_LEFT);
		return $newTime;
	 }
	/* Added on 27/03/2014 */
	  function getPrevCity($con,$t_title)
	  {
		  $link='https://promptcharters.com/';		  	  	
		  $query1=mysqli_query($con,"select * from city_all where city_name_url='$t_title'");
		  $row1=mysqli_fetch_assoc($query1);
		  $city_id=$row1['city_id'];
		  $query=mysqli_query($con,"select * from city_all where city_id<'$city_id' AND city_status='A' ORDER BY city_id desc LIMIT 0,1");
		  if($row=mysqli_fetch_assoc($query))
		  {
			  return "<a href='".$link.$row['city_name_url'].".html' class='contentfont8'>&larr;&nbsp;See Our&nbsp;".$row['city_name_url']."</a>";
		  }
	  }
	  function getNextCity($con,$t_title)
	  {
	      $link='https://promptcharters.com/';
		  $query1=mysqli_query($con,"select * from city_all where city_name_url='$t_title'");
		  $row1=mysqli_fetch_assoc($query1);
		  $city_id=$row1['city_id'];
		  $query=mysqli_query($con,"select * from city_all where city_id>'$city_id' AND city_status='A' ORDER BY city_id LIMIT 0,1");
		  if($row=mysqli_fetch_assoc($query))
		  {
			  return "<a href='".$link.$row['city_name_url'].".html' class='contentfont8'>See Our&nbsp;".$row['city_name_url']."&nbsp;&rarr;</a>";
		  }
	  }
 /* End  */	 
 	/* Added on 17/02/2017 */
	  function getPrevsubCity($con,$t_title)
	  {
		  $link='https://promptcharters.com/charterbusservice.php?id=';		  	  	
		  $query1=mysqli_query($con,"select * from subcity where subcity='$t_title'");
		  $row1=mysqli_fetch_assoc($query1);
		  $city_id=$row1['id'];
		  $query=mysqli_query($con,"select * from subcity where id<'$city_id' AND city_status='A' ORDER BY id desc LIMIT 0,1");
		  if($row=mysqli_fetch_assoc($query))
		  {
			  return "<a href='".$link.$row['id']."' class='contentfont8'>&larr;&nbsp;See Our Charter Bus Service &nbsp;".$row['subcity']."</a>";
		  }
	  }
	  function getNextsubCity($con,$t_title)
	  {
	      $link='https://promptcharters.com/charterbusservice.php?id=';
		  $query1=mysqli_query($con,"select * from subcity where subcity='$t_title'");
		  $row1=mysqli_fetch_assoc($query1);
		  $city_id=$row1['id'];
		  $query=mysqli_query($con,"select * from subcity where id>'$city_id' AND city_status='A' ORDER BY id LIMIT 0,1");
		  if($row=mysqli_fetch_assoc($query))
		  {
			  return "<a href='".$link.$row['id']."' class='contentfont8'>See Our Charter Bus Service &nbsp;".$row['subcity']."&nbsp;&rarr;</a>";
		  }
	  }
 /* End  */	 
	 function greenMessage($msg)
	 {
	 	echo '<div style="visibility: visible;" id="notification"><div style="border: medium none; position: relative;" class="message notification"><div style="margin: -1px -1px -2px;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 3px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 2px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 1px;"></div></div><div style="border: medium none; position: relative;" class="inner"><div style="margin: -10px -10px 8px -60px;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 2px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 1px;"></div></div><div class="icon">&nbsp;</div><div>'.$msg.'</div><div style="position: absolute; margin: 0pt; padding: 0pt; left: 0pt; bottom: 0pt; width: 100%;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 1px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 2px;"></div></div></div><div style="position: absolute; margin: 0p;t; padding: 0pt; left: 0pt; bottom: 0pt; width: 100%;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 1px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 2px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 3px;"></div></div></div></div>';
	 }
	 function redMessage($msg)
	 {
	 	echo '<div style="visibility: visible;" id="error"><div style="border: medium none; position: relative;" class="message error"><div style="margin: -1px -1px -2px;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 3px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 2px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 1px;"></div></div><div style="border: medium none; position: relative;" class="inner"><div style="margin: -10px -10px 8px -60px;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 2px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 1px;"></div></div><div class="icon">&nbsp;</div><div>'.$msg.'</div><div style="position: absolute; margin: 0pt; padding: 0pt; left: 0pt; bottom: 0pt; width: 100%;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 1px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 2px;"></div></div></div><div style="position: absolute; margin: 0p;t; padding: 0pt; left: 0pt; bottom: 0pt; width: 100%;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 1px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 2px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 3px;"></div></div></div></div>';
	 }
	 function orangeMessage($msg)
	 {
	 	echo '<div style="visibility: visible;" id="alert"><div style="border: medium none; position: relative;" class="message alert"><div style="margin: -1px -1px -2px;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 3px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 2px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 1px;"></div></div><div style="border: medium none; position: relative;" class="inner"><div style="margin: -10px -10px 8px -60px;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 2px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 1px;"></div></div><div class="icon">&nbsp;</div><div>'.$msg.'</div><div style="position: absolute; margin: 0pt; padding: 0pt; left: 0pt; bottom: 0pt; width: 100%;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 1px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(186, 255, 95); border-width: 0pt 2px;"></div></div></div><div style="position: absolute; margin: 0p;t; padding: 0pt; left: 0pt; bottom: 0pt; width: 100%;" class="jquery-corner"><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 1px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 2px;"></div><div style="overflow: hidden; height: 1px; background-color: transparent; border-style: none solid; border-color: rgb(238, 248, 249); border-width: 0pt 3px;"></div></div></div></div>';
	 }

$permission_data=getRow($conn,"SELECT * FROM admin WHERE id='".$_SESSION['sess_admin_id']."'");
$in_array_category_val=explode(",",$permission_data['category_access']);
$in_array_edition_val=explode(",",$permission_data['edition_access']);
$in_category_val=$permission_data['category_access'];
$in_edition_val=$permission_data['edition_access'];	 
?>