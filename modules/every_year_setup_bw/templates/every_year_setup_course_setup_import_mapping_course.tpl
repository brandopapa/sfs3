{{* $Id: every_year_setup_course_setup_import_mapping_course.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<table bgcolor="#9EBCDD" cellspacing="1" cellpadding="4">
<tr bgcolor="#FFFFFF">
<td class="title_sbody1" nowrap style="text-align:left;">�m�����ҵ{��ơn<br><font color="red">�]�Х��I��u�פJ�ҵ{��ơv�A�I��u�t�νҵ{��ơv�^</font><br>
{{foreach from=$class_year item=d key=i}}{{if $snum.$i>0}}<input type="radio" name="c_year" value="{{$i}}" {{if $smarty.post.c_year==$i}}checked{{/if}} OnClick="this.form.submit();">{{$d}}��<font color="red">({{$snum.$i}}�`)</font> {{/if}}{{/foreach}}<br>
<br>
<table><tr class="title_sbody1">
<td align="left" valign="top">
<fieldset>
<legend>�פJ�ҵ{���</legend>
{{assign var=k value=0}}
{{foreach from=$s_data item=d key=i name=s_data}}
{{if $unmappings.os_id.$i && $k==0}}
{{assign var=chk value=1}}
{{assign var=k value=1}}
{{else}}
{{assign var=chk value=0}}
{{/if}}
<input type="radio" name="in_sel" value="{{$i}}" {{if $chk==1}}checked{{/if}} {{if $unmappings.os_id.$i==""}}disabled{{/if}}><font color="{{if $unmappings.os_id.$i}}#003366{{else}}#66CCFF{{/if}}">{{$d}}({{$i}})</font><font color="red">(�@{{if $so_data.$i==""}}0{{else}}{{$so_data.$i}}{{/if}}�`)</font><input type="image" name="clean_os_id[{{$i}}]" src="images/del.png" alt="�R��{{$d}}������"><br>
{{/foreach}}
</fieldset>
</td>
<td align="left" valign="top">
<fieldset>
<legend>�t�νҵ{���</legend>
{{foreach from=$ss_data item=d key=i}}
{{assign var=m value=$d.scope_id}}
{{assign var=n value=$d.subject_id}}
<input type="radio" name="map_sel" value="{{$i}}" OnClick="this.form.submit();">{{if $d.class_id==""}}<font color="blue">[{{$d.class_year}}�~�ť��~�Žҵ{]</font>{{else}}<font color="red">[{{$d.class_year}}�~��{{$d.class_id|@substr:-2:2}}�Z�ҵ{]</font>{{/if}} {{$sb_data.$m}}{{if $n}}-{{$sb_data.$n}}{{/if}}<font color="red">({{if $sm_data.$i==""}}0{{else}}{{$sm_data.$i}}{{/if}}�`)</font><input type="image" name="clean_ss_id[{{$i}}]" src="images/del.png" alt="�R��{{$d}}������"><br>
{{/foreach}}
</fieldset>
</td>
<td align="left" valign="top">
<fieldset>
<legend>�\��ﶵ</legend>
<input type="submit" name="clean" value="�M���Ҧ��������"><br>
<input type="submit" name="status" value="�^��������A"><br>
</fieldset>
<fieldset>
<legend>���{{if $unmappings>0 || $mappings==0}}��{{else}}�w{{/if}}��������</legend>
<font color="red">�|�����������ҵ{�G{{$unmappings.subject}}��</font><br>
<font color="red">�|�������`�ơG{{$unmappings.sector}}�`</font><br>
</fieldset>
</td></tr></table>
</td></tr>
<input type="hidden" name="act" value="�i��ҵ{����">
<input type="hidden" name="year_seme" value="{{$sel_year}}-{{$sel_seme}}">
<input type="hidden" name="import" value="1">
</table>
