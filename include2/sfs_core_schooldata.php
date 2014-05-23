<?php

// $Id: sfs_core_schooldata.php 7734 2013-10-29 11:42:30Z smallduh $
//-------------------------------------------
// �� core API �禡�w�]�t�H�U�����禡�϶��A���ǦP�U�G
// 1. �Ǯո�� ����
// 2. �Ǧ~/�Ǵ�/�~�� ��Ƭ���
// 3. �Z�� ����
// 4. �Юv��� ����
//-------------------------------------------


//-------------------------------------------
// 1. �Ǯո�� ����
//-------------------------------------------

//���o�Ǯհ򥻸��

function get_school_base(){ 
	global $CONN; 
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256); 

	$sql_select = "select * from school_base"; 

	$rs = $CONN->Execute($sql_select) ; 
	if ($rs and $ro=$rs->FetchNextObject(false)) { 
		$arr=get_object_vars($ro); 
	}
	return $arr; 
}

//-------------------------------------------
// 2. �Ǧ~/�Ǵ�/�~�� ��Ƭ���
//-------------------------------------------
//�ثe�Ǧ~
function curr_year($date="",$sp="-"){
	global $SFS_SEME1,$CONN;
	//�H�}�l��]�w�^��
	$query = "select * from school_day where  day<=now() and day_kind='start' order by day desc limit 1";
	$res = $CONN->Execute($query);
	return $res->fields[year];
	/*
	if(!empty($date)){
		$d=explode($sp,$date);
		$y=$d[0];
		$m=$d[1];
	}else{
		$y=date("Y");
		$m=date("m");
	}

		
	if( $m < $SFS_SEME1 )
		return $y-1912;
	else
		return $y-1911;
	*/
}

//�ثe�Ǵ�
function curr_seme($date="",$sp="-"){ 
	global $SFS_SEME1,$SFS_SEME2,$CONN;
	//�H�}�l��]�w�^��
	$query = "select * from school_day where  day<=now() and day_kind='start' order by day desc limit 1";
	$res = $CONN->Execute($query);
	return $res->fields[seme];
	/*
	if(!empty($date)){
		$d=explode($sp,$date);
		$m=$d[1];
	}else{
		$m=date("m");
	}
	
	if( $m < $SFS_SEME1 and $m > ($SFS_SEME2-1))
		return 2;
	else
		return 1;
	*/
}

//�ثe�Ǵ����}�Ǥ�H�ε�����
function curr_year_seme_day($sel_year="",$sel_seme=""){ 
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);


	$sel_year=intval($sel_year);
	if ($sel_year==0) $sel_year=curr_year();
	$sel_seme=intval($sel_seme);
	if ($sel_seme==0) $sel_seme=curr_seme();
	$sql_select="select day_kind,day from school_day where year='$sel_year' and seme='$sel_seme'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

	// init $main
	$main=array();

	while(list($day_kind,$day)=$recordSet->FetchRow()){
		$main[$day_kind]=$day;
	}
	return $main;
}

//���o�Ǵ��Y�~�Ū��W�Ҥ� �Ǧ^�}�C day['yyyy-dd-mm']=1 ;  $DAY['School_days']=
function get_school_days($seme_year_seme,$class_year){ 
 global $CONN;
	$query="select school_days from seme_course_date where seme_year_seme='$seme_year_seme' and class_year='$class_year'";
	$res=$CONN->Execute($query) or die ('SQL Error! query='.$query);
 if ($res->RecordCount()>0) {
	 $DAY=unserialize($res->fields['school_days']); 		//�Ѷ}�ܦ��}�C
	 //$DAY['School_days']=count($DAY); 								//�ǥͤW�Ǥ��	 
 		$i=0;
		foreach($DAY as $k=>$v) {
		 if ($v=='1') $i++;
		} 
		$DAY['School_days']=$i; 													//�ǥͤW�Ǥ��	 
 } else {
   $DAY['School_days']=0;															//�ǥͤW�Ǥ�
 }
	
	return $DAY;
 
} // end functions

