{{* $Id:$ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" valign=top bgcolor="#CCCCCC">
    <form name ="base_form" action="{{$smarty.server.PHP_SELF}}" method="post" >
		<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			<tr>
				<td class=title_mbody colspan=2 align=center > XML��X�@�~</td>
			</tr>
			<tr>
				<td class=title_sbody2>�������O</td>
				<td>{{$move_kind_sel}}</td>	      
			</tr>
			{{if $smarty.post.move_kind}}
				{{if $year_seme_sel!=""}}
				<tr>
					<td class=title_sbody2>���ʾǴ�</td>
					<td>{{$year_seme_sel}}</td>	      
				</tr>
				{{/if}}
			<tr>
	    	<td width="100%" align="center" colspan="2">
	    	<input type="hidden" name="update_id" value="{{$smarty.session.session_log_id}}">
				<BR>�����X�ɮ׫e�A�Х��T�{�t�Τw�w�� 1.�ǥͼ��g(reward) 2.�ǥͨ������O�P�ݩ�(stud_subkind) �ҲաI<BR><BR>
				{{$career_checkbox}} 
				<input type="checkbox" name="all_reward" value='1'>�������g��X��ܾǥͦb���մNŪ�Ǵ����Ҧ����g��� <input type=submit name="output_xml" value =" ��X�ɮ� "></td>
			</tr>
		</table><br></td>
	</tr>
	<TR>
		<TD>
			<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body><tr><td colspan="8" class=title_top1 align=center>���Ǵ�<Script>document.write(document.base_form.move_kind.options[document.base_form.move_kind.selectedIndex].text+'�O��')</Script></td></tr>
				<TR class=title_mbody >				
					{{if $form_kind=="1"}}
						<TD>���</TD>
						<TD>�Ǹ�</TD>
						<TD>�m�W</TD>
						<TD>���ʮɶ�</TD>
						<TD>�s�NŪ�Ǯ�</TD>
					{{else}}
						<TD>���</TD>
						<TD>�Ǧ~��</TD>				
						<TD>�s�NŪ�Ǯ�</TD>
						<TD>����</TD>
					{{/if}}
				</TR>
				{{section loop=$stud_move name=arr_key}}
					<TR class=nom_2>		
					{{if $form_kind=="1"}}
						<TD><input type="checkbox" name="choice[{{$stud_move[arr_key].student_sn}}]"></TD>
						<TD>{{$stud_move[arr_key].stud_id}}</TD>
						<TD>{{$stud_move[arr_key].stud_name}}</TD>					
						<TD>{{$stud_move[arr_key].move_date}}</TD>
						<TD>{{$stud_move[arr_key].school}}�@</TD>
					{{else}}
						<TD><input type="radio" name="choice[]" value="{{$stud_move[arr_key].move_year_seme}}_{{$stud_move[arr_key].move_c_unit}}_{{$stud_move[arr_key].move_c_date}}_{{$stud_move[arr_key].move_c_num}}" {{if $smarty.post.move_kind==13}}OnClick="ss={{$stud_move[arr_key].move_year}}"{{/if}}></TD>
						<TD>{{$stud_move[arr_key].move_year}}</TD>					
						<TD>{{$stud_move[arr_key].move_date}}</TD>
						<TD>{{if $stud_move[arr_key].move_c_unit}}{{$stud_move[arr_key].move_c_unit}}{{else}}<font color="red">�|����J</font>{{/if}}</TD>
						<TD>{{$stud_move[arr_key].move_c_date}}</TD>
						<TD>{{$stud_move[arr_key].move_c_word}}�r��{{$stud_move[arr_key].move_c_num}}��</TD>
						<TD>{{$stud_move[arr_key].num}}</TD>
					{{/if}}
					</TR>
				{{/section}}
			{{/if}}
			</table></TD>
	</TR>
	<TR>
		<TD></TD>
	</TR>
	</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}