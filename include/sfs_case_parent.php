<?php
// $Id: sfs_case_parent.php 5310 2009-01-10 07:57:56Z hami $


//�Ѯa�����y������X�L���Ҧ��p��
function &get_child($parent_sn=""){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	
	$parent_sn=$_SESSION['session_tea_sn'];
	if (!$parent_sn) user_error("�S���ǤJ�a���N�X�I���ˬd�I",256);
	
	//��X�a������������
	$sql="select parent_id from parent_auth where parent_sn='$parent_sn'";
	$rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G $sql", E_USER_ERROR);
	//�p�S���ظ�Ʈɦ^�ǪŰ}�C
	if ($rs->RecordCount()==0)
		return array();
	$parent_id=$rs->fields['parent_id'];
	
	//��X���@���ǥͦW��
	$sql_st="select stud_id from stud_domicile where  guardian_p_id='$parent_id'";
	//echo $sql_st;
	$rs_st=$CONN->Execute($sql_st) or trigger_error("SQL�y�k���~�G $sql_st", E_USER_ERROR);	
	
	//��l�ư}�C
	$child_A=array();
	
	$i=0;
	while(!$rs_st->EOF){
		$stud_id[$i]=$rs_st->fields['stud_id'];
			//�u��ܦb�Ǫ�
			$sql_bs="select * from stud_base where stud_study_cond=0 and stud_id='$stud_id[$i]'";
			//echo $sql_bs;
			$rs_bs=$CONN->Execute($sql_bs);		
			$child_A[$i][id]=$rs_bs->fields['stud_id'];
			$child_A[$i][Cclass]=substr($rs_bs->fields['curr_class_num'],0,-2);
			$child_A[$i][num]=substr($rs_bs->fields['curr_class_num'],-2);
			$child_A[$i][name]=$rs_bs->fields['stud_name'];
			//echo $child_A[$i][id];
			if(count($child_A[$i][id])==0) {$rs_st->MoveNext(); continue;}
		$i++;
		$rs_st->MoveNext();		
	}
		
	return $child_A;
}


//�Ѥp�Ī��y������a���y�����M�m�W
function &get_parent($student_sn_A){
	global $CONN;
	
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);	
	
	if (!$student_sn_A) user_error("�S���ǤJ�ǥͥN�X�I���ˬd�I",256);
	
	//��l�ư}�C
	$parent_A=array();
	
	for($i=0;$i<count($student_sn_A);$i++){
		//echo $i;
		//�p��sn��id
		$sql="select stud_id,stud_name from stud_base where student_sn='$student_sn_A[$i]'";
		$rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G $sql", E_USER_ERROR);
		$stud_id[$i]=$rs->fields['stud_id'];
		$stud_name[$i]=$rs->fields['stud_name'];
		//echo $stud_id[$i];
		//�����@�H��id		
		$sql="select guardian_p_id,guardian_name from stud_domicile where stud_id='$stud_id[$i]'";
		$rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G $sql", E_USER_ERROR);
		$parent_id[$i]=$rs->fields['guardian_p_id'];
		$parent_name[$i]=$rs->fields['guardian_name'];
		//echo $parent_name[$i];
		//echo $sql;
		if($parent_name[$i]!=""){
			//��X�a���y����
			$sql="select parent_sn from parent_auth where parent_id='$parent_id[$i]'";
			$rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G $sql", E_USER_ERROR);
			$parent_sn[$i]=$rs->fields['parent_sn'];		
			if($parent_sn[$i]!=""){
				$parent_A[$i][sn]=$parent_sn[$i];//�a���y����
				$parent_A[$i][name]=$parent_name[$i];//�a���m�W
				$parent_A[$i][child]=$stud_name[$i];//�Q�l��
			}
			else continue;
		}
		else continue;
	}
	
	return $parent_A;
}

//�Ѯa�����y������X�L���m�W
function &get_guardian_name($parent_sn){
	global $CONN;
	
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);	
	
	if (!$parent_sn) user_error("�S���ǤJ�a���N�X�I���ˬd�I",256);
	
	//��X�a������������
	$sql="select parent_id from parent_auth where parent_sn='$parent_sn'";
	$rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G $sql", E_USER_ERROR);
	$parent_id=$rs->fields['parent_id'];
	//��X�a���W��
	$sql_name="select guardian_name from stud_domicile where  guardian_p_id='$parent_id'";
	$rs_name=$CONN->Execute($sql_name) or trigger_error("SQL�y�k���~�G $sql_name", E_USER_ERROR);
	$guardian_name=$rs_name->fields['guardian_name'];	
	return $guardian_name;
}

?>
