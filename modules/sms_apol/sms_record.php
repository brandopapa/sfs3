<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();


$target_id=$_POST['taskid'];
if($target_id){
	//�����ID�����T�̦W��
	$sql="SELECT * FROM sms_apol_record WHERE TaskID='$target_id'";
	$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	while(!$rs->EOF){
		$MSISDN=$rs->fields['MSISDN'];
		$name_arr[$MSISDN]=$rs->fields['MSISDN_Name'];
		$rs->MoveNext();
	}

	//�d�ߦU�Ӹ��X�ǰe���A
	$xml=get_task_result($target_id);	

	$RtnDateTime=$xml->RtnDateTime;
	$CreateTime=$xml->CreateTime;
	$Code=$xml->Code;
	$Reason=iconv("UTF-8","Big5//IGNORE",$xml->Reason);
	$TotalRec=$xml->TotalRec;
	$TaskStatus=iconv("UTF-8","Big5//IGNORE",$xml->TaskStatus);
	$description=$statuscodeArray[$TaskStatus];
	//��s��������A
	$sql="UPDATE sms_apol_task SET Code='$TaskStatus',TotalRec='$TotalRec' WHERE TaskID='$target_id'";
	$rs=$CONN->Execute($sql) or user_error("��s���A���ѡI<br>$sql",256);	
	
	//�i��HTML��X
	$result="<table><tr valign='top'><td><font size=1 color='#FF8888'>���d�߮ɨ�G $RtnDateTime<br>������N���G $target_id<br>������ɨ�G $CreateTime<br>��������A�X�G $Code $Reason<br>���o�e��H�ơG $TotalRec<br>���ǰe���A�X�G $TaskStatus $description<br></font></td>
		<td><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr align='center' bgcolor='#ffffcc'><td>No.</td><td>������X</td><td>��H�W��</td><td>�ǰe���G</td><td>�������²�T�ɶ�</td></tr>";
	$MDNList=(array)$xml->MDNList;

	if($TotalRec==1){
			$MSISDN=$MDNList[MDNUnit]->MSISDN;
			$MSISDN_NAME=$name_arr["$MSISDN"];
			$Status=$MDNList[MDNUnit]->Status;
			$DrDateTime=$MDNList[MDNUnit]->DrDateTime;
			$DrDateTime=substr($DrDateTime,0,4).'/'.substr($DrDateTime,4,2).'/'.substr($DrDateTime,6,2).' '.substr($DrDateTime,8,2).':'.substr($DrDateTime,10,2);
			$bgcolor=($Status=='99')?'#FFEEEE':'#FFFFFF';
			$result.="<tr align='center' bgcolor='$bgcolor'><td>1</td><td align='center'>$MSISDN</td><td>$MSISDN_NAME</td><td>$Status {$statuscodeArray["$Status"]}</td><td>$DrDateTime</td></tr>";
	} else {
		$i=0;
		foreach($MDNList[MDNUnit] as $MDNUnit) {
			$i++;		
			$MSISDN=$MDNUnit->MSISDN;
			$MSISDN_NAME=$name_arr["$MSISDN"];
			$Status=$MDNUnit->Status;
			$bgcolor=($Status=='99')?'#FFEEEE':'#FFFFFF';
			$DrDateTime=$MDNUnit->DrDateTime;
			$DrDateTime=substr($DrDateTime,0,4).'/'.substr($DrDateTime,4,2).'/'.substr($DrDateTime,6,2).' '.substr($DrDateTime,8,2).':'.substr($DrDateTime,10,2);
			$result.="<tr align='center' bgcolor='$bgcolor'><td>$i</td><td align='center'>$MSISDN</td><td>$MSISDN_NAME</td><td>$Status</td><td>{$statuscodeArray["$Status"]}</td><td>$DrDateTime</td></tr>";
		}
	}
	$result.="</table></td></tr></table>";
}


//$action='��s�ǰe���G';

//�Ǵ��O
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$curr_year=curr_year();
$curr_month=date("m");
$session_tea_sn=$_SESSION['session_tea_sn'];

//�q�X����
head("�o�e�O��");
print_menu($menu_p);

$year_month=$_POST['year_month'];	
//����o�e�~��
$sql="SELECT DISTINCT DATE_FORMAT(ask_time,'%Y-%m') FROM sms_apol_task WHERE teacher_sn='$session_tea_sn' AND year_seme='$curr_year_seme'";
$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
while(!$rs->EOF){
	$this_year_month=$rs->fields[0];
	$checked=($this_year_month==$year_month)?'checked':'';
	$year_month_radio.="<input type='radio' value='$this_year_month' name='year_month' $checked onclick=\"document.myform.taskid.value=''; this.form.submit();\">{$year}$this_year_month ";
	$rs->MoveNext();
}

$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><input type='hidden' name='taskid' value=''><font size=2 color='brown'>$year_month_radio<br>$msg</font>
	<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1' width='100%'>
	<tr align='center' bgcolor='#ffcccc'><td>No.</td><td>�ШD�ɨ�</td><td>���~�N��</td><td>�D��</td><td>²�T���e</td><td>����N��</td><td>����</td><td>²�T���A</td><td>���A�^���ɨ�</td></tr>";

//���o�ǰe�O��
$sql="SELECT * FROM sms_apol_task WHERE teacher_sn='$session_tea_sn' AND DATE_FORMAT(ask_time,'%Y-%m')='$year_month' ORDER BY RtnDateTime DESC";
$recordSet=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
while(!$recordSet->EOF){
	$i++;
	$ask_time=$recordSet->fields['ask_time'];
	$MDN=$recordSet->fields['MDN'];
	$Subject=$recordSet->fields['Subject'];
	$Message=str_replace("\r\n",'<br>',$recordSet->fields['Message']);
	$Code=$statuscodeArray[$recordSet->fields['Code']];
	$TaskID=$recordSet->fields['TaskID'];
	$TotalRec=$recordSet->fields['TotalRec'];
	$RtnDateTime=$recordSet->fields['RtnDateTime'];	
	
	$java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#ffffcc';\" onMouseOut=\"this.style.backgroundColor='#ffffff';\" ondblclick='document.myform.taskid.value=\"$TaskID\"; document.myform.submit();'";
	
	$my_num=$target_id==$TaskID?'��':$i;
	$my_color=$target_id==$TaskID?'#FF0000':'#000000';
	
	$main.="<tr align='center' $java_script  style='Color:$my_color'><td>$my_num</td><td>$ask_time</td><td>$MDN</td><td align='left'>$Subject</td><td align='left'>$Message</td><td>$TaskID</td><td>$TotalRec</td><td>$Code</td><td>$RtnDateTime</td></tr>";
	$recordSet->MoveNext();
}
$main.="</table></form><br>$result";

echo $main;
foot();

?>