<?php

// $Id: my_function.php 7767 2013-11-15 06:18:35Z smallduh $

//���o��ظ`��
function get_ss_num($class_id="",$stud_id="",$student_sn="",$ss_id=""){
	global $CONN;

	$sql_select = "select count(*) from score_course where ss_id=$ss_id and class_id='$class_id'";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	list($n)= $recordSet->FetchRow();

	return $n;
}



//��X�Y��ǥͬY�쪺���Ǵ����Z�A�åH�ҤA���B�����G
function get_ss_score($class_id="",$stud_id="",$student_sn="",$ss_id=""){
	global $CONN;
	$class=class_id_2_old($class_id);
	$year=$class[0];
	$seme=$class[1];
	//�u�D�X�`���Z
	$score=seme_score2($student_sn,$ss_id,$year,$seme);
	// ����J
	if ($score == -1)
		$score_name = "�L���";
	else
		$score_name=score2str($score,$class);
	return $score_name;
}

//���o�U����r�y�z 
function get_ss_score_memo($class_id="",$stud_id="",$student_sn="",$ss_id=""){
	global $CONN;
	$class=class_id_2_old($class_id);
	$year=$class[0];
	$seme=$class[1];

	$seme_year_seme = sprintf("%03d%d",$year,$seme);
	$query = "select ss_score_memo from stud_seme_score where seme_year_seme='$seme_year_seme' and student_sn = $student_sn and ss_id =$ss_id ";
	$res = $CONN->Execute($query) or trigger_error($query);
	return $res->fields[0];
}

//�W�h�f�y��
function &say_rule_2($class){
	$year=$class[0];
	$seme=$class[1];
         //���Ҹճ]�w���
        $sm=&get_all_setup("",$year,$seme,$class[3]);
                                                                                                                            
        //���ѳW�h
        $r=explode("\n",$sm[rule]);
        reset($r);
        while(list($k,$v)=each($r)){
                $str=explode("_",$v);
                $main.="<text:p text:style-name=\"P11\">�Ǵ����� ".htmlspecialchars($str[1])." $str[2] �ɡA���Ĭ��y$str[0]�z</text:p>";
        }
//	echo $main; exit;
        return $main;
}

//��X�Y��ǥͨư��`�`��
function get_abs_v($class_id="",$stud_id="",$ss_id=""){
	global $CONN;
	$class=class_id_2_old($class_id);
	$year=$class[0];
	$seme=$class[1];
	if ($seme==1) {
		$abs_sdate=(string)(1911+(integer)$year)."-07-31";
		$abs_edate=(string)(1912+(integer)$year)."-02-01";
	} else {
		$abs_sdate=(string)(1912+(integer)$year)."-01-31";
		$abs_edate=(string)(1912+(integer)$year)."-08-01";
	}

	$sql_select = "select count(sasn) from stud_absent where stud_id='$stud_id' and class_id='$class_id' and (date>'$abs_sdate' and date<'$abs_edate') and absent_kind='�ư�' and (section != 'uf' and section != 'df')";
	$recordSet = $CONN->Execute($sql_select);
	$abs_times=$recordSet->fields[0];

	return $abs_times;
}

//��X�Y��ǥͯf���`�`��
function get_abs_s($class_id="",$stud_id="",$ss_id=""){
	global $CONN;
	$class=class_id_2_old($class_id);
	$year=$class[0];
	$seme=$class[1];
	if ($seme==1) {
		$abs_sdate=(string)(1911+(integer)$year)."-07-31";
		$abs_edate=(string)(1912+(integer)$year)."-02-01";
	} else {
		$abs_sdate=(string)(1912+(integer)$year)."-01-31";
		$abs_edate=(string)(1912+(integer)$year)."-08-01";
	}

	$sql_select = "select count(sasn) from stud_absent where stud_id='$stud_id' and class_id='$class_id' and (date>'$abs_sdate' and date<'$abs_edate') and absent_kind='�f��' and (section != 'uf' and section != 'df')";
	$recordSet = $CONN->Execute($sql_select);
	$abs_times=$recordSet->fields[0];

	return $abs_times;
}

