<?php
                                                                                                                             
// $Id: search.php 5310 2009-01-10 07:57:56Z hami $

// --�t�γ]�w��
include "config.php"; 
// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

?>
<table border=0 width=100%>
<form method=get name=myform action="<?php echo $PHP_SELF ?>">
<tr><td align=center><B>�a�A�]�d��</B>�п�J�ǥͩm�W�G
&nbsp;<input type="text" name="s_str" maxlength=16 value="<?php echo $s_str ?>">�@
<input type="submit" name="key" value="�j�M">�@�@�@�@<a href="list.php">�^�ؿ�</a></td>
</tr>
</form>
</table>
<?php
if($s_str) {
$sql_select = " select stud_id,stud_name,curr_class_num,stud_study_cond  from stud_base where stud_name like '%$s_str%'  ";

$result = mysql_query ($sql_select,$conID)or die ($sql_select);
echo "<table align=center width='90%' border='1' cellspacing='0' cellpadding='4' bgcolor='#CCFFFF' bordercolor='#33CCFF'>
 <tr bgcolor='#66CCFF'> 
    <td >�ǥͩm�W</td>
    <td >�~�Z�y��</td> 
  </tr>";

while ($row = mysql_fetch_array($result)){
	$stud_id = $row["stud_id"];
	$stud_name = $row["stud_name"];
	$cond = $row["stud_study_cond"];
	$note=$cond_arr[$cond];	
	$curr=curr_class_num2_data($row["curr_class_num"]);
 	$curr_class_num=$curr[class_id]."-".$curr[num];
      echo "<tr><td><a href='show.php?stud_id=$stud_id'>$stud_name</a></td><td>$curr_class_num $note</td</tr>" ;
   
  }
echo "</table>";
	
}
?>
