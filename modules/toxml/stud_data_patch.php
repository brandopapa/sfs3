<?php

// �ޤJ SFS3 ���禡�w
include "../../include/config.php";
include_once "../../include/sfs_case_dataarray.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
//�L�X���Y
head("��J�͸�Ƹɵn");

$tool_bar=make_menu($toxml_menu);
echo $tool_bar;

$selected_type=$_POST['selected_type'];
$selected_student=$_POST['selected_student'];
$selected_student_id=$_POST['selected_student_id'];

if($_POST['go']=='�g�J�ɵn���s�Z���')
{
	$seme_year_seme=$_POST['study_year_seme'];
	$study_grade=$_POST['study_grade'];
	$study_class_name=$_POST['study_class_name'];
	$study_seme_num=$_POST['study_seme_num'];
	$study_teacher_name=$_POST['study_teacher_name'];
	//var_dump($study_teacher_name);

	$sql="REPLACE INTO stud_seme_import(seme_year_seme,stud_id,seme_class_grade,seme_class_name,seme_num,student_sn,teacher_name) values";
	$count=count($study_year_seme);
	if($count)
	{
		for($i=0;$i<$count;$i++)
		{
			$sql.="('".$seme_year_seme[$i]."','$selected_student_id','".$study_grade[$i]."','".$study_class_name[$i]."','".$study_seme_num[$i]."','$selected_student','".$study_teacher_name[$i]."'),";
		}
		$sql=substr($sql,0,-1);
		$recordSet=$CONN->Execute($sql) or user_error("��s�s�Z�������ѡI<br>$sql",256);
		$message="<FONT COLOR='RED' SIZE=2>�e���g�J�ɶ��G".date("Y-m-d H:i:s")." </FONT> ";
	}
	//echo"<BR><BR>$sql<BR><BR>";
}
//------------------------------------------------------------------------------------------------------------------------------------------------- 
if($_POST['go']=='�g�J�ק諸���ʸ��')
{
	$move_id=$_POST['move_id'];
	$move_date=$_POST['move_date'];
	$move_kind=$_POST['move_kind'];
	$stud_id=$_POST['stud_id'];
	$move_year_seme=$_POST['move_year_seme'];
	$move_c_unit=$_POST['move_c_unit'];
	$move_c_date=$_POST['move_c_date'];
	$move_c_word=$_POST['move_c_word'];
	$move_c_num=$_POST['move_c_num'];
	$school_id=$_POST['school_id'];
	$school=$_POST['school'];
	$reason=$_POST['reason'];
	$city=$_POST['city'];

	$sql="REPLACE INTO stud_move_import(move_id,move_date,move_kind,stud_id,move_year_seme,move_c_unit,move_c_date,move_c_word,move_c_num,school_id,school,reason,city,student_sn,update_id,update_ip,update_time) values";
	$count=count($move_date);
	if($count)
	{
		//���N��ɵn�O���尣
		//$sql_delete="DELETE FROM stud_move_import WHERE student_sn=$selected_student";
		//$res=$CONN->Execute($sql_delete) or user_error("�R����ɵn���ʰO���������ѡI<br>$sql_delete",256);
		//�ɤW�ɵn���O��
		for($i=0;$i<$count;$i++)
		{
			if($move_date[$i] and $move_kind[$i])
				$sql.="({$move_id[$i]},'{$move_date[$i]}','{$move_kind[$i]}','$selected_student_id','{$move_year_seme[$i]}','{$move_c_unit[$i]}','{$move_c_date[$i]}','{$move_c_word[$i]}','{$move_c_num[$i]}','{$school_id[$i]}','{$school[$i]}','{$reason[$i]}','{$city[$i]}','$selected_student','{$_SESSION [session_log_id]}','{$_SERVER['REMOTE_ADDR']}',NOW()),";
		}
		$sql=substr($sql,0,-1);
		$recordSet=$CONN->Execute($sql) or user_error("��s���ʬ������ѡI<br>$sql",256);
		$message="<FONT COLOR='RED' SIZE=2>�e���ק�g�J�ɶ��G".date("Y-m-d H:i:s")." </FONT><BR>";
	}
	//echo"<BR><BR>$sql<BR><BR>";
}
//------------------------------------------------------------------------------------------------------------------------------------------------- 
if($_POST['go']=='�g�J�s�W�����ʸ��')
{
	$move_date=$_POST['a_move_date'];
	$move_kind=$_POST['a_move_kind'];
	$stud_id=$_POST['a_stud_id'];
	$move_year_seme=$_POST['a_move_year_seme'];
	$move_c_unit=$_POST['a_move_c_unit'];
	$move_c_date=$_POST['a_move_c_date'];
	$move_c_word=$_POST['a_move_c_word'];
	$move_c_num=$_POST['a_move_c_num'];
	$school_id=$_POST['a_school_id'];
	$school=$_POST['a_school'];
	$reason=$_POST['a_reason'];
	$city=$_POST['a_city'];

	$sql="INSERT INTO stud_move_import(move_date,move_kind,stud_id,move_year_seme,move_c_unit,move_c_date,move_c_word,move_c_num,school_id,school,reason,city,student_sn,update_id,update_ip,update_time) values";
	if($move_date and $move_kind)
	{
		$sql.="('$move_date','$move_kind','$selected_student_id','$move_year_seme','$move_c_unit','$move_c_date','$move_c_word','$move_c_num','$school_id','$school','$reason','$city','$selected_student','{$_SESSION [session_log_id]}','{$_SERVER['REMOTE_ADDR']}',NOW());";
		$recordSet=$CONN->Execute($sql) or user_error("�s�W���ʬ������ѡI<br>$sql",256);
	}
	//echo"<BR><BR>$sql<BR><BR>";
}

