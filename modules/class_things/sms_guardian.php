<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

//�q�X����
head("�ǰe²�T�ܾǥͺ��@�H��ʹq��");

$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id
//��X���ЯZ��
$class_name=teacher_sn_to_class_name($teacher_sn);
$class_id=$class_name[0];

print_menu($menu_p);
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

$action='�Ұʶǰe';
//�Ǵ��O
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
$my_sn=$_SESSION['session_tea_sn'];
$my_name=$_SESSION['session_tea_name'];

//�إߪ���
$SendGet = new SocketHttpRequest();
$usr=$_POST['usr'];
$pwd=$_POST['pwd'];
$sign_name=$m_arr['sign_name'];
$class_select=$m_arr['class_select'];
$smbody_posted=$_POST['smbody'];
$selected_stud=$_POST['selected_stud'];


//�d�߳Ѿl�I��
if($usr and $pwd){
$strOnlineSend = "http://www.smsgo.com.tw/sms_gw/query_point.asp?username=$usr&password=$pwd";
$fp = @fopen($strOnlineSend, "r");
$left_points=fread($fp,10);
fclose($fp);
} else $left_points='����';

if($selected_stud AND $_POST['act']==$action){
	$smbody=$smbody_posted;
	if($sign_name) $smbody.="\r\n".$my_name.' from SFS3';
	//�����ܪ��ǥ�
	$batch_value="";
	$pre_data="<br><font size=2 color='green'>���e���o�e�O���G<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber2'>
		<tr align='center' bgcolor='#ccccff'><td>NO.</td><td>²�T�Ǹ�</td><td>��H�W��</td><td>������X</td><td>²�T���e</td><td>���A</td><td>�ӥ��I��</td></tr>";
	$amount_limit=50; //²�T���q�����C���B�z�̤j�q
	$selected_student_array=array();
	$i=0;
	foreach($selected_stud as $key=>$dstaddr_combine)
	{
		//�N��ư}�C���ά�²�T���q�����C���B�z�̤j�q
		$selected_student_array[$i][]=$dstaddr_combine;		
		if($key=$amount_limit) $i=0; else $i++;	
	}

//echo "<pre>";
//print_r($selected_student_array);	
//echo "</pre>";

	foreach($selected_student_array as $group=>$group_data)
	{
		$dstaddr_list='';
		$value_list='';		
		foreach($group_data as $key=>$dstaddr_combine)
		{
			$dstaddr_combine_arr=explode("\r",stripslashes($dstaddr_combine));
//echo "<pre>";
//print_r($dstaddr_combine_arr);	
//echo "</pre>";			
			$dstaddr=$dstaddr_combine_arr[0];
			$DestName=$dstaddr_combine_arr[1];		
			$DestName_list.="$DestName,";
			$dstaddr_list.="$dstaddr,";

			$value_list.="('$curr_year_seme','{msgid}','{statuscode}','{point}','{statusstr}',now(),'$REMOTE_ADDR',$my_sn,0,'$usr','$dstaddr','$DestName','$dlvtime','$smbody_posted'),";
		}
		$dstaddr_list=substr($dstaddr_list,0,-1);
		$DestName_list=substr($DestName_list,0,-1);
		$value_list=substr($value_list,0,-1);
		
		//�o�e²�T�ܥ��s�դ�����X
		$url="http://www.smsgo.com.tw/sms_gw/sendsms.aspx?username=$usr&password=$pwd&dstaddr=$dstaddr_list&dlvtime=$dlvtime&smbody=".urlencode(iconv('big5','UTF-8',$smbody));
//echo "<br><br>$url<br><br>";
		$SendGet->HttpRequest($url); //�I�s������k
		$SendGet->sendRequest(); //�o�e		
		//�g�J��Ʈw�H�Ѭd��
		$response_str=$SendGet->getResponseBody();
		$response_str_array=explode("\n",$response_str);
//echo '<pre>';
//print_r($response_str_array);
//echo '</pre>';
		foreach($response_str_array as $key=>$value){
			$value_array=explode('=',$value);
			$response_array[$value_array[0]]=trim($value_array[1]);
		}
		
		$value_list=str_replace('{msgid}',$response_array['msgid'],$value_list);
		$value_list=str_replace('{statuscode}',$response_array['statuscode'],$value_list);
		$value_list=str_replace('{point}',$response_array['point'],$value_list);
		$value_list=str_replace('{statusstr}',$response_array['statusstr'],$value_list);
		
		$sql="INSERT INTO sms_smsgo_record(year_seme,msgid,statuscode,Point,statusstr,ask_time,ask_ip,teacher_sn,private,username,dstaddr,DestName,dlvtime,smbody) VALUES $value_list";
//echo "<br><br>$sql<br><br><br>";
		$recordSet=$CONN->Execute($sql) or user_error("�g�J��ƪ�O�����ѡI<br>$sql",256);

		$j++;			
		$status_message=$statuscodeArray[$response_array['statuscode']];
		$DestName_list=str_replace(',','<br>',$DestName_list);
		$dstaddr_list=str_replace(',','<br>',$dstaddr_list);
		$smbody=str_replace("\r\n",'<br>',$smbody);
		$pre_data.="<tr align='center'><td>$j</td><td>{$response_array[msgid]}</td><td align='left'>$DestName_list</td><td>$dstaddr_list</td><td align='left'>$smbody</td><td>$status_message</td><td>{$response_array[point]}</td></tr>";
	}
	$pre_data.="</table></font>";
}

