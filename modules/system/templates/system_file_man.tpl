{{* $Id: system_file_man.tpl 5488 2009-06-03 02:32:36Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="4" class="small">
<form name="myform" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<tr>
<td bgcolor="#FFFFFF">
�ثe���ؿ�&gt; <span style="color:blue;">data/{{foreach from=$smarty.post.path item=d}}{{$d}}/{{/foreach}}</span><br><br>
{{foreach from=$rowdata item=d}}
<img src="images/{{$d.kind}}.png"> {{if $d.kind=="dir"}}<a href="#" OnClick="document.getElementById('path').value='{{$d.name}}';document.myform.submit();">{{$d.name}}</a>{{else}}<a href="{{$url}}/{{$d.name}}" target="new">{{$d.name}}</a> <a href="#" OnClick="document.getElementById('del').value='{{$d.name}}';document.myform.submit();"><img src="images/del.png" border="0"></a>{{/if}}<br>
{{/foreach}}
<br>
<table>
<tr bgcolor="#FBFBC4">
<td><img src="{{$SFS_PATH_HTML}}images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td>
</tr>
<tr><td style="line-height:150%;">
<ol>
<li class="small">���\��Ω��˵�data�ؿ������ɮ�(���t�t���ɮ�)�C</li>
<li class="small">�Y���ɮת��\�ण�F�ѽФť��N�R�ɡC</li>
<li class="small">�Y�ɮ׵L�k�R���A���apache���ɮת��v�������A���ˬd�ɮ��v���]�w�O�_���T�C</li>
<li class="small">�Y�ɮ׵L�k�s���A���httpd.conf��upfiles��alias�]�w�����T�C</li>
</ol>
</td></tr>
</table>
</td>
</tr>
{{assign var=i value=0}}
{{foreach from=$smarty.post.path item=d}}
<input type="hidden" name="path[{{$i}}]" value="{{$d}}">
{{assign var=i value=$i+1}}
{{/foreach}}
<input type="hidden" name="path[{{$i}}]" id="path">
<input type="hidden" name="del" id="del">
</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
