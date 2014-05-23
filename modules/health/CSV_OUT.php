<?php

// $Id: wh.php 5310 2009-01-10 07:57:56Z hami $

// ���o�]�w��
include "config.php";

sfs_check();

$health_tables=array(
1=>"health_WH",
2=>"health_accident_attend",
3=>"health_accident_attend_record",
4=>"health_accident_part",
5=>"health_accident_part_record",
6=>"health_accident_place",
7=>"health_accident_reason",
8=>"health_accident_record",
9=>"health_accident_status",
10=>"health_accident_status_record",
11=>"health_bodymind",
12=>"health_checks_doctor",
13=>"health_checks_item",
14=>"health_checks_record",
15=>"health_diag_record",
16=>"health_disease",
17=>"health_diseaseserious",
18=>"health_exam_item",
19=>"health_exam_record",
20=>"health_fday",
21=>"health_hospital",
22=>"health_hospital_record",
23=>"health_inherit",
24=>"health_inject_item",
25=>"health_inject_record",
26=>"health_insurance",
27=>"health_insurance_record",
28=>"health_manage_record",
29=>"health_sight",
30=>"health_sight_ntu",
31=>"health_teeth",
32=>"health_uri",
33=>"health_worm",
34=>"health_yellowcard",
35=>"web_wh",
'00'=>"identification"
);

// �����ץX�����Ҹ�
$health_tables_no_id = array(
2,3,4,5,6,7,9,10,13,18,20,21,24,26,
);


