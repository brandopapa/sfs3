{{* $Id: health_stud_now.tpl 5831 2010-01-19 08:05:00Z hami $ *}}
<form name="myform" action="{{$smarty.post.PHP_SELF}}" method="post">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="2" style="color:white;text-align:center;">�ثe�s��ǥ�</td>
</tr>
<tr bgcolor="#f4feff">
<td>�νs</td><td>{{$health_data->stud_base.$sn.stud_person_id}}</td>
</tr>
<tr bgcolor="white">
<td>�ǥ�</td><td>{{$health_data->stud_base.$sn.stud_name}}</td>
</tr>
<tr bgcolor="#f4feff">
<td>�Ǹ�</td><td>{{$health_data->stud_base.$sn.stud_id}}</td>
</tr>
<tr bgcolor="white">
<td>�ͤ�</td><td>{{$health_data->stud_base.$sn.stud_birthday}}</td>
</tr>
<tr style="background-color:white;">
<td>�嫬</td><td>{{$health_data->stud_base.$sn.stud_blood_type}}</td>
</tr>
<tr bgcolor="#f4feff">
<td>����</td><td>{{$health_data->stud_base.$sn.fath_name}}</td>
</tr>
<tr bgcolor="white">
<td>����</td><td>{{$health_data->stud_base.$sn.moth_name}}</td>
</tr>
<tr bgcolor="#f4feff">
<td>���s��</td><td>{{$health_data->stud_base.$sn.stud_tel_2}}</td>
</tr>
</table>
