<?php
//$Id: grad_print2.php 8011 2014-04-30 22:11:30Z yjtzeng $
//���J�]�w��
require("config.php") ;
include_once "../../include/sfs_oo_zip2.php";
// �{���ˬd
sfs_check();

($IS_JHORES==0) ? $UP_YEAR=6:$UP_YEAR=9;//�P�_�ꤤ�p
$y[] = $UP_YEAR ;
$class_year_p = class_base("",$y); //�Z��

//-----------------------------------
$oo_path = "ooo/list_all2"  ;
include "head_line2.php";

$temp_grade = get_grade_school_table();

$key = $_POST['key'];
$curr_class_name = $_POST['curr_class_name'];
$curr_grade_school = $_POST['curr_grade_school'];


switch ( $key)  {
    case "�̾ǮնץX" :    
        
        foreach ($temp_grade as $tkey => $curr_grade_school) 
           $data .= hs_print($curr_grade_school);    
        do_sxw($data) ;   
        
         break;
    case "�̯Z�ŶץX" :    

        if ($curr_class_name == $UP_YEAR ) {
          foreach ($class_year_p as $ckey => $c_name)  	
            foreach ($temp_grade as $tkey => $curr_grade_school) 
                $data .=  hs_print($curr_grade_school, $ckey);  	
        }else{ 	
            foreach ($temp_grade as $tkey => $curr_grade_school) 
                $data .=  hs_print($curr_grade_school, $curr_class_name);
        }  
        do_sxw($data ,  $curr_class_name ) ;     
         break;
    case "�ץX sxw" :    
         if ($curr_grade_school == "all" )

            foreach ($temp_grade as $tkey => $curr_grade_school) 
                $data .=  hs_print($curr_grade_school, $curr_class_name );                  
         else        
             $data .= hs_print($curr_grade_school, $curr_class_name) ;
         do_sxw($data ,  $curr_class_name) ; 
         break;                  
}


if (!isset($key)) {
   $main = show_menu() ;
   head() ;  
   print_menu($menu_p);
   echo $main ;
   foot() ;
}   

//�D���
function show_menu() { 
        global $UP_YEAR ,$PHP_SELF,$class_year_p ;
        
        $curr_year =  curr_year() ;

	$main =  "<table width=100%  bgcolor='#CCCCCC' >
  		<tr><td align='center'>	 
	<H2>$curr_year �Ǧ~�ײ��~�ͦW�U�C�L</H2>
	<form action='$PHP_SELF' method='post' name='pform'> 
	<table width=50%  cellspacing='0' cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF' border='1' bgcolor='#99CCCC' > 
	<tr ><td colspan=2 align=center>�����ɾǾǮ�<br><input type='submit' name='key' value='�̾ǮնץX'> &nbsp; &nbsp; <input type='submit' name='key' value='�̯Z�ŶץX'></td></tr>
	<tr ><td align=right>�ɾǾǮ�</td><td><select name='curr_grade_school'>
	<option value= 'all' selected >�����Ǯ�</option> \n";
	$temp_grade =  get_grade_school_table(); 
	
	foreach( $temp_grade as $tkey => $tvalue) {
		if ($tvalue == $curr_grade_school)
			$main .=   sprintf ("<option value='%s' selected>%s</option>\n",$tvalue,$tvalue);
		else
			$main .=  sprintf ("<option value='%s'>%s</option>\n",$tvalue,$tvalue);
	}

	$main .= "</select></td></tr> \n
	     <tr ><td align=right>��ܯZ��</td><td><select name='curr_class_name'>
	     <option value='$UP_YEAR'>���Ǧ~</option> ";
        foreach ( $class_year_p as $tkey => $tvalue) {
		  if ($tkey == $curr_class_name)	  
			 $main .=  sprintf ("<option value='%02d' selected>%s</option>\n",$tkey,$tvalue);
		   else
			 $main .=   sprintf ("<option value='%02d'>%s</option>\n",$tkey,$tvalue);
	}             	 
          

	$main .= " </select></td></tr>
	         <tr ><td colspan=2 align=center><input type='submit' name='key' value='�ץX sxw'></td></tr>
	         </table></form>
	         </td></tr></table>" ;
        return $main ;
}





