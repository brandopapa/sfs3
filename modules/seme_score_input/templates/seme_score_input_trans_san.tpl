{{* $Id: seme_score_input_trans_san.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table border="0" cellspacing="0" cellpadding="0"><tr><td style="vertical-align:top;">
<table cellspacing="1" cellpadding="3" class="main_body">
<tr bgcolor="#FFFFFF">
<form name="form0" enctype="multipart/form-data" action="{{$smarty.server.PHP_SELF}}" method="post">
<td class="title_sbody1" nowrap>�W�Ǭ�س]�w�ɡG</td>
<td colspan="2"><input type="file" name="upload_setup_file"><input type="submit" name="doup_key" value="�W��"></td>
</form>
</tr>
<tr bgcolor="#FFFFFF">
<form name="form1" action="{{$smarty.server.PHP_SELF}}" method="post">
<td class="title_sbody1" nowrap>���A�����s�ɮסG</td>
<td colspan="2">{{$file_menu1}}{{if $chk_file1}} &nbsp;<span style="color:red;">{{$chk_file1}}</span>{{/if}}</td>
</form>
</tr>
{{if $smarty.post.file_name1}}
<tr bgcolor="#FFFFFF">
<form name="form2" enctype="multipart/form-data" action="{{$smarty.server.PHP_SELF}}" method="post">
<td class="title_sbody1" nowrap>�W�Ǧ��Z�ɡG</td>
<td colspan="2"><input type=file name="upload_file"><input type=submit name="doup_key" value="�W��"><input type="hidden" name="file_name1" value="{{$smarty.post.file_name1}}"></td>
</form>
</tr>
<tr bgcolor="#FFFFFF">
<form name="form3" action="{{$smarty.server.PHP_SELF}}" method="post">
<td class="title_sbody1" nowrap>���A�����s�ɮסG</td>
<td colspan="2">{{$file_menu2}}{{if $chk_file1}} &nbsp;<span style="color:red;">{{$chk_file2}}</span>{{/if}}<input type="hidden" name="file_name1" value="{{$smarty.post.file_name1}}"></td>
</form>
</tr>
{{if $rowdata}}
<form name="form4" action="{{$smarty.server.PHP_SELF}}" method="post">
{{foreach from=$stud_data item=d key=i name=s}}
<tr><td colspan="3" style="color:white;">
<input type="radio" name="stud_study_year" value="{{$d.stud_study_year}}" {{if $smarty.foreach.s.iteration==1}}checked{{/if}}>
�Ǹ� : {{$d.stud_id}} &nbsp;&nbsp; 
�m�W : {{$d.stud_name}} &nbsp;&nbsp; 
�ʧO : {{if $d.stud_sex==1}}�k{{elseif $d.stud_sex==2}}�k{{else}}���]�w{{/if}} &nbsp;&nbsp; 
�J�Ǧ~ : {{$d.stud_study_year}}</td></tr>
{{/foreach}}
<tr style="background-color:#aecced;color:white;text-align:center;">
<td>��]�w��ئW</td>
<td>���Z</td>
<td>�פJ������ئW</td></tr>
{{foreach from=$rowdata item=d key=i}}
<tr>
<td nowrap style="background-color:#cedcfd;color:blue;text-align:center;">{{$subj_arr.$i.subj_name}}</td>
<td style="background-color:white;text-align:right;">{{$d}}&nbsp;&nbsp;</td>
<td style="background-color:white;text-align:center;">{{$subj_menu|@substr_replace:$i:23:3}}</td>
</tr>
{{/foreach}}
{{/if}}
{{/if}}
</table>
{{if $rowdata}}
<input type="submit" name="import" value="�T�w�פJ">
<input type="hidden" name="file_name1" value="{{$smarty.post.file_name1}}">
<input type="hidden" name="file_name2" value="{{$smarty.post.file_name2}}">
</form>
{{/if}}
{{if $ok>0}}<span class="small" style="color:blue;">�פJ���T���ơG{{$ok}}<br>{{/if}}
{{if $in_err>0}}<span class="small" style="color:red;">�פJ���~���ơG{{$in_err}}<br>{{/if}}
{{if $sn_err>0}}<span class="small" style="color:red;">�Ǹ����~���ơG{{$sn_err}}<br>{{/if}}
</td><td style="vertical-align:top;">
<table cellspacing="1" cellpadding="3" class="main_body" style="color:red;">
<tr style="background-color:#f0f0f0;">
<td>
�`�N�ƶ��G
<ol>
<li>���{�����A�Ω�u�Z�Žҵ{�v���ҵ{�]�w�Ҧ��C</li>
<li>�פJ�e�Х��إ߾ǥͰ򥻸�ƤΦU�Ǵ������]�w�C</li>
<li>�ǰȨt�Τ����ҵ{�]�w�кɶq�t�X��t�νҵ{�]�w�C</li>
<li>���פJ����إi����u�פJ������ءv�C</li>
{{if $rowdata}}
<li style="color:blue;">�Y�S���X�{�ǥͩm�W��ܾǥͰ򥻸�ƥ��إߡC</li>
<li style="color:blue;">�Y�u�פJ������ءv�S���X�{����ܽҵ{���]�w�C</li>
<li style="color:blue;">�Y���Z�Ȭ��u999�v��ܸӥ͸Ӭ쥼��J���Z�C</li>
{{/if}}
{{if $in_err>0}}
<li style="color:green;">�u�פJ���~�v���ӥ͸ӾǴ��w�����Z�C</li>
{{/if}}
{{if $sn_err>0}}
<li style="color:green;">�u�Ǹ����~�v���ӾǸ��䤣��������ǥͰ򥻸�ơC</li>
{{/if}}
</ol>
</td>
</tr></table>
</td></tr></table>
<table>
<tr bgcolor="#FBFBC4">
<td><img src="/sfs3/images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td>
</tr>
<tr><td style="line-height:150%;">
<ol>
<li class="small">�p�G�ɮץ��W�ǡA�Х���ܤ@���ɮפW�ǡC</li>
<li class="small">�p�G�ɮפw�W�ǡA�h��ܭn�פJ���ɮסC</li>
<li class="small">�n�B�z���ɮסG<br>
(1) ��س]�w�� :�u\STUDENT\COURSE\R9x\Y91S9xyz.DBF�v<br>
(2) ���Z�� :�u\STUDENT\STAGE\G9x\Y91G9xyz.DBF�v<br>
�N�X�N�q (x:�Ǧ~�̫�@�X�By:�Ǵ��Bz:�~��)</li>
<li class="small">�Х��N���G�ɥHOpenOffice.org Calc���}�A�M��s��CSV�榡��A��ܤW�ǡA�x�s�ɡu�s��z��]�w�v�ȥ��Ŀ�B�ɦW�ŧ�C</li>
<li class="small">�W�ǫe���T�{�ɦW���uY91S9xyz.CSV�v�P�uY91G9xyz.CSV�v�A����ɮװȥ��t�X(�P�Ǧ~�סB�P�Ǵ��B�P�~��)�C</li>
<li class="small">�ɮ׻����GY91S9417.dbf��94�Ǧ~�ײ�1�Ǵ�7�~�Ŭ�س]�w�ɡBY91G9417.dbf��94�Ǧ~�ײ�1�Ǵ�7�~�Ŧ��Z�ɡA�̦������C</li>
<li class="small"><a href="Y91S9417.CSV">��س]�w�d����</a>�B<a href="Y91G9417.CSV">���Z�d����</a>�C</li>
</ol>
</td></tr>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
