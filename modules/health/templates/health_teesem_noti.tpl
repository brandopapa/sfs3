{{* $Id: health_teesem_noti.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
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

<input type="submit" name="print" value="�C�L">
<input type="button" value="����" OnClick="selall();">
<input type="button" value="�Ͽ�" OnClick="resel();">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="2" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td>��</td>
<td>�~��</td>
<td>�Z��</td>
<td>�y��</td>
<td>�m�W</td>
<td>���O</td>
<td>�T��</td>
<td>�ʤ�</td>
<td>�w�B�v</td>
<td>�ݩޤ�</td>
<td>���ͤ�</td>
<td>�إͤ�</td>
<td>�f�Ľåͤ��}</td>
<td>���C�r�X����</td>
<td>���i��</td>
<td>�f���H�����`</td>
</tr>
{{assign var=dis value=0}}
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=seme_class value=$smarty.post.class_name}}
{{foreach from=$health_data->stud_data item=seme_class key=i}}
{{assign var=year_name value=$i|@substr:0:-2}}
{{assign var=class_name value=$i|@substr:-2:2}}
{{foreach from=$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
{{if $dd.DisTeeth || $dd.DisOra}}
{{assign var=dis value=$dis+1}}
{{counter assign=i}}
<tr style="background-color:white;">
<td rowspan="2"><input type="checkbox" name="student_sn[{{$i}}]" id="C{{$i}}" value="{{$sn}}"></td>
<td rowspan="2" style="background-color:#f4feff;">{{$year_name}}</td>
<td rowspan="2" style="background-color:#f4feff;">{{$class_name}}</td>
<td rowspan="2" style="background-color:#f4feff;">{{$seme_num}}</td>
<td rowspan="2" style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};background-color:#fbf8b9;">{{$health_data->stud_base.$sn.stud_name}}</td>
<td style="background-color:#c4d9ff;">��</td>
<td style="text-align:center;">{{$dd.N1}}</td>
<td style="text-align:center;">{{$dd.N2}}</td>
<td style="text-align:center;">{{$dd.N3}}</td>
<td style="text-align:center;">{{$dd.N4}}</td>
<td style="text-align:center;">{{$dd.N5}}</td>
<td style="text-align:center;">{{$dd.N6}}</td>
<td rowspan="2" style="text-align:center;color:red;font-size:12pt;">{{if $dd.checks.Ora1}}+{{/if}}</td>
<td rowspan="2" style="text-align:center;color:red;font-size:12pt;">{{if $dd.checks.Ora4}}+{{/if}}</td>
<td rowspan="2" style="text-align:center;color:red;font-size:12pt;">{{if $dd.checks.Ora5}}+{{/if}}</td>
<td rowspan="2" style="text-align:center;color:red;font-size:12pt;">{{if $dd.checks.Ora6}}+{{/if}}</td>
</tr>
<tr style="background-color:#f4fe80;text-align:center;">
<td style="background-color:#c4d9ff;">�ž�</td>
<td>{{$dd.n1}}</td>
<td>{{$dd.n2}}</td>
<td>{{$dd.n3}}</td>
<td>{{$dd.n4}}</td>
<td>{{$dd.n5}}</td>
<td>{{$dd.n6}}</td>
</tr>
{{/if}}
{{/foreach}}
{{foreachelse}}
<tr><td colspan="24" style="background-color:white;text-align:center;color:red;">�L���</td></tr>
{{/foreach}}
{{if $dis==0}}
<tr><td colspan="24" style="background-color:white;text-align:center;color:red;">�L�ݳq�����</td></tr>
{{/if}}
</table>
<input type="submit" name="print" value="�C�L"> <input type="button" value="����" OnClick="selall();"> <input type="button" value="�Ͽ�" OnClick="resel();">
</td></tr></table>
</td>
</tr>
</table>