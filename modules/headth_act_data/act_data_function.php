<?php
// $Id: act_data_function.php 5310 2009-01-10 07:57:56Z hami $

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