//�Ǧ^�g���}�C
//����[0]���ثe�g��, ����[1]�H�ᬰ�g���}�l��
function get_week_arr($sel_year="",$sel_seme="",$now_date="") {
	global $CONN;

	if ($sel_year=="") $sel_year=curr_year();
	if ($sel_seme=="") $sel_seme=curr_seme();
	if ($now_date=="") $now_date=date("Y-m-d");
	$temp_arr=array();
	$temp_arr[0]=0;
	$res=$CONN->Execute("select count(*) as num from week_setup where year='$sel_year' and semester='$sel_seme'");
	$r_num=$res->fields['num'];
	if ($r_num) {
		$res=$CONN->Execute("select * from week_setup where year='$sel_year' and semester='$sel_seme' order by week_no");
		while(!$res->EOF) {
			$temp_arr[$res->fields['week_no']]=$res->fields['start_date'];
			if ($now_date >= $res->fields['start_date']) $temp_arr[0]=$res->fields['week_no'];
			$res->MoveNext();
		}
	} else {
		$db_date=curr_year_seme_day($sel_year,$sel_seme);
		$d=explode("-",$db_date['st_start']);
		$end_date=$db_date['st_end'];
		$smt=mktime(0,0,0,$d[1],$d[2],$d[0]);
		$w_day=date("Y-m-d",$smt);
		$dd=getdate($smt);
		$wmt=$smt-($dd['wday']*86400);
		$i=0;
		do {
			$i++;
			$w_day=date("Y-m-d",$wmt);
			$temp_arr[$i]=$w_day;
			
			if ($now_date >= $w_day) $temp_arr[0]=$i;
			$wmt+=86400*7;
		}
		while ($w_day < $end_date);
		array_pop($temp_arr);
		if ($temp_arr[0]==$i) $temp_arr[0]--;
	}
	return $temp_arr;
}

//�Ǧ^�Ǧ~�}�C
function get_class_year($s_z=0,$add=0,$order='a') {
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$curr_year_seme = sprintf("%03d",curr_year());
	if($order=='a')
		$result = $CONN->Execute("select year  from school_class where enable=1 group by year order by year ") or user_error("Ū�����ѡI",256);
	else
		$result = $CONN->Execute("select year  from school_class where enable=1 group by year order by year desc ") or user_error("Ū�����ѡI",256);

	// init $rr
	$rr=array();
	while(!$result->EOF){ 
		$temp_id = sprintf("%03d",$result->fields[0]);
		if ($result->fields[0] || $s_z)
			$rr[$temp_id] = intval($result->fields[0])."�Ǧ~";
		$result->MoveNext();
	}	
	
	// ��ܤU�Ǧ~
	if($add) {
		$temp_year = $curr_year_seme;		
		for($i=1;$i<=$add;$i++) {			
			$year_seme = sprintf("%03d",$temp_year);
			$rr["$year_seme"] = intval($temp_year)."�Ǧ~";
		}
	}
	return $rr;
}



//�Ǧ^�Ǵ��}�C

function get_class_seme($s_z=0,$add=0) {
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
	$query = "select year,semester from school_class where enable=1 group by year,semester order by year desc,semester desc";
	$result = $CONN->Execute($query) or trigger_error("SQL�y�k���~�G $query", E_USER_ERROR);
	
	while(!$result->EOF){ 
		$index_temp = sprintf("%03d%d",$result->fields[0],$result->fields[1]);
		$rr[$index_temp] = $result->fields[0]."�Ǧ~��".$result->fields[1]."�Ǵ�";
		$result->MoveNext();
	}
	
	// return $rr;

	return (!$rr) ? array() : $rr; 

	// �P�_ $rr �O�_�s�b? �Y���s�b�h�Ǧ^���Ű}�C	
}


//�C�X �~��
function year_base($sel_year=0,$sel_seme=0,$str="") {
	global $CONN,$school_kind_name,$IS_JHORES;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	reset($school_kind_name);	
	if ($sel_year == 0)
		$sel_year = curr_year();
	if ($sel_seme == 0)
		$sel_seme = curr_seme();
	$query = "select c_year from school_class where year=$sel_year and
semester=$sel_seme group by c_year ";	
	$res = $CONN->Execute($query) or trigger_error("�y�k���~�G $query", E_USER_ERROR);

	// init $arr
	$arr=array();

	while(!$res->EOF) {
		$arr[$res->fields[c_year]] =
$school_kind_name[$res->fields[c_year]].$str;
		$res->MoveNext();
	}
	return $arr;	
		
}


//�Ǧ^�Ӯժ��Ҧ��~�Ű}�C
function get_class_year_array($sel_year="",$sel_seme=""){
	global $CONN,$school_kind_name;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
	
	// init 
	$class_year_array=array();
	
	$sql_select = "select c_year from school_class where year='$sel_year' and semester = '$sel_seme' and enable='1' group by c_year";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

	//���o�~�Ű}�C
	while(list($c_year) = $recordSet->FetchRow()){
		$class_year_array[$c_year]=$c_year;
	}
	return $class_year_array;
}


