{{* $Id: health_accident_search.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

{{dhtml_calendar_init src="`$SFS_PATH_HTML`javascripts/calendar.js" setup_src="`$SFS_PATH_HTML`javascripts/calendar-setup.js" lang="`$SFS_PATH_HTML`javascripts/calendar-tw.js" css="`$SFS_PATH_HTML`javascripts/calendar-brown.css"}}
<script>
function del(a) {
	if (confirm('�T�w�R���������?')) {
		document.getElementById('del').value=1;
		document.getElementById('del_id').value=a;
		document.myform.submit();
	}
}
</script>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="2" class="small" style="font-size:10pt;">
<tr style="color:white;text-align:center;line-height:18pt;font-size:14pt;">
<td colspan="2">�d�߱�����w</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td nowrap>�_���ɶ�</td>
<td style="background-color:#f4feff;text-align:left;">
<input type="text" id="start_date" name="health_accident_record[start_date]" value="{{$smarty.post.start_date}}" style="width:70px;"><input type="button" id="sdate" value="��ܮɶ�"> �� <input type="text" id="end_date" name="health_accident_record[end_date]" value="{{$smarty.post.end_date}}" style="width:70px;"><input type="button" id="edate" value="��ܮɶ�">(�ťեN�����w)
</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�a�@�@�I</td>
<td style="background-color:#f4feff;">
<table style="width:100%;">{{assign var=i value=0}}{{foreach from=$aplace item=d key=k}}{{if $i % 5 == 0}}<tr>{{/if}}<td><input type="radio" id="sel_pla_{{$k}}" name="health_accident_record[place_id]" value="{{$k}}">{{$d}}</td>{{assign var=i value=$i+1}}{{if $i % 5 == 0}}</tr>{{/if}}{{/foreach}}</table>
</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>��@�@�]</td>
<td style="background-color:#f4feff;">
<table style="width:100%;">{{assign var=i value=0}}{{foreach from=$areason item=d key=k}}{{if $i % 5 == 0}}<tr>{{/if}}<td><input type="radio" id="sel_rea_{{$k}}" name="health_accident_record[reason_id]" value="{{$k}}">{{$d}}</td>{{assign var=i value=$i+1}}{{if $i % 5 == 0}}</tr>{{/if}}{{/foreach}}</table>
</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>���@�@��</td>
<td style="background-color:#f4feff;">
<table style="width:100%;">{{assign var=i value=0}}{{foreach from=$apart item=d key=k}}{{if $i % 5 == 0}}<tr>{{/if}}<td><input type="checkbox" id="sel_par_{{$k}}" name="health_accident_part_record[part_id][{{$k}}]">{{$d}}</td>{{assign var=i value=$i+1}}{{if $i % 5 == 0}}</tr>{{/if}}{{/foreach}}</table></td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>���@�@�p</td>
<td style="background-color:#f4feff;">
<table style="width:100%;">{{assign var=i value=0}}{{foreach from=$astatus item=d key=k}}{{if $i % 5 == 0}}<tr>{{/if}}<td><input type="checkbox" id="sel_sta_{{$k}}" name="health_accident_status_record[status_id][{{$k}}]">{{$d}}</td>{{assign var=i value=$i+1}}{{if $i % 5 == 0}}</tr>{{/if}}{{/foreach}}</table></td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�B�m�覡</td>
<td style="background-color:#f4feff;">
<table style="width:100%;">{{assign var=i value=0}}{{foreach from=$aattend item=d key=k}}{{if $i % 5 == 0}}<tr>{{/if}}<td><input type="checkbox" id="sel_att_{{$k}}" name="health_accident_attend_record[attend_id][{{$k}}]">{{$d}}</td>{{assign var=i value=$i+1}}{{if $i % 5 == 0}}</tr>{{/if}}{{/foreach}}</table></td>
</tr>
</table>

<input type="submit" name="start_search" value="�}�l�d��">
<input type="hidden" id="del" name="del">
<input type="hidden" id="del_id" name="update[del][0]">
<table cellspacing="0" cellpadding="0"><tr><td>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="5" class="small">
<tr style="color:white;text-align:center;"><td colspan="13">�d�߰O��</td></tr>
<tr style="background-color:white;text-align:center;">
<td>�~��</td>
<td>�Z��</td>
<td>�y��</td>
<td>�m�W</td>
<td>�B�z�ɶ�</td>
<td>�[��ɶ�</td>
<td>���</td>
<td>�a�I</td>
<td>��]</td>
<td>����</td>
<td>���p</td>
<td>�B�m�覡</td>
<td>�\��ﶵ</td>
</tr>
{{foreach from=$rowdata item=d}}
<tr style="background-color:{{cycle values="#C0CAEC,white"}};text-align:center;">
<td>{{$d.year}}</td>
<td>{{$d.class}}</td>
<td>{{$d.num}}</td>
<td>{{$d.stud_name}}</td>
<td>{{$d.sign_time}}</td>
<td>{{if $d.obs_min>0}}{{$d.obs_min}}��{{else}}���O��{{/if}}</td>
<td>{{if $d.temp>0}}{{$d.temp}}<sup>o</sup>C{{else}}���O��{{/if}}</td>
{{assign var=i value=$d.place_id}}
<td>{{$aplace.$i}}</td>
{{assign var=i value=$d.reason_id}}
<td>{{$areason.$i}}</td>
<td>{{foreach from=$d.part_id item=dd}}{{$apart.$dd}}<br>{{/foreach}}</td>
<td>{{foreach from=$d.status_id item=dd}}{{$astatus.$dd}}<br>{{/foreach}}</td>
<td>{{foreach from=$d.attend_id item=dd}}{{$aattend.$dd}}<br>{{/foreach}}</td>
<td>�s�� <a href="#" OnClick="del({{$d.id}});">�R��</a> <span title="{{if $d.memo}}{{$d.memo}}{{else}}�L�������e{{/if}}" style="cursor:pointer;color:blue;">����</span></td>
</tr>
{{/foreach}}
</table>
</td></tr></table>
{{dhtml_calendar inputField="start_date" button="sdate" singleClick=false}}
{{dhtml_calendar inputField="end_date" button="edate" singleClick=false}}