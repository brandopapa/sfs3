<?php

// $Id: teach_print2.php 5310 2009-01-10 07:57:56Z hami $

//���J�]�w��
include "config.php";


// --�{�� session 
sfs_check();



if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�


//���b¾���A
if ($c_sel != "")
	$sel = $c_sel;
else if ($sel=="")
	$sel = 0 ; //�w�]����b¾���p
	


	
//����ʧ@�P�_

$main=&main_form($sel_year,$sel_seme , $sel );



//�q�X����
head("��¾���q�T���C�L");
 $tool_bar=&make_menu($school_menu_p);
 echo $tool_bar;

echo $main;
foot();

//�D�n�e��
function &main_form($sel_year,$sel_seme , $sel){
	global $button;
	
	//���o�Юv���
	$row=&get_teacher_data(   $sel);

	$remove_p = remove(); //�b¾���p    
	$upstr = "���<select name=\"c_sel\" onchange=\"this.form.submit()\">\n"; 
	while (list($tid,$tname)=each($remove_p)){
		if ($sel== $tid)
			$upstr .= "<option value=\"$tid\" selected>$tname</option>\n";
		else
			$upstr .= "<option value=\"$tid\">$tname</option>\n";
	}
	$upstr .= "</select>"; 	

	$t_data="";
	for($i=0;$i<sizeof($row);$i++){
		$job = $row[$i]["title_name"];
		if ($row[$i]["class_num"]) {
			//�ť� 
			$job = class_id2big5($row[$i]["class_num"],$sel_year,$sel_seme);
		}


		$teach_name = $row[$i]["name"];

		$address = $row[$i]["address"];
		$home_phone = $row[$i]["home_phone"];
		$cell_phone = $row[$i]["cell_phone"];
		//�ഫ������
		$birthday=( substr($birthday,0,4)>1911)?(substr($birthday,0,4) - 1911). substr($birthday,4):"";
	
		$color= ($i%2 == 1) ? "white" : "#fafafa";
		
		$t_data.= "
		<tr bgcolor='$color' class='small'>
		<td>$job</td>
		<td>$teach_name</td>
		<td>$address</td>
		<td>$home_phone</td><td>$cell_phone</td></tr>\n";
	}
	
	
	$main="
	<table cellspacing='1' cellpadding='4' align='center' bgcolor='#C0C0C0'>
	<tr bgcolor='#FFFFB9'><td colspan='6' class='small'>
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	$upstr  <font color='#800000'>�@�� $i �����</font> 
	
	<tr bgcolor='#D0D8F7' class='small'><td>¾��</td><td>�m�W</td><td>�a�}</td><td>�q��</td><td>��ʹq��</td>
	</tr>
	$t_data
	</table>
	</form>";

	return $main;
}



//����Юv��ơA�]�A�qteach_person_id,name,birthday,address,home_phone,title_name,class_num�r
function &get_teacher_data( $sel = 0 ){
	global $CONN;
	
	//����Юv���
	$sql_select = "
	SELECT a.teach_person_id , a.name, a.birthday, a.address, a.home_phone, a.cell_phone , d.title_name ,b.class_num 
	FROM  teacher_base a , teacher_post b, teacher_title d 
	where  a.teacher_sn =b.teacher_sn  
	and b.teach_title_id = d.teach_title_id  
	and a.teach_condition = '$sel'  order by class_num, post_kind , post_office , a.teach_id "  ;              
	
	$recordSet=$CONN->Execute($sql_select) or user_error($sql_select,256);
	while($row=$recordSet->FetchRow()){
		$data[]=$row;
	}
	
	return $data;
}
?>
