<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

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
	$sql="UPDATE 12basic_ylc SET card_no='{$_POST['card_no']}',kind_id='{$_POST['kind_id']}',disability_id='{$_POST[disability_id]}',free_id='{$_POST['free_id']}' WHERE academic_year=$work_year AND student_sn=$edit_sn";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	$edit_sn=0;
}

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);
$tool_icon="<input type='checkbox' name='show_zero' value=1 $show_zero onclick=\"this.form.submit();\"><font size=2 color='green'>��ܡu(0)�@��͡v</font>";
if($work_year==$academic_year) $tool_icon.=$editable_hint;
$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester $class_list $tool_icon <table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>";
if($stud_class)
{
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$student_list_array=get_student_list($work_year);
	
	//���o���w�Ǧ~�w�g�}�C���ǥͧߧU�z�դ���	
	$kind_free_array=get_student_kind_free($work_year);	
	
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_person_id,year(b.stud_birthday)-1911,month(b.stud_birthday),day(b.stud_birthday),b.stud_id,b.stud_study_year FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	$studentdata="<tr align='center' bgcolor='#ff8888'><td>�y��</td><td>�m�W</td><td>�Ǹ�</td><td>�����Ҧr��</td><td>�~</td><td>��</td><td>��</td><td>�ǥͨ���</td><td>���߻�ê</td><td>�C�����~</td><td>�ʧ@</td>";
	while(list($student_sn,$seme_num,$stud_name,$stud_sex,$stud_id,$stud_person_id,$birth_year,$birth_month,$birth_day,$stud_id,$stud_study_year)=$recordSet->FetchRow()) {
		if($pic_checked) $my_pic=get_pic($stud_study_year,$stud_id);
		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#EEFFEE":"#FFEEEE";
		$kind_id=$kind_free_array[$student_sn]['kind_id'];
		$disability_id=$kind_free_array[$student_sn]['disability_id'];
		echo $disability_id;
		$free_id=$kind_free_array[$student_sn]['free_id'];
		$action='';
		if($student_sn==$edit_sn){	
			//���͹��������W����select����
			$kind_data="<select name='kind_id'>";
			foreach($stud_kind_arr_12ylc as $kind_key=>$kind_value){
				$selected='';
				$bg_color='';
				if($kind_key==$kind_id){
					$selected='selected';
					$bg_color="style='background-color: #ffcccc;'";
				}
				$kind_data.="<option value='$kind_key' $selected $bg_color>($kind_key) $kind_value</option>";
			}
			$kind_data.="</select>";			
			
			//���͹��������߻�êselect����
			$disability_data="<select name='disability_id'>";
			foreach($stud_disability_arr_12ylc as $disability_key=>$disability_value){
				$selected='';
				$bg_color='';
				if($disability_key==$disability_id){
					$selected='selected';
					$bg_color="style='background-color: #ffcccc;'";
				}
				$disability_data.="<option value='$disability_key' $selected $bg_color>($disability_key) $disability_value</option>";
			}
			$disability_data.="</select>";
			
			//���͹������C�����~select����
			$free_data="<select name='free_id'>";
			foreach($stud_free_arr_12ylc as $free_key=>$free_value){
				$selected='';
				$bg_color='';
				if($free_key==$free_id){
					$selected='selected';
					$bg_color="style='background-color: #ffcccc;'";
				}
				$free_data.="<option value='$free_key' $selected $bg_color>($free_key) $free_value</option>";
			}
			$free_data.="</select>";

			//�ʧ@���s
			$action="<input type='submit' name='act' value='�T�w�ק�' onclick='return confirm(\"�T�w�n�ק� $stud_name �����W���?\")'> <input type='submit' name='act' value='����' onclick='document.myform.edit_sn.value=0;'>";		
			$stud_sex_color='#ffffaa';
			$java_script='';
		} else {		
			if(array_key_exists($student_sn,$student_list_array)){
				if($work_year==$academic_year) $java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='$stud_sex_color';\" ondblclick='document.myform.edit_sn.value=\"$student_sn\"; document.myform.submit();'";
			} else { $stud_sex_color='#aaaaaa'; }
			
			$kind_data="($kind_id){$stud_kind_arr_12ylc[$kind_id]}"; if(!$kind_id and !$show_zero) $kind_data='';
			$disability_data="($disability_id){$stud_disability_arr_12ylc[$disability_id]}"; if(!$disability_id and !$show_zero) $disability_data='';
			$free_data="($free_id){$stud_free_arr_12ylc[$free_id]}"; if(!$free_id and !$show_zero) $free_data='';
		}
			
		$stud_sex_color=array_key_exists($student_sn,$student_list_array)?$stud_sex_color:'#aaaaaa';		
		$studentdata.="<tr align='center' bgcolor='$stud_sex_color' $java_script><td>$seme_num</td><td>$my_pic $stud_name</td><td>$stud_id</td><td>$stud_person_id</td><td>$birth_year</td><td>$birth_month</td><td>$birth_day</td><td align='left'>$kind_data</td><td align='left'>$disability_data</td><td align='left'>$free_data</td><td>$action</td></tr>";
	}
}

echo $main.$studentdata."</form></table>";
foot();
?>