{{* $Id: check_score_error2.tpl 5874 2010-03-01 18:56:38Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<script type="text/javascript">
<!--
function chk() {
	document.getElementById('mform').action='{{$smarty.server.SCRIPT_NAME}}';
	document.menu_form.submit();
}
//-->
</script>

<form name="menu_form" id="mform" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<input type="hidden" name="step" value="{{$smarty.post.step}}">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td style="vertival-align:top;background-color:#CCCCCC;">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF" width="100%" class="main_body">
<tr><td>�Ǵ��G{{$year_seme_menu}}</td></tr>
<tr style="background-color:white;font-size:12pt;"><td>
{{if $rowdata}}
���~���Z�C��p�U�G<br><br>
{{foreach from=$rowdata item=d key=seme_class}}
{{foreach from=$d item=num key=ss_id}}
<input type="submit" name="del[{{$seme_class}}][{{$ss_id}}]" value="�R"> {{$c_arr.$seme_class}} ---&gt; {{$ss_all_arr.$ss_id}} ..... �@{{$num}}�� <span style="color:blue;font-size:10pt;">[�ҵ{�N�X:{{$ss_id}}]</span><br>
{{/foreach}}
{{/foreach}}
<br>
{{else}}
<br>���Ǵ����ˬd�X���~���Z�C<br><br>
{{/if}}
</td></tr>
{{*����*}}
<tr></td>
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;background-color:white;">
	<ol>
	<li>���{���Ψ��ˬd�������Z�������~��ơC</li>
	</ol>
</td></tr>
</table>
</td>
</tr>
</table>
</td></tr>
</table>
</form>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
