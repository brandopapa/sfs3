<?php
// $Id: normal.php 5836 2010-01-25 15:03:54Z chiming $
/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";
include "./module-upgrade.php";
require_once "../../include/sfs_case_score.php";


//�ϥΪ̻{��
sfs_check();


//�ܼƳ]�w
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//�Юv�N��
$teacher_sn = $_SESSION[session_tea_sn];
$teacher_name = $_SESSION[session_tea_name];

//���o�Z�ŦW�ٰ}�C
$class_name_arr = class_base();

//�]�w�i�H�ޥΪ��ǥ͸��
$student_fields_array=array('curr_class_num'=>'�Z�Ůy��','stud_name'=>'�ǥͩm�W','stud_sex'=>'�ʧO','stud_id'=>'�Ǹ�','stud_tel_2'=>'�p���q��','email'=>'�q�l�l��','stud_mschool_name'=>'��p�NŪ�Ǯ�','enroll_school'=>'�J�ǾǮ�');

if($_POST['go']=='HTML��X')
{
	$page_title=$_POST['page_title'];
	$page_memo=$_POST['page_memo'];
	$added_field=$_POST['added_field'];	
	$selected_class=$_POST['selected_class'];
	$preload_field=$_POST['preload_field'];
	$groups_title=$_POST['groups_title'];
	$cols_title=$_POST['cols_title'];

	$sex_array=array('1'=>'�k','2'=>'�k');

	$page_break ="<P style='page-break-after:always'>&nbsp;</P>";
	
	//��������P�l��
	$cols=$_POST['cols'];
	$groups=$_POST['groups'];
	switch($groups_title)
	{
		case '1': $groups_title_array=explode(',','�@,�@,�@,�@,�@,�@,�@,�@,�@,�@,�@'); break;
		case '2': $groups_title_array=explode(',','1,2,3,4,5,6,7,8,9,10'); break;
		case '3': $groups_title_array=explode(',','�@,�G,�T,�|,��,��,�C,�K,�E,�Q'); break;
		case '9': $groups_title_array=explode(',',$_POST['my_groups_title']); break;
	}
	for($i=0;$i<$groups;$i++) $groups_list.="<td colspan='$cols' align='center'>{$groups_title_array[$i]}</td>";
	
	
	switch($cols_title)
	{
		case '1': $cols_title_array=explode(',','�@,�@,�@,�@,�@,�@,�@,�@,�@,�@,�@'); break;
		case '2': $cols_title_array=explode(',','1,2,3,4,5,6,7,8,9,10'); break;
		case '3': $cols_title_array=explode(',','�@,�G,�T,�|,��,��,�C,�K,�E,�Q'); break;
		case '9': $cols_title_array=explode(',',$_POST['my_cols_title']); break;
	}
	for($k=0;$k<$groups;$k++) for($i=0;$i<$cols;$i++)
	{
		$cols_list.="<td align='center'>{$cols_title_array[$i]}</td>"; 
		$cols_list_empty.="<td ></td>"; 
	}
	
	//����e�m���W��
	foreach($preload_field as $value) $table_header.="<td rowspan='2' align='center'>{$student_fields_array[$value]}</td>";

	//�����m���W��
	$added_field_array=explode(',',$_POST['added_field']);
	foreach($added_field_array as $value)
	{
		$added_field_list.="<td rowspan=2 align='center'>$value</td>";
		$added_field_list_empty.="<td></td>";
	}
	
	//�C�X�����
	$class_count=count($selected_class)-1;
	foreach($selected_class as $key=>$value)
	{
		$group_data=explode(' ',$value);
		$group_id=$group_data[0];
		//������սҵ{�ǥͲM��
		$sql="select student_sn from elective_stu where group_id=$group_id";
		$rs=$CONN->Execute($sql) or trigger_error($sql,E_USER_ERROR);
		$group_sn='';
		while (!$rs->EOF) {
			$group_sn.=$rs->fields['student_sn'].',';
			$rs->MoveNext();
		}
		$group_sn=substr($group_sn,0,-1);
		
		
		//����Z�žǥ͸��
		$stud_data="";
		$sql="select * from stud_base where student_sn in ($group_sn) AND stud_study_cond=0 order by curr_class_num";
		$rs=$CONN->Execute($sql) or trigger_error($sql,E_USER_ERROR);
		while(!$rs->EOF) {
			foreach($preload_field as $value)
			{
				$field_data=$rs->fields[$value];
				if($value=='curr_class_num') $field_data=substr($field_data,0,-2).'-'.substr($field_data,-2); else
					if($value=='stud_sex') $field_data=$sex_array[$field_data]; 
		
				$stud_data.="<td align='center'>$field_data</td>";
			}
			$stud_data="<tr>$stud_data $cols_list_empty $added_field_list_empty</tr>";
			$rs->MoveNext();
		}

		
		$main="<center><font size=4>$page_title</font></center>
			<p>���Ǵ��O�G$sel_year - $sel_seme �@���Юv�G$teacher_name �@�����вէO�P��ءG{$group_data[1]}�@{$group_data[2]}</p>
			<table STYLE='font-size: x-small' border='1' cellpadding=5 cellspacing=0 style='border-collapse: collapse' bordercolor='#111111' width='100%'>
			<tr bgcolor='#FFEECC'>$table_header $groups_list $added_field_list</tr><tr>$cols_list</tr>$stud_data</table><font size=2>$page_memo</font>";
		if($key<$class_count) $main.=$page_break;
		echo $main;
	}
} else {
	head('���վǥͦW�U�C�L');
	print_menu($menu_p);
	echo "<script>
		function tagall(status) {
		  var i =0;
		  while (i < document.myform.elements.length)  {
			if (document.myform.elements[i].name=='selected_class[]') {
			  document.myform.elements[i].checked=status;
			}
			i++;
		  }
		}
		</script>";

	$subject_checkbox_list="";
	//���o���T���нҵ{
	$sql="SELECT a.*,b.* FROM elective_tea a,score_ss b WHERE a.ss_id=b.ss_id AND b.year=$sel_year AND b.semester=$sel_seme AND a.teacher_sn=$teacher_sn ORDER BY group_id";
	$rs=$CONN->Execute($sql) or trigger_error($sql,E_USER_ERROR);
	while (!$rs->EOF) {
		$course_id[$i] = $rs->fields["course_id"];
		$class_year = $rs->fields["class_year"];
		$group_id= $rs->fields["group_id"];
		$group_name = $rs->fields["group_name"];
		$ss_id= $rs->fields["ss_id"];
		$subject_name=ss_id_to_subject_name($ss_id).'-'.$group_name;
		$subject_checkbox_list.="<input type='checkbox' name='selected_class[]' value='$group_id $subject_name' checked>($group_id)$subject_name<br>";
		$rs->MoveNext();
	}

	$page_title="��������D�G<input type='text' name='page_title' size=70 value='$school_long_name ���Z������'>";
	
	//�]�w�i�H������ǥ͸��
	$lead_field="���e�m���G";
	foreach($student_fields_array as $key=>$value)
	{
		$c++;
		$checked=($c<=3)?'checked':'';
		$lead_field.="<input type='checkbox' name='preload_field[]' value='$key' $checked>$value";
	}
	

	$groups="�@�����q���ơG<input type='radio' value='1' name='groups'>1 <input type='radio' value='2' name='groups'>2 <input type='radio' value='3' name='groups' checked>3 <input type='radio' value='4' name='groups'>4";
	$groups_title="�@�@�����D�G<input type='radio' value='1' name='groups_title'>�ť� <input type='radio' value='2' name='groups_title'>1,2,3,.. <input type='radio' value='3' name='groups_title' checked>�@,�G,�T,.. <input type='radio' value='9' name='groups_title'>�۩w�q(�H,���j)�G<input type='text' name='my_groups_title' size=25 maxlength=25 value='�Ĥ@���q,�ĤG���q,�ĤT���q'>";
	$cols="�@���C���q��ơG<input type='radio' value='3' name='cols'>3 <input type='radio' value='5' name='cols' checked>5 <input type='radio' value='7' name='cols'>7 <input type='radio' value='10' name='cols'>10 ";
	$cols_title="�@�@�����D�G<input type='radio' value='1' name='cols_title'>�ť� <input type='radio' value='2' name='cols_title' checked>1,2,3,.. <input type='radio' value='3' name='cols_title'>�@,�G,�T,.. <input type='radio' value='9' name='cols_title'>�۩w�q(�H,���j)�G<input type='text' name='my_cols_title' size=25 maxlength=25 value='�w��,����,����'>";
	
	$added_field="����m���(�H,���j)�G<input type='text' name='added_field' size=30 maxlength=30 value='�`��,����,�Ƶ�'>";
	
	$page_memo="������Ƶ��G<input type='text' name='page_memo' size=70 value=''>";
	
	echo "<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]' target='_BLANK'>
			<table STYLE='font-size: x-small' border='1' cellpadding=5 cellspacing=0 style='border-collapse: collapse' bordercolor='#111111' width='100%'>
			<tr><td align='center' width='200' bgcolor='#FFCCCC'>�����Ъ���ء� �@�@�@<input type='checkbox' name='tag' checked onclick='javascript:tagall(this.checked);'>����</td>
			<td rowspan=2 valign='top'><BR>$page_title<BR><BR>$lead_field<BR><BR> $groups<BR> $groups_title<BR><BR> $cols<BR> $cols_title<BR><BR>$added_field<BR><BR>$page_memo
			<BR><BR><p align='center'><input type='submit' name='go' value='HTML��X'></p></td></tr>
			<tr><td>$subject_checkbox_list</td></tr>
			</table></form>";
	foot();
}
?>
