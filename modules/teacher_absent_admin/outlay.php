<?php
//$Id: supply.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
include_once "../../include/config.php";
include_once "../../include/sfs_case_score.php";
require_once "../../include/sfs_core_globals.php";
include_once "../../include/sfs_case_studclass.php";
include_once "../../include/sfs_case_subjectscore.php";

//�{��
sfs_check();

//�Y�S����ܰ���A�h�^��C��
if(empty($id)){
	header("Location: deputy.php?act='err'");
}

head("�t�ȶO�B�z");
$tool_bar=make_menu($school_menu_p);
echo $tool_bar;
	
//�q�X����
//������
$main=teacher_absent($id);
echo $main;

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
//�R���N��
if ($_POST[del]) {
	foreach ($_POST['del'] as $c_id=>$v)
	$query = "delete from teacher_absent_course where c_id ='$c_id'";
	$CONN->Execute($query);
	$main=&room_setup_form();

}
$outlay_a=$outlay1+$outlay2+$outlay3+$outlay4+$outlay5+$outlay6+$outlay7+$outlay8;


if ($act == "�ק�T�w") {	
	$sql_update = "update teacher_absent_course set 
	start_date='$start_date',end_date='$end_date' ,outlay1='$outlay1',outlay2='$outlay2',outlay3='$outlay3',outlay4='$outlay4' ,
	outlay5='$outlay5' ,outlay6='$outlay6',outlay7='$outlay7',outlay8='$outlay8',outlay_a='$outlay_a' ,outl_id='$outl_id',class_name='$class_name' where c_id=$c_id";
	$CONN->Execute($sql_update);
	$main=&room_setup_form();
}elseif ($act=="�s�W�T�w") {
	$sql_insert = "insert into teacher_absent_course (travel,a_id,teacher_sn,start_date,end_date,outlay1,outlay2,outlay3,outlay4,outlay5,outlay6,outlay7,outlay8,outlay_a,outl_id,class_name) values 
								('1','$id','$teacher_sn','$start_date','$end_date','$outlay1','$outlay2','$outlay3','$outlay4','$outlay5','$outlay6','$outlay7','$outlay8','$outlay_a','$outl_id','$class_name')";
	$CONN->Execute($sql_insert);
 	$main=&room_setup_form();




}elseif ($_POST[deputy]) {
	foreach ($_POST['deputy'] as $c_id=>$v)
		$query="update teacher_absent_course set deputy_sn='$_SESSION[session_tea_sn]',deputy_date='".date("Y-m-d H:i:s")."' where c_id='$c_id'";
		$CONN->Execute($query);
	$main=&room_setup_form();

} elseif ($_POST[deputy_c]) {
	foreach ($_POST['deputy_c'] as $c_id=>$v)
		$query="update teacher_absent_course set deputy_sn='0',deputy_date='".date("Y-m-d H:i:s")."' where c_id='$c_id'";
		$CONN->Execute($query);
	$main=&room_setup_form();



}elseif ($_POST[edit]) {	//�ק�N��
	foreach ($_POST['edit'] as $c_id=>$v)
	$main=&room_setup_form("edit",$c_id);
}elseif ($act=="�s�W") {
	$main=&room_setup_form("add",$c_id,$c_d_kind);

}else{
	$main=&room_setup_form();
}

echo $main;

/*
�禡��
*/

