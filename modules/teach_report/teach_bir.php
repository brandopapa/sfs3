<?php

	// $Id: teach_bir.php 5310 2009-01-10 07:57:56Z hami $
	//�쪩�@�̡Gchi 2004/03/08
	//���J�]�w��
	include "config.php";
  include "../../include/sfs_case_PLlib.php";

	// --�{�� session
	sfs_check();
	//����ʧ@�P�_
	//�q�X����
	head("��¾������جP");
	$tool_bar=&make_menu($school_menu_p);
	echo $tool_bar;
	($_GET[mon]=='' )?$m=date("n"):$m=$_GET[mon];
	if ($m>12) $m-=12 ;
	if ($m<=0) $m= 12 ;
	echo "[<A HREF='$PHP_SELF?mon=".($m-1)."'>�W�Ӥ�</A>|";
	echo "<A HREF='$PHP_SELF?mon=".date("n")."'>����</A>|";
	echo "<A HREF='$PHP_SELF?mon=".($m+1)."'>�U�Ӥ�</A>]<BR><BR>";
  echo "$m ��جP<br>" ; 
	$SQL="select name , birthday from teacher_base where MONTH(birthday)=$m  and teach_condition=0 order by DAYOFMONTH(birthday) "; 
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	for($i=0; $i<$rs->RecordCount(); $i++) {
		echo $arr[$i][name]." (".Getday($arr[$i][birthday])."��)<BR>";
	}

	foot();
?>
