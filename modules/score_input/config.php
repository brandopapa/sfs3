<?php

// $Id: config.php 8418 2015-05-12 02:10:21Z smallduh $
include "../../include/config.php";
include "../../include/sfs_oo_overlib.php";
include "../../include/sfs_case_PLlib.php";
include "../../include/sfs_case_subjectscore.php";
include "module-upgrade.php";

//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

if(!$is_new_nor) $is_new_nor='y';
if(!$is_mod_nor) $is_mod_nor='y';

//�C�X��V���s�����Ҳ�
$year_name = get_teach_class();
$menu_p = array("stud_list.php"=>"�W�U�C�L","group_stud_list.php"=>"���կZ�W�U�C�L","normal.php"=>"���ɦ��Z", "manage2.php"=>"�޲z�Ǵ����Z","write_memo.php"=>"�ǲߴy�z��r�s��","tol.php"=>"�Z�žǴ����Z","make.php"=>"�M�Φۭq���Z��","upload.php"=>"�W�Ǧ��Z��","stick.php"=>"���Z�K��");

if ($is_print=="y" or $year_name) $menu_p["print_tol.php"]="��ܶ��q���Z";
if ($year_name != '') $menu_p["../academic_record/"]="�s�@���Z�� ^";
$menu_p["test.php"]="�ϥλ���";

function stud_class_err() {
	echo "<center><h2>�����@�~����ɮv���</h2>";
	echo "<h3>�Y���ðݽЬ� �t�κ޲z��</h3></center>";
}

//�b�Ǿǥͽs�X 0:�b�y, 15:�b�a�۾�
$in_study="'0'";

//�إ߾Ǭ��O���ո�ƪ�
function creat_elective(){
global $CONN;
$creat1="
CREATE TABLE `elective_tea` (
  `group_id` int(11) NOT NULL auto_increment,
  `group_name` varchar(40) NOT NULL default '',
  `ss_id` int(11) NOT NULL default '0',
  `teacher_sn` int(11) NOT NULL default '0',
  `member` tinyint(3) unsigned NOT NULL default '0',
  `open` set('�O','�_') NOT NULL default '�_',
  PRIMARY KEY  (`group_id`),
  UNIQUE KEY `group_name` (`group_name`,`ss_id`,`teacher_sn`)
)  AUTO_INCREMENT=1 ;";

$creat2="
CREATE TABLE `elective_stu` (
  `elective_stu_sn` int(11) NOT NULL auto_increment,
  `group_id` int(11) NOT NULL default '0',
  `student_sn` int(11) NOT NULL default '0',
  PRIMARY KEY  (`elective_stu_sn`),
  UNIQUE KEY `ss_id` (`group_id`,`student_sn`)
)  AUTO_INCREMENT=1 ;";

$s1="select * from elective_tea where 1=0";
$r1=$CONN->Execute($s1);
if(!$r1) $CONN->Execute($creat1) or trigger_error("�L�k�۰ʫإ�elective_tea��ƪ�\n<br>�бN�H�U�y�k�H��ʫإ�\n<br>$creat1",256);

$s2="select * from elective_stu where 1=0";
$r2=$CONN->Execute($s2);
if(!$r2) $CONN->Execute($creat2) or trigger_error("�L�k�۰ʫإ�elective_stu��ƪ�\n<br>�бN�H�U�y�k�H��ʫإ�\n<br>$creat2",256);


return 0;
}

//���o�ư��W��
function get_manage_out($sel_year,$sel_seme) {
 global $CONN;
 $sql="select student_sn from score_manage_out where year='$sel_year' and semester='$sel_seme'";
 $res=$CONN->Execute($sql) or trigger_error($sql,256);
 $student_out=array();
 while ($row=$res->fetchRow()) {
  $student_sn=$row['student_sn'];
  $student_out[$student_sn]=1;
 }
 return $student_out;
}
?>
