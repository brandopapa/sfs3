<?php

// $Id: score_certi.php 6234 2010-10-19 17:03:18Z brucelyc $

// ���J�]�w��
include "../../include/config.php";
include "../../include/sfs_case_subjectscore.php";
include "../../include/sfs_case_dataarray.php";
include "../../include/sfs_oo_zip2.php";
include "../../include/sfs_case_PLlib.php";    
require_once "./module-cfg.php";

// �{���ˬd
sfs_check();

$stud_id=$_POST['stud_id'];
$student_sn=$_POST['student_sn'];
$student_ename=$_POST['student_ename'];
$kind=$_POST['kind'];
$nor_score=$_POST['nor_score'];
$school_move_num=$_POST['school_move_num'];
$c_word=$_POST['c_word'];
$c_num=$_POST['c_num'];
$m_reason=$_POST['m_reason'];
$m_unit=$_POST['m_unit'];
$m_date=$_POST['m_date'];
$m_word=$_POST['m_word'];
$m_num=$_POST['m_num'];
$n_date=$_POST['n_date'];
$have_word=$_POST['have_word'];
$today=explode("-",date("Y-m-d",mktime (date("m"),date("d"),date("Y"))));
$cond=study_cond();

$m_arr = get_sfs_module_set("stud_move");
extract($m_arr, EXTR_OVERWRITE);
$m_arr = get_sfs_module_set("");
extract($m_arr, EXTR_OVERWRITE);

if ($student_sn) {
	$sql="select stud_id,stud_name,stud_study_year,stud_study_cond,stud_name_eng from stud_base where student_sn='$student_sn'";
	$rs=$CONN->Execute($sql);
	$stud_id=$rs->fields['stud_id'];
	$stud_name=$rs->fields['stud_name'];
	if ($stud_name) {
		$stud_study_year=$rs->fields['stud_study_year'];
		$stud_study_cond=$rs->fields['stud_study_cond'];
		$stud_ename=$rs->fields['stud_name_eng'];
	}
}

switch ($kind) {
	case "�ꤤ���~���Z�ҩ���(1)":
		$oo_path="1";
		include ("trans_main.php");
		break;
	case "�ꤤ���~���Z�ҩ���(2)":
		$oo_path="2";
		include ("trans_main.php");
		break;
	case "�ꤤ�^�妨�Z�ҩ���":
		$oo_path="3";
		include ("trans_main.php");
		break;
	case "�U�Ǵ��w�Ҧ��Z��";
		include ("stage.php");
		break;
	case "����ҩ���":
		include ("my_fun.php");
		if ($have_word) {
			$d=explode("-",$m_date);
			$m_content="�g�^".$m_unit.num2str($d[0])."�~".num2str($d[1])."��".num2str($d[2])."��".$m_word."�r��".$m_num."���֭�";
		} else {
			$d=explode("-",$n_date);
			$m_content="�]�ӥͫY".num2str($d[0])."�~".num2str($d[1])."��".num2str($d[2])."��J�ǩ|�����^�֭�";
		}
		$oo_path="move_out";
		include ("move_out.php");
		break;
}
 
//�L�X���Y
head("�C�L���Z�ҩ�");
print_menu($menu_p);

$check_1="";
$check_2="checked";

if ($student_sn) {
	//���o��X���ʸ�Ƭ���
	$sql="select * from stud_move where (move_kind in (7,8,11,12)) and student_sn='$student_sn' ORDER BY move_id DESC";
	$rs=$CONN->Execute($sql);
	if ($rs->recordcount()>0) {
		$school_move_num=$rs->fields['move_year_seme'].sprintf('%03d',$rs->fields['school_move_num']);
		$reason=$rs->fields['reason'];
		if (!empty($m_num)) {
			$check_1="checked";
			$check_2="";
		}
	}

	//���o�s�ͤJ�ǩ���J���ʸ�Ƭ���
	$sql="select * from stud_move where (move_kind in (2,13)) and student_sn='$student_sn'";
	$rs=$CONN->Execute($sql);
	if ($rs->recordcount()>0) {
		$m_unit=$rs->fields['move_c_unit'];
		$m_date=DtoCh($rs->fields['move_c_date']);
		$m_word=$rs->fields['move_c_word'];
		$m_num=$rs->fields['move_c_num'];
		$n_date=DtoCh($rs->fields['move_date']);
		if (!empty($m_num)) {
			$check_1="checked";
			$check_2="";
		}
	}
}

