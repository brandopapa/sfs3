<?php
include "config.php";
sfs_check();

download_csv(curr_year());

function download_csv($year){
  global $CONN,$school_sshort_name,$school_long_name;
   $stud_sex_array=array(1=>"�k",2=>"�k");
   //�s�ͤJ�Ǧ~��
   $in_time = $year.".08";
      
   $data = "�Ǹ�,�m�W,�ʧO,�����Ҧr��,�ͤ�,�J�Ǯɶ�,�J�Ǹ��,���y�a�}\r\n";
   $sql_select="select stud_id,stud_name,stud_sex,stud_person_id,stud_birthday,stud_addr_1 from stud_base where stud_study_year ='".$year."' and (stud_study_cond='0' or stud_study_cond='8') ";
   $recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
   while( list($stud_id,$stud_name,$stud_sex,$stud_person_id,$stud_birthday,$stud_addr_1)=$recordSet->FetchRow() ){
     //�ʧO�ഫ���k�k
     $stud_sex = $stud_sex_array[$stud_sex];
      //�ͤ��~���A�~3�줸�A��2�줸�A��2�줸
     $birth_date = explode("-",$stud_birthday);
     //$birth_year = sprintf("%03s",$birth_date[0]-1911);
     $birth_year = $birth_date[0]-1911;
     $birth_mon = sprintf("%02s",$birth_date[1]);
     $birth_day = sprintf("%02s",$birth_date[2]);
     $stud_birthday = $birth_year.".".$birth_mon.".".$birth_day;
   
     $data.=$stud_id.",".$stud_name.",".$stud_sex.",".$stud_person_id.",".$stud_birthday.",".$in_time.",".$school_long_name.",".$stud_addr_1."\r\n";
   }
   

   $filename=$year."�Ǧ~".$school_sshort_name."�J�ǾǥͦW�U.csv";
   header("Content-disposition: attachment;filename=$filename");
   header("Content-type: text/x-csv ; Charset=Big5");
   header("Pragma: no-cache");
   header("Expires: 0");

   echo $data;
}


