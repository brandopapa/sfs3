{{* $Id: health_setup_hos.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<input type="submit" name="act" value="�s�W��|�ζE��">
<table bgcolor="#7e9cbd" cellspacing="1" cellpadding="4" class="small">
<tr style="background-color:#9ebcdd;color:white;text-align:center;">
<td>��|�ζE�ҦW��</td><td>�\��ﶵ</td>
</tr>
{{foreach from=$hos_arr item=d key=i}}
<tr bgcolor="white">
{{if $smarty.post.edit_hos_id==$i}}
<td><input type="text" name="hos_name" value="{{$d}}"></td><td><input type="button" name="sure" value="�T�w�ק�" OnClick="this.form.hos_id.value='{{$i}}';this.form.submit();"> <input type="reset" value="�^�_"> <input type="submit" value="���"></td>
{{else}}
<td>{{$d}}</td><td style="text-align:center;"><input type="image" src="images/edit.gif" name="edit_hos_id" value="{{$i}}" alt="�s�׳o�����"><input type="image" src="images/delete.gif" name="del_hos_id" value="{{$i}}" alt="�R���o�����" OnClick="this.form.submit();"></td>
{{/if}}
</tr>
{{foreachelse}}
<tr bgcolor="white">
<td colspan="2" style="color:red;text-align:center;">�|���]�w������|�ζE��</td>
</tr>
{{/foreach}}
{{if $smarty.post.act=="�s�W��|�ζE��"}}
<tr style="background-color:yellow;">
<td><input type="text" name="new_hos"></td><td><input type="submit" name="act" value="�T�w�s�W"></td>
</tr>
{{/if}}
</table>
<input type="submit" name="act" value="�s�W��|�ζE��">
<input type="hidden" name="hos_id" value="">

{{*����*}}
<table class="small">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>�p�G�P�ɦ��O���s�W�ΧR���A�ФŪ�����n�R������Ƨ令�n�s�W����ơA<br>�_�h�N�y����ƿ��áC</li>
	</ol>
</td></tr>
</table>
