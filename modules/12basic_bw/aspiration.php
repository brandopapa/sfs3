<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

//�q�X����
head("���@��");
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

if($_POST['act']=='�T�w�ק�'){
	//���v��Ƨ�ʬ���
	$data=$_POST['edit_aspiration'];
	$aspiration_data=explode("\r\n",$data);
	$aspiration_reference=get_csv_reference(1);
	//���v������
	foreach($aspiration_data as $key=>$value){
		$order=$key+1;
		$code="[$value]".$aspiration_reference[$value];
		if(!$aspiration_reference[$value]) $code.="------";
		$data_list.="$order. $code".$aspiration_separateor;
	}
	$data_list.=" ��¾���G($session_tea_sn)".$_SESSION['session_tea_name'];
	$sql="UPDATE 12basic_ylc SET aspiration='$data',aspiration_datetime=now(),aspiration_memo=concat(aspiration_memo,'\r\n',date_format(now(),'�ɶ��G %Y-%m-%d %H:%i:%s'),'  �׺�IP:','$REMOTE_ADDR',' ���@�ǡG','$data_list') WHERE academic_year=$work_year AND student_sn=$edit_sn";
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

if($work_year==$academic_year) $tool_icon.=$editable_hint;

$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'><input type='hidden' name='edit_sn' value='$edit_sn'>$recent_semester $class_list $tool_icon <table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>";

if($stud_class)
{
	//���o���w�Ǧ~�w�g�}�C���ǥͲM��
	$listed=get_student_list($work_year);
	
	//���o���w�Ǧ~�w�g�}�C���ǥͧ��@
	$aspiration_array=get_student_aspiration($work_year);	
	
	//����W�Ǫ����@��
	$aspiration_reference=get_csv_reference(1);
	
	
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_study_year FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	$studentdata="<tr align='center' bgcolor='#ff8888'><td width=50>�y��</td><td width=120>�m�W</td><td width=80>�Ǹ�</td><td width=150>���@����ɶ�</td><td>���@��</td>";
	while(list($student_sn,$seme_num,$stud_name,$stud_sex,$stud_id,$stud_study_year)=$recordSet->FetchRow()) {
		if($pic_checked) $my_pic=get_pic($stud_study_year,$stud_id);
		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#EEFFEE":"#FFEEEE";
		$aspiration_datetime=$aspiration_array[$student_sn]['aspiration_datetime'];
		$java_script="";
		$data_list='';
		if($student_sn==$edit_sn){
			$aspiration_history=str_replace("\r\n",'<br><li>',$aspiration_array[$student_sn]['aspiration_memo']);
			$data_list="<table><tr valign='top'><td><textarea name='edit_aspiration' cols=15 rows='".count($rank_score_array)."'>{$aspiration_array[$student_sn]['aspiration_original']}</textarea><br><input type='submit' name='act' value='�T�w�ק�' onclick='return confirm(\"�T�w�n�ק� $stud_name �����@?\")'> <input type='submit' name='act' value='����' onclick='document.myform.edit_sn.value=0;'></td><td><font size=2 color='brown'>$aspiration_history</font></td></tr></table>";		
		} else {
			if(array_key_exists($student_sn,$listed)){
				if($work_year==$academic_year) $java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='$stud_sex_color';\" ondblclick='document.myform.edit_sn.value=\"$student_sn\"; document.myform.submit();'";
				$aspiration_data=$aspiration_array[$student_sn]['aspiration'];
				foreach($aspiration_data as $key=>$value){
					$order=$key+1;
					$code="[$value]".$aspiration_reference[$value];
					if(!$aspiration_reference[$value]) $code="<font color='red'>$code</font>";
					$data_list.="$order. $code".$aspiration_separateor;
				}
			} else { $stud_sex_color='#aaaaaa'; }
		}		
		$studentdata.="<tr align='center' bgcolor='$stud_sex_color' $java_script><td>$seme_num</td><td>$my_pic $stud_name</td><td>$stud_id</td><td>$aspiration_datetime</td><td align='left'>$data_list</td></tr>";
	}
}

echo $main.$studentdata."</form></table>";
foot();
?>