<?php
//$Id: module-upgrade.php 6737 2012-04-06 12:25:56Z hami $

if(!$CONN){
        echo "go away !!";
        exit;
}
// reward_reason�Mreward_base ����ݩʬ�text

$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

//�H�W�O�d--------------------------------------------------------
//�ק��ƪ�A�W�[�����ʧO�s�Z�ﶵ

?>