<?php

//$Id: module-cfg.php 6207 2010-10-05 04:46:46Z infodaes $

$MODULE_TABLE_NAME[1]="equ_board";
$MODULE_TABLE_NAME[2]="equ_equipments";
$MODULE_TABLE_NAME[3]="equ_record";
$MODULE_TABLE_NAME[4]="equ_request";
//

$MODULE_PRO_KIND_NAME = "���~�ɥκ޲z";


// �Ҳճ̫��s����
$MODULE_UPDATE_VER="1.0.0";

// �Ҳճ̫��s���
$MODULE_UPDATE="2007-10-8";


//�ؿ����{��
$MENU_P = array("item.php"=>"�g�ު��~���@","issue.php"=>"�t�o�n��","allow.php"=>"�ӽЮ֥�","barcode_lend.php"=>"����n��","maintain.php"=>"�ɥά������@","barcode_refund.php"=>"�k�ٵn��","message.php"=>"�T�����i","mail.php"=>"�l��q��","report.php"=>"�έp���R","barcode_crash.php"=>"���~���o","consign.php"=>"�޲z����");

//---------------------------------------------------
$IS_MODULE_ARR = array("Y"=>"�O",""=>"�_");
$import_ARR = array("I"=>"�s�W�Ҧ�(INSERT)","R"=>"�����Ҧ�(REPLACE)");

$SFS_MODULE_SETUP[] =array('var'=>"Import_Type", 'msg'=>"�פJ�Ҧ�?", 'value'=>$import_ARR);
$SFS_MODULE_SETUP[] =array('var'=>"User_Removable", 'msg'=>"�޲z�̥i�M���ӽ�?", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[] =array('var'=>"Barcode_Font", 'msg'=>"���X�r���W��?", 'value'=>'IDAutomationHC39M');
$SFS_MODULE_SETUP[] =array('var'=>"Footer", 'msg'=>"�ɥγ橳�����O?", 'value'=>'�ɥΤH�G�@�@�@�@�@�@�@�@�޲z�H�G�@�@�@�@ �@�@�@�@�ժ��G�@�@�@ �@�@�@�@�D���G�@�@�@�@�@�@�@�@�@');

$SFS_MODULE_SETUP[] =array('var'=>"Table_width", 'msg'=>"�M������ڵe���e�פ��(%)", 'value'=>'100');
$SFS_MODULE_SETUP[] =array('var'=>"Tr_BGColor", 'msg'=>"���D�C����", 'value'=>'#C8FFAA');
$SFS_MODULE_SETUP[] =array('var'=>"Lendable_BGColor", 'msg'=>"�i�ɥΪ��~����", 'value'=>'#FFFFFF');
$SFS_MODULE_SETUP[] =array('var'=>"Requested_BGColor", 'msg'=>"�w�w�ɪ��~����", 'value'=>'#CCFFCC');
$SFS_MODULE_SETUP[] =array('var'=>"NotReturned_BGColor", 'msg'=>"�w�ɥX���~����", 'value'=>'#AAAAAA');
$SFS_MODULE_SETUP[] =array('var'=>"OverTime_BGColor", 'msg'=>"�O�����k�٪��~����", 'value'=>'#FFAAAA');
$SFS_MODULE_SETUP[] =array('var'=>"Returned_BGColor", 'msg'=>"�w�k�٪��~����", 'value'=>'#AAAAAA');
$SFS_MODULE_SETUP[] =array('var'=>"Crashed_BGColor", 'msg'=>"�w���o���~����", 'value'=>'#333333');

$SFS_MODULE_SETUP[] =array('var'=>"SMTP_Server", 'msg'=>"���ٶl��H�H�D��", 'value'=>'');
$SFS_MODULE_SETUP[] =array('var'=>"SMTP_Port", 'msg'=>"���ٶl��H�H�D��", 'value'=>'25');
$SFS_MODULE_SETUP[] =array('var'=>"Title", 'msg'=>"���ٶl��w�]�D��", 'value'=>'�Ӧ۾Ǯ�SFS3�ǰȨt�Ϊ����~�ɥΰT��....');
$SFS_MODULE_SETUP[] =array('var'=>"Content_Head", 'msg'=>"���ٶl�󤺤���Y�q����", 'value'=>'�˷R�� {{borrower}} �g');
$SFS_MODULE_SETUP[] =array('var'=>"Content_Body", 'msg'=>"���ٶl��w�]�D��", 'value'=>'�@�@�U�������~�ɥθ�T,�бz�Ѹ�!\r\n�Y�ɥΪ��~�w�L�ɥδ���,�q�дf�����t��z�k�٤��򬰲�!\r\n{{content}}');
$SFS_MODULE_SETUP[] =array('var'=>"Content_Foot", 'msg'=>"���ٶl�󤺤嵲���q����", 'value'=>'{{manager}} �Ա�');
$SFS_MODULE_SETUP[] =array('var'=>"Reply", 'msg'=>"���ٶl��n�D�^��", 'value'=>$IS_MODULE_ARR);
$SFS_MODULE_SETUP[] =array('var'=>"Cc_Send", 'msg'=>"���ٶl��H�e�ƥ����޲z��", 'value'=>$IS_MODULE_ARR);

$SFS_MODULE_SETUP[] =array('var'=>"Cur_BGColor", 'msg'=>"�ثe��ܪ����i����", 'value'=>'#FFFFFF');
$SFS_MODULE_SETUP[] =array('var'=>"Pre_BGColor", 'msg'=>"�w�p�W�[�����i����", 'value'=>'#FFCCCC');
$SFS_MODULE_SETUP[] =array('var'=>"Aft_BGColor", 'msg'=>"�L�������i����", 'value'=>'#CCCCCC');
$SFS_MODULE_SETUP[] =array('var'=>"Over_Days", 'msg'=>"�O�����k���i���", 'value'=>'30');
$SFS_MODULE_SETUP[] =array('var'=>"Over_Title", 'msg'=>"�O�����k���i�D��", 'value'=>'[�p�H�T��]�z���ɥΪ��~�O�����k��, �о��t�V���~�޲z�̿�z�k�٤���!!');
$SFS_MODULE_SETUP[] =array('var'=>"Over_Content", 'msg'=>"�O�����k���i����", 'value'=>'������T�ЦܾǮժ�SFS�ǰȨt�άd��!!');

$SFS_MODULE_SETUP[] =array('var'=>"Cols", 'msg'=>"���檫�~���O������", 'value'=>'5');

$SFS_MODULE_SETUP[] =array('var'=>"Label_Cols", 'msg'=>"���~���X���", 'value'=>'3');
$SFS_MODULE_SETUP[] =array('var'=>"Pic_Width", 'msg'=>"�Ϥ���ܵ����e��", 'value'=>'320');
$SFS_MODULE_SETUP[] =array('var'=>"Pic_Height", 'msg'=>"�Ϥ���ܵ�������", 'value'=>'240');

//$SFS_MODULE_SETUP[] =array('var'=>"Refused_Reason", 'msg'=>"�ڵ��~�ɭ�]�ﶵ", 'value'=>'���פ�,���O�����k,�t���L��,�����L��');
//$SFS_MODULE_SETUP[] =array('var'=>"Refused_Reason", 'msg'=>"�~�ɥӽЪ��A�ﶵ", 'value'=>'�ݮ�,�ʥ]��z��,�̳���');

$SFS_MODULE_SETUP[] =array('var'=>"remove_sfs3head", 'msg'=>"��ܮɲ���sfs3���Y�Ч�?",'value'=>$IS_MODULE_ARR);



?>
