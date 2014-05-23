<?php

// $Id: address_book_th.php 6848 2012-08-01 01:55:54Z hsiao $

/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";
include_once "../../include/config.php";


//�ϥΪ̻{��
sfs_check();


if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id
//��X���ЯZ��
$class_name=teacher_sn_to_class_name($teacher_sn);

$sex_arr= array(1=>"�k" ,2 =>"�k") ;


//�Ӹ�O��
//�u�n�i�J�N�O��
$class_description=implode(",",$class_name);
$test=pipa_log("�ϥαЮv��U�W��\��(���e�t�q�T��)\r\n�Ǧ~�G$sel_year\r\n�Ǵ��G$sel_seme\r\n�Z�šG$class_description\r\n");		


if($_POST['Submit1']=="�U���Z�ųq�T��"){
  print_key($class_name) ;
}else{
	//�q�X����
	head("�Юv��U�W��");

	if ($_GET['act']=="") print_menu($menu_p);
	//�]�w�D������ܰϪ��I���C��

    
    //$class_name = $class_name_arr[$sel_year] ;
    //$data_class_name = $class_name_arr[$sel_year] ;  
    $data_array = get_class_data($class_name ,$sel_seme) ;
    
        
    //�ϥμ˪�
    $template_dir = $SFS_PATH."/".get_store_path()."/templates";
    // �ϥ� smarty tag
    $smarty->left_delimiter="{{";
    $smarty->right_delimiter="}}";
    //$smarty->debugging = true;
    

    $smarty->assign("data_array",$data_array); 
    $smarty->assign("class_name",$class_name[1] ); 
    
    $smarty->assign("guardian_relation",guardian_relation()); 
    
    $smarty->assign("template_dir",$template_dir);
    
    $smarty->display("$template_dir/address_th.htm");
    

	foot();
}

//���o��ư}�C
function get_class_data($class_name    ){
    global $CONN, $sex_arr ;


    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();


       $sql="select s.stud_id,s.seme_num ,seme_class from stud_seme s , stud_base b where s.stud_id=b.stud_id and  b.stud_study_cond =0 and s.seme_class = '$class_name[0]' and  s.seme_year_seme='$seme_year_seme' order by  s.seme_class ,s.seme_num";

    
    $rs=$CONN->Execute($sql);


    while(!$rs->EOF){
        unset($row_data) ;
        $row_data[stud_id] = $rs->fields["stud_id"];
        $row_data[site_num] = $rs->fields["seme_num"];
        
        $rs_name=$CONN->Execute("select b.* , d.*  from stud_base b ,stud_domicile d  where b.stud_id='$row_data[stud_id]' and b.student_sn =d.student_sn and b.stud_study_cond =0 ");
        $row_data[stud_name] = $rs_name->fields["stud_name"];
		    //$row_data[stud_addr_1] = $rs_name->fields["stud_addr_1"];
		    $s_addres = addslashes($rs_name->fields["stud_addr_1"]);
		    $addr = change_addr($s_addres,1);
		    for ($i=1;$i<=12;$i++) 
		        $row_data[stud_addr_1] .= $addr[$i];
		        
		    $row_data[stud_addr_2] = $rs_name->fields["stud_addr_2"];
		    $row_data[stud_tel_1] = $rs_name->fields["stud_tel_1"];
		    $row_data[stud_tel_2] = $rs_name->fields["stud_tel_2"];
		    $row_data[stud_tel_3] = $rs_name->fields["stud_tel_3"];
		    $row_data[stud_person_id] = $rs_name->fields["stud_person_id"];
		    $row_data[stud_sex] = $sex_arr[$rs_name->fields["stud_sex"]];
		    if ($print_key == "Excel")
		       $row_data[stud_birthday] = $rs_name->fields["stud_birthday"];
		    else 
		       $row_data[stud_birthday] = DtoCh($rs_name->fields["stud_birthday"]);		
		
        $row_data[d_guardian_name] =$rs_name->fields["guardian_name"]  ;
        
        $row_data[guardian_relation] =$rs_name->fields["guardian_relation"]  ;
        
        $row_data[guardian_work_name] =$rs_name->fields["guardian_work_name"]  ;
        
        $data[] = $row_data ;
        $rs->MoveNext();
    }
    
  return $data ;

}	


//�C�L���
function print_key($class_name  ){
	global $CONN, $sex_arr , $SFS_PATH ,$smarty   ;
	

    $data_array = get_class_data($class_name ) ;

    
    //�ϥμ˪�
    $template_dir = $SFS_PATH."/".get_store_path()."/templates";

    // �ϥ� smarty tag
    $smarty->left_delimiter="{{";
    $smarty->right_delimiter="}}";
    //$smarty->debugging = true;
    
    
    $smarty->assign("data_array",$data_array); 
    $smarty->assign("guardian_relation",guardian_relation());     
    $smarty->assign("data_class_name",$class_name[1]); 
    
    $smarty->assign("template_dir",$template_dir);
    
    $smarty->display("$template_dir/address_th_exec.htm");

	exit;
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
