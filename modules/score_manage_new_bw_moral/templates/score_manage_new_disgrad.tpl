{{* $Id: score_manage_new_disgrad.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<tr><td bgcolor='#FFFFFF'>
<form name="menu_form" method="post" action="{{$smarty.server.PHP_SELF}}">
<table width="100%">
<tr>
<td>{{$year_seme_menu}} {{$class_year_menu}} <select name="years" size="1" style="background-color:#FFFFFF;font-size:13px" onchange="this.form.submit()";><option value="5" {{if $smarty.post.years==5}}selected{{/if}}>���Ǵ�</option><option value="6" {{if $smarty.post.years==6}}selected{{/if}}>���Ǵ�</option></select>�ǲ߻�쥭�����Z�b60���H�W�̥��F<input type="text" name="fail_num" size="1" value="{{if $smarty.post.fail_num == ""}}3{{else}}{{$smarty.post.fail_num}}{{/if}}">��{{if $smarty.post.year_name}} <input type="submit" name="friendly_print" value="�͵��C�L">{{/if}}</td>
</tr>
{{if $smarty.post.year_name}}
<tr><td>
<table border="0" cellspacing="1" cellpadding="4" width="100%" bgcolor="#cccccc" class="main_body">
<tr bgcolor="#E1ECFF" align="center">
<td>�Z��</td>
<td>�y��</td>
<td>�Ǹ�</td>
<td>�m�W</td>
<td>�y��</td>
<td>�ƾ�</td>
<td>�۵M�P�ͬ����</td>
<td>���|</td>
<td>���d�P��|</td>
<td>���N�P�H��</td>
<td>��X</td>
</tr>
{{foreach from=$show_sn item=sc key=sn}}
<tr bgcolor="#ddddff" align="center">
<td>{{$sclass[$sn]}}</td>
<td>{{$snum[$sn]}}</td>
<td>{{$stud_id[$sn]}}</td>
<td>{{$stud_name[$sn]}}</td>
{{foreach from=$show_ss item=ssn key=ss}}
<td>{{if $fin_score.$sn.$ss.avg.score < 60}}<font color="red">{{/if}}{{$fin_score.$sn.$ss.avg.score}}{{if $fin_score.$sn.$ss.avg.score < 60}}</font>{{/if}}</td>
{{/foreach}}
</tr>
{{/foreach}}
</table>
</td></tr>
{{/if}}
</tr>
</table>
</td></tr>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}