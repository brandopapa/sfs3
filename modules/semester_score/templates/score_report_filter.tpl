
<table border="0" cellspacing="1" cellpadding="2" width="100%">
<tr><td bgcolor='#FFFFFF'>
{{if $year_name}}
<tr><td>
<table border='2' cellpadding='3' cellspacing='0' style='border-collapse:collapse; font-size:{{$m_arr.text_size}};' bordercolor='#111111' width='100%'>
<tr bgcolor="#ffcccc" align="center">
<td rowspan=2 width={{$m_arr.class_width}}>�Z��</td>
<td rowspan=2 width={{$m_arr.num_width}}>�y��</td>
<td rowspan=2 width={{$m_arr.id_width}}>�Ǹ�</td>
<td rowspan=2 width={{$m_arr.name_width}}>�m�W</td>
<td rowspan=2 width={{$m_arr.class_width}}>�ثe�Z�Ůy��</td>
<td colspan=4>�y����</td>
<td rowspan=2 width={{$m_arr.area_width}}>���d�P��|</td>
<td rowspan=2 width={{$m_arr.area_width}}>�ƾ�</td>

{{if $year_name>2}}
<td rowspan=2 width={{$m_arr.area_width}}>���|</td>
<td rowspan=2 width={{$m_arr.area_width}}>���N�P�H��</td>
<td rowspan=2 width={{$m_arr.area_width}}>�۵M�P�ͬ����</td>

{{else}}
<td rowspan=2 width={{$m_arr.area_width}}>�ͬ�</td>
{{/if}}

<td rowspan=2 width={{$m_arr.area_width}}>��X����</td>
<td rowspan=2 width={{$m_arr.avg_width}}>���<br>����</td>
</tr>
<tr bgcolor="#ffcccc" align="center">
<td width={{$m_arr.area_width}}>����y��</td>
<td width={{$m_arr.area_width}}>�^�y</td>
<td width={{$m_arr.area_width}}>���g�y��</td>
<td width={{$m_arr.avg_width}}>����</td>
</tr>

{{foreach from=$student_data item=data key=sn}}
{{if $data.chk==1}}
<tr align="center">
<td>{{$data.class_name}}</td>
<td>{{$data.seme_num}}</td>
<td>{{$data.stud_id}}</td>
<td>{{$data.stud_name}}</td>
<td>{{$data.curr_class_num}}</td>

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
</tr>
{{/if}}

{{/foreach}}
</table>
</td></tr>
{{/if}}
</tr>
</td></tr>
</table>
