<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

sfs_check();

//�q�X����
head("�h���ǲ�");
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

if($_POST['act']=='�έp���~�שҦ��}�C�ǥͦh���ǲߪ��Ť�'){
	//�쥻�~�שҦ��}�C�ǥͪ�student_sn
	$sn_array=get_student_list($work_year);

	//���žǲ�-����health,����art,��Xcomplex
	$score_balance=count_student_score_balance($sn_array);	
	//�v�ɦ��Z
	$score_competetion=count_student_score_competetion();	
	//��A��
	$score_fitness=count_student_score_fitness($sn_array);
/*	
echo '<pre>';
print_r($score_fitness);
echo '</pre>';
*/	
	//��s�Ť�
	foreach($sn_array as $key=>$student_sn){
		$score_competetion[$student_sn]=min($score_competetion[$student_sn],$race_score_max);
		$score_fitness[$student_sn]=min($score_fitness[$student_sn],$fitness_score_max);
		
		$sql="UPDATE 12basic_ylc set score_balance_health='{$score_balance[$student_sn]['health']}',score_balance_art='{$score_balance[$student_sn]['art']}',score_balance_complex='{$score_balance[$student_sn]['complex']}'
				,score_competetion='{$score_competetion[$student_sn]}',score_fitness='{$score_fitness[$student_sn]}'
			WHERE academic_year=$work_year AND student_sn=$student_sn";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	}
};


if($_POST['act']=='�T�w�ק�'){
	$_POST['edit_health']=min($_POST['edit_health'],$balance_score);
	$_POST['edit_art']=min($_POST['edit_art'],$balance_score);
	$_POST['edit_complex']=min($_POST['edit_complex'],$balance_score);
	$_POST['edit_competetion']=min($_POST['edit_competetion'],$race_score_max);
	$_POST['edit_fitness']=min($_POST['edit_fitness'],$fitness_score_max);	
	$sql="UPDATE 12basic_ylc SET score_balance_health='{$_POST['edit_health']}',score_balance_art='{$_POST['edit_art']}',score_balance_complex='{$_POST['edit_complex']}',score_competetion='{$_POST['edit_competetion']}',score_fitness='{$_POST['edit_fitness']}',diversification_memo='{$_POST['edit_memo']}' WHERE academic_year=$work_year AND student_sn=$edit_sn";
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

if($work_year==$academic_year) $tool_icon=" <input type='submit' value='�έp���~�שҦ��}�C�ǥͦh���ǲߪ��Ť�' name='act' onclick='return confirm(\"�T�w�n���s�έp���~�שҦ��}�C�ǥͦh���ǲߪ��Ť�?\")'>";
if($diversification_editable) $tool_icon.=$editable_hint;

$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester $class_list $tool_icon <table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>";

if($stud_class)
{
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$listed=get_student_list($work_year);
	
	//���o���w�Ǧ~�w�g�}�C���ǥͦh���ǲߤ���	
	$diversification_array=get_student_diversification($work_year);
/*
echo '<pre>';
print_r($diversification_array);
echo '</pre>';
*/
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_study_year FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5,15) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	$studentdata="<tr align='center' bgcolor='#ff8888'><td width=80 rowspan=2>�Ǹ�</td><td width=50 rowspan=2>�y��</td><td width=120 rowspan=2>�m�W</td><td colspan=3>���žǲ�</td><td rowspan=2>�v�ɦ��Z</td><td rowspan=2>��A��</td><td rowspan=2>�Ť��έp</td><td rowspan=2>�Ƶ�</td>";
	$studentdata.="<tr align='center' bgcolor='#ff8888'><td width=50>����</td><td width=50>����</td><td width=50>��X</td>";
	while(list($student_sn,$seme_num,$stud_name,$stud_sex,$stud_id,$stud_study_year)=$recordSet->FetchRow()) {
		if($pic_checked) $my_pic=get_pic($stud_study_year,$stud_id);
		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#EEFFEE":"#FFEEEE";

		$score_balance_health=$diversification_array[$student_sn]['score_balance_health'];
		$score_balance_art=$diversification_array[$student_sn]['score_balance_art'];
		$score_balance_complex=$diversification_array[$student_sn]['score_balance_complex'];
	
		$score_competetion=$diversification_array[$student_sn]['score_competetion'];
		$score_fitness=$diversification_array[$student_sn]['score_fitness'];

		$score=$diversification_array[$student_sn]['score'];
		$memo=$diversification_array['diversification_memo'];
	
		$java_script="";
		$action='';
		if($student_sn==$edit_sn){			
			$score_balance_health="<input type='text' name='edit_health' size=5 value='$score_balance_health'>";
			$score_balance_art="<input type='text' name='edit_art' size=5 value='$score_balance_art'>";
			$score_balance_complex="<input type='text' name='edit_complex' size=5 value='$score_balance_complex'>";

			$score_competetion="<input type='text' name='edit_competetion' size=5 value='$score_competetion'>";
			$score_fitness="<input type='text' name='edit_fitness' size=5 value='$score_fitness'>";
			
			//�h���ǲ߳Ƶ�
			$memo="<input type='text' name='edit_memo' size=20 value='$memo'>";
			//�ʧ@���s
			$action="<input type='submit' name='act' value='�T�w�ק�' onclick='return confirm(\"�T�w�n�ק� $stud_name ���h���ǲ߯Ť�?\")'> <input type='submit' name='act' value='����' onclick='document.myform.edit_sn.value=0;'>";		
		} else {
			if(array_key_exists($student_sn,$listed)){
				if($work_year==$academic_year and $diversification_editable)  $java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='$stud_sex_color';\" ondblclick='document.myform.edit_sn.value=\"$student_sn\"; document.myform.submit();'";
			} else { $stud_sex_color='#aaaaaa'; }
		}		
		$studentdata.="<tr align='center' bgcolor='$stud_sex_color' $java_script><td>$stud_id</td><td>$seme_num</td><td>$my_pic $stud_name</td><td>$score_balance_health</td><td>$score_balance_art</td><td>$score_balance_complex</td><td>$score_competetion</td><td>$score_fitness</td><td><B>$score</B></td><td>$memo<br>$action</td></tr>";
	}
}

echo $main.$studentdata."</form></table>";
foot();
?>