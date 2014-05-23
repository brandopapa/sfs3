<?php

// $Id: sfs_case_studclass.php 7771 2013-11-15 06:39:56Z smallduh $
// ���N�� class_stud.php

//���o�ǥͰ򥻸�ư}�C
function get_stud_base($student_sn="",$stud_id=""){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if(empty($student_sn) and empty($stud_id))return;

	// init $array
	$array=array();

	$where=(empty($stud_id))?"student_sn='$student_sn'":"stud_id='$stud_id'";
	$sql_select = "select * from stud_base where $where";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$array = $recordSet->FetchRow();
	return $array;
}

//���o�ǥͰ򥻸�ư}�C2
function get_stud_baseB($student_sn,$stud_id){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if(empty($student_sn) or empty($stud_id))return;

	// init $array
	$array=array();
	$sql_select = "select * from stud_base where student_sn='$student_sn' and stud_id='$stud_id' ";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$array = $recordSet->FetchRow();
	return $array;
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
	reset($stud);
	while(list($k,$v)=each($stud)){
		$selected=($stud_id==$k)?"selected":"";
		$select_option.="<option value='$k' $selected>$v</option>\n";
	}
	$select_stud="<select name='$name' size='$size' $jump>
	$select_option
	</select>";
	return $select_stud;
}


//���o�Y�Z���Ĥ@�Ӿǥͽs��
function get_no1($class_id){
	if (!$class_id) user_error("�S���ǤJ�Z�ťN�X�I���ˬd�I",256);

	//���o�ǥ͸�ư}�C
	$c=class_id_2_old($class_id);
	$stud=get_stud_array($c[0],$c[1],$c[3],$c[4],"id","name");
	if(!is_array($stud))return;
	list($k,$v)=each($stud);
	return $k;
}


//�ѯZ�ŧǸ�$class_num�d�X�~��[year]�A�Z��[sort]
function class_num_2_all($class_num=""){
	global $school_kind_name;
	if(empty($class_num)) return;
	$cyear=(strlen($class_num)==3)?"0".substr($class_num,0,1):substr($class_num,0,2);
	$cnum=(strlen($class_num)==3)?substr($class_num,1,2):substr($class_num,2,2);

	$main[year]=$cyear;
	$main[sort]=$cnum;
	return $main;
}

//���ª��Z�ťN�X�ഫ���s�N�X�A�p101�ܦ�091_1_01_01
function old_class_2_new_id($class_num,$curr_year,$curr_seme){
	if(empty($class_num)) return;

	if (!$curr_year) user_error("�S���ǤJcurr_year�I���ˬd�I",256);
	if (!$curr_seme) user_error("�S���ǤJcurr_seme�I���ˬd�I",256);

	$curr_year=(strlen($curr_year)<3)?"0".$curr_year:$curr_year;
	$curr_seme=$curr_seme*1;
	$cyear=(strlen($class_num)==3)?"0".substr($class_num,0,1):substr($class_num,0,2);
	$cnum=(strlen($class_num)==3)?substr($class_num,1,2):substr($class_num,2,2);

	$main=$curr_year."_".$curr_seme."_".$cyear."_".$cnum;
	return $main;
}

//��101���Z�ťN�X�ഫ����r
function class_id2big5($old_class_id,$sel_year,$sel_seme){
	global $school_kind_name,$class_name_kind,$class_name_kind_1,$class_name_kind_2,$class_name_kind_3;

	if (!$old_class_id) user_error("�S���ǤJ�Z�ťN�X�I���ˬd�I",256);
	if (!$sel_year) user_error("�S���ǤJ�Ǧ~�סI���ˬd�I",256);
	if (!$sel_seme) user_error("�S���ǤJ�Ǵ��I���ˬd�I",256);

	$class_id=old_class_2_new_id($old_class_id,$sel_year,$sel_seme);
	$class_data=get_class_stud($class_id);
	$y=$class_data[c_year];

	$main=$school_kind_name[$y].$class_data[c_name]."�Z";
	return $main;
}

//�� curr_class_num �ন�Z�ũM�y��
function  curr_class_num2_data($curr_class_num){
	if (!$curr_class_num) user_error("�S���ǤJcurr_class_num�I���ˬd�I",256);

	if(strlen($curr_class_num)==5){
		$stu[class_id]=substr($curr_class_num,0,3);
		$stu[num]=substr($curr_class_num,3,2);
	}elseif(strlen($curr_class_num)==6){
		$stu[class_id]=substr($curr_class_num,0,4);
		$stu[num]=substr($curr_class_num,4,2);
	}
	return $stu;
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

	$sql_select = "select stud_base.$str[$k], stud_base.$str[$v] from stud_base, stud_seme where stud_base.student_sn=stud_seme.student_sn and stud_seme.seme_year_seme='$stud_year' and stud_seme.seme_class='$class_num' and stud_study_cond in (0,2,3,4,13,14,15) order by stud_seme.seme_num";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(list($k, $v) = $recordSet->FetchRow()){
		$stu[$k]=$v;
	}
	return $stu;
}

