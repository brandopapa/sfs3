<?php

// $Id: link_parent.php 5310 2009-01-10 07:57:56Z hami $

/*�ޤJ�ǰȨt�γ]�w��*/
include_once "config.php";

//�ϥΪ̻{��
sfs_check();

$month=($_GET[month])?$_GET[month]:$_POST[month];
$year=($_GET[year])?$_GET[year]:$_POST[year];
$day=($_GET[day])?$_GET[day]:$_POST[day];

$act=($_GET[act])?$_GET[act]:$_POST[act];
$link_sn=($_GET[link_sn])?$_GET[link_sn]:$_POST[link_sn];
$content=($_GET[content])?$_GET[content]:$_POST[content];
$use1=($_GET[use1])?$_GET[use1]:$_POST[use1];
$date=($_GET['date'])?$_GET['date']:$_POST['date'];
$re_link=($_GET[re_link])?$_GET[re_link]:$_POST[re_link];

foreach($_POST['member'] as $K=> $V) $member[$K]=$V;
	

if(!empty($_GET[this_date]) or !empty($_POST[this_date])){
	$this_date=($_GET[this_date])?$_GET[this_date]:$_POST[this_date];
	$d=explode("-",$this_date);
	$year=$d[0];
	$month=$d[1];
	$day=$d[2];
}


if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id
//��X���ЯZ��
$class_name=teacher_sn_to_class_name($teacher_sn);
//��X�ǥͰ}�C
$student_sn_A=class_id_to_student_sn($class_name[3]);
//echo $student_sn_A[1];


if(empty($year))$year=date("Y");
if(empty($month))$month=date("m");
if(empty($day))$day=date("d");
$week=date ("w", mktime(0,0,0,$month,$day,$year));
$right=&getMonthView($year,$month,$day);
$this_date=$year."-".$month."-".$day;

if($act=="del"){
	search_and_sn($link_sn);
	header("Location:{$_SERVER['PHP_SELF']}?this_date=$this_date");

}
elseif($act=="edit"){
	//�q�X����
	head("�Z�Ũư�");

	echo print_menu($menu_p);
	
	$sql_select="select * from parent_link where link_sn='$link_sn'";
	$rs_select=$CONN->Execute($sql_select);
	$content=$rs_select->fields['content'];
	$parent_link=$rs_select->fields['parent_link'];	
	$content=br2nl($content);
	$parent_link_A=explode(",",$parent_link);
	
	$parent_A=&get_parent($student_sn_A);
	//echo "�m�W".$parent_A[0][name];
	$j=0;
	foreach($parent_A as $VAL){		
		$checked=(in_array($VAL[sn],$parent_link_A))?"checked":"";
		$member.="<input type='checkbox' $checked name='member[$j]' value='$VAL[sn]'>$VAL[name] ";
		if($j%8==7) $member.="<br>";
		$j++;		
	}
		
	$main="
		<form action='{$_SERVER['PHP_SELF']}?act=save_edit' method='POST' name='form_edit'>      
		<table width='100%' cellspacing='1' cellpadding='3' align='center' bgcolor='#000000' class='small' valign='top'>
		<tr bgcolor='#FEFBDA'>
		<td>
		<table bgcolor='#D844EB' cellspacing='1' cellpadding='3' align='center'  width='100%' valign='top'>
		<tr bgcolor='#FFCAF8'>
		<td><textarea name='content' cols='60' rows='10' >$content</textarea></td>
		<td valign='top'><input type='submit' name='submit_edit' value='�e�X'></td>
		<tr bgcolor='#FFCAF8'><td colspan='2'>��H�G<br>$member</td></tr>
		<input type='hidden' name='link_sn' value='$link_sn'>
		<input type='hidden' name='this_date' value='$this_date'>
		</table>
		</td>
		</tr>
		</table>			
		</form>			
	";
}

elseif($act=="save_edit"){
	$time=date("Y-m-d H:i:s");
	$parent_link=implode(",",$member);
	$content=nl2br($content);
	$sql_edit="update parent_link set time='$time',parent_link='$parent_link',content='$content' where link_sn='$link_sn'";
	$CONN->Execute($sql_edit);
	header("Location:{$_SERVER['PHP_SELF']}?this_date=$this_date");
}


