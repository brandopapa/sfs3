{{* $Id: every_year_setup_course_setup_import.tpl 5592 2009-08-19 02:21:05Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<table cellspacing="0" cellpadding="0" border="0">
<tr valign="top">
<form name="menu_form" method="post" action="{{$smarty.server.PHP_SELF}}" enctype="multipart/form-data">
<td>
{{if $ifile}}
{{include file=$ifile}}
{{else}}
<table bgcolor="#9EBCDD" cellspacing="1" cellpadding="4">
<tr bgcolor="#FFFFFF">
<td>
<table>
<tr>
<td>�п�ܱ��]�w���Ǵ��G{{$year_seme_menu}}</td>
</tr>
<tr><td>
<input type="submit" name="act" value="�i��פJ�@�~" class="b1"> 
<input type="submit" name="act" value="�M���פJ���" class="b1">
<input type="submit" name="act" value="�^��Ҫ�]�w" class="b1" OnClick="this.form.import.value='0'"><br>
<input type="submit" name="act" value="�i��Юv����" class="b1"> 
<input type="submit" name="act" value="�i��ҵ{����" class="b1">
<input type="submit" name="act" value="�g�J�Ҫ�]�w" class="b1">
<input type="hidden" name="import" value="1">
</td></tr>
</table>
</td></tr>
</table>
{{if $smarty.post.act=="�}�l�]�w"}}
<td><input type="submit" name="save" value="�x�s�]�w">
{{elseif $smarty.post.act=="�[�ݳ]�w" || $smarty.post.act=="show"}}
<td><input type="submit" name="act" value="�}�l�]�w">
{{/if}}
</td>
</form>
</tr></table>
<br>
<table width="100%" class="small"><tr>
<td style="vertical-align:top;" width="25%">
<fieldset>
<legend>�Z�Ź���</legend>
�`�Z�ơG{{$data.c.0}}<br>
�w�����G{{$data.c.1}}<br>
�L�����G{{$data.c.2}}
</fieldset>
</td>
<td style="vertical-align:top;" width="25%">
<fieldset>
<legend>�Юv����</legend>
�`�H�ơG{{$data.t.0}}<br>
�w�����G{{$data.t.1}}<br>
�L�����G{{$data.t.2}}<br>
</fieldset>
</td>
<td style="vertical-align:top;" width="25%">
<fieldset>
<legend>�ҵ{����</legend>
�`�ҼơG{{$data.s.0}}<br>
�w�����G{{$data.s.1}}<br>
�L�����G{{$data.s.2}}<br>
</fieldset>
</td>
<td style="vertical-align:top;" width="25%">
<fieldset>
<legend>�`������</legend>
�`�`�ơG{{$data.ss.0}}<br>
�w�����G{{$data.ss.1}}<br>
�L�����G{{$data.ss.2}}<br>
</fieldset>
</td></tr></table>
<br>
{{if $err_msg!=""}}<font color="red">{{$err_msg}}</font><br><br>{{/if}}
<table>
<tr bgcolor="#FBFBC4"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td></tr>
<tr><td style="line-height: 150%;">
<ol>
{{if $step==""}}
<li class="small">�п�ܤ@�ӾǦ~�B�Ǵ��H���]�w�C</li>
<li class="small"><span class="like_button">�i��פJ�@�~</span>�}�l�i��ӾǴ��Ҫ��פJ�@�~�C</li>
<li class="small"><span class="like_button">�M���פJ���</span>�M���w�פJ���Ȧs��ơC
{{elseif $step==1}}
<li class="small">�Х��W�ǽҪ��ɥH�Ѩt�ζi��ѪR�C</li>
<li class="small">�ФŨϥΤ����ɦW�H�K�o�Ϳ��~�C</li>
<li class="small">���t�Υثe�䴩�Y�e�ƽҨt�ΡC</li>
<li class="small">��L�ƽҨt�Τ䴩�Ь��t�ζ}�o�H���C</li>
{{/if}}
</li>
</ol>
{{/if}}
</td></tr>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
