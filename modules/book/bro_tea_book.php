<?php
                                                                                                                             
// $Id: bro_tea_book.php 6803 2012-06-22 07:56:42Z smallduh $

// --�t�γ]�w��  
include "book_config.php";

$teach_id = $_REQUEST['teach_id'];
$book_id = $_REQUEST['book_id'];

//�ֳt���ܤU�@��ɮѪ�
if ($book_id == "33" || $book_id == "333333")
	header("Location: bro_tea_book.php");

if (!$un_limit_ip) {
        //�ˬd�޲zIP
        $is_man = 0;
        for($mi=0 ; $mi< count($man_ip) ;$mi++){
                if (check_home_ip($man_ip[$mi])){
                 $is_man = 1;
                 break;
                }
        }

        if (!$is_man)
                header("Location: err.php");
}


// --�{�� session
//session_start();
//session_register("session_log_id");
if(!checkid(substr($_SERVER['PHP_SELF'],1))){
	include "header.php";
	include "$rlogin";
	include "footer.php";
	exit;
}
include "header.php";
/*
//�R��
if ($sel == "del"){
	$query ="delete from borrow where b_num='$b_num'";
	mysql_query($query);
	//�]�w���i��
	$query = "update book set book_isout=0 where book_id='$dbook_id'";
	$result = mysql_query($query)or die ($query);
}	
*/

$reader_flag = 0;
//��̵n�J
if ($teach_id !=""){
	$query = "select teach_id,name from teacher_base  where teach_id = '$teach_id' and teach_condition=0 ";
	$result = mysql_query($query)or die ($query); 
	if ( mysql_num_rows($result) >0){
		$row= mysql_fetch_array($result);
		$name = $row["name"];
		$reader_flag = 1 ;
	}
	
}
//�ɮѳB�z
if ($book_id != ""){
	$query = "select book_id,bookch1_id,book_name,book_author from book where book_id='$book_id' and book_isout=0 and book_isborrow=0";
	$result = mysql_query($query)or die ($query); 
	$temp_bb = "<font color=red><b>�䤣��o���ѩΤw�Q�ɥX</b></font>";
	if ( mysql_num_rows($result) >0){
		$row= mysql_fetch_array($result);
		$bookch1_id = $row["bookch1_id"];
		$book_id = $row["book_id"];
		$book_name = $row["book_name"];
		$book_author = $row["book_author"];
		$temp_bb ="<table><tr><td>$book_id</td><td>$book_name</td><td>$book_authod</td></tr></table>";

		//�ɮѵn�O
		$query = "insert into borrow (stud_id, bookch1_id, book_id, out_date) values ('$teach_id', '$bookch1_id', '$book_id', '".$now."')";
		$result = mysql_query($query)or die ($query);
		//�]�w�w�ɥX
		$query = "update book set book_isout=1 where book_id='$book_id'";
		$result = mysql_query($query)or die ($query);
		$reader_flag = 1 ;
	}
}
if ($reader_flag == 0){
?>
<body onload="setfocus()">
<script language="JavaScript"><!--
function setfocus() {
      document.bookform.teach_id.focus();
      return;
 }
// --></script>
<table><tr><td><h3>�Юv�ɮѧ@�~</h3></td><td><h4><a href="ret_tea_book.php">�Юv�ٮѧ@�~</a></h4></td></tr></table>
<form action ="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="bookform">
��J�Юv�N���G<input type=text name="teach_id" size="12" onchange="document.bookform.submit()" >
</form>
<?php
}
else if ($reader_flag == 1){
?>
<body onload="setfocus()">
<script language="JavaScript"><!--
function setfocus() {
      document.bookform.book_id.focus();
      return;
 }
// --></script>

<table><tr><td><h3>�Юv�ɮѧ@�~</h3></td><td><h4><a href="ret_tea_book.php">�Юv�ٮѧ@�~</a></h4></td></tr></table>
<?php echo "�Юv�m�W�G$teach_id -- $name"; ?>
<form action ="<?php echo $PHP_SELF ?>" method="post" name="bookform">
��J�Ѹ��G<input type=text name="book_id" size="12" onchange="document.bookform.submit()" >&nbsp;&nbsp;<?php echo $temp_bb; ?><b>(�U�@���33)</b>
<input type=hidden name="teach_id" value="<?php echo $teach_id ?>">

</form>
<?php
}
?>


<?php
$query = "SELECT book.bookch1_id, book.book_id, book.book_name, book.book_num, borrow.stud_id,borrow.b_num,book.book_author,borrow.out_date, borrow.in_date FROM book , borrow where  book.book_id = borrow.book_id  and borrow.stud_id= '$teach_id' order by borrow.out_date desc ,borrow.in_date LIMIT 0, 10 ";
$result = mysql_query($query)or die ($query); 
echo "<center><table border=1>";
echo "<tr bgcolor=#8080FF><td>�`��</td><td>�Ѹ�</td><td>�ѦW</td><td>�ɾ\���</td><td>�k�٤��</td></tr>";
while ($row = mysql_fetch_array($result)){
	$bookch1_id = $row["bookch1_id"];
	$book_id = $row["book_id"];
	$book_name = $row["book_name"];
	$book_num = $row["book_num"];
	$out_date = $row["out_date"];
	$in_date = $row["in_date"];
	$b_num = $row["b_num"];
	if ($in_date == 0){
		echo "<tr bgcolor=yellow >";
		$in_date = "�|���k��";
	}
	else{
		echo "<tr>";
	}
	echo "<td>$bookch1_id</td>";
	echo "<td>$book_id</td>";
	echo "<td>$book_name</td>";
	echo "<td>$out_date</td>";
	echo "<td>$in_date</td>";
	echo "</tr>";
}
echo "</table>";
echo "</center>";
include "footer.php";
?>
