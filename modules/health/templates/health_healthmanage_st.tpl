{{* $Id: health_healthmanage_st.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<script src="js/DropDownControl.js" language="javascript"></script>
<link href="js/DropDownControl.css"rel="stylesheet" type="text/css"/>

<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<tr><td bgcolor="white">
<table border="0"><tr><td valign="top">
{{*���*}}
<table class="tableBg" cellspacing="1" cellpadding="1">
<tr><td align="center" class="leftmenu">
{{$stud_menu}}
</td>
</tr>
</table>
</td><td valign="top">

{{if $smarty.post.student_sn}}
{{assign var=sn value=$smarty.post.student_sn}}
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
<form name="myform" action="{{$smarty.post.PHP_SELF}}" method="post">
<tr style="color:white;background-color:#aecced;">
<td>����</td>
<td>
�νs�G<span style="color:blue;">{{$health_data->stud_base.$sn.stud_person_id}}</span> &nbsp; 
�ˬd�~�šG<span style="color:blue;">7</span> &nbsp; 
</td>
</tr>

<tr bgcolor="#f4feff">
<td>�`��</td>
<td>
<input type="checkbox">������ &nbsp; �ݴN�E��O�G<br>
<input type="text" OnDblClick="showDropDownItem(this,'{{$check_dep_str}}',1,2,0)" style="background-color:#FFFFC0;width:198px;">
</td>
</tr>

<tr bgcolor="white">
<td>���d�޲z</td>
<td>
<input type="checkbox">�w�N�� &nbsp; ��O�G<br>
<input type="text" style="background-color:#FFFFC0;width:198px;">
<br>
<input type="checkbox">�ݫ���l�� &nbsp; ���ءG<br>
<input type="text" style="background-color:#FFFFC0;width:198px;">
<br>
<input type="checkbox">�ݭ�����ଡ�� &nbsp; <input type="checkbox">�ݰt���U����<br>
<input type="checkbox">�y�b�S��ǮթίS��Z�NŪ<br>
���ѡG<br>
<input type="text" style="width:198px;">
</td>
</tr>

</table>
<input type="submit" name="edit" value="�T�w"> <input type="submit" value="����"> <input type="button" OnClick="window.close();" value="����������">
</td></tr>
<input type="hidden" name="sub_menu_id" value="{{$smarty.post.sub_menu_id}}">
<input type="hidden" name="year_seme" value="{{$smarty.post.year_seme}}">
<input type="hidden" name="class_name" value="{{$smarty.post.class_name}}">
<input type="hidden" name="student_sn" value="{{$smarty.post.student_sn}}">
<input type="hidden" name="nav_prior" value="{{$smarty.post.nav_prior}}">
<input type="hidden" name="nav_next" value="{{$smarty.post.nav_next}}">
<input type="hidden" name="act" value="{{$smarty.post.act}}">
</form></table>
{{/if}}
</td></tr></table>
</td></tr></table>
</td>
</tr>
</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}