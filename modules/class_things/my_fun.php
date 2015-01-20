<?php
// $Id: my_fun.php 5310 2009-01-10 07:57:56Z hami $

include_once "../../include/sfs_case_studclass.php";

//���եثe�Ӧ~�ŸӯZ�ŸӬ�إثe�w�����q���Z�����
function &now_stage($id,$col_name,$teacher_id,$sel_year,$sel_seme,$class_id,$ss_id){
    global $CONN;
    
    $class=class_id_2_old($class_id);

    $times_qry="select performance_test_times from score_setup where class_year=$class[3] and year=$sel_year and semester='$sel_seme' and enable='1'";
    $times_rs=&$CONN->Execute($times_qry);
    $performance_test_times=$times_rs->fields["performance_test_times"];

    $score_semester="score_semester_".$sel_year."_".$sel_seme;
    $sql="select test_sort from $score_semester where class_id='$class_id' and ss_id='$ss_id' and sendmit='0' order by score_id";
    $rs=&$CONN->Execute($sql);
    $i=0;
    if(is_object($rs)){
        while (!$rs->EOF) {
            $test_sort=$rs->fields["test_sort"];
            $i++;
            $rs->MoveNext();
        }
    }
    if(($test_sort=="")||($test_sort>=$performance_test_times)){ $test_sort=0; }
    $now=$test_sort+1;
    $option="<option value=''>��ܶ��q</option>\n";
    for($i=1;$i<=$performance_test_times;$i++){
        $selected=($id==$i)?"selected":"";
        if($id==""){
            $selected=($i==$now)?"selected":"";
        }
        $option.="<option value='$i' $selected>��".$i."���q</option>\n";
    }

    return $option;
}

//���եثe�Ӧ~�ŸӯZ�ŸӬ�إثe�w�����q���Z�����
function &Nnow_stage($id,$col_name,$teacher_id,$sel_year,$sel_seme,$class_id,$ss_id){
    global $CONN;
    
    $class=class_id_2_old($class_id);

    $times_qry="select performance_test_times from score_setup where  class_year=$class[3] and year=$sel_year and semester='$sel_seme' and enable='1'";
    $times_rs=&$CONN->Execute($times_qry);
    $performance_test_times=$times_rs->fields["performance_test_times"];
    $score_semester="score_semester_".$sel_year."_".$sel_seme;
    $sql="select test_sort from $score_semester where class_id='$class_id' and ss_id='$ss_id' and sendmit='0' order by score_id";
    $rs=&$CONN->Execute($sql);
    $i=0;
    if(is_object($rs)){
        while (!$rs->EOF) {
            $test_sort_a[$i]=$rs->fields["test_sort"];
            $i++;
            $rs->MoveNext();
        }
    }
    $t_max=max($test_sort_a);
    if(($t_max=="")||($t_max>=$performance_test_times)){ $t_max=0; }
    $now=$t_max+1;
    return $now;
}

//���եثe�Ǧ~�P�Ǵ��U�Ԧ����
function &select_year_seme($id,$col_name){
    global $CONN;
    $sql="select * from school_class";
    $rs=$CONN->Execute($sql);

    $option="<option value=''>��ܾǦ~��</option>\n";
    $i=0;
    while (!$rs->EOF) {
        $year[$i]=$rs->fields["year"];
        $semester[$i]=$rs->fields['semester'];
        $year_semester[$i]=$year[$i]."_".$semester[$i];
        $i++;
        $rs->MoveNext();
    }
    $year_semester=deldup($year_semester);
    for($i=0;$i<count($year_semester);$i++){
        $selected=($id==$year_semester[$i])?"selected":"";
        $YS=explode("_",$year_semester[$i]);
        $option.="<option value='$year_semester[$i]' $selected>".$YS[0]."�Ǧ~�ײ�".$YS[1]."�Ǵ�</option>\n";
    }
    $select_school_class="<select name='$col_name'>$option</select>";
	//return $select_school_class;
    return $option;
}

