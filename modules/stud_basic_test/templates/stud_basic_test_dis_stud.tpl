{{* $Id: stud_basic_test_dis_stud.tpl 7140 2013-02-23 16:11:18Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<script>
function selAll() {
	var i=0;
	while (i < document.myform.elements.length)  {
		a=document.myform.elements[i].id.substr(0,4);
		if (a=='sel_') {
			document.myform.elements[i].checked=!document.myform.elements[i].checked;
		}
		i++;
	}
}

function selCheck() {
	var i=0, s=0, g=0;
	while (i < document.myform.elements.length)  {
		a=document.myform.elements[i].id.substr(0,4);
		if (a=='sel_') {
			if (document.myform.elements[i].checked) s=1;
		}
		if (a=='act_') {
			if (document.myform.elements[i].checked) g=1;
		}
		i++;
	}
	if (!g) {
		alert('����B�z����');
		return;
	}
	if (!s) {
		alert('����B�z�ǥ�');
		return;
	}
	document.myform.submit();
}
</script>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td valign=top bgcolor="#CCCCCC">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" width="100%" class="main_body">
<tr><td>
<form action="{{$smarty.server.SCRIPT_NAME}}" method="post" name="myform">
�Ǵ��G{{$year_seme_menu}} �~�šG{{$class_year_menu}} {{if $smarty.post.year_name}} 
{{if $smarty.post.sel}}
<input type="button" value="�^�έp��" OnClick="this.form.sel.value='';this.form.submit();"><br>
{{$menu2}}
<table border='0' width='100%' style='font-size:12px;' bgcolor='#C0C0C0' cellpadding='3' cellspacing='1'>
<tr style="background-color: #D0D0D0; text-align: center;">
<td><input type="checkbox" OnClick="selAll();"></td>
<td>�Z��</td>
<td>�y��</td>
<td>�ǥͩm�W</td>
<td>�ǥ�<br>����</td>
<td>����<br>��ê</td>
<td>�C��<br>�J��</td>
<td>���C<br>���J</td>
<td>���~��<br>�u�l�k</td>
<td>�S��<br>����</td>
<td>���w<br>�~</td>
<td>���<br>���v</td>
<td>�a���m�W</td>
<td>�q��</td>
<td>�l��<br>�ϸ�</td>
<td>�a�}</td>
<td>����p<br>�����</td>
<td>�Ұ�<br>�N�X</td>
<td>���o<br>�ϽX</td>
<td>�ѻP<br>�Ƨ�</td>
</tr>
{{foreach from=$rowdata item=d key=sn}}
<tr style="background-color: {{cycle values="white,#FFFF80"}}; text-align:center;">
<td><input type="checkbox" name="sn[{{$sn}}]" id="sel_{{$sn}}"></td>
<td>{{$smarty.post.sel}}</td>
<td>{{$d.stud_site}}</td>
<td style="color: {{if $d.stud_sex==1}}blue{{else}}red{{/if}};">{{$d.stud_name}}</td>
<td>{{$d.stud_kind}}</td>
<td>{{$d.hand_kind}}</td>
<td>{{$d.lowincome}}
<td>{{$d.midincome}}
<td>{{$d.unemployed}}
<td>{{$d.sp_kind}}</td>
<td>1</td>
<td>1</td>
<td>{{$d.stud_parent}}</td>
<td>{{$d.stud_tel}}</td>
<td><input type="text" name="zip[{{$sn}}]" size="3" maxlength="3" value="{{$d.addr_zip}}"></td>
<td style="text-align: left;"> &nbsp; {{$d.stud_addr}}</td>
<td>{{$d.stud_cell}}</td>
<td>{{$d.area1}}</td>
<td>{{$d.area2}}</td>
<td>{{$d.cal}}</td>
</tr>
{{/foreach}}
</table>
<input type="button" value="�T�w" OnClick="selCheck();"> <input type="reset" value="�M��"> <input type="hidden" name="sel" value="{{$smarty.post.sel}}">
{{else}}
<input type="submit" name="sync" value="�ǥ͸�ƦP�B��"> <input type="submit" name="lock" value="�ǥ͸�ƫʦs" {{if $isLock}}disabled{{/if}}> <input type="submit" name="unlock" value="�ǥ͸�ƸѰ��ʦs" {{if $today>"2013-02-28" || !$isLock}}disabled{{/if}}> <br>�ץX�G<input type="submit" name="ct_out" value="�K�դ���ϰ���¾">
<br>{{$menu2}}
<table style="border-width: 0;">
<tr><td style="vertical-align: top;">
<table border='0' style='font-size:12px;' bgcolor='#C0C0C0' cellpadding='3' cellspacing='1'>
<tr style="background-color: #D0D0D0; text-align: center;">
<td>��Ƴ]�w</td>
<td>�Z��</td>
<td>���y<br>�ǥͼ�</td>
<td>�K�է@�~<br>�ǥͼ�</td>
<td>�ѻP�Ƨ�<br>�ǥͼ�</td>
</tr>
{{foreach from=$rowdata item=d key=seme_class}}
<tr style="background-color: {{cycle values="white,#FFFF80"}}; text-align:center;">
<td><input type="radio" name="sel" value="{{$seme_class}}" OnClick="this.form.submit();"></td>
<td>{{$seme_class}}</td>
<td>{{$d}}</td>
<td style="color: {{if $rowdata2.$seme_class<>$d}}red{{else}}black{{/if}};">{{$rowdata2.$seme_class|intval}}</td>
<td style="color: {{if $rowdata3.$seme_class<>$d}}green{{else}}black{{/if}};">{{$rowdata3.$seme_class|intval}}</td>
</tr>
{{/foreach}}
</table>
</td><td style="vertical-align: top;">
{{*����*}}
<table class="small" width="100%" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li style="color: red;">�аȥ��� 2013-03-01 �i��u�ǥ͸�ƫʦs�v�H�T�w�ǥͤH�ơC</li>
	<li style="color: red;">��ƭY�w�T�w�A�A�P�B�ɽФſ���������A�_�h��ƱN�|�Q�٭�C</li>
	<li>�H�U����P�B�Ʈɷ|�۰ʨ��o�G
	<ul style="padding-left: 12pt; list-style-type: disc;">
	<li>�ǥͨ���</li>
	<li>���߻�ê(�N�X: 1)</li>
	<li>�C���J��(�N�X: 3)</li>
	<li style="color: red;">���C���J��(�N�X: {{$type61}}) �m�N�X�Ѩt�θ�Ʈw����n</li>
	<li>���~�Ҥu�l�k(�N�X: 53)</li>
	<li>�S�ؾǥ�</li>
	</ul>
	</li>
	<li>��L�P�_�u�ǥͨ����v�ɩҨϥΤ��t�ΥN�X�G
	<ul style="padding-left: 12pt; list-style-type: disc;">
	<li>����(�N�X: 9)</li>
	<li>���~�H���l�k(�N�X: 12)</li>
	<li>�X�å�(�N�X: 51)</li>
	<li>�^�깴��(�N�X: 6)</li>
	<li>��D��(�N�X: 7)</li>
	<li>�h��x�H(�N�X: 52)</li>
	<li>�ҥ~�u�q��ǧ޳N�H�~�l�k(�N�X: 71)</li>
	</ul>
	</li>
	</ol>
</td></tr>
</table>
</td></tr></table>
{{/if}}
{{/if}}
</form></td>
</tr>
</table>
</td></tr></table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
