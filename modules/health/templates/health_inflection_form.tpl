{{* $Id: health_inflection_form.tpl 5631 2009-09-07 01:28:42Z brucelyc $ *}}
<script>
<!--
function go(){
	if (document.myform.class_name.value=='')
		alert("����Z��");
	else if (document.myform.student_sn.value=='')
		alert("����ǥ�");
	else if (document.myform.iid.value=='')
		alert("����ͯf��]");
	else {
		document.myform.act.value='sure';
		document.myform.submit();
	}
}
-->
</script>

<input type="button" value="�T�w{{if $rowdata}}�ק�{{else}}�s�W{{/if}}" OnClick="go();">
<input type="hidden" name="act" value="add">
<input type="hidden" name="iid" value="{{$smarty.post.iid}}">
{{foreach from=$rowdata.id item=d key=i}}
<input type="hidden" name="id[{{$i}}]" value="{{$d}}">
{{/foreach}}
<br>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">�Z��</td>
<td style="text-align:left;">{{$class_menu2}}</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">�m�W</td>
<td style="text-align:left;">{{$stud_menu}}</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">�ͯf��]</td>
<td style="text-align:left;">
{{foreach from=$inf_arr item=d}}
<input type="radio" name="chgid" OnClick="document.myform.iid.value='{{$d.iid}}';" {{if $smarty.post.iid==$d.iid}}checked{{/if}}>{{$d.name}}
{{/foreach}}
<br><span style="color:red;">(�u���N��̡v�Ш���v�E�_�f�W�I��A�u���N��̡v�h�Ю��@��U�̯g���I��)</span>
</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;" colspan="2">�ͯf��</td>
</tr>
{{foreach from=$cweekday item=d key=i}}
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">{{$d}}<br>[{{$weekday_arr[$i]}}]</td>
<td style="text-align:left;">
<input type="radio" name="status[{{$weekday_arr[$i]}}]" value="" {{if $rowdata.weekday.$i==""}}checked{{/if}}>�L
<input type="radio" name="status[{{$weekday_arr[$i]}}]" value="A" {{if $rowdata.weekday.$i=="A"}}checked{{/if}}>�ͯf���W��
<input type="radio" name="status[{{$weekday_arr[$i]}}]" value="B" {{if $rowdata.weekday.$i=="B"}}checked{{/if}}>�ͯf�b�a��
<input type="radio" name="status[{{$weekday_arr[$i]}}]" value="C" {{if $rowdata.weekday.$i=="C"}}checked{{/if}}>�ͯf��|
</td>
</tr>
{{/foreach}}
<tr style="background-color:white;text-align:center;">
<td style="background-color:#E6E9F9;">�Ƶ�</td>
<td style="text-align:left;"><textarea name="oth_txt[1]" rows="2" cols="50">{{$oth_txt.1|br2nl}}</textarea></td>
</tr>
</table>
