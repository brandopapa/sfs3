<?php
//$Id: function.php 5310 2009-01-10 07:57:56Z hami $

//���Ү榡��
function make_list($array=array(),$txt="",$other_title="",$other=array(),$table=true){

	
	$main=($table)?"<table cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>":"";
	
	$main.="<tr bgcolor='#DFEFAF'><td>".$txt."����</td><td>���ҭȽd��</td>$other_title</tr>";
	foreach($array as $kind=>$v){
		$other_main="";
		foreach($other[$kind] as $o){
			$other_main.="<td>$o</td>";
		}
		$main.="<tr bgcolor='#FFFFFF'><td nowrap>{".$kind."}</td><td><font color=blue>$v</font></td>$other_main</tr>";
	}
	$main.=($table)?"</table>":"";
	return $main;
}

//���Z��U�Կﶵ
function score_paper_option(){
	global $CONN;
	$main="";
	$sql_select="select sp_sn,sp_name,descriptive from score_paper where enable='1'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($sp_sn,$sp_name,$descriptive)=$recordSet->FetchRow()) {
		$main.="<option value='$sp_sn'>$sp_name</option>";
	}
	
	return $main;
}

//�^���X����
function get_mark($data=array(),$other=""){
	
	if(!empty($other)){
		foreach($other as $key=>$v){
			$temp_arr.="{".$key."}\n";
			foreach($v as $vv){
				$temp_arr.=$vv."\n";
			}
		}
		$temp_arr.="\n\n";
	}else{
		foreach($data as $key=>$v){
			$temp_arr.="{".$key."}";
		}
		$temp_arr.="\n\n";
	}
	return $temp_arr;
}

//���o�Ǯո��
function get_school_base_array(){
	global $CONN;
	$sql_select = "select * from school_base";
	$recordSet=$CONN->Execute($sql_select);
	$school_data = $recordSet->FetchRow();
	
	$school['�ݩ�']=$school_data["sch_attr_id"];
	$school['�����O']=$school_data["sch_sheng"];
	$school['�Ǯե���']=$school_data["sch_cname"];
	$school['�Ǯ�²��']=$school_data["sch_cname_s"];
	$school['�Ǯ�²��']=$school_data["sch_cname_ss"];
	$school['�Ǯզa�}']=$school_data["sch_addr"];
	$school['�Ǯչq��']=$school_data["sch_phone"];
	$school['�Ǯնǯu']=$school_data["sch_fax"];
	
	return $school;
}

//���o�ҵ{�}�C
function ss_array($year="",$seme="",$cyear="",$class_id=""){
        global $CONN;
        
        //���o���W��
        $subject_name_arr=&get_subject_name_arr();
        
		if(!empty($class_id)){
			$andwhere="and class_id='$class_id'";
		}else{
			$andwhere="and class_year='$cyear'";
		}
		
        $sql_select = "select * from score_ss where year='$year' and semester='$seme' and enable='1' $andwhere order by ss_id";
        
		$recordSet = $CONN->Execute($sql_select) or trigger_error("SQL ���~",E_USER_ERROR);
		while ($subject=$recordSet->FetchRow()) {
			$scope_id=$subject[scope_id];
			$subject_id=$subject[subject_id];
			//���o���W��
			$scope_name=$subject_name_arr[$scope_id][subject_name];
			
			//���o�Ǭ�W��
			$subject_name=(!empty($subject_id))?$subject_name_arr[$subject_id][subject_name]:"";
	
			$show_ss=(empty($subject_name))?$scope_name:$scope_name."-".$subject_name;
	
			$ss_id=$subject[ss_id];
			$subject['name']=$show_ss;
			$res_arr[$ss_id]=$subject;
		}
		
		if(empty($res_arr) and !empty($class_id)){
			$cyear=substr($class_id,6,2)*1;
			$res_arr=ss_array($year,$seme,$cyear,"");
		}
		
        return $res_arr;
}

//���o�W�Ҥ�ơA�}�Ǥ��end��
function get_all_days($sel_year,$sel_seme,$class_id){
	global $CONN;
	
	$class=class_id_2_old($class_id);
	$cyear=$class[3];
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	
	$sql_select = "select days from seme_course_date where seme_year_seme='$seme_year_seme' and class_year='$cyear'";
	$recordSet = $CONN->Execute($sql_select) or trigger_error("SQL ���~",E_USER_ERROR);
	list($days)=$recordSet->FetchRow();
	$mark['�W�Ҥ��']=$days;
	
	$sql_select = "select day_kind,day from school_day where year='$sel_year' and seme='$sel_seme'";
	$recordSet = $CONN->Execute($sql_select) or trigger_error("SQL ���~",E_USER_ERROR);
	while(list($day_kind,$day)=$recordSet->FetchRow()){
		if($day_kind=="start"){
			$mark['���Ǵ��}�Ǥ�']=$day;
		}elseif($day_kind=="end"){
			$mark['���Ǵ�������']=$day;
		}
	}
	
	return $mark;
}

