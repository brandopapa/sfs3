{{* $Id: health_teesem_fclass.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<input type="submit" name="chart" value="�C�L���Z��I��">
<input type="submit" name="allchart" value="�C�L���չ�I��">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td colspan="3">�g�O</td>
{{foreach from=$date_arr item=d key=i}}
<td>{{$d.week_no}}</td>
{{/foreach}}
<td colspan="3">�X�p</td>
<td rowspan="2">�C��<br>�ǵ�<br>����v</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�y��</td>
<td>�m�W</td>
<td>�ѻP���p</td>
{{foreach from=$date_arr item=d key=i}}
<td>{{$d.do_date|@substr:5:2}}<br>��<br>{{$d.do_date|@substr:8:2}}</td>
{{/foreach}}
<td>��<br><br>�u</td>
<td>��<br>��<br>�f</td>
<td>��<br>��<br>�f</td>
</tr>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=seme_class value=$smarty.post.class_name}}
{{foreach from=$health_data->stud_data.$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
<tr style="background-color:white;text-align:center;">
<td style="background-color:#f4feff;">{{$seme_num}}</td>
<td style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};background-color:#fbf8b9;">{{$health_data->stud_base.$sn.stud_name}}</td>
{{assign var=agree value=$health_data->health_data.$sn.$year_seme.frecord.agree}}
<td>{{if $agree=="0"}}���ѻP{{elseif $agree==1}}�ѻP{{else}}���]�w{{/if}}</td>
{{foreach from=$date_arr item=d key=i}}
<td></td>
{{/foreach}}
<td></td>
<td></td>
<td></td>
<td></td>
{{/foreach}}
</tr>
</table>
