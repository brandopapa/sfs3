{{* $Id: stud_grad_grad_score_print.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>{{if $smarty.post.years==5}}���Ǵ�{{else}}���~{{/if}}���Z��</title>
</head>

<body>
{{foreach from=$student_sn item=sn key=site_num name=ss}}
{{if $smarty.foreach.ss.iteration % 4 == 1}}
<table border="0" cellspacing="0" cellpadding="0" width="610" {{if ($smarty.foreach.ss.iteration+4)<$stud_num }}style="page-break-after: always"{{/if}}>
<tr align="right">
<td colspan="{{$ss_num+5}}"><b>{{$class_base[$seme_class]}} {{if $smarty.post.years==5}}���Ǵ�{{else}}���~{{/if}}���Z��@�@�@�@�@ <font size="1" style="font-size: 10pt">�C�L����G{{$smarty.now|date_format}}</font></b></td>
</tr>
<tr align="center">
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 1.5pt;"><font size="1" style="font-size: 8pt">�y��</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 8pt">�Ǹ�</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 8pt">�m�W</font></td>
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 8pt">�ǲ߻��</font></td>
{{foreach from=$show_year item=i key=j}}
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 8pt">{{$i}}{{if $jos!=0}}�Ǧ~��<br>��{{/if}}{{if $jos!=0}}{{$show_seme[$j]}}�Ǵ�{{else}}{{if $show_seme[$j]==1}}�W{{else}}�U{{/if}}{{/if}}</font></td>
{{/foreach}}
<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 0.75pt;"><font size="1" style="font-size: 8pt">�U���<br>����</font></td>
<td style="border-style:solid; border-width:1.5pt 1.5pt 1.5pt 0.75pt;"><font size="1" style="font-size: 8pt">�`����</font></td>
</tr>
{{/if}}
{{foreach from=$ss_link item=sl name=ss_link}}
<tr align="center">
{{if $smarty.foreach.ss_link.iteration == 1}}
<td {{if $ss_num > 1}}rowspan="{{$ss_num+1}}"{{/if}} style="border-style:solid; border-width:0pt 0.75pt 1.5pt 1.5pt;">{{$site_num}}</td>
<td {{if $ss_num > 1}}rowspan="{{$ss_num+1}}"{{/if}} style="border-style:solid; border-width:0pt 0.75pt 1.5pt 0pt;">{{$stud_id[$site_num]}}</td>
<td {{if $ss_num > 1}}rowspan="{{$ss_num+1}}"{{/if}} style="border-style:solid; border-width:0pt 0.75pt 1.5pt 0pt;">{{$stud_name[$site_num]}}</td>
{{/if}}
<td align="left" style="border-style:solid; border-width:0pt 0.75pt 0.75pt 0pt;"><font size="1" style="font-size: 8pt">&nbsp;{{$link_ss[$sl]}}</font></td>
{{foreach from=$semes item=si key=sj}}
<td style="border-style:solid; border-width:0pt 0.75pt 0.75pt 0pt;">{{if $fin_score.$sn.$sl.$si.score == ""}}---{{else}}{{$fin_score.$sn.$sl.$si.score}}{{/if}}</td>
{{/foreach}}
{{if $sl!="local" and $sl!="english"}}
<td {{if $sl=="chinese"}}rowspan="3"{{/if}} style="border-style:solid; border-width:0pt 0.75pt 0.75pt 0.75pt;">{{if $sl=="chinese"}}{{$fin_score.$sn.language.avg.score}}{{else}}{{if $fin_score.$sn.$sl.avg.score == ""}}---{{else}}{{$fin_score.$sn.$sl.avg.score}}{{/if}}{{/if}}</td>
{{/if}}
{{if $sl=="chinese"}}<td rowspan="{{$ss_num}}" style="border-style:solid; border-width:0pt 1.5pt 0.75pt 0.75pt;">{{$fin_score.$sn.avg.score}}<br>({{$fin_score.$sn.avg.str}})</td>{{/if}}
{{if $ss_num==1 and ($sl=="basic" or $sl=="live" or $sl=="mylife")}}<td style="border-style:solid; border-width:0pt 1.5pt 0.75pt 0.75pt;">{{$fin_score.$sn.avg.score}}<br>({{$fin_score.$sn.avg.str}})</td>{{/if}}
</tr>
{{/foreach}}
{{if $ss_num > 1}}
<tr align="center">
<td align="left" style="border-style:solid; border-width:0pt 0.75pt 1.5pt 0pt;"><font size="1" style="font-size: 8pt">&nbsp;���`�ͬ���{</font></td>
{{foreach from=$semes item=si key=sj}}
<td style="border-style:solid; border-width:0pt 0.75pt 1.5pt 0pt;">{{if $fin_nor_score.$sn.$si.score == ""}}---{{else}}{{$fin_nor_score.$sn.$si.score}}{{/if}}</td>
{{/foreach}}
<td style="border-style:solid; border-width:0pt 0.75pt 1.5pt 0.75pt;">{{if $fin_nor_score.$sn.avg.score == ""}}---{{else}}{{$fin_nor_score.$sn.avg.score}}{{/if}}</td>
<td style="border-style:solid; border-width:0pt 1.5pt 1.5pt 0.75pt;">---</td>
</tr>
{{/if}}
{{if $smarty.foreach.ss.iteration % 4 == 0 || $smarty.foreach.ss_link.iteration == $stud_num}}
</table>
{{/if}}
{{/foreach}}
</body>
</html>
