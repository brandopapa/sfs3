<?php
//$Id: magazine.php 5456 2009-04-23 08:32:09Z infodaes $
  include "config.php" ;
  include "../../include/sfs_case_PLlib.php" ;
  include "function.php" ;

  $self_php = $_SERVER["PHP_SELF"] ;  
  $book_num =$_POST["book_num"] ?$_POST["book_num"] : $_GET["book_num"]  ;
  $chap= $_GET["chap"] ;
  $paper= $_GET["paper"] ;
  $new_win= $_GET["new_win"] ;
  
  if (!isset($book_num)) {
      //���o�̷s�������O
    $sqlstr =  "select * from magazine  where is_fin <> '0'  " ;
    $sqlstr .= " order by num DESC  " ;
  }
  else {
    $sqlstr =  "select * from magazine  where is_fin <> '0' and id = '$book_num' " ;
  }

  $result = $CONN->Execute( $sqlstr) ;
  if ($result) {
      $book_num = $result->fields["id"];  
      $book_path = $result->fields["book_path"]; 
      $themes = $result->fields["themes"]; 	
  }

  if (!$book_num) {
    echo "�����w�������q�l�եZ�I�I<br>" ;
    echo "<a href='a_main.php'>�i�J���O�޲z�e��</a>" ;
    exit ;
  }     

  //=======================================================================  


  
    //�D���------------------------------------------------------------              
    //$book_num ���O ,$chap ���O

        //���o�Ӵ��ؿ� �C�X�U���`
        $sqlstr =  "select a.*, b.publish,b.publish_date from magazine_chap a , magazine b  where  a.book_num ='$book_num' and b.id= '$book_num' " ;   
        $sqlstr .= "order by a.chap_sort " ;    
        //echo $sqlstr ;
        $i = 0 ;
        $result = $CONN->Execute( $sqlstr) ;
        if ($result)    
           while ($row = $result->FetchRow()) {        
                $chap_id = $row["id"] ;
                $chap_name = $row["chap_name"] ;
                $publish = nl2br($row["publish"]) ;    
                $publish_date = $row["publish_date"];
                
                //$new_win = $row["new_win"] ;     
                $menu_list[$i][link] =  "$self_php?book_num=$book_num&chap=$chap_id" ;
                $menu_list[$i][chap_name] = $chap_name ;
                if ($chap == $chap_id ) $menu_list[$i][select] = "TRUE" ; 
                $i++ ;
            }
 
   //�˪�
    

    $tpl->assign("themes", $themes);   
    $tpl->assign("templetdir", $templetdir);
    $tpl->assign("menu_list", $menu_list);   
    $tpl->assign("publish", $publish);
    $tpl->assign("publish_date", $publish_date);
    $tpl->assign("basepath", $basepath);
    $tpl->assign("htmlpath", $htmlpath);
    $tpl->assign("mbooks_num", $books);
    $tpl->assign("mbooks_name", $mbooks_name);
    $tpl->assign("book_num", $book_num);
    $tpl->assign("PHP_SELF", $self_php);

    $tpl->assign("HOME_URL", $HOME_URL);
    
    
   if ($paper) {     //�I��d�ݤ峹�X�{�ӽg�峹   
      $paper_doc = get_paper($book_num,$chap,$paper) ;
      $tpl->assign("paper_doc", $paper_doc);
      if ($new_win) {
      	 $tpl->display("$themes/paper_s.htm"); 
      	 exit ;
      } else {
        switch  ($paper_doc[cmode]) {
			case 0: //�峹
        	    $dyn_page = "$themes/paper.htm" ; 
				break ;
			case 1: //����
        	    $dyn_page = "$themes/paper_t.htm" ;            
				break ;
			case 2: //�Z�ŰT��
               $dyn_page = "$themes/class.htm" ;
				break ;
			case 3: //����

				break ;
		  case 4: //SWF
        	    $dyn_page = "$themes/paper_swf.htm" ;            
          break ;
        }      
      }  
   } else {
      $paper_list = showpaper($book_num,$chap) ;        
      $tpl->assign("paper_list", $paper_list);
        switch  ($paper_list[cmode]) {
        	case 0: //�峹
        	    $dyn_page = "$themes/paper_list.htm" ; 
				break ;
          case 1: //����
               if ($paper_list[small_pic])
                 $dyn_page = "$themes/paper_list_t.htm" ; 
               else 
                  $dyn_page = "$themes/paper_list.htm" ;    
       
				break ;
          case 2: //�Z�ŰT��
               $dyn_page = "$themes/class.htm" ;
				break ;
          case 3: //����
			   if ($paper_list[include_mode]) {  //�����]�J
				  $fn = "$basepath" . $paper_list[book_path] ."/" . $paper_list[chap_path] . "/index.htm" ;
				  $handle = fopen($fn, "r");
				  $html_doc = fread($handle, filesize($fn));
				  fclose($handle);
				  $tpl->assign("html_doc", $html_doc);
			   }
			$dyn_page = "$themes/html.htm" ;
			break ;
		case 4: //SWF
        	    $dyn_page = "$themes/paper_list_swf.htm" ;            
          break ;
			
        }//switch         
   } 
 
    $tpl->assign("dyn_page", $dyn_page);   
    
    
    $tpl->display("$themes/index.htm");         
?>