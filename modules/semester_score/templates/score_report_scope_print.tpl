{{*  *}}
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>{{$show_year.0}}�Ǧ~��{{$show_seme.0}}�Ǵ�{{$year_name}}�~��{{$m_arr.title}}</title>
</head>
<body>
{{if $m_arr.style}}
<P align="center" style='font-size:{{$m_arr.title_font_size}}; font-family:{{$m_arr.title_font_name}}'>{{$school_long_name}}{{$show_year.0}}�Ǧ~��{{$show_seme.0}}�Ǵ�{{$year_name}}�~��{{$m_arr.title}}</P>
<table border='2' cellpadding='3' cellspacing='0' style='border-collapse:collapse; font-size:{{$m_arr.text_size}};' bordercolor='#111111' width='100%'>
<tr bgcolor="{{$m_arr.header_bgcolor}}" align="center">
<td rowspan=2 width={{$m_arr.class_width}}>�Z��</td>
<td rowspan=2 width={{$m_arr.num_width}}>�y��</td>
<td rowspan=2 width={{$m_arr.id_width}}>�Ǹ�</td>
<td rowspan=2 width={{$m_arr.name_width}}>�m�W</td>
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
<td colspan=4>��`�ͬ���{</td>
</tr>
<tr bgcolor="{{$m_arr.header_bgcolor}}" align="center">
<td width={{$m_arr.area_width}}>����y��</td>
<td width={{$m_arr.area_width}}>�^�y</td>
<td width={{$m_arr.area_width}}>���g�y��</td>
<td width={{$m_arr.avg_width}}>����</td>
<td>��`�欰</td>
<td>���鬡��</td>
<td>���@�A��</td>
<td>�S���{</td>
</tr>

{{foreach from=$student_data item=data key=sn}}
<tr align="center">
<td>{{$data.class_name}}</td>
<td>{{$data.seme_num}}</td>
<td>{{$data.stud_id}}</td>
<td>{{$data.stud_name}}</td>

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

{{else}}

<P align="center" style='font-size:{{$m_arr.title_font_size}}; font-family:{{$m_arr.title_font_name}}'>{{$school_long_name}}<br>{{$show_year.0}}�Ǧ~��{{$show_seme.0}}�Ǵ�{{$year_name}}�~��{{$m_arr.title}}</P>
<table border='2' cellpadding='3' cellspacing='0' style='border-collapse:collapse; font-size:{{$m_arr.text_size}};' bordercolor='#111111' width='100%'>
<tr bgcolor="{{$m_arr.header_bgcolor}}" align="center">
<td rowspan=2>�Z��</td>
<td rowspan=2>�y��</td>
<td rowspan=2>�Ǹ�</td>
<td rowspan=2>�m�W</td>
<td colspan=4>�y����</td>
<td rowspan=2>���d�P��|</td>
<td rowspan=2>�ƾ�</td>

{{if $year_name>2}}
<td rowspan=2>���|</td>
<td rowspan=2>���N�P�H��</td>
<td rowspan=2>�۵M�P�ͬ����</td>

{{else}}
<td rowspan=2>�ͬ�</td>
{{/if}}

<td rowspan=2>��X����</td>
<td rowspan=2>���<br>����</td>
</tr>
<tr bgcolor="{{$m_arr.header_bgcolor}}" align="center">
<td>����y��</td>
<td>�^�y</td>
<td>���g�y��</td>
<td>����</td>
</tr>

{{foreach from=$student_data item=data key=sn}}
<tr align="center">
<td>{{$data.class_name}}</td>
<td>{{$data.seme_num}}</td>
<td>{{$data.stud_id}}</td>
<td>{{$data.stud_name}}</td>

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

{{/foreach}}
</table>
{{if $m_arr.print_sign_row}}<br>{{$m_arr.sign_row}}{{/if}}

<br style="page-break-before:always;">

<P align="center" style='font-size:{{$m_arr.title_font_size}}; font-family:{{$m_arr.title_font_name}}'>{{$school_long_name}}<br>{{$show_year.0}}�Ǧ~��{{$show_seme.0}}�Ǵ�{{$year_name}}�~��{{$m_arr.title}}</P>
<table border='2' cellpadding='3' cellspacing='0' style='border-collapse:collapse; font-size:{{$m_arr.text_size}};' bordercolor='#111111' width='100%'>
<tr bgcolor="{{$m_arr.header_bgcolor}}" align="center">
<td rowspan=2 width={{$m_arr.class_width}}>�Z��</td>
<td rowspan=2 width={{$m_arr.num_width}}>�y��</td>
<td rowspan=2 width={{$m_arr.id_width}}>�Ǹ�</td>
<td rowspan=2 width={{$m_arr.name_width}}>�m�W</td>
<td colspan=4>��`�ͬ���{</td>
</tr>
<tr bgcolor="{{$m_arr.header_bgcolor}}" align="center">
<td>��`�欰</td>
<td>���鬡��</td>
<td>���@�A��</td>
<td>�S���{</td>
</tr>

{{foreach from=$student_data item=data key=sn}}
<tr align="center">
<td>{{$data.class_name}}</td>
<td>{{$data.seme_num}}</td>
<td>{{$data.stud_id}}</td>
<td>{{$data.stud_name}}</td>
<td align='left'>{{$student_data.$sn.nor.0}}</td>
<td align='left'>{{$student_data.$sn.nor.1}}</td>
<td align='left'>{{$student_data.$sn.nor.2}}{{$student_data_nor.$sn.nor.3}}</td>
<td align='left'>{{$student_data.$sn.nor.4}}{{$student_data_nor.$sn.nor.5}}</td>
</tr>

{{/foreach}}
</table>


{{/if}}
{{if $m_arr.print_sign_row}}<br>{{$m_arr.sign_row}}{{/if}}
</body>
</html>
