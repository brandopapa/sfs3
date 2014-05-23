<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

//�q�X����
head("�ǥͨ����O�����]�w");
print_menu($menu_p);

//�Ǵ��O
$work_year_seme=$_REQUEST['work_year_seme'];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$academic_year=substr($curr_year_seme,0,-1);
$work_year=substr($work_year_seme,0,-1);
$session_tea_sn=$_SESSION['session_tea_sn'];

//���o�ǥͨ����C��
$type_select="SELECT d_id,t_name FROM sfs_text WHERE t_kind='stud_kind' AND d_id>0 order by t_order_id";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
while(list($d_id,$t_name)=$recordSet->FetchRow()) {
	$kinddata[$d_id]=$t_name;
}

if($_POST['act']=='�x�s�í��s�]�w���W����'){
	//���i�ק�L���~��
	if($work_year>=curr_year()){
		$kind_data_array=$_POST['kind_select'];
		$kind_data=serialize($kind_data_array);
		$disability_data_array=$_POST['disability_select'];
		$disability_data=serialize($disability_data_array);
		$free_data_array=$_POST['free_select'];
		$free_data=serialize($free_data_array);
				
		//�g�J��ƪ�
		$sql="REPLACE INTO 12basic_kind_ylc SET year_seme='$work_year_seme',kind_data='$kind_data',disability_data='$disability_data',free_data='$free_data'";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);	
	
		//�M���J���]�w
		$sql="UPDATE 12basic_ylc SET kind_id=NULL,free_id=NULL,score_disadvantage=NULL WHERE academic_year='$work_year'";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		
		//����ǥͨ������O��ƨèM�w�䨭��
		$sql="SELECT a.student_sn,b.stud_kind FROM 12basic_ylc a INNER JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.academic_year='$work_year'";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		while(!$res->EOF){
			$student_sn=$res->fields['student_sn'];
			$stud_kind_arr=explode(',',$res->fields['stud_kind']);
			$kind_id=0;
			$kind_rate=0;
			$disability_id=0;
			$free_id=0;
			$free_rate=0;
			$score_disadvantage=0;
							
			foreach($stud_kind_arr as $key=>$value){
				if($value){
					//�ǥͨ���
					$kind_id=$kind_data_array[$value]?$kind_data_array[$value]:$kind_id;
// 					$a=$kind_data_array[$value];
// 					if($kind_rate<$stud_kind_rate[$a]){
// 						$kind_rate=$stud_kind_rate[$a];
// 						$kind_id=$a;				
// 					}
					
					//���߻�ê
					$disability_id=$disability_data_array[$value]?$disability_data_array[$value]:$disability_id;
					
					//�C�����~
					$free_id=$free_data_array[$value]?$free_data_array[$value]:$free_id;			
// 					$a=$free_data_array[$value];					
// 					if($free_rate<$stud_free_rate[$a]){
// 						$free_rate=$stud_free_rate[$a];
// 						$free_id=$a;				
// 					}
				}
			}	
							
			//�M�w�C���Τ��C���J��Ť�
			$score_disadvantage=($stud_free_rate[$free_id]>0)?2:0;
			
			//�P�w�ڻy�{�һP�_
// 			if($kind_id=='1' or $kind_id=='2'){
// 				����O�_�q�L�ڻy�{��
// 				$field_name=$kind_field_mirror[$native_language_sort];
// 				$sql="SELECT $field_name FROM stud_subkind WHERE student_sn=$student_sn and type_id='$native_id'";
// 				$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
// 				if($native_language_text==$rs->fields[0]) $kind_id='2'; else $kind_id='1';										
// 			}

			//�g�J��ƪ�
			$sql="UPDATE 12basic_ylc SET kind_id='$kind_id',disability_id='$disability_id',free_id='$free_id',score_disadvantage='$score_disadvantage',update_sn='$session_tea_sn' WHERE student_sn=$student_sn AND academic_year='$work_year'";
			$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);			
			$res->MoveNext();
		}
	} else {
		echo "<font size=4 color='red'>�I�I �T��ק�L���~�׸�� �I�I</font><br>";
	}
}

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester<input type='submit' name='act' value='�x�s�í��s�]�w���W����' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>
		<font size=1 color='red'><li>�ǥͨ��������� 1.���� �� 2.���~�H���l�k...��|�̷ӶQ�ռҲ��ܼƪ��]�w �۰ʧ�������ݩʸ�ƨM�w�O�_�q�L�ڻy�{�ҡI</li></font>
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1'>";

//������W�����P�C�����~������
$sql="SELECT * FROM `12basic_kind_ylc` WHERE year_seme='$work_year_seme'";
$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
$kind_mirror_array=unserialize($rs->fields['kind_data']);
$disability_mirror_array=unserialize($rs->fields['disability_data']);
$free_mirror_array=unserialize($rs->fields['free_data']);

$mirror_data="<tr align='center' bgcolor='#ccccff'><td>SFS3�ǰȨt�Τ����������O</td><td>�ǥͨ���</td><td>���߻�ê</td><td>�C�����~</td></tr>";
foreach($kinddata as $key=>$value){
	//���͹��������W����select����
	$kind_select="<select name='kind_select[$key]'>";
	foreach($stud_kind_arr_12ylc as $kind_key=>$kind_value){
		$selected='';
		$bg_color='';
		if($kind_key==$kind_mirror_array[$key]){
			$selected='selected';
			if($kind_mirror_array[$key]) $bg_color="style='background-color: #ffcccc;'";
		}
		$kind_select.="<option value='$kind_key' $selected $bg_color>($kind_key) $kind_value</option>";
	}
	$kind_select.="</select>";
	
	//���͹��������߻�êselect����
	$disability_select="<select name='disability_select[$key]'>";
	foreach($stud_disability_arr_12ylc as $disability_key=>$disability_value){
		$selected='';
		$bg_color='';
		if($disability_key==$disability_mirror_array[$key]){
			$selected='selected';
			if($disability_mirror_array[$key]) $bg_color="style='background-color: #ffcccc;'";
		}
		$disability_select.="<option value='$disability_key' $selected $bg_color>($disability_key) $disability_value</option>";
	}
	$disability_select.="</select>";
	
	//���͹������C�����~select����
	$free_select="<select name='free_select[$key]'>";
	foreach($stud_free_arr_12ylc as $free_key=>$free_value){
		$selected='';
		$bg_color='';
		if($free_key==$free_mirror_array[$key]){
			$selected='selected';
			if($free_mirror_array[$key]) $bg_color="style='background-color: #ffcccc;'";
		}
		$free_select.="<option value='$free_key' $selected $bg_color>($free_key) $free_value</option>";
	}
	$free_select.="</select>";
	
	$mirror_data.="<tr><td>($key)$value</td><td>$kind_select</td><td>$disability_select</td><td>$free_select</td></tr>";
}

echo $main.$mirror_data."</table></form>";
foot();
?>