<?php

// $Id: sight.php 5626 2009-09-06 15:34:35Z brucelyc $

// ���o�]�w��
include "config.php";
include "../health/class.health.php";

sfs_check();

$health_data=new health_chart();
$health_data->get_stud_base(curr_year(),curr_seme(),$class_num);
$health_data->get_sight();

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","�Z�žǥ͵��O���p");
$smarty->assign("SFS_MENU",$menu_p);
$smarty->assign("year_seme",sprintf("%03d",curr_year()).curr_seme());
$smarty->assign("health_data",$health_data);
$smarty->display("class_health_sight.tpl");
?>