<?php
                                                                                                                             
// $Id: bro_book.php 7794 2013-12-03 03:39:50Z infodaes $

// --�t�γ]�w��  
include "book_config.php";
include "../../include/sfs_case_dataarray.php";

$study_cond=study_cond();
$book_id = $_REQUEST['book_id'];
$stud_id = $_REQUEST['stud_id'];

if ($book_id == "33" || $book_id == "333333")
	header("Location: bro_book.php");
if (!$un_limit_ip) {
	//�ˬd�O�_������ IP 
	if (!check_home_ip($man_ip))
		header("Location: err.php");
}
// --�{�� session   
//session_start();
//session_register("session_log_id");
if(!checkid(substr($PHP_SELF,1))){
	include "header.php";
	include "$rlogin";
	include "footer.php";
	exit;
}
include "header.php";
/*
//�R��
if ($sel == "del")
{
	$query ="delete from borrow where b_num='$b_num'";
	mysql_query($query);
	//�]�w���i��
	$query = "update book
		set book_isout=0
      		where book_id='$dbook_id'";
      	$result = mysql_query($query)or die ($query);  
}	

*/
$reader_flag = 0;
//��̵n�J
if ($stud_id !=""){
	$query = "select stud_name,curr_class_num,stud_study_cond,stud_study_year from stud_base where stud_id = '$stud_id' and stud_study_cond=0";
	$result = mysql_query($query)or die ($query);
	if ( mysql_num_rows($result) >0){
		$row= mysql_fetch_array($result);
		$stud_name = $row["stud_name"];
		if($row["stud_study_cond"]<>0) $stud_color="#FF0000"; else $stud_color="#000000";
		$stud_study_cond = $study_cond[($row["stud_study_cond"])];
		$stud_name ="<font color='$stud_color'>".$row["stud_name"]."($stud_study_cond)</font>";
		$curr_class_num =$row["curr_class_num"];
		$stud_study_year=$row["stud_study_year"];
		//�ˬd����ǥͤj�Y��
		$img=$UPLOAD_PATH."photo/student/".$stud_study_year."/".$stud_id; 
		if (file_exists($img)) $img_link="<img src='".$UPLOAD_URL."photo/student/".$stud_study_year."/".$stud_id."' width=$pic_width border=1><br>"; else $img_link='';
		
		$reader_flag = 1 ;
	}
}
//�ɮѳB�z
if ($book_id != ""){
	//�ˬd�O�_�W�X�ɾ\����
	$amount_limit_s=$amount_limit_s?$amount_limit_s:7;
	$query = "SELECT count(*) AS counter FROM borrow WHERE stud_id='$stud_id' and ISNULL(in_date)";
	$result = mysql_query($query)or die ($query);
	$row= mysql_fetch_array($result);
	if($row["counter"]>=$amount_limit_s) echo "<script language=\"Javascript\"> alert (\"���ǥͥ��k�٭ɮѼơG{$row['counter']}�A�w�g�F��Ҳ��ܼƳ]�w������ơG $amount_limit_s ���F�C\\n\\n �бN���ɥX���ϮѦ��^�I\")</script>";
	else {
		$query = "select book_id,bookch1_id,book_name,book_author from book where book_id='$book_id' and book_isout=0 and book_isborrow=0";
		$result = mysql_query($query)or die ($query); 
		//$temp_bb = "<font color=red><b>�䤣��o���ѩΤw�Q�ɥX</b></font>";
		$temp_bb = "<script language=\"Javascript\"> alert (\"�䤣��o���ѩΤw�Q�ɥX�F�I\")</script>";
		if ( mysql_num_rows($result) >0){
			$row= mysql_fetch_array($result);
			$bookch1_id = $row["bookch1_id"];
			$book_id = $row["book_id"];	
			$book_name = $row["book_name"];	
			$book_author = $row["book_author"];
			$temp_bb ="<table><tr><td>$book_id</td><td>$book_name</td><td>$book_authod</td></tr></table>" ;
			//�ɮѵn�O
			$query = "insert into borrow(stud_id, bookch1_id, book_id, out_date,curr_class_num) values ('$stud_id', '$bookch1_id', '$book_id', '".$now."','$curr_class_num')";
			$result = mysql_query($query)or die ($query);
			//�]�w�w�ɥX
			$query = "update book set book_isout=1 where book_id='$book_id'";
			$result = mysql_query($query)or die ($query);
			$reader_flag = 1 ;
		}
	}
}
if ($reader_flag == 0){
?>
<body onload="setfocus()">
<script language="JavaScript"><!--
function setfocus() {
      document.bookform.stud_id.focus();
      return;
 }
// --></script>
<table><tr><td><h3>�ǥͭɮѧ@�~</h3></td><td><h4><a href="ret_book.php">�ǥ��ٮѧ@�~</a></h4></td></tr></table>
<form action ="<?php echo $PHP_SELF ?>" method="post" name="bookform">
��J�Ǹ��G<input type=text name="stud_id" size="12" onchange="document.bookform.submit()" >
</form>
<?php
}
else if ($reader_flag == 1)
{
?>
<body onload="setfocus()">
<script language="JavaScript"><!--
function setfocus() {
      document.bookform.book_id.focus();
      return;
 }
// --></script>

<form action ="<?php echo $PHP_SELF ?>" method="post" name="bookform">
<table width=100%><tr><td><h3>�ǥͭɮѧ@�~</h3></td><td><h4><a href="ret_book.php">�ǥ��ٮѧ@�~</a></h4></td></tr>

<tr><td><?php echo $img_link ?></td><td align='left'><?php echo "���Ǹ��G$stud_id<br><br>���m�W�G$stud_name "; ?></td></td><td align='center'>�n ��J�Ѹ� �m<br><input type=text name="book_id" size="14" onchange="document.bookform.submit()" ><?php echo $temp_bb; ?><br><b>(�U�@���33)</b>
<input type=hidden name="stud_id" value="<?php echo $stud_id ?>"></td></tr>
</table>
</form>
<?php
}
?>

<?php
$query = "SELECT book.bookch1_id, book.book_id, book.book_name, book.book_num, borrow.stud_id,borrow.b_num,book.book_author,borrow.out_date, borrow.in_date FROM book , borrow where  book.book_id = borrow.book_id  and borrow.stud_id= '$stud_id' order by borrow.out_date desc ,borrow.in_date LIMIT 0, 10 ";
$result = mysql_query($query)or die ($query);
echo "<center><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111' id='AutoNumber1'>";
echo "<tr bgcolor=#8080FF align='center'><td>NO.</td><td>�`��</td><td>�Ѹ�</td><td>�ѦW</td><td>�ɾ\���</td><td>�k�٤��</td></tr>";
while ($row = mysql_fetch_array($result)){
	$i++;
	$bookch1_id = $row["bookch1_id"];
	$book_id = $row["book_id"];
	$book_name = $row["book_name"];
	$book_num = $row["book_num"];
	$out_date = $row["out_date"];
	$in_date = $row["in_date"];
	$b_num = $row["b_num"];
	if ($in_date == 0){
		echo "<tr bgcolor=yellow  align='center'>";
		$in_date = "�|���k��";
	}
	else{
		echo "<tr align='center'>";
	}
	echo "<td>$i</td>";
	echo "<td>$bookch1_id</td>";
	echo "<td>$book_id</td>";
	echo "<td align='left'>$book_name</td>";
	echo "<td>$out_date</td>";
	echo "<td>$in_date</td>";
	echo "</tr>";
}
echo "</table>";
echo "</center>";
include "footer.php";
?>
