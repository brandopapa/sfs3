<?php
// $Id: sfs_case_score.php 8596 2015-11-19 02:21:51Z qfon $

//��student_sn�Mss_id��X�ӥͦ��쪺�Ǵ��`���Z
function seme_score($student_sn,$ss_id,$sel_year="",$sel_seme=""){
  	global $CONN;

	if (!$student_sn) user_error("�S���ǤJ�ǥͥN�X�I���ˬd�I",256);
	if (!$ss_id) user_error("�S���ǤJ��ءI���ˬd�I",256);

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

    if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
    if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

    $ratio=test_ratio($sel_year,$sel_seme);
    //$score=edu_score($student_sn,$ss_id,$test_sort,$sel_year,$sel_seme);

    //�Ѿǥͪ��y�����d�X�O�X�~�Ū�
    //$rs_curr_class_num=$CONN->Execute("select curr_class_num from stud_base where student_sn='$student_sn'") or user_error("Ū�����ѡI",256);
    $seme_year_seme=sprintf("%03d%d",$sel_year,$sel_seme);
	$rs_seme_class=$CONN->Execute("select seme_class from stud_seme where student_sn='$student_sn' and seme_year_seme='$seme_year_seme' ") or user_error("Ū�����ѡI",256);
    //echo "select seme_class from stud_seme where student_sn='$student_sn' and seme_year_seme='$seme_year_seme' ";
	$class_year=substr($rs_seme_class->fields['seme_class'],0,-2);

    $rs_times=$CONN->Execute("select performance_test_times from score_setup where year='$sel_year' and semester='$sel_seme' and class_year='$class_year'") or user_error("Ū�����ѡI",256);

   //echo "select performance_test_times from score_setup where year='$sel_year' and semester='$sel_seme' and class_year='$class_year'";
	$performance_test_times=  $rs_times->fields['performance_test_times'];

    for($j=1;$j<=$performance_test_times;$j++){
        $test_sort=$j;
        $test_sort_A=$j-1;
        //�Ӷ��q����v
        $ratio_plus= ($ratio[$class_year][$test_sort_A][0]+$ratio[$class_year][$test_sort_A][1])/100;
        //echo $class_year.$test_sort_A;
		//echo $ratio[$class_year][$test_sort_A][0]." + ".$ratio[$class_year][$test_sort_A][1]." = ".$ratio_plus."<br>";
        //�Ӷ��q������
        //$stage_score=$score[$student_sn][$ss_id][$test_sort]*$ratio_plus;
		$stage_score=edu_score($student_sn,$ss_id,$test_sort,$sel_year,$sel_seme)*$ratio_plus;
		//echo $score[$student_sn][$ss_id][$test_sort]." * ".$ratio_plus." = ".$stage_score."<br>";
        //��Ǵ�������
        $seme_score=$seme_score+$stage_score;
    }

    return $seme_score;
}

//�Ѹ�Ʈw���o�`���Z
function seme_score2($student_sn,$ss_id,$sel_year="",$sel_seme=""){
	global $CONN;
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	$query = "select ss_score from stud_seme_score where seme_year_seme = '$seme_year_seme' and ss_id=$ss_id and student_sn='$student_sn'";
	//echo $query."<br>";
	$res = $CONN->Execute($query);
	if ($res->EOF)
		return -1;
	else
		return $res->fields[0];
}

//�ഫ���Z�ҤA���B�����G
function score2str($score="",$class=array(),$rule){
	global $CONN;
	if(empty($score)) return "";

	if ($rule) {
		$r=$rule;
	} else {
		$year=$class[0];
		$seme=$class[1];

		//�ഫ������
		//���Ҹճ]�w���
		$sm=&get_all_setup("",$year,$seme,$class[3]);

		//���ѳW�h
		$r=explode("\n",$sm[rule]);
	}
	reset($r);
	while(list($k,$v)=each($r)){
		$rule_a=array();
		$str=explode("_",$v);
		$du_str = (double)$str[2];

		if($str[1]==">="){
		if($score >= $du_str)return $str[0];
		}elseif($str[1]==">"){
			if($score > $du_str)return $str[0];
		}elseif($str[1]=="="){
			if($score == $du_str)return $str[0];
		}elseif($str[1]=="<"){
			if($score < $du_str)return $str[0];
		}elseif($str[1]=="<="){
			if($score <= $du_str)return $str[0];
		}
	}
	$score_name="";
	return $score_name;
}

//�Ǧ^�ഫ���Z�ҤA���B�}�C
function score2str_arrs($class=array()){
	global $CONN;

	$year=$class[0];
	$seme=$class[1];

	//�ഫ������
	//���Ҹճ]�w���
	$sm=&get_all_setup("",$year,$seme,$class[3]);

	//���ѳW�h
	$r=explode("\n",$sm[rule]);
	reset($r);
	while(list($k,$v)=each($r)){
		$rule_a=array();
		$str=explode("_",$v);
		$du_str=(double)$str[2];
		$rule_all[$k]=$str;
	}
	return $rule_all;
}

//�ഫ���Z�ҤA���B�����G �öǦ^�ʤ��ư}�C
function &score2str_arr($class=array()){
	global $CONN;
	$year=$class[0];
	$seme=$class[1];

	//�ഫ������
	//���Ҹճ]�w���
	$sm=&get_all_setup("",$year,$seme,$class[3]);

	//���ѳW�h
	$r=explode("\n",$sm[rule]);
	$res_arr = array();
	for($i=100;$i>0;$i--){
		reset($r);
		while(list($k,$v)=each($r)){
			$rule_a=array();
			$str=explode("_",$v);
			$du_str = (double)$str[2];

			if($str[1]==">="){
				if($i >= $du_str) {$res_arr[$i] = $str[0]."-- $i ��";break;}
			}elseif($str[1]==">"){
				if($i > $du_str){$res_arr[$i] = $str[0]."-- $i ��";break;}

			}elseif($str[1]=="="){
				if($i == $du_str){$res_arr[$i] = $str[0]."-- $i ��";break;}

			}elseif($str[1]=="<"){
				if($i < $du_str){$res_arr[$i] = $str[0]."-- $i ��";break;}

			}elseif($str[1]=="<="){
				if($i <= $du_str){$res_arr[$i] = $str[0]."-- $i ��";break;}

			}
		}

	}
	return $res_arr;
}



//���o�Ҹճ]�w
function &get_all_setup($setup_id="",$sel_year="",$sel_seme="",$Cyear=""){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if(!empty($setup_id)){
		$where="where setup_id=$setup_id";
	}elseif(!empty($sel_year) and !empty($sel_seme) and !is_null($Cyear)){
		$where="where year = '$sel_year' and semester='$sel_seme' and class_year='$Cyear'";
	}else{
		return false;
	}

	// init $main
	$main=array();

	$sql_select = "select * from score_setup $where";
	//die($sql_select);
	$recordSet=$CONN->Execute($sql_select) or trigger_error("SQL�y�k���~�G $sql_select", E_USER_ERROR);
	$main = $recordSet->FetchRow();
	return $main;
}



//�z�ҿ�J���O����٬O����O
function more_ss($ss_id){
	global $CONN;

	if (!$ss_id) user_error("�S���ǤJ���ά�ءI���ˬd�I",256);

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

    if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
    if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

	// init $new_ss_id_array
	$new_ss_id_array=array();

    $sql="select * from score_ss where ss_id='$ss_id'";
    $rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
    $i=0;
    while(!$rs->EOF){
        $ss_id[$i]= $rs->fields['ss_id'];
        $year[$i]= $rs->fields['year'];
        $semester[$i]= $rs->fields['semester'];
        $scope_id[$i]= $rs->fields['scope_id'];
        $subject_id[$i]= $rs->fields['subject_id'];
        $enable[$i]= $rs->fields['enable'];
        $rate=$rs->fields['rate'];
        $need_exam[$i]= $rs->fields['need_exam'];
        $print[$i]=  $rs->fields['print'];
        //if subject_id=0, this ss_id is scope if enable=0, have subject
        if($subject_id[$i]!="0") {//�����N�O�@�Ӥ���
            $new_ss_id_array[ss_id]=$ss_id;
            $new_ss_id_array[need_exam]=$need_exam[$i];
            $new_ss_id_array[rate]=$rate[$i];
            $new_ss_id_array[pprint]=$print[$i];
        }
        else{
            if($enable[$i]!="0"){//�����O�@�ӵL���쪺���
                $new_ss_id_array[ss_id]=$ss_id;
                $new_ss_id_array[need_exam]=$need_exam[$i];
                $new_ss_id_array[rate]=$rate[$i];
                $new_ss_id_array[pprint]=$print[$i];
            }
            else{//�����O�@�Ӧ����쪺���
                $rs_sec=$CONN->Execute("select * from score_ss where scope_id='$scope_id[$i]' and subject_id<>0 and enable<>0 ");
                $j=0;
                while(!$rs_sec->EOF){
                    $new_ss_id_array[ss_id][$j]= $rs_sec->fields['ss_id'];
                    $new_ss_id_array[rate][$j]= $rs_sec->fields['rate'];
                    $new_ss_id_array[need_exam][$j]= $rs_sec->fields['need_exam'];
                    $new_ss_id_array[pprint][$j]=  $rs_sec->fields['print'];
                    $j++;
                    $rs_sec->MoveNext();
                }
            }
        }
        $i++;
        $rs->MoveNext();
    }
    return $new_ss_id_array;
}


//���X�U�Ǧ~�U�Ǵ��U�~�Ū��Ǯզ��Z�@�q�]�w
function test_ratio($sel_year="",$sel_seme=""){
    global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

    if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
    if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

	// init $test_ratio_all
	$test_ratio_all=array();

    $sql="select * from score_setup where year='$sel_year' and semester='$sel_seme' and enable=1";
    $rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
    $i=0;
    while(!$rs->EOF){
        $class_year[$i]= $rs->fields['class_year'];
        $score_mode[$i]= $rs->fields['score_mode'];
        $test_ratio[$i]= $rs->fields['test_ratio'];
		$Ttest_ratio[$class_year[$i]]=$test_ratio[$i];
        $performance_test_times[$i]=  $rs->fields['performance_test_times'];

		if($score_mode[$i]=="all"){
            $Ttest_ratio[$class_year[$i]]=explode("-",$Ttest_ratio[$class_year[$i]]);
            if ($Ttest_ratio[$class_year[$i]][0]=="") $Ttest_ratio[$class_year[$i]][0]=60;
            if ($Ttest_ratio[$class_year[$i]][1]=="") $Ttest_ratio[$class_year[$i]][1]=40;
            $m1[$i]=$Ttest_ratio[$class_year[$i]][0]/$performance_test_times[$i];
            $m2[$i]=$Ttest_ratio[$class_year[$i]][1]/$performance_test_times[$i];
            $Ttest_ratio[$class_year[$i]]=array("$m1[$i]","$m2[$i]");
            for($j=0;$j<$performance_test_times[$i];$j++){
                $test_ratio_all[$class_year[$i]][$j]=$Ttest_ratio[$class_year[$i]];
				//echo "$class_year[$i] => $j : ".$test_ratio_all[$class_year[$i]][$j][0]."=>".$test_ratio_all[$class_year[$i]][$j][1]."<br>";

            }

        }
        elseif($score_mode[$i]=="severally"){
            //echo $test_ratio[$i]."<br>";
			//echo $Ttest_ratio[$class_year[$i]]."<br>";
			$Ttest_ratio[$class_year[$i]]=explode(",",$Ttest_ratio[$class_year[$i]]);
            for($j=0;$j<count($Ttest_ratio[$class_year[$i]]);$j++){
			//echo "CC".count($Ttest_ratio[$class_year[$i]]);
                $test_ratio_all[$class_year[$i]][$j]=explode("-",$Ttest_ratio[$class_year[$i]][$j]);
				//echo  "$class_year[$i] => $j : ".$test_ratio_all[$class_year[$i]][$j][0]."=>".$test_ratio_all[$class_year[$i]][$j][1]."<br>";
            }

        }
        else{
          	$Ttest_ratio[$class_year[$i]][0]=60;
           	$Ttest_ratio[$class_year[$i]][1]=40;
            for($j=0;$j<$performance_test_times[$i];$j++){
                $test_ratio_all[$class_year[$i]][$j]=$Ttest_ratio[$class_year[$i]];
            }
        }
    $i++;
    $rs->MoveNext();

    }
    return $test_ratio_all;
}

