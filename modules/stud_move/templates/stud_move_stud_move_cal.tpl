{{* $Id: stud_move_stud_move_cal.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" valign=top bgcolor="#CCCCCC">
		<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			<tr>
				<td class="title_mbody" colspan="{{$c_num*2+4}}" align="center"> ���ʲέp�� </td>
			</tr>
			<tr>
				<td class="title_mbody" rowspan="2" align="center">�������O</td>
				<td class="title_mbody" align="center">�~��</td>
{{foreach from=$class_year item=c_name}}
				<td class="title_mbody" colspan="2" align="center">{{$c_name}}</td>
{{/foreach}}
			</tr>
			<tr>
				<td class="title_mbody" align="center">�ʧO</td>
{{foreach from=$class_year item=c_name}}
				<td class="title_mbody" align="center">�k</td>
				<td class="title_mbody" align="center">�k</td>
{{/foreach}}
			</tr>
			<tr>
				<td class="title_mbody" colspan="2" align="center">�b�y</td>
{{foreach from=$class_year item=c_name key=c_year}}
				<td align="center">{{if $in_arr.$c_year.1}}{{$in_arr.$c_year.1}}{{else}}<font color="gray">0</font>{{/if}}</td>
				<td align="center">{{if $in_arr.$c_year.2}}{{$in_arr.$c_year.2}}{{else}}<font color="gray">0</font>{{/if}}</td>
{{/foreach}}
			</tr>
{{foreach from=$data_arr item=v key=i}}
			<tr>
				<td class="title_mbody" colspan="2" align="center">{{$kind_arr.$i}}</td>
{{foreach from=$class_year item=c_name key=c_year}}
				<td align="center">{{if $data_arr.$i.$c_year.1}}{{$data_arr.$i.$c_year.1}}{{else}}<font color="gray">0</font>{{/if}}</td>
				<td align="center">{{if $data_arr.$i.$c_year.2}}{{$data_arr.$i.$c_year.2}}{{else}}<font color="gray">0</font>{{/if}}</td>
{{/foreach}}
			</tr>
{{/foreach}}
		</table></td>
	</tr>
</table>
<div class="small" style="color:red;">���b�y�t�b�a�۾Ǿǥ�</div>
<div class="small" style="color:red;">���Y�`�H�ƻP�U�~�ŤH�Ƥ���, �h��ܦ����~��Ʀs�b�C</div>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
