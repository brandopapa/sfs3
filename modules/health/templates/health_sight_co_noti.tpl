{{* $Id: health_sight_co_noti.tpl 5718 2009-10-28 03:08:39Z brucelyc $ *}}
<script>
function selall() {
	var i =0;

	for (var i=0, len=document.myform.elements.length; i< len; i++) {
		a=document.myform.elements[i].id.substr(0,1);
		if (a=='C') {
			document.myform.elements[i].checked=true;
		}
	}
}
function resel() {
	var i =0;

	for (var i=0, len=document.myform.elements.length; i< len; i++) {
		a=document.myform.elements[i].id.substr(0,1);
		if (a=='C') {
			document.myform.elements[i].checked=!document.myform.elements[i].checked;
		}
	}
}
</script>

<input type="submit" name="print" value="�C�L�M��">
<input type="submit" name="noti" value="�C�L�q����">
<input type="button" value="����" OnClick="selall();">
<input type="button" value="�Ͽ�" OnClick="resel();">
<span class="small">�^��ú����<input type="text" name="rmonth" size="2">��<input type="text" name="rday" size="2">��</span>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="2" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td>��</td>
<td>�~��</td>
<td>�Z��</td>
<td>�y��</td>
<td>�m�W</td>
<td>�ʧO</td>
<td>�����Ҧr��</td>
<td>�E�_</td>
<td>��L�E�_</td>
<td>��|</td>
</tr>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=seme_class value=$smarty.post.class_name}}
{{foreach from=$health_data->stud_data item=seme_class key=i}}
{{assign var=year_name value=$i|@substr:0:-2}}
{{assign var=class_name value=$i|@substr:-2:2}}
{{foreach from=$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->stud_base.$sn}}
<tr style="background-color:white;">
{{counter assign=i}}
<td><input type="checkbox" name="student_sn[{{$i}}]" id="C{{$i}}" value="{{$sn}}"></td>
<td style="background-color:#f4feff;">{{$year_name}}</td>
<td style="background-color:#f4feff;">{{$class_name}}</td>
<td style="background-color:#f4feff;">{{$seme_num}}</td>
<td style="color:{{if $dd.stud_sex==1}}blue{{elseif $dd.stud_sex==2}}red{{else}}black{{/if}};background-color:#fbf8b9;">{{$dd.stud_name}}</td>
<td style="text-align:center;">{{if $dd.stud_sex==1}}�k{{elseif $dd.stud_sex==2}}�k{{/if}}</td>
<td>{{$dd.stud_person_id}}</td>
<td></td>
<td></td>
<td></td>
</tr>
{{/foreach}}
{{foreachelse}}
<tr><td colspan="10" style="background-color:white;text-align:center;color:red;">�L���</td></tr>
{{/foreach}}
</table>
<input type="submit" name="print" value="�C�L�M��">
<input type="submit" name="noti" value="�C�L�q����">
<input type="button" value="����" OnClick="selall();">
<input type="button" value="�Ͽ�" OnClick="resel();">
</td></tr></table>
</td>
</tr>
</table>
