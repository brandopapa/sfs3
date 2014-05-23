<?php
// $Id: my_fun.php 6587 2011-10-15 10:17:01Z infodaes $


//���o�Ҳճ]�w
$m_arr = &get_module_setup("score_input");
extract($m_arr, EXTR_OVERWRITE);


//��student_sn�o�쥻�Ǵ��ǥͪ��Z�Ůy���m�W
function student_sn_to_classinfo($student_sn){
    global $CONN;
    $rs_sn=$CONN->Execute("select stud_id from stud_base where student_sn='$student_sn'");
    $stud_id=$rs_sn->fields["stud_id"];
    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
    $rs_seme=$CONN->Execute("select seme_class,seme_num from stud_seme where stud_id='$stud_id' and seme_year_seme='$seme_year_seme' order by seme_num ");
    $seme_class=$rs_seme->fields["seme_class"];
    $year= substr($seme_class,0,-2);
    $class= substr($seme_class,-2);
    $site=$rs_seme->fields["seme_num"];
    //echo $year.$class.$site;
    $rs1=&$CONN->Execute("select  stud_name,stud_sex,curr_class_num  from  stud_base where student_sn='$student_sn'");
    $curr_class_num=$rs1->fields['curr_class_num'];
    $stud_sex=$rs1->fields['stud_sex'];
    $stud_name=$rs1->fields['stud_name'];
    //$site= substr($curr_class_num,-2);
    //$class= substr($curr_class_num,-4,2);
    //$year= substr($curr_class_num,0,1);
    settype($site,"integer");
    settype($class,"integer");
    settype($year,"integer");
    settype($stud_sex,"integer");
    $year_class_site_sex=array($year,$class,$site,$stud_sex,$stud_name);
    return $year_class_site_sex;
}

//���եثe�Ӧ~�ŸӯZ�ŸӬ�إثe�w�����q���Z�����
function now_stage($id,$col_name,$teacher_id,$sel_year,$sel_seme,$class_id,$ss_id){
    global $CONN,$yorn;
    
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
	if($yorn=='n'){
		$sd=($id==254)?"selected":"";
		$option.="<option value='254' $sd>���ɦ��Z</option>\n";
	}
    return $option;
}

