<?php
// $Id: stud_kind_all.php 5369 2010-08-25 07:31:36Z wkb $

/*
=====================================================
�{���G�ǥͨ����O�έp���`��
ver1.0 -- wkb
=====================================================
*/

/* �ǰȨt�γ]�w�� */
include "stud_query_config.php";  

//�{���ˬd
sfs_check();

//�n���ͪ�csv�ɦW
$char_kind=$_REQUEST[char_kind];
if($char_kind == 1){
  $file_name = curr_year()."_".curr_seme()."_utf8_all.csv";
  $char_value = "UTF-8";
}else{
  $file_name = curr_year()."_".curr_seme()."_big5_all.csv";
  $char_value = "Big5";
}


header("Content-disposition: filename=".$file_name);
header("Content-type: application/octetstream ; Charset=".$char_value."");
//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
header("Expires: 0");
$test = "";
$test.= '"�~","�Z","�Z��","�y��","�m�W","�ʧO",';/**/
//echo $test;
//exit;

//���o�ǥͨ����O�N��
$stud_kind_arr = stud_kind();


foreach($stud_kind_arr as $k=>$v){
  //echo count($stud_kind_arr)."|".$i."|".$stud_kind_arr[$i]."<BR>\n";
  if(strlen($v)>1 and $k>0){
    $test.= '"'.$v.'",';
  }
}
$test.= "\n";

$query = "select a.*,left(a.curr_class_num,length(a.curr_class_num)-2) as stud_class,right(a.curr_class_num,2) as stud_site from stud_base a where a.stud_study_cond=0 order by a.curr_class_num;";
$rs = $CONN->Execute($query) or die ($CONN->ErrorMsg()."|<BR>\n".$query);
//$k1=0;
//echo $query."|<BR>\n";
//echo $rs -> RecordCount()."|<BR>\n";
while($row = $rs->FetchRow()){
  //echo $k1."|111|<BR>\n";
  $test.=substr($row['stud_class'],0,1).',';
  $test.=substr($row['stud_class'],1,2).',';
  $test.=$class_base[$row['stud_class']].',';
  $test.=$row['stud_site'].',';
  $test.=$row['stud_name'].',';
  $test.=$sex_arr[$row['stud_sex']].',';
  foreach($stud_kind_arr as $k=>$v){
	if (strlen($v)>1 and $k>0){
      if(strpos($row['stud_kind'],",".$k.",")){
	    //echo "Id:".$row['stud_kind']."|".$k."|".$v."|<BR>\n";
	    $test.= "1,";
	  }else{
	    $test.= ",";
	  }
    }
  }
  $test.= "\n";
}

echo $test;
exit;