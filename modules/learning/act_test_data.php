<?php

// $Id: act_test_data.php 7708 2013-10-23 12:19:00Z smallduh $

// --�t�γ]�w��
include "config.php";
//���Юv�i�J
if($_SESSION['session_who']=='�Юv'){

// $unit �ߤ@�ǤJ���椸�N��

$m = substr ($unit, 0, 1); 
$t = substr ($unit, 1, 2); 
$u = trim (substr ($unit, 3, 4)); 

//���o�U���U�O
$sqlstr = "select * from unit_tome where  unit_m='$m' and unit_t='$t' " ;
$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
$row= mysql_fetch_array($result);
$c_tome = $row["unit_tome"];
$tome_ver = $row["tome_ver"];
//���o�椸�W��
$sqlstr = "select * from unit_u where  unit_m='$m'  and unit_t='$t' and u_s='$u' and tome_ver='$tome_ver' ";
$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
$row= mysql_fetch_array($result);
$c_unit = $row["unit_name"];
$u_id = $row["u_id"];
$msg_err="";
if($u_id==""){   //�L���椸
	$s_unit="<font size=7 color=red>�L���椸���D�w�I</font>";
}
$s_title= $modules[$m] . $c_tome .$c_unit  ; 



//--�{�� session
// sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


if ($do_key =="CSV ��X") {		
	$filename = $s_title.".csv";	
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream; Charset=Big5");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");
	
		$ma .= "�D������(0:��� 1:�ƿ� 2:��R),����,���D,�ﶵ1,�ﶵ2,�ﶵ3,�ﶵ4,�ﶵ5,�ﶵ6,(�Ĥ@�C�d�@���D�A�Ф��n�ק�)\n";

$sqlstr = "select * from test_data   where  u_id='$u_id' " ;
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
while ($row = $result->FetchRow() ) {    	
	$ques = $row["ques"] ;  
	$ch1= $row["ch1"] ;  
	$ch2= $row["ch2"] ;  
	$ch3= $row["ch3"] ;  
	$ch4= $row["ch4"] ;  
	$ch5 = $row["ch5"] ;  
	$ch6 = $row["ch6"] ;  
	$breed = $row["breed"] ; 
	$answer= $row["answer"] ; 
	$arr = array($breed,$answer,$ques,$ch1,$ch2,$ch3,$ch4,$ch5,$ch6); 
	$data[] = implode(",", $arr);
}
$ma .= implode("\n", $data);
echo $ma;
exit;
}

}

echo  "<font size=5 face=�з��� color=#800000><b>$s_title</b> �D�w�ץX</font>";	
?>

<table border="0" width="90%" cellspacing="0" cellpadding="0" >
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="pform">
<tr>
<td>
<a href=test_edit.php?unit=<?=$unit ?>>�^�W�@��</a>�@<input type=submit name="do_key" value="CSV ��X">
</td>
</tr>
<tr>
<td>
���\��u���ץX�D�w��r�����A�p�ݦ��Ϥ��λy���A�Щ�פJ��A�t�H�ק諸�覡�W�ǡC
</td>
</tr>
<input type='hidden' name='unit' value=<?=$unit ?>>	
</form>
</table>





