{{* $Id: health_other_stud_num.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<table cellspacing="0" cellpadding="0">
	<tr>
	<td style="vertical-align:top;">
		<table style="background-color:#9EBCDD;" cellspacing="1" cellpadding="4">
			<tr style="background-color:#E1ECFF;">
			<td>�~��</td><td>�k�ǥ�</td><td>�k�ǥ�</td><td>�ǥͦX�p</td>
			</tr>
{{foreach from=$class_arr item=d key=i}}
			<tr style="background-color:#FFFFFF;text-align:center;">
			<td>{{$d}}</td>
			<td>{{$nums_arr.$i.1|@intval}} �H</td>
			<td>{{$nums_arr.$i.2|@intval}} �H</td>
			<td>{{$nums_arr.$i.all|@intval}} �H</td>
			</tr>
{{/foreach}}
		</table>
	</td>
	<td>&nbsp;</td>
	<td style="vertical-align:top;">
		<table style="background-color:#9EBCDD;" cellspacing="1" cellpadding="4">
			<tr style="background-color:#E1ECFF;">
			<td>�~��</td><td>�`�Z�ż�</td><td>�k�ǥ�</td><td>�k�ǥ�</td><td>�ǥͦX�p</td>
			</tr>
{{foreach from=$year_arr item=d key=i}}
			<tr style="background-color:#FFFFFF;text-align:center;">
			<td>{{$d}}</td>
			<td>{{$nums_arr.$i.nums|@intval}}</td>
			<td>{{$nums_arr.$i.1|@intval}}</td>
			<td>{{$nums_arr.$i.2|@intval}}</td>
			<td>{{$nums_arr.$i.all|@intval}}</td>
			</tr>
{{/foreach}}
			<tr style="background-color:#FFFFFF;text-align:center;">
			<td>�X�p</td>
			<td>{{$nums_arr.all.nums|@intval}}</td>
			<td>{{$nums_arr.all.1|@intval}}</td>
			<td>{{$nums_arr.all.2|@intval}}</td>
			<td>{{$nums_arr.all.all|@intval}}</td>
			</tr>
		</table>
		<span style="font-size:10pt;">
		<br>�t�b�a�Ш|�H�� : 2 �H
{{foreach from=$pers_arr item=d key=i}}
{{foreach from=$d item=dd key=ii}}
		<br>{{$class_arr.$i}}{{$ii}}�� ({{if $dd.stud_sex==1}}�k{{else}}�k{{/if}}) {{$dd.stud_name}}
{{/foreach}}
{{/foreach}}
		</span>
	</td>
	</tr>
</table>
