<?php

include "config.php";
sfs_check();
// $Id: stud_base.php 7709 2013-10-23 12:24:27Z smallduh $
$filename="STUDENT.CSV";
header("Content-disposition: attachment; filename=$filename");
header("Content-type: application/octetstream ; Charset=Big5");
//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
header("Expires: 0");
echo "�~��,�Z��,�y��,�Ǹ�,�m�W,�ʧO,�a��,��},�q��,������,�y����,�X��-�~,�X��-��,�X��-��,�׷~�Ҹ�\r\n";
$query="select a.*,b.guardian_name from stud_base a left join stud_domicile b on a.student_sn=b.student_sn where a.stud_study_cond='0' order by a.curr_class_num";
$res=$CONN->Execute($query);
while (!$res->EOF) {
	$curr_class_num=$res->fields[curr_class_num];
	$class_year=intval(substr($curr_class_num,0,-4))-$IS_JHORES;
	$seme_class=substr($curr_class_num,-4,2);
	$seme_num=substr($curr_class_num,-2,2);
	$stud_id=$res->fields[stud_id];
	$stud_name=$res->fields[stud_name];
	$stud_sex=$res->fields[stud_sex];
	$stud_addr_1=$res->fields[stud_addr_1];
	$stud_person_id=$res->fields[stud_person_id];
	$guardian_name=$res->fields[guardian_name];
	echo $class_year.",".$seme_class.",".$seme_num.",".$stud_id.",".$stud_name."  ,".$stud_sex.",".$guardian_name."  ,".$stud_addr_1.",".$stud_tel_1.",".$stud_person_id.", , , , , \r\n";
	$res->MoveNext();
}
header("Location:read_card.php");
?>
