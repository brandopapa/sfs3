<?php
// $Id: test.php 5310 2009-01-10 07:57:56Z hami $
/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";

//�ϥΪ̻{��
sfs_check();

//�{�����Y
head("���Z�C��");

print_menu($menu_p);

//�]�w�D������ܰϪ��I���C��
echo "<table border=0 cellspacing=0 cellpadding=2 width=100% bgcolor=#cccccc>
<tr><td bgcolor='#FFFFFF'>";

//�������e�иm�󦹳B
echo "<table>
        <tr bgcolor='#FBFBC4'><td><img src='images/filefind.png' width=16 height=16 hspace=3 border=0>���ɦ��Z��������</td></tr>
	    <tr><td style='line-height: 150%;'>
            <ol>
            <li>���ɦ��Z�|�̷ӵn�J�b�����Ѯv�ҥ��ХB�����Ҹժ���ئC�X��洣�ѿ�ܡC</li>
            <li>�I��A�ҭn�޲z���Z�ŻP��ءA�{���|�ߧY�P�_�ثe�A�i��ҭn�޲z�����q���Z�A�Y�O���X�ݨD�A�Ъ�����ܧA�ҭn�޲z���q���Z�C</li>
            <li>�n�s�W�@�������ɦ��Z�A�Ы�<span class='like_button'>�s�W�@�����ɦҦ��Z</span>�A�{���|�۰ʩR�W�A��M�A�]�i�H�ק復�C</li>
            <li>�n��J���Z�Ы�<img src=images/pen.png>�A��J���@�������Z�Ы��x�s�A������t�@�������Z</li>
            <li>�n�R���Ӧ����Z�Ы�<img src=images/del.png>�A�άO�N�[�v�]��0</li>
            <li>�[�v�ƹw�]��1�A�A�]�i�H�ۦ�ק�A�H�W��Ӧ��Ҹժ��񭫡C</li>
            <li>��<span class='like_button'>�x�s</span>�N���ɦ��Z�s�ɡC</li>
            <li>��<span class='like_button'>�ר�Ǵ����Z</span>�N���ɦ��Z�g�J�Ǵ����Z��ƪ�A�`�N�I�z�즳�Ӭ쪺���ɦ��Z�|�Q�мg�C</li>
            </ol>
            </td></tr>
            <tr><td></td></tr>
      </table>";        
echo "<table>
        <tr bgcolor='#FBFBC4'><td><img src='images/filefind.png' width=16 height=16 hspace=3 border=0>�޲z�Ǵ����Z��������</td></tr>
	    <tr><td style='line-height: 150%;'>
            <ol>
            <li>�{���|�̷ӵn�J�b�����Ѯv�ҥ��ХB�����Ҹժ���ئC�X��洣�ѿ�ܡC</li>
            <li>�I��A�ҭn�޲z�����</li>
            <li>�n��J���Z�Ы�<img src=images/pen.png>�A��J���@�������Z�Ы��x�s�A������t�@�������Z</li>
            <li>�n�R���Ӧ����Z�Ы�<img src=images/del.png></li>
            <li>��<span class='like_button'>�x�s</span>�N�Ӷ��q�����Z�s�ɡC</li>
            <li>��<span class='like_button'>�ר�аȳB</span>�A�N�Ӷ��q�����Z�e��аȳB�A�w�g�e��аȳB�����Z�N�����\�b���ƶǰe�A�Y�T��ݭn�ק�w�g�e��аȳB�����Z�A�����боǲժ��άO���v�����H�N�v�����}�A�l�i���Ǥ@���C</li>
            </ol>
            </td></tr>
            <tr><td></td></tr>
      </table>";
if ($is_print=="y") {
echo "<table>
        <tr bgcolor='#FBFBC4'><td><img src='images/filefind.png' width=16 height=16 hspace=3 border=0>��ܾǴ����Z��������</td></tr>
	    <tr><td style='line-height: 150%;'>
            <ol>
            <li>�I��A�ҭn�[�ݪ����Z</li>
            <li>�{���|��ܥثe�|���ǰe��аȳB�����Z�M���Z���G��ѦѮv�Ѧ�</li>
            <li>���T�����Z�H�ר�аȳB�����ǡI</li>
            </ol>
            </td></tr>
            <tr><td></td></tr>
      </table>";
}
//�����D������ܰ�
echo "</td>";
echo "</tr>";
echo "</table>";

//�{���ɧ�
foot();
?>
