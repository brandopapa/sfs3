{{* $Id: create_data_trans_dos.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table cellspacing="1" cellpadding="3" class="main_body">
<tr bgcolor="#FFFFFF">
<form name="form0" enctype="multipart/form-data" action="{{$smarty.server.PHP_SELF}}" method="post">
<td class="title_sbody1" nowrap>�W�ǾǥͰ򥻸���ɡG</td>
<td colspan="2"><input type="file" name="upload_file"><input type="submit" name="doup_key" value="�W��"></td>
</form>
</tr>
<tr bgcolor="#FFFFFF">
<form name="form1" action="{{$smarty.server.PHP_SELF}}" method="post">
<td class="title_sbody1" nowrap>���A�����s�ɮסG</td>
<td colspan="2">{{$file_menu1}}{{if $chk_file1}} &nbsp;<span style="color:red;">{{$chk_file1}}</span>{{/if}}</td>
</form>
</tr>
{{if $stud_base}}
<form name="form4" action="{{$smarty.server.PHP_SELF}}" method="post">
<tr><td colspan="3" style="color:white;text-align:center;">
�Ĥ@���ǥ͸��
</td></tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�Ǹ�</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.stud_id}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�m�W</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.stud_name}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�����Ҧr��</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.stud_person_id}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�ʧO</td>
<td colspan="2" style="background-color:white;text-align:left;">{{if $stud_base.stud_sex==1}}�k{{elseif $stud_base.stud_sex==2}}�k{{else}}���]�w{{/if}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�ͤ�</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.stud_birthday}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�X�ͦa</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.stud_birth_place}}</td>
</tr>
{{assign var=d value=$stud_base.stud_study_cond}}
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�N�Ǫ��A</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$study_cond.$d}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�J�ǫe��p</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.stud_mschool_name}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">���y�a�}</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.stud_addr_1}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�s���a�}</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.stud_addr_2}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�s���q��</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.stud_tel_2}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">���@�H�m�W</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.guardian_name}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">�P���@�H���Y</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.guardian_relation}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">���@�H�a�}</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.guardian_address}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">���@�H�q��</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.guardian_phone}}</td>
</tr>
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">���@�H���q�q��</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$stud_base.phone}}</td>
</tr>
{{foreach from=$stud_base.seme_year item=d key=i}}
<tr>
<td style="background-color:#cedcfd;color:blue;text-align:center;">��{{$i}}�Ǵ��Z��</td>
<td colspan="2" style="background-color:white;text-align:left;">{{$d}}�Ǧ~��{{$stud_base.seme_class.$i}}�Z{{$stud_base.seme_num.$i}}��</td>
</tr>
{{/foreach}}
{{/if}}
{{if $err_msg}}
<tr><td colspan="3">
{{$err_msg}}
</td></tr>
{{/if}}
</table>
{{if $chk_file1}}
<input type="submit" name="import" value="�T�w�פJ"> <input type="submit" name="del" value="�T�w�R��">
<input type="hidden" name="file_name1" value="{{$smarty.post.file_name1}}">
</form>
{{/if}}
{{if $line!=""}}
<span style="color:red;">�z�W�Ǫ���l��Ʋ� {{$line}} �榳���D�A��ĳ�ק�᭫�s�W�ǡC</span><br>
���_���ơG�u<span style="color:red;">{{$brk_msg}}</span>�v
{{/if}}
<table>
<tr bgcolor="#FBFBC4">
<td><img src="/sfs3/images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td>
</tr>
<tr><td style="line-height:150%;">
<ol>
<li class="small">�p�G�ɮץ��W�ǡA�Х���ܤ@���ɮפW�ǡC</li>
<li class="small">�p�G�ɮפw�W�ǡA�h��ܭn�פJ���ɮסC</li>
<li class="small">�n�B�z���ɮסG�u\STUDENT\PERSON\Pxx\XBASICxx.DBF�v�N�X�N�q (xx:�Ǧ~)</li>
<li class="small">�Х��N���ɥH�u<a href="http://sfshelp.tcc.edu.tw/download/dBase2csv.rar">dBase��CSV�ɵ{��</a>�v�B�z�� XBASICxx.CSV �ɦA�W�ǡC</li>
<li class="small">�ɮ׻����GXBASIC90.dbf��90�Ǧ~�פJ�ǾǥͰ򥻸�ơA�̦������C</li>
<li class="small" style="color:red;">�{���H�ɦW�����J�Ǧ~�P�_�̾ڡA�ҥH�Фť��N����ɦW�C</li>
<li class="small"><a href="XBASIC91.CSV">�d����</a>�C</li>
</ol>
</td></tr>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
