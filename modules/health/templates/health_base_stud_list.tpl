{{* $Id: health_base_stud_list.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<input type="submit" name="csv" value="�ץXCSV��">
<input type="submit" name="xls" value="�ץXXLS��">
<input type="submit" name="ods" value="�ץXODS��">
<input type="submit" name="xls_all" value="�ץX���~��XLS��">
<input type="submit" name="ods_all" value="�ץX���~��ODS��">
<table bgcolor="#7e9cbd" cellspacing="1" cellpadding="4" class="small">
<tr style="background-color:#9ebcdd;color:white;text-align:center;">
<td>�Z��</td><td>�y��</td><td>�Ǹ�</td><td>�m�W</td><td>�����Ҧr��</td><td>�X�ͤ��</td><td>�s���a�}</td><td>�s���H</td><td>�s���q��</td>
</tr>
{{foreach from=$health_data->stud_data item=sd key=seme_class}}
{{foreach from=$sd item=d key=seme_num}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->stud_base.$sn}}
<tr bgcolor="white">
<td>{{$seme_class}}</td><td>{{$seme_num}}</td><td>{{$dd.stud_id}}</td><td>{{$dd.stud_name}}</td><td>{{$dd.stud_person_id}}</td><td>{{$dd.stud_birthday}}</td><td>{{$dd.stud_addr_2}}</td><td>{{$dd.guardian_name}}</td><td>{{$dd.stud_tel_2}}</td>
</tr>
{{/foreach}}
{{/foreach}}
</table>