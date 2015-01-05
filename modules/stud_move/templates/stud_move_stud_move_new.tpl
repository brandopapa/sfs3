{{* $Id: stud_move_stud_move_new.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

{{dhtml_calendar_init}}
<script>
function showCalendar(id, format, showsTime, showsOtherMonths) {
	var el = document.getElementById(id);
	if (_dynarch_popupCalendar != null) {
		_dynarch_popupCalendar.hide();
	} else {
		var cal = new Calendar(1, null, selected, closeHandler);
		cal.weekNumbers = false;
		cal.showsTime = false;
		cal.time24 = (showsTime == "24");
		if (showsOtherMonths) {
			cal.showsOtherMonths = true;
		}
		_dynarch_popupCalendar = cal;
		cal.setRange(2000, 2030);
		cal.create();
	}
	_dynarch_popupCalendar.setDateFormat(format);
	_dynarch_popupCalendar.parseDate(el.value);
	_dynarch_popupCalendar.sel = el;
	_dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");

	return false;
}
function closeHandler(cal) {
	cal.hide();
	_dynarch_popupCalendar = null;
}
function selected(cal, date) {
	cal.sel.value = date;
}
</script>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" valign=top bgcolor="#CCCCCC">
    <form name ="base_form" action="{{$smarty.server.PHP_SELF}}" method="post" >
		<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			<tr>
				<td class=title_mbody colspan=2 align=center > �s�ͤJ�ǧ@�~ </td>
			</tr>
			<tr>
				<td class=title_sbody2 >��ܾǦ~��</td>
				<td>{{$year_id_sel}} �s�ͭp {{$tol}} �H�G �k�͡G<font color="blue">{{$boy}}</font> �H ,&nbsp; �k�͡G<font color="red">{{$girl}}</font> �H	      
    		</td>
			</tr>
			<tr>
				<td class=title_sbody2>�ͮĤ��</td>
				<td> �褸 <input type="text" size="10" maxlength="10" name="move_date" id="move_date" value="{{if $default_date}}{{$default_date}}{{else}}{{$smarty.now|date_format:"%Y-%m-%d"}}{{/if}}"><input type="reset" value="��ܤ��" onclick="return showCalendar('move_date', '%Y-%m-%d', '12');"></td>
			</tr>
			<tr>
				<td align="right" CLASS="title_sbody1">���ʮ֭�����W��</td>
				<td><input type="text" size="30" maxlength="30" name="move_c_unit" value="{{$default_unit}}"></td>
			</tr>
			<tr>
				<td align="right" CLASS="title_sbody1">�֭���</td>
				<td> �褸 <input type="text" size="10" maxlength="10" name="move_c_date" id="move_c_date" value="{{if $default_c_date}}{{$default_c_date}}{{else}}{{$smarty.now|date_format:"%Y-%m-%d"}}{{/if}}"><input type="reset" value="��ܤ��" onclick="return showCalendar('move_c_date', '%Y-%m-%d', '12');"></td>
			</tr>
			<tr>
				<td align="right" CLASS="title_sbody1">�֭�r</td>
				<td><input type="text" size="20" maxlength="20" name="move_c_word" value="{{$default_word}}"> �r </td>
			</tr>
			<tr>
				<td align="right" CLASS="title_sbody1">�֭㸹</td>
				<td> �� <input type="text" size="14" maxlength="14" name="move_c_num" value="{{if $default_c_num}}{{$default_c_num}}{{/if}}"> �� </td>
			</tr>
			<tr>
	    	<td width="100%" align="center" colspan="5" >
	    	<input type="hidden" name="update_id" value="{{$smarty.session.session_log_id}}">
				<input type=submit name="do_key" value =" �s�W��� " onClick="return confirm('�T�w�s�W '+document.base_form.year_id.value+' �Ǧ~�s�ͰO�� ?')" >    </td>
			</tr>
		</table><br></td>
	</tr>
	<TR>
		<TD>
			<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body ><tr><td colspan=8 class=title_top1 align=center >�s�ͤJ�ǰO��</td></tr>
				<TR class=title_mbody >				
					<TD>�ͮĤ��</TD>
					<TD>�Ǧ~��</TD>				
					<TD>�֭���</TD>
					<TD>�r��</TD>
					<TD>����</TD>
					<TD>�s��</TD>
				</TR>
				{{section loop=$stud_move name=arr_key}}
					<TR class=nom_2>		
						<TD>{{$stud_move[arr_key].move_date}}</TD>
						<TD>{{$stud_move[arr_key].move_year}}</TD>					
						<TD>{{if $stud_move[arr_key].move_c_unit}}{{$stud_move[arr_key].move_c_unit}}{{else}}<font color="red">�|����J</font>{{/if}}</TD>
						<TD>{{$stud_move[arr_key].move_c_date}} {{$stud_move[arr_key].move_c_word}}�r��{{$stud_move[arr_key].move_c_num}}��</TD>
						<TD>{{$stud_move[arr_key].num}}</TD>
						<TD><a href="{{$smarty.post.PHP_SELF}}?do_key=edit&year={{$stud_move[arr_key].move_year}}&date={{$stud_move[arr_key].move_date}}&unit={{$stud_move[arr_key].move_c_unit}}&c_date={{$stud_move[arr_key].move_c_date}}&word={{$stud_move[arr_key].move_c_word}}&num={{$stud_move[arr_key].move_c_num}}">�s��</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{$smarty.post.PHP_SELF}}?do_key=delete&move_year_seme={{$stud_move[arr_key].move_year_seme}}" onClick="return confirm('�T�w���� {{$stud_move[arr_key].move_year}} �Ǧ~�s�ͤJ�ǰO�� ?');">�R���O��</a></TD>
					</TR>
				{{/section}}
			</table></TD>
	</TR>
	<TR>
		<TD></TD>
	</TR>
	</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}