/*
//��ܯZ��
if($class_select){
	$class_base=class_base($curr_year_seme);
	$class_list="����ܯZ�š�<br><select name='class_id' onchange='this.form.submit()'><option value=''></option>";
	foreach($class_base as $key=>$value){
			$selected=($class_id==$key)?'selected':'';
			$class_list.="<option value=$key $selected>$value</option>";	
	}
	$class_list.="</select>";
} else {
	$class_base=class_base($curr_year_seme);
	$class_list="<table border='2' cellpadding='6' cellspacing='0' style='border-collapse: collapse; font-size=9pt;' bordercolor='#111111' id='AutoNumber1' width='100%'>
	<tr><td align='center' bgcolor='#ccccff'>��ܯZ��</td></tr><tr><td>";
	foreach($class_base as $key=>$value){
			$selected=($class_id==$key)?'checked':'';
			$class_list.="<input type='radio' name='class_id' value='$key' onclick='this.form.submit()' $selected>$value<br>";	
	}
	$class_list.="</td></tr></table><br>";
}
 */

$class_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' id='AutoNumber1'><tr><td bgcolor='#ccffff'>�����ЯZ�š�</td></tr><tr><td align='center'>{$class_name[1]}</td></tr></table>";

$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><table><tr valign='top'><td>$class_list</td><td>";

