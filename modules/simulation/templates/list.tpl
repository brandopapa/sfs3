{{* $Id: list.tpl 5672 2009-09-28 07:57:09Z hami $ *}}
<script language="JavaScript">

function set_s(id){
	document.myform.teach_id.value=id;
	document.myform.submit();
	return true;
}

function sort_kind(id){
	document.myform.sort_kind.value=id;
	document.myform.submit();
	return true;
}
function act_kind(id){
	document.myform.mode.value=id;
	document.myform.submit();
	return true;
}
</script>
<form action='{{$smarty.server.PHP_SELF}}' name='myform' method='post'>
<table bgcolor='#bbdddd' cellpadding=2 cellspacing=1>
{{if $smarty.post.mode neq 'all'}}
<tr><td><input type='button' value='�C�X���ո��' OnClick="act_kind('all')"></td></tr>
<tr><td>��J�Юv�m�W�G <input type='text' name='name' size='10'>
<input type='button' value='�d��' OnClick="act_kind('name')">
</td>
</tr>
{{/if}}
{{if $smarty.post.mode}}
{{assign var=data value=$self->get_teacher_name($smarty.post.sort_kind,$smarty.post.mode)}}
{{/if}}
{{if $data}}
<tr bgcolor='#E1E1FF'><td><a href="#" OnClick="sort_kind('post')">�B��</a></td><td><a href="#" OnClick="sort_kind('title')">¾��</a></td><td><a href="#" OnClick="sort_kind('name')">�Юv�m�W</a></td><td>�Юv�N��</td><td>�ʧ@</td></tr>
{{foreach from=$data item=item}}
<tr bgcolor='{{cycle values="#ffffff,#dbf8fe"}}'>
<td>
{{if $post_office_p[$item.post_office]|strpos:"���" == true }}
&nbsp;
{{elseif $item.class_num}}
{{$class_name[$item.class_num]}}
{{else}}
{{$post_office_p[$item.post_office]}}
{{/if}}
</td>
<td>{{$item.title_name}}</td>
<td>{{$item.name}}</td>
<td>{{$item.teach_id}}</td>
<td><input type='button' value='��������' onClick="set_s('{{$item.teach_id}}')"></td>
</tr>
{{/foreach}}
{{/if}}
<input name="teach_id" type="hidden">
<input name="sort_kind" type="hidden">
<input name="mode" type="hidden" value="{{$smarty.post.mode}}">

</table>

</form>