//���եثe�~�ŤU�Ԧ����
function &select_school_class($id,$col_name,$sel_year,$sel_seme){
    global $CONN;
    $sql="select * from school_class where year=$sel_year and semester=$sel_seme";
    $rs=$CONN->Execute($sql);
    $school_kind_name=array("���X��","�@�~","�G�~","�T�~","�|�~","���~","���~","�@�~","�G�~","�T�~","�@�~","�G�~","�T�~");
    $option="<option value=''>��ܦ~��</option>\n";
    $i=0;
    while (!$rs->EOF) {
        $c_year[$i]=$rs->fields["c_year"];
        $i++;
        $rs->MoveNext();
    }
    $c_year=deldup($c_year);
    for($i=0;$i<count($c_year);$i++){
        $selected=($id==$c_year[$i])?"selected":"";
        $option.="<option value='$c_year[$i]' $selected>".$school_kind_name[$c_year[$i]]."��</option>\n";
    }
    $select_school_class="<select name='$col_name'>$option</select>";
	//return $select_school_class;
    return $option;
}

//���եثe�Ӧ~�Ū��Ҧ��Z�ŤU�Ԧ����
function &select_school_class_name($c_year,$id,$col_name,$sel_year,$sel_seme){
    global $CONN;
    if(empty($c_year)) $c_year=1;
    $sql="select * from school_class where year=$sel_year and semester=$sel_seme and c_year=$c_year";
    $rs=$CONN->Execute($sql);
    $option="<option value=''>��ܯZ��</option>\n";
    $i=0;
    while (!$rs->EOF) {
        $c_name[$i]=$rs->fields["c_name"];
        $c_sort[$i]=$rs->fields["c_sort"];
        $i++;
        $rs->MoveNext();
    }
    $c_name=deldup($c_name);
    $c_sort=deldup($c_sort);
    for($i=0;$i<count($c_name);$i++){
        $selected=($id==$c_sort[$i])?"selected":"";
        $option.="<option value='$c_sort[$i]' $selected>".$c_name[$i]."�Z</option>\n";
    }
    $select_school_class_name="<select name='$col_name'>$option</select>";
	//return $select_school_class_name;
    return $option;
}

//���եثe�Ӧ~�ŸӯZ�ťثe�w�����q���Z�����
function &select_stage($c_year,$c_name,$id,$col_name,$sel_year,$sel_seme){
    global $CONN,$score_semester;
    $sql="select class_id from school_class where year=$sel_year and semester=$sel_seme and c_year=$c_year and c_sort=$c_name";
    $rs=$CONN->Execute($sql);
    $class_id=$rs->fields["class_id"];
    $sql="select * from $score_semester where class_id='$class_id' order by test_sort";
    $rs=&$CONN->Execute($sql);
    $i=0;
    if(is_object($rs)){
        while (!$rs->EOF) {
            $test_sort[$i]=$rs->fields["test_sort"];
            $i++;
            $rs->MoveNext();
        }
        $test_sort=deldup($test_sort);
        $option="<option value=''>��ܶ��q���Z</option>\n";
        for($i=0;$i<=count($test_sort);$i++){
            $selected=($id==$test_sort[$i])?"selected":"";
            //$selectedd=($id=="255")?"selected":"";
            //$test_sort_name[$i]=$test_sort[$i];
            if($test_sort[$i]==255) $test_sort_name[$i]="���Ǵ�";
            else $test_sort_name[$i]="��".$test_sort[$i]."���q";
            if($i<count($test_sort)) $option.="<option value='$test_sort[$i]' $selected>".$test_sort_name[$i]."</option>\n";
            //if($i==count($test_sort)){
                //if(count($test_sort)!=0){
                    //$option.="<option value='255' $selectedd>���Ǵ�</option>";
                //}
            //}
        }
        if (!in_array("255", $test_sort)) $option.="<option value='255' $selected>���Ǵ�</option>\n";
    }
    else{
        $option="<option $selectedd>�|�L���</option>";
    }
    return $option;
}

