{{* $Id: every_year_setup_course_setup_import_mapping_teacher.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<table bgcolor="#9EBCDD" cellspacing="1" cellpadding="4">
<tr bgcolor="#FFFFFF">
<td class="title_sbody1" nowrap style="text-align:left;">�m�����Юv��ơn<br><font color="red">�]�Х��I��u�פJ�Юv��ơv�A�I��u�{���Юv��ơv�^</font><br>
<input type="checkbox" name="hide" {{if $smarty.post.hide}}checked{{/if}} OnChange="this.form.submit();">���äw�������u�פJ�Юv��ơv<br><br>
<table><tr class="title_sbody1">
<td align="left" valign="top">
<fieldset>
<legend>�פJ�Юv���</legend>
{{foreach from=$t_data item=d key=i}}
<input type="radio" name="in_sel" value="{{$d.ot_id}}" {{if $i==0}}checked{{/if}}><font color="#336699">{{$d.ot_name}}({{$d.ot_id}})</font> =&gt; ({{if $d.teacher_sn>0}}<font color="{{if $d.sex==1}}blue{{else}}red{{/if}}">{{$d.teacher_name}}</font>{{else}}<font color="hotpink">������</font>{{/if}}) <input type="image" name="clean_one[{{$d.ot_id}}]" src="images/del.png" alt="�R��{{$d.name}}������"><br>
{{/foreach}}
</fieldset>
</td>
<td align="left" valign="top">
<fieldset>
<legend>�{���Юv���</legend>
{{foreach from=$tb_data item=d key=i}}
{{assign var=k value=$d.teach_title_id}}
<input type="radio" name="map_sel" value="{{$d.teacher_sn}}" OnClick="this.form.submit();"><font color="{{if $d.sex==1}}blue{{else}}red{{/if}}">{{$d.name}}</font>({{if $d.class_num!=""}}{{$d.class_num}}{{/if}}{{$tt_data[$k]}})<br>
{{/foreach}}
</fieldset>
</td>
<td align="left" valign="top">
<fieldset>
<legend>�\��ﶵ</legend>
<input type="submit" name="auto" value="�۰ʨ̩m�W����"><br>
<input type="submit" name="clean_teacher" value="�M���Ҧ��������"><br>
<input type="submit" name="status" value="�^��������A"><br>
</fieldset>
<fieldset>
<legend>���{{if $unmappings>0 || $mappings==0}}��{{else}}�w{{/if}}��������</legend>
<font color="red">�|�������Юv�ơG{{$unmappings}}</font><br>
</fieldset>
</td></tr></table>
</td></tr>
<input type="hidden" name="act" value="�i��Юv����">
<input type="hidden" name="year_seme" value="{{$sel_year}}-{{$sel_seme}}">
<input type="hidden" name="import" value="1">
</table>