//���o�Z�ŤέӤH���
function get_stud_base_array($class_id,$stud_id){
	global $CONN;
	$c=class_id_2_old($class_id);
	
	$class['�Ǧ~']=$c[0];
	$class['�Ǵ�']=($c[1]=='1')?"�W":"�U";
	$class['�~��']=$c[3];
	$class['�Z']=$c[4];
	$class['�Z��']=$c[5];
	$teacher=get_class_teacher($c[2]);
	$class['�ɮv']=$teacher[name];
	//���o���w�ǥ͸��
	$stu=get_stud_base("",$stud_id);
	$class['�ǥͩm�W']=$stu['stud_name'];
	$class['�y��']=substr($stu['curr_class_num'],-2,2);
	$class['�Ǹ�']=$stud_id;
	$class['�ʧO']=($stu['stud_sex']=='1')?"�k":"�k";
	$class['�ͤ�']=$stu['stud_birthday'];
	$class['�����Ҹ�']=$stu['stud_person_id'];
	$class['�ǥͦa�}�@']=$stu['stud_addr_1'];
	$class['�ǥͦa�}�G']=$stu['stud_addr_2'];
	$class['�ǥ͹q�ܤ@']=$stu['stud_tel_1'];
	$class['�ǥ͹q�ܤG']=$stu['stud_tel_2'];
	return $class;
}

// �۰ʨ��o�E�~�@�e���Z
function get_ss9_array($sel_year,$sel_seme,$stud_id,$student_sn,$class_id) {
	global $CONN,$ss9;
	//���o���W��
    $subject_name_arr=&get_subject_name_arr();
        
	$class=class_id_2_old($class_id);
	$cyear=$class[3];
	
	// ���o�V�O�{�פ�r�ԭz
	$oth_data=get_oth_value($stud_id,$sel_year,$sel_seme);
	// ���o�ҵ{�C�g�ɼ�
	$ss_num_arr = get_ss_num_arr($class_id);
	// ���o�ǲߦ��N
	$ss_score_arr =get_ss_score_arr($class,$student_sn);
	
	//���o�P�@��쪺��إ[�v���ƦX�p
	foreach($ss_score_arr as $ssid=>$v){
		$sql_select = "select scope_id,subject_id,need_exam,rate,link_ss from score_ss where  class_year='$cyear' and enable='1' and year = $sel_year and semester='$sel_seme' and ss_id='$ssid'";
		$recordSet = $CONN->Execute($sql_select) or trigger_error("SQL ���~",E_USER_ERROR);
		while(list($scope_id,$subject_id,$need_exam,$rate,$link_ss)=$recordSet->FetchRow()){

			//���o���W��
			$scope_name=$subject_name_arr[$scope_id][subject_name];
			
			//���o�Ǭ�W��
			$subject_name=(!empty($subject_id))?$subject_name_arr[$subject_id][subject_name]:"";
	
			$show_ss=(empty($subject_name))?$scope_name:$subject_name;
			
			//��n�������حp��i��
			if($need_exam=='1'){
				//�p����즨�Z
				$score_tmp=$ss_score_arr[$ssid][ss_score];
				//�p���즨�Z
				$score_rate[$link_ss]+=$score_tmp*$rate;
				
				//�p�����`�[�v��
				$all_rate[$link_ss]+=$rate;
				//�p�����`�`��
				$all_ss_num[$link_ss]+=$ss_num_arr[$ssid];
				
				//��������[�v��}�C��
				$rate_txt[$link_ss][]=$rate;
				//����������y��}�C��
				$p_txt[$link_ss][]=$ss_score_arr[$ssid]['ss_score_memo'];
				//��������V�O�{�ר�}�C��
				$nl_txt[$link_ss][]=$oth_data["�V�O�{��"][$ssid];
			}
		}
	}
	
	//�p���@���X��[�v�᪺����
	foreach($score_rate as $ss_name=>$ls_score){
		$score[$ss_name]=round($ls_score/$all_rate[$ss_name],2);
		$score_name[$ss_name]=score2str($score[$ss_name],$class);
		$ss_rate_txt[$ss_name]=implode("<text:line-break/>",$rate_txt[$ss_name]);
		$ss_p_txt[$ss_name]=implode("<text:line-break/>",$p_txt[$ss_name]);
		$ss_nl_txt[$ss_name]=implode("<text:line-break/>",$nl_txt[$ss_name]);
	}

	foreach($ss9 as $ss_name){
		
		$k="�E_".$ss_name;
		$k1=$k."�`��";
		$k2=$k."����";
		$k3=$k."�[�v";
		$k4=$k."����";
		$k5=$k."�V�O�{��";
		$k6=$k."���y";
		
		$main[$k]=$ss_name;
		$main[$k1]=$all_ss_num[$ss_name];
		$main[$k2]=$score[$ss_name];
		$main[$k3]=$ss_rate_txt[$ss_name];
		$main[$k4]=$score_name[$ss_name];
		$main[$k5]=$ss_nl_txt[$ss_name];
		$main[$k6]=$ss_p_txt[$ss_name];
	}

	
	return $main;
}


