{{* $Id: health_whole_renew1.tpl 5708 2009-10-23 15:33:08Z brucelyc $ *}}

<form action="{{$smarty.server.SCRIPT_NAME}}" method="post" target="_blank">
{{assign var=sn value=$smarty.post.student_sn}}

{{* ���d�򥻸�� *}}
<table style="background-color:#9ebcdd;" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="2" style="color:white;">���d�򥻸��</td>
</tr>
<tr style="background-color:#f4feff;">
<td><input type="image" src="images/edit.gif" OnClick="this.form.act.value='disease_st';">�ӤH�e�f�v</td>
<td>
{{foreach from=$health_data->stud_base.$sn.disease item=dd name=dis}}
{{$smarty.foreach.dis.iteration}}. {{$disease_kind_arr.$dd}}<br>
{{foreachelse}}
�L
{{/foreach}}
</td>
</tr>
<tr style="background-color:white;">
<td><input type="image" src="images/edit.gif" OnClick="this.form.act.value='serious_st';">���j�˯f�d</td>
<td>
{{foreach from=$health_data->stud_base.$sn.serious item=dd name=dis}}
{{$smarty.foreach.dis.iteration}}. {{$serious_kind_arr.$dd}}<br>
{{foreachelse}}
�L
{{/foreach}}
</td>
</tr>
<tr style="background-color:#f4feff;">
<td nowrap><input type="image" src="images/edit.gif" OnClick="this.form.act.value='bodymind_st';">���߻�ê��U</td>
<td>
{{if $health_data->stud_base.$sn.bodymind}}
{{assign var=dd value=$health_data->stud_base.$sn.bodymind.bm_id}}
{{assign var=lv value=$health_data->stud_base.$sn.bodymind.bm_level}}
{{$bodymind_kind_arr.$dd}}<br><span style="color:blue;">({{$bodymind_level_arr.$lv}})</span>
{{else}}
�L
{{/if}}
</td>
</tr>
<tr style="background-color:white;">
<td><input type="image" src="images/edit.gif" OnClick="this.form.act.value='inherit_st';">�a�گe�f�v</td>
<td>
{{foreach from=$health_data->stud_base.$sn.inherit item=dd key=i}}
{{$folk_kind_arr.$i}}-{{$hereditary_disease_kind_arr.$dd}}<br>
{{foreachelse}}
�L
{{/foreach}}
</td>
</tr>
<tr style="background-color:#f4feff;">
<td><input type="image" src="images/edit.gif" OnClick="this.form.act.value='hospital_st';">�@�e��|</td>
<td>
{{foreach from=$health_data->stud_base.$sn.hospital item=dd name=hospital}}
{{assign var=id value=$dd|string_format:"%02d"}}
{{$smarty.foreach.hospital.iteration}}.{{$hos_arr.$id}}<br>
{{foreachelse}}
����J
{{/foreach}}
</td>
</tr>
<tr style="background-color:white;">
<td><input type="image" src="images/edit.gif" OnClick="this.form.act.value='insurance_st';">�O�I</td>
<td>
{{foreach from=$health_data->stud_base.$sn.insurance item=dd key=i name=insurance}}
{{$smarty.foreach.insurance.iteration}}.{{$ins_arr.$i}}<br>
{{foreachelse}}
�L
{{/foreach}}
</td>
</tr>
<tr style="background-color:#f4feff;">
<td><input type="image" src="images/edit.gif" OnClick="this.form.act.value='ntu_st';">����P</td>
<td>{{if $health_data->health_data.$sn.ntu==1}}�L����{{elseif $health_data->health_data.$sn.ntu==2}}������{{else}}����J{{/if}}</td>
</tr>
</table>

{{* �b�մ������j�˯f�ƬG *}}
<table style="background-color:#9ebcdd;" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td style="color:white;"><input type="image" src="images/edit.gif" OnClick="this.form.act.value='accserious_st';">�b�մ������j�˯f�ƬG</td>
</tr>
<tr style="background-color:#f4feff;">
<td>���j�˯f:�L</td>
</tr>
</table>
<input type="hidden" name="sub_menu_id" value="{{$smarty.post.sub_menu_id}}">
<input type="hidden" name="year_seme" value="{{$smarty.post.year_seme}}">
<input type="hidden" name="class_name" value="{{$smarty.post.class_name}}">
<input type="hidden" name="student_sn" value="{{$smarty.post.student_sn}}">
<input type="hidden" name="act" value="">
</form>
</div>
