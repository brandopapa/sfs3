{{* $Id: record.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

{{include file="$SFS_TEMPLATE/header.tpl"}}

{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor="#cccccc">

<tr><td bgcolor="#FFFFFF">

<form name="menu_form" method="post" action="{{$smarty.server.PHP_SELF}}">

<table>

<tr>

<td>{{$year_seme_menu}}</td>

</tr>

</table>

<table border="0" cellspacing="1" cellpadding="2" bgcolor="#cccccc" class="main_body">

<tr bgcolor="#E1ECFF" align="center">

<td>�а��H</td>

<td bgcolor="#ffffff" align="left">{{$leave_teacher_menu}}</td>

</tr>

{{if $smarty.post.teacher_sn != ""}}


<tr bgcolor="#E1ECFF" align="center">

<td>���O</td>

<td bgcolor="#ffffff" align="left">{{$abs_kind}}</td>

</tr>

{{if $smarty.post.abs_kind != ""}}
<tr bgcolor="#E1ECFF" align="center">
<td>�ƥ�</td>
<td bgcolor="#ffffff" align="left"><input type="text" name="reason" value="{{$smarty.post.reason}}" size="30"></td>
</tr>
<tr bgcolor="#E1ECFF" align="center">

<td>�}�l��� �ɶ�</td>

<td bgcolor="#ffffff" align="left"><input type="text" style='font-size: 18pt' name="start_date" value="{{if $smarty.post.start_date}}{{$smarty.post.start_date}}{{else}}{{$morning}}{{/if}}"><br><font color="#ff0000">(�榡�G{{$morning}})</font></td>

</tr>

<tr bgcolor="#E1ECFF" align="center">

<td>������� �ɶ�</td>

<td bgcolor="#ffffff" align="left"><input type="text" style='font-size: 18pt' name="end_date" value="{{if $smarty.post.end_date}}{{$smarty.post.end_date}}{{else}}{{$evening}}{{/if}}"><br><font color="#ff0000">(�榡�G{{$evening}})</font></td>

</tr>
<tr bgcolor="#E1ECFF" align="center">

<td>�@�p</td>

<td bgcolor="#ffffff" align="left"><input type="text" name="day" value="{{$smarty.post.day}}" size="4">��<input type="text" name="hour" value="{{$smarty.post.hour}}" size="4">��</td>

</tr>

<tr bgcolor="#E1ECFF" align="center">

<td>�ҵ{�w��</td>

<td bgcolor="#ffffff" align="left">{{$course_menu}}</td>

</tr>

<tr bgcolor="#E1ECFF" align="center">

<td>¾�ȥN�z�H</td>

<td bgcolor="#ffffff" align="left">{{$agent_menu}}</td>

</tr>

<tr bgcolor="#E1ECFF" align="center">
<td>�ҩ����</td>
<td bgcolor="#ffffff" align="left"><input type="text" name="note" value="{{$smarty.post.note}}" size="30"></td>
</tr>
{{if $smarty.post.abs_kind == "52"}}

<tr bgcolor="#E1ECFF" align="center">
<td>�X�t�a�I</td>
	<td bgcolor="#ffffff" align="left"><input type="text" name="locale" value="{{$smarty.post.locale}}" size="30"></td>

</tr>
{{/if}}
{{/if}}

{{/if}}

</table>

{{if $smarty.post.abs_kind != ""}}

{{if $smarty.post.act == "edit"}}<input type="submit" name="sure" value="�T�w�ק�">{{else}}<input type="submit" name="sure" value="�T�w�s�W">{{/if}}

{{/if}}

{{if $smarty.post.act == "edit"}}<input type="hidden" name="act" value="edit"><input type="hidden" name="id" value="{{$id}}">{{else}}<input type="hidden" name="act" value="add">{{/if}}

</form>

{{if $smarty.post.abs_kind != ""}}

<table>

<tr bgcolor="#FBFBC4">

<td><img src="images/filefind.png" width=16 height=16 hspace=3 border=0>��������</td>

</tr>

<tr>

<td style="line-height: 150%;">

<ol>

<li class="small">�Ъ`�N����ɶ��榡���A����P�ɶ������n���@�ӪťաA�_�hŪ�X���ȷ|�X���C</li>

</ol></td>

</tr>

</table>

{{/if}}

</tr>

</table><p>

</td>

</tr>

</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}