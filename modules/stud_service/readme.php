<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();
?>
<script type="text/javascript" src="./include/functions.js"></script>
<script type="text/javascript" src="./include/JSCal2-1.9/src/js/jscal2.js"></script>
<script type="text/javascript" src="./include/JSCal2-1.9/src/js/lang/b5.js"></script>
<link type="text/css" rel="stylesheet" href="./include/JSCal2-1.9/src/css/jscal2.css">

<?php

//�q�X����
head("�ӤH�A�Ⱦǲߵn�O");

$tool_bar=&make_menu($school_menu_p);

//Ū���A�����O $ITEM[0],$ITEM[1].....
$M_SETUP=get_module_setup('stud_service');
$ITEM=explode(",",$M_SETUP['item']);

//�C�X���
echo $tool_bar;

echo "
<br>
�A�Ⱦǲ߼Ҳըϥλ���:<br>

1.��J�ǥͪA�Ⱦǲ߮ɼ� <br>
  (1)�@��Юv�M�޲z���ҥi���ǥ͵n���A�Ȼ{��. <br>
  (2)��J�A�Ⱦǲ߬�������:<br>
  ���s���� <br>
  �B�J1:��J�A�Ȥ���B�A�ȳ��B�A�������B�A�Ȥ��e<br>
  �B�J2:���U�Ԧ����, �Ш̪A�Ȥ����ܾA��Ǵ����Z�žǥ�, �b�ǥ����J�A�Ȥ�����, �Y���S�O�ݵ����Ӷ�, �Цb�ӥͪ����O���J���O���e�C<br>
  ���¦����A�Ȭ���, �W�[�ǥͩΦ����ǥ� (�u��ɵn���Ǵ��O��)<br>
  �B�J1:�I��e���k��w�s�b������ , �t�ΦC�X�w�n�����A�Ȫ��ǥͦW��.<br>
  �B�J2:�p�G���A�ȶ��حn�ɵn�ǥ�, �Ы��U�Ԧ����, ��ܯZ��, �äĿ�ǥ�, �b�ǥ����J�A�Ȥ�����,�Y���S�O�ݵ����Ӷ�, �Цb�ӥͪ����O���J���O���e�C<br>
  �B�J3:�p�G���A�ȶ��ذO�����ǥͦ��~, �n�R��, �����I��ӥͪ� x �Ÿ�. <br>
  �B�J4:�p�G���A�ȶ��ذO�����ǥ͵n�������Ʀ��~, �ФĿ�ӥ�, �ë��U [�վ�Ŀ�ǥͪ��A�Ȯɶ�]�H�i����.<br>
 ";
 
 ?>