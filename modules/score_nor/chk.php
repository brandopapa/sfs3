<?php

// $Id: chk.php 5310 2009-01-10 07:57:56Z hami $

// ���o�]�w��
include "config.php";

sfs_check();


if ($_POST['df_item']=="") $_POST['df_item']=($IS_JHORES)?"default_jh":"default_es";
if ($_POST['year_seme']=="") $_POST['year_seme']=sprintf("%03d",curr_year()).curr_seme();
if($_POST['year_seme']==sprintf("%03d",curr_year()).curr_seme()) $current=sprintf("%03d",curr_year()).curr_seme();

$sel_year=intval(substr($_POST['year_seme'],0,-1));
$sel_seme=intval(substr($_POST['year_seme'],-1,1));

//�R���Ҧ��w�s�b���
if ($_POST['del_record'])
	$res=$CONN->Execute("delete from stud_seme_score_nor_chk where seme_year_seme='".$_POST['year_seme']."'");

//�ƻs�ܥ��Ǵ�
if ($_POST['copy_to_cur'])
{
	//���祻�Ǵ��O�_�w�����
	$query="select count(*) from score_nor_chk_item where year='".curr_year()."' and seme='".curr_seme()."'";
	$res=$CONN->Execute($query);
	if($res->fields[0]) echo "<script language=\"Javascript\"> alert (\"���Ǵ��w�g���]�w�F�A�t�θT��z�i��ƻs�I\")</script>";	
	 else {
		//���o�C�ܾǴ����
		$query="select * from score_nor_chk_item where year='$sel_year' and seme='$sel_seme'";	
		$res=$CONN->Execute($query);
		//�s�@ INSERT SQL
		$copy_data="INSERT INTO score_nor_chk_item(year,seme,main,sub,item) VALUES ";
		while(!$res->EOF) {
			$copy_data.="(".curr_year().",".curr_seme().",".$res->fields['main'].",".$res->fields['sub'].",'".addslashes($res->fields['item'])."'),";
			$res->MoveNext();
		}
		$copy_data=substr($copy_data,0,-1);
		$res=$CONN->Execute($copy_data) or user_error("�ƻs���ѡI<br>$copy_data",256);
		$current=sprintf("%03d",curr_year()).curr_seme();
		$_POST['year_seme']=$current;
		
		echo "<script language=\"Javascript\"> alert (\"�w�g�����ƻs���ഫ��ܦܾǴ� $current �F�I ���˵�!!\")</script>";
	}
}
$smarty->assign("current",$current);

