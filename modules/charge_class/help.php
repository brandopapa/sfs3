<?php

// $Id: help.php 5310 2009-01-10 07:57:56Z hami $



include "config.php";

sfs_check();



//�q�X����
head("���O�޲z(�ɮv��)");



//��V������

$linkstr="item_id=$item_id";

echo print_menu($MENU_P,$linkstr);



$help_doc="<font color='#FF0000'>�ϥΥ��Ҳիe �Х��w�� [���O�޲z(charge)]�Ҳ�~~~~~~</font>
    <table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#008000' width='100%'><tr>
    <td width='5%' align='center' bgcolor='#CCFF99' height='22'>NO.</td>
    <td width='1%' align='center' bgcolor='#CCFF99' height='22'>���O</td>
    <td width='14%' align='center' bgcolor='#CCFF99' height='22'>�s������</td>
    <td width='5%' align='center' bgcolor='#CCFF99' height='22'>�ɮv��</td>
    <td width='6%' align='center' bgcolor='#CCFF99' height='22'>��F��</td>
    <td width='20%' align='center' bgcolor='#CCFF99' height='22'>�ɮצW��</td>
    <td width='62%' align='center' bgcolor='#CCFF99' height='22'>����</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>1</td>
    <td width='6%' align='center' height='16'>����</td>
    <td width='14%' align='center' height='16'>�Ҳջ���</td>
    <td width='5%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>help.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�z�ثe�Ҩ����e��</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>2</td>
    <td width='6%' align='center' height='64' rowspan='4'>�]�w</td>
    <td width='14%' align='center' height='16'>���س]�w</td>
    <td width='5%' align='center' height='16'></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>item.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�]�w���O����</p>
    <p style='margin-top: 0; margin-bottom: 0'>�]�A[���O]<span style='font-family: �s�ө���'>�B</span>[���ئW��]<span style='font-family: �s�ө���'>�B</span>[�޲z�Ƶ�]<span style='font-family: �s�ө���'>�B</span>[���O���]<span style='font-family: �s�ө���'>�B</span>[�̾�]<span style='font-family: �s�ө���'>�B</span>[ú�ڤ覡]<span style='font-family: �s�ө���'>�B</span>[��ڪ��O]</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>3</td>
    <td width='14%' align='center' height='16'>�ӥس]�w</td>
    <td width='5%' align='center' height='16'></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>detail.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�]�w�������O���ӥ�</p>
    <p style='margin-top: 0; margin-bottom: 0'>�]�w�ɻݦҼ{���O��i�e�Ƕ���</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>4</td>
    <td width='14%' align='center' height='16'>���O�W��</td>
    <td width='5%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>list.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�]�w�ѥ[�������O���ǥͦW��</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>5</td>
    <td width='14%' align='center' height='16'>��K�]�w</td>
    <td width='5%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>decrease.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�]�w�ѥ[�������O���ǥ�&quot;�ӥش�K&quot;�W��</p>
    <p style='margin-top: 0; margin-bottom: 0'>�i��ܳ]�w��@�ǥͩΨ̷Ӿǥͨ������O�}�C�W��</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>6</td>
    <td width='6%' align='center' height='16'>���</td>
    <td width='14%' align='center' height='16'>���O�q��</td>
    <td width='5%' align='center' height='16'></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>announce.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�C�L���O���</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>7</td>
    <td width='6%' align='center' height='48' rowspan='3'>�޲z</td>
    <td width='14%' align='center' height='16'>ú�ڵn��</td>
    <td width='5%' align='center' height='16'></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>received.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�H�ƹ��I��覡�]�wú�ڪ̻Pú�ڪ��B</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>8</td>
    <td width='14%' align='center' height='16'>���X���ڵn��</td>
    <td width='5%' align='center' height='16'></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>barcode.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�H���X���]�wú��</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>9</td>
    <td width='14%' align='center' height='16'>�������@</td>
    <td width='5%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>record.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�ק�ΧR���Y�ǥͪ��Y���O���ج���</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>10</td>
    <td width='6%' align='center' height='48' rowspan='3'>����</td>
    <td width='14%' align='center' height='16'>��ú�M�U</td>
    <td width='5%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>hie.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>��ܩ|��ú�M�ǥͦW��</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>11</td>
    <td width='14%' align='center' height='16'>�Z�Ųέp</td>
    <td width='5%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>class_summary.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>��ܯZ�Ŧ��O����</p>
    <p style='margin-top: 0; margin-bottom: 0'>�]�A[�����H�ƻP���B][��K�H�ƻP���B][ú�ڤH�ƻP���B]</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>12</td>
    <td width='14%' align='center' height='16'>�ӥزέp</td>
    <td width='5%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>detail_summary.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>���~�Ť����C�ܲӥ������ڱ���</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>13</td>
    <td width='6%' align='center' height='32' rowspan='2'>�ؿ�</td>
    <td width='14%' align='center' height='32' rowspan='2'>---</td>
    <td width='5%' align='center' height='16'></td>
    <td width='6%' align='center' height='32' rowspan='2'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>/ooo</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>���O��ڸm��ؿ�</p>
    <p style='margin-top: 0; margin-bottom: 0'>���w�� [A4�|�p<span style='font-family: �s�ө���'>]�B[</span>B5�T�p<span style='font-family: �s�ө���'>]�B[</span>A5�G�p<span style='font-family: �s�ө���'>]�B[</span>���@�M�b�e����] 
    �|�خ榡</p>
    <p style='margin-top: 0; margin-bottom: 0'>�i�N�ۦ�s�w�������i��</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>14</td>
    <td width='5%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>/images</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�����s���ϧθm��ؿ�</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>15</td>
    <td width='6%' align='center' height='16'>��L</td>
    <td width='14%' align='center' height='16'>---</td>
    <td width='5%' align='center' height='16'></td>
    <td width='6%' align='center' height='16'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>IDAutomationHC39M_Free.ttf</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�K�O���X�r��</p>
    <p style='margin-top: 0; margin-bottom: 0'>�ާ@�ݹq�����w�˥H�K���������T��ܤΦC�L���X</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>16</td>
    <td width='6%' align='center' height='64' rowspan='3'>�Ҳ�</td>
    <td width='14%' align='center' height='48' rowspan='3'>---</td>
    <td width='5%' align='center' height='48' rowspan='3'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='6%' align='center' height='48' rowspan='3'>
    <span style='font-size: 12.0pt; font-family: �s�ө���'>��</span></td>
    <td width='24%' align='center' height='16'>index.php</td>
    <td width='44%' height='16'>�Ҳդ��w������</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>17</td>
    <td width='24%' align='center' height='16'>config.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�ҲդޤJ��</td>
  </tr>
  <tr>
    <td width='5%' align='center' height='16'>18</td>
    <td width='24%' align='center' height='16'>module-cfg.php</td>
    <td width='44%' height='16'>
    <p style='margin-top: 0; margin-bottom: 0'>�Ҳթw�q��(�ϥΪ���ƪ�<span style='font-family: �s�ө���'>�B</span>���w�t���ܼ�<span style='font-family: �s�ө���'>�B���w�q</span>...)</td>
  </tr>
