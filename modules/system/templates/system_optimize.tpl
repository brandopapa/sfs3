{{* $Id: system_optimize.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="1">
<form name="log" method="post" action="{{$smarty.server.PHP_SELF}}">
<tr>
<td bgcolor="#FFFFFF">
<input type="submit" name="optimize" value="�i��̨Τ�">
<table border="0">
<tr><td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr style="text-align:left;color:blue;background-color:#bedcfd;">
<td>�Ǧ�</td><td>��ƪ�W��</td><td>�w���t�����ϥΪ��줸�ռ�</td>
{{if $smarty.post.optimize}}<td>�״_</td><td>�̨Τ�</td>{{/if}}
</tr>
{{foreach from=$rowdata item=v key=i name=n}}
<tr bgcolor="white">
<td>{{$smarty.foreach.n.iteration}}</td><td>{{$v.name}}</td><td>{{$v.data_free}}</td>
{{if $smarty.post.optimize}}<td style="text-align:center;"><font color="{{if $v.repair}}blue">���\{{else}}red">����{{/if}}</font></td><td style="text-align:center;"><font color="{{if $v.optimize}}blue">���\{{else}}red">����{{/if}}</font></td>{{/if}}
</tr>
{{foreachelse}}
<tr bgcolor="white">
<td colspan="4" style="text-align:center;color:blue;">�d�L���</td>
</tr>
{{/foreach}}
</form>
</table>
</td></tr></table>
</td>
</tr>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
