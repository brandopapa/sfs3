<?php
//$Id: list.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
include "../../include/sfs_class_absent.php";

//�{��
sfs_check();

head("�t���C��");
$tool_bar=make_menu($school_menu_p);
echo $tool_bar;
$abs_kind_arr=tea_abs_kind();

// �P�_�O�_���޲z�v��
$isAdmin = (int)checkid($_SERVER[SCRIPT_FILENAME],1);

//��ܾǴ�
$year_seme_menu=year_seme_menu($sel_year,$sel_seme);
//��ܱЮv
$leave_teacher_menu=teacher_menu("teacher_sn",$_POST[teacher_sn]); 
//��ܰ��O
$abs_kind=tea_abs($_POST[abs_kind],$abs_kind_arr); 
//��ܤ��
$month=month_menu($_POST[month],$month_arr); 


$edit_sn=$_POST['edit_sn'];
if($_POST['act']=='�T�w�ק�') {
	$query="update teacher_absent set reason='$_POST[reason]',abs_kind='$_POST[abs_kind_2]',start_date='$_POST[start_date]',end_date='$_POST[end_date]',day='$_POST[days]',hour='$_POST[hours]',deputy_sn='$_POST[agent_sn]',record_id='$_SESSION[session_log_id]',record_date='".date("Y-m-d H:i:s")."',class_dis='$_POST[course_kind]' where id='$edit_sn'";
	$CONN->Execute($query);
	$edit_sn=0;
}

if($_POST['cancel']) {
	$edit_sn=0;
}

//����
$query1.=" a.year='$sel_year' and a.semester='$sel_seme' ";

if ($_POST[teacher_sn]) {
$query1 .=" and a.teacher_sn='$_POST[teacher_sn]'";
}

if ($_POST[abs_kind]) {
$query1 .=" and a.abs_kind='$_POST[abs_kind]'";
}
if ($_POST[month] ) {
$query1 .=" and a.month='$_POST[month]'";
}


//�p��X�p

$aa="select sum(a.day)from teacher_absent a where a.check4_sn>0 and ".$query1;
$m_day=mysql_result(mysql_query($aa),0);

$aa="select sum(a.hour)from teacher_absent a where a.check4_sn>0 and ".$query1;
$m_hour=mysql_result(mysql_query($aa),0);

$m_day=$m_day+intval($m_hour/8);
$m_hour=($m_hour % 8);
$day_s=($m_day==0)?"":$m_day ."��";
$hour_s=($m_hour==0)?"":$m_hour ."��";

$sum_day= "�X�p�G".$day_s.$hour_s;
$sum_day.=" �@�@<font size=2 color='red'>(��Ҳպ޲z�v���̡A�����ƹ��i�i��s�סI)</font>";


echo "<table width=100% border=0 cellspacing=1 cellpadding=4 ><form name='myform' method='post' action='{$_SERVER['PHP_SELF']}'><input type='hidden' name='edit_sn' value='$edit_sn'>
<tr><td> $year_seme_menu �а��H:$leave_teacher_menu $abs_kind $month $d_check4_menu</td>
</tr>";

$abs_name=get_teacher_name($_POST[teacher_sn]);
$abs_kind=$abs_kind_arr[$_POST[abs_kind]];
$abs_month= $month_arr[$_POST[month]];
if ($isAdmin)
echo "<tr bgcolor=#cccccc><td> $sel_year  �Ǧ~�ײ� $sel_seme �Ǵ�  $abs_name  $abs_kind $abs_month  (����) $sum_day</td></tr>";
else 
echo "<tr bgcolor=#cccccc><td> $sel_year  �Ǧ~�ײ� $sel_seme �Ǵ�  $abs_name  $abs_kind $abs_month (���B��) $sum_day </td></tr>";

echo  	"<tr><tr><table border=0 cellspacing=1 cellpadding=4 width=100% bgcolor=#cccccc class='main_body' >
	<tr bgcolor=#E1ECFF align=center>
	<td width=4%>�Ǹ�</td><td width=8%>�а��H</td><td width=8%>¾��</td><td width=6%>���O</td>	<td width=12%>�ƥ�</td><td  width=60 align=center>�}�l�ɶ��@�����ɶ�</td><td width=6% >���</td>
	<td width=6%>�Ұ�</td><td width=7%>¾�ȥN�z�H</td><td width=7%>$check1</td><td width=7%>$check2</td><td width=7%>$check3</td><td width=7%>$check4</td></tr>";

	//Ū�����

//Ū�����
if ($isAdmin) {
	$sql_select="select * from teacher_absent a where  a.check4_sn>0 and " .$query1 ;
	$sql_select .=" order by a.start_date  desc ";
}
else {
	$query = "SELECT * FROM teacher_post WHERE teacher_sn={$_SESSION['session_tea_sn']}";
	$res=$CONN->Execute($query);
	$user_post_office = $res->fields['post_office'];

	$sql_select = "select a.* from teacher_absent a , teacher_post c where
	a.teacher_sn=c.teacher_sn and c.post_office=$user_post_office and	 a.check4_sn>0 and  $query1";
}



	$result = $CONN->Execute ($sql_select) or die($sql_select) ;
	$i=0;
	while (!$result->EOF) {

		$id=$result->fields["id"];
		$view_tsn=$result->fields["teacher_sn"];
		$sel_year=$result->fields["year"];
		$sel_seme=$result->fields["semester"];
		$teacher_sn=$result->fields["teacher_sn"];
		$class_dis=$result->fields["class_dis"];
		$post_k=$result->fields["post_k"];

		$t_name=get_teacher_name($result->fields["teacher_sn"]);
		$reason=$result->fields["reason"];
		$abs_kind_arr=tea_abs_kind();
		$abs_kind=$abs_kind_arr[$result->fields["abs_kind"]];
		$n_class_dis=$course_kind[$result->fields["class_dis"]];
		$start_date=substr($result->fields["start_date"],0,16);
		$c_start_date=substr($start_date,0,10);

		$end_date=substr($result->fields["end_date"],0,16);
		$c_end_date=substr($end_date,0,10);
	
		$day_hour=($result->fields["day"]==0)?"":$result->fields["day"] ."��";
		$day_hour.=($result->fields["hour"]==0)?"":$result->fields["hour"] ."��";

		$check2_sn=$result->fields["check2_sn"];
		$de_name=get_teacher_name($result->fields["deputy_sn"]);
		$c1_name=get_teacher_name($result->fields["check1_sn"]);
		$c2_name=get_teacher_name($result->fields["check2_sn"]);
		$c3_name=get_teacher_name($result->fields["check3_sn"]);
		$c4_name=get_teacher_name($result->fields["check4_sn"]);
		if($id==$edit_sn) {
			$kind_select="<select name='abs_kind_2'>";
			foreach($abs_kind_arr as $key=>$value){
				$selected=($key==$result->fields["abs_kind"])?'selected':'';
				$bgcolor=($key==$result->fields["abs_kind"])?"style='background-color: #ccffcc;'":'';
				$kind_select.="<option value='$key' $selected $bgcolor>$value</option>";			
			}
			$kind_select.="</select>";
			
			
			$course_select="<select name='course_kind'>";
			foreach($course_kind as $key=>$value){
				$selected=($key==$result->fields["class_dis"])?'selected':'';
				$bgcolor=($key==$result->fields["class_dis"])?"style='background-color: #ccffcc;'":'';
				$course_select.="<option value='$key' $selected $bgcolor>$value</option>";			
			}
			$course_select.="</select>";	

			$agent_select=teacher_menu("agent_sn",$result->fields["deputy_sn"],'',False); 
			
			
			$main= "<tr bgcolor='#ffcccc' align=center>
			<td>$id</td>
			<td><font size=3>$t_name</font></td>
			<td>$post_kind[$post_k]</font></td>
			<td>$kind_select</font></td>	
			<td><input type='text' name='reason' value='$reason'></td>
			<td width=100 align=center><font size=3><input type='text' name='start_date' size=16 value='$start_date'><br><input type='text' name='end_date' size=16 value='$end_date'></font></td>
			<td><font size=3><input type='text' size=3 name='days' value='{$result->fields["day"]}'>��<input type='text' name='hours' size=2 value='{$result->fields["hour"]}'>��</font></td>
			<td>$course_select</td>
			<td><font size=3>$agent_select</font></td>
			<td colspan=4><input type='submit' name='act' value='�T�w�ק�' onclick='document.myform.edit_sn.value=\"$id\"; return confirm(\"�T�w�n�ק� #$id $t_name ��[$abs_kind]�а�����?\")'><input type='reset' value='�^�_���'><input type='submit' name='cancel' value='����'</td>
			</tr>";
		} else {
			if(checkid($_SERVER['SCRIPT_FILENAME'],1)) $dblclick="ondblclick='document.myform.edit_sn.value=\"$id\"; document.myform.submit();'";
			$main= "<tr bgcolor=#ddddff align=center OnMouseOver=sbar(this) OnMouseOut=cbar(this) $dblclick>
			<td>$id</td>
			<td><font size=3>$t_name</font></td>
			<td>$post_kind[$post_k]</font></td>
			
			<td>$abs_kind</font></td>	
			<td>$reason</td>
			<td width=120 align=center><font size=3>$start_date  $end_date</font></td>
			<td><font size=3>$day_hour</font></td>
			<td>$n_class_dis</td>	
			<td><font size=3>$de_name</font></td>
			<td>$c1_name</td>
			<td>$c2_name</td>
			<td>$c3_name</td>
			<td>$c4_name</td></tr>";
		}
		echo $main;
		$result->MoveNext();
}

echo "</table></td></tr></form></table>";
foot();
?>
<script language="JavaScript1.2">

<!-- Begin

function sbar(st){st.style.backgroundColor="#F3F3F3";}

function cbar(st){st.style.backgroundColor="";}

//  End -->



</script>