//���X�ӾǦ~�U�~�ŸӬ�ظӶ��q������
function test_score($sel_year="",$sel_seme=""){
    global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

    if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
    if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
    //$score_edu_adm=score_edu_adm."_".$sel_year."_".$sel_seme;
	$score_edu_adm=sprintf("score_edu_adm_%d_%d",$sel_year,$sel_seme);
	// init $score_array
	$score_array=array();

    $sql="select * from $score_edu_adm";
    $rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
    $i=0;
    while(!$rs->EOF){
        $edu_adm_id[$i]=$rs->fields['edu_adm_id'];
        $class_id[$i]=$rs->fields['class_id'];
        $student_sn[$i]=$rs->fields['student_sn'];
        $ss_id[$i]=$rs->fields['ss_id'];
        $score[$i]=$rs->fields['score'];
        $test_sort[$i]=$rs->fields['test_sort'];
        $score_array[$student_sn[$i]][$ss_id[$i]][$test_sort[$i]]=$score[$i];
        $i++;
        $rs->MoveNext();
    }

    return $score_array;
}

//��student_sn�Mss_id���o��r�y�z
function seme_score_memo($student_sn,$ss_id,$sel_year="",$sel_seme=""){
  	global $CONN;

	if (!$student_sn) user_error("�S���ǤJ�ǥͥN�X�I���ˬd�I",256);
	if (!$ss_id) user_error("�S���ǤJ��ءI���ˬd�I",256);

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

    if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
    if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
		//��X���y
	$seme_year_seme=sprintf("%03d%d",$sel_year,$sel_seme);
	$sql="select ss_score_memo from stud_seme_score where seme_year_seme='$seme_year_seme' and ss_id='$ss_id' and student_sn='$student_sn' ";
	//echo $sql;
	$rs=$CONN->Execute($sql);
	$ss_score_memo=$rs->fields['ss_score_memo'];

	return $ss_score_memo;
}

//���o�ǥͤ�`�ͬ���{�ˮ֪���
function get_chk_item($sel_year,$sel_seme) {
	global $CONN;

	$ary=array();
	$query="select * from score_nor_chk_item where year='$sel_year' and seme='$sel_seme' order by main,sub";
	$res=$CONN->Execute($query);
	$ary[items]=$res->GetRows();
	$query="select count(item) as num from score_nor_chk_item where year='$sel_year' and seme='$sel_seme' group by main order by main,sub";
	$res=$CONN->Execute($query);
	$ary[nums]=$res->GetRows();

	return $ary;
}

//���o�ǥͤ�`�ͬ���{�ˮ֪�� mode:value,input
function get_chk_value($student_sn,$sel_year,$sel_seme,$chk_kind_sel="",$mode="value") {
	global $CONN;
	$seme_year_seme = sprintf("%03d",$sel_year).$sel_seme;
	$query="select * from stud_seme_score_nor_chk where seme_year_seme='$seme_year_seme' and student_sn='$student_sn' order by main,sub";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$d[$res->fields[main]][$res->fields[sub]][score]=$res->fields[ms_score];
		$d[$res->fields[main]][$res->fields[sub]][memo]=$res->fields[ms_memo];
		$res->MoveNext();
	}
	$query="select * from score_nor_chk_item where year='$sel_year' and seme='$sel_seme' order by main,sub";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$main=$res->fields[main];
		$sub=$res->fields[sub];
		if ($mode=="input") {
			$temp_input="";
			reset($chk_kind_sel);
			while(list($k,$v)=each($chk_kind_sel)) {
				$checked=($d[$main][$sub][score]==$k)?"checked":"";
				$temp_input.="<input type=\"radio\" id=\"c$k"."_"."$student_sn\" name=\"chk[$student_sn][$main][$sub]\" value=\"$k\" $checked>$v\n";
			}
			$temp[$main][$sub][score]=$temp_input;
		} else {
			$temp[$main][$sub][score]=($d[$main][$sub][score])?$chk_kind_sel[$d[$main][$sub][score]]:"";
		}
		$temp[$main][$sub][memo]=$d[$main][$sub][memo];
		$res->MoveNext();
	}

	return $temp;
}

//���o�ǥͤ�`�欰��{��
function &get_oth_value($stud_id,$sel_year,$sel_seme,$ss_kind_sel='') {
	global $CONN;
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	if ($ss_kind_sel=='')
		$query = "select ss_kind,ss_id,ss_val from stud_seme_score_oth where seme_year_seme='$seme_year_seme' and stud_id='$stud_id'";
	else
		$query = "select ss_kind,ss_id,ss_val from stud_seme_score_oth where seme_year_seme='$seme_year_seme' and stud_id='$stud_id' and ss_kind='$ss_kind_sel' ";

	$res = $CONN->Execute($query) or trigger_error("������~ $query",E_USER_ERROR);
	$temp_arr = array();
	while(!$res->EOF){
		//���O
		$ss_kind = $res->fields[ss_kind];
		//���
		$ss_id= $res->fields[ss_id];
		//��
		$ss_val = $res->fields[ss_val];
		if ($ss_kind_sel=='')
			$temp_arr[$ss_kind][$ss_id] = $res->fields[ss_val];
		else
			$temp_arr[$ss_id] = $res->fields[ss_val];
		$res->MoveNext();
	}
	return $temp_arr;

}

//�X�־ǥͤ�`�ͬ����˪��r
function merge_chk_text($sel_year,$sel_seme,$student_sn,$ary=array()) {
	global $CONN;

	$temp_str="";
	$s="";
	$r="";
	while(list($main,$v)=each($ary)) {
		$s=trim($v[0][memo]);
		$r=(strlen($s)>1)?substr($s,-2,2):"";
		if ($r!="�C" && $r!="�I" && $r!="�H")
			$r="�C";
		else
			$r="";
		$temp_str.=($s=="")?"":$s.$r;
	}
	$temp_str=addslashes(($temp_str=="")?"":$temp_str);
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$query="select * from stud_seme_score_nor where seme_year_seme='$seme_year_seme' and student_sn='$student_sn' and ss_id='0'";
	$res=$CONN->Execute($query);
	if ($res->RecordCount()>0)
		$CONN->Execute("update stud_seme_score_nor set ss_score_memo='$temp_str' where seme_year_seme='$seme_year_seme' and student_sn='$student_sn' and ss_id='0'");
	else
		$CONN->Execute("insert into stud_seme_score_nor (seme_year_seme,student_sn,ss_id,ss_score_memo) values ('$seme_year_seme','$student_sn','0','$temp_str')");
}

//���o�ǥͤ�`�欰��{�� �Ǧ^�Z�Ű}�C
//$class_id = sprintf("%d%02d",$temp_id_arr[2],$temp_id_arr[3]);
function &get_class_oth_value($class_id,$sel_year,$sel_seme,$ss_id_sel,$ss_kind_sel='') {
	global $CONN,$IS_JHORES;
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	if ($ss_kind_sel=='')
		$query = "select a.stud_id,a.ss_kind,a.ss_val from stud_seme_score_oth a ,stud_base b where a.stud_id=b.stud_id and a.seme_year_seme='$seme_year_seme' and a.ss_id='$ss_id_sel' and b.curr_class_num like '$class_id%'";
	else
		$query = "select a.stud_id,a.ss_kind,a.ss_val from stud_seme_score_oth a ,stud_base b where a.stud_id=b.stud_id and a.seme_year_seme='$seme_year_seme' and a.ss_id='$ss_id_sel' and a.ss_kind='$ss_kind_sel'  and b.curr_class_num like '$class_id%'";
	
	$query=$IS_JHORES?$query." and ($sel_year - b.stud_study_year between 0 and 9)":$query;

	$res = $CONN->Execute($query) or trigger_error("������~ $query",E_USER_ERROR);
	$temp_arr = array();
	while(!$res->EOF){
		//���O
		$stud_id = $res->fields[stud_id];
		$ss_kind = $res->fields[ss_kind];
		//���
		$ss_id= $res->fields[ss_id];
		//��
		$ss_val = $res->fields[ss_val];
		if ($ss_kind_sel=='')
			$temp_arr[$ss_kind][$stud_id] = $res->fields[ss_val];
		else
			$temp_arr[$stud_id] = $res->fields[ss_val];
		$res->MoveNext();
	}
	return $temp_arr;

}

//���o�ǥͤ�`�欰��r
function get_nor_text($student_sn,$sel_year,$sel_seme) {
	global $CONN;

	$temp_arr = array();
	$nor_text_arr=nor_text();
	foreach($nor_text_arr as $k=>$v){
		$temp_arr[$v."_��"]="";
	}
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	$query = "select * from stud_seme_score_nor where seme_year_seme='$seme_year_seme' and student_sn='$student_sn'";
	$res = $CONN->Execute($query) or trigger_error("������~ $query",E_USER_ERROR);
	while(!$res->EOF){
		$temp_arr[$nor_text_arr[$res->fields[ss_id]]."_��"] = $res->fields[ss_score_memo];
		$res->MoveNext();
	}
	return $temp_arr;
}

//���o�ǥͤ�`��{�ˮ֪��r
function get_chk_text($student_sn,$sel_year,$sel_seme,$chk_kind_arr=array()) {
	global $CONN;

	$temp_arr = array();
	$chk_text_arr=get_chk_item($sel_year,$sel_seme);
	foreach($chk_text_arr['items'] as $k=>$v){
		if ($v['sub']==0) $temp_arr["�ˮ֥D��_".$v['main']."_��"]="";
	}
	reset($chk_text_arr['items']);
	foreach($chk_text_arr['items'] as $k=>$v){
		if ($v['sub']) $temp_arr["�ˮֲӶ�_".$v['main']."_".$v['sub']."_���p"]="";
	}
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);

	$query = "select * from stud_seme_score_nor_chk where seme_year_seme='$seme_year_seme' and student_sn='$student_sn'";
	$res = $CONN->Execute($query) or trigger_error("������~ $query",E_USER_ERROR);
	while(!$res->EOF){
		if ($res->fields['sub']==0) {
			$temp_arr["�ˮ֥D��_".$res->fields['main']."_��"] = $res->fields['ms_memo'];
		} else {
			$temp_arr["�ˮֲӶ�_".$res->fields['main']."_".$res->fields['sub']."_���p"] = $chk_kind_arr[$res->fields['ms_score']];
		}
		$res->MoveNext();
	}
	return $temp_arr;
}

