<?php

// $Id: my_fun.php 5463 2009-04-27 13:34:45Z brucelyc $

function  stage_score($id,$col_name,$year="",$semester="",$year_name,$me,$scope_subject){
    global $CONN;
    if(empty($year))$year = curr_year(); //�ثe�Ǧ~
    if(empty($semester))$semester = curr_seme(); //�ثe�Ǵ�
    $option="<option value=''>��ܶ��q���Z</option>\n";
    //���X���Z���W��
    $A=explode("_",$scope_subject);
    $ss_id=$A[0];
    $print=$A[1];
    if($print!=1){
        $selected=($id=="all")?"selected":"";
        $option.="<option value='all' $selected>�`���Z</option>";
    }
    else{
        $sql="select * from score_setup where year='$year' and semester='$semester' and class_year='$year_name' and enable=1";
        $rs=$CONN->Execute($sql);
        $performance_test_times=$rs->fields["performance_test_times"];
        $setup_id=$rs->fields["setup_id"];
        for($i=0;$i<$performance_test_times;$i++){
            $j=$i+1;
            $selected=($id==$j)?"selected":"";
            $option.="<option value='$j' $selected>��".$j."���q</option>";
        }
    }
    return $option;

}

//�Ǧ^�Y�@�Ǧ~�Y�@�Ǵ��Y�@�Ӧ~�Ū��Ҧ��ҵ{
function  scope_subject($id,$col_name,$year="",$semester="",$class_year){
    global $CONN;
    if(empty($year))$year = curr_year(); //�ثe�Ǧ~
    if(empty($semester))$semester = curr_seme(); //�ثe�Ǵ�
    $option="<option value=''>��ܬ��</option>\n";
    $sql1="select subject_id,print,ss_id,scope_id from score_ss where year='$year' and semester='$semester' and  class_year='$class_year' and enable=1 and need_exam=1";
    $rs1=$CONN->Execute($sql1) or die($sql1);
    $i=0;
    while(!$rs1->EOF){
        $subject_id[$i] = $rs1->fields["subject_id"];
        $print[$i] = $rs1->fields["print"];
        if($print[$i]=="") $print[$i]=0;
        $ss_id[$i] = $rs1->fields["ss_id"];
        $scope_id[$i] = $rs1->fields["scope_id"];
        if($subject_id[$i]=="0") $subject_id[$i] = $scope_id[$i];
        $rs2=$CONN->Execute("select subject_name from score_subject where subject_id='$subject_id[$i]'");
        $subject_name[$i] = $rs2->fields["subject_name"];
        $ss_id_print[$i]=$ss_id[$i]."_".$print[$i];
        $selected=($id==$ss_id_print[$i])?"selected":"";
        $option.="<option value='$ss_id_print[$i]' $selected>$subject_name[$i]</option>";
        $i++;
        $rs1->MoveNext();
    }
    if($i==0) trigger_error("�藍�_�I�z�|���]�w�ҵ{�I",E_USER_ERROR);
    return $option;
}

