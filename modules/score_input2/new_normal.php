<?php

// $Id: new_normal.php 5310 2009-01-10 07:57:56Z hami $

/*�ޤJ�ǰȨt�γ]�w��*/
include "../../include2/config.php";
//�ޤJ���
include "./my_fun.php";
//�ϥΪ̻{��
sfs_check();

//���ݭn register_globals
$teacher_course=$_POST['teacher_course'];
$weighted=trim($_POST['weighted']);
if(!$weighted) $weighted=1;
$test_name=trim($_POST['test_name']);
$teacher_id=$_SESSION['session_log_id'];//���o�n�J�Ѯv��id
$nor_score="nor_score_".curr_year()."_".curr_seme();
if(!empty($test_name)){
	if(strstr ($teacher_course, 'g')){
		$group_arr=explode("g",$teacher_course);
		//$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
		$ss_id=$group_arr[1];
		$sql="select student_sn from elective_stu where group_id='{$group_arr[0]}' ";
		$rs=$CONN->Execute($sql) or trigger_error($sql,256);
		while(!$rs->EOF){
			$stud_sn[]=$rs->fields['student_sn'];
			$rs->MoveNext();
		}
		if(!is_array($stud_sn) or sizeof($stud_sn)==0) trigger_error("�䤣��ӲվǥͦW��A�G�z�L�k�ϥΦ��\��C<ol>
			<li>�нT�{�аȳB�w�g�N�ӲվǥͦW���ƿ�J�t�Τ��C
			<li>�n���t�ӲվǥͽЦܡG(<a href='".$SFS_PATH_HTML."modules/elective/elective_stu.php'>�Ǭ��O����</a>)</ol>", E_USER_ERROR);
		for($j=0;$j<count($stud_sn);$j++){
			$sql="INSERT INTO $nor_score(teach_id,stud_sn,class_subj,stage,test_name,weighted,enable,freq) values('$teacher_id','$stud_sn[$j]','$teacher_course','{$_POST['stage']}','$test_name','$weighted','1','{$_POST['freq']}')";
			$rs=$CONN->Execute($sql) ;
		}
	}else{
    	$stud_sn=class_id_to_student_sn($_POST['class_id']);
		if(!is_array($stud_sn) or sizeof($stud_sn)==0) trigger_error("�䤣��ӯZ�ǥͦW��A�G�z�L�k�ϥΦ��\��C<ol>
			<li>�нT�{�аȳB�w�g�N�ӯZ�ǥͦW���ƿ�J�t�Τ��C
			<li>�פJ�ǥ͸�ơG�y�ǰȨt�έ���>�а�>���U��>�פJ��ơz(<a href='".$SFS_PATH_HTML."school_affairs/student_reg/create_data/mstudent2.php'>".$SFS_PATH_HTML."school_affairs/student_reg/create_data/mstudent2.php</a>)</ol>", E_USER_ERROR);
		for($j=0;$j<count($stud_sn);$j++){
			$sql="INSERT INTO $nor_score(teach_id,stud_sn,class_subj,stage,test_name,weighted,enable,freq) values('$teacher_id','$stud_sn[$j]','{$_POST['class_subj']}','{$_POST['stage']}','$test_name','$weighted','1','{$_POST['freq']}')";
			$rs=$CONN->Execute($sql) ;
		}
	}
	header("Location:./normal.php?teacher_course={$_POST['teacher_course']}&stage={$_POST['stage']}");

}
else{
	header("Location:./normal.php?teacher_course={$_POST['teacher_course']}&stage={$_POST['stage']}");
}
?>
