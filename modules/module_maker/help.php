<?php
// $Id: help.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�]�w�� */
include_once "config.php";
sfs_check();

//�q�X����
head("�Ҳղ��;�����");
echo main_form();
foot();

function main_form(){
	global $school_menu_p;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	
	$main="
	$tool_bar
	<table bgcolor='#000000' cellspacing=1 cellpadding=4>
	<tr bgcolor='white'><td>
	<h3>�S��G</h3>
	<ol>
	<li>�i�H�Y�ɲ��� SFS ���зǼҲժ����Y�ɡA���Y�ɤ��|�]�A index.php�Bmodule-cfg.php�Bmodule.sql�Bconfig.php�Bauthor.txt�BINSTALL�BNEWS�BREADME ���ɮסC
	</li><br>
	<li>���ͪ��Ҳո����Y��Y�i�b SFS3 ���ϥΡA���ݭק�]�S���Y�C</li><br>
	<li>�۰ʰ�����ƪ���ƫ��A�A�۰ʿ�ܾA�����A���~�U�ت�����i�H�ۦ�]�w�w�]�ȡB�ϥ� function�B�άO�_�n�ϥθ����C</li><br>
	<li>�Ҳմ��ѡu�����C�X�v�B�u�ק�v�B�u�R���v���򥻾ާ@�\��C</li><br>
	<li>��i�����q�u�q�������ͼҲ� �v�Ӳ��ͧ��㪺�ťռҲաA��K���Y�}�l�]�p�C</li><br>
	</ol>
	</td></tr>
	</table>
	
	<h3>�d�ҡG</h3>
	
	<table bgcolor='#000000' cellspacing=0 cellpadding=4>
	<col>
	<col>
	<tbody>
		<tr bgcolor='white'>
		<td>		
		<p>
		�����Х� phpMyAdmin �ӫإ߱z�{������ƪ�C
		</p>
		</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help01.png'><img src='images/help01_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>���]�p�n����A�Ш�uSFS3 �Ҳղ��;��v���C</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help02.png'><img src='images/help02_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>��ܱz���ۤv�}�X�Ӫ���ƪ�A�H�K�q��ƪ�ӥͥX�һݵ{���C</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help03.png'><img src='images/help03_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�o�ӨB�J�̭��n�A�M�w�z���{�����e�C
		<ul>
		<li>�u<font color='darkBlue'><b>�ϥ�</b></font>�v�G�ݦ����O�_�n�ϥΡC</li><br>
		<li>�u<font color='darkBlue'><b>���W��</b></font>�v�G��Ʈw�������W�١A���i��C</li><br>
		<li>�u<font color='darkBlue'><b>��줤��W��</b></font>�v�G�]�w�����b��椤����줤��W�١A�Y�S��h�H�^�����W�٥N���C</li><br>
		<li>�u<font color='darkBlue'><b>��ƫ��A</b></font>�v�G��ƪ�����쪺��ƫ��A�A���i��C</li><br>
		<li>�u<font color='darkBlue'><b>������</b></font>�v�G�|�۰ʿ�ܾA�X�� HTML ��櫬�A�A�i�H�ۦ�A��C</li><br>
		<li>�u<font color='darkBlue'><b>�w�]</b></font>�v�G�]�w����쪺�w�]�ȡC�i�H�ϥΤ@���r�B�ܼơ]�Ҧp teacher_sn ���@��^�A�]�i�H�ϥ� function �@���w�]�ȡ]share_sn �M adddate�A�䤤 share_sn ���@��Ϊ��O�ۭq function �A���ͫᥲ���ۦ�[�J�� function�^�A���ϥΨ�ƽбN�u��ơv���خإ��ħY�i�C</li><br>
		<li>�u<font color='darkBlue'><b>�j�p</b></font>�v�G�p�G�O�u��r��J�v���A�h�i�]�w�Ӫ�檺�j�p�C�p�G�O�u��r�϶��v�A�h�� textarea ���e�סC</li><br>
		<li>�u<font color='darkBlue'><b>�̤j��</b></font>�v�G�p�G�O�u��r��J�v���A�h�]�w�Ӫ�檺�i�H��J���̤j�ȡC�p�G�O�u��r�϶��v�A�h�� textarea �����סC</li><br>
		<li>�u<font color='darkBlue'><b>��s�B�R�����D�n���ޭȬO</b></font>�v�G �]�w�H���@�����ӧ@���ק�ΧR���ɡA�D�n���̾����A�q�`���O�H  PRIMARY ���D�C</li><br>
		<li>�u<font color='darkBlue'><b>�ɦW�G</b></font>�v�G �ӼҲժ������ɦW�A����ĳ�ק�C</li>
		</ul>
		</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help04.png'><img src='images/help04_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>��o�̡A��� index.php �ɤw�g���ͤF�A���U�ӱz������J�@�ǰ򥻸�ƥH���ͨ�L�ɮסC<br>
		�u<font color='darkBlue'><b>�Ҳդ���W�� </b></font>�v�ж�J�Ҳդ���W�١C<br>
		�u<font color='darkBlue'><b>�Ҳեؿ��W��</b></font>�v�ж�J�ӼҲխ^��W�١A���W�ٷ|�@���Ҳժ��ؿ��W�١C</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help05.png'><img src='images/help05_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>
		<ul>
		<li>�u<font color='darkBlue'><b>�Ҳե\��y�z</b></font>�v�G�o�̪��ȷ|�g�J author.txt ���C
		<li>�u<font color='darkBlue'><b>�w�˻���</b></font>�v�G�o�̪��ȷ|�g�J INSTALL ���C
		<li>�u<font color='darkBlue'><b>�\��W�׬���</b></font>�v�G�o�̪��ȷ|�g�J NEWS ���C
		<li>�u<font color='darkBlue'><b>Ū���ɮ�</b></font>�v�G�o�̪��ȷ|�g�J README ���C
		</ul>
</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help06.png'><img src='images/help06_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�e�X��K�|�U�����ɮסC</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help07.png'><img src='images/help07_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�бN�� zip ���Y�ɩ��w�Ф��A�Ϊ̪������ǰȨt�Ϊ� module �ؿ��U�A�Ѷ}�N��ΤF�C</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help08.png'><img src='images/help08_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�b Linux �U�ϥ� unzip �N���Ѷ}��ǰȨt�ε{���� /modules/ ��</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help09.png'><img src='images/help09_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>���ۡA�Ш�t�κ޲z���s�W�Ҳդ��A�����s�W���ҲաA�M��N���w�ˤW�h�N OK �F�I
		</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help10.png'><img src='images/help10_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�w�˪��Ҳդw�g�X�{�F�I</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help11.png'><img src='images/help11_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�o�O�i�h�ӼҲժ��e���A�Ҧ���槡�w�s�@�����I���W�N�i�H�ϥΡI</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help12.png'><img src='images/help12_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�ѩ��誺���]�w���A share_sn ���@��Ϊ��O�ۭq function �A�ҥH�����ۦ�ק� index.php �������� function�C�t�Τw�g�۰ʲ��ͤ@�Ӫ� function�A�u�n�N���ק�@�U�N�n�F�C�]�p�G�S���ۭq function ���N���ݭק�աI�^</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help13.png'><img src='images/help13_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�ۦ�ק� function ���e�C</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help14.png'><img src='images/help14_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>��J�@�����</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help15.png'><img src='images/help15_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>��J���G</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help16.png'><img src='images/help16_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�ק��ơ]�ϥνƿ�^�C</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help17.png'><img src='images/help17_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�קﵲ�G</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help18.png'><img src='images/help18_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
		<tr bgcolor='white'>
		<td>�R�����</td>
		</tr>
		<tr bgcolor='white'>
		<td><a href='images/help19.png'><img src='images/help19_1.png'  border=0></a><p>&nbsp;</p></td>
		</tr>
	</tbody>
	</table>	<p>
	²��a�I</p>
	";
	return $main;
}
?>
