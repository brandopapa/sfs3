<?php

// $Id: name_form2.php 7694 2013-10-23 08:03:46Z smallduh $

/*�ޤJ�ǰȨt�γ]�w��*/
include "../../include/config.php";
require_once "./module-cfg.php";
include_once "../../include/sfs_case_PLlib.php";
//�ޤJ���
//include "./my_fun.php";
$sex_ch= array(1=>"�k" ,2=>"�k") ;

$sel_year = $_POST['sel_year'] ;		
if ($sel_year=="") $sel_year ="601" ;
$class_name_arr = class_base() ;
$class_name[0]= $sel_year ;
$class_name[1]= $class_name_arr[$sel_year] ;

$allyear = $_POST['allyear'] ;

		$sel1 = new drop_select(); //������O
		$sel1->s_name = "sel_year"; //���W��		
		$sel1->id = $sel_year;		
		$sel1->has_empty = false;
		$sel1->arr = $class_name_arr ; //���e�}�C(���ӾǦ~)
		$sel1->is_submit = true;
		$sel1->bgcolor = "#DDFFEE";
		$sel1->font_style ="font-size: 15px;font-weight: bold";
		$class_select = "�Z��:" . $sel1->get_select();

		

//�ϥΪ̻{��
sfs_check();
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id

$many_col=$_POST['many_col'];
$print_key = $_POST[print_key];

if($_POST['Submit1']=="�U���Z�ŦW��") {
	$act = $print_key ;
}	

    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
    $sql="select stud_id,seme_num from stud_seme where seme_class='$class_name[0]' and  seme_year_seme='$seme_year_seme' order by  seme_num";
    $rs=$CONN->Execute($sql);

    $m=0;
	while(!$rs->EOF){
	  unset($tmp) ;	
	  $stud_id = $rs->fields["stud_id"];	
          $tmp[stud_id] = $stud_id;
          $tmp[site_num] = $rs->fields["seme_num"];
          $rs_name=$CONN->Execute("select stud_name , stud_sex  from stud_base where stud_id='$stud_id' and stud_study_cond =0 ");
    
        if ($rs_name->fields["stud_name"]) {

           $tmp[stud_name] = $rs_name->fields["stud_name"];	
           $tmp[stud_sex] = $sex_ch[$rs_name->fields["stud_sex"]];	
           $data_array[]= $tmp ;
	}
        $rs->MoveNext();
    }

  if ($act and ($act<>'html')) {
    $filename =  $class_name[0]. "." . $act; 	
    if ($act == "sxc") {
       header("Content-disposition: attachment; filename=$filename");
	     header("Content-type: application/vnd.sun.xml.calc");    	
	  }else {
	     header("Content-disposition: filename=$filename");
	     header("Content-type: application/octetstream");	  
	  }   
    //header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	  header("Expires: 0"); 
  }
  
  
    //�ϥμ˪�
    $template_dir = $SFS_PATH."/".get_store_path()."/templates";

    // �ϥ� smarty tag
    $smarty->left_delimiter="{{";
    $smarty->right_delimiter="}}";
    //$smarty->debugging = true;
    
    $smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
    
    $smarty->assign("with_stud_id",$_POST['with_stud_id']); 
    $smarty->assign("act",$act); 
    $smarty->assign("data_array",$data_array); 
    $smarty->assign("class_select",$class_select); 
    $smarty->assign("import_option",$import_option);     

    $smarty->assign("many_col",$_POST[many_col]); 
      
    $smarty->assign("class_id",$class_name[0]); 
    $smarty->assign("data_class_name",$class_name[1]); 
    
    $smarty->assign("template_dir",$template_dir);
    
    $smarty->display("$template_dir/name.htm");
    

?>
