{{* $Id: fitness_print_html.tpl 7069 2013-01-13 08:10:57Z smallduh $ *}}
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>��A����禨�Z��</title>
</head>
<style type="text/css">
<!--
td {
	font-size:10pt;
}
-->
</style>
<body>
<center>
<table border="0" cellspacing="0" cellpadding="0" width="610">
<tr align="right">
<td align="center" style="font-size: 16pt;font-family: �з���;font-weight: bold;">{{$sch.sch_cname}}{{$sel_year}}�Ǧ~�ײ�{{$sel_seme}}�Ǵ�<br>{{$class_arr.$class_num}}��A����禨�Z��<br>
<table cellspacing="0" cellpadding="0" width="100%">
<tr style="text-align:center;">
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 1.5pt;">�y<br>��</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;">�m�W</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;">�ͤ�</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">����<br>(cm)[%]</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">�魫<br>(kg)[%]</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">BMI����<br>(kg/m<sup>2</sup>)[%]</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">�����e�s<br>(cm)[%]</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">�ߩw����<br>(cm)[%]</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">���װ_��<br>(��)[%]</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;">{{if $IS_JHORES==0}}800{{else}}1600{{/if}}����<br>(��)[%]</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;">�~��</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;">����<br>�~��</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;">����</td>
</tr>
{{foreach from=$rowdata item=d key=i name=fdrows}}
{{assign var=sn value=$d.student_sn}}
<tr style="text-align:right;">
{{if $smarty.foreach.fdrows.iteration mod 5 == 1}}
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 1.5pt;">{{$d.seme_num}}</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;text-align:left;">{{$d.stud_name}}</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;">{{$d.stud_birthday}}</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$fd.$sn.tall}}[{{$fd.$sn.prec_t}}]</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$fd.$sn.weigh}}[{{$fd.$sn.prec_w}}]</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$fd.$sn.bmt}}[{{$fd.$sn.prec_b}}]</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$fd.$sn.test1}}[{{$fd.$sn.prec1}}]</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$fd.$sn.test3}}[{{$fd.$sn.prec3}}]</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$fd.$sn.test2}}[{{$fd.$sn.prec2}}]</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;">{{$fd.$sn.test4}}[{{$fd.$sn.prec4}}]</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;text-align:center;">{{$fd.$sn.age}}</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;text-align:center;">{{$fd.$sn.test_y}}-{{$fd.$sn.test_m}}</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;text-align:center;">{{if $fd.$sn.reward}}{{$fd.$sn.reward}}{{else}}--{{/if}}</td>
{{else}}
<td style="border-style: solid; border-width: 0.75pt 1.5pt 0pt 1.5pt;">{{$d.seme_num}}</td>
<td style="border-style: solid; border-width: 0.75pt 1.5pt 0pt 0pt;text-align:left;">{{$d.stud_name}}</td>
<td style="border-style: solid; border-width: 0.75pt 1.5pt 0pt 0pt;">{{$d.stud_birthday}}</td>
<td style="border-style: solid; border-width: 0.75pt 0.75pt 0pt 0pt;">{{$fd.$sn.tall}}[{{$fd.$sn.prec_t}}]</td>
<td style="border-style: solid; border-width: 0.75pt 0.75pt 0pt 0pt;">{{$fd.$sn.weigh}}[{{$fd.$sn.prec_w}}]</td>
<td style="border-style: solid; border-width: 0.75pt 0.75pt 0pt 0pt;">{{$fd.$sn.bmt}}[{{$fd.$sn.prec_b}}]</td>
<td style="border-style: solid; border-width: 0.75pt 0.75pt 0pt 0pt;">{{$fd.$sn.test1}}[{{$fd.$sn.prec1}}]</td>
<td style="border-style: solid; border-width: 0.75pt 0.75pt 0pt 0pt;">{{$fd.$sn.test3}}[{{$fd.$sn.prec3}}]</td>
<td style="border-style: solid; border-width: 0.75pt 0.75pt 0pt 0pt;">{{$fd.$sn.test2}}[{{$fd.$sn.prec2}}]</td>
<td style="border-style: solid; border-width: 0.75pt 1.5pt 0pt 0pt;">{{$fd.$sn.test4}}[{{$fd.$sn.prec4}}]</td>
<td style="border-style: solid; border-width: 0.75pt 1.5pt 0pt 0pt;text-align:center;">{{$fd.$sn.age}}</td>
<td style="border-style: solid; border-width: 0.75pt 1.5pt 0pt 0pt;text-align:center;">{{$fd.$sn.test_y}}-{{$fd.$sn.test_m}}</td>
<td style="border-style: solid; border-width: 0.75pt 1.5pt 0pt 0pt;text-align:center;">{{if $fd.$sn.reward}}{{$fd.$sn.reward}}{{else}}--{{/if}}</td>
{{/if}}
</tr>
{{/foreach}}
{{foreach from=$avg item=d key=i}}
<tr style="text-align:right;">
<td colspan="3" style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 1.5pt;">{{$avg_title.$i}}����</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$d.a_tall|@round:1}}</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$d.a_weigh|@round:1}}</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$d.a_bmt|@round:1}}</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$d.a_test1|@round:1}}</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$d.a_test3|@round:1}}</td>
<td style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;">{{$d.a_test2|@round:1}}</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;">{{$d.a_test4|@round:1}}</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;text-align:center;">--</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;text-align:center;">---</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;text-align:center;">--</td>
</tr>
{{/foreach}}
<tr style="text-align:right;">
<td colspan="3" style="border-style: solid; border-width: 1.5pt;">50�H�H�W�H��</td>
{{foreach from=$cou item=d name=cou}}
{{if $smarty.foreach.cou.last==$smarty.foreach.cou.iteration}}
<td style="border-style: solid; border-width: 1.5pt 1.5pt 1.5pt 0pt;">{{$d}}</td>
{{else}}
<td style="border-style: solid; border-width: 1.5pt 0.75pt 1.5pt 0pt;">{{$d}}</td>
{{/if}}
{{/foreach}}
<td style="border-style: solid; border-width: 1.5pt 1.5pt 1.5pt 0pt;text-align:center;">--</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 1.5pt 0pt;text-align:center;">---</td>
<td style="border-style: solid; border-width: 1.5pt 1.5pt 1.5pt 0pt;text-align:center;">--</td>
</tr>
</table>
</td></tr></table>
</body></html>
