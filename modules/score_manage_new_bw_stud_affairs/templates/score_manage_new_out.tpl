{{* $Id: score_manage_new_out.tpl 6238 2010-10-21 05:47:54Z infodaes $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<form name="menu_form" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<tr><td bgcolor='#FFFFFF'>
<table width="100%">
<tr>
<td>{{$year_seme_menu}}</td>
</tr>
<tr><td>
<table cellspacing="0" cellpadding="0"><tr><td>
<table bgcolor="#9EBCDD" cellspacing="1" cellpadding="4">
<tr class="title_sbody2">
<td align="center" colspan="2" vlign="middle">�ǥ;Ǹ�</td>
<td bgcolor="white" colspan="6" align="left">
<input type="text" size="10" name="sel_stud_id" value="">
<input type="submit" name="add_id" value="�s�W�ǥ�"> ��
</td></tr>
<tr class="title_sbody2">
<td align="center" colspan="2">�Z�Ůy��</td>
<td bgcolor="white" colspan="6" align="left">
<input type="text" size="2" name="sel_year_name" value="">�~��
<input type="text" size="2" name="sel_class_num" value="">�Z
<input type="text" size="2" name="sel_site_num" value="">��
<input type="submit" name="add_num" value="�s�W�ǥ�">
</td></tr>
<tr class="title_sbody2">
<td align="center" colspan="2" vlign="middle">��@�@�]</td>
<td bgcolor="white" colspan="6" align="left">
<input type="text" size="30" name="reason" value="">
<input type="hidden" id="deldata" name="del" value="">
</td></tr></table>
</td></tr></table>
</td></tr>
<tr><td>
<table border="0" cellspacing="1" cellpadding="4" width="100%" bgcolor="#cccccc" class="main_body">
<tr style="background-color:#E1ECFF;text-align:center;">
<td>�Z��</td>
<td>�y��</td>
<td>�Ǹ�</td>
<td>�m�W</td>
<td>��]</td>
<td>�\��</td>
</tr>
{{foreach from=$rowdata item=d key=sn}}
<tr style="background-color:#ddddff;text-align:center;">
<td>{{$d.seme_class}}</td>
<td>{{$d.seme_num}}</td>
<td>{{$d.stud_id}}</td>
<td style="color:{{if $d.stud_sex==2}}red{{else}}blue{{/if}};">{{$d.stud_name}}</td>
<td>{{$d.reason}}</td>
<td><input type="image" src="../reward/images/del.png" OnClick="document.getElementById('deldata').value='{{$sn}}';this.form.submit();"></td>
</tr>
{{foreachelse}}
<tr style="background-color:white;text-align:center;">
<td colspan="6" style="color:red;">�ثe�L���</td>
</tr>
{{/foreach}}
</table>
</td></tr>
</table>
</td></tr></table>
</form>
{{*����*}}
<table class="small" style="width:100%;">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>���\��Ω�Z�Ŧ��Z�p��ɱư��귽�Z�ǥ͡A�H�ϦU�Z���Z���A�X�z�e�{�C</li>
	<li>�Y�n�ϥ��C���p��ɥͮġA�аȥ�����������Ŀ�u�M�αư��W��v�C</li>
	<li style="color:red;">�ФŦb�Ǵ������N���ܥ��C��A�H�K���Z��o��V�æӳy���U�Z�Ѯv�B�ǥͻP�ǥͮa����Ǯզ��Z�B�z���h�H�ߪ��M���C</li>
	</ol>
</td></tr>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
