<?php
// $Id: module-upgrade.php 8054 2014-06-04 12:04:49Z smallduh $
if(!$CONN){
        echo "go away !!";
        exit;
}

// �ˬd��s�_
// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

$up_file_name =$upgrade_str."2004-11-29.txt";
if (!is_file($up_file_name)){
	$query="select * from stud_ext_data_menu where 1=0";
	if ($CONN->Execute($query))
		$temp_str = "�ǥ͸ɥR��ƿﶵ��w�s�b, �L�ݤɯšC";
	else {
			
		$query=" CREATE TABLE if not exists  `stud_ext_data_menu` (
			`id` INT NOT NULL AUTO_INCREMENT ,
			`ext_data_name` VARCHAR( 50 ) NOT NULL ,
			`doc` TEXT,
			PRIMARY KEY ( `id` )
			) COMMENT = '�ǥ͸ɥR��ƿﶵ' " ;	
		if ($CONN->Execute($query))
			$temp_str = "$query\n �ǥ͸ɥR��ƪ�إߦ��\ ! \n";
		else
			$temp_str = "$query\n �ǥ͸ɥR��ƪ�إߥ��� ! \n";

	}
	$query="select * from stud_ext_data where 1=0";
	if ($CONN->Execute($query))
		$temp_str = "�ǥ͸ɥR��ƿﶵ��w�s�b, �L�ݤɯšC";
	else {
		
		$query=" CREATE TABLE if not exists stud_ext_data (
  			stud_id varchar(8) NOT NULL default '',
  			mid int(11) NOT NULL default '0',
  			ext_data text NOT NULL,
  			teach_id varchar(10) NOT NULL default '',
  			ed_date date NOT NULL default '0000-00-00',
  			update_time timestamp(14) NOT NULL,
  			PRIMARY KEY  (stud_id,mid)
			);" ;	
			
		if ($CONN->Execute($query))
			$temp_str = "$query\n �ǥ͸ɥR�ӤH��ƪ�إߦ��\ ! \n";
		else
			$temp_str = "$query\n �ǥ͸ɥR�ӤH��ƪ�إߥ��� ! \n";

	}
	$temp_query = "�ǥ͸ɥR��ƪ��إ� -- by prolin (2004-9-25)\n\n$temp_str";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}

$up_file_name =$upgrade_str."2009-02-02.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE `stud_domicile` ADD `fath_grad_kind` TINYINT( 4 ) DEFAULT '1' AFTER `fath_education` , ADD `moth_grad_kind` TINYINT( 4 ) DEFAULT '1' AFTER `moth_education` ;";
	if ($CONN->Execute($query))
		$str="�s�W���׷~�O��즨�\\";
	else
		$str="�s�W���׷~�O��쥢��";
	$temp_query = "�� stud_domicile ��ƪ�s�W�������׷~�O���H�ŦXXML 3.0".$str." -- by infodaes 2009-02-02 \n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}


$up_file_name =$upgrade_str."2009-07-28.txt";
if (!is_file($up_file_name)){
	$query ="ALTER TABLE stud_base ADD enroll_school VARCHAR(30);";
	if ($CONN->Execute($query))
	{
		$str="�W�[�J�ǮɾǮ���� SUCESSED";
	} else {
		$str="�W�[�J�ǮɾǮ���� FAILED";
	}
	$temp_query = "�� stud_base ��ƪ�s�W�J�ǮɾǮ���� �H�ŦX95�榡���y��  ".$str." -- by infodaes 2009-07-28 \n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}


$up_file_name =$upgrade_str."2009-07-29.txt";
if (!is_file($up_file_name)){
	$query="SELECT student_sn,move_kind,school FROM stud_move WHERE move_kind=13";
	if($res=$CONN->Execute($query))
	{
		$str="�N���J�Ǭ������ǥͳ]���J�ǾǮճ]�w���Ǯ� SUCESSED";
		while(!$res->EOF) {
			$student_sn=$res->fields['student_sn'];
			$enroll_school=$res->fields['school'];
			$CONN->Execute("UPDATE stud_base SET enroll_school='$enroll_school' WHERE student_sn=$student_sn");
			$res->MoveNext();
		}		
	} else {
		$str="�N���J�Ǭ������ǥͳ]���J�ǾǮճ]�w���Ǯ� FAILED";
	}
	$temp_query = "�N���J�Ǭ������ǥͳ]���J�ǾǮճ]�w���Ǯ� stud_base ==> enroll_school_XX ".$str." -- by infodaes 2009-07-29 \n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}


$up_file_name =$upgrade_str."2012-09-07.txt";
if (!is_file($up_file_name)){
	$query="ALTER table stud_domicile MODIFY fath_email varchar(60), MODIFY moth_email varchar(60), MODIFY guardian_email varchar(60)";
	if($res=$CONN->Execute($query))
	{
		$str="�ץ������q�l�l���ƪ��ר�varchar(60) SUCESSED";
		while(!$res->EOF) {
			$student_sn=$res->fields['student_sn'];
			$enroll_school=$res->fields['school'];
			$CONN->Execute("UPDATE stud_base SET enroll_school='$enroll_school' WHERE student_sn=$student_sn");
			$res->MoveNext();
		}		
	} else {
		$str="�ץ������q�l�l���ƪ��ר�varchar(60) FAILED";
	}
	$temp_query = "�ץ������q�l�l���ƪ��ר�varchar(60) SUCESSED stud_domicile ==> fath_email, moth_email, guardian_email Shengche Hsiao 2012-09-07 \n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
}



$up_file_name =$upgrade_str."2014-06-04.txt";

$str="";

if (!is_file($up_file_name)){
	$q[1]="ALTER TABLE stud_ext_data ADD student_sn int(10)";
	$t[1]="stud_ext_data��ƪ�W�[ student_sn ���";
	$q[2]="ALTER TABLE stud_ext_data DROP PRIMARY KEY";
	$t[2]="stud_ext_data��ƪ����쥻��primary key";
	$q[3]="ALTER TABLE `stud_ext_data` ADD `sn` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY";
	$t[3]="stud_ext_data��ƪ�W�[ sn ���, �ó]�� primary key";
  
  foreach ($q as $k=>$query) {	
	if ($CONN->Execute($query))
	 {
		$str.=$t[$k]." success\n";
	 } else {
		$str.=$t[$k]." failed\n";
	 }
  }
	$temp_query = $str." -- by smallduh 2014-06-04 \n$query";
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose ($fp);
	//��J student_sn
	$query="select * from stud_ext_data";
	$res=$CONN->Execute($query);
	while ($row=$res->fetchRow()) {
		$edit_year=substr($row['ed_date'],0,4)-1911;
	  $sql="select student_sn from stud_base where stud_id='".$row['stud_id']."' and ".$edit_year."-stud_study_year<9 and ".$edit_year."-stud_study_year>0 limit 1";
		$res_stud=$CONN->Execute($sql) or die ($sql);
		if ($res_stud->RecordCount()>0) {
			$student_sn=$res_stud->fields['student_sn'];
			$sql="update stud_ext_data set student_sn='$student_sn' where mid='".$row['mid']."' and stud_id='".$row['stud_id']."'";					
			$CONN->Execute($sql) or die ($sql);
		}	  
	}
}

?>
