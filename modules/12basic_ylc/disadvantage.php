<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

//�q�X����
head("�ߧU�z��");
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

if($_POST['act']=='�έp���~�פ��ŦX�����p�ե[������ǥͪ��Ť�'){
	//�쥻�~�שҦ��}�C�ǥͪ�student_sn
	$sn_array=get_student_list($work_year);
	
	//���C�J���~�װ����p�ե[�����_�l���
	$remote_score_no_date=($academic_year+1911)."-08-01";
	
	//��s�Ť�
	foreach($sn_array as $key=>$student_sn){
		if($school_remote==0) continue;
		$sql="SELECT move_date FROM stud_move WHERE student_sn=$student_sn AND move_kind=2 AND move_date>='{$remote_score_no_date}'";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		if($res->recordcount()>0) {
			$sql="UPDATE 12basic_ylc SET score_remote=0,disadvantage_memo='�����p�դ��[��' WHERE academic_year=$work_year AND student_sn=$student_sn";
			$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		}
	}
}

if($_POST['act']=='�T�w�ק�'){
	$sql="UPDATE 12basic_ylc SET score_remote='{$_POST['edit_remote']}',score_disadvantage='{$_POST['edit_disadvantage']}',disadvantage_memo='{$_POST['edit_memo']}' WHERE academic_year=$work_year AND student_sn=$edit_sn";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	$edit_sn=0;
}
/*
if($_POST['act']=='�]�w�ѻP�K�վǥͬҲŦX�NŪ����'){
	$sql="update 12basic_ylc set score_remote=1 where academic_year=$work_year";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
};
*/

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);

if($work_year==$academic_year) {
	if($school_remote==1 || $school_remote==2) $tool_icon.=" <input type='submit' value='�έp���~�פ��ŦX�����p�ե[������ǥͪ��Ť�' name='act' onclick='return confirm(\"�T�w�n���s�έp�έp���~�פ��ŦX�����p�ե[������ǥͪ��Ť�?\")'>";
	$tool_icon.=$editable_hint;
	if($school_remote==1 || $school_remote==2) $tool_icon.="<br><font size=3 color='#DC143C'>���̡i���L�ϤQ�G�~��ЧK�դJ�ǿ�k�j�W�w�A���~�ͭY�󲦡]���^�~�Ǧ~�׶}�l����J�̡]�Ҧp�G�ҥͩ�".($academic_year+1)."�~6�벦�~�A��{$academic_year}�~8��1��H����J�^�A���C�J������ǥ[���C�Щӿ�H�ȥ��I��W��i�έp���~�פ��ŦX�����p�ե[������ǥͪ��Ť��j���s�i��t���ˬd�A���±z�I</font>";
}

$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester $class_list $tool_icon<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>";


if($stud_class)
{
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$listed=get_student_list($work_year);
	
	//���o���w�Ǧ~�w�g�}�C���ǥͧߧU�z�դ���	
	$disadvantage_array=get_student_disadvantage($work_year);	
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_study_year FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	//$studentdata="<tr align='center' bgcolor='#ff8888'><td width=80>�Ǹ�</td><td width=50>�y��</td><td width=120>�m�W</td><td>�NŪ�����a��</td><td>�C���J��/���C���J��</td><td>�Ť��έp</td><td>�Ƶ�</td>";
	$studentdata="<tr align='center' bgcolor='#ff8888'><td width=80>�Ǹ�</td><td width=50>�y��</td><td width=120>�m�W</td><td>�g�ٮz��</td><td>�����p��</td><td>�Ť��έp</td><td>�Ƶ�</td>";

	while(list($student_sn,$seme_num,$stud_name,$stud_sex,$stud_id,$stud_study_year)=$recordSet->FetchRow()) {
		if($pic_checked) $my_pic=get_pic($stud_study_year,$stud_id);
		$seme_num=sprintf('%01d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#EEFFEE":"#FFEEEE";
		//$remote=$disadvantage_array[$student_sn]['remote'];
		$disadvantage=$disadvantage_array[$student_sn]['disadvantage'];
		$remote=$disadvantage_array[$student_sn]['remote'];
		$score=$disadvantage_array[$student_sn]['score'];
		$memo=$disadvantage_array[$student_sn]['disadvantage_memo'];
		$java_script="";
		$action='';

		if($student_sn==$edit_sn){			
			//�g�ٮz�տ��
			$disadvantage_value=$disadvantage;
			$disadvantage='';
			foreach($disadvantage_level as $key=>$value){
				$checked=($disadvantage_value==$key)?'checked':'';
				$disadvantage.="<input type='radio' name='edit_disadvantage' value=$key $checked>$value ";
			}
			//�����p�տ��
			$remote_value=$remote;
			$remote='';
			foreach($remote_level as $key=>$value){
				$checked=($remote_value==$key)?'checked':'';
				$remote.="<input type='radio' name='edit_remote' value=$key $checked>$value<br>";
			}
			
			$stud_sex_color='#ffffaa';
			//�ߧU�z�ճƵ�
			$memo.="<input type='text' name='edit_memo' size=20 value='$memo'>";
			//�ʧ@���s
			$action="<input type='submit' name='act' value='�T�w�ק�' onclick='return confirm(\"�T�w�n�ק� $stud_name ���ߧU�z�կŤ�?\")'> <input type='submit' name='act' value='����' onclick='document.myform.edit_sn.value=0;'>";		
		} else {
			if(array_key_exists($student_sn,$listed)){
				if($work_year==$academic_year) $java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='$stud_sex_color';\" ondblclick='document.myform.edit_sn.value=\"$student_sn\"; document.myform.submit();'";
			} else { $stud_sex_color='#aaaaaa'; }
		}		
		$studentdata.="<tr align='center' bgcolor='$stud_sex_color' $java_script><td>$stud_id</td><td>$seme_num</td><td>$my_pic $stud_name</td><td>$disadvantage</td><td>$remote</td><td><B>$score</B></td><td>$memo $action</td></tr>";
	}
}

echo $main.$studentdata."</table></form>";

//ĵ�i�T��
//if($school_remote==1 || $school_remote==2) {
//	$msg="�̡i���L�ϤQ�G�~��ЧK�դJ�ǿ�k�j�W�w�A���~�ͭY�󲦡]���^�~�Ǧ~�׶}�l����J�̡]�Ҧp�G�ҥͩ�103�~6�벦�~�A��102�~8��1��H����J�^�A���C�J������ǥ[���C�Щӿ�H�ȥ��N���ŦX�W�w�ǥͤ��i�����p�աj������אּ�i���Ű����p�ե[������j�A���±z�I";
//	$alert=AlertBox($msg);
//	echo $alert;
//}

foot();

?>
