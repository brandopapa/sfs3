{{* $Id: health_input_fcount.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<script>
function cm() {
	if (confirm("�T�w�n����վǥͪ��A���]�w���u�ѻP�v?")) {
		document.myform.all.value=1;
		document.myform.submit();
	}
}

function cm2() {
	if (confirm("�T�w�n����հѻP�ǥͪ���I���A���]�w���u�����f�v?")) {
		document.myform.act.value=1;
		document.myform.submit();
	}
}
</script>

<input type="button" value="�]�w���վǥͬҰѻP" OnClick="cm();">
<input type="button" value="�]�w���հѻP�ǥͳ������f" OnClick="cm2();">
<input type="hidden" name="all" value="">
<input type="hidden" name="act" value="">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td rowspan="2">�Z��</td>
<td rowspan="2">���<br>�H��</td>
<td rowspan="2">�ѻP<br>�H��</td>
<td rowspan="2">���ѻP<br>�H��</td>
<td rowspan="2">���]�w<br>�H��</td>
<td colspan="{{$maxd}}">�w��I�H��(�g/�H)</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
{{foreach from=$date_arr item=d key=i}}
<td>&nbsp;{{if $d.week_no<10}}&nbsp;{{/if}}{{$d.week_no}}&nbsp;</td>
{{/foreach}}
</tr>
{{foreach from=$rowdata item=d key=i}}
<tr style="background-color:{{cycle values="white,white,white,white,yellow"}};text-align:center;">
<td>{{$i}}</td>
<td>{{$d.num|@intval}}</td>
<td>{{$d.y|@intval}}</td>
<td>{{$d.n|@intval}}</td>
<td>{{$d.u|@intval}}</td>
{{foreach from=$date_arr item=dd key=i}}
{{assign var=ww value=$dd.week_no}}
{{assign var=ww value=w$ww}}
<td>{{$d.$ww}}</td>
{{/foreach}}
{{/foreach|@intval}}
</tr>
</table>