//���o�ǥͥX�ʮu���p
function get_abs_value($stud_id,$sel_year,$sel_seme,$mode="",$start_date="",$end_date="") {
	global $CONN;

	$abs_kind_arr=stud_abs_kind();
	if ($start_date=="" && $end_date=="" && ($mode=="" || $mode=="����_��" || $mode=="�K��")) {
		//���o�Ǵ����
		$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
		$t_arr=array();
		$sql_select = "select * from stud_seme_abs where stud_id='$stud_id' and seme_year_seme='$seme_year_seme'";
		$recordSet = $CONN->Execute($sql_select) or trigger_error("SQL ���O���~ $sql_select",E_USER_ERROR);
		for ($i=1;$i<7;$i++) $t_arr[$i]=0;
		while (!$recordSet->EOF) {
			$abs_kind=$recordSet->fields['abs_kind'];
			$t_arr[$abs_kind]=$recordSet->fields['abs_days'];
			$recordSet->MoveNext();
		}
		if ($mode=="����_��") {
			foreach($t_arr as $id=>$v){
				$temp_arr[$abs_kind_arr[$id]."_��"]=$v;
			}
		}elseif($mode=="�K��"){
			foreach($t_arr as $id=>$v){
				$temp_arr[$abs_kind_arr[$id]]=$v;
			}
		}else {
			$temp_arr=$t_arr;
		}
	} else {
		if ($start_date=="" && $end_date=="") {
			//���o��Ʈw����������
			$db_date=curr_year_seme_day($sel_year,$sel_seme);
			$date_str=" and date <= '".$db_date['end']."'";
		} else {
			$date_str=" and date <= '$end_date' and date >= '$start_date'";
		}
		//���o�������
		$sql_select="select section, absent_kind from stud_absent where stud_id='$stud_id' and year='$sel_year' and semester='$sel_seme' $date_str";
		$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
		for($i=1;$i<=6;$i++) $t_arr[$i]=0;
		while(list($section,$absent_kind)=$recordSet->FetchRow()){
			if($mode=="����"||$mode=="����"){
				$n=($section=="allday")?7:1;
				//�ư�
				if(($absent_kind=="�ư�")&&($section!="uf")&&($section!="df")) $t_arr[1]+=$n;
				//�f��
				if(($absent_kind=="�f��")&&($section!="uf")&&($section!="df")) $t_arr[2]+=$n;
				//�m��
				if(($absent_kind=="�m��")&&($section!="uf")&&($section!="df")) $t_arr[3]+=$n;
				//���|(�u���m�Ҫ��~�p��)
				if(($absent_kind=="�m��")&&(($section=="uf")||($section=="df"))) $t_arr[4]+=$n;
				//����
				if(($absent_kind=="����")&&($section!="uf")&&($section!="df")) $t_arr[5]+=$n;
				//��L
				if((($absent_kind=="�ల")||($absent_kind=="���i�ܤO"))&&(($section!="uf")&&($section!="df"))) $t_arr[6]+=$n;
			} else {
				//���`�Ʋέp
				$t_arr[$section]+=1;
			}
		}
		if ($mode=="����") {
			foreach($t_arr as $id=>$v){
				$temp_arr[$abs_kind_arr[$id]]=$v;
			}
		} else {
			$temp_arr=$t_arr;
		}
	}
	return $temp_arr;
}

//$class_id �O�M�����ۭq���Z��ҲըϥΪ�
//���o�ǥͤ�`�ͬ���{���Ƥξɮv���y��ĳ
//$mode=1 ���o���鬡�ʡB���@�A�ȡB�S���{����r
function get_nor_value($student_sn,$sel_year,$sel_seme,$class_id="",$mode=0) {
	global $CONN;
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	if ($mode) {
		$ss_str="order by ss_id";
	} else {
		$ss_str="and ss_id=0";
	}
	$query="select ss_id,ss_score,ss_score_memo from stud_seme_score_nor where seme_year_seme='$seme_year_seme' and student_sn='$student_sn' $ss_str";
	$res = $CONN->Execute($query) or trigger_error("������~ $query",E_USER_ERROR);
	$temp_arr = array();
	if ($mode) {
		while(!$res->EOF) {
			$temp_arr[ss_score][$res->fields['ss_id']]=$res->fields['ss_score'];
			$temp_arr[ss_score_memo][$res->fields['ss_id']]=$res->fields['ss_score_memo'];
			$res->MoveNext();
		}
	} else {
		if ($class_id) {
			$class=class_id_2_old($class_id);
			$score=intval($res->fields[ss_score]);
			$score_txt=score2str($score,$class);

			$temp_arr['�ɮv���y�Ϋ�ĳ']=$res->fields[ss_score_memo];
			$temp_arr['���Ƶ���']=$score."-".$score_txt;
			$temp_arr['��{����']=$score_txt;
			$temp_arr['��{����']=$score;
		} else {
			$temp_arr[ss_score]=$res->fields[ss_score];
			$temp_arr[ss_score_memo]=$res->fields[ss_score_memo];
		}
	}

	return $temp_arr;
}

//���o�N�g�O��
function get_reward_value($stud_id,$sel_year,$sel_seme,$mode="") {
	global $CONN;
	$reward_kind_arr=stud_rep_kind();
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$query = "select * from stud_seme_rew where stud_id='$stud_id' and seme_year_seme='$seme_year_seme'";
	$res = $CONN->Execute($query) or trigger_error("SQL ���O���~ $query",E_USER_ERROR);
	$t_arr=array();
	for ($i=1;$i<7;$i++) $t_arr[$i]=0;
	while(!$res->EOF){
		$sr_kind_id=$res->fields['sr_kind_id'];
		$t_arr[$sr_kind_id]=$res->fields['sr_num'];
		$res->MoveNext();
	}
	if ($mode=="����_��") {
		foreach($t_arr as $id=>$v){
			$temp_arr[$reward_kind_arr[$id]."_��"]=$v;
		}
	} else {
		$temp_arr=$t_arr;
	}
	return $temp_arr;
}

//��student_sn�Mss_id��X�ӥͦ���C�@���q�n�s��bedu_adm_score�����Z�]�]�t���ɦ��Z�M�w���Ҭd���Z�^
function edu_score($student_sn,$ss_id,$test_sort,$sel_year="",$sel_seme=""){
 	global $CONN;

	if (!$student_sn) user_error("�S���ǤJ�ǥͥN�X�I���ˬd�I",256);
	if (!$ss_id) user_error("�S���ǤJ��ءI���ˬd�I",256);

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

    if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
    if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

    $seme_year_seme=sprintf("%03d%d",$sel_year,$sel_seme);
	$rs_seme_class=$CONN->Execute("select seme_class from stud_seme where student_sn='$student_sn' and seme_year_seme='$seme_year_seme' ") or user_error("Ū�����ѡI",256);
	$class_year=substr($rs_seme_class->fields['seme_class'],0,-2);


	$score_semester=sprintf("score_semester_%d_%d",$sel_year,$sel_seme);
	$sql="select score,test_kind from $score_semester where student_sn='$student_sn' and  test_sort='$test_sort' and ss_id='$ss_id' ";
	$rs=$CONN->Execute($sql) or trigger_error("$sql",256);
	$i=0;
	while(!$rs->EOF){
		$score[$i]=$rs->fields['score'];
		$test_kind[$i]=$rs->fields['test_kind'];
		$Sscore[$test_kind[$i]]=$score[$i];
		$rs->MoveNext();
		$i++;
	}
	$test_radio=test_ratio($sel_year,$sel_seme);
	$test_sort_p=$test_sort-1;
	$total_score=0;
	if($test_sort==255){
		$total_score=$Sscore['���Ǵ�'];
	}
	else{
		if($Sscore['�w�����q']>=0 )  {
			$total_score=$total_score+($Sscore['�w�����q'])*($test_radio[$class_year][$test_sort_p][0]/($test_radio[$class_year][$test_sort_p][0]+$test_radio[$class_year][$test_sort_p][1]));
			//echo "�w�����q:".$total_score."<br>";
		}
		if($Sscore['���ɦ��Z']>=0 )  {
			$total_score=$total_score+($Sscore['���ɦ��Z'])*($test_radio[$class_year][$test_sort_p][1]/($test_radio[$class_year][$test_sort_p][0]+$test_radio[$class_year][$test_sort_p][1]));
			//echo "���ɦ��Z:".$total_score."<br>";
		}
	}
	$total_score=round($total_score,2);

	return $total_score;
}

//��class_id��X�ӯZ�ݤ�Ҫ����
function class_id2subject($class_id){
	global $CONN;
	//����class_id
	$class_id_array=explode("_",$class_id);
	$year=intval($class_id_array[0]);
	$semester=intval($class_id_array[1]);
	$class_year=intval($class_id_array[2]);
//	092_2_06_01
	$class_id_t = sprintf("%03d_%d_%02d_%02d",$class_id_array[0],$class_id_array[1],$class_id_array[2],$class_id_array[3]);
	$sql="select * from score_ss where enable=1 and need_exam=1 and print=1 and year='$year' and semester='$semester' and class_year='$class_year' and class_id='$class_id_t' order by sort,sub_sort";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	if ($rs->RecordCount() ==0){
		$sql="select * from score_ss where enable=1 and need_exam=1 and print=1 and year='$year' and semester='$semester' and class_year='$class_year' and class_id='' order by sort,sub_sort";
		$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	}
	$i=0;
	while(!$rs->EOF){
		$ss_id[$i]=$rs->fields['ss_id'];
		$scope_id[$i]=$rs->fields['scope_id'];
		$subject_id[$i]=$rs->fields['subject_id'];
		$real_subject[$i]=($subject_id[$i]!="0")?"$subject_id[$i]":"$scope_id[$i]";
			//�ন����W��
			$sql2="select subject_name from score_subject where subject_id='$real_subject[$i]' and enable=1";
			$rs2=$CONN->Execute($sql2) or trigger_error($sql2,256);
			$subject_name[$i]=$rs2->fields['subject_name'];

		$SS[$ss_id[$i]]=$subject_name[$i];

 		$rs->MoveNext();
		$i++;
	}
	//�Ǧ^ss_id�]�ҵ{�N���^�}�C,ss_name�]�ҵ{�W�١^�}�C
	return $SS;
}

//��student_sn,ss_id,tetst_kind,test_sort���X���Z
function score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort="1"){
	global $CONN;
	if($curr_year=="") $curr_year = curr_year();
	if($curr_seme=="") $curr_seme = curr_seme();
	$curr_year=intval($curr_year);
	$score_semester="score_semester_".$curr_year."_".$curr_seme;
	$sql="select score from $score_semester where student_sn='$student_sn' and ss_id='$ss_id' and test_kind='$test_kind' and test_sort='$test_sort' ";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$score=$rs->fields['score'];
	return $score;
}


//�ӯZ�ثe�����Z���q���
function test_sort_select($curr_year,$curr_seme,$class_num){
	global $CONN,$test_sort;
	if($curr_year=="") $curr_year = curr_year();
	if($curr_seme=="") $curr_seme = curr_seme();
	$curr_year=intval($curr_year);
	$class_year=substr($class_num,0,-2);
	$sql="select  performance_test_times from score_setup where enable=1 and year='$curr_year' and semester='$curr_seme' and class_year='$class_year' ";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$times=$rs->fields['performance_test_times'];
	$option="<option>�п�ܶ��q</option>";
	for($i=1;$i<=$times;$i++){
		$selected[$i]=($i==$test_sort)?"selected":"";
		$option.="<option value='$i' $selected[$i]>�� $i ���q</option>";
	}
	return $option;
}

//�}�C�]�Ʀr���}�C�^�����Y�@�ƭȦb�}�C���Ʀ�ĴX
function sort_sort($num,$num_array){
	//echo count($num_array)."<br>";
	if(!in_array($num, $num_array)) return 0;
	sort($num_array,SORT_NUMERIC);
	//����
	$num_array=array_reverse($num_array);
	foreach($num_array as $key => $value){
		//echo $key."///".$value."<br>";
		$order=$key+1;
		if($num==$value) return $order;
	}
}

