<?php
require "config.php";
sfs_check();
if (!checkid($_SERVER[SCRIPT_FILENAME],1)){
	head();
	print_menu($menu_p);
	echo '<h1>�D�޲z��,����ާ@���@�~</h1>';
	foot();
	exit;
}
if ($_POST['act'] == '�T�w') {
	$arr = array();
	$arr['title'] = filter_input(INPUT_POST, 'title');
	$arr['items_per_page'] = filter_input(INPUT_POST, 'items_per_page' ,FILTER_SANITIZE_NUMBER_INT);
	$arr['image_width'] = filter_input(INPUT_POST, 'image_width' ,FILTER_SANITIZE_NUMBER_INT);
	$query = "UPDATE artical_paramter SET paramter='".serialize($arr)."'";
	$CONN->Execute($query);
}


$query = "SELECT * FROM artical_paramter";
$res = $CONN->Execute($query);
$param = $res->fields['paramter'];
if($param=='')
$param = $PARAMSTER;
else
$param = unserialize($param);



head();

print_menu($menu_p);
?>
<style>
.ui-widget-header {font-size:16px;padding:5px;margin-top:5px;}
.ui-widget-content {padding:5px;}
</style>
<div class="ui-widget-header ui-corner-top">�t�ΰѼƳ]�w</div>
<div class="ui-widget-content ui-corner-bottom">
<form action="" method="post" id="setForm">
<dl>
	<dt>���Z�W��</dt>
	<dd><input type="text" name="title" size="20"
		value="<?php echo $param['title']?>" /></dd>
	<dt>�C���峹����</dt>
	<dd><input type="text" name="items_per_page" size="5"
		value="<?php echo $param['items_per_page']?>" /></dd>
	<dt>���ɼe��</dt>
	<dd><input type="text" name="image_width" size="5"
		value="<?php echo $param['image_width']?>" /></dd>
	<dt></dt>
	<dd><input type="submit" name="act" id="act" value="�T�w" /></dd>
</dl>
</form>
</div>
<?php
foot();