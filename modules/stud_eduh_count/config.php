<?php
                                                                                                                             
// $Id: config.php 6596 2011-10-19 06:55:54Z infodaes $

include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_dataarray.php";

sfs_check();

//���

$menu_p = array("index2.php"=>"�¦����ɬ�����","eduh_count.php"=>"���ɬ�����g����","eduh_check.php"=>"���ɬ�����Ƨ�����ˬd","talk_count.php"=>"�X�ͬ�����g����","home_count.php"=>"�a�x���p�έp","spec_class_count.php"=>"�S��Z�ǥͬd��");

//���o�ثe�Ǧ~��(�Ĥ@�줣�t0)
function get_curr_year($year_seme){
         if (empty($year_seme))
               $get_year=curr_year();
         else
               if (substr($year_seme,0,1)!="0")
                  $get_year=substr($year_seme,0,strlen($year_seme)-1);
               else
                  $get_year=substr($year_seme,1,strlen($year_seme)-2);
         return $get_year;
}
//���o�ثe�Ǵ�(1��2)
function get_curr_seme($year_seme){
         if (empty($year_seme))
               $get_seme=curr_seme();
         else
               $get_seme=substr($year_seme,-1);
         return $get_seme;
}
//�N�ǥͮa�x�������N���ন��r��X
function get_sfs_text($t_kind,$d_id){
         global $CONN;
         $d_id=($d_id=='0')?'-1':$d_id;
         //���sfs_text���A�ŦX��t_name
         $sql_select = "select t_name from sfs_text where t_kind='$t_kind' and d_id='$d_id'";
	 $record=$CONN->Execute($sql_select) or die($sql_select);
         $num=$record->RecordCount();
         if ($num<1) return " ";//�p�G�����A�h�Ǧ^�ť�
	 $sss = $record->FetchRow();
	 return $sss[t_name];
}
//�H�U���������
 //�w�]�Ĥ@�Ӷ}�Ҧ~��
 $default_begin_class = 6;
 //�����]�w��ܵ���
 $gridRow_num = 16;
 //����橳��]�w
 $gridBgcolor="#DDDDDC";
//�����k������C��
 $gridBoy_color = "blue";
 //�����k������C��
 $gridGirl_color = "#FF6633";
//�s�W���s�W��
$newBtn = " �s�W��� ";
//�ק���s�W��
$editBtn = " �T�w�ק� ";
//�R�����s�W��
$delBtn = " �T�w�R�� ";
//�T�w�s�W���s�W��
$postBtn = " �T�w�s�W ";
$editModeBtn = " �ק�Ҧ� ";
$browseModeBtn = " �s���Ҧ� ";

?>
