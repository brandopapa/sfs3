<?php
//$Id: config.php 6064 2010-08-31 12:26:33Z infodaes $
//�w�]���ޤJ�ɡA���i�����C
include_once "../../include/config.php";
require_once "./module-cfg.php";
require_once "./module-upgrade.php";

//�z�i�H�ۤv�[�J�ޤJ��

$detail_types=array(""=>"�Ǯ�","1"=>"�X�@��","2"=>"�N��");

//���o�ҲհѼƪ����O�]�w
$m_arr = &get_module_setup("charge");
extract($m_arr,EXTR_OVERWRITE);

//�w�]��
if(! $m_arr['detail_types']) $m_arr['detail_types']='�Ǯդ��w,�X�@��';
if(! $m_arr['detail_lists']) $m_arr['detail_lists']='10,10';

$detail_types=explode(',',$m_arr['detail_types']);
$detail_lists=explode(',',$m_arr['detail_lists']);

?>
