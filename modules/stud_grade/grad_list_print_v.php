<?php
//$Id: grad_list_print_v.php 8010 2014-04-30 22:11:29Z yjtzeng $

//���J�]�w��
require("config.php") ;
include_once "../../include/sfs_oo_zip2.php";

$oo_path = "ooo/v_view"  ;
//include "head_line.php"; 

// �{���ˬd
sfs_check();
($IS_JHORES==0) ? $UP_YEAR=6:$UP_YEAR=9;//�P�_�ꤤ�p

$class_year_p =  class_base(); //�Z��    
//print_r($class_year_p);
//exit;
$key =$_POST['key'];
$curr_class_name =$_POST['curr_class_name'];
$name_add = $curr_class_name ;

function page_break() {
   $break ='<text:p text:style-name="break_page"/>';
   return $break ;
}

if  ( $key)  {

       
  $title_str = $school_long_name . Num2CNum(curr_year()) ."�Ǧ~�ײ��~�ͤ@����"; 

/*
  $sqlstr = "select s.stud_id , s.stud_name ,s.curr_class_num ,s.stud_birthday ,s.stud_sex , 
             g.grad_sn , g.grad_word , grad_num   from stud_base as s  LEFT JOIN grad_stud as g ON s.stud_id=g.stud_id 
             where s.stud_study_cond = '0'  and s.curr_class_num like '$curr_class_name%' order by s.curr_class_num ";   
  $sqlstr = "select s.stud_id , s.stud_name ,s.curr_class_num ,s.stud_birthday ,s.stud_sex , 
             g.grad_sn , g.grad_word , grad_num   from stud_base as s , grad_stud as g where  s.stud_id=g.stud_id 
             and s.stud_study_cond = '0'  and s.curr_class_num like '$curr_class_name%' order by s.curr_class_num ";  */
  $sqlstr = "select s.stud_id , s.stud_name ,s.curr_class_num ,s.stud_birthday ,s.stud_sex , 
             g.grad_sn , g.grad_word , grad_num   from stud_base as s , grad_stud as g where  s.student_sn=g.student_sn 
             and s.stud_study_cond = '0'  and s.curr_class_num like '$curr_class_name%' order by s.curr_class_num "; 
             //�j�M����Ns.stud_id=g.stud_id�ק令 s.student_sn=g.student_sn�A�קK���~�ͤQ�~�Ǹ����ư��D  modify by kai,103.4.30
             

  //echo  $sqlstr ;         
  $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 


  
  for ($i = 1 ; $i <=19 ; $i++) {
    	  $clear_arr["class" . $i ] = "";

        $clear_arr["name". $i] ="" ;
        $clear_arr["sex". $i] ="" ;
        $clear_arr["birth" . $i] ="" ;
        $clear_arr["num". $i] ="";
  }  
  $clear_arr["ttt"]=$title_str ; 
  $clear_arr["grad_id"] ="" ;
  
  $i = 1;
  $temp_arr = $clear_arr ;
    
  $ttt = new EasyZip; 
  $ttt->setPath($oo_path);
  $data_cont = $ttt->read_file(dirname(__FILE__)."/$oo_path/content");
  
  while ($row = $result->FetchRow() ) {
    	
    	$stud_id = $row["stud_id"];	
    	$stud_name = $row["stud_name"];	
    	$stud_birthday = $row["stud_birthday"];
      $temp = explode ("-",$stud_birthday);
      $stud_birthday = sprintf ("%s�~%s��%s��", $temp[0]-1911,intval($temp[1]),intval($temp[2]));
          	
    	$stud_sex = $row["stud_sex"];
      if ($stud_sex =='1') 
    	  $stud_sex_temp = "�k";	
      else 
    	   $stud_sex_temp = "�k";
 	
    	$curr_class_num = substr($row["curr_class_num"],0,3);
    	
    	$now_classname= $class_name[$t_class]  ;   //�Z�W    
    	
    	$stud_graduate_num = $row["grad_word"] ."��" ;
    	$grad_num = $row["grad_num"];	
 
      $curr_class_name  = $class_year_p[$curr_class_num] ;


      if ($old_class == "")  $old_class = $curr_class_name ;
    	if  ($old_class <> $curr_class_name) {  //���Z�ŴN�n����
          $old_class = $curr_class_name ;

						$data .= $ttt->change_temp($temp_arr,$data_cont)  ;
            $i = 1;
  	        $have_data_out = false ;  
		        
            unset($temp_arr) ;
            $temp_arr = $clear_arr ;
    	}    
      
      $temp_arr["class" . $i ]=$curr_class_name ;
      $temp_arr["name". $i]=$stud_name ;
      $temp_arr["sex" . $i ]=$stud_sex_temp ;
      $temp_arr["birth" . $i]=$stud_birthday ;
      $temp_arr["grad_id"]=$stud_graduate_num ;
      $temp_arr["num" . $i]=$grad_num ;
      $have_data_out = true ;    
        


    	if ($i % 19 == 0) {	
            //�����@���A

						$data .= $ttt->change_temp($temp_arr,$data_cont)  ;

            //$data .= page_break(); //�����Ÿ�

            $i = 1;
		        $have_data_out = false ;  
		        
            unset($temp_arr) ;
            $temp_arr = $clear_arr ;
    	}
    	else
    		$i++;
	
  } //while

     if ( $have_data_out) {
      //�̫᳡��
					
  	  $data .= $ttt->change_temp($temp_arr,$data_cont)  ;
      //$data .= page_break(); //�����Ÿ�
    }		

	//Ū�X XML ���Y
	$doc_head = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_head");

	
	//Ū�X XML �ɧ�
	$doc_foot = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_foot");

        
  //���X�Y��
  $data = $doc_head . $data  . $doc_foot;
        
        // �[�J content.xml ��zip ��
	$ttt->add_file($data,"content.xml");
        
	$ttt->addDir('META-INF');

	$ttt->addfile("settings.xml");
	$ttt->addfile("styles.xml");
	$ttt->addfile("meta.xml");

  //���� zip ��
  $sss = &$ttt->file();
        
	$df="���~�ͤ@����$name_add.sxw";

	//�H��y�覡�e�X ooo.sxw
	header("Content-disposition: attachment; filename=$df");
	//header("Content-type: application/octetstream");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

  	echo $sss;      
}
        
	
if (!isset($key)) {
	head() ;

	print_menu($menu_p);
        echo show_menu() ;
	foot() ;
	exit;
}

