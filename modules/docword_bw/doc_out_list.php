<?php

// $Id: doc_out_list.php 6805 2012-06-22 08:00:32Z smallduh $

//���J�]�w��
include "docword_config.php";
// session �{��
//session_start();
//session_register("session_log_id");

//�޲z���ˬd
if(checkid($PHP_SELF))
	$ischecked = true;
//-----------------------------------

include "header.php";
prog(2); //�W��menu (�b docword_config.php ���]�w)
//prog_doc2(1); //�lmenu (�b docword_config.php ���]�w)

if ($QueryBeginDate == "" )
	$QueryBeginDate = date("Y")."-1-1";
if ($QueryEndDate == "")
	$QueryEndDate = date("Y-m-j");


//�p�⭶��
$query ="select count(doc1_id) as cc from sch_doc1 where doc1_k_id = 1 ";

//�}�l�P�������
if ($QueryBeginDate !="")
	$query .= " and doc1_date >= '$QueryBeginDate' and doc1_date <= '$QueryEndDate' ";
//����r
if ($QueryString!="")
	$query .= " and (doc1_unit like'%$QueryString%' or doc1_main like '%$QueryString%' or do_teacher like '%$QueryString%') ";
//���
if ($doc1_unit_num1!= 0 )
	$query .= " and doc1_unit_num1 ='$doc1_unit_num1' ";
	
$result = mysql_query($query)or die($query);
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$num_record = $row[0];

//�p��̫�@��
if ($num_record % $page_count > 0 )
	$last_page = floor($num_record / $page_count)+1;
else
	$last_page = floor($num_record / $page_count);

$less_record = $num_record -($page_count * ($curr_page+1));

if (!isset($curr_page))
	$curr_page =1 ;

//�d�ߦr��	
$Qstr = "doc1_unit_num1=$doc1_unit_num1&QueryBeginDate=$QueryBeginDate&QueryEndDate=$QueryEndDate&QueryString=$QueryString";

if ($curr_page == 1)
	$navbar  = "[����]&nbsp;&nbsp;&nbsp;";

else
	$navbar  = "<a href=\"$PHP_SELF?curr_page=1&$Qstr\">[����]</a>&nbsp;&nbsp;&nbsp;";

if ($curr_page > 1)
	$navbar .= "<a href=\"$PHP_SELF?curr_page=".($curr_page-1)."&$Qstr\">[�W�@��]</a>&nbsp;&nbsp;";
else
	$navbar .= "[�W�@��]&nbsp;&nbsp;";

if ($curr_page >= $last_page)
	$navbar .= "[�U�@��]&nbsp;&nbsp;";
else
	$navbar .= "<a href=\"$PHP_SELF?curr_page=".($curr_page+1)."&$Qstr\"> [�U�@��]</a>&nbsp;&nbsp;";

if ($curr_page == $last_page)
	$navbar .= "[����]&nbsp;&nbsp;";
else
	$navbar .= "<a href=\"$PHP_SELF?curr_page=$last_page&$Qstr\"> [����]</a>&nbsp;";


?>

<table border="0" width="100%">
  <tr>
         <td align="right" width="100%" colspan=2><form method="POST" action="<?php echo $PHP_SELF ?>">
         �d�߽d�� <select name="doc1_unit_num1">         
	 <option value="0">�������</option>
	 <?php 
		$doc_unit_p = doc_unit(); //���o�B�ǦW�� ( --> docwprd_config.php)
		while(list($tkey,$tvalue)= each ($doc_unit_p)){
		if ($tkey == $doc1_unit_num1)
			echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
		else
			echo  sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
		}	 	
	 ?>
	 </select>&nbsp;��
	 <input type="text" name="QueryBeginDate" size="10" value="<?php echo $QueryBeginDate; ?>">��<input type="text" name="QueryEndDate" size="10" value="<?php echo $QueryEndDate ?>">��,����r:<input type="text" name="QueryString" size="10"><input type="submit" value="�d��" name="B1"></form></td>
  </tr>
  <tr>  
    <td width="35%" align="left">
	<?php 
    		if ($ischecked)
    			echo "<a href=\"doc_out.php\" >[�s�W�o��]</a>";
    
	?>
	<a href="doc_out_list.php" >[���s�d��]</a></td>
    <td width="65%" align="right">
    <?php echo $navbar; //�L�X������ ?>
    </td>
  </tr>
