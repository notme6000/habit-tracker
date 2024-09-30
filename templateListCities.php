<?
require_once("../codelibrary/inc/variables.php");
require_once("../codelibrary/inc/functions.php");
$navigateid=$_GET['navigateid'];
$getNavigationData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$navigateid'");
$nextNavigateId=$navigateid-1;
$getNavigationDataNext=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$nextNavigateId'");
//$getNavigationData=mysql_fetch_assoc($getNavigationDataQuery);
$parent_id=$getNavigationData['parent_id'];
$getNavigationParentData=getRow($conn,"SELECT * FROM admin_menu_settings WHERE menu_id='$parent_id'");
$start=(isset($_GET['start']) && $_GET['start']<>'')?$_GET['start']:'0';
$pagesize=(isset($_GET['pagesize']) && $_GET['pagesize']<>'')?$_GET['pagesize']:PAGING_SIZE;
$where=(isset($_GET['where']) && $_GET['where']<>'')?$_GET['where']:'';
$from=$start*$pagesize;
$sql= "select * from cities
 ".stripslashes($where)." ORDER BY id limit $from, $pagesize";
$result=executequery($sql);
$reccnt=getSingleResult($sql);
?> 
<form name="frm_del" method="post" action="<?=$getNavigationData['menu_url'];?>">
<table width="100%" border="0" cellspacing="1" cellpadding="4" align=center style="border:1px solid #E1E1E1;" >
<?php if($reccnt>0){?>
  <tr class="blueBackground">
    <td width="50" align="left" bgcolor="#D8E6FC"><strong>No.</strong></td>
	<td width="600" align="left" bgcolor="#D8E6FC"><strong>City Name</strong></td>
    <td width="50" align="center" bgcolor="#D8D8D8"><strong>Status</strong></td>
    <td width="72" align="center" bgcolor="#D8D8D8"><b>Edit</b></td>
    <td width="45" align="center"  bgcolor="#D8D8D8"><input name="check_all" type="checkbox" id="check_all" value="check_all" onClick="checkall(this.form)"></td>
  </tr>
<?php $i=0;
  while($line=mysql_fetch_array($result)){
  $className = ($className == "evenRow")?"oddRow":"evenRow";
  ?>
  <tr class="<?php print $className?>"> 
    <td align="left" class="txt" ><?=(($i+1)+$from)?>.</td>
	<td align="left" class="txt" ><?=$line['city'];?> </td>
    <td align="center" class="txt" style=" <? if($line['status']=='A'){?>color:#009900;<? }else{?>color:#FF0000;<? }?>"><? if($line['status']=='A'){?>Active<? }else{?>Deactive<? }?></td>
    <td align="center"><a href="<?=$getNavigationDataNext['menu_url'];?>?id=<?php print $line[0];?>" class="orangetxt">Edit</a></td>
    <td valign="middle" align="center"><input type="checkbox" name="ids[]" value="<?php print $line[0]?>"></td>
  </tr>
  <?php 
  $i++;
  }
  ?>
  <?php $className = ($className == "evenRow")?"oddRow":"evenRow";?>
  <tr align="right" class="<?php print $className?>"> 
    <td colspan="100%" align="right">
          <input type="submit" name="Submit" value="Activate" class="button" onclick="return del_prompt(this.form,this.value)">
          <input type="submit" name="Submit" value="Deactivate" class="button" onclick="return del_prompt(this.form,this.value)">
          <input type="submit" name="Submit" value="Delete" class="button" onclick="return del_prompt(this.form,this.value)">	</td>
  </tr>
<?php }else{?>
  <tr align="center" class="oddRow">
    <td colspan="6" class="warning">Sorry, Currently there are no Records to display.</td>
  </tr>
<?php }?>
</table>
</form>