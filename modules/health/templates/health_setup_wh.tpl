{{* $Id: health_setup_wh.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<table border="0">
<tr><td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" class="small">
<form name="v" method="post" action="{{$smarty.server.PHP_SELF}}">
<tr style="text-align:center;color:blue;background-color:#bedcfd;">
<td colspan="2">�����魫��J�覡</td>
</tr>
{{assign var=c value=$smarty.post.chk-1}}
{{assign var=d value=$smarty.post.dot-1}}
{{assign var=s value=$smarty.post.slope-1}}
{{assign var=r value=$smarty.post.color-1}}
<tr style="background-color:white;text-align:center;">
<td><select name="wh_input"><option value="">���������魫</option><option value="1" {{if $smarty.post.wh_input=="1"}}selected{{/if}}>���魫�ᨭ��</option></select></td>
</tr>
<input type="hidden" name="chk" value="{{$smarty.post.chk}}">
</table>
<input type="submit" name="sure" value="�T�w�x�s">
<table>
<tr bgcolor="#FBFBC4">
<td><img src="{{$SFS_PATH_HTML}}images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td>
</tr>
<tr><td style="line-height:150%;">
<ol>
<li class="small">���t�X���۰ʨ����魫���q���e�X�ƾڤ覡�A�i�Ѧ��]�w���ܨ����魫��J���ƦC���ǡC</li>
</ol>
</td></tr>
</form>
</table>
</td></tr></table>
