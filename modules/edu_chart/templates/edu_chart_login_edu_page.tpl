{{* $Id: edu_chart_login_edu_page.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}

<script>
<!--
function fill_data() {
{{if $smarty.post.chart_no==2}}
	parent.main.document.Form1.getElementById('TbM11').value=50;
{{/if}}
}
function change_window()
{
	parent.main.window.location.replace('login_edu_chart.php?url={{$replace_url}}');
}
//-->
</script>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	<form name ="base_form" enctype="multipart/form-data" action="{{$smarty.server.PHP_SELF}}" method="post">
    <td width="100%" valign=top bgcolor="#CCCCCC">
		<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			<tr>
				<td class="title_sbody1">�п�ܪ�O</td>
				<td>{{$chart_sel}}</td>
			</tr>
			<tr>
				<td width="100%" align="center" colspan="2" >
				<input type="button" name="do_key" value =" ��J��� " OnClick="javascript:fill_data();"> <input type="button" name="return" value=" ��^�ǰȨt�� " OnClick="window.open('index.php','_top')"></td>
			</tr>
		</table>
	</tr>
	</form>
</table>
{{if $smarty.post.data_id=="" || $smarty.post.data_id==0}}
<table>
<tr bgcolor='#FBFBC4'><td><img src="{{$SFS_PATH_HTML}}/images/filefind.png" width="16" height="16" hspace="3" border="0">��������</td></tr>
<tr><td style="line-height: 150%;">
<ol>
<li class="small">�п�ܱz�ҭn����������u��J��ơv�C</a></li>
</ol>
</td></tr>
</table>
{{/if}}

</body>
{{if $smarty.post.chart_no!=""}}
<body OnLoad="javascript:change_window();">
</body>
{{/if}}
