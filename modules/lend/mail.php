<?php

//$Id: mail.php 6207 2010-10-05 04:46:46Z infodaes $
include "config.php";
sfs_check();
//�q�X����
if(!$remove_sfs3head) head("���~�ɥκ޲z�l��q��");

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

$status=$_POST['status'];

if($_POST['BtnSubmit']=='�o�e' and $_POST['item_selected']){
	
	$Mail_Content=$_POST['Mail_Content'];
	$Cc_Send=$m_arr['Cc_Send'];
	$Reply=$m_arr['Reply'];
	
	
	//�]�wSMTP
	ini_set("sendmail_from",$teacher_array[$session_tea_sn]['title']."-".$teacher_array[$session_tea_sn]['name']."<".$teacher_array[$session_tea_sn]['email'].">");
	ini_set("SMTP",$m_arr['SMTP_Server']);
	ini_set("smtp_port",$m_arr['SMTP_Port']);
	
	$excuted="<BR>�� �e���H��H�e�����G�p�U��<BR><BR>";
	$item_selected=$_POST[item_selected];
	foreach($item_selected as $item){
		$item_arr=explode($split_str,$item);
		
		//���H�H�l��
		$to=$item_arr[1];

		//�l��D��
		$subject =$_POST['Mail_Title'];

		//�l�󤺮e
		$message =str_replace('{{borrower}}',$item_arr[0],$Mail_Content);
		$message =str_replace('{{content}}',$item_arr[2],$message);
		$message =str_replace('{{manager}}',$teacher_array[$session_tea_sn]['title'].' '.$teacher_array[$session_tea_sn]['name'],$message);
		
		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		//$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "Content-type: text/html;\r\n";

		/* additional headers */
		$manager_mail=$teacher_array[$session_tea_sn]['title']."-".$teacher_array[$session_tea_sn]['name']."<".$teacher_array[$session_tea_sn]['email'].">\r\n";
		$headers.="To: ".$item_arr[0]."<".$item_arr[1].">\r\n";
		$headers.="From: $manager_mail";
		$headers.="Reply-To: $manager_mail";
		$headers.="Return-Path: $manager_mail";

		if($Reply) {
			$headers.="Disposition-Notification-To: $manager_mail";
		}
		
		if($Cc_Send) {
			$headers .= "Cc: $manager_mail";
		}
		//$headers .= "Bcc: birthdaycheck@example.com\r\n";

		/* and now mail it */
		if(mail($to, $subject, $message, $headers)) {
			$excuted.=date("h:i:s A")." �H��w���\�H�� ".$item_arr[0]."(".$item_arr[1].")<BR>";
		} else {
			$excuted.=date("h:i:s A")." �H�� ".$item_arr[0]."(".$item_arr[1].") ���H�󥢱�!!<BR>";
		}
	}
}

//��V������
$linkstr="teacher_sn=$teacher_sn";
if($_GET['menu']<>'off') echo print_menu($MENU_P,$linkstr);

$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'>";

//�������w
$main.="�ɥX���A���w�G";

$status_arr=array(0=>'�O�����k',1=>'���k��',2=>'�w�k��',3=>'����');
foreach($status_arr as $key=>$value){
	$main.="<input type='radio' value='$key' name='status' onclick='this.form.submit()'".($status==$key?' checked':'').">$value ";
}

$main.="<table align=center width=".$m_arr['Table_width']."% border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>
	<tr bgcolor='$Tr_BGColor'>
		<td align='center'><input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'></td>
		<td align='center'>�ɥΪ�</td>
		<td align='center'>���~�ƶq�έp</td>
		<td align='center'>�ɥΪ��~����</td>
	</tr>";	

//���o�w�ɥζ��ؤ��޲z�H
$sql="SELECT teacher_sn,count(*) as amount FROM equ_record WHERE manager_sn=$session_tea_sn";
switch ($status) {
case 0:
	$sql.=" AND ISNULL(refund_date) AND refund_limit<CURDATE()";
	break;
case 1:
	$sql.=" AND ISNULL(refund_date)";
	break;
case 2:
	$sql.=" AND NOT ISNULL(refund_date)";
	break;
}
$sql.=" GROUP BY teacher_sn";

$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
while(!$res->EOF) {
	//���detail���
	$teacher_sn=$res->fields['teacher_sn'];
	$sql_detail="SELECT a.*,b.item FROM equ_record a,equ_equipments b WHERE teacher_sn=$teacher_sn AND (a.manager_sn=$session_tea_sn OR b.manager_sn=$session_tea_sn) AND a.equ_serial=b.serial";
	$detail_data='';
	switch ($status) {
	case 0:
		$sql.=" AND ISNULL(refund_date) AND refund_limit<CURDATE()";
		break;
	case 1:
		$sql.=" AND ISNULL(refund_date)";
		break;
	case 2:
		$sql.=" AND NOT ISNULL(refund_date)";
		break;
	}
	$detail=$CONN->Execute($sql_detail) or user_error("Ū�����ѡI<br>$sql_detail",256);
	while(!$detail->EOF) {
		$detail_data.='('.($detail->currentrow()+1).') '.$detail->fields['equ_serial'].'-'.$detail->fields['item'].' ['.$detail->fields['lend_date'].']~['.$detail->fields['refund_limit'].'] '.($detail->fields['refund_date']?$detail->fields['refund_date'].'�w�k��':'�|���k��')."<BR>";
		$detail->MoveNext();
	}

	//��X�e��
	$email=$teacher_array[$res->fields['teacher_sn']]['email'];
	$item_post_data=$teacher_array[$res->fields['teacher_sn']]['title']."-".$teacher_array[$res->fields['teacher_sn']]['name'].$split_str.$teacher_array[$res->fields['teacher_sn']]['email'].$split_str.$detail_data;
	$main.="<tr><td>".($email?"<input type='checkbox' name='item_selected[]' value='".$item_post_data."'":"<img src='images/delete.gif' alt='���]�wemail'>")."</td>
		<td>".$teacher_array[$res->fields['teacher_sn']]['title']."-".$teacher_array[$res->fields['teacher_sn']]['name']."</td>
		<td align='center'>".$res->fields['amount']."</td>
		<td>$detail_data</td></tr>";
	$res->MoveNext();
}
$main.="<tr bgcolor='$Tr_BGColor'><td colspan=4>
	�o�H�H�G ".$teacher_array[$session_tea_sn]['title']."-".$teacher_array[$session_tea_sn]['name']." (".$teacher_array[$session_tea_sn]['email'].")
	�@�@<input type='checkbox' name='Reply' value='R'".($m_arr['Reply']?" checked":"").">�n�D�l��Ū���^��
	�@�@<input type='checkbox' name='Reply' value='C'".($m_arr['Reply']?" checked":"").">�ǰe�ƥ����ۤv
	<BR>�D�@���G <input type='text' size=91 value='".$m_arr['Title']."' name='Mail_Title'>
	<BR>���@�e�G <textarea rows=10 name='Mail_Content' cols=90>".$m_arr['Content_Head']."\r\n".$m_arr['Content_Body']."\r\n".$m_arr['Content_Foot']."</textarea>
	<input type='submit' value='�o�e' name='BtnSubmit' onclick='return confirm(\"�u���n�o�e?\")'".(($teacher_array[$session_tea_sn]['email'] and $m_arr['SMTP_Server'])?"":" disabled").">
	</td></tr>";

echo $main."</form></table>$excuted";
if(!$remove_sfs3head) foot();
?>