<?php
ob_start();
session_start();

if($_SERVER['HTTP_HOST']=="localhost") {
	// Config setting for localhost.
	define("DBSERVER","localhost");
	define("DBNAME","project");
	define("DBUSER","root");
	define("DBPASS","");
	define("SITE_URL","http://localhost/project/");
	define("SITE_FS_PATH",$_SERVER['DOCUMENT_ROOT']."/project/");
	define("SITE_PATH","http://localhost/project");
} else {
	// Config setting for live server.
	define("DBSERVER","localhost");
	define("DBNAME","promptdb");
	define("DBUSER","promptdb");
	define("DBPASS","Prompt@nftc14");
	define("SITE_URL","https://www.promptcharters.com/");
	define("SITE_FS_PATH",$_SERVER['DOCUMENT_ROOT']);
	define("SITE_PATH","https://www.promptcharters.com/");
}

// Database Connection Establishment String
//mysql_connect(DBSERVER,DBUSER,DBPASS);
//mysql_select_db(DBNAME);
$conn = mysqli_connect(DBSERVER, DBUSER, DBPASS);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
mysqli_select_db($conn,DBNAME);
//// Some common settings
define('SITE_TITLE',"Project");
define('COPY_BY_NAME',"PMMS");
define('COPY_BY_LINK',"http://www.abc.com/");
define('POWERED_BY_NAME',"abc.com");
define('POWERED_BY_LINK',"http://www.abc.com/");
define('PAGING_SIZE',15);
define('TODAY',date('Y-m-d H:i:s'));
define('DEFAULT_IMAGE',"img/icons/menu/listing_fields.png");
date_default_timezone_set('US/Eastern');
// Turn off error reporting
error_reporting(1);

?>
