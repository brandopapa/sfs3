{{* $Id: health_import_WEB.tpl 5500 2009-06-17 16:21:00Z brucelyc $ *}}

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
{{if $smarty.post.fkind=="health_wh"}}
<td>�Ǹ�</td><td>�ǥͩm�W</td><td>�Ǧ~</td><td>�Ǵ�</td><td>����</td><td>�魫</td>
</tr>
<tr bgcolor="#FFFFFF" style="text-align:center;">
<td>{{$stud_id}}</td><td>{{$stud_name}}</td><td>{{$rowdata.1}}</td><td>{{$rowdata.2}}</td><td>{{$rowdata.4}}</td><td>{{$rowdata.3}}</td>
{{/if}}
{{if $smarty.post.fkind=="health_sight"}}
<td>�Ǹ�</td><td>�ǥͩm�W</td><td>�Ǧ~</td><td>�Ǵ�</td><td>�r���k</td><td>�r����</td><td>�B���k</td><td>�B����</td><td>���q���</td>
</tr>
<tr bgcolor="#FFFFFF" style="text-align:center;">
<td>{{$stud_id}}</td><td>{{$stud_name}}</td><td>{{$rowdata.1}}</td><td>{{$rowdata.2}}</td><td>{{$rowdata.4}}</td><td>{{$rowdata.3}}</td><td>{{$rowdata.6}}</td><td>{{$rowdata.5}}</td><td>{{$rowdata.15}}</td>
{{/if}}
{{if $smarty.post.fkind=="health_teeth"}}
<td>�Ǹ�</td><td>�ǥͩm�W</td><td>�~��</td><td>�Ǵ�</td><td>�T��</td><td>�ʾ�</td><td>�f�Ľåͤ��}</td><td>������</td><td>���P��</td><td>���C�r�X����</td><td>���i��</td><td>�f���H�����`</td><td>���A</td>
</tr>
<tr bgcolor="#FFFFFF" style="text-align:center;">
<td>{{$stud_id}}</td><td>{{$stud_name}}</td><td>{{$rowdata.1}}</td><td>{{$rowdata.2}}</td><td>{{$rowdata.4}}</td><td>{{$rowdata.5}}</td><td>{{$rowdata.6}}</td><td>{{$rowdata.7}}</td><td>{{$rowdata.8}}</td><td>{{$rowdata.9}}</td><td>{{$rowdata.10}}</td><td>{{$rowdata.15}}</td><td style="color:{{if $ok}}blue{{else}}red{{/if}};">{{if $ok}}�ɮ׮榡���T{{else}}�ɮ׮榡���~{{/if}}</td>
</tr>
<tr bgcolor="#FFFFFF">
<td colspan="2" class="title_sbody1" style="text-align:center;">�f�˪�</td><td colspan="11">{{$rowdata.13}}</td>
{{/if}}
{{if $smarty.post.fkind=="health_inject"}}
<td>�Ǹ�</td><td>�ǥͩm�W</td><td>�̭]���O</td><td>�w�I������</td>
</tr>
<tr bgcolor="#FFFFFF" style="text-align:center;">
<td>{{$stud_id}}</td><td>{{$stud_name}}</td><td>{{$rowdata.1}}</td><td>{{$rowdata.2}}</td>
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
	<li>�Ъ����q�U�װ��d��T�t��Web��<span style="color:red;">(V8.42�H�W����)</span>�u��ƳB�z�v���u��ƶפJ�ץX�v���u�ץXCSV�v�ץX�U����ơC</li>
	<li>���@�~���U�C���q�i��G<br>(1)�u�W���ɮסv�G���N�һ��ɮפW�ǡC<span style="color:red;">(�ФŨϥΤ����ɦW�ýT�{���ɦW��CSV)</span><br>(2)��ܡu�פJ�ɮ����O�v�P�u���A�����s�ɮסv�G�Х���ܡu�פJ�ɮ����O�v�A�A��ܡu���A�����s�ɮסv�C<br>(3)�u��ƸѪR���աv�G�t�η|�۰ʱq�ɮפ��ѪR�����o��ǥͰ򥻸�ƪ��̫e���@����ơC<br>(4)�u�T�w�פJ�v�G�p�T�w�t�θѪR�X����ƵL�~�A�Y�i�i��פJ�@�~�C</li>
{{if $rowdata}}
	<li style="color:red;">�аȥ��T�{�u��Ƥ��R���աv�檺����������T�A�i��פJ�C</li>
{{/if}}
	</ol>
</td></tr>
</table>
</td>
</tr>
</table>