//�C�C(�C�ӤH)�����
function hs_print($curr_grade_school, $curr_class_name='all') {
    global $CONN , $UP_YEAR ;     
    global $stud_id,$stud_name,$stud_birthday,$stud_sex,$stud_inhabit_address,$guardian_name,$stud_home_phone,$boy,$girl , $now_classname;

    $class_name = class_base();
        
    if ( $curr_class_name == 'all' ) $curr_class_name = $UP_YEAR ;  //��Ӧ~��

 if (!get_magic_quotes_gpc())  $curr_grade_school = addslashes($curr_grade_school); 
    /*
    $sqlstr = "select s.stud_id , s.stud_name , s.stud_addr_1  , s.stud_tel_1 , s.stud_tel_2  , s.curr_class_num ,s.stud_birthday ,s.stud_sex , 
             g.grad_sn , g.grad_word , g.grad_num ,g.new_school  ,d.guardian_name 
             from stud_base as s 
             LEFT JOIN stud_domicile as d ON s.stud_id=d.stud_id
             LEFT JOIN grad_stud as g ON s.stud_id=g.stud_id 
             where s.stud_study_cond = '0'  and s.curr_class_num like '$curr_class_name%' and g.new_school = '$curr_grade_school' 
             order by s.curr_class_num "; */
    
    $sqlstr = "select s.stud_id , s.stud_name , s.stud_addr_1  , s.stud_tel_1 , s.stud_tel_2  , s.curr_class_num ,s.stud_birthday ,s.stud_sex , 
             g.grad_sn , g.grad_word , g.grad_num ,g.new_school  ,d.guardian_name 
             from stud_base as s 
             LEFT JOIN stud_domicile as d ON s.student_sn=d.student_sn
             LEFT JOIN grad_stud as g ON s.student_sn=g.student_sn 
             where s.stud_study_cond = '0'  and s.curr_class_num like '$curr_class_name%' and g.new_school = '$curr_grade_school' 
             order by s.curr_class_num ";   
    //�j�M����Ns.stud_id=g.stud_id�ק令 s.student_sn=g.student_sn�A�קK���~�ͤQ�~�Ǹ����ư��D  modify by kai,103.4.30
    //echo  $sqlstr ;         
    $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 


    $data .= title_line();
    
    $i = 1;
    $now_class = "" ;
    $boy = 0 ;
    $girl = 0 ;


    while ($row = $result->FetchRow() ) {

        $stud_inhabit_address =  $row["stud_addr_1"]  ;
        $stud_home_phone = $row["stud_tel_1"]  ;	//�a���q��
        $s_offical_phone =  $row["stud_tel_2"]  ;	//�u�@�a�q��	
        
        $stud_id = $row["stud_id"];

        $stud_name = $row["stud_name"];	
        $stud_birthday = $row["stud_birthday"];
        $stud_sex = $row["stud_sex"];
        $guardian_name = $row["guardian_name"] ;	  
   	

        //�ثe�ҳB�z���Z��
        $t_class = substr($row["curr_class_num"],0,3) ;
        //$t_class = $row["curr_class_num"] ;
        $now_classname= $class_name[$t_class]  ;   //�Z�W
//    	print_r($class_name);
//	echo $t_class;
//	exit; 
        if ($i % 23 ==0) {	

                $data .= tol_sex(); //�p��k�k�H��
                $data .= page_break(); //�����Ÿ�
                //�C���w�]��
                $i = 1;
                $boy = 0 ;
                $girl = 0 ;
                
                $data .= title_line();//���D			
                $data .= content_line();//���e	

        }
        else
             $data .= content_line();	//���e

        
        $i++;
        
    }

      $data .= tol_sex();
      $data .= page_break(); //�����Ÿ�
    if ($i>1) 
       return $data ; 
}


function do_sxw($data, $name_add ) {
    global $oo_path;        
    if ($data){
	$ttt = new EasyZip; 
	$ttt->setPath($oo_path);

        //$data_utf =iconv("Big5","UTF-8",$data);


	//Ū�X XML ���Y
	$doc_head = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_head");
	//$doc_head =iconv("Big5","UTF-8",$doc_head);
	
	//Ū�X XML �ɧ�
	$doc_foot = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_foot");
	//$doc_foot =iconv("Big5","UTF-8",$doc_foot);
        
        //���X�Y��
        $data = $doc_head . $data  . $doc_foot;
        
        // �[�J content.xml ��zip ��
	$ttt->add_file($data,"content.xml");
        
	//Ū�X xml �ɮ�

	//�[�J xml �ɮר� zip ���A�@�������ɮ� 
	//�Ĥ@�ӰѼƬ���l�r��A�ĤG�ӰѼƬ� zip �ɮת��ؿ��M�W��
	$ttt->addDir("META-INF");

	$ttt->addfile("settings.xml");
	$ttt->addfile("styles.xml");
	$ttt->addfile("meta.xml");

        //���� zip ��
        $sss = & $ttt->file();
        
	$df="���~�ͦW�U$name_add.sxw";

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
}
  
?>
