<?php

// $Id: analysis.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

sfs_check();

//�q�X����
head("���\�N���լd");

//��V������
echo print_menu($MENU_P);

if(checkid($_SERVER['SCRIPT_FILENAME'],1))
{
//�έp�����
$s_date=$_POST[s_date];
if(!$s_date) $s_date=date("Y-m-d");
$e_date=$_POST[e_date];
if(!$e_date) $e_date=date("Y-m-d");

$date_period="����϶��G<input type='text' name='s_date' value='$s_date' size=8>��<input type='text' name='e_date' value='$e_date' size=8><input type='submit' value='�C��'>";

//�Ǵ��O
$work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
//���X�Z�ŦW�ٰ}�C
$class_base = class_base($work_year_seme);
$unsigned=$class_base;

//�s�դ覡
$group_method=$_POST[group_method];
$method_arr=array('�Z��'=>'class_id','�D�ƭ�����'=>'item','���\���'=>'pdate','�Юv'=>'teacher_sn','������'=>'update_date');
if(!$group_method) $group_method=$method_arr[�Z��];
$group_method_radio="���R�̾ڡG";
foreach($method_arr as $key=>$value)
{
	$group_method_radio.="<input type='radio' value='$value' name='group_method'".($group_method==$value?' checked':'')." onclick='this.form.submit()'>$key ";
}

//�}�l���R
$analysis_arr=array();
$analysis_items=array('�ƶq���N��'=>'quantity','�⭻�����N��'=>'taste','�åͦw�����N��'=>'hygiene');
foreach($analysis_items as $key=>$value)
{
	$field_show_title.="<td align='center'>$key</td>";
	
	//�}�l�d��
	$sql="select $group_method,$value,count(*) as counter from lunch_feedback where (pDate between '$s_date' AND '$e_date') GROUP BY $group_method,$value";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);

	while(!$res->EOF)
	{
		$analysis_arr[$res->fields[$group_method]][$key][$res->fields[$value]]+=$res->fields[counter];
		$res->MoveNext();
	}

}
//�N���G�}�C�Ƨǫ����

//echo "<pre>";
//print_r($analysis_arr);
//echo "</pre>";
$title='<h2><center>['.$s_date.($s_date==$e_date?'':']~['.$e_date).']'.array_search($group_method,$method_arr).'���N�פ��R</center></h2>';
$main="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'><form name='form_day' method='post' action='$_SERVER[PHP_SELF]'>
	$date_period �@ $group_method_radio<BR><BR>$title";

$showdata="<tr bgcolor='#CCFF99'>
	<td align='center'>���R�s�ն���</td>$field_show_title<td align='center'>�Ƶ�</td></tr>";
	foreach($analysis_arr as $analysis_item=>$satisfy_items)
	{
		if ($group_method=='class_id') { $analysis_item=$class_base[$analysis_item]; }
		if ($group_method=='teacher_sn')
		{
			//���X�Юv�}�C
			$teacher_base=teacher_base();
			$analysis_item=$teacher_base[$analysis_item];
		}
		$showdata.="<tr bgcolor=#FFFFDD><td>$analysis_item</td>";
		foreach($satisfy_items as $satisfy_item)
		{			
			$showdata.="<td>";
			foreach($satisfy_item as $key=>$value)
			{
				$showdata.="$key($value) ";
			}
		}
		$showdata.="</td><td width='20%'></td></tr>";
	}

$showdata.="</form></table>";

echo $main.$showdata;


} else echo "�z�ëD�Ҳպ޲z��, �L�k�[���έp��T!!";

foot();

?>