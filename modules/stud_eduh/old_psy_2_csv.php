<?php
// $Id: old_psy_2_csv.php 7711 2013-10-23 13:07:37Z smallduh $

include "config.php";

sfs_check();

$sql="SELECT LEFT(a.seme_year_seme,3) as year,RIGHT(a.seme_year_seme,1) as semester,b.student_sn,a.st_numb,a.st_name,a.st_score_numb,a.st_data_from,a.st_chang_numb,a.st_name_long,a.teacher_sn FROM stud_seme_test a,stud_base b WHERE a.stud_id=b.stud_id ORDER BY seme_year_seme";
$res=$CONN->Execute($sql) or user_error("�^���¤߸̴����ƥ��ѡI<br>$sql",256);

$filename = "�ǥ��¤߸̴����ƦC��.csv";
$Str='"�Ǧ~","�Ǵ�","�ǥͽs��","�߲z����s��","���礤��²��","���Z�s��","��ƨӷ�","�ഫ��s��","���礤����W","�Юv�s��"'."\r\n";
while(!$res->EOF)
{
	$record_str="";
	for($i=0;$i<$res->FieldCount();$i++){
		$record_str.='"'.$res->fields[$i].'",';
	}
	$record_str=substr($record_str,0,-1);
	$Str.="$record_str\r\n";
	$res->MoveNext();
}
header("Content-disposition: attachment; filename=$filename");
header("Content-type: text/x-csv; Charset=Big5");
//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
header("Expires: 0");
echo $Str;
?>