//stud_id��student_sn
function stud_id2student_sn($stud_id,$stud_study_year=""){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if(empty($stud_id))return;
	$sql_select = "select student_sn from stud_base where stud_id='$stud_id'";
        if($stud_study_year) $sql_select .=" and stud_study_year='$stud_study_year'";
        $sql_select.=" order by student_sn desc";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	list($student_sn) = $recordSet->FetchRow();
	return $student_sn;
}

//student_sn��stud_id
function student_sn2stud_id($student_sn=""){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if(empty($student_sn) and empty($stud_id)) return;
	$sql_select = "select stud_id from stud_base where student_sn='$student_sn'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	list($stud_id) = $recordSet->FetchRow();
	return $stud_id;
}


//��ǥ͸�ơA�ξǸ�
function stud_data($stud_id=""){
	global $CONN;
	if(empty($student_sn) and empty($stud_id))return;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	// init $student
	$student=array();

	$sql_select = "select * from stud_base where stud_id=$stud_id";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$student = $recordSet->FetchRow();
	return $student;
}


//���o�Y�@�ӱЮv�b�Y�@�`���X�`��
function get_teacher_course_num($sel_year="",$sel_seme="",$teacher_sn="",$day="",$sector=""){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	//��X�Y�Z�Ҧ��ҵ{
	$sql_select = "select count(*) from score_course where year=$sel_year and semester='$sel_seme' and teacher_sn='$teacher_sn' and day='$day' and sector='$sector'";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	list($n)= $recordSet->FetchRow();
	return $n;
}

//���ǥͩm�W�A�ξǸ�
function stud_name($stud_id=""){
	global $CONN;

	if(empty($student_sn) and empty($stud_id))return;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$sql_select = "select stud_name from stud_base where stud_id=$stud_id";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$stud_name = $recordSet->fields['stud_name'];
	return $stud_name;
}



//


//��student_sn�o��Y�Ǵ��ǥͪ��Z�Ůy���m�W
function student_sn_to_classinfo($student_sn,$sel_year,$sel_seme){
    global $CONN;

	if ($sel_year=="") $sel_year=curr_year();
	if ($sel_seme=="") $sel_seme=curr_seme();
    
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if (!$student_sn) user_error("�S���ǤJ�ǥͬy�����I���ˬd�I",256);
	
	$rs_sn=$CONN->Execute("select stud_id from stud_base where student_sn='$student_sn'") or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    $stud_id=$rs_sn->fields["stud_id"];
    $seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
    $rs_seme=$CONN->Execute("select seme_class,seme_num from stud_seme where student_sn='$student_sn' and seme_year_seme='$seme_year_seme' order by seme_num ") or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    $seme_class=$rs_seme->fields["seme_class"];
    $year= substr($seme_class,0,-2);
    $class= substr($seme_class,-2);
    $site=$rs_seme->fields["seme_num"];
    //echo $year.$class.$site;
    $rs1=&$CONN->Execute("select stud_name, stud_sex, curr_class_num from stud_base where student_sn='$student_sn'") or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
//    $curr_class_num=$rs1->fields['curr_class_num'];
    $stud_sex=$rs1->fields['stud_sex'];
    $stud_name=$rs1->fields['stud_name'];
	//��l�ư}�C 
	$year_class_site_sex=array();
    settype($site,"integer");
    settype($class,"integer");
    settype($year,"integer");
    settype($stud_sex,"integer");
    $year_class_site_sex=array($year,$class,$site,$stud_sex,$stud_name);
    return $year_class_site_sex;
}

//��student_sn�o��Ӧ�ǥͥ��Ǵ����y��
function student_sn_to_site_num($student_sn){
    global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if (!$student_sn) user_error("�S���ǤJ�ǥͬy�����I���ˬd�I",256);
	
    $rs_sn=$CONN->Execute("select stud_id from stud_base where student_sn='$student_sn'") or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    $stud_id=$rs_sn->fields["stud_id"];
    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
    $rs_seme=$CONN->Execute("select seme_num from stud_seme where stud_id='$stud_id' and seme_year_seme='$seme_year_seme'") or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
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
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	//if (!$class_id) user_error("�S���ǤJ�Z�ťN�X�I���ˬd�I",256);
	//��l�ư}�C 
	$student_sn=array();
    $class_id_array=explode("_",$class_id);
    $class_num=intval($class_id_array[2]).$class_id_array[3];
    $sql="select student_sn from stud_base where stud_study_cond=0 and curr_class_num like '$class_num%' order by curr_class_num ";
    $rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    while (!$rs->EOF) {
        $student_sn[]=$rs->fields["student_sn"];
        $rs->MoveNext();
    }
    return $student_sn;
}

