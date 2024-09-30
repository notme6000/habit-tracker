<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?
echo $strings="vishnu<html>my<head><title>testtitle</title></head><body>test data of m'y vision</body></html>fffffffffff";
$stlen=strlen($strings);
$orginalstringArray=str_split($strings);
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
$remPointArray=array();
for($si=0;$si<count($point);$si=$si+2)
{
if($si<>0)
{
if(($point[($si-1)]+1)<>$point[$si])
{
array_push($remPointArray,$point[($si-1)]+1);
array_push($remPointArray,$point[$si]-1);
}
}
}
$pArray=array_merge($point,$remPointArray);
sort($pArray);
//print_r($pArray);
$sarray=array();
for($ti=0;$ti<count($pArray);$ti=$ti+2)
{
$ccount=($pArray[($ti+1)]+1)-$pArray[$ti];
$data=substr($strings,$pArray[$ti],$ccount);
//array_push($sarray,htmlentities($data));
array_push($sarray,$data);
}
foreach($sarray as $ssKey => $ssVal)
{

}
?>
</body>
</html>
