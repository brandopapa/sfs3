{{* $Id: reward_reward_stud_all.tpl 6920 2012-10-01 08:25:16Z infodaes $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<script>
<!--
function del(a,b,c) {
	var k;
	k=confirm('�T�w�R�����O��?');
	if (k) {
		document.record.reward_id.value=a;
		document.record.sel_year.value=b;
		document.record.sel_seme.value=c;
		document.record.act.value='del';
		document.record.submit();
	}
}
-->
</script>

<table cellspacing="0" cellpadding="0"><tr><td>
<table bgcolor="#9EBCDD" cellspacing="1" cellpadding="4">
<form action="{{$smarty.server.PHP_SELF}}" method="post">
<tr class="title_sbody2">
<td align="center" colspan='2'>1.���d��</td><td align='left' bgcolor='white'>{{$year_seme_select}}
{{$class_select}}{{if $smarty.post.class_id}}{{$stud_select}}<input type="submit" value="�󴫾ǥ�">{{/if}}</td>
</tr>
<tr class="title_sbody2">
<td align="center" colspan="2" vlign="middle">2.�Ǹ��Ψ����r���d��</td>
<td bgcolor="white" colspan="6" align="left">
<input type="text" size="10" name="stud_id" value="{{$smarty.post.stud_id}}">
<input type="submit" value="�󴫾ǥ�">
<input type="hidden" name="id" value="�󴫾ǥ�">
</td></tr>
</form>
<form action="{{$smarty.server.PHP_SELF}}" method="post">
<tr class="title_sbody2">
<td align="center" colspan="2">3.�Z�Ůy���d��</td>
<td bgcolor="white" colspan="6" align="left">
<input type="text" size="2" name="year_name" value="">�~��
<input type="text" size="2" name="class_num" value="">�Z
<input type="text" size="2" name="site_num" value="">��
<input type="submit" name="num" value="�󴫾ǥ�">
</td></tr>
</form>
{{if $stud_rows}}
<form action="{{$smarty.server.PHP_SELF}}" method="post">
{{foreach from=$stud_rows item=d key=i}}
<tr class="title_sbody2">
{{if $i==0}}
<td align="center" colspan="2" rowspan="{{$stud_nums}}">�ǥͦC��</td>
{{/if}}
{{assign var=d_id value=$d.stud_study_cond}}
<td bgcolor="white" colspan="6" align="left">
<input type="radio" name="student_sn" value="{{$d.student_sn}}" OnClick="this.form.submit();">
<span style="color:{{if $d.stud_sex==1}}blue{{elseif $d.stud_sex==2}}red{{else}}black{{/if}};">{{$d.stud_name}}</span>
({{$d.stud_study_year}}�~�J��)
({{$study_cond.$d_id}})
</td>
</tr>
{{/foreach}}
</form>
{{/if}}
{{if $stud_base}}
<tr class="title_sbody2">
<td align="center" colspan="2">�ǥͩm�W</td>
<td bgcolor="white" colspan="6" align="left">{{$stud_base.stud_name}}</td>
</tr>
{{assign var=d_id value=$stud_base.stud_study_cond}}
<tr class="title_sbody2">
<td align="center" colspan="2">�N�Ǫ��A</td>
<td bgcolor="white" colspan="6" align="left">{{$study_cond.$d_id}}</td>
</tr>
<form name="record" action="{{$smarty.server.PHP_SELF}}" method="post">
<tr class="title_sbody2">
<td align="center" colspan="2">�\��ﶵ</td>
<td bgcolor="white" colspan="6" align="left">
<input type="checkbox" name="only_this" {{if $smarty.post.only_this}}checked{{/if}} OnClick="this.form.submit();">�ȦC���Ǵ��O��
<input type="checkbox" name="cancel_chk" {{if $smarty.post.cancel_chk}}checked{{/if}} OnClick="this.form.submit();">�t�w�P�L�O��
{{if $smarty.post.list!=""}}<input type="button" OnClick="this.form.list.value='';this.form.submit();" value="�C�X�Ҧ�����">{{/if}}
{{if $smarty.post.list!='1'}}<input type="button" OnClick="this.form.list.value='1';this.form.submit();" value="�u�C���y����">{{/if}}
{{if $smarty.post.list!='2'}}<input type="button" OnClick="this.form.list.value='2';this.form.submit();" value="�u�C�g�٬���">{{/if}}
<input type="submit" name="print" value="�C�L">
<input type="hidden" name="student_sn" value="{{$smarty.post.student_sn}}">
<input type="hidden" name="stud_id" value="{{$smarty.post.stud_id}}">
<input type="hidden" name="list" value="{{$smarty.post.list}}">
<input type="hidden" name="reward_id" value="">
<input type="hidden" name="sel_year" value="">
<input type="hidden" name="sel_seme" value="">
<input type="hidden" name="act" value="">
</td>
</tr>
{{/if}}
{{if $reward_rows}}
<tr class="title_sbody2">
<td align="center">�Ǧ~</td>
<td align="center">�Ǵ�</td>
<td align="center">���g�ƥ�</td>
<td align="center" width="50">���g���O</td>
<td align="center">���g�̾�</td>
<td align="center" width="80">���g�ͮĤ��</td>
<td align="center" width="80">�P�L���</td>
<td align="center" width="50">�\��ﶵ</td>
</tr>
{{foreach from=$reward_rows item=d}}
{{assign var=r_id value=$d.reward_kind}}
{{assign var=sel_year value=$d.reward_year_seme|@substr:0:-1}}
{{assign var=sel_seme value=$d.reward_year_seme|@substr:-1:1}}
<tr class="title_sbody1" style="background-color:{{if $r_id>0}}#FFE6D9{{else}}#E6F2FF{{/if}}">
<td align="center">{{$sel_year}}</td>
<td align="center">{{$sel_seme}}</td>
<td align="left">{{$d.reward_reason}}</td>
<td align="center">{{$reward_kind.$r_id}}</td>
<td align="left">{{$d.reward_base}}</td>
<td align="center">{{$d.reward_date}}</td>
<td align="center">{{if $r_id>0}}---{{elseif $d.reward_cancel_date=="0000-00-00"}}���P�L{{else}}{{$d.reward_cancel_date}}{{/if}}</td>
<td align="left">
<a href="reward_one.php?sel_year={{$sel_year}}&sel_seme={{$sel_seme}}&reward_id={{$d.reward_id}}&act=edit"><img src="images/edit.png" border="0" alt="�ק�"></a>
<input type="image" src="images/del.png" onClick="del('{{$d.reward_id}}','{{$sel_year}}','{{$sel_seme}}');" alt="�R��">
<a href="reward_rep.php?stud_id={{$smarty.post.stud_id}}&reward_id={{$d.reward_id}}&oo_path={{if $r_id>0}}good{{else}}bad{{/if}}"><img src="images/print.png" border="0" alt="�C�L�q����"></a>
</td>
</tr>
{{/foreach}}
{{/if}}
</form>
</table>
</tr></table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
