<?php
$M="
�Ҳըϥλ����G

���t�_
�Ʊ��ǥѽu�W�����H�u�@�~�ɶ��A�P�ɴ�֯ȱi�L�ꦨ���A��������O���ɤ@���ߤO�C

���ǳƤu�@
�z���F�w�˥��ҲաA�٥����w�˸ɦ���q�@�~�]makeup_exam�^�ҲաB�ξǥͽu�W����]stud_exam�^�Ҳ�

���@�~�y�{����

���B�J1�G�i�Ǵ��ɦҳ]�w�j
�T�{�{�b�n�ҥΨ��ӾǴ����ɦҡA�H�θɦҮɾǥͪ�����Ҧ��A����Ҧ��]�A�G
(1)�̸ը��]�w�G�b�ը��]�w���ɬq���~���Ӹը��i��ɦҡC
(2)�b�Y�Ӯɬq���A�ثe�W�u�ǥͥi�H�⥻�Ǧ~�Ǵ��Ҧ��L�ӸɦҪ��Ҩ��C

���B�J2�G�i�ɦҦW������@�~�j
�T�{���ǤH�ӸɦҡB�ץX�W��B�Q�� Excel �� Word �M�L�\��q���a���ξǥ͡^

���B�J3�G�i�R�D�ɦҦҨ��j
�i�H�����u�W�R�D�A�]��ЦѮv�R�n�D�A��q�l�ɪ����פJ�A
�D���@�߬��|��@������D�C
�p�G�b�B�J1������Ҧ��O��(1)�A�O�o�]�w�o���Ҩ��n�Ҫ��ɶ��C

���B�J4�G�u�W����]stud_exam�^�Ҳ�
�o�O�ǥͽu�W����M�μҲաA�Ǯեi�H�w�Ʈɶ��A�@��@��ǥͱa�i�q���Ы�
�A�����u�W����A�u�W�@���A�@���������Z���W�p��X�ӡC
�u�W����X�D�覡�̾ڸը��]�w�A�i�X�ը������D�ءA�Χ�ը����D�w�A�u�X
���w�D�ơA�X�D���D�ǱĶüƱƦC�A��ؤ]�ĶüƱƦC�C

���u�W����i��ɡG
�i�H�z�L�i�ɦҦW������@�~�j�\��A�H�ɰl�a���ɦҡB�ɦҤ��B�w�ɦҦW��C

���u�W�ɦҵ����G�i�ץX�ɦҤ��ơj
�N�U���ɦҧ������ƶץX�ܸɦ���q�@�~�]makeup_exam�^�Ҳժ���Ʈw���A
���U�ӽ����ɦ���q�@�~�]makeup_exam�^�ҲաA�Q�θӼҲաu���Z��J/���u�p��Ǵ����Z�v�\��s�J�ǥͪ����Ǵ��`���Z���C 

";

header('Content-type: text/html;charset=big5');
// $Id: index.php 5310 2009-01-10 07:57:56Z smallduh $
//���o�]�w��
include_once "config.php";
//���ҬO�_�n�J
sfs_check(); 

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

head();
//�C�X���
echo $tool_bar;

$M=preg_replace("/\n/","<br>\n",$M);

echo $M;

?>
