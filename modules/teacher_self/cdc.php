<?php

// $Id:$

// --�t�γ]�w��
include "teach_config.php";
// --�B�zunicode�X�禡
include "my_fun.php";
// --�{�� session 
sfs_check();

head("���U�۵M�H����");
print_menu($teach_menu_p);
if ($CDCLOGIN) { ?>
<script type="text/javascript">
//<!--

function setForm(tname,pid,sn,pk){
	var thisForm = document.regform;
	thisForm.id4.value=pid;
	thisForm.serialnumber.value=sn;
	thisForm.pk.value=pk;
	thisForm.submit();
}
	
function doAlert(msg){
	alert(msg);
}
//-->
</script>
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  class=main_body >
<?php
if ($_POST['id4']) {
	$cdc = new CDC();
	$cdc->setCerSn($_POST['serialnumber']);
	$cdc->setCert($_POST['pk']);
	$cdc->readCert();

	if ($cdc->cert_status == "good") {
		$msg = openssl_x509_parse($cdc->cert);
		$FromTime = date("Y-m-d H:i:s",$msg['validFrom_time_t']);
		$ToTime = date("Y-m-d H:i:s",$msg['validTo_time_t']);
		//$TrueName = iconv("UTF-8","BIG5",$msg['subject']['CN']);
                //�Nutf-8�r���ରunicode�r��(�Y��big5�X���䴩��)
                $TrueName = utf8conv2charset($msg['subject']['CN']);
                
		$query="select * from teacher_base where teacher_sn='".$_SESSION['session_tea_sn']."'";
		$res=$CONN->Execute($query);
		$userdata=$res->FetchRow();

		if (substr(trim($userdata['teach_person_id']),-4,4) == $_POST['id4'] && trim($userdata['name']) == $TrueName) {
			$query="update teacher_base set cerno='".$_POST['serialnumber']."' where teacher_sn='".$_SESSION['session_tea_sn']."'";
			$res=$CONN->Execute($query);
			$msg = "�q�L�T�{, �n�����\!";
		} else
			$msg = '�u�d�����n���m�W�Ψ����Ҧr���P�b���n����Ƥ��šv!\n\n���q�L�ӤH����ˮ�, �L�k�i��n�� !';
	} elseif ($cdc->cert_status=="revoked") {
		$msg = "���Ҥw�o��!";
	} else
		$msg = "���ҵL�k����!";
}

?>
<tr><td>
<applet code="regCDC.class" archive="<?php echo $SFS_PATH_HTML;?>/getCDC.jar" width="340" height="70" MAYSCRIPT>
<param name="setForm" value="setForm">
<param name="doAlert" value="doAlert">
<param name="certtype" value="Sign">
<param name="fontsize" value="14">
<param name="fontname" value="�ө���">
<param name="ocsp" value="false">
</applet>
<form name="regform" id="regform" method="post" action="">
<input type="hidden" name="serialnumber" id="serialnumber" />
<input type="hidden" name="id4" id="id4" />
<input type="hidden" name="pk" id="pk" />
</form>
</td></tr>
<?php
$query="select * from teacher_base where teacher_sn='".$_SESSION['session_tea_sn']."'";
$res=$CONN->Execute($query);
$userdata=$res->FetchRow();
if ($userdata['cerno'])
	echo '<tr><td style="text-align: center; background-color: white;">���ҧǸ� : '.$userdata['cerno'].'</td></tr>';
else
	echo '<tr><td style="text-align: center; background-color: white; color: red;">�����U����</td></tr>';

echo '</table>';

if ($msg) echo '<br><span style="color: red; font-size: 14pt;">'.$msg.'<br><br>';

echo '
<table>
<tr bgcolor="#FBFBC4">
<td><img src="'.$SFS_PATH_HTML.'images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td>
</tr>
<tr><td style="line-height:150%;">
<ol>
<li class="small">�z�������w��<a href="http://www.sfs.project.edu.tw/modules/mydownloads/visit.php?cid=2&lid=47" target="new">�O�������ҵn�J����v0.4��</a>��<a href="http://gca.nat.gov.tw/download/HiCOSClient_v2.1.7.zip" target="new">HiCOS���Һ޲z�{��</a>, �Y�w�w�˹L�h�������Цw��</li>
<li class="small">���ҵ��U�u���b�Ĥ@���ϥΩξ��ҧ󴫮ɶi��Y�i</li>
</ol>
</td></tr></table>
';
} else echo '<H1 style="color: red;">���\�ॼ�ҥ�, �Ա��Ь��޲z��!</H1>';
foot();
?>