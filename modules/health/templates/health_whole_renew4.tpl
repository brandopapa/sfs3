{{* $Id: health_whole_renew4.tpl 5708 2009-10-23 15:33:08Z brucelyc $ *}}

<form action="{{$smarty.server.SCRIPT_NAME}}" method="post" target="_blank">
{{assign var=sn value=$smarty.post.student_sn}}

{{* �w������ *}}
{{assign var=inject value=$health_data->health_data.$sn.inject}}
<table style="background-color:#9ebcdd;" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="3" style="color:white;"><input type="image" src="images/edit.gif">�w������</td>
</tr>
<tr style="background-color:#f4feff;">
<td>����</td><td>�ǫe</td><td>���ذO��</td>
</tr>
<tr style="background-color:white;">
<td>���d</td><td>�@</td><td>{{if $inject.0.0.times==1}}<span style="color:blue;">�wú{{else}}<span style="color:red;">��ú{{/if}}</span></td>
</tr>
<tr style="background-color:#f4feff;">
<td>�d���]</td><td>{{$inject.0.1.times|intval}}</td><td>�@</td>
</tr>
<tr style="background-color:white;">
<td>B���x��</td><td>{{$inject.0.2.times|intval}}</td><td>�@</td>
</tr>
<tr style="background-color:#f4feff;">
<td>�p��·�</td><td>{{$inject.0.3.times|intval}}</td><td>�@</td>
</tr>
<tr style="background-color:white;">
<td>�}�˭��ճ�</td><td>{{$inject.0.4.times|intval}}</td><td>�@</td>
</tr>
<tr style="background-color:#f4feff;">
<td>�饻����</td><td>{{$inject.0.5.times|intval}}</td><td>�@</td>
</tr>
<tr style="background-color:white;">
<td>MMR</td><td>{{$inject.0.7.times|intval}}</td><td>�@</td>
</tr>
</table>

{{* �{�ɩʹw������ *}}
<table style="background-color:#9ebcdd;" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="2" style="color:white;"><input type="image" src="images/edit.gif">�{�ɩʹw������</td>
</tr>
</table>

{{* �{�ɩ��ˬd *}}
<table style="background-color:#9ebcdd;" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="2" style="color:white;"><input type="image" src="images/edit.gif">�{�ɩ��ˬd</td>
</tr>
</table>
<input type="hidden" name="sub_menu_id" value="{{$smarty.post.sub_menu_id}}">
<input type="hidden" name="year_seme" value="{{$smarty.post.year_seme}}">
<input type="hidden" name="class_name" value="{{$smarty.post.class_name}}">
<input type="hidden" name="student_sn" value="{{$smarty.post.student_sn}}">
<input type="hidden" name="act" value="">
</form>
