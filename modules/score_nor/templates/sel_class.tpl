<!-- //$Id: sel_class.tpl 5310 2009-01-10 07:57:56Z hami $ -->
<SCRIPT LANGUAGE="JavaScript">
<!--
function chk1(formName, elementName,chk_type) {
	for(var i = 0; i < document.forms[formName].elements[elementName].length; i++) {
		if (chk_type == 0) 
			document.forms[formName].elements[elementName][i].checked = false;
		if (chk_type == 1) 
			document.forms[formName].elements[elementName][i].checked = true;
		if (chk_type == 2) {
			var $chk_now = document.forms[formName].elements[elementName][i].checked;
			if ($chk_now) 
				document.forms[formName].elements[elementName][i].checked = false;
			else
				document.forms[formName].elements[elementName][i].checked =  true;
		}
	}
}
//-->
</SCRIPT>
<form name='score' action="{{$PHP_SELF}}" method="post" >
	<select name=year_seme onChange='submit()'>
		{{html_options options=$year_seme_ary selected=$year_seme}}
	</select>
	<select name=grade onChange='submit()'>
		{{html_options options=$grade_ary selected=$grade}}
	</select>

</form>
<form name=prn action='prn_class_seme_score_nor.php' method='post' target=_blank>
	<input type=hidden name=prn_type>
	<input type=hidden name=year_seme value="{{$year_seme}}">
	<input type=hidden name=test_sort value="{{$test_sort}}">
	<input type=hidden name=grade value="{{$grade}}">
	<table bgcolor="ghostwhite" cellPadding='0' border=1 cellSpacing='0' width='90%' align=left style='empty-cells:show;border-collapse:collapse;text-align:center;' >
	<tr>
		<td align=left colspan=10>
			�ФĿ�Z�� 
			<input type=button value='����'  onClick="chk1('prn', 'sel_class[]',1);">
			<input type=button value='����' onClick="chk1('prn', 'sel_class[]',0);">
			<input type=button value='�ϦV���' onClick="chk1('prn', 'sel_class[]',2);">
			<input type=submit value='�C�L' >
		</td>
	</tr>
	<!---- 95/01/14 �ץ� -->
	<!---- ���ǾǮժ��Z�ŦW�� c_name �ä��O�Ʀr�A�p�G�ҤA���Ω������R  -->
	<!---- �]���ݭץ��P�_���覡 -->
	{{counter assign='clano' start=0 skip=1 print=false}}
	{{foreach from=$class_ary key=class_id item=c_name}}
		{{counter print=false}}
	 	{{if $clano % 10 == 1}}<tr>{{/if}}
	 	<td>
	 	{{if $c_name !=''}}
	 		<label>
	 			<input type="checkbox" name="sel_class[]" value="{{$class_id}}" >{{$c_name}}
	 		</label>
	 	{{/if}}
	 	</td>
	 	{{if $clano % 10 == 0}}</tr>{{/if}}
	{{/foreach}}
 	{{if $clano % 10 != 0}}</tr>{{/if}}
 	<!---- 95/01/14 �ץ����� -->
	</table>
</form>
<p>
<pre>
<br>
<br>
<FONT>
<DIV style="color:blue" onclick="alert('�@�̸s�G\n���� ���K�e �M�s ���a��\n�G�L ������ ��� ���۶v\n�_�� ���Y�Y �j�� �Lڭ��\n�j�� �G����');"> 
��By ���ƿ��ǰȨt�ζ}�o�p��</DIV></FONT>
<br>
�C�L�ɡA�ȱi�г]�� B4 ��L
</pre>
