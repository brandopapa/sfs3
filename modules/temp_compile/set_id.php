<?php
// $Id: set_id.php 5310 2009-01-10 07:57:56Z hami $

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";

$class_year_b=$_REQUEST['class_year_b'];
$act=$_REQUEST['act'];
$pre=$_REQUEST['pre'];
$much=$_REQUEST['much'];
$sort_g=$_REQUEST['sort_g'];
$sort_s=$_REQUEST['sort_s'];
//�ϥΪ̻{��
sfs_check();

//�{�����Y
head("�s�ͽs�Z");
print_menu($menu_p,"class_year_b=$class_year_b");

$year=date("Y")-1911;
$year_num=$year;
if ($IS_JHORES!=0) $year_num%=10;

$main.= "
<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc>
<tr>
<td bgcolor='#FFFFFF'>";
//�������e�иm�󦹳B
if($act=="send"){
	//����Ѹ��L�Ǹ�
	$skip_id=explode(";",$_POST[skip_id]);
	//�}�l�ƾǸ�
	$sql="select * from new_stud where stud_study_year='$year' and sure_study<>'0' order by $sort_s $sort_g";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$i=1;
	while(!$rs->EOF){
		$stud_id=$pre.sprintf ("%0".$much."d", $i);
		if (in_array($stud_id,$skip_id)) {
			$main.="<font color='red'>".$stud_id."--->���L</font><br>";
		} else {
			$stud_name=addslashes($rs->fields['stud_name']);
			$newstud_sn=$rs->fields['newstud_sn'];
			$main.=$stud_id."--->".$stud_name."<br>";
			//�g�J�Ǹ�
			$sql_upd="update new_stud set stud_id='$stud_id' where newstud_sn='$newstud_sn' ";
			$CONN->Execute($sql_upd) or trigger_error($sql_upd,256);
			$rs->MoveNext();
		}
		$i++;
	}
}else{
	$main.="
	�]�w�Ǹ���h�G<br>
	<form action='{$_SERVER['PHP_SELF']}' method='POST'>
	�}�Y�Ʀr��<input type='text' name='pre' value='$year_num' size='2'>+<input type='text' name='much' size='2' maxlength='2' value='4'>��Ʀr<br><br>
	�Ǹ��ƧǨ̾ڡG<br>
	<table cellspacing=5 cellpadding=0><tr><td valign='top'>
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#E1ECFF' valign='top'><td>
	<input type='radio' name='sort_g' value='class_sort,class_site' checked>�Z�Ůy��<br>
	<input type='radio' name='sort_g' value='stud_name'>�m�W<br>
	<input type='radio' name='sort_g' value='stud_address'>��}<br>
	<input type='radio' name='sort_g' value='stud_birthday'>�ͤ�<br>
	<input type='radio' name='sort_g' value='stud_person_id'>�����Ҧr��<br>
	</td><td>
	<input type='radio' name='sort_s' value='' checked>���ީʧO<br>
	<input type='radio' name='sort_s' value='stud_sex desc,'>���]�w���Ҧ��k�ͦA�]�w�k��<br>
	<input type='radio' name='sort_s' value='stud_sex,'>���]�w���Ҧ��k�ͦA�]�w�k��<br>
	</td></tr></table>
	</td></tr></table><br>
	���L���ƾǸ��G<br>
	<table cellspacing=5 cellpadding=0><tr><td valign='top'>
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#E1ECFF' valign='top'><td>
	<textarea name='skip_id' cols='30' nowrap></textarea><br>
	</td><td width='300'>
	<ol>
	<li>�p�G�������Ǹ��A�i�H�b���]�w�A�ƾǸ��ɷ|�۰ʸ��L�C</li>
	<li>��J�Ǹ��ɽХΤp�g����(;)���j�A�ӥB���d�ťաA����������A�@����J�짹������C</li>
	</ol>
	</td></tr></table>
	</td></tr></table>
	<input type='hidden' name='act' value='send'>
	<input type='hidden' name='class_year_b' value='$class_year_b'>
	<input type='submit' value='�T�w'>
	</form>";
}
//�����D������ܰ�
$main.= "</td></tr></table>";

echo stripslashes($main);
//�{���ɧ�
foot();
?>