</table>
<table cellSpacing="0" cellPadding="0" width="100%" align="center" bgColor="#cccccc" border="0">
  <tbody>
    <tr>
      <td>
        <table cellSpacing="1" cellPadding="3" width="100%" border="0">
          <tbody>
<!------ ��ض}�l -------->

<table border="0" width="100%">
  <tr bgcolor= "#c0c0c0">

<?php

	echo "<td align='center'>�ӿ���</td><td>���帹</td><td align='center'>�o��K�n</td><td align='center'>�����</td><td align='center'>�o��r��</td><td align='center'>�o����</td>";


?>

</tr>

<?php
//���o�ӿ�B��
$doc_unit_p = doc_unit();

$query = "select doc1_id,doc1_year_limit,doc1_kind,doc1_date,doc1_date_sign,doc1_unit,doc1_word,doc1_main,doc1_unit_num1,doc1_unit_num2,teach_id from sch_doc1  where doc1_k_id = 1 ";
//�}�l�P�������
if ($QueryBeginDate !="")
	$query .= " and doc1_date >= '$QueryBeginDate' and doc1_date <= '$QueryEndDate' ";
//����r
if ($QueryString!="")
	$query .= " and (doc1_unit like'%$QueryString%' or doc1_main like '%$QueryString%' or do_teacher like '%$QueryString%') ";
//���
if ($doc1_unit_num1 != 0)
	$query .= " and doc1_unit_num1 ='$doc1_unit_num1' ";

$query .= " order by doc1_id desc  limit ".(($curr_page-1) * $page_count).", $page_count ";

$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {

	$doc1_id = $row["doc1_id"];
	$doc1_year_limit = $row["doc1_year_limit"];
	$doc1_kind = $row["doc1_kind"];
	$doc1_date = $row["doc1_date"];
	$doc1_date_sign = $row["doc1_date_sign"];
	$doc1_unit = $row["doc1_unit"];
	$doc1_word = $row["doc1_word"];
	$doc1_main = $row["doc1_main"];
	$doc1_unit_num1 = $row["doc1_unit_num1"];
	$doc1_unit_num2 = $row["doc1_unit_num2"];
	$teach_id = $row["teach_id"];
              $unit_temp = $doc_unit_p[$row[doc1_unit_num1]]; //���o�B�ǦW��
	if ($i++ % 2 == 0)
		echo  "<tr bgcolor=#FFFFCC>";
	else
		echo  "<tr bgcolor=#CCFFCC>";

		echo "<td align=center>$unit_temp</td><td><a href=\"doc_out_edit.php?doc1_id=$doc1_id\">$doc1_id</a></td><td>$doc1_main</td><td>$doc1_unit</td><td>$doc1_word</td><td>$doc1_date</td>";



	echo "</tr>";
};
echo "</table>";
?>
<table width=100%><tr>
<td>
<?php
	//���ƭp��
	$temp = $page_count * ($curr_page);
	if ( $temp >= $num_record)
		$temp = $num_record;
	echo sprintf("��%3d�ܲ�%3d��/�ŦX����@%5d��",$page_count * ($curr_page-1)+1,$temp,$num_record);
?>
</td>
<td>
<?php
	//���ƭp��
	echo sprintf("��%d��/�@%d��<font color=green>(�@��%d��)",$curr_page,$last_page,$page_count);
?>
</td>
<td align= right>
<?php echo $navbar; //�L�X������ ?>
</td></tr></table>
<!------ ��ص��� -------->
</tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>

<?php
include "footer.php";
?>