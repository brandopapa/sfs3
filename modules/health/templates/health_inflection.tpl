{{* $Id: health_inflection.tpl 5629 2009-09-07 00:27:32Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<form name="myform" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<tr>
<td style="background-color:white;">
<table class="small"><tr><td>{{$sub_menu}} {{if $smarty.post.sub_menu_id}}{{$year_seme_menu}} {{$class_menu}}{{if $mfile}} {{include file=$mfile}}{{/if}}{{/if}}</td></tr></table>
{{if $ifile}}
{{include file=$ifile}}
{{/if}}
</td>
</tr>
</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
