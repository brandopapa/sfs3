<?php
// $Id: csv_export.php 7711 2013-10-23 13:07:37Z smallduh $

include "config.php";
include "../../include/sfs_case_dataarray.php";
sfs_check();

$semester=$_REQUEST['semester'];
$item=$_REQUEST['item'];
$key=$_REQUEST['key'];
$value=$_REQUEST['value'];

// ���X�Z�Ű}�C
$class_base = class_base($semester);


$status_arr=array();
$status_arr['�������Y']="SELECT b.* FROM stud_base b,stud_seme_eduh a WHERE a.stud_id=b.stud_id AND a.seme_year_seme='$semester' AND a.sse_relation=$key ORDER BY b.curr_class_num";
$status_arr['�a�x����']="SELECT b.* FROM stud_base b,stud_seme_eduh a WHERE a.stud_id=b.stud_id AND a.seme_year_seme='$semester' AND a.sse_family_kind=$key ORDER BY b.curr_class_num";
$status_arr['�a�x��^']="SELECT b.* FROM stud_base b,stud_seme_eduh a WHERE a.stud_id=b.stud_id AND a.seme_year_seme='$semester' AND a.sse_family_air=$key ORDER BY b.curr_class_num";
$status_arr['���ޱФ覡']="SELECT b.* FROM stud_base b,stud_seme_eduh a WHERE a.stud_id=b.stud_id AND a.seme_year_seme='$semester' AND a.sse_farther=$key ORDER BY b.curr_class_num";
$status_arr['���ޱФ覡']="SELECT b.* FROM stud_base b,stud_seme_eduh a WHERE a.stud_id=b.stud_id AND a.seme_year_seme='$semester' AND a.sse_mother=$key ORDER BY b.curr_class_num";
$status_arr['�~����']="SELECT b.* FROM stud_base b,stud_seme_eduh a WHERE a.stud_id=b.stud_id AND a.seme_year_seme='$semester' AND a.sse_live_state=$key ORDER BY b.curr_class_num";
$status_arr['�g�٪��p']="SELECT b.* FROM stud_base b,stud_seme_eduh a WHERE a.stud_id=b.stud_id AND a.seme_year_seme='$semester' AND a.sse_rich_state=$key ORDER BY b.curr_class_num";

$sql=$status_arr[$item];
$res=$CONN->Execute($sql) or user_error("����C��sql���ѡI<br>$sql",256);

################################    ��X CSV    ##################################
$filename = $school_id.$school_short_name." $semester $item [ $value ] �ǥͦW��M�U.csv";
$Str="�Z�ŦW��,�y��,�Ǹ�,�m�W,�ʧO,�X�ͦ~���,�����Ҧr��,�q�T�a�},���y�q��,�q�T�q��\r\n";
while(!$res->EOF)
{
    
	$class_number=substr($res->fields['curr_class_num'],-2);
	$class_id=substr($res->fields['curr_class_num'],0,3);
    $class_name=$class_base[$class_id];

    $Str.=$class_name.',';
    $Str.=$class_number.',';
    $Str.=$res->fields['stud_id'].',';
    $Str.=$res->fields['stud_name'].',';
    $Str.=($res->fields['stud_sex']==1?'�k':'�k').',';
    $Str.=$res->fields['stud_birthday'].',';
    $Str.=$res->fields['stud_person_id'].',';
    $Str.=$res->fields['stud_addr_2'].',';
	$Str.=$res->fields['stud_tel_1'].',';
	$Str.=$res->fields['stud_tel_2']."\r\n";
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