//��ss_id���X�Ӭ�[�v��
function subj_wet($ss_id=""){
	global $CONN;
	if($ss_id=="") return 0;
	$sql="select rate from score_ss where ss_id='$ss_id' and enable=1";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$wet=$rs->fields['rate'];
	return $wet;
}

// ���o���Z��
function &get_score_value($stud_id,$student_sn,$class_id,$oth_data,$sel_year,$sel_seme,$stage="") {
	global $CONN,$oth_arr_score,$oth_arr_score_2,$style_ss_num;
	$class=class_id_2_old($class_id);
	// ���o�V�O�{�פ�r�ԭz
//	$arr_1 = sfs_text("�V�O�{��");

	// ���o�ҵ{�C�g�ɼ�
	$ss_num_arr = get_ss_num_arr($class_id);
	
	if ($style_ss_num==1)//�H�ҵ{�]�w�C�P�`�Ƭ��D
	{
	$ss_num_arr =get_ss_num_arr_from_score_ss($class_id);
	}
	
	if ($style_ss_num==2)//�H�ҵ{�]���[�v�Ƨ@���`��
	{
	$ss_num_arr =get_ss_num_arr_from_score_ss_rate($class_id);
	}
	
	if ($stage=="") {
		// �Ǵ����Z
		// ���o���~�Ū��ҵ{�}�C
		$ss_name_arr = &get_ss_name_arr($class,"�u");
		
		// ���o�ǲߦ��N
		$ss_score_arr =get_ss_score_arr($class,$student_sn);
	} else {
		// ���q���Z
		// ���o���~�Ū��ҵ{�}�C
		$ss_name_arr = &get_ss_name_arr($class);
		// ���o�ǲߦ��N
		$ss_score_arr =get_ss_score($student_sn,$sel_year,$sel_seme,$stage);
	}

//�p�⥭��
$sectors=0;
foreach($ss_score_arr as $key=>$value){
	$ss_score_sum['�w�����q']+=$value['�w�����q']*$ss_num_arr[$key];
	$ss_score_sum['���ɦ��Z']+=$value['���ɦ��Z']*$ss_num_arr[$key];
	
	$sectors+=$ss_num_arr[$key];	

}
$ss_score_sum['�w�����q']=$ss_score_sum['�w�����q']/$sectors;
$ss_score_sum['���ɦ��Z']=$ss_score_sum['���ɦ��Z']/$sectors;

$ss_score_avg['����']['�w�����q']=round($ss_score_sum['�w�����q'],0);
$ss_score_avg['����']['���ɦ��Z']=round($ss_score_sum['���ɦ��Z'],0);

	$temp_str = "<table bgcolor=\"#9ebcdd\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">
	<tr bgcolor=\"#c4d9ff\">
	<td>���</td>";
	if ($stage=="") {
		$temp_str.="
			<td align=\"center\">�C�g�`��</td>
			<td align=\"center\">�V�O�{��</td>
			<td align=\"center\">�ǲߦ��N</td>
			<td align=\"center\">�ǲߴy�z��r����</td>
			</tr>";
		$ss_sql_select = "select link_ss,count(ss_id) as cc from score_ss where enable='1' and class_id='$class_id' and need_exam='1' group by link_ss order by sort,sub_sort";
		$ss_recordSet=$CONN->Execute($ss_sql_select) or user_error("Ū�����ѡI<br>$ss_sql_select",256);
		if ($ss_recordSet->RecordCount() ==0){
			$ss_sql_select = "select link_ss,count(ss_id) from score_ss where enable='1' and year='$class[0]' and semester='$class[1]' and need_exam='1' and class_id='' and class_year='$class[3]' group by link_ss order by sort,sub_sort";
			$ss_recordSet=$CONN->Execute($ss_sql_select) or user_error("Ū�����ѡI<br>$ss_sql_select",256);
		}
		$hidden_ss_id='';
		$temp_9_arr = array();
		while (!$ss_recordSet->EOF) {
			$link_ss=$ss_recordSet->fields['link_ss'];
			if ($link_ss!="�u�ʽҵ{") $temp_9_arr[$link_ss][num]=$ss_recordSet->fields['cc'];
			$ss_recordSet->MoveNext();
		}
		$ss_sql_select = "select ss_id,rate,link_ss from score_ss where enable='1' and class_id='$class_id' and need_exam='1' order by sort,sub_sort";
		$ss_recordSet=$CONN->Execute($ss_sql_select) or user_error("Ū�����ѡI<br>$ss_sql_select",256);
		if ($ss_recordSet->RecordCount() ==0){
			$ss_sql_select = "select ss_id,rate,link_ss from score_ss where enable='1' and year='$class[0]' and semester='$class[1]' and class_id='' and need_exam='1' and class_year='$class[3]' order by sort,sub_sort";
			$ss_recordSet=$CONN->Execute($ss_sql_select) or user_error("Ū�����ѡI<br>$ss_sql_select",256);
		}
		while ($SS=$ss_recordSet->FetchRow()) {
			$ss_id=$SS[ss_id];
			$link_ss=$SS[link_ss];
			$rate=$SS[rate];
			$ss_name= $ss_name_arr[$ss_id];
			$sub_link=0;
			if ($link_ss=="�u�ʽҵ{" or $link_ss=='') {
				$link_ss="�u�ʽҵ{-".$ss_name;
				$sub_link=1;
			}
			$temp_9_arr[$link_ss][ss_hours] += $ss_num_arr[$ss_id];
			$temp_9_arr[$link_ss][ss_score] += $ss_score_arr[$ss_id][ss_score]*$rate;
			$temp_9_arr[$link_ss][rate] += $rate;
			$oth_data_rate = 0;
			$temp_9_arr[$link_ss][oth_data] += $oth_arr_score[$oth_data["�V�O�{��"]["$ss_id"]]*$rate;
			if ($ss_score_arr[$ss_id][ss_score_memo]<>'') {
				if ($sub_link == 0 && $temp_9_arr[$link_ss][num]>1) $temp_9_arr[$link_ss][ss_score_memo] .= "$ss_name :";
				$temp_9_arr[$link_ss][ss_score_memo] .= $ss_score_arr[$ss_id][ss_score_memo]."<br/>";
			}
			//if ($temp_sel=='')
			//	$temp_sel = "--";
			//�Nss_id ��b hidden
			$hidden_ss_id .="$ss_id,";
		}
		reset($temp_9_arr);
		while(list($id,$val)=each($temp_9_arr)){
			if($id){
				$score_temp = $val[ss_score]/$val[rate];
				$score_oth = $oth_arr_score_2[round($val[oth_data]/$val[rate],0)];
				if ($score_temp>0)
					$score_temp_str = "<font color=#cccccc>(".round($score_temp,0).")</font>";
				else
					$score_temp_str ='';
				$score_memo = score2str($score_temp,$class);
				$temp_str .= "<tr bgcolor='white'>
					<td>$id</td>
					<td align='center'>$val[ss_hours]�`</td>
					<td nowrap align='center'>".$score_oth."</td>
					<td align='center'>$score_memo $score_temp_str</td>
					<td>".substr($val[ss_score_memo],0,-5)."</td>
					</tr>";
			}
		}
	} else {
		$temp_str.="
			<td align=\"center\">�C�g�`��</td>
			<td align=\"center\">�w���Ҭd</td>
			<td align=\"center\">���ɦ��Z</td>
			</tr>";
		$ss_sql_select = "select ss_id from score_ss where enable='1' and class_id='$class_id' and need_exam='1' and print='1' order by sort,sub_sort";
		$ss_recordSet=$CONN->Execute($ss_sql_select) or user_error("Ū�����ѡI<br>$ss_sql_select",256);
		if ($ss_recordSet->RecordCount() ==0){
			$ss_sql_select = "select ss_id from score_ss where enable='1' and year='$class[0]' and semester='$class[1]' and class_year='$class[3]' and class_id='' and need_exam='1' and print='1' order by sort,sub_sort";
			$ss_recordSet=$CONN->Execute($ss_sql_select) or user_error("Ū�����ѡI<br>$ss_sql_select",256);
		}

		while ($SS=$ss_recordSet->FetchRow()) {
			$ss_id=$SS[ss_id];
			$ss_name= $ss_name_arr[$ss_id];

			if ($ss_score_arr[$ss_id]['�w�����q']=='') $ss_score_arr[$ss_id]['�w�����q'] = "--";
			if ($ss_score_arr[$ss_id]['���ɦ��Z']=="") $ss_score_arr[$ss_id]['���ɦ��Z']="--";
			$temp_str .= "<tr bgcolor='white'>
				<td>$ss_name</td>
				<td align='center'>$ss_num_arr[$ss_id]�`</td>
				<td nowrap align='center'>".round($ss_score_arr[$ss_id]['�w�����q'],0)."</td>
				<td align='center'>".round($ss_score_arr[$ss_id]['���ɦ��Z'],0)."</td>
				</tr>";
		}
		$temp_str .= "<tr align='center' bgcolor='#ffdddd'><td colspan=2>�[�v����</td><td>{$ss_score_avg['����']['�w�����q']}</td><td>{$ss_score_avg['����']['���ɦ��Z']}</td></tr>";
	}
	$hidden_str=($hidden_ss_id)?"<input type=\"hidden\" name=\"hidden_ss_id\" value=\"$hidden_ss_id\">\n":"";
	return $temp_str.$hidden_str;
}

// $oth_data -- �P��صL�����
// $abs_data -- ���m�ҰO��
// $reward_data -- �N�g�O��
// $score_data -- ���Z�O��
// $mode 0:���t�ˮ֪�, 1:�t�ˮ֪�
function &html2code2($class,$sel_year,$sel_seme,$oth_data,$nor_data,$abs_data,$reward_data,$score_data,$student_sn,$mode=0) {
	global $SFS_PATH_HTML,$TOTAL_DAYS,$CONN,$IS_JHORES,$is_summary_input;
	$arr_1 = sfs_text("��`�欰��{");
	$arr_2 = sfs_text("���鬡�ʪ�{");
	$arr_3 = sfs_text("���@�A�Ȫ�{");
	$arr_4 = sfs_text("�ե~�S���{");
	//���O
	$abs_kind_arr = stud_abs_kind();
	//���g
	$rep_kind_arr = stud_rep_kind();
	$sel1 = new drop_select();
	$sel1->use_val_as_key = true;
	for($i=1;$i<=4;$i++) {
		if ($IS_JHORES==0&&$_SESSION[session_who]=="�Юv") {
			$ss_name = "a_$i";
			$sel1->s_name=$ss_name;
			$sel1->arr= ${"arr_$i"};
			$sel1->id=$oth_data['�ͬ���{���q'][$i];
			${"sel_str_$i"} = $sel1->get_select();
		} else {
			${"sel_str_$i"} = $oth_data['�ͬ���{���q'][$i];
		}
	}
	//��`�ͬ���{���q
	if ($IS_JHORES==0&&$_SESSION[session_who]=="�Юv") {
		$score_str_arr = &score2str_arr($class);
		$sel1->s_name="nor_score";
		$sel1->id = $nor_data[ss_score];
		$sel1->top_option="��ܵ���";
		$sel1->use_val_as_key = false;
		$sel1->arr = $score_str_arr;
		$nor_score_sel = $sel1->get_select();
	} else {
		$final_nor_score=$nor_data[ss_score];
		$final_nor=score2str($final_nor_score,$class);
		$score_str_arr = &score2str_arr($class);
	}


	$temp_str ="
	<table cellspacing=\"0\" cellpadding=\"0\">
	<tr>
	<td>
	<table bgcolor=\"#9ebcdd\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">
	";

	if ($mode==1) {
		$temp_str .="
		<tr bgcolor=\"#c4d9ff\">
		<td colspan=\"13\" align=\"center\" nowrap>��`�ͬ���{</td>
		</tr>
		<tr bgcolor=\"white\">
		<td nowrap>�ͬ��欰</td><td colspan=\"12\"><textarea name='nor_score_memo' id='nor_score_memo'  rows=5 style='width: 100%'>".$nor_data[ss_score_memo][0]."</textarea><br><font color=\"red\" size=\"2\">���Y���椺�e�P�ˮ֪��ĳ��r���P�A�Ш��ˮ֪��s�x�s�@���Y�i�C</font></td>
		</tr>
		<tr bgcolor=\"white\">
		<td nowrap>���鬡��</td><td colspan=\"12\">".$nor_data[ss_score_memo][1]."</td>
		</tr>
		<tr bgcolor=\"white\">
		<td nowrap>���@�A��</td><td colspan=\"12\">�դ��A�ȡG".$nor_data[ss_score_memo][2]."<br>���ϪA�ȡG".$nor_data[ss_score_memo][3]."</td>
		</tr>
		<tr bgcolor=\"white\">
		<td nowrap>�S���{</td><td colspan=\"12\">�դ��S���{�G".$nor_data[ss_score_memo][4]."<br>�ե~�S���{�G".$nor_data[ss_score_memo][5]."</td>
		</tr>
		";
	} else {
		$temp_str .="
		<tr bgcolor=\"white\">
		<td colspan=\"13\" nowrap>��`�ͬ���{���q</td>
		</tr>
		<tr bgcolor=\"white\">
		<td nowrap>��`�欰��{</td>
		<td colspan=\"3\">$sel_str_1
		</td>
		<td colspan=\"8\" nowrap>�ɮv���y�Ϋ�ĳ";

		if ($IS_JHORES==0&&$_SESSION[session_who]=="�Юv") $temp_str.="<img src='$SFS_PATH_HTML/images/comment1.png' border='0' title='�妸�פJ���y' onclick=\"return OpenWindow2('�妸�s�׵��y')\">";

		$temp_str.="
		</td>
		<td nowrap>����</td>
		</tr>
		<tr bgcolor=\"white\">
		<td nowrap>���鬡�ʪ�{</td>

		<td colspan=\"3\">$sel_str_2
		</td>";
		if ($IS_JHORES==0&&$_SESSION[session_who]=="�Юv") {
			$temp_str.="
				<td rowspan=\"3\" colspan=\"8\"><img src='$SFS_PATH_HTML/images/comment.png' width=16 height=16 border=0 title='���w��J' align='left' name='nor_score_memo' value='nor_score_memo_s' onClick=\"return OpenWindow('nor_score_memo')\"><textarea name='nor_score_memo' id='nor_score_memo' cols=30 rows=5>mmmmm$nor_data[ss_score_memo]</textarea></td>
				<td rowspan=\"3\" colspan=\"1\">$nor_score_sel</td>";
		} else {
			$temp_str.="
				<td rowspan=\"3\" colspan=\"8\">".$nor_data[ss_score_memo]."</td>
				<td rowspan=\"3\" colspan=\"1\" align='center'>$final_nor</td>";
		}
		$temp_str.="
		</tr>

		<tr bgcolor=\"white\">
		<td nowrap>���@�A��</td>
		<td colspan=\"3\">$sel_str_3
		</td>

		</tr>
		<tr bgcolor=\"white\">
		<td nowrap>�ե~�S���{</td>
		<td colspan=\"3\">$sel_str_4
		</td>
		</tr>";
	}
	if ($IS_JHORES==0) {
		$temp_str.="
			<tr bgcolor=\"white\">
			<td nowrap>�W���`���</td>
			<td colspan=\"13\">$TOTAL_DAYS ��
			</td>
			</tr>";
	}

if($is_summary_input=='y' || $IS_JHORES!=0) {
	$temp_str.="
	<tr bgcolor=\"white\">";

	if ($IS_JHORES!=0)
	$temp_str.="
	<td nowrap>�ǥͯʮu���p</td>";
	else
	$temp_str.="
	<td nowrap>�ǥͯʮu���p�A<br/><a href=\"absent.php\">��g�Դk�O��</a> $summary_input<br>
	</td>";
	reset($abs_kind_arr);
	while(list($id,$val)=each($abs_kind_arr)){
		$ttt =($IS_JHORES==0)?"�Ѽ�":"�`��";
		if ($id==4) $ttt= "����";
//		if ($IS_JHORES==0) {
//			if ($_SESSION[session_who]=="�Юv")
//				$temp_str .="<td nowrap>$val<br>$ttt</td>\n<td><input type='text' name='abs_$id' id='abs_$id' value='".$abs_data[$id]."' size=5 ></td>\n";
//			else
//				$temp_str .="<td nowrap>$val<br>$ttt</td>\n<td>$abs_data[$id]</td>\n";
//		} else
			$temp_str .="<td nowrap>$val<br>$ttt</td>\n<td>$abs_data[$id]</td>\n";
	}
}

	if ($IS_JHORES!=0) {
		$temp_str.= "</tr>
		<tr bgcolor=\"white\">
		<td nowrap>���g<br>
		</td>";
		//�C�X���g
		reset($rep_kind_arr);
		while(list($id,$val)= each($rep_kind_arr)) $temp_str .= "<td nowrap>$val<br>����</td>\n<td>$reward_data[$id]</td>\n";
	}

	if ($mode==1) {
		$temp_str.= "</tr>
		<tr bgcolor=\"#c4d9ff\">
		<td colspan=\"13\" align=\"center\" nowrap>�ǲ߻����q</td>";
	} else {
		$temp_str.= "</tr>
		<tr bgcolor=\"white\">
		<td nowrap>��L</td>";

		if  ($IS_JHORES==0&&$_SESSION[session_who]=="�Юv")
			$temp_str.= "<td colspan=\"12\"><input type='text' name='oth_rep' id='oth_rep' value='".$oth_data['��L�]�w'][0]."'></td>";
		else
			$temp_str.= "<td colspan=\"12\">".$oth_data['��L�]�w'][0]."</td>";
	}

	$temp_str.= "
	</tr>
	</table>
	</td></tr>
	<tr><td>
	$score_data
	</td></tr>
	</table>
	</td>
	</tr>
	</table>";
	return $temp_str;
}

//���Z��
class score_chart {

	var $upper_title;	//���̤W�������D
	var $kind=array(); 	//���Z���� : ���ɦ��Z,�w���Ҭd,���Ǵ�
	var $sort; 		//���q�O : 1,2,3...
	var $score_arr=array(); //���Z���e : $score_arr[$student_sn][$ss_id][$sort][$kind]
//	var $score_cal=array(); //�p�ⶵ�� : $score_cal[$student_sn][sum]	�`���Z
				//                                  [num]	�`��ؼ�
				//                                  [avg]	����
//	var $subject_cal=array(); �p�ⶵ�� : $subject_cal[$ss_id][num]		�U��ؤH��
				//                               [avg]		�U��إ���
				//                               [std]		�U��ؼзǮt
	var $col_arr=array(); 	//���D�C���e : $col_arr[$ss_id][name]		��ئW��
				//                             [ratio]		�t�����
	var $row_arr=array();	//�C�Y���e : $row_arr[$site_num][sn]		�ǥͧǸ�
				//                              [name]		�ǥͩm�W
				//                              [class_site]	�Z�Ůy��(�Ω����) 5-10 ���Z�Q��
	var $left_col_arr=array();	//��ؤ��e�����D���e
	var $right_col_arr=array();	//��ؤ��᪺���D���e
	var $title_bgcolor="'#FDC3F5'";
	var $col_bgcolor=array("0"=>"'#B8FF91'","1"=>"'#CFFFC4'","2"=>"'#B4BED3'","3"=>"'#CBD6ED'","4"=>"'#D8E4FD'");
	var $ratio_enable=false;

	function score_chart() {
		$this->left_col_arr[][name]="�y��";
		$this->left_col_arr[][name]="�m�W";
	}

	function show_header($mode) {
		if ($mode=="output") {
			echo '	<HTML><HEAD><TITLE>'.$this->upper_title.'</TITLE>
				<META http-equiv=Content-Language content=zh-tw>
				<META http-equiv=Content-Type content="text/html; charset=big5">
				<BODY>
				<P align=center><FONT size=4>'.$this->upper_title.'</FONT></P>
				<TABLE style="BORDER-COLLAPSE: collapse" borderColor=#111111 cellSpacing=0 cellPadding=0 width=610 align=center border=0>
				<TBODY>
				<tr>';
			$i=1;
			while(list($k,$v)=each($this->left_col_arr)) {
				$l_border=($i==1)?"1.5":"0.75";
				echo '<td style="border-style:solid; border-width:1.5pt 0.75pt 0.75pt '.$l_border.'pt;" align="center" width="40">'.$this->left_col_arr[$k][name].'</td>';
				$i++;
			}
			while(list($k,$v)=each($this->col_arr)) {
				$ratio_str=($this->ratio_enable && $this->col_arr[$k][ratio])?"<br>(x".$this->col_arr[$k][ratio].")":"";
				echo '<td style="border-style:solid; border-width:1.5pt 0.75pt 0.75pt 0.75pt;" align="center" width="40">'.$this->col_arr[$k][name].$ratio_str.'</td>';
			}
			while(list($k,$v)=each($this->right_col_arr)) {
				echo '<td style="border-style:solid; border-width:1.5pt 1.5pt 0.75pt 1.5pt;" align="center" width="40">'.$this->right_col_arr[$k][name].'</td>';
			}
		} elseif ($mode=="file_out") {
			header("Content-disposition: attachment; filename=file_out.csv");
			header("Content-type: application/octetstream");
			header("Pragma: no-cache");
			header("Expires: 0");
			while(list($k,$v)=each($this->left_col_arr)) {
				echo $this->left_col_arr[$k][name].",";
			}
			while(list($k,$v)=each($this->col_arr)) {
				$ratio_str=($this->ratio_enable && $this->col_arr[$k][ratio])?"<br>(x".$this->col_arr[$k][ratio].")":"";
				echo $this->col_arr[$k][name].",";
			}
			$i=1;
			while(list($k,$v)=each($this->right_col_arr)) {
				$j=count($this->right_col_arr);
				echo $this->right_col_arr[$k][name];
				if ($i==$j)
					echo "\r\n";
				else
					echo ",";
				$i++;
			}
		} else {
			echo "	<table bgcolor='#0000ff' border='0' cellpadding='6' cellspacing='1'>\n
				<tr bgcolor=$this->title_bgcolor>";
			if ($this->upper_title) {
				$cols=count($this->left_col_arr)+count($this->col_arr)+count($this->right_col_arr);
				echo "<td colspan='$cols' align='center'>$this->upper_title</td></tr><tr bgcolor=$this->title_bgcolor>";
			}
			while(list($k,$v)=each($this->left_col_arr)) {
				echo "<td>".$this->left_col_arr[$k][name]."</td>";
			}
			while(list($k,$v)=each($this->col_arr)) {
				$ratio_str=($this->ratio_enable && $this->col_arr[$k][ratio])?"<br><font color='#ff0000'>(x".$this->col_arr[$k][ratio].")</font>":"";
				echo "<td align='center'>".$this->col_arr[$k][name].$ratio_str."</td>";
			}
			while(list($k,$v)=each($this->right_col_arr)) {
				echo "<td>".$this->right_col_arr[$k][name]."</td>";
			}
			echo "</td>\n";
		}
	}

	function summary() {
		$this->right_col_arr[sum][name]="�`��";
		$this->is_summary=true;
		reset ($this->score_arr);
		while(list($student_sn,$z)=each($this->score_arr)) {
			reset($z);
			while(list($ss_id,$y)=each($z)) {
				reset($y);
				while(list($sort,$x)=each($y)) {
					reset($x);
					while(list($kind,$s)=each($x)) {
						$ratio=($this->ratio_enable)?$this->col_arr[$ss_id][ratio]:1;
						$this->score_cal[$student_sn][num]+=$ratio;
						$this->score_cal[$student_sn][sum]+=$s*$ratio;
						$this->score_subject[$ss_id][num]++;
						$this->score_subject[$ss_id][sum]+=$s;
						$this->sort_no[$student_sn]=$this->score_cal[$student_sn][sum];
						$this->subject_cal[$ss_id]["s".floor($s/10)]++;
					}
				}
			}
			//�p���`�H�Ƥ��`���[�`
			$this->score_cal[avg][num]++;
			$this->score_cal[avg][sum]+=$this->score_cal[$student_sn][sum];
		}
		//�p���`������
		$this->score_cal[avg][sum]=number_format($this->score_cal[avg][sum]/$this->score_cal[avg][num],$precision);
		//���U��зǮt��ܮɤ��|�X�{���~
		$this->score_cal[std][sum]=" ";
	}

	function average_one() {
		//�p�G�٨S�p�⦨�Z�A�N���p��
		if ($this->is_summary!=true) {
			$this->summary();
			$out=array_pop($this->right_col_arr);
		}
		$this->right_col_arr[avg][name]="����";
		$this->is_average_one=true;
		reset ($this->score_cal);
		while(list($student_sn,$v)=each($this->score_cal)) {
			$this->score_cal[$student_sn][avg]=number_format($this->score_cal[$student_sn][sum]/$this->score_cal[$student_sn][num],$precision);
		}
		$this->score_cal[avg][avg]=number_format($this->score_cal[avg][sum]/count($this->col_arr),$precision);
		//���U��зǮt��ܮɤ��|�X�{���~
		$this->score_cal[std][avg]=" ";
	}

	function sorting() {
		$this->right_col_arr[sort][name]="�W��";
		$this->is_sorting=true;
		arsort($this->sort_no);
		$total=count($this->sort_no);
		$i=1;
		reset ($this->sort_no);
		while(list($student_sn,$v)=each($this->sort_no)) {
			if ($this->score_cal[$student_sn][sum]!=$pre_score) $j=$i;
			$this->score_cal[$student_sn][sort]=$j;
			$pre_score=$this->score_cal[$student_sn][sum];
			$i++;
		}
		//���U�쥭���B�U��зǮt��ܮɤ��|�X�{���~
		$this->score_cal[avg][sort]=" ";
		$this->score_cal[std][sort]=" ";
	}

	function average_subject() {
		$this->row_arr[avg][name]="�U�쥭��";
		$this->is_average_subject=true;
		//�p�G�٨S�p�⦨�Z�A�N���p��
		if ($this->is_summary!=true) $this->summary();
		reset ($this->score_subject);
		while(list($ss_id,$v)=each($this->score_subject)) {
			$this->subject_cal[$ss_id][avg]=number_format($this->score_subject[$ss_id][sum]/$this->score_subject[$ss_id][num],$precision);
		}
	}

	function std() {
		$this->row_arr[std][name]="�U��зǮt";
		//�p�G�٨S�p��U�쥭���A�N���p��
		if ($this->is_average_subject!=true) $this->average_subject();
		reset ($this->score_arr);
		while(list($student_sn,$z)=each($this->score_arr)) {
			while(list($ss_id,$y)=each($z)) {
				while(list($sort,$x)=each($y)) {
					while(list($kind,$s)=each($x)) {
						$this->subject_cal[$ss_id][std]+=pow($s-$this->subject_cal[$ss_id][avg],2);
					}
				}
			}
		}
		reset ($this->score_subject);
		while(list($ss_id,$v)=each($this->score_subject)) {
			$this->subject_cal[$ss_id][std]=number_format(sqrt($this->subject_cal[$ss_id][std]/$this->score_subject[$ss_id][num]),$precision);
		}
	}

	function stat() {
		$this->row_arr[w1][name]="���Z���G��";
		$this->row_arr[w1][sn]="line";
		$this->row_arr[s10][name]="100��";
		$this->row_arr[s9][name]="90��~100��";
		$this->row_arr[s8][name]="80��~ 90��";
		$this->row_arr[s7][name]="70��~ 80��";
		$this->row_arr[s6][name]="60��~ 70��";
		$this->row_arr[s5][name]="50��~ 60��";
		$this->row_arr[s4][name]="40��~ 50��";
		$this->row_arr[s3][name]="30��~ 40��";
		$this->row_arr[s2][name]="20��~ 30��";
		$this->row_arr[s1][name]="10��~ 20��";
		$this->row_arr[s0][name]=" 0��~ 10��";
		for ($i=0;$i<=10;$i++) {
			$j="s".$i;
			$this->score_cal[$j][sum]=" ";
			$this->score_cal[$j][avg]=" ";
			$this->score_cal[$j][sort]=" ";
		}
	}

	function view() {
		$this->show_header("view");
		$left_cols=count($this->left_col_arr);
		while(list($k,$v)=each($this->row_arr)) {
			//�Y���U�쥭���B�U��зǮt�h�C�X
			if (intval($k)==0 && $k!="0" && $k!="") {
				if ($this->row_arr[$k][sn]=="line") {
					$line_cols=$left_cols+count($this->col_arr)+count($this->score_cal);
					echo "<tr><td colspan='$line_cols'><font color='#ffffff'>".stripslashes($this->row_arr[$k][name])."</font></td></tr>";
				} else {
					echo "<tr bgcolor=".$this->title_bgcolor."><td colspan='$left_cols'>".stripslashes($this->row_arr[$k][name])."</td>";
					reset ($this->col_arr);
					while(list($ss_id,$j)=each($this->col_arr)) {
						echo "<td bgcolor='".$this->title_bgcolor."'>".$this->subject_cal[$ss_id][$k]."</td>";
					}
					//�ӤH�`���B�����B�ƦW�����n�d�ť�
					while(list($cal_kind,$j)=each($this->score_cal[$k])) {
						if ($cal_kind=="num" || $this->right_col_arr[$cal_kind]=="") continue;
						echo "<td>$j</td>";
						$i++;
					}
					echo "</tr>";
				}
			} else {
			//�C�X�U�H�U�즨�Z
				//�p�G�O���իh�y����ܪ��O�Z�Ůy���A�_�h��ܮy��
				if ($this->row_arr[$k][class_site])
					$site=$this->row_arr[$k][class_site];
				else
					$site=$k;
				echo "<tr bgcolor='#ffffff'><td bgcolor=".$this->col_bgcolor[0].">$site</td><td bgcolor=".$this->col_bgcolor[1].">".stripslashes($this->row_arr[$k][name])."</td>";
				reset ($this->col_arr);
				while(list($ss_id,$j)=each($this->col_arr)) {
					while(list($kind,$b)=each($this->score_arr[$this->row_arr[$k][sn]][$ss_id][$this->sort])) {
						if ($kind=="num") continue;
						$s=$this->score_arr[$this->row_arr[$k][sn]][$ss_id][$this->sort][$kind];
						$score_fcolor=(intval($s)<60)?"'#ff0000'":"'#000000'";
						echo "<td><font color=$score_fcolor>".$s."</font></td>";
					}
				}
				//�C�X�ӤH�`���B�����B�ƦW
				$i=$left_cols;
				while(list($cal_kind,$j)=each($this->score_cal[$this->row_arr[$k][sn]])) {
					if ($cal_kind=="num" || $this->right_col_arr[$cal_kind]=="") continue;
					$score_fcolor=(intval($j)<60)?"'#ff0000'":"'#000000'";
					if ($cal_kind=="sort") $score_fcolor="'#000000'";
					echo "<td bgcolor=".$this->col_bgcolor[$i]."><font color=$score_fcolor>".$j."</font></td>";
					$i++;
				}
				echo "</tr>\n";
			}
		}
		echo "</table>";
	}

	function edit() {
		$this->show_header("edit");
	}

	function save() {
	}

	function file_in() {
	}

	function file_out() {
		$this->show_header("file_out");
		$left_cols=count($this->left_col_arr);
		while(list($ss_id,$v)=each($this->col_arr)) {
			echo $this->col_arr[$ss_id][name].'\r\n';
		}
		$h=1;
		while(list($k,$v)=each($this->row_arr)) {
			//�Y���U�쥭���B�U��зǮt�h�C�X
			if (intval($k)==0 && $k!="0" && $k!="") {
				if ($this->row_arr[$k][sn]=="line") {
					$line_cols=$left_cols+count($this->col_arr)+count($this->score_cal);
					echo stripslashes($this->row_arr[$k][name]).',';
				} else {
					echo ','.stripslashes($this->row_arr[$k][name]).',';
					reset ($this->col_arr);
					while(list($ss_id,$j)=each($this->col_arr)) {
						echo $this->subject_cal[$ss_id][$k].',';
					}
					//�ӤH�`���B�����B�ƦW�����n�d�ť�
					while(list($cal_kind,$j)=each($this->score_cal[$k])) {
						if ($cal_kind=="num" || $this->right_col_arr[$cal_kind]=="") continue;
						echo $j.',';
					}
					echo "\r\n";
				}
			} else {
				//�C�X�U�H�U�즨�Z
				//�p�G�O���իh�y����ܪ��O�Z�Ůy���A�_�h��ܮy��
				if ($this->row_arr[$k][class_site])
					$site=$this->row_arr[$k][class_site];
				else
					$site=$k;
				echo $site.','.stripslashes($this->row_arr[$k][name]).',';
				reset ($this->col_arr);
				$i=1;
				while(list($ss_id,$j)=each($this->col_arr)) {
					while(list($kind,$b)=each($this->score_arr[$this->row_arr[$k][sn]][$ss_id][$this->sort])) {
						if ($kind=="num") continue;
						$s=$this->score_arr[$this->row_arr[$k][sn]][$ss_id][$this->sort][$kind];
						echo $s.',';
					}
					$i++;
				}
				//�C�X�ӤH�`���B�����B�ƦW
				$i=$left_cols;
				$j=1;
				while(list($cal_kind,$j)=each($this->score_cal[$this->row_arr[$k][sn]])) {
					if ($cal_kind=="num" || $this->right_col_arr[$cal_kind]=="") continue;
					echo $j.',';
					$i++;
					$j++;
				}
				echo "\r\n";
			$h++;
			}
		}

	}

	function output() {
		$this->show_header("output");
		$left_cols=count($this->left_col_arr);
		$col_width=floor(510/(count($this->col_arr)+count($this->score_cal)));
		$i=1;
		while(list($ss_id,$v)=each($this->col_arr)) {
			if ($i!=count($this->col_arr)) {
				echo '<td style="border-style:solid; border-width:1.5pt 0.75pt;" align="center" width="'.$col_width.'">'.$this->col_arr[$ss_id][name].'</td>\n';
			} else {
				echo '<td style="border-style:solid; border-width:1.5pt 1.5pt 1.5pt 0.75pt;" align="center" width="'.$col_width.'">'.$this->col_arr[$ss_id][name].'</td>\n';
			}
			$i++;
		}
		echo '</tr>';
		$h=1;
		while(list($k,$v)=each($this->row_arr)) {
			//�Y���U�쥭���B�U��зǮt�h�C�X
			if (intval($k)==0 && $k!="0" && $k!="") {
				if ($this->row_arr[$k][sn]=="line") {
					$line_cols=$left_cols+count($this->col_arr)+count($this->score_cal);
					echo '<tr><td style="border-style:solid; border-width:1.5pt 1.5pt 1.5pt 0.75pt;" align="center" colspan="'.$line_cols.'">'.stripslashes($this->row_arr[$k][name]).'</td></tr>';
				} else {
					echo '<tr><td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 1.5pt;" align="center" colspan="'.$left_cols.'">'.stripslashes($this->row_arr[$k][name]).'</td>';
					reset ($this->col_arr);
					while(list($ss_id,$j)=each($this->col_arr)) {
						echo '<td style="border-style:solid; border-width:1.5pt 0.75pt;" align="center">'.$this->subject_cal[$ss_id][$k].'</td>';
					}
					//�ӤH�`���B�����B�ƦW�����n�d�ť�
					while(list($cal_kind,$j)=each($this->score_cal[$k])) {
						if ($cal_kind=="num" || $this->right_col_arr[$cal_kind]=="") continue;
						echo '<td style="border-style:solid; border-width:1.5pt;" align="center">'.$j.'</td>';
						$i++;
					}
					echo "</tr>";
				}
			} else {
				$d_str=($h % 5==0 || $h==count($this->row_arr))?"1.5pt":"0.75pt";
				//�C�X�U�H�U�즨�Z
				//�p�G�O���իh�y����ܪ��O�Z�Ůy���A�_�h��ܮy��
				if ($this->row_arr[$k][class_site])
					$site=$this->row_arr[$k][class_site];
				else
					$site=$k;
				echo '<td style="border-style:solid; border-width:0.75pt 0.75pt '.$d_str.' 1.5pt;" align="center" width="40">'.$site.'</td><td style="border-style:solid; border-width:0.75pt 0.75pt '.$d_str.' 0.75pt;" align="center" width="60">'.stripslashes($this->row_arr[$k][name]).'</td>';
				reset ($this->col_arr);
				$i=1;
				while(list($ss_id,$j)=each($this->col_arr)) {
					while(list($kind,$b)=each($this->score_arr[$this->row_arr[$k][sn]][$ss_id][$this->sort])) {
						if ($kind=="num") continue;
						$s=$this->score_arr[$this->row_arr[$k][sn]][$ss_id][$this->sort][$kind];
						$r_str=($i!=count($this->col_arr))?"0.75pt":"1.5pt";
						echo '<td style="border-style:solid; border-width:0.75pt '.$r_str.' '.$d_str.' 0.75pt;" align="center" width="'.$col_width.'">'.$s.'</td>';
					}
					$i++;
				}
				//�C�X�ӤH�`���B�����B�ƦW
				$i=$left_cols;
				$j=1;
				while(list($cal_kind,$j)=each($this->score_cal[$this->row_arr[$k][sn]])) {
					if ($cal_kind=="num" || $this->right_col_arr[$cal_kind]=="") continue;
					echo '<td style="border-style:solid; border-width:0.75pt '.$r_str.' '.$d_str.' 0.75pt;" align="center" width="'.$col_width.'">'.$j.'</td>';
					$i++;
					$j++;
				}
				echo "</tr>\n";
			$h++;
			}
		}
	}
}

function cal_fin_score($student_sn=array(),$seme=array(),$succ="",$strs="",$precision=1)   //$succ:�ݦX����� $strs:���ĵ��_�N���r��
{

	//���X�Ǵ���]�w��  ���~���Z�p��覡  0:��ƥ���   1:�[�v����(�Ǥ������[�v)

	global $CONN;
	if (count($seme)==0) return;
	$SQL="select * from pro_module where pm_name='every_year_setup' AND pm_item='FIN_SCORE_RATE_MODE'";
        $RES=$CONN->Execute($SQL);
        $FIN_SCORE_RATE_MODE=INTVAL($RES->fields['pm_value']);

	$sslk=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","���d�P��|"=>"health","�ͬ�"=>"life","���|"=>"social","���N�P�H��"=>"art","�۵M�P�ͬ����"=>"nature","�ƾ�"=>"math","��X����"=>"complex");
	if (count($student_sn)>0 && count($seme)>0) {
		$all_sn="'".implode("','",$student_sn)."'";
		$all_seme="'".implode("','",$seme)."'";
		//���o��ئ��Z
		$query="select a.*,b.link_ss,b.rate from stud_seme_score a left join score_ss b on a.ss_id=b.ss_id where a.student_sn in ($all_sn) and a.seme_year_seme in ($all_seme) and b.enable='1' and b.need_exam='1'";
		// �Y���ƿ�..�h�ץ���Ʈw�y�k,�[�J�w��SS_ID���~�ŧ@�ˬd,�O�_�P�ǥͩҦb�~�Ŭ۲�
/*		$sch=get_school_base();
		if($sch[sch_sheng]=='���ƿ�'){
			$query="select a.*,b.link_ss,b.rate,b.class_year ,b.year as chc_year,b.semester as chc_semester,c.seme_class as chc_seme_class from stud_seme_score a left join score_ss b on a.ss_id=b.ss_id left join stud_seme as c on (a.seme_year_seme=c.seme_year_seme and a.student_sn =c.student_sn) where a.student_sn in ($all_sn) and a.seme_year_seme in ($all_seme) and b.enable='1' and b.need_exam='1' and (b.class_year=left(c.seme_class,1))";
		}
*/		
		$res=$CONN->Execute($query);
		//���o�U�Ǵ����Ǭ즨�Z.�[�v�ƨå[�`
		while(!$res->EOF) {
			//���o���[�v�`��
			$subj_score[$res->fields[student_sn]][$res->fields[link_ss]][$res->fields[seme_year_seme]]+=$res->fields[ss_score]*$res->fields[rate];
			//����`�[�v��
			$rate[$res->fields[student_sn]][$res->fields[link_ss]][$res->fields[seme_year_seme]]+=$res->fields[rate];
			$res->MoveNext();
		}

		//�B�z�U�Ǵ���쥭��
		$IS5=false;
		$IS7=false;
		while(list($sn,$v)=each($subj_score)) {
			$sys=array();
			reset($v);
			while(list($link_ss,$vv)=each($v)) {
				reset($vv);
				$ls=$sslk[$link_ss];
				if($ls){  //�Ǵ����Z�p��ư��E�~�@�e������"�D�w�]�����"�P"�u�ʽҵ{"(�D���j�ΤC�j���) �����Z 
					if($ls=="life") $IS5=true;
					if($ls=="art") $IS7=true;
					//�p��U���Ǵ����Z
					while(list($seme_year_seme,$s)=each($vv)) {
						$fin_score[$sn][$ls][$seme_year_seme][score]=number_format($s/$rate[$sn][$link_ss][$seme_year_seme],$precision);
						$fin_score[$sn][$ls][$seme_year_seme][rate]=$rate[$sn][$link_ss][$seme_year_seme];

						//$FIN_SCORE_RATE_MODE=1���[�v����  0����ƥ���   ���]���~�`�����[�v�ƨӦۭ�l��إ[�v��   ���`�N�U�Ǵ��[�v�O�_�X�z  ��p  �e�@�Ǵ��H100 200  500 �]�w   �����@�Ǵ��H�`�� 2  3 6  �]�w  �p���|�y����@�Ǵ����ӻ�즨�Z�񭫥��Ű��D
						if($FIN_SCORE_RATE_MODE=='1') {
							//��첦�~�`���Z
							$fin_score[$sn][$ls][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score]*$rate[$sn][$link_ss][$seme_year_seme];
							//��첦�~�`����
							$fin_score[$sn][$ls][total][rate]+=$rate[$sn][$link_ss][$seme_year_seme];
						} else {
							$fin_score[$sn][$ls][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score];
							$fin_score[$sn][$ls][total][rate]+=1;
						}

						//��Ǵ��Ǵ��`�����B�z
						if ($ls=="chinese" || $ls=="local" || $ls=="english") {
							//�y����S�O�B�z����
							if ($sys[$seme_year_seme]!=1) $sys[$seme_year_seme]=1;
							$fin_score[$sn][language][$seme_year_seme][score]+=$fin_score[$sn][$ls][$seme_year_seme][score]*$fin_score[$sn][$ls][$seme_year_seme][rate];
							$fin_score[$sn][language][$seme_year_seme][rate]+=$fin_score[$sn][$ls][$seme_year_seme][rate];
						} else {

							if($FIN_SCORE_RATE_MODE=='1') {
								$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score]*$rate[$sn][$link_ss][$seme_year_seme];
								$fin_score[$sn][$seme_year_seme][total][rate]+=$rate[$sn][$link_ss][$seme_year_seme];
							} else {
								$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score];
								$fin_score[$sn][$seme_year_seme][total][rate]+=1;
							}
						}
					}
				}
				$fin_score[$sn][$ls][avg][score]=number_format($fin_score[$sn][$ls][total][score]/$fin_score[$sn][$ls][total][rate],$precision);

				//�� ����y��  �m�g�y��  �^�y  �M �u�ʽҵ{ �~   �N��L��쥭�����Z�[�J"���~"�`���Z
				if ($ls!="chinese" && $ls!="local" && $ls!="english" && $ls!="") {
					if($FIN_SCORE_RATE_MODE=='1') {
						$fin_score[$sn][total][score]+=$fin_score[$sn][$ls][total][score];
						$fin_score[$sn][total][rate]+=$fin_score[$sn][$ls][total][rate];
					} else {
						$fin_score[$sn][total][score]+=$fin_score[$sn][$ls][avg][score];
						$fin_score[$sn][total][rate]+=1;
//echo $sn."---".$fin_score[$sn][total][score]." --- ".$fin_score[$sn][$ls][avg][score]."---".$fin_score[$sn][total][rate]."<BR>";
					}
					//�P�_�ή����
					if ($fin_score[$sn][$ls][avg][score] >= 60) $fin_score[$sn][succ]++; else  $fin_score[$sn][fail]++;
				}
			}


			//�ͬ���즨�Z�S�O�B�z
			if($IS5 && $IS7) {
				$fin_score[$sn][art][total][score]+=$fin_score[$sn][life][avg][score]*$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][nature][total][score]+=$fin_score[$sn][life][avg][score]*$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][social][total][score]+=$fin_score[$sn][life][avg][score]*$fin_score[$sn][life][total][rate]/3;

				$fin_score[$sn][art][total][rate]+=$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][nature][total][rate]+=$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][social][total][rate]+=$fin_score[$sn][life][total][rate]/3;

				$fin_score[$sn][art][avg][score]=number_format($fin_score[$sn][art][total][score]/$fin_score[$sn][art][total][rate],$precision);
				$fin_score[$sn][nature][avg][score]=number_format($fin_score[$sn][nature][total][score]/$fin_score[$sn][nature][total][rate],$precision);
				$fin_score[$sn][social][avg][score]=number_format($fin_score[$sn][social][total][score]/$fin_score[$sn][social][total][rate],$precision);
			}


			//�y���즨�Z�S�O�W�߭p��
			if (count($sys)>0) {
				$r=0;
				while(list($seme_year_seme,$s)=each($sys)) {
					$fin_score[$sn][language][$seme_year_seme][score]=number_format($fin_score[$sn][language][$seme_year_seme][score]/$fin_score[$sn][language][$seme_year_seme][rate],$precision);


					if($FIN_SCORE_RATE_MODE=='1')	{
						$fin_score[$sn][language][avg][score]+=$fin_score[$sn][language][$seme_year_seme][score]*$fin_score[$sn][language][$seme_year_seme][rate];
						$fin_score[$sn][language][total][score]+=$fin_score[$sn][language][$seme_year_seme][score]*$fin_score[$sn][language][$seme_year_seme][rate];
						$fin_score[$sn][language][total][rate]+=$fin_score[$sn][language][$seme_year_seme][rate];



						$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][language][$seme_year_seme][score]*$fin_score[$sn][language][$seme_year_seme][rate];
						$r+=$fin_score[$sn][language][$seme_year_seme][rate];
		//echo $sn."---".$r."---".$fin_score[$sn][language][$seme_year_seme][rate]."---".$fin_score[$sn][language][avg][score]."<BR>";
						$fin_score[$sn][$seme_year_seme][total][rate]+=$fin_score[$sn][language][$seme_year_seme][rate];
					} else {
						$fin_score[$sn][language][avg][score]+=$fin_score[$sn][language][$seme_year_seme][score];
						$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][language][$seme_year_seme][score];
						$r+=1;
						$fin_score[$sn][$seme_year_seme][total][rate]+=1;
					}
					$fin_score[$sn][$seme_year_seme][avg][score]=number_format($fin_score[$sn][$seme_year_seme][total][score]/$fin_score[$sn][$seme_year_seme][total][rate],$precision);
				}

				$fin_score[$sn][language][avg][score]=number_format($fin_score[$sn][language][avg][score]/$r,$precision);
				if($FIN_SCORE_RATE_MODE=='1')	{
					$fin_score[$sn][total][score]+=$fin_score[$sn][language][avg][score]*$r;
					$fin_score[$sn][total][rate]+=$r;
				} else {
					$fin_score[$sn][total][score]+=$fin_score[$sn][language][avg][score];
					$fin_score[$sn][total][rate]+=1;
				}

				$fin_score[$sn][avg][score]=number_format($fin_score[$sn][total][score]/$fin_score[$sn][total][rate],$precision);
				//�ƻs��ƦW�}�C
				$rank_score[$sn]=$fin_score[$sn]['total']['score'];


				if ($fin_score[$sn][language][avg][score] >= 60) $fin_score[$sn][succ]++;else $fin_score[$sn][fail]++;
			}

			if ($succ) {
				if ($fin_score[$sn][succ] < $succ) $show_score[$sn]=$fin_score[$sn];
			}
      
      //�w��̫ᵲ�G���Ƨ�
			arsort($rank_score);
			//�p��W��
			$rank=0;
			foreach($rank_score as $key=>$value) {
				$rank+=1;
				$fin_score[$key]['total']['rank']=$rank;
			}

		}


		if ($succ)
			return $show_score;
		else
			return $fin_score;
	} elseif (count($student_sn)==0) {
		return "�S���ǤJ�ǥͬy����";
	} else {
		return "�S���ǤJ�Ǵ�";
	}
}

