<?php
	
include "config.php";

sfs_check();

$action='�}�l�ǰe';
//�Ǵ��O
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$my_sn=$_SESSION['session_tea_sn'];
$my_name=$_SESSION['session_tea_name'];

$selected_MDN=$_POST['selected_MDN'];
$selected_MDN_name=$_POST['selected_MDN_name'];
$Subject=iconv("Big5","UTF-8//IGNORE",$_POST['Subject']);
$my_name=$sign_name?"\r\n by $my_name":"";
$Message=iconv("Big5","UTF-8//IGNORE",$_POST['Message'].$my_name);
$room_id=$_POST['room_id'];


if($_POST['act']==$action)
if($selected_MDN and $Subject and $Message){	
	$fp = fsockopen("xsms.aptg.com.tw", 80, $errno, $errstr, 30);
	if (!$fp) echo '�L�k�s���Ȥӹq�H���A���I'; else
	{
		$MDNList='';
		foreach($selected_MDN as $key=>$MSISDN) $MDNList.="<MSISDN>$MSISDN</MSISDN>";
		$xmlpacket ="<soap-env:Envelope xmlns:soap-env='http://schemas.xmlsoap.org/soap/envelope/'>
		<soap-env:Header/>
		<soap-env:Body>
			<Request>
			<MDN>$MDN</MDN>
			<UID>$UID</UID>
			<UPASS>$UPASS</UPASS>
			<Subject>$Subject</Subject>
			<Message>$Message</Message>
			<MDNList>
				$MDNList
			</MDNList>
			</Request>
		</soap-env:Body>
		</soap-env:Envelope>";
		$contentlength = strlen($xmlpacket);
		$out = "POST /XSMSAP/api/APIRTRequest HTTP/1.1\r\n";
		$out .= "Host: 210.200.64.111\r\n";
		$out .= "Connection: close\r\n";
		$out .= "Content-type: text/xml;charset=utf-8\r\n";
		$out .= "Content-length: $contentlength\r\n\r\n";
		$out .= "$xmlpacket";
		fwrite($fp, $out);
		while (!feof($fp))
		{
			$theOutput .= fgets($fp, 128);
		}
		fclose($fp);
		$theOutput=iconv("UTF-8","Big5//IGNORE",$theOutput);
		
		//�H�r��覡����^�����
		$pos1=strpos($theOutput,'<Code>',1)+6;
		$pos2=strpos($theOutput,'</Code>',1);
		$Code=substr($theOutput,$pos1,$pos2-$pos1);
		
		$pos1=strpos($theOutput,'<TaskID>',1)+8;
		$pos2=strpos($theOutput,'</TaskID>',1);
		$TaskID=substr($theOutput,$pos1,$pos2-$pos1);
		
		$pos1=strpos($theOutput,'<RtnDateTime>',1)+13;
		$pos2=strpos($theOutput,'</RtnDateTime>',1);
		$RtnDateTime=substr($theOutput,$pos1,$pos2-$pos1);
		
		//�g�Jtask��ƪ�
		$TotalRec=count($selected_MDN);
		$sql="INSERT INTO sms_apol_task (year_seme,ask_time,teacher_sn,MDN,Subject,Message,Code,TaskID,TotalRec,RtnDateTime) VALUES ('$curr_year_seme',now(),'$my_sn','$MDN','".stripslashes($_POST['Subject'])."','".stripslashes($_POST['Message'])."','$Code','$TaskID','$TotalRec','$RtnDateTime');";
		$res=$CONN->Execute($sql) or die("�g�J��ƪ�O�����ѡI<br>$sql");
		
		//�g�Jrecord��ƪ�
		$sql="INSERT INTO sms_apol_record (TaskID,MSISDN,MSISDN_Name) VALUES ";
		foreach($selected_MDN as $key=>$MSISDN){
			$my_name=stripslashes($selected_MDN_name[$MSISDN]);
			$sql.="('$TaskID','$MSISDN','$my_name'),";
		}
		$sql=substr($sql,0,-1);
		$res=$CONN->Execute($sql) or die("�g�J��ƪ�O�����ѡI<br>$sql");
		//echo "<textarea cols=100 rows=10>$theOutput</textarea>";
	}
} else echo "��J��Ƥ������A���ˬd 1.�ǰe��H 2.�D�� 3.²�T���e<br>";


//�q�X����
head("�ǰe²�T�ܱ�¾��");

