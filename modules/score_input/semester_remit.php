<?php

// $Id: semester_remit.php 7768 2013-11-15 06:23:39Z smallduh $

/*�ޤJ�ǰȨt�γ]�w��*/
require "../../include/config.php";
require "../../include/sfs_case_score.php";
//�ޤJ���
include "./my_fun.php";
//�ϥΪ̻{��
sfs_check();

// ���ݭn register_globals
/*
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
*/
$class_id=$_POST['class_id'];
$student_sn=$_POST['student_sn'];
$ss_id=$_POST['ss_id'];
$test_sort=$_POST['test_sort'];
$test_form=$_POST['test_form'];
$sended=$_POST['sended'];
$teacher_course=$_POST['teacher_course'];
$Submit3=$_POST['Submit3'];
$score=$_POST['score'];

$feelback1="1";
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
$score_semester="score_semester_".$sel_year."_".$sel_seme;

/*****************************************************************************************************/
//����Ǵ��`���Z����ذT��
$seme_year_seme=sprintf("%03d%d",$sel_year,$sel_seme);
$ss_id_array=more_ss($ss_id);
reset($ss_id_array);
while(list($key , $val) = each($ss_id_array)) {
    if(is_array($val)){
    	reset($val);
        while(list($key1 , $val1) = each($val)) {
        //echo $key ."[". $key1 ."] => ".$val1."<br>";
            if($key=="ss_id") $TTL_ss_id[]=$val1;
            if($key=="rate") $TTL_rate[]=$val1;
        }
    }
    else{
        //echo "$key => $val<br>";
        if($key=="ss_id") $TTL_ss_id[]=$val;
        if($key=="rate") $TTL_rate[]=$val;
    }
}
//�g�J�аȳB�����q���Z��ƪ�
for($i=0;$i<count($student_sn);$i++){
    //echo $test_sort." ";
	if($test_sort=='254'){
		$sql_se="select * from $score_semester where class_id='$class_id' and student_sn='$student_sn[$i]' and ss_id='$ss_id' and test_kind='���ɦ��Z'";    		
		$rs_se=$CONN->Execute($sql_se);
		$j=0;
		$check[$i]=0;
		while(!$rs_se->EOF){
			$score_id[$j]=$rs_se->fields['score_id'];
			$sendmit[$j]=$rs_se->fields['sendmit'];
			//echo $score_id[$j]."--->".$sendmit[$j]."<br>";
			$check[$i]=$check[$i]+$sendmit[$j];
			$j++;
			$rs_se->MoveNext();
		}
		//�|���e��аȳB�A�g�J		
		//echo $check[$i]." ";
		if($check[$i]!=0){
			$update_time=date("Y-m-d H:i:s");
			//�Nsendmit�אּ0
			for($k=0;$k<count($sendmit);$k++){
				$sql_sendmit="UPDATE $score_semester SET sendmit='0' WHERE score_id='$score_id[$k]'";
				$CONN->Execute($sql_sendmit);
			}
			//���K���s�p��Ǵ��`���Z
			for($m=0;$m<count($TTL_ss_id);$m++){
				$total_score[$i]=$total_score[$i]+(seme_score($student_sn[$i],$TTL_ss_id[$m])*$TTL_rate[$m]);
				$weight[$i]=$weight[$i]+$TTL_rate[$m];
			}
			echo "��즨�Z�G$real_score[$i]=$total_score[$i]/$weight[$i] <br>";			
			$real_score[$i]=$total_score[$i]/$weight[$i];//�ӻ��ά�ت��Ǵ��`����
			//�P�_�Ӧ��Z�O�_�w�g�s�b�üg�J
			$sss_id_qry="select sss_id from stud_seme_score where seme_year_seme='$seme_year_seme' and ss_id='$ss_id' and student_sn='$student_sn[$i]'";
			$sss_id_rs=$CONN->Execute($sss_id_qry) or trigger_error("�Ǵ��`���Z��ƪ��إ�",E_USER_ERROR);
			$sss_id[$i]=$sss_id_rs->fields['sss_id'];
			if($sss_id[$i]){//��s���Z
				$CONN->Execute("UPDATE stud_seme_score SET ss_score='$real_score[$i]',teacher_sn='$_SESSION[session_tea_sn]'  WHERE  sss_id='$sss_id[$i]'");
			}
			else{//�s�W���Z
				$CONN->Execute("INSERT INTO stud_seme_score (seme_year_seme,student_sn,ss_id,ss_score,teacher_sn) values('$seme_year_seme','$student_sn[$i]','$ss_id','$real_score[$i]','$_SESSION[session_tea_sn]')");
				//echo "INSERT INTO $score_semester (class_id,student_sn,ss_id,score,test_name,test_kind,test_sort,update_time) values('$class_id','$student_sn[$i]','$ss_id','$new_score','���Ǵ�','���Ǵ�','255','$update_time')";
			}
			//��Ƽg�J�����A���X���{��
			//header("Location:manage.php?teacher_course=$teacher_course&curr_sort=$test_sort&curr_form=$test_form&sended=$sended");
		}
		//�w�g�e��аȳB�A���X
		else{
		//	header("Location:manage.php?teacher_course=$teacher_course&curr_sort=$test_sort&curr_form=$test_form&feelback1=$feelback1");

		}	
	
	}
	else{
		$sql_se="select * from $score_semester where class_id='$class_id' and student_sn='$student_sn[$i]' and ss_id='$ss_id' and test_sort='$test_sort'";    
		//echo $sql_se;
		$rs_se=$CONN->Execute($sql_se);
		$j=0;
		$check[$i]=0;
		while(!$rs_se->EOF){
			$score_id[$j]=$rs_se->fields['score_id'];
			$sendmit[$j]=$rs_se->fields['sendmit'];
			//echo $score_id[$j]."--->".$sendmit[$j]."<br>";
			$check[$i]=$check[$i]+$sendmit[$j];
			$j++;
			$rs_se->MoveNext();
		}
		//�|���e��аȳB�A�g�J
		//echo $student_sn[$i]."---".$check[$i]."<br>";
		if(($check[$i]==1)||($check[$i]==2)){
			$update_time=date("Y-m-d H:i:s");
			//�Nsendmit�אּ0
			for($k=0;$k<count($sendmit);$k++){
				$sql_sendmit="UPDATE $score_semester SET sendmit='0' WHERE score_id='$score_id[$k]'";
				$CONN->Execute($sql_sendmit);
			}
			//���K���s�p��Ǵ��`���Z
			for($m=0;$m<count($TTL_ss_id);$m++){
				$total_score[$i]=$total_score[$i]+(seme_score($student_sn[$i],$TTL_ss_id[$m])*$TTL_rate[$m]);
				$weight[$i]=$weight[$i]+$TTL_rate[$m];
			}
			//echo "��즨�Z�G".$real_score[$i]=$total_score[$i]/$weight[$i]."<br>";
			if($test_sort=="255") $real_score[$i]=$score[$i];
			else $real_score[$i]=$total_score[$i]/$weight[$i];//�ӻ��ά�ت��Ǵ��`����
			//�P�_�Ӧ��Z�O�_�w�g�s�b�üg�J
			$sss_id_qry="select sss_id from stud_seme_score where seme_year_seme='$seme_year_seme' and ss_id='$ss_id' and student_sn='$student_sn[$i]'";
			$sss_id_rs=$CONN->Execute($sss_id_qry) or trigger_error(" $sss_id_qry �Ǵ��`���Z��ƪ��إ�",E_USER_ERROR);
			$sss_id[$i]=$sss_id_rs->fields['sss_id'];
			if($sss_id[$i]){//��s���Z
				$CONN->Execute("UPDATE stud_seme_score SET ss_score='$real_score[$i]',teacher_sn='$_SESSION[session_tea_sn]' WHERE  sss_id='$sss_id[$i]'");
			}
			else{//�s�W���Z
				$CONN->Execute("INSERT INTO stud_seme_score (seme_year_seme,student_sn,ss_id,ss_score,teacher_sn) values('$seme_year_seme','$student_sn[$i]','$ss_id','$real_score[$i]','$_SESSION[session_tea_sn]')");
				//echo "INSERT INTO $score_semester (class_id,student_sn,ss_id,score,test_name,test_kind,test_sort,update_time) values('$class_id','$student_sn[$i]','$ss_id','$new_score','���Ǵ�','���Ǵ�','255','$update_time')";
			}
			//��Ƽg�J�����A���X���{��
		//	header("Location:manage.php?teacher_course=$teacher_course&curr_sort=$test_sort&curr_form=$test_form&sended=$sended");
		}
		//�w�g�e��аȳB�A���X
		else{
		//	header("Location:manage.php?teacher_course=$teacher_course&curr_sort=$test_sort&curr_form=$test_form&feelback1=$feelback1");

		}
	}	
}

?>
