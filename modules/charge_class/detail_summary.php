<?php

//$Id: detail_summary.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
include "my_fun.php";
sfs_check();

//�q�X����
head("���O�޲z(�ɮv��)");
$work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$item_id=$_REQUEST[item_id];
$record_id=$_POST[record_id];
// ���X�Z�ŦW�ٰ}�C
$class_base = class_base($work_year_seme);
//��V������
$linkstr="item_id=$item_id";
echo print_menu($MENU_P,$linkstr);
if($m_arr[is_detail_summary] AND $class_id) {

$main="<table><form name='form_item' method='post' action='$_SERVER[PHP_SELF]'>
	<select name='item_id' onchange='this.form.submit()'><option></option>";

//���o�~�׶���
$sql_select="select * from charge_item where cooperate=1 AND year_seme='$work_year_seme' AND (curdate() between start_date AND end_date) order by end_date desc";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

while(!$res->EOF) {
	$main.="<option ".($item_id==$res->fields[item_id]?"selected":"")." value=".$res->fields[item_id].">".$res->fields[item]."(".$res->fields[start_date]."~".$res->fields[end_date].")</option>";
	$res->MoveNext();
}
$main.="</select>";

if($item_id>0)
{
	//���o�U�~�Ŧ��O�C��έp���K���B  �۩w��Ʀb my-fun.php
	$grade_dollars=get_grade_charge($item_id);
	$data_arr=array();
	//���o���O���ئU�~�Ÿ�Ʋέp
	$stud_select="select MID(record_id,5,1) as grade,count(*) as members from charge_record where item_id=$item_id AND record_id like '$work_year_seme$class_id%' group by grade";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	//echo "<PRE>";
	//print_r($recordSet->getrows());
	//echo "</PRE>";

	//�N���O�C���W�����H�ơ@�ñN�w���O���B
	while(!$recordSet->EOF) {
		foreach($grade_dollars as $grade=>$detail){
			foreach($detail as $key=>$value){
				//print_r($value);
				$data_arr[$recordSet->fields[grade]][$key][singal]=$value;
				$data_arr[$recordSet->fields[grade]][$key][total]=$value*$recordSet->fields[members];
				//$data_arr[$recordSet->fields[grade]][$key][paid]=$recordSet->fields[dollars];
			}
		}
		$members[$recordSet->fields[grade]]=$recordSet->fields[members];
		$recordSet->MoveNext();
	}
	//�N����K����ƥ[�}�C��
	$decrease_dollars=get_charge_decrease($item_id);  //����Ʒ|�N�w�]�w��K���S�������O�W��C�J�䤤
	$stud_select="select student_sn,MID(record_id,5,1) as grade from charge_record where item_id=$item_id AND record_id like '$work_year_seme$class_id%'";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	while(!$recordSet->EOF) {
		if (array_key_exists($recordSet->fields[student_sn],$decrease_dollars)) {
			foreach($decrease_dollars[$recordSet->fields[student_sn]] as $key=>$value){
				if($key<>"total") {
					$data_arr[$recordSet->fields[grade]][$key][decrease_count]+=1;
					$data_arr[$recordSet->fields[grade]][$key][decrease_dollars]+=$value[dollars];
				}
			}
		}
		$recordSet->MoveNext();
	}
/*
	//�N�U�Ǧ~���Ӷ����p�p
	//$detail_list=array_keys(current($data_arr));
	foreach($data_arr as $grade=>$detail){
		foreach($detail as $detail_name=>$detail_value){
			foreach($detail_value as $key=>$value){
				$data_arr[$grade]['�~�ŦX�p'][$key]+=$value;
			}
		}
	}
*/
	//�N�}�C�ରHTML���---���  ��K�H�ơ@��K���B�@�����X�p
	//��ܼ��D
	$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'><tr bgcolor='#CCFFCC'><td rowspan=2 align='center'>���O�ӥ�</td>";
	//���o�~��
	$grade_list=array_keys($data_arr);
	foreach($grade_list as $grade) {
		$showdata.="<td colspan=5 align='center'>$class_base[$class_id] (".$members[$grade]."�H)</td>";
		$sub_title.="<td align='center'>�ӥ��B</td><td align='center'>�Z�Ū��B</td><td align='center'>��K��</td><td align='center'>��K�B</td><td align='center'>�����X�p</td>";
	}
	$showdata.="<td rowspan='2' align='center'>�Z�������X�p</td></tr><tr>$sub_title</tr>";
	//��ܸ��
	//���o�ӥئW��
	$detail_list=array_keys(current($data_arr));
	//print_r($detail_list);
	foreach($detail_list as $detail_key){
		$showdata.="<tr bgcolor='#FFDDFF'><td>$detail_key</td>";
		$school_detail_total=0;
		foreach($grade_list as $grade) {
			$showdata.="<td align='center'>".$data_arr[$grade][$detail_key][singal]."</td>";
			$showdata.="<td align='center'>".$data_arr[$grade][$detail_key][total]."</td>";
			$showdata.="<td align='center'>".$data_arr[$grade][$detail_key][decrease_count]."</td>";
			$showdata.="<td align='center'>".$data_arr[$grade][$detail_key][decrease_dollars]."</td>";
			$detail_should_paid=$data_arr[$grade][$detail_key][total]-$data_arr[$grade][$detail_key][decrease_dollars];
			$showdata.="<td align='center'>$detail_should_paid</td>";
			$school_detail_total+=$detail_should_paid;
			}
		$showdata.="<td align='center'>$school_detail_total</td></tr>";
	}
}

$showdata.="</form></table>";
echo $main.$showdata;
} else echo $not_allowed;
foot();
?>