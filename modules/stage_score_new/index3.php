<?php

/* ���o�]�w�� */
include "config.php";
require_once "../../include/sfs_case_excel.php";

sfs_check();

$year_seme=$_POST[year_seme]?$_POST[year_seme]:sprintf("%03d%d",curr_year(),curr_seme());
$class_year=$_POST[class_year]?$_POST[class_year]:'';
$subject_arr=$_POST[subject];

//$stage_item_arr=explode(',',$stage_item);
//$stage=$_POST[stage]?$_POST[stage]:$stage_item_arr[0];

$percision=$_POST[percision]?$_POST[percision]:$default_percision;
//$note_text=$_POST[note_text]?$_POST[note_text]:$default_note_text;

//�i�洫�����
//$note_text=str_replace("\n","<br>",$note_text);

$sel_year=substr($year_seme,0,-1);
$sel_seme=substr($year_seme,-1);

//���Ϳ����ذ}�C
foreach($subject_arr as $key=>$value) {
	$temp=explode('_',$value);
	$ss_id=$temp[0];
	$score_subject_array[$ss_id][rate]=$temp[1];
	$score_subject_array[$ss_id][subject_id]=$temp[2];
	$score_subject_array[$ss_id][subject_name]=$temp[3];
}

//�Ǵ����
$year_seme_array=get_class_seme();
krsort($year_seme_array); //����Ƨ�

$year_seme_select="<select name='year_seme' onchange=\"this.form.target='$_PHP[SCRIPT_NAME]'; this.form.submit()\">";
foreach($year_seme_array as $key=>$value){
	$selected=($year_seme==$key)?' selected':'';
	$year_seme_select.="<option value='$key'$selected>$value</option>";
}
$year_seme_select.="</select>";

//�~�ſ��
$class_select="<select name='class_year' onchange=\"this.form.target='$_PHP[SCRIPT_NAME]'; this.form.submit()\"><option></option>";

$sql="SELECT distinct c_year FROM school_class WHERE enable=1 AND year=$sel_year AND semester=$sel_seme order by c_year,c_sort";
$res = $CONN->Execute($sql) or trigger_error($sql,E_USER_ERROR);
while(!$res->EOF){
	$this_class_year=$res->fields[c_year];
	$this_class_name=$school_kind_name[$res->fields[c_year]];
	$selected=($this_class_year==$class_year)?' selected':'';
	if($selected) $selected_class_name="<input type='hidden' name='selected_class_name' value='$this_class_name'>";
	$class_select.="<option value='$this_class_year'$selected>$this_class_name</option>";
	$res->MoveNext();
}
$class_select.="</select>$selected_class_name";

//���Ϧ��ǤJ�Z�ťN���~�i��
if($class_year) {
	$go_buttons="<input type='submit' name='go' value='HTML'><input type='submit' name='go' value='EXCEL'>";
	
	if($_POST['go']) {
		//����ҵ{��ئW��
		$sql_select = "select subject_id,subject_name from score_subject ";
		$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
		$temp_arr=array();
		while (!$recordSet->EOF) {
			$temp_arr[$recordSet->fields[subject_id]] = $recordSet->fields[subject_name];
			$recordSet->MoveNext();
		}
		
		//�������W�ټ�
		$nor_score_db="nor_score_".intval($sel_year).'_'.$sel_seme;
		$class_subj=sprintf("%d_%d_%02d",intval($sel_year),$sel_seme,$class_year).'_%';
		
		//����Ҧ������ର�ǥͭӤH���Z�}�C
		$data_arr=array();
		$sql="SELECT * FROM $nor_score_db WHERE enable=1 AND stage=255 AND class_subj LIKE '$class_subj' ORDER BY class_subj,test_name";
		$res = $CONN->Execute($sql) or trigger_error($sql,E_USER_ERROR);
		while(!$res->EOF){
			$student_sn=$res->fields['stud_sn'];
			$class_subject=explode('_',$res->fields['class_subj']);
			$class_id=$class_subject[3];
			$subject_id=$class_subject[4];
			$test_name=$res->fields['test_name'];
			//EXCEL�n��X�����W�٦C��
			$field_name=$temp_arr[$subject_id].'-'.$test_name;
			$fields_array[$field_name]+=1;
			
			//�ӤH���Z
			$data_arr[$student_sn][$field_name]=$res->fields['test_score'];
			$res->MoveNext();
		}

		//�s�@���Y
		switch($_POST['go']){
			case 'EXCEL':
				$x=new sfs_xls();
				$x->setUTF8();
				$x->filename=$SCHOOL_BASE['sch_id'].'_'.$school_long_name.'_'.$year_seme.'_'.$class_year.'�~�Ť�����ҵ{���ɦ��Z.xls';
				$x->setBorderStyle(1);
				$x->addSheet($school_id);
				
				$a=array('�Z��','�y��','�Ǹ�','�m�W');
				foreach($fields_array as $field_name=>$counter) $a[]=$field_name;
				$x->items[0]=$a;
				break;
			case 'HTML':
				$student_data="<table border=2 cellpadding=3 cellspacing='0' style='border-collapse: collapse;' width=100%>
					<tr bgcolor='#ffcccc' align='center'><td>�Z��</td><td>�y��</td><td>�Ǹ�</td><td>�m�W</td>";
				foreach($fields_array as $field_name=>$counter) $student_data.="<td>$field_name</td>";
				$student_data.="</tr>";
				break;
		}


		//�������Ǵ��ǥͦC��
		$sql="SELECT a.student_sn,a.seme_class,a.seme_class_name,a.seme_num,a.stud_id,b.stud_name FROM stud_seme a INNER JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.seme_year_seme='$year_seme' AND a.seme_class like '$class_year%' ORDER BY seme_class,seme_num";
		$res = $CONN->Execute($sql) or trigger_error($sql,E_USER_ERROR);
		while(!$res->EOF){
			$student_sn=$res->fields['student_sn'];
			$stud_name=$res->fields['stud_name'];
			$seme_class=$res->fields['seme_class'];
			$seme_num=$res->fields['seme_num'];
			$stud_id=$res->fields['stud_id'];
			$seme_class_name=$res->fields['seme_class_name'];
			
			
			switch($_POST['go']){
				case 'EXCEL':
					$a=array($seme_class,$seme_num,$stud_id,$stud_name);
					foreach($fields_array as $field_name=>$counter) {
						$score=$data_arr[$student_sn][$field_name];
						$a[]=$score;
					}
					$x->items[]=$a;
					break;
				case 'HTML':
					$student_data.="<tr align='center'><td>$seme_class</td><td>$seme_num</td><td>$stud_id</td><td>$stud_name</td>";
					foreach($fields_array as $field_name=>$counter) {
						$score=$data_arr[$student_sn][$field_name];
						$student_data.="<td>$score</td>";
					}
					$student_data.="</tr>";
				break;
			}

			$res->MoveNext();
		}
		
		if($_POST['go']=='EXCEL') {
			$x->writeSheet();
			$x->process();
			exit;
		} else 	$student_data.="</table>";
	}
}

//�q�X����
head("������ҵ{���ɦ��ZXLS�ץX");

//�L���
print_menu($menu_p);
$main="<form name='myform' method='post'>$year_seme_select $class_select $go_buttons $student_data</form>";
echo $main;

foot();


?>
