<body <?php if (!$_REQUEST['cdc']) {?>onload="setfocus()"<?php } ?>>
<!-- $Id: new_login.php 7938 2014-03-18 03:39:09Z hsiao $ -->
<script language="JavaScript">
<!--
function setfocus() {
      document.checkid.log_id.focus();
      return;
}

function setForm(tname,pid,encryptstr,sn,pk){
	var thisForm = document.checkid;
	thisForm.id4.value=pid;
	thisForm.serialnumber.value=sn;
	thisForm.encrypted.value=encryptstr;
	thisForm.pk.value=pk;
	thisForm.submit();
}

function doAlert(msg){
        alert(msg);
}
<?php if($_SESSION['CAPTCHA']['TYPE']==1) {?>

var IE = document.all?true:false;
if (!IE) document.captureEvents(Event.MOUSEMOVE);
document.onclick = getMouseXY;
var tempX = 0;
var tempY = 0;
function getMouseXY(e) {
  if (IE) { // grab the x-y pos.s if browser is IE
    tempX = event.clientX + document.body.scrollLeft;
    tempY = event.clientY + document.body.scrollTop;
  } else {  // grab the x-y pos.s if browser is NS
    tempX = e.pageX;
    tempY = e.pageY;
  }
  // catch possible negative values in NS4
  if (tempX < 0){tempX = 0}
  if (tempY < 0){tempY = 0}
  var objs = document.getElementById("KIMG");
  var x = objs.offsetLeft;
  var y = objs.offsetTop;
  for ( var i = 1; i < 9; i++) {
    newobjs = objs.offsetParent;
	if (newobjs) {
		x += newobjs.offsetLeft;
		y += newobjs.offsetTop;
		objs = newobjs;
	} else
	  break;
  }
  document.getElementById("KIMG").src = "<?php echo $SFS_PATH_HTML; ?>kitten_img.php?x="+(tempX-x)+"&y="+(tempY-y)+"&t="+Math.random();

  ajaxGetValue("nums", "num=1");
  return true;
}

function ajaxGetValue(id, val) {
  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {// code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { //�Ǧ^�ȬO�T�w�g�k
      document.getElementById(id).innerHTML = xmlhttp.responseText; //[�̫�]��select�X�Ӫ���� �Ǧ^�e�����w��html��m
    }
  }

  xmlhttp.open("GET", "<?php echo $SFS_PATH_HTML; ?>kitten_img.php?"+val, false);
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send();

  return true;
}
<?php } ?>
 -->
</script>
<p></p>
<?php
//Ū���U�ب������n�J�Ҧ�
$E[0]="�����n�J";
$E[1]="LDAP�n�J";
  		$query="select * from ldap limit 1";
  		$res=$CONN->Execute($query); // or die('Error! SQL='.$query);  
  		if (!$res) {
  			$LDAP['enable']=0;
  		} else {
  			$LDAP=$res->fetchrow();  
  		}
  		
if ($_REQUEST['cdc'])
	echo login_form3();
else {
	if (chk_login_img("","",1))
		echo login_form();
	else
		echo login_form2();
}
?>

<Script>
//�Юv
$('#logwho_0').click(function(){
  $('#LoginMode').html('<?php echo $E[$LDAP['enable']];?>');
})

//�ǥ�
$('#logwho_1').click(function(){
  $('#LoginMode').html('<?php echo $E[$LDAP['enable1']];?>');
})

//�a��
$('#logwho_2').click(function(){
  $('#LoginMode').html('�����n�J');
})

//��L
$('#logwho_3').click(function(){
  $('#LoginMode').html('�����n�J');
})

</Script>
<?php
if ($_REQUEST['cdc']) { ?>
<p align="center">
<font size="2">�����A�Ȼ��ˬd���ҡA�Y������ðݽЬ��t�κ޲z�̡C</font>
<a href="javascript:history.back()">�^�W��</a>
</p>
<?php } else { ?>
<p align="center">
<font size="2">�����A�Ȼ��ˬd�޲z�N���K�X�A�Y�ѰO�A�Ь��t�κ޲z�̡C</font>
<a href="javascript:history.back()">�^�W��</a>
</p>
<?php }
function login_who_radio($checked='�Юv')
{
	$arr = array('�Юv','�ǥ�','�a��','��L');
	$str = '';
	foreach ($arr as $id=>$val) {
		$str .= "<input id='logwho_$id'  type='radio' name='log_who' value='$val' ";
		if ($checked == $val)
			$str.= "checked='checked'";
		$str .= " /> <label for='logwho_$id'>$val</label>"; 
	}
	return  $str;
}

