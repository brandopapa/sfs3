<?php

// $Id: show.php 8592 2015-11-12 08:22:32Z qfon $

include "config.php";
$stud_id = $_GET['stud_id'];
$der = $_GET['der'];
$cita_year = $_GET['cita_year'];

if($der=="") $der="up_date desc";

    $class_base_p = class_base();
    $sqlstr =" select stud_name  from stud_base where stud_id = '$stud_id' and ($cita_year-stud_study_year<9)" ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    $row = $result->FetchRow() ;          
    $stud_name = $row["stud_name"];   
	/*
		if($viewfullname==1)
		{
		//$stud_name_replace=mb_substr($stud_name,1,1,"BIG5");
		$stud_name_replace=substr($stud_name,2,2);
        $stud_name=str_replace($stud_name_replace,"��",$stud_name);
		}
   */
   
   
echo " <p align=center><font size=5 color=red>$stud_name ���a�A�]</font>�@�@<a href='list.php'>�^�ؿ�</a></p>";
      //���D��
    
	echo "<table cellSpacing=0 cellPadding=4 width='100%' align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
          <tr bgcolor='#66CCFF' align=center> 
            <td ><a href=$PHP_SELF?stud_id=$stud_id&der=grada,up_date>��</a>����<a href=$PHP_SELF?stud_id=$stud_id&der=grada%20desc,up_date>��</a></td>
		<td >���Z</td><td >�~�Z</td>
		<td ><a href=$PHP_SELF?stud_id=$stud_id&der=up_date>��</a>���<a href=$PHP_SELF?stud_id=$stud_id&der=up_date%20desc>��</a></td></tr>";              

  
    //�Z�W���W���
	
     $sqlstr ="select * from cita_data a inner join cita_kind b on a.kind=b.id where ( a.stud_id = '$stud_id' and a.order_pos>-1) order by $der  " ;

	//echo $query ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
    while ($row = $result->FetchRow() ) {
        $did = $row["id"] ;	
        $item = $row["item"] ;
        $order_pos = $row["order_pos"]+1 ;      
        $data_get = $row["data_get"] ;
        $data_input = $row["data_input"] ;   
	 $up_date = $row["up_date"] ;    
        $class_id = $row["class_id"] ;              
        $doc = $row["doc"] ;  
	 $gra = $row["grada"] ;  

	$class_name=class_id_to_full_class_name($class_id);
	
	$tempx = explode("_",$class_id);
	 if ($viewyn ==2)
	 {
	 
     $class_name=$tempx[1]."�~��";
     }
	 if ($viewyn ==1)
	 {
     $class_name=$tempx[3]."�Z";
     }
        
		
		echo "<tr> 
  		<td ><a href='view.php?id=$did'>$doc</a><font size=2>---$grada[$gra]</font></td>
            <td >$data_get</td>
		     <td >$class_name</td>          
	          <td >$up_date</td>
         </tr>" ;
   
   }           
   echo "</table>" ;  
   
   //�έp -------------------------------------------------------
   //�ǮաB�ռƲέp	
  
   echo  "<br><table cellSpacing=0 cellPadding=4 width='50%' align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
             <tr bgcolor='#66CCFF'><td>����</td><td>����</td></tr>\n" ;   
   $sqlstr = " select b.grada , count(*) as cc  from cita_data a,cita_kind b where (a.kind = b.id and a.stud_id='$stud_id'  and a.order_pos>-1) group by b.grada   " ;
   $result =  $CONN->Execute($sqlstr) ;      
   while ($row = $result->FetchRow() ) {
    $data_get  = $row["grada"] ;
       $num = $row["cc"] ;
     echo  "<tr><td>$grada[$data_get]</td><td>$num </td></tr>\n" ;   
     $school_num_g ++ ;
     $group_num_g += $num ;
   } 
	         
   echo "<tr><td>�@ $school_num_g ��</td><td>�@ $group_num_g ��</td></tr></table>\n<br>" ;  

              
?>