//���եثe�Ӧ~�ŸӯZ�ťثe�w�����q���Z�����
function &select_stage1($c_year,$c_name,$id,$col_name,$sel_year,$sel_seme){
    global $CONN,$score_semester;
    $sql="select class_id from school_class where year=$sel_year and semester=$sel_seme and c_year=$c_year and c_sort=$c_name";
    $rs=$CONN->Execute($sql);
    $class_id=$rs->fields["class_id"];
    $sql="select * from $score_semester where class_id='$class_id'";
    $rs=&$CONN->Execute($sql);
    $i=0;
    while (!$rs->EOF) {
        $test_sort[$i]=$rs->fields["test_sort"];
        $i++;
        $rs->MoveNext();
    }
    $test_sort=deldup($test_sort);
    $option="<option value=''>��ܶ��q</option>\n";
    for($i=0;$i<count($test_sort);$i++){
        $selected=($id==$test_sort[$i])?"selected":"";
        $option.="<option value='$test_sort[$i]' $selected>��".$test_sort[$i]."���q</option>\n";
    }

    return $option;
}

//�n�J�Ѯv�ثe���Ҫ��Z�ŻP��ت����
function &select_teacher_ss($id,$col_name,$teacher_id,$sel_year,$sel_seme){
    global $CONN;
    //echo $id." ".$col_name." ".$teacher_id." ".$sel_year." ".$sel_seme;
/***************************************************************************************/
//  �Nteacher_id �ন teacher_sn
    $sql="select teacher_sn from teacher_base where teach_id='$teacher_id'";
    $rs=$CONN->Execute($sql) or die($sql);
    $teacher_sn = $rs->fields["teacher_sn"];

    //�P�_�O�X�~�X�Z���ɮv
    $sql_class_num="select class_num from teacher_post where teacher_sn='$teacher_sn'";
    $rs_class_num=$CONN->Execute($sql_class_num) or die($sql_class_num);
    $class_num = $rs_class_num->fields["class_num"];
    $class_year=substr($class_num,0,-2);
    $class_name=intval(substr($class_num,-2));
/***************************************************************************************/
    if($class_num){//�O�ɮv
        $sql="select * from score_course where year=$sel_year and semester=$sel_seme and (teacher_sn='$teacher_sn' or (class_year='$class_year' and class_name='$class_name' and allow='0'))";
        $rs=$CONN->Execute($sql) or trigger_error($sql,E_USER_ERROR);
        $option="<option value='0'>��ܯZ�Ŭ��</option>\n";
        $i=0;
        while (!$rs->EOF) {
            $course_id[$i] = $rs->fields["course_id"];
            $class_year = $rs->fields["class_year"];
            $class_name = $rs->fields["class_name"];
            $class_id[$i] = $rs->fields["class_id"];
            $ss_id[$i] = $rs->fields["ss_id"];
            $teacher_sn = $rs->fields["teacher_sn"];
            //�Nsubject_id �ন subject_name
            $sql1="select need_exam from score_ss where ss_id=$ss_id[$i]";
            $rs1=$CONN->Execute($sql1);
            $need_exam = $rs1->fields["need_exam"];            
            if($need_exam==0) $i--;
            $i++;
            $rs->MoveNext();
        }

    }
    else{//����Ѯv
        $sql="select * from score_course where year=$sel_year and semester=$sel_seme and teacher_sn='$teacher_sn'";
        $rs=$CONN->Execute($sql) or trigger_error($sql,E_USER_ERROR);
        $option="<option value='0'>��ܯZ�Ŭ��</option>\n";
        $i=0;
        while (!$rs->EOF) {
            $course_id[$i] = $rs->fields["course_id"];
            $class_year = $rs->fields["class_year"];
            $class_name = $rs->fields["class_name"];
            $class_id[$i] = $rs->fields["class_id"];
            $ss_id[$i] = $rs->fields["ss_id"];
            $teacher_sn = $rs->fields["teacher_sn"];

    /***************************************************************************************/
    //  �Nsubject_id �ন subject_name
            $sql1="select need_exam from score_ss where ss_id=$ss_id[$i]";
            $rs1=$CONN->Execute($sql1);
            $need_exam = $rs1->fields["need_exam"];
            if($need_exam==0) $i--;
            $i++;
            $rs->MoveNext();
        }
    }
    if($i==0) trigger_error("�藍�_�I�䤣��z�ҥ��Ъ���ءA�нT�{�Ҫ����ƤW�z���Ъ���ءI",E_USER_ERROR);

    for($k=0;$k<$i;$k++){
        $sql="select course_id from score_course where class_id='$class_id[$k]' and ss_id='$ss_id[$k]'";
        $rs=$CONN->Execute($sql) or die($sql);
        $course_id[$k] = $rs->fields["course_id"];
        $teacher_course[$k]=course_id_to_full_class_name($course_id[$k]);
        $teacher_course[$k].=ss_id_to_subject_name($ss_id[$k]);
    }
    $course_id=deldup($course_id);
    $teacher_course=deldup($teacher_course);
    $aa=$course_id.$teacher_course;
    $bgcolor=array("#E3DBFF","#E2D9FD","#DBD3F6","#D5CDEF","#CDC6E6","#C4BDDC","#C5BEDD","#BCB5D3","#B4ADCA","#ABA5CD");
    for($j=0;$j<count($teacher_course);$j++){
        $rs_tea=$CONN->Execute("select teacher_sn from score_course where course_id='$course_id[$j]'");
        $teacher_sn[$j]=$rs_tea->fields['teacher_sn'];
        $color[$j]=($teacher_sn[$j]==$_SESSION['session_tea_sn'])?"#000000":"#F71CFF";
        $selected=($id==$course_id[$j])?"selected":"";
        $option.="<option value='$course_id[$j]'  style='background-color: $bgcolor[$j]; color:$color[$j]' $selected >".trim($teacher_course[$j])."</option>\n";
    }

    $select_teacher_ss="<select name='$col_name'>$option</select>";
	$select_teacher_ss_1="$option";
	return $select_teacher_ss_1;
}

