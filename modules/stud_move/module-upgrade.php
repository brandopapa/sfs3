<?php
// $Id: module-upgrade.php 6204 2010-09-30 23:31:15Z infodaes $

if(!$CONN){
        echo "go away !!";
        exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path();
$upgrade_str = set_upload_path("$upgrade_path");

// �[�J��X�J�Ǯ�
$up_file_name =$upgrade_str."2003-10-14.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `stud_move` ADD `school` VARCHAR(40) NOT NULL default '';";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\ ! \n";
	else
		$temp_str = "$query\n ��s���� ! \n";
	$temp_query = "�s�W��X�J�Ǯ���� -- by brucelyc (2003-10-14)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2005-09-02.txt";
if (!is_file($up_file_name)){
	//���X�Ҧ����~�O��
	$update_ip=getip();
	$query="select * from stud_move where stud_id like 'g%' and move_kind='5' order by move_date";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$m_seme=array();
		$m_seme=explode("_",$res->fields[move_year_seme]);
		$seme_year_seme=sprintf("%03d",$m_seme[0])."2";
		$move_year_seme=$m_seme[0]."2";
		$query_seme="select a.stud_id,a.student_sn from stud_base a left join stud_seme b on a.student_sn=b.student_sn where b.seme_year_seme='$seme_year_seme' and b.seme_class like '".$m_seme[1]."%' and a.stud_study_cond='5'"; 
		$res_seme=$CONN->Execute($query_seme);
		while(!$res_seme->EOF) {
			$CONN->Execute("insert into stud_move (stud_id,move_kind,move_year_seme,move_date,move_c_unit,move_c_date,move_c_word,move_c_num,update_id,update_ip,student_sn) values ('".$res_seme->fields[stud_id]."','5','$move_year_seme','".$res->fields[move_date]."','".$res->fields[move_c_unit]."','".$res->fields[move_c_date]."','".$res->fields[move_c_word]."','".$res->fields[move_c_num]."','$_SESSION[session_tea_sn]','$update_ip','".$res_seme->fields[student_sn]."')");
			$res_seme->MoveNext();
		}
		$res->MoveNext();
	}
	$CONN->Execute("delete from stud_move where stud_id like 'g%' and move_kind='5'");

	$temp_query = "�N���~�O����אּ�C�H�@�� -- by brucelyc (2005-09-02)\n\n";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

// �[�J��X�J��]
$up_file_name =$upgrade_str."2005-10-07.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `stud_move` ADD `reason` text NOT NULL default '';";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\ ! \n";
	else
		$temp_str = "$query\n ��s���� ! \n";
	$temp_query = "�s�W��X�J��]��� -- by brucelyc (2005-10-07)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

// �[�J�Ш|���ǮեN�X
$up_file_name =$upgrade_str."2009-5-7.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `stud_move` ADD `school_id` VARCHAR(6) AFTER `school` ;";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\ ! \n";
	else
		$temp_str = "$query\n ��s���� ! \n";
	$temp_query = "�s�W�Ш|���ǮեN�X��� -- by infodaes (2009-5-7)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}


// �[�J�ǮվǴ����ʬy�������
$up_file_name =$upgrade_str."2009-8-23.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `stud_move` ADD `school_move_num` INT AFTER `move_year_seme` ;";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\! \n";
	else
		$temp_str = "$query\n ��s����! \n";
	$temp_query = "�[�J�ǮվǴ����ʬy������� -- by infodaes (2009-8-23)\n\n$temp_str";
	
	//�N�H�������ʬ����H����Ƨ� �̧ǵ����Ǯ��ҩ��}�߽s��
	$query = "SELECT move_year_seme,move_id FROM `stud_move` WHERE move_kind IN (7,8,11,12) ORDER BY move_year_seme,move_id;";
	$recordSet=$CONN->Execute($query);
	while(!$recordSet->EOF)
	{
		$move_id=$recordSet->fields['move_id'];
		if($this_year_seme<>$recordSet->fields['move_year_seme']) {
			$this_year_seme=$recordSet->fields['move_year_seme'];
			$school_move_num=1;
		} else $school_move_num++;
		
		$update_sql="UPDATE stud_move SET school_move_num='$school_move_num' WHERE move_id='$move_id'";
		$CONN->Execute($update_sql);
		
		$recordSet->MoveNext();
	}
	
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

// �[�J��X����y�a�}���
$up_file_name =$upgrade_str."2010-09-28.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `stud_move` ADD `new_address` VARCHAR(100);";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\! \n";
	else
		$temp_str = "$query\n ��s����! \n";
	$temp_query = "�[�J��X����y�a�}��� -- by infodaes (2010-09-28)\n\n$temp_str";
	
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

// �[�Jstud_move_import��X����y�a�}��� 
$up_file_name =$upgrade_str."2010-09-30.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `stud_move_import` ADD `new_address` VARCHAR(100);";
	if ($CONN->Execute($query))
		$temp_str = "$query\n ��s���\! \n";
	else
		$temp_str = "$query\n ��s����! \n";
	$temp_query = "�[�Jstud_move_import��X����y�a�}��� -- by infodaes (2010-09-30)\n\n$temp_str";
	
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}
?>
