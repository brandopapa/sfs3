{{* $Id: every_year_setup_section_time.tpl 6688 2012-02-08 02:27:53Z infodaes $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<table cellspacing="0" cellpadding="0" border="0">
<tr valign="top">
<form name="menu_form" method="post" action="{{$smarty.server.PHP_SELF}}">
<td>
<table bgcolor="#9EBCDD" cellspacing="1" cellpadding="4">
{{if $smarty.post.act==""}}
<tr bgcolor="#FFFFFF"><td>
<table>
<tr>
<td>�п�ܱ��]�w���Ǵ��G{{$year_seme_menu}}</td>
</tr>
<tr><td>
<input type="submit" name="act" value="�}�l�]�w" class="b1"> <input type="submit" name="act" value="�[�ݳ]�w" class="b1">
</td></tr>
</table>
</td></tr>
{{else}}
<tr bgcolor="#E1ECFF" class="small" align="center">
<td colspan="2"><font color="#607387"><font color="black">{{$sel_year}}</font>�Ǧ~��<font color="black">{{$sel_seme}}�Ǵ��U�`�W�Үɶ���</font>
{{if !$year_seme_data}}<br><br><font color='red'>���Ǵ��U�`�W�Үɶ��|���]�w�A��C��ƫY�e�@�Ǵ���ơI</font>{{/if}}
</td>
</tr>
<tr bgcolor="#E1ECFF" class="small" align="center">
<td>�`��<td>�_���ɶ�</td>
</tr>
{{foreach from=$section_table item=v key=i}}
<tr bgcolor="white" class="small" align="center">
<td>{{$i}}<td bgcolor="{{$bg.$i}}">{{if $smarty.post.act=="�}�l�]�w"}}<input type="text" size="5" name="st[{{$i}}][0]" value="{{$section_table.$i.0}}"> - <input type="text" size="5" name="st[{{$i}}][1]" value="{{$section_table.$i.1}}">{{else}}{{$section_table.$i.0}} - {{$section_table.$i.1}}{{/if}}</td>
</tr>
{{/foreach}}
{{/if}}
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
<table>
<tr bgcolor="#FBFBC4"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td></tr>
<tr><td style="line-height: 150%;">
<ol>
{{if $smarty.post.act==""}}
<li class="small">�п�ܤ@�ӾǦ~�B�Ǵ��H���]�w�C</li>
<li class="small"><span class="like_button">�}�l�]�w</span>�|�}�l�i��ӾǴ��U�`�W�Үɶ����]�w�C</li>
<li class="small"><span class="like_button">�[�ݳ]�w</span>�|�C�X�ӾǴ��U�`�W�Үɶ����]�w�C
{{else}}
<li class="small">�ɶ����榡��hh:mm�C�ҡG08:00�C</li>
<li class="small">��ܬ��⩳�⪺�ϰ��ܮɶ��]�w�W�����D�C�Ҧp�U�Үɶ���W�Үɶ����A�άO�᭱�`�����ɶ���e���`�����ɶ����A�аȥ��󥿡C</li>
{{/if}}
</li>
</ol>
</td></tr>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}