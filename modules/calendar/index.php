<?php

// $Id: index.php 7971 2014-04-01 06:50:58Z smallduh $

/* ���o�]�w�� */
include "config.php";

sfs_check();

//�ˬd�O�_���޲z�v, ���޲z�v�~��o�G�հȦ�ƾ�
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

//2014.04.01 �ץ�, ��ҥΨîհȮ�,�i�@���O���ҥΨîհȪ��A
if ($_POST['with_school_thing']==1) {
	$use_school=$_POST['use_school'];
  $_SESSION[use_school]=$use_school;
}

//$use_school=$_REQUEST['use_school'];
//$_SESSION[use_school]=($use_school=="" and ($_REQUEST['act']=="")) ?0:$_SESSION[use_school];
//$_SESSION[use_school]=($use_school=="on")?1:$_SESSION[use_school];

$month=($_GET[month])?$_GET[month]:$_POST[month];
$year=($_GET[year])?$_GET[year]:$_POST[year];
$day=($_GET[day])?$_GET[day]:$_POST[day];

if(!empty($_GET[this_date]) or !empty($_POST[this_date])){
	$this_date=($_GET[this_date])?$_GET[this_date]:$_POST[this_date];
	$d=explode("-",$this_date);
	$year=$d[0];
	$month=$d[1];
	$day=$d[2];
}

$act=($_GET[act])?$_GET[act]:$_POST[act];

//����ʧ@�P�_
if($act=="getYearView"){
	$main=&getYearView($year);
}elseif($act=="addThingForm"){
	$main=&viewAll($year,$month,$day,"add");
}elseif($act=="�s�J�O��"){
	addOneThing($_POST[data]);
	header("location: $_SERVER[PHP_SELF]?this_date=$_POST[this_date]");
}elseif($act=="�K�W��ƾ�"){
	PasteSchoolThing($_POST[data]);
	header("location: $_SERVER[PHP_SELF]");
}elseif($act=="modifyThing"){
	$main=&viewAll($year,$month,$day,"modify",$_GET[cal_sn]);
}elseif($act=="�x�s��s"){
	updateOneThing($_POST[data],$_POST[cal_sn]);
	header("location: $_SERVER[PHP_SELF]?this_date=$_POST[this_date]");
}elseif($act=="delThing"){
	delThing($_GET[cal_sn]);
	header("location: $_SERVER[PHP_SELF]?this_date=$_GET[this_date]");
}elseif($act=="getMonthThingView"){
	$main=&viewAll($year,$month,$day,"viewThing");
}elseif($act=="getMonthThingListView"){
	$main=&viewAll($year,$month,$day,"viewMonthThing");
}elseif($act=="PasteForm"){
	$main=&viewAll($year,$month,$day,"PasteForm");
}else{
	$main=&viewAll($year,$month,$day);
}


//�q�X����
head("��ƾ�");
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
	}elseif($mode=="PasteForm"){
		$thing=&PasteForm($year,$month,$day);
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
	$state=($_SESSION[use_school]==1?"(�îհ�)":"");
	$main="
	<table cellspacing='1' cellpadding='2' bgcolor='#E2ECFC' class='small'>
	<tr bgcolor='#FEFBDA'><td align='center'>
	<a href='$_SERVER[PHP_SELF]?act=getYearView' class='box'><img src='images/month.png' alt='���~���' width='16' height='16' hspace='2' border='0' align='absmiddle'>���~���</a>
	
	<a href='$_SERVER[PHP_SELF]?act=$act&this_day=$today' class='box'><img src='images/today.png' alt='�^�줵��' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^�줵��</a>
	</td></tr>
	<tr bgcolor='#FFFFFF'><td>$mc</td></tr>
	<tr><td align='center'>$state</td></tr>
	</table>
	";
	return $main;
}

