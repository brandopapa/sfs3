{{* $Id: academic_record_chk.tpl 7308 2013-06-09 11:41:16Z smallduh $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<script>
	var remote=null;
	function OpenWindow(p,x){
		strFeatures ="top=300,left=20,width=500,height=210,toolbar=0,resizable=no,scrollbars=yes,status=0";
		remote = window.open("comment.php?cq="+p,"MyNew", strFeatures);
		if (remote != null) {
			if (remote.opener == null) remote.opener = self;
		}
		if (x == 1) { return remote; }
	}

	function checkmemo(){
		var str='';
		var len = $(".setArea").length;
		for(i=0;i<len ;i++){
			if ($("#V{{$student_sn}}_"+i).val() !=''){
				str += $("#V{{$student_sn}}_"+i).val();
				if (i<{{$itemdata.nums|@count}}){
					str += '�A';
				}
			}
		}
		if (str !=''){
			str = str.substring(0,str.length-1) + '�C';
			$("#nor_memo0").val(str);
		}
	}
	
	function form_signal() {
	 signal_1.style.display="block";
	 signal_2.style.display="block";
	 signal_3.style.display="block";
	 past_1.style.display="none";
	}
	
  function form_past() {
	 signal_1.style.display="none";
	 signal_2.style.display="none";
	 signal_3.style.display="none";
	 past_1.style.display="block";
	}
</script>

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="4">
<form name="myform" method="post" action="{{$smarty.server.PHP_SELF}}">
	<tr class="small">
		
		<td valign="top" align="center">{{$date_select}}<BR>{{$class_select}}<BR>{{$stud_select}}
			<BR><input type='checkbox' name='chknext' value='1' {{if $smarty.post.chknext}}checked{{/if}}>�۰ʸ��U�@��
		</td>
		
		<td bgcolor="#FFFFFF" valign="top">
{{if $student_sn}}
			<p align="center">
			<font size="3">{{$sch_cname}}{{$sel_year}}�Ǧ~�ײ�{{$sel_seme}}�Ǵ����`�ͬ���{���q</font></p>
			<table align="center" cellspacing="4" id="signal_1">
				<tr>
					<td>�Z�šG<font color="blue">{{$class_name}}</font></td><td width="40"></td>
					<td>�y���G<font color="green">{{$stu_class_num}}</font></td><td width="40"></td>
					<td>�m�W�G<font color="red">{{$stu.stud_name}}</font></td>
				</tr>
			</table>	
			<table align="center" cellspacing="4" id="signal_2">
				<tr bgcolor="#c4d9ff">
				  <td style="text-align:center;">���q����</td>
				  <td style="text-align:center;">�V�O�{��</td>
				  <td style="text-align:center;">�ɮv���q�Ϋ�ĳ</td>
				</tr>
				{{foreach from=$rowdata.nor.ss_item item=dd key=i}}
					<tr class="title_sbody1">
					<td style="text-align:center;">{{$dd}}</td>
					<td style="background-color:white;text-align:center;">
					  <select name="nor_val[{{$i}}]">{{$rowdata.nor.ss_val.$i}}</select>
					</td>
					 {{if $i == 1}}
						 <td rowspan="4" style="text-align:center;"><textarea rows="7" cols="50" maxlength="50" id="nor_memo0" name="nor_memo">{{$rowdata.nor.memo}}</textarea></td>
					 {{/if}}
					</tr>
				{{/foreach}}
			</table>			
<table border="0" width="100%" id="signal_3">
 <tr>
  <td align="center">
		<input type="submit" name="save" value="�T�w�x�s" OnClick="document.myform.nav_next.value={{$next_student_sn}};">
		<!--<input type="button" value="�ֶK�᤭���r�O��" onclick="form_past()">-->
  </td>
  </tr>
</table>
<input type='hidden' name='nav_next' value="">
<input type='hidden' name='class_reset' value="">
<input type='hidden' name='semester_reset' value="">
<input type='hidden' name='stud_id' value="{{$stud_id}}">
<input type='hidden' name='current_student_sn' value="{{$student_sn}}">

</form>

<!---�ֶK�Ϊ���� -->
 <table border="0" width="100%" id="past_1" style="display:none">
 <form method="post" name="pastform" action="{{$smarty.server.PHP_SELF}}">
  <input type="hidden" name="class_id" value="{{$class_id}}">
  <input type="hidden" name="mode" value="pastALL">
  <tr>
   <td>�ֶK���Z�O������ class_id: {{$class_id}}</td>
  </tr>
  <tr>
   <td>
    <textarea name="stud_data" cols="100" rows="10"></textarea>
   </td>
  </tr>
  <tr>
   <td>
   <input type="submit" value="�T�w�K�W"><input type="button" value="��^�浧�s�W" onclick="form_signal()">
   </td>
  </tr>
  <tr>
   <td>
      <table border="1" width="100%" style="border-collapsecollapse" bordercolor="#CCCCCC">
     <tr>
       <td style="color:#800000;font-size:9pt">
       ������ : �p�G�z�ߺD�H Excel ���覡�޲z�ǥͥ��`�ͬ���{�O�� (Excel�d����:<a href="images/demo.xls">�U��</a>) ,���{���i��K�z�ֳt��J���Z�ǥͪ��ͬ���{�O���C<br>�Ъ�����ܤ��e�����p��, �ƻs/�K�W�A�e�X�Y�i.<br>
       <img src="images/demo.jpg" border="0" width="80%"><br>
       �`�N! ��쪺���ǥ������T,�@�C���@�Ӿǥ͸��, �y���P�m�W�O�Ω���, �������T�ӵ���Ƥ~�|�s�J.
       </td>
     </tr>
   </table>	

   </td>
  </tr>
  </form>
 </table>
 <!--------------------->
</td>
{{/if}}
</tr>
</table>



{{include file="$SFS_TEMPLATE/footer.tpl"}}
