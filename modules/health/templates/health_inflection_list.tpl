{{* $Id: health_inflection_list.tpl 5635 2009-09-10 14:02:36Z brucelyc $ *}}

<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/jquery.min.js"></script>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/hovertip.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		window.setTimeout(hovertipInit, 1);
     });
	function go2(a,b,c) {
		if ((a=='del' && confirm('�T�w�n�R��������� ?')) || a!='del') {
			document.myform.act.value=a;
			document.myform.student_sn.value=b;
			document.myform.iid.value=c;
			document.myform.submit();
		}
	}
	function go(a,b) {
		document.myform.act.value=a;
		if (b) document.myform.sel_week.value=b;
		document.myform.submit();
	}
</script>
<style type="text/css" media="all">@import "{{$SFS_PATH_HTML}}javascripts/css.css";</style>

<input type="button" value="�s�W���" OnClick="go('add');">
<span class="small">
�g��&gt;
{{foreach from=$weeks_arr item=d key=i}}{{if $i>0}}{{if $weeks_arr.0==$i}}<span style="color:red;">{{$i}}</span>{{else}}<a href="#" OnClick="go('',{{$i}});">{{$i}}</a>{{/if}}{{if ($weeks_arr|@count)>($i+1)}},{{/if}}{{/if}}{{/foreach}}
</span>
<input type="hidden" name="act" value="">
<input type="hidden" name="student_sn">
<input type="hidden" name="iid">
<input type="hidden" name="sel_week" value="{{$weeks_arr.0}}">
<br>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="3" class="small">
<tr style="background-color:#E6E9F9;text-align:center;">
<td rowspan="2">�~��</td>
<td rowspan="2">�Z��</td>
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
{{foreach from=$d.iid item=dd key=iid}}
<tr style="background-color:{{if $ii}}#F0F0F0{{else}}white{{/if}};text-align:center;">
<td>{{$rowdata.$sn.year_name}}</td>
<td>{{$rowdata.$sn.class_name}}</td>
<td>{{$rowdata.$sn.seme_num}}</td>
<td style="color:{{if $rowdata.$sn.stud_sex==1}}blue{{elseif $rowdata.$sn.stud_sex==2}}red{{else}}black{{/if}};">{{$rowdata.$sn.stud_name}}</td>
<td>{{if $rowdata.$sn.stud_sex==1}}�k{{elseif $rowdata.$sn.stud_sex==2}}�k{{/if}}</td>
{{foreach from=$inf_arr item=ddd}}
<td>{{if $iid==$ddd.iid}}v{{/if}}</td>
{{/foreach}}
<td></td>
{{foreach from=$cweekday item=ddd key=iii}}
<td>{{$dd.$iii}}</td>
{{/foreach}}
<td></td>
<td><a href="#" OnClick="go2('edit','{{$sn}}','{{$iid}}');">�s��</a> <a href="#" OnClick="go2('del','{{$sn}}','{{$iid}}');">�R��</a></td>
</tr>
{{/foreach}}
{{foreachelse}}
<tr style="background-color:white;">
<td colspan="19" style="color:red;text-align:center;">�ثe�L���</td>
</tr>
{{/foreach}}
</table>
