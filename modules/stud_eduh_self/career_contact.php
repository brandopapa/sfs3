<?php

// $Id:  $

//���o�]�w��
include_once "config.php";
include "../../include/sfs_case_score.php";

sfs_check();

// ���O�d�d��
switch ($ha_checkary){
        case 2:
                ha_check();
                break;
        case 1:
                if (!check_home_ip()){
                        ha_check();
                }
                break;
}


//�q�X����
head("�ɮv�λ��ɱЮv");

//�Ҳտ��
print_menu($menu_p);

//�ˬd�O�_�}��
if (!$mystory){
   echo "�Ҳ��ܼƩ|���}�񥻥\��A�Ь��߾Ǯըt�κ޲z�̡I";
   exit;
}

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$seme_year_seme=sprintf('%03d%d',$curr_year,$curr_seme);
$student_sn=$_SESSION['session_tea_sn'];
$stud_name=$_SESSION['session_tea_name'];

$menu=$_POST['menu'];

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


//����ǥ;Ǵ��NŪ�Z��
$stud_seme_arr=array();
$table=array('stud_seme_import','stud_seme');
foreach($table as $key=>$value){
	$query="select * from $value where student_sn=$student_sn";
	$res=$CONN->Execute($query);
	while(!$res->EOF){
		$stud_grade=substr($res->fields['seme_class'],0,-2);
		$year_seme=$res->fields['seme_year_seme'];
		$semester=substr($year_seme,-1);	
		$seme_key=$stud_grade.'-'.$semester;
		$stud_seme_arr[$seme_key]=$year_seme;
		//������Ǵ��������
		if($year_seme==$seme_year_seme) {
			$curr_stud_grade=$stud_grade;
			$curr_seme_class=$res->fields['seme_class'];
			$curr_seme_num=$res->fields['seme_num'];
			$curr_seme_key=$seme_key;			
		}
		$res->MoveNext();
	}
}

//�i��Ƨ�
asort($stud_seme_arr);

//���Ϳ��
$memu_select="���ڬO $stud_name �A���Ǵ��NŪ�Z�šG $curr_seme_class �A�y���G $curr_seme_num �C";

//����B���p���q�ܡ@�@room_name room_tel room_fax 
$query="select * from school_room where enable='1'";
$res=$CONN->Execute($query);
while(!$res->EOF){
	$room_name=$res->fields['room_name'];
	$room_tel[$room_name]=$res->fields['room_tel'];
	$res->MoveNext();
}

$room_list="���Ǯլ����B���p���q�ܡG<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
<tr bgcolor='#c4ffd9' align='center'><td>�m�аȳB�n<br>{$room_tel['�аȳB']}</td><td>�m�ǰȳB�n<br>{$room_tel['�ǰȳB']}</td><td>�m���ɳB�n<br>{$room_tel['���ɳB']}</td></tr></table>";



//���o�J�����
$query="select * from career_contact where student_sn=$student_sn";
$res=$CONN->Execute($query);
$content_array=unserialize($res->fields['content']);

$contact_list="���ɮv�λ��ɱЮv�G<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' id='AutoNumber1' width=100%>
		<tr bgcolor='#c4d9ff' align='center'><td>�~��</td><td>�Ǵ�</td><td>�ɮv�m�W</td><td>�ɮv�p���q��</td><td>���ɱЮv�m�W</td><td>���ɱЮv�p���q��</td></tr>";

//�ˬd�O�_���i��g���
$contact_months="[,$contact_months,]";
$pos=strpos($contact_months,$curr_month,1);
//���e
foreach($stud_seme_arr as $seme_key=>$year_seme) {
	if($pos) {
		$bgcolor=($career_previous or $curr_seme_key==$seme_key)?'#ffdfdf':'#cfefef';
		$readonly=($career_previous or $curr_seme_key==$seme_key)?'':'readonly';
		$contact_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>
			<td><textarea name='contact[$seme_key][tutor]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$content_array[$seme_key][tutor]}</textarea></td>
			<td><textarea name='contact[$seme_key][tutor_tel]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$content_array[$seme_key][tutor_tel]}</textarea></td>
			<td><textarea name='contact[$seme_key][guidance]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$content_array[$seme_key][guidance]}</textarea></td>
			<td><textarea name='contact[$seme_key][guidance_tel]' style='border-width:1px; color:brown; background:$bgcolor; font-size:11px; width=100%; height=100%;' $readonly>{$content_array[$seme_key][guidance_tel]}</textarea></td>
			</tr>";
	} else {	
		$contact_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>
			<td>{$content_array[$seme_key][tutor]}</td>
			<td>{$content_array[$seme_key][tutor_tel]}</td>
			<td>{$content_array[$seme_key][guidance]}</td>
			<td>{$content_array[$seme_key][guidance_tel]}</td>
			</tr>";	
	}
}
$contact_list.="</table>";
	
$showdata="$room_list<br>$contact_list";

$act=$pos?"<br><center><input type='submit' value='�x�s����' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#5555ff; font-size:20px; height=42'></center>":"���Ǯճ]�w�i��g����G$m_arr[contact_months]";
$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'>$showdata $act</form></font>";

echo $main;

foot();

?>
