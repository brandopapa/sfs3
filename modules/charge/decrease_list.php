<?php

// $Id: decrease_list.php 5864 2010-02-23 15:16:23Z infodaes $

include "config.php";
include "my_fun.php";

sfs_check();

//�q�X����
//head("���O�޲z");

//�Ǵ��O
$work_year_seme=$_REQUEST[work_year_seme];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());

$item_id=$_REQUEST[item_id];

// ���X�Z�Ű}�C
$class_base = class_base($work_year_seme);

//��ܫ��w���ت���K�H��
$sql="SELECT a.item_id,a.detail,a.dollars,b.student_sn,b.curr_class_num,b.percent,b.cause,c.stud_name from charge_detail a,charge_decrease b,stud_base c where a.item_id=$item_id AND a.detail_id=b.detail_id AND b.student_sn=c.student_sn ORDER BY detail,curr_class_num";
$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);

$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>
	<tr bgcolor='#CCFF99'>
	<td align='center' size=5>NO.</td>
	<td align='center' size=5>���O�ӥ�</td>
	<td align='center' size=5>�Z��</td>
	<td align='center' size=3>�y��</td>
	<td align='center' size=20>�ǥͩm�W</td>
	<td align='center' size=30>������</td>
	<td align='center' size=30>��K��</td>
	<td align='center' size=30>��K�B</td>
	<td align='center' size=30>��ú��</td>
	<td align='center' size=30>��K��]</td>
	</tr>";

$res->MoveFirst();
while(!$res->EOF) {
	$class_id=substr($res->fields[curr_class_num],0,3);
	//echo $class_id."<BR>";
	$grade_dollar=explode(',',$res->fields[dollars]);
	if ($IS_JHORES==0) $grade_offset=1; else $grade_offset=7;
	$curr_grade=substr($class_id,0,1)-1;
	//echo $curr_grade."<BR>";
	$my_decrease=round($grade_dollar[$curr_grade]*$res->fields[percent]/100);
	$my_dollar=$grade_dollar[$curr_grade]-$my_decrease;

		$showdata.="<tr bgcolor=#FFFFDD><td align='center'>".($res->CurrentRow()+1)."</td>";
		$showdata.="<td align='center'>".$res->fields[detail]."</td>";
		$showdata.="<td align='center'>".$class_base[$class_id]."</td>";
		$showdata.="<td align='center'>".substr($res->fields[curr_class_num],-2)."</td>";
		$showdata.="<td align='center'>".$res->fields[stud_name]."</td>";
		$showdata.="<td align='center'>".$grade_dollar[$curr_grade]."</td>";
		$showdata.="<td align='center'>".$res->fields[percent]."%</td>";
		$showdata.="<td align='center'>".$my_decrease."</td>";
		$showdata.="<td align='center'>".$my_dollar."</td>";
		
		$showdata.="<td align='center'>".$res->fields[cause]."</td>";
		$showdata.="</td></tr>";


	$res->MoveNext();
}

echo $main.$showdata;
?>