//���o�ǥ;Ǵ����
function seme_class_id_to_student_sn($class_id){
    global $CONN;
        if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
        //if (!$class_id) user_error("�S���ǤJ�Z�ťN�X�I���ˬd�I",256);
        //��l�ư}�C
        $student_sn=array();
    $class_id_array=explode("_",$class_id);
    $class_temp = sprintf("%03d%d",$class_id_array[0],$class_id_array[1]);
    $class_num=intval($class_id_array[2]).$class_id_array[3];
    if ($class_id_array[3]=='')
	    $sql="select student_sn from stud_seme where seme_year_seme='$class_temp' and seme_class like '$class_num%' order by seme_num";
    else
	    $sql="select student_sn from stud_seme where seme_year_seme='$class_temp' and seme_class='$class_num' order by seme_num";
    $rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    while (!$rs->EOF) {
        $student_sn[]=$rs->fields["student_sn"];
        $rs->MoveNext();
    }
    return $student_sn;
}


//��course_id��X�X�~�X�Z
function  course_id_to_full_class_name($course_id){
    global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);	
	
    $select_course_id_sql="select * from score_course where course_id=$course_id";
    $rs_select_course_id=$CONN->Execute($select_course_id_sql) ;
    $class_id= $rs_select_course_id->fields['class_id'];
    $ss_id= $rs_select_course_id->fields['ss_id'];
    $school_kind_name=array("���X��","�@�~","�G�~","�T�~","�|�~","���~","���~","�@�~","�G�~","�T�~","�@�~","�G�~","�T�~");
    //$full_year_class_name=$school_kind_name[$class_year];
    $sql="select * from school_class where class_id='$class_id'";
    $rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    $c_year= $rs->fields['c_year'];
    $c_name= $rs->fields['c_name'];
    $full_year_class_name=$school_kind_name[$c_year];
    $full_year_class_name.=$c_name."�Z";
    return $full_year_class_name;
}

