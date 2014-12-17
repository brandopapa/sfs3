<?php
// $Id: create_data_function.php 5310 2009-01-10 07:57:56Z hami $

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

	//mode=2, �u�������m��
	if ($mode==2) return $res;

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

function check_student_data($base_arr=array()) {
	global $CONN,$ZIP_ARR,$IS_JHORES;

	//�ˬd�Ǹ��O�_�s�b
	if($base_arr['stud_id']=="") {
		return $temp_arr['msg']="�m�W�G".$base_arr['stud_name']." ���Ǹ��ť�";
	}

	//�ˬd�Ǹ��O�_����
	$query="select stud_name from stud_base where stud_id='".$base_arr['stud_id']."'";
	$res=$CONN->Execute($query) or trigger_error($query,256);
	if($res->fields['stud_name']!="")  {
		return $temp_arr['msg']="�z�ҭn�פJ���ǥ͸�Ƥ��Ǹ��G".$base_arr['stud_id']." �P ".$res->fields['stud_name']." ����"; 
	}

	//�ˬd�m�W
	if($base_arr['stud_name']=="") {
		return $temp_arr['msg']="�Ǹ��G".$base_arr['stud_id']." ���ǥͨS���m�W";
	}

	//�ˬd�ʧO				
	$sex_arr=array("0"=>"�k","1"=>"�k");
	if(!in_array($base_arr['stud_sex'],array_keys($sex_arr))) {
		return $temp_arr['msg']="�Ǹ��G".$base_arr['stud_id']."  �m�W�G".$base_arr['stud_name']." ���ʧO���~"; 
	}
	$base_arr['stud_sex']=2-$base_arr['stud_sex'];

	//�ˬd�ͤ�
	$stud_birthday_arr=split("[/.-]",$base_arr['stud_birthday']);
	if($stud_birthday_arr[0]<1900 || $stud_birthday_arr[0]>2030 || $stud_birthday_arr[1]<1 || $stud_birthday_arr[1]>12 || $stud_birthday_arr[2]<1 || $stud_birthday_arr[2]>31) {
		return $temp_arr['msg']="�Ǹ��G".$base_arr['stud_id']."  �m�W�G".$base_arr['stud_name']." ���ͤ�] ".$base_arr['stud_birthday']." �^��g���~";
	} else {
		$base_arr['stud_birthday']=$stud_birthday_arr[0]."-".$stud_birthday_arr[1]."-".$stud_birthday_arr[2];
	}

	//�ˬd������
	if($base_arr['stud_person_id']=="") {
		return $temp_arr['msg']="�Ǹ��G".$base_arr['stud_id']."  �m�W�G".$base_arr['stud_name']." �������Ҫť�";
	}

	//�ˬd�����ҬO�_����
	$query="select stud_id,stud_name from stud_base where stud_person_id='".$base_arr['stud_person_id']."'";
	$res=$CONN->Execute($query) or trigger_error($query,256);
	if($res->fields['stud_id']!="")  {
		return $temp_arr['msg']="�Ǹ��G".$base_arr['stud_id']."  �m�W�G".$base_arr['stud_name']." �������Ҧr���G".$base_arr['stud_person_id']." �P�Ǹ��G".$res->fields['stud_id']."  �m�W�G".$res->fields['stud_name']."����"; 
	}

	//��Ѧa�}
	$addr_arr=change_addr($base_arr['stud_addr_1']);
	if ($addr_arr[0]=="") {
		$addr_arr[0]=$base_arr['default'];
		$base_arr['stud_addr_1']=$base_arr['default'].$base_arr['stud_addr_1'];
	}
	$zip_id=0;
	if ($base_arr['stud_addr_2']) {
		$addr_arr2=change_addr($base_arr['stud_addr_2'],2);
		if ($addr_arr2[0]=="") $addr_arr2[0]=$base_arr['default'];
		if ($addr_arr2[0] && $addr_arr2[1]) {
			$zip_id=$ZIP_ARR[$addr_arr2[0].$addr_arr2[1]];
		}
	}

	//�ѪR�y��
	for($i=6;$i>1;$i--) {
		if ($base_arr['seme_year'][$i] && $base_arr['seme_class'][$i] && $base_arr['seme_num'][$i]) {
			$base_arr['curr_class_num']=intval($base_arr['seme_year'][$i]-$base_arr['stud_study_year']+1+$IS_JHORES)*10000+intval($base_arr['seme_class'][$i]*100)+intval($base_arr['seme_num'][$i]);
			break;
		}
	}

	//�s�W�ܸ�Ʈw
	$stud_kind =",0,";
	$query="insert into stud_base (stud_id,stud_name,stud_person_id,stud_birthday,stud_sex,stud_study_cond,curr_class_num,stud_study_year,stud_addr_a,stud_addr_b,stud_addr_c,stud_addr_d,stud_addr_e,stud_addr_f,stud_addr_g,stud_addr_h,stud_addr_i,stud_addr_j,stud_addr_k,stud_addr_l,stud_addr_m,stud_addr_1,stud_addr_2,stud_tel_2,stud_kind,stud_mschool_name,addr_zip) values ('".$base_arr['stud_id']."','".$base_arr['stud_name']."','".$base_arr['stud_person_id']."','".$base_arr['stud_birthday']."','".$base_arr['stud_sex']."','0','".$base_arr['curr_class_num']."','".$base_arr['stud_study_year']."','$addr_arr[0]','$addr_arr[1]','$addr_arr[2]','$addr_arr[3]','$addr_arr[4]','$addr_arr[5]','$addr_arr[6]','$addr_arr[7]','$addr_arr[8]','$addr_arr[9]','$addr_arr[10]','$addr_arr[11]','$addr_arr[12]','".$base_arr['stud_addr_1']."','".$base_arr['stud_addr_2']."','".$base_arr['stud_tel_2']."','$stud_kind','".$base_arr['stud_mschool_name']."','$zip_id')";
	$res=$CONN->Execute($query) or trigger_error($query,256);
	$student_sn=$CONN->Insert_ID();
	if ($student_sn) {
		$query="insert into stud_domicile (stud_id,guardian_name,guardian_relation,guardian_address,guardian_phone,student_sn) values('".$base_arr['stud_id']."','".$base_arr['guardian_name']."','".$base_arr['guardian_relation']."','".$base_arr['guardian_address']."','".$base_arr['guardian_phone']."','$student_sn')";
		$res=$CONN->Execute($query) or trigger_error($query,256);

		//�ѪR�y��
		for($i=1;$i<=6;$i++) {
			if ($base_arr['seme_year'][$i] && $base_arr['seme_class'][$i] && $base_arr['seme_num'][$i]) {
				$query="insert into stud_seme (student_sn,stud_id,seme_year_seme,seme_class,seme_num) values ('$student_sn','".$base_arr['stud_id']."','".sprintf("%03d",$base_arr['seme_year'][$i]).intval(($i-1)%2+1)."','".intval($base_arr['seme_year'][$i]-$base_arr['stud_study_year']+1+$IS_JHORES).$base_arr['seme_class'][$i]."','".$base_arr['seme_num'][$i]."')";
				$res=$CONN->Execute($query) or trigger_error($query,256);
			}
		}
	}
}
?>
