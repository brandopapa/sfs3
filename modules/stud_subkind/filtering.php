<?php
// $Id: filtering.php 5596 2009-08-21 01:33:21Z infodaes $

include_once "config.php";
sfs_check();
$group_selected=$_POST['group_selected'];
$group_xor_selected=$_POST['group_xor_selected'];

$new_description=$_POST['new_description'];
$filter_mode=$_POST['filter_mode']?$_POST['filter_mode']:'or';

$stud_data_mode=$_POST['stud_data_mode']?$_POST['stud_data_mode']:'simple';
$aid=($stud_data_mode=='aid')?'checked':'';
$simple=($stud_data_mode=='simple')?'checked':'';
$book=($stud_data_mode=='book')?'checked':'';

$sorted=$_POST['sorted']?$_POST['sorted']:'by_class';
$by_kind=($sorted=='by_kind')?'checked':'';
$by_class=($sorted=='by_class')?'checked':'';


if($_POST['go']=='�x�s�ק�'){
	if($group_selected) {
		$kind_array=$_POST['kind'];
		foreach($kind_array as $value) $kind_list.="$value,";
		$kind_list=','.$kind_list;
		$update_sql="UPDATE stud_kind_group SET description='$new_description',kind_list='$kind_list' WHERE sn=$group_selected";
		$recordSet=$CONN->Execute($update_sql) or user_error("Ū�����ѡI<br>$update_sql",256);
	}
}


//�q�X����
head("�s�զW��z��");

