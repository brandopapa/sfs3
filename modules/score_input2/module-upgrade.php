<?php
// $Id: module-upgrade.php 6224 2010-10-18 03:31:41Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}
//�Ұ� session
session_start();
//
// �ˬd��s�_
// ��s�O���ɸ��|

$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");
// 2010 -10-18 �R�� 2003 �~�ª�ɯųB�z
//$up_file_name =$upgrade_str."2003-10-09.txt";
//$up_file_name =$upgrade_str."score_mester_chane.txt";
//$up_file_name =$upgrade_str."2003-11-13.txt";
//$up_file_name =$upgrade_str."score_mester_change_0106.txt";


//�ɥ�score_semester_94_2���վǲ߬�ئ��Z�ǥͪ�class_id���O�ŭȪ����D
$up_file_name =$upgrade_str."class_id_corrected_0942.txt";
if (!is_file($up_file_name) ){
        if (curr_year()==94 && curr_seme()==2) {
	        $score_semester='score_semester_94_2';
	        $leadstring='094_2';
	        $query = "SELECT score_id,student_sn FROM $score_semester WHERE (class_id IS NULL) OR class_id=''";
	        //echo "$query<BR>";
	        $res = $CONN->Execute($query);
	        if ($res->RecordCount()>0){
	              //echo "�t�εo�{( $score_semester )�Ǵ����Z��ƪ�\"class_id\"��즳�ŭ�(".$res->RecordCount()."��)<BR>�۰ʶi��׸�........<BR>";
	              while ($data=$res->FetchRow()) {
	                    //�q stud-base ����ثe�Z�űa�JCLASS_ID
	                    $sn=$data['student_sn'];
	                    $score_id=$data['score_id'];
	                    $sql_select="select curr_class_num from stud_base where student_sn=$sn";
	                    $rs_class=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	                    $row = $rs_class->FetchRow() ;
	                    $class_num = $row["curr_class_num"].'';
	                    $class_num=sprintf("%02d_%02d",substr($class_num,0,-4),substr($class_num,-4,2));
	                    $class_id=$leadstring.'_'.$class_num;

	                    $query = "update $score_semester set class_id='$class_id' where score_id=$score_id";
	                    $CONN->Execute($query) or die($query);

	                    //echo "#$score_id OK!!  ";
	                }
		}
		$nums=$res->RecordCount();
	}
        $fp = fopen ($up_file_name, "w");
        $temp_query = "( $score_semester )�Ǵ����Z��ƪ�\"class_id\"��즳�ŭ�(".$nums."��)<BR>�۰ʶi��׸� -- by infodaes (2006-4-14)";
        fwrite($fp,$temp_query);
        fclose($fp);
}

// �[�J�Юv�W�Ǧ��Z���ƪ�
$up_file_name =$upgrade_str."score_paper_upload_06_27.txt";
if (!is_file($up_file_name) ){
        $query = "CREATE TABLE IF NOT EXISTS score_paper_upload (
  spu_sn int(5) NOT NULL auto_increment,
  curr_seme varchar(5) NOT NULL default '',
  class_num char(3) NOT NULL default '',
  file_name varchar(255) NOT NULL default '',
  log_id varchar(20) NOT NULL default '',
  time datetime default NULL,
  printed tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (spu_sn),
  UNIQUE KEY class_num (class_num,curr_seme)
) ";

        $res = $CONN->Execute($query);
        $fp = fopen ($up_file_name, "w");
        $temp_query = "�[�J�Юv�W�Ǧ��Z���ƪ� score_paper_upload	-- by hami (2006-6-27)";
        fwrite($fp,$temp_query);
        fclose($fp);
}

?>
