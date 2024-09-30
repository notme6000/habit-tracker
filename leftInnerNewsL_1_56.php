<?
require_once("codelibrary/inc/variables.php");
require_once("codelibrary/inc/functions.php");
$nowDate=date('Y-m-d');
$settings=getRow($conn,"SELECT * FROM settings WHERE id='1'");
$specialsettings=getRow($conn,"SELECT * FROM specialsettings WHERE id='1'");
$defaults=isset($_GET['defaults'])?$_GET['defaults']:'1|56';
$splitDefaults=explode("|",$defaults);
$category=isset($_GET['category'])?$_GET['category']:$splitDefaults[0];
$value=isset($_GET['value'])?$_GET['value']:$splitDefaults[1];
$p=isset($_GET['p'])?$_GET['p']:"L";
if($category=='2')
{
$condition=" AND news_category2='$value'";
}
elseif($category=='3')
{
$condition=" AND news_category3='$value'";
}
else
{
$condition=" AND news_category='$value'";
}
$getTabFirstNews=getRow($conn,"SELECT * FROM news WHERE ('$nowDate' BETWEEN fromdate AND todate)".$condition." AND status='A' ORDER BY priority,updated_on DESC LIMIT 0,1");
$getTabAllNews=getAll($conn,"SELECT * FROM news WHERE ('$nowDate' BETWEEN fromdate AND todate)".$condition." AND status='A' ORDER BY priority,updated_on DESC LIMIT 1,".$settings['tab_news_count']);
?>
<div class="newssectionmenusnewstop" <?=($p=='R')?'style="width:343px;"':'';?>>
<h3><a href="newscontent.php?id=<?=$getTabFirstNews['id'];?>"><?=sentenceBreakUnicode($getTabFirstNews['news_title'],$settings['tab_main_news_title_length'],"","",$getTabFirstNews['unicode']);?></a>
<?
$getTabNewsImageCount=getCount("SELECT * FROM galleryimages WHERE gallery_type='News' AND gallery_id='".$getTabFirstNews['id']."' ORDER BY priority");
if(trim($getTabFirstNews['video_url'])<>'')
{
?>
<a href='javascript:void(0);'><img src="myimages/video.png" alt="<?=sentenceBreakUnicode($getTabFirstNews['news_title'],$settings['tab_main_news_title_length'],"","",$getTabFirstNews['unicode']);?>"></a>
<?
}
if($getTabNewsImageCount)
{
?>
<a href='gallery.php?id=<?=$getTabFirstNews['id'];?>&type=News'><img src="myimages/gallery.png" alt="<?=sentenceBreakUnicode($getTabFirstNews['news_title'],$settings['tab_main_news_title_length'],"","",$getTabFirstNews['unicode']);?>"></a>
<?
}
?>
</h3>
<?=(trim($getTabFirstNews['external_image'])<>'')?"<div class='newssectionmenusnewspic'><img src='userfiles/".$getTabFirstNews['external_image']."'></div>":""?>
<p><?=sentenceBreakUnicode($getTabFirstNews['news_description'],$settings['tab_main_news_description_length'],"","No",$getTabFirstNews['unicode']);?>  &nbsp;<a href="newscontent.php?id=<?=$getTabFirstNews['id'];?>" class="readmore">&#3364;&#3393;&#3359;&#3376;&#3405;&#8205;&#3368;&#3405;&#3368;&#3393; &#3381;&#3390;&#3375;&#3391;&#3349;&#3405;&#3349;&#3393;&#3349;</a></p>
</div>	
<!--Deshabhimani Othernews part Subnews-->
<div class="newssectionmenusnewssubnews">
<?
if($getTabAllNews)
{
foreach($getTabAllNews as $gknKey => $gknVal)
{
?>
<div class="newssectionmenusnewssubnewstitles"><a href="newscontent.php?id=<?=$gknVal['id'];?>" style="float:left"><?=sentenceBreakUnicode($gknVal['news_title'],$settings['tab_sub_news_title_length'],"","",$gknVal['unicode']);?></a></div>
<?
}
}
?>
</div>
<!--End Deshabhimani Othernews part Subnews-->							

<!--Deshabhimani Othernews morenewsicon-->
<div class="morenewsicon"><a href="categorynews.php?category_id<?=($category<>1)?$category:'';?>=<?=$value;?>" class="readmore" style="line-height:25px">&#3349;&#3394;&#3359;&#3393;&#3364;&#3378;&#3405;&#8205; &#3381;&#3390;&#3376;&#3405;&#8205;&#3364;&#3405;&#3364;&#3349;&#3379;&#3405;&#8205;</a></div>
<!--End Deshabhimani Othernews morenewsicon-->	