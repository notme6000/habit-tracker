
<!-- left column start -->
<div class="left-column">
<?
$qrymenuset=mysqli_query($conn,"select * from admin_menu_settings where menu_status='A' AND parent_id='-1' order by menu_priority");
while($gpVal=mysqli_fetch_array($qrymenuset))
{
$parent=$gpVal['menu_id'];
$getChild=mysqli_query($conn,"select * from admin_menu_settings where menu_status='A' AND parent_id='$parent' AND menu_url<>'' order by menu_priority");
$childCount=mysqli_query($conn,"select * from admin_menu_settings where menu_status='A' AND parent_id='$parent' order by menu_priority");
$getChildCount=mysqli_num_rows($childCount);
$parentCount=mysqli_query($conn,"select * from admin_menu_permissions where user_id='{$_SESSION['sess_admin_id']}' AND menu_parent_id='{$gpVal['menu_id']}' AND menu_permission LIKE '%Y%'");
$getOnlyParentDataCount=mysqli_num_rows($parentCount);
if($getOnlyParentDataCount>0 || $_SESSION['sess_admin_id']>='1')
{
?>
<!-- menu start -->
<div class="menu" id="menu_box_common" >
<div class="inner">

<div class="menu-caption"><?=$gpVal['menu_name'];?></div>
<div class="minmax white-close"></div>
<div class="box-content" style="padding: 0;">
<ul class="menu" id="menu_common">
<?php
if($getChildCount>0)
{
while($gcVal=mysqli_fetch_array($getChild))
{
if(checkPermission($conn,$gcVal['menu_id']))
{
?>
<li <?=($navigateid==$gcVal['menu_id'])?'class="active"':'';?>><a  style="background-image:url('<?=(trim($gcVal['icon'])<>'')?trim($gcVal['icon']):DEFAULT_IMAGE;?>');" href="<?=$gcVal['menu_url'];?>"  class="submenu"><?=$gcVal['menu_name'];?></a></li>
<? 
}
}
}
?>
<li><span>&nbsp;</span></li>
</ul>
</div>
</div>

</div>
<!-- menu end -->
<?
}
}
?>
<div style="display:block;height:70px;width:100%;">&nbsp;</div>
</div>


<!-- left column end -->