//��class_id�����ª��Ǧ~�H�ΡAclass_id�A�p�G091_1_01_02=>[0]=91�B[1]=1�B[2]=102�A[3]=1�A[4]=2�A[5]=�@�~�G�Z
function class_id_2_old($class_id=""){
	global $school_kind_name;
	if (!$class_id) user_error("�S���ǤJ \$class_id �ȡA���ˬd�I",256);

	//���ꪺ�Ǧ~��
	$classid[0]=substr($class_id,0,3)*1;
	//�Ǵ�
	$classid[1]=substr($class_id,4,1)*1;
	//�Z�š]�T�X�Υ|�X�^
	$classid[2]=(substr($class_id,6,2).substr($class_id,9,2))*1;

	$classid[3]=substr($class_id,6,2)*1;
	$classid[4]=substr($class_id,9,2)*1;

	$class_data=get_class_stud($class_id);
	$Cyear=$class_data[c_year];

	$classid[5]=$school_kind_name[$Cyear]."".$class_data[c_name]."�Z";

	return $classid;
}




//-------------------------------------------
// 3. �Z�� ����
//-------------------------------------------

//�Ǧ^�Z�żư}�C
function get_class_num($curr_seme="") {
	global $class_year,$class_name,$CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if ($curr_seme) {
		$curr_year = substr($curr_seme,0,-1); //�Ǧ~
		$curr_seme = substr($curr_seme,-1); //�Ǵ�
	}
	else{
		$curr_year = curr_year(); //�{�b�Ǧ~
		$curr_seme = curr_seme(); //�{�b�Ǵ�
	}
	$query = "select year,semester,count(*) as cc from school_class where year=$curr_year and semester=$curr_seme group by year,semester "	;
	$result = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);

	// init $rr
	$rr=array();

	while (!$result->EOF) {
		$index_temp = sprintf("%03d%d",$result->fields[0],$result->fields[1]);
		$rr[$index_temp]=$result->fields[2];	
		$result->MoveNext();
	}
	return $rr;
}




//�Z�W�}�C
function class_name($sel_year="",$sel_seme="") {
    global $class_year,$class_name,$SCHOOL_BASE,$CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

    $class_name="";
    if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
    if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
    $sql="select * from school_class where year='$sel_year' and semester='$sel_seme' and enable=1 order by c_sort";
//echo $sql;exit;
    $rs=$CONN->Execute($sql) or user_error("���Ǵ��Z�ũ|���]�w�I",256);
	// init $class_name
	$class_name=array();

    while (!$rs->EOF) {
	$c_sort = sprintf ("%d%02d",$rs->fields['c_year'],$rs->fields['c_sort']);
        $c_name = $rs->fields["c_name"];
        $class_name[$c_sort] = $c_name;

        $rs->MoveNext();
    }
    return $class_name;
}


//�C�X�ثe�Z��
function class_base($curr_seme="",$sel_year_arr = array()) {
	global $CONN,$school_kind_name;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	
	if($curr_seme<>''){
		$curr_year= intval(substr($curr_seme,0,3));
		$curr_seme=substr($curr_seme,-1);
	}
	else {
		$curr_year = curr_year();
		$curr_seme = curr_seme();
	}
	
  	if (count($sel_year_arr) == 0)
    		$sel_year_arr = array_keys ($school_kind_name); //�w�]�����Ǧ~

	if (empty($curr_year))
		user_error("���]�w�Ǧ~�Ǵ�,�Х�����<a href='../every_year_setup/'>�Ǵ���]�w</a>",256);
	$query = "select c_year,c_sort,c_name from school_class where enable=1 and year=$curr_year and semester=$curr_seme order by c_year,c_sort";
	$res = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256);

	// init $class_name
	$class_name=array();

	while(!$res->EOF) {
		if (in_array ($res->fields[c_year], $sel_year_arr)) { //�b��ܪ��~�Ť�
			$class_name_id = sprintf("%d%02d",$res->fields[c_year],$res->fields[c_sort]);
			$class_name[$class_name_id]=$school_kind_name[$res->fields[c_year]].$res->fields[c_name]."�Z";
		}
		$res->MoveNext();
	}
	return $class_name;

}