//���եثe�Ӧ~�ŸӯZ�ŸӬ�إثe�w�����q���Z�����
function Nnow_stage($id,$col_name,$teacher_id,$sel_year,$sel_seme,$class_id,$ss_id){
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

//��student_sn�o��Ӧ�ǥͥ��Ǵ����y��
function student_sn_to_site_num($student_sn){
    global $CONN;
    $rs_sn=$CONN->Execute("select stud_id from stud_base where student_sn='$student_sn'");
    $stud_id=$rs_sn->fields["stud_id"];
    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
    $rs_seme=$CONN->Execute("select seme_num from stud_seme where stud_id='$stud_id' and seme_year_seme='$seme_year_seme'");    
    $site=$rs_seme->fields["seme_num"];
    //$rs1=&$CONN->Execute("select  curr_class_num  from  stud_base where student_sn='$student_sn'");
    //$curr_class_num=$rs1->fields['curr_class_num'];
    //$site_num= substr($curr_class_num,-2);
    settype($site,"integer");
    return $site;
}
//���o���Ǵ��ӯZ�Ҧ��ǥͪ��򥻸��
function class_id_to_student_sn($class_id){
    global $CONN;
    $class_id_array=explode("_",$class_id);
    $class_num=intval($class_id_array[2]).$class_id_array[3];
    $sql="select student_sn from stud_base where stud_study_cond=0 and curr_class_num like '$class_num%' order by curr_class_num ";
    $rs=$CONN->Execute($sql) or trigger_error($sql);;
    while (!$rs->EOF) {
        $student_sn[]=$rs->fields["student_sn"];
        $rs->MoveNext();
    }
    return $student_sn;
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
//��course_id��X�X�~�X�Z
function  course_id_to_full_class_name($course_id){
    global $CONN;
    $select_course_id_sql="select * from score_course where course_id=$course_id";
    $rs_select_course_id=$CONN->Execute($select_course_id_sql);
    $class_id= $rs_select_course_id->fields['class_id'];
    $ss_id= $rs_select_course_id->fields['ss_id'];
    $school_kind_name=array("���X��","�@�~","�G�~","�T�~","�|�~","���~","���~","�@�~","�G�~","�T�~","�@�~","�G�~","�T�~");
    //$full_year_class_name=$school_kind_name[$class_year];
    $sql="select * from school_class where class_id='$class_id'";
    $rs=$CONN->Execute($sql);
    $c_year= $rs->fields['c_year'];
    $c_name= $rs->fields['c_name'];
    $full_year_class_name=$school_kind_name[$c_year];
    $full_year_class_name.=$c_name."�Z";
    return $full_year_class_name;
}

//��class_id��X�X�~�X�Z
function  class_id_to_full_class_name($class_id){
    global $CONN;
    $class_sql="select * from school_class where class_id='$class_id'";
    $rs_class=$CONN->Execute($class_sql);
    $c_year= $rs_class->fields['c_year'];
    $c_name= $rs_class->fields['c_name'];
    $school_kind_name=array("���X��","�@�~","�G�~","�T�~","�|�~","���~","���~","�@�~","�G�~","�T�~","�@�~","�G�~","�T�~");
    $full_year_class_name=$school_kind_name[$c_year];
    $full_year_class_name.=$c_name."�Z";
    return $full_year_class_name;
}

//��student_sn��X�ǥͪ��m�W
function  student_sn_to_stud_name($student_sn){
    global $CONN;
    $rs=&$CONN->Execute("select  stud_name  from  stud_base where student_sn='$student_sn'");
    $stud_name=$rs->fields['stud_name'];
    return $stud_name;
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
//�O�_�C�@����ҭn�t�X�@�����ɦ��Z
function  findyorn(){
	global $CONN;
	$rs_yorn=$CONN->Execute("SELECT pm_value FROM pro_module WHERE pm_name='score_input' AND pm_item='yorn'");
	$yorn=$rs_yorn->fields['pm_value'];
	return $yorn;
}

function year_seme_menu($sel_year,$sel_seme,$other_script="") {
	global $CONN;

	$sql="select year,semester from school_class where enable='1' order by year desc,semester";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$year=$rs->fields["year"];
		$semester=$rs->fields["semester"];
		if ($year!=$oy || $semester!=$os)
			$show_year_seme[$year."_".$semester]=$year."�Ǧ~�ײ�".$semester."�Ǵ�";
		$oy=$year;
		$os=$semester;
		$rs->MoveNext();
	}
	$scys = new drop_select();
	$scys->s_name ="year_seme";
	$scys->top_option = "��ܾǴ�";
	$scys->id = $sel_year."_".$sel_seme;
	$scys->arr = $show_year_seme;
	$scys->is_submit = true;
	$scys->other_script = $other_script;
	return $scys->get_select();
}

function class_year_menu($sel_year,$sel_seme,$id,$other_script="") {
	global $school_kind_name,$CONN;

	$sql="select distinct c_year from school_class where year='$sel_year' and semester='$sel_seme' and enable='1' order by c_year";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$show_year_name[$rs->fields["c_year"]]=$school_kind_name[$rs->fields["c_year"]]."��";
		$rs->MoveNext();
	}
	$scy = new drop_select();
	$scy->s_name ="year_name";
	$scy->top_option = "��ܦ~��";
	$scy->id = $id;
	$scy->arr = $show_year_name;
	$scy->is_submit = true;
	$scy->other_script = $other_script;
	return $scy->get_select();
}

function class_name_menu($sel_year,$sel_seme,$sel_class,$id,$other_script="") {
	global $CONN;

	$sql="select distinct c_name,c_sort from school_class where year='$sel_year' and semester='$sel_seme' and c_year='$sel_class' and enable='1' order by c_sort";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$show_class_year[$rs->fields["c_sort"]]=$rs->fields["c_name"]."�Z";
		$rs->MoveNext();
	}
	$sc = new drop_select();
	$sc->s_name ="me";
	$sc->top_option = "��ܯZ��";
	$sc->id = $id;
	$sc->arr = $show_class_year;
	$sc->is_submit = true;
	$sc->other_script = $other_script;
	return $sc->get_select();
}

