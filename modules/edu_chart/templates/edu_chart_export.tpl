{{* $Id: edu_chart_export.tpl 6590 2011-10-18 07:07:27Z infodaes $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	<form name ="base_form" action="{{$smarty.server.PHP_SELF}}" method="post" >
    <td width="100%" valign=top bgcolor="#CCCCCC">
		<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
			<tr>
				<td class="title_mbody" colspan="2" align="center" >�ɮפU��</td>
			</tr>
			<tr>
				<td class="title_sbody1">��ܤU�����</td>
				<td>{{$data_sel}} <input type='checkbox' name='blank_name' value='Y' checked>�M�ũm�W <input type='checkbox' name='quoted' value='Y'>���޸��]��</td>
			</tr>
			<tr>
				<td width="100%" align="center" colspan="2" >
					<input type=submit name="do_key" value =" �T�w�U�� ">
					{{if !$OK1 || !$OK2}}<input type="button" name="do_key" value =" ���W���ɮ� " OnClick="this.form.action='import.php';this.form.submit();">{{/if}}
				</td>
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
<li class="small">�ǥ͵��O��ƽХѡu�ǥͰ��d��T�v�ҲնפJ�ο�J��ơC</li>
<li class="small">�U���ɮ׫e�������b�u�ǥͨ������O�P�ݩʡv�����n�u����(9)�v�Ρu�~�y�t���l�k(100)�v��ơC</a></li>
<li class="small">�Y�Q�աu�~�y�t���l�k�v���������O�N�����O100, �ЦܼҲ��ܼƤ��]�w���T�N���C</a></li>
<li class="small">�����ڧO�ж�C�b�Ĥ@���ݩ����(�ڧO), �~�y�t���l�k���˥N��O�ж�C�b�ĤG���ݩ����(���y)�C</a></li>
<li class="small">100�Ǧ~�׷s�W�G�a�x�{�p(1�X)�A1=���ˡA2=��ˡA3=�H��, ���ƨ��۾Ǵ�����-�a�x�����A�����O�h�w�]��~~1.���ˡC</a></li>
</ol>
</td></tr>
</table>
{{/if}}
{{include file="$SFS_TEMPLATE/footer.tpl"}}