//�N�Ҹ��
function &room_setup_form($mode="",$cc_id,$c_d_kind){
	global $CONN,$id,$d_kind_arr,$times_kind_arr,$teacher_sn,$course_kind,$check4_sn,$c_start_date,$c_locale,$class_dis,$deputy_class,$week_array,$check5;
	
	//if ($check4_sn==0){  //�H�Ƶn�O�e�i�s�W
		$add_button="<input type=submit name='act' value='�s�W'>";
		$view_button="<input type=submit name='act' value='�s��'>";
	//}

	$modify_submit_button="<input type='submit' name='act' value='�ק�T�w'>";
	

	if ($mode=="edit"){
		$b0="$view_button $add_button $modify_submit_button";
		$b1="$modify_submit_button";
	}elseif($mode=="add"){
			//$hidden="<input type='hidden' name='act' value= '�s�W'>";

	
		$add_form="<tr >
		<td><input type='text' style='font-size: 12pt' size='10' maxlength='10' name='start_date' value='$c_start_date'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='10' maxlength='10' name='end_date' value='$c_locale'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='10' maxlength='10' name='class_name' value='$class_name'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay1'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay2'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay3'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay4'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay5'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay6'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outl_id'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay8'></td>
		<td align='center' ><input type='submit' name='act' value='�s�W�T�w'></td>		
		</tr>
		$hidden
		";
	}
	
	$button0="<tr  class='title_sbody2'><td colspan='5'>$b0</td></tr>";
	$button1=(!empty($b1))?"<tr  class='title_sbody2'><td colspan='5'>$b1</td></tr>":$button0;

	//Ū�����
	$sql_select = "select * from teacher_absent_course  where a_id='$id' and travel='1' order by start_date";
	$result = $CONN->Execute ($sql_select) or die($sql_select) ;
	$i=0; $outlay_Tol=0;//�`���B�ܼ�
	while (!$result->EOF) {

		$c_id = $result->fields["c_id"];
		$start_date = $result->fields["start_date"];
		$end_date = $result->fields["end_date"];
		$deputy_sn = $result->fields["deputy_sn"];
		$deputy_date = substr($result->fields["deputy_date"],0,10);
		$d_name=get_teacher_name($deputy_sn);
		$class_name = $result->fields["class_name"];
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
		$outlay_Tol=$outlay_Tol+$outlay_a;// �`���B�֭p

		$coutlay1 = ztos($outlay1);
		$coutlay2 = ztos($outlay2);
		$coutlay3 = ztos($outlay3);
		$coutlay4 = ztos($outlay4);
		$coutlay5 = ztos($outlay5);
		$coutlay6 = ztos($outlay6);
		$coutlay8 = ztos($outlay8);


	
		$ti = ($i++%2)+1;
		if($deputy_sn ==0){
			$modify_button="<input type='image' src='images/edit.png' name='edit[$c_id]' alt='�ק�'>";
			$del_button="<input type='image' src='images/del.png' name='del[$c_id]' alt='�R��'>";
			$check ="<font size=2 color=red>�ݽT�{</font><input type='image' src='images/edit.png' name='deputy[$c_id]' alt=' �T�w'>";
			
		}else{
			$add_button="";
			$view_button="";

			$modify_button="";
			$del_button="";
			$check ="<font size=2 >$deputy_date</font><input type='image' src='images/del.png' name='deputy_c[$c_id]' alt='����'>";
		}
		
		
	
		$room=($mode=="edit" and $c_id==$cc_id)?
		"<td align='center' ><input type='text' style='font-size: 12pt' size='10' maxlength='10' name='start_date' value='$start_date'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='10' maxlength='10' name='end_date' value='$end_date'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='10' maxlength='10' name='class_name' value='$class_name'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay1' value='$outlay1'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay2' value='$outlay2'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay3' value='$outlay3'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay4' value='$outlay4'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay5' value='$outlay5'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay6' value='$outlay6'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outl_id' value='$outl_id'></td>
		<td align='center' ><input type='text' style='font-size: 12pt' size='4'  name='outlay8' value='$outlay8'></td>
		<td><input type='submit' name='act' value='�ק�T�w'></td>
		<input type='hidden' name='c_id' value= $c_id >
		":"
		<td align='center'>
		$del_button
		$start_date 
		$modify_button
		</td>
		<td align='center'><font size=3>$end_date</font><br></td>		
		<td align='center'><font size=3>$class_name<br></font></td>		
		<td align='center'>$coutlay1<br></td>
		<td align='center'>$coutlay2<br></td>
		<td align='center'>$coutlay3<br></td>
		<td align='center'>$coutlay4<br></td>
		<td align='center'>$coutlay5<br></td>
		<td align='center'>$coutlay6<br></td>
		<td align='center'>$outl_id<br></td>
		<td align='center'>$coutlay8<br></td>	
		<td align='center'>$outlay_a</td>
		";
		$room.= "<td align='center'>". $d_name . $check ."</td"; 
		$room_data.="
		<tr >
		$room
		</tr>";
		$result->MoveNext();
	}


	//�����\���

	$main="	
	<table border='1' cellPadding='3' cellSpacing='0'  width=100%>
	<form name ='myform' action='{$_SERVER['PHP_SELF']}' method='post'>
	<tr class='title_mbody'>
	<td align='center' width='15%' rowspan='2' > $add_button ���  $view_button</td> 
	<td align='center' width='10%' rowspan='2'>�_���a�I</td>
	<td align='center' width='15%' rowspan='2'>�u�@�O�n</td>
	<td align='center' width='20%' colspan='4'>��q�O</td>
	<td align='center' width='5%' rowspan='2'>��J�O</td>
	<td align='center' width='5%' rowspan='2'>�Ȧ�~�N����I</td>
	<td align='center' width='5%' rowspan='2'>��ڸ���</td>
	<td align='center' width='5%' rowspan='2'>���O</td>
	<td align='center' width='5%' rowspan='2'>�X�p</td>	
	<td align='center' width='15%' rowspan='2'>$check5 </td>	

	</tr>	
	<tr class='title_mbody'>
	<td align='center' width='5%'>����</td>
	<td align='center' width='5%'>�����α��B</td>
	<td align='center' width='5%'>����</td>
	<td align='center' width='5%'>���K</td>
	</tr>	
	$room_data 
	$add_form
	</table>
	<input type='hidden' name='id' value= $id >
	</form>
<br>
<table border='1' cellPadding='3' cellSpacing='0'�@ width=90%>
<tr><td colspan=5>�бԩ���q�u������G�f�ȹB�@�f���B�@�f����(�_��)�@�f����(����)�@�f����(�۱j)</td></tr>
<tr Height=50><td colspan=5>�W�C�X�t�ȶO�X�p�s�x�� <ins><b> $outlay_Tol </b></ins> ����A
�~�g�p�Ʀ��W�C<b>���H</b>�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@�@(ñ�W�λ\��)</td></tr>
<tr align='center'><td>�X�t�H</td><td>���D��</td><td>�H�Ƴ��</td><td>�|�p���</td><td>��������</td></tr>
<tr Height=60><td>&nbsp;<br><br></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
</table>
	";


	return $main;
}







