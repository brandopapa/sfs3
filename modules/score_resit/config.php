<?php
// $Id: board_config.php 7779 2013-11-20 16:09:00Z smallduh $
/* �ǰȨt�γ]�w�� */
require_once "../../include/config.php";

/* �ǰȨt�Ψ禡�w */

include "module-upgrade.php";

include_once "../../include/sfs_case_score.php";
include_once "./module-cfg.php";

include_once "my_functions.php";

//��p�ΰꤤ, �Ω���̪ܳ�N�Ǧ~��
$CY_step=($IS_JHORES==6)?2:5;

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();
$curr_year_seme=$curr_year.$curr_seme;


?>
