{{* $Id: health_setup_fday.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<script>
function fillall() {
	var i =0;

	for (var i=0, len=document.myform.elements.length; i< len; i++) {
		a=document.myform.elements[i].id.substring(0,1);
		if (a=='w') {
			document.myform.elements[i].checked=true;
		}
	}
}
function resel() {
	var i =0;

	for (var i=0, len=document.myform.elements.length; i< len; i++) {
		a=document.myform.elements[i].id.substr(0,1);
		if (a=='w') {
			document.myform.elements[i].checked=!document.myform.elements[i].checked;
		}
	}
}
</script>
<fieldset class="small" style="width:40%;">
<legend style="color:blue;font-size:12pt;">�]�w��I��</legend>
{{foreach from=$weekN item=d key=i}}<input type="radio" name="fday" value="{{$i+1}}">�P��{{$d}} {{/foreach}}
</fieldset><br>
<fieldset class="small" style="width:40%;">
<legend style="color:blue;font-size:12pt;">�]�w��I�g��</legend>
<table border="0" width="100%" class="small">
{{foreach from=$rowdata item=d key=i}}
{{if $i>0}}
{{if $i%5==1}}<tr>{{/if}}
<td><input type="checkbox" name="w[{{$i}}]" id="w{{$i}}" value="{{$i}}" {{if $rowdata2.$i}}checked{{/if}}>��{{$i}}�g</td>
{{if $i%5==0}}</tr>{{/if}}
{{/if}}
{{/foreach}}
</table>
</fieldset><br>
<input type="button" value="�g������" OnClick="fillall();">
<input type="button" value="�g���Ͽ�" OnClick="resel();">
<input type="submit" name="sure" value="�T�w�x�s">
<table cellspacing="0" cellpadding="0"><tr><td>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="5" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�g��</td>
<td>��I���</td>
<td>�]�w���p</td>
<td>�\��ﶵ</td>
</tr>
{{foreach from=$rowdata item=d key=i}}
{{if $i>0}}
{{assign var=t value=$rowdata2.$i|@strtotime}}
{{assign var=dd value=$t|@getdate}}
<tr style="background-color:white;text-align:center;">
<td>{{$i}}</td>
<td>{{$rowdata2.$i}} {{if $rowdata2.$i}}<span style="color:blue;">({{$dd.wday}})</span>{{/if}}</td>
<td><span style="color:{{if $rowdata2.$i}}blue{{else}}red{{/if}};">{{if $rowdata2.$i}}��I{{else}}���]�w{{/if}}</span></td>
<td><input type="image" src="images/delete.png" OnClick="document.getElementById('d').value='{{$i}}';document.myform.submit();"></td>
</tr>
{{/if}}
{{/foreach}}
<input type="hidden" name="del" id="d" value="">
</table>
</td></tr></table>
