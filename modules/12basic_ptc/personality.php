<?php

include "config.php";

sfs_check();

//�q�X����
head("�A�ʵo�i ");
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
	$sql="UPDATE 12basic_ptc SET score_my_aspiration='{$_POST['edit_score_my_aspiration']}',score_domicile_suggestion='{$_POST['edit_score_domicile_suggestion']}',score_guidance_suggestion='{$_POST['edit_score_guidance_suggestion']}',disadvantage_memo='{$_POST['edit_memo']}' WHERE academic_year=$work_year AND student_sn=$edit_sn AND editable='1'";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	$edit_sn=0;
}

if($_POST['act']=='�̾ڥͲP���ɬ��������ƧP�w'){
	//�������M��
	$sql="update 12basic_ptc set score_my_aspiration=0,score_domicile_suggestion=0,score_guidance_suggestion=0 where academic_year=$work_year AND editable='1'";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	//�A�̾ڶ����ƧP�w
	$sn_array=get_student_list($work_year);
	$personality=get_student_direction($sn_array);
	foreach($personality as $student_sn=>$value) {
		$self=$value[self];
        $parent=$value[parent];
        $teacher=$value[teacher];
		
		$score_domicile_suggestion=($self==$parent)?$domicile_suggestion:0;
		$score_guidance_suggestion=($self==$teacher)?$guidance_suggestion:0;

		$sql="update 12basic_ptc set score_my_aspiration=$my_aspiration,score_domicile_suggestion=$score_domicile_suggestion,score_guidance_suggestion=$score_guidance_suggestion where student_sn=$student_sn and academic_year=$work_year AND editable='1'";
		$res=$CONN->Execute($sql) or user_error("��s���ѡI<br>$sql",256);
	}
};


if($_POST['act']=='�]�w�ѻP�K�վǥͬҲŦX�A�ʵo�i'){
	$sql="update 12basic_ptc set score_my_aspiration=$my_aspiration,score_domicile_suggestion=$domicile_suggestion,score_guidance_suggestion=$guidance_suggestion where academic_year=$work_year AND editable='1'";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
};

if($_POST['act']=='�����M��'){
	$sql="update 12basic_ptc set score_my_aspiration=0,score_domicile_suggestion=0,score_guidance_suggestion=0 where academic_year=$work_year AND editable='1'";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
};

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);

if($work_year==$academic_year) $tool_icon=" <input type='submit' value='�̾ڥͲP���ɬ��������ƧP�w' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>
											<input type='submit' value='�]�w�ѻP�K�վǥͬҲŦX�A�ʵo�i' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>
											<input type='submit' value='�����M��' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>";
$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester $class_list $tool_icon<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>";

if($stud_class)
{
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$listed=get_student_list($work_year);
	
	//�ˬd�O�_���i�ק�������ѻP�K�վǥ�
	$editable_sn_array=get_editable_sn($work_year);
	
	//���o���w�Ǧ~�w�g�}�C���ǥͧߧU�z�դ���
	$personality_array=get_student_personality($work_year);	
//echo "<pre>";	
//print_r($personality_array);
//echo "</pre>";	
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_study_year FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5,15) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	$studentdata="<tr align='center' bgcolor='#ff8888'><td width=80>�Ǹ�</td><td width=50>�y��</td><td width=120>�m�W</td><td width=$pic_width>�j�Y��</td><td>�ڪ����@</td><td>�a����ĳ</td><td>���ɤp�ի�ĳ</td><td>�Ť��έp</td><td>�Ƶ�</td>";
	while(!$recordSet->EOF){
		$student_sn=$recordSet->fields['student_sn'];
		$seme_num=$recordSet->fields['seme_num'];
		$stud_name=$recordSet->fields['stud_name'];
		$stud_sex=$recordSet->fields['stud_sex'];
		$stud_id=$recordSet->fields['stud_id'];
		$stud_study_year=$recordSet->fields['stud_study_year'];

		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#CCFFCC":"#FFCCCC";
		$score_my_aspiration=$personality_array[$student_sn]['score_my_aspiration'];
			$bgcolor_my_aspiration=$score_my_aspiration?$stud_sex_color:'#cccccc';
		$score_domicile_suggestion=$personality_array[$student_sn]['score_domicile_suggestion'];
			$bgcolor_domicile_suggestion=$score_domicile_suggestion?$stud_sex_color:'#cccccc';
		$score_guidance_suggestion=$personality_array[$student_sn]['score_guidance_suggestion'];
			$bgcolor_guidance_suggestion=$score_guidance_suggestion?$stud_sex_color:'#cccccc';
		$score=$score_my_aspiration+$score_domicile_suggestion+$score_guidance_suggestion;
			$bgcolor_score=$score?$stud_sex_color:'#cccccc';
		$memo=$personality_array[$student_sn]['personality_memo'];
		$java_script="";
		$action='';
		$my_pic=$pic_checked?get_pic($stud_study_year,$stud_id):'';

		if($student_sn==$edit_sn){			
			//���
			$score_my_aspiration="<input type='checkbox' name='edit_score_my_aspiration' value='$my_aspiration'".($score_my_aspiration?' checked':'').">�ŦX";
			$score_domicile_suggestion="<input type='checkbox' name='edit_score_domicile_suggestion' value='$domicile_suggestion'".($score_domicile_suggestion?' checked':'').">�ŦX";
			$score_guidance_suggestion="<input type='checkbox' name='edit_score_guidance_suggestion' value='$guidance_suggestion'".($score_guidance_suggestion?' checked':'').">�ŦX";
			$score='';
			$stud_sex_color='#ffffaa';
			//�Ƶ�
			$memo="<input type='text' name='edit_memo' size=20 value='$memo'>";
			//�ʧ@���s
			$action="<input type='submit' name='act' value='�T�w�ק�' onclick='return confirm(\"�T�w�n�ק� $stud_name ���A�ʵo�i �Ť�?\")'> <input type='submit' name='act' value='����' onclick='document.myform.edit_sn.value=0;'>";		
		} else {
			if(array_key_exists($student_sn,$listed)){
				$editable=array_key_exists($student_sn,$editable_sn_array)?1:0;
				$stud_sex_color=$editable?$stud_sex_color:$uneditable_bgcolor;
				$java_script=($work_year==$academic_year and $editable and $personality_editable)?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='$stud_sex_color';\" ondblclick='document.myform.edit_sn.value=\"$student_sn\"; document.myform.submit();'":'';
			} else { $stud_sex_color='#aaaaaa'; }
		}		
		$studentdata.="<tr align='center' bgcolor='$stud_sex_color' $java_script><td>$stud_id</td><td>$seme_num</td><td>$stud_name</td><td>$my_pic</td><td bgcolor='$bgcolor_my_aspiration'>$score_my_aspiration</td><td bgcolor='$bgcolor_domicile_suggestion'>$score_domicile_suggestion</td><td bgcolor='$bgcolor_guidance_suggestion'>$score_guidance_suggestion</td><td bgcolor='$bgcolor_score'><B>$score</B></td><td>$memo $action</td></tr>";
		$recordSet->MoveNext();
	}
}

//��ܫʦs���A��T
echo get_sealed_status($work_year).'<br>';

echo $main.$studentdata."</table></form>";
foot();
?>