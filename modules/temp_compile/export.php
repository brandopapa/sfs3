<?php

// $Id:$

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";

//�ϥΪ̻{��
sfs_check();

require_once "../../include/sfs_case_excel.php";
$x=new sfs_xls();
$x->setUTF8();
$x->addSheet('Sheet1');
$x->setRowText(array('�m�W','�����Ҹ�'));

$sql="select * from new_stud where class_year='".($IS_JHORES+1)."' and stud_study_year='".(curr_year()+1)."' order by temp_id";
$rs=$CONN->Execute($sql) or die($sql);
while(!$rs->EOF){
	$temp_arr[] = array($rs->fields['stud_name'],$rs->fields['stud_person_id']);
        $rs->MoveNext();
}
$x->items=$temp_arr;
$x->writeSheet();
$x->process();
exit;
