{{* $Id: elective_elective_copy.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<script>
<!--
function chg() {
	document.myform.curr.value=1-document.myform.curr.value;
	document.myform.submit();
}
-->
</script>

<table border="0" cellspacing="1" cellpadding="6" width="100%" bgcolor="#B0C0F8">
<tr bgcolor="#FFF6BA">
<td>
<table align="center" width="99%"><tr>
<td width="1%" nowrap>
<form method="post" action="{{$smarty.server.PHP_SELF}}">
{{$class_year_menu}}
</form>
</td>
<td width="1%" nowrap>
{{if $smarty.post.c_year}}
<form method="post" action="{{$smarty.server.PHP_SELF}}">
<input type="hidden" name="c_year" value="{{$smarty.post.c_year}}">
{{$subject_menu}}
</form>
{{/if}}</td>
<td>
{{if $smarty.post.ss_id}}
<form method="post" action="{{$smarty.server.PHP_SELF}}">
<input type="hidden" name="c_year" value="{{$smarty.post.c_year}}">
<input type="hidden" name="ss_id" value="{{$smarty.post.ss_id}}">
{{$class_menu}}
{{if $smarty.post.group_id}}<input type="submit" name="clear" value="�M�žǥ�">{{/if}}
</form>
{{/if}}</td>
</tr>
{{if $smarty.post.group_id}}
<tr><td colspan="3">
<table cellspacing="1" cellpadding="6" border="0" bgcolor="#211BC7" width="100%" align="center">
<form name="myform" method="post" action="{{$smarty.server.PHP_SELF}}">
<tr bgcolor='#FFFFFF'><td>
�п�Q�n�ƻs���ӷ��Z�šG<input type="checkbox" {{if $smarty.post.curr}}checked{{/if}} OnClick="chg();">�u��ܷ�Ǵ����<br>
<table cellspacing="1" cellpadding="6" border="0" bgcolor="#211BC7">
<tr bgcolor="#B6BFFB"><td>���</td><td>�Ǧ~��</td><td>�Ǵ�</td><td>���զW��</td><td>���ұЮv</td><td>�w�s�H�� / �̦h�H��</td><td>�}��ۿ�</td></tr>
{{foreach from=$rowdata item=d}}
{{assign var=tsn value=$d.teacher_sn}}
{{assign var=gid value=$d.group_id}}
<tr bgcolor="#E1E5F5"><td align="center"><input type="radio" name="sel_group" value="{{$gid}}"></td><td>{{$d.year}}</td><td>{{$d.semester}}</td><td>{{$d.group_name}}</td><td>{{$tea_arr.$tsn}}</td><td align="center">{{$stu_num.$gid.num|@intval}} / {{$d.member}}</td><td>{{$d.open}}</td>
</tr>
{{/foreach}}
</table><br>
<input type="submit" name="copy" value="�}�l�ƻs">
</td></tr>
<input type="hidden" name="c_year" value="{{$smarty.post.c_year}}">
<input type="hidden" name="ss_id" value="{{$smarty.post.ss_id}}">
<input type="hidden" name="group_id" value="{{$smarty.post.group_id}}">
<input type="hidden" name="curr" value="{{$smarty.post.curr}}">
</form>
</table>
{{/if}}
</td></tr></table>
</td></tr></table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
