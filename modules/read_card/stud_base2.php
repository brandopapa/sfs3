<?php
// $Id: stud_base2.php 7709 2013-10-23 12:24:27Z smallduh $
include "config.php";
sfs_check();
$filename="STUDENT.CSV";
header("Content-disposition: attachment; filename=$filename");
header("Content-type: application/octetstream ; Charset=Big5");
//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
header("Expires: 0");
echo "�ҰϥN��,�ǮեN��,�Ǹ�,�~��,�Z��,�y��,�m�W\r\n";
$query="select * from stud_base where stud_study_cond='0' order by curr_class_num";
$res=$CONN->Execute($query);
while (!$res->EOF) {
	$curr_class_num=$res->fields[curr_class_num];
	$class_year=intval(substr($curr_class_num,0,-4))-$IS_JHORES;
	$seme_class=substr($curr_class_num,-4,2);
	$seme_num=substr($curr_class_num,-2,2);
	$stud_id=$res->fields[stud_id];
	$stud_name=$res->fields[stud_name];
	echo "01,001,".$stud_id.",".$class_year.",".$seme_class.",".$seme_num.",".$stud_name."\r\n";
	$res->MoveNext();
}
header("Location:read_card.php");
?>