function cal_fin_nor_score($student_sn=array(),$seme=array(),$mode="")
{
	global $CONN;
	if (count($student_sn)>0 && count($seme)>0) {
		$all_sn="'".implode("','",$student_sn)."'";
		$all_seme="'".implode("','",$seme)."'";
		$query="select * from stud_seme_score_nor where student_sn in ($all_sn) and seme_year_seme in ($all_seme) and ss_id='0'";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$fin_score[$res->fields[student_sn]][$res->fields[seme_year_seme]][score]=number_format($res->fields[ss_score],$precision);
			if ($mode=="word") $fin_score[$res->fields[student_sn]][$res->fields[seme_year_seme]][word]=$res->fields[ss_score_memo];
			$res->MoveNext();
		}
		$s_num=count($seme);
		while(list($sn,$v)=each($fin_score)) {
			while(list($seme_year_seme,$vv)=each($v)) {
				if ($vv[score] != "") {
					$s=$vv[score];
					settype($s,"double");
					if ($s < 0 ) {
						//�L�ʧ@
					} elseif ($s <= 100) {
						$fin_score[$sn][total][score]+=$s;
					} else {
						$fin_score[$sn][total][score]+=100;
					}
					$fin_score[$sn][num]++;
					if ($s < 60) $fin_score[$sn][dissucc]++;
				}
			}
			$fin_score[$sn][avg][score]=number_format($fin_score[$sn][total][score]/$fin_score[$sn][num],$precision);
			if ($mode=="disgrad" && $fin_score[$sn][dissucc]>0) $show_score[$sn]=$fin_score[$sn];
		}
		if ($mode=="disgrad") {
			return $show_score;
		} else {
			return $fin_score;
		}
	} elseif (count($student_sn)==0) {
		return "�S���ǤJ�ǥͬy����";
	} else {
		return "�S���ǤJ�Ǵ�";
	}
}