$main="
	<table cellspacing=0 cellpadding=0><tr><td>
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4><tr  class='title_sbody1'>
	<form name ='form' action='{$_SERVER['PHP_SELF']}' method='post' >
	<td class='title_sbody2'>�ǥ;Ǹ�<td colspan='3' align='left'><input type='text' size='10' name='stud_id' value='$stud_id'><input name='SUBMIT' type='submit' value='�󴫾ǥ�'></td></form></tr>";
if ($student_sn=="" && $stud_id) {
	$main.="<form name ='form1' action='{$_SERVER['PHP_SELF']}' method='post'><tr class=\"title_sbody2\"><td align=\"center\">�ǥͦC��</td><td style=\"text-align:left;background-color:white;\">";
	$query="select * from stud_base where stud_id='$stud_id' order by stud_study_year";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$main.="<input type=\"radio\" name=\"student_sn\" value=\"".$res->fields['student_sn']."\" OnClick=\"this.form.submit();\"><span style=\"color:red;\">".$res->fields['stud_name']."</span>(".$res->fields['stud_study_year']."�~�J��)(".$cond[$res->fields['stud_study_cond']].")<br>";
		$res->MoveNext();
	}
	$main.="</td></tr>";
} elseif ($student_sn && $stud_name) {
	$main.="
		<form name ='form1' action='{$_SERVER['PHP_SELF']}' method='post' >
		<tr class='title_sbody1'>
		<td class='title_sbody2'>�ǥͩm�W
		<td align='left' colspan='3'>$stud_name
		</tr>
		<tr class='title_sbody1'>
		<td class='title_sbody2'>�J �� �~
		<td align='left' colspan='3'>".$stud_study_year."
		</tr>
		<tr  class='title_sbody1'>
		<td class='title_sbody2'>�N�Ǫ��A
		<td align='left' colspan='3'>".$cond[$stud_study_cond]."
		</tr>
		<tr class='title_sbody1'>
		<td class='title_sbody2'>��`���Z
		<td align='left' colspan='3'><input type='radio' name='nor_score' value='1'>�� <input type='radio' name='nor_score' value='0' checked>�L
		</tr>
		<tr class='title_sbody1'>
		<td class='title_sbody2' rowspan='3'>�U�@�@��".(($IS_JHORES)?"
		<td align='left' colspan='3'> <input type='submit' name='kind' value='�ꤤ���~���Z�ҩ���(1)'> (��ǥΡA�t��r�y�z)<input type='hidden' name='student_sn' value='$student_sn'><br>
		<input type='submit' name='kind' value='�ꤤ���~���Z�ҩ���(2)'> (�@��ΡA���t��r�y�z)<br>
		<input type='submit' name='kind' value='�ꤤ�^�妨�Z�ҩ���'><input type='hidden' name='student_sn' value='$student_sn'></td>
		":"
		<td align='left' colspan='3'> <INPUT TYPE=button value='��p�����Z�ҩ���' onclick=\" window.open('/sfs3/modules/chc_page/index.php?st_sn=$student_sn');\"> (�@��ΡA�t��r�y�z)
		")."
		</tr>
		<tr class='title_sbody1'>
		<td align='left'> <input type='submit' name='kind' value='�U�Ǵ��w�Ҧ��Z��'></td>
		</tr>
		<tr class='title_sbody1'>
		<td align='left' colspan='3'> <input type='submit' name='kind' value='����ҩ���'>(�Х���J�U�C���e)
		<br>�@�@�ҮѦr�@�G<input type='text' name='c_word' value='".($default_cword?$default_cword:$school_sshort_name.'����')."'>�r
		<br>�@�@�ҮѸ��@�G��<input type='text' name='c_num' value='$school_move_num' size='18'>��
		<br>�@�@��ǲz�ѡG<input type='text' name='m_reason' value='$reason'>
		<br><input type='radio' name='have_word' $check_1 value='1'>���y�w���֭�帹
		<br>�@�@�֭���G<input type='text' name='m_unit' value='$m_unit'>
		<br>�@�@�֭����G���� <input type='text' name='m_date' value='$m_date' size='16'>
		<br>�@�@�֭�r�@�G<input type='text' name='m_word' value='$m_word'>�r
		<br>�@�@�֭㸹�@�G��<input type='text' name='m_num' value='$m_num' size='18'>��
		<br><input type='radio' name='have_word' $check_2 value='0'>���y�|�L�֭�帹
		<br>�@�@�J�Ǥ���G���� <input type='text' name='n_date' value='$n_date' size='16'>
		<input type='hidden' name='student_sn' value='$student_sn'>
		</tr>";
}
$main.="</form>";
$main.="</table></td></tr></table>";

echo $main;
foot();
?>
