<?php                                                                                                                             
// $Id: teacher_edit.php 8673 2015-12-25 02:23:33Z qfon $

if (!$isload)
{
include "config.php";
//session_start();
if ($session_tea_img != "1")
{
 $exename = $PHP_SELF;                                 
 include "checkid.php";
 exit;
}

include "header.php";
}
if ($sel =="delete")
  {
        echo "<form action=\"$PHP_SELF\" method=\"post\">\n"; 
        echo "�T�w�R�� <font color=red>".stripslashes ($stud_name)."</font> �H<br>";
        echo "<input type=\"hidden\" name=\"stud_id\" value=\"$stud_id\">\n";
        echo "<input type=\"submit\" name=\"key\" value=\"�T�w�R��\" >\n";
        echo "&nbsp;&nbsp;<input type=button  value= \"�^�W��\" onclick=\"history.back()\">";
        echo "</form>";
        include "footer.php";
	exit;
  }  
  if ($key =="�T�w�R��")
  {
        $sql_update = " delete from stud_base ";
	$sql_update .= " where stud_id='$stud_id' ";
	$result = mysql_query ($sql_update,$conID)  or die ($sql_update);  
	include "stud_base.php";	
	exit;
  }
  if ($key =="�ק�")
  {
	$sql_update = "update stud_base set stud_id='$stud_id',stud_name='$stud_name',stud_pass='$stud_pass',tea_school='$tea_school',tea_img='$tea_img' ";
	$sql_update .= " where stud_id='$stud_id' ";
	$result = mysql_query ($sql_update,$conID)  or die ($sql_update);  
	//echo $sql_update;
	include "stud_base.php";
	exit;
  }
///mysqli	
$mysqliconn = get_mysqli_conn();
$stmt = "";
$stmt = $mysqliconn->prepare("select stud_id,stud_name,stud_pass,tea_school,tea_img from stud_base where stud_id=?");
$stmt->bind_param('s', $stud_id);
$stmt->execute();
$stmt->bind_result($stud_id,$stud_name,$stud_pass,$tea_school,$tea_imgx);
while ($stmt->fetch()) {

        if ($tea_imgx=='1') 
	    $tea_img = " checked ";
	    else 
	    $tea_img = " ";
}

  
 /*
  $sql_select = "select stud_id,stud_name,stud_pass,tea_school,tea_img from stud_base";
  $sql_select .= " where stud_id='$stud_id' ";
  $result = mysql_query ($sql_select,$conID);  
 
while ($row = mysql_fetch_array($result)) {

	$stud_id = $row["stud_id"];
	$stud_name = $row["stud_name"];
	$stud_pass = $row["stud_pass"];
	$tea_school = $row["tea_school"];
        if ($row["tea_img"]=='1') 
	    $tea_img = " checked ";
	   else 
	    $tea_img = " ";
		

}

*/
?>
�ק�H�����
<form method="post" >
<table>
<tr>
	<td>�Юv�N��<br>
		<?php echo $stud_id ?>
	</td>
</tr>
<tr>
	<td>�Юv�m�W<br>
		<input type="text" size="20" maxlength="20" name="stud_name" value="<?php echo $stud_name ?>">
	</td>
</tr>



<tr>
	<td>�K�X<br>
		<input type="text" size="6" maxlength="6" name="stud_pass" value="<?php echo $stud_pass ?>">
	</td>
</tr>



<tr>
	<td>�Ǯ�<br>
		<input type="text" size="20" maxlength="20" name="tea_school" value="<?php echo $tea_school ?>">
	</td>
</tr>
<tr>
	<td>�޲z��<br>
		�O <input type="checkbox" name="tea_img" value="1" <? echo $tea_img ?> > 
	</td>
</tr>
<tr>
	<td>
	<input type="hidden" name=stud_id value="<? echo $stud_id; ?>">
	<input type="submit" name=key value="�ק�">
	&nbsp;&nbsp;<input type="button"  value= "�^�W��" onclick="history.back()">
	</td>
</tr>

</table>


<? include "footer.php"; ?>
