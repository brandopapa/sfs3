<?php

//$Id: maintain.php 6731 2012-03-28 01:50:11Z infodaes $
include "config.php";
sfs_check();
//�q�X����
if(!$remove_sfs3head) head("�ɥά������@");

echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='item_selected[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

$status_arr=array(0=>'����',1=>'�w�k��',2=>'���k��',3=>'�O�����k');
$teacher_sn=$_REQUEST['teacher_sn'];
$status=$_POST['status'];
$year_seme=$_POST['year_seme'];
$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());


if($_POST['item_selected']){
	$ask_items='';
	$ask_teacher_sn=array();
	$item_selected=$_POST[item_selected];
	foreach($item_selected as $value)
	{
		$temp_arr=explode('-',$value);
		$ask_items.=$temp_arr[0].",";
		$ask_teacher_sn[$temp_arr[1]]['count']+=1;
	}
	$ask_items=SUBSTR($ask_items,0,-1);
	$ask_teachers='';
	foreach($ask_teacher_sn as $key=>$value){
		$ask_teachers.='['.$key.']';
	}
}


if($_POST['BtnSubmit']=='�k�ٵn��' and $item_selected){
	$refund_date=$_POST['refund_date'];
	$memo=$_POST['memo'];
	$sql="UPDATE equ_record SET refund_date=CURDATE(),receiver_sn=$session_tea_sn,memo='$memo' where sn IN ($ask_items)";
	
	$res=$CONN->Execute($sql) or user_error("�g�J�ӽЬ������ѡI<br>$sql",256);
}

if($_POST['BtnSubmit']=='�����k��' and $item_selected){
	$sql="UPDATE equ_record SET refund_date=NULL,receiver_sn=NULL where sn IN ($ask_items)";
	$res=$CONN->Execute($sql) or user_error("�g�J�ӽЬ������ѡI<br>$sql",256);
}

if($_POST['BtnSubmit']=='�R������' and $item_selected){
	$sql="DELETE FROM equ_record where sn IN ($ask_items)";
	$res=$CONN->Execute($sql) or user_error("�R���ɥά������ѡI<br>$sql",256);
}

if($_POST['BtnSubmit']=='�o�e���i' and $item_selected){
	$Over_Days=$_POST['Over_Days'];
	$Over_Title=$_POST['Over_Title'];
	$Over_Content=$_POST['Over_Content'];
	$sql="INSERT INTO equ_board SET announce_date=CURDATE(),announce_limit=CURDATE()+$Over_Days,manager_sn=$session_tea_sn,title='$Over_Title',detail='$Over_Content',receiver_sn='$ask_teachers'";
	$res=$CONN->Execute($sql) or user_error("�o�e���i���ѡI<br>$sql",256);
	$executed='�� '.date('Y/m/d h:i:s')." �w�o�e���w�H�� $ask_teachers ��".$status_arr[$status]."���i";
}


//��V������
$linkstr="teacher_sn=$teacher_sn";
if($_GET['menu']<>'off') echo print_menu($MENU_P,$linkstr);

	$main="<table>
<form name='myform' method='post' action='$_SERVER[PHP_SELF]'>�ɥΪ̭��w�G<select name='teacher_sn' onchange='this.form.submit()'><option></option>";

	//���o�w�ɥζ��ؤ��޲z�H
	$sql_select="SELECT teacher_sn,count(*) as amount FROM equ_record WHERE manager_sn=$session_tea_sn GROUP BY teacher_sn";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		$main.="<option ".($teacher_sn==$res->fields['teacher_sn']?"selected":"")." value=".$res->fields['teacher_sn'].">".$teacher_array[$res->fields['teacher_sn']]['title']."-".$teacher_array[$res->fields['teacher_sn']]['name']."(".$res->fields['amount'].")</option>";
		$res->MoveNext();
	}
	$main.="</select>�@�@ ���A�G";
	
//�������w
foreach($status_arr as $key=>$value){
	$main.="<input type='radio' value='$key' name='status' onclick='this.form.submit()'".($status==$key?' checked':'').">$value ";
}

$main.="�@�@<input type='checkbox' name='year_seme' value='Y'".($_POST['year_seme']?' checked':'')." onclick='this.form.submit()'>���Ǵ����w";

