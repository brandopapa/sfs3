<?php
// $Id: readme.php 5310 2009-01-10 07:57:56Z hami $

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";
if($_GET['class_year_b']) $class_year_b=$_GET['class_year_b'];
else $class_year_b=$_POST['class_year_b'];

//�ϥΪ̻{��
sfs_check();

//�{�����Y
head("�s�ͽs�Z");

print_menu($menu_p);
//�]�w�D������ܰϪ��I���C��
echo "
<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc>
<tr>
<td bgcolor='#FFFFFF'>";
//�������e�иm�󦹳B

echo "<table>
        <tr bgcolor='#FBFBC4'><td><img src='images/filefind.png' width=16 height=16 hspace=3 border=0>�פJ�s�ͬ�������</td></tr>
	    <tr><td style='line-height: 150%;'>
            <ol>
            <li>��ܱz�ҭn�פJ���~�šC</li>
			<li>���s����ܱz�ҭn�פJ���ɮסC</li>
            <li>�ɮת��榡�аѷ�<a  href='newstud.csv'>newstud.csv</a></li>
			<li>�̫�A���y�妸�إ߸�ơz�I</li>
            </ol>
            </td></tr>
            <tr><td></td></tr>
      </table>";        
echo "<table>
        <tr bgcolor='#FBFBC4'><td><img src='images/filefind.png' width=16 height=16 hspace=3 border=0>�޲z�s�ͬ�������</td></tr>
	    <tr><td style='line-height: 150%;'>
            <ol>
			<li>������ܦ~�ũM�u�@����</li>
			<li>�u�@���ئ��y�s�Ͱ򥻸�ơz�A�y�O�_�NŪ���աz�A�y���Z��J�z�A�y�վ�s�Z�z���|���C</li>
			<li>��פJ���s�͸�ơA��ĳ�����y�O�_�NŪ���աz�T�{�C</li>
			<li>���Z��J�A�O���ѵ����ݭn�̦��Z�ӧ@���۰ʽs�Z�̾ڪ��Ǯիإߦ��Z�Ϊ��A�ä��@�w��J�C</li>
			</ol>
            </td></tr>
            <tr><td></td></tr>
      </table>";
echo "<table>
        <tr bgcolor='#FBFBC4'><td><img src='images/filefind.png' width=16 height=16 hspace=3 border=0>�۰ʽs�Z��������</td></tr>
	    <tr><td style='line-height: 150%;'>
            <ol>
			<li>������ܯZ�ũM�s�Z�̾�</li>
			<li>�b�Z�s����J�C�@�Z�s���Z�żơA��M�z�]�i�H�u���@�ӯZ�s�C�Y�z�ݭn�@�Y�ǯS��]�N�O�z��~�諸�s�Z�̾ڡ^�ӱN�Ӧ~�Ť��s�A�N�i�H��Z�s��찵�]�w</li>
			<li>�]�w�Ǹ���h�A�ثe�u���ѤJ�Ǧ~�צb�[�W�z�ۭq����ơA�p�z�ۭq��Ƭ�4���ܡA�h�Ǹ��N�O920001,920002,920003......</li>
			<li>�п�ܾǸ��ƧǪ��̾�</li>
			<li>�̫�Ы��y�}�l�s�Z�z���s</li>
			<li>�{���|�i��۰ʽs�Z�A�ä����ܡy�վ�s�Z�e���z���z�i�H�ߧY�h���s�Z���ץ�</li>						
            </ol>
            </td></tr>
            <tr><td></td></tr>
      </table>";
echo "<table>
        <tr bgcolor='#FBFBC4'><td><img src='images/filefind.png' width=16 height=16 hspace=3 border=0>�g�J���y��ƪ��������</td></tr>
	    <tr><td style='line-height: 150%;'>
            <ol>
			<li>������ܦ~��</li>
			<li>�A���y�g�J�������y��ƪ�z�A�Y�i</li>						
            </ol>
            </td></tr>
            <tr><td></td></tr>
      </table>";	  	  
echo "<table>
        <tr bgcolor='#FBFBC4'><td><img src='images/filefind.png' width=16 height=16 hspace=3 border=0>����C�L��������</td></tr>
	    <tr><td style='line-height: 150%;'>
            <ol>
			<li>�Хѥ������ܾǦ~�שM�Z��</li>
			<li>���ɥ���e���|�X�ӯZ���s�ͦW�U�A���W�観�y�U��SXW�ɡz�s���A�����Y�i�U���ӯZ���s�ͦW�U�A�A�Hopenofficec��writer�}�ҧY�i�I</li>						
            </ol>
            </td></tr>
            <tr><td></td></tr>
      </table>";	  	  
//�����D������ܰ�
echo "</td>";
echo "</tr>";
echo "</table>";

//�{���ɧ�
foot();
?>
