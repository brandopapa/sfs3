{{* $Id: system_bad_login.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="1">
<form name="log" method="post" action="{{$smarty.server.PHP_SELF}}">
<tr>
<td bgcolor="#FFFFFF">
<input type="submit" name="clean" value="�M���O��">
<input type="submit" name="export" value="�ץXCSV��">
<table border="0">
<tr><td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr style="text-align:center;color:blue;background-color:#bedcfd;">
<td>�n�J�ɶ�</td><td>�n�JIP</td><td>�n�J�b��</td><td>�n�J���p</td>
</tr>
{{foreach from=$rowdata item=v key=i}}
<tr bgcolor="white">
<td>{{$v.log_time}}</td><td>{{$v.log_ip}}</td><td>{{$v.log_id}}</td><td>{{$v.err_kind}}</td>
</tr>
{{foreachelse}}
<tr bgcolor="white">
<td colspan="4" style="text-align:center;color:blue;">�d�L���</td>
</tr>
{{/foreach}}
</form>
</table>
<td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
<form name="v" method="post" action="{{$smarty.server.PHP_SELF}}">
<tr style="text-align:center;color:blue;background-color:#bedcfd;">
<td colspan="2">���@�s��n�J���~</td>
</tr>
{{assign var=c value=$smarty.post.lock-1}}
<tr style="background-color:white;text-align:center;">
<td>���@�}���{�b���A</td><td style="color:{{if $c}}red{{else}}green{{/if}};"><div OnClick="document.v.lock.value='{{$c*-1}}';document.v.submit();" style="cursor:pointer;">{{if $smarty.post.lock}}�}{{else}}��{{/if}}</div></td>
</tr>
<tr style="background-color:white;text-align:center;">
<td>�C�����̤j���~����</td><td><input type="text" name="err_times" size="2" value="{{$smarty.post.err_times}}">��</td>
</tr>
<input type="hidden" name="lock" value="{{$smarty.post.lock}}">
</form>
</table>
</td></tr></table>
</td>
</tr>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
