<?php

include "config.php";

sfs_check();

//�Ǵ��O
$work_year_seme=$_REQUEST['work_year_seme'];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$academic_year=substr($curr_year_seme,0,-1);
$work_year=substr($work_year_seme,0,-1);
$session_tea_sn=$_SESSION['session_tea_sn'];



//��ܹ��
$level_arr=array("1"=>"��ک�","2"=>"�����","3"=>"�ϰ��(�󿤥�)","4"=>"������","5"=>"������(�m��)","6"=>"�դ�");

//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
$stud_select="SELECT student_sn,curr_class_num,stud_name,stud_sex,stud_id FROM stud_base
				WHERE student_sn IN (SELECT student_sn FROM 12basic_ptc WHERE academic_year='$work_year') ORDER BY curr_class_num";
$rs=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
while(!$rs->EOF){
	$student_sn=$rs->fields[student_sn];
	$seme_class=substr($rs->fields['curr_class_num'],0,-2);	
	$seme_num=substr($rs->fields['curr_class_num'],-2);
	$stud_name=$rs->fields['stud_name'];
	$stud_sex=$rs->fields['stud_sex'];
	$stud_id=$rs->fields['stud_id'];
	
	//����v�ɬ�����X
	$sql="select * from career_race where student_sn=$student_sn ORDER BY year,nature,certificate_date";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	if($res->RecordCount()) {
		echo "<div style='page-break-before:always;'><P>���ǮաG{$school_long_name}</P><P>���Z�šG{$seme_class} ���y���G{$seme_num} ���m�W�G{$stud_name} ���Ǹ��G{$stud_id}</P>";
		echo "<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr align='center' bgcolor='#ffcccc'><td>NO.</td><td>�Ǧ~��</td><td>�v�����O</td><td>�d��</td><td>�v�ɦW��</td><td>�o���W��</td><td>�ҮѤ��</td><td>�D����</td><td>�r��</td><td>�ĭp</td></tr>";  //<td>�ʽ�</td>
		$no=0;
		while(!$res->EOF)
		{
			$level=$res->fields['level'];
			$level=$level_arr[$level];
			$weight=$res->fields['weight']?'�O':'';
			if($level) {				
				$no++;
				$bgcolor=$weight?'':"bgcolor='#cccccc'";
				echo "<tr align='center' $bgcolor><td>$no</td><td>{$res->fields['year']}</td><td>{$res->fields['nature']}</td><td>$level</td><td align='left'>{$res->fields['name']}</td><td>{$res->fields['rank']}</td><td>{$res->fields['certificate_date']}</td><td align='left'>{$res->fields['sponsor']}</td><td align='left'>{$res->fields['word']}</td><td>$weight</td></tr>"; //<td>{$res->fields['squad']}</td>
			}
			$res->MoveNext();
		}
		echo "</table></div>";		
	}
	$rs->MoveNext();
}

?>