<?php

//$Id: up20051006.php 5310 2009-01-10 07:57:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}

//�N�X�ͦa�[�J�t�οﶵ�M��
$res=$CONN->Execute("select * from sfs_text where t_kind='birth_state'");
if ($res->RecordCount()==0) join_sfs_text(1,"birth_state",array("01"=>"�x�_��","02"=>"������","03"=>"�y����","04"=>"�򶩥�","05"=>"�x�_��","06"=>"��鿤","07"=>"�s�˿�","08"=>"�s�˥�","09"=>"�]�߿�","10"=>"�x����","11"=>"�x����","12"=>"�n�뿤","13"=>"���ƿ�","14"=>"���L��","15"=>"�Ÿq��","16"=>"�Ÿq��","17"=>"�x�n��","18"=>"�x�n��","19"=>"������","20"=>"�̪F��","21"=>"�x�F��","22"=>"�Ὤ��","23"=>"���","24"=>"������","25"=>"�s����"));
$res=$CONN->Execute("select * from sfs_text where t_name='birth_state'");
if ($res->RecordCount()!=0) $CONN->Execute("update sfs_text set t_name='�X�ͦa' where t_name='birth_state'");
?>