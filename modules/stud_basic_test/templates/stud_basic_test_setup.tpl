{{* $Id: stud_basic_test_setup.tpl 7219 2013-03-12 07:02:20Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<script>
function selAll() {
	var i =0;

	while (i < document.menu_form.elements.length)  {
		a=document.menu_form.elements[i].id.substring(0,4);
		if (a=='sel_') {
			document.menu_form.elements[i].checked=1-document.menu_form.elements[i].checked;
		}
		i++;
	}
}
</script>
<form name="menu_form" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr><td style="vertival-align:top;background-color:#CCCCCC;">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" class="main_body" width="100%">
<tr><td style="vertical-align: top;">
{{if $stage==1}}
<br>
1.�ݩ�u�ǥͤl����v(stud_subkind)�����u(9)�����v���U�[�J�u�ڻy�{�ҡv�ݩʡC<br>
 &nbsp;&nbsp; ��Ʈw�ثe�O�����ݩʸ�Ƥ��O���G<br>
 &nbsp;&nbsp; (1)<span style="color: blue;"> {{$clan}}</span><br>
 &nbsp;&nbsp; (2)<span style="color: blue;"> {{$area}}</span><br>
 &nbsp;&nbsp; (3)<input type="radio" name="spec" value="memo"><span style="color: blue;">{{if $memo}}{{$memo}}{{else}}�|���]�w{{/if}}</span><br>
 &nbsp;&nbsp; (4)<input type="radio" name="spec" value="note"><span style="color: blue;">{{if $note}}{{$note}}{{else}}�|���]�w{{/if}}</span><br>
 &nbsp;&nbsp; �п�ܱz�ҭn�[�J�����(<span style="color:red;">�Ъ`�N, �p�G�����즳���, �h�|�N��ƥ��ƲM��!</span>)�C<br>
 &nbsp;&nbsp; <input type="submit" name="sure9" value="�T�w"><br>
{{elseif $stage==2}}
2.�ݩ�u�ǥͨ����O�v���[�J�u�ҥ~��ޤH�~�l�k�v�ﶵ�C<br>
 &nbsp;&nbsp; �{���۰ʥ[�J���u�ҥ~��ޤH�~�l�k�v�ﶵ�N�X��<input type="text" size="2" maxlength="2" name="tech" value="{{$type71}}"><br>
 &nbsp;&nbsp; <input type="submit" name="sure71" value="�T�w"><br>
{{else}}
<table cellpadding="0" cellspacing="0"><tr><td>
<table style="font-size:12px;" bgcolor="#F0F0F0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC">
<td rowspan="2"><input type="checkbox" OnClick="selAll()"></td>
<td rowspan="2">�S�ب���</td>
<td rowspan="2">�[�����</td>
<td rowspan="2">�Z��</td>
<td rowspan="2">�y��</td>
<td rowspan="2">�m�W</td>
<td rowspan="2">�Ǹ�</td>
<td colspan="3" style="text-align: center;">���Z�ĭp�Ǵ�</td>
</tr>
<tr bgcolor="#FFFFCC">
<td>�K�W</td>
<td>�K�U</td>
<td>�E�W</td>
</tr>
{{if count($rowdata) >0}}
{{foreach from=$rowdata item=d key=kind}}
{{foreach from=$d item=dd key=sn}}
<tr bgcolor="{{cycle values="white,#F0F0F0"}}">
<td style="text-align: center;"><input type="checkbox" name="sel[{{$sn}}]" id="sel_{{$sn}}"></td>
<td>{{$spc_arr.$kind}}{{if $spo_arr.$kind}}(<span style="color: red;">{{$spo_arr.$kind}}</span>){{/if}}</td>
<td style="text-align: center;">{{$plus_arr.$kind}}�H</td>
<td style="text-align: center;">{{$dd.seme_class|@substr:-2:2|intval}}</td>
<td style="text-align: center;">{{$dd.seme_num}}</td>
<td style="color:{{if $dd.sex==2}}red{{else}}blue{{/if}};">{{$dd.name}}</td>
<td style="text-align: center;">{{$dd.stud_id}}</td>
<td style="text-align: center;">{{if $chk_arr.$kind || $dd.sp_cal}}<input type="checkbox" name="cal[{{$sn}}][0]" {{if $stud_data.$sn.enable0}}checked{{/if}}>{{else}}<input type="checkbox" checked disabled>{{/if}}</td>
<td style="text-align: center;">{{if $chk_arr.$kind || $dd.sp_cal}}<input type="checkbox" name="cal[{{$sn}}][1]" {{if $stud_data.$sn.enable1}}checked{{/if}}>{{else}}<input type="checkbox" checked disabled>{{/if}}</td>
<td style="text-align: center;">{{if $chk_arr.$kind || $dd.sp_cal}}<input type="checkbox" name="cal[{{$sn}}][2]" {{if $stud_data.$sn.enable2}}checked{{/if}}>{{else}}<input type="checkbox" checked disabled>{{/if}}</td>
</tr>
{{/foreach}}
{{/foreach}}
{{else}}
<tr bgcolor="white">
<td colSpan="10" style="color: red; text-align: center;">���i��P�B�ƩΨS�����</td>
</tr>
{{/if}}
</table>
<input type="submit" name="print" value="�C�X�ҿ��ҩ���"> <input type="submit" name="save" value="�x�s�ĭp�Ǵ�">
{{if $smarty.get.hid==1}}
</td><td style="vertical-align: top;">
<table style="font-size:12px;" bgcolor="#F0F0F0" cellpadding="3" cellspacing="1" width="100%">
<tr style="background-color: green; color: white;">
<td>�п�J�ĭp�������Z�ǥ;Ǹ��G<input type="text" name="stud_id" size="5"><br><input type="submit" name="add" value="�T�w�s�W">
</td>
</tr>
</table>
{{/if}}
{{if $smarty.get.sp==1}}
</td><td style="vertical-align: top;">
<table style="font-size:12px;" bgcolor="#F0F0F0" cellpadding="3" cellspacing="1" width="100%">
<tr style="background-color: green; color: white;">
<td>�п�J�n�����ĭp���S��;Ǹ�����U�T�w�s�W�G<input type="text" name="stud_id" size="5"><br><input type="submit" name="sp" value="�T�w�s�W">
</td>
</tr>
</table>
{{/if}}
{{if $smarty.get.noCal==1}}
</td><td style="vertical-align: top;">
<table style="font-size:12px;" bgcolor="#F0F0F0" cellpadding="3" cellspacing="1" width="100%">
<tr style="background-color: blue; color: white;">
<td>�п�J���ƧǦ��Z�ǥ;Ǹ��G<input type="text" name="stud_id" size="5"><br><input type="submit" name="del" value="�T�w�s�W">
</td>
</tr>
</table>
{{/if}}
{{/if}}
</td></tr></table>
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li style="color: red;">���t�ζȴ��ѧ@�~���x�A�@�~�覡�Ш̦U�ۥͰϩο����W�w��z�A�ФŦۥD�M�w�H�K�v�T�ǥ��v�q�C</li>
{{if $stage>2}}
	<li>�Y�[���ʤ��񥼥X�{�A�h��ܳ]�w�������C
	<li>��ܤ��ǥ͸�ƭY�����~�A�u�ڻy�{�ҡv��ƽЦ�<a href="{{$SFS_PATH_HTML}}/modules/stud_subkind/">�u�ǥͨ������O�P�ݩʡv</a>�Ҳխץ��A��L��ƽЦ�<a href="{{$SFS_PATH_HTML}}/modules/stud_reg/">�u���y�޲z�v</a>�Ҳխץ��C
{{/if}}	
	</ol>
</td></tr>
</table>
</tr>
</table>
</td></tr>
</table>
</form>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
