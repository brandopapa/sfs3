{{* $Id: *}}
{{strip}}
<TABLE width=100% valign="top">
<TR>
<TD>���</TD>
<TD>���O</TD>
<TD>�֭����</TD>
<TD>�֭���</TD>
<TD {{if $smarty.post.type==1}}class="empty_right"{{/if}}>�֭�帹</TD>
</TR>
{{foreach from=$move_data  item=move_data}}
<TR><TD>{{$move_data.move_date}}</TD>
{{assign var=mid value=$move_data.move_kind}}
<TD>{{$move_kind.$mid}}</TD>
<TD>{{$move_data.move_c_unit}}</TD>
<TD>{{$move_data.move_c_date}}</TD>
<TD {{if $smarty.post.type==1}}class="empty_right"{{/if}}>{{$move_data.move_c_word}}�r<br>{{if $smarty.post.type==1}}<br>{{else}} {{/if}}��{{$move_data.move_c_num}}��
</TD></TR>
{{/foreach}}
</TABLE>
{{/strip}}
