<?php
//$Id: grad_list_print.php 7711 2013-10-23 13:07:37Z smallduh $

//���J�]�w��
require("config.php") ;
include_once "../../include/sfs_oo_zip2.php";

$oo_path = "ooo/list_all"  ;
include "head_line.php"; 

// �{���ˬd
sfs_check();
($IS_JHORES==0) ? $UP_YEAR=6:$UP_YEAR=9;//�P�_�ꤤ�p

$class_year_p =  class_base(); //�Z��    
//print_r($class_year_p);
//exit;
$key =$_POST['key'];
$curr_class_name =$_POST['curr_class_name'];
$name_add = $curr_class_name ;

if  ( $key)  {

       
  $title_str = $school_long_name . Num2CNum(curr_year()) ."�Ǧ~�ײ��~�ͤ@����"; 


  $sqlstr = "select s.stud_id , s.stud_name ,s.curr_class_num ,s.stud_birthday ,s.stud_sex , 
             g.grad_sn , g.grad_word , grad_num   from stud_base as s  LEFT JOIN grad_stud as g ON s.stud_id=g.stud_id 
             where s.stud_study_cond = '0'  and s.curr_class_num like '$curr_class_name%' order by s.curr_class_num ";   
  $sqlstr = "select s.stud_id , s.stud_name ,s.curr_class_num ,s.stud_birthday ,s.stud_sex , 
             g.grad_sn , g.grad_word , grad_num   from stud_base as s , grad_stud as g where  s.stud_id=g.stud_id 
             and s.stud_study_cond = '0'  and s.curr_class_num like '$curr_class_name%' order by s.curr_class_num ";   

  //echo  $sqlstr ;         
  $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 

  $data  .= title_line();
  $i = 1;

  while ($row = $result->FetchRow() ) {
	
	$stud_id = $row["stud_id"];	
	$stud_name = $row["stud_name"];	
	$stud_birthday = $row["stud_birthday"];
	$stud_sex = $row["stud_sex"];
	$curr_class_num = substr($row["curr_class_num"],0,3);
	
	$stud_graduate_num = $row["grad_word"] ."��" ;
	$grad_num = $row["grad_num"];	
 
        $curr_class_name  = $class_year_p[$curr_class_num] ;
        
        if ($old_class == "")  $old_class = $curr_class_name ;
    	if  ($old_class <> $curr_class_name) {  //���Z�ŴN�n����
          $old_class = $curr_class_name ;
          $i = 26 ;
    	}

	if ($i % 13 ==0) {	
		if ($i % 26 == 0){ //����
			$data  .= sign_form();
			$data  .= page_break(); //�����Ÿ�
			//�C���w�]��
			$i = 1;			
			$data  .= title_line();//���D			
			$data  .= content_line();//���e	
			
		}
		else {	
			
			$data  .= blank_line();	//�j��
			$data  .= content_line(1);//���e			
		}
	}
	else
		$data  .= content_line();	//���e

	$i++;
	
  } //while


	$data  .= sign_form();

        
	$ttt = new EasyZip; 
	$ttt->setPath($oo_path);

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
        $sss = & $ttt->file();
        
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
