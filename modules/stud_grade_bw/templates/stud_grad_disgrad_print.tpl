{{* $Id: stud_grad_disgrad_print.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>�׷~��ĳ�W��</title>
</head>

<body>
{{foreach from=$show_sn item=sc key=sn name=fs}}
{{if $smarty.foreach.fs.iteration % 40 == 1}}
<table border="0" cellspacing="0" cellpadding="0" width="610" style="page-break-after: always">
<tr align="right">
<td colspan="11"><b>{{if $smarty.post.years==5}}��{{else}}��{{/if}}�Ǵ��ǲ߻�쥭�����Z�b60���H�W�̥��F{{$smarty.post.fail_num}}���W��@�@ <font size="1" style="font-size: 10pt">�C�L����G{{$smarty.now|date_format}}</font></b></td>
</tr>

<tr align="center">
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 1.5pt;"><font size="1" style="font-size: 10pt">�Z��</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">�y��</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">�Ǹ�</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">�m�W</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">�y��</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">�ƾ�</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">�۵M�P�ͬ����</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">���|</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">���d�P��|</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">���N�P�H��</font></td>
<td style="border-style:solid; border-width:1.5pt 1.5pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">��X</font></td>
<td style="border-style:solid; border-width:1.5pt 1.5pt 1.5pt 0pt;"><font size="1" style="font-size: 10pt">�έp</font></td>
</tr>
{{/if}}
<tr align="center">
<td style="border-style:solid; border-width:0pt 0.75pt {{if $smarty.foreach.fs.iteration % 5 == 0 || $smarty.foreach.fs.iteration == $fin_score_num}}1.5{{else}}0.75{{/if}}pt 1.5pt;">{{$sclass[$sn]}}</td>
<td style="border-style:solid; border-width:0pt 0.75pt {{if $smarty.foreach.fs.iteration % 5 == 0 || $smarty.foreach.fs.iteration == $fin_score_num}}1.5{{else}}0.75{{/if}}pt 0pt;">{{$snum[$sn]}}</td>
<td style="border-style:solid; border-width:0pt 0.75pt {{if $smarty.foreach.fs.iteration % 5 == 0 || $smarty.foreach.fs.iteration == $fin_score_num}}1.5{{else}}0.75{{/if}}pt 0pt;">{{$stud_id[$sn]}}</td>
<td style="border-style:solid; border-width:0pt 0.75pt {{if $smarty.foreach.fs.iteration % 5 == 0 || $smarty.foreach.fs.iteration == $fin_score_num}}1.5{{else}}0.75{{/if}}pt 0pt;">{{$stud_name[$sn]}}</td>
{{foreach from=$show_ss item=ssn key=ss name=sss}}
<td style="border-style:solid; border-width:0pt {{if $smarty.foreach.sss.iteration == $show_ss_num}}1.5{{else}}0.75{{/if}}pt {{if $smarty.foreach.fs.iteration % 5 == 0 || $smarty.foreach.fs.iteration == $fin_score_num}}1.5{{else}}0.75{{/if}}pt 0pt;">{{$fin_score.$sn.$ss.avg.score}}</td>
{{/foreach}}
<td style="border-style:solid; border-width:0pt 0.75pt {{if $smarty.foreach.fs.iteration % 5 == 0 || $smarty.foreach.fs.iteration == $fin_score_num}}1.5{{else}}0.75{{/if}}pt 0pt;">{{$fin_score.$sn.ng}}</td>
</tr>
{{if $smarty.foreach.fs.iteration % 40 == 0 || $smarty.foreach.fs.iteration == $fin_score_num}}
</table>
{{/if}}
{{/foreach}}
</body>
</html>