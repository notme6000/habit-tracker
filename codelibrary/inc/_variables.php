<?php
ob_start();
session_start();
// Config setting for localhost.
date_default_timezone_set('Asia/Calcutta');
if($_SERVER['HTTP_HOST']=="localhost") 
{
define(DBSERVER,"localhost");
define(DBNAME,"deshabhi_db");
define(DBUSER,"deshabhiman");
define(DBPASS,"Nor4Desh");
define(SITE_URL,"http://deshabhimani.com/");
define(SITE_FS_PATH,$_SERVER['DOCUMENT_ROOT']."/");
} 
else 
{
// Config setting for live server.Added user portohel_user with password port1430#@. 
define(DBSERVER,"localhost");
define(DBNAME,"deshabhi_db");
define(DBUSER,"deshabhiman");
define(DBPASS,"Nor4Desh");
define(SITE_URL,"http://deshabhimani.com/");
define(SITE_FS_PATH,$_SERVER['DOCUMENT_ROOT']."/");
}
// Database Connection Establishment String
$con=mysql_connect(DBSERVER,DBUSER,DBPASS);
// Database Selection String
$db=mysql_select_db(DBNAME,$con);
// Some common settings
define(SITE_TITLE,"Deshabhimani");
define(COPY_BY_NAME,"deshabhimani.com");
define(COPY_BY_LINK,"http://deshabhimani.com/");
define(POWERED_BY_NAME,"Deshabhimani");
define(POWERED_BY_LINK,"http://www.deshabhimani.com/");
define(PAGING_SIZE,15);
define(TODAY,date('Y-m-d H:i:s'));
define(DEFAULT_IMAGE,"img/icons/menu/listing_fields.png");

?>
