<?php

//$Id: cal_email.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
include_once "cal_elps_class.php";

$sel_week=$_POST[sel_week]?$_POST[sel_week]:1;
$syear=sprintf("%03d%d",curr_year(),curr_seme());
$_REQUEST[syear]=$syear;

sfs_check();

	
//���o�ҲհѼƪ����O�]�w
$m_arr = get_module_setup("elps_cal");
extract($m_arr,EXTR_OVERWRITE);

$Tr_BGColor=$m_arr['Tr_BGColor'];

class cal_index extends cal_elps{
	//��l��
	function init() {
		$this->seme=$_REQUEST[syear];	
	}
	//�{��
	function process() {
		$this->init();
		$this->get_all_set();//�������Ǵ���ƾ�]�w
		$this->get_use_set();//���ϥΤ���ƾ�]�w
		//$this->get_all_event();//�[�J�Ҧ���Ƹ��
		//$this->all();
	}
}
//�إߪ���
$obj= new cal_index();
$obj->CONN=&$CONN;
$obj->process();

//���
$week_select="��ܶg���G<select name='sel_week' onchange='this.form.submit();'>";
foreach($obj->WK as $week=>$value){
	if($week==$sel_week){
		$selected='selected';
		$curr_week="�� $week �g($st_day ~ $en_day)";
	} else $selected='';
	$st_day=$value[st_day];
	$en_day=$value[en_day];
	$week_select.="<option $selected value=$week>�� $week �g($st_day ~ $en_day)</option>";
}
$week_select.="</select>";

//���o�Юv�����Ҧr��
$session_tea_sn = $_SESSION['session_tea_sn'];

//���o��¾��¾�٦C��
$title_array=array();
$query ="select * from teacher_title";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
while(!$result->EOF)
{
	$title_array[$result->fields[teach_title_id]]=$result->fields[title_name];
	$result->MoveNext();
}

//���o��¾���m�W�P�s��
$teacher_array=array();
$query ="select a.teacher_sn,a.teach_id,a.name,a.teach_condition,b.teach_title_id from teacher_base a,teacher_post b where a.teach_condition=0 and a.teacher_sn=b.teacher_sn";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
while(!$result->EOF)
{
	$teacher_array[$result->fields[teacher_sn]]['name']=$result->fields[name];
	$teacher_array[$result->fields[teacher_sn]]['title']=$title_array[$result->fields[teach_title_id]];

	$result->MoveNext();
}

//���o��¾��email �[�J$teacher_array��
$query ="select * from teacher_connect";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
while(!$result->EOF)
{
	if(array_key_exists($result->fields[teacher_sn],$teacher_array)) $teacher_array[$result->fields[teacher_sn]]['email']=$result->fields[email];
	$result->MoveNext();
}


//�q�X����
head("�հȦ�ƶl��q��");

echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='item_selected[]') {
      	if(! document.myform.elements[i].disabled){
	document.myform.elements[i].checked=status; }
    }
    i++;
  }
}
</script>
HERE;

if($_POST['BtnSubmit']=='�o�e' and $_POST['item_selected']){
	
	$Mail_Content=$_POST['Mail_Content'];
	$Cc_Send=$m_arr['Cc_Send'];
	$Reply=$m_arr['Reply'];
	$event_data=$_POST['event_data'];
	
	//�]�wSMTP
	ini_set("sendmail_from",$teacher_array[$session_tea_sn]['title']."-".$teacher_array[$session_tea_sn]['name']."<".$teacher_array[$session_tea_sn]['email'].">");
	ini_set("SMTP",$m_arr['SMTP_Server']);
	ini_set("smtp_port",$m_arr['SMTP_Port']);
	
	$excuted="<BR>�� �e���H��H�e�����G�p�U��<BR><BR>";
	$item_selected=$_POST[item_selected];
	foreach($item_selected as $item){
		$item_arr=explode('@#@',$item);
		//���H�H�l��
		$to=$item_arr[1];
		if($to){
			//�l��D��
			$subject =$_POST['Mail_Title'];

			//�l�󤺮e
			$message =str_replace('{{teacher}}',$item_arr[0],$Mail_Content);
			//$message =str_replace('{{content}}',$event_data,$message);
			$message =str_replace('{{sender}}',$teacher_array[$session_tea_sn]['title'].' '.$teacher_array[$session_tea_sn]['name'],$message);
			
			/* To send HTML mail, you can set the Content-type header. */
			$headers  = "MIME-Version: 1.0\r\n";
			//$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "Content-type: text/html;\r\n";

			/* additional headers */
			$manager_mail=$teacher_array[$session_tea_sn]['title']."-".$teacher_array[$session_tea_sn]['name']."<".$teacher_array[$session_tea_sn]['email'].">\r\n";
			$headers.="To: ".$item_arr[0]."<$to>\r\n";
			$headers.="From: $manager_mail";
			$headers.="Reply-To: $manager_mail";
			$headers.="Return-Path: $manager_mail";

			if($Reply) {
				$headers.="Disposition-Notification-To: $manager_mail";
			}
			
			if($Cc_Send) {
				$headers .= "Cc: $manager_mail";
			}
			/* and now mail it */
			if(mail($to, $subject, $message, $headers)) {
				$excuted.=date("h:i:s A")." �H��w���\�H�� ".$item_arr[0]."($to)<BR>";
			} else {
				$excuted.=date("h:i:s A")." �H�� ".$item_arr[0]."($to) ���H�󥢱�!!<BR>";
			}
		}
	}
}

