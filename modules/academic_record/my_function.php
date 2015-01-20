<?php

// $Id: my_function.php 7727 2013-10-28 08:26:17Z smallduh $

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
        return $main;
}

function teacher_sn_to_class_name($teacher_sn){
    global $CONN;
        $sql="select class_num from teacher_post where teacher_sn='$teacher_sn'";
        $rs=$CONN->Execute($sql);
        $class_num = $rs->fields["class_num"];
        if($class_num=="") trigger_error("�z�S������ɮv�I",E_USER_ERROR);
        $sel_year = curr_year(); //�ثe�Ǧ~
        $sel_seme = curr_seme(); //�ثe�Ǵ�
        $class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,substr($class_num,0,-2),substr($class_num,-2));
        $class_cname=class_id_to_full_class_name($class_id);
        $class_name[0]=$class_num;//�Ʀr
        $class_name[1]=$class_cname;//����
		$class_name[3]=$class_id;//����
        return $class_name;
}

//���o�ӯZ�ҵ{�`��
function get_class_cn($class_id=""){
	global $CONN;
	//���o�Y�Z�ǥͰ}�C
	$c=class_id_2_old($class_id);
	
	//���o�ӯZ���X�`��
	$sql_select = "select sections from score_setup where year = '$c[0]' and semester='$c[1]' and class_year='$c[3]'";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("SQL�y�k���~�G $sql_select", E_USER_ERROR);
	list($all_sections) = $recordSet->FetchRow();
	return $all_sections;
}
?>
