<?php

// $Id: sfs_case_installform.php 5351 2009-01-20 00:39:21Z brucelyc $
// ���N intall_form.php

$sfsname="sfs3";
$input_width="100%";
$delimit_color="#E5E5E5";
$sfs_url="http://sfs.wpes.tcc.edu.tw";


$sfshostname=$_SERVER['HTTP_HOST'];
$dirname=dirname($_SERVER['SCRIPT_NAME']);

$SFS_INSTALL_URL="http://".$sfshostname.$dirname;
if(substr($SFS_INSTALL_URL,-1,1)=="\\")$SFS_INSTALL_URL=substr($SFS_INSTALL_URL,0,-1);
if(substr($SFS_INSTALL_URL,-1,1)!="/")$SFS_INSTALL_URL.="/";


//$SFS_INSTALL_PATH=$_SERVER['DOCUMENT_ROOT'];
$Install_Path=$_SERVER['SCRIPT_FILENAME'];
$Install_dirName= pathinfo($Install_Path);
$SFS_INSTALL_PATH=$Install_dirName[dirname];

$SCHOOL_INSTALL_URL="http://".$sfshostname."/";
$GIP=explode(".",$_SERVER['SERVER_ADDR']);
$SCHOOL_IP=$GIP[0].".".$GIP[1].".".$GIP[2];
//$UPDATA_PATH={$_SERVER['DOCUMENT_ROOT']}."/$UPLOAD_PATH/";
$UPDATA_PATH=$SFS_INSTALL_PATH."/data/";
$sfsnameman=$sfsname."man";

echo <<<HERE
<html>
<head>
<script language="JavaScript">
<!--
function CHECK() {
  var chkf=document.inst.SFS_PATH.value;
  if (chkf.length==0) { document.inst.SFS_PATH.focus(); alert("�{���ڥؿ����|����ť�"); return false; }

  var chkf=document.inst.SFS_PATH_HTML.value;
  if (chkf.length==0) { document.inst.SFS_PATH_HTML.focus(); alert("�ǰȺ޲z�����{��URL����ť�"); return false; }

  var chkf=document.inst.HOME_URL.value;
  if (chkf.length==0) { document.inst.HOME_URL.focus(); alert("�Ǯխ���URL����ť�"); return false; }

  var chkf=document.inst.HOME_IP.value;
  if (chkf.length==0) { document.inst.HOME_IP.focus(); alert("�Ǯ�IP�d�򤣯�ť�"); return false; }

  var chkf=document.inst.mysql_host.value;
  if (chkf.length==0) { document.inst.mysql_host.focus(); alert("mysql�D������ť�"); return false; }

  var chkf=document.inst.mysql_adm_user.value;
  if (chkf.length==0) { document.inst.mysql_adm_user.focus(); alert("mysql�޲z�̤���ť�"); return false; }

  var chkf=document.inst.mysql_adm_pass.value;
  if (chkf.length==0) { document.inst.mysql_adm_pass.focus(); alert("mysql�޲z�̱K�X����ť�"); return false; }

  var chkf=document.inst.mysql_user.value;
  if (chkf.length==0) { document.inst.mysql_user.focus(); alert("mysql�ϥΪ̤���ť�"); return false; }

  var chkf=document.inst.mysql_pass.value;
  if (chkf.length==0) { document.inst.mysql_pass.focus(); alert("mysql�ϥΪ̱K�X����ť�"); return false; }

  var chkf=document.inst.mysql_db.value;
  if (chkf.length==0) { document.inst.mysql_db.focus(); alert("��Ʈw�W�٤���ť�"); return false; }

}
-->

