{{* $Id: health_whole_renew3.tpl 5708 2009-10-23 15:33:08Z brucelyc $ *}}

<form action="{{$smarty.server.SCRIPT_NAME}}" method="post" target="_blank">
{{assign var=sn value=$smarty.post.student_sn}}

{{* �������� *}}
<table style="background-color:#9ebcdd;" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="2" style="color:white;text-align:center;"><input type="image" src="images/edit.gif" OnClick="this.form.act.value='checkinput_st';">��������<input type="image" src="images/edit.gif" OnClick="this.form.act.value='healthmanage_st';">���d�޲z</td>
</tr>
<tr style="background-color:#f4feff;">
<td>�Ǵ������</td><td>�Ĥ@�Ǵ�</td>
</tr>
</table>

{{* ������ˬd *}}
<table style="background-color:#9ebcdd;" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="2" style="color:white;text-align:center;">������ˬd</td>
</tr>
<tr style="background-color:#f4feff;">
<td><input type="image" src="images/edit.gif">���G</td><td>��d</td>
</tr>
</table>
<input type="hidden" name="sub_menu_id" value="{{$smarty.post.sub_menu_id}}">
<input type="hidden" name="year_seme" value="{{$smarty.post.year_seme}}">
<input type="hidden" name="class_name" value="{{$smarty.post.class_name}}">
<input type="hidden" name="student_sn" value="{{$smarty.post.student_sn}}">
<input type="hidden" name="act" value="">
</form>
