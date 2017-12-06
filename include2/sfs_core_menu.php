<?php

// $Id: sfs_core_menu.php 7772 2013-11-15 07:07:28Z smallduh $


//�N�}�C���e�[�J�t�ο��
// $gid -- �ﶵ���O
// $text_name -- �ﶵ�W��
// $temp_arr -- �ﶵ���e 
function join_sfs_text($gid,$text_name,$temp_arr) {
	global $CONN,$DATA_VAR;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if ($text_name=='')
		return false;

	$query = "select t_kind from sfs_text where t_kind='$text_name'";
	$result = $CONN->Execute($query) or trigger_error($CONN->ErrorMsg(), E_USER_ERROR) ;
	if ($result->EOF) {
		$query = "insert into sfs_text(t_kind,g_id,d_id,t_name,p_id) values('$text_name','$gid',0,'$text_name',0)";
		
		$CONN->Execute($query) or trigger_error($query, E_USER_ERROR);
		$query = "select t_id from sfs_text where t_kind='$text_name'";
		$res = $CONN->Execute($query) or trigger_error($query, E_USER_ERROR);
		$p_id = $res->fields[0];
		while (list($tid,$val) = each($temp_arr)) {
			$i++;
			//if (strtolower($DATA_VAR[character_set]) == 'big5')
			//$val = myAddSlashes($val);
			$val = AddSlashes($val);	
			$query = "insert into sfs_text(t_kind,g_id,d_id,t_name,t_parent,p_id,p_dot,t_order_id) values('$text_name',$gid,'$tid','$val','$p_id,',$p_id,'.',$i)";
			
			$CONN->Execute($query) or trigger_error($query, E_USER_ERROR);
		}
	}
	return true;
}

function myAddSlashes($st) {
if (get_magic_quotes_gpc()) {
return $st;
} else {
return AddSlashes($st);
}
} 

//�U�Կ����


//���o���~�Юv���U�Կ��
function &select_teacher($col_name="teacher_sn",$teacher_sn="",$enable='1',$sel_year="",$sel_seme="",$jump_fn="",$day="",$sector=""){
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
	$where=($enable=='1')?"where teach_condition='0'":"";
	$sql_select = "select name,teacher_sn from teacher_base $where";
	$recordSet=$CONN->Execute($sql_select) or trigger_error($query, E_USER_ERROR);
	$option="<option value='0'></option>";

	$jump=(!empty($jump_fn))?" onChange='$jump_fn()'":"";

	while (list($name,$tsn) = $recordSet->FetchRow()) {
		//�Юv�b�Ӱ󪺱½Ҧ��ơA�Y>2��ܽİ�C
		if(!empty($day) and !empty($sector)){
			$tcn=get_teacher_course_num($sel_year,$sel_seme,$tsn,$day,$sector);
		}
		//�Y�w�g���ҡA�H�Ǧ����
		$color=($tcn>=1)?"#D7D7D7":"#000000";
		$selected=($tsn==$teacher_sn)?"selected":"";
		$option.="<option value='$tsn' $selected style='color: $color'>$name</option>\n";
	}

	$select_teacher="
	<select name='$col_name' $jump>
	$option
	</select>";
	return $select_teacher;
}

//���o���~�Юv���}�C
function &select_teacher_arr($enable='1',$sel_year="",$sel_seme="",$sector=""){
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
	$where=($enable=='1')?"where teach_condition='0'":"";
	$sql_select = "select name,teacher_sn from teacher_base $where";
	$recordSet=$CONN->Execute($sql_select) or trigger_error($query, E_USER_ERROR);

	while (list($name,$tsn) = $recordSet->FetchRow()) {
		//�Юv�b�Ӱ󪺱½Ҧ��ơA�Y>2��ܽİ�C
		if(!empty($day) and !empty($sector)){
			$tcn=get_teacher_course_num($sel_year,$sel_seme,$tsn,$day,$sector);
		}
		//�Y�w�g���ҡA�H�Ǧ����
		$color=($tcn>=1)?"#D7D7D7":"#000000";
		$selected=($tsn==$teacher_sn)?"selected":"";
		$option.="<option value='$tsn' $selected style='color: $color'>$name</option>\n";
	}

	$select_teacher="
	<select name='$col_name' $jump>
	$option
	</select>";
	return $select_teacher;
}


//�s�@�~�ŤU�Կ��
function &get_class_year_select($sel_year="",$sel_seme="",$Cyear="",$jump_fn="",$col_name="Cyear"){
	global $CONN,$school_kind_name,$school_kind_color;

	$class_year_array=get_class_year_array($sel_year,$sel_seme);

	if(sizeof($class_year_array)<1){
		$msg="��Ʈw���䤣�� $sel_year �Ǧ~�A�� $sel_seme �Ǵ����Z�θ�ơC<p>
		�Х��i�� $sel_year �Ǧ~�A�� $sel_seme �Ǵ���
		<a href='".$SFS_PATH."/modules/every_year_setup/class_year_setup.php?act=setup&sel_year=$sel_year&sel_seme=$sel_seme'>
		�Z�ų]�w</a>�A�~���~��i��C</p>";
		trigger_error("�L�k���o�Ӧ~�Ū��Z�ų]�w�G $msg", 256);
	}
	
	$class_option="";
	//���o�~�Ű}�C
	reset($class_year_array);
	while(list($i,$v)=each($class_year_array)){
		$selected=($Cyear==$class_year_array[$i])?"selected":"";
		$c_year=$class_year_array[$v];
    	$class_option.="<option value='$c_year' $selected style='background-color: $school_kind_color[$c_year];'>$school_kind_name[$c_year]</option>\n";
	}
	
	if(empty($class_option))trigger_error("�d�L�~�Ÿ��", E_USER_ERROR);
	
	$jump=(!empty($jump_fn))?" onChange='$jump_fn()'":"";

	//�s�@�~�ſ��
	$class_year_list="
	<select name='$col_name' $jump>
	<option value=''>�п�~��</option>
	$class_option
	</select>
	";
	return $class_year_list;
}


