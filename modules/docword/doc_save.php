<?php

// $Id: doc_save.php 8746 2016-01-08 15:41:01Z qfon $

//���J�]�w��
include "docword_config.php";
// session �{��
//session_start();
//session_register("session_log_id");

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

$year = date("Y")-1911;

///mysqli	
$mysqliconn = get_mysqli_conn();

// ���s�]�w�O�s�~��
if ($resetkey != ""){
	//$query = "select doc1_id,doc1_year_limit from sch_doc1 where doc1_k_id=0 and doc1_infile_date = '$doc1_infile_date' ";
	$query = "select doc1_id,doc1_year_limit from sch_doc1 where doc1_k_id=0 and doc1_infile_date = ? ";

///mysqli	
$stmt = "";
$stmt = $mysqliconn->prepare($query);
$stmt->bind_param('s',$doc1_infile_date);
$stmt->execute();
$stmt->bind_result($doc1_id,$doc1_year_limit);

///mysqli
	//$result = mysql_query($query);
	//while($row = mysql_fetch_array($result)) {	
      while ($stmt->fetch()) {	
		$temp = "doc1_year_limit_".$doc1_id;
		$doc1_year_limit = $$temp;
		//$doc1_id = $row[doc1_id];
		$query = "update sch_doc1 set doc1_year_limit ='$doc1_year_limit' where doc1_id='$doc1_id'"; 		
		mysql_query ($query) or die($query);
	}
}

//�����k��
else if($do_kind == "resign") {
	$query = "update sch_doc1 set doc_stat='1' ,doc1_infile_date ='' where doc1_id ='$doc1_id' ";
	mysql_query ($query);
	
}
//�k�ɳB�z
else if ($doc1_id !=""){
	if (strlen($doc1_id)<= $max_doc) //��~�פ���i²�ƿ�J
		$doc1_id = sprintf ("%d%0$max_doc"."s",$year,$doc1_id);
	//$query = "update sch_doc1 set doc_stat='2' , doc1_infile_date='$doc1_infile_date' ";
	$query = "update sch_doc1 set doc_stat='2' , doc1_infile_date=? ";
	if ($doc1_year_limit !="")
		$query .=",doc1_year_limit='$doc1_year_limit'";
	$query .=" where doc1_id='$doc1_id'"; 
	//mysql_query ($query) or die($query);
	
	
///mysqli	
$stmt = "";
$stmt = $mysqliconn->prepare($query);
$stmt->bind_param('s',$doc1_infile_date);
$stmt->execute();
$stmt->close();
///mysqli	
	
	
}
include "header.php";
prog(1); //�W��menu (�b docword_config.php ���]�w)

//�w�]�k�ɤ��
if ($doc1_infile_date == "")
	$doc1_infile_date = date("Y-m-j");
?>
<script language="JavaScript"><!--
function setfocus() {
<?php 
	if ($change_date != 1)
		echo "document.sform.doc1_id.focus();\n";
	else 
		echo "document.sform.doc1_infile_date.focus();\n";
?>
      return;
 }
// --></script>
<body  onload="setfocus()">
<br>
<form name="sform" method="POST" action="<?php echo $PHP_SELF ?>" >
<table cellSpacing="0" cellPadding="0"  align="center" bgColor="#000000" border="0">
  <tbody>
    <tr>
      <td>
        <table cellSpacing="1" cellPadding="3" width="100%" border="0">
          <tbody>
            <tr>
              <td bgColor="#cccccc"><b>�����k��</b></td>
            </tr>
            <tr>