function show_menu() {
        global $UP_YEAR ,$PHP_SELF ;
        $curr_year =  curr_year() ;
        $class_year_p = class_base("",array($UP_YEAR)); //�Z��
        
	$main =  "<table width=100% bgcolor='#CCCCCC' >
  		<tr><td align='center'>	
  		<center><H2>���~�ͤ@����C�L</H2><form action='$PHP_SELF' method='post' name='pform'>
  		<table  width=50% cellspacing='0'  cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF' border='1' bgcolor='#99CCCC' >
  		<tr><td align=right>��ܯZ��</td><td><select name='curr_class_name'>
  		<option value='$UP_YEAR'>���Ǧ~</option>\n";
	$class_temp ="";		
	foreach ( $class_year_p as $tkey => $tvalue) {
		  if ($tkey == $curr_class_name)	  
			 $class_temp .=  sprintf ("<option value='%d' selected>%s</option>\n",$tkey,$tvalue);
		   else
			 $class_temp .=   sprintf ("<option value='%d'>%s</option>\n",$tkey,$tvalue);
	}             	 
	$main .=  $class_temp ;
	
	$main .= " </select></td></tr>
	    <tr><td colspan=2 align=center><input type='submit' name='key' value='�ץX SXW'>
	    </td></tr></table></form></center>
	    </td></tr></table>" ;	    
	return $main ;        
}        


?>
