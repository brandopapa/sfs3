<?

// $Id: stu_list.php 5310 2009-01-10 07:57:56Z hami $

//���J�]�w��
require("config.php") ;
// �{���ˬd
sfs_check();
//-----------------------------------

$class_year_p = class_base(); //�Z��
  
head("�j�M");
//�w�]�Ǵ�
if (!isset($curr_seme))
	$curr_seme = curr_seme();

$stud_id =$_GET['stud_id'];
//	�ӤH���
 $sqlstr = "select *  from stud_base  where stud_id ='$stud_id' ";
 $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 

 $row = $result->FetchRow();

	$data[stud_id] = $row["stud_id"];
	$data[stud_name] = $row["stud_name"];
	$data[stud_person_id] = $row["stud_person_id"];
	$data[stud_birthday] = DtoCh($row["stud_birthday"]);
	$data[stud_sex] = $SEX_STR[$row["stud_sex"]];

	$data[curr_class_num] = substr ($row["curr_class_num"],-2);
	$curr_class = intval (substr ($row["curr_class_num"],0,-2));
	$data[current_class_name] = $class_year_p["$curr_class" ] ;

  $data[stud_addr_1] = $row["stud_addr_1"] ;
  $data[stud_addr_2] = $row["stud_addr_2"] ;
  $data[stud_tel_1] = $row["stud_tel_1"] ;
  $data[stud_tel_2] = $row["stud_tel_2"] ;
  $data[stud_tel_3] = $row["stud_tel_3"] ;
  $data[stud_study_cond] =  $row["stud_study_cond"] ;
  if ($row["stud_study_cond"] ==0) 
  	    $data[curr_stud_study_cond] = "�b��" ;
  else 
        $data[curr_stud_study_cond] = "�D�b��" ;
	$data[change_time] = $row["update_time"] ;

 //��f���
 $sqlstr = "select *  from stud_domicile  where stud_id ='$stud_id' ";
 $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 

 $row = $result->FetchRow();  
 $data[fath_name] =  $row["fath_name"] ;
 $data[fath_unit] =  $row["fath_unit"] ;
 $data[fath_work_name] =  $row["fath_work_name"] ;
 $data[fath_phone] =  $row["fath_phone"] ;
 $data[fath_home_phone] =  $row["fath_home_phone"] ;
 $data[fath_hand_phone] =  $row["fath_hand_phone"] ;
 
 $data[moth_name] =  $row["moth_name"] ;
 $data[moth_unit] =  $row["moth_unit"] ;
 $data[moth_work_name] =  $row["moth_work_name"] ;
 $data[moth_phone] =  $row["moth_phone"] ;
 $data[moth_home_phone] =  $row["moth_home_phone"] ;
 $data[moth_hand_phone] =  $row["moth_hand_phone"] ;

 $data[guardian_name] =  $row["guardian_name"] ;
 $data[guardian_phone] =  $row["guardian_phone"] ;
 $data[guardian_address] =  $row["guardian_address"] ;
 $data[guardian_relation] =  $row["guardian_relation"] ;
 $data[guardian_unit] =  $row["guardian_unit"] ;
 $data[guardian_work_name] =  $row["guardian_work_name"] ;
 $data[guardian_hand_phone] =  $row["guardian_hand_phone"] ; 



//���
print_menu($menu_p);
//�ϥμ˪�
$template_dir = $SFS_PATH."/".get_store_path()."/templates";
// �ϥ� smarty tag
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
//$smarty->debugging = true;


$smarty->assign("data",$data); 


$smarty->assign("template_dir",$template_dir);

$smarty->display("$template_dir/list.htm");

foot();

?>
