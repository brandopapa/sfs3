{{* $Id: $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<form name="menu_form" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td style="vertival-align:top;background-color:#CCCCCC;">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" width="100%" class="main_body">
<tr><td>�Ǵ��G{{$year_seme_menu}} �~�šG{{$class_year_menu}} 
<table class="main_body" cellspacing="0" cellpadding="0">
<tr style="vertical-align: top;"><td style="width:50%;">
<br>�п�J���ɥͯZ�Ůy���G
<br><textarea name="stud_str" cols="20" rows="20"></textarea>
<br><input type="submit" name="add" value="�T�w�s�W">
<br>
</td><td>&nbsp;</td><td>

<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" class="main_body" width="300">
<tr style="background-color: #FFFFCC">
<td colSpan="5" style="text-align: center;">{{$work_year}}�Ǧ~�ת��ɥͦW�U</td>
</tr>
<tr style="background-color: #FFFFCC">
<td style="text-align: center;">�R��</td>
<td>�Z�@�š@�@</td>
<td>�y�@���@�@</td>
<td>�ǡ@���@�@</td>
<td>�m�@�W�@�@</td>
</tr>
{{foreach from=$rowdata item=d key=sn}}
<tr style="background-color: white;">
<td style="text-align: center;"><input type="radio" name="sn" value="{{$sn}}" OnClick="this.form.submit();"></td>
<td>{{$d.class_no}}</td>
<td>{{$d.seme_num}}</td>
<td>{{$d.stud_id}}</td>
<td style="color: {{if $d.stud_sex==1}}blue{{else}}red{{/if}};">{{$d.stud_name}}</td>
</tr>
{{foreachelse}}
<tr><td colSpan="5" style="background-color: white; color:red; text-align: center;">�ثe�L���</td></tr>
{{/foreach}}

</table>
</tr>
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>�п�J�ǥͯZ�Ůy��(�H������j�A�|��Ʀr�A�ҡG0102)</li>
	</ol>
</td></tr>
</table>
<br>

</tr>
</table>
</td></tr>
</table>
</form>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
