{{* $Id: $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
<table border="0" cellspacing="1" cellpadding="2" width="100%">
<tr><td bgcolor='#FFFFFF'>
<form name="myform" method="post" action="{{$smarty.server.PHP_SELF}}">
<tr>
<td align='right'>
<input type="submit" name="print_all" value="�͵��C�L" onclick='this.form.target="{{$year_name}}";'></td>
</tr>
{{if $year_name}}
<tr><td>
<table border='2' cellpadding='3' cellspacing='0' style='border-collapse:collapse; font-size:{{$m_arr.text_size}};' bordercolor='#111111' width='100%'>
<tr bgcolor="#ffcccc" align="center">
<td rowspan=2 width={{$m_arr.num_width}}><input type="radio" name="order" value=""{{if $order==""}} checked{{/if}} onclick="this.form.target=''; this.form.submit();">�y��</td>
<td rowspan=2 width={{$m_arr.id_width}}>�Ǹ�</td>
<td rowspan=2 width={{$m_arr.name_width}}>�m�W</td>
<td colspan=4>�y����</td>
<td rowspan=2 width={{$m_arr.area_width}}><input type="radio" name="order" value="health"{{if $order=="health"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>���d�P��|</td>
<td rowspan=2 width={{$m_arr.area_width}}><input type="radio" name="order" value="math"{{if $order=="math"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>�ƾ�</td>

{{if $year_name>2}}
<td rowspan=2 width={{$m_arr.area_width}}><input type="radio" name="order" value="social"{{if $order=="social"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>���|</td>
<td rowspan=2 width={{$m_arr.area_width}}><input type="radio" name="order" value="art"{{if $order=="art"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>���N�P�H��</td>
<td rowspan=2 width={{$m_arr.area_width}}><input type="radio" name="order" value="nature"{{if $order=="nature"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>�۵M�P�ͬ����</td>

{{else}}
<td rowspan=2 width={{$m_arr.area_width}}><input type="radio" name="order" value="life"{{if $order=="life"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>�ͬ�</td>
{{/if}}

<td rowspan=2 width={{$m_arr.area_width}}><input type="radio" name="order" value="complex"{{if $order=="complex"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>��X����</td>
<td rowspan=2 width={{$m_arr.avg_width}}><input type="radio" name="order" value="total"{{if $order=="total"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>���<br>����</td>
<td colspan=4>��`�ͬ���{</td>
</tr>
<tr bgcolor="#ffcccc" align="center">
<td width={{$m_arr.area_width}}><input type="radio" name="order" value="chinese"{{if $order=="chinese"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>����y��</td>
<td width={{$m_arr.area_width}}><input type="radio" name="order" value="english"{{if $order=="english"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>�^�y</td>
<td width={{$m_arr.area_width}}><input type="radio" name="order" value="local"{{if $order=="local"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>���g�y��</td>
<td width={{$m_arr.avg_width}}><input type="radio" name="order" value="language"{{if $order=="language"}} checked{{/if}} onclick="this.form.target=''; this.form.submit();"><br>����</td>
<td>��`�欰</td>
<td>���鬡��</td>
<td>���@�A��</td>
<td>�S���{</td>
</tr>

{{foreach from=$score_rank item=data key=sn}}
<tr align="center">
<td>{{$student_data.$sn.seme_num}}</td>
<td>{{$student_data.$sn.stud_id}}</td>
<td>{{$student_data.$sn.stud_name}}{{$student_data.$sn.stud_study_cond}}</td>

<td>{{$fin_score.$sn.chinese.$curr_seme.score}}</td>
<td>{{$fin_score.$sn.english.$curr_seme.score}}</td>
<td>{{$fin_score.$sn.local.$curr_seme.score}}</td>
<td>{{$fin_score.$sn.language.$curr_seme.score}}</td>
<td>{{$fin_score.$sn.health.$curr_seme.score}}</td>
<td>{{$fin_score.$sn.math.$curr_seme.score}}</td>

{{if $year_name>2}}
<td>{{$fin_score.$sn.social.$curr_seme.score}}</td>
<td>{{$fin_score.$sn.art.$curr_seme.score}}</td>
<td>{{$fin_score.$sn.nature.$curr_seme.score}}</td>

{{else}}
<td>{{$fin_score.$sn.life.$curr_seme.score}}</td>
{{/if}}


<td>{{$fin_score.$sn.complex.$curr_seme.score}}</td>
<td bgcolor='{{$m_arr.area_avg_bgcolor}}'>{{$fin_score.$sn.avg.score}}</td>
<td align='left'>{{$student_data.$sn.nor.0}}</td>
<td align='left'>{{$student_data.$sn.nor.1}}</td>
<td align='left'>{{$student_data.$sn.nor.2}}{{$student_data_nor.$sn.nor.3}}</td>
<td align='left'>{{$student_data.$sn.nor.4}}{{$student_data_nor.$sn.nor.5}}</td>
</tr>

{{/foreach}}
</table>
</form>
</td></tr>
{{/if}}
</tr>
</td></tr>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
