{{* $Id: health_whole_renew2.tpl 5908 2010-03-16 23:47:21Z hami $ *}}
<style>
#openSigntDialog {float:right; cursor:pointer;}
#dialog {display:none;}
</style>
<script>
$(document).ready(function(){

	$("#openSigntDialog").live('click',function(){
		var studentName = $("select[name='student_sn'] option[selected]").text();
		$("#dialog").attr('title',studentName);

		var studentSn = '{{$smarty.post.student_sn}}';
		var yearSeme = '{{$smarty.post.year_seme}}';
		// ���o���O�ˬd�B�m��ܤ��
		$.get('input_ajax.php',
				{kind:'sight_form',
				 yearSeme: yearSeme,
				 studentSn: studentSn
				},
				function(data){
					$("#dialog").html(data);
					$("#dialog").dialog({
						autoOpen: false,
						height: 240,
						width:600,
						modal: true
					});
					$("#dialog").dialog('open');
		});
	});
});
</script>
<form action="{{$smarty.server.SCRIPT_NAME}}" method="post" target="_blank">
{{assign var=sn value=$smarty.post.student_sn}}
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=d value=$health_data->health_data.$sn.$year_seme}}

{{* �����魫 *}}
<table style="background-color:#9ebcdd;" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="2" style="color:white;"><input type="image" src="images/edit.gif" OnClick="this.form.act.value='wh_st';">�����魫</td>
</tr>
<tr style="background-color:#f4feff;">
<td>����</td><td>{{$d.height}}</td>
</tr>
<tr style="background-color:white;">
<td>�魫</td><td>{{$d.weight}}</td>
</tr>
<tr style="background-color:#f4feff;">
{{assign var=Bid value=$d.Bid}}
<td>����</td><td>{{$Bid_arr.$Bid}}</td>
</tr>
<tr style="background-color:white;">
<td>�귳</td><td>{{$d.years}}</td>
</tr>
</table>

{{* ���O *}}
<table style="background-color:#9ebcdd;" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr>
<td colspan="3" style="color:white;"><input type="image" src="images/edit.gif" OnClick="this.form.act.value='sight_st';">���O

</td>
</tr>
<tr style="background-color:#f4feff;">
<td>��</td>
<td>�k</td>
<td>��</td>
</tr>
<tr style="background-color:white;">
<td>�r��</td>
<td><font color="{{if $d.r.sight_o>'0.8'}}blue{{else}}red{{/if}}">{{$d.r.sight_o}}</font></td>
<td><font color="{{if $d.l.sight_o>'0.8'}}blue{{else}}red{{/if}}">{{$d.l.sight_o}}</font></td>
</tr>
<tr style="background-color:#f4feff;">
<td>�B��</td>
<td><font color="{{if $d.r.sight_r>'0.8'}}blue{{else}}red{{/if}}">{{$d.r.sight_r}}</font></td>
<td><font color="{{if $d.l.sight_r>'0.8'}}blue{{else}}red{{/if}}">{{$d.l.sight_r}}</font></td>
</tr>
<tr style="background-color:white;">
<td>���</td>
<td><input type="checkbox" disabled="true" {{if $d.r.My}}checked{{/if}}></td>
<td><input type="checkbox" disabled="true" {{if $d.l.My}}checked{{/if}}></td>
</tr>
<tr style="background-color:#f4feff;">
<td>����</td>
<td><input type="checkbox" disabled="true" {{if $d.r.Hy}}checked{{/if}}></td>
<td><input type="checkbox" disabled="true" {{if $d.l.Hy}}checked{{/if}}></td>
</tr>
<tr style="background-color:white;">
<td>����</td>
<td><input type="checkbox" disabled="true" {{if $d.r.Ast}}checked{{/if}}></td>
<td><input type="checkbox" disabled="true" {{if $d.l.Ast}}checked{{/if}}></td>
</tr>
<tr style="background-color:#f4feff;">
<td>�z��</td>
<td><input type="checkbox" disabled="true" {{if $d.r.Amb}}checked{{/if}}></td>
<td><input type="checkbox" disabled="true" {{if $d.l.Amb}}checked{{/if}}></td>
</tr>
<tr style="background-color:white;">
<td>��L</td>
<td><input type="checkbox" disabled="true" {{if $d.r.other}}checked{{/if}}></td>
<td><input type="checkbox" disabled="true" {{if $d.l.other}}checked{{/if}}></td>
</tr>
<tr style="background-color:#f4feff;">
<td>�B�m</td><td colspan="2">
{{if $d.l.manage_id}}����:{{$sight_kind[$d.l.manage_id]}}{{/if}}
{{if $d.l.diag}}:{{$d.l.diag}}{{/if}}
 <br/>
 {{if $d.r.manage_id}}�k��:{{$sight_kind[$d.r.manage_id]}}{{/if}}
{{if $d.r.diag}}:{{$d.r.diag}}{{/if}}
 </td>
