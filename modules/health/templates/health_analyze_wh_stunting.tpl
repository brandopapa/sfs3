{{* $Id: health_analyze_wh_stunting.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<table cellspacing="0" cellpadding="0"><tr><td>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="5" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�~��</td>
<td>�Z��</td>
<td>�y��</td>
<td>�m�W</td>
<td>�ʧO</td>
<td>�X�ͦ~���</td>
<td>����</td>
<td>������</td>
<td>�a���m�W</td>
<td>�s����}</td>
<td>�s���q��</td>
<td>�E�_���p</td>
<td>�E�_��|</td>
</tr>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{foreach from=$health_data->stud_data item=seme_class key=i}}
{{assign var=year_name value=$i|@substr:0:-2}}
{{assign var=class_name value=$i|@substr:-2:2}}
{{foreach from=$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
{{assign var=sex value=$health_data->stud_base.$sn.stud_sex}}
{{if $dd.stunting}}
<tr style="background-color:white;">
<td style="background-color:#f4feff;">{{$year_name}}</td>
<td style="background-color:#f4feff;">{{$class_name}}</td>
<td style="background-color:#f4feff;">{{$seme_num}}</td>
<td style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};background-color:#fbf8b9;">{{$health_data->stud_base.$sn.stud_name}}</td>
<td style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};background-color:#f4feff;text-align:center;">{{if $health_data->stud_base.$sn.stud_sex==1}}�k{{elseif $health_data->stud_base.$sn.stud_sex==2}}�k{{else}}--{{/if}}</td>
<td style="text-align:center;">{{$health_data->stud_base.$sn.stud_birthday}}</td>
<td style="text-align:center;">{{$dd.years}}</td>
<td style="text-align:center;">{{$dd.height}}</td>
<td style="text-align:center;">{{$health_data->stud_base.$sn.guardian_name}}</td>
<td>{{$health_data->stud_base.$sn.stud_addr_2}}</td>
<td>{{$health_data->stud_base.$sn.stud_tel_2}}</td>
<td></td>
<td></td>
</tr>
{{/if}}
{{/foreach}}
{{/foreach}}
</table>
</td></tr></table>