print_menu($menu_p);
echo <<<HERE
<script>
function tagall(status) {
  var i =0;
  while (i < document.myform.elements.length)  {
    if(document.myform.elements[i].name=='selected_teacher[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

//��ܳB��
$school_room=room_kind();
if($room_select){	
	$room_list="����ܳB�ǡ�<br><select name='room_id' onchange='this.form.submit()'><option value=''>*�����¾��*</option>";
	foreach($school_room as $key=>$value){
			$selected=($room_id==$key)?'selected':'';
			$room_list.="<option value=$key $selected>$value</option>";	
	}
	$room_list.="</select>";
} else {
	$room_list="<table border='2' cellpadding='6' cellspacing='0' style='border-collapse: collapse; font-size=9pt;' bordercolor='#111111' id='AutoNumber1' width='100%'>
	<tr><td align='center' bgcolor='#ccccff'>��ܳB��</td></tr><tr><td><input type='radio' name='room_id' value='' onclick='this.form.submit()' checked>*�����¾��*<br>";
	foreach($school_room as $key=>$value){
			$selected=($room_id==$key)?'checked':'';
			$room_list.="<input type='radio' name='room_id' value='$key' onclick='this.form.submit()' $selected>$value<br>";	
	}
	$room_list.="</td></tr></table><br>";
}

$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><table><tr valign='top'><td>$room_list</td><td>";

//if($class_id)
//{
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	//����Юv���
	if($room_id) $room_limit=" and post_office=$room_id";
	$sql_select = "SELECT a.name,a.sex,a.cell_phone,d.title_name,b.class_num ,b.post_office
		FROM teacher_base a,teacher_post b,teacher_title d 
		where a.teacher_sn =b.teacher_sn  
		and b.teach_title_id=d.teach_title_id  
		and a.teach_condition=0 $room_limit order by class_num,post_kind,post_office";
	
	$recordSet=$CONN->Execute($sql_select) or user_error($sql_select,256);
	$col=6; //�]�w�C�@�C��ܴX�H
	$teacherdata="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>
			<tr bgcolor='#ccffff'><td colspan=$col align='center'>
				<input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'>�ǰe��H
			</td></tr>";
	while(list($name,$sex,$cell_phone,$title_name,$class_num,$post_office)=$recordSet->FetchRow()) {
		if($recordSet->currentrow() % $col==1) $teacherdata.="<tr align='center'>";
		$num=sprintf('%02d',$recordSet->currentrow());
		$sex_color=($sex==1)?"#CCFFCC":"#FFCCCC";
		$cell_phone=str_replace('-','',$cell_phone); //�קK�|��J-�������j���ߺD���D
		$cell_phone=intval($cell_phone);
		if(!$cell_phone) {
			$teacherdata.="<td bgcolor='#CCCCCC'>($num)$name<br><font size=2 color='gray'>[$class_num$title_name]</font></td>";
		} else {
			$cell_phone='0'.$cell_phone;
			$DestName='('.$num.')'.$class_num.$title_name.$name;
			$teacherdata.="<td bgcolor='$sex_color'><input type='checkbox' name='selected_MDN[]' value='$cell_phone'>($num)$name<input type='hidden' name='selected_MDN_name[$cell_phone]' value='$DestName'><br><font size=2 color='blue'>[$class_num$title_name][$cell_phone]</font></td>";
		}
		if($recordSet->currentrow() % $col==0  or $recordSet->EOF) $teacherdata.="</tr>";
	}
	$col=$col-3;
	
	//�d�߳Ѿl�I��
	$lefted=get_points();
	
	
	$teacherdata.="</table><br>
	<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>
	<tr align='center' bgcolor='#ccffff'><td colspan=3>�ϥλ���</td><td colspan=$col'>²�T���e</td></tr>
		<tr bgcolor='#ffffcc'>
		<td colspan=3>
		<font color='brown' size=2>
			<li>���~�N���G$MDN �F�ϥαb���G$UID �C</li>
			<li>�w�o�e�G{$lefted['PointsUsed']} �F�i�o�e�G{$lefted['PointsRemain']} �C</li>
			<li>�C��²�T���סG70�Ӥ���r�άO160�ӭ^�Ʀr�C</li>
			<li>�o�e�e�Х��˵��e���o�e�O���A�קK���Ƶo�e</li>
			<li>�o�e���C��²�T�A���ݭn������X�A�Ъ`�N�����įq�C</li>
			<li>������ܬ��Ƕ¦⪺��¾���u�A�Y�䥼��Юv�޲z�Ҳյn�O��ʹq�ܩεn�����~�C</li>
		</font>
		</td>
		<td colspan=$col' align='left'>
		�D�������G<input type='text' maxlength=20 size=26 name='Subject' value='{$_POST['Subject']}'><br>�ǰe���e�G<br>
		<textarea name='Message' rows=5 cols=40>{$_POST['Message']}</textarea>
		<input type='submit' value='$action' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:20px;'></td></tr></table>";
//}
echo $main.$teacherdata."<font size=2 color='green'>$pre_data</font></td></tr></table></form>";
foot();

?>