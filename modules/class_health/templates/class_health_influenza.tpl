{{* $Id: class_health_influenza.tpl 7728 2013-10-28 09:02:05Z smallduh $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/jquery.min.js"></script>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/hovertip.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		window.setTimeout(hovertipInit, 1);
     });
	function act(a,b,c) {
		if ((a=='del' && confirm('�T�w�n�R��������� ?')) || a!='del') {
			document.myform.act.value=a;
			document.myform.student_sn.value=b;
			document.myform.dis_date.value=c;
			document.myform.submit();
		}
	}
</script>
<style type="text/css" media="all">@import "{{$SFS_PATH_HTML}}javascripts/css.css";</style>

<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<form name="myform" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<tr>
<td bgcolor="white">
<input type="submit" name="add" value="�s�W���">
<input type="hidden" name="act" value="add">
<input type="hidden" name="student_sn">
<input type="hidden" name="dis_date">
<br>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:#E6E9F9;text-align:center;">
<td rowspan="2">�y��</td>
<td rowspan="2">�m�W</td>
<td rowspan="2">�ʧO</td>
<td rowspan="2">�X�ͦ~��</td>
<td colspan="7">�g��</td>
<td rowspan="2">�а�<br>���p</td>
<td>�o�f��</td>
<td>�N�E��|</td>
<td>���ˤ��</td>
<td rowspan="2">���L<br>�I��<br>�y�P<br>�̭]</td>
<td rowspan="2">���P<br>�_�g<br>�g�a<br>�ݡ@</td>
<td rowspan="2">�a�H<br>�̪�<br>���_<br>�X��</td>
<td rowspan="2">�Ƶ�</td>
<td rowspan="2">�\��</td>
</tr>
<tr style="background-color:#E6E9F9;text-align:center;vertical-align:top;">
<td>�o<br>��<br>�N</td>
<td>��<br>��<br>��<br>�h</td>
<td>�Y<br>�h</td>
<td>��<br>��<br>��<br>��</td>
<td>�y<br>��</td>
<td>�I<br>�l<br>��</td>
<td>��<br>�V<br>�h</td>
<td style="vertical-align:middle;">�N�E��</td>
<td style="vertical-align:middle;">��v�E�_�f�W</td>
<td style="vertical-align:middle;">������i</td>
</tr>
{{assign var=j value=1}}
{{foreach from=$rowdata item=d key=i}}
{{assign var=sn value=$d.student_sn}}
{{php}}
$this->_tpl_vars['v']=explode("@@@",$this->_tpl_vars['d']['sym_str']);
$this->_tpl_vars['vv']=explode("@@@",$this->_tpl_vars['d']['oth_chk']);
$vvv=explode("@@@",$this->_tpl_vars['d']['oth_txt']);
reset($vvv);
while(list($k,$v)=each($vvv)) {
	$vvvv=explode("###",$v);
	$this->_tpl_vars['vvv'][$vvvv[0]]=$vvvv[1];
}
{{/php}}
<tr style="background-color:{{if $ii}}#F0F0F0{{else}}white{{/if}};">
<td rowspan="2">{{$studdata.$sn.seme_num}}</td>
<td rowspan="2">{{$studdata.$sn.stud_name}}</td>
<td rowspan="2">{{$studdata.$sn.stud_sex}}</td>
<td rowspan="2">{{$studdata.$sn.stud_birthyear}}</td>
<td rowspan="2">{{if (in_array(1,$v))}}v{{/if}}</td>
<td rowspan="2">{{if (in_array(2,$v))}}v{{/if}}</td>
<td rowspan="2">{{if (in_array(3,$v))}}v{{/if}}</td>
<td rowspan="2">{{if (in_array(4,$v))}}v{{/if}}</td>
<td rowspan="2">{{if (in_array(5,$v))}}v{{/if}}</td>
<td rowspan="2">{{if (in_array(6,$v))}}v{{/if}}</td>
<td rowspan="2">{{if (in_array(7,$v))}}v{{/if}}</td>
<td rowspan="2">{{$status[$d.status]}}</td>
<td>{{$d.dis_date}}</td>
<td>{{$d.diag_hos}}</td>
<td>{{if $d.chk_date!="0000-00-00"}}{{$d.chk_date}}{{else}}&nbsp;{{/if}}</td>
<td rowspan="2" style="text-align:center;">{{if (in_array(1,$vv))}}v{{/if}}</td>
<td rowspan="2">{{$vvv.0}}</td>
<td rowspan="2" style="text-align:center;">{{if (in_array(2,$vv))}}v{{/if}}</td>
<td rowspan="2">{{if $vvv.1}}<a href="#" id="j{{$i}}">***</a><ul style="display: block;" class="hovertip" target="j{{$i}}">{{$vvv.1}}</ul>{{/if}}</td>
<td rowspan="2"><a href="#" OnClick="act('edit','{{$sn}}','{{$d.dis_date}}');">�s��</a> <a href="#" OnClick="act('del','{{$sn}}','{{$d.dis_date}}');">�R��</a></td>
</tr>
<tr style="background-color:{{if $ii}}#F0F0F0{{else}}white{{/if}};">
<td>{{if $d.diag_date!="0000-00-00"}}{{$d.diag_date}}{{else}}&nbsp;{{/if}}</td>
<td>{{$d.diag_name}}</td>
<td>{{$d.chk_report}}</td>
</tr>
{{assign var=ii value=$j-$ii}}
{{foreachelse}}
<tr style="background-color:white;">
<td colspan="20" style="color:red;text-align:center;">�ثe�L���</td>
</tr>
{{/foreach}}
</table>
</td>
<table width="100%">
<tr bgcolor="#FBFBC4">
<td><img src="{{$SFS_PATH_HTML}}images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td>
</tr>
<tr><td style="line-height:150%;">
<ol>
<li class="small">���{���ثe���]�߿��ϥή榡�A��L�����ШϥΡu<a href="inflection.php">�æ��ǬV�f�q��</a>�v�{���i��O���C</li>
<li class="small">���{���P�u�æ��ǬV�f�q���v�{���w�������X�A�Y�󥻵{���i��O���A�N�P�B��u�æ��ǬV�f�q���v�i��O���C</li>
</ol>
</td></tr>
</table>
</tr>
</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
