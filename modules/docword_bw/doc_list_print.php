<?php

// $Id: doc_list_print.php 6805 2012-06-22 08:00:32Z smallduh $

//���J�]�w��
include "docword_config.php";
// session �{��
//session_start();
//session_register("session_log_id");
$page_count = 15 ; //�C�������
if(!checkid($PHP_SELF)){
	$go_back=1; //�^��ۤw���{�ҵe��
	include "header.php";
	include $path."/rlogin.php";
	include "footer.php";
	exit;
}
else
	$ischecked = true;
//-----------------------------------

//���P����B�z
if ($key == "�T�w���P") {
	$query ="update sch_doc1 set doc_stat='9' where doc1_year_limit < 99 and doc1_k_id=0 and TO_DAYS(DATE_ADD(doc1_date,INTERVAL doc1_year_limit YEAR)) <= TO_DAYS('$DelDate') ";
	mysql_query ($query);
}

//�P���ѦҤ��
if ($DelDate == "") 
	$DelDate = date("Y-m-j");

//���o�ӿ�B��
$doc_unit_p = doc_unit();


$query ="select *  from sch_doc1 where doc_stat<>'9' and doc1_year_limit < 99 and doc1_k_id=0 and TO_DAYS(DATE_ADD(doc1_date,INTERVAL doc1_year_limit YEAR)) <= TO_DAYS('$DelDate') ";

$result = mysql_query ($query) or die ($query);
$num_record= mysql_num_rows($result); 

if ($key == "�C�L�P���M�U") {	
	include "include/firelist2.php";
	
	//�p��̫�@��
	if ($num_record % $page_count > 0 )
		$last_page = floor($num_record / $page_count)+1;
	else
		$last_page = floor($num_record / $page_count);
		
		
	$i = 1 ;
	$page = 1;	//����
	content_header();
	//�������O(�b docword_config.php ���]�w)
	$doc_kind_p = doc_kind();
	while($row = mysql_fetch_array( $result ) ) {
        	$doc1_id = $row["doc1_id"];
        	$doc1_main = $row["doc1_main"];
        	$doc1_word = $row["doc1_word"];        	        	
        	$doc1_kind = $doc_kind_p[$row["doc1_kind"]];
        	$doc1_date = $row["doc1_date"];
        	$doc1_date_sign = $row["doc1_date_sign"];        	
        	$doc1_unit = $row["doc1_unit"];        	
        	$doc1_unit_num1 = $doc_unit_p[$row["doc1_unit_num1"]] ;
        	
        	$temp = explode ("-",$doc1_date);
        	$doc1_date = sprintf("%d.%d.%d",$temp[0]-1911,$temp[1],$temp[2]);
        	
        	if ( ($i>1) && ($i % $page_count == 0) ) {        		
        		//content_end(); //�L�X���e
        		content_normal(); //�L�X���e
        		content_footer();
        		if ($num_record - ($page * $page_count) > 0) {
        			$page++;
        			page_break();
        			content_header();
        		}
        	}
//        	else if ($num_record == $i)
//        		content_end(); //�L�X���e
        	else
        		content_normal(); //�L�X���e
        	        	
        	$i++;
        }
        content_footer();
	exit;
}
else {
	while($row = mysql_fetch_array( $result ) ) {
        	$doc1_id = $row["doc1_id"];
        	$doc1_main = $row["doc1_main"];
        	$doc1_year_limit = $row["doc1_year_limit"];
        	$doc1_kind = $row["doc1_kind"];
        	$doc1_date = $row["doc1_date"];
        	$doc1_date_sign = $row["doc1_date_sign"];
        	$doc1_infile_date = $row["doc1_infile_date"];
        	$doc1_unit = $row["doc1_unit"];
        	$doc1_unit_num1 = $row["doc1_unit_num1"];        
        	$con.= "<tr><td>$doc1_year_limit</td><td>$doc1_date</td><td>$doc1_id</td><td>$doc1_unit</td><td>$doc1_main</td><td>$doc_unit_p[$doc1_unit_num1]</td><td>&nbsp;</td></tr>";
        }
}
include "header.php";
prog(4); //�W��menu (�b docword_config.php ���]�w)


?>
<table border="0"  width="100%" >
  <tr>

       <td align="center" width="100%" colspan=2>
       <form method="POST" action="<?php echo $PHP_SELF ?>">
	<?php 

	if ($key == "���P�L������") {
		echo "<H2><font color=\"red\">�U�C����N�Q���P�A�нT�{�P���M�U�w�C�L����</font></H2>";
		echo "<input type=\"hidden\" name=\"DelDate\" value=\"$DelDate\">";
		echo "<input type=\"submit\" name=\"key\" value=\"�T�w���P\">";
	}
	else
		echo "�P���ѦҤ��:<input type=\"text\" name=\"DelDate\" size=\"10\" value=\"$DelDate\"> <input type=\"submit\" value=\"�d��\" name=\"B1\"> &nbsp;<input type=\"submit\" value=\"�C�L�P���M�U\" name=\"key\">&nbsp;<input type=\"submit\" value=\"���P�L������\" name=\"key\"> </form>";
	?>
</tr>
</table>
<?php echo "<center><font size=4>�H $DelDate �d�ߡA�W�L�O�s�~������p $num_record ��</font></center>";?>
<table border=1 width="100%" >
<tr><td>�O�s�~��</td><td>������</td><td>���帹</td><td>�Ӥ���</td><td>���D��</td><td>��z���</td><td width="120">ñ��</td></tr>
<?php echo $con ?>
</table>
<?php
include "footer.php";
?>