//�έp���Ǵ��O������
$query="select count(*) from stud_seme_score_nor_chk where seme_year_seme='".$_POST['year_seme']."'";
$res=$CONN->Execute($query);
if ($res->fields[0]>0) {
	$smarty->assign("msg_str","<font color=\"red\">���Ǵ��w��".$res->fields[0]."���O���s�b�A�Q�ק�νվ㶵�إ������R���Ҧ��w�s�b��ơC</font>");
} else {
	if ($_POST['default']) {
		while(list($i,$v)=each($item_arr[$_POST['df_item']])) {
			while(list($j,$vv)=each($v)) {
				$CONN->Execute("insert into score_nor_chk_item (year,seme,main,sub,item) values ('$sel_year','$sel_seme','$i','$j','".addslashes($item_arr[$_POST[df_item]][$i][$j])."')");
			}
		}
	}

	//�x�s����
	if ($_POST['act']=="save") {
		$CONN->Execute("update score_nor_chk_item set item='$_POST[item_value]' where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' and sub='$_POST[sub]'");
	}

	//���J����
	if ($_POST['act']=="insert") {
		$CONN->Execute("insert into score_nor_chk_item (year,seme,main,sub,item) values ('$sel_year','$sel_seme','$_POST[main]','$_POST[sub]','$_POST[item_value]')");
	}

	//�R������
	if ($_POST['act']=="del") {
		if ($_POST['sub']>0) {
			$CONN->Execute("delete from score_nor_chk_item where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' and sub='$_POST[sub]'");
			$CONN->Execute("update score_nor_chk_item set sub=sub-1 where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' and sub>'$_POST[sub]' order by main,sub");
		} else {
			$CONN->Execute("delete from score_nor_chk_item where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]'");
			$CONN->Execute("update score_nor_chk_item set main=main-1 where year='$sel_year' and seme='$sel_seme' and main>'$_POST[main]' order by main,sub");
		}
	}

	//���ؤW��
	if ($_POST['act']=="up") {
		if ($_POST['sub']>0) {
			$CONN->Execute("update score_nor_chk_item set sub='99' where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' and sub='$_POST[sub]' order by main,sub");
			$CONN->Execute("update score_nor_chk_item set sub=sub+1 where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' and sub='".($_POST[sub]-1)."' order by main,sub");
			$CONN->Execute("update score_nor_chk_item set sub=".($_POST[sub]-1)." where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' and sub='99' order by main,sub");
		} else {
			$CONN->Execute("update score_nor_chk_item set main='99' where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' order by main,sub");
			$CONN->Execute("update score_nor_chk_item set main=main+1 where year='$sel_year' and seme='$sel_seme' and main='".($_POST[main]-1)."' order by main,sub");
			$CONN->Execute("update score_nor_chk_item set main=".($_POST[main]-1)." where year='$sel_year' and seme='$sel_seme' and main='99' order by main,sub");
		}
	}

	//���ؤU��
	if ($_POST['act']=="down") {
		if ($_POST['sub']>0) {
			$CONN->Execute("update score_nor_chk_item set sub='99' where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' and sub='$_POST[sub]' order by main,sub");
			$CONN->Execute("update score_nor_chk_item set sub=sub-1 where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' and sub='".($_POST[sub]+1)."' order by main,sub");
			$CONN->Execute("update score_nor_chk_item set sub=".($_POST[sub]+1)." where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' and sub='99' order by main,sub");
		} else {
			$CONN->Execute("update score_nor_chk_item set main='99' where year='$sel_year' and seme='$sel_seme' and main='$_POST[main]' order by main,sub");
			$CONN->Execute("update score_nor_chk_item set main=main-1 where year='$sel_year' and seme='$sel_seme' and main='".($_POST[main]+1)."' order by main,sub");
			$CONN->Execute("update score_nor_chk_item set main=".($_POST[main]+1)." where year='$sel_year' and seme='$sel_seme' and main='99' order by main,sub");
		}
	}

	if ($_POST['del_all']) {
		$CONN->Execute("delete from score_nor_chk_item where year='$sel_year' and seme='$sel_seme'");
	}
}

//�Ǧ~���
$sel1 = new drop_select();
$sel1->s_name="year_seme";
$sel1->id= $_POST['year_seme'];
$sel1->arr = get_class_seme();
$sel1->has_empty = false;
$sel1->is_submit = true;

$smarty->assign("year_seme_sel",$sel1->get_select());

//�w�]��ؿ��
$sel1 = new drop_select();
$sel1->s_name="df_item";
$sel1->id= $_POST['df_item'];
$sel1->arr = $item_sel;
$sel1->has_empty = false;
$sel1->is_submit = true;
$smarty->assign("item_sel",$sel1->get_select());

$query="select main,sub,item from score_nor_chk_item where year='$sel_year' and seme='$sel_seme' order by main,sub";
$res=$CONN->Execute($query);
$smarty->assign("rowdata",$res->GetRows());
$smarty->assign("current_records",$res->recordcount());

$query="select count(item) as num from score_nor_chk_item where year='$sel_year' and seme='$sel_seme' group by main order by main,sub";
$res=$CONN->Execute($query);
$smarty->assign("rownum",$res->GetRows());
$query="select count(item) from score_nor_chk_item where year='$sel_year' and seme='$sel_seme' and sub='0'";
$res=$CONN->Execute($query);
$smarty->assign("maxnum",$res->fields[0]);
$query="select count(item) as num from score_nor_chk_item where year='$sel_year' and seme='$sel_seme' group by main";
$res=$CONN->Execute($query);
$smarty->assign("submax",$res->GetRows());

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�]�w�ǥͤ�`�ͬ��ˮ֪�");
$smarty->assign("SFS_MENU",$menu_p);
$smarty->display("score_nor_chk.tpl");
?>
