<?php                                                                                                                             
// $Id: exam_score.php 8673 2015-12-25 02:23:33Z qfon $

//���J�]�w��
include "exam_config.php";
session_start();

if(!checkid(substr($_SERVER[PHP_SELF],1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}
	
//�P�O�O�_���t�κ޲z��
//$man_flag = check_is_man();

//���o�~�ůZ��
if (isset($_SESSION[session_curr_class_num]))
	$curr_class = substr($session_curr_class_num,1,2 );
if ($curr_class_id == ""){
	//�ثe�Ǧ~
	$curr_year = sprintf("%03s",curr_year());
	//�ثe�Ǵ�
	$curr_seme = curr_seme();
	$curr_class_id =$curr_year.$curr_seme;
}
//���Z��
if ($_SESSION[session_e_kind_id] == $_POST[c_e_kind_id] or  $_POST[c_e_kind_id]=='')
	$e_kind_id = $_SESSION[session_e_kind_id];
else {
	$e_kind_id = $_POST[c_e_kind_id];
	$_SESSION[session_e_kind_id] = $_POST[c_e_kind_id];
}

//���o�Z�ŦW�ٰ}�C
$class_name = class_base();
	
//�ثe���@�~���Z��
$e_kind_id=intval($e_kind_id);
$sql_select  = "select exam.exam_id ,exam.exam_name from exam,exam_kind ";
$sql_select .= " where exam.e_kind_id=exam_kind.e_kind_id ";
$sql_select .= " and exam_kind.class_id like '$curr_class_id%' ";
$sql_select .= " and exam.e_kind_id='$e_kind_id' ";
$sql_select .= " and exam.teach_id ='$_SESSION[session_log_id]' ";
$sql_select .= " order by exam.exam_id  ";

$result = $CONN->Execute ($sql_select) or die ($sql_select);
while (!$result->EOF) {
	$exam_array[0][]= $result->fields[0];
	$exam_array[1][]= $result->fields[1];
	$result->MoveNext();
}

if ($_POST[print_key] == "�নExcel��") {
	$filename = "exam.xls"; 
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");
	echo '<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=big5">
	<title>�ǥͧ@�~�i��</title>
	</head>

	<body  >\n';
}
else
{
	//�ثe���@�~���Z��
	$sql_select = "select exam_kind.class_id,exam_kind.e_kind_id  from exam,exam_kind ";
	$sql_select .=" where exam.e_kind_id=exam_kind.e_kind_id and exam.teach_id ='$_SESSION[session_log_id]' and exam_kind.class_id like '$curr_year_seme%' group by exam_kind.class_id order by exam_kind.class_id  ";
	//echo $sql_select ;
	$result = $CONN->Execute($sql_select) or trigger_error("SQL ���~",E_USER_ERROR);

	$class_select_arr[-1]="�Ҧ��Z��";
	while(!$result->EOF){
		$temp_class = substr($result->fields[class_id],-3);
		$class_select_arr[$result->fields[e_kind_id]] = substr($result->fields[class_id],0,4) .'--' . $class_name[$temp_class];
		$result->MoveNext();
	}
	$sel = new drop_select();
	$sel->s_name="c_e_kind_id";
	$sel->id=$e_kind_id;
	$sel->has_empty = false;
	$sel->is_submit = true;
	$sel->arr= $class_select_arr;
	$class_select= $sel->get_select();

	
	include "header.php";
	echo "<h3>$exam_title</h3>\n";
	echo "<center><form name=myform action=\"$_SERVER[PHP_SELF]\" method=post >"; //�Z�ſﶵ
	echo "�w�� $_SESSION[session_tea_name] �n�J ";
	echo "&nbsp;�U&nbsp; $class_select \n";	
	if ($e_kind_id !="")
		echo "&nbsp;�U&nbsp;<input type=submit name=\"print_key\" value=\"�নExcel��\">";
	echo "&nbsp;�U&nbsp; <a href=\"exam_list.php\">�^�@�~��</a>";			
	echo "&nbsp;�U&nbsp; <a href=\"checkid.php?logout=1&exename=$_SERVER[PHP_SELF]\">�n�X�t��</a>";	
	
	echo "</form></center>";
}
echo "<center>";
echo "<table  border=1 >";
echo "<tr><td>�y��</td><td>�m�W</td>\n";

for($i=0 ; $i< count($exam_array[0]); $i++)
	echo "<td>�� ".($i+1)." ��</td>";//<BR>".$exam_array[1][$i]."</td>";

echo "</tr>\n";

//���o�ǥͩm�W
$e_kind_id=intval($e_kind_id);
$sql_select = "select exam_stud.stud_num,exam_stud.stud_name from exam_kind,exam,exam_stud where exam.e_kind_id = exam_kind.e_kind_id and exam.exam_id=exam_stud.exam_id and exam.e_kind_id='$e_kind_id' and exam_stud.stud_id not like 'demo%'  group by exam_stud.stud_num order by exam_stud.stud_num ";
$result = $CONN->Execute($sql_select); //�ǥ�
//echo $sql_select ;

while (!$result->EOF) {	
	$score_stud[$result->fields[0]] = $result->fields[1];	
	$result->MoveNext();
}

//���o�U�������Z
for($i=0 ; $i< count($exam_array[0]); $i++) {
	$sql_select = "select exam_stud.stud_num,exam_stud.tea_grade from exam LEFT JOIN exam_stud on exam_stud.exam_id = exam.exam_id where  exam.exam_id = '".$exam_array[0][$i]."' and exam_stud.stud_id not like 'demo%' order by exam_stud.stud_num  ";

	$result = $CONN->Execute ($sql_select) or die ($sql_select);
	while (!$result->EOF) {
		$stud_num = $result->fields["stud_num"];
		$score_grade[$i][$stud_num] = $result->fields["tea_grade"]; //���Z
		$result->MoveNext();
	}
}


foreach ( $score_stud as $sit_no => $stud_name )   {
		echo "<tr><td>".$sit_no."</td><td>".$stud_name."</td>";
		for($j=0 ; $j< count($exam_array[0]); $j++) {
			echo "<td>".$score_grade[$j][$sit_no]."</td>";
		}
		echo "</tr>";

		
}
?>
</table>

<? include "footer.php"; ?>
