{{* $Id: list.tpl 5618 2009-09-01 14:42:58Z hami $ *}}

{{include file="$SFS_TEMPLATE/header.tpl"}}

{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">

<tr><td bgcolor="#FFFFFF">

<table width="100%">

<form name="menu_form" method="post" action="{{$smarty.server.PHP_SELF}}">

<tr>

<td>{{$year_seme_menu}} {{$abs_kind}} {{$month}} {{$d_check4_menu}} {{$sum_day}}�@<a  href='record.php'><u>�s�W����</u></a></td>

</tr>

<tr><td>

<table border="0" cellspacing="1" cellpadding="4" width="100%" bgcolor="#cccccc" class="main_body">

<tr bgcolor="#E1ECFF" align="center">

<td >�ǧO</td>
<td>�Юv�m�W</td>
<td>���O</td>
<td>�ƥ�</td>
<td width=120>�}�l�ɶ�<br>�����ɶ�</td>

<td>��Ʈɼ�</td>

<td>�Ұ�</td>

<td>¾�ȥN�z�H</td>
<td>{{$check1}}</td>
<td>{{$check2}}</td>
<td>{{$check3}}</td>
<td>{{$check4}}</td>
</tr>

{{foreach from=$absent item=a name=absent}}

<tr bgcolor="#ddddff" align="center" OnMouseOver="sbar(this)" OnMouseOut="cbar(this)">

<td width=30>{{$a.id}}
<br>
{{if ($a.status=="0" and $a.check1_sn =="0" and $a.check2_sn =="0" and $a.check3_sn =="0" and $a.check4_sn =="0") }} 
	<input type="image" src="images/edit.png" name="edit[{{$a.id}}]" alt="�ק���"> 
	<input type="image" src="images/del.png" name="del[{{$a.id}}]" alt="�R������">
{{/if}}
</td>

<td>{{$tea_arr[$a.teacher_sn]}}</td>
<td>{{$abs_kind_arr[$a.abs_kind]}}
	{{if ($a.abs_kind==52 )}} 
		<input type="image" src="images/supply.png" name="outlay[{{$a.id}}]" alt="�t�ȶO�B�z">
	{{/if}}
	<br><font color=blue>{{$a.note}}</font></td>
<td>{{$a.reason}}<br><font color=blue>{{$a.locale}}</font></td>
<td><font size=3>{{$a.start_date|date_format:"%Y-%m-%d %H:%M"}}<br>

{{$a.end_date|date_format:"%Y-%m-%d %H:%M"}}</font></td>

<td>
{{if $a.day>0 }}{{$a.day}}��{{/if}}
{{if $a.hour>0 }}{{$a.hour}}��{{/if}}
</td>

<td>
{{$course_kind_arr[$a.class_dis]}}<br>

<input type="image" src="images/supply.png" name="class_t[{{$a.id}}]" alt="�ҰȳB�z">

</td>

<td><font size=3>
{{$tea_arr[$a.deputy_sn]}}</font><br>
<font color="{{if $a.status=="1"}}black{{else}}red{{/if}}">{{$status_kind_arr[$a.status]}}</font>
</td>
<td>{{$tea_arr[$a.check1_sn]}}</td>
<td>{{$tea_arr[$a.check2_sn]}}</td>
<td>{{$tea_arr[$a.check3_sn]}}</td>
<td>{{$tea_arr[$a.check4_sn]}}</td>


</tr>

{{/foreach}}

</table></td>

</tr>

</form>

</table></td>

</tr>

</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}



<script language="JavaScript1.2">

<!-- Begin

function sbar(st){st.style.backgroundColor="#F3F3F3";}

function cbar(st){st.style.backgroundColor="";}

//  End -->

</script>