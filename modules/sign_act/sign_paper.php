<?
// $Id: sign_paper.php 8681 2015-12-25 02:59:43Z qfon $
  include "config.php";
  //�n�J�{��
  session_start();   
  //���W���`�� ===============================
  $_GET[pid]=intval($_GET[pid]);
  $sqlstr = " select * from  sign_act_kind where  id ='$_GET[pid]' " ;

  $result =  $CONN->Execute($sqlstr) ; 
  $row = $result->FetchRow() ;
      $id = $row["id"] ;	
      $beg_date = $row["beg_date"] ;	
      $end_date = $row["end_date"] ;	
      $doc = $row["act_doc"] ;	
      $title = $row["act_name"] ;
      $act_passwd = $row["act_passwd"] ;
      $team_set = $row["team_set"] ;
      $max_team = $row["max_team"] ;
      $max_each = $row["max_each"] ;
      $member_set = $row["member_set"] ;
      $fields_set = $row["fields_set"] ;     
      $def_passwd = $row["act_passwd"] ;     
      

  //�էO    
  $tmparr = split (",", $team_set) ;  
  for ($i= 1 ; $i <= count($tmparr) ; $i++) {
    if ($tmparr[$i-1]<>"") {
      	$ni = $i ;	  
  	$tmp_arr1 = split ("##",$tmparr[$i-1]) ;  //�ҲզW|�k�m����,�A��|�k��  
  	$team_set_arr[] = $tmp_arr1 ;
    } 	  
  }

  //����    
  $tmparr = split (",", $member_set) ;      //����*1,�a��*2,����*1,����*4
  for ($i= 1 ; $i <= count($tmparr) ; $i++) {
    if ($tmparr[$i-1]<>"") {

      	$ni = $i ;	  
  	$tmp_arr1 = split ("\*",$tmparr[$i-1]) ;    
  	
  	//����¾�٩�J�}�C��
  	for ($j = 0 ; $j < $tmp_arr1[1] ; $j++ ) 
  	  $group_user_title[]= $tmp_arr1[0] ; 
  	/*  
  	$member_set_arr[] = $tmp_arr1 ;

  	$group_man += $member_set_arr[$i-1][1] ;
  	*/
    } 	  
  }  
  
  //���    
  $tmparr = split (",", $fields_set) ;      //�������r��|10|�w�]��|����,�ͤ�|6|�w�]��|����
  for ($i= 1 ; $i <= count($tmparr) ; $i++) {
    if ($tmparr[$i-1]<>"") {
      	$ni = $i ;	  
  	$tmp_arr1 = split ("##",$tmparr[$i-1]) ;    
  	$fields_set_arr[] = $tmp_arr1 ;
    } 	  
  } 
  // ���N�ǮզW�٪��ťէR��
  $schoolName = preg_replace('/\s+/', '',$_SESSION['schoolname']);
  //�Ӯժ����W���======================================================================
  $_GET[pid]=intval($_GET[pid]);
  $sqlstr = " select * from  sign_act_data where  pid ='$_GET[pid]'   and school_name ='$schoolName' order by did " ;
  $result = $CONN->Execute($sqlstr);  
  

  $mi=0 ;
  while($row =$result->FetchRow()) {
      $did_arr[] = $row["did"] ;	
      $team_id[$mi] = $row["team_id"] ;	
      $set_passwd = $row["set_passwd"] ;	
      $data = $row["data"] ;	
      
     
      
      //���    
      $tmparr = split (",", $data) ;      //(�m�W|���1|���2,�m�W|���1|���2)
      for ($i= 1 ; $i <= count($tmparr) ; $i++) {
      	    $tmp_arr1 = @split ("##",$tmparr[$i-1]) ;    
      	    $member_data_arr[$mi][] = $tmp_arr1 ;
      }    
      //$member_data_arr[$mi]['term'] = $row["team_id"] ;
      $mi++ ;
      $have_team ++ ;
  }
  
//=================================================  
$template_dir = $SFS_PATH."/".get_store_path()."/templates";
$smarty->template_dir = $template_dir;
$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","���W��ƪ�");


$smarty->assign("school_name",$_SESSION[schoolname]);

$smarty->assign("team_set_arr",$team_set_arr);

$smarty->assign("fields_set_arr",$fields_set_arr);

$smarty->assign("member_data_arr",$member_data_arr);
$smarty->assign("team_id",$team_id);
$smarty->assign("group_user_title",$group_user_title);


//$smarty->debugging = true;
$smarty->display("sign_paper.htm");

?>