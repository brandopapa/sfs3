{{* $Id: score_nor_award.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<tr><td bgcolor='#FFFFFF'>
<form name="menu_form" method="post" action="{{$smarty.server.PHP_SELF}}">
<table width="100%">
<tr>
<td>{{$year_seme_menu}} {{$class_year_menu}}</td>
</tr>
{{if $smarty.post.year_name}}
<tr><td>
<table border="0" cellspacing="1" cellpadding="4" width="100%" bgcolor="#cccccc" class="main_body">
<tr bgcolor="#E1ECFF" align="center">
<td>班級</td>
<td>座號</td>
<td>學號</td>
<td>姓名</td>
</tr>
{{foreach from=$show_sn item=sc key=sn}}
<tr bgcolor="#ddddff" align="center">
<td>{{$sclass[$sn]}}</td>
<td>{{$snum[$sn]}}</td>
<td>{{$stud_id[$sn]}}</td>
<td>{{$stud_name[$sn]}}</td>
</tr>
{{/foreach}}
</table>
<br>
<font color="red">註：轉學生不列入統計。</font>
</td></tr>
{{/if}}
</tr>
</table>
</td></tr>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}