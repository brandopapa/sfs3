{{* $Id: health_import_SHL.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<table border="0" cellspacing="0" cellpadding="0"><tr><td style="vertical-align:top;">
<table cellspacing="1" cellpadding="3" class="main_body">
<tr bgcolor="#FFFFFF">
</form>
<form name="form0" enctype="multipart/form-data" action="{{$smarty.server.PHP_SELF}}" method="post">
<td class="title_sbody1" nowrap>�W���ɮסG</td>
<td><input type="file" name="upload_file"><input type="submit" name="doup_key" value="�W��"><input type="hidden" name="sub_menu_id" value="{{$smarty.post.sub_menu_id}}"></td>
</form>
</tr>
<form name="form1" action="{{$smarty.server.PHP_SELF}}" method="post">
<tr bgcolor="#FFFFFF">
<td class="title_sbody1" nowrap>�פJ�ɮ����O�G</td>
<td>
	<select name="fkind">
	{{html_options options=$file_kind_arr selected=$smarty.post.fkind}}
	</select>
</td>
</tr>
<tr bgcolor="#FFFFFF">
<td class="title_sbody1" nowrap>���A�����s�ɮסG</td>
<td>{{$file_menu}}{{if $chk_file}} &nbsp;<span style="color:red;">({{$chk_file}})</span>{{/if}}<input type="hidden" name="sub_menu_id" value="{{$smarty.post.sub_menu_id}}"></td>
</tr>
{{if $rowdata}}
<tr bgcolor="#FFFFFF">
<td class="title_sbody1">��ƸѪR���աG</td>
<td>
<table border="0" cellspacing="0" cellpadding="0"><tr><td style="vertical-align:top;">
<table cellspacing="1" cellpadding="3" class="main_body">
<tr class="title_sbody1" style="text-align:center;">
{{if $smarty.post.fkind=="health_mapping"}}
<td>�Ǹ�</td><td>�ǥͩm�W</td><td>�ʧO</td>
</tr>
<tr bgcolor="#FFFFFF" style="text-align:center;">
<td>{{$rowdata.1}}</td><td>{{$rowdata.0}}</td><td>{{$rowdata.5}}</td>
{{/if}}
{{if $smarty.post.fkind=="health_wh"}}
<td>�Ǹ�</td><td>�ǥͩm�W</td><td>�Ǧ~</td><td>�Ǵ�</td><td>����</td><td>�魫</td><td>���q���</td>
</tr>
<tr bgcolor="#FFFFFF" style="text-align:center;">
<td>{{$stud_id}}</td><td>{{$stud_name}}</td><td>{{$rowdata.1}}</td><td>{{$rowdata.2}}</td><td>{{$rowdata.7}}</td><td>{{$rowdata.8}}</td><td>{{$rowdata.4}}-{{$rowdata.5}}-{{$rowdata.6}}</td>
{{/if}}
{{if $smarty.post.fkind=="health_sight"}}
<td>�Ǹ�</td><td>�ǥͩm�W</td><td>�Ǧ~</td><td>�Ǵ�</td><td>�r���k</td><td>�r����</td><td>�B���k</td><td>�B����</td><td>���q���</td>
</tr>
<tr bgcolor="#FFFFFF" style="text-align:center;">
<td>{{$stud_id}}</td><td>{{$stud_name}}</td><td>{{$rowdata.1}}</td><td>{{$rowdata.2}}</td><td>{{$rowdata.6}}</td><td>{{$rowdata.7}}</td><td>{{$rowdata.8}}</td><td>{{$rowdata.9}}</td><td>{{$rowdata.3}}-{{$rowdata.4}}-{{$rowdata.5}}</td>
{{/if}}
{{if $smarty.post.fkind=="health_teeth"}}
<td>�Ǹ�</td><td>�ǥͩm�W</td><td>�Ǧ~</td><td>�Ǵ�</td><td>�T��</td><td>�ʾ�</td><td>�w�B�v</td><td>�ݩ�</td><td>���q���</td><td>���A</td>
</tr>
<tr bgcolor="#FFFFFF" style="text-align:center;">
<td>{{$stud_id}}</td><td>{{$stud_name}}</td><td>{{$rowdata.1}}</td><td>{{$rowdata.2}}</td><td>{{$ts.0|@intval}}</td><td>{{$ts.1|@intval}}</td><td>{{$ts.2|@intval}}</td><td>{{$ts.3|@intval}}</td><td>{{$rowdata.3}}-{{$rowdata.4}}-{{$rowdata.5}}</td><td style="color:{{if $ok}}blue{{else}}red{{/if}};">{{if $ok}}�ɮ׮榡���T{{else}}�ɮ׮榡���~{{/if}}</td>
{{/if}}
{{if $smarty.post.fkind=="health_accident"}}
<td>�Ǹ�</td><td>�ǥͩm�W</td><td>�Ǧ~</td><td>�Ǵ�</td><td>�ɶ�</td><td>�a�I</td><td>��]</td><td>����</td><td>���p</td><td>�B�m�覡</td><td>��L����</td>
</tr>
<tr bgcolor="#FFFFFF" style="text-align:center;">
<td>{{$stud_id}}</td><td>{{$stud_name}}</td><td>{{$rowdata.1}}</td><td>{{$rowdata.2}}</td><td>{{$rowdata.3}}-{{$rowdata.4}}-{{$rowdata.5}} {{$rowdata.8}}</td><td>{{$rowdata.10}}</td><td>{{$rowdata.12}}</td><td>{{$rowdata.9}}</td><td>{{$rowdata.11}}{{if $rowdata.11 && $rowdata.13}}�B{{/if}}{{$rowdata.13}}</td><td>{{$rowdata.14}}{{if $rowdata.14 && $rowdata.15}}�B{{/if}}{{$rowdata.15}}</td><td>{{$rowdata.17}}</td>
{{/if}}
</tr>
</table>
<input type="submit" name="sure" value="�T�w�פJ">
</td></tr></table>
</td>
</tr>
{{/if}}
</form>
</table>
{{*����*}}
<table class="small">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>�Шϥ�<a href="http://sfshelp.tcc.edu.tw/download/MDB2csv.rar">�u�@�媩�Ǯհ��d��T�t�θ����CSV�ɵ{���v</a>�ץX�U����ơC</li>
	<li>���@�~���U�C���q�i��G<br>(1)�u�W���ɮסv�G���N�һ��ɮפW�ǡC<br>(2)��ܡu�פJ�ɮ����O�v�P�u���A�����s�ɮסv�G�Х���ܡu�פJ�ɮ����O�v�A�A��ܡu���A�����s�ɮסv�C<br>(3)�u��ƸѪR���աv�G�t�η|�۰ʱq�ɮפ��ѪR�����o��ǥͰ򥻸�ƪ��̫e���@����ơC<br>(4)�u�T�w�פJ�v�G�p�T�w�t�θѪR�X����ƵL�~�A�Y�i�i��פJ�@�~�C</li>
	<li>�ثe�ǥ͹�����Ʀ@ <span style="color:red;">{{$havedb}}</span> ���A�нT�{��Ƶ��ƬO�_���T�C</li>
	<li>�Y�ǥ͹�����Ƶ��Ƥ����A�Х��פJ�ǥͰ򥻸�ơA�إ߹������Y��A�_�h�ǥͰ��d��ƱN�L�k���T�פJ�C</li>
{{if $rowdata}}
	<li style="color:red;">�аȥ��T�{�u��Ƥ��R���աv�檺����������T�A�i��פJ�C</li>
{{/if}}
	</ol>
</td></tr>
</table>
</td>
</tr>
</table>