<?php

// $Id:  $

// ���J�]�w��
include "stud_move_config.php";
include "../../include/sfs_case_dataarray.php";


// �{���ˬd
sfs_check();
//���y���A
$study_cond_array=study_cond();
unset($study_cond_array[0]);
unset($study_cond_array[1]);

/*
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);
*/

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

/*	$sel_year = curr_year(); //��ܾǦ~
	$sel_seme = curr_seme(); //��ܾǴ�
	$curr_seme = curr_year().curr_seme(); //�{�b�Ǧ~�Ǵ�
*/	
$today = date("Y-m-d") ;

//�����w����A���o�e�@�~
if (!$beg_date) {
	 $beg_date =GetMonthAdd( $today ,-12) ;
	 list($ty,$tm,$td) = split('[/-]' , $beg_date) ;
	 $beg_date= "$ty-$tm-01" ;
}	
if (!$end_date) {
	 $end_date = $today  ;
}	

if($_POST['move_kind'])
{
	$kind_list=implode(',',$_POST['move_kind']);

	//���o���---------------------------------------------------------------------------
	$class_list_p = class_base($curr_seme);
	//$query = "select a.*,b.stud_name,b.stud_birthday,b.curr_class_num from stud_move a inner join stud_base b on a.student_sn=b.student_sn where a.move_kind IN ($kind_list) and (a.move_date between '$beg_date' and '$end_date') order by a.move_date";
	$query = "select a.*,b.stud_name, CONCAT( CAST(DATE_FORMAT(b.stud_birthday,'%Y')-1911 AS CHAR) , DATE_FORMAT(b.stud_birthday,'.%m.%d') ) as stud_birthday,b.curr_class_num,b.stud_sex,b.stud_person_id,b.stud_addr_1,b.stud_study_year,b.enroll_school from stud_move a inner join stud_base b on a.student_sn=b.student_sn where a.move_kind IN ($kind_list) and (a.move_date between '$beg_date' and '$end_date') order by a.move_date";
	
	$result = $CONN->Execute($query) or die ($query);
	while(!$result->EOF) {
		$move_id = $result->fields["move_id"];
		$move_kind=$result->fields["move_kind"];
		$arr[$move_id][move_kind] = $study_cond_array[$move_kind];
		//$arr[$move_id][stud_name] = "<a href='../stud_search/stu_list.php?student_sn=$student_sn' target='_$student_sn'>{$result->fields[stud_name]}</a>";
		$arr[$move_id][stud_name] = $result->fields["stud_name"];
		$arr[$move_id][stud_birthday] = $result->fields["stud_birthday"];
		// add at 20140926
		$arr[$move_id][stud_sex] = $result->fields["stud_sex"] == 1 ? "�k" : "�k";
		$arr[$move_id][stud_person_id] = $result->fields["stud_person_id"];
		$arr[$move_id][stud_addr_1] = $result->fields["stud_addr_1"];
		$arr[$move_id][stud_study_year] = $result->fields["stud_study_year"];
		
		
		$arr[$move_id][move_date] = $result->fields["move_date"];
		$arr[$move_id][stud_id] = $result->fields["stud_id"];
		$arr[$move_id][curr_class_num] = $result->fields["curr_class_num"];
		$arr[$move_id][school] = $result->fields["school"];
		$arr[$move_id][reason] = $result->fields["reason"];
		$arr[$move_id][school_id] = $result->fields["school_id"];
		$arr[$move_id][enroll_school] = $result->fields["enroll_school"];		
		$arr[$move_id][move_year] = substr($result->fields["move_year_seme"],0,-1);
		$arr[$move_id][move_semester] = substr($result->fields["move_year_seme"],-1);
		$result->MoveNext();
	}
	
	
	if($_POST[go]=='HTML��X'){
		//�����ƻs�����
		//$main="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>
			//	<tr align='center' bgcolor='#ffffcc'><td>NO.</td><td>�Ǵ�</td><td>���O</td><td>�Ǹ�</td><td>�~��</td><td>�m�W</td><td>�X�ͦ~���</td><td>���ʤ��</td><td>���ʭ�]</td><td>��X/��J�Ǯ�</td></tr>";
		$main="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>
				<tr align='center' bgcolor='#ffffcc'><td>NO.</td><td>�Ǹ�</td><td>�m�W</td><td>�ʧO</td><td>�����Ҧr��</td><td>�X�ͦ~���</td><td>�J�Ǧ~��</td><td>�J�Ǹ��</td><td>���y�a�}</td></tr>";
				
		foreach($arr as $move_id=>$data){
			$grade=substr($data[curr_class_num],0,-4);
			$i++;
			//$main.="<tr align='center'><td>$i</td><td>{$data[move_year]}-{$data[move_semester]}</td><td>{$data[move_kind]}</td><td>{$data[stud_id]}</td><td>$grade</td><td>{$data[stud_name]}</td><td>{$data[stud_birthday]}</td><td>{$data[move_date]}</td><td>{$data[reason]}</td><td>{$data[school_id]}{$data[school]}</td></tr>";
			//$main.="<tr align='center'><td>$i</td><td>{$data[stud_id]}</td><td>{$data[stud_name]}</td><td>{$data[stud_sex]}</td><td>{$data[stud_person_id]}</td><td>{$data[stud_birthday]}</td><td>{$data[move_year]}-{$data[move_semester]}</td><td>{$data[school_id]}{$data[school]}</td><td>{$data[stud_addr_1]}</td></tr>";
			$main.="<tr align='center'><td>$i</td><td>{$data[stud_id]}</td><td>{$data[stud_name]}</td><td>{$data[stud_sex]}</td><td>{$data[stud_person_id]}</td><td>{$data[stud_birthday]}</td><td>{$data[move_year]}-{$data[move_semester]}</td><td>{$data[enroll_school]}</td><td>{$data[stud_addr_1]}</td></tr>";
		}
		$main.="</table>";		
		foreach($_POST['move_kind'] as $key) $kind_name_list.="[{$study_cond_array[$key]}]";
		$date_list=sprintf("%d�~%02d��%02d��",date("Y")-1911,date("m"),date("d"));
		$main="<center><font size=5>{$school_long_name}���ʰO���C��</font><br>���������O�G$kind_name_list �@�@�@������϶��G$beg_date~$end_date<br>���������G$date_list<br>$main<br>�~�ȩӿ�G�@�@�@�@�@�@���U�ժ��G�@�@�@�@�@�@�аȥD���G�@�@�@�@�@�@�ժ��G�@�@�@�@�@�@</center>";

		echo $main;
		exit;
	}	
}		


//---------------------------------------------------------------------------
head("���ʰO���C��");
print_menu($student_menu_p);
//echo $beg_date ;

$template_dir = $SFS_PATH."/".get_store_path()."/templates";
// �ϥ� smarty tag
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
//$smarty->debugging = true;


$smarty->assign("beg_date",$beg_date);
$smarty->assign("end_date",$end_date);
$smarty->assign("arr",$arr);
$smarty->assign("move_kind",$_POST['move_kind']);
$smarty->assign("study_cond_array",$study_cond_array); //�հ����O
//$smarty->assign("move_kind",$study_cond_array[$_POST[move_kind]]);

$smarty->assign("template_dir",$template_dir);

$smarty->display("$template_dir/stud_move_list2.htm");

foot();

?>