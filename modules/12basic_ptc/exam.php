<?php
include "config.php";

sfs_check();

//�q�X����
head("�ѻP�K�վǥ�");

print_menu($menu_p);

//�Ǵ��O
$work_year_seme=$_REQUEST['work_year_seme'];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$academic_year=substr($curr_year_seme,0,-1);
$work_year=substr($work_year_seme,0,-1);
$session_tea_sn=$_SESSION['session_tea_sn'];

$stud_class=$_REQUEST['stud_class'];
$edit_sn=$_POST['edit_sn'];

if($_POST['act']=='�T�w�ק�'){
	$_POST['edit_score_exam_c']=min($_POST['edit_score_exam_c'],$exam_score_well);
	$_POST['edit_score_exam_m']=min($_POST['edit_score_exam_m'],$exam_score_well);
	$_POST['edit_score_exam_e']=min($_POST['edit_score_exam_e'],$exam_score_well);
	$_POST['edit_score_exam_s']=min($_POST['edit_score_exam_s'],$exam_score_well);
	$_POST['edit_score_exam_n']=min($_POST['edit_score_exam_n'],$exam_score_well);
	
	$sql="UPDATE 12basic_ptc SET score_exam_c='{$_POST['edit_score_exam_c']}',score_exam_m='{$_POST['edit_score_exam_m']}',score_exam_e='{$_POST['edit_score_exam_e']}',score_exam_s='{$_POST['edit_score_exam_s']}',score_exam_n='{$_POST['edit_score_exam_n']}',exam_memo='{$_POST['edit_memo']}' WHERE academic_year=$work_year AND student_sn=$edit_sn AND editable='1'";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	$edit_sn=0;
}


if($_POST['act']=='�M���Ҧ��Ш|�|�Ҧ��Z'){
	$sql="UPDATE 12basic_ptc SET score_exam_c=NULL,score_exam_m=NULL,score_exam_e=NULL,score_exam_s=NULL,score_exam_n=NULL,exam_memo=NULL WHERE academic_year=$work_year AND editable='1'";
	$res=$CONN->Execute($sql) or user_error("�M�����ѡI<br>$sql",256);
	$edit_sn=0;
}


//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);

if($work_year==$academic_year) $tool_icon=" <input type='submit' value='�M���Ҧ��Ш|�|�Ҧ��Z' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>";
$main.="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester $class_list $tool_icon<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>";

if($stud_class)
{
	//���o�e�w�}�C�ǥ͸��
	$student_list_array=get_student_list($work_year);
	
	//�ˬd�O�_���i�ק�������ѻP�K�վǥ�
	$editable_sn_array=get_editable_sn($work_year);
	
	//���o�|�Ҧ��Z
	$exam_data=get_exam_data($work_year);
//echo "<pre>";
//print_r($exam_data);
//echo "</pre>";
	if(!$_POST['edit_write'] and $work_year==$academic_year) $java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='#ff8888';\" ondblclick='document.myform.edit_write.value=1; document.myform.submit();'";
	elseif($_POST['edit_write']) $ok="<input type='submit' name='act' value='�T�w�ק�'  onclick='return confirm(\"�T�w�n�ק�g�@����Ť�?\")'>";
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_study_year FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5,15) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);	
	$studentdata="<tr align='center' bgcolor='#ff8888'><td width=80>�Ǹ�</td><td width=50>�y��</td><td width=120>�m�W</td><td width=$pic_width>�j�Y��</td><td>���</td><td>�ƾ�</td><td>�^�y</td><td>���|</td><td>�۵M</td><td>�Ť��έp</td><td>�Ƶ�</td>";
	while(!$recordSet->EOF){
		$student_sn=$recordSet->fields['student_sn'];
		$seme_num=$recordSet->fields['seme_num'];
		$stud_name=$recordSet->fields['stud_name'];
		$stud_sex=$recordSet->fields['stud_sex'];
		$stud_id=$recordSet->fields['stud_id'];
		$stud_study_year=$recordSet->fields['stud_study_year'];
		
		$my_pic=$pic_checked?get_pic($stud_study_year,$stud_id):'';
		
		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#CCFFCC":"#FFCCCC";
		$stud_sex_color=array_key_exists($student_sn,$student_list_array)?$stud_sex_color:'#aaaaaa';
		
		
		$score_exam_c=$exam_data[$student_sn]['score_exam_c'];
		$score_exam_m=$exam_data[$student_sn]['score_exam_m'];
		$score_exam_e=$exam_data[$student_sn]['score_exam_e'];
		$score_exam_s=$exam_data[$student_sn]['score_exam_s'];
		$score_exam_n=$exam_data[$student_sn]['score_exam_n'];		
		$memo=$exam_data[$student_sn]['exam_memo'];
		//�Ť��έp
		$score=$score_exam_c+$score_exam_m+$score_exam_e+$score_exam_s+$score_exam_n;
		
		$java_script="";
		$action='';
		if($student_sn==$edit_sn){			
			//�Ш|�|�ҳƵ�
			$score_exam_c="<input type='text' name='edit_score_exam_c' size=5 value='$score_exam_c'>";
			$score_exam_m="<input type='text' name='edit_score_exam_m' size=5 value='$score_exam_m'>";
			$score_exam_e="<input type='text' name='edit_score_exam_e' size=5 value='$score_exam_e'>";
			$score_exam_s="<input type='text' name='edit_score_exam_s' size=5 value='$score_exam_s'>";
			$score_exam_n="<input type='text' name='edit_score_exam_n' size=5 value='$score_exam_n'>";
			$memo="<input type='text' name='edit_memo' size=20 value='$memo'>";
			$stud_sex_color='#ffffaa';
			$score='';
			//�ʧ@���s
			$action="<input type='submit' name='act' value='�T�w�ק�' onclick='return confirm(\"�T�w�n�ק� $stud_name ���Ш|�|�үŤ�?\")'> <input type='submit' name='act' value='����' onclick='document.myform.edit_sn.value=0;'>";		
		} else {
			if(array_key_exists($student_sn,$student_list_array)){
				$editable=array_key_exists($student_sn,$editable_sn_array)?1:0;
				$stud_sex_color=$editable?$stud_sex_color:$uneditable_bgcolor;
				$java_script=($work_year==$academic_year and $editable)?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='$stud_sex_color';\" ondblclick='document.myform.edit_sn.value=\"$student_sn\"; document.myform.submit();'":'';
			} else { $stud_sex_color='#aaaaaa'; }
		}		
		
		$studentdata.="<tr align='center' bgcolor='$stud_sex_color' $java_script><td>$stud_id</td><td>$seme_num</td><td>$stud_name</td><td>$my_pic</td><td>$score_exam_c</td><td>$score_exam_m</td>
		<td>$score_exam_e</td><td>$score_exam_s</td><td>$score_exam_n</td><td>$score</td><td>$memo $action</td></tr>";
		
		$recordSet->MoveNext();
	}
}

//��ܫʦs���A��T
echo get_sealed_status($work_year).'<br>';

echo $main.$studentdata."<input type='hidden' name='edit_write' value=0></form></table>";
foot();
?>