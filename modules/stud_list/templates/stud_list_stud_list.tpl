{{* $Id: stud_list_stud_list.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<form name="myform" method="post" action="{{$smarty.server.PHP_SELF}}" target="_blank">
<tr><td bgcolor='#FFFFFF'>
<table width="100%">
<tr><td>
<input type="submit" name="print_out" value="�C�X�W��">
<input type="submit" name="csv_out" value="�ץXCVS��">
<input type="submit" name="csv_out_all" value="�ץX����CVS��">
{{if $sex_enable}}<input type="checkbox" name="sex" value="1">�C�X�ʧO{{/if}}<br>
<table border="0" cellspacing="1" cellpadding="4" bgcolor="#cccccc" class="main_body">
<tr bgcolor="#E1ECFF" align="center">
<td>�Ĥ@�C�Z��</td>
<td>�ĤG�C�Z��</td>
<td>�ĤT�C�Z��</td>
</tr>
{{foreach from=$class_arr item=class_name key=cid}}
<tr bgcolor="#FFFFFF">
<td><input type="radio" name="c_id[1]" value="{{$cid}}">{{$class_name}}</td>
<td><input type="radio" name="c_id[2]" value="{{$cid}}">{{$class_name}}</td>
<td><input type="radio" name="c_id[3]" value="{{$cid}}">{{$class_name}}</td>
</tr>
{{/foreach}}
</table>
<input type="submit" name="print_out" value="�C�X�W��">
<input type="submit" name="csv_out" value="�ץXCVS��">
<input type="submit" name="csv_out_all" value="�ץX����CVS��">
{{if $sex_enable}}<input type="checkbox" name="sex" value="1">�C�X�ʧO{{/if}}
</td></tr>
</table>
</td></tr>
</form>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
