<?php

// $Id: view.php 8592 2015-11-12 08:22:32Z qfon $

include "config.php";
// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

if($der=="") $der="order_pos,class_id,num";

    $class_base_p = class_base();            
    $sqlstr =" select *,year(beg_date)-1911 AS cita_year from cita_kind  where id = '$id'   " ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    $row = $result->FetchRow() ;          
      $doc = $row["doc"];     
             $title = $row["title"];  
             $foot = $row["foot"];  
      $kind_set = $row["kind_set"] ;       
   $beg_date = $row["beg_date"];  
 $end_date = $row["end_date"];  
$gra = $row["grada"];  
$cita_year = $row["cita_year"];	


//�s�פ���]���}�l�� �ɵn�ɭץ���
//$sqlstr="UPDATE `cita_data` SET `up_date` = '$beg_date' where kind=$id";
//		 $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 

echo "<table align=center width='90%'>";
echo "<tr><td><font size=5 color=red  face=�з���>$doc</font>( <a href=list.php?gra=$gra>$grada[$gra]</a> )";
     //�����ˬd    
      if (date("Y-m-d")>=$beg_date and date("Y-m-d")<=$end_date) 
         echo "�@�@<a href=\"citain.php?id=$id\"><img src=\"images/edit.gif\" border=\"0\" alt=\"�����\">�����</a>" ;
    
