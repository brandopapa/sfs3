<?php

// $Id: record.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
include "my_fun.php";
sfs_check();
//�q�X����
head("���O�޲z");
//�Ǵ��O
$work_year_seme=$_REQUEST[work_year_seme];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());

$item_id=$_REQUEST[item_id];
$class_id=$_POST[class_id];
$record_id=$_POST[record_id];

$grade=substr($class_id,0,1);

// ���X�Z�ŦW�ٰ}�C
$class_base = class_base($work_year_seme);

//��V������
$linkstr="work_year_seme=$work_year_seme&item_id=$item_id";
echo print_menu($MENU_P,$linkstr);
if($_POST['act']=='���s�}�C'){
	if( $item_id<>'' AND $class_id<>'')
	{
		//��Z�žǥ�
		$sql_select="select curr_class_num,student_sn from stud_base where (curr_class_num like '$class_id%') and (stud_study_cond=0) order by curr_class_num";
		$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
		$batch_value="";
		while(!$recordSet->EOF)
		{
			$sn=$recordSet->fields[student_sn];
			$record_id=$work_year_seme.$recordSet->fields[curr_class_num];

			$batch_value.="('$record_id',$sn,$item_id),";
			$recordSet->MoveNext();
		}
		$batch_value=substr($batch_value,0,-1);

		//echo "===================<BR>$batch_value<BR>===================";
		$sql_select="REPLACE INTO charge_record(record_id,student_sn,item_id) values $batch_value";
		$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	} else echo "<script language=\"Javascript\"> alert (\"��T����, �L�k�����O�妸�s�W�I\")</script>";
};

if($_POST['act']=='�M�ť�ú����'){
	$sql_select="delete from charge_record where item_id=$item_id AND record_id like '$work_year_seme$class_id%' AND dollars=0";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
};

if($_POST['act']=='�ק�'){
	$sql_select="update charge_record set dollars='$_POST[dollars]',paid_date=".($_POST[dollars]==0?"NULL":($_POST[paid_date]?"'$_POST[paid_date]'":"CURDATE()")).",comment='$_POST[comment]' where item_id=$item_id AND record_id=$record_id;";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$record_id="";
};

if($_POST['act']=='�R��'){
	$sql_select="delete from charge_record where item_id=$item_id AND record_id=$record_id";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
};

//���o�~�׻P�Ǵ����U�Կ��
$seme_list=get_class_seme();
$main="<table><form name='form_item' method='post' action='$_SERVER[PHP_SELF]'>
	<select name='work_year_seme' onchange='this.form.submit()'>";