elseif($act=="new"){
	//�q�X����
	head("�Z�Ũư�");

	echo print_menu($menu_p);	
	//echo $student_sn_A[1];
	$parent_A=&get_parent($student_sn_A);
	//echo "�m�W".$parent_A[0][name];
	$j=0;
	
	foreach($parent_A as $VAL){		
		$member.="<input type='checkbox' checked name='member[$j]' value='$VAL[sn]'>$VAL[name] ";
		if($j%8==7) $member.="<br>";
		$j++;		
	}
	$main="
		<form action='{$_SERVER['PHP_SELF']}?act=save_new' method='POST' name='form_new'>      
		<table width='100%' cellspacing='1' cellpadding='3' align='center' bgcolor='#000000' class='small' valign='top'>
		<tr bgcolor='#FEFBDA'>
		<td>
		<table bgcolor='#D844EB' cellspacing='1' cellpadding='3' align='center'  width='100%' valign='top'>
		<tr bgcolor='#FFCAF8'>
		<td><textarea name='content' cols='60' rows='10' ></textarea></td>
		<td valign='top'><input type='submit' name='submit_new' value='�e�X'></td>
		<tr bgcolor='#FFCAF8'><td colspan='2'>��H�G<br>$member</td></tr>
		<input type='hidden' name='this_date' value='$this_date'>
		</table>
		</td>
		</tr>
		</table>
		</form>				
	";


}
elseif($act=="save_new"){	
	$date=date($this_date);
	//echo $date;
	$time=date("Y-m-d H:i:s");
	$class_id=$class_name[3];
	$teacher_link=$teacher_sn;
	$parent_link=implode(",",$member);
	$content=nl2br($content);
	$author_sn="t".$teacher_sn;
	//echo $date.$time;
	$sql_new="insert into parent_link(author_sn,date,time,class_id,teacher_link,parent_link,content) values('$author_sn','$date','$time','$class_id','$teacher_link','$parent_link','$content')";	
	//echo $sql_new;
	$CONN->Execute($sql_new);
	header("Location:{$_SERVER['PHP_SELF']}?this_date=$this_date");
}
elseif($act=="respon"){
	//�q�X����
	head("�Z�Ũư�");

	echo print_menu($menu_p);
	
	$sql_select="select * from parent_link where link_sn='$link_sn'";
	$rs_select=$CONN->Execute($sql_select);
	$content=$rs_select->fields['content'];
	$parent_link=$rs_select->fields['parent_link'];	
	$date=$rs_select->fields['date'];
	$content=br2nl($content);
	$parent_link_A=explode(",",$parent_link);
	$use_content=($use1==1)?"<div style='margin-left: 20px;'>$content</div><hr style='width: 98%; height: 1px;'  noshade='noshade'>":"";
	
	$parent_A=&get_parent($student_sn_A);
	//echo "�m�W".$parent_A[0][name];
	$j=0;
	foreach($parent_A as $VAL){
		$checked=(in_array($VAL[sn],$parent_link_A))?"checked":"";
		$member.="<input type='checkbox' $checked name='member[$j]' value='$VAL[sn]'>$VAL[name] ";
		if($j%8==7) $member.="<br>";
		$j++;		
	}
	$main="
		<form action='{$_SERVER['PHP_SELF']}?act=save_respon' method='POST' name='form_respone'>      
		<table width='100%' cellspacing='1' cellpadding='3' align='center' bgcolor='#000000' class='small' valign='top'>
		<tr bgcolor='#FEFBDA'>
		<td>
		<table bgcolor='#D844EB' cellspacing='1' cellpadding='3' align='center'  width='100%' valign='top'>
		<tr bgcolor='#FFCAF8'>
		<td><textarea name='content' cols='60' rows='10' >$use_content</textarea></td>
		<td valign='top'><span class='button'><a href='{$_SERVER['PHP_SELF']}?act=respon&use1=1&link_sn=$link_sn'>�ޤ�</a></span><input type='submit' name='submit_respone' value='�e�X'  ></td>						
		<tr bgcolor='#FFCAF8'><td colspan='2'>��H�G<br>$member</td></tr>
		<input type='hidden' name='date' value='$date'>
		<input type='hidden' name='re_link' value='$link_sn'>
		</table>
		</td>
		</tr>
		</table>
		</form>				
	";

}
elseif($act=="save_respon"){		
	$time=date("Y-m-d H:i:s");
	$class_id=$class_name[3];
	$teacher_link=$teacher_sn;
	$parent_link=implode(",",$member);
	$content=nl2br($content);
	$author_sn="t".$teacher_sn;
	//echo $date.$time;
	$sql_respon="insert into parent_link(author_sn,date,time,class_id,teacher_link,parent_link,content,re_link) values('$author_sn','$date','$time','$class_id','$teacher_link','$parent_link','$content','$re_link')";		
	$CONN->Execute($sql_respon) or die($sql_respon);
	header("Location:{$_SERVER['PHP_SELF']}?this_date=$date");
}