</table>
<p style='margin-top: 0; margin-bottom: 0'>�@</p>
<p style='margin-top: 0; margin-bottom: 0'><font color='#0000FF'>
<span style='font-size: 12.0pt; font-family: �s�ө���'>��</span>�ϥΨB�J<span style='font-family: �s�ө���'>�G</span></font></p>
<p style='margin-top: 0; margin-bottom: 0'><font color='#0000FF'>
<span style='font-family: �s�ө���'>�@Step 1. &gt;&gt; �]�w [����]�G��&nbsp; (1)�ƻs�\��G�i�۾��~��ƽƻs�L��&nbsp; 
(2)�榡�s�W�\��G�̷ӯS�w�榡�@�����Ͷ��ػP�ӥ�</span></font></p>
<p style='margin-top: 0; margin-bottom: 0'><font color='#0000FF'>
<span style='font-family: �s�ө���'>�@Step 2. &gt;&gt; �]�w [�ӥ�]�G(1)</span>�Ƨ�<span style='font-family: �s�ө���'>�欰�D�����ơ@(2)</span>�������B(�ХH,���j�U�~��)�A�H�Q�{���P�_</font></p>
<p style='margin-top: 0; margin-bottom: 0'><font color='#0000FF'>
<span style='font-family: �s�ө���'>�@Step 3. &gt;&gt; �]�w [���O�W��]�G�i�}�C[��@�ǥ�]�B[�Z��]�B[���~��]�W��</span></font></p>
<p style='margin-top: 0; margin-bottom: 0'><font color='#0000FF'>
<span style='font-family: �s�ө���'>�@Step 4. &gt;&gt; 
�]�w [��K�W��]�G�]�w�Y�@�ӥ�[��@�ǥ�]��[�Y���O�ǥ�]��&quot;��K�ʤ���&quot;��</span></font></p>
<p style='margin-top: 0; margin-bottom: 0'><font color='#0000FF'>
<span style='font-family: �s�ө���'>�@Step 5. &gt;&gt; </span><font face='�s�ө���'>�C�L [���O�q��]</font><span style='font-family: �s�ө���'>�G��ܾǥͻP���O��榡�Უ��OpenOffice�ɮץH�ѦC�L</span></font></p>
<p style='margin-top: 0; margin-bottom: 0'>�@</p>
<p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000'><span style='font-size: 12.0pt; font-family: �s�ө���'>��</span>PS. 
�ɮv������\��G</font></p>

<p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000'>�@1.�L�k��ܾǴ�</font></p>

<p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000'>�@2.�u��ާ@���ЯZ��</font></p>

<p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000'>
�@3.�ާ@���ط|�����O[�_�l��]�P[������]����</font></p>

<p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000'>�@4.�L�k�}�C���ػP�ӥ�</font></p>

<p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000'>�@5.�L�k�L�s���O���</font></p>

<p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000'>
�@6.��L�\����t�κ޲z���}�һP�_

<BR><BR><BR>���t�Τ��R�P�{���]�p�Ginfodaes   2006/8/3

";

echo $help_doc;

foot();

?>