function get_nor_score($sel_year="",$sel_seme="",$sel_stage="",$class_subj="",$teacher_sn="",$precision="")
{
	global $CONN;
	if($precision==='') $precision=2;

	if ($sel_year=="") {
		$data_arr[err]="�S���ǤJ�Ǧ~";
	} elseif ($sel_seme=="") {
		$data_arr[err]="�S���ǤJ�Ǵ�";
	} elseif ($sel_stage=="") {
		$data_arr[err]="�S���ǤJ���q";
	} elseif ($class_subj=="") {
		$data_arr[err]="�S���ǤJ�ҵ{�N�X";
	} elseif ($teacher_sn=="") {
		$data_arr[err]="�S���ǤJ�Юv�N�X";
	} else {
		$nor_score="nor_score_".$sel_year."_".$sel_seme;
		$query = "select distinct * from $nor_score where class_subj='$class_subj' and stage='$sel_stage' and enable='1' group by class_subj,stage,freq";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$data_arr[status][$res->fields[stage]][$res->fields[freq]][name]=$res->fields[test_name];
			$data_arr[status][$res->fields[stage]][$res->fields[freq]][weighted]=$res->fields[weighted];
			$data_arr[status][$res->fields[stage]][$res->fields[freq]][teach_id]=$res->fields[teach_id];
			$res->MoveNext();
		}
		$query = "select a.* from $nor_score a,stud_base b where a.stud_sn=b.student_sn and a.class_subj='$class_subj' and a.stage='$sel_stage' and b.stud_study_cond in ('0','15') and a.enable='1' order by b.curr_class_num,a.sn";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$data_arr[score][$res->fields[stage]][$res->fields[freq]][$res->fields[stud_sn]]=$res->fields[test_score];
			if ($res->fields[test_score]!="-100") {
				$data_arr[score][$res->fields[stage]][avg][$res->fields[stud_sn]]+=$res->fields[test_score]*$data_arr[status][$res->fields[stage]][$res->fields[freq]][weighted];
				$data_arr[score][$res->fields[stage]][weighted][$res->fields[stud_sn]]+=$data_arr[status][$res->fields[stage]][$res->fields[freq]][weighted];
			}
			$res->MoveNext();
		}
		reset($data_arr[score]);
		while(list($stage,$v)=each($data_arr[score])) {
			reset($data_arr[score][$stage][avg]);
			while(list($sn,$vv)=each($data_arr[score][$stage][avg])) {
				if (!empty($data_arr[score][$stage][avg][$sn])) {
					if ($data_arr[score][$stage][weighted][$sn]>0) $data_arr[score][$stage][avg][$sn]=number_format($data_arr[score][$stage][avg][$sn]/$data_arr[score][$stage][weighted][$sn],$precision);
				}
			}
		}
	}
	return $data_arr;
}

