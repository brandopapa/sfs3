{{* $Id: health_analyze_sight_all.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<table cellspacing="0" cellpadding="0"><tr><td>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td rowspan="3">�Z�O</td>
{{foreach from=$class_year item=d key=i}}
{{if $i>0}}
<td colspan="8">{{$d}}��</td>
{{/if}}
{{/foreach}}
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
{{foreach from=$class_year item=d key=i}}
{{if $i>0}}
<td colspan="2">�ˬd<br>�H��</td>
<td colspan="2">���O��<br>�}�H��</td>
<td colspan="2">�B�v��<br>���H��</td>
<td colspan="2">���B�v<br>�H�@��</td>
{{/if}}
{{/foreach}}
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
{{foreach from=$class_year item=d key=i}}
{{if $i>0}}
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
{{/if}}
{{/foreach}}
</tr>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{foreach from=$rowdata item=d key=c}}
<tr style="background-color:{{cycle values="#f4feff,white"}};text-align:center;">
<td>{{$c}}</td>
{{foreach from=$class_year item=dd key=y}}
{{if $y>0}}
{{foreach from=$kdata item=k}}
{{foreach from=$sdata item=s}}
<td>{{$rowdata.$c.$y.$k.$s}}</td>
{{/foreach}}
{{/foreach}}
{{/if}}
{{/foreach}}
</tr>
{{/foreach}}
</table>
</td>
</tr></table>