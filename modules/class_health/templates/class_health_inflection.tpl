{{* $Id: class_health_inflection.tpl 5634 2009-09-10 06:57:09Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/jquery.min.js"></script>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/hovertip.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		window.setTimeout(hovertipInit, 1);
     });
	function go(a,b,c) {
		if ((a=='del' && confirm('�T�w�n�R��������� ?')) || a!='del') {
			document.myform.act.value=a;
			document.myform.student_sn.value=b;
			document.myform.iid.value=c;
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
<input type="hidden" name="iid">
<br>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:#E6E9F9;text-align:center;">
<td rowspan="2">�y��</td>
<td rowspan="2">�m�W</td>
<td rowspan="2">�ʧO</td>
<td colspan="7">�ͯf��]</td>
<td colspan="5">�ͯf��<br><span style="color:red;">(A�G��ܥͯf���W�� B�G��ܥͯf�b�a�� C�G��ܥͯf��|)</span></td>
<td rowspan="2">�Ƶ�</td>
<td rowspan="2">�\��</td>
</tr>
<tr style="background-color:#E6E9F9;text-align:center;vertical-align:top;">
{{foreach from=$inf_arr item=d}}
<td style="width:40pt;">{{$d.name}}</td>
{{/foreach}}
<td>��L����</td>
{{foreach from=$cweekday item=d key=i}}
<td style="vertical-align:middle;">{{$d}}<br>[{{$weekday_arr[$i]}}]</td>
{{/foreach}}
</tr>
{{foreach from=$rowdata item=d key=sn}}
{{foreach from=$d item=dd key=iid}}
<tr style="background-color:{{if $ii}}#F0F0F0{{else}}white{{/if}};text-align:center;">
<td>{{$dd.seme_num}}</td>
<td style="color:{{if $dd.stud_sex==1}}blue{{elseif $dd.stud_sex==2}}red{{else}}black{{/if}};">{{$dd.stud_name}}</td>
<td>{{if $dd.stud_sex==1}}�k{{elseif $dd.stud_sex==2}}�k{{/if}}</td>
{{foreach from=$inf_arr item=ddd}}
<td>{{if $iid==$ddd.iid}}v{{/if}}</td>
{{/foreach}}
<td></td>
{{foreach from=$cweekday item=ddd key=iii}}
<td>{{$dd.$iii}}</td>
{{/foreach}}
<td></td>
<td><a href="#" OnClick="go('edit','{{$sn}}','{{$iid}}');">�s��</a> <a href="#" OnClick="go('del','{{$sn}}','{{$iid}}');">�R��</a></td>
</tr>
{{/foreach}}
{{foreachelse}}
<tr style="background-color:white;">
<td colspan="17" style="color:red;text-align:center;">�ثe�L���</td>
</tr>
{{/foreach}}
</table>
</td>
</tr>
</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
