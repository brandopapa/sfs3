{{* $Id: stud_basic_test_distest3.tpl 5903 2010-03-09 11:44:44Z brucelyc $ *}}
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
						$('#showBtn').attr('disabled', false);
						$('#proc').hide();
					}
				}
			});
		}
	});
}
//-->
</script>

<form name="menu_form" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td style="vertival-align:top;background-color:#CCCCCC;">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" width="100%" class="main_body">
<tr><td>
{{if !$smarty.post.year_name}}�ϰ�G<input type="radio" name="city" {{if $smarty.post.cy=="" || $smarty.post.cy==1}}checked{{/if}} OnClick="document.menu_form.cy.value='1';">����� <input type="radio" name="city" {{if $smarty.post.cy==2}}checked{{/if}} OnClick="document.menu_form.cy.value='2';">���ư� <input type="radio" name="city" {{if $smarty.post.cy==3}}checked{{/if}} OnClick="document.menu_form.cy.value='3';">�O�n�� <input type="radio" name="city" {{if $smarty.post.cy==4}}checked{{/if}} OnClick="document.menu_form.cy.value='4';">�˭]�� <input type="radio" name="city" {{if $smarty.post.cy==5}}checked{{/if}} OnClick="document.menu_form.cy.value='5';">�O�F��<br>{{/if}}
�Ǵ��G{{$year_seme_menu}} �~�šG{{$class_year_menu}} <input type="submit" id="cleanBtn" name="clean" value="�M���Ȧs"> <input type="button" id="calBtn" value="�}�l�p��" OnClick="go();" {{if !$smarty.post.clean || !$smarty.post.year_name}}disabled="true"{{/if}}> <input type="submit" id="showBtn" name="show" value="������" disabled="true">{{if $smarty.post.show}} <input type="submit" name="out" value="��ƶץX"> <input type="submit" name="htm" value="�ҩ����X"> <input type="submit" name="LOCK" value="���Z�ʦs">{{/if}}
{{if $smarty.post.year_name}}<br>�ϰ�G<span style="color:red;">�m{{if $smarty.post.cy==2}}����{{elseif $smarty.post.cy==3}}�O�n{{elseif $smarty.post.cy==4}}�˭]{{elseif $smarty.post.cy==5}}�O�F{{else}}����{{/if}}�ϡn{{/if}}</span> <input type="hidden" name="cy" value="{{$smarty.post.cy}}">
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
<td>{{$d}}PR</td>
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
<br>�Х��ˬd�Ǵ����Z�O�_���h�l��ơA�H�T�O���Z�p�⥿�T�C<input type="submit" name="check" value="���ˬd���Z">
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>����ƥثe������ϡB���ưϡB�O�n�ϡB�˭]�ϡB�O�F�ϰ�����¾�K�դJ�ǨϥΡA��L�a�ϭY�����P��Ʈ榡�A�ЦA�P<a href="http://www.sfs.project.edu.tw">�{���}�o�p��</a>�s���C</li>
	<li>99�Ǧ~�b�ժ�{�ĭp�覡�G</li>
	<ol style="list-style-type: none;">
	<li>(1) ����ϡG�ĭp�T�Ǵ��]��G�W�B�U�Ǵ��B��T�W�Ǵ��^�C�j��줧�Ǵ����Z�]���[�v���ܤp�Ʋ�2��^�C</li>
	<li>(2) ���ưϡG�ĭp���Ǵ��]��@�W�Ǵ����T�W�Ǵ��^�C�j��줧�Ǵ����Z�]���[�v���ܤp�Ʋ�2��^�C</li>
	<li>(3) �O�n�ϡG�ĭp���Ǵ��]��@�W�Ǵ����T�W�Ǵ��^�C�j��줧�Ǵ����Z�]�[�v���ܤp�Ʋ�2��^�C</li>
	<li>(4) �˭]�ϡG�ĭp���Ǵ��]��@�W�Ǵ����T�W�Ǵ��^�C�j��줧�Ǵ����Z�]�[�v���ܤp�Ʋ�1��^�C</li>
	</ol>
	<li>99�Ǧ~�b�ժ�{�e�{�覡�G</li>
	<ol style="list-style-type: none;">
	<li>(1) ����ϡG�C�j���PR�ȡC</li>
	<li>(2) ���ưϡG�C�j���~�ūe�ʤ���C</li>
	<li>(3) �O�n�ϡG�C�j���~�ūe�ʤ���C</li>
	<li>(4) �˭]�ϡG�C�j���~�ūe�ʤ���C</li>
	</ol>
	<li>�U�϶ץX�ɮ׮榡�i�ण�P�A�Ш̰ϰ��ܡC</li>
	<li>�Y�p��覡�ζץX�ɮ׮榡�P��ڤ��šA�о��ֻP<a href="http://www.sfs.project.edu.tw">�{���}�o�p��</a>�s���C</li>
	<li style="color:red;">�C�L�e�ȥ��T�{�ǥͦ��Z�]�t�Ǵ��즨�Z�]�w�^�w�������T���A�ק�A�_�h���Z�ק�᭫�s�p�⪺���G�i�ण�u�@��ǥͪ��ʤ�����ܰʦӳy�����H���B����G�C</li>
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