foreach($seme_list as $key=>$value){
	$main.="<option ".($key==$work_year_seme?"selected":"")." value=$key>$value</option>";
}
$main.="</select><select name='item_id' onchange='this.form.submit()'><option></option>";
//���o�~�׶���
$sql_select="select * from charge_item where year_seme='$work_year_seme' order by end_date desc";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
while(!$res->EOF) {
	$main.="<option ".($item_id==$res->fields[item_id]?"selected":"")." value=".$res->fields[item_id].">".$res->fields[item]."(".$res->fields[start_date]."~".$res->fields[end_date].")</option>";
	$res->MoveNext();
}
$main.="</select>";
if($item_id)
{
	//���o�U�~�Ŧ��O�C��έp���K���B  �۩w��Ʀb my-fun.php
	$grade_dollars=get_grade_charge($item_id);
	$item_total=array_sum($grade_dollars[$grade]);
	//echo $item_total;
	$decrease_dollars=get_charge_decrease($item_id);
	//��ܯZ��
	$class_list=get_item_class($item_id,$class_base,$class_id);
	$main.=$class_list;
	if($class_id)
	{
		//���o�w�}�C�Z�žǥͦC��
		$stud_select="select a.*,mid(a.record_id,4) as curr_class_num,b.stud_name from charge_record a,stud_base b where item_id=$item_id AND record_id like '$work_year_seme$class_id%' AND a.student_sn=b.student_sn order by record_id";
		$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
		$studentdata="�@<img border=0 src='images/modify.gif' alt='�s�׿�w�ǥ�'><select name='record_id' onchange='this.form.submit()'><option></option>";
		while(!$recordSet->EOF)
		{
			$is_selected=($record_id==$recordSet->fields[record_id]?" selected":"");
			$studentdata.="<option value='".$recordSet->fields[record_id]."'$is_selected>(".substr($recordSet->fields[curr_class_num],-2).")".$recordSet->fields[stud_name]."</option>";
			$recordSet->MoveNext();
		}
		$studentdata.="</select>";
		$main.=$studentdata;

		//��ܯZ�žǥͪ������ڬ���
		$recordSet->MoveFirst();
		$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
			<tr bgcolor='#CCFF99'>
			<td align='center' size=3>NO.</td>
			<td align='center' size=3>��ڸ��X</td>
			<td align='center' size=10>�m�W</td>
			<td align='center' size=6>�����`�B</td>
			<td align='center' size=6>��K�B</td>
			<td align='center' size=6>��ú�B</td>
			<td align='center' size=6>�wú�B</td>
			<td align='center' size=10>ú�ڤ��</td>
			<td align='center' size=6>��ú�B</td>
			<td align='center' size=10>�Ƶ�</td>
			<td align='center'><input type='submit' value='�M�ť�ú����' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\\n\\n��[�T�w]�N��L�ݺ޲z���Z���@ú�ڶ��إ�ú�ڪ��ǥ�\")'></td>
			</tr>";
		while(!$recordSet->EOF) {
			$my_decrease=$decrease_dollars[$recordSet->fields[student_sn]][total];
			$my_should_paid=$item_total-$my_decrease;
			$left=$my_should_paid-($recordSet->fields[dollars]);
			if($my_should_paid-$recordSet->fields[dollars]>0) $my_bgcolor="#FFCCCC"; else $my_bgcolor="#FFFFDD";
			if($record_id==$recordSet->fields[record_id])
			{
				//�s��
				$showdata.="<tr bgcolor=#AAFFCC><td align='center'>".($recordSet->CurrentRow()+1)."</td>";
				$showdata.="<td align='center'>".$recordSet->fields[record_id]."</td>";
				$showdata.="<td align='center'>".$recordSet->fields[stud_name]."</td>";
				$showdata.="<td align='center'>$item_total</td>";
				$showdata.="<td align='center'>$my_decrease</td>";
				$showdata.="<td align='center'>".$my_should_paid."</td>";
				$showdata.="<td align='center'><input type='text' name='dollars' size=6 value='".$recordSet->fields[dollars]."'></td>";
				$showdata.="<td align='center'><input type='text' name='paid_date' size=10 value='".$recordSet->fields[paid_date]."'></td>";
				$showdata.="<td align='center'>$left</td>";
				$showdata.="<td align='center'><input type='text' name='comment' size=10 value='".$recordSet->fields[comment]."'></td>";
				$showdata.="<td align='center'><input type='submit' value='�ק�' name='act' onclick='return confirm(\"�T�w�n���[".$recordSet->fields[stud_name]."]?\")'>�@<input type='submit' value='�R��' name='act' onclick='return confirm(\"�u���n�R��[".$recordSet->fields[stud_name]."]?\")'></td></tr>";
			} else {
				//�C��
				$my_decrease=$decrease_dollars[$recordSet->fields[student_sn]][total];
				
				$showdata.="<tr bgcolor=$my_bgcolor><td align='center'>".($recordSet->CurrentRow()+1)."</td>";
				$showdata.="<td align='center'>".$recordSet->fields[record_id]."</td>";
				$showdata.="<td align='center'>".$recordSet->fields[stud_name]."</td>";
				$showdata.="<td align='center'>".$item_total."</td>";
				$showdata.="<td align='center'>$my_decrease</td>";
				$showdata.="<td align='center'>".$my_should_paid."</td>";
				$showdata.="<td align='center'>".$recordSet->fields[dollars]."</td>";
				$showdata.="<td align='center'>".$recordSet->fields[paid_date]."</td>";
				$showdata.="<td align='center'>$left</td>";
				$showdata.="<td align='center'>".$recordSet->fields[comment]."</td>";
				$showdata.="<td></td>";
			}

			//�\��s��
			//$showdata.="<td align='center'>";
			//$showdata.="<a href='detail.php?item_id=".$recordSet->fields[item_id]."'><img border=0 src='images/modify.gif' alt='�]�w�ӥ�'> </a>";
			//$showdata.="<a href='record.php?item_id=".$recordSet->fields[item_id]."'><img border=0 src='images/sxw.gif' alt='�L���O��'> </a>";
			//$showdata.="<a href='statistics.php?item_id=".$recordSet->fields[item_id]."'><img border=0 src='images/sigma.gif' alt='���O�έp'> </a>";
			//$showdata.="<a href='item.php?act=delete&item_id=".$recordSet->fields[item_id]."'><img border=0 src='images/delete.gif' alt='�R��' onclick='return confirm(\"�u���n�R�� $stud_name ?\")'></a>";
			$showdata.="</td></tr>";
			$recordSet->MoveNext();
		}
	}
}
$showdata.="</form></table>";

echo $main.$showdata;
foot();
?>