<?php

// $Id: stud_eduh_personal.php 5310 2009-01-10 07:57:56Z hami $

// ���o�]�w��
include "config.php";
sfs_check();
head("��g�ǥͤ�`�ͬ���{�ˮ֪�");

echo '
<script language="JavaScript">
<!--
function setBG(TheColor,thetable) {
thetable.bgColor=TheColor
}
function setBGOff(TheColor,thetable) {
thetable.bgColor=TheColor
}
//-->
</script>';

//���s���r��
$linkstr = "stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme";
//�Ҳտ��
print_menu($menu_p,$linkstr);

$class_id=$_POST['class_id'];

if($_POST['year_seme']=="") $_POST['year_seme']=sprintf("%03d",curr_year()).curr_seme();
$sel_year=intval(substr($_POST['year_seme'],0,-1));
$sel_seme=intval(substr($_POST['year_seme'],-1,1));
$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
$stud_id=$_POST['stud_id'];

//���o�~�׻P�Ǵ����U�Կ��
$sql="select DISTINCT year,semester from school_class where enable='1' order by year DESC,semester";
$res=$CONN->Execute($sql) or user_error("���o�~�׻P�Ǵ����ѡI<br>$sql",256);
$date_select="<select name='year_seme' onchange='this.form.submit();'>";
while(!$res->EOF) {
	$curr_semester=sprintf("%03d",$res->fields['year']).$res->fields['semester'];
	if($curr_semester==$_POST['year_seme']) $selected_seme='selected'; else $selected_seme='';
	$semester_name=$res->fields['year'].'�Ǧ~�ײ�'.$res->fields['semester'].'�Ǵ�';
	$date_select.="<option value='$curr_semester' $selected_seme>$semester_name</option>";
	$res->MoveNext();
}
$date_select.="</select>";

//$date_select=&class_ok_setup_year($sel_year,$sel_seme,"year_seme","this.form.semester_reset.value=\"Y\"; this.form.submit");
$smarty->assign("date_select",$date_select);

//�~�ŻP�Z�ſ��
$sql="select class_id,c_year,c_name from school_class where year='$sel_year' and semester = '$sel_seme' and enable='1' order by c_year,c_sort";
$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
$class_select="<select name='class_id' onchange='this.form.submit();'>";
while(!$res->EOF) {
	if(! $class_id) $class_id=$res->fields['class_id'];  //�Y�����w�Z��  �h�H�Ĥ@�Z�N��
	if($class_id==$res->fields['class_id']) $curr_class='selected'; else $curr_class='';
	$class_name=$school_kind_name[$res->fields['c_year']].$res->fields['c_name'].'�Z';
	$class_select.="<option $curr_class value='".$res->fields['class_id']."'>$class_name</option>";
	$res->MoveNext();
}
$class_select.="</select>";

//�Nclass_id�ରclass_num
$class_id_arr=explode('_',$class_id);
$class_num=($class_id_arr[2]+0).$class_id_arr[3];

//��ܯZ�žǥ͸��
$style_color[1]="#5555FF";
$style_color[2]="#FF5555";
$sql="select a.student_sn,a.stud_id,a.stud_name,a.stud_sex,b.seme_num as sit_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$seme_year_seme' and b.seme_class='$class_num' order by b.seme_num ";   //SQL �R�O   
$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
$records=$res->recordcount();
$stud_select="<select size='$records' name='stud_id' onchange='this.form.submit();'>";
while(!$res->EOF) {
	if(! $stud_id) $stud_id=$res->fields['stud_id'];  //�Y�����w�ǥ�  �h�H�Ĥ@��N��
	if($stud_id==$res->fields['stud_id']) {
		$curr_student='selected';
		$stu_class_num=$res->fields['sit_num'];
	} else $curr_student='';
	$stud_select.="<option $curr_student STYLE=\"color:".$style_color[$res->fields['stud_sex']]."\" value='".$res->fields['stud_id']."'>(".$res->fields['sit_num'].")".$res->fields['stud_name']."</option>";
$res->MoveNext();
}

$sse_relation_arr = sfs_text("�������Y");
$sse_family_kind_arr = sfs_text("�a�x����");
$sse_family_air_arr = sfs_text("�a�x��^");
$sse_farther_arr = sfs_text("�ޱФ覡");
$sse_mother_arr = sfs_text("�ޱФ覡");
$sse_live_state_arr = sfs_text("�~����");
$sse_rich_state_arr = sfs_text("�g�٪��p");

