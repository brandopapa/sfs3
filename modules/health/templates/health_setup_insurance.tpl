{{* $Id: health_setup_hos.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<script>
$(document).ready(function(){
	// �R�����ˬd�O�_�����
	$("#insurance-table .delBtn").click(function(){
		if (confirm('�T�w�R�o���]�w?')) {
			var id = $(this).attr('id').substr(3);
			$.post('setup.php',
					{
						sub_menu_id : 8,
						checkKind: 'insurance_record',
						id : id
					},
					function(hasData){
						if (hasData != '0') {
							alert('���ǥ͸��,����R��');
						}
						else
							// �R��
							$.post('setup.php',
									{
										sub_menu_id : 8,
										checkKind: 'delete_insurance_record',
										id : id
									},
									function(data){
										$("#setupForm").submit();
									}
							);
					}
			);
		}
	});

});
</script>

<input type="submit" name="act" value="�s�W�O�I����">
<table  id="insurance-table"  bgcolor="#7e9cbd" cellspacing="1" cellpadding="4" class="small">
<tr style="background-color:#9ebcdd;color:white;text-align:center;">
<td>�O�I�����W��</td><td>�\��ﶵ</td>
</tr>
{{foreach from=$insurance  item=d key=i}}
<tr bgcolor="white">
{{if $smarty.post.edit_insurance_id==$i}}
<td><input type="text" name="insurance_name" value="{{$d}}"></td><td><input type="button" name="sure" value="�T�w�ק�" OnClick="this.form.insurance_id.value='{{$i}}';this.form.submit();"> <input type="reset" value="�^�_"> <input type="submit" value="���"></td>
{{else}}
<td>{{$d}}</td>
<td style="text-align:center;">
<input type="image" src="images/edit.gif" name="edit_insurance_id" value="{{$i}}" alt="�s�׳o�����">
<img  src="images/delete.gif"   class="delBtn"  id="id-{{$i}}" alt="�R���o�����" /></td>
{{/if}}
</tr>
{{foreachelse}}
<tr bgcolor="white">
<td colspan="2" style="color:red;text-align:center;">�|���]�w����O�I����</td>
</tr>
{{/foreach}}
{{if $smarty.post.act=="�s�W�O�I����"}}
<tr style="background-color:yellow;">
<td><input type="text" name="new_insurance"></td><td><input type="submit" name="act" value="�T�w�s�W"></td>
</tr>
{{/if}}
</table>
<input type="submit" name="act" value="�s�W�O�I����">
<input type="hidden" name="insurance_id" value="">

{{*����*}}
<table class="small">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>�p�G�P�ɦ��O���s�W�ΧR���A�ФŪ�����n�R������Ƨ令�n�s�W����ơA<br>�_�h�N�y����ƿ��áC</li>
	</ol>
</td></tr>
</table>
