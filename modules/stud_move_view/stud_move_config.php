<?php
// $Id: stud_move_config.php 5310 2009-01-10 07:57:56Z hami $
	//�t�γ]�w��
	include "../../include/config.php";
	//�禡�w
	include "../../include/sfs_case_PLlib.php";    
	
$menu_p = array("stud_move_view.php"=>"�d�ݾǥͲ���","explode_stu.php"=>"�ץX�U�ת����");

//���o�����m���� zip �}�C
function get_addr_zip_arr() {
	global $CONN;
	$query = "select zip,country,town from stud_addr_zip order by zip";
	$res= $CONN->Execute($query) or trigger_error("�y�k���~!",E_USER_ERROR);
	while(!$res->EOF){
		$addr =   $res->fields[1].$res->fields[2];
		$zip_arr[$addr]=$res->fields[0] ;
		//$zip_arr[$res->fields[0]] = $res->fields[1].$res->fields[2];
		$res->MoveNext();
	}
	return $zip_arr;
}	

function change_addr($addr,$mode=0) {
	//����
	$temp_str = split_str($addr,"��",1);
	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

      	//�m��	
	$temp_str = split_str($addr,"�m",1);
	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);

	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);
	
	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);

	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//����
	$temp_str = split_str($addr,"��",1);
	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);

	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//�F
	$temp_str = split_str($addr,"�F",$mode);
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//��
	$temp_str = split_str($addr,"��",1);
	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);
	
	$res[] = $temp_str[0];
	$addr=$temp_str[1];

      	//�q
	$temp_str = split_str($addr,"�q",$mode);
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

      	//��
	$temp_str = split_str($addr,"��",$mode);
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//��
	$temp_str = split_str($addr,"��",$mode);
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//��
	$temp_str = split_str($addr,"��",$mode);
	$temp_arr = explode("-",$temp_str);
	if (sizeof($temp_arr)>1){
		$res[]=$temp_arr[0];
		$res[]=$temp_arr[1];
	}else {
		$res[]=$temp_str[0];
		$res[]="";
	}
	$addr=$temp_str[1];
	
	//��
	$temp_str = split_str($addr,"��",$mode);
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//�Ӥ�
	if ($addr != "") {
		if ($mode)
			$temp_str = $addr;
		else
			$temp_str = substr(chop($addr),2);
	} else
		$temp_str ="";
		
	$res[]=$temp_str ;
      	return $res;
}

function split_str($addr,$str,$last=0) {
      	$temp = explode ($str, $addr);
	if (count($temp)<2 ){
		$t[0]="";
		$t[1]=$addr;
	}else{
		$t[0]=(!empty($last))?$temp[0].$str:$temp[0];
		$t[1]=$temp[1];
	}
	return $t;
}
?>