function stage_menu($sel_year,$sel_seme,$sel_class,$sel_num,$id,$all="",$other_script="") {
	global $CONN,$score_semester,$choice_kind,$yorn;

	$sql="select class_id from school_class where year='$sel_year' and semester='$sel_seme' and c_year='$sel_class' and c_sort='$sel_num'";
	$rs=$CONN->Execute($sql);
	$class_id=$rs->fields["class_id"];
	if ($all) {
		$class_id=substr($class_id,0,strlen($class_id)-2)."%";
		$sql="select distinct test_sort from $score_semester where class_id like '$class_id' and test_sort < '200' order by test_sort";
	} else {
		$sql="select distinct test_sort from $score_semester where class_id='$class_id' order by test_sort";
	}
	$rs=$CONN->Execute($sql);
	if(is_object($rs)){
		while (!$rs->EOF) {
			$test_sort=$rs->fields["test_sort"];
			if($test_sort<200)	$show_stage[$test_sort]="��".$test_sort."���q";
			$rs->MoveNext();
		}
	}
	if ($yorn=="n") $show_stage["254"]="���ɦ��Z";
	$rs=$CONN->Execute("select distinct print from score_ss where class_year='$sel_class' and enable='1' and need_exam='1' and print!='1'");
	if ($rs->recordcount()>0) $show_stage["255"]="�������q";
	$ss = new drop_select();
	$ss->s_name ="stage";
	$ss->top_option = "��ܶ��q";
	$ss->id = $id;
	$ss->arr = $show_stage;
	$ss->is_submit = true;
	$ss->other_script = $other_script;
	return $ss->get_select();
}

function kind_menu($sel_year,$sel_seme,$sel_class,$sel_num,$stage,$id) {
	global $CONN;
	$show_kind=array("1"=>"�w�����q","2"=>"���ɦ��Z","3"=>"�w��+����","4"=>"�w���F����");

	$sk = new drop_select();
	$sk->s_name ="kind";
	$sk->top_option = "��ܺ���";
	$sk->id = $id;
	$sk->arr = $show_kind;
	$sk->is_submit = true;
	return $sk->get_select();
}

function score_head($sel_year,$sel_seme,$year_name,$me,$stage,$chart_kind){
    global $CONN,$school_kind_name;
    $rs1=&$CONN->Execute("select * from school_base");
    $sch_sheng=$rs1->fields['sch_sheng'];
    $sch_cname=$rs1->fields['sch_cname'];
    if(strlen($sel_year)==2) $sel_year="0".$sel_year;
    if(strlen($year_name)==1) $year_name="0".$year_name;
    if(strlen($me)==1) $me="0".$me;
    $class_id=$sel_year."_".$sel_seme."_".$year_name."_".$me;
    $rs2=&$CONN->Execute("select * from school_class where class_id='$class_id'");
    $c_year=$rs2->fields['c_year'];
    $c_name=$rs2->fields['c_name'];
    settype($sel_year,"integer");
    $stage_name=array(1=>"�Ĥ@���q",2=>"�ĤG���q",3=>"�ĤT���q",4=>"�ĥ|���q","all"=>"���Ǵ�");
    return $sch_cname.$sel_year."�Ǧ~�ײ�".$sel_seme."�Ǵ�".$school_kind_name[$c_year].$c_name."�Z".$stage_name[$stage].$chart_kind."���Z��";
}

