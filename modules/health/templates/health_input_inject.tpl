{{* $Id: health_input_inject.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{assign var=id value=$smarty.post.work_id2}}

<script>
function fillall() {
	var i =0;

	while (i < document.myform.elements.length)  {
		a=document.myform.elements[i].id.substr(0,1);
		if (a=='t') {
			document.myform.elements[i].value='{{$inject_arr.times.$id}}';
		}
		i++;
	}
}
function okall(a) {
	var i =0;

	while (i < document.myform.elements.length)  {
		b=document.myform.elements[i].id.substr(0,1);
		if (a==1) {
			if (b=='y') {
				document.myform.elements[i].checked=true;
			} else if (b=='z') {
				document.myform.elements[i].checked=false;
			} else if (b=='x') {
				document.myform.elements[i].value=a;
			}
		} else {
			if (b=='y') {
				document.myform.elements[i].checked=false;
			} else if (b=='z') {
				document.myform.elements[i].checked=true;
			} else if (b=='x') {
				document.myform.elements[i].value=a;
			}
		}
		i++;
	}
}
function sel(a,b) {
alert(document.getElementById("y"+a).checked);
	if (b==0) {
		document.getElementById("y"+a).checked=false;
	} else {
		document.getElementById("z"+a).checked=false;
	}
	document.getElementById("x"+a).value=b;
}
{{if $id>0}}
function chknum(a) {
	if (document.getElementById(a).value > {{$inject_arr.times.$id}}) {
		alert("���̭]�̦h�u���J {{$inject_arr.times.$id}} ���I");
		document.getElementById(a).value=document.getElementById("o"+a).value;
		document.getElementById(a).focus();
	}
}
{{/if}}
</script>

<input type="submit" name="save" value="�T�w�x�s">
<input type="reset" value="����x�s">
{{if $id==0}}
<input type="button" value="�����]����ú" OnClick="okall(0);">
<input type="button" value="�����]���wú" OnClick="okall(1);">
{{else}}
<input type="button" value="�����]��������" OnClick="fillall();">
{{/if}}
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="2" class="small">
<tr bgcolor="#c4d9ff">
{{if $id==0}}
<td rowspan="2" align="center">�y��</td>
<td rowspan="2" align="center">�m�W</td>
<td colspan="2" align="center">ú�檬�p</td>
<td rowspan="2" align="center">�y��</td>
<td rowspan="2" align="center">�m�W</td>
<td colspan="2" align="center">ú�檬�p</td>
</tr>
<tr bgcolor="#c4d9ff">
<td align="center">��ú</td>
<td align="center">�wú</td>
<td align="center">��ú</td>
<td align="center">�wú</td>
</tr>
{{else}}
<td rowspan="2" align="center">�y��</td>
<td rowspan="2" align="center">�m�W</td>
<td rowspan="2" align="center">�J�ǫe<br>���ؾ���</td>
<td colspan="{{$inject_arr.times.$id}}" align="center">���ؤ��</td>
<td rowspan="2" align="center">�y��</td>
<td rowspan="2" align="center">�m�W</td>
<td rowspan="2" align="center">�J�ǫe<br>���ؾ���</td>
<td colspan="{{$inject_arr.times.$id}}" align="center">���ؤ��</td>
</tr>
<tr bgcolor="#c4d9ff">
<td align="center">�Ĥ@��</td>
{{if $inject_arr.show.$id>1}}
<td align="center">�ĤG��</td>
{{/if}}
{{if $inject_arr.show.$id>2}}
<td align="center">�ĤT��</td>
{{/if}}
{{if $inject_arr.show.$id>3}}
<td align="center">�ĥ|��</td>
{{/if}}
<td align="center">�Ĥ@��</td>
{{if $inject_arr.show.$id>1}}
<td align="center">�ĤG��</td>
{{/if}}
{{if $inject_arr.show.$id>2}}
<td align="center">�ĤT��</td>
{{/if}}
{{if $inject_arr.show.$id>3}}
<td align="center">�ĥ|��</td>
{{/if}}
</tr>
{{/if}}
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=seme_class value=$smarty.post.class_name}}
{{assign var=kid value=0}}
{{foreach from=$health_data->stud_data.$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->stud_data.$sn.$year_seme}}
{{assign var=ddd value=$health_data->health_data.$sn}}
{{assign var=maxlen value=6}}
{{if $smarty.foreach.rows.iteration % 2==1}}
<tr style="background-color:white;">
{{/if}}
{{counter assign=d}}
<td style="background-color:#f4feff;">{{$seme_num}}</td>
<td style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};background-color:#fbf8b9;">{{$health_data->stud_base.$sn.stud_name}}</td>
{{if $id==0}}
<td align="center"><input type="checkbox" id="z{{$d}}" OnClick="sel('{{$d}}','0');" {{if $ddd.inject.0.0.times==0}}checked{{/if}}></td>
<td align="center"><input type="checkbox" id="y{{$d}}" OnClick="sel('{{$d}}','1');" {{if $ddd.inject.0.0.times==1}}checked{{/if}}></td>
<input type="hidden" id="x{{$d}}" name="update[new][{{$sn}}][inject][{{$kid}}][{{$id}}][times]" value="">
<input type="hidden" name="update[old][{{$sn}}][inject][{{$kid}}][{{$id}}][times]" value="{{$ddd.inject.0.0.times}}">
{{else}}
<td align="center">
<input type="text" id="t{{$d}}" name="update[new][{{$sn}}][inject][{{$kid}}][{{$id}}][times]" maxlength="1" value="{{$ddd.inject.$kid.$id.times}}" style="width:20pt;" OnChange="chknum('t{{$d}}');">
<input type="hidden" id="ot{{$d}}" name="update[old][{{$sn}}][inject][{{$kid}}][{{$id}}][times]" value="{{$ddd.inject.$kid.$id.times}}">
</td>
<td align="center">
{{if $ddd.inject.$kid.$id.times>=1}}
<input type="text" name="update[new][{{$sn}}][inject][{{$kid}}][{{$id}}][date1]" size="{{$maxlen}}" maxlength="{{$maxlen}}" value="{{if $ddd.inject.$kid.$id.date1!="0000-00-00"}}{{$ddd.inject.$kid.$id.date1|replace:"-":""}}{{/if}}">
{{else}}
-----
{{/if}}
</td>
{{if $inject_arr.show.$id>1}}
<td align="center">
{{if $ddd.inject.$kid.$id.times>=2}}
<input type="text" name="update[new][{{$sn}}][inject][{{$kid}}][{{$id}}][date2]" size="{{$maxlen}}" maxlength="{{$maxlen}}" value="{{if $ddd.inject.$kid.$id.date2!="0000-00-00"}}{{$ddd.inject.$kid.$id.date2|replace:"-":""}}{{/if}}">
{{else}}
-----
{{/if}}
</td>
{{/if}}
{{if $inject_arr.show.$id>2}}
<td align="center">
{{if $ddd.inject.$kid.$id.times>=3}}
<input type="text" name="update[new][{{$sn}}][inject][{{$kid}}][{{$id}}][date3]" size="{{$maxlen}}" maxlength="{{$maxlen}}" value="{{if $ddd.inject.$kid.$id.date3!="0000-00-00"}}{{$ddd.inject.$kid.$id.date3|replace:"-":""}}{{/if}}">
{{else}}
-----
{{/if}}
</td>
{{/if}}
{{if $inject_arr.show.$id>3}}
<td align="center">
{{if $ddd.inject.$kid.$id.times>=4}}
<input type="text" name="update[new][{{$sn}}][inject][{{$kid}}][{{$id}}][date4]" size="{{$maxlen}}" maxlength="{{$maxlen}}" value="{{if $ddd.inject.$kid.$id.date4!="0000-00-00"}}{{$ddd.inject.$kid.$id.date4|replace:"-":""}}{{/if}}">
{{else}}
-----
{{/if}}
</td>
{{/if}}
{{/if}}
{{if $smarty.foreach.rows.iteration % 2==0}}
</tr>
{{/if}}
{{/foreach}}
</table>
<input type="submit" name="save" value="�T�w�x�s">
<input type="reset" value="����x�s">
{{if $id==0}}
<input type="button" value="�����]����ú" OnClick="okall(0);">
<input type="button" value="�����]���wú" OnClick="okall(1);">
{{else}}
<input type="button" value="�����]��������" OnClick="fillall();">
{{/if}}