//
function select_teacher_course_id($id,$col_name,$teacher_id,$sel_year,$sel_seme){
    global $CONN;

/***************************************************************************************/
//  �Nteacher_id �ন teacher_sn
    $sql="select teacher_sn from teacher_base where teach_id=$teacher_id";
    $rs=$CONN->Execute($sql);
    $teacher_sn = $rs->fields["teacher_sn"];
/***************************************************************************************/

    $sql="select * from score_course where year=$sel_year and semester=$sel_seme and teacher_sn=$teacher_sn";
    $rs=$CONN->Execute($sql);
	$option="<option value='0'>��ܯZ�Ŭ��</option>\n";
        $i=0;
	while (!$rs->EOF) {
		$course_id[$i] = $rs->fields["course_id"];
        $class_year = $rs->fields["class_year"];
        $class_name = $rs->fields["class_name"];
        $class_id[$i] = $rs->fields["class_id"];
        $ss_id[$i] = $rs->fields["ss_id"];
        $teacher_sn = $rs->fields["teacher_sn"];

/***************************************************************************************/
//  �Nsubject_id �ন subject_name
        $sql1="select need_exam from score_ss where ss_id=$ss_id[$i]";
        $rs1=$CONN->Execute($sql1);
        $need_exam = $rs1->fields["need_exam"];
        if($need_exam==0) $i--;
        $i++;
        $rs->MoveNext();
    }
    for($k=0;$k<$i;$k++){
        $sql="select course_id from score_course where class_id='$class_id[$k]' and ss_id='$ss_id[$k]'";
        $rs=$CONN->Execute($sql) or die($sql);
        $course_id[$k] = $rs->fields["course_id"];
        //echo $course_id[$k];
        $teacher_course[$k]=course_id_to_full_class_name($course_id[$k]);
        $teacher_course[$k].=ss_id_to_subject_name($ss_id[$k]);
    }
    $course_id=deldup($course_id);
	return $course_id;
}


