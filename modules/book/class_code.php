<?php
                                                                                                                             
// $Id: class_code.php 8723 2016-01-02 06:00:38Z qfon $

// --�t�γ]�w��
include "book_config.php";
include_once "../../include/sfs_case_PLlib.php";
// --�{�� session 
//session_start();
//session_register("session_log_id"); 
$class_year = year_base();
if(!checkid(substr($_SERVER['PHP_SELF'],1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}
if ($_POST['key'] =="�s�@�Ϯ���"){
	echo "<html><body><table border=1 cellPadding=5 cellSpacing=10 ><tr>";
	$_POST[class_id]=intval($_POST[class_id]);
	$query = "select stud_id,stud_name from stud_base  where curr_class_num like '$_POST[class_id]%' and stud_study_cond =0 order by curr_class_num";
	$result = mysql_query ($query,$conID) or die ($query);             
	while ($row= mysql_fetch_array($result)){
		$core = $row["stud_id"];
		$topname = "$school_sshort_name"."--".$row["stud_name"];
		echo "<td align=center nowrap ><font size=2>$topname<BR>";
		barcode($core);
		echo "<br>$core</font></td>\n";
//		echo sprintf ("<img src=\"%s?code=%s&text=%s\">",$code_url,$row["stud_id"],"$school_sshort_name"."--".$row["stud_name"] );
		if ($i++ % $barcore_cols == $barcore_cols-1 )
			echo"</tr><tr>";
	}
	echo "</tr></table>";	
	echo "</body></html>";
	exit;
}
include "header.php";
$code_p =$_SERVER['PHP_SELF'];
?>

<center>
<h3>�Z�ŹϮ��ҦC�L</h3><form action="<?php echo $_SERVER['PHP_SELF'] ?>" method= "post">
<?php
	$class_base = class_base();
	$sel = new drop_select();
	$sel->id=$_POST['class_id'];
	$sel->arr =$class_base;
	$sel->s_name = "class_id";
	$sel->top_option="��ܯZ��";
	$sel->do_select();
?>

<hr><input type=submit name=key value="�s�@�Ϯ���">

</form>

<?php
foot();
?>
