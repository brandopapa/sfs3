{{* $Id: fitness_input.tpl 8065 2014-06-13 06:18:06Z smallduh $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<script language="JavaScript">
function openwindow(t){
	window.open ("quick_input.php?t="+t+"&class_num={{$class_num}}&c_curr_seme={{$smarty.post.year_seme}}","���Z�B�z","toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=600,height=420");
}
</script>

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="4">
<form action="{{$smarty.server.PHP_SELF}}" method="post">
<input type="hidden" name="act" value="">
<tr>
<td bgcolor="#FFFFFF" valign="top">
<p>{{$seme_menu}} {{$class_menu}} <font size="3" color="blue">���U���ئW�٧Y�i��J���Z</font> {{if $admin}}<input type='submit' value='������Ǵ����վǥͨ����魫���' name='copy_wh' onclick='return confirm("�ǥͤH�Ʀh���ܥi��|�Ӯɫܤ[�A�T�w�n�o�˰��ܡH")'>{{else}}<input type='submit' value='������Ǵ������魫���' name='copy_wh'>{{/if}}</p>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%">
<tr bgcolor="#c4d9ff">
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">�Ǹ�</td>
<td align="center"><a onclick="openwindow('0');"><img src="./images/wedit.png" border="0" title="��ƿ�J">����</a><br>(cm)</td>
<td align="center"><a onclick="openwindow('1');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�魫</a><br>(kg)</td>
<td align="center"><a onclick="openwindow('2');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�����e�s</a><br>(cm)</td>
<td align="center"><a onclick="openwindow('4');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�ߩw����</a><br>(cm)</td>
<td align="center"><a onclick="openwindow('3');"><img src="./images/wedit.png" border="0" title="��ƿ�J">���װ_��</a><br>(��)</td>
<td align="center"><a onclick="openwindow('5');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�ߪ;A��</a><br>(��)</td>
<td align="center"><a onclick="openwindow('6');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�˴����</a></td>
<td align="center"><a onclick="openwindow('7');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�˴��~��</a><br>( �~-�� )</td>
</tr>
{{foreach from=$rowdata item=d key=i}}
{{assign var=sn value=$d.student_sn}}
<tr bgcolor="white">
<td class="small">{{$d.seme_num}}</td>
<td class="small"><font color="{{if $d.stud_sex==1}}blue{{elseif $d.stud_sex==2}}red{{else}}black{{/if}}">{{$d.stud_name}}</font></td>
<td style="text-align:right;">{{$d.stud_id}}</td>
<td style="text-align:right;">{{$fd.$sn.tall}}</td>
<td style="text-align:right;">{{$fd.$sn.weigh}}</td>
<td style="text-align:right;">{{$fd.$sn.test1}}</td>
<td style="text-align:right;">{{$fd.$sn.test3}}</td>
<td style="text-align:right;">{{$fd.$sn.test2}}</td>
<td style="text-align:right;">{{$fd.$sn.test4}}</td>
<td style="text-align:left;">{{$fd.$sn.organization}}</td>
<td style="text-align:center;">{{$fd.$sn.test_y}}-{{$fd.$sn.test_m}}</td>
</tr>
{{/foreach}}
</table>
</td></tr></table>
{{if $admin}}
<table border="2" cellpadding="3" cellspacing="0" style="border-collapse: collapse; font-size=9px;" bordercolor="#119911" width="100%">
		<tr><td align="center" bgcolor="#ccffff">���絲�G�妸�פJ</td></tr>
		<tr><td><font size=2>
			<li>���\��i�פJ��w�Ǵ��N�Ǿǥͪ���A���������A<a href='./xls_sample.xls'><img src='./images/pen.png' border=0 height=11>�榡�U��</a>�C</li>
			<li>�פJ����ƱıШ|����Ʈ榡�A��춷���T�w�����ǡG�������B�Ǯ����O�B�~�šB�Z�ŦW�١B�Ǹ��B�ʧO�B�����Ҧr���B�ͤ�B�����B�魫�B������e�s�B�ߩw�����B���װ_���B�ߪ;A��B<font color='red'>�˴����</font>�C</li>
			<li>�פJ�ɧK�n�������G�Ǯ����O�B�~�šB�ʧO�B�����Ҧr���B�ͤ�F<font color='red'>���������G�Z�ŦW�١B�Ǹ��F�Z�ŦW�ٽХΧǦC�N����ܡA�p���~�үZ�ж�601�B�E�~�G�Z�ж�902�C</font></li>
			<li>�פJ��A�{���|�N��Ƥ����ľǥͫ��w�Ǵ��즳�������R���A�A�̾ڱz�K�W����ƭ��s�O���A���ԷV�ϥΡC</li>
			<li>�ƻs�K�W����ƵL���]�t���W�٩λ����A�ȻݶK�W�ǥͬ����C�Y�i�I</li>
			</font></td></tr>
		<tr><td>
		<textarea name="content" style="border-width:1px; color:blue; background:#ffeeee; font-size:11px;" cols=120 rows=5></textarea></td></tr>
		<tr><td align="center" bgcolor="#ccffff"><input type="submit" name="go" value="�פJ"></td></tr>
		</table><font color="red">{{$msg}}</font>
{{/if}}
</form>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
