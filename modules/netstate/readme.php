<?php
include_once('config.php');
include_once('include/PHPTelnet.php');
sfs_check();


//�q�X����
head("�����޲z - ���n����");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}
?>
<table border="0">
  <tr>
   <td style="color:#FF0000">�����A�������n���A���Ҳեثe�H���ժ��[�c���լO���`�i����A�����O�ҶQ�ժ������[�c�i�A�ΡC�p�z�L�k�Ӿᨾ����]�w�W�����I�A�ФűҥΡI�I�I</td>
  </tr>
  <tr>
    <td>���U�ӡA�Y�n�������`�ҥΥ��Ҳժ��q���ЫǤW���޲z�\��A���X�I�����`�N�C</td>
  </tr>
  <tr>
   <td>1.�z�������T�{�Q�ժ�������O�̪�Ш|���ɧU�����x Fortigate 110C�A�B�ĥά[�c�p�U�ϩҥܡG<br>
  <br>
  <img src="./images/fg.png" border="0">
  <br>  ps.FG-400�i��]��ϥΡA���S��ڸչL�C<br><br>
   </td>
  </tr>

  <tr>
   <td>
    2.�q���ЫǪ��ӤH�q����IP���T�wIP�A�B��IP�|�q�L������(���׬O�u��IP�� private ip (192.168.x.x))�C�H���լ��ҡA���չq���ЫǪ�IP�ҳ]�� 192.168.2.x �A��F�������~�| NAT �ন�u��IP��~�s�u�C<br>
    3.�����𤺩|���Ұ� IP-MAC-Binding �\��A�Y IP �j MAC ���\��C�]�ѥ��ҲեN���ҰʡA�~��]�w���ŦX�ҲջݨD���\��^
    <br>
   </td>
  </tr>
  <tr>
    <td><br><font color=blue>���Ҳպި�q���Ыǹq����_�W���A�D�n�O�Q�� IP-MAC-Binding ��z�G</font><br><br>
    	1.�Q�ε{���N���Ұ� IP-MAC-Binding�\��(�ި�e�P)�A�ñN��]�w�� WAN1 �����C<br>
    	<br>
    	2.�z�L���覡�A�]�w�C�x�q����IP�O�_�n�g�J������ IP-MAC binding table���C�Y�n��w�Y�q������W���A�b�g�JIP�P�ɡA�]���N�w���IP�g�J�@�ӿ��~��MAC�C<br>
     <br>
      3.�ѩ� IP-MAC-Binding �O�ĥμe�P�]�w�A�ҥH������b�B�@�ɡG<br>
        (1)IP��MAC�ŦX��Ʈw����  -->���q�L <br>
        (2)IP and MAC�Ҥ��b��Ʈw�w�q������    -->���q�L <br>
        (3)�Y��IP�P��Ʈw�ۦP����MAC�P��Ʈw���P -->�T��q�L (<font color=red>�q���ЫǪ��q������W���Y�O�z�L���W�h�޲z</font>) <br>
        (4)�YMAC�P��Ʈw�ۦP����IP�P��Ʈw���P�@--> �T��q�L	<br>
        
        <br>
        ���`�N�I�p�G�Q�ը����𦳱ҥ� DHCP �\��A��Y�q���w�Q�� DHCP���o IP , ����IP��MAC�|�Q�O���b DHCP ��address leases�A���ɭY�ӹq������LIP �N�|�L�k�W���C
         ����telnet�i�J�������A�U���O execute dhcp lease-clear ,�M��DHCP�O�d�����C
    </td>
  </tr>
  <tr>
    <td style="color:blue"><br>
     �]�w�覡�G�����I��Ҳաu������IP-MAC�\���˴��v���ҡA�̨t�ΨB�J�i��A����X�{�@�u���߱z! �z��������w���`�ҥ� IP �j MAC �\��C�v��r�C
    </td>
  </tr>
  <tr>
   <td>
  �ҲլO�H���� telnet ���覡�n�J������A�i������]�w�A�p�G�Q�`�J�F�ѡA<br>���� IP-MAC binding �������ѡA�Цۦ� <a style="color:#FF0000" href="./include/IP-MAC-Binding.txt">�U��</a> ��s�C
   </td>
  </tr>
</table>