{{* $Id: score_manage_new_scope_tol.tpl 6530 2011-09-21 08:55:51Z infodaes $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<tr><td bgcolor='#FFFFFF'>
<form name="menu_form" method="post" action="{{$smarty.server.PHP_SELF}}">
<table width="100%">
<tr>
<td>{{$year_seme_menu}} {{$class_year_menu}} {{if $smarty.post.year_seme}}{{$class_name_menu}}{{/if}}{{if $smarty.post.me}}
 {{$percision_radio}} <input type="submit" name="friendly_print" value="�͵��C�L">{{/if}}</td>
</tr>
{{if $smarty.post.me}}
<tr><td>
<table border="0" cellspacing="1" cellpadding="4" width="100%" bgcolor="#cccccc" class="main_body">
<tr bgcolor="#E1ECFF" align="center">
<td>�y��</td>
<td>�Ǹ�</td>
<td>�m�W</td>
<td>�ǲ߻��</td>
{{foreach from=$show_year item=i key=j}}
<td>{{$i}}{{if $jos!=0}}�Ǧ~��<br>��{{/if}}{{if $jos!=0}}{{$show_seme[$j]}}�Ǵ�{{else}}{{if $show_seme[$j]==1}}�W{{else}}�U{{/if}}{{/if}}</td>
{{/foreach}}
<td>�U�ǲ߻��<br>����</td>
<td>�`����</td>
</tr>
{{foreach from=$student_sn item=sn key=site_num name=ss}}
{{foreach from=$ss_link item=sl name=ss_link}}
<tr bgcolor="#ddddff" align="center">
{{if $smarty.foreach.ss_link.iteration == 1}}
<td rowspan="{{$ss_num+1}}">{{$site_num}}</td>
<td rowspan="{{$ss_num+1}}">{{$stud_id[$site_num]}}</td>
<td rowspan="{{$ss_num+1}}">{{$stud_name[$site_num]}}</td>
{{/if}}
<td align="left">{{$link_ss[$sl]}}</td>
{{foreach from=$semes item=si key=sj}}
<td>{{if $fin_score.$sn.$sl.$si.score < 60}}<font color="red">{{/if}}{{$fin_score.$sn.$sl.$si.score}}{{if $fin_score.$sn.$sl.$si.score < 60}}</font>{{/if}}</td>
{{/foreach}}
{{if $sl!="local" and $sl!="english"}}
<td {{if $sl=="chinese"}}rowspan="3"{{/if}}>{{if $sl=="chinese"}}{{if $fin_score.$sn.language.avg.score < 60}}<font color="red">{{/if}}{{$fin_score.$sn.language.avg.score}}{{if $fin_score.$sn.language.avg.score < 60}}</font>{{/if}}{{else}}{{if $fin_score.$sn.$sl.avg.score < 60}}<font color="red">{{/if}}{{$fin_score.$sn.$sl.avg.score}}{{if $fin_score.$sn.$sl.avg.score < 60}}</font>{{/if}}{{/if}}</td>
{{if $sl=="chinese"}}<td rowspan="{{$area_rowspan}}">{{if $fin_score.$sn.avg.score < 60}}<font color="red">{{/if}}{{$fin_score.$sn.avg.score}}{{if $fin_score.$sn.avg.score < 60}}</font>{{/if}}<br>({{$fin_score.$sn.avg.str}})</td>{{/if}}
{{/if}}
</tr>
{{/foreach}}
<tr bgcolor="#ddddff" align="center">
<td align="left">��`�ͬ���{</td>
{{foreach from=$semes item=si key=sj}}
<td>{{if $fin_nor_score.$sn.$si.score < 60}}<font color="red">{{/if}}{{$fin_nor_score.$sn.$si.score}}{{if $fin_nor_score.$sn.$si.score < 60}}</font>{{/if}}</td>
{{/foreach}}
<td>{{if $fin_nor_score.$sn.avg.score < 60}}<font color="red">{{/if}}{{$fin_nor_score.$sn.avg.score}}{{if $fin_nor_score.$sn.avg.score < 60}}</font>{{/if}}</td>
<td>---</td>
</tr>
{{/foreach}}
</table>
</td></tr>
{{/if}}
</tr>
</table>
</td></tr>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
