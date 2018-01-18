<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

sfs_check();

//�q�X����
head("�~�w�A��");
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

if($_POST['act']=='�έp���~�שҦ��}�C�ǥͫ~�w�A�Ȫ��Ť�'){
	//�쥻�~�שҦ��}�C�ǥͪ�student_sn
	$sn_array=get_student_list($work_year);

	//�L�O�L�O��&���y�O��
	$reward_array=get_student_reward($sn_array);
	
	//����X�ʮu�έp��
	$absence_array=get_student_seme_abs($absence_semester);

	//��s�Ť�
	foreach($sn_array as $key=>$student_sn){
		//�����stud_id
		$sql="SELECT stud_id FROM stud_base WHERE student_sn=$student_sn";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		$stud_id=$res->fields[0];
		//$my_abs_score=(array_key_exists($stud_id,$absence_array))?$absence_array[$stud_id]:$absence_score_array[0];
		$my_abs_score=$absence_score_max;
		$absence_sid=count_student_seme_abs($stud_id);		//����ǥ;��~�Ǵ��X�ʮu����
		foreach($absence_sid as $abs_seme=>$abs_days){
			if($abs_days>0) $my_abs_score--;
		}

		$sql="UPDATE 12basic_ylc SET score_reward='{$reward_array[$student_sn]['bonus'][2]}',score_fault='{$reward_array[$student_sn]['bonus'][1]}',score_absence='$my_abs_score'
				WHERE academic_year=$work_year AND student_sn=$student_sn AND editable='1'";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	}
};

if($_POST['act']=='�T�w�ק�') {
	$score_reward=min($_POST[edit_reward],$reward_score_max);
	$score_absence=min($_POST[edit_absence],$absence_score_max);
	$score_fault=min($_POST[edit_fault],$fault_score_max);
	
	$sql="UPDATE 12basic_ylc SET score_reward='$score_reward',score_absence='$score_absence',score_fault='$score_fault',moral_memo='$_POST[edit_memo]' WHERE academic_year=$work_year AND student_sn=$edit_sn";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	$edit_sn=0;
};

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);

if($work_year==$academic_year) $tool_icon.=" <input type='submit' value='�έp���~�שҦ��}�C�ǥͫ~�w�A�Ȫ��Ť�' name='act' onclick='return confirm(\"�T�w�n���s�έp���~�שҦ��}�C�ǥͫ~�w�A�Ȫ��Ť�?\")'>";
if($moral_editable) $tool_icon.=$editable_hint;

$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester $class_list $tool_icon <table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>";

if($stud_class)
{
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$listed=get_student_list($work_year);
	
	//���o���w�Ǧ~�w�g�}�C���~�w�A�Ȫ�����
	$moral_array=get_student_moral($work_year);

	//���o�L�O�L�P���y����
	$reward_array=get_student_reward();
	
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_study_year FROM stud_seme a INNER JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	$studentdata="<tr align='center' bgcolor='#ff8888'><td width=80>�Ǹ�</td><td width=50>�y��</td><td width=120>�m�W</td><td>���y�O��</td><td>�X�ʮu�O��</td><td>�L�O�L�O��</td><td>�Ť��έp</td><td>�Ƶ�</td>";
	while(list($student_sn,$seme_num,$stud_name,$stud_sex,$stud_id,$stud_study_year)=$recordSet->FetchRow()) {
		if($pic_checked) $my_pic=get_pic($stud_study_year,$stud_id);
		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#DDFFDD":"#FFDDDD";		
		$score_reward=$moral_array[$student_sn]['score_reward'];
		$score_absence=$moral_array[$student_sn]['score_absence'];
		$score_fault=$moral_array[$student_sn]['score_fault'];		
		$score=$score_reward+$score_absence+$score_fault;		
		$memo=$moral_array[$student_sn]['moral_memo'];
	
		$java_script="";
		$action='';
		if($student_sn==$edit_sn){			
			$score_reward="<input type='text' name='edit_reward' size=5 value='$score_reward'>";
			$score_absence="<input type='text' name='edit_absence' size=5 value='$score_absence'>";
			$score_fault="<input type='text' name='edit_fault' size=5 value='$score_fault'>";
			$memo="<input type='text' name='edit_memo' size=20 value='$memo'>";
			//�ʧ@���s
			$action="<input type='submit' name='act' value='�T�w�ק�' onclick='return confirm(\"�T�w�n�ק� $stud_name ���~�w�A�ȯŤ�?\")'> <input type='submit' name='act' value='����' onclick='document.myform.edit_sn.value=0;'>";		
		} else {
			if(array_key_exists($student_sn,$listed)){
				if($work_year==$academic_year and $moral_editable) $java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='$stud_sex_color';\" ondblclick='document.myform.edit_sn.value=\"$student_sn\"; document.myform.submit();'";
			} else { $stud_sex_color='#aaaaaa'; }
		}		
		$studentdata.="<tr align='center' bgcolor='$stud_sex_color' $java_script><td>$stud_id</td><td>$seme_num</td><td>$my_pic $stud_name</td><td>$score_reward</td><td>$score_absence</td><td>$score_fault</td><td><B>$score</B></td><td>$memo<br>$action</td></tr>";
	}
}

echo $main.$studentdata."</form></table>";
foot();
?>