if($class_id)
{
	//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
	$stud_select="SELECT a.student_sn,a.stud_name,a.curr_class_num,a.stud_sex,b.guardian_name,b.guardian_hand_phone FROM stud_base a left join stud_domicile b on a.student_sn=b.student_sn WHERE a.stud_study_cond=0 and a.curr_class_num like '$class_id%' ORDER BY a.curr_class_num";
	$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
	//�Hcheckbox�e�{
	$col=6; //�]�w�C�@�C��ܴX�H
	
	$studentdata="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>
				<tr bgcolor='#ccffff'><td colspan=$col align='center'>
				<input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'>�ǰe��H
				</td></tr>";
	while(list($student_sn,$stud_name,$curr_class_num,$stud_sex,$guardian_name,$guardian_hand_phone)=$recordSet->FetchRow()) {
		if($recordSet->currentrow() % $col==1) $studentdata.="<tr align='center'>";
		$seme_num=sprintf('%02d',substr($curr_class_num,-2));
		$stud_sex_color=($stud_sex==1)?"#CCFFCC":"#FFCCCC";
		$guardian_hand_phone=str_replace('-','',$guardian_hand_phone);  //�קK�|��J-�������j���ߺD���D
		$guardian_hand_phone=intval($guardian_hand_phone);
		if(!$guardian_hand_phone) {
			$studentdata.="<td bgcolor='#CCCCCC'>($seme_num)$stud_name<br><font size=2 color='gray'>[$guardian_name]</font></td>";
		} else {
			$guardian_hand_phone='0'.$guardian_hand_phone;
			$DestName=$curr_class_num.$stud_name.'�����@�H';
			$studentdata.="<td bgcolor='$stud_sex_color'><input type='checkbox' name='selected_stud[]' value='{$guardian_hand_phone}\r{$DestName}'>($seme_num)$stud_name<br><font size=2 color='blue'>[$guardian_name][$guardian_hand_phone]</font></td>";
		}
		if($recordSet->currentrow() % $col==0  or $recordSet->EOF) $studentdata.="</tr>";
	}
	$col=$col-3;
	
	$studentdata.="</table><br><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'><tr align='center' bgcolor='#ccffff'><td colspan=3>�ϥλ���</td><td colspan=$col>²�T���e</td></tr>
		<tr bgcolor='#ffffcc'>
		<td colspan=3>
		<font color='brown' size=2>
			<li>���{���Ȥ䴩SMSGO²�T�N�o�A�ϥΫe�����w��sms_smsgo�Ҳըè��o�b���C</li>
                        <li>�e���o�e�ϥΪ��b���G$usr �F �Ѿl�I�ơG $left_points �C</li>
			<li>�C��²�T���סG70�Ӥ���r�άO160�ӭ^�Ʀr�C</li>
			<li>�o�e�e�Х��˵��e���o�e�O���A�קK���Ƶo�e�C</li>
			<li>�o�e���C��²�T�A���ݭn������X�A�Ъ`�N�����įq�C</li>
			<li>������ܬ��Ƕ¦⪺�ǥ͡A�Y����@�H��ƥ��n�O��ʹq�ܩεn�����~�C</li>
		</font>
		</td>
		<td colspan=$col' align='center'>
                    ���b���G<input type='text' name='usr' value='$usr'>�@���K�X�G<input type='password' name='pwd' value='$pwd'></font><br>
		<textarea name='smbody' rows=4 cols=40>$smbody_posted</textarea>
		<input type='submit' value='$action' name='act' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:20px; height=66'></td></tr></table>";
}

echo $main.$studentdata."<font size=2 color='green'>$pre_data</font></td></tr></table></form>";
foot();

class SocketHttpRequest
{
    var $sHostAdd;
    var $sUri;
    var $iPort;  
    var $sRequestHeader; 
    var $sResponse;
   
    function HttpRequest($sUrl)
    {
        $sPatternUrlPart = '/http:\/\/([a-z-\.0-9]+)(:(\d+)){0,1}(.*)/i';
        $arMatchUrlPart = array();
        preg_match($sPatternUrlPart, $sUrl, $arMatchUrlPart);
       
        $this->sHostAdd = gethostbyname($arMatchUrlPart[1]);
        if (empty($arMatchUrlPart[4]))
        {
            $this->sUri = '/';
        }
        else
        {
            $this->sUri = $arMatchUrlPart[4];
        }
        if (empty($arMatchUrlPart[3]))
        {
            $this->iPort = 80;
        }
        else
        {
            $this->iPort = $arMatchUrlPart[3];
        }
       
        $this->addRequestHeader('Host: '.$arMatchUrlPart[1]);
        $this->addRequestHeader('Connection: Close');

    }
   
    function addRequestHeader($sHeader)
    {
        $this->sRequestHeader .= trim($sHeader)."\r\n";
    }
   
    function sendRequest($sMethod = 'GET', $sPostData = '')
    {
        $sRequest = $sMethod." ".$this->sUri." HTTP/1.1\r\n";
        $sRequest .= $this->sRequestHeader;
        if ($sMethod == 'POST')
        {
            $sRequest .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $sRequest .= "Content-Length: ".strlen($sPostData)."\r\n";
            $sRequest .= "\r\n";
            $sRequest .= $sPostData."\r\n";
        }
        $sRequest .= "\r\n";
       
        $sockHttp = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$sockHttp)
        {
            die('socket_create() failed!');
        }
       
        $resSockHttp = socket_connect($sockHttp, $this->sHostAdd, $this->iPort);
        if (!$resSockHttp)
        {
            die('socket_connect() failed!');
        }
       
        socket_write($sockHttp, $sRequest, strlen($sRequest));
       
        $this->sResponse = '';
        while ($sRead = socket_read($sockHttp, 4096))
        {
            $this->sResponse .= $sRead;
        }
       
        socket_close($sockHttp);
    }
   
    function getResponse()
    {
        return $this->sResponse;
    }
   
    function getResponseBody()
    {
        $sPatternSeperate = '/\r\n\r\n/';
        $arMatchResponsePart = preg_split($sPatternSeperate, $this->sResponse, 2);
        return $arMatchResponsePart[1];
    }
}
?>