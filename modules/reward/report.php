<?php

// $Id: report.php 6764 2012-05-21 05:16:09Z infodaes $

/* ���o�]�w�� */
include "config.php";

sfs_check();

//���o�Ǧ~�Ǵ�
$year_seme=$_REQUEST[year_seme];
if ($year_seme) {
	$sel_year=intval(substr($year_seme,0,3));
	$sel_seme=substr($year_seme,3,1);
} else {
	$sel_year=(empty($_REQUEST[sel_year]))?curr_year():$_REQUEST[sel_year];
	$sel_seme=(empty($_REQUEST[sel_seme]))?curr_seme():$_REQUEST[sel_seme];
}

//���o�g��
$weeks_array=get_week_arr($sel_year,$sel_seme,$today);

if ($_REQUEST[week_num]) {
	$week_num=$_REQUEST[week_num];
	$weeks_array[0]=$week_num;
}

if (empty($week_num)) $week_num=$weeks_array[0];

$act=$_POST[act];

if ($act=="�C�L���y���i"){
	$oo_path="report";
	$kd="and a.reward_kind > '0'";
	include ("trans_main.php");
} elseif ($act=="�C�L�g�٤��i") {
	$oo_path="report";
	$kd="and a.reward_kind < '0'";
	include ("trans_main.php");
} elseif ($act=="�C�L������y") {
	$oo_path="report";
	$kd="and a.reward_kind > '0'";
	$dt="and a.reward_date = '".date("Y-m-d")."'";
	include ("trans_main.php");
} elseif ($act=="�C�L�����g��") {
	$oo_path="report";
	$kd="and a.reward_kind < '0'";
	$dt="and a.reward_date = '".date("Y-m-d")."'";
	include ("trans_main.php");
}

$main=&mainForm($sel_year,$sel_seme,$week_num);

//�q�X����
head("�g���g����");
echo $main;
echo "</tr></table>";
foot();

//�D�n��J�e��
function &mainForm($sel_year,$sel_seme,$week_num=""){
	global $student_menu_p,$SFS_PATH_HTML,$CONN,$today,$weeks_array;
	//�����\���
	$tool_bar=&make_menu($student_menu_p);

	//�g���
	$start_day=curr_year_seme_day($sel_year,$sel_seme);
	$week_select="";
	if (!$start_day[start])
		$week_select="�}�Ǥ�S���]�w";
	else {
		while(list($k,$v)=each($weeks_array)) {
			if ($k==0) continue;
			$weeks[$k]="��".$k."�g ($v ~ ".date("Y-m-d",(strtotime($v)+86400*6)).")";
		}
		$ds=new drop_select();
		$ds->s_name = "week_num"; //���W��
		$ds->id = $week_num; //����ID
		$ds->arr = $weeks; //���e�}�C
		$ds->has_empty = true; //���C�X�ť�
		$ds->top_option = "�п�ܶg��";
		$ds->bgcolor = "#FFFFFF";
		$ds->font_style = "font-size:12px";
		$ds->is_submit = true; //��ʮɰe�X�d��
		$week_select=$ds->get_select();
	}

	$reward_list=reward_data($sel_year,$sel_seme);

	$main="
	$tool_bar
	<table cellspacing='1' cellpadding='3' bgcolor='#C6D7F2'>
	<form action='$_SERVER[SCRIP_NAME]' method='post'>
	<tr bgcolor='#FFFFFF'><td>
	<font color='blue'>$sel_year</font>�Ǧ~�ײ�<font color='blue'>$sel_seme</font>�Ǵ�
	$week_select
	<input type='hidden' name='act' value='view'>
	���g���i
	<input type='submit' name='act' value='�C�L���y���i'>
	<input type='submit' name='act' value='�C�L�g�٤��i'>
	<input type='submit' name='act' value='�C�L������y'>
	<input type='submit' name='act' value='�C�L�����g��'>
	</td></tr></form>
	</table>
	<table cellspacing='1' cellpadding='3'>
	<tr>
	<td valign='top'>$reward_list</td>
	</tr>
	</table>
	";
	return $main;
}

function reward_data($sel_year,$sel_seme) {
	global $CONN,$weeks_array,$reward_arr,$class_year;

	//���o�ǥͰ}�C
	$reward_year_seme=$sel_year.$sel_seme;
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$all_sn="";
	$query="select * from stud_seme where seme_year_seme='$seme_year_seme' order by seme_class,seme_num";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$stud_id=$res->fields[stud_id];
		$student_sn=$res->fields[student_sn];
		$seme_class[$stud_id]=$res->fields[seme_class];
		$seme_num[$stud_id]=$res->fields[seme_num];
		$all_sn.="'".$student_sn."',";
		$res->MoveNext();
	}
	$all_sn=substr($all_sn,0,-1);
	$query="select stud_id,stud_name from stud_base where student_sn in ($all_sn)";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$stud_id=$res->fields[stud_id];
		$stud_name[$stud_id]=addslashes($res->fields[stud_name]);
		$res->MoveNext();
	}

	//���o�Z�Ű}�C
	$query="select class_id,c_name from school_class where year='$sel_year' and semester='$sel_seme' order by class_id";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$class_id=$res->fields[class_id];
		$c=explode("_",$class_id);
		$c_year=intval($c[2]);
		$class_name[$c_year.$c[3]]=$class_year[$c_year].$res->fields[c_name];
		$res->MoveNext();
	}

	$sw1=$weeks_array[0];
	$sw2=$sw1+1;
	$last_str=($sw2<count($weeks_array))?"and a.reward_date<'$weeks_array[$sw2]'":"";
	$temp_str="
		<table cellspacing='1' cellpadding='3' bgcolor='#9ebcdd' class='small'>
		<tr class='title_sbody2'>
		<td align='left'>�~��</td>
		<td align='left'>�Z��</td>
		<td align='left'>�y��</td>
		<td align='left'>�m�W</td>
		<td align='left'>���g���</td>
		<td align='left'>���g�ƥ�</td>
		<td align='left'>���g�̾�</td>
		<td align='left'>���g���O</td>
		<td align='left'>�Ƶ�</td>
		</tr>";
	$query="select a.* from reward a left join stud_seme b on a.student_sn=b.student_sn and b.seme_year_seme='$seme_year_seme' where a.reward_year_seme='$reward_year_seme' and a.reward_date>='$weeks_array[$sw1]' $last_str and dep_id <> 0 order by b.seme_class,b.seme_num";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$stud_id=$res->fields[stud_id];
		$reward_kind=$res->fields[reward_kind];
		$bgcolor=($reward_kind>0)?"#FFE6D9":"#E6F2FF";
		$c=explode("�~",$class_name[$seme_class[$stud_id]]);
		$temp_str.="
		<tr bgcolor=$bgcolor>
		<td>".$c[0]."
		<td>".$c[1]."
		<td>".$seme_num[$stud_id]."
		<td>".addslashes($stud_name[$stud_id])."
		<td width='100'>".addslashes($res->fields[reward_date])."
		<td width='150'>".addslashes($res->fields[reward_reason])."
		<td width='150'>".addslashes($res->fields[reward_base])."
		<td>".addslashes($reward_arr[$reward_kind])."
		<td></td>
		</tr>\n";
		
		$res->MoveNext();
	}
	
	return $temp_str;
}
?>