//�ר�аȳB
function seme_score_input($sel_year,$sel_seme,$class_id,$ss_id) {
	global $CONN,$now,$yorn;
	//�Ǵ���ƪ�W��
	$score_semester="score_semester_".$sel_year."_".$sel_seme;
	$seme_year_seme = sprintf("%03d",$sel_year).$sel_seme;
	$temp_class_id_arr=explode("_",$class_id);
	//�N�Z�Ŧr���ର�}�C
	$class_arr=class_id_2_old($class_id);
	$query = "select performance_test_times,score_mode,test_ratio from score_setup where class_year=$class_arr[3] and year='$sel_year' and semester='$sel_seme' and enable='1'";
	$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	//���禸��
	$performance_test_times = $res->fields[performance_test_times];
	//���Z�t����Ҭ����]�w
	$score_mode = $res->fields[score_mode];
	//��v
	$test_ratios = $res->fields[test_ratio];
	 //��v����
        if($score_mode=="all"){
       	        $test_ratio=explode("-",$test_ratios);
	}
	//�C���q���q���O���P��v
	elseif($score_mode=="severally"){
		$temp_arr=explode(",",$test_ratios);
		reset($temp_arr);
		while(list($id,$val) = each($temp_arr)){
			$test_ratio_temp=explode("-",$val);
			$test_ratio[$id][0]=$test_ratio_temp[0];
			$test_ratio[$id][1]=$test_ratio_temp[1];
		}
	}else{
		$test_ratio[0]=60;
		$test_ratio[1]=40;
	}

	//�����X�ǥ͸��
	$seme_class=intval($temp_class_id_arr[2]).$temp_class_id_arr[3];
	$query = "select student_sn from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$seme_class'";
	$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	$temp_sn="";
	while(!$res->EOF) {
		$temp_sn.="'".$res->fields['student_sn']."',";
		$res->MoveNext();
	}
	if ($temp_sn) $temp_sn=substr($temp_sn,0,-1);
	//�ˬd stud_seme_score �Ǵ����Z���L�O��
	$check_ss=($ss_id)?"and ss_id='$ss_id'":"";
	$all_ss=array();
	$query = "select ss_id from score_ss where year='$sel_year' and semester='$sel_seme' and class_id='$class_id' and enable='1' $check_ss";
	$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	if ($res->fields[ss_id]=="") {
		$query = "select ss_id from score_ss where year='$sel_year' and semester='$sel_seme' and class_id='' and enable='1' $check_ss";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	}
	while(!$res->EOF){
		$all_ss[]=$res->fields['ss_id'];
		$res->MoveNext();
	}
	reset($all_ss);
	while(list($k,$ss_id)=each($all_ss)){
		$query = "select print from score_ss where ss_id='$ss_id'";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$print=$res->fields['print'];
		$temp_sn_seme_arr = "";
		$query = "select student_sn from stud_seme_score where ss_id='$ss_id' and seme_year_seme='$seme_year_seme' and student_sn in($temp_sn)";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		while(!$res->EOF){
			$temp_sn_seme_arr.="'".$res->fields[0]."',";
			$res->MoveNext();
		}
		if ($temp_sn_seme_arr) $temp_sn_seme_arr=substr($temp_sn_seme_arr,0,-1);

		//���N��r�y�z���X
		$rs=$CONN->Execute("select student_sn,ss_id,ss_score_memo from stud_seme_score where seme_year_seme='$seme_year_seme' and student_sn in ($temp_sn_seme_arr) and ss_id='$ss_id'");
		if ($rs->fields['student_sn'])
			while (!$rs->EOF) {
				$val_arr[$rs->fields['student_sn']][$rs->fields['ss_id']]=addslashes($rs->fields['ss_score_memo']);
				$rs->MoveNext();
			}

		//���q���Z ���ɦ��Z
		if ($print==1) {

			//�p�G�C�Ǵ��u�]�w�@���Ǵ����ɦ��Z�B�C���q���q��v�Ҥ��P��,��v�� 100 - �U���q���q��v
			if ($yorn =='n' and $score_mode=="severally"){
				$temp_ratio=0;
				for($i=0;$i<$performance_test_times;$i++) $temp_ratio += $test_ratio[$i][0];
				$temp_ratio = (100-$temp_ratio);
			}

			//�p��Ǵ����Z
			//���Ǵ����O�@�س]�w
			if($score_mode=="all"){
				if($yorn =='y')
					$query = "select student_sn,test_kind,sum(score) as cc from $score_semester where ss_id='$ss_id' and student_sn in($temp_sn) and test_sort <= $performance_test_times and score <> '-100' group by student_sn,test_kind ";
				else
					$query = "select student_sn,test_kind,sum(score) as cc from $score_semester where ss_id='$ss_id' and student_sn in($temp_sn) and test_sort <= $performance_test_times and score <> '-100' and (test_kind='�w�����q' or test_kind='���ɦ��Z') group by student_sn,test_kind";
//				echo $query."<BR>";
				$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
				$score_arr = array();
				$test_ratio_1  = $test_ratio[0]/100;
				$test_ratio_2  = $test_ratio[1]/100;

				while(!$res->EOF){
					$student_sn = $res->fields[student_sn];
					$test_kind = $res->fields[test_kind];
					$score = $res->fields[cc];
					if ($score=='') $score=0;
					if ($test_kind == "�w�����q")
						$cc = ($score/$performance_test_times)*$test_ratio_1;
					else
						$cc = $score * $test_ratio_2 / $performance_test_times;
//					echo "$student_sn --  $test_kind -- $test_ratio_1 --  $test_ratio_2 -- $cc <BR>";
					$score_arr[$student_sn] += $cc;
					$res->MoveNext();
				}
			}
			//�C�����q�����P�]�w
			else {
				if ($yorn=='y')
					$query = "select student_sn,test_kind,test_sort,score from $score_semester where ss_id='$ss_id' and student_sn in($temp_sn) and test_sort<255 ";
				else
					$query = "select student_sn,test_kind,test_sort,score from $score_semester where ss_id='$ss_id' and student_sn in($temp_sn) and (test_kind='�w�����q' or test_kind='���ɦ��Z')";
				$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
				$score_arr=array();
				while(!$res->EOF){
					$test_sort = $res->fields[test_sort];
					$student_sn = $res->fields[student_sn];
					$test_kind = $res->fields[test_kind];
					$score = $res->fields[score];
					if ($score=="-100") $score=0;
					$id = $test_sort-1;
					if ($test_kind=='�w�����q')
						$cc = $score*$test_ratio[$id][0]/100;
	                                else
						$cc = $score*$test_ratio[$id][1]/100;
					$score_arr[$student_sn] += $cc;
					$res->MoveNext();
				}
			}
			//�N���Z��J�Ǵ����Z��
			reset($score_arr);
			while(list($id,$val) = each($score_arr)){
				$query = "replace into stud_seme_score (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo,teacher_sn)values('$seme_year_seme','$id','$ss_id','$val','".$val_arr[$id][$ss_id]."','$_SESSION[session_tea_sn]')";
				$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			}
		}
		//���Ǵ��@�����Z
		else if ($print==0) {
			//�N���Z��J�Ǵ����Z��
			$score_arr=array();
			$query = "select student_sn,score from $score_semester where ss_id='$ss_id' and student_sn in($temp_sn) and test_sort=255";
			$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			while(!$res->EOF){
				$score_arr[$res->fields['student_sn']]=$res->fields['score'];
				$res->MoveNext();
			}
			reset($score_arr); 
			while(list($sn,$score) = each($score_arr)){
				$query = "replace into stud_seme_score (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo,teacher_sn)values('$seme_year_seme','$sn','$ss_id','$score','".$val_arr[$sn][$ss_id]."','$_SESSION[session_tea_sn]')";
				$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			}
		}
	}
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
?>
