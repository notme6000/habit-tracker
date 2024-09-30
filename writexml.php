<?
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
$ddate=(isset($_GET['ddate']))?$_GET['ddate']:date('d-m-Y');
$date_array=explode("-",$ddate);
$nowDate=$date_array[2]."-".$date_array[1]."-".$date_array[0];
/*********************************************************************/
$dom = new DOMDocument("1.0","UTF-8");
header("Content-Type: text/plain");
//<rss>
$rss = $dom->createElement("rss");
$dom->appendChild($rss);
//<version>
$version = $dom->createAttribute("version");
$rss->appendChild($version);
$versionValue = $dom->createTextNode("2.0");
$version->appendChild($versionValue);
//</version>
//<channel>
$channel = $dom->createElement("channel");
$rss->appendChild($channel);
//<title>
$title = $dom->createElement("title");
$channel->appendChild($title);
$titleValue = $dom->createTextNode("Deshabhimani Online Latest News");
$title->appendChild($titleValue);
//</title>
//<link>
$link = $dom->createElement("link");
$channel->appendChild($link);
$linkValue = $dom->createTextNode("http://deshabhimani.com");
$link->appendChild($linkValue);
//</link>
//<description>
$description = $dom->createElement("description");
$channel->appendChild($description);
$descriptionValue = $dom->createTextNode("The latest news from Deshabhimani Online");
$description->appendChild($descriptionValue);
//</description>
//<language>
$language = $dom->createElement("language");
$channel->appendChild($language);
$languageValue = $dom->createTextNode("ml");
$language->appendChild($languageValue);
//</language>
//<copyright>
$copyright = $dom->createElement("copyright");
$channel->appendChild($copyright);
$copyrightValue = $dom->createTextNode("Copyright © deshabhimani 2011  All rights reserved.");
$copyright->appendChild($copyrightValue);
//</copyright>
//<managingEditor>
$managingEditor = $dom->createElement("managingEditor");
$channel->appendChild($managingEditor);
$managingEditorValue = $dom->createTextNode("info@deshabhimani.com");
$managingEditor->appendChild($managingEditorValue);
//</managingEditor>
//<webMaster>
$webMaster = $dom->createElement("webMaster");
$channel->appendChild($webMaster);
$webMasterValue = $dom->createTextNode("vishnu@norfolkllc.com");
$webMaster->appendChild($webMasterValue);
//</webMaster>
//<pubDate>
$pubDate = $dom->createElement("pubDate");
$channel->appendChild($pubDate);
$pubDateValue = $dom->createTextNode(date("d F Y h:i A"));
$pubDate->appendChild($pubDateValue);
//</pubDate>
//<docs>
$docs = $dom->createElement("docs");
$channel->appendChild($docs);
$docsValue = $dom->createTextNode("http://deshabhimani.com/contactus.php");
$docs->appendChild($docsValue);
//</docs>
//<lastBuildDate>
$lastBuildDate = $dom->createElement("lastBuildDate");
$channel->appendChild($lastBuildDate);
$lastBuildDateValue = $dom->createTextNode(date("d F Y h:i A"));
$lastBuildDate->appendChild($lastBuildDateValue);
//</lastBuildDate>
//<category>
$category = $dom->createElement("category");
$channel->appendChild($category);
$categoryValue = $dom->createTextNode("Latest News");
$category->appendChild($categoryValue);
//</category>
//<generator>
$generator = $dom->createElement("generator");
$channel->appendChild($generator);
$generatorValue = $dom->createTextNode("RSS 2.0 generation class");
$generator->appendChild($generatorValue);
//</generator>
//<image>
$image = $dom->createElement("image");
$channel->appendChild($image);
//<url>
$url = $dom->createElement("url");
$image->appendChild($url);
$urlValue = $dom->createTextNode("http://deshabhimani.com/myimages/rsslogo.png");
$url->appendChild($urlValue);
//</url>
//<title>
$imgtitle = $dom->createElement("title");
$image->appendChild($imgtitle);
$imgtitleValue = $dom->createTextNode("Deshabhimani Online Latest News");
$imgtitle->appendChild($imgtitleValue);
//</title>
//<link>
$imglink = $dom->createElement("link");
$image->appendChild($imglink);
$imglinkValue = $dom->createTextNode("http://deshabhimani.com");
$imglink->appendChild($imglinkValue);
//</link>
//</image>
/*$getLatestNews=getAll("SELECT * FROM news WHERE ('$nowDate' BETWEEN fromdate AND todate) AND status='A' AND (news_category2='15' OR news_category2='16' OR news_category2='17') ORDER BY updated_on DESC LIMIT 0,10");*/
$getLatestNews=getAll("SELECT * FROM news WHERE id='134736'");
if($getLatestNews)
{
foreach($getLatestNews as $gKey => $gVal)
{
//<item>
$titem = $dom->createElement("item");
$channel->appendChild($titem);
//<title>
$ttitle = $dom->createElement("title");
$titem->appendChild($ttitle);
$ttitleValue = $dom->createTextNode(strip_tags($gVal['news_title']));
//$ttitleValue = $dom->createTextNode("Test");
$ttitle->appendChild($ttitleValue);
//</title>
//<link>
$tlink = $dom->createElement("link");
$titem->appendChild($tlink);
$tlinkValue = $dom->createTextNode("http://deshabhimani.com/newscontent.php?id=".$gVal['id']);
$tlink->appendChild($tlinkValue);
//</link>
//<description>
$tdescription = $dom->createElement("description");
$titem->appendChild($tdescription);
$tdescriptionValue = $dom->createTextNode(strip_tags($gVal['news_description']));
//$tdescriptionValue = $dom->createTextNode("DESC");
$tdescription->appendChild($tdescriptionValue);
//</description>
//</item>
}
}
//</channel>
//</rss>
$dom->save("../xml/rssfeed.xml");