{{* $Id: health_bodymind_gr.tpl 5589 2009-08-17 10:27:40Z brucelyc $ *}}
<script src="js/DropDownControl.js" language="javascript"></script>
<link href="js/DropDownControl.css" rel="stylesheet" type="text/css"/>
{{* ���߻�ê��U *}}
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="7" style="color:white;text-align:center;">���߻�ê��U</td>
</tr>
<tr bgcolor="#f4feff">
<td>�y��</td><td>�m�W</td><td>�E�_�N��</td><td>�e�f�W��</td><td>����</td><td>�\��ﶵ</td>
</tr>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=seme_class value=$smarty.post.class_name}}
{{foreach from=$health_data->stud_data.$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
{{if $health_data->stud_base.$sn.bodymind}}
{{assign var=ddd value=$health_data->stud_base.$sn.bodymind.bm_id}}
{{assign var=lv value=$health_data->stud_base.$sn.bodymind.bm_level}}
<tr style="background-color:white;">
<td style="text-align:center;">{{$seme_num}}</td>
<td style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};">{{$health_data->stud_base.$sn.stud_name}}</td>
<td>{{$ddd}}</td>
<td>{{$bodymind_kind_arr.$ddd}}</td>
<td>{{$bodymind_level_arr.$lv}}</td>
<td><input type="image" src="images/edit.gif" alt="�s��o�����" OnClick="document.getElementById('act').value='bodymind_st';document.getElementById('sn').value='{{$sn}}';document.myform.target='new';document.myform.submit();"> <input type="image" src="images/delete.gif" alt="�R���o�����" OnClick="document.getElementById('del').name='del[{{$sn}}][health_bodymind][bm_id]';document.getElementById('del').value='{{$ddd}}';document.myform.submit();"></td>
</tr>
{{else}}
<tr style="background-color:white;">
<td style="text-align:center;">{{$seme_num}}</td>
<td style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};">{{$health_data->stud_base.$sn.stud_name}}</td>
<td>---</td>
<td>-----</td>
<td>-----</td>
<td><input type="image" src="images/edit.gif" alt="�s��o�����" OnClick="document.getElementById('act').value='bodymind_st';document.getElementById('sn').value='{{$sn}}';document.myform.target='new';document.myform.submit();"></td>
</tr>
{{/if}}
{{foreachelse}}
<tr bgcolor="white">
<td colspan="7" style="text-align:center;color:blue;">�L���</td>
</tr>
{{/foreach}}
</table>

</td></tr>
<input type="hidden" name="sub_menu_id" value="{{$smarty.post.sub_menu_id}}">
<input type="hidden" name="year_seme" value="{{$smarty.post.year_seme}}">
<input type="hidden" name="class_name" value="{{$smarty.post.class_name}}">
<input type="hidden" id="sn" name="student_sn" value="">
<input type="hidden" id="act" name="act" value="">
{{if !$smarty.post.edit}}
<input type="hidden" id="del" name="aaa" value="">
{{/if}}
</form></table>
</td></tr></table>
</td></tr></table>
</td>
</tr>
</form>
</table>
