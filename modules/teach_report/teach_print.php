<?php

// $Id: teach_print.php 7712 2013-10-23 13:31:11Z smallduh $

//���J�]�w��
include "teach_report_config.php";

// --�{�� session 
//session_register("session_log_id"); 

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

if(!checkid($_SERVER['PHP_SELF'])){
	include ($head);
	include "$rlogin";
	include ($foot);
	exit;
}
//-----------------------------------


if (isset($print_key)){
   //��X��excel�Bword	
	if ($print_key == "�নExcel��")
		$filename =  "��¾���q�T��.xls"; 	
	else if ($print_key == "�নWord��")
		$filename =  "��¾���q�T��.doc";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	//�m�W�B�q�ܡB��ʡB¾�١B�Z��
	$sql_select = " SELECT a.teach_person_id , a.name, a.birthday , a.address , a.home_phone ,   d.title_name ,b.class_num 
             
              FROM  teacher_base a , teacher_post b, teacher_title d 
              where  a.teach_id =b.teach_id  
              and b.teach_title_id = d.teach_title_id  
              and a.teach_condition = 0  order by class_num, post_kind , post_office , a.teach_id "  ;              


	if ($cols > 20 )	//�̦h����
		$cols = 20;
	echo "<html><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\"><body><table border=1>";
	echo "<tr><td colspan=".($cols+6)." align=center>";

	echo "��¾���q�T��</td></tr>";
	
	echo "<tr>";
	echo "<td >¾��</td><td >�������r��</td><td >�m�W</td><td >�ͤ�</td><td >�a�}</td><td >�q��</td>";
	
	for ($j =0 ;$j< $cols ;$j++)
		echo "<td>&nbsp;</td>";
	echo "</tr>";
	$result = mysql_query ($sql_select,$conID)or die ($sql_select);
	$i =0;
	while ($row = mysql_fetch_array($result)) {
                $job = $row["title_name" ] ;
                if ($row[class_num]) {//�ť� 
                  $temp_year = $class_year[substr($row[class_num],0,1)] ;
                  $temp_class =$class_name[substr($row[class_num],1)] ;
                  $job = $temp_year . $temp_class ."�Z";
                }  
                $teach_person_id = $row["teach_person_id"];
        	$teach_name = $row["name"];
        	$birthday = $row["birthday"];
		
		//�bexcel �����ഫ������
        	if ( substr($birthday,0,4)>1911) {
        	    if ($print_key == "�নWord��") 
        	      $birthday = (substr($birthday,0,4) - 1911). substr($birthday,4) ;}
        	else 
        	    $birthday = " " ; 
 
        	$address = $row["address"];
        	$home_phone = $row["home_phone"];
        
        	echo "<tr>" ;
        	echo "<td>$job</td> " ;
        	echo "<td>$teach_person_id</td>";
        	echo "<td>$teach_name</td>";
        	echo "<td>$birthday</td>";
        	echo "<td>$address</td>";
        	echo "<td>$home_phone</td>";	
        	
        	echo "</tr>\n";
		$i++;
	};
	echo "</table></body><html>";
	exit;
}


head() ;
?>

<center><h2>��¾���q�T���C�L</H2></center>


<table width=100% BGCOLOR="#FDDDAB" ><tr><td align=center>
<form action="<?php echo $PHP_SELF ?>" method="post" name="pform">

<?php
echo "�����ơG<input type=text size=3 maxlength=2 name=\"cols\" value=\"$cols\">  ";
echo "<input type=submit name=\"print_key\" value=\"�নExcel��\">  ";
echo "<input type=submit name=\"print_key\" value=\"�নWord��\">  ";


//�m�W�B�q�ܡB��ʡB¾�١B�Z�� //tta ���ƧǨϥ�
/*
$sql_select = " SELECT a.teach_person_id , a.name, a.birthday , a.address , a.home_phone ,   d.title_name ,b.class_num , 
              CONCAT(post_kind, LPAD(b.post_office,3,'0'),lpad(class_num,3,'0'),lpad(b.teach_title_id,3,'0')) as tta
              FROM  teacher_base a , teacher_post b, teacher_title d 
              where  a.teach_id =b.teach_id  
              and b.teach_title_id = d.teach_title_id  
              and a.teach_condition = 0  order by tta "  ;
*/              
$sql_select = " SELECT a.teach_person_id , a.name, a.birthday , a.address , a.home_phone ,   d.title_name ,b.class_num 
             
              FROM  teacher_base a , teacher_post b, teacher_title d 
              where  a.teach_id =b.teach_id  
              and b.teach_title_id = d.teach_title_id  
              and a.teach_condition = 0  order by class_num, post_kind , post_office , a.teach_id "  ;              

$result = mysql_query ($sql_select,$conID)or die ($sql_select);

$i =0;

if (mysql_num_rows ($result) > 0 ){
	echo "���ơG".mysql_num_rows ($result)."</td></tr></table>
	      <table  align=center  border=\"1\" cellspacing=\"0\" cellpadding=\"2\" bordercolorlight=\"#333354\" bordercolordark=\"#FFFFFF\" ><tr  class='title_sbody1'><td >¾��</td><td >�������r��</td><td >�m�W</td><td >�ͤ�</td><td >�a�}</td><td >�q��</td>";
	echo "</tr>";
}
while ($row = mysql_fetch_array($result)) {
        $job = $row["title_name" ] ;
        if ($row[class_num]) {//�ť� 
          $temp_year = $class_year[substr($row[class_num],0,1)] ;
          $temp_class =$class_name[substr($row[class_num],1)] ;
          $job = $temp_year . $temp_class ."�Z";
        }  
        $teach_person_id = $row["teach_person_id"];
	$teach_name = $row["name"];
	
	$birthday = $row["birthday"];
	//�ഫ������
	if ( substr($birthday,0,4)>1911) 
	  $birthday = (substr($birthday,0,4) - 1911). substr($birthday,4) ;
	else 
	  $birthday = " " ; 
	  
	$address = $row["address"];
	$home_phone = $row["home_phone"];

	echo ($i%2 == 1) ? "<tr class='nom_1' >" : "<tr class='nom_2'>";
	echo "<td>$job</td> " ;
	echo "<td>$teach_person_id</td>";
	echo "<td>$teach_name</td>";
	echo "<td>$birthday</td>";
	echo "<td>$address</td>";
	echo "<td>$home_phone</td>";	
	
	echo "</tr>\n";
	$i++;
};
echo "</table>";

echo "</form>";
?>
<?php
foot() ;
?>