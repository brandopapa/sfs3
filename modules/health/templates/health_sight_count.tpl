{{* $Id: health_sight_count.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<table cellspacing="0" cellpadding="0"><tr>
<td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="5" class="small" style="text-align:center;">
<tr style="background-color:#c4d9ff;text-align:center;">
<td rowspan="4" nowrap>�~��</td>
<td colspan="14">�r�����O�ˬd�H��</td>
<td colspan="9">�B�����O�ˬd�H��</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td colspan="3" rowspan="2" nowrap>�X�p</td>
<td colspan="2" rowspan="2">�Ⲵ<br>���F<br>0.9</td>
<td colspan="9">�r�����O���}�H��</td>
<td colspan="3" rowspan="2" nowrap>�X�p</td>
<td colspan="2" rowspan="2">�Ⲵ<br>���F<br>0.5</td>
<td colspan="4">�B�����O���}�H��</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td colspan="2">0.5~0.8</td>
<td colspan="2">0.1~0.4</td>
<td colspan="2">���F0.1</td>
<td colspan="3">�X�p</td>
<td colspan="2">0.1~0.4</td>
<td colspan="2">���F0.1</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td nowrap>�X�p</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td nowrap>�X�p</td>
<td>�k</td>
<td>�k</td>
<td nowrap>�X�p</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
<td>�k</td>
</tr>
{{foreach from=$data_arr item=d key=i}}
{{if $i!="all"}}
<tr style="background-color:white;text-align:center;">
<td>{{$i}}</td>
<td>{{$d.0.all}}</td>
<td>{{$d.0.1.all}}</td>
<td>{{$d.0.2.all}}</td>
<td>{{$d.0.1.0}}</td>
<td>{{$d.0.2.0}}</td>
<td>{{$d.0.1.1}}</td>
<td>{{$d.0.2.1}}</td>
<td>{{$d.0.1.2}}</td>
<td>{{$d.0.2.2}}</td>
<td>{{$d.0.1.3|@intval}}</td>
<td>{{$d.0.2.3|@intval}}</td>
<td>{{$d.0.dis}}</td>
<td>{{$d.0.1.dis}}</td>
<td>{{$d.0.2.dis}}</td>
<td>{{$d.1.all}}</td>
<td>{{$d.1.1.all}}</td>
<td>{{$d.1.2.all}}</td>
<td>{{$d.1.1.0}}</td>
<td>{{$d.1.2.0}}</td>
<td>{{$d.1.1.1}}</td>
<td>{{$d.1.2.1}}</td>
<td>{{$d.1.1.2|@intval}}</td>
<td>{{$d.1.2.2|@intval}}</td>
</tr>
{{/if}}
{{/foreach}}
<tr style="background-color:#c4d9ff;text-align:center;">
<td nowrap>�X�p</td>
<td>{{$data_arr.all.0.all|@intval}}</td>
<td>{{$data_arr.all.0.1.all|@intval}}</td>
<td>{{$data_arr.all.0.2.all|@intval}}</td>
<td>{{$data_arr.all.0.1.0|@intval}}</td>
<td>{{$data_arr.all.0.2.0|@intval}}</td>
<td>{{$data_arr.all.0.1.1|@intval}}</td>
<td>{{$data_arr.all.0.2.1|@intval}}</td>
<td>{{$data_arr.all.0.1.2|@intval}}</td>
<td>{{$data_arr.all.0.2.2|@intval}}</td>
<td>{{$data_arr.all.0.1.3|@intval}}</td>
<td>{{$data_arr.all.0.2.3|@intval}}</td>
<td>{{$data_arr.all.0.dis|@intval}}</td>
<td>{{$data_arr.all.0.1.dis|@intval}}</td>
<td>{{$data_arr.all.0.2.dis|@intval}}</td>
<td>{{$data_arr.all.1.all|@intval}}</td>
<td>{{$data_arr.all.1.1.all|@intval}}</td>
<td>{{$data_arr.all.1.2.all|@intval}}</td>
<td>{{$data_arr.all.1.1.0|@intval}}</td>
<td>{{$data_arr.all.1.2.0|@intval}}</td>
<td>{{$data_arr.all.1.1.1|@intval}}</td>
<td>{{$data_arr.all.1.2.1|@intval}}</td>
<td>{{$data_arr.all.1.1.2|@intval}}</td>
<td>{{$data_arr.all.1.2.2|@intval}}</td>
</tr>
</table>
</td></tr></table>
