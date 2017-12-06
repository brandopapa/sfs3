<?php

// $Id: disease.php 5666 2009-09-23 15:24:24Z brucelyc $

// 取得設定檔
include "config.php";
include "../health/class.health.php";
include_once "../../include/sfs_case_dataarray.php";

sfs_check();

$health_data=new health_chart();
$health_data->get_stud_base(curr_year(),curr_seme(),$class_num);
$health_data->get_disease();

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","班級學生疾病史");
$smarty->assign("SFS_MENU",$menu_p);
$smarty->assign("year_seme",sprintf("%03d",curr_year()).curr_seme());
$smarty->assign("disease_kind_arr",hDiseaseKind());
$smarty->assign("health_data",$health_data);
$smarty->display("class_health_disease.tpl");
?>
