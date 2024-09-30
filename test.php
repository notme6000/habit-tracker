<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?
$strings="dddddddddddddddddddd<html><head><title>testtitle</title></head><body>test data of my vision</body></html>fffffffffff";
$stlen=strlen($strings);
$orginalstringArray=str_split($strings);
echo "<pre>";
print_r($orginalstringArray);
echo "</pre>";
$point=array();
$arrayCount=0;
foreach($orginalstringArray as $arrKey => $arrVal)
{
if($arrVal=="<")
{
$point[$arrayCount]=$arrKey;
$arrayCount++;
}
if($arrVal==">")
{
$point[$arrayCount]=$arrKey;
$arrayCount++;
}
}
$pointCount=count($point);
if($point[$pointCount]<>$stlen)
{
array_push($point,($point[$pointCount-1])+1);
array_push($point,$stlen);
}
if($point[0]<>0)
{
$temp_point=array_reverse($point);
array_push($temp_point,$point[0]-1);
array_push($temp_point,0);
$point=$point=array_reverse($temp_point);
}

/*if(count($startPoint) <> count($endPoint))
{
echo "Invalid Html Tags in this data.";
}*/
print_r($point);
$newArray=array();
for($i=0;$i<count($point);$i=$i+2)
{
//echo $point[$pKey]."-".$point[$pKey+1]."<br>";
echo $ss=substr($strings,$point[$i],$point[($i+1)]);
array_push($newArray,$ss);
}
/*echo "<pre>";
print_r($newArray);
echo "</pre>";*/
?>
</body>
</html>
