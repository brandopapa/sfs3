{{* $Id: stud_basic_test_score_input.tpl 5827 2010-01-14 14:02:11Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<script type="text/javascript">
<!--
function go(a) {
	var i =0;
	document.menu_form.student_sn.value=a;
	document.menu_form.submit();
}
//-->
</script>

<form name="menu_form" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<input type="hidden" name="student_sn">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td style="vertival-align:top;background-color:#CCCCCC;">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" width="100%" class="main_body">
<tr><td>�Ǵ��G{{$year_seme_menu}} �~�šG{{$class_year_menu}}
{{if $smarty.post.student_sn}}
{{* �ɵn�Ҧ� *}}
<input type="submit" name="sure" value="�T�w�x�s"> <input type="reset" value="�٭�"> <input type="submit" value="���}">
{{assign var=sn value=$smarty.post.student_sn}}
<br>
<table border="0" width="100%" style="font-size:12px;" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC" align="center">
<td>�Z��</td>
<td colSpan="6" style="background-color:white;text-align:left;">&nbsp; &nbsp;{{$rowdata.$sn.seme_class}}</td>
</tr>
<tr bgcolor="#FFFFCC" align="center">
<td>�y��</td>
<td colSpan="6" style="background-color:white;text-align:left;">&nbsp; &nbsp;{{$rowdata.$sn.seme_num}}</td>
</tr>
<tr bgcolor="#FFFFCC" align="center">
<td>�ǥͩm�W</td>
<td colSpan="6" style="background-color:white;text-align:left;color:{{if $rowdata.$sn.stud_sex==1}}blue{{else}}red{{/if}};">&nbsp; &nbsp;{{$rowdata.$sn.stud_name}}</td>
</tr>
<tr bgcolor="#FFFFCC" align="center">
<td>��J��</td>
<td colSpan="6" style="background-color:white;text-align:left;">&nbsp; &nbsp;{{$rowdata.$sn.move_date}}</td>
</tr>
<tr bgcolor="#FFFFCC" align="center">
<td>��� \ �Ǵ�</td>
{{foreach from=$semes item=d}}
<td>{{$d}}</td>
{{/foreach}}
</tr>
{{foreach from=$ss_link item=dd key=s_no}}
<tr bgcolor="{{cycle values="white,#f0f0f0"}}" align="center">
<td>{{$s_arr.$s_no}}</td>
{{foreach from=$semes item=d key=s}}
{{if $rowdata.$sn.move_year_seme>$s}}{{assign var=ss value=1}}{{elseif $rowdata.$sn.move_year_seme==$s}}{{assign var=ss value=2}}{{else}}{{assign var=ss value=3}}{{/if}}
{{assign var=t value=$times.$s}}
{{assign var=ff_arr value=$ff.$t}}
<td>{{if $ss!=3}}{{foreach from=$ff_arr item=f}}���q{{$f}}<input type="text" size="5" name="score[{{$sn}}][{{$s}}][{{$s_no}}][{{$f}}]" value="{{if $score_arr.$sn.$s.$s_no.$f>0}}{{$score_arr.$sn.$s.$s_no.$f}}{{/if}}"><br>{{/foreach}}{{else}}-----{{/if}}</td>
{{/foreach}}
</tr>
{{/foreach}}
</table>
<br><input type="submit" name="sure" value="�T�w�x�s"> <input type="reset" value="�٭�">
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>�ɵn���Ƭ��U�Ǵ��]�w���w���Ҭd���ơC</li>
	<li>�]���C�Ǧ~�ĭp���覡�L�k�T�w�A�ҥH�ثe�w�]�ɵn���Z�H�Ҧ��Ǵ��ӦҶq�A�Y�T�w���ĭp���Ǵ��A�h�i�H���ɵn�C</li>
	<li>�Y�L���Z�h�L�ݸɵn�C</li>
	</ol>
</td></tr>
</table>
{{elseif $smarty.post.year_name}}
{{* �C��Ҧ� *}}
<br>
<table border="0" width="100%" style="font-size:12px;" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC" align="center">
<td>��</td>
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
<td><input type="checkbox" OnClick="go({{$sn}});"></td>
<td>{{$rowdata.$sn.seme_class}}</td>
<td>{{$rowdata.$sn.seme_num}}</td>
<td style="color:{{if $rowdata.$sn.stud_sex==1}}blue{{else}}red{{/if}};">{{$rowdata.$sn.stud_name}}</td>
<td>{{$rowdata.$sn.move_date}}</td>
{{foreach from=$semes item=d key=s}}
{{if $rowdata.$sn.move_year_seme>$s}}{{assign var=ss value=1}}{{elseif $rowdata.$sn.move_year_seme==$s}}{{assign var=ss value=2}}{{else}}{{assign var=ss value=3}}{{/if}}
<td style="background-color:{{if $ss==1}}white{{elseif $ss==2}}#FFFF80;color:red;{{else}}#E0E0E0;color:grey{{/if}};">{{if $ss==1}}�ݸɵn{{$times.$s}}��{{elseif $ss==2}}�����p�ɵn{{else}}���ݸɵn{{/if}}</td>
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
	<li>�ɵn���Ƭ��U�Ǵ��]�w���w���Ҭd���ơC</li>
	<li>�]���C�Ǧ~�ĭp���覡�L�k�T�w�A�ҥH�ثe�w�]�ɵn���Z�H�Ҧ��Ǵ��ӦҶq�A�Y�T�w���ĭp���Ǵ��A�h�i�H���ɵn�C</li>
	</ol>
</td></tr>
</table>
{{else}}
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>����Ʀ��Z�ɵn�ثe�ȨѧK�դJ�ǭp��ϥΡC</li>
	<li>�ɵn��쬰�t�Φ۰ʧP�_�A���Хu�ɵn����J�e�����q���Z�C</li>
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
