{{* $Id: stud_move_stud_move_rein.tpl 6483 2011-08-22 13:21:39Z infodaes $ *}}
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
function checkok()	{
	var OK=true;	
	if(document.base_form.move_out_kind.value=='')
	{	alert('����ܽեX���O');
		OK=false;
	}	
	if(document.base_form.student_sn.value=='')	{
		alert('����ܾǥ�');
		OK=false;
	}	
	if(document.base_form.move_kind.value=='')
	{	alert('����ܴ_�����O');
		OK=false;
	}	
	if(document.base_form.stud_class.value==0)	{
		alert('����ܯZ��');
		OK=false;
	}
	if (OK==true) return confirm('�T�w�s�W '+document.base_form.student_sn.options[document.base_form.student_sn.selectedIndex].text+' '+document.base_form.move_kind.options[document.base_form.move_kind.selectedIndex].text+'�O�� ?');
	return OK
}
//-->
</script>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" valign=top bgcolor="#CCCCCC">
    <form name ="base_form" action="{{$smarty.server.SCRIPT_NAME}}" method="post" >
		<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			<tr>
				<td class=title_mbody colspan=2 align=center > �ǥʹ_�ǧ@�~ </td>
			</tr>
			{{if $smarty.get.do_key!="edit"}}
			<tr>
				<td class=title_sbody2>�եX���O</td>
				<td>{{$out_kind_sel}}</td>
			</tr>
			{{/if}}
			<tr>
				<td class=title_sbody2>��ܾǥ�</td>
				<td>{{$stud_sel}}</td>
			</tr>
			<tr>
				<td class=title_sbody2>�_�����O</td>
				<td>{{$move_kind_sel}}</td>
			</tr>
			{{if $smarty.get.do_key!="edit"}}
			<tr>
				<td class=title_sbody2>��ܯZ��</td>
				<td>{{$class_sel}}</td>
			</tr>
			{{/if}}
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
	    	<input type="hidden" name="move_id" value="{{$smarty.get.move_id}}">
				<input type=submit name="do_key" value ="{{if $smarty.get.do_key!="edit"}} �T�w�_�� {{else}} �T�w�ק� {{/if}}" onClick="return {{if $smarty.get.do_key!="edit"}}checkok(){{else}}confirm('�T�w�ק� '+document.base_form.student_sn.options[document.base_form.student_sn.selectedIndex].text+' �_�ǰO��?'){{/if}}" >    </td>
			</tr>
		</table><br></td>
	</tr>
	<TR>
		<TD>
			<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body ><tr><td colspan=8 class=title_top1 align=center >���Ǵ��_�Ǿǥ�</td></tr>
				<TR class=title_mbody >				
					<TD>�������O</TD>
					<TD>�ͮĤ��</TD>
					<TD>�Ǹ�</TD>				
					<TD>�m�W</TD>				
					<TD>�Z��</TD>				
					<TD>�֭���</TD>
					<TD>�r��</TD>
					<TD>�s��</TD>
				</TR>
				{{section loop=$stud_move name=arr_key}}
					<TR class=nom_2>
						{{assign var=kid value=$stud_move[arr_key].move_kind}}
						{{assign var=cid value=$stud_move[arr_key].seme_class}}
						<TD>{{$kind_arr.$kid}}</TD>
						<TD>{{$stud_move[arr_key].move_date}}</TD>
						<TD>{{$stud_move[arr_key].stud_id}}</TD>					
						<TD>{{$stud_move[arr_key].stud_name}}</TD>					
						<TD>{{$class_list.$cid}}</TD>					
						<TD>{{if $stud_move[arr_key].move_c_unit}}{{$stud_move[arr_key].move_c_unit}}{{else}}<font color="red">�|����J</font>{{/if}}</TD>
						<TD>{{$stud_move[arr_key].move_c_date}} {{$stud_move[arr_key].move_c_word}}�r��{{$stud_move[arr_key].move_c_num}}��</TD>
						<TD><a href="{{$smarty.server.SCRIPT_NAME}}?do_key=edit&move_id={{$stud_move[arr_key].move_id}}">�s��</a>&nbsp;&nbsp;
						<a href="{{$smarty.server.SCRIPT_NAME}}?do_key=delete&&move_id={{$stud_move[arr_key].move_id}}&student_sn={{$stud_move[arr_key].student_sn}}" onClick="return confirm('�T�w���� {{$stud_move[arr_key].stud_id}}--{{$stud_move[arr_key].stud_name}} {{$kind_arr.$kid}}�O�� ?');">�R���O��</a>
						<a href='../toxml/stud_data_patch.php' target='_BLANK'>��Ƹɵn</a></TD>

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
