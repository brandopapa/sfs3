{{* $Id: system_acc.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="4" class="small">
<form name="myform" method="post" action="{{$smarty.server.PHP_SELF}}">
<tr>
<td bgcolor="#FFFFFF">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" class="small">
<tr style="color:blue;background-color:#bedcfd;">
<td>�t�μȦs�ؿ�</td><td>�]�w���p</td>
</tr>
<tr bgcolor="white">
<td><input type="text" name="dir_name" value="{{if $smarty.post.dir_name}}{{$smarty.post.dir_name}}{{else}}/tmp{{/if}}"></td>
<td style="color:red;text-align:center;">{{if $status}}�}��{{else}}����{{/if}}</td>
</tr>
</table>
<input type="submit" name="test" value="���ը��x�s">
<input type="submit" name="cancel" value="�����]�w">
<br><br>
{{if $err_msg}}<div style="color:red;">���յ��G�G{{$err_msg}}<br><br></div>{{/if}}
���]�w���ت��O�n�N /sfs3/data/templates_c ���ܨt�Ϊ��Ȧs�ؿ��A�H�[�� smarty ���g�ɳt�סA�ϥλP�_�Цۦ����u�C
</td>
</tr>
</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