</tr>
</table>
{{* �f���ˬd *}}
<table cellspacing="1" cellpadding="4" width="100%" class="small" style="background-color:#9ebcdd;">
<tr>
<td colspan="2" style="color:white;"><input type="image" src="images/edit.gif" OnClick="this.form.act.value='oral_st';"><input type="image" src="images/edit.gif" OnClick="this.form.act.value='tee_st';">�f���ˬd</td>
</tr>
<tr style="background-color:#f4feff;">
<td>�f���ˬd</td><td style="text-align:center;"><input type="checkbox" disabled="true" {{if $d.chkOra}}checked{{/if}}></td>
</tr>
<tr style="background-color:white;">
<td>�T��</td><td style="text-align:center;">{{if $d.C1}}���`{{else}}�L����{{/if}}</td>
</tr>
<tr style="background-color:#f4feff;">
<td>�ʤ�</td><td style="text-align:center;">{{if $d.C2}}���`{{else}}�L����{{/if}}</td>
</tr>
<tr style="background-color:white;">
<td>�f�Ľåͤ��}</td><td style="text-align:center;{{if $d.Ora1}}color:red;{{/if}}">{{if $d.checks.Ora1}}���`{{else}}�L����{{/if}}</td>
</tr>
<tr style="background-color:#f4feff;">
<td>���C�r�X����</td><td style="text-align:center;{{if $d.Ora4}}color:red;{{/if}}">{{if $d.checks.Ora4}}���`{{else}}�L����{{/if}}</td>
</tr>
<tr style="background-color:white;">
<td>���i��</td><td style="text-align:center;{{if $d.Ora5}}color:red;{{/if}}">{{if $d.checks.Ora5}}���`{{else}}�L����{{/if}}</td>
</tr>
<tr style="background-color:#f4feff;">
<td>�f���H�����`</td><td style="text-align:center;{{if $d.Ora6}}color:red;{{/if}}">{{if $d.checks.Ora6}}���`{{else}}�L����{{/if}}</td>
</tr>
<tr style="background-color:white;">
<td>��L</td><td>�@</td>
</tr>
<tr style="background-color:#f4feff;">
<td>��L���z</td><td>�@</td>
</tr>
<tr style="background-color:white;">
<td>�f�˪�</td><td>
{{assign var=i value=0}}
{{foreach from=$d item=dd key=k}}
{{if ($k|@substr:0:1)=="T"}}{{if $i % 3==0 && $i!=0}}<br>{{/if}}{{$k|@substr:1:2}}{{$teesb.$dd}}{{assign var=i value=$i+1}}{{/if}}
{{/foreach}}
</td></tr>
</table>
<input type="hidden" name="sub_menu_id" value="{{$smarty.post.sub_menu_id}}">
<input type="hidden" name="year_seme" value="{{$smarty.post.year_seme}}">
<input type="hidden" name="class_name" value="{{$smarty.post.class_name}}">
<input type="hidden" name="student_sn" value="{{$smarty.post.student_sn}}">
<input type="hidden" name="act" value="">
</form>
<div id="dialog" title="���O�ˬd�B�m����">

</div>