$table_id=$_GET["table"];
$table_name=$health_tables[$table_id];
if($table_id){
	//echo "�A��ܤFDUMP ��ƪ�  $table_id $table_name !!";
	################################    ��X CSV    ##################################
	//$filename ="$school_short_name ���d�Ҳո�ƪ�DUMP--$table_id $table_name.csv";
	$filename =sprintf("%02d",$table_id)."-$table_name.csv";
	if($table_id=='00'){
		$sql_select="SELECT a.student_sn,b.stud_person_id,b.stud_name,b.stud_sex,b.stud_birthday,b.curr_class_num,b.stud_study_cond FROM health_WH AS a LEFT JOIN stud_base AS b ON a.student_sn=b.student_sn";
	} elseif ($table_id=='35'){
		$sql_select="SELECT a.student_sn,a.year,a.semester,a.weight,a.height,b.stud_person_id,b.stud_study_cond,b.stud_study_year FROM health_WH AS a LEFT JOIN stud_base AS b ON a.student_sn=b.student_sn";
		$web_id=1;
	} else {
		if (in_array($table_id,$health_tables_no_id))
		$sql_select="SELECT *  FROM $table_name ";
		else
		$sql_select="SELECT b.stud_person_id, a.*  FROM $table_name a LEFT JOIN stud_base b  ON a.student_sn=b.student_sn ";
	}
	$res=$CONN->Execute($sql_select) or user_error("��ƪ�  $table_id $table_name Ū�����ѡI<br>$sql_select",256);
	$field_count=$res->FieldCount();
	for($i=0;$i<$field_count;$i++) {
		$field_data=$res->FetchField($i);
		$field_name=$field_data->name;
		$fields_name.="\"$field_name\",";
	}
	$all_str=substr($fields_name,0,-1)."\r\n";

	if ($web_id) {
		$smarty->assign("IS_JHORES",$IS_JHORES);
		$smarty->assign("rowdata",$res->GetRows());
		header("Content-disposition: attachment; filename=web_WH.csv");
		header("Content-type: text/x-csv ; Charset=Big5");
		//header("Pragma: no-cache");
						//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

		header("Expires: 0");
		$smarty->display("health_".$table_name."_csv.tpl");
		exit;
	} else {
		while(!$res->EOF) {
			$row_str='';
			for($i=0;$i<$field_count;$i++) {
				$field_data='"'.$res->Fields($i).'",';
				$row_str.=$field_data;
			}
			$all_str.=substr($row_str,0,-1)."\r\n";
			$res->MoveNext();
		}
	}
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: text/x-csv");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");
	echo $all_str;
} else {
	head('���d�Ҳո�ƪ�DUMP');
	echo print_menu($school_menu_p);
	echo "<table style='border-collapse: collapse' borderColor='#111111' cellSpacing='0' cellPadding='10' width='100%' border='1'>
		<tr>
			<td width='249' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=1'>01)&nbsp; health_WH&nbsp; �����魫�O����</a></font></td>
			<td width='241' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=11'>11)&nbsp; health_bodymind&nbsp;
			���߻�ê��U�O��</a></font></td>
			<td width='233' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=21'>21)&nbsp; health_hospital&nbsp;
			�@�e��|</a></font></td>
			<td width='214' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=31'>31)&nbsp; health_teeth&nbsp;
			�������d������</a></font></td>
		</tr>
		<tr>
			<td width='249' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=2'>02)&nbsp; health_accident_attend&nbsp;
			�˯f�B�z�覡</a></font></td>
			<td width='241' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=12'>12)&nbsp; health_checks_doctor&nbsp;
			������v�O��</a></font></td>
			<td width='233' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=22'>22)&nbsp; health_hospital_record&nbsp;
			�@�e��|�O��</a></font></td>
			<td width='214' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=32'>32)&nbsp; health_uri&nbsp; ���G�ˬd</a></font></td>
		</tr>
		<tr>
			<td width='249' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=3'>03)&nbsp;
			health_accident_attend_record&nbsp; �˯f�B�z�O��</a></font></td>
			<td width='241' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=13'>13)&nbsp; health_checks_item&nbsp;
			���˶���</a></font></td>
			<td width='233' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=23'>23)&nbsp; health_inherit&nbsp;
			�a�گe�f�v</a></font></td>
			<td width='214' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=33'>33)&nbsp; health_worm&nbsp; �H�����ˬd</a></font></td>
		</tr>
		<tr>
			<td width='249' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=4'>04)&nbsp; health_accident_part&nbsp;
			�˯f����</a></font></td>
			<td width='241' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=14'>14)&nbsp; health_checks_record&nbsp;
			���˰O��</a></font></td>
			<td width='233' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=24'>24)&nbsp; health_inject_item&nbsp;
			�w�����ج̭]</a></font></td>
			<td width='214' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=34'>34)&nbsp; health_yellowcard&nbsp;
			���عw���O����</a></font></td>
		</tr>
		<tr>
			<td width='249' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=5'>05)&nbsp;
			health_accident_part_record&nbsp; �˯f����O��</a></font></td>
			<td width='241' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=15'>15)&nbsp; health_diag_record&nbsp;
			�E�_�O��</a></font></td>
			<td width='233' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=25'>25)&nbsp; health_inject_record&nbsp;
			���ذO��</a></font></td>
			<td width='214' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=35'>35)&nbsp; health_web_wh&nbsp;
			²�������魫</a></font></td>
		</tr>
		<tr>
			<td width='249' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=6'>06)&nbsp; health_accident_place&nbsp;
			�˯f�o�ͦa�I</a></font></td>
			<td width='241' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=16'>16)&nbsp; health_disease&nbsp;
			�ӤH�e�f�v</a></font></td>
			<td width='233' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=26'>26)&nbsp; health_insurance&nbsp;
			�O�I</a></font></td>
			<td width='214' bgColor='#CCFFCC'>�@</td>
		</tr>
		<tr>
			<td width='249' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=7'>07)&nbsp; health_accident_reason&nbsp;
			�˯f��]</a></font></td>
			<td width='241' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=17'>17)&nbsp; health_diseaseserious&nbsp;
			���j�˯f</a></font></td>
			<td width='233' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=27'>27)&nbsp; health_insurance_record&nbsp;
			�O�I�O��</a></font></td>
			<td width='214' bgColor='#CCFFCC'>�@</td>
		</tr>
		<tr>
			<td width='249' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=8'>08)&nbsp; health_accident_record&nbsp;
			�˯f�O��</a></font></td>
			<td width='241' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=18'>18)&nbsp; health_exam_item&nbsp;
			������ˬd����</a></font></td>
			<td width='233' bgColor='#CCFFCC'><font size='2'>
			<a href='CSV_OUT.php?table=28'>28)&nbsp; health_manage_record&nbsp;
			�E�_��B�m�O��</a></font></td>
			<td width='214' bgColor='#CCFFCC'>�@</td>
		</tr>
		<tr>
			<td width='249' bgColor='#CCFFCC' height='38'><font size='2'>
			<a href='CSV_OUT.php?table=9'>09)&nbsp; health_accident_status&nbsp;
			�˯f���O</a></font></td>
			<td width='241' bgColor='#CCFFCC' height='38'><font size='2'>
			<a href='CSV_OUT.php?table=19'>19)&nbsp; health_exam_record&nbsp;
			������ˬd���ذO��</a></font></td>
			<td width='233' bgColor='#CCFFCC' height='38'><font size='2'>
			<a href='CSV_OUT.php?table=29'>29)&nbsp; health_sight&nbsp; ���O�O����</a></font></td>
			<td width='214' bgColor='#CCFFCC' height='38'>�@</td>
		</tr>
		<tr>
			<td width='249' bgColor='#CCFFCC' height='38'><font size='2'>
			<a href='CSV_OUT.php?table=10'>10)&nbsp;
			health_accident_status_record&nbsp; �˯f���O�O��</a></font></td>
			<td width='241' bgColor='#CCFFCC' height='38'><font size='2'>
			<a href='CSV_OUT.php?table=20'>20)&nbsp; health_fday&nbsp; �����I���</a></font></td>
			<td width='233' bgColor='#CCFFCC' height='38'><font size='2'>
			<a href='CSV_OUT.php?table=30'>30)&nbsp; health_sight_ntu&nbsp;
			����P</a></font></td>
			<td width='233' bgColor='#CCFFCC' height='38'><font size='2'>
			<a href='CSV_OUT.php?table=00'>00)&nbsp; identification&nbsp;
			�����Ҧr��������</a></font></td>

		</tr>
	</table>";


	foot();
}

?>
