<?php
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
if($key =='�s�W')
{
$sql_insert = "insert into stud_base (stud_id,stud_name,stud_pass,tea_school,tea_img) values ('$stud_id','$stud_name','$stud_pass','$tea_school','$tea_img')";
// Insert: 
  $result = mysql_query ($sql_insert,$conID) or die($sql_insert);  
  if ($result) 
  include "stud_base.php";
  exit;
}

//$sql_update = "update exam_kind set e_kind_id='$e_kind_id',e_kind_name='$e_kind_name',e_kind_memo='$e_kind_memo'";


// Update: 
//$result = mysql_query ($sql_update,$conID);




?>
�H���޲z

<form method="post" >
<table>


<tr>
	<td>�Юv�N��<br>
		<input type="text" size="6" maxlength="6" name="stud_id" value="<?php echo $stud_id ?>">
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
		�O <input type="checkbox" name="tea_img" value="1" >
	</td>
</tr>

<tr>
	<td>
		<input type="submit" name="key" value="�s�W">
                &nbsp;&nbsp;<input type="button"  value= "�^�W��" onclick="history.back()">		
	</td>
</tr>
</table>
</form>
<? include "footer.php"; ?>


