<?php

// $Id: barcode.php 6368 2011-03-01 01:53:02Z infodaes $



include "config.php";

sfs_check();



//�q�X����

head("���O�޲z");

$linkstr="item_id=$item_id";

echo print_menu($MENU_P,$linkstr);

$barcode=str_replace("*","",$_POST[barcode]);
$paid_date=$_POST[paid_date];

if($barcode AND $_POST['act']=='�ѪR�B�z'){

	$barcode=explode("\r\n",$barcode);

	//print_r($barcode);

	$excuted="<BR>�� �e���ѪR�õn�������X�p�U��<BR><BR>";

	$counter=0;

	foreach($barcode as $value){

		//print_r($value);

		//echo "<BR>";

		if($value){

			$data_arr=explode("-",$value);

			//echo $data_arr[0]."=".$data_arr[1]."==".$data_arr[2]."<BR>";

			$sql_select="update charge_record set dollars=".$data_arr[2].",paid_date='$paid_date',comment='���X���y�n��' where item_id=".$data_arr[0]." AND record_id='".$data_arr[1]."'";

			

			//echo $sql_select."<BR><BR><BR>";

			$counter++;

			$excuted.="�@�� ($counter) $value<BR>";

			$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

		}

	}  

}

//��V������



$main="<table><form name='my_form' method='post' action='$_SERVER[PHP_SELF]'><tr><td>��ú�O����G<input type='text' size=10 value='".date('Y-m-d',time())."' name='paid_date'><BR>���б��y���O����X�G<BR><textarea rows='22' name='barcode' cols=30></textarea>

<BR><input type='submit' value='�ѪR�B�z' name='act'><input type='reset' value='�M�ŭ���'></td><td valign='top'>$excuted</td></tr></form></table>";

echo $main;

foot();

?>