//���X�Ǧ~�ת��y�����
function get_class_num_field($year_seme,$class_id) {

	if (!$year_seme) user_error("�S���ǤJ�ѼơI",256);
	if (!$class_id) user_error("�S���ǤJ�ѼơI",256);

	$sel_year = intval(substr($year_seme,0,-1)); //��ܾǦ~
	$sel_seme = substr($year_seme,-1); //��ܾǴ�
	$sel_class_year = substr($class_id,0,1); //��ܦ~��	
	if (ereg("^[0-9]$",$sel_class_year)) {//�@��Z��
		$stud_study_year = $sel_year-$sel_class_year+1; //�NŪ�~		
		$temp = $sel_year - $stud_study_year;
		$curr_seme_field= "class_num_".($temp * 2 + $sel_seme); 
	}
	else  //�S��Z��
		$curr_seme_field= "class_num_$sel_seme"; 
	
	return $curr_seme_field;
}


//�C�X�Y�ӯZ�Ū��Z�Ÿ�ư}�C
function get_class_stud($class_id=""){
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$sql_select = "select * from school_class where class_id='$class_id'";
	$recordSet=$CONN->Execute($sql_select) or trigger_error($sql_select, E_USER_ERROR);

	// init array
	$array=array();

	$array = $recordSet->FetchRow();
	return $array;
}


//��X�Y�ӯZ�Ū��ɮv
function get_class_teacher($class_num){
	global $CONN;
	$sql_select = "SELECT t.teach_id ,t.name ,t.teacher_sn  
	   FROM teacher_post p , teacher_base t   
       WHERE p.teacher_sn =t.teacher_sn and t.teach_condition =0 and p.class_num='$class_num' ";

	$recordSet=$CONN->Execute($sql_select) or user_error("���~�T���G $sql_select", 256);
	if ($recordSet) {
		list($teach_id, $tname , $teacher_sn)= $recordSet->FetchRow();

		$man[name]=$tname;
		$man[sn]=$teacher_sn;
		$man[id]=$teach_id;
	} else {
		$man=array();
	}
	
	return $man;
}

//-------------------------------------------
// 4. �Юv��� ����
//-------------------------------------------

//����Юv��¾���
function get_teacher_post_data($teacher_sn=""){
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	// init $row
	$row=array();
	
	//����Юv���
	$sql_select = "
	SELECT a.name, d.title_name , b.post_office , b.class_num 
	FROM  teacher_base a , teacher_post b, teacher_title d 
	where
	a.teacher_sn = $teacher_sn
	and	a.teacher_sn =b.teacher_sn  
	and b.teach_title_id = d.teach_title_id  
	" ;              
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$row=$recordSet->FetchRow();	
	return $row;
}



//���o�Юv�W�١]��teacher_sn�^
function get_teacher_name($teacher_sn){
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$sql_select = "select name from teacher_base where teacher_sn = '$teacher_sn'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	list($name) = $recordSet->FetchRow();
	return $name;
}

//��X���Ǵ�$c_year�~�Ū��Юv�A�٦��O�_�n�[�J���$guest,0
function teacher_fun($c_year,$guest="0"){
	global $CONN;
	if($guest!="0")//�u���ӾǦ~�Ѯv
		$sql="select tb.teacher_sn from teacher_base as tb , teacher_post as tp where tb.teach_condition='0' and tp.class_num like '$c_year%' and tb.teacher_sn=tp.teacher_sn order by tb.name";
	else //�]�A����Ѯv
		$sql="select tb.teacher_sn,tb.teach_condition,tp.class_num from teacher_base as tb , teacher_post as tp where tb.teach_condition='0' and (tp.class_num like '$c_year%' or tp.class_num='0' or tp.class_num='')  and tb.teacher_sn=tp.teacher_sn order by tb.name";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$i=0;
	$teacher_arr=array();
	while(!$rs->EOF){
		$teacher_arr[$i]=$rs->fields['teacher_sn'];
		$i++;
		$rs->MoveNext();
	}
	return $teacher_arr;
}


//�Юv���
function teacher_base() {
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	// init $teacher_array
	$teacher_array=array();

	$sql_select = "select name,teacher_sn from teacher_base where teach_condition='0' order by name";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($name,$teacher_sn) = $recordSet->FetchRow()) {
		$teacher_array[$teacher_sn]=$name;
	}
	return $teacher_array;
}


?>