$sse_s1_arr = sfs_text("�߷R�x�����");
$sse_s2_arr = sfs_text("�߷R�x�����");
$sse_s3_arr = sfs_text("�S��~��");
$sse_s4_arr = sfs_text("����");
$sse_s5_arr = sfs_text("�ͬ��ߺD");
$sse_s6_arr = sfs_text("�H�����Y");
$sse_s7_arr = sfs_text("�~�V�欰");
$sse_s8_arr = sfs_text("���V�欰");
$sse_s9_arr = sfs_text("�ǲߦ欰");
$sse_s10_arr = sfs_text("���}�ߺD");
$sse_s11_arr = sfs_text("�J�{�欰");

$personal_data_caption="<table  style='font-size:10pt;' cellspacing=1  bgcolor=\"#cccccc\">
 <tr bgcolor=\"#DBE9DC\"><td>�Ǵ�</td><td>�������Y</td><td>�a�x����</td><td>�a�x��^</td><td>���ޱФ覡</td><td>���ޱФ覡</td><td>�~����</td><td>�g�٪��p</td> <td>�̳߷R���</td><td>�̧x�����</td><td>�S��~��</td><td>����</td><td>�ͬ��ߺD</td><td>�H�����Y</td><td>�~�V�欰</td><td>���V�欰</td> <td>�ǲߦ欰</td><td>���}�ߺD</td><td>�J�{�欰</td></tr>
";

$query = "select * from stud_seme_eduh where stud_id='$stud_id' order by seme_year_seme";

$recordSet = $CONN->Execute($query) or die($query);
while (!$recordSet->EOF) {
	$seme_year_seme = $recordSet->fields["seme_year_seme"];
	$stud_id = $recordSet->fields["stud_id"];
	$stud_name = $recordSet->fields["stud_name"];
	//$curr_class_num = $recordSet->fields["curr_class_num"];
	$sse_relation = $sse_relation_arr[$recordSet->fields["sse_relation"]];
	$sse_family_kind = $sse_family_kind_arr[$recordSet->fields["sse_family_kind"]];
	$sse_family_air = $sse_family_air_arr[$recordSet->fields["sse_family_air"]];
	$sse_farther = $sse_farther_arr[$recordSet->fields["sse_farther"]];
	$sse_mother = $sse_mother_arr[$recordSet->fields["sse_mother"]];
	$sse_live_state = $sse_live_state_arr[$recordSet->fields["sse_live_state"]];
	$sse_rich_state = $sse_rich_state_arr[$recordSet->fields["sse_rich_state"]];	
	$sse_s1 = $recordSet->fields["sse_s1"];
	$sse_s2 = $recordSet->fields["sse_s2"];
	$sse_s3 = $recordSet->fields["sse_s3"];
	$sse_s4 = $recordSet->fields["sse_s4"];
	$sse_s5 = $recordSet->fields["sse_s5"];
	$sse_s6 = $recordSet->fields["sse_s6"];
	$sse_s7 = $recordSet->fields["sse_s7"];
	$sse_s8 = $recordSet->fields["sse_s8"];
	$sse_s9 = $recordSet->fields["sse_s9"];
	$sse_s10 = $recordSet->fields["sse_s10"];
	$sse_s11 = $recordSet->fields["sse_s11"];
	//$sit_num = substr($curr_class_num,-2);
	$bgcolor = ($i++%2)?"#eeffff":"#ffffff";
	$personal_data.="<tr bgcolor='$bgcolor' onMouseOver=setBG('#AAFFCC',this) onMouseout=setBGOff('$bgcolor',this) >";
	
	$personal_data.="<td>$seme_year_seme</td><td>$sse_relation</td><td>$sse_family_kind</td><td>$sse_family_air</td>
		<td>$sse_farther</td><td>$sse_mother</td><td>$sse_live_state</td><td>$sse_rich_state</td>";
	for($j=1;$j<=11;$j++) {
		$temp_arr = explode(",",${"sse_s".$j});
		$s_temp_arr = ${"sse_s".$j."_arr"};
		$temp_str='';
		while(list($id,$val)=each($temp_arr)){
			if ($val)
				$temp_str .= $s_temp_arr[$val].",";
		}
		$personal_data.="<td>$temp_str</td>";
	}
	$personal_data.="</tr>\n";
	$recordSet->MoveNext();
}
$personal_data_caption.=$personal_data."</table>";

$main="<table>";
$main.="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'>
<tr><td align='center'>$date_select<BR>$class_select<BR>$stud_select</td><td valign='top'>$personal_data_caption</td></tr>";
$main.="</table></form>";

echo $main;
?>
