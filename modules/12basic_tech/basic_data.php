<?php

include "config.php";

sfs_check();

//�q�X����
head("�ǥͨ����P�C�����~");
print_menu($menu_p);

//�Ǵ��O
$work_year_seme=$_REQUEST['work_year_seme'];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$academic_year=substr($curr_year_seme,0,-1);
$work_year=substr($work_year_seme,0,-1);
$session_tea_sn=$_SESSION['session_tea_sn'];

$stud_class=$_REQUEST['stud_class'];
$selected_stud=$_POST['selected_stud'];
$edit_sn=$_POST['edit_sn'];

$show_zero=$_POST['show_zero']?'checked':'';


if($_POST['act']=='�T�w�ק�'){
	//���@�H���
	//$sql="UPDATE stud_domicile SET guardian_name='{$_POST['guardian_name']}',guardian_phone='{$_POST['guardian_phone']}',guardian_hand_phone='{$_POST['guardian_hand_phone']}',guardian_address='{$_POST['guardian_address']}' WHERE student_sn=$edit_sn";
	//$res=$CONN->Execute($sql) or user_error("�g�J���ѡI<br>$sql",256);
	//stud_base�l���ϸ�
	$sql="UPDATE stud_base SET addr_zip='{$_POST['addr_zip']}' WHERE student_sn=$edit_sn";
	$res=$CONN->Execute($sql) or user_error("�g�J���ѡI<br>$sql",256);
	$edit_sn=0;
}

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);
//$tool_icon="<input type='checkbox' name='show_zero' value=1 $show_zero onclick=\"this.form.submit();\"><font size=2 color='green'>��ܡu(0)�@��͡v</font>";
//if($work_year==$academic_year) $tool_icon.="<font size=1>���X�{��������ЮɡA�i�֫���U�i�i��ק</font>";
$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester $class_list $tool_icon <table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width='100%'>";
if($stud_class)
{
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$student_list_array=get_student_list($work_year);
	
	//�ˬd�O�_���i�ק�������ѻP�K�վǥ�
	$editable_sn_array=get_editable_sn($work_year);
	
	//���o���w�Ǧ~�w�g�}�C���ǥͨ���	
	$id_array=get_student_id($work_year);	
	
	//���o�ǥͰ򥻸��
	$student_data=get_student_data($work_year);
	//���o���@�H���
	$domicile_data=get_domicile_data($work_year);
	
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_study_year,b.stud_id FROM stud_seme a INNER JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' ORDER BY a.seme_num";
	$rs=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	$studentdata="<tr align='center' bgcolor='#ff8888'><td>�y��</td><td>�m�W</td><td>�j�Y��</td><td>�Ǹ�</td><td>�����Ҧr��</td><td>�~</td><td>��</td><td>��</td><td>�����q��</td><td>��ʹq��</td><td>�l���ϸ�</td><td>�a�}</td>";
	while(!$rs->EOF) {
		$student_sn=$rs->fields['student_sn'];
		$seme_num=$rs->fields['seme_num'];
		$stud_name=$rs->fields['stud_name'];
		$stud_id=$rs->fields['stud_id'];
		$stud_study_year=$rs->fields['stud_study_year'];
		
		$stud_sex=$student_data[$student_sn]['stud_sex'];		
		$stud_person_id=$student_data[$student_sn]['stud_person_id'];		
		$birth_year=$student_data[$student_sn]['birth_year'];
		$birth_month=$student_data[$student_sn]['birth_month'];
		$birth_day=$student_data[$student_sn]['birth_day'];
		
		//�ǥ��p����ƳB�z		
		$stud_tel_2=$student_data[$student_sn]['stud_tel_2']?$student_data[$student_sn]['stud_tel_2']:$student_data[$student_sn]['stud_tel_1'];
		$addr_zip=$student_data[$student_sn]['addr_zip'];
		$stud_addr_2=$student_data[$student_sn]['stud_addr_2']?$student_data[$student_sn]['stud_addr_2']:$student_data[$student_sn]['stud_addr_1'];
		
		$guardian_name=$domicile_data[$student_sn]['guardian_name'];
		$guardian_phone=$domicile_data[$student_sn]['guardian_phone'];
		$guardian_hand_phone=$domicile_data[$student_sn]['guardian_hand_phone']?$domicile_data[$student_sn]['guardian_hand_phone']:$student_data[$student_sn]['stud_tel_3'];
		
		$guardian_phone=$guardian_phone?$guardian_phone:$stud_tel_2;
		$guardian_address=$domicile_data[$student_sn]['guardian_address']?$domicile_data[$student_sn]['guardian_address']:$stud_addr_2;

		
		$my_pic=$pic_checked?get_pic($stud_study_year,$stud_id):'';
		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#CCFFCC":"#FFCCCC";

		$action='';
		$java_script='';
		if($student_sn==$edit_sn){	
			$guardian_name="<input type='text' name='guardian_name' value='$guardian_name' size=10>";
			$guardian_phone="<input type='text' name='guardian_phone' value='$guardian_phone' size=10>";
			$guardian_hand_phone="<input type='text' name='guardian_hand_phone' value='$guardian_hand_phone' size=14>";
			$addr_zip="<input type='text' name='addr_zip' value='$addr_zip' size=5>";
			$guardian_address="<input type='text' name='guardian_address' value='$guardian_address' size=40>";
			
			//�ʧ@���s
			$action="<input type='submit' name='act' value='�T�w�ק�' onclick='return confirm(\"�T�w�n�ק� $stud_name ���򥻸��?\")'> <input type='submit' name='act' value='����' onclick='document.myform.edit_sn.value=0;'>";		
			$stud_sex_color='#ffffaa';
		} else {		
			if(array_key_exists($student_sn,$student_list_array)){
				$editable=array_key_exists($student_sn,$editable_sn_array)?1:0;
				$stud_sex_color=$editable?$stud_sex_color:$uneditable_bgcolor;
				$java_script=($work_year==$academic_year and $editable and $comm_editable)?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='$stud_sex_color';\" ondblclick='document.myform.edit_sn.value=\"$student_sn\"; document.myform.submit();'":'';
			} else { $stud_sex_color='#aaaaaa'; }
		}
		$stud_sex_color=array_key_exists($student_sn,$student_list_array)?$stud_sex_color:'#aaaaaa';		
		$studentdata.="<tr align='center' bgcolor='$stud_sex_color' $java_script><td>$seme_num</td><td>$stud_name</td><td width=$pic_width>$my_pic</td><td>$stud_id</td><td>$stud_person_id</td><td>$birth_year</td><td>$birth_month</td><td>$birth_day</td><td>$guardian_phone</td><td>$guardian_hand_phone</td><td>$addr_zip</td><td align='left'>$guardian_address $action</td></tr>";
	
		$rs->MoveNext();
	}
}

//��ܫʦs���A��T
echo get_sealed_status($work_year).'<br>';

echo $main.$studentdata."</form></table>";
foot();
?>