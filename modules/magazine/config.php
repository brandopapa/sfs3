<?php
//$Id: config.php 5310 2009-01-10 07:57:56Z hami $
//�w�]���ޤJ�ɡA���i�����C
require_once "./module-cfg.php";
include_once "../../include/config.php";

//���o�ҲհѼƳ]�w
$m_arr = &get_module_setup("magazine");
extract($m_arr, EXTR_OVERWRITE);

    //�W�Ǹ��|
    set_upload_path("/school/magazine");
    set_upload_path("templates_c/magazine");
    
    //�s��U�ϫ��B�峹�Ҧb(�ؿ��v���� 777 )
    $htmlpath = $UPLOAD_URL ."school/magazine/" ;    //�����۹�ؿ��A�̫�[ /
    $basepath = $UPLOAD_PATH. "school/magazine/" ; //����ؿ��A�̫�[ /


    //smarty  �]�w��
    //include "class/Smarty.class.php";
    define('__MAG_ROOT', $SFS_PATH . '/modules/magazine'); // �̫�S���׽u
    define('__MAG_HTML', $SFS_PATH_HTML . '/modules/magazine') ;
    
    $tpl = new Smarty();
    $tpl->template_dir = __MAG_ROOT . "/templates/";
    $tpl->compile_dir = $UPLOAD_PATH."templates_c/magazine/";

    //$tpl->config_dir = __MAG_ROOT . "/configs/";
    //$tpl->cache_dir = __MAG_ROOT . "/cache/";
    $tpl->left_delimiter = '<{';
    $tpl->right_delimiter = '}>';
    
    //�˪��Ҧb�������|�A�̫�[/
    $templetdir =__MAG_HTML . "/templates/" ;
    
    

  //���O���
  function print_chap_item($book_num, $chap_num=0 , $chap ){
  	
  	foreach ($chap as $k => $v) {
  		if ($chap_num == $k) 
  		    $seled_str = "selected" ;
  		else 
  		    $seled_str = "" ;   
      $seletc_str .= "<option value='$k' $seled_str>$v</option>\n " ;
  
    }
    $main = "
    
    �ثe�Ҧb���O:<select name='chap_num' onChange='this.form.submit();' >
    $seletc_str
    </select>
    <input name='book_num' type='hidden' value='$book_num'>
  
    " ;
    return $main ;
  }  


  //�ର�p��
  function dosmalljpg($updir , $filelist) {
     //��ӥؿ����������ର 1/10 ���p�� 	
     global $debug ;
     chdir($updir) ;
     if ($debug) echo "���ɭn�Y��: $filelist" ;
     $smail_jpg = "___" . $filelist ;

     system("djpeg -pnm \"$filelist\" | pnmscale -xscale 0.1 -yscale 0.1 | cjpeg > \"$smail_jpg\" ");
  }  	
  
    //�R���ؿ�  
    function do_rmdir($updir) 
    {     
       if (is_dir($updir) ) {
           $dirs = dir($updir) ;
           @$dirs->rewind() ;
           while ( $filelist = $dirs->read()) {
           	 if (($filelist!=".") && ($filelist!="..")){
           	   if ($debug) echo "del $updir $filelist" ;
                 unlink($updir.$filelist);      	
               }
           }
           $dirs->close() ;
           rmdir($updir);  
           //echo $updir ;     
       }else {
          return ;
       } 
    
    }      
    
   
 

  //�ˬd�޲z�̨禡
    function check_is_man2($editors) {

      $session_log_id = $_SESSION[session_log_id] ;

      $flag = false;
      $perr_man = split("," , $editors) ;
      for ($i =0 ;$i < count ($perr_man);$i++)
        if (trim($perr_man[$i]) == "$session_log_id")
           $flag = true ; 
      return $flag;
    }


    $self_php = $_SERVER["PHP_SELF"] ;
//=======================================================================
    //���o���������O
    $sqlstr =  "select * from magazine  where is_fin <> '0'  " ;
    $sqlstr .= " order by num DESC  " ;
  
    $result = $CONN->Execute( $sqlstr) ;
    if ($result) 
        while ($row = $result->FetchRow() ) {
          $id=	 $row["id"]  ;
          $books[] = $row["id"] ; //���o���O    
          $mbooks_num[] = $row["num"] ;
          $mbooks_name[$id]= "��" . $row["num"] ."��" ;
        }   
   

    if (!$book_num) $book_num = $books[0] ;  //�����w��̪ܳ�@��

?>
