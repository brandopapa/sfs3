{{* $Id: class_import.tpl 5978 2010-08-10 08:47:23Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table cellspacing="1" cellpadding="3" class="main_body">
<tr bgcolor="#FFFFFF">
<form name="form0" enctype="multipart/form-data" action="{{$smarty.server.PHP_SELF}}" method="post">
<td class="title_sbody1" nowrap>�s�Z����ɡG</td>
<td colspan="2"><input type="file" name="upload_file"><input type="submit" name="doup_key" value="�W��"></td>
</form>
</tr>
{{if $msg}}
<tr><td colspan="3" style="background-color:white;text-align:left;">
<br>
{{$msg}}
<br>
</td></tr>
{{/if}}
</table>

<table style="width:100%;">
<tr bgcolor="#FBFBC4">
<td><img src="/sfs3/images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td>
</tr>
<tr><td style="line-height:150%;">
<ol>
<li class="small">�п�ܤ@���ɮפW�ǳB�z�C</li>
<li class="small">���{���ȳB�z�ǥͽs�Z��ơC</li>
<li class="small"><a href="newin.csv">�d����</a>�C</li>
</ol>
</td></tr>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