//�~�ũίZ�ŤU�Կ��
function &get_class_select($sel_year="",$sel_seme="",$Cyear="",$col_name="class_id",$jump_fn="",$curr_class_id="",$mode="��",$option1="�п�ܯZ��"){
	global $CONN,$school_kind_name,$school_kind_color;

	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	//���p�~�Ŧ�m���O�Ū��A�h�ȦC�X�Ӧ~�ſ��
	$and_Cyear=($Cyear == '')?"":" and c_year='$Cyear'";
	$sql_select = "select class_id,c_year,c_name from school_class where year='$sel_year' and semester = '$sel_seme' and enable='1' $and_Cyear order by c_year,c_sort";
	$class_name_option="";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error($sql_select, E_USER_ERROR);
	while(list($class_id,$c_year,$c_name) = $recordSet->FetchRow()){
		$selected=($curr_class_id==$class_id)?"selected":"";
		$class_name_option.=($mode=="�u")?"<option value='$class_id' $selected style='background-color: $school_kind_color[$c_year]'></option>\n":"<option value='$class_id' $selected style='background-color: $school_kind_color[$c_year];'>".$school_kind_name[$c_year]."".$c_name."�Z</option>\n";
	}
	if(empty($class_name_option))trigger_error("�d�L�Z�Ÿ��", E_USER_ERROR);

	$jump=(!empty($jump_fn))?" onChange='$jump_fn()'":"";

	$class_name_list="
	<select name='$col_name' $jump>
	<option value=''>$option1
	$class_name_option
	</select>";
	return $class_name_list;
}


//�Y�~�ΦU�~�Z�ŤU�Կ��]�Q�Ϊ��󪺤覡�^
function &classSelect($sel_year="",$sel_seme="",$Cyear="",$col_name="class_id",$curr_class_id="",$is_submit=true){
	global $CONN,$school_kind_name,$school_kind_color;

	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	//���p�~�Ŧ�m���O�Ū��A�h�ȦC�X�Ӧ~�ſ��
	$and_Cyear=(!is_int($Cyear))?"":" and c_year='$Cyear'";
	$sql_select = "select class_id,c_year,c_name from school_class where year='$sel_year' and semester = '$sel_seme' and enable='1' $and_Cyear order by c_year,c_sort";
	$recordSet=$CONN->Execute($sql_select)  or user_error($sql_select, 256);
	while(list($class_id,$c_year,$c_name) = $recordSet->FetchRow()){
		$class_array[$class_id]=$school_kind_name[$c_year]."".$c_name."�Z";
	}
	
	if(sizeof($class_array)<=0){
		user_error("�d�L�Z�Ÿ��", 256);
	}
	$ds=new drop_select();
	$ds->s_name=$col_name; //���W��
	$ds->id=$curr_class_id;	//����ID
	$ds->arr = $class_array; //���e�}�C
	$ds->has_empty = true; //���C�X�ť�
	$ds->top_option = "�п�ܯZ��";
	$ds->bgcolor = "#FFFFFF";
	$ds->font_style = "font-size:12px";
	$ds->is_submit = $is_submit; //��ʮɰe�X�d��
	$class_name_list=$ds->get_select();

	return $class_name_list;
}


//���o�~�׻P�Ǵ����U�Կ��
function &date_select($sel_year,$sel_seme,$year_name="sel_year",$seme_name="sel_seme",$jump_fn=""){
	global $CONN,$class_year;
	
	//�۰ʿ�ܾǦ~�A�Ǵ�
	$selected1=($sel_seme=='1')?"selected":"";
	$selected2=($sel_seme=='2')?"selected":"";
	$jump=(!empty($jump_fn))?" onChange='$jump_fn()'":"";
	$main="
	<input type='text' name='$year_name' size='3' value='$sel_year'> �Ǧ~�סA
	<select name='$seme_name' $jump>
	<option value='1' $selected1>�W</option>
	<option value='2' $selected2>�U</option>
	</select>�Ǵ�
	";
	return $main;
}


//�q�Z�ų]�w���A��X�w�g�]�w�n���Ǵ��M�Ǧ~���U�Կ��
function &class_ok_setup_year($sel_year,$sel_seme,$name="year_seme",$jump_fn=""){
	global $CONN;

	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$jump=(!empty($jump_fn))?" onChange='$jump_fn()'":"";
	$sql_select = "select year,semester from school_class where enable='1' order by year,semester";
	$recordSet=$CONN->Execute($sql_select) or user_error($sql_select, 256);
	$other_year=array();
	$option="";
	while(list($year,$semester)=$recordSet->FetchRow()){
		$semester_name=($semester=='2')?"�U":"�W";
		$ys=$year."�Ǧ~".$semester_name."�Ǵ�";

		//�s�@��L�Ǧ~�Ǵ������
		if(!in_array($ys,$other_year)){
			$other_year[$i]=$ys;
			$selected=($year==$sel_year and $semester==$sel_seme)?"selected":"";
			$option.="<option value='".$year."-".$semester."' $selected>$ys</option>";
			$i++;
		}
	}
	if(empty($option))trigger_error("�d�L����Ǵ����", 256);
	
	$main="<select name='$name' $jump>
	$option
	</select>";
	return $main;
}

?>
