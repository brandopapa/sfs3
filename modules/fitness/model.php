<?php
// $Id: model.php 8674 2015-12-25 02:45:35Z qfon $
// ���o�]�w��
include "config.php";
if ($_POST[model_id]=="") $_POST[model_id]="0";
for($i=1;$i<20;$i++) {
	$p=$i*5;
	//$p=$i;
	if ($p<25) $c="#e6ebff";
	if ($p>20 && $p<50) $c="#f0f4f7";
	if ($p>45 && $p<75) $c="#ebffcc";
	if ($p>70 && $p<85) $c="#faebff";
	if ($p>80) $c="#ffffde";
	$p_arr[$p]=$c;
}
$smarty->assign("p_arr",$p_arr);

$query="select * from fitness_mod where grade='".intval($_POST[model_id])."' order by sex,age";
$res=$CONN->Execute($query);
while(!$res->EOF) {
	$r[$res->fields[sex]][]=$res->FetchRow();
}
$smarty->assign("rowdata",$r);

$model_arr=array("0"=>"����","1"=>"�魫","2"=>"������e�s","3"=>"���װ_��60��","4"=>"�w�߸���","5"=>"�ߪ;A��");
$model_menu = new drop_select();
$model_menu->s_name ="model_id";
$model_menu->has_empty = false;
$model_menu->id = $_POST[model_id];
$model_menu->arr = $model_arr;
$model_menu->is_submit = true;
$smarty->assign("model_menu",$model_menu->get_select());
$smarty->assign("model_arr",$model_arr);
$smarty->assign("k_arr",array("0"=>"����","1"=>"����","2"=>"����","3"=>"��","4"=>"����","5"=>"��"));

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","��A��`��");
$smarty->assign("SFS_MENU",$menu_p);
$smarty->assign("sel_year",$sel_year);
$smarty->assign("sel_seme",$sel_seme);
$smarty->assign("IS_JHORES",$IS_JHORES);
$smarty->display("fitness_model.tpl");
?>
