<?php

// $Id:  $

//���o�]�w��
include_once "config.php";
include "../../include/sfs_case_score.php";

sfs_check();

//�q�X����
head("�ɮv�λ��ɱЮv");

//�Ҳտ��
print_menu($menu_p,$linkstr);

//�x�s�����B�z
if($_POST['go']=='�x�s����'){
	$content=serialize($_POST['contact']);
	//�ˬd�O�_�w���¬���
	$query="select sn from career_contact where student_sn=$student_sn";
	$res=$CONN->Execute($query) or die("SQL���~:$query");
	$sn=$res->fields[0];
	if($sn) $query="update career_contact set content='$content' where sn=$sn";
		else $query="insert into career_contact set student_sn=$student_sn,content='$content'";
		$res=$CONN->Execute($query) or die("SQL���~:$query");
}

if($c_id){	
	//����B���p���q��
	$room_tel=get_room_tel();
	$room_list="���Ǯլ����B���p���q�ܡG<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
	<tr bgcolor='#c4ffd9' align='center'><td>�m�аȳB�n<br>{$room_tel['�аȳB']}</td><td>�m�ǰȳB�n<br>{$room_tel['�ǰȳB']}</td><td>�m���ɳB�n<br>{$room_tel['���ɳB']}</td></tr></table>";	
}

if($student_sn){
	//����ǥ;Ǵ��NŪ�Z��
	$stud_seme_arr=get_student_seme($student_sn);
	
	//���o�ɮv�λ��ɱЮv���
	$query="select * from career_contact where student_sn=$student_sn";
	$res=$CONN->Execute($query);
	$content_array=unserialize($res->fields['content']);

	$contact_list="���ɮv�λ��ɱЮv�G<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
		<tr bgcolor='#c4d9ff' align='center'><td>�~��</td><td>�Ǵ�</td><td>�ɮv�m�W</td><td>�ɮv�p���q��</td><td>���ɱЮv�m�W</td><td>���ɱЮv�p���q��</td></tr>";
	//���e
	foreach($stud_seme_arr as $seme_key=>$year_seme){
		$bgcolor=($career_previous or $curr_seme_key==$seme_key)?'#ffdfdf':'#cfefef';
		$readonly=($career_previous or $curr_seme_key==$seme_key)?'':'readonly';
		$contact_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>
		<td><textarea name='contact[$seme_key][tutor]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$content_array[$seme_key][tutor]}</textarea></td>
		<td><textarea name='contact[$seme_key][tutor_tel]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$content_array[$seme_key][tutor_tel]}</textarea></td>
		<td><textarea name='contact[$seme_key][guidance]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$content_array[$seme_key][guidance]}</textarea></td>
		<td><textarea name='contact[$seme_key][guidance_tel]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$content_array[$seme_key][guidance_tel]}</textarea></td>
		</tr>";
	}
	$contact_list.="</table>";
	
	$showdata="$room_list<br>$contact_list";
	$act="<br><center><input type='submit' value='�x�s����' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#5555ff; font-size:20px; height=42'></center>";
}

$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'><table style='border-collapse: collapse; font-size=12px;'><tr><td valign='top'>$class_select<br>$student_select</td><td valign='top'>$showdata $act</td></tr></table></form></font>";

echo $main;

foot();

?>
