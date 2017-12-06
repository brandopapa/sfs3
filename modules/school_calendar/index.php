<?php

// $Id: index.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�]�w�� */
include "config.php";

$month=($_GET[month])?$_GET[month]:$_POST[month];
$year=($_GET[year])?$_GET[year]:$_POST[year];
$day=($_GET[day])?$_GET[day]:$_POST[day];

if(!empty($_GET[this_date]) or !empty($_POST[this_date])){
	$this_date=($_GET[this_date])?$_GET[this_date]:$_POST[this_date];
	$d=explode("-",$_GET[this_date]);
	$year=$d[0];
	$month=$d[1];
	$day=$d[2];
}

$act=($_GET[act])?$_GET[act]:$_POST[act];

//����ʧ@�P�_
if($act=="getYearView"){
	$main=&getYearView($year);
}elseif($act=="getMonthThingView"){
	$main=&viewAll($year,$month,$day,"viewThing");
}elseif($act=="getMonthThingListView"){
	$main=&viewAll($year,$month,$day,"viewMonthThing");
}else{
	$main=&viewAll($year,$month,$day);
}


//�q�X����
head("�հȦ�ƾ�");
?>
<style type="text/css">
<!--
.calendarTr {font-size:12px; font-weight: bolder; color: #006600}
.calendarHeader {font-size:12px; font-weight: bolder; color: #cc0000}
.calendarToday {font-size:12px; background-color: #ffcc66}
.calendarTheday {font-size:12px; background-color: #ccffcc}
.calendar {font-size:11px;font-family: Arial, Helvetica, sans-serif;}
.dateStyle {font-size:15px;font-family: Arial; color: #cc0066; font-weight: bolder}
-->
</style>
<?php
echo $main;
foot();

function &viewAll($year="",$month="",$day="",$mode="",$cal_sn=""){
	global $school_menu_p;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	//���p�S������A���w����
	
	if(empty($year))$year=date("Y");
	if(empty($month))$month=date("m");
	if(empty($day))$day=date("d");
	
	//��ƾ�
	$cal=&getMonthView($year,$month,$day,$mode);
	
	//�ƥ�C��
	if($mode=="add"){
		$thing=&addThingForm($year,$month,$day);
	}elseif($mode=="modify"){
		$thing=&addThingForm($year,$month,$day,$cal_sn);
	}elseif($mode=="viewThing"){
		$thing="";
	}elseif($mode=="viewMonthThing"){
		$thing=&getMonththing($year,$month,$day);
	}else{
		$thing=&getthing($year,$month,$day);
	}
	
	$main="
	$tool_bar
	<table width='96%' cellspacing='0' cellpadding='0' bgcolor='#C0C0C0'><tr bgcolor='#FFFFFF'>
	<td valign='top'>$thing</td>
	<td width='5'></td>
	<td valign='top'>$cal</td>
	</tr></table>";
	return $main;
}


//���o���ƾ�
function &getMonthView($year="",$month="",$day="",$mode=""){
	global $today,$act;
	$cal = new MyCalendar;
	$cal->setStartDay(1);
	$mc=($mode=="viewThing")?$cal->getMonthThingView($month,$year,$day):$cal->getMonthView($month,$year,$day);

	if($act!="addThingForm")$act="";
	
	$main="
	<table cellspacing='1' cellpadding='2' bgcolor='#E2ECFC' class='small'>
	<tr bgcolor='#FEFBDA'><td align='center'>
	<a href='$_SERVER[PHP_SELF]?act=getYearView' class='box'><img src='images/month.png' alt='���~���' width='16' height='16' hspace='2' border='0' align='absmiddle'>���~���</a>
	
	<a href='$_SERVER[PHP_SELF]?act=$act&this_day=$today' class='box'><img src='images/today.png' alt='�^�줵��' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^�줵��</a>
	</td></tr>
	<tr bgcolor='#FFFFFF'><td>$mc</td></tr>
	</table>
	";
	return $main;
}

//���ƥ��`��
function &getMonththing($year,$month,$day){
	global $CONN,$import_array,$kind_array,$restart_array,$week_array,$today,$kind_color_array,$import_color_array,$mNames;
	
	$mounth_num=date("t",mktime(0,0,0,$month,$day,$year));
	$data="";
	for($i=1;$i<=$mounth_num;$i++){
		$data.=getOneDayThing($year,$month,$i,"show_date");
	}
	
	$m=$month*1;
	$cmName=$mNames[$m];

	$main="	
	<table width='100%' cellspacing='1' cellpadding='3' align='center' bgcolor='#DFE8F2' class='small'>
	<tr bgcolor='#FEFBDA'>
	<td colspan='10'>
	<font class='dateStyle'>$year</font>
	�~
	<font class='dateStyle'>$month</font>
	��
	<font class='dateStyle'>$day</font>�]�P��".$week_array[$w]."�^����ƾ�G
	<a href='$_SERVER[PHP_SELF]?act=$act&this_day=$today' class='box'><img src='images/today.png' alt='�^��ƾ�' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^��ƾ�</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingListView&this_date=$this_date' class='box'>
	<img src='images/list.png' alt='".$cmName."�ƥ��`��' width='16' height='16'  hspace='2' border='0' align='absmiddle'>".$cmName."�ƥ��`��</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingView&this_date=$this_date' class='box'>
	<img src='images/1day.png' alt='".$cmName."��ƾ�' width='16' height='16'  hspace='2' border='0' align='absmiddle'>".$cmName."��ƾ�</a>
	</td>
	</tr>
	<tr bgcolor='#EAECEE'>
	<td nowrap>���</td><td nowrap>�P��</td><td nowrap>�ɶ�</td><td nowrap>�a�I</td><td>�ƥ�</td><td nowrap>�B��</td><td nowrap>������</td><td nowrap>�`��</td><td nowrap>���n��</td>
	</tr>
	$data
	</table>";
	return $main;
}

//���o�Y��ƥ�A�u��<tr></tr>�A�S��<table></table>
function getOneDayThing($year,$month,$day,$mode=""){
	global $CONN,$import_array,$kind_array,$restart_array,$week_array,$today,$kind_color_array,$import_color_array,$MODULE_TABLE_NAME;

	//�B�ǥN�X
	$office=room_kind();
	//�P��
	$w=date ("w", mktime(0,0,0,$month,$day,$year));
	
	$this_date="$year-$month-$day";
	$this_date_tt=mktime (0,0,0,$month,$day,$year);
	
	$sql_select = "
	select * from calendar
	where 
	(
		(year='$year' and month='$month' and day='$day') or
		(
			(restart='md' and month='$month' and day='$day') or 
			(restart='d' and day='$day') or 
			(restart='w' and week='$w')
		) 
	)		
	and kind='0'
	order by time";
	$recordSet = $CONN->Execute($sql_select) or user_error("$sql_select",256);
	while ($c=$recordSet->FetchRow()) {
		
		$te=get_teacher_post_data($c[teacher_sn]);
		$teacher_post=$te[post_office];
		
		if($c[restart_day]!="0000-00-00"){
			$rd=explode("-",$c[restart_day]);
			if($this_date_tt < mktime (0,0,0,$rd[1],$rd[2],$rd[0])) {
				continue;
			}
		}
		if($c[restart_end]!="0000-00-00"){
			$re=explode("-",$c[restart_end]);
			if($this_date_tt > mktime (0,0,0,$re[1],$re[2],$re[0])) {
				continue;
			}
		}
		
		$name=get_teacher_name($c[from_teacher_sn]);
		$kind=$c[kind];
		$import=$c[import];
		$thing=nl2br($c[thing]);
		$time=substr($c[time],0,5);
		
		if($c[restart]=="w"){
			$restart_txt="�C�P��".$week_array[$w]."";
		}elseif($c[restart]=="d"){
			$restart_txt="�C�몺".$day."��";
		}elseif($c[restart]=="md"){
			$restart_txt="�C�~��".$month."��".$day."��";
		}else{
			$restart_txt="";
		}
		
		$show_date=($mode=="show_date")?"<td>$this_date</td><td>$week_array[$w]</td>":"";
		
		$data.="
		<tr bgcolor='#FFFFFF'>
		$show_date
		<td nowrap>$time</td>
		<td nowrap>$c[place]</td>
		<td>$thing</td>
		<td bgcolor='$kind_color_array[$kind]' nowrap>$office[$teacher_post]</td>
		<td nowrap>$name</td>
		<td nowrap>$restart_txt</td>
		<td nowrap><font color='$import_color_array[$import]'>$import_array[$import]</font></td>
		</tr>
		";
	}
	
	if(empty($data))$data=($mode=="show_date")?"<tr bgcolor='#FFFFFF'><td>$this_date</td><td>$week_array[$w]</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>":"<tr bgcolor='#FFFFFF'><td colspan='8' align='center' nowrap>����L�j�ơI</td></tr>";
	
	return $data;
}

//���o�Y��ƥ�
function &getthing($year,$month,$day){
	global $CONN,$import_array,$kind_array,$restart_array,$week_array,$today,$kind_color_array,$import_color_array,$mNames;
	
	$w=date ("w", mktime(0,0,0,$month,$day,$year));
	$this_date="$year-$month-$day";
	$data=getOneDayThing($year,$month,$day);
	
	$m=$month*1;
	$cmName=$mNames[$m];

	$main="	
	<table width='100%' cellspacing='1' cellpadding='3' align='center' bgcolor='#DFE8F2' class='small'>
	<tr bgcolor='#FEFBDA'>
	<td colspan='8'>
	<font class='dateStyle'>$year</font>
	�~
	<font class='dateStyle'>$month</font>
	��
	<font class='dateStyle'>$day</font>�]�P��".$week_array[$w]."�^����ƾ�G
	<a href='$_SERVER[PHP_SELF]?act=$act&this_day=$today' class='box'><img src='images/today.png' alt='�^�줵��' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^�줵��</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingListView&this_date=$this_date' class='box'>
	<img src='images/list.png' alt='".$cmName."�ƥ��`��' width='16' height='16'  hspace='2' border='0' align='absmiddle'>".$cmName."�ƥ��`��</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingView&this_date=$this_date' class='box'>
	<img src='images/1day.png' alt='".$cmName."��ƾ�' width='16' height='16'  hspace='2' border='0' align='absmiddle'>".$cmName."��ƾ�</a>
	</td>
	</tr>
	<tr bgcolor='#EAECEE'>
	<td nowrap>�ɶ�</td><td nowrap>�a�I</td><td>�ƥ�</td><td nowrap>����</td><td nowrap>������</td><td nowrap>�`��</td><td nowrap>���n��</td>
	</tr>
	$data
	</table>";
	return $main;
}

//���o�Y��²���ƥ�
function getSimpleThing($year,$month,$day){
	global $CONN,$import_array,$kind_array,$restart_array,$week_array,$today,$MODULE_TABLE_NAME;
	
	//�P��
	$w=date ("w", mktime(0,0,0,$month,$day,$year));
	
	$this_date="$year-$month-$day";
	$this_date_tt=mktime (0,0,0,$month,$day,$year);
	
	$sql_select = "
	select * from calendar
	where 
	(
		(year='$year' and month='$month' and day='$day') or
		(
			(restart='md' and month='$month' and day='$day') or 
			(restart='d' and day='$day') or 
			(restart='w' and week='$w')
		) 
	)		
	and kind='0'
	order by time";
	$recordSet = $CONN->Execute($sql_select) or user_error("$sql_select",256);
	while ($c=$recordSet->FetchRow()) {
		if($c[restart_day]!="0000-00-00"){
			$rd=explode("-",$c[restart_day]);
			if($this_date_tt < mktime (0,0,0,$rd[1],$rd[2],$rd[0])) {
				continue;
			}
		}
		if($c[restart_end]!="0000-00-00"){
			$re=explode("-",$c[restart_end]);
			if($this_date_tt > mktime (0,0,0,$re[1],$re[2],$re[0])) {
				continue;
			}
		}
		
		$name=get_teacher_name($c[from_teacher_sn]);
		
		$dot=(strlen($c[thing])>12)?"...":"";
		$thing=substr(nl2br($c[thing]),0,12).$dot;
		
		$time=substr($c[time],0,5);
		
		$data.="<li>$thing</li>
		";
	}
	
	return $data;
}

//���o�@�Өƥ󪺸��
function get_one_cal($cal_sn){
	global $CONN,$MODULE_TABLE_NAME;
	$sql_select = "select * from calendar where cal_sn=$cal_sn";
	$recordSet = $CONN->Execute($sql_select) or user_error("$sql_select",256);
	$c=$recordSet->FetchRow();
	return $c;
}


//�~�צ�ƾ�
function &getYearView($year=""){
	global $school_menu_p;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	$d = getdate(time());
	
	if ($year == ""){
	    $year = $d["year"];
	}
	
	$cal = new MyCalendar;
	//$cal->setStartMonth(4);
	$yearCal=$cal->getYearView($year);
	$main="
	$tool_bar
	<table cellspacing='1' cellpadding='4' bgcolor='#DFE8F2' class='small'>
	<tr bgcolor='#FEFBDA'><td><a href='$_SERVER[PHP_SELF]?act=$act&this_day=$today' class='box'><img src='images/1day.png' alt='�^��ƾ�' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^��ƾ�</a></td></tr>
	<tr bgcolor='#FFFFFF'><td>$yearCal</td>
	</tr></table>
	";
	return $main;
}


?>