else{
	//�q�X����
	head("�Z�Ũư�");

	echo print_menu($menu_p);
	
	$sql_link="select * from parent_link where date='$this_date' and teacher_link='$teacher_sn' order by link_sn DESC";
	$rs_link=$CONN->Execute($sql_link);
	while(!$rs_link->EOF){
		$link_sn[$i]=$rs_link->fields['link_sn'];
		$author_sn[$i]=$rs_link->fields['author_sn'];
		$date[$i]=$rs_link->fields['date'];
		$time[$i]=$rs_link->fields['time'];
		$class_id[$i]=$rs_link->fields['class_id'];
		$teacher_link[$i]=$rs_link->fields['teacher_link'];
		$parent_link[$i]=$rs_link->fields['parent_link'];
		$content[$i]=$rs_link->fields['content'];
		$content[$i]="<small style='font-style: italic; background-color: rgb(255, 255, 153);'>�p$link_sn[$i]</small><br>".$content[$i];
		$re_link[$i]=$rs_link->fields['re_link'];	
		
		//�a���y�����ন�m�W���Φ�
		$parent_link_A[$i]=explode(",",$parent_link[$i]);
		echo "-----".$link_sn[$i];
		$parent_link_name[$i].="<select name='parent_name'>";
		for($j=0;$j<count($parent_link_A[$i]);$j++) {
			$parent_link_A_name[$i][$j]=&get_parent_name($parent_link_A[$i][$j]);
			//echo $parent_link_A[$i][$j].$parent_link_A_name[$i][$j]."<br>";			
			$parent_link_name[$i].="<option>{$parent_link_A_name[$i][$j]}</option>";			
		}	
		$parent_link_name[$i].="</select>";
		//�@���ഫ����m�W
		$author_name[$i]=&get_author_name($author_sn[$i]);
		if($author_sn[$i]=="t".$teacher_sn){		
			$data.="<br>
				<table bgcolor='#D844EB' cellspacing='1' cellpadding='3' align='center'  width='100%' valign='top'>
					<tr bgcolor='#FFFFFF'><td colspan='6'>$content[$i]</td></tr>
					<tr bgcolor='#FFCAF8'><td>�i�K�̡G$author_name[$i]</td><td>�ɶ��G$time[$i]</td><td>��H�G$parent_link_name[$i]</td><td><span class='button'><a href='$_SERVER[PHP_SELF]?link_sn=$link_sn[$i]&act=del&this_date=$this_date'>�R��</a></span></td>
						<td><span class='button'><a href='$_SERVER[PHP_SELF]?link_sn=$link_sn[$i]&act=edit&this_date=$this_date'>�s��</a></span></td><td><span class='button'><a href='$_SERVER[PHP_SELF]?link_sn=$link_sn[$i]&act=respon&this_date=$this_date'>�^��</a></span></td>	
					</tr>
				</table>";
		}
		else{
			$data.="<br>
				<table bgcolor='#4A56A3' cellspacing='1' cellpadding='3' align='center'  width='100%' valign='top'>
					<tr bgcolor='#FFFFFF'><td colspan='5'>$content[$i]</td></tr>
					<tr bgcolor='#A3C7FD'><td>�i�K�̡G$author_name[$i]</td><td>�ɶ��G$time[$i]</td><td><span class='button'><a href='$_SERVER[PHP_SELF]?link_sn=$link_sn[$i]&act=del&this_date=$this_date'>�R��</a></span></td>
						<td><span class='button'><a href='$_SERVER[PHP_SELF]?link_sn=$link_sn[$i]&act=edit&this_date=$this_date'>�s��</a></span></td><td><span class='button'><a href='$_SERVER[PHP_SELF]?link_sn=$link_sn[$i]&act=respon&this_date=$this_date'>�^��</a></span></td>	
					</tr>
				</table>";								
		}		
		$i++;
		$rs_link->MoveNext();	
	}

	$main="
		<table width='100%' cellspacing='1' cellpadding='3' align='center' bgcolor='#000000' class='small' valign='top'>
		<tr bgcolor='#FEFBDA'>
		<td>
		<font class='dateStyle'>$year</font>
		�~
		<font class='dateStyle'>$month</font>
		��
		<font class='dateStyle'>$day</font>�]�P��".$week_array[$week]."�^<font class='dateStyle'>".$class_name[1]."</font> �a�x�p��ï
		<a href='$_SERVER[PHP_SELF]?act=&this_date=$today' class='box'><img src='images/today.png' alt='�^�줵��' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^�줵��</a>
		<span class='button'><a href='$_SERVER[PHP_SELF]?act=new&this_date=$this_date' class='box'>�s�W</a></span><br>
		$data
		</td>
		</tr>
		</table>
	";
}
//��ܦb�����W���e��
echo "<table width='100%'><tr><td width='70%' valign='top'>".$main."</td><td align='right' valign='top'>".$right."</td></tr></table>";


//�����D������ܰ�
echo "</td>";
echo "</tr>";
echo "</table>";
//�{���ɧ�
foot();

