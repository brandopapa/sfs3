<?php

include "config.php";

sfs_check();

//�q�X����
head("�ǥ͸�ƫʦs");

print_menu($menu_p);
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

if($selected_stud AND $_POST['act']=='�ʦs��ܪ��ǥ�'){
	//�����ܪ��Z�žǥ�
	foreach($selected_stud as $key=>$sn)
	{
		$sql="UPDATE 12basic_ylc SET editable='0' WHERE academic_year='$academic_year' and student_sn='$sn'";
		$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	}
}

//�Ѱ��ʦs�ǥ�
if($_POST['student_sn']) {
	$sql="UPDATE 12basic_ylc SET editable='1' WHERE academic_year='$academic_year' and student_sn='{$_POST['student_sn']}'";
	$rs=$CONN->Execute($sql) or user_error("���~�T���G",$sql,256);
}


if($_POST['act']=='�ʦs���Ǧ~�Ҧ����ǥ�'){
	$sql="UPDATE 12basic_ylc SET editable='0' WHERE academic_year='$work_year'";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
};

if($_POST['act']=='���ƸѰ��ʦs'){
	$sql="UPDATE 12basic_ylc SET editable='1' WHERE academic_year='$work_year'";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
};


//���X�Z�ŦW�ٰ}�C
$class_base=class_base($work_year_seme);

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

//���o�~�׻P�Ǵ����U�Կ��
//$seme_list=get_class_seme();
$recent_semester=get_recent_semester_select('work_year_seme',$work_year_seme);

//��ܯZ��
$class_list=get_semester_graduate_select('stud_class',$work_year_seme,$graduate_year,$stud_class);

//���o���w�Ǧ~�w�g�}�C���ǥͲM��
$listed=get_student_list($work_year);

//�w�ʦs�N����
$sealed_pic="<img src='./images/sealed.png' width=16>";


if($stud_class and $work_year_seme==$curr_year_seme){
	$tool_icon.="<input type='button' name='all_stud' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(0);'>�@";
	$tool_icon.="<font size=2>�@{$sealed_pic}�G�w�ʦs�@</font>";
	$tool_icon.="<input type='submit' value='�ʦs��ܪ��ǥ�' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>";
	$tool_icon.=" <input type='submit' value='�ʦs���Ǧ~�Ҧ����ǥ�' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>";
	$tool_icon.=" <input type='submit' value='���ƸѰ��ʦs' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>";
}
$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><input type='hidden' name='student_sn' value=''>$recent_semester $class_list $tool_icon <table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width='100%'>";

if($stud_class)
{
	//�ˬd�O�_���i�ק�������ѻP�K�վǥ�
	$editable_sn_array=get_editable_sn($work_year);
	
	//���ostud_base���Z�žǥͦC���þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex,b.stud_id,b.stud_study_year FROM stud_seme a inner join stud_base b on a.student_sn=b.student_sn WHERE a.seme_year_seme='$work_year_seme' AND a.seme_class='$stud_class' AND b.stud_study_cond in (0,5,15) ORDER BY a.seme_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	//�Hcheckbox�e�{
	$col=7; //�]�w�C�@�C��ܴX�H
	
	$studentdata="";
	while(list($student_sn,$seme_num,$stud_name,$stud_sex,$stud_id,$stud_study_year)=$recordSet->FetchRow()) {
		$my_pic=$pic_checked?get_pic($stud_study_year,$stud_id):'';
		if($recordSet->currentrow() % $col==1) $studentdata.="<tr align='center'>";
		$seme_num=sprintf('%02d',$seme_num);
		$stud_sex_color=($stud_sex==1)?"#CCFFCC":"#FFCCCC";
		if(array_key_exists($student_sn,$listed)) {
			$sealed=array_key_exists($student_sn,$editable_sn_array)?0:1;
			$stud_sex_color=$sealed?$uneditable_bgcolor:$stud_sex_color;
		
			if($work_year==$academic_year and $sealed) {
				$java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#ff5555';\" onMouseOut=\"this.style.backgroundColor='$uneditable_bgcolor';\" ondblclick='document.myform.student_sn.value=\"$student_sn\"; document.myform.submit();'";
				$studentdata.="<td bgcolor='$uneditable_bgcolor' $java_script>$my_pic ($seme_num)$stud_name $sealed_pic</td>";
			} else {
				$checkable=($curr_year_seme==$work_year_seme)?"<input type='checkbox' name='selected_stud[]' value='$student_sn'>":"";
				$studentdata.="<td bgcolor='$stud_sex_color'>$my_pic $checkable($seme_num)$stud_name</td>";				
			}
		} else {
			$studentdata.="<td bgcolor='#cccccc'>$my_pic ($seme_num)$stud_name</td>";
		}
		if($recordSet->currentrow() % $col==0  or $recordSet->EOF) $studentdata.="</tr>";
	}
}

//��ܫʦs���A��T
echo get_sealed_status($work_year).'<br>';

echo $main.$studentdata."</form></table>";
foot();?>