{{* $Id: health_setup_place.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

{{assign var=id value=$smarty.post.third_menu_id}}
{{assign var=cname value=$third_menu_arr.$id}}
<input type="submit" name="act" value="�s�W{{$cname}}">
<table bgcolor="#7e9cbd" cellspacing="1" cellpadding="4" class="small">
<tr style="background-color:#9ebcdd;color:white;text-align:center;">
<td>{{$cname}}</td><td>�\��ﶵ</td>
</tr>
{{foreach from=$item_arr item=d key=i}}
<tr bgcolor="white">
{{if $smarty.post.edit_item_id==$i}}
<td><input type="text" name="item_name" value="{{$d}}"></td><td><input type="button" name="sure" value="�T�w�ק�" OnClick="this.form.item_id.value='{{$i}}';this.form.submit();"> <input type="reset" value="�^�_"> <input type="submit" value="���"></td>
{{else}}
<td>{{$d}}</td><td style="text-align:center;"><input type="image" src="images/edit.gif" name="edit_item_id" value="{{$i}}" alt="�s�׳o�����"><input type="image" src="images/delete.gif" name="del_item_id" value="{{$i}}" alt="�R���o�����" OnClick="this.form.submit();"></td>
{{/if}}
</tr>
{{foreachelse}}
<tr bgcolor="white">
<td colspan="2" style="color:red;text-align:center;">�|���]�w����{{$cname}}</td>
</tr>
{{/foreach}}
{{assign var=chkname value=�s�W$cname}}
{{if $smarty.post.act==$chkname}}
<tr style="background-color:yellow;">
<td><input type="text" name="new_item"></td><td><input type="submit" name="act" value="�T�w�s�W"></td>
</tr>
{{/if}}
</table>
<input type="submit" name="act" value="�s�W{{$cname}}">
<input type="hidden" name="item_id" value="">

{{*����*}}
<table class="small">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>�p�G�P�ɦ��O���n�s�W�ΧR���A�ФŪ�����n�R������ƶ��ا令�n�s�W����ƶ��ءA�_�h�N�y����ưO�����áC</li>
	<li>�p�G���`�ϥΪ���ƶ��ءA�Ъ����s�W���W�߶��ءA�ťH�u��L�v�O���A�_�h�N�L�k�i�����T����Ƥ��R�βέp�C</li>
	</ol>
</td></tr>
</table>