//���o���ƾ�
function &getMonthView($year="",$month="",$day="",$mode=""){
	global $today;
	$cal = new MyCalendar;
	$cal->setStartDay(1);
	$mc=($mode=="viewThing")?$cal->getMonthThingView($month,$year,$day):$cal->getMonthView($month,$year,$day);
	$main="
	<table cellspacing='1' cellpadding='2' bgcolor='#000000' class='small'>
	<tr bgcolor='#FEFBDA'><td align='center'>
	<a href='$_SERVER[PHP_SELF]?act=$act&this_date=$today' class='box'><img src='images/today.png' alt='�^�줵��' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^�줵��</a>
	</td></tr>
	<tr bgcolor='#FFFFFF'><td>$mc</td></tr>
	</table>
	";
	return $main;
}

//�Ѥp�Ī��y������a���y�����M�m�W
function &get_parent($student_sn_A){
	global $CONN;
	for($i=0;$i<count($student_sn_A);$i++){
		//echo $i;
		//�p��sn��id
		$sql="select stud_id,stud_name from stud_base where student_sn='$student_sn_A[$i]'";
		$rs=$CONN->Execute($sql);
		$stud_id[$i]=$rs->fields['stud_id'];
		$stud_name[$i]=$rs->fields['stud_name'];
		//echo $stud_id[$i];
		//�����@�H��id		
		$sql="select guardian_p_id,guardian_name from stud_domicile where stud_id='$stud_id[$i]'";
		$rs=$CONN->Execute($sql);
		$parent_id[$i]=$rs->fields['guardian_p_id'];
		$parent_name[$i]=$rs->fields['guardian_name'];
		//echo $parent_name[$i];
		//echo $sql;
		if($parent_name[$i]!=""){
			//��X�a���y����
			$sql="select parent_sn from parent_auth where parent_id='$parent_id[$i]'";
			$rs=$CONN->Execute($sql);
			$parent_sn[$i]=$rs->fields['parent_sn'];		
			if($parent_sn[$i]!=""){
				$parent_A[$i][sn]=$parent_sn[$i];//�a���y����
				$parent_A[$i][name]=$parent_name[$i];//�a���m�W
				$parent_A[$i][child]=$stud_name[$i];//�Q�l��
			}
			else continue;
		}
		else continue;
	}
	if(count($parent_A)==0) $parent_A=array();
	return $parent_A;
}

//�Ѯa�����y������X�L���m�W
function &get_guardian_name($parent_sn){
	global $CONN;
	//��X�a������������
	$sql="select parent_id from parent_auth where parent_sn='$parent_sn'";
	$rs=$CONN->Execute($sql);
	$parent_id=$rs->fields['parent_id'];
	//��X�a���W��
	$sql_name="select guardian_name from stud_domicile where  guardian_p_id='$parent_id'";
	$rs_name=$CONN->Execute($sql_name);
	$guardian_name=$rs_name->fields['guardian_name'];	
	return $guardian_name;
}


//�ഫ<br>������r��\n
function br2nl($message=""){
	$message=str_replace ("<br>","",$message);
	$message=str_replace ("<br/>","",$message);
	$message=str_replace ("<br />","",$message);
	$message=str_replace ("<BR>","",$message);
	$message=str_replace ("<BR/>","",$message);
	$message=str_replace ("<BR />","",$message);
	return $message;
}

//�ѧ@�̪��y������X�L���m�W
function &get_author_name($author_sn){
	global $CONN;
	$A=substr($author_sn,0,1);
	$sn=substr($author_sn,1);
	//$A=t�Ѯv�A$A=p�a��
	if($A=="t"){//�Ѯv
		$sql="select name from teacher_base where teacher_sn='$sn'";		
		$rs=$CONN->Execute($sql);
		$name=$rs->fields['name'];		
	}
	elseif($A=="p"){//�a��
		//��X�a������������
		$sql="select parent_id from parent_auth where parent_sn='$sn'";
		$rs=$CONN->Execute($sql);
		$parent_id=$rs->fields['parent_id'];
		//��X�a���W��
		$sql_name="select guardian_name from stud_domicile where  guardian_p_id='$parent_id'";
		$rs_name=$CONN->Execute($sql_name);
		$name=$rs_name->fields['guardian_name'];			
	}			
	return $name;
}

//�R����link_sn�M�U�h������link_sn
function search_and_sn($link_sn){
	global $CONN;
	
	$sql_del="delete from parent_link where link_sn='$link_sn'";
	$CONN->Execute($sql_del);
	
	$sql_select="select link_sn from parent_link where re_link='$link_sn'";
	$rs_select=$CONN->Execute($sql_select);	
	$link_sn=$rs_select->fields['link_sn'];
	if($link_sn!=""){
		search_and_sn($link_sn);
	}
}	

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