//������
function teacher_absent($id){
	global $CONN,$course_kind,$view_tsn,$sel_year,$sel_seme,$teacher_sn,$class_dis,$check4_sn,$c_start_date,$c_end_date,$check1,$check2,$check3,$check4,$post_kind;

		$query="select * from teacher_absent where id='".$id."'";
		$result = mysql_query($query) or die ($query);
		$row = mysql_fetch_array($result);
		
		$view_tsn=$row["teacher_sn"];
		if($view_tsn=="") exit();
		$abs_kind=$row["abs_kind"];
		if($abs_kind<>"52") exit();

		$sel_year=$row["year"];
		$sel_seme=$row["semester"];
		$teacher_sn=$row["teacher_sn"];
		$class_dis=$row["class_dis"];
		$locale=$row["locale"];
		$post_k=$row["post_k"];

		$t_name=get_teacher_name($row["teacher_sn"]);
		$reason=$row["reason"];
		$note=$row["note"];
		$record_date=$row["record_date"];//�n�O�ɶ�
		$abs_kind_arr=tea_abs_kind();
		$abs_kind=$abs_kind_arr[$row["abs_kind"]];
		$n_class_dis=$course_kind[$row["class_dis"]];
		$start_date=substr($row["start_date"],0,16);
		$c_start_date=substr($start_date,0,10);

		$end_date=substr($row["end_date"],0,16);
		$c_end_date=substr($end_date,0,10);
	
		$day_hour=($row["day"]==0)?"":$row["day"] ."��";
		$day_hour.=($row["hour"]==0)?"":$row["hour"] ."��";

		$check4_sn=$row["check4_sn"];
		$de_name=get_teacher_name($row["deputy_sn"]);
		$c1_name=get_teacher_name($row["check1_sn"]);
		$c2_name=get_teacher_name($row["check2_sn"]);
		$c3_name=get_teacher_name($row["check3_sn"]);
		$c4_name=get_teacher_name($row["check4_sn"]);
		
		$main= "<table border=0 cellspacing=1 cellpadding=4 width=100% bgcolor=#cccccc >
		<tr bgcolor=#E1ECFF align=center>
		<td width=4%>�Ǹ�</td><td width=8%>�а��H</td><td width=6%>���O</td>	<td width=12%>�ƥ�</td><td width=16%>�}�l�ɶ�<br>�����ɶ�</td><td width=6% >���</td>
		<td width=6%>�a�I</td><td width=8%>¾�ȥN�z�H</td><td width=8%>$check1</td><td width=8%>$check2</td><td width=8%>$check3</td><td width=8%>$check4</td></tr>";

		$main.= "<tr bgcolor=#ffffff align=center>
		<td>$id</td>
		<td><font size=2 color=blue>$post_kind[$post_k]</font><br>$t_name</td>
		<td><font size=2>$abs_kind</font><br>
			<font size=2 color=blue>$note</font></td>	
		<td><font size=2>$reason</font></td>
		<td>$start_date<br>$end_date</td>
		<td>$day_hour</td>
		<td>$locale </td>	
		<td>$de_name</td>
		<td>$c1_name</td>
		<td>$c2_name</td>
		<td>$c3_name</td>
		<td>$c4_name</td></tr></table>";
	return $main;
}
?>