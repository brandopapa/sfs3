<?php
// $Id: index.php 6991 2012-11-01 12:16:47Z infodaes $
/* ���o�򥻳]�w�� */
include "config.php";

sfs_check();
$teacher_sn=$_SESSION['session_tea_sn'];
$choice=$_POST['choice'];

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
$year_seme=$_POST['year_seme'];
if(!empty($year_seme)){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�


//����ץX������
switch ($choice) {
    case 0:
        break;
    case 1:
        Header("Location: list_all_teacher.php?sel_year=$sel_year&sel_seme=$sel_seme");
        break;
    case 2:
        Header("Location: list_all_room.php?sel_year=$sel_year&sel_seme=$sel_seme");
		break;
    case 3:
        Header("Location: list_class_sum.php?sel_year=$sel_year&sel_seme=$sel_seme");
        break;
    case 4:
        Header("Location: list_teach_sum.php?sel_year=$sel_year&sel_seme=$sel_seme");
        break;
    case 5:
        Header("Location: list_class_assign.php?sel_year=$sel_year&sel_seme=$sel_seme");
        break;
    case 6:
        Header("Location: list_chk_class.php?sel_year=$sel_year&sel_seme=$sel_seme");
        break;
	case 7:
        Header("Location: list_teach_sum_csv.php?sel_year=$sel_year&sel_seme=$sel_seme");
        break;
	case 8:
		Header("Location: csv_class_all.php?sel_year=$sel_year&sel_seme=$sel_seme");
		break;
}


//�q�X����
head("�Z�ŽҪ�d��");
$tool_bar=&make_menu($school_menu_p);
echo $tool_bar ;
//���o�~�׻P�Ǵ����U�Կ��
$date_select=class_ok_setup_year($sel_year,$sel_seme,"year_seme");

echo "<table cellspacing='1' cellpadding='4'  bgcolor=#9EBCDD><form name='myform' method='post' action='$_SERVER[PHP_SELF]'>
	<tr bgcolor='#F7F7F7'>
	<td>�ץX��openoffice ����ɮ�</td></tr>
	<tr><td>��ܾǴ��G$date_select</td></tr>
	<tr bgcolor='#F7F7F7'>
	<td>
	<input type='radio' value='1' name='choice'>�Юv�ӧO�Ҫ�ץX<br>
	<input type='radio' value='2' name='choice'>�M��ЫǽҪ�ץX<br>
	<input type='radio' value='3' name='choice'>�Z���`��ץX<br>
	<input type='radio' value='4' name='choice'>�Юv�`��ץX<br>
	<input type='radio' value='5' name='choice'>�Z�Űt�Ҫ�ץX(.CSV)<br>
	<input type='radio' value='7' name='choice'>�Юv�`��ץX(.CSV)<br>
	<input type='radio' value='8' name='choice'>�Z�ť\�Ҫ�M�LCSV�ץX<br>
	</td>
	</tr>
	<tr>
	<td align='center'>
	<input type='submit' name='go' value='����ץX'><br>
	</td>
	</tr>		
	</table></form>" ;
	
foot();


?>
