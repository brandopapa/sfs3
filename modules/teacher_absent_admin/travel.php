<?php
//$Id: supply.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
head("�t�ȶO�C��");
$tool_bar=make_menu($school_menu_p);
echo $tool_bar;
$abs_kind_arr=tea_abs_kind();

// �P�_�O�_���޲z�v��
$isAdmin = (int)checkid($_SERVER[SCRIPT_FILENAME],1);


//��ܾǴ�
$year_seme_menu=year_seme_menu($sel_year,$sel_seme);
//��ܱЮv
$leave_teacher_menu=teacher_menu("teacher_sn",$_POST[teacher_sn]); 
//��ܤ��
$month=month_menu($_POST[month],$month_arr); 

//��ܬO�_�T�w
$d_check4_menu=d_make_menu("�O�_�T�w",$_POST[d_check4] , $check_arr,"d_check4",1); 


//����
$query1.=" and year='$sel_year' and semester='$sel_seme' ";

if ($_POST[teacher_sn]) {
$query1 .=" and b.teacher_sn='$_POST[teacher_sn]'";
$abs_name=get_teacher_name($_POST[teacher_sn])."�а��@";
}

if ($_POST[d_check4]=='1') {
	$query1 .=" and b.deputy_sn>'0' ";
}else{
	$query1 .=" and b.deputy_sn='0'";
}

if ($_POST[month] ) {
$query1 .=" and month='$_POST[month]'";
}


echo "<table width=100% border=0 cellspacing=1 cellpadding=4 ><form name='menu_form' method='post' action='{$_SERVER['PHP_SELF']}'>
<tr><td> $year_seme_menu �X�t�H:$leave_teacher_menu  $month  $d_check4_menu</td>
</tr>";




$abs_month= $month_arr[$_POST[month]];


if($isAdmin)
echo "<tr bgcolor=#cccccc><td> $sel_year  �Ǧ~�ײ� $sel_seme �Ǵ�  $abs_name  $abs_month (����) </td></tr>";
else 
echo "<tr bgcolor=#cccccc><td> $sel_year  �Ǧ~�ײ� $sel_seme �Ǵ�  $abs_name  $abs_month (���B��)</td></tr>";

echo "<tr><td><table border='1' cellPadding='3' cellSpacing='0' class='main_body' width=100%>
	<tr bgcolor=#E1ECFF align=center>
	<td  align='center'width=5% rowspan='2'> �Ǹ�</td>
	<td  align='center'width=7% rowspan='2'> �X�t�H</td>
	<td  align='center'width=6% rowspan='2'> ¾��</td>
	<td align='center' width='10%' rowspan='2' > $add_button ���  $view_button</td> 
	<td align='center' width='10%' rowspan='2'>�_���a�I</td>
	<td align='center' width='10%' rowspan='2'>�u�@�O�n</td>
	<td align='center' width='20%' colspan='4'>��q�O</td>
	<td align='center' width='5%' rowspan='2'>��J�O</td>
	<td align='center' width='5%' rowspan='2'>�Ȧ�~�N����I</td>
	<td align='center' width='5%' rowspan='2'>��ڸ���</td>
	<td align='center' width='5%' rowspan='2'>�����O</td>
	<td align='center' width='5%' rowspan='2'>�X�p</td>	
	<td align='center' width='7%' rowspan='2'>$check5</td>
	</tr>	
	<tr class='title_mbody'>
	<td align='center' width='5%'>����</td>
	<td align='center' width='5%'>�����α��B</td>
	<td align='center' width='5%'>����</td>
	<td align='center' width='5%'>���K</td>
	</tr>";	


	//Ū�����
	if ($isAdmin) {
		$sql_select = "select * from teacher_absent a , teacher_absent_course b where a.id=b.a_id and travel='1' ";
		$sql_select.=$query1;
		$sql_select.=" order by b.start_date desc ,b.deputy_sn,b.end_date";
		
    }
	else {
		$query = "SELECT * FROM teacher_post WHERE teacher_sn={$_SESSION['session_tea_sn']}";
		$res=$CONN->Execute($query);
		$user_post_office = $res->fields['post_office'];
	
		$sql_select = "select a.* from teacher_absent a , teacher_absent_course b , teacher_post c where
		a.teacher_sn=c.teacher_sn and c.post_office=$user_post_office and
		a.id=b.a_id and travel='1'   $query1";
	}
	
	
	$result = $CONN->Execute ($sql_select) or die($sql_select) ;
	$i=0;
	while (!$result->EOF) {
		$a_id = $result->fields["id"];
		$teacher_sn = $result->fields["teacher_sn"];		
		$reason=$result->fields["reason"];		
		$deputy_sn = $result->fields["deputy_sn"];	
		$d_name=get_teacher_name($deputy_sn);
		$t_name=get_teacher_name($teacher_sn);	
		$c_id = $result->fields["c_id"];
		$start_date = $result->fields["start_date"];
		$end_date = $result->fields["end_date"];
		$class_name = $result->fields["class_name"];
		$post_k = $result->fields["post_k"];
		$outlay1 = $result->fields["outlay1"];
		$outlay2 = $result->fields["outlay2"];
		$outlay3 = $result->fields["outlay3"];
		$outlay4 = $result->fields["outlay4"];
		$outlay5 = $result->fields["outlay5"];
		$outlay6 = $result->fields["outlay6"];
		$outlay7 = $result->fields["outlay7"];
		$outlay8 = $result->fields["outlay8"];
		$outlay_a = $result->fields["outlay_a"];
		$outl_id = $result->fields["outl_id"];

		$coutlay1 = ztos($outlay1);
		$coutlay2 = ztos($outlay2);
		$coutlay3 = ztos($outlay3);
		$coutlay4 = ztos($outlay4);
		$coutlay5 = ztos($outlay5);
		$coutlay6 = ztos($outlay6);
		$coutlay8 = ztos($outlay8);

		$c_a_id="<a href=outlay.php?id=$a_id title=�t�ȶO�B�z> $a_id </a>";
		$ti = ($i++%2)+1;
		$check=($deputy_sn=="0") ?
		"<font size=2 color=red>�ݽT�{</font>":"";

		
		echo "
		<tr bgcolor=#ddddff align=center OnMouseOver=sbar(this) OnMouseOut=cbar(this)>
		<td align='center'>$c_a_id</td>
		<td align='center'><font size=3>$t_name</font></td>
		<td align='center'><font size=2>$post_kind[$post_k]</font></td>
		<td align='center'><font size=3>	$start_date 	</font></td>
		<td align='center'><font size=2>$end_date</font><br></td>		
		<td align='center'><font size=2>$class_name<br></font></td>		
		<td align='center'><font size=3>$coutlay1<br></font></td>
		<td align='center'><font size=3>$coutlay2<br></font></td>
		<td align='center'><font size=3>$coutlay3<br></font></td>
		<td align='center'><font size=3>$coutlay4<br></font></td>
		<td align='center'><font size=3>$coutlay5<br></font></td>
		<td align='center'><font size=3>$coutlay6<br></font></td>
		<td align='center'><font size=3>$outl_id<br></font></td>
		<td align='center'><font size=3>$coutlay8<br></font></td>	
		<td align='center'><font size=3>$outlay_a</font></td>
		<td align='center'><font size=2>$d_name $check</td></tr>

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

