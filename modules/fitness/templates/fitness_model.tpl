{{* $Id: fitness_model.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="4">
<form action="{{$smarty.server.PHP_SELF}}" method="post">
<tr>
<td bgcolor="#FFFFFF" valign="top">
{{$model_menu}}<br><br>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
{{foreach from=$rowdata item=v key=sex}}
{{assign var=id value=$smarty.post.model_id}}
<tr style="text-align:center;color:white;{{if $sex==2}}background-color:#ff79bc;{{/if}}"><td colspan="20">7-23�����p��{{if $sex==1}}�k{{else}}�k{{/if}}�ǥ�{{$model_arr.$id}}�ʤ����ű`��(���:{{$k_arr.$id}})</td></tr>
<tr bgcolor="#c4d9ff">
<td align="center">�ʤ�<br>����</td>
{{foreach from=$p_arr item=c key=p}}
<td align="center">{{$p}}%</td>
{{/foreach}}
{{if $smarty.post.model_id>1}}
<tr bgcolor="white">
<td>�~��</td>
<td colspan="4" style="text-align:center;color:red;">&lt;&lt;�Х[�j&gt;&gt;</td>
<td colspan="5" style="text-align:center;color:blue;">&lt;&lt;����&gt;&gt;</td>
<td colspan="5" style="text-align:center;"><img src="images/award_3rd.gif" alt="�ɵP"></td>
<td colspan="2" style="text-align:center;"><img src="images/award_silver.gif" alt="�ȵP"></td>
<td colspan="3" style="text-align:center;"><img src="images/award_gold.gif" alt="���P"></td>
</tr>
{{/if}}
</tr>
{{foreach from=$v item=d key=i}}
<tr bgcolor="white">
<td>{{$d.age}}</td>
{{foreach from=$p_arr item=c key=p}}
{{assign var=pp value=p$p}}
<td bgcolor="{{$c}}">{{$d.$pp}}</td>
{{/foreach}}
</tr>
{{/foreach}}
{{/foreach}}
</table>
<br>
<div class="small">����ƨӦ�<a href="http://www.fitness.org.tw">�Ш|����A�����</a>�A�Y�����~�A�Чi��<a href="http://sfshelp.tcc.edu.tw"�}�o�H��</a>�ץ��C</div>
</td></tr></form></table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
