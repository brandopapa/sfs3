<?php
                                                                                                                             
// $Id: qbooktea.php 5310 2009-01-10 07:57:56Z hami $

// --�t�γ]�w��
include "book_config.php";
include "header.php";
// ���ݭn register_globals
if (!ini_get('register_globals')) {
        ini_set("magic_quotes_runtime", 0);
        extract( $_POST );
        extract( $_GET );
        extract( $_SERVER );
}

sfs_check();
?>
<body  onload="setfocus()">
<script language="JavaScript"><!--
function setfocus() {
      document.sform.stud_id.focus();
      return;
 }
// --></script>
<form method="post" action="<?php echo $PHP_SELF ?>" name="sform">
<table  align="center">
<caption><BR><font size=4><B>�Юv�ɾ\�d��</b></font><hr></caption>
  <tr> 
    <td>��J�Юv�b���G<input type="text" name="stud_id" size=8 onchange="document.sform.submit()">
     <input type="submit" name="key" value="�d��">
     </td>
  </tr>
</table>
</form>
<table border=1 align=center>
<?php
if ($key == "�d��" || $stud_id != ""){
	$query = "select name from teacher_base  where teach_id ='$stud_id'";
	$result = mysql_query($query,$conID)or die ($query); 
	if ( mysql_num_rows($result) >0){
		$row= mysql_fetch_array($result);
		$name = $row["name"];
		$query = "select b.* ,a.book_name from borrow b,book a  where a.book_id=b.book_id and b.stud_id ='$stud_id' order by out_date desc";
		$result = mysql_query($query,$conID)or die ($query);
		$num = mysql_num_rows($result);
		echo "<caption>�Юv�m�W�G$name �֭p�U��: $num </caption>";
		echo "<tr bgcolor=#8080FF><td>�Ѹ�</td><td>�ѦW</td><td>�ɾ\���</td><td>�k�٤��</td></tr>\n";    
		while ($row = mysql_fetch_array($result)){
			if ($ci++ % 2 == 1 )
				$bgcolor =" bgcolor=#FFFF80 ";
			else
				$bgcolor = "";	
			if ($row["in_date"]==0)
				$in_date ="<font color=red>�|���k��</font>";
			else
				$in_date = substr($row["in_date"],0,10);
			echo sprintf ("<tr %s><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n",$bgcolor,$row["book_id"],$row["book_name"],substr($row["out_date"],0,10),$in_date);
		}
	}
}
echo "</table>";
include "footer.php";
?>
