<?php

// $Id: doc_print.php 8716 2015-12-31 08:46:04Z qfon $

//���J�]�w��
include "docword_config.php";

// session �{��
//session_start();
//session_register("session_log_id");
$page_count = 15 ; //�C�������
if(!checkid($PHP_SELF)){
	$go_back=1; //�^��ۤw���{�ҵe��
	include "header.php";
	include $SFS_PATH."/rlogin.php";
	include "footer.php";
	exit;
}
else
	$ischecked = true;
//-----------------------------------

if ($QueryBeginDate == "" )
	$QueryBeginDate =date("Y-m-j");
if ($QueryEndDate == "")
        $QueryEndDate = date("Y-m-j");


//���o�ӿ�B��
$doc_unit_p = doc_unit();
if ($_POST[unit]!="") $unit_str=" and doc1_unit_num1 = '".intval($_POST[unit])."'";
if ($B1=="�帹�d��" or $key=="�帹�C�L")
        $query = "select * from sch_doc1 where  doc1_id >='$QueryBeginID' and  doc1_id <='$QueryEndID' $unit_str order by doc1_id";
else
        $query = "select * from sch_doc1 where TO_DAYS(doc1_date_sign) >=TO_DAYS('$QueryBeginDate') and TO_DAYS(doc1_date_sign) <=TO_DAYS(' $QueryEndDate') $unit_str order by doc1_id";

$result = mysql_query ($query) or die ($query);
if ($key == "�C�L" or $key=="�帹�C�L" or $key=="�C�L�k�ɳ�") {
	include "include/content.php";
	//header("Content-disposition: filename=print.");
	//header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
	//header("Expires: 0");
	if ($key == "�C�L" or $key=="�帹�C�L")
		$p_str="ñ��";
	else
		$p_str="�k��";

	$num_record= mysql_num_rows($result);
	//�p��̫�@��
	if ($num_record % $page_count > 0 )
		$last_page = floor($num_record / $page_count)+1;
	else
		$last_page = floor($num_record / $page_count);


	$i = 1 ;
	$page = 1;	//����
	content_header();
	while($row = mysql_fetch_array( $result ) ) {
        	$doc1_id = $row["doc1_id"];
        	$doc1_main = $row["doc1_main"];
        	$doc1_word = $row["doc1_word"];
        	$doc1_kind = $row["doc1_kind"];
        	$doc1_date = $row["doc1_date"];
        	$doc1_date_sign = $row["doc1_date_sign"];
        	$doc1_unit = $row["doc1_unit"];        	
        	$doc1_unit_num1 = $doc_unit_p[$row["doc1_unit_num1"]] ;
        	
        	$temp = explode ("-",$doc1_date);
        	$doc1_date = sprintf("%d.%d.%d",$temp[0]-1911,$temp[1],$temp[2]);
        	
        	if ( ($i>1) && ($i % $page_count == 0) ) {        		
        		content_end(); //�L�X���e
        		content_footer();
        		if ($num_record - ($page * $page_count) > 0) {
        			$page++;
        			page_break();
        			content_header();
        		}
        	}
        	else if ($num_record == $i)
        		content_end(); //�L�X���e
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
        	$con.= "<tr><td>$doc1_id</td><td>$doc1_date</td><td>$doc1_unit</td><td>$doc1_main</td><td>$doc_unit_p[$doc1_unit_num1]</td><td>&nbsp;</td></tr>";
        }
}
include "header.php";
prog(1); //�W��menu (�b docword_config.php ���]�w)

$sk = new drop_select();
$sk->s_name ="unit";
$sk->top_option = "����";
$sk->id = $_POST[unit];
$sk->arr = $doc_unit_p;
$sk->is_submit = false;
?>
<table border="0"  width="100%" >
  <tr>

       <td align="center" width="100%" colspan=2>
       <form method="POST" action="<?php echo $PHP_SELF ?>">
       <table><tr><td align="left">
	�n�����:��<input type="text" name="QueryBeginDate" size="10" value="<?php echo $QueryBeginDate; ?>">��<input type="text" name="QueryEndDate" size="10" value="<?php echo $QueryEndDate ?>">�� <input type="submit" value="�d��" name="B1"> &nbsp;<input type="submit" value="�C�L" name="key"> &nbsp;<input type="submit" value="�C�L�k�ɳ�" name="key"><br>
	��@�@��:��<input type="text" name="QueryBeginID" size="10" value="<?php echo $QueryBeginID; ?>">��<input type="text" name="QueryEndID" size="10" value="<?php echo $QueryEndID ?>">�� <input type="submit" value="�帹�d��" name="B1"> &nbsp;<input type="submit" value="�帹�C�L" name="key"><br>
	��z���:�@<?php $sk->do_select(); ?>
	</td></tr></table>
	</form>
</tr>
</table>
<table border=1 width="100%" >
<tr><td>���帹</td><td>������</td><td>�Ӥ���</td><td>���D��</td><td>��z���</td><td width="120">ñ��</td></tr>
<?php echo $con ?>
</table>
<?php
include "footer.php";
?>
