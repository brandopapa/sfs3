{{* $Id: stud_basic_test_distest5.tpl 6702 2012-02-22 15:09:06Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/jquery.progressbar.min.js"></script>
<script type="text/javascript">
<!--
var pp=0, d, acc, pass;
var arr=[0{{foreach from=$class_arr item=d key=k}}, {{$k}}{{/foreach}}];
function go() {
	$('#calBtn').attr('disabled', true);
	$('#calBtn').attr('value', ' ���Z�p�⤤, �еy��... ');
	$("#calBtn").get(0).style.color = "red";
	$('#proc').show();
	$('#pb1').progressBar(0);
	d=100/{{$class_arr|@count}};
	$.each(arr,function(i, n){
		if (n>0) {
			$.post('{{$smarty.server.SCRIPT_NAME}}',{ class_no: n, year_seme: "{{$smarty.post.year_seme}}", year_name: "{{$smarty.post.year_name}}", cy: "{{$smarty.post.cy}}", act: "cal"},function(data){
				if (data!=''){
					pp+=d;
					$('#pb1').progressBar(pp);
					$('#msg').html(data);
					if (pp>99) {
						$('#calBtn').attr('value', '�p�⧹��');
						$("#calBtn").get(0).style.color = "blue";
						$('#speBtn').attr('disabled', false);
						$('#proc').hide();
					}
				}
			});
		}
	});
}

function sort() {
	$('#speBtn').attr('disabled', true);
	$('#speBtn').attr('value', ' �ƧǤ�, �еy��... ');
	$("#speBtn").get(0).style.color = "red";
	$('#act').attr('value', 'sort');
	$('#mform').submit();
}
//-->
</script>

<form name="menu_form" id="mform" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td style="vertival-align:top;background-color:#CCCCCC;">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" width="100%" class="main_body">
<tr><td>
�Ǵ��G{{$year_seme_menu}} �~�šG{{$class_year_menu}} <input type="submit" id="cleanBtn" name="clean" value="�M���Ȧs"> <input type="button" id="calBtn" value="�}�l�p��" OnClick="go();" {{if !$smarty.post.clean || !$smarty.post.year_name}}disabled="true"{{/if}}> <input type="button" id="speBtn" value="�ʤ��Ƨ�" disabled="true" OnClick="sort();"> <input type="hidden" id="act" name="act"> <input type="submit" id="showBtn" name="show" value="������" {{if !$smarty.post.act=="sort"}}disabled="true"{{/if}}>{{if $smarty.post.show}} <input type="submit" name="htm" value="�ҩ����X"><br>
�ץX�G<input type="submit" name="out5" value="���Ϥ��M�榡"> <input type="submit" name="out5s" value="�n�Ϥ��M�榡"> <input type="submit" name="out_chc" value="���ưϮ榡"> <input type="submit" name="out_ct" value="����Ϯ榡"> <input type="submit" name="out" value="��ƶץX"> <input type="submit" name="LOCK" value="���Z�ʦs">{{/if}}
{{if $smarty.post.show}}
<br>
<table border="0" width="100%" style="font-size:12px;" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC" align="center">
<td>�Z��</td>
<td>�Ǹ�</td>
<td>�m�W</td>
<td>�����Ҹ�</td>
<td>�ʧO</td>
{{if $smarty.post.cy!=4}}
<td>�ͤ�</td>
{{/if}}
{{foreach from=$col_arr item=d}}
<td>{{$d}}</td>
{{/foreach}}
{{if $smarty.post.cy!=4}}
{{foreach from=$s_arr item=d}}
<td>{{$d}}��</td>
{{/foreach}}
{{/if}}
{{if $smarty.post.cy==2 || $smarty.post.cy==4 || $smarty.post.cy==5}}
<td>�e�ʤ�</td>
{{elseif $smarty.post.cy==3}}
<td>�Ƨ�</td>
{{else}}
{{foreach from=$s_arr item=d}}
<td>{{$d}}�ʤ�</td>
{{/foreach}}
{{/if}}
</tr>
{{foreach from=$student_sn item=d key=seme_class}}
{{foreach from=$d item=sn key=site_num}}
<tr bgcolor="#ddddff" align="center">
<td>{{$seme_class|@substr:-2:2|intval}}</td>
<td>{{$stud_data.$sn.stud_id}}</td>
<td>{{$stud_data.$sn.stud_name}}</td>
<td>{{$stud_data.$sn.stud_person_id}}</td>
<td>{{$stud_data.$sn.stud_sex}}</td>
{{if $smarty.post.cy!=4}}
<td>{{$stud_data.$sn.stud_birthday}}</td>
{{/if}}
{{foreach from=$semes item=si key=i}}
{{foreach from=$s_arr item=sl key=j}}
{{if $smarty.post.cy!=4 || $i!=5}}
<td>{{$rowdata.$sn.$i.$j.score}}</td>
{{/if}}
{{/foreach}}
{{/foreach}}
{{if $smarty.post.cy==2 || $smarty.post.cy==4 || $smarty.post.cy==5}}
{{if $j==10}}
<td>{{$rowdata.$sn.$pry.$j.pr}}�H</td>
{{/if}}
{{elseif $smarty.post.cy==3}}
{{if $j==10}}
<td>{{$rowdata.$sn.$pry.$j.pr}}</td>
{{/if}}
{{else}}
{{foreach from=$s_arr item=sl key=j}}
<td>{{$rowdata.$sn.$pry.$j.pr}}</td>
{{/foreach}}
{{/if}}
</tr>
{{/foreach}}
{{/foreach}}
</table>
</td></tr>
{{else}}
<div id="proc" style="display:none;">
<br>
���Z�p��i�� <span class="progressBar" id="pb1">0%</span>
<div id="msg">
&nbsp;
</div></div>
<br>�Х��ˬd�Ǵ����Z�O�_���h�l��ơA�H�T�O���Z�p�⥿�T�C<input type="button" value="���ˬd���Z" OnClick="this.form.action='{{$SFS_PATH_HTML}}modules/stud_check/check_score_error.php';this.form.submit();">
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li style="color: red;">���t�ζȴ��ѧ@�~���x�A�@�~�覡�Ш̦U�ۥͰϩο����W�w��z�A�ФŦۥD�M�w�H�K�v�T�ǥ��v�q�C</li>
	<li>���Z�B�z�e�аȥ����ˬd�U�Z�ǥͬO�_���T�C</li>
	<li>���{���ثe�N�P���C���P�@�ʤ���</li>
	</ol>
</td></tr>
</table>
{{/if}}
</tr>
</table>
</td></tr>
</table>
</form>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