</script>
<title>SFS3.0 �ǰȺ޲z�t�Φw�˵{�� ".$Install_Path."</title>
    <style type='text/css'>
    body,td{font-size: 12px}
    .small{font-size: 12px}
    </style>
</head>
<body bgcolor="white">
<div style="color:white ;font-size: 30px">
<b>SFS3.0 �ǰȺ޲z�t�Φw�˵{��</b>
</div>
<p></p>
<br>
<form name="inst" method="post" action="$_SERVER[SCRIPT_NAME]" onSubmit="return CHECK()">
<table border=0 align="center" cellspacing="0" cellpadding="1" bgcolor="#E5E5E5">
<tr><td>

<table border=0 align="center" cellspacing="0" cellpadding="3" bgcolor="#E5E5E5">
<tr bgcolor="#1E3B89">
<td colspan="4" nowrap>
<img src="images/logo.png" width="16" height="16" hspace="3" align="middle" border="0">
<font color="white">��Ʈw�H�Ψt�θ��|�����]�w</font></td>
</tr>

<tr bgcolor="$delimit_color">
<td rowspan="13" width=170 background="images/install_bg.jpg" style="size: 12px; color:white;line-height: 130%; " valign="top">
<font color="yellow"><b>SFS3.0 �ǰȨt�Φw�˻���</b></font>
<p>
�ݴ���MySQL �޲z�̪��b���K�X�A�H�K�۰ʫإ߸�Ʈw�A�ȩ�w�ˮɨϥΡC
</p>
<p>�Цۦ�]�w�@�աyMySQL �ϥΪ̡z���b���K�X�A�H�K���ǰȨt�Υi�H�s����Ʈw�C</p>
<p>
��L���A�t�η|�۰ʰ������͡A�Цۦ�d�ݭק�C
</p>
<p>
<img src="images/whatsnext.png" width=16 height=16 border=0>�G�������ݪ`�N�ƶ��C
<br>
<img src="images/help.png" alt="����" width=16 height=16 border=0>�G�����������C
</p>
<p>
�w�˫�A��MySQL �޲z�̪��b���K�X�H�~�A�Ҧ��ѼƧ��|�����binclude/config.php���C
</p>
</td>
<td><img src="images/checkboxdown.png" width=13 height=14 border=0></td><td nowrap>MySQL ��Ʈw�D����m</td>
<td><input type="text" name="mysql_host" value="localhost" style="width: $input_width"></td></tr>

<tr>
<td><img src="images/checkboxdown.png" width=13 height=14 border=0></td>
<td nowrap>MySQL �޲z�̱b��</td>
<td>
<input type="text" name="mysql_adm_user" value="root" size="15" style='background-color: #fbec8c;'>
�K�X�G<input type="password" name="mysql_adm_pass" value="" size="15" style='background-color: #fbec8c;'>
</td></tr>

<tr bgcolor="$delimit_color">
<td><img src="images/checkboxdown.png" width=13 height=14 border=0></td>
<td nowrap>�إ� MySQL �ϥΪ�</td>
<td><input type="text" name="mysql_user" value="$sfsnameman" size="15">
�K�X�G<input  type="password" name="mysql_pass" value="" size="15">
</td></tr>

<tr bgcolor="$delimit_color">
<td><img src="images/checkboxdown.png" width=13 height=14 border=0></td>
<td nowrap>��Ʈw�W��</td>
<td><input type="text" name="mysql_db" value="$sfsname" style="width: $input_width">
</td></tr>


<tr bgcolor="$delimit_color">
<td><img src="images/checkboxdown.png" width=13 height=14 border=0>
</td><td nowrap>�Q�լ��ꤤ�ΰ�p�H</td>
<td><input type="radio" name="SFS_JHORES" value="1" checked>��p &nbsp; &nbsp; <input type="radio" name="SFS_JHORES" value="2">�ꤤ &nbsp; &nbsp; <input type="radio" name="SFS_JHORES" value="3">����¾�H�W
</td></tr>

<!--�w�˫e�ǳưʧ@-->

<tr bgcolor="$delimit_color"><td><img src="images/checkboxdown.png" width=13 height=14 border=0></td>
<td nowrap>�ǰȺ޲z�t�Ϊ� URL
<a href="javascript:alert('�`�N�I�I\\nURL �����n�� /')"><img src="images/whatsnext.png" width=16 height=16 border=0></a>
</td>
<td><input type="text" name="SFS_PATH_HTML" value ="$SFS_INSTALL_URL" style="width: $input_width"></td>
</tr> 

<tr bgcolor="$delimit_color"><td><img src="images/checkboxdown.png" width=13 height=14 border=0></td>
<td nowrap>�Ǯխ��� URL</td>
<td><input type="text" name="HOME_URL" value="$SCHOOL_INSTALL_URL" style="width: $input_width"></td>
</tr>

<tr bgcolor="$delimit_color"><td><img src="images/checkboxdown.png" width=13 height=14 border=0></td>
<td nowrap>�Ǯ�IP �d��
<a href="javascript:alert('�h�� IP �d��]�w�A�ҡG\\n163.17.169,\\n163.17.168.1-163.17.169.128,\\n163.17.40.1')"><img src="images/help.png" alt="����" width=16 height=16 border=0></a>
</td>
<td><input type="text" name="HOME_IP" value="$SCHOOL_IP" style="width: $input_width"></td>
</tr>
<tr bgcolor="$delimit_color"><td><img src="images/checkboxdown.png" width=13 height=14 border=0></td>
<td nowrap>�{���ڥؿ����|</td>
<td>
<input type="text" name="SFS_PATH" value="$SFS_INSTALL_PATH" style="width: $input_width"></td></tr>

<!-- �w�d�N�Өϥ�
<tr><td nowrap>�O�_�ϥΤE�~�@�e�~�Ũ�? </td>
<td><input type="radio" name="SFS_ALL9INONE" value="1" checked>�O &nbsp; &nbsp; <input type="radio" name="SFS_ALL9INONE" value="0">�_</td></tr>
-->

<!-- default �Y�i -->
<!--�H�U�]�w�ϥιw�]�ȧY�i(�O�o�ؿ��n��ʶ}�])-->
<tr bgcolor="$delimit_color"><td><img src="images/checkboxdown.png" width=13 height=14 border=0></td>
<td nowrap>�W�ǥؿ���������|
<a href="javascript:alert('�`�N�I�I\\nURL �����n�� /')"><img src="images/whatsnext.png" width=16 height=16 border=0></a></td>
<td><input type="text" name="UPLOAD_PATH" value="$UPDATA_PATH" style="width: $input_width"></td></tr>

<tr bgcolor="$delimit_color"><td><img src="images/checkboxdown.png" width=13 height=14 border=0><td nowrap>
�W�ǥؿ����O�W (alias)
</td><td><input type="text" name="UPLOAD_URL" value="/upfiles/" style="width: $input_width"></td></tr>

<tr bgcolor="$delimit_color"><td><img src="images/checkboxdown.png" width=13 height=14 border=0><td nowrap>�W�Ǵ��}�l����G<input type="text" name="SFS_SEME1" value="8" size="2"></td>
<td nowrap>�U�Ǵ��}�l����G<input type="text" name="SFS_SEME2" value="2" size="2"></td></tr>


<tr>
<td colspan="4" nowrap align="right">
<input type="hidden" name="installsfs" value="yes_do_it_now">
<br>
<input type="submit" value="�}�l�w��">
</td>
</tr>

</table>
</td></tr></table><br>

</form>
</body>
</html>

HERE

?>