//�@�Ӥ����Ӱ}�C�A�M��h�����ƪ��Ȫ����
function  deldup($a){

        $i=count($a);
        for  ($j=0;$j<=$i;$j++){
                      for  ($k=0;$k<$j;$k++){
                                    if($a[$k]==$a[$j]){
                                            $a[$j]="";
                                    }
                      }
        }
        $q=0;
        for($r=0;$r<=$i;$r++){
                      if($a[$r]!=""){
                                      $d[$q]=$a[$r];
                                      $q++;
                      }
          }

return  $d;
}

//�@�Ӥ����Ӱ}�C�A�M��h�����ƪ��Ȫ����
function  delarray($a,$b){

                for($i=0;$i<count($a);$i++){
                            for($j=0;$j<count($b);$j++){
                                          if  ($a[$i]==$b[$j])  $a[$i]="";
                            }
                  }
                            $q=0;
                            for($r=0;$r<=$i;$r++){
                                                if($a[$r]!=""){
                                                                  $d[$q]=$a[$r];
                                                                  $q++;
                                                }
                              }
                      return  $d;
}


//��X�o�ӭȬO�}�C���ĴX�j���Aa�O�@�ӼơAb�O�@�Ӱ}�C
function  how_big($a,$b){
    $sort=1;
    for($i=0;$i<count($b);$i++){
        if($a<$b[$i]) $sort++;
    }
    return  $sort;
}


//��subject_id��X��ئW�٪����
function  subject_id_to_subject_name($subject_id){
    global $CONN;
    $sql1="select subject_name from score_subject where subject_id=$subject_id and enable=1";
    $rs1=$CONN->Execute($sql1);
    $subject_name = $rs1->fields["subject_name"];
    return $subject_name;
}

//��ss_id��X��ئW�٪����
function  ss_id_to_subject_name($ss_id){
    global $CONN;
    $sql1="select subject_id from score_ss where ss_id=$ss_id";
    $rs1=$CONN->Execute($sql1);
    $subject_id = $rs1->fields["subject_id"];
    if($subject_id!=0){
        $sql2="select subject_name from score_subject where subject_id=$subject_id";
        $rs2=$CONN->Execute($sql2);
        $subject_name = $rs2->fields["subject_name"];
    }
    else{
        $sql3="select scope_id from score_ss where ss_id=$ss_id";
        $rs3=$CONN->Execute($sql3);
        $scope_id = $rs3->fields["scope_id"];
        $sql4="select subject_name from score_subject where subject_id=$scope_id";
        $rs4=$CONN->Execute($sql4);
        $subject_name = $rs4->fields["subject_name"];
    }
    return $subject_name;
}

//��ss_id��X���W�٪����
function  ss_id_to_scope_name($ss_id){
    global $CONN;
        $sql3="select scope_id from score_ss where ss_id=$ss_id";
        $rs3=$CONN->Execute($sql3);
        $scope_id = $rs3->fields["scope_id"];
        $sql4="select subject_name from score_subject where subject_id=$scope_id";
        $rs4=$CONN->Execute($sql4);
        $scope_name = $rs4->fields["subject_name"];

    return $scope_name;
}
//��stud_id��X�ǥͪ��m�W
function  stud_id_to_stud_name($stud_id){
    global $CONN;
    $rs=&$CONN->Execute("select  stud_name  from  stud_base where stud_id='$stud_id'");
    $stud_name=$rs->fields['stud_name'];
    return $stud_name;
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

//�ӾǸ����ǥͥثe�b�Ǫ��A
function stud_id_live($stud_id){
	global $CONN;
	$sql="select stud_study_cond from stud_base where stud_id='$stud_id' ";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$stud_study_cond=$rs->fields['stud_study_cond'];
	if($stud_study_cond=="") return 0;
	elseif($stud_study_cond>0) return 0;
	else return 1;
}
?>