//���ƥ��`��
function &getMonththing($year,$month,$day){
	global $CONN,$import_array,$kind_array,$restart_array,$week_array,$today,$kind_color_array,$import_color_array;
	global $module_manager;
	
	if ($module_manager) {
	  $paste="
	  <a href='$_SERVER[PHP_SELF]?act=PasteForm' class='box'>
	  <img src='images/appointment.png' alt='�ֶK�հȦ�ƾ�' width='16' height='16' hspace='2' border='0' align='absmiddle'>�ֶK�հȦ�ƾ�</a>";
	  
	}
	
	$mounth_num=date("t",mktime(0,0,0,$month,$day,$year));
	$data="";
	for($i=1;$i<=$mounth_num;$i++){
		$data.=getOneDayThing($year,$month,$i,"show_date");
	}
	$state=($_SESSION[use_school]==1?"(�îհ�)":"");
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
	<a href='$_SERVER[PHP_SELF]?act=addThingForm&this_date=$this_date' class='box'>
	<img src='images/appointment.png' alt='�s�W�ƥ�' width='16' height='16' hspace='2' border='0' align='absmiddle'>�s�W�ƥ�</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingListView&this_date=$this_date' class='box'>
	<img src='images/list.png' alt='���ƥ��`��' width='16' height='16'  hspace='2' border='0' align='absmiddle'>���ƥ��`��</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingView&this_date=$this_date' class='box'>
	<img src='images/1day.png' alt='����ƾ�' width='16' height='16'  hspace='2' border='0' align='absmiddle'>����ƾ�</a>
	$paste
	$state
	</td>
	</tr>
	<tr bgcolor='#EAECEE'>
	<td nowrap>���</td><td nowrap>�P��</td><td nowrap>�ɶ�</td><td nowrap>�a�I</td><td>�ƥ�</td><td nowrap>����</td><td nowrap>������</td><td nowrap>�`��</td><td nowrap>���n��</td><td nowrap>�\��</td>
	</tr>
	$data
	</table>";
	return $main;
}

//���o�Y��ƥ�A�u��<tr></tr>�A�S��<table></table>
function getOneDayThing($year,$month,$day,$mode=""){
	global $CONN,$import_array,$kind_array,$restart_array,$week_array,$today,$kind_color_array,$import_color_array,$MODULE_TABLE_NAME;
	global $coop_edit;

	//�P��
	$w=date ("w", mktime(0,0,0,$month,$day,$year));
	
	$this_date="$year-$month-$day";
	$this_date_tt=mktime (0,0,0,$month,$day,$year);
	
	$sql_select = "
	select * from $MODULE_TABLE_NAME[0]
	where 
	(
		(year='$year' and month='$month' and day='$day') or
		(
			(restart='md' and month='$month' and day='$day') or 
			(restart='d' and day='$day') or 
			(restart='w' and week='$w')
		) 
	) and (teacher_sn=$_SESSION[session_tea_sn]";
	$sql_select .= ($_SESSION[use_school]==1)?" or kind=0)":")";	
	$sql_select .= " order by time";
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
		$modify_tool=(($_SESSION[session_tea_sn]==$c[from_teacher_sn]) or ($kind==0 and $coop_edit==1))?"<a href='$_SERVER[PHP_SELF]?act=modifyThing&cal_sn=$c[cal_sn]&this_date=$this_date'>�ק�</a>":"";	
		$del_tool=(($_SESSION[session_tea_sn]==$c[from_teacher_sn]) or ($kind==0 and $coop_edit==1))?"| <a href='$_SERVER[PHP_SELF]?act=delThing&cal_sn=$c[cal_sn]&this_date=$this_date'>�R��</a>":"";
		
		$show_date=($mode=="show_date")?"<td>$this_date</td><td>$week_array[$w]</td>":"";
		
		$data.="
		<tr bgcolor='#FFFFFF'>
		$show_date
		<td nowrap>$time</td>
		<td nowrap>$c[place]</td>
		<td>$thing</td>
		<td bgcolor='$kind_color_array[$kind]' nowrap>$kind_array[$kind]</td>
		<td nowrap>$name</td>
		<td nowrap>$restart_txt</td>
		<td nowrap><font color='$import_color_array[$import]'>$import_array[$import]</font></td>
		<td nowrap>
		$modify_tool
		$del_tool</td>
		</tr>
		";
	}
	
	if(empty($data))$data=($mode=="show_date")?"<tr bgcolor='#FFFFFF'><td>$this_date</td><td>$week_array[$w]</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>":"<tr bgcolor='#FFFFFF'><td colspan='8' align='center' nowrap>����L�j�ơI</td></tr>";
	
	return $data;
}

