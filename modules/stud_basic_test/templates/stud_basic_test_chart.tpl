{{* $Id: stud_basic_test_chart.tpl 6730 2012-03-26 15:47:34Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<form name="menu_form" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<input type="hidden" name="step" value="{{$smarty.post.step}}">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td style="vertival-align:top;background-color:#CCCCCC;">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" width="100%" class="main_body">
<tr><td>�Ǵ��G{{$year_seme_menu}} �~�šG{{$class_year_menu}} 
{{if $smarty.post.sel}}�m<span style="color:red";>{{if $smarty.post.sel==2}}101�~�X�j����¾(���M)�K�դJ�� (�ӽмҦ�){{else}}����¾�K�դJ�� (�˰e�Ҧ�){{/if}}</span>�n<input type="hidden" name="sel" value="{{$smarty.post.sel}}">{{/if}}
{{if $smarty.post.sel==2}}
<table class="main_body" cellspacing="0" cellpadding="0">
<tr style="vertical-align: top;"><td>
<br>�����ǥͯZ�Ůy���G
<br><textarea name="stud_str" cols="20" rows="20"></textarea>
<br><input type="submit" name="default" value="�@����ҩ���(�C�ҿ�)"> <input type="submit" name="default_sp" value="�S�ب������ҩ���(�C�ҿ�)">
<br><input type="submit" name="n_all" value="�@����ҩ���(���~��)"> <input type="submit" name="sp_all" value="�S�ب������ҩ���(���~��)">
<br>
</td><td><br>
{{if $smarty.post.stud_id}}
�m<span style="color: blue;">�s�W�D�����ǥ�</span>�n<span style="color: white;">�п�ܾǥ�</span>
{{else}}
�D�����ǥ;Ǹ��G<input type="text" size="7" maxlength="7" name="stud_id"><input type="submit" name="add" value="�s�W"><input type="submit" name="print" value="�C�L�Ŀ�">
{{/if}}
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" class="main_body" width="300">
<tr style="background-color: #FFFFCC">
<td style="text-align: center;">���</td>
<td>�J�ǾǦ~��</td>
<td>�ǡ@���@�@</td>
<td>�m�@�W�@�@</td>
</tr>
{{if $smarty.post.stud_id}}
{{foreach from=$rowdata item=d key=sn}}
<tr style="background-color: white;">
<td style="text-align: center;"><input type="radio" name="sn" value="{{$sn}}" OnClick="this.form.submit();"></td>
<td>{{$d.stud_study_year}}</td>
<td>{{$d.stud_id}}</td>
<td style="color: {{if $d.stud_sex==1}}blue{{else}}red{{/if}};">{{$d.stud_name}}</td>
</tr>
{{foreachelse}}
<tr><td colSpan="4" style="background-color: white; color:red; text-align: center;">�ثe�L���</td></tr>
{{/foreach}}
{{else}}
{{foreach from=$predata item=d key=sn}}
<tr style="background-color: white;">
<td style="text-align: center;"><input type="checkbox" name="sel_sn[{{$sn}}]"></td>
<td>{{$d.stud_study_year}}</td>
<td>{{$d.stud_id}}</td>
<td style="color: {{if $d.stud_sex==1}}blue{{else}}red{{/if}};">{{$d.stud_name}}</td>
</tr>
{{foreachelse}}
<tr><td colSpan="4" style="background-color: white; color:red; text-align: center;">�ثe�L���</td></tr>
{{/foreach}}
{{/if}}
</table>
</tr>
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>�Х���J�ǥͯZ�Ůy��(�H������j�A�|��Ʀr�A�ҡG0102)�A��J������A���ҩ��櫬���C</li>
	</ol>
</td></tr>
</table>
{{elseif $smarty.post.sel==3}}
<br>�ǥͯZ�Ůy���G
<br><textarea name="stud_str" cols="20" rows="20"></textarea>
<br><input type="submit" name="TCC" value="���목�ҩ���"> <input type="submit" name="CHC" value="�������ҩ���">
<br>
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>�Х���J�ǥͯZ�Ůy��(�H������j�A�|��Ʀr�A�ҡG0102)�A��J������A���ҩ��櫬���C</li>
	</ol>
</td></tr>
</table>
{{else}}
<br><br>
<table border="0" style="font-size:12px;" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC" align="center">
<td>��</td>
<td>����</td>
<td>���A</td>
<td>�Ѱ��ʦs</td>
</tr>
<tr bgcolor="#EEEEEE" align="center">
<td><input type="radio" name="sel" value="2" {{if $chk_arr.2==1}}OnClick="this.form.submit();"{{else}}disabled="true"{{/if}}></td>
<td>101�~�X�j����¾(���M)�K�դJ��(�ӽ�)</td>
<td><span style="color:{{if $chk_arr.2==1}}blue{{else}}red{{/if}};">{{if $chk_arr.2==1}}�w�ʦs{{else}}���ʦs{{/if}}</span></td>
<td>{{if $chk_arr.2==1}}<input type="submit" name="del[2]" value="�Ѱ�">{{else}}---{{/if}}</td>
</tr>
<tr bgcolor="white" align="center">
<td><input type="radio" name="sel" value="3" {{if $chk_arr.3==1}}OnClick="this.form.submit();"{{else}}disabled="true"{{/if}}></td> 
<td>99�~����¾�K�դJ��(�˰e)</td>
<td><span style="color:{{if $chk_arr.3==1}}blue{{else}}red{{/if}};">{{if $chk_arr.3==1}}�w�ʦs{{else}}���ʦs{{/if}}</span></td>
<td>{{if $chk_arr.3==1}}<input type="submit" name="del[3]" value="�Ѱ�">{{else}}---{{/if}}</td>
</tr>
</table>
<br>
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>�ϥΥ��\��e�Х��N��ƫʦs�]�����\���s�p��^�A�Y�ݭ��s�p��A�Х��N��ƸѰ��ʦs���A�C</li>
	</ol>
</td></tr>
</table>
{{/if}}
</tr>
</table>
</td></tr>
</table>
</form>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
