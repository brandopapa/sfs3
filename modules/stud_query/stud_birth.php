<?php

// $Id: stud_birth.php 6896 2012-09-20 08:36:24Z infodaes $

/*
=====================================================
�{���G�Z�žǥͤH�Ʋέp�W�U(stud_birth.php)  ver1.0

prolin

=====================================================
*/

/* �ǰȨt�γ]�w�� */
include "stud_query_config.php";


// --�{�� session 
sfs_check();

head("�ǥͥͤ����έp");
print_menu($menu_p);
$class_year_p = class_base($curr_year_seme); //�Z��
echo "<h2 align=\"center\"> ���վǥͦU����H�Ʋέp�W�U </hr><br>"  ;

  //���o�U�~���`�H��  
  $query = "select count(*) as tc ,substring(curr_class_num,1,1) as gg from stud_base
            where stud_study_cond=0 
            group by gg order by gg   ";
  //$result = mysql_query($query) or die($query);
  $recordSet=$CONN->Execute($query) or die($query);
  while($row = $recordSet->FetchRow() ){		
		if ($row[gg]==0)
			continue;
		$s_class = $row[gg];	
		$year_stud_num[$s_class] = $row[tc];
  }		

/*
���o�U�Z�U������O�έp��	
select  LEFT(curr_class_num,3) as Tclass , month(stud_birthday)  , count(*) , CONCAT(  LEFT(curr_class_num,3) , LPAD(month(stud_birthday),2,'0')) as tt 
from stud_base
group by  tt	
*/

      $query = " select  LEFT(curr_class_num,3) as Tclass , month(stud_birthday) as TM , count(*) as TC , CONCAT(  LEFT(curr_class_num,3) , LPAD(month(stud_birthday),2,'0')) as tt  
                  from stud_base
                  where stud_study_cond  = 0 
                  group by  tt " ;
            
                        
    //echo $sql1 ."<br>";
    //$result = mysql_query ($sqlstr,$conID)or die ($sqlstr);
    $recordSet=$CONN->Execute($query) or die($query);
    
    while ($row = $recordSet->FetchRow() ) {		
         $classN	 = $row["Tclass" ] ;	//�Z��
         $monthN = $row["TM" ] ;		//���
         $studN	 = $row["TC" ] ;		//�H��
         $birth_array[ $classN ][$monthN] = $studN ;	//��b [�Z��][���]�}�C��
     }
     


//�U�Z��
    $row_title = ' <table width="90%" border="1" cellspacing="0" BGCOLOR="#FDDDAB" align="center" cellpadding=2  bordercolor=#008080  bordercolorlight=#666666 bordercolordark=#FFFFFF>
         <tr align="center"><td>���</td>  <td>1��</td>    <td>2��</td>    <td>3��</td>    <td>4��</td>    <td>5��</td>    <td>6��</td>    <td>7��</td>    <td>8��</td>    <td>9��</td>    <td>10��</td>    <td>11��</td>    <td>12��</td><td>�p�p</td> </tr> ' ."\n" ;
    $class_list = $row_title ;     
    foreach ($class_year_p as $curr_class_name=>$value ) {
        //�@�C����
        $m_sum = 0 ;   
        $rowstr = "" ;	  
        for ($m= 1 ; $m<=12 ; $m++) {		//�U����H��
            $m_sum += intval($birth_array["$curr_class_name"][$m])   ;
            if (intval($birth_array["$curr_class_name"][$m]) >0)
              $rowstr .= "<td >" .  intval($birth_array["$curr_class_name"][$m])  . "</td> "  ;
            else 
              $rowstr .= "<td >0</td> "  ;
        } 
        $rowstr .= "<td >$m_sum</td> "  ;
        
        if ($m_sum>0) {		//�ӯZ���H
                 	
           $class_list .= "<tr align='center' bgcolor=#FFFF80>" ;	
           $class_list .= "<td>" . $value ."</td>" ;
           $class_list .= $rowstr ;   
           
           $class_list .= "</tr> \n" ;
           
 
	   for ($m= 1 ; $m<=12 ; $m++) {		//�[�`����զU����H��            
	       $all_m_sum[$m] += $birth_array["$curr_class_name"][$m] ;
	   }    
      
       }          
    }	
    $class_list .= "</table><br>" ;
    
    echo $class_list ;