//���եثe�Ǧ~�P�Ǵ��U�Ԧ����
function select_year_seme($id,$col_name){
    global $CONN;
    $sql="select * from school_class order by year,semester";
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
function select_school_class($id,$col_name,$sel_year,$sel_seme){
    global $CONN;
    $sql="select distinct c_year from school_class where year=$sel_year and semester=$sel_seme order by year,semester,c_year";
    $rs=$CONN->Execute($sql);
    $school_kind_name=array("���X��","�@�~","�G�~","�T�~","�|�~","���~","���~","�@�~","�G�~","�T�~","�@�~","�G�~","�T�~");
    $option="<option value=''>��ܦ~��</option>\n";
    $i=0;
    while (!$rs->EOF) {
        $c_year[$i]=$rs->fields["c_year"];
        $i++;
        $rs->MoveNext();
    }
    if($i==0) trigger_error("�藍�_�I�z�|���]�w�Z�šI",E_USER_ERROR);
    for($i=0;$i<count($c_year);$i++){
        $selected=($id==$c_year[$i])?"selected":"";
        $option.="<option value='$c_year[$i]' $selected>".$school_kind_name[$c_year[$i]]."��</option>\n";
    }
    $select_school_class="<select name='$col_name'>$option</select>";
	//return $select_school_class;
    return $option;
}

//���եثe�Ӧ~�Ū��Ҧ��Z�ŤU�Ԧ����
function select_school_class_name($c_year,$id,$col_name,$sel_year,$sel_seme){
    global $CONN;
    if(empty($c_year)) $c_year=1;
    $sql="select distinct c_name,c_sort from school_class where year=$sel_year and semester=$sel_seme and c_year=$c_year order by year,semester,c_year,c_sort";
    $rs=$CONN->Execute($sql);
    $option="<option value=''>��ܯZ��</option>\n";
    $i=0;
    while (!$rs->EOF) {
        $c_name[$i]=$rs->fields["c_name"];
        $c_sort[$i]=$rs->fields["c_sort"];
        $i++;
        $rs->MoveNext();
    }
    if($i==0) trigger_error("�藍�_�I�z�|���]�w�Z�šI",E_USER_ERROR);
    for($i=0;$i<count($c_name);$i++){
        $selected=($id==$c_sort[$i])?"selected":"";
        $option.="<option value='$c_sort[$i]' $selected>".$c_name[$i]."�Z</option>\n";
    }
    $select_school_class_name="<select name='$col_name'>$option</select>";
	//return $select_school_class_name;
    return $option;
}

//���եثe�Ӧ~�ŸӯZ�ťثe�w�����q���Z�����
function select_stage($c_year,$c_name,$id,$col_name,$sel_year,$sel_seme){
    global $CONN,$score_semester;
    $sql="select class_id from school_class where year=$sel_year and semester=$sel_seme and c_year=$c_year and c_sort=$c_name";
    $rs=$CONN->Execute($sql);
    $class_id=$rs->fields["class_id"];
    $sql="select * from $score_semester where class_id='$class_id'";
//091_1_01_01
    $err_arr = explode ("_",$class_id);
    $err_str = sprintf("%d �Ǧ~�� %d �Ǵ� ���ɦ��Z�|���إ�!!",$err_arr[0],$err_arr[1]);
    $rs=&$CONN->Execute($sql)or trigger_error($err_str, E_USER_ERROR);
    $i=0;
    while (!$rs->EOF) {
        $test_sort[$i]=$rs->fields["test_sort"];
        $i++;
        $rs->MoveNext();
    }
    $test_sort=deldup($test_sort);
    $option="<option value=''>��ܶ��q���Z</option>\n";
    for($i=0;$i<=count($test_sort);$i++){
        $selected=($id==$test_sort[$i])?"selected":"";
        $selectedd=($id=="all")?"selected":"";
        if($i<count($test_sort)) $option.="<option value='$test_sort[$i]' $selected>��".$test_sort[$i]."���q</option>\n";
        if($i==count($test_sort)){
            if(count($test_sort)!=0){
                $option.="<option value='all' $selectedd>���Ǵ�</option>";
            }
        }
    }

    return $option;
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

//�Z�žǥͿ��
function get_stud_select($class_id, $stud_id="",$name="stud_id",$jump_fn="",$size=""){

	if (!$class_id) user_error("�S���ǤJ�Z�ťN�X�I���ˬd�I",256);

	//���o�ǥ͸�ư}�C
	$c=class_id_2_old($class_id);
	$stud=get_stud_array($c[0],$c[1],$c[3],$c[4],"id","name");
	if(empty($size))$size=sizeof($stud);
	if(empty($stud))return "�L�ǥ͸��";

	//�[�Jjava���
	$jump=(!empty($jump_fn))?" onChange='$jump_fn()'":"";

	//�s�@�Z�ſ��
	$select_option="<option value='0'>��ܾǥ�</option>\n";
	while(list($k,$v)=each($stud)){
		$selected=($stud_id==$k)?"selected":"";
		$select_option.="<option value='$k' $selected>$v</option>\n";
	}
	$select_stud="<select name='$name' size='$size' $jump>
	$select_option
	</select>";
	return $select_stud;
}

//���o�Y�Z�ǥͰ}�C�A�Ǧ^$stu[$k]=$v
//$k�M$v���ȥi�H�O id=�Ǹ��Asn=�y�����Aname=�m�W�Asex=�ʧO�Anum=�y��
function get_stud_array($year=0,$seme=0,$Cyear=0,$Cnum=0,$k="id",$v="name"){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$year=(empty($year))?curr_year():$year*1;
	$seme=(empty($seme))?curr_seme():$seme*1;
	$str=array("id"=>"stud_id","sn"=>"student_sn","name"=>"stud_name","sex"=>"stud_sex","num"=>"right(curr_class_num,2)");

	$stud_year=(strlen($year)==2)?"0".$year.$seme:$year.$seme;
	$class_num=$Cyear*100+$Cnum;

	// init $stu
	$stu=array();

	$sql_select = "select  stud_base.$str[$k],stud_base.$str[$v] from stud_base,stud_seme where stud_base.stud_id=stud_seme.stud_id and  stud_seme.seme_year_seme='$stud_year' and stud_seme.seme_class='$class_num' and stud_study_cond=0 order by stud_seme.seme_num";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(list($k, $v) = $recordSet->FetchRow()){
		$stu[$k]=$v;
	}
	return $stu;
}

function year_seme_menu($sel_year,$sel_seme) {
	global $CONN;

	$sql="select year,semester from school_class where enable='1' order by year,semester";
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
	return $scys->get_select();
}

function seme_menu($start_year,$id) {
	global $CONN,$IS_JHORES;

	$s_y=$start_year;
	$e_y=($IS_JHORES=="6")?"2":"5";
	$e_y+=$s_y;
	$query="select * from school_class where year >= '$s_y' and year <= '$e_y' order by year,semester";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$temp_arr[$res->fields["year"]."_".$res->fields['semester']]=$res->fields["year"]."�Ǧ~�ײ�".$res->fields['semester']."�Ǵ�";
		$res->MoveNext();
	}
	$scys = new drop_select();
	$scys->s_name ="year_seme";
	$scys->top_option = "��ܾǴ�";
	$scys->id = $id;
	$scys->arr = $temp_arr;
	$scys->is_submit = true;
	return $scys->get_select();
}

function class_year_menu($sel_year,$sel_seme,$id) {
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
	return $scy->get_select();
}

function class_name_menu($sel_year,$sel_seme,$sel_class,$id) {
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
	return $sc->get_select();
}

function stage_menu($sel_year,$sel_seme,$sel_class,$sel_num,$id,$all="") {
	global $CONN,$score_semester,$choice_kind;

	$sql="select class_id from school_class where year='$sel_year' and semester='$sel_seme' and c_year='$sel_class' and c_sort='$sel_num'";
	$rs=$CONN->Execute($sql);
	$class_id=$rs->fields["class_id"];
	if ($all) {
		$class_id=substr($class_id,0,strlen($class_id)-2)."%";
		$sql="select distinct test_sort from $score_semester where class_id like '$class_id' and test_kind = '$choice_kind' and test_sort < '200' order by test_sort";
	} else {
		$sql="select distinct test_sort from $score_semester where class_id='$class_id' order by test_sort";
	}
	$rs=&$CONN->Execute($sql);
	if(is_object($rs)){
		while (!$rs->EOF) {
			$test_sort=$rs->fields["test_sort"];
			if($test_sort<200)	$show_stage[$test_sort]="��".$test_sort."���q";
			$rs->MoveNext();
		}
	}
	$show_stage[255]="���Ǵ�";
	$ss = new drop_select();
	$ss->s_name ="stage";
	$ss->top_option = "��ܶ��q";
	$ss->id = $id;
	$ss->arr = $show_stage;
	$ss->is_submit = true;
	return $ss->get_select();
}

function kind_menu($sel_year,$sel_seme,$sel_class,$sel_num,$stage,$id) {
	global $CONN;
	$show_kind=array("1"=>"�w�����q","2"=>"���ɦ��Z","3"=>"�w��+����");

	$sk = new drop_select();
	$sk->s_name ="kind";
	$sk->top_option = "��ܺ���";
	$sk->id = $id;
	$sk->arr = $show_kind;
	$sk->is_submit = true;
	return $sk->get_select();
}

function stud_menu($sel_year,$sel_seme,$sel_class,$sel_num,$sel_sn) {
	global $CONN;

	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$seme_class=$sel_class.sprintf("%02d",$sel_num);
	$query="select a.*,b.stud_name,b.stud_sex from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class='$seme_class' order by a.seme_num";
	$res=$CONN->Execute($query);
	$temp_arr=array();
	while(!$res->EOF) {
		$temp_arr[$res->fields['student_sn']]=$res->fields['stud_name'];
		$cr_arr[$res->fields['student_sn']]=$res->fields['stud_sex'];
		$res->MoveNext();
	}
	$s = new drop_select();
	$s->s_name ="student_sn";
	$s->top_option = "��ܾǥ�";
	$s->id = $sel_sn;
	$s->arr = $temp_arr;
	//�̩ʧO����C��
	$s->is_display_color = true;
	$s->color_index_arr = $cr_arr;
	$s->color_item = array("black","blue","red");
	$s->is_submit = true;
	return $s->get_select();
}

//�ר�аȳB
function cal_seme_score($sel_year,$sel_seme,$class_id,$ss_id) {
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
	while(!$res->EOF) {
		$temp_sn.="'".$res->fields['student_sn']."',";
		$res->MoveNext();
	}
	$temp_sn=substr($temp_sn,0,-1);
	//�ˬd stud_seme_score �Ǵ����Z���L�O��
	$check_ss=($ss_id)?"and ss_id='$ss_id'":"";
	$all_ss=array();
	$query = "select distinct ss_id from stud_seme_score where seme_year_seme='$seme_year_seme' and student_sn in ($temp_sn) $check_ss";
	$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	while(!$res->EOF){
		$all_ss[]=$res->fields['ss_id'];
		$res->MoveNext();
	}
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
		$temp_sn_seme_arr=substr($temp_sn_seme_arr,0,-1);

		//���N��r�y�z���X
		$rs=$CONN->Execute("select student_sn,ss_score_memo from stud_seme_score where seme_year_seme='$seme_year_seme' and student_sn in ($temp_sn_seme_arr) and ss_id='$ss_id'");
		if ($rs->recordcount()>0)
			while (!$rs->EOF) {
				$val_arr[$rs->fields['student_sn']]=addslashes($rs->fields['ss_score_memo']);
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
					$query = "select student_sn,test_kind,sum(score) as cc from $score_semester where ss_id=$ss_id and class_id='$class_id' and test_sort <= $performance_test_times and score <> '-100' group by student_sn,test_kind ";
				else
					$query = "select student_sn,test_kind,sum(score) as cc from $score_semester where ss_id=$ss_id and class_id='$class_id' and test_sort <= $performance_test_times and score <> '-100' and (test_kind='�w�����q' or test_kind='���ɦ��Z') group by student_sn,test_kind";
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
					$query = "select student_sn,test_kind,test_sort,score from $score_semester where ss_id='$ss_id' and class_id='$class_id' and test_sort<255 ";
				else
					$query = "select student_sn,test_kind,test_sort,score from $score_semester where ss_id='$ss_id' and class_id='$class_id' and (test_kind='�w�����q' or test_kind='���ɦ��Z')";
				$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
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
			while(list($id,$val) = each($score_arr)){
				$query = "replace into stud_seme_score (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo,teacher_sn)values('$seme_year_seme','$id','$ss_id','$val','$val_arr[$id]','$_SESSION[session_tea_sn]')";
				$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			}
		}
		//���Ǵ��@�����Z
		else if ($print==0) {
			//�N���Z��J�Ǵ����Z��
			$score_arr=array();
			$query = "select student_sn,score from $score_semester where ss_id='$ss_id' and class_id='$class_id' and test_sort=255";
			$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			while(!$res->EOF){
				$score_arr[$res->fields['student_sn']]=$res->fields['score'];
				$res->MoveNext();
			}
			reset($score_arr); 
			while(list($sn,$score) = each($score_arr)){
				$query = "replace into stud_seme_score (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo,teacher_sn)values('$seme_year_seme','$sn','$ss_id','$score','$val_arr[$sn]','$_SESSION[session_tea_sn]')";
				$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			}
		}
	}
}
?>