// ���o���Z
function get_score_array($sel_year,$sel_seme,$stud_id,$student_sn,$class_id) {
	global $CONN;
	
	$class=class_id_2_old($class_id);
	$cyear=$class[3];
	
	// ���o�V�O�{�פ�r�ԭz
	$oth_data=get_oth_value($stud_id,$sel_year,$sel_seme);
	// ���o�ҵ{�C�g�ɼ�
	$ss_num_arr = get_ss_num_arr($class_id);
	// ���o�ǲߦ��N
	$ss_score_arr =get_ss_score_arr($class,$student_sn);
	
	
	//���o��ذ}�C
	$ss_array=ss_array($sel_year,$sel_seme,$cyear,$class_id);
	$yss=array();
	
	foreach($ss_array as $ss_id=>$subject){
		if($subject[need_exam]!='1')continue;
		$k=$subject['name'];
		$yss[$k]=$subject['name'];
		
		$k1=$k."�`��";
		$k2=$k."����";
		$k3=$k."����";
		$k4=$k."�V�O�{��";
		$k5=$k."���y";
		$k6=$k."�[�v";
		
		$score[$k]=$subject['name'];
		$score[$k1]=$ss_num_arr[$ss_id];
		$score[$k2]=$ss_score_arr[$ss_id]['ss_score'];
		$score[$k3]=$ss_score_arr[$ss_id]['score_name'];
		$score[$k4]=$oth_data["�V�O�{��"]["$ss_id"];
		$score[$k5]=$ss_score_arr[$ss_id]['ss_score_memo'];
		$score[$k6]=$subject['rate'];
	}

	
	return $score;
}

//���o�N�g�O�� 
function get_reward_value2($stud_id,$sel_year,$sel_seme) {
	global $CONN;
	$all_kind=stud_rep_kind();
	//"1"=>"�j�\","2"=>"�p�\","3"=>"�ż�","4"=>"�j�L","5"=>"�p�L","6"=>"ĵ�i"
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	$query="select * from reward where reward_year_seme = $seme_year_seme and stud_id='$stud_id'";
	$res = $CONN->Execute($query);
	if(empty($res))return;
	$temp_arr=array();
	while(!$res->EOF){
		$reward_kind=$res->fields['reward_kind'];
		//���y���O
		if($reward_kind=="1"){
			$reward['�ż�']++;
		}elseif($reward_kind=="1"){
			$reward['�ż�']++;
		}elseif($reward_kind=="2"){
			$reward['�ż�']+=2;
		}elseif($reward_kind=="3"){
			$reward['�p�\\']++;
		}elseif($reward_kind=="4"){
			$reward['�p�\\']+=2;
		}elseif($reward_kind=="5"){
			$reward['�j�\\']++;
		}elseif($reward_kind=="6"){
			$reward['�j�\\']+=2;
		}elseif($reward_kind=="7"){
			$reward['�j�\\']+=3;
		}elseif($reward_kind=="-1"){
			$reward['ĵ�i']++;
		}elseif($reward_kind=="-2"){
			$reward['ĵ�i']+=2;
		}elseif($reward_kind=="-3"){
			$reward['�p�L']++;
		}elseif($reward_kind=="-4"){
			$reward['�p�L']+=2;
		}elseif($reward_kind=="-5"){
			$reward['�j�L']++;
		}elseif($reward_kind=="-6"){
			$reward['�j�L']+=2;
		}elseif($reward_kind=="-7"){
			$reward['�j�L']+=3;
		}
				
		$res->MoveNext();
	}
	
	foreach($all_kind as $v){
		$val=(empty($reward[$v]))?0:$reward[$v];
		$temp_arr[$v]=$val;
	}
	
	return $temp_arr;
	
}

//���o�ͬ���{���q
function get_performance_value($stud_id,$sel_year,$sel_seme){
	global $performance;
	$oth_data=get_oth_value($stud_id,$sel_year,$sel_seme);
	foreach($performance as $id=>$sk){
		$oth_array[$sk]=$oth_data['�ͬ���{���q'][$id];
	}
	return $oth_array;
}

//�R���ؿ�
function deldir($dir){
	$current_dir = opendir($dir);
	while($entryname = readdir($current_dir)){
		if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
			deldir("${dir}/${entryname}");
		}elseif($entryname != "." and $entryname!=".."){
			unlink("${dir}/${entryname}");
		}
	}
	closedir($current_dir);
	rmdir(${dir});
}
?>
