<?php
// $Id: csv_export.php 7712 2013-10-23 13:31:11Z smallduh $

include "config.php";
include "../../include/sfs_case_dataarray.php";
sfs_check();

//���Ѫ����
$today=(date("Y")-1911).date("�~m��d��");


// ���X�Z�Ű}�C
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$class_base = class_base($curr_year_seme);
$stud_sex_array=array(1=>"�k",2=>"�k");

//�ؼШ���t_id
$type_id=($_REQUEST[type_id]);
if($type_id=='') $type_id='1';

//���o�Юv�ҤW�~�šB�Z��
$session_tea_sn = $_SESSION['session_tea_sn'] ;
$query =" select class_num  from teacher_post  where teacher_sn  ='$session_tea_sn'  ";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
$row = $result->FetchRow() ;
$class_num = $row["class_num"];

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];

if( checkid($SCRIPT_FILENAME,1) OR $class_num) {


//�Ĥ@���q----���Xstud_base�X�G���ǥ�
$type_select="SELECT a.*, a.student_sn as sn,left(a.curr_class_num,length(a.curr_class_num)-2) as class_id,right(a.curr_class_num,2) as num,b.* FROM stud_base a left join stud_domicile b ON a.student_sn=b.student_sn WHERE a.stud_study_cond=0 AND a.stud_kind like '%,$type_id,%'";
$type_select.=(!checkid($SCRIPT_FILENAME,1) AND $class_num<>'')?" AND curr_class_num like '$class_num%'":"";
$type_select.=" ORDER BY curr_class_num";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
//�Nstudent_sn�ন�}�C�r��
$select_sn='';
while ($data=$recordSet->FetchRow()) {
	$student_sn = 's-'.$data['sn'];
          $stud_data[$student_sn]['class_id']=$data['class_id'];
          $stud_data[$student_sn]['stud_id']=$data['stud_id'];
          $stud_data[$student_sn]['stud_name']=$data['stud_name'];
		  $stud_data[$student_sn]['stud_sex']=$stud_sex_array[($data['stud_sex'])];
          $stud_data[$student_sn]['stud_birthday']=$data['stud_birthday'];
          $stud_data[$student_sn]['stud_person_id']=$data['stud_person_id'];
          $stud_data[$student_sn]['stud_addr_1']=$data['stud_addr_1'];
          $stud_data[$student_sn]['stud_tel_1']=$data['stud_tel_1'];
          $stud_data[$student_sn]['num']=$data['num'];
          $stud_data[$student_sn]['fath_name']=$data['fath_name'];
          $stud_data[$student_sn]['fath_alive']=$data['fath_alive'];
          $stud_data[$student_sn]['moth_name']=$data['moth_name'];
          $stud_data[$student_sn]['moth_alive']=$data['moth_alive'];
          $stud_data[$student_sn]['guardian_name']=$data['guardian_name'];
          $stud_data[$student_sn]['guardian_relation']=$data['guardian_relation'];
          $stud_data[$student_sn]['guardian_phone']=$data['guardian_phone'];
          $stud_data[$student_sn]['guardian_hand_phone']=$data['guardian_hand_phone'];
          }


//�ĤG���q----���Xstud_subkind����
//�[�J���O�ݩʸ��
$sql_select="select * from stud_subkind where type_id='$type_id'";
$res=$CONN->Execute($sql_select) or user_error("�����ݩ�Ū�����ѡI<br>$sql_select",256);
while(!$res->EOF) {
	$student_sn=$res->fields['student_sn'];
	$student_sn = 's-'.$res->fields['student_sn'];
	if(array_key_exists($student_sn,$stud_data)){
		$stud_data[$student_sn]['clan']=$res->fields['clan'];
		$stud_data[$student_sn]['area']=$res->fields['area'];
		$stud_data[$student_sn]['memo']=$res->fields['memo'];
		$stud_data[$student_sn]['note']=$res->fields['note'];
	}
	$res->MoveNext();
}

//���o�ǥͤl�������O�M����
$type_select="SELECT * FROM stud_subkind_ref WHERE type_id='$type_id'";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
$sunkind_data=$recordSet->FetchRow();

$clan_title=$sunkind_data[clan_title];
$area_title=$sunkind_data[area_title];
$memo_title=$sunkind_data[memo_title];
$note_title=$sunkind_data[note_title];

//print_r($stud_data);
//exit;

################################    ��X CSV    ##################################
$filename ="$school_short_name $class_num �ǥͨ���($type_id)�M�U.csv";
$Str="�s��,�Z��,�Z�ŦW��,�y��,�Ǹ�,�m�W,�ʧO,�X�ͦ~,�X�ͤ�,�X�ͤ�,�����Ҧr��,���y�a�},�q�T�a�},���y�q��,�q�T�q��,���˩m�W,���˦s�\,���˩m�W,���˦s�\,���@�H�m�W,���Y,�q��,���,$clan_title,$area_title,$memo_title,$note_title\r\n";

$i=0;
foreach($stud_data as $key=>$value)
{
    $Str.=($i+1).',';

    $class_id=$value['class_id'];
    $class_name=$class_base[$class_id];

    $Str.=$value['class_id'].',';
    $Str.=$class_name.',';
    $Str.=$value['num'].',';
    $Str.=$value['stud_id'].',';
    $Str.=$value['stud_name'].',';
	$Str.=$value['stud_sex'].',';

    list($year,$month, $day) = split('[/.-]',$value['stud_birthday']);
    $Str.=($year-1911).',';
    $Str.=$month.',';
    $Str.=$day.',';

    $Str.=$value['stud_person_id'].',';
    $Str.=$value['stud_addr_1'].',';
    $Str.=$value['stud_addr_2'].',';
    $Str.=$value['stud_tel_1'].',';
    $Str.=$value['stud_tel_2'].',';
    $Str.=$value['fath_name'].',';

    $alive=is_live();
    $alive_code=$value['fath_alive'];
    $Str.=$alive[$alive_code].',';

    $Str.=$value['moth_name'].',';
    $alive_code=$value['moth_alive'];
    $Str.=$alive[$alive_code].',';

    $Str.=$value['guardian_name'].',';
    $guardian_relation=guardian_relation();
    $relation_code=$value['guardian_relation'];
    $Str.=$guardian_relation[$relation_code].',';

    $Str.=$value['guardian_phone'].',';
    $Str.=$value['guardian_hand_phone'].",";
    $Str.=str_replace(chr(13),'',$value['clan']).',';
    $Str.=str_replace(chr(13),'',$value['area']).',';
    $Str.=str_replace(chr(13),'',$value['memo']).',';
    $Str.=str_replace(chr(13),'',$value['note'])."\r\n";
    $i++;
}
header("Content-disposition: attachment; filename=$filename");
header("Content-type: text/x-csv");
//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
header("Expires: 0");
echo $Str;
} else { echo "\n<script language=\"Javascript\"> alert (\"�z�å��Q���v�ϥΦ��Ҳ�(�D�ɮv�μҲպ޲z��)�I\")</script>"; }
?>
