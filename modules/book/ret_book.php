<?php  
                                                                                                                             
// $Id: ret_book.php 8723 2016-01-02 06:00:38Z qfon $

// --�t�γ]�w��  
include "book_config.php";  

$book_id = $_REQUEST['book_id'];

//�ˬd�޲zIP 
//$is_man = 0;
//for($mi=0 ; $mi< count($man_ip) ;$mi++){
//        if (check_home_ip($man_ip[$mi])){
//                $is_man = 1;
//                break;
//       }
//}

//if (!$is_man)
//	header("Location: err.php");

if (!$un_limit_ip) {
	//�ˬd�O�_������ IP 
	if (!check_home_ip($man_ip))
		header("Location: err.php");
}

// --�{�� session
//session_start();
//session_register("session_log_id");   

if(!checkid(substr($PHP_SELF,1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}

include "header.php";
$book_flag = 0;
if($book_id != ""){
///mysqli
$query = "SELECT borrow.bookch1_id, borrow.book_id, borrow.out_date, borrow.in_date,borrow.b_num,stud_base.stud_id, stud_base.stud_name,  book.book_name, book.book_author FROM borrow ,stud_base ,book where  borrow.stud_id = stud_base.stud_id and  borrow.book_id = book.book_id and in_date IS NULL and  borrow.book_id= ?";
$mysqliconn = get_mysqli_conn();
$stmt = "";
$stmt = $mysqliconn->prepare($query);
$stmt->bind_param('s',$book_id);
$stmt->execute();
$stmt->bind_result($bookch1_id, $book_id, $out_date, $in_date,$b_num,$stud_id, $stud_name,  $book_name, $book_author);
$stmt->fetch();
$stmt->close();
	//$query = "SELECT borrow.bookch1_id, borrow.book_id, borrow.out_date, borrow.in_date,borrow.b_num,stud_base.stud_id, stud_base.stud_name,  book.book_name, book.book_author FROM borrow ,stud_base ,book where  borrow.stud_id = stud_base.stud_id and  borrow.book_id = book.book_id and in_date IS NULL and  borrow.book_id= '$book_id'";
	//$result = mysql_query($query);
	
	//if (mysql_num_rows($result) >0 ){
	if ($b_num >0 ){
		//$row = mysql_fetch_array($result);
		//$stud_id = $row["stud_id"];
		//$stud_name = $row["stud_name"];
		//$book_name = $row["book_name"];	
		//$b_num = $row["b_num"];	
		$query = "update borrow set in_date='".$now."' where b_num='$b_num'";
		mysql_query($query);

		//�]�w���i�ɾ\
		$query = "update book set book_isout=0 where book_id='$book_id'";
		$result = mysql_query($query)or die ($query);    
		$book_flag = 1;
	}
}

?>

<body onload="setfocus()">
<script language="JavaScript"><!--
function setfocus() {
      document.bookform.book_id.focus();
      return;
 }
// --></script>
<table bgcolor=FFC800 width=100% ><tr><td>
<table><tr><td><h3>�ǥ��ٮѧ@�~</h3></td><td><h4><a href="bro_book.php">�ǥͭɮѧ@�~</a></h4></td></tr></table>

<form action ="<?php echo $PHP_SELF ?>" method="post" name="bookform">
��J�Ѹ��G<input type=text name="book_id" size="12" onchange="document.bookform.submit()" >
<input type=hidden name="stud_id" value="<?php echo $stud_id ?>">

</form>
<?php
if ($book_flag)
{
if ($stud_name !="")
	echo "<table><tr><td>Ū�̡G$stud_id -- $stud_name</td><td>�w�ٮѦW�G$book_name</td></tr></table>";	
	$query = "SELECT book.bookch1_id, book.book_id, book.book_name, book.book_num, borrow.stud_id,borrow.b_num,book.book_author,borrow.out_date, borrow.in_date FROM book , borrow where  book.book_id = borrow.book_id  and borrow.stud_id= '$stud_id' order by borrow.in_date ,borrow.out_date desc LIMIT 0, 10 ";
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
}
?>
</td></tr></table>
<?php
include "footer.php";
?>
