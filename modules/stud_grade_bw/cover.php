<?php
// $Id: cover.php 7711 2013-10-23 13:07:37Z smallduh $

//���J�]�w��
require("config.php") ;
include "../../include/sfs_oo_zip2.php";

// �{���ˬd
sfs_check();

$act=$_POST[key];
$oo_path="ooo/".$act;
	
//�s�W�@�� zipfile
$ttt=new EasyZip;
$ttt->setPath($oo_path);

$ttt->addDir('META-INF');

$ttt->addfile("settings.xml");
$ttt->addfile("styles.xml");
$ttt->addfile("meta.xml");
$data=$ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

$sql="select * from school_base";
$rs=$CONN->Execute($sql);
$temp_sty["school_name"]=$rs->fields['sch_cname'];
$temp_sty["sel_year"]=Num2CNum(curr_year());
$temp_sty["sel_seme"]=Num2CNum(curr_seme());
$today=explode("-",date("Y-m-d",mktime(date("m"),date("d"),date("Y"))));
$temp_sty["year"]=Num2CNum(intval($today[0]-1911));
$temp_sty["month"]=Num2CNum(intval($today[1]));
$temp_sty["day"]=Num2CNum(intval($today[2]));
$replace_data=$ttt->change_temp($temp_sty,$data);
$ttt->add_file($replace_data,"content.xml");

//���� zip ��
$sss = & $ttt->file();

//�H��y�覡�e�X ooo.sxw
$fl=$act;
header("Content-disposition: attachment; filename=$fl.sxw");
header("Content-type: application/octetstream");
//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
header("Expires: 0");

echo $sss;
exit;
?>
