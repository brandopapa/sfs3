{{* $Id: stud_basic_test_distest.tpl 5886 2010-03-06 01:57:08Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<form name="menu_form" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td style="vertival-align:top;background-color:#CCCCCC;">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" width="100%" class="main_body">
<tr><td>�Ǵ��G{{$year_seme_menu}} �~�šG{{$class_year_menu}} <input type="submit" name="xls" value="XLS��X" {{if !$smarty.post.year_name}}disabled="true"{{/if}}> {{$menu2}}
{{if $smarty.post.year_name}}
<br>
<table border="0" width="100%" style="font-size:12px;" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC" align="center">
<td>�ۥ;Ǯ�</td>
<td>�Z��</td>
<td>�Ǹ�</td>
<td>�m�W</td>
<td>�����Ҹ�</td>
<td>�ʧO</td>
<td>�ͤ�</td>
<td>�q��</td>
<td>�l���ϸ�</td>
<td>�a�}</td>
{{foreach from=$col_arr item=d}}
<td>{{$d}}</td>
{{/foreach}}
<td>�`����</td>
<td>�K���W�O</td>
</tr>
{{foreach from=$student_sn item=d key=seme_class}}
{{foreach from=$d item=sn key=site_num}}
<tr bgcolor="#ddddff" align="center">
<td></td>
<td>{{$seme_class|@substr:-2:2|intval}}</td>
<td>{{$stud_data.$sn.stud_id}}</td>
<td>{{$stud_data.$sn.stud_name}}</td>
<td>{{$stud_data.$sn.stud_person_id}}</td>
<td>{{$stud_data.$sn.stud_sex}}</td>
<td>{{$stud_data.$sn.stud_birthday}}</td>
<td>{{$stud_data.$sn.stud_tel}}</td>
<td>{{$stud_data.$sn.addr_zip}}</td>
<td>{{$stud_data.$sn.stud_addr_1}}</td>
{{foreach from=$col2_arr item=si}}
{{foreach from=$ss_link item=sl}}
<td>{{s2s score=$fin_score.$sn.$sl.$si.score rule=$rule.$si}}</td>
{{/foreach}}
{{/foreach}}
<td>{{s2s score=$fin_score.$sn.avg.score rule=$rule.$seme_year_seme}}</td>
<td></td>
</tr>
{{/foreach}}
{{/foreach}}
</table>
</td></tr>
{{else}}
<br>�Х��ˬd�Ǵ����Z�O�_���h�l��ơA�H�T�O���Z�p�⥿�T�C<input type="submit" name="check" value="���ˬd���Z">
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>����Ƭ��n�Ϥ��M�p�ۧK�դJ�ǨϥΡC</li>
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
