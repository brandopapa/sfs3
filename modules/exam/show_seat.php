<?php
                                                                                                                             
// $Id: show_seat.php 6807 2012-06-22 08:08:30Z smallduh $

/// --�t�γ]�w��
include "exam_config.php";
// --�{�� session
//session_start();
//session_register("session_log_id");
if(!checkid(substr($_SERVER[$PHP_SELF],1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}


$query = "select class_id from exam_kind where e_kind_id = '$_SESSION[session_e_kind_id]'";
$result = $CONN->Execute($query);
$class_id = $result->fields[0];
$temp_clasee = substr($class_id,4); //���o�~�ůZ��
$query = "select a.stud_id,a.stud_num,a.stud_pass,a.stud_sit_num ,b.stud_name from exam_stud_data a ,stud_base b where b.stud_study_cond= 0 and a.stud_id = b.stud_id and b.curr_class_num like '$temp_clasee%' order by a.stud_num";

$result = $CONN->Execute($query) or die ($query);
while (!$result->EOF) {
	$stud_id = $result->fields["stud_id"];
	$stud_num = $result->fields["stud_num"];
	$stud_name = $result->fields["stud_name"];
	$stud_pass = $result->fields["stud_pass"];
	$stud_sit_num = $result->fields["stud_sit_num"];
	if ($_GET[show_pass]==1) { //��ܱK�X
		$pass_temp .= "<tr><td>$stud_num</td><td>$stud_name</td><td>$stud_id</td><td>$stud_pass</td></tr>\n";
	}
	else {
		$temp = explode ("-",$stud_sit_num);
		$col = hexdec($temp[0]); //��
		$row = hexdec($temp[1]); //�C
		
		$comparray[$col][$row]['stud_num'] = $stud_num ;//�y��
		$comparray[$col][$row]['stud_name'] = $stud_name ; //�m�W
		$comparray[$col][$row]['stud_id'] = $stud_id ;//�n�J�N��
		$comparray[$col][$row]['stud_pass'] = $stud_pass ; //�n�J�K�X 
	}
	
	$result->MoveNext();
}
$temp_class_name = get_class_name($class_id);
include "header.php";
echo "<center><b>$temp_class_name �y���</b>";
if ($_GET[show_pass]==1)
	echo "&nbsp;�U&nbsp; <a href=\"$_SERVER[$PHP_SELF]?show_pass=0\">���ñK�X</a>";
else
	echo "&nbsp;�U&nbsp; <a href=\"$_SERVER[$PHP_SELF]?show_pass=1\">��ܱK�X</a>";

echo "&nbsp;�U&nbsp; <a href=\"exam_list.php\">�^�@�~��</a></center>";

//��ܱK�X
if ($_GET[show_pass]==1) {
	echo "<center><table width=400 border=1></center>\n";
	echo "<tr><td>�y��</td><td>�m�W</td><td>�n�J�N��(�Ǹ�)</td><td>�n�J�K�X</td></tr>\n";
	echo $pass_temp;
	echo "\n</table >\n";
	include "footer.php";
	exit;
}
?>
<table width="100%" border="1">
<tr> 
<?php
for ($i=1; $i<=$class_cols;$i++){
	echo "<td width=\"5%\" >�s��</td>\n";
	echo "<td width=\"19%\">�m�W</td>\n";
}
echo "</tr>";
//�C�X�ǥͦW�U
for ($i=$class_rows;$i>=1;$i--) {
	echo "<tr> \n" ;
	for ($j=1; $j<=$class_cols; $j++) {
		//�������X
		$id = $j."-".$i ;
		echo '      <td width="5%" align=center>'.$id ."</td> \n" ;
		echo '      <td width="19%" align=center>' ;
		echo $comparray[$j][$i]['stud_num']." -- ";
		echo $comparray[$j][$i]['stud_name'];
		if ($_GET[show_pass]==1)
			echo "<br>(".$comparray[$j][$i]['stud_id']."-- <font color=red>".$comparray[$j][$i]['stud_pass']."</font>)";
		echo "</td> \n" ;
	}
	echo " </tr> \n" ;
}

?>
  </table>    
<? include "footer.php"; ?>
