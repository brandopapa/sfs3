<?php
//$Id: config.php 5310 2009-01-10 07:57:56Z hami $
//�w�]���ޤJ�ɡA���i�����C
require_once"./module-cfg.php";
include_once"../../include/config.php";
//���o�ҲհѼƪ����O�]�w
$m_arr=&get_module_setup("rent");
extract($m_arr,EXTR_OVERWRITE);
$borrower_type=array("public"=>"��","private"=>"�p","special"=>"�S");
$c_day=array('�@','�G','�T','�|','��','��','��');
?>