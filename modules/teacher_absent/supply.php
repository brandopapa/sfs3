<?php
//$Id: supply.php 8689 2015-12-25 03:09:57Z qfon $
include "config.php";
head("�N�ҦC��");
$tool_bar=make_menu($school_menu_p);
echo $tool_bar;
$abs_kind_arr=tea_abs_kind();

//��ܾǴ�
$year_seme_menu=year_seme_menu($sel_year,$sel_seme);
//��ܱЮv
$leave_teacher_menu=teacher_menu("teacher_sn",$_POST[teacher_sn]); 
//��ܰ��O
$abs_kind=tea_abs($_POST[abs_kind],$abs_kind_arr); 
//��ܤ��
$month=month_menu($_POST[month],$month_arr); 
//��ܱЮv
$leave_deputy_menu=teacher_menu("deputy_sn",$_POST[deputy_sn]); 
//��ܥN�Ҥ覡
$d_class_dis_menu=d_make_menu("��ܤ覡",$_POST[class_dis] , $c_course_kind,"class_dis",1);

//��ܬO�_�T�w
$d_check4_menu=d_make_menu("�O�_�T�w",$_POST[d_check4] , $check_arr,"d_check4",1); 



if ($_POST[deputy]) {
	list($c_id,$v)=each($_POST[deputy]);
		$query="update teacher_absent_course set status='1',deputy_date='".date("Y-m-d H:i:s")."' where c_id='$c_id'";
	
		$CONN->Execute($query);

} elseif ($_POST[deputy_c]) {
	list($c_id,$v)=each($_POST[deputy_c]);
		$query="update teacher_absent_course set status='0',deputy_date='".date("Y-m-d H:i:s")."' where c_id='$c_id'";

		$CONN->Execute($query);
}


$today=date("Y-m-d",mktime(date("m"),date("d"),date("Y")));
//����
$query1.=" and year='$sel_year' and semester='$sel_seme' ";

if ($_POST[teacher_sn]) {
$_POST[teacher_sn]=intval($_POST[teacher_sn]);			
$query1 .=" and b.teacher_sn='$_POST[teacher_sn]'";
$abs_name=get_teacher_name($_POST[teacher_sn])."�а��@";
}

if ($_POST[class_dis]) {
$_POST[class_dis]=intval($_POST[class_dis]);
$query1 .=" and b.class_dis='$_POST[class_dis]'";
}
//�оǲծֳ�

if ($_POST[d_check4]=='1') {
	$query1 .=" and a.check2_sn>0 ";
}else{
	$query1 .=" and (a.check2_sn=0 or b.start_date >= '$today' )";
	//$query1 .=" and (b.status='0') ";

}

if ($_POST[abs_kind]) {
$_POST[abs_kind]=intval($_POST[abs_kind]);
$query1 .=" and abs_kind='$_POST[abs_kind]'";
}
if ($_POST[month] ) {
$_POST[month]=intval($_POST[month]);
$query1 .=" and month='$_POST[month]'";
}


echo "<table width=100% border=0 cellspacing=1 cellpadding=4 ><form name='menu_form' method='post' action='{$_SERVER['PHP_SELF']}'>
<tr><td> $year_seme_menu �а��H:$leave_teacher_menu $abs_kind $month $d_class_dis_menu  $d_check4_menu</td>
</tr>";



$abs_kind=$abs_kind_arr[$_POST[abs_kind]];
$abs_month= $month_arr[$_POST[month]];
$n_class_dis=$course_kind[$_POST[class_dis]];


echo "<tr bgcolor=#cccccc><td> $sel_year  �Ǧ~�ײ� $sel_seme �Ǵ�  $abs_name  $dep_name �@$abs_kind $abs_month $n_class_dis</td></tr>";

echo "<tr><td><table border='1' cellPadding='3' cellSpacing='0' class='main_body' width=100%>
	<tr bgcolor=#E1ECFF align=center>
	<td  align='center'width=6%> �Ǹ�</td>
	<td  align='center'width=8%> �а��H</td>
	<td  align='center' width=7%>���O</td>
	<td  align='center'width=15%> �ƥ�</td>
	<td  align='center'width=7%> �Ұ�</td>
	<td  align='center'width=15%>�N�Ҥ��</td>
	<td align='center'width=12%>��������θ`��</td>
	<td align='center'width=10%>��دZ��</td>
	<td align='center'width=14%>�N�z�H</td>
	<td align='center'width=4%>�ƶq</td>
	<td align='center'width=4%>���</td></tr>";	

	//Ū�����
	$sql_select = "select * from teacher_absent a , teacher_absent_course b where a.id=b.a_id and b.deputy_sn=$_SESSION[session_tea_sn] and travel='0' ";
	$sql_select.=$query1;
	$sql_select.=" order by b.start_date desc ,b.deputy_sn,b.end_date";
	$result = $CONN->Execute ($sql_select) or die($sql_select) ;
	$i=0;
	while (!$result->EOF) {
		$a_id = $result->fields["id"];
		$teacher_sn = $result->fields["teacher_sn"];		
		$reason=$result->fields["reason"];
		$c_id = $result->fields["c_id"];
		$d_kind = $result->fields["d_kind"];

		$abs_kind_arr=tea_abs_kind();
		$abs_kind=$abs_kind_arr[$result->fields["abs_kind"]];

		$start_date = $result->fields["start_date"];
		$end_date = $result->fields["end_date"];
		$class_name = $result->fields["class_name"];
		$deputy_sn = $result->fields["deputy_sn"];
		$times = $result->fields["times"];
		$status = $result->fields["status"];
		$check2_sn=$result->fields["check2_sn"];
		$class_dis=$result->fields["class_dis"];
		$d_name=get_teacher_name($deputy_sn);
		$t_name=get_teacher_name($teacher_sn);

	
		$nw=d_week($start_date);
		//$cancel_button="<font size=2 color=blue>�w�ֳ�</font>";
		//$check_button="";
		$cancel_button="";
		$check_button="";

		if ($check2_sn==0  ){  //and $class_dis<>0
			$cancel_button="<input type='image' src='images/del.png' name='deputy_c[$c_id]' alt='����'>";
			$check_button="<input type='image' src='images/edit.png' name='deputy[$c_id]' alt=' �T�w'>";
		}

		if ( $deputy_sn==0 ){
			$check_button="";
		}
	
		$check=($status=="0")?
			"<font size=2 color=red>�ݽT�w</font>$check_button
			":"	
			$cancel_button";
		

		$n_class_dis=$course_kind["$class_dis"];
	
		$ti = ($i++%2)+1;
		
		
		
		echo "
		<tr bgcolor=#ddddff align=center OnMouseOver=sbar(this) OnMouseOut=cbar(this)>
		<td align='center'>$a_id</td>
		<td align='center'><font size=3>$t_name</font></td>
		<td align='center'>$abs_kind</td> 
		<td align='center'>$reason</td>
		<td align='center'>$n_class_dis</td>

		<td align='center'><font size=3>$start_date $nw </font></td>
		<td align='center'><font size=3>$end_date</font></td>		
		<td align='center'>$class_name</td>
		<td align='center'><font size=3>$d_name</font> $check</td>
		<td align='center'><font size=3>$times</font></td>
		<td align='center'>$times_kind_arr[$d_kind]</td></tr>
		";

		$result->MoveNext();
	}



echo "</table></td></tr></table>";
foot();
?>
<script language="JavaScript1.2">

<!-- Begin

function sbar(st){st.style.backgroundColor="#F3F3F3";}

function cbar(st){st.style.backgroundColor="";}

//  End -->



</script>

