{{* $Id: stud_basic_test_distest4.tpl 5893 2010-03-08 06:04:51Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/jquery.progressbar.min.js"></script>
<script type="text/javascript">
<!--
function go(a) {
	var i =0;
	while (i < document.menu_form.elements.length)  {
		b="sel"+a;
		c=document.menu_form.elements[i].id.substr(0,4);
		if (b==c) document.menu_form.elements[i].checked=!document.menu_form.elements[i].checked;
		i++;
	}
}

var pp=0, d, acc, pass;
var arr=[0{{foreach from=$class_arr item=d key=k}}, {{$k}}{{/foreach}}];
function cal() {
	$('#calBtn').attr('disabled', true);
	$('#calBtn').attr('value', ' ���Z�p�⤤, �еy��... ');
	$("#calBtn").get(0).style.color = "red";
	$('#proc').show();
	$('#pb1').progressBar(0);
	d=100/{{$class_arr|@count}};
	$.each(arr,function(i, n){
		if (n>0) {
			$.post('{{$smarty.server.SCRIPT_NAME}}',{ class_no: n, year_seme: "{{$smarty.post.year_seme}}", year_name: "{{$smarty.post.year_name}}", act: "cal", step: 4},function(data){
				if (data!=''){
					pp+=d;
					$('#pb1').progressBar(pp);
					$('#msg').html(data);
					if (pp>99) {
						$('#calBtn').attr('value', '�p�⧹��');
						$("#calBtn").get(0).style.color = "blue";
						$('#nextBtn').attr('disabled', false);
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
<input type="hidden" name="step" value="{{$smarty.post.step}}">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td style="vertival-align:top;background-color:#CCCCCC;">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" width="100%" class="main_body">
<tr><td>�Ǵ��G{{$year_seme_menu}} �~�šG{{$class_year_menu}} {{if $smarty.post.year_name}}{{$step_str}} <input type="submit" id="nextBtn" name="next" value="�i��U�ӨB�J" {{if $smarty.post.step>=4}}disabled=true{{/if}}>{{/if}}
{{if $smarty.post.step==3}}<br>�ֿ�G<input type="button" value="��J�e�Ͽ�" OnClick="go(1);"> <input type="button" value="��J�Ǵ��Ͽ�" OnClick="go(2);"> <input type="button" value="��J��Ͽ�" OnClick="go(3);" disabled> &nbsp; �R����ǥͦh�l���Z�G<input type="submit" name="del" value="�R��">{{/if}}
{{if $smarty.post.step==5}}<br>�ϰ�G<input type="radio" name="cy" value="1" {{if $smarty.post.cy=="" || $smarty.post.cy==1}}checked{{/if}}>���목 <input type="radio" name="cy" value="2" {{if $smarty.post.cy==2}}checked{{/if}}>������ <input type="submit" name="CRT" value="�C�L�ҩ���"> <input type="submit" name="LOCK" value="���Z�ʦs">{{/if}}
{{if $smarty.post.step==1}}
<br>
<table border="0" style="font-size:12px;" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC" align="center">
<td>��</td>
<td>�Ǵ�</td>
</tr>
{{foreach from=$year_arr item=d key=i}}
<tr bgcolor="white" align="center">
<td><input type="checkbox" name="seme[{{$i}}]" value="{{$i}}" {{if $seme_arr.$i}}checked{{/if}}></td>
<td>{{$d}}</td>
</tr>
{{/foreach}}
</table>
{{elseif $smarty.post.step==2}}
<br>
<table border="0" style="font-size:12px;" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC" align="center">
<td>�Ǧ~</td>
<td>�Ǵ�</td>
<td>��إN�X</td>
<td>��ئW</td>
<td>���Z��</td>
<td>�������</td>
<td>�Z�Žҵ{</td>
</tr>
{{foreach from=$ss_arr item=d key=i}}
{{assign var=year value=$d.year}}
{{assign var=semester value=$d.semester}}
<tr bgcolor="{{cycle values="white,#f0f0f0"}}" align="center">
<td>{{$year}}</td>
<td>{{$semester}}</td>
<td>{{$i}}</td>
<td style="text-align:left;">&nbsp; &nbsp;{{$d.name}}&nbsp; &nbsp;</td>
<td>{{$d.num}}</td>
<td>{{html_radios name=sel[$i] options=$m_arr selected=$subj_arr.$i|intval}}</td>
<td>{{if $d.class_id}}�O{{else}}�_{{/if}}</td>
</tr>
{{/foreach}}
</table>
{{foreach from=$seme_arr item=d name=s}}
<input type="hidden" name="seme[{{$smarty.foreach.s.iteration}}]" value="{{$d}}">
{{/foreach}}
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>�u�ݹ����n�ĭp����ءA���ĭp����ثh�L�ݹ����C</li>
	<li>�Y���Z�Žҵ{�A��ݶi������A�_�h�N���|�Q�ĭp�C</li>
	</ol>
</td></tr>
</table>
{{elseif $smarty.post.step==3}}
<br>
<table border="0" width="100%" style="font-size:12px;" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC" align="center">
<td>�Z��</td>
<td>�y��</td>
<td>�ǥͩm�W</td>
<td>��J��</td>
{{foreach from=$semes item=d}}
<td>{{$d}}</td>
{{/foreach}}
</tr>
{{foreach from=$sn_arr item=sn}}
<tr bgcolor="white" align="center">
<td>{{$rowdata.$sn.seme_class}}</td>
<td>{{$rowdata.$sn.seme_num}}</td>
<td style="color:{{if $rowdata.$sn.stud_sex==1}}blue{{else}}red{{/if}};">{{$rowdata.$sn.stud_name}}<input type="hidden" name="sn[{{$sn}}]" value="{{$sn}}"></td>
<td>{{$rowdata.$sn.move_date}}</td>
{{foreach from=$semes item=d key=s}}
{{if $rowdata.$sn.move_year_seme>$s}}{{assign var=ss value=1}}{{elseif $rowdata.$sn.move_year_seme==$s}}{{assign var=ss value=2}}{{else}}{{assign var=ss value=3}}{{/if}}
<td style="background-color:{{if $ss==1}}white{{elseif $ss==2}}#FFFF80{{else}}#E0E0E0{{/if}};">{{t2c times=$times.$s semes=$s sn=$sn kind=$ss enable=$rowdata.$sn.testdata.$s}}</td>
{{/foreach}}
</tr>
{{/foreach}}
</table>
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>������N��ӾǴ�����J�Ǵ��C</li>
	<li>��J�᪺�U�Ǵ��]��Ǵ��Цۦ�̱��p���H�u�P�_�^���q���Z�۰ʡ]�j��^�ĭp�C</li>
	<li>�ݥ��ɵn���Z��A�ҿﶵ�ؤ~���x�s�C</li>
	</ol>
</td></tr>
</table>
{{elseif $smarty.post.step==4}}
<div id="proc" style="display:none;">
<br>
���Z�p��i�� <span class="progressBar" id="pb1">0%</span>
<div id="msg">
&nbsp;
</div></div>
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>���U�u�}�l�p��v�s�N�}�l�i�榨�Z�p��C</li>
	</ol>
</td></tr>
</table>
{{elseif $smarty.post.step==5}}
<table border="0" width="100%" style="font-size:12px;" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC" align="center">
<td>�Z��</td>
<td>�Ǹ�</td>
<td>�m�W</td>
<td>�����Ҹ�</td>
<td>�ʧO</td>
<td>�ͤ�</td>
{{foreach from=$col_arr item=d}}
<td>{{$d}}�w</td>
{{/foreach}}
{{foreach from=$s_arr item=d}}
<td>{{$d}}�w��</td>
{{/foreach}}
<td>�`�w��</td>
{{foreach from=$s_arr item=d}}
<td>{{$d}}�wPR</td>
{{/foreach}}
<td>�`�wPR</td>
</tr>
{{foreach from=$student_sn item=d key=seme_class}}
{{foreach from=$d item=sn key=site_num}}
<tr bgcolor="#ddddff" align="center">
<td>{{$seme_class|@substr:-2:2|intval}}</td>
<td>{{$stud_data.$sn.stud_id}}</td>
<td>{{$stud_data.$sn.stud_name}}</td>
<td>{{$stud_data.$sn.stud_person_id}}</td>
<td>{{$stud_data.$sn.stud_sex}}</td>
<td>{{$stud_data.$sn.stud_birthday}}</td>
{{foreach from=$semes item=si}}
{{foreach from=$s_arr item=sl key=j}}
<td>{{$rowdata.$sn.$si.$j.score}}</td>
{{/foreach}}
{{/foreach}}
{{foreach from=$s_arr item=sl key=j}}
<td>{{$rowdata.$sn.9991.$j.score}}</td>
{{/foreach}}
<td>{{$rowdata.$sn.9991.6.score}}</td>
{{foreach from=$s_arr item=sl key=j}}
<td>{{$rowdata.$sn.9991.$j.pr}}</td>
{{/foreach}}
<td>{{$rowdata.$sn.9991.6.pr}}</td>
</tr>
{{/foreach}}
{{/foreach}}
</table>
{{else}}
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>����ƥثe���x�����K�դJ�ǨϥΡA��L�a�ϭY�����P��Ʈ榡�A�ЦA�P�{���}�o�p�ճs���C</li>
	<li>���@�~�N�̤U�C�B�J�i��G</li>
	<ol style="list-style-type: lower-roman;">
	<li>��ܩҭn�B�z���Z���Ǧ~�Ǵ��C</li>
	<li>�]�w�U�Ǧ~�Ǵ����ҭn�B�z��������ءC</li>
	<li>�]�w�U��ǥͭn�B�z���Z���Ǧ~�Ǵ��P���q�C</li>
	<li>���Z�p��C</li>
	<li>��ܵ��G�C</li>
	</ol>
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
