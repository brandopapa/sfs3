<?php
// $Id: config.php 7816 2013-12-17 14:10:29Z infodaes $
include "../../include/config.php";
include "module-cfg.php";
include "module-upgrade.php";
include "my_fun.php";
include "../../include/sfs_oo_overlib.php";
include "../../include/sfs_case_PLlib.php";
include_once "../../include/sfs_case_studclass.php";

//���o�Ҳճ]�w
$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

function stud_class_err() {
        echo "<center><h2>�����@�~����ɮv���</h2>";
        echo "<h3>�Y���ðݽЬ� �t�κ޲z��</h3></center>";
}

//�b�Ǿǥͽs�X 0:�b�y, 15:�b�a�۾�
$in_study="'0','15'";

//�a�A�]����
$test = array("����<br>cm","�魫<br>kg","�����e�s<br>cm","���װ_��<br>��","�ߩw����<br>cm","800/1600����<br>��","�˴����","�˴��~��") ;
$file = array("tall","weigh","test1","test2","test3","test4","organization","test_date") ;
$input_classY="1,2,3,4,5,6,7,8,9,10,11,12";

//�޲z�v
if (checkid($_SERVER['SCRIPT_FILENAME'],1)) $admin=1;

$Bid_arr=array("0"=>"�L��", "1"=>"�A��", "2"=>"�L��", "3"=>"�έD");


?>
