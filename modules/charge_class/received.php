<?php

//$Id: received.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
include "my_fun.php";

sfs_check();

//�q�X����
head("���O�޲z(�ɮv��)");

echo <<<HERE
<script>

function tagall(status) {
  var i =0;
  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='selected_stud[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

//�Ǵ��O

$work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

$item_id=$_REQUEST[item_id];
$selected_stud=$_POST[selected_stud];
$dollars=$_POST[dollars];
$grade=substr($class_id,0,1);


// ���X�Z�ŦW�ٰ}�C
$class_base = class_base($work_year_seme);
//��V������
$linkstr="item_id=$item_id";
echo print_menu($MENU_P,$linkstr);

if($m_arr[is_received] AND $class_id) {
	
if($selected_stud AND $_POST['act']=='ú�ڳ]�w'){
	if( $item_id AND $class_id)
	{
		//�����ܪ��Z�žǥ�
		$batch_value="";
		foreach($selected_stud as $stud_datas)
		{
			$stud_data=explode(',',$stud_datas);
			$sn=$stud_data[0];
			$record_id=$stud_data[1];
			
			$batch_value.="('$record_id',$sn,$item_id,$dollars,CURDATE()),";
		}
		$batch_value=substr($batch_value,0,-1);
		//echo "===================<BR>$batch_value<BR>===================";
		
		$sql_select="REPLACE INTO charge_record(record_id,student_sn,item_id,dollars,paid_date) values $batch_value";
		
		$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	} else echo "<script language=\"Javascript\"> alert (\"��T����, �L�k�����O�妸�s�W�I\")</script>";
};


if($_POST['act']=='�M�ť��Z��ú�ڳ]�w'){
	$sql_select="update charge_record set dollars=0,paid_date=NULL where item_id=$item_id AND record_id like '$work_year_seme$class_id%'";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
};

$main="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#AAAAAA' width='100%'><form name='myform' method='post' action='$_SERVER[PHP_SELF]'>
	<select name='item_id' onchange='this.form.submit()'><option></option>";

//���o�~�׶���
$sql_select="select * from charge_item where cooperate=1 AND year_seme='$work_year_seme' AND (curdate() between start_date AND end_date) order by end_date desc";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

while(!$res->EOF) {
	$main.="<option ".($item_id==$res->fields[item_id]?"selected":"")." value=".$res->fields[item_id].">".$res->fields[item]."(".$res->fields[start_date]."~".$res->fields[end_date].")</option>";
	$res->MoveNext();
}
$main.="</select>";
if($item_id)
{

	if($class_id)
	{
		//���o�e�w�}�C�ǥ͸��
		$sql_select="select a.record_id,a.student_sn,a.dollars,b.stud_name,b.stud_sex from charge_record a,stud_base b where a.student_sn=b.student_sn AND item_id=$item_id AND record_id like '$work_year_seme$class_id%' order by record_id";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
		$col=7; //�]�w�C�@�C��ܴX�H
		$studentdata="";
		while(list($record_id,$student_sn,$dollars,$stud_name,$stud_sex)=$recordSet->FetchRow()) {
			//echo $recordSet->currentrow()."==<BR>";			
			if($recordSet->currentrow() % $col==1) $studentdata.="<tr>";
			if($dollars) {
				$studentdata.="<td bgcolor='#CCCCCC' align='center'>(".substr($record_id,-2).")$stud_name<BR>�C $dollars</td>";
			} else {
				$studentdata.="<td bgcolor=".($stud_sex==1?"#CCFFCC":"#FFCCCC")."><input type='checkbox' name='selected_stud[]' value='$student_sn,$record_id' id='stud_selected'>(".substr($record_id,-2).")$stud_name</td>";
			}
			if($recordSet->currentrow() % $col==0  or $recordSet->EOF) $studentdata.="</tr>";
		}
		$studentdata.="<tr height='50'><td align='center' colspan=$col><input type='button' name='all_stud' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(0);'>�@";
		$studentdata.="�@�@ú�O���B�G<input type='text' size=5 value='' name='dollars'>";
		$studentdata.="<input type='submit' value='ú�ڳ]�w' name='act'>�@�C�G�wú��";
		$studentdata.="�@<input type='submit' value='�M�ť��Z��ú�ڳ]�w' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'></td></tr>";
	}
}
echo $main.$studentdata."</form></table>";
} else echo $not_allowed;
foot();
?>