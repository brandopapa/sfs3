{{* $Id: system_chk_login_img.tpl 7927 2014-03-13 06:18:04Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="1">
<tr>
<td bgcolor="#FFFFFF">
<table border="0">
<tr><td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" class="small">
<form name="v" method="post" action="{{$smarty.server.PHP_SELF}}">
<tr style="text-align:center;color:blue;background-color:#bedcfd;">
<td colspan="2">�n�J�Ϥ��ˬd</td>
</tr>
{{assign var=c value=$smarty.post.chk-1}}
{{assign var=d value=$smarty.post.dot-1}}
{{assign var=s value=$smarty.post.slope-1}}
{{assign var=r value=$smarty.post.color-1}}
{{assign var=t value=$smarty.post.type}}
{{if ($t=="")}}{{assign var=t value="font"}}{{/if}}
<tr style="background-color:white;text-align:center;">
<td>�{�b���A</td><td style="color:{{if $c}}red{{else}}green{{/if}};"><div OnClick="document.v.chk.value='{{$c*-1}}';document.v.submit();" style="cursor:pointer;">{{if $smarty.post.chk}}�}{{else}}��{{/if}}</div></td>
</tr>
<tr style="text-align:center;color:blue;background-color:#bedcfd;">
<td colspan="2"><input type="radio" name="img_type"{{if $t=="font"}} checked{{/if}} OnClick="document.v.type.value='font';document.v.submit();">�n�J�Ϥ��i��</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td colspan="2"><img src="{{$SFS_PATH_HTML}}pass_img.php" style="vertical-align:middle;"></td>
</tr>
<tr style="background-color:white;text-align:center;">
<td>�r��</td><td><select name="font_no" OnChange="this.form.submit();">
{{html_options options=$font_arr selected=$smarty.post.font_no}}
</select></td>
</tr>
<tr style="background-color:white;text-align:center;">
<td>�I�����I</td><td style="color:{{if $d}}red{{else}}green{{/if}};"><div OnClick="document.v.dot.value='{{$d*-1}}';document.v.submit();" style="cursor:pointer;">{{if $smarty.post.dot}}�}{{else}}��{{/if}}</div></td>
</tr>
<tr style="background-color:white;text-align:center;">
<td>�r��ɱ�</td><td style="color:{{if $s}}red{{else}}green{{/if}};"><div OnClick="document.v.slope.value='{{$s*-1}}';document.v.submit();" style="cursor:pointer;">{{if $smarty.post.slope}}�}{{else}}��{{/if}}</div></td>
</tr>
<tr style="background-color:white;text-align:center;">
<td>�r���C��</td><td style="color:{{if $r}}red{{else}}green{{/if}};"><div OnClick="document.v.color.value='{{$r*-1}}';document.v.submit();" style="cursor:pointer;">{{if $smarty.post.color}}�}{{else}}��{{/if}}</div></td>
</tr>
<tr style="text-align:center;color:blue;background-color:#bedcfd;">
<td colspan="2"><input type="radio" name="img_type"{{if $t=="kitten"}} checked{{/if}} OnClick="document.v.type.value='kitten';document.v.submit();">�p�߹Ϥ��i��</td>
</tr>
<tr style="background-color:white;text-align:center;">
<td colspan="2"><img src="{{$SFS_PATH_HTML}}kitten_img.php" style="vertical-align:middle;"></td>
</tr>
<input type="hidden" name="chk" value="{{$smarty.post.chk}}">
<input type="hidden" name="dot" value="{{$smarty.post.dot}}">
<input type="hidden" name="slope" value="{{$smarty.post.slope}}">
<input type="hidden" name="color" value="{{$smarty.post.color}}">
<input type="hidden" name="type" value="{{$smarty.post.type}}">
</form>
</table>
</td>
</tr>
<table>
<tr bgcolor="#FBFBC4">
<td><img src="{{$SFS_PATH_HTML}}images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td>
</tr>
<tr><td style="line-height:150%;">
<ol>
<li class="small">������۰ʵn�J�{�������A�i�N���\��}�ҡA���t�η|�b�n�J�e���W�[�@�H���r��Ϥ��C</li>
<li class="small">�Y�ݤ���u�n�J�Ϥ��i�ܡv�Ρu�p�߹Ϥ��i�ܡv�檺�Ϥ��A�ФűN���\��}�ҡC</li>
<li class="small">�Y���\��}�ҫ�b�n�J�e���L�k��ܹϤ����ܡA�бN�u/sfs3/data/system/chk_login_img�v�R���Y�i�C</li>
</ol>
</td></tr>
</table>
</td></tr></table>
</td>
</tr>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}