<?php

// $Id: limit_adm.php 5480 2009-06-01 06:48:17Z brucelyc $

// ���o�]�w��
include "config.php";

sfs_check();

$kind_arr=array("�B��","¾��","�Юv","�Ǹ�","�a��");
if (!in_array($_POST['kind'],$kind_arr)) $_POST['kind']="";
else {
	if (intval($_POST['del'])==$_POST['del']) {
		$query="delete from pro_check_new where p_id='".$_POST['del']."'";
		$res=$CONN->Execute($query);
	}
	$query="select a.*,b.* from pro_check_new a left join sfs_module b on a.pro_kind_id=b.msn where id_kind='".$_POST['kind']."' order by a.id_sn,a.pro_kind_id";
	$res=$CONN->Execute($query);
	$rowdata=$res->GetRows();
}
$temp_arr=array();
switch($_POST['kind']) {
	case "�B��":
		$temp_arr=room_kind();
		$temp_arr[99]="�Ҧ��Юv";
		break;
	case "¾��":
		$temp_arr=title_kind();
		break;
	case "�Юv":
		$query="select * from teacher_base order by teacher_sn";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$temp_arr[$res->fields['teacher_sn']]=$res->fields['name'];
			$res->MoveNext();
		}
		break;
	case "�Ǹ�":
		break;
	case "�a��":
		break;
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�ϥ��v���C��");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->assign("kind_menu",power_set($_POST['kind'],"kind","","","","",1));
$smarty->assign("rowdata",$rowdata);
$smarty->assign("l_arr",array(""=>"�@��","0"=>"�@��","1"=>"�޲z"));
$smarty->assign("t_arr",$temp_arr);
$smarty->display("sfs_man2_limit_adm.tpl");
?>
