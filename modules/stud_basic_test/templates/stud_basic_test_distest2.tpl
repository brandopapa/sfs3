{{* $Id: stud_basic_test_distest2.tpl 5887 2010-03-06 02:00:48Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<form name="menu_form" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td style="vertival-align:top;background-color:#CCCCCC;">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" width="100%" class="main_body">
<tr><td>�Ǵ��G{{$year_seme_menu}} �~�šG{{$class_year_menu}} {{$menu2}} <br>
��X�G<input type="submit" name="txt" value="����TXT��" {{if !$smarty.post.year_name}}disabled="true"{{/if}}> <input type="submit" name="xls" value="�_��XLS��" {{if !$smarty.post.year_name}}disabled="true"{{/if}}> <input type="submit" name="chart" value="���Z�ҩ�" {{if !$smarty.post.year_name}}disabled="true"{{/if}}>
{{if $smarty.post.year_name}}
<br>
<table border="0" width="100%" style="font-size:12px;" bgcolor="#C0C0C0" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFCC" align="center">
<td>�Z<br>��</td>
<td>�y<br>��</td>
<td>�ǥͩm�W</td>
<td>�����Ҧr��</td>
<td>��<br>�O</td>
<td>�X<br>��<br>�~</td>
<td>�X<br>��<br>��</td>
<td>�X<br>��<br>��</td>
<td>��<br>��<br>��<br>��</td>
<td>��<br>��<br>��<br>ê</td>
<td>��<br>�w<br>�~</td>
<td>��<br>��<br>��<br>�v</td>
<td>�a���m�W</td>
<td>�q�@�@��</td>
<td>�l<br>��<br>��<br>��</td>
<td>�a�@�@�}</td>
<td>�Ǹ�</td>
<td>���</td>
<td>�^��</td>
<td>�ƾ�</td>
<td>���|</td>
<td>�۵M</td>
<td>���d<br>�P<br>��|</td>
<td>���N<br>�P<br>�H��</td>
<td>��X<br>����</td>
<td>�C�j<br>�ǲ�<br>���<br>����</td>
</tr>
{{foreach from=$student_sn item=d key=seme_class}}
{{foreach from=$d item=sn key=site_num}}
<tr bgcolor="#ddddff" align="center">
<td>{{$seme_class|@substr:-2:2}}</td>
<td>{{$site_num|string_format:"%02d"}}</td>
<td>{{$stud_data.$sn.stud_name}}</td>
<td>{{$stud_data.$sn.stud_person_id}}</td>
<td>{{$stud_data.$sn.stud_sex}}</td>
<td>{{$stud_data.$sn.stud_birthday|@substr:0:2}}</td>
<td>{{$stud_data.$sn.stud_birthday|@substr:2:2}}</td>
<td>{{$stud_data.$sn.stud_birthday|@substr:4:2}}</td>
<td>0</td>
<td>00</td>
<td>1</td>
<td>1</td>
<td>{{$stud_data.$sn.parent_name}}</td>
<td>{{$stud_data.$sn.stud_tel}}</td>
<td>{{$stud_data.$sn.addr_zip|@substr:0:3}}</td>
<td>{{$stud_data.$sn.stud_addr_1}}</td>
<td>{{$stud_data.$sn.stud_id}}</td>
{{foreach from=$ss_link item=sl}}
<td>{{s2n score=$fin_score.$sn.$sl semes=$semes}}</td>
{{/foreach}}
<td>{{tavg score=$fin_score.$sn semes=$semes ss_link=$ss_link}}</td>
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
	<ol style="list-style-type: none;">
	<li>1. ����Ƭ����ϡB�_�Ϥ��M�p�ۧK�դJ�ǨϥΡC</li>
	<li>2. ���Z�p��W�h�G</li>
	<li> &nbsp; (1) �U��دŤ�����W�h�G</li>
	<li> &nbsp; &nbsp; (i) �U��ؤ��Ǵ���l���Z���|�ˤ��J�A�������⬰�Ť��C</li>
	<li> &nbsp; &nbsp; (ii) �U��ؤ��Ǵ����Ť��[�`��A�o��U��دŤ��X�p�C</li>
	<li> &nbsp; (2) �C�j���]�K�j��^��������W�h�G</li>
	<li> &nbsp; &nbsp; (i) �U��ؤ��Ǵ���l���Z���|�ˤ��J�A���O��X�U��إ������ƫ�A���H�|�ˤ��J���ܤp���I��ĤG��C</li>
	<li> &nbsp; &nbsp; (ii) �H�U��إ������ơ]���ܤp���I��ĤG��^��X�U����`������A���H�|�ˤ��J���ܤp���I��Ĥ@��C</li>
	<li> &nbsp; &nbsp; (iii) �H�U����`�����]���ܤp���I��Ĥ@��^���⬰���ġC</li>
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
