{{* $Id: health_analyze_inject_count2.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<table cellspacing="0" cellpadding="0"><tr>
<td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="5" class="small" style="text-align:center;">
<tr style="background-color:#c4d9ff;text-align:center;">
<td rowspan="3">�~��</td>
<td rowspan="3">�Z��</td>
<td rowspan="3">�ǥ�<br>�H��</td>
<td colspan="2" rowspan="2">�w��<br>����<br>�d�v<br>���w<br>ú�@</td>
<td colspan="2">�d���]</td>
<td colspan="6">B���x���̭]</td>
<td colspan="8">�p��·��̭]</td>
<td colspan="8">�ճ�B�ʤ�y�B<br>�}�˭��V�X�̭]</td>
<td colspan="2">�¯l�̭]</td>
<td colspan="2">MMR</td>
<td colspan="6">�饻�����̭]</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td colspan="2">�@<br>��</td>
<td colspan="2">��<br>�@<br>��</td>
<td colspan="2">��<br>�G<br>��</td>
<td colspan="2">��<br>�T<br>��</td>
<td colspan="2">��<br>�@<br>��</td>
<td colspan="2">��<br>�G<br>��</td>
<td colspan="2">��<br>�T<br>��</td>
<td colspan="2">��<br>�|<br>��</td>
<td colspan="2">��<br>�@<br>��</td>
<td colspan="2">��<br>�G<br>��</td>
<td colspan="2">��<br>�T<br>��</td>
<td colspan="2">��<br>�|<br>��</td>
<td colspan="2">�@<br>��</td>
<td colspan="2">�@<br>��</td>
<td colspan="2">��<br>�@<br>��</td>
<td colspan="2">��<br>�G<br>��</td>
<td colspan="2">��<br>�T<br>��</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
<td>�H<br>��</td>
<td>�H</td>
</tr>
{{foreach from=$data_arr item=d key=year}}
{{foreach from=$d item=dd key=class}}
{{if $year!="all" && $class!="all"}}
<tr style="background-color:{{cycle values="white,yellow"}};">
<td>{{$year}}</td>
<td>{{$class}}</td>
<td>{{$dd.nums|@intval}}</td>
<td>{{$dd.ptotal|@intval}}</td>
<td>{{$dd.ptotal/$dd.nums*100|@round:2}}%</td>
<td>{{$dd.1.1|@intval}}</td>
<td>{{$dd.1.2|@intval}}</td>
<td>{{$dd.1.3|@intval}}</td>
<td>{{$dd.1.ttotal|@intval}}</td>
<td>{{$dd.1.ttotal/$dd.nums|@round:2}}</td>
<td>{{$dd.2.1|@intval}}</td>
<td>{{$dd.2.2|@intval}}</td>
<td>{{$dd.2.3|@intval}}</td>
<td>{{$dd.2.ttotal|@intval}}</td>
<td>{{$dd.2.ttotal/$dd.nums|@round:2}}</td>
<td>{{$dd.3|@intval}}</td>
<td>{{$dd.3/$dd.nums*100|@round:2}}%</td>
<td>{{$dd.4|@intval}}</td>
<td>{{$dd.4/$dd.nums*100|@round:2}}%</td>
<td>{{$dd.5|@intval}}</td>
<td>{{$dd.5/$dd.nums*100|@round:2}}%</td>
</tr>
{{/if}}
{{/foreach}}
{{if $year!="all"}}
<tr style="background-color:#c4d9ff;text-align:center;">
<td>{{$year}}</td>
<td>�p�p</td>
<td>{{$d.all.nums|@intval}}</td>
<td>{{$d.all.ptotal|@intval}}</td>
<td>{{$d.all.ptotal/$d.all.nums*100|@round:2}}%</td>
<td>{{$d.all.1.1|@intval}}</td>
<td>{{$d.all.1.2|@intval}}</td>
<td>{{$d.all.1.3|@intval}}</td>
<td>{{$d.all.1.ttotal|@intval}}</td>
<td>{{$d.all.1.ttotal/$d.all.nums|@round:2}}</td>
<td>{{$d.all.2.1|@intval}}</td>
<td>{{$d.all.2.2|@intval}}</td>
<td>{{$d.all.2.3|@intval}}</td>
<td>{{$d.all.2.ttotal|@intval}}</td>
<td>{{$d.all.2.ttotal/$d.all.nums|@round:2}}</td>
<td>{{$d.all.3|@intval}}</td>
<td>{{$d.all.3/$d.all.nums*100|@round:2}}%</td>
<td>{{$d.all.4|@intval}}</td>
<td>{{$d.all.4/$d.all.nums*100|@round:2}}%</td>
<td>{{$d.all.5|@intval}}</td>
<td>{{$d.all.5/$d.all.nums*100|@round:2}}%</td>
</tr>
{{/if}}
{{/foreach}}
<tr style="background-color:#c4d9ff;text-align:center;">
<td colspan="2">�`�p</td>
<td>{{$data_arr.all.all.nums|@intval}}</td>
<td>{{$data_arr.all.all.ptotal|@intval}}</td>
<td>{{$data_arr.all.all.ptotal/$data_arr.all.all.nums*100|@round:2}}%</td>
<td>{{$data_arr.all.all.1.1|@intval}}</td>
<td>{{$data_arr.all.all.1.2|@intval}}</td>
<td>{{$data_arr.all.all.1.3|@intval}}</td>
<td>{{$data_arr.all.all.1.ttotal|@intval}}</td>
<td>{{$data_arr.all.all.1.ttotal/$data_arr.all.all.nums|@round:2}}</td>
<td>{{$data_arr.all.all.2.1|@intval}}</td>
<td>{{$data_arr.all.all.2.2|@intval}}</td>
<td>{{$data_arr.all.all.2.3|@intval}}</td>
<td>{{$data_arr.all.all.2.ttotal|@intval}}</td>
<td>{{$data_arr.all.all.2.ttotal/$data_arr.all.all.nums|@round:2}}</td>
<td>{{$data_arr.all.all.3|@intval}}</td>
<td>{{$data_arr.all.all.3/$data_arr.all.all.nums*100|@round:2}}%</td>
<td>{{$data_arr.all.all.4|@intval}}</td>
<td>{{$data_arr.all.all.4/$data_arr.all.all.nums*100|@round:2}}%</td>
<td>{{$data_arr.all.all.5|@intval}}</td>
<td>{{$data_arr.all.all.5/$data_arr.all.all.nums*100|@round:2}}%</td>
</tr>
</table>
</td></tr></table>