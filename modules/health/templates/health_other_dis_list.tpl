{{* $Id: health_other_dis_list.tpl 5694 2009-10-20 07:16:16Z brucelyc $ *}}

<input type="submit" name="xls" value="�ץXXLS��">
<input type="submit" name="ods" value="�ץXODS��">
<input type="submit" name="edit" value="�s�׸��">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�~��</td>
<td>�Z��</td>
<td>�y��</td>
<td>�m�W</td>
<td>�e�f</td>
<td>���z</td>
<td>���@</td>
</tr>
{{foreach from=$health_data->stud_base item=d key=sn}}
{{if $d.disease}}
{{foreach from=$d.disease item=dd}}
{{assign var=year_name value=$d.seme_class|@substr:0:-2}}
{{assign var=class_name value=$d.seme_class|@substr:-2:2}}
<tr style="background-color:white;">
<td style="background-color:#f4feff;">{{$year_name}}</td>
<td style="background-color:#f4feff;">{{$class_name}}</td>
<td style="background-color:#f4feff;">{{$d.seme_num}}</td>
<td style="color:{{if $d.stud_sex==1}}blue{{elseif $d.stud_sex==2}}red{{else}}black{{/if}};background-color:#fbf8b9;">{{$d.stud_name}}</td>
<td>{{$disease_kind_arr.$dd}}</td>
<td>{{$health_data->stud_base.$sn.status_record.disease.$dd}}</td>
<td>{{$health_data->stud_base.$sn.diag_record.disease.$dd}}</td>
</tr>
{{/foreach}}
{{/if}}
{{/foreach}}
</table>
<input type="submit" name="xls" value="�ץXXLS��">
<input type="submit" name="ods" value="�ץXODS��">