//��V������
$linkstr="syear=$syear";
echo print_menu($school_menu_p,$linkstr);

$main="<form name='myform' method='post' action='$_SERVER[PHP_SELF]'>";

//�Ǵ��]�w
$SQL="select * from cal_elps_set order by sday desc ";
$res=$CONN->Execute($SQL) or user_error("�����ƾ���]�w���ѡI<br>$SQL",256);
if($res->RecordCount()==0){ echo "�Ǵ���ƾ���|���]�w!!"; exit; }

//��ܼ��D
$main.="<table style='font-size:10pt;' align=center border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>";
if($m_arr['Show_Event'])  $main.="<tr bgcolor='$Tr_BGColor'>
				<td align='center'>���</td>
				<td align='center'>���</td>
				</tr>";	

//��Ƨ��
$event_data='';
$SQL="select * from cal_elps where syear='$syear' and week=$sel_week order by unit";
$res=$CONN->Execute($SQL) or user_error("�^����Ƹ�ƥ��ѡI<br>$SQL",256);
while(!$res->EOF) {
		$unit=$res->fields[unit];
		$event=$res->fields[event];
		if($m_arr['Show_Event']) $main.="<tr><td>$unit</td><td>$event</td><td></td></tr>";
		$event_data.="\r\n�� $event ($unit)";
		$res->MoveNext();
}


$main.="<tr bgcolor='$Tr_BGColor'><td colspan=2>�H�e��H (<input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'>���� )</td></tr><tr><td colspan=2>";
foreach($teacher_array as $sn=>$value){
	//��X�e��
	$name=$value['name'];
	$title=$value['title'];
	$email=$value['email'];
	$item_post_data=$title."-".$name.'@#@'.$email;
	$main.="<input type='checkbox' name='item_selected[]' value='$item_post_data'".($email?'':' disabled').">$title-$name ";
}
$main.="</td></tr>";
//���N���e
$m_arr['Content_Body']=str_replace('{{content}}',$event_data,$m_arr['Content_Body']);
$m_arr['Content_Body']=str_replace('{{week}}',$curr_week,$m_arr['Content_Body']);


$main.="<tr bgcolor='$Tr_BGColor'><td colspan=4>
	�o�H�H�G ".$teacher_array[$session_tea_sn]['title']."-".$teacher_array[$session_tea_sn]['name']." (".$teacher_array[$session_tea_sn]['email'].")
	�@�@<input type='checkbox' name='Reply' value='R'".($m_arr['Reply']?" checked":"").">�n�D�l��Ū���^��
	�@�@<input type='checkbox' name='Cc_Send' value='C'".($m_arr['Cc_Send']?" checked":"").">�ǰe�ƥ����ۤv
	<BR>�D�@���G <input type='text' size=91 value='".$m_arr['Title']."' name='Mail_Title'>
	<BR>���@�e�G <textarea rows=10 name='Mail_Content' cols=70>".$m_arr['Content_Head']."\r\n\r\n".$m_arr['Content_Body']."\r\n\r\n".$m_arr['Note']."\r\n\r\n".$m_arr['Content_Foot']."</textarea>
	<input type='hidden' name='event_data' value='$event_data'>
	<input type='submit' value='�o�e' name='BtnSubmit' onclick='return confirm(\"�u���n�o�e?\")'".(($teacher_array[$session_tea_sn]['email'] and $m_arr['SMTP_Server'])?"":" disabled").">
	</td></tr>";
echo $main.$week_select."</form></table>$excuted";

foot();
?>