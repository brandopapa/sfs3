<?php
//$Id: stud_id2.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();


//�D���]�w
$school_menu_p=(empty($school_menu_p))?array():$school_menu_p;

$main=&main_form();


//�q�X�����������Y
head("�ǥ��ҭI�����");

echo $main;

//�G������
foot();

function &main_form(){
	global $school_menu_p;

    $tool_bar=&make_menu($school_menu_p);
    
	//�s�@���s
	$make_button1="<input type='button' value='�U�� PDF ��' onclick=\"window.location.href='stud_id2.pdf'\" class='b1'>";
	
	$make_button2="<input type='button' value='�U�� OpenOffice.org Writer ��' onclick=\"window.location.href='stud_id2.sxw'\" class='b1'>";

	$main="
	$tool_bar
	<table bgcolor='#c0c0c0' cellspacing=1 cellpadding=8 class='small'>
	<tr bgcolor='#FFFFFF'>
	<td valign=top>
	�ǥ��ҦC�L�Ȼs�@���������A���ǥ��ҭI����󴣨ѾǮզC�L�λs���ݨD�A��i�ۦ�s�@�C
	</td>
	</tr>
	<tr class='title_mbody'>
	<td valign=top>
	$make_button1
	$make_button2
	</td>
	</tr>
	</table>
	";
	return $main;
}

?>
