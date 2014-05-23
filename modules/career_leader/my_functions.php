<?php

//�ھگZ�Ũ��o���үZ���Ҧ��Ǵ�
function get_class_seme_select($class_num) {
	global $IS_JHORES;	
	$data_arr=array();	
	$I=substr($class_num,0,1)-$IS_JHORES-1;	
	
	for ($i=0;$i<=$I;$i++) {
	  $now_year=curr_year()-$i;
 	  if ($i>0 or curr_seme()==2) {
	  	$k=sprintf("%03d",$now_year)."2";
	  	$v=$now_year."�Ǧ~�ײ�2�Ǵ�";
	    $data_arr[$k]=$v;
	  } //end if

	  $k=sprintf("%03d",$now_year)."1";
	  $v=$now_year."�Ǧ~�ײ�1�Ǵ�";
	  $data_arr[$k]=$v;
	  
	}	// end for
	
	return $data_arr; 

} //end function

//�ھگZ�Ũ��o���үZ���Ҧ��Ǵ���key �p:[1001]=7-1 [1002]=7-2 .....
function get_class_seme_key_select($data_arr,$class_num) {
	global $IS_JHORES;
	$H=substr($class_num,0,1);	
		
  $seme_key_arr=array();
	foreach ($data_arr as $k=>$v) {
	  $year_step=curr_year()-substr($k,0,3);  //�ثe�w�N�ǴX�~
	  $V=($H-$year_step)."-".substr($k,-1);
	  $seme_key_arr[$k]=$V;
	}	// end foreach
	
	return $seme_key_arr; 

} //end function

//���ͷF���W��select
function get_name_list_select($select_name,$name_list_arr,$default_value='') {
	$select="<select name='$select_name'><option value=''></option>";
	foreach ($name_list_arr as $k=>$v) {
		$selected=($v==$default_value)?' selected':'';
		$select.="<option value='$v'$selected>$v</option>";
	}	// end foreach
	$select.='</select>';
	return $select; 

} //end function

?>