//��X�Y��ǥ��m���`�`��
function get_abs_c($class_id="",$stud_id="",$ss_id=""){
	global $CONN;
	$class=class_id_2_old($class_id);
	$year=$class[0];
	$seme=$class[1];
	if ($seme==1) {
		$abs_sdate=(string)(1911+(integer)$year)."-07-31";
		$abs_edate=(string)(1912+(integer)$year)."-02-01";
	} else {
		$abs_sdate=(string)(1912+(integer)$year)."-01-31";
		$abs_edate=(string)(1912+(integer)$year)."-08-01";
	}

	$sql_select = "select count(sasn) from stud_absent where stud_id='$stud_id' and class_id='$class_id' and (date>'$abs_sdate' and date<'$abs_edate') and absent_kind='�m��' and (section != 'uf' and section != 'df')";
	$recordSet = $CONN->Execute($sql_select);
	$abs_times=$recordSet->fields[0];

	return $abs_times;
}

//��X�Y��ǥͶ��|�`�`��
function get_abs_f($class_id="",$stud_id="",$ss_id=""){
	global $CONN;
	$class=class_id_2_old($class_id);
	$year=$class[0];
	$seme=$class[1];
	if ($seme==1) {
		$abs_sdate=(string)(1911+(integer)$year)."-07-31";
		$abs_edate=(string)(1912+(integer)$year)."-02-01";
	} else {
		$abs_sdate=(string)(1912+(integer)$year)."-01-31";
		$abs_edate=(string)(1912+(integer)$year)."-08-01";
	}

	$sql_select = "select count(sasn) from stud_absent where stud_id='$stud_id' and class_id='$class_id' and (date>'$abs_sdate' and date<'$abs_edate') and (section = 'uf' or section = 'df')";
	$recordSet = $CONN->Execute($sql_select);
	$abs_times=$recordSet->fields[0];

	return $abs_times;
}

//��X�Y��ǥͤ����`�`��
function get_abs_b($class_id="",$stud_id="",$ss_id=""){
	global $CONN;
	$class=class_id_2_old($class_id);
	$year=$class[0];
	$seme=$class[1];
	if ($seme==1) {
		$abs_sdate=(string)(1911+(integer)$year)."-07-31";
		$abs_edate=(string)(1912+(integer)$year)."-02-01";
	} else {
		$abs_sdate=(string)(1912+(integer)$year)."-01-31";
		$abs_edate=(string)(1912+(integer)$year)."-08-01";
	}

	$sql_select = "select count(sasn) from stud_absent where stud_id='$stud_id' and class_id='$class_id' and (date>'$abs_sdate' and date<'$abs_edate') and absent_kind='����' and (section != 'uf' and section != 'df')";
	$recordSet = $CONN->Execute($sql_select);
	$abs_times=$recordSet->fields[0];

	return $abs_times;
}

//��X�Y��ǥͤ����`�`��
function get_abs_o($class_id="",$stud_id="",$ss_id=""){
	global $CONN;
	$class=class_id_2_old($class_id);
	$year=$class[0];
	$seme=$class[1];
	if ($seme==1) {
		$abs_sdate=(string)(1911+(integer)$year)."-07-31";
		$abs_edate=(string)(1912+(integer)$year)."-02-01";
	} else {
		$abs_sdate=(string)(1912+(integer)$year)."-01-31";
		$abs_edate=(string)(1912+(integer)$year)."-08-01";
	}

	$sql_select = "select count(sasn) from stud_absent where stud_id='$stud_id' and class_id='$class_id' and (date>'$abs_sdate' and date<'$abs_edate')";
	$recordSet = $CONN->Execute($sql_select);
	$abs_times=$recordSet->fields[0];
	$abs_v=get_abs_v($class_id,$stud_id,$ss_id);
	$abs_s=get_abs_s($class_id,$stud_id,$ss_id);
	$abs_c=get_abs_c($class_id,$stud_id,$ss_id);
	$abs_f=get_abs_f($class_id,$stud_id,$ss_id);
	$abs_b=get_abs_b($class_id,$stud_id,$ss_id);
	$abs_times=$abs_times-$abs_v-$abs_s-$abs_c-$abs_f-$abs_b;

	return $abs_times;
}

?>
