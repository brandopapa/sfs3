<html>
<head>
<meta http-equiv="Content-Language" content="zh-tw">
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>{{$report_title}}</title>
</head>
<body>
{{foreach from=$stud_data item=d key=i}}
<p align="center"><font size="5" face="�з���">{{$report_title}}</font></p>
<table border="0" width="100%" id="table1">
	<tr>
		<td height="31" colspan="2"><font face="�з���">�NŪ�ꤤ�G<font color="{{$data_color}}"><b><u>{{$school_long_name}}</u></b></font></font></td>
		<td height="31" width="43%"><font face="�з���">�NŪ�ꤤ�N�X�G<font color="{{$data_color}}"><b><u>{{$sch_id}}</u></b></font></font></td>
	</tr>
	<tr>
		<td width="26%"><font face="�з���">�Z�šG<font color="{{$data_color}}"><b><u>{{$d.class_id}}</u></b></font></font></td>
		<td width="31%"><font face="�з���">�m�W�G<font color="{{$data_color}}"><b><u>{{$d.stud_name}}</u></b></font></font></td>
		<td width="43%"><font face="�з���">�����ҲΤ@�s���G<font color="{{$data_color}}"><b><u>{{$d.stud_person_id}}</u></b></font></font></td>
	</tr>
</table>
<div align="center">
	<table  border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr>
			<td colspan="2" align="center" height="41" bgcolor="{{$header_bgcolor}}">��Ƕ���</td>
			<td width="65%" align="center" height="41" bgcolor="{{$header_bgcolor}}">�n���ֺ⻡��</td>
			<td width="8%" align="center" height="41" bgcolor="{{$header_bgcolor}}">�涵<br>�n��</td>
			<td width="9%" align="center" height="41" bgcolor="{{$header_bgcolor}}">��Ƕ��ؿn��</td>
		</tr>
		<tr>
			<td rowspan="4" align="center" width="4%">�h���ǲߪ�{</td>
			<td align="center" width="12%" height="43">�v�@�@��</td>
			<td width="65%" align="left" height="43">{{foreach from=$competetion_score.$i.detail item=data key=k}}<li>({{$level_array[$data.level]}}-{{$squad_array[$data.squad]}}){{$data.name}}�G{{$data.rank}}</li>{{/foreach}}</td>
			<td width="8%" align="center" height="43"><i>
			<font size="4" color="{{$data_color}}">{{if $competetion_score.$i.score}}{{$competetion_score.$i.score}}{{else}}0{{/if}}</font></i></td>
			<td width="9%" align="center" rowspan="4"><b>
			<font size="5" color="{{$data_color}}">{{$diversification_score.$i}}</font></b></td>
		</tr>
		<tr>
			<td align="center" width="12%" height="68">�A�Ⱦǲ�</td>
			<td width="65%" align="left" height="68">����Z�ŷF���B�p�Ѯv�Ϊ��ηF����
			<font color="{{$data_color}}" size="4"><b><u>{{if $service_score.$i.leader}}{{$service_score.$i.leader}}{{else}}0{{/if}}</u></b></font> �Ǵ��C<br>�ѥ[�դ��A�Ⱦǲ߽ҵ{�ά��ʡA�Ω󰲤�B�H���������ѥ[�Ӥu�A�ȩΪ��ϪA�ȡG��  
			<font color="{{$data_color}}" size="4"><b><u>{{if $service_score.$i.hours}}{{$service_score.$i.hours}}{{else}}0{{/if}}</u></b></font> �p�ɡC</td>
			<td width="8%" align="center" height="68"><i>
			<font size="4" color="{{$data_color}}">{{$service_score.$i.bonus}}</font></i></td>
		</tr>
		<tr>
			<td align="center" width="12%" height="49">��`�ͬ�<br>��{���q</td>
			<td width="65%" align="left" height="49"> 
			�֭p�ż� <font color="{{$data_color}}" size="4"><b><u>{{if $fault_score.$i.1}}{{$fault_score.$i.1}}{{else}}0{{/if}}</u></b></font> 
			���A�p�\ <font color="{{$data_color}}" size="4"><b><u>{{if $fault_score.$i.3}}{{$fault_score.$i.3}}{{else}}0{{/if}}</u></b></font> ���A�j�\ 
			<font color="{{$data_color}}" size="4"><b><u>{{if $fault_score.$i.9}}{{$fault_score.$i.9}}{{else}}0{{/if}}</u></b></font> ���F<br>�@�@ĵ�i 
			<font color="{{$data_color}}" size="4"><b><u>{{if $fault_score.$i.a}}{{$fault_score.$i.a}}{{else}}0{{/if}}</u></b></font> ���A�p�L 
			<font color="{{$data_color}}" size="4"><b><u>{{if $fault_score.$i.b}}{{$fault_score.$i.b}}{{else}}0{{/if}}</u></b></font> ���A�j�L 
			<font color="{{$data_color}}" size="4"><b><u>{{if $fault_score.$i.c}}{{$fault_score.$i.c}}{{else}}0{{/if}}</u></b></font> ���C</td>
			<td width="8%" align="center" height="49"><i>
			<font size="4" color="{{$data_color}}">{{if $fault_score.$i.bonus}}{{$fault_score.$i.bonus}}{{else}}0{{/if}}</font></i></td>
		</tr>
		<tr>
			<td align="center" width="12%" height="88">�� �A ��</td>
			<td width="65%" align="left" height="88">�٭@�O  
			<font color="{{$data_color}}" size="4"><b><u>{{if $fitness_score.$i.2}}�F{{else}}���F{{/if}}</u></b></font> ���e�зǡC<br>�X�n��  
			<font color="{{$data_color}}" size="4"><b><u>{{if $fitness_score.$i.1}}�F{{else}}���F{{/if}}</u></b></font> ���e�зǡC<br>���o�O  
			<font color="{{$data_color}}" size="4"><b><u>{{if $fitness_score.$i.3}}�F{{else}}���F{{/if}}</u></b></font> ���e�зǡC<br>�ߪͭ@�O  
			<font color="{{$data_color}}" size="4"><b><u>{{if $fitness_score.$i.4}}�F{{else}}���F{{/if}}</u></b></font> ���e�зǡC</td>
			<td width="8%" align="center" height="88"><i>
			<font size="4" color="{{$data_color}}">{{if $fitness_score.$i.bonus}}{{$fitness_score.$i.bonus}}{{else}}0{{/if}}</font></i></td>
		</tr>
		<tr>
			<td colspan="2" align="center" height="33">�����u�}</td>
			<td width="65%" align="left" height="33">�����Ш|�ҵ{�����`���Z 
			 
			<font color="{{$data_color}}" size="4"><b><u>{{if $particular_score.$i.score}}{{$particular_score.$i.score}}{{else}}0{{/if}}</u></b></font> ���C</td>
			<td width="8%" align="center" height="33"><i>
			<font size="4" color="{{$data_color}}">{{$particular_score.$i.bonus}}</font></i></td>
			<td width="9%" align="center" height="33"><b>
			<font size="5" color="{{$data_color}}">{{$particular_score.$i.bonus}}</font></b></td>
		</tr>
		<tr>
			<td colspan="2" align="center" height="35">�z�ը���</td>
			<td width="65%" align="left" height="35">{{if $disadvantage_score.$i.score}}��<font color="{{$data_color}}"> <b>
			<u><font size="4">{{$disadvantage_score.$i.disadvantage_name}}</font></u></b> </font>�����C{{/if}}</td>
			<td width="8%" align="center" height="35"><i>
			<font size="4" color="{{$data_color}}">{{$disadvantage_score.$i.score}}</font></i></td>
			<td width="9%" align="center" height="35"><b>
			<font size="5" color="{{$data_color}}">{{$disadvantage_score.$i.score}}</font></b></td>
		</tr>
		<tr>
			<td colspan="2" align="center" height="69">���žǲ�</td>
			<td width="65%" align="left" height="69">���d�P��|5�Ǵ��������Z			 
			<font color="{{$data_color}}" size="4"><b><u>{{$balance_area_score.$i.health.avg}}</u></b></font> ���C<br>���N�P�H��5�Ǵ��������Z  
			<font color="{{$data_color}}" size="4"><b><u>{{$balance_area_score.$i.art.avg}}</u></b></font> ���C<br>��X����5�Ǵ��������Z  
			<font color="{{$data_color}}" size="4"><b><u>{{$balance_area_score.$i.complex.avg}}</u></b></font> ���C</td>
			<td width="8%" align="center" height="69"><i>
			<font size="4" color="{{$data_color}}">{{$balance_score_t.$i.score}}</font></i></td>
			<td width="9%" align="center" height="69"><b>
			<font size="5" color="{{$data_color}}">{{$balance_score_t.$i.score}}</font></b></td>
		</tr>
		<tr>
			<td colspan="2" align="center" height="83">�A�ʻ���</td>
			<td width="65%" align="left" height="83">�ꤤ�ǥͥͲP���ɬ�����U<span style="font-size: 12.0pt; font-family: �s�ө���">�u�ͲP�o�i�W���ѡv��</span><span style="font-family: �s�ө���"><br>�a���N��  
			</span><u><font color="{{$data_color}}"><b><font size="4">{{if $personality_score.$i.score_adaptive_domicile}}�Ŀ�{{else}}���Ŀ�{{/if}}</font> </b>
			</font></u><span style="font-family: �s�ө���">���M</span>�C<span style="font-family: �s�ө���"><br>�ɮv�N��  
			</span><u><font color="{{$data_color}}" size="4"><b>{{if $personality_score.$i.score_adaptive_tutor}}�Ŀ�{{else}}���Ŀ�{{/if}}</b></font></u><span style="font-family: �s�ө���"> 
			���M</span>�C<span style="font-family: �s�ө���"><br>���ɱЮv�N�� </span><u>
			<font color="{{$data_color}}" size="4"><b>{{if $personality_score.$i.score_adaptive_guidance}}�Ŀ�{{else}}���Ŀ�{{/if}}</b></font></u><span style="font-family: �s�ө���"> 
			���M</span>�C</td>
			<td width="8%" align="center" height="83"><i>
			<font size="4" color="{{$data_color}}">{{$personality_score.$i.bonus}}</font></i></td>
			<td width="9%" align="center" height="83"><b>
			<font size="5" color="{{$data_color}}">{{$personality_score.$i.bonus}}</font></b></td>
		</tr>
		<tr>
			<td colspan="2" align="center" bgcolor="{{$header_bgcolor}}" height="50"><font size="4" face="�з���">�X�@�@�@�p</font></td>
			<td>
			</td>
			<td align="center">
			</td>
			<td width="9%" align="center"><b><font size="5" color="{{$data_color}}">{{$diversification_score.$i+$particular_score.$i.bonus+$disadvantage_score.$i.score+$balance_score_t.$i.score+$personality_score.$i.bonus}}</font></b></td>
		</tr>
	</table>
</div>
<p>�@</p>
<p><font size="5" face="�з���"><b>�NŪ�ꤤ�Ǯ��W���G</b></font></p>
<p style="page-break-after: always">
{{/foreach}}
</body>

</html>