//���o�Y��ƥ�
function &getthing($year,$month,$day){
	global $CONN,$import_array,$kind_array,$restart_array,$week_array,$today,$kind_color_array,$import_color_array;
	global $module_manager;
	
	if ($module_manager) {
	  $paste="
	  <a href='$_SERVER[PHP_SELF]?act=PasteForm' class='box'>
	  <img src='images/appointment.png' alt='�ֶK�հȦ�ƾ�' width='16' height='16' hspace='2' border='0' align='absmiddle'>�ֶK�հȦ�ƾ�</a>";
	  
	}
	$w=date ("w", mktime(0,0,0,$month,$day,$year));
	$this_date="$year-$month-$day";
	$data=getOneDayThing($year,$month,$day);
	
	$use_checked=($_SESSION[use_school]==1)?"checked":"";

	$main="
	<form name=\"myform\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">	
	<input type='hidden' name='with_school_thing' value=0>
	<table width='100%' cellspacing='1' cellpadding='3' align='center' bgcolor='#DFE8F2' class='small'>
	<tr bgcolor='#FEFBDA'>
	<td colspan='8'>
	<font class='dateStyle'>$year</font>
	�~
	<font class='dateStyle'>$month</font>
	��
	<font class='dateStyle'>$day</font>�]�P��".$week_array[$w]."�^����ƾ�G
	<a href='$_SERVER[PHP_SELF]?act=$act&this_day=$today' class='box'><img src='images/today.png' alt='�^�줵��' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^�줵��</a>
	<a href='$_SERVER[PHP_SELF]?act=addThingForm&this_date=$this_date' class='box'>
	<img src='images/appointment.png' alt='�s�W�ƥ�' width='16' height='16' hspace='2' border='0' align='absmiddle'>�s�W�ƥ�</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingListView&this_date=$this_date' class='box'>
	<img src='images/list.png' alt='���ƥ��`��' width='16' height='16'  hspace='2' border='0' align='absmiddle'>���ƥ��`��</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingView&this_date=$this_date' class='box'>
	<img src='images/1day.png' alt='����ƾ�' width='16' height='16'  hspace='2' border='0' align='absmiddle'>����ƾ�</a>
	$paste
	<input type='checkbox' name='use_school' value='1' $use_checked onclick='this.form.with_school_thing.value=\"1\";this.form.submit()';>�îհ�
	<input name='act' type='hidden' id='act' value=''>
	<input name='this_date' type='hidden' id='this_date' value='$this_date'>
	</td>
	</tr>
	<tr bgcolor='#EAECEE'>
	<td nowrap>�ɶ�</td><td nowrap>�a�I</td><td>�ƥ�</td><td nowrap>����</td><td nowrap>������</td><td nowrap>�`��</td><td nowrap>���n��</td><td nowrap>�\��</td>
	</tr>
	$data
	</table>
	</form>	";
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
	select * from $MODULE_TABLE_NAME[0]
	where 
	(
		(year='$year' and month='$month' and day='$day') or
		(
			(restart='md' and month='$month' and day='$day') or 
			(restart='d' and day='$day') or 
			(restart='w' and week='$w')
		) 
	) and (teacher_sn=$_SESSION[session_tea_sn]";
	$sql_select .= ($_SESSION[use_school]==1)?" or kind=0)":")";	
	$sql_select .= " order by time";
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

//�s�W�ƥ���
function &addThingForm($year="",$month="",$day="",$cal_sn=""){
	global $import_array,$kind_array,$hour_array,$restart_array,$week_array;
	global $module_manager,$manager_kind_array,$nor_kind_array;
	
	if(!empty($cal_sn)){
		$cal_data=get_one_cal($cal_sn);
	}
	
	$is_v=(!empty($cal_sn))?$cal_data[import]:2;
	$is=new drop_select;
	$is->s_name="data[import]";
	$is->arr=$import_array;
	$is->id=$is_v;
	$is->font_style = "font-size:12px";
	$import_select=$is->get_select();
	
	$ks_v=(!empty($cal_sn))?$cal_data[kind]:2;
	$ks=new drop_select;
	$ks->s_name="data[kind]";
	$ks->arr=($module_manager)?$manager_kind_array:$nor_kind_array;
	$ks->id=$ks_v;
	$ks->font_style = "font-size:12px";
	//$ks->use_val_as_key=true;
	$kind_select=$ks->get_select();
	
	$rs_v=(!empty($cal_sn))?$cal_data[restart]:"���`��";
	$rs=new drop_select;
	$rs->s_name="data[restart]";
	$rs->arr=$restart_array;
	$rs->id=$rs_v;
	$rs->font_style = "font-size:12px";
	$restartselect=$rs->get_select();
	
	if(!empty($cal_sn)){
		$t=explode(":",$cal_data[time]);
	}
	$ts_v=(!empty($cal_sn))?$t[0]:date("H");
	$hs=new drop_select;
	$hs->s_name="data[h]";
	$hs->arr=$hour_array;
	$hs->has_empty=false;
	$hs->id=$ts_v;
	$hs->font_style = "font-size:12px";
	$hour_select=$hs->get_select();
	
	
	//�Юv���
	$to_tsn_arr=(!empty($cal_sn))?get_cal_to_who($cal_sn):"";
	$teacher_array=teacher_array();
	$teacher_array[all]="������";
	$ts=new drop_select;
	$ts->s_name="data[to_teacher_sn][]";
	$ts->arr=$teacher_array;
	$ts->unvisible_arr=array($_SESSION[session_tea_sn]);
	$ts->top_option="�����}";
	$ts->font_style = "font-size:12px";
	$ts->multiple=true;
	$ts->multiple_id=$to_tsn_arr;
	$ts->size=9;
	$teacher_select=$ts->get_select();
	
	$this_date="$year-$month-$day";
	$w=date ("w", mktime(0,0,0,$month,$day,$year));
	
	$restart_day=(!empty($cal_sn))?$cal_data[restart_day]:$this_date;
	$submit=(!empty($cal_sn))?"�x�s��s":"�s�J�O��";
	
	$main="
	
	<table width='100%' cellspacing='1' cellpadding='3' align='center' bgcolor='#DFE8F2' class='small'>
	<tr bgcolor='#FEFBDA'><td colspan='3'>
	<font class='dateStyle'>$year</font>
	�~
	<font class='dateStyle'>$month</font>
	��
	<font class='dateStyle'>$day</font>
	�]�P��".$week_array[$w]."�^����ƾ�G
	<a href='$_SERVER[PHP_SELF]?this_date=$this_date' class='box'>
	<img src='images/1day.png' alt='�^��ƾ�C��' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^��ƾ�C��</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingView&this_date=$this_date' class='box'><img src='images/list.png' alt='����ƾ�' width='16' height='16' hspace='2' border='0' align='absmiddle'>����ƾ�</a></td></tr>
	<form action='$_SERVER[PHP_SELF]' method='post'>
	<input type='hidden' name='data[year]' value='$year'>
	<input type='hidden' name='data[month]' value='$month'>
	<input type='hidden' name='data[day]' value='$day'>
	<input type='hidden' name='data[week]' value='$w'>
	<tr bgcolor='#FFFFFF'>
	<td colspan='2' nowrap>
	�ɶ��G $hour_select<input type='text' name='data[min]' value='$t[1]' size='2' maxlength='2'> ���A
	�a�I�G<input type='text' name='data[place]' value='$cal_data[place]'>�A
	�бN�ƥ�ԭz��U�G<br>
	<textarea cols='50' rows='5' name='data[thing]' style='width:100%' class='small'>$cal_data[thing]</textarea></td>
</tr>
	<tr bgcolor='#FFFFFF'>
	<td nowrap>�����G $kind_select
	</td>
	<td rowspan='5'>
		<table class='small'><tr><td valign='top'>
		���}���G<br>
		$teacher_select
		</td><td valign='top'>
		<ol style='line-height: 1.5;'>
		<li><font color='#8000FF'><strong>�w���Ǯզ�ƾ�G</strong></font>�b�u�����v���A��u�հȡv�|��Өƥ�����Ǯզ�ƾ䪺�ƥ�C</li>
		<li><font color='#8000FF'><strong>��ƥ�ƻs����L�Юv�G</strong></font>�b�u���}���G�v���I��Юv�W�٧Y�i�C���� ctrl �M���I��A�i�H���s��ƿ�C���� shift �M���I��U�A�i�H�s��ƿ�C�Y��F�u�����աv�A�h�|�ƻs�����ձ�¾���C</li>
		<li><font color='#8000FF'><strong>�T�w���ƥX�{���ƥ�G</strong></font>�p�ͤ�A�i�H��ܡu�C�~�Ӥ�v�C�p�G�O�C�Ӥ몺�Y�@�ѡA�����u�C��Ӥ�v�A�άO�T�w�C�g���Y�@�ѡ]�H�P���X�@���D�n�̾ڡ^�A�����u�C�g�Ӥ�v�C</li>
		</ol>
		</td></tr></table>
	</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
	<td nowrap>
	���n�ʡG $import_select
	</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
	<td nowrap>
	�`���ƥ�H
	$restartselect
	</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
	<td nowrap>
	�`���ƥ�_�l��
	<input type='text' name='data[restart_day]' value='$restart_day' size='10'>
	</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
	<td nowrap>
	�`���ƥ󵲧���
	<input type='text' name='data[restart_end]' value='$cal_data[restart_end]' size='10'>
	</td>
	</tr>
	</table>
	<input type='hidden' name='this_date' value='$this_date'>
	<input type='hidden' name='cal_sn' value='$cal_sn'>
	<div align='center'><input type='submit' name='act' value='$submit'></div>
	</form>";
	return $main;
}


//�ֶK�հȦ�ƾ�
function &PasteForm($year="",$month="",$day=""){
	global $import_array,$kind_array,$hour_array,$restart_array,$week_array;
	global $module_manager,$manager_kind_array,$nor_kind_array;
	
	if ($module_manager==0) {
		echo "��p! �z�S���o�G�հȦ�ƾ䪺�v��!";
		exit();
	}
	$submit="�K�W��ƾ�";
	$main="
	<table width='100%' cellspacing='1' cellpadding='3' align='center' bgcolor='#DFE8F2' class='small'>
	<tr bgcolor='#FEFBDA'>
	<td colspan='10'>
	<font class='dateStyle'>$year</font>
	�~
	<font class='dateStyle'>$month</font>
	��
	<font class='dateStyle'>$day</font>�]�P��".$week_array[$w]."�^�G
	<a href='$_SERVER[PHP_SELF]?act=$act&this_day=$today' class='box'><img src='images/today.png' alt='�^��ƾ�' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^��ƾ�</a>
	<a href='$_SERVER[PHP_SELF]?act=addThingForm&this_date=$this_date' class='box'>
	<img src='images/appointment.png' alt='�s�W�ƥ�' width='16' height='16' hspace='2' border='0' align='absmiddle'>�s�W�ƥ�</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingListView&this_date=$this_date' class='box'>
	<img src='images/list.png' alt='���ƥ��`��' width='16' height='16'  hspace='2' border='0' align='absmiddle'>���ƥ��`��</a>
	<a href='$_SERVER[PHP_SELF]?act=getMonthThingView&this_date=$this_date' class='box'>
	<img src='images/1day.png' alt='����ƾ�' width='16' height='16'  hspace='2' border='0' align='absmiddle'>����ƾ�</a>
	</td>
	</tr>
	</table>
	<br>
		<form action='$_SERVER[PHP_SELF]' method='post'>
      <font color=blue>���ֶK�հȦ�ƾ�</font> - �ЧQ�� Excel �̮榡��z�n����K�W<br>
      <textarea cols='80' rows='10' name='data'></textarea><br>
      <input type='submit' name='act' value='$submit'>
		</form>	
		<table border='0'>
		<tr>
			<td>
			�������G�p�ϩҥܡA�ȿ�ܤ��e�����A�ƻs�öK�W�Y�i�C<<a href='./images/demo.xls'>�U���d����</a>><br>
			<img src='./images/demo.png' border='0'><br>
			<font color='red'>���`�N�I�w�s�b�t�Τ����ƥ�A�Фŭ��жK�W�I</font>
			</td>
		</tr>
		</table>
	";
	
	
	
	return $main;
}





//���o�@�Өƥ󪺸��
function get_one_cal($cal_sn){
	global $CONN,$MODULE_TABLE_NAME;
	$sql_select = "select * from $MODULE_TABLE_NAME[0] where cal_sn=$cal_sn";
	$recordSet = $CONN->Execute($sql_select) or user_error("$sql_select",256);
	$c=$recordSet->FetchRow();
	return $c;
}

//���o�@�Өƥ󪺸�Ƥ��}�����ǱЮv
function get_cal_to_who($cal_sn){
	global $CONN,$MODULE_TABLE_NAME;
	$sql_select = "select teacher_sn from $MODULE_TABLE_NAME[0] where from_cal_sn=$cal_sn";
	$recordSet = $CONN->Execute($sql_select) or user_error("$sql_select",256);
	while(list($teacher_sn)=$recordSet->FetchRow()){
		$tsn[]=$teacher_sn;
	}
	return $tsn;
}

//�s�W�@�Өƥ�
function addOneThing($data){
	global $CONN,$MODULE_TABLE_NAME;
	$min=(empty($data[min]))?"00":$data[min];
	$time=$data[h].":".$min;

	$sql_insert = "insert into $MODULE_TABLE_NAME[0] (year,month,day,week,time,place,thing,kind,teacher_sn,from_teacher_sn,from_cal_sn,restart,restart_day,restart_end,import,post_time) values ($data[year],$data[month],$data[day],'$data[week]','$time','$data[place]','$data[thing]','$data[kind]',$_SESSION[session_tea_sn],$_SESSION[session_tea_sn],'0','$data[restart]','$data[restart_day]','$data[restart_end]','$data[import]',now())";
	$CONN->Execute($sql_insert) or user_error("�s�W�ƥ󥢱ѡI<br>$sql_insert",256);
	$from_cal_sn=mysql_insert_id();
	
	if($data[kind]!="0"){
		//�Y�O�����իh���o���ձЮv�s��
		if(in_array("all",$data[to_teacher_sn])){
			$teacher_array=teacher_array();
			$all_tsn=array_keys($teacher_array);
		}else{
			$all_tsn=$data[to_teacher_sn];
		}
		
		if(empty($data[restart])){
			$data[restart_day]="";
			$data[restart_end]="";
		}
		
		//���F�ۤv�H�~�A�����ӵ����H
		foreach($all_tsn as $to_ts){
			if($to_ts==$_SESSION[session_tea_sn])continue;
			$sql_insert = "insert into $MODULE_TABLE_NAME[0] (year,month,day,week,time,place,thing,kind,teacher_sn,from_teacher_sn,from_cal_sn,restart,restart_day,restart_end,import,post_time) values ($data[year],$data[month],$data[day],'$data[week]','$time','$data[place]','$data[thing]','$data[kind]','$to_ts',$_SESSION[session_tea_sn],'$from_cal_sn','$data[restart]','$data[restart_day]','$data[restart_end]','$data[import]',now())";
			$CONN->Execute($sql_insert) or user_error("�s�W�ƥ󥢱ѡI<br>$sql_insert",256);
		}
	}
	
	return true;
}

//�s�W�հȨƥ�
function PasteSchoolThing($DATA) {
	global $CONN,$MODULE_TABLE_NAME;
	
	 $data=explode("\n",$DATA);
	 
   //�}�l�s�J �C����Ʀ�6�� (�~,��,��,��,�a,�ƥ�,���n��)
   foreach ($data as $a) {
    $data_array=explode("\t",$a);
       $year=trim($data_array[0]);
       $month=trim($data_array[1]);
       $day=trim($data_array[2]);
       $time=trim($data_array[3]);
       $place=trim($data_array[4]);
       $thing=trim($data_array[5]);
       $import=trim($data_array[6]);

    if ($year!="" and $month!="" and $day!="" and $time!="" and $place!="" and $thing!="") {
       $week=date ("w", mktime(0,0,0,$month,$day,$year));
			 $sql_insert = "insert into $MODULE_TABLE_NAME[0] (year,month,day,week,time,place,thing,kind,teacher_sn,from_teacher_sn,from_cal_sn,restart,restart_day,restart_end,import,post_time)	values ('$year','$month','$day','$week','$time','$place','$thing','0',".$_SESSION['session_tea_sn'].",".$_SESSION['session_tea_sn'].",'0','0','0000-00-00','0000-00-00',".$import.",now())";
			 $CONN->Execute($sql_insert) or user_error("�s�W�ƥ󥢱ѡI<br>$sql_insert",256);
    
    } //��짹��
	 } // end foreach	
	 
	return true;
}

//��s�@�Өƥ�
function updateOneThing($data,$cal_sn){
	global $CONN,$MODULE_TABLE_NAME;
	$min=(empty($data[min]))?"00":$data[min];
	$time=$data[h].":".$min;
	
	if(empty($data[restart])){
		$data[restart_day]="";
		$data[restart_end]="";
	}
	
	$sql_update="update $MODULE_TABLE_NAME[0] set
	time='$time',
	place='$data[place]',
	thing='$data[thing]',
	kind='$data[kind]',
	restart='$data[restart]',
	restart_day='$data[restart_day]',
	restart_end='$data[restart_end]',
	import='$data[import]',
	post_time=now()
	where cal_sn='$cal_sn'
	";

	$CONN->Execute($sql_update) or user_error("��s�ƥ󥢱ѡI<br>$sql_update",256);
	
	
	//�Y�O�����իh���o���ձЮv�s��
	
	if(in_array("all",$data[to_teacher_sn])){
		$teacher_array=teacher_array();
		$all_tsn=array_keys($teacher_array);
	}else{
		$all_tsn=$data[to_teacher_sn];
	}

		//���F�ۤv�H�~�A�����ӵ����H
	foreach($all_tsn as $to_ts){
		if($to_ts==$_SESSION[session_tea_sn])continue;
		$sql_update = "
		update $MODULE_TABLE_NAME[0] set
		time='$time',
		place='$data[place]',
		thing='$data[thing]',
		kind='$data[kind]',
		restart='$data[restart]',
		restart_day='$data[restart_day]',
		restart_end='$data[restart_end]',
		import='$data[import]',
		post_time=now()
		where from_cal_sn=$cal_sn
		";
	
		$CONN->Execute($sql_update) or user_error("��s�ƥ󥢱ѡI<br>$sql_update",256);
	}
	
	
	
	return true;
}

//�R���ƥ�
function delThing($cal_sn){
	global $CONN,$MODULE_TABLE_NAME;
	$sql_delete = "delete from $MODULE_TABLE_NAME[0] where cal_sn=$cal_sn or from_cal_sn=$cal_sn";
	$CONN->Execute($sql_delete) or user_error("�R���ƥ󥢱ѡI<br>$sql_delete",256);
	return true;
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
