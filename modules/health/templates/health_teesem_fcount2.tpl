{{* $Id: health_teesem_fcount2.tpl 5669 2009-09-24 08:33:05Z brucelyc $ *}}

<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�Z��</td>
<td>�ǥͼ�</td>
<td>���ѻP��</td>
<td>�ѻP�v</td>
<td>����I�H��</td>
<td>����I�H��</td>
<td>��I�H��</td>
<td>����v</td>
</tr>
{{foreach from=$rowdata item=d key=i}}
<tr style="background-color:white;text-align:center;">
<td>{{$i}}</td>
<td>{{$d.num|@intval}}</td>
<td>{{$d.n|@intval}}</td>
<td>{{$d.y/$d.num*100|@round:2}}%</td>
{{assign var=t value=$d.y*$maxd|intval}}
{{assign var=y value=$d.d|intval}}
{{assign var=n value=$t-$y}}
<td>{{$n}}</td>
<td>{{$t}}</td>
<td>{{$y}}</td>
<td>{{$y/$t*100|round:2}}%</td>
{{/foreach|@intval}}
</tr>
</table>
