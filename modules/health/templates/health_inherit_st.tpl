{{* $Id: health_inherit_st.tpl 5707 2009-10-23 14:35:07Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<script src="js/DropDownControl.js" language="javascript"></script>
<link href="js/DropDownControl.css"rel="stylesheet" type="text/css"/>

<script>
function check_value() {
	if (document.getElementById('u1').value=='') {
		alert('����J�u��ǩʯe�f�v');
		return false;
	}
	return true;
}
</script>

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
{{include file="health_stud_now.tpl"}}

</td><td valign="top">
{{* �a�گe�f�v *}}
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="3" style="color:white;text-align:center;">�a�گe�f�v</td>
</tr>
<tr bgcolor="#f4feff">
<td>����</td><td>��ǩʯe�f</td><td>�\��ﶵ</td>
</tr>
{{foreach from=$health_data->stud_base.$sn.inherit item=dd key=i}}
<tr bgcolor="white">
<td>{{$folk_kind_arr.$i}}</td><td>{{$hereditary_disease_kind_arr.$dd}}</td><td><input type="image" name="del[{{$sn}}][health_inherit][folk_id]" src="images/delete.gif" alt="�R���o�����" value="{{$i}}"></td>
</tr>
{{foreachelse}}
<tr bgcolor="white">
<td colspan="3" style="text-align:center;color:blue;">�L���</td>
</tr>
{{/foreach}}
</table>
{{if $smarty.post.edit}}
<span class="small">�a�ݡG</span><select name="update[{{$sn}}][health_inherit][folk_id]">{{html_options options=$folk_kind_arr selected=$folk_id}}</select>
<span class="small">��ǩʯe�f�G</span><input type="text" id="u1" name="update[{{$sn}}][health_inherit][di_id]" OnDblClick="showDropDownItem(this,'{{$hereditary_disease_kind_str}}',1,0,2);" style="background-color:#FFFFC0;width:25px;">
<span class="small">��L�G</span><input type="text" style="width:133px;"><br>
<input type="button" value="�T�w" OnClick="if (check_value()) {this.form.sure.value='1';this.form.submit();}"> <input type="submit" value="����">
{{else}}
<input type="button" OnClick="this.form.edit.value=1;this.form.submit();" value="�s�W���">
{{/if}}
<input type="button" OnClick="window.opener.renew(1);window.close();" value="����������">
</td></tr>
<input type="hidden" name="sub_menu_id" value="{{$smarty.post.sub_menu_id}}">
<input type="hidden" name="year_seme" value="{{$smarty.post.year_seme}}">
<input type="hidden" name="class_name" value="{{$smarty.post.class_name}}">
<input type="hidden" name="student_sn" value="{{$smarty.post.student_sn}}">
<input type="hidden" name="nav_prior" value="{{$smarty.post.nav_prior}}">
<input type="hidden" name="nav_next" value="{{$smarty.post.nav_next}}">
<input type="hidden" name="act" value="{{$smarty.post.act}}">
<input type="hidden" name="edit" value="">
<input type="hidden" name="sure" value="">
</form></table>
{{/if}}
</td></tr></table>
</td></tr></table>
</td>
</tr>
</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