function login_form(){
     global $SFS_PATH_HTML, $go_back,$CONN,$TaiChung_OpenID;
     
     //�ˬd�O�_�ҥ� LDAP �n�J�Ҳ�
    $query="select * from sfs_module where dirname='ldap' and islive='1'";
  	$res=$CONN->Execute($query) or die('Error! SQL='.$query);;
     if ($res->RecordCount()>0) {
  		$query="select * from ldap limit 1";
  		$res=$CONN->Execute($query); // or die('Error! SQL='.$query);  
  		if (!$res) {
  			$LDAP['enable']=0;
  		} else {
  			$LDAP=$res->fetchrow();  
  		}
     } else {
      $LDAP['enable']=0;
     }
     
     if (isset($_POST['log_who']))
     	$logStr = login_who_radio($_POST['log_who']);
    else     	
     $logStr = login_who_radio();
     $logMode=($LDAP['enable'])?"LDAP�n�J":"�����n�J";
     $Form = "
	<form action='" . $SFS_PATH_HTML . "login.php' method='post'  name='checkid'>
	<table style='width:100%;'>
	<tr><td style='text-align:center;padding:15px;'>
	<div  class='ui-widget-header ui-corner-top'  style='width:350px; padding:5px; margin:auto'>
	<span style='text-align:center;'>�n�J�ˬd</span>
	</div>
	<div  class='ui-widget-content ui-corner-bottom'  style='width:350px; padding:5px; margin:auto'>
	<table cellspacing='0' cellpadding='3' align='center'>
	<tr class='small'>
	<td nowrap>��J�N��</td><td nowrap>
	<input type='text' name='log_id' size='20' maxlength='15'>
	</td>
	</tr>
	<tr class='small'>
	<td nowrap>��J�K�X</td>
	<td nowrap>
	<input type='password' name='log_pass' size='20' maxlength='15'>
	</td>
	</tr>
	<tr class='small'>
	<td nowrap>�n�J����</td>
	<td>
	$logStr 
	</td>
	</tr>
	<tr class='small'>
	<td nowrap>�{�ҼҦ�</td>
	<td>
	<table border='1' cellspacing='1' cellpadding='1' style='border-collapse:collapse' bordercolor='#111111'>
	<tr class='small'><td id='LoginMode'>$logMode</td></tr> 
	</table>
	</td>
	</tr>
	<tr>
	<td  colspan='2' style='text-align:center'>
		<input type='submit' value='�T�w' name='B1'>
	</td>
	</tr>
	</table>
  	<input type='hidden' name='go_back' value='$go_back'>
	</div>
	</td>
	</tr>
	</table>
	</form>
	";
			if ($TaiChung_OpenID==1) {
	 
	 $Form.="
	 <br>
	  <div style=\"border-width:1px; border-color:black;  padding:3px; font-size:15px;\">
	   <center>
	   <table border='0'>
	   <tr>
	   <td style='color:#0000FF'>���������\�ϥλO�����Ш|���b���n�J</td>
	   </tr>
	   <tr>
	   <td>
      <form method=\"get\" action=\"include/OIDpackage/authcontrol.php\">
        �п�J�A���O�����Ш|�����ȱb��<br />
        <input type=\"hidden\" name=\"action\" value=\"verify\" />
        <input type=\"hidden\" name=\"domain\" value=\"tc\" />
        <span style=\"color:#777;\">http://<input type=\"text\" name=\"openid_identifier\" value=\"\" size=\"12\" maxlength=\"16\" />.openid.tc.edu.tw</span>
        <input type=\"submit\" value=\" �H���ȱb���n�J \" />
      </form>
      </td></tr>
      <tr>
       <td style='color:#700000;font-size:9pt'>���`�N:<br/>1.���Юv�����C<br/>2.�ǰȨt�Τ��������Ҧr����ưȥ����T�~�ॿ�`�n�J!</td>
      </tr>
      </table>
      </center>
    </div>

	 ";	
	} // end if ($TaiChung_OpenID==1)

     return $Form;
     }

     
     
     
function login_form2(){
     global $SFS_PATH_HTML, $go_back,$CONN,$TaiChung_OpenID;

     //�ˬd�O�_�ҥ� LDAP �n�J�Ҳ�
    $query="select * from sfs_module where dirname='ldap' and islive='1'";
  	$res=$CONN->Execute($query) or die('Error! SQL='.$query);;
     if ($res->RecordCount()>0) {
  		$query="select * from ldap limit 1";
  		$res=$CONN->Execute($query); // or die('Error! SQL='.$query);  
  		if (!$res) {
  			$LDAP['enable']=0;
  		} else {
  			$LDAP=$res->fetchrow();  
  		}
     } else {
      $LDAP['enable']=0;
     }


     $logStr = login_who_radio();
     $logMode=($LDAP['enable'])?"LDAP�n�J":"�����n�J";

	$Form = "
	<form action='" . $SFS_PATH_HTML . "login.php' method='post'  name='checkid'>
	<table style='width:100%;' id='loginTable'>
	<tr><td style='text-align:center;padding:15px;'>
	<div  class='ui-widget-header ui-corner-top'  style='width:350px; padding:5px; margin:auto'>
	<span style='text-align:center;'>�n�J�ˬd</span>
	</div>
	<div  class='ui-widget-content ui-corner-bottom'  style='width:350px; padding:5px; margin:auto'>
	<table cellspacing='0' cellpadding='3' align='center'>
	<tr class='small'>
	<td nowrap>��J�N��</td><td nowrap>
	<input type='text' name='log_id' size='20' maxlength='15'>
	</td>
	</tr>
	<tr class='small'>
	<td nowrap>��J�K�X</td>
	<td nowrap>
	<input type='password' name='log_pass' size='20' maxlength='15'>
	</td>
	</tr>" . (($_SESSION['CAPTCHA']['TYPE']==1)?
	"<tr class='small'><td>�p������<td>���I��Ϥ����Ⱖ�p��</td></tr>
	<tr class='small'><td colspan='2'>
	<img src='".$SFS_PATH_HTML."kitten_img.php' style='vertical-align:middle;' id='KIMG'>
	</td></tr>
	<tr class='small'><td colspan='2' style='text-align: center;'>�z�ثe��ܤF <span id='nums'>0</span> ���ʪ�</td></tr>":
	"<tr class='small'>
	<td nowrap>��J����X</td>
	<td nowrap>
	<img src='".$SFS_PATH_HTML."pass_img.php' style='vertical-align:middle;' name='PIMG'>
	<input type='text' name='log_pass_chk' size='4' maxlength='15'>
	</td>") .
	"</tr>
	<tr class='small'>
	<td nowrap>�n�J����</td>
	<td>
	$logStr 
	</td>
	</tr>
	<tr class='small'>
	<td nowrap>�{�ҼҦ�</td>
	<td>
	<table border='1' cellspacing='1' cellpadding='1' style='border-collapse:collapse' bordercolor='#111111'>
	<tr class='small'><td id='LoginMode'>$logMode</td></tr> 
	</table>
	</td>
	</tr>
	<tr>
	<td  colspan='2' style='text-align:center'>
	<input type='submit' value='�T�w' name='B1'>
	<input type='button' value='������' onclick=\"PIMG.src='".$SFS_PATH_HTML."pass_img.php?'+ Math.random();\">
	</td>
	</tr>
	</table>
	</div>
	</td></tr></table>
	<input type='hidden' name='go_back' value='$go_back'>
	
	</form>
	";
			if ($TaiChung_OpenID==1) {
	 
	 $Form.="
	 <br>
	  <div style=\"border-width:1px; border-color:black;  padding:3px; font-size:15px;\">
	   <center>
	   <table border='0'>
	   <tr>
	   <td style='color:#0000FF'>���������\�ϥλO�����Ш|���b���n�J</td>
	   </tr>
	   <tr>
	   <td>
      <form method=\"get\" action=\"include/OIDpackage/authcontrol.php\">
        �п�J�A���O�����Ш|�����ȱb��<br />
        <input type=\"hidden\" name=\"action\" value=\"verify\" />
        <input type=\"hidden\" name=\"domain\" value=\"tc\" />
        <span style=\"color:#777;\">http://<input type=\"text\" name=\"openid_identifier\" value=\"\" size=\"12\" maxlength=\"16\" />.openid.tc.edu.tw</span>
        <input type=\"submit\" value=\" �H���ȱb���n�J \" />
      </form>
      </td></tr>
      <tr>
       <td style='color:#700000;font-size:9pt'>���`�N:<br/>1.���Юv�����C<br/>2.�ǰȨt�Τ��������Ҧr����ưȥ����T�~�ॿ�`�n�J!</td>
      </tr>
      </table>
      </center>
    </div>

	 ";	
	} // end if ($TaiChung_OpenID==1)

	return $Form;
}

function login_form3(){
     global $SFS_PATH_HTML, $go_back,$CONN;

     //�ˬd�O�_�ҥ� LDAP �n�J�Ҳ�
    $query="select * from sfs_module where dirname='ldap' and islive='1'";
  	$res=$CONN->Execute($query) or die('Error! SQL='.$query);;
     if ($res->RecordCount()>0) {
  		$query="select * from ldap limit 1";
  		$res=$CONN->Execute($query); // or die('Error! SQL='.$query);  
  		if (!$res) {
  			$LDAP['enable']=0;
  		} else {
  			$LDAP=$res->fetchrow();  
  		}
     } else {
      $LDAP['enable']=0;
     }

     $logStr = login_who_radio();
	
	$Form = "
	<table style='width:100%;'>
	<tr><td style='text-align:center;padding:15px;'>
	<div  class='ui-widget-header ui-corner-top'  style='width:350px; padding:5px; margin:auto'>
	<span style='text-align:center;'>�n�J�ˬd</span>
	</div>
	<div  class='ui-widget-content ui-corner-bottom'  style='width:350px; padding:5px; margin:auto'>
	
	<form action='" . $SFS_PATH_HTML . "login.php' method='post'  name='checkid' id='cerloginform'>
	<table cellspacing='0' cellpadding='3' align='center'>
	<tr style='height: 8pt;'><td></td></tr>
	<tr><td>
	<applet code='getCDC.class' archive='".$SFS_PATH_HTML."/getCDC.jar' width='320' height='80' MAYSCRIPT>
	<param name='setForm' value='setForm'>
	<param name='doAlert' value='doAlert'>
	<param name='encrypt' value='".$_SESSION['ToBeSign']."'>
	<param name='certtype' value='Sign'>
	<param name='fontsize' value='14'>
	<param name='fontname' value='�ө���'>
	<param name='ocsp' value='false'>
	</applet>
	<input type='hidden' name='encrypted' id='encrypted' />
	<input type='hidden' name='serialnumber' id='serialnumber' />
	<input type='hidden' name='id4' id='id4' />
	<input type='hidden' name='pk' id='pk' />
	<input type='hidden' name='cdc' value='1' />
	<input type='hidden' name='go_back' value='$go_back'>
	<span class='small'> &nbsp; &nbsp; �n�ϥΦ۵M�H���ҵn�J, �z���� :<br> &nbsp; 1.  �w��<a href='http://gca.nat.gov.tw/download/HiCOSClient_v2.1.8.zip' target='new'>HiCOS���Һ޲z�{��</a>��<a href='http://www.sfs.project.edu.tw/modules/mydownloads/visit.php?cid=2&lid=47'>�O�����F���Ш|�����ҵn�J����v0.3��</a><br> &nbsp; 
	2. <a href='{$SFS_PATH_HTML}modules/teacher_self/'>���U�۵M�H����</a></span>
	</td></tr></table>
	</form>
	</div>
	</td>
	</tr>
	</table>
	";
	$str = '';
	if (isset($_GET['cdc_error']) and $_GET['cdc_error']==1) {
		$str = '<script>alert("�z�|�����U���ҡA�Х��Ѥ@��n�J��A�i�J�Юv�ӤH��ơA���U����");</script>';
	}
	return $Form.$str;
}
