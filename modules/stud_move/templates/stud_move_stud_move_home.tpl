{{* $Id: stud_move_stud_move_home.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<script language="JavaScript">
	function checkok()	{
		var OK=true;	
		if(document.base_form.stud_class.value==0)	{
			alert('����ܯZ��');
			OK=false;
		}
		if(document.base_form.student_sn.value=='')	{
			alert('����ܾǥ�');
			OK=false;
		}	
		if (OK==true) return confirm('�T�w�s�W '+document.base_form.student_sn.options[document.base_form.student_sn.selectedIndex].text+' �b�a�۾ǰO�� ?');
		return OK
	}
//-->
</script>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" valign=top bgcolor="#CCCCCC">
    <form name ="base_form" action="{{$smarty.server.PHP_SELF}}" method="post" >
		<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			<tr>
				<td class=title_mbody colspan=2 align=center > �b�a�۾Ǿǥͧ@�~ </td>
			</tr>
			<tr>
				<td class=title_sbody2>��ܯZ��</td>
				<td>{{$class_sel}}</td>
			</tr>
			<tr>
				<td class=title_sbody2>��ܾǥ�</td>
				<td>{{$stud_sel}} </td>
			</tr>
			<tr>
	    	<td width="100%" align="center" colspan="5" >
	    	<input type="hidden" name="update_id" value="{{$smarty.session.session_log_id}}">
				<input type=submit name="do_key" value =" �T�w�b�a�۾� " onClick="return checkok()" >    </td>
			</tr>
		</table><br></td>
	</tr>
	<TR>
		<TD>
			<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body ><tr><td colspan=8 class=title_top1 align=center >���Ǵ��b�a�۾ǾǥͦC��</td></tr>
				<TR class=title_mbody >				
					<TD>�Ǹ�</TD>
					<TD>�m�W</TD>				
					<TD>�Z��</TD>
					<TD>�s��</TD>
				</TR>
				{{section loop=$stud_move name=arr_key}}
					<TR class=nom_2>
						{{assign var=cid value=$stud_move[arr_key].stud_class}}		
						<TD>{{$stud_move[arr_key].stud_id}}</TD>
						<TD>{{$stud_move[arr_key].stud_name}}</TD>					
						<TD>{{$class_list.$cid}}</TD>
						<TD><a href="{{$smarty.post.PHP_SELF}}?do_key=delete&student_sn={{$stud_move[arr_key].student_sn}}" onClick="return confirm('�T�w���� {{$stud_move[arr_key].stud_name}} �b�a�۾ǰO�� ?');">�R���O��</a></TD>
					</TR>
				{{/section}}
			</table></TD>
	</TR>
	<TR>
		<TD></TD>
	</TR>
	</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}