//��class_id��X�X�~�X�Z
function  class_id_to_full_class_name($class_id){
    global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if (!$class_id) user_error("�S���ǤJ�Z�ťN�X�I���ˬd�I",256);
	
    $class_sql="select * from school_class where class_id='$class_id' and enable=1";	
    $rs_class=$CONN->Execute($class_sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
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
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if (!$student_sn) user_error("�S���ǤJ�ǥͬy�����I���ˬd�I",256);
	
    $rs=&$CONN->Execute("select stud_name from stud_base where student_sn='$student_sn'") or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    $stud_name=$rs->fields['stud_name'];
    return $stud_name;
}

//��student_sn��X�ǥͪ��m�W�A�y���A�Ǹ�
function  student_sn_to_name_num($student_sn){
    global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if (!$student_sn) user_error("�S���ǤJ�ǥͬy�����I���ˬd�I",256);
	
    $rs=&$CONN->Execute("select stud_id,stud_name,curr_class_num from stud_base where student_sn='$student_sn'") or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    $stud_name=$rs->fields['stud_name'];
	 $stud_id=$rs->fields['stud_id'];
	$stud_num=substr($rs->fields['curr_class_num'],-2);
	$name_num=array($stud_id,$stud_name,$stud_num);
    return $name_num;
}


//��student_sn�o��class_id
function student_sn_to_class_id($student_sn,$seme_year="",$seme=""){
    global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if (!$student_sn) user_error("�S���ǤJ�ǥͬy�����I���ˬd�I",256);
	if(!$seme_year) $seme_year=curr_year();
	if(!$seme) $seme=curr_seme();
	$seme_year_seme=sprintf("%03d%d",$seme_year,$seme);
    $rs_sn=$CONN->Execute("select stud_id from stud_base where student_sn='$student_sn'") or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    $stud_id=$rs_sn->fields["stud_id"];    
    $rs_seme=$CONN->Execute("select seme_class from stud_seme where stud_id='$stud_id' and seme_year_seme='$seme_year_seme'") or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    $seme_class=$rs_seme->fields["seme_class"];
	$class_id=sprintf("%03d_%d_%02d_%02d",$seme_year,$seme,substr($seme_class,0,-2),substr($seme_class,-2));
    return $class_id;
}

//��class_id��X�Ǵ��X�~�X�Z
function  class_id_to_full_class_name2($class_id){
    global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if (!$class_id) user_error("�S���ǤJ�Z�ťN�X�I���ˬd�I",256);
	
    $class_sql="select * from school_class where class_id='$class_id' and enable=1";	
    $rs_class=$CONN->Execute($class_sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    $c_year= $rs_class->fields['c_year'];
    $c_name= $rs_class->fields['c_name'];	
	$arr=explode("_",$class_id);
	$full_year_class_name.=sprintf("%d�Ǧ~�ײ�%d�Ǵ�",$arr[0],$arr[1]);	
    $school_kind_name=array("���X��","�@�~","�G�~","�T�~","�|�~","���~","���~","�@�~","�G�~","�T�~","�@�~","�G�~","�T�~");
    $full_year_class_name.=$school_kind_name[$c_year];
    $full_year_class_name.=$c_name."�Z";	
    return $full_year_class_name;
}

//��class_id��X�X�~�X�Z
function  class_id_to_c_name($class_id){
    global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if (!$class_id) user_error("�S���ǤJ�Z�ťN�X�I���ˬd�I",256);
	
    $class_sql="select * from school_class where class_id='$class_id' and enable=1";	
    $rs_class=$CONN->Execute($class_sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
    $c_year= $rs_class->fields['c_year'];
    $c_name= $rs_class->fields['c_name'];
    return $c_name;
}

//�ӯZ�ثe���ǥͿ��
function logn_stud_sel($curr_year,$curr_seme,$class_num){
	global $CONN,$student_sn;
	if($curr_year=="") $curr_year = curr_year();
	if($curr_seme=="") $curr_seme = curr_seme();		
	$curr_year=intval($curr_year);	
	$seme_year_seme=sprintf("%03d%d",$curr_year,$curr_seme);
	$sql="select seme_num, stud_name, sb.student_sn from stud_seme as se, stud_base as sb where se.seme_year_seme='$seme_year_seme' and se.seme_class='$class_num' and se.student_sn=sb.student_sn and sb.stud_study_cond='0' order by se.seme_num";
	$rs=$CONN->Execute($sql);
	$i=0;	
	while(!$rs->EOF){		
		$seme_num=$rs->fields['seme_num'];		
		$stud_name=$rs->fields['stud_name'];			
		$st_sn=$rs->fields['student_sn'];
		$style[$i]=($student_sn==$st_sn)?" STYLE='background-color: #C82EE7; color:#FFFFFF;' ":"";
		$option.="<option value='$st_sn'$style[$i]>".sprintf("%02d",$seme_num)."--".$stud_name."</option>\n";	
		$i++;
		$rs->MoveNext();
	}	
	return $option;	

}

//��student_sn�o��Ӧ�ǥͬY�@�Ǵ��Ǵ����Ǹ��m�W�y��
function student_sn_to_id_name_num($student_sn,$curr_year="",$curr_seme=""){
    global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if (!$student_sn) user_error("�S���ǤJ�ǥͬy�����I���ˬd�I",256);
	if($curr_year=="") $curr_year=curr_year();
	if($curr_seme=="") $curr_seme=curr_seme();
    $seme_year_seme=sprintf("%03d%d",$curr_year,$curr_seme);
    $sql="select sb.stud_id, sb.stud_name, se.seme_num from stud_seme as se, stud_base as sb where se.student_sn=sb.student_sn and se.seme_year_seme='$seme_year_seme' and se.student_sn='$student_sn'";
	$rs=$CONN->Execute($sql) or trigger_error($sql, E_USER_ERROR);
    $stud_id=$rs->fields['stud_id'];
	$stud_name=$rs->fields['stud_name'];
	$site=$rs->fields['seme_num'];
	settype($site,"integer");
	$info=array($stud_id,$stud_name,$site);
    
    return $info;
}

//���o�Y�@�Ǵ��ӯZ�Ҧ��ǥͪ��򥻸��
function class_id_to_seme_student_sn($class_id){
    global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	//if (!$class_id) user_error("�S���ǤJ�Z�ťN�X�I���ˬd�I",256);
	//��l�ư}�C 
	$student_sn=array();
    $class_id_array=explode("_",$class_id);
    $seme_year_seme=$class_id_array[0].$class_id_array[1];
	$seme_class=sprintf("%d%02d",$class_id_array[2],$class_id_array[3]);
    $sql="select student_sn from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$seme_class'  order by seme_num";
    $rs=$CONN->Execute($sql) or trigger_error("$sql", E_USER_ERROR);
    while (!$rs->EOF) {
        $student_sn[]=$rs->fields["student_sn"];
        $rs->MoveNext();
    }
    return $student_sn;
}
?>
