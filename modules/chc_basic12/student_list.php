<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

// include "../../include/sfs_case_score.php";


//���~�~��
$graduate_year=$IS_JHORES?9:6;

//�@�~��������G�A�����@�Ӧ~��
// $graduate_year--;

sfs_check();

chk_login('�аȳB');

//�q�X����
head("�ѻP�K�վǥ�");

print_menu($school_menu_p);
echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='selected_stud[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;



//�Ǵ��O
$work_year_seme=$_REQUEST['work_year_seme'];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$academic_year=substr($curr_year_seme,0,-1);
$work_year=substr($work_year_seme,0,-1);
$session_tea_sn=$_SESSION['session_tea_sn'];

$stud_class=$_REQUEST['stud_class'];
$selected_stud=$_POST['selected_stud'];

//���X�Z�ŦW�ٰ}�C
$class_base=class_base($work_year_seme);

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

if($selected_stud AND $_POST['act']=='�}�C��ܪ��ǥ�'){
	//�[�J�N��J��--���ƿ�
	$school=get_school_base();//print_r($school);
	$score_nearby=($school['sch_sheng']=='���ƿ�') ? 7:0;
	//�����ܪ��Z�žǥ�	
	$batch_value="";
	foreach($selected_stud as $key=>$sn)
	{
		$batch_value.="('$academic_year',$sn,$score_nearby,$session_tea_sn),";
	}
	$batch_value=substr($batch_value,0,-1);
	$sql="REPLACE INTO chc_basic12(academic_year,student_sn,score_nearby,update_sn) values $batch_value";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
}


//�R���ѥ[�ǥ�
if($_POST['student_sn']) {
	$sql="delete from chc_basic12 WHERE academic_year='$academic_year' and student_sn=".$_POST['student_sn'];
	$rs=$CONN->Execute($sql) or user_error("���~�T���G",$sql,256);
}


if($_POST['act']=='�}�C���Ǧ~�Ҧ����ǥ�'){
	//�[�J�N��J��--���ƿ�
	$school=get_school_base();//print_r($school);
	$score_nearby=($school['sch_sheng']=='���ƿ�') ? 7:0;
	//��Z�žǥ�
	$sql_select="SELECT a.student_sn FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND b.stud_study_cond=0 AND a.seme_class like '$graduate_year%'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	
	
	
	$batch_value="";
	while(!$recordSet->EOF)
	{
		$sn=$recordSet->fields['student_sn'];
		$batch_value.="('$academic_year',$sn,$score_nearby,$session_tea_sn),";
		$recordSet->MoveNext();
	}
	$batch_value=substr($batch_value,0,-1);
	
	$sql="INSERT INTO chc_basic12(academic_year,student_sn,score_nearby,update_sn) values $batch_value";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
};


//���o�~�׻P�Ǵ����U�Կ��
//$seme_list=get_class_seme();
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);

//���o���w�Ǧ~�w�g�}�C���ǥͲM��
$listed=get_student_list($work_year);

if($stud_class and $work_year_seme==$curr_year_seme){
	$tool_icon.="<input type='button' name='all_stud' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(0);'>�@";
	$tool_icon.="<font size=2>�@���G�w�}�C(�֫���U�i�M��)�@�@</font>";
	$tool_icon.="<input type='submit' value='�}�C��ܪ��ǥ�' name='act'>";
	if(!$listed  ) $tool_icon.="<input type='submit' value='�}�C���Ǧ~�Ҧ����ǥ�' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>";
}
$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><input type='hidden' name='student_sn' value=''>$recent_semester $class_list $tool_icon <table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>";

if($stud_class)
{
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	//�Hcheckbox�e�{
	$col=7; //�]�w�C�@�C��ܴX�H
	
	$studentdata="";
	while(list($student_sn,$seme_num,$stud_name,$stud_sex)=$recordSet->FetchRow()) {
		if($recordSet->currentrow() % $col==1) $studentdata.="<tr align='center'>";
		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#CCFFCC":"#FFCCCC";
		if(array_key_exists($student_sn,$listed)) {
			$java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#ff5555';\" onMouseOut=\"this.style.backgroundColor='#FFFFDD';\" ondblclick='document.myform.student_sn.value=\"$student_sn\"; document.myform.submit();'";
			$studentdata.="<td bgcolor='#FFFFDD' $java_script>��($seme_num)$stud_name</td>";
		} else {
			$checkable=($curr_year_seme==$work_year_seme)?"<input type='checkbox' name='selected_stud[]' value='$student_sn'>":"";
			$studentdata.="<td bgcolor='$stud_sex_color'>$checkable($seme_num)$stud_name</td>";
		}
		if($recordSet->currentrow() % $col==0  or $recordSet->EOF) $studentdata.="</tr>";
	}
}

echo $main.$studentdata."</form></table>";
foot();?>
