{{* $Id: health_input_sight.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<script>
function chk(a) {
	b=document.getElementById(a).value;
	n=a.length;
	c=a.substr(0,n-2);
	d=a.substr(n-2,1);
	e=a.substr(n-1,1);
	f=b/10;
	if (b=="-1" || b=="-9") break;
	if (b!="" && b.length < 3)	document.getElementById(a).value=f.toFixed(1);
	if (e=="r") {
		f=c+d+"o";
		if (document.getElementById(f).value=="") document.getElementById(f).value=0;
	}
}
function restore() {
	if (confirm('���e���x�s����ƱN�|��!\n�T�w���?')) {
		document.myform.reset();
	}
}
</script>

<input type="submit" name="save" value="�T�w�x�s">
<input type="button" value="����x�s" OnClick="return restore();">
<span style="color:red;">(���O�p��0.1�п�J�u-1�v��ܡA�r���L�k���q�п�J�u-9�v��ܡC)</span>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="2" class="small">
<tr bgcolor="#c4d9ff">
<td align="center" rowspan="2">�y��</td>
<td align="center" rowspan="2">�m�W</td>
<td align="center" colspan="2">�r��</td>
<td align="center" colspan="2">�B��</td>
<td align="center" rowspan="2">�y��</td>
<td align="center" rowspan="2">�m�W</td>
<td align="center" colspan="2">�r��</td>
<td align="center" colspan="2">�B��</td>
<td align="center" rowspan="2">�y��</td>
<td align="center" rowspan="2">�m�W</td>
<td align="center" colspan="2">�r��</td>
<td align="center" colspan="2">�B��</td>
<td align="center" rowspan="2">�y��</td>
<td align="center" rowspan="2">�m�W</td>
<td align="center" colspan="2">�r��</td>
<td align="center" colspan="2">�B��</td>
</tr>
<tr bgcolor="#c4d9ff">
<td align="center">�k��</td>
<td align="center">����</td>
<td align="center">�k��</td>
<td align="center">����</td>
<td align="center">�k��</td>
<td align="center">����</td>
<td align="center">�k��</td>
<td align="center">����</td>
<td align="center">�k��</td>
<td align="center">����</td>
<td align="center">�k��</td>
<td align="center">����</td>
<td align="center">�k��</td>
<td align="center">����</td>
<td align="center">�k��</td>
<td align="center">����</td>
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
<td align="center"><input type="text" id="{{$i}}ro" name="update[new][{{$sn}}][{{$year_seme}}][r][sight_o]" value="{{if $dd.r.sight_o}}{{if $dd.r.sight_o=="-1" || $dd.r.sight_o=="-9"}}{{$dd.r.sight_o}}{{else}}{{$dd.r.sight_o|string_format:"%.1f"}}{{/if}}{{/if}}" size="2" style="background-color:#f8f8f8;font-size:12px;" OnChange="chk('{{$i}}ro');"><input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][r][sight_o]" value="{{$dd.r.sight_o}}"></td>
<td align="center"><input type="text" id="{{$i}}lo" name="update[new][{{$sn}}][{{$year_seme}}][l][sight_o]" value="{{if $dd.l.sight_o}}{{if $dd.l.sight_o=="-1" || $dd.l.sight_o=="-9"}}{{$dd.l.sight_o}}{{else}}{{$dd.l.sight_o|string_format:"%.1f"}}{{/if}}{{/if}}" size="2" style="background-color:#f8f8f8;font-size:12px;" OnChange="chk('{{$i}}lo');"><input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][l][sight_o]" value="{{$dd.l.sight_o}}"></td>
<td align="center"><input type="text" id="{{$i}}rr" name="update[new][{{$sn}}][{{$year_seme}}][r][sight_r]" value="{{if $dd.r.sight_r}}{{if $dd.r.sight_r=="-1" || $dd.r.sight_r=="-9"}}{{$dd.r.sight_r}}{{else}}{{$dd.r.sight_r|string_format:"%.1f"}}{{/if}}{{/if}}" size="2" style="background-color:#f8f8f8;font-size:12px;" OnChange="chk('{{$i}}rr');"><input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][r][sight_r]" value="{{$dd.r.sight_r}}"></td>
<td align="center"><input type="text" id="{{$i}}lr" name="update[new][{{$sn}}][{{$year_seme}}][l][sight_r]" value="{{if $dd.l.sight_r}}{{if $dd.l.sight_r=="-1" || $dd.l.sight_r=="-9"}}{{$dd.l.sight_r}}{{else}}{{$dd.l.sight_r|string_format:"%.1f"}}{{/if}}{{/if}}" size="2" style="background-color:#f8f8f8;font-size:12px;" OnChange="chk('{{$i}}lr');"><input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][l][sight_r]" value="{{$dd.l.sight_r}}"></td>
{{if $smarty.foreach.rows.iteration % 4==0}}
</tr>
{{/if}}
{{/foreach}}
</table>
</td></tr></table>
<input type="submit" name="save" value="�T�w�x�s">
<input type="button" value="����x�s" OnClick="return restore();">
