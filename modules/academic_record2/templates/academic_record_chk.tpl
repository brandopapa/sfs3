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

	function set_chk(a){
		var i=0, v=new Array(10);
{{foreach from=$chk_item item=d key=i}}
		v[{{$i}}]="{{$d}}";
{{/foreach}}
		if (confirm('�N�������ت���{���p���令�u'+v[a]+'�v?')){
			while (i < document.myform.elements.length) {
				b=document.myform.elements[i].id.substring(0,1);
				if (b=='c') {
					c=document.myform.elements[i].id.substring(1,2);
					if (c==a)
						document.myform.elements[i].checked=true;
					else
						document.myform.elements[i].checked=false;
				}
				i++;
			}
			alert('���ʧ@�å��i���x�s, �аO�o���U�u�T�w�x�s�v���ܤ~�|�ͮ�!');
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
			<font size="3">{{$sch_cname}}{{$sel_year}}�Ǧ~�ײ�{{$sel_seme}}�Ǵ����`�ͬ���{�ˮ֪�</p>
			<table align="center" cellspacing="4" id="signal_1">
				<tr>
					<td>�Z�šG<font color="blue">{{$class_name}}</font></td><td width="40"></td>
					<td>�y���G<font color="green">{{$stu_class_num}}</font></td><td width="40"></td>
					<td>�m�W�G<font color="red">{{$stu.stud_name}}</font></td>
				</tr>
				<tr>
					<td colspan="5">
						<fieldset class="small">
							<span style="color:blue;">��{���p���]���G</span>
								{{foreach from=$chk_item item=c key=i}}
								<input type="radio" OnClick="set_chk({{$i}});">{{$c}}&nbsp;
								{{/foreach}}
						</fieldset>
						<fieldset>
								<font size=2 color='brown'><input type='checkbox' name='auto_spe' value='1' {{if $smarty.post.auto_spe}}checked{{/if}} onclick="this.form.submit();">�C�ܥ��Ǵ����ǥͤw�n�������ɸ��-�S���{����</font>
						</fieldset>
					</td>
				</tr>
			</table>
			</font>
			
			<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" id="signal_2">
				<tr bgcolor="#c4d9ff">
					<td colspan="2" align="center">���`�欰��{����</td><td align="center">��{���p</td><td align="center">�����ĳ</td>
				</tr>
					{{foreach from=$itemdata.items item=d key=i}}
					{{assign var=main value=$d.main}}
					{{assign var=sub value=$d.sub}}
					{{if $d.sub!=1}}
				<tr bgcolor="white">
					{{/if}}
					{{if $d.sub==0}}
					<td rowspan="{{$itemdata.nums.$main.num-1}}" class="small">{{$d.item}}</td>
					{{else}}
					<td class="small" width="180">{{$d.item}}</td><td class="small">{{$chk_value.$main.$sub.score}}</td>
					{{if $d.sub==1}}
					{{* <td rowspan="{{$itemnum.$main.num-1}}" class="small"><img src="../../images/comment.png" width="16" height="16" border="0" align="left" onClick="return OpenWindow('V{{$student_sn}}_{{$main}}')"><input type="text" name="stud_memo[{{$student_sn}}][{{$main}}]" id="V{{$student_sn}}_{{$main}}" value="{{$chk_value.$main.0.memo}}" style="width:100pt;"></td> *}}
					<td rowspan="{{$itemdata.nums.$main.num-1}}" class="small"><textarea class="setArea" name="chk[{{$student_sn}}][{{$main}}][memo]" id="V{{$student_sn}}_{{$main}}" style="width:100pt;"  rows="{{$itemdata.nums.$main.num-1}}" onblur="checkmemo()">{{$chk_value.$main.0.memo}}</textarea></td>
					{{/if}}
				</tr>
					{{/if}}
				{{foreachelse}}
			
			<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%">
				<tr style="background-color:yellow;color:red;">
					<td>���Ǵ��|���]�w�ˮ֪�A�ثe�L�k��J�A�кɳt�s���ǰȡ]�V�ɡ^�B�C</td>
				</tr>
			{{/foreach}}
			{{if $itemdata.items}}
				<tr bgcolor="#c4d9ff"><td colspan="4" style="text-align:center;">���`�ͬ���{</td></tr>
				<tr bgcolor="#d4e9ff"><td colspan="4" style="text-align:center;"><textarea rows="2" cols="80" id="nor_memo0" name="nor_memo[{{$student_sn}}][0]">{{$nor_memo.0}}</textarea></td></tr>
				<tr bgcolor="#c4d9ff"><td colspan="4" style="text-align:center;">���鬡�ʬ���</td></tr>
				<tr bgcolor="#d4e9ff"><td colspan="4" style="text-align:center;"><textarea rows="2" cols="80" name="nor_memo[{{$student_sn}}][1]">{{$nor_memo.1}}</textarea></td></tr>
				<tr bgcolor="#c4d9ff"><td colspan="4" style="text-align:center;">���@�A�Ȭ���</td></tr>
				<tr bgcolor="#d4e9ff"><td colspan="4" style="text-align:center;">
			
			<table border="0" class="small">
			 <tr>
			  <td width="50%">
				<fieldset>
					<legend>�դ��A��</legend>
					<textarea rows="2" cols="36" name="nor_memo[{{$student_sn}}][2]">{{$nor_memo.2}}</textarea>
				</fieldset>
			  </td>
			  <td>
				 <fieldset>
					<legend>���ϪA��</legend>
						<textarea rows="2" cols="36" name="nor_memo[{{$student_sn}}][3]">{{$nor_memo.3}}</textarea>
				 </fieldset>
				 </td>
				</tr>
			</table>
			
			</td></tr>
		<tr bgcolor="#c4d9ff"><td colspan="4" style="text-align:center;">�դ��~�S���{����</td></tr>
		<tr bgcolor="#d4e9ff"><td colspan="4" style="text-align:center;">
			<table border="0" class="small">{{if $smarty.post.auto_spe}}
			<tr>				
				<td valign="top" align="center">{{if $spe_data_1}}����-�դ��S���{�����ѦҡG<BR><TEXTAREA rows="4" cols="36" name="eduh_memo4" disabled>{{$spe_data_1}}</TEXTAREA><BR><input type="button" name="paste_it" value="�ƻs���ˮ֪�-�դ��S���{" onclick="document.getElementById('nor_memo4').value=document.myform.eduh_memo4.value;">{{/if}}</td>
   			<td valign="top" align="center">{{if $spe_data_2}}����-�ե~�S���{�����ѦҡG<BR><TEXTAREA rows="4" cols="36" name="eduh_memo5" disabled>{{$spe_data_2}}</TEXTAREA><BR><input type="button" name="paste_it" value="�ƻs���ˮ֪�-�ե~�S���{" onclick="document.getElementById('nor_memo5').value=document.myform.eduh_memo5.value;">{{/if}}</td>
			</tr>{{/if}}<tr><td width="50%">
       <fieldset>
			<legend>�դ��S���{</legend>
			<textarea rows="5" cols="36" name="nor_memo[{{$student_sn}}][4]" id="nor_memo4" bgcolor="#FFFCCCC">{{$nor_memo.4}}</textarea>
			</fieldset>
			</td><td>
     <fieldset>
			<legend>�ե~�S���{</legend>
			<textarea rows="5" cols="36" name="nor_memo[{{$student_sn}}][5]" id="nor_memo5" bgcolor="#FFFCCCC">{{$nor_memo.5}}</textarea>
		</fieldset>
	
		
</tr></table>
</td></tr>
{{/if}}
</table>
{{if $itemdata}}
<table border="0" width="100%" id="signal_3">
 <tr>
  <td align="center">
		<input type="submit" name="save" value="�T�w�x�s" OnClick="document.myform.nav_next.value={{$next_student_sn}};">
		<input type="submit" value="�٭�">
		<input type="submit" name="clear" value="�M��">
		<input type="button" value="�ֶK�᤭���r�O��" onclick="form_past()">
  </td>
  </tr>
</table>
{{/if}}
<input type='hidden' name='nav_next' value="">
<input type='hidden' name='class_reset' value="">
<input type='hidden' name='semester_reset' value="">
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