//2013/02/27 by smallduh
//�W�[�@�Ӫ��ΰO��
if ($_POST['club_act']=='club_add') {
 $query="insert into association (student_sn,seme_year_seme,association_name,score,description,update_sn,update_time) values ('".$selected_student."','".$_POST['year_seme']."','".$_POST['association_name']."','".$_POST['score']."','".$_POST['description']."','".$_SESSION['session_tea_sn']."',NOW())";
 mysql_query($query);
}
//�R���@�Ӫ��ΰO��
if ($_POST['club_act']=='club_delete') {
 $query="delete from association where sn='".$_POST['club_option']."'";
 mysql_query($query);
}

//-------------------------------------------------------------------------------------------------------------------------------------------------
/*
if($selected_student)
{
	$data_types=array('�Ǵ��s�Z'=>'','���ʬ���'=>'','�Ǵ����Z'=>'../score_input_all_new/person_seme_input.php');
	$data_type_radio="����ܸɵn���ءG";
	foreach($data_types as $key=>$value)
	{
		if($key==$selected_type) $action_target=$value;
		$data_type_radio.="<input type='radio' value='$key' name='selected_type'".(($key==$selected_type)?' checked':'')." onclick='this.form.submit()'>$key ";	
	}
	if(! $action_target) $action_target=$_SERVER['SCRIPT_NAME'];
}
*/
//���o�~�׻P�Ǵ����U�Կ��
$work_year_seme=$_REQUEST[work_year_seme];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$move_year_seme = intval(substr($work_year_seme,0,-1)).substr($work_year_seme,-1,1);

$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());

$seme_list=get_class_seme();
$main="<hr><form name='myform' method='post' action='{$_SERVER['SCRIPT_NAME']}'>
	�������J���Ǵ��G<select name='work_year_seme' onchange='document.myform.submit()'>";
foreach($seme_list as $key=>$value){
	$main.="<option ".($key==$work_year_seme?"selected":"")." value=$key>$value</option>";
}
$main.="</select><hr>";


