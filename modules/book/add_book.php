<?php

// $Id: add_book.php 5394 2009-02-12 06:40:08Z brucelyc $

// --�t�γ]�w��
include "book_config.php";
// --�{�� session
session_start();
if(!checkid(substr($_SERVER['PHP_SELF'],1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}
include "header.php";

if ($_POST['key']=="�妸�إ߸��"){
	$rst=-1;
	 if ($_FILES['userdata']['size']>0 && is_uploaded_file($_FILES['userdata']['tmp_name']) && !$_FILES['userdata']['error']){
		move_uploaded_file($_FILES['userdata']['tmp_name'],$tmp_path."/book_data.txt");
		$fd=file($tmp_path."/book_data.txt");
		$i=1;
		while ($fd[$i]!=""){
			$fd[$i]=ereg_replace("'","",$fd[$i]);
			$fd[$i]=ereg_replace("\"","",$fd[$i]);
			$tt=split(chr(9),$fd[$i]);
			// �Ѹ����i���Ŧr��
			if ($tt[0] != '' && $tt[1] != ''){ 
				$sql_insert = "insert into book (bookch1_id,book_id,book_name,book_num,book_author,book_maker,book_myear,book_bind,book_dollar,book_price,book_gid,book_content,book_isborrow,book_isbn,book_buy_date) values ('$tt[0]','$tt[1] ','$tt[2] ','$tt[3]','$tt[4] ','$tt[5] ','$tt[6]','$tt[7]','$tt[8]','$tt[9]','$tt[10]','$tt[11] ','$tt[12]','$tt[13]','$tt[14]')";
				$result=@mysql_query("$sql_insert");  
				if ($result)
					print "$tt[1] -- $tt[2] �s�W���\!<br>";
				else
					print "��Ʒs�W����!$sql_insert<br>";
			}
			$i++;
		}
		//��s�έp���
		$query = "select count(bookch1_id) as cc ,bookch1_id from book group by bookch1_id" ;
		$result = mysql_query($query);
		while ($row = mysql_fetch_row ($result)) {
			$query2 = "update bookch1 set tolnum= $row[0] where bookch1_id = '$row[1]' ";
			mysql_query ($query2);
		}
	}
	else {
		echo "�п�ܤ@�ӥHtxt�����[�ɦW���¤�r�ɮ�!";
		exit;
	}
}
?>

<h3>�ϮѸ�Ƨ妸����</h3>  
<form action ="<?php echo $_SERVER['SCRIPT_NAME'] ?>" enctype="multipart/form-data" method=post>  

�ɮסG<input type=file name=userdata ><br><p>  
<input type=submit name=key value="�妸�إ߸��">  
</form>  

�ϮѸ�Ƥ�r�ɰѦҦp�U�G<br>
���ɤ覡�G�H excel �إ߸�ơC�s�� ��r��(Tab�r�����j) ���ɮ׫��A�A�ëO�d�Ĥ@�C���Y�����C
�d���ɡG<a href="Book3.txt">Book3.txt</a>

<?php
	include "footer.php";
?>
