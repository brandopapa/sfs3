{{* $Id: edu_chart_login_edu_select.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}

<script>
<!--
function go() {
	document.base_form.submit();
	window.open("login_edu_page.php","select");
}
//-->
</script>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	<form name ="base_form" enctype="multipart/form-data" action="login_edu_main.php" method="post" target="main">
    <td width="100%" valign=top bgcolor="#CCCCCC">
		<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			<tr>
				<td class="title_sbody1">�п�J�ǮեN�X</td>
				<td><input type="text" name="sch_id" value="{{$sch_id}}"></td>
			</tr>
			<tr>
				<td class="title_sbody1">�п�J�K�X</td>
				<td><input type="password" name="login_pass" value=""></td>
			</tr>
			<tr>
	    	<td width="100%" align="center" colspan="2" >
				<input type=button name="do_key" value =" �T�w�n�J " OnClick="javascript:go();"></td>
			</tr>
		</table>
	</tr>
	</form>
</table>
{{if $smarty.post.data_id=="" || $smarty.post.data_id==0}}
<table>
<tr bgcolor='#FBFBC4'><td><img src="{{$SFS_PATH_HTML}}/images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td></tr>
<tr><td style="line-height: 150%;">
<ol>
<li class="small">�п�J�y�w�����ȳ���z�����@�~����t�Τ��K�X�C</a></li>
<li class="small">�t�η|�����a�X�Q�զb�u�Ǯճ]�w�v���ҳ]�w���ǮեN�X�A�Y�����~�Х��󥿡C</a></li>
</ol>
</td></tr>
</table>
{{/if}}