/*
//�U�~��
  reset($class_year) ;
  while(list($c,$s_year_name)= each($class_year)){
    if ($year_stud_num[$c]==0) 
        continue ;
    echo ' <table width="90%" border="1" cellspacing="0" BGCOLOR="#FDDDAB" align="center" cellpadding=2  bordercolor=#008080  bordercolorlight=#666666 bordercolordark=#FFFFFF>
         <tr align="center"><td>���</td>  <td>1��</td>    <td>2��</td>    <td>3��</td>    <td>4��</td>    <td>5��</td>    <td>6��</td>    <td>7��</td>    <td>8��</td>    <td>9��</td>    <td>10��</td>    <td>11��</td>    <td>12��</td><td>�p�p</td> </tr> ' ."\n" ;
    
    //�U�Z  
    reset($class_name) ;
    while(list($d,$t_class_name)= each($class_name)){
        $curr_class_name = $c . sprintf("%02d" , $d) ;

        //�@�C����
        $m_sum = 0 ;   
        $rowstr = "" ;	  
        for ($m= 1 ; $m<=12 ; $m++) {		//�U����H��
            $m_sum += intval($birth_array["$curr_class_name"][$m])   ;
            if (intval($birth_array["$curr_class_name"][$m]) >0)
              $rowstr .= "<td >" .  intval($birth_array["$curr_class_name"][$m])  . "</td> "  ;
            else 
              //$rowstr .= "<td >&nbsp;</td> "  ;
              $rowstr .= "<td >0</td> "  ;
        } 
        $rowstr .= "<td >$m_sum</td> "  ;
        
        if ($m_sum>0) {		//�ӯZ���H
           $class_year[substr($curr_class_name,0,1)] . $class_name[substr($curr_class_name,1)] ;	  
                 	
           echo "<tr align='center' bgcolor=#FFFF80>" ;	
           echo "<td>" . $class_year_p[$curr_class_name] ."</td>" ;
           echo $rowstr ;   
           
           echo "</tr> \n" ;
           
 
	   for ($m= 1 ; $m<=12 ; $m++) {		//�[�`����զU����H��            
	       $all_m_sum[$m] += $birth_array["$curr_class_name"][$m] ;
	   }    
      
       }          
    }	
    echo "</table><br>" ;
}
*/

  //���ղέp����
  $all_stud = 0 ;
  echo ' <table width="90%" border="1" cellspacing="0" BGCOLOR="#FDDDAB" align="center" cellpadding=2  bordercolor=#008080  bordercolorlight=#666666 bordercolordark=#FFFFFF>
     <tr align="center"><td>���</td>  <td>1��</td>    <td>2��</td>    <td>3��</td>    <td>4��</td>    <td>5��</td>    <td>6��</td>    <td>7��</td>    <td>8��</td>    <td>9��</td>    <td>10��</td>    <td>11��</td>    <td>12��</td><td>�p�p</td> </tr> ' ."\n" ;
  echo "<tr align='center' bgcolor=#FFFF80><td>���ղέp</td>" ;   
  for ($m= 1 ; $m<=12 ; $m++) {		//�U����H��
	$this_month=$all_m_sum[$m];
	$this_month="<a href='stud_birth_list.php?month=$m' target='birthday_$m'>$this_month</a>";
	
     echo  "<td>$this_month</td> "  ;
     $all_stud += $all_m_sum[$m] ;
  }      
  echo "<td>$all_stud</td>" ;
  echo "</tr></table><br>" ;   
  
  
  //�Юv�ͤ���
  $query = " select  month(birthday) as TM , count(*) as TC   
                  from teacher_base
                  where teach_condition=0 
                  group by  TM ";
                  //having teach_condition=0 " ;
          
   //$result = mysql_query ($sqlstr,$conID)or die ($sqlstr);  
   $recordSet=$CONN->Execute($query) or die($query);
   
    while ($row = $recordSet->FetchRow() ) {		
         $monthN = $row[TM ] ;		//���
         $teachN = $row[TC ] ;		//�H��
         $birth_array[$monthN] = $teachN ;	//��b [�Z��][���]�}�C��
     }   
  echo ' <table width="90%" border="1" cellspacing="0" BGCOLOR="#FDDDAB" align="center" cellpadding=2  bordercolor=#008080  bordercolorlight=#666666 bordercolordark=#FFFFFF>
     <tr align="center"><td>���</td>  <td>1��</td>    <td>2��</td>    <td>3��</td>    <td>4��</td>    <td>5��</td>    <td>6��</td>    <td>7��</td>    <td>8��</td>    <td>9��</td>    <td>10��</td>    <td>11��</td>    <td>12��</td> <td>�p�p</td></tr> ' ."\n" ;
  echo "<tr align='center' bgcolor=#FFFF80><td>��¾���έp</td>" ;   
  for ($m= 1 ; $m<=12 ; $m++) {		//�U����H��
     if ($birth_array[$m]) {
        echo  "<td >" .  $birth_array[$m]  . "</td> "  ;
        $all_teach +=  $birth_array[$m] ;  
     }   
     else 
        echo  "<td >&nbsp</td> "  ;   
  }      
  echo "<td>$all_teach</td>" ;
  echo "</tr></table><br>" ;     
        
foot();	

?>