//���o����
//if($selected_student)
//{
	$data_types=array('1'=>'�Ǵ��s�Z','2'=>'���ʬ���','3'=>'���ΰO��','4'=>'�Ǵ����Z');
	$data_type_radio="����ܸɵn���ءG";
	foreach($data_types as $key=>$value)
	{
		$data_type_radio.="<input type='radio' value='$key' name='selected_type'".(($key==$selected_type)?' checked':'')." onclick='this.form.submit()'>$value ";	
	}
	$data_type_radio.="<hr>";
//}

if($selected_type)
{
//���o�ӾǴ���J�ǥͲM��
$sql="SELECT a.*,b.stud_id,b.stud_name,b.stud_sex,b.stud_study_year FROM stud_move a LEFT JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.move_kind in (2,3,14) AND move_year_seme='$move_year_seme' ORDER BY move_date DESC";
$recordSet=$CONN->Execute($sql) or user_error("Ū��stud_move�Bstud_base��ƥ��ѡI<br>$sql",256);

$col=3; //�]�w�C�@�C��ܴX�H
$studentdata="����ܱ��ɵn���ǥ͡G<table>";
$student_radio='';
while(!$recordSet->EOF)
{
	$currentrow=$recordSet->currentrow()+1;
	if($currentrow % $col==1) $studentdata.="<tr>";
	$student_sn=$recordSet->fields['student_sn'];
	$stud_id=$recordSet->fields['stud_id'];
	$stud_name=$recordSet->fields['stud_name'];
	$stud_move_date=$recordSet->fields['move_date'];
	if($recordSet->fields['stud_sex']=='1') $color='#CCFFCC'; else  $color='#FFCCCC';
	if($student_sn==$selected_student) {
		$color='#FFFFAA';
		$stud_study_year=$recordSet->fields['stud_study_year'];
		$selected_student_id=$stud_id;
	}
	
	$student_radio="<input type='radio' value='$student_sn' name='selected_student'".(($student_sn==$selected_student)?' checked':'')." onclick='document.myform.submit()'>( $student_sn - $stud_id ) $stud_name - $stud_move_date";	
	
	$studentdata.="<td bgcolor='$color' align='center'> $student_radio </td>";

	if( $currentrow % $col==0  or $recordSet->EOF) $studentdata.="</tr>";
	$recordSet->movenext();
}
$studentdata.='</table><hr>';

//�̾ڿﶵ��ܸӥͥثe���p
if($selected_student)
switch($selected_type)
{
	case '1': //�s�Z���
		//�������N�ǾǴ�
		$counter=$IS_JHORES?3:6;
		$seme_class_cond=array();
		for($grade=1;$grade<=$counter;$grade++)
		{
			for($semester=1;$semester<=2;$semester++)
			{
				$real_grade=$grade+$IS_JHORES;
				$study_year=$stud_study_year+$grade-1;
				$seme_year_seme=sprintf('%03d%d',$study_year,$semester);
				$seme_class_cond[$seme_year_seme]['grade']=$real_grade;
				$seme_class_cond[$seme_year_seme]['data_source']='0';
			}
		}
	
		//���stud_seme_import������
		$sql="SELECT seme_year_seme,seme_class_grade,seme_class_name,seme_num,teacher_name FROM stud_seme_import WHERE student_sn=$selected_student ORDER BY seme_year_seme";
		$recordSet=$CONN->Execute($sql) or user_error("Ū��stud_seme_import��ƥ��ѡI<br>$sql",256);
		while(!$recordSet->EOF)
		{
			$seme_year_seme=$recordSet->fields['seme_year_seme'];
			
			$seme_class_cond[$seme_year_seme]['seme_class']=$recordSet->fields['seme_class_grade'];
			$seme_class_cond[$seme_year_seme]['seme_class_name']=$recordSet->fields['seme_class_name'];
			$seme_class_cond[$seme_year_seme]['seme_num']=$recordSet->fields['seme_num'];
			$seme_class_cond[$seme_year_seme]['teacher_name']=$recordSet->fields['teacher_name'];
			
			$seme_class_cond[$seme_year_seme]['data_source']='2';
	
			$recordSet->movenext();
		}
			
		//���stud_seme������
		$sql="SELECT seme_year_seme,seme_class,seme_class_name,seme_num FROM stud_seme WHERE student_sn=$selected_student ORDER BY seme_year_seme";
		$recordSet=$CONN->Execute($sql) or user_error("Ū��stud_seme��ƥ��ѡI<br>$sql",256);
		while(!$recordSet->EOF)
		{
			$seme_year_seme=$recordSet->fields['seme_year_seme'];
			
			$seme_class_cond[$seme_year_seme]['seme_class']=$recordSet->fields['seme_class'];
			$seme_class_cond[$seme_year_seme]['seme_class_name']=$recordSet->fields['seme_class_name'];
			$seme_class_cond[$seme_year_seme]['seme_num']=$recordSet->fields['seme_num'];
			$seme_class_cond[$seme_year_seme]['data_source']='1';
			$recordSet->movenext();
		}
	
		//echo "<pre>";
		//print_r($seme_class_cond);
		//echo "</pre>";		
		
		//��ܨåi�����ץ�
		$show_data="<table width='80%' border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>";
		$show_data.="<tr bgcolor='#FFFFAA'><td align='center'>�Ǵ��O</td><td align='center'>�~��</td><td align='center'>�Z��</td><td align='center'>�y��</td><td align='center'>�ɮv�m�W</td><td align='center'>��ƨӷ�</td></tr>";
		foreach($seme_class_cond as $seme_year_seme=>$value)
		{
			$grade=substr($value['grade'],0,1);
			//echo "<BR>".substr($value['grade'],0,1)."---<BR>".$value['grade']."<BR>";
			$class_name=$value['seme_class_name'];
			$seme_num=$value['seme_num'];
			$teacher_name=$value['teacher_name'];
			switch($value['data_source'])
			{
				case '0': $data_source=''; break;
				case '1': $data_source='���մNŪ����(stud_seme)'; break;
				case '2': $data_source='�ɵn����(stud_seme_import)'; break;			
			}
			if($curr_year_seme>=$seme_year_seme)
			{
				if($value['data_source']=='1') $show_data.="<tr><td align='center'>$seme_year_seme</td><td align='center'>$grade</td><td align='center'>$class_name</td><td align='center'>$seme_num</td><td align='center'>$teacher_name</td><td>$data_source</td></tr>";
				else  $show_data.="<tr><td align='center'>$seme_year_seme<input type='hidden' name='study_year_seme[]' value='$seme_year_seme'></td><td align='center'><input type='text' name='study_grade[]' value='$grade' size=2 maxlength=2></td><td align='center'><input type='text' name='study_class_name[]' value='$class_name' size=8 maxlength=8></td><td align='center'><input type='text' name='study_seme_num[]' value='$seme_num' size=2 maxlength=2></td><td align='center'><input type='text' name='study_teacher_name[]' value='$teacher_name' maxlength=20></td><td>$data_source</td></tr>";
			} //else $show_data.="<tr><td align='center'>$seme_year_seme</td><td align='center'>$grade</td><td align='center'>--</td><td align='center'>--</td><td align='center'>--</td><td align='center'>--</td></tr>";
		}
		$show_data.="<tr bgcolor='#FFFFAA'><td colspan=4 align='center'>$message</td><td colspan=2 align='center'><input type='hidden' name='selected_student_id' value='$selected_student_id'><input type='submit' name='go' value='�g�J�ɵn���s�Z���'></td></tr></table>";
		break;
		
	case '2': //���ʬ���
		$counter=$IS_JHORES?3:6;
		$seme_move_cond=array();
	
		//���stud_seme_import������
		$sql="SELECT * FROM stud_move_import WHERE student_sn=$selected_student ORDER BY move_date";
		$recordSet=$CONN->Execute($sql) or user_error("Ū��stud_move_import��ƥ��ѡI<br>$sql",256);
		while(!$recordSet->EOF)
		{
			$move_date=$recordSet->fields['move_date'];
			$seme_move_cond[$move_date]['move_id']=$recordSet->fields['move_id'];
			$seme_move_cond[$move_date]['data_source']='2';
			$seme_move_cond[$move_date]['move_year_seme']=$recordSet->fields['move_year_seme'];
			$seme_move_cond[$move_date]['stud_id']=$recordSet->fields['stud_id'];
			$seme_move_cond[$move_date]['move_kind']=$recordSet->fields['move_kind'];
			$seme_move_cond[$move_date]['school_move_num']=$recordSet->fields['school_move_num'];
			$seme_move_cond[$move_date]['move_c_unit']=$recordSet->fields['move_c_unit'];
			$seme_move_cond[$move_date]['move_c_date']=$recordSet->fields['move_c_date'];
			$seme_move_cond[$move_date]['move_c_word']=$recordSet->fields['move_c_word'];
			$seme_move_cond[$move_date]['move_c_num']=$recordSet->fields['move_c_num'];
			$seme_move_cond[$move_date]['update_time']=$recordSet->fields['update_time'];
			$seme_move_cond[$move_date]['update_id']=$recordSet->fields['update_id'];
			$seme_move_cond[$move_date]['update_ip']=$recordSet->fields['update_ip'];
			$seme_move_cond[$move_date]['school']=$recordSet->fields['school'];
			$seme_move_cond[$move_date]['school_id']=$recordSet->fields['school_id'];
			$seme_move_cond[$move_date]['student_sn']=$recordSet->fields['student_sn'];
			$seme_move_cond[$move_date]['reason']=$recordSet->fields['reason'];
			$seme_move_cond[$move_date]['city']=$recordSet->fields['city'];

			$recordSet->movenext();
		}
		//���stud_seme������
		$sql="SELECT * FROM stud_move WHERE student_sn=$selected_student ORDER BY move_date";
		$recordSet=$CONN->Execute($sql) or user_error("Ū��stud_move_import��ƥ��ѡI<br>$sql",256);
		while(!$recordSet->EOF)
		{
			$move_date=$recordSet->fields['move_date'];
			$seme_move_cond[$move_date]['move_id']=$recordSet->fields['move_id'];
			$seme_move_cond[$move_date]['data_source']='1';
			$seme_move_cond[$move_date]['move_year_seme']=$recordSet->fields['move_year_seme'];
			$seme_move_cond[$move_date]['stud_id']=$recordSet->fields['stud_id'];
			$seme_move_cond[$move_date]['move_kind']=$recordSet->fields['move_kind'];
			$seme_move_cond[$move_date]['school_move_num']=$recordSet->fields['school_move_num'];
			$seme_move_cond[$move_date]['move_c_unit']=$recordSet->fields['move_c_unit'];
			$seme_move_cond[$move_date]['move_c_date']=$recordSet->fields['move_c_date'];
			$seme_move_cond[$move_date]['move_c_word']=$recordSet->fields['move_c_word'];
			$seme_move_cond[$move_date]['move_c_num']=$recordSet->fields['move_c_num'];
			$seme_move_cond[$move_date]['update_time']=$recordSet->fields['update_time'];
			$seme_move_cond[$move_date]['update_id']=$recordSet->fields['update_id'];
			$seme_move_cond[$move_date]['update_ip']=$recordSet->fields['update_ip'];
			$seme_move_cond[$move_date]['school']=$recordSet->fields['school'];
			$seme_move_cond[$move_date]['school_id']=$recordSet->fields['school_id'];
			$seme_move_cond[$move_date]['student_sn']=$recordSet->fields['student_sn'];
			$seme_move_cond[$move_date]['reason']=$recordSet->fields['reason'];
			$seme_move_cond[$move_date]['city']=$recordSet->fields['city'];

			$recordSet->movenext();
		}
	
		//echo "<pre>";
		//print_r($seme_move_cond);
		//echo "</pre>";
		//�̤���Ƨ�
		ksort($seme_move_cond);
		//��ܨåi�����ץ�
		$show_data="<table width='100%' border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse ;font-size:10pt;' bordercolor='#111111' width='100%'>";
		$show_data.="<tr bgcolor='#FFCCAA'><td align='center'>���ʤ��</td><td align='center'>���O</td><td align='center'>�Ǹ�</td><td align='center'>�Ǧ~�Ǵ�</td><td align='center'>�֭���</td><td align='center'>�֭���</td><td align='center'>�֭�r��</td><td align='center'>��X�J�ǮեN���ΦW��</td><td align='center'>���ʭ�]</td><td align='center'>��NŪ�Ǯտ���</td><td align='center'>�����ӷ�</td></tr>";
		$edit_count=0;
		foreach($seme_move_cond as $move_date=>$value)
		{
			$move_id=$value['move_id'];
			$move_kind=$value['move_kind'];
			$move_year_seme=$value['move_year_seme'];
			$school_move_num=$value['school_move_num'];
			
			$move_c_unit=$value['move_c_unit'];
			$move_c_date=$value['move_c_date'];
			$move_c_word=$value['move_c_word'];
			$move_c_num=$value['move_c_num'];
			$school=$value['school'];
			$school_id=$value['school_id'];
			$stud_id=$value['stud_id'];
			$reason=$value['reason'];
			$city=$value['city'];

			switch($value['data_source'])
			{
				case '1': $data_source='���ղ��ʬ���(stud_move)'; break;
				case '2': $data_source='�ɵn�L�լ���(stud_move_import)'; $edit_count++; break;			
			}
			if($value['data_source']=='1')
				$show_data.="<tr><td align='center'>$move_date</td><td align='center'>$move_kind</td><td align='center'>$stud_id</td><td align='center'>$move_year_seme</td><td align='center'>$move_c_unit</td>
					<td align='center'>$move_c_date</td><td align='center'>$move_c_word $move_c_num</td><td align='center'>$school $school_id</td><td align='center'>$reason</td><td align='center'>$city</td><td>$data_source</td></tr>";
			else $show_data.="<tr><input type='hidden' name='move_id[]' value='$move_id'><td align='center'><input type='text' name='move_date[]' value='$move_date' size=8></td><td align='center'><input type='text' name='move_kind[]' value='$move_kind' size=2></td><td><input type='text' name='stud_id[]' value='$stud_id' size=6></td>
					<td align='center'><input type='text' name='move_year_seme[]' value='$move_year_seme' size=4></td><td align='center'><input type='text' name='move_c_unit[]' value='$move_c_unit' size=8></td>
					<td align='center'><input type='text' name='move_c_date[]' value='$move_c_date' size=8></td><td align='center'><input type='text' name='move_c_word[]' value='$move_c_word' size=6> <input type='text' name='move_c_num[]' value='$move_c_num' size=8></td><td align='center'><input type='text' name='school_id[]' value='$school_id' size=6> <input type='text' name='school[]' value='$school' size=10></td> 
					<td align='center'><input type='text' name='reason[]' value='$reason' size=6></td><td align='center'><input type='text' name='city[]' value='$city' size=6></td><td>$data_source</td></tr>";
		}
		$message.="�����O�N�������G2:��J 3:�����_�� 4:��Ǵ_�� 5:���~ 6:��� 7:�X�� 8:�ծ�(��X) 9:�ɯ� 10:���� 11:���` 12:���� 13:�s�ͤJ�� 14:��Ǵ_�� 15:�b�a�۾�"; 
		//�[�C�ť�
		$append_data="<tr bgcolor='#FFCCAA'><td align='center'><input type='text' name='a_move_date' value='' size=8></td><td align='center'><input type='text' name='a_move_kind' value='' size=2></td><td><input type='text' name='a_stud_id' value='' size=6></td>
					<td align='center'><input type='text' name='a_move_year_seme' value='' size=4></td><td align='center'><input type='text' name='a_move_c_unit' value='' size=8></td>
					<td align='center'><input type='text' name='a_move_c_date' value='' size=8></td><td align='center'><input type='text' name='a_move_c_word' value='' size=6> <input type='text' name='a_move_c_num' value='' size=8></td><td align='center'><input type='text' name='a_school_id' value='' size=6> <input type='text' name='a_school' value='' size=10></td> 
					<td align='center'><input type='text' name='a_reason' value='' size=6></td><td align='center'><input type='text' name='a_city' value='' size=6></td><td><input type='submit' name='go' value='�g�J�s�W�����ʸ��'></td></tr>";
		
		$show_data.="<tr bgcolor='#CAFACF'><td colspan=10 align='center'>$message</td><td align='center'><input type='hidden' name='selected_student_id' value='$selected_student_id'>".($edit_count?"<input type='submit' name='go' value='�g�J�ק諸���ʸ��'>":"")."</td></tr><tr></tr>$append_data</table>";
	
		break;
	case '4':
		$show_data="<br><br><center><input type='hidden' name='stud_id' value='$selected_student_id'><input type='hidden' name='student_sn' value='$selected_student'><input type='button' name='score' value='�Ы����s���� [���Z�ɵn�ק� ] �Ҳնi��ɵn' onclick=\"document.myform.action='../score_input_all_new/person_seme_input.php'; document.myform.submit();\"></center>";
		break;
	case '3': //���ΰO��
		
		$show_club_form="
		
		 <br>
		 
		  <input type='hidden' name='club_act' value=''>
		  <input type='hidden' name='club_option' value=''>
		  
		  <input type='hidden' name='selected_student_id' value='$selected_student_id'>
		  <font color='#800000'>���ɵn���ΰO��</font>
		  <table border='1' style='border-collapse:collapse' bordercolor='#800000'>
		    <tr bgcolor='#FFCCFF'>
		     <td align='center'>�Ǵ�</td>
		     <td align='center'>���ΦW��</td>
		     <td align='center'>���Z(0-100��)</td>
		     <td align='center'>���ɦѮv���y</td>
		     <td align='center'>&nbsp;</td>
			  </tr>
			  ";
			$query="select * from association where student_sn='$selected_student' order by seme_year_seme";
			$res=mysql_query($query);
			while ($row=mysql_fetch_array($res,1)) {
			 $del_mode=($row['club_sn']>0)?"<font size=2 color=red><i>�դ�����</i></font>":"<input type='button' value='�R��' onclick=\"if(confirm('�z�T�w�n�R���ӥͪ�\����:�u".$row['association_name']."�v�O��?')) { document.myform.club_option.value='".$row['sn']."';document.myform.club_act.value='club_delete';document.myform.submit(); } \">";
			 $dd="
		    <tr>
		     <td align='center'>".$row['seme_year_seme']."</td>
		     <td align='center'>".$row['association_name']."</td>
		     <td align='center'>".$row['score']."</td>
		     <td>".$row['description']."</td>
		     <td align='center'>".$del_mode."</td></tr>";
			   $show_club_form.=$dd;
			}  			  
			$show_club_form.="  
		    <tr>
		     <td align='center'><input type='text' name='year_seme' size='5'></td>
		     <td align='center'><input type='text' name='association_name' size='20'></td>
		     <td align='center'><input type='text' name='score' size='5'></td>
		     <td><input type='text' name='description' size='50'></td>
		     <td><input type='button' value='�s�W���θ��' onclick=\"if( document.myform.association_name.value!='') { document.myform.club_act.value='club_add';document.myform.submit(); } \">
			  </tr>
		  </table>
      ������:<br>
      1.�Ǵ��п�J�Ǧ~+�Ǵ��O, �p: 99�Ǧ~��1�Ǵ�, �h��J 991 �C<br>
      2.�H���ҲթҸɵn�����, �b���μҲդ��L�k�d�o, �����Z�椺�i���`��X.
   		 
		 
		";
		
		$show_data.=$show_club_form;
		
		break;
} // end switch
}
echo $main.$data_type_radio.$studentdata.$show_data."</form>";

foot();
?>