function count_nor($student_sn=array(),$seme=array(),$mode="") {
	global $CONN,$_POST;

	if (count($student_sn)>0 && count($seme>0)) {
		$all_sn="'".implode("','",$student_sn)."'";
		$all_seme="'".implode("','",$seme)."'";
		$stud_id=array();
		$query="select * from stud_base where student_sn in ($all_sn)";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$stud_id[]=$res->fields['stud_id'];
			$id2sn[$res->fields['stud_id']]=$res->fields['student_sn'];
			$res->MoveNext();
		}
		if (count($stud_id)>0) {
			$all_id="'".implode("','",$stud_id)."'";
			$data_arr=array();
			if ($mode==0) {
				//$query="select * from stud_seme_abs where seme_year_seme in ($all_seme) and stud_id in ($all_id) and abs_kind in ('1','2','3') order by stud_id";
				//2015.03.03 by smallduh ,�̾ڱШ|���̷s�W�w �f�����C�J�ײ��~����p�� array("�ư�"=>"1","�f��"=>"2","�m��"=>"3","���|"=>"4","����"=>"5","��L"=>"6","�ల"=>"6");
				$query="select * from stud_seme_abs where seme_year_seme in ($all_seme) and stud_id in ($all_id) and abs_kind in ('1','3') order by stud_id";
				$res=$CONN->Execute($query);
				$dis=0;
				$sday=intval($_POST['semeday']);
				$sday2=intval($_POST['semeday2']);
				$d_arr=array();
				while(!$res->EOF) {
					$sn=$id2sn[$res->fields[stud_id]];
					if ($osn==0) $osn=$sn;
					if ($osn!=$sn) {
						if ($dis==1) $data_arr[$osn]=$d_arr;
						$dis=0;
						$d_arr=array();
						$osn=$sn;
					}
					$sms=$res->fields['seme_year_seme'];
					$kind=$res->fields['abs_kind'];
					$days=$res->fields['abs_days'];
					$d_arr[$sms][abs][$kind]+=$days;
					$d_arr[$sms][abs][all]+=$days;
					if ($_POST['chk1'] && $kind==3 && $days>=$sday) $dis=1;
					if ($_POST['chk2'] && $d_arr[$sms][abs][all]>=$sday2) $dis=1;
					$res->MoveNext();
				}
				if ($osn && $dis) $data_arr[$osn]=$d_arr;
			}
			if ($mode==1) {
				if (intval($_POST['neu'])>0)
					$r_arr=array(0,0,0,0,"-9","-3","-1");
				else
					$r_arr=array(0,9,3,1,"-9","-3","-1");
				$osn=0;
				$dis=0;
				$query="select * from stud_seme_rew where seme_year_seme in ($all_seme) and student_sn in ($all_sn) order by student_sn";
				$res=$CONN->Execute($query);
				while(!$res->EOF) {
					$sn=$res->fields[student_sn];
					if ($osn==0) $osn=$sn;
					if ($osn!=$sn) {
						if ($d_arr[all][rew][all] <= (-27)) $data_arr[$osn]=$d_arr;
						$dis=0;
						$d_arr=array();
						$osn=$sn;
					}
					$sms=$res->fields['seme_year_seme'];
					$kind=$res->fields['sr_kind_id'];
					$r=$res->fields['sr_num']*$r_arr[$kind];
					$d_arr[$sms][rew][$kind]+=$r;
					$d_arr[$sms][rew][all]+=$r;
					$d_arr[all][rew][all]+=$r;
					$res->MoveNext();
				}
				if ($osn && $dis) $data_arr[$osn]=$d_arr;
			}
			return $data_arr;
		}
	} elseif (count($student_sn)==0) {
		return "�S���ǤJ�ǥͬy����";
	} else {
		return "�S���ǤJ�Ǵ�";
	}
}