echo "</td></tr></table>";

      //���D��
    
	echo "<table cellSpacing=0 cellPadding=4 width='100%' align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
          <tr bgcolor='#66CCFF' align=center> 
            <td ><a href=$PHP_SELF?id=$id&der=order_pos,class_id,num>��</a>���Z<a href=$PHP_SELF?id=$id&der=order_pos%20desc,class_id,num>��</a></td>";
	if ($viewyn !=1 && $viewyn !=2)echo "<td ><a href=$PHP_SELF?id=$id&der=class_id,order_pos,num>��</a>�Z��<a href=$PHP_SELF?id=$id&der=class_id%20desc,order_pos,num>��</a></td>";
	if ($viewyn ==2)echo "<td ><a href=$PHP_SELF?id=$id&der=class_id,order_pos,num>��</a>�~��<a href=$PHP_SELF?id=$id&der=class_id%20desc,order_pos,num>��</a></td>";
    if ($viewyn ==1)echo "<td ><a href=$PHP_SELF?id=$id&der=class_id,order_pos,num>��</a>�Z��<a href=$PHP_SELF?id=$id&der=class_id%20desc,order_pos,num>��</a></td>";
	if ($viewyn !=2)echo "<td >�y��</td>";
	echo "<td >�Ǹ�</td>";
	if ($viewfullname !=1)echo "<td ><a href=$PHP_SELF?id=$id&der=stud_name,order_pos>��</a>�m�W<a href=$PHP_SELF?id=$id&der=stud_name%20desc,order_pos>��</a></td>";
	echo "<td ><a href=$PHP_SELF?id=$id&der=guidance_name,order_pos>��</a>���ɪ�<a href=$PHP_SELF?id=$id&der=guidance_name%20desc,order_pos>��</a></td>
		<td><a href=$PHP_SELF?id=$id&der=up_date,order_pos,class_id,num>��</a>���<a href=$PHP_SELF?id=$id&der=up_date%20desc,order_pos,class_id,num>��</a>�@<a href=$PHP_SELF?id=$id&der=order_pos,class_id,num&date=no>���ä��</a></td></tr>";              

    //�Z�W���W���
     $sqlstr =" select * from cita_data  where (kind = '$id'  and order_pos>-1) order by $der  " ;

	//echo $query ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    while ($row = $result->FetchRow() ) {
        $did = $row["id"] ;	
        $item = $row["item"] ;
        $order_pos = $row["order_pos"]+1 ;
		
        $stud_name = $row["stud_name"] ;
		
		/*
		if($viewfullname==1)
		{
		//$stud_name_replace=mb_substr($stud_name,1,1,"BIG5");
		$stud_name_replace=substr($stud_name,2,2);
        $stud_name=str_replace($stud_name_replace,"��",$stud_name);
		}
		*/
		
		$guidance_name = $row["guidance_name"] ;
		$stud_num = $row["num"] ;
        $data_get = $row["data_get"] ;
        $data_input = $row["data_input"] ; 
			
     	
	   $up_date = $row["up_date"] ;      
		if($date=='no')   $up_date="";
        $class_id = $row["class_id"] ;              
        $stud_id = $row["stud_id"] ;  
		$class_name=class_id_to_full_class_name($class_id);
        $temp = explode("_",$class_id);
        $seme_year_seme = $temp[0].$temp[1];
        $cti_class_id = sprintf("%d%02d",$temp[2],$temp[3]);
        $num = $row["cc"] ;
        echo "<tr align='center'> 
            <td >$data_get</td>";
       	if ($viewyn !=1 && $viewyn !=2)echo "<td><a href='show_class.php?seme_year_seme=$seme_year_seme&class_id=$cti_class_id'>$class_name</td>";
      	if ($viewyn ==2)echo "<td>$temp[1]</td>";
      	if ($viewyn ==1)echo "<td>$temp[3]</td>";
			
		if ($viewyn !=2)echo "<td>$stud_num</td>";
		echo "<td>$stud_id</td>";
        if ($viewfullname !=1) echo "<td ><a href='show.php?cita_year=$cita_year&stud_id=$stud_id'>$stud_name</a></td>";
		echo "<td >$guidance_name</td>
	          <td >$up_date</td>
         </tr>" ;
   
   }           
   echo "</table>" ;  
   
   //�έp -------------------------------------------------------
   //�ǮաB�ռƲέp	
   echo  "<br><table cellSpacing=0 cellPadding=4 width='50%' align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
             <tr bgcolor='#66CCFF'>";
   if ($viewyn ==2)echo "<td>�~��</td>";
   if ($viewyn !=2)echo "<td>�Z��</td>";
   echo "<td>�H��</td></tr>\n";
   
   $sqlstr = " select class_id , count(*) as cc  from  cita_data where (kind = '$id'  and order_pos>-1) group by class_id   " ;
   $result =  $CONN->Execute($sqlstr) ;      
   while ($row = $result->FetchRow() ) {
     $class_id   = $row["class_id"] ;
     $class_name=class_id_to_full_class_name($class_id);
     $temp = explode("_",$class_id);
     $seme_year_seme = $temp[0].$temp[1];
     $cti_class_id = sprintf("%d%02d",$temp[2],$temp[3]);
     $num = $row["cc"] ;
	 if ($viewyn ==2)
	 {
	  $class_name=$temp[1];
      echo  "<tr><td>$class_name</td><td>$num </td></tr>\n" ;  		 
		 
	 }
	 
	 if ($viewyn ==1)
	 {
		 $class_name=$temp[3];
      echo  "<tr><td>$class_name</td><td>$num </td></tr>\n" ;   

	 }
	
	
	  if ($viewyn !=1 && $viewyn !=2)
	  {
      echo  "<tr><td><a href='show_class.php?seme_year_seme=$seme_year_seme&class_id=$cti_class_id'>$class_name</td><td>$num </td></tr>\n" ;   
	  }	 
	 
	 

	 
     $school_num ++ ;
     $group_num += $num ;
   } 
	         
   echo "<tr><td>�@ $school_num �Z</td><td>�@ $group_num �H</td></tr></table>\n<br>" ;  
   echo  "<br><table cellSpacing=0 cellPadding=4 width='50%' align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
             <tr bgcolor='#66CCFF'><td>����</td><td>�H��</td></tr>\n" ;   
   $sqlstr = " select data_get , count(*) as cc  from  cita_data where (kind = '$id'  and order_pos>=0) group by order_pos order by order_pos  " ;

	$result =  $CONN->Execute($sqlstr) ;      
   while ($row = $result->FetchRow() ) {
    $data_get  = $row["data_get"] ;
       $num = $row["cc"] ;
     echo  "<tr><td>$data_get</td><td>$num </td></tr>\n" ;   
     $school_num_g ++ ;
     $group_num_g += $num ;
   } 
	         
   echo "<tr><td>�@ $school_num_g ��</td><td>�@ $group_num_g �H</td></tr></table>\n<br>" ;  

              
?>
