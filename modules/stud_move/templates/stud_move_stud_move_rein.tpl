{{* $Id: stud_move_stud_move_rein.tpl 8116 2014-09-10 12:41:32Z hsiao $ *}}
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
	{	alert('未選擇調出類別');
		OK=false;
	}	
	if(document.base_form.student_sn.value=='')	{
		alert('未選擇學生');
		OK=false;
	}	
	if(document.base_form.move_kind.value=='')
	{	alert('未選擇復學類別');
		OK=false;
	}	
	if(document.base_form.stud_class.value==0)	{
		alert('未選擇班級');
		OK=false;
	}
	if (OK==true) return confirm('確定新增 '+document.base_form.student_sn.options[document.base_form.student_sn.selectedIndex].text+' '+document.base_form.move_kind.options[document.base_form.move_kind.selectedIndex].text+'記錄 ?');
	return OK
}

function openModal(studentnewsn,stud_name,stud_id,stud_birthday,stud_in_class,stud_out_school_info)
{
  var para = studentnewsn + ';' + stud_name.trim() + ';' + stud_id + ';' + stud_birthday+ ';' + stud_in_class.trim() + ';' + stud_out_school_info.trim() + ';' + '{{$session_schoolnameeduno}}';
  para = encodeURIComponent(para);
  var targeturi = encodeURI("{{$sesion_path}}"+para);
  window.open(targeturi);
}

//-->
</script>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" valign=top bgcolor="#CCCCCC">
    <form name ="base_form" action="{{$smarty.server.SCRIPT_NAME}}" method="post" >
		<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			<tr>
				<td class=title_mbody colspan=2 align=center > 學生復學作業 </td>
			</tr>
			{{if $smarty.get.do_key!="edit"}}
			<tr>
				<td class=title_sbody2>調出類別</td>
				<td>{{$out_kind_sel}}</td>
			</tr>
			{{/if}}
			<tr>
				<td class=title_sbody2>選擇學生</td>
				<td>{{$stud_sel}}</td>
			</tr>
			<tr>
				<td class=title_sbody2>復學類別</td>
				<td>{{$move_kind_sel}}</td>
			</tr>
			{{if $smarty.get.do_key!="edit"}}
			<tr>
				<td class=title_sbody2>選擇班級</td>
				<td>{{$class_sel}}</td>
			</tr>
			{{/if}}
			<tr>
				<td class=title_sbody2>生效日期</td>
				<td> 西元 <input type="text" size="10" maxlength="10" name="move_date" id="move_date" value="{{if $default_date}}{{$default_date}}{{else}}{{$smarty.now|date_format:"%Y-%m-%d"}}{{/if}}"><input type="reset" value="選擇日期" onclick="return showCalendar('move_date', '%Y-%m-%d', '12');"></td>
			</tr>
			<tr>
				<td align="right" CLASS="title_sbody1">異動核准機關名稱</td>
				<td><input type="text" size="30" maxlength="30" name="move_c_unit" value="{{$default_unit}}"></td>
			</tr>
			<tr>
				<td align="right" CLASS="title_sbody1">核准日期</td>
				<td> 西元 <input type="text" size="10" maxlength="10" name="move_c_date" id="move_c_date" value="{{if $default_c_date}}{{$default_c_date}}{{else}}{{$smarty.now|date_format:"%Y-%m-%d"}}{{/if}}"><input type="reset" value="選擇日期" onclick="return showCalendar('move_c_date', '%Y-%m-%d', '12');"></td>
			</tr>
			<tr>
				<td align="right" CLASS="title_sbody1">核准字</td>
				<td><input type="text" size="20" maxlength="20" name="move_c_word" value="{{$default_word}}"> 字 </td>
			</tr>
			<tr>
				<td align="right" CLASS="title_sbody1">核准號</td>
				<td> 第 <input type="text" size="14" maxlength="14" name="move_c_num" value="{{if $default_c_num}}{{$default_c_num}}{{/if}}"> 號 </td>
			</tr>
			<tr>
	    	<td width="100%" align="center" colspan="5" >
	    	<input type="hidden" name="move_id" value="{{$smarty.get.move_id}}">
				<input type=submit name="do_key" value ="{{if $smarty.get.do_key!="edit"}} 確定復學 {{else}} 確定修改 {{/if}}" onClick="return {{if $smarty.get.do_key!="edit"}}checkok(){{else}}confirm('確定修改 '+document.base_form.student_sn.options[document.base_form.student_sn.selectedIndex].text+' 復學記錄?'){{/if}}" >    </td>
			</tr>
		</table><br></td>
	</tr>
	<TR>
		<TD>
			<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body ><tr><td colspan=9 class=title_top1 align=center >本學期復學學生</td></tr>
				<TR class=title_mbody >				
					<TD>異動類別</TD>
					<TD>生效日期</TD>
					<TD>學號</TD>				
					<TD>姓名</TD>				
					<TD>班級</TD>				
					<TD>核准單位</TD>
					<TD>字號</TD>
					<TD>編修</TD>
					<TD>XML自動匯入</TD>
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
						<TD>{{if $stud_move[arr_key].move_c_unit}}{{$stud_move[arr_key].move_c_unit}}{{else}}<font color="red">尚未輸入</font>{{/if}}</TD>
						<TD>{{$stud_move[arr_key].move_c_date}} {{$stud_move[arr_key].move_c_word}}字第{{$stud_move[arr_key].move_c_num}}號</TD>
						<TD><a href="{{$smarty.server.SCRIPT_NAME}}?do_key=edit&move_id={{$stud_move[arr_key].move_id}}">編輯</a>&nbsp;&nbsp;
						<a href="{{$smarty.server.SCRIPT_NAME}}?do_key=delete&&move_id={{$stud_move[arr_key].move_id}}&student_sn={{$stud_move[arr_key].student_sn}}" onClick="return confirm('確定取消 {{$stud_move[arr_key].stud_id}}--{{$stud_move[arr_key].stud_name}} {{$kind_arr.$kid}}記錄 ?');">刪除記錄</a>
						<a href='../toxml/stud_data_patch.php' target='_BLANK'>資料補登</a></TD>
						<TD>
                                                <input type='button' value='自動匯入' onclick='openModal("{{$stud_move[arr_key].stud_id}}","{{$stud_move[arr_key].stud_name}}","{{$stud_move[arr_key].stud_person_id}}","{{$stud_move[arr_key].stud_birthday}}","{{$class_list.$cid}}","");'>
						</TD>

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
