{{* $Id: health_input_wh.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<script>
function chk_h(a) {
	b="h"+a;
	c=document.getElementById(b).value;
	if (c < 70 || c > 226) {
		alert("�X�z�����d��������70������226���������I\n�Э��s��J�I");
		d="oh"+a;
		document.getElementById(b).value=document.getElementById(d).value;
		document.getElementById(b).focus();
	}
}
function chk_w(a) {
	b="w"+a;
	c=document.getElementById(b).value;
	if (c < 10 || c > 150) {
		alert("�X�z�魫�d��������10�����150���礧���I\n�Э��s��J�I");
		d="ow"+a;
		document.getElementById(b).value=document.getElementById(d).value;
		document.getElementById(b).focus();
	}
}
function restore() {
	if (confirm('���e���x�s����ƱN�|��!\n�T�w���?')) {
		document.myform.reset();
	}
}
function chk_file() {
	if (document.myform.upload_file.value=="") {
		alert("�Х���ܤW���ɮ�");
	} else {
		document.myform.encoding="multipart/form-data";
		document.myform.submit();
	}
}
</script>

<input type="submit" name="save" value="�T�w�x�s">
<input type="button" value="����x�s" OnClick="return restore();">
<input type="submit" name="csv" value="�U��CSV��">
<input type="file" name="upload_file">
<input type="button" name="upload" value="�W��CSV��" OnClick="chk_file();">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="2" class="small">
<tr bgcolor="#c4d9ff">
{{if $smarty.post.wh_input}}
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">�魫</td>
<td align="center">����</td>
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">�魫</td>
<td align="center">����</td>
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">�魫</td>
<td align="center">����</td>
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">�魫</td>
<td align="center">����</td>
{{else}}
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">����</td>
<td align="center">�魫</td>
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">����</td>
<td align="center">�魫</td>
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">����</td>
<td align="center">�魫</td>
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">����</td>
<td align="center">�魫</td>
{{/if}}
</tr>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=seme_class value=$smarty.post.class_name}}
{{foreach from=$health_data->stud_data.$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
{{if $smarty.foreach.rows.iteration % 4==1}}
<tr style="background-color:white;">
{{/if}}
{{counter assign=i}}
<td style="background-color:#f4feff;">{{$seme_num}}</td>
<td style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};background-color:#fbf8b9;">{{$health_data->stud_base.$sn.stud_name}}</td>
{{if $smarty.post.wh_input}}
<td align="center"><input type="text" id="w{{$i}}" name="update[new][{{$sn}}][{{$year_seme}}][weight]" value="{{$dd.weight}}" size="5" style="background-color:#f8f8f8;font-size:12px;" OnChange="chk_w('{{$i}}');"><input type="hidden" id="ow{{$i}}" name="update[old][{{$sn}}][{{$year_seme}}][weight]" value="{{$dd.weight}}"></td>
<td align="center"><input type="text" id="h{{$i}}" name="update[new][{{$sn}}][{{$year_seme}}][height]" value="{{$dd.height}}" size="5" style="background-color:#f8f8f8;font-size:12px;" OnChange="chk_h('{{$i}}');"><input type="hidden" id="oh{{$i}}" name="update[old][{{$sn}}][{{$year_seme}}][height]" value="{{$dd.height}}"></td>
{{else}}
<td align="center"><input type="text" id="h{{$i}}" name="update[new][{{$sn}}][{{$year_seme}}][height]" value="{{$dd.height}}" size="5" style="background-color:#f8f8f8;font-size:12px;" OnChange="chk_h('{{$i}}');"><input type="hidden" id="oh{{$i}}" name="update[old][{{$sn}}][{{$year_seme}}][height]" value="{{$dd.height}}"></td>
<td align="center"><input type="text" id="w{{$i}}" name="update[new][{{$sn}}][{{$year_seme}}][weight]" value="{{$dd.weight}}" size="5" style="background-color:#f8f8f8;font-size:12px;" OnChange="chk_w('{{$i}}');"><input type="hidden" id="ow{{$i}}" name="update[old][{{$sn}}][{{$year_seme}}][weight]" value="{{$dd.weight}}"></td>
{{/if}}
{{if $smarty.foreach.rows.iteration % 4==0}}
</tr>
{{/if}}
{{/foreach}}
</table>
</td></tr></table>
<input type="submit" name="save" value="�T�w�x�s">
<input type="button" value="����x�s" OnClick="return restore();">
<input type="submit" name="csv" value="�U��CSV��">
{{*����*}}
<table class="small">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>�u�U��CSV�ɡv�ҤU���ɮפ��Ĥ@�欰�~�ůZ�šB�ĤG�欰�y���B�ĤT�欰�Ǹ��B�ĥ|�欰�����B�Ĥ��欰�魫�C</li>
	<li>�����ƭ��ˬd�X�z�d��70��226�����A�魫�ƭ��ˬd�X�z�d��10��150����C</li>
	<li>�Y�ϥΥ��۰ʨ����魫���q���A�ӻ����e�X���ƾڬ����魫�ᨭ�����ܡA�Цܡu�t�οﶵ�]�w�v���u�����魫��J�]�w�v�������T�]�w�A�ϥΧY�i�C</li>
	</ol>
</td></tr>
</table>
