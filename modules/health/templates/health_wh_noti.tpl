{{* $Id: health_wh_noti.tpl 5406 2009-02-17 05:13:41Z brucelyc $ *}}
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

<input type="submit" name="print" value="�C�L"> <input type="button" value="����" OnClick="selall();"> <input type="button" value="�Ͽ�" OnClick="resel();"> <input type="checkbox" name="bad" OnChange="this.form.submit();" {{if $smarty.post.bad}}checked{{/if}}><span class="small">�������줣�}��</span>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td>��</td>
<td>�~��</td>
<td>�Z��</td>
<td>�y��</td>
<td>�m�W</td>
<td>����</td>
<td>�魫</td>
<td>���PŪ</td>
<td>GHD</td>
<td>BMI</td>
<td>�귳</td>
</tr>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{foreach from=$health_data->stud_data item=seme_class key=i}}
{{assign var=year_name value=$i|@substr:0:-2}}
{{assign var=class_name value=$i|@substr:-2:2}}
{{foreach from=$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
{{if (($smarty.post.bad && $dd.Bid<>1 && $dd.height>0 && $dd.weight>0) || (!$smarty.post.bad))}}
<tr style="background-color:white;">
<td><input type="checkbox" name="student_sn[{{$seme_num}}]" id="C{{$i}}" value="{{$sn}}"></td>
<td style="background-color:#f4feff;">{{$year_name}}</td>
<td style="background-color:#f4feff;">{{$class_name}}</td>
<td style="background-color:#f4feff;">{{$seme_num}}</td>
<td style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};background-color:#fbf8b9;">{{$health_data->stud_base.$sn.stud_name}}</td>
<td style="text-align:center;">{{$dd.height}}</td>
<td style="text-align:center;">{{$dd.weight}}</td>
{{assign var=Bid value=$dd.Bid}}
<td {{if $Bid!=1}}style="color:red;"{{/if}}>{{$Bid_arr.$Bid}}</td>
<td>{{$dd.GHD}}</td>
<td>{{$dd.BMI}}</td>
<td style="text-align:center;">{{$dd.years}}</td>
</tr>
{{/if}}
{{/foreach}}
{{/foreach}}
</table>
