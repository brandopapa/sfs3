{{* $Id: edu_chart_import.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	<form name ="base_form" enctype="multipart/form-data" action="{{$smarty.server.PHP_SELF}}" method="post" >
    <td width="100%" valign=top bgcolor="#CCCCCC">
		<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			<tr>
				<td class="title_mbody" colspan="2" align="center" >�פJ�ɮ�</td>
			</tr>
			<tr>
				<td class="title_sbody1">��ܶפJ���</td>
				<td>{{$data_sel}}</td>
			</tr>
			<tr>
				<td class="title_sbody1">��ܤW���ɮ�</td>
				<td><input type="file" name="upload_file"></td>
			</tr>
			<tr>
	    	<td width="100%" align="center" colspan="2" >
				<input type=submit name="do_key" value =" �T�w�פJ "></td>
			</tr>
		</table>
	</tr>
	</form>
</table>
{{if $smarty.post.data_id=="" || $smarty.post.data_id==0}}
<table>
<tr bgcolor='#FBFBC4'><td><img src="{{$SFS_PATH_HTML}}/images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td></tr>
<tr><td style="line-height: 150%;">
<ol>
<li class="small"><a href="student.csv">�d����</a></li>
<li class="small">���W�ǧ@�~�D�n��쬰�u�Ǹ��v�B�u�k���r���v�B�u�����r���v�A�]�N�O�H�Ǹ������Ѩ̾ڡA�N�k���r���B�����r���ȼg�J�t�ΡA�ҥH��L���ä����n�C</a></li>
</ol>
</td></tr>
</table>
{{/if}}
{{include file="$SFS_TEMPLATE/footer.tpl"}}
