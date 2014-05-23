{{* $Id: class_health_influenza_form.tpl 5626 2009-09-06 15:34:35Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
{{php}}
if (count($this->_tpl_vars['rowdata'])>0) {
	$this->_tpl_vars['sym']=explode("@@@",$this->_tpl_vars['rowdata']['sym_str']);
	$tmp_arr=explode("@@@",$this->_tpl_vars['rowdata']['oth_txt']);
	foreach($tmp_arr as $v) {
		$tmp_arr2=explode("###",$v);
		$this->_tpl_vars['oth_txt'][$tmp_arr2[0]]=$tmp_arr2[1];
	}
}
{{/php}}

{{dhtml_calendar_init src="`$SFS_PATH_HTML`javascripts/calendar.js" setup_src="`$SFS_PATH_HTML`javascripts/calendar-setup.js" lang="`$SFS_PATH_HTML`javascripts/calendar-tw.js" css="`$SFS_PATH_HTML`javascripts/calendar-brown.css"}}
<script>
<!--
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
function go(){
	if (document.myform.student_sn.value=='')
		alert("����ǥ�");
	else {
		document.getElementById('inf_date').disabled=false;
		document.getElementById('diag_date').disabled=false;
		document.getElementById('chk_date').disabled=false;
		document.myform.submit();
	}
}
-->
</script>

<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<form name="myform" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<tr>
<td bgcolor="white">
<input type="button" value="�T�w{{if $rowdata}}�ק�{{else}}�s�W{{/if}}" OnClick="go();">
<input type="hidden" name="act" value="sure">
{{if $rowdata}}<input type="hidden" name="student_sn" value="{{$smarty.post.student_sn}}">{{/if}}
<br>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">�m�W</td>
<td style="text-align:left;">{{$stud_menu}}</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">�o�f���</td>
<td style="text-align:left;">
<input type="text" name="inf_date" id="inf_date" size="10" value="{{if $rowdata.dis_date}}{{$rowdata.dis_date}}{{else}}{{$smarty.now|date_format:"%Y-%m-%d"}}{{/if}}" disabled style="color:black;">{{if $rowdata.dis_date==""}}<input type="reset" value="��ܤ��" onclick="return showCalendar('inf_date', '%Y-%m-%d', '12');">{{/if}}
</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">�g�@�@��</td>
<td style="text-align:left;">
<input type="checkbox" name="sym[1]" {{if (in_array(1,$sym))}}checked{{/if}}>�o���N
<input type="checkbox" name="sym[2]" {{if (in_array(2,$sym))}}checked{{/if}}>�٦׻ĵh
<input type="checkbox" name="sym[3]" {{if (in_array(3,$sym))}}checked{{/if}}>�Y�h
<input type="checkbox" name="sym[4]" {{if (in_array(4,$sym))}}checked{{/if}}>���׭«�
<input type="checkbox" name="sym[5]" {{if (in_array(5,$sym))}}checked{{/if}}>�y��
<input type="checkbox" name="sym[6]" {{if (in_array(6,$sym))}}checked{{/if}}>�I�l��
<input type="checkbox" name="sym[7]" {{if (in_array(7,$sym))}}checked{{/if}}>���V�h
</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">�а����p</td>
<td style="text-align:left;">
<input type="radio" name="status" value="A" {{if $rowdata.status=="A"}}checked{{/if}}>�ͯf���W��
<input type="radio" name="status" value="B" {{if $rowdata.status=="B"}}checked{{/if}}>�ͯf�b�a��
<input type="radio" name="status" value="C" {{if $rowdata.status=="C"}}checked{{/if}}>�ͯf��|
</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">�N�E���p</td>
<td style="text-align:left;">
�N�E�� <input type="text" name="diag_date" id="diag_date" size="10" value="{{if $rowdata.diag_date!="0000-00-00"}}{{$rowdata.diag_date}}{{/if}}" disabled style="color:black;"><input type="reset" value="��ܤ��" onclick="return showCalendar('diag_date', '%Y-%m-%d', '12');">
�N�E��| <input type="text" name="diag_hos" value="{{$rowdata.diag_hos}}">
��v�E�_�f�W <input type="text" name="diag_name" value="{{$rowdata.diag_name}}">
</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">���窬�p</td>
<td style="text-align:left;">
���ˤ� <input type="text" name="chk_date" id="chk_date" size="10" value="{{if $rowdata.chk_date!="0000-00-00"}}{{$rowdata.chk_date}}{{/if}}" disabled style="color:black;"><input type="reset" value="��ܤ��" onclick="return showCalendar('chk_date', '%Y-%m-%d', '12');">
������i <input type="text" name="chk_report" value="{{$rowdata.chk_report}}">
</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">��L</td>
<td style="text-align:left;"><input type="checkbox" name="oth_chk[1]">���L�I���y�P�̭] �a�ݦ��P�_�g����<input type="text" name="oth_txt[0]" value="{{$oth_txt.0}}"> <input type="checkbox" name="oth_chk[2]">�a�ݬO�_�X��</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">�Ƶ�</td>
<td style="text-align:left;"><textarea name="oth_txt[1]" rows="3" cols="70">{{$oth_txt.1|br2nl}}</textarea></td>
</tr>
</table>
</td>
</tr>
</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