<?php 
	if ($change_date != 1) {
            	?>
              <td bgColor="#ffffff">&nbsp;
                �k�ɤ���G <?php echo $doc1_infile_date ?><input type="hidden" name="doc1_infile_date" value="<?php echo $doc1_infile_date ?>">
                (<a href="<?php echo "$PHP_SELF?doc1_infile_date=$doc1_infile_date&change_date=1" ?>">�����</a>)
              </td>
            </tr>
            <tr>
              <td bgColor="#ffffff">&nbsp;
                ��J�帹�G <input type="text" name="doc1_id" size="12" >
		&nbsp;�O�s�~���G <input type="text" name="doc1_year_limit" size=5>&nbsp;(99:�ä[�O�s)<input type="submit" name="key" value="�T�w">(Enter��,�k��)<br>
                &nbsp;��~�פ���i²�ƿ�J�A��: <font color=red><?php echo sprintf("%d%0$max_doc"."s",$year,12); ?></font> ,��J<font color=red>12</font>�Y�i,�O�s�~���d��,�����ܨ��.
		<input type="hidden" name="ckey" value="<?php echo $ckey ?>">
              </td>
	<?php }
	//�����
	else {
		?>
		<td bgColor="#ffffff">&nbsp;
		<input type="hidden" name="change_date" value="0">
                �k�ɤ���G <input type="text" name="doc1_infile_date" value="<?php echo $doc1_infile_date ?>" onchange="document.sform2.submit()">
		<input type="hidden" name="ckey" value="<?php echo $ckey ?>">
		&nbsp;<input type="submit" name="key" value="�T�w">
              </td>
            </tr>

        <?php }

        ?>

            </tr>
            <tr>
		<td align="right" bgColor="#cccccc">
		<! �����k�ɤ��C�� >
<?php
//���o�ӿ�B��
$doc_unit_p = doc_unit();


///mysqli
$query = "select doc1_id,doc1_year_limit,doc1_kind,doc1_date,doc1_date_sign,doc1_unit,doc1_word,doc1_main,doc1_unit_num1,doc1_unit_num2,teach_id,doc1_k_id,doc_stat,doc1_end_date,doc1_infile_date,do_teacher from sch_doc1 where  doc1_infile_date=? and doc_stat = '2' order by doc1_id";	
$stmt = "";
$stmt = $mysqliconn->prepare($query);
$stmt->bind_param('s',$doc1_infile_date);
$stmt->execute();
$stmt->bind_result($doc1_id,$doc1_year_limitx,$doc1_kind,$doc1_date,$doc1_date_sign,$doc1_unit,$doc1_word,$doc1_main,$doc1_unit_num1,$doc1_unit_num2,$teach_id,$doc1_k_id,$doc_stat,$doc1_end_date,$doc1_infile_date,$do_teacher );

///mysqli

//$query = "select * from sch_doc1 where  doc1_infile_date='$doc1_infile_date' and doc_stat = '2' order by doc1_id";
//$result = mysql_query($query);
//echo $query;

echo "<center><b>$doc1_infile_date �k�ɤ��</b></center>";
echo "<table width=100% ><tr bgcolor=#C0C0C0><td> </td><td>�帹</td><td>�Ӥ���</td><td>�K�n</td><td>�ӿ�B��</td><td>";
if ($ckey == "1")
	echo "<a href=\"$PHP_SELF?ckey=0\">�����</a>�O�s�~��";
else
	echo "<a href=\"$PHP_SELF?ckey=1\">���</a>�O�s�~��";
echo "</td></tr>";
//�O�s�~��(�b docword_config.php ���]�w)
$doc_life_p = doc_life();
//�`����

//while($row = mysql_fetch_array($result)) {
  while ($stmt->fetch()) {
	$unit_temp = $doc_unit_p[$doc1_unit_num1]; //���o�B�ǦW��
	reset ($doc_life_p);
	if ($ckey == '1'){
		$doc1_year_limit ="<select name=\"doc1_year_limit_$doc1_id\" >";
		while(list($tkey,$tvalue)= each ($doc_life_p)){
			if ($tkey == $doc1_year_limitx)
				$doc1_year_limit .=  sprintf ("<option value=\"%d\" selected>%s</option>\n",$tkey,$tvalue);
			else
				$doc1_year_limit .=  sprintf ("<option value=\"%d\">%s</option>\n",$tkey,$tvalue);
		}
		$doc1_year_limit .= "</select>";
	}
	else
		$doc1_year_limit = $doc1_year_limitx;
		
	if ($i++ % 2 == 0)
		echo "<tr bgcolor=#AAEEAA>";
	else
		echo "<tr>";
	echo "<td><a href=\"$PHP_SELF?do_kind=resign&doc1_id=$doc1_id\">����</a></td><td>$doc1_id</td><td>$doc1_unit</td><td>$doc1_main</td><td>$unit_temp</td><td>$doc1_year_limitx</td></tr>";
}
echo "</table>";
?>
	</td>
            </tr>
            <tr>
            <td align=right bgcolor=#FFFFFF>
            <a href="javascript:var aa=window.open('file_save.htm', 'external', 'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0')">�ɮ׫O�s�~����Ǫ�</a>&nbsp;&nbsp;&nbsp;

	<?php
		if ($ckey ==1) {
			echo "<input type=\"hidden\" name=\"ckey\" value=\"$ckey\">";
            		echo" <input type=\"hidden\" name=\"doc1_infile_date\" value=\"$doc1_infile_date\">";
			echo "<input type=\"submit\" name=\"resetkey\" value=\"���s�]�w�O�s�~��\">";
		}
	?>
            </td></tr>
            </form>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<?php
include "footer.php";
?>
