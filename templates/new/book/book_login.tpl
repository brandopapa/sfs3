{{* $Id: book_login.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/book_header.tpl"}}

<body  onload="setfocus()">
<script language="JavaScript">
<!--
function setfocus() {
      document.checkid.log_id.focus();
      return;
 }
-->
</script>
<table width="100%" style="border: 1px solid #5F6F7E; border-collapse:collapse;"><tr><td align="center" bgcolor='#DDFF78'>
<p>&nbsp;</p>
<form action='{{$SFS_PATH_HTML}}login.php' method='post' name='checkid'>
<table width='290' height='136' cellspacing='0' cellpadding='2' align='center' background='http://127.0.0.1/sfs3/themes/new/images/login_bg.png'>
<tr><td><br>
<table cellspacing='0' cellpadding='3' align='center'>
<tr class='small'>
<td nowrap>��J�N��</td>
<td nowrap><input type='text' name='log_id' size='20' maxlength='15'></td>
</tr>
<tr class='small'>
<td nowrap>��J�K�X</td>
<td nowrap><input type='password' name='log_pass' size='20' maxlength='15'></td>
</tr>
<tr class='small'>
<td nowrap>�n�J����</td>
<td nowrap>
	<select name='log_who'>
	<option value='�Юv' selected>�Юv</option>
	<option value='�a��'>�a��</option>
	<option value='�ǥ�'>�ǥ�</option>
	<option value='��L'>��L</option>
	</select>
	<input type='submit' value='�T�w' name='B1'>
</td>
</tr>
</table>
<input type='hidden' name='go_back' value=''>
</td></tr>
</table>
</form>
<p align="center">
<font size="2">�����A�Ȼ��ˬd�޲z�N���K�X�A �Y�ѰO�A�Ь��t�κ޲z�̡C</font>
<a href="javascript:history.back()">�^�W��</a>
</p><p></p>
</td></tr></table>
{{include file="$SFS_TEMPLATE/book_footer.tpl"}}