$showdata.="<table align=center width=".$m_arr['Table_width']."% border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
	<tr bgcolor='$Tr_BGColor'>
		<td align='center'>�ӽФ��</td>
		<td align='center'>�ɥΪ�</td>
		<td align='center'>���~�s��</td>
		<td align='center'><input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'>���~�W��</td>
		<td align='center'>�֥ܤ��</td>
		<td align='center'>�ɥX���</td>
		<td align='center'>�ɥδ���</td>
		<td align='center'>�k�٤��</td>
		<td align='center'>�k�ٵn��</td>
		<td align='center'>���O����</td>
	</tr>";	
if($status or $teacher_sn)
{
	//���o�ɥά���
	$sql_select="SELECT a.*,CURDATE()-a.refund_limit as leftdays,b.item FROM equ_record a,equ_equipments b WHERE a.equ_serial=b.serial AND a.manager_sn=$session_tea_sn";
	if($teacher_sn) $sql_select.=" AND a.teacher_sn=$teacher_sn";

	switch ($status) {
	case 1:
	$sql_select.=" AND NOT ISNULL(a.refund_date)";
	break;
	case 2:
	$sql_select.=" AND ISNULL(a.refund_date)";
	break;
	case 3:
	$sql_select.=" AND ISNULL(a.refund_date) AND a.refund_limit<CURDATE()";
	break;
	}
	//���Ǵ����w
	if($year_seme) $sql_select.=" AND year_seme='$curr_year_seme'";

	//$sql_select.=" ORDER BY ask_date";
	$result=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	if($result->recordcount()){
		while(!$result->EOF)
		{
			//$BGColor=$m_arr['NotReturned_BGColor'];
			$BGColor=$m_arr['#FFFFFF'];
			if($result->fields['refund_date']) { $BGColor=$m_arr['Returned_BGColor']; }
				else { if($result->fields['leftdays']<0) { $BGColor=$m_arr['OverTime_BGColor']; } }

			$showdata.="<tr bgcolor='$BGColor' align='center'><td>".$result->fields['ask_date']."</td>
				<td>".$teacher_array[$result->fields['teacher_sn']]['title']."-".$teacher_array[$result->fields['teacher_sn']]['name']."</td>
				<td>".$result->fields['equ_serial']."</td>
				<td align='left'><input type='checkbox' name='item_selected[]' value=".$result->fields['sn']."-".$result->fields['teacher_sn'].">".$result->fields['item']."</td>
				<td>".$result->fields['allowed_date']."</td>
				<td>".$result->fields['lend_date']."</td>
				<td>".$result->fields['refund_limit']."</td>
				<td>".$result->fields['refund_date']."</td>
				<td>".$teacher_array[$result->fields['receiver']]['name']."</td>
				<td>".$result->fields['memo']."</td></tr>";
			$result->MoveNext();
		}
		if($status==3){
			$showdata.="<tr bgcolor='$Tr_BGColor'><td align=center>".$status_arr[$status]."<BR>�p�K���i</td>
			<td colspan=8>���i��ơG<input type='text' size=3 value='".$m_arr['Over_Days']."' name='Over_Days'>
			<BR>���i�D���G<input type='text' size=60 value='".$m_arr['Over_Title']."' name='Over_Title'>
			<BR>���廡���G<textarea rows=3 name='Over_Content' cols=60>".$m_arr['Over_Content']."</textarea></td>
			<td align=center colspan=1><input type='submit' value='�o�e���i' name='BtnSubmit' onclick='return confirm(\"�u���n�o�e?\")'></td>";
		}
			
		}
		$showdata.="<tr bgcolor='$Tr_BGColor'>
		<td align=center colspan=9>���k�٤���G<input type='text' size=8 value='".date('Y-m-d',time())."' name='refund_date'>
		�@�@�����O�����G<input type='text' size=15 value='' name='memo'>�@<input type='submit' value='�k�ٵn��' name='BtnSubmit' onclick='return confirm(\"�u�����k��?\")'> <input type='submit' value='�����k��' name='BtnSubmit' onclick='return confirm(\"�u���n����?\")'></td>
		<td align=center colspan=1><input type='submit' value='�R������' name='BtnSubmit' onclick='return confirm(\"�u���n�R��?\")'></td>";
}

$showdata.="</form></table><BR>$executed";
echo $main.$showdata;
if(!$remove_sfs3head) foot();
?>