//��V������
echo print_menu($MENU_P,$linkstr);
if(checkid($_SERVER['SCRIPT_FILENAME'],1)) {
//���o�ǥͨ����C��
$kind_ref_array=SFS_TEXT(stud_kind);

//���o�s�զW��
$group_sql="SELECT * FROM stud_kind_group ORDER BY description";
$recordSet=$CONN->Execute($group_sql) or user_error("Ū�����ѡI<br>$group_sql",256);
$group_select="<select name='group_selected' onchange='this.form.submit();'><option value='-'>---------��ܸs��---------</option>";
$group_xor_select="<select name='group_xor_selected' onchange='this.form.submit();'><option value='-'>---------��ܤ����s��---------</option>";

while(!$recordSet->EOF){
	$sn=$recordSet->fields['sn'];
	$description=$recordSet->fields['description'];
	$selected='';
	
	if($group_selected==$sn) {
		$selected='selected';
		$kind_list='';
		$kind_list_array=explode(',',$recordSet->fields['kind_list']);
		foreach($kind_list_array as $value) if($value) $kind_list.="[$kind_ref_array[$value]]";
	}
	$group_select.="<option $selected value=$sn>$description</option>";
	
	$selected='';
	if($group_xor_selected==$sn) {
		$selected='selected';
		$kind_xor_list='';
		$kind_xor_list_array=explode(',',$recordSet->fields['kind_list']);
		foreach($kind_xor_list_array as $value) if($value) $kind_xor_list.="[$kind_ref_array[$value]]";
	}
	$group_xor_select.="<option $selected value=$sn>$description</option>";

	$recordSet->MoveNext();
}
$group_select.="</select>";
$group_xor_select.="</select>";

//�i�椬���B�z
foreach($kind_xor_list_array as $value) {
	$key_result=array_search($value,$kind_list_array);
	if($key_result) unset($kind_list_array[$key_result]);
}

//�z��ǥ�
$filtered_student=array();
$sn_list='';
$all_kind='';
foreach($kind_list_array as $kind) {
	if($kind) {
		$all_kind.="[$kind]";
		$group_sql="SELECT a.student_sn,a.curr_class_num,a.stud_id,a.stud_name,a.stud_sex,a.stud_addr_1,a.stud_addr_2,a.stud_tel_1,a.stud_tel_2,b.guardian_name FROM stud_base a LEFT JOIN stud_domicile b ON a.student_sn=b.student_sn WHERE stud_study_cond=0 AND INSTR(a.stud_kind,',$kind,') ORDER BY a.curr_class_num;";
		$recordSet=$CONN->Execute($group_sql) or user_error("Ū�����ѡI<br>$group_sql",256);
		while(!$recordSet->EOF){
			$student_sn=$recordSet->fields['student_sn'];
			$curr_class_num=$recordSet->fields['curr_class_num'];
			$primary_key=$curr_class_num."_".$student_sn;  //�קK�ǮկZ�žǥͮy�����ƥH�ܩ�W��Q����л\
			if(!array_key_exists($student_sn,$filtered_student)) {
				$filtered_student[$primary_key]['student_sn']=$recordSet->fields['student_sn'];
				$filtered_student[$primary_key]['curr_class_num']=$recordSet->fields['curr_class_num'];
				$filtered_student[$primary_key]['stud_id']=$recordSet->fields['stud_id'];
				$filtered_student[$primary_key]['stud_name']=$recordSet->fields['stud_name'];
				$filtered_student[$primary_key]['stud_sex']=$recordSet->fields['stud_sex'];
				$filtered_student[$primary_key]['stud_addr_1']=$recordSet->fields['stud_addr_1'];
				$filtered_student[$primary_key]['stud_addr_2']=$recordSet->fields['stud_addr_2'];
				$filtered_student[$primary_key]['stud_tel_1']=$recordSet->fields['stud_tel_1'];
				$filtered_student[$primary_key]['stud_tel_2']=$recordSet->fields['stud_tel_2'];
				$filtered_student[$primary_key]['guardian_name']=$recordSet->fields['guardian_name'];				 
			}
			$filtered_student[$primary_key]['kind'].="[$kind]";
			$filtered_student[$primary_key]['kind_description'].="[$kind_ref_array[$kind]]";
			$recordSet->MoveNext();
		}
	}
}

//�i��and �z��
if($_POST['filter_mode']=='and'){
	foreach($filtered_student as $curr_class_num=>$data){
		if($data['kind']<>$all_kind) unset($filtered_student[$curr_class_num]);
	}
}
foreach($kind_list_array as $value) if($value) $kind_result_list.="[$kind_ref_array[$value]]";

//�i��}�C�Ƨ�
if($by_class) ksort($filtered_student);

//echo "<PRE>";
//print_r($filtered_student);
//echo "</PRE>";

// ���X�Z�Ű}�C
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$class_base = class_base($curr_year_seme);
$sex_array=array('1'=>'�k','2'=>'�k');

//����Ǧ~�Z�žɮv�}�C
$class_teacher_arr=array();
$semester_template=sprintf('%03d_%d_',curr_year(),curr_seme());
$sql="select class_id,teacher_1 from school_class where class_id like '$semester_template%'";
$res=$CONN->Execute($sql) or user_error("Ū��school_class��ƥ��ѡI<br>$sql",256);
while(!$res->EOF) {
	$teacher_class_id=$res->fields['class_id'];
	$class_teacher_arr[$teacher_class_id]=$res->fields['teacher_1'];
	$res->MoveNext();
}

//�ǥ͸�ƦC��
$serial_no=0;
foreach($filtered_student as $curr_class_num=>$data){
	$stud_sex=$data['stud_sex'];
	$stud_class=$class_base[substr($data['curr_class_num'],0,3)];
	$stud_no=substr($data['curr_class_num'],-2);
	
	$teacher_class_id=sprintf('%02d_%02d',substr($data['curr_class_num'],0,1),substr($data['curr_class_num'],1,2));
	$teacher_class_id=$semester_template.$teacher_class_id;

	$bg_color=$stud_sex==1?'#CCCCFF':'#FFCCCC';
	$serial_no++;
	switch($stud_data_mode){
	case 'simple':
		$stud_data.="<tr bgcolor='$bg_color'>
					<td align='center'>$serial_no</td>
					<td>".$data['stud_id']."</td>
					<td>$stud_class</td>
					<td>$stud_no</td>
					<td>".$data['stud_name']."</td>
					<td>".$sex_array[$stud_sex]."</td>
					<td>".$data['kind_description']."</td>
					</tr>";		
		break;
	case 'aid':
		$stud_data.="<tr bgcolor='$bg_color'>
					<td align='center'>$serial_no</td>
					<td>".$SCHOOL_BASE["sch_sheng"]."</td>
					<td>".$SCHOOL_BASE["sch_local_name"]."</td>
					<td>".$SCHOOL_BASE["sch_cname_ss"]."</td>
					<td>$stud_class</td>
					<td>".$class_teacher_arr[$teacher_class_id]."</td>
					<td>".$data['stud_name']."</td>
					<td>".$data['guardian_name']."</td>
					<td>".($data['stud_tel_2']?$data['stud_tel_2']:$data['stud_tel_1'])."</td>
					<td>".($data['stud_addr_2']?$data['stud_addr_2']:$data['stud_addr_1'])."</td>
					<td>".$data['kind_description']."</td>
					</tr>";		
		break;	
	case 'book':
		$stud_data.="<tr bgcolor='$bg_color'>
					<td align='center'>$serial_no</td>
					<td>".$SCHOOL_BASE["sch_local_name"]."</td>
					<td>".$SCHOOL_BASE["sch_cname_ss"]."</td>
					<td>".$data['stud_id']."</td>
					<td>$stud_class</td>
					<td>".$data['stud_name']."</td>					
					<td>".$data['kind_description']."</td>
					</tr>";
		break;	
	}
	
	
}

switch($stud_data_mode){
case 'simple':
	$cols_count=7;
	$title_data="<tr align=center><td>NO.</td><td>�Ǹ�</td><td>�NŪ�Z��</td><td>�y��</td><td>�m�W</td><td>�ʧO</td><td>�ŦX���������O</td></tr>";
	break;
case 'aid':
	$cols_count=11;
	$title_data="<tr align=center><td>����</td><td>����</td><td>�m���</td><td>�զW</td><td>�Z��</td><td>�ɮv�m�W</td><td>�ǥͩm�W</td><td>�a���m�W</td><td>�p���q��</td><td>�p���a�}</td><td>�L�Oú��N���N��O��]</td></tr>";
	break;	
case 'book':
	$cols_count=7;
	$title_data="<tr align=center><td>�s��</td><td>�m���</td><td>�զW</td><td>�Ǹ�</td><td>�Z��</td><td>�ǥͩm�W</td><td>�ŦX���O</td></tr>";
	break;
}

$listdata="<table width='100%' cellspacing='1' cellpadding='3'>
             <form name='my_form' method='post' action='$_SERVER[PHP_SELF]'>
			 <tr bgcolor=#FFCFAA><td colspan=$cols_count><img border='0' src='images/pin.gif'>�����O�s�զC��G$group_select <font color=red size=2>$kind_list</font></td></tr>
			 <tr bgcolor=#FFCFAA><td colspan=$cols_count><img border='0' src='images/pin.gif'>�s�ը����O�ư��G$group_xor_select  <font color=red size=2>$kind_xor_list</font></td></tr>
			 <tr bgcolor=#FFCFAA><td colspan=$cols_count><img border='0' src='images/pin.gif'>�ư����G�G<font color=blue>$kind_result_list</font></td></tr>
			 <tr bgcolor=#FFCFAA><td colspan=$cols_count><img border='0' src='images/pin.gif'>�z���޿�G
			 <input type='radio' value='or' name='filter_mode' ".(($filter_mode=='or')?'checked':'')." onclick='this.form.submit();'>�㨭�����O����
			 <input type='radio' value='and' name='filter_mode' ".(($filter_mode=='and')?'checked':'')." onclick='this.form.submit();'>�ŦX�������������O
			 </td></tr>
			 
			 <tr bgcolor=#FFCFAA><td colspan=$cols_count><img border='0' src='images/pin.gif'>�z�ﵲ�G�G�@�� ".count($filtered_student)." ��ŦX����</td></tr>";

if($group_selected and count($filtered_student)) {
	$listdata.="<tr bgcolor=#FFCFAA><td colspan=$cols_count><img border='0' src='images/pin.gif'>�ƧǤ覡�G
				<input type='radio' value='by_kind' name='sorted' $by_kind onclick='this.form.submit()'>�H�������O 
				<input type='radio' value='by_class' name='sorted' $by_class onclick='this.form.submit()'>�H�Z�Ůy��
				</td></tr>";	
	$listdata.="<tr bgcolor=#FFCFAA><td colspan=$cols_count><img border='0' src='images/pin.gif'>�ǥ͸�ƦC��G
				<input type='radio' value='simple' name='stud_data_mode' $simple onclick='this.form.submit()'>²���� 
				<input type='radio' value='aid' name='stud_data_mode' $aid onclick='this.form.submit()'>�N���N��O�ɧU 
				<input type='radio' value='book' name='stud_data_mode' $book onclick='this.form.submit()'>�Ь�ѸɧU�O
				</td></tr>";	
	
}

$listdata.="$title_data $stud_data</form></table>";
echo $listdata;
} else { echo "<h2><center><BR><BR><font color=#FF0000>�z�ëD�Ҳպ޲z���A�L�k�ϥΥ��\��!</font></center></h2>"; } 
foot();
?>
