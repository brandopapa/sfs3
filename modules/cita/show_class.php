<?php

// $Id: show_class.php 8650 2015-12-18 03:58:09Z qfon $

include "config.php";
$class_id = $_GET['class_id'];
$der = $_GET['der'];
$seme_year_seme = $_GET['seme_year_seme'];

if($seme_year_seme==''){
        $sel_year = curr_year(); //�ثe�Ǧ~
        $sel_seme = curr_seme(); //�ثe�Ǵ�
        $seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
}
$query = "SELECT  DISTINCT SUBSTRING(class_id,1,5) AS year_seme FROM cita_data ORDER BY year_seme DESC ";
$recordSet = $CONN->Execute($query) or trigger_error("SQL ���~ <br>$query",E_USER_ERROR);
$year_seme_arr = array();
while($row = $recordSet->FetchRow()){
	$temp = explode('_',$row['year_seme']);
	$year_seme_arr[$temp[0].$temp[1]] = $temp[0].'�Ǧ~��'.$temp[1].'�Ǵ�';
}
$seme_str = "<select name='seme_year_seme' onChange='this.form.submit()'>";
foreach($year_seme_arr as $year_seme=>$seme_name){
	$seme_str .="<option value='".$year_seme ."'";
	if ($year_seme == $seme_year_seme){
		$seme_str .=" selected";
	}
	$seme_str .=">$seme_name</option>";
}
$seme_str .="</select>";

if($der=="") $der="up_date desc";

    $class_base_p = class_base();            
$class_str = '<select name="class_id" onChange="this.form.submit()">';
// ���o�Z�ŤU�Կ��
foreach($class_base_p as $c_id=>$c_name){
	$class_str .= '<option value="'.$c_id.'"';
	if ($class_id == $c_id){
		$class_str .= ' selected="true"';
	}
	$class_str .= '>'.$c_name.'</option>';
} 
$class_str .= '</select>';
echo "<form method='get' action='{$_SERVER['php_SELF']}'> <p align=center><font size=5 color=red>$seme_str $class_str ���a�A�]</font>�@�@<a href='list.php'>�^�ؿ�</a></form></p>";
      //���D��
    
	echo "<table cellSpacing=0 cellPadding=4 width='100%' align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
          <tr bgcolor='#66CCFF' align=center> 
            <td ><a href=$PHP_SELF?class_id=$class_id&seme_year_seme=$seme_year_seam&der=grada,up_date>��</a>����<a href=$PHP_SEL?class_id=$class_id&seme_year_seme=$seme_year_seam&der=grada%20desc,up_date>��</a></td>
		<td >���Z</td>";
	if ($viewfullname !=1)echo "<td >�m�W</td>";
		echo "<td ><a href=$PHP_SELF?class_id=$class_id&seme_year_seme=$seme_year_seam&der=up_date>��</a>���<a href=$PHP_SELFclass_id=$class_id&seme_year_seme=$seme_year_seme&der=up_date%20desc>��</a></td></tr>";              

     
     $cti_class_id = sprintf("%03d_%d_%02d_%02d",substr($seme_year_seme,0,3),substr($seme_year_seme,-1),substr($class_id,0,1),substr($class_id,-2));

	 //�Z�W���W���

///mysqli	
$mysqliconn = get_mysqli_conn();
$stmt = "";
if ($cti_class_id <> "") {
    $stmt = $mysqliconn->prepare("select a.id,b.title,a.order_pos,a.data_get,a.data_input,a.up_date,a.stud_name,b.doc,b.grada from cita_data a,cita_kind b where (a.kind=b.id and a.class_id=? and a.order_pos>-1) order by $der ,num");
    $stmt->bind_param('s', $cti_class_id);
} 
$stmt->execute();
$stmt->bind_result($did, $item, $order_pos, $data_get, $data_input, $up_date, $stud_name, $doc, $gra);

while ($stmt->fetch()) {
	$order_pos=$order_pos+1;
	echo "<tr> 
  		<td ><a href='view.php?id=$did'>$doc</a><font size=2>---$grada[$gra]</font></td>
            <td >$data_get</td>";
			
         if ($viewfullname !=1)echo "<td >$stud_name</td>";          
	     echo "<td >$up_date</td>
         </tr>" ;
   
   }           
   echo "</table>" ;  
   
    //�έp -------------------------------------------------------
   //�ǮաB�ռƲέp	
  
   echo  "<br><table cellSpacing=0 cellPadding=4 width='50%' align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
             <tr bgcolor='#66CCFF'><td>����</td><td>����</td></tr>\n" ;   
   
if ($cti_class_id <> "") {
    $stmt = $mysqliconn->prepare("select b.grada , count(*) as cc  from  cita_data a,cita_kind b where (a.kind = b.id and a.class_id=?  and a.order_pos>-1) group by b.grada ");
    $stmt->bind_param('s', $cti_class_id);
} 

$stmt->execute();
$stmt->bind_result($data_get,$num);
while ($stmt->fetch()) {

     echo  "<tr><td>$grada[$data_get]</td><td>$num </td></tr>\n" ;   
     $school_num_g ++ ;
     $group_num_g += $num ;
   } 
	         
   echo "<tr><td>�@ $school_num_g ��</td><td>�@ $group_num_g ��</td></tr></table>\n<br>" ;  

   
   
   
	/*
    $sqlstr =" select *  from cita_data a,cita_kind b where (a.kind=b.id and a.class_id='$cti_class_id'  and a.order_pos>-1) order by $der ,num " ;
	//echo $query ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    while ($row = $result->FetchRow() ) {
        $did = $row["id"] ;	
        $item = $row["item"] ;
        $order_pos = $row["order_pos"]+1 ;      
        $data_get = $row["data_get"] ;
        $data_input = $row["data_input"] ;   
	    $up_date = $row["up_date"] ;    
        $stud_name = $row["stud_name"] ;              
        $doc = $row["doc"] ;  
	    $gra = $row["grada"] ;  

        echo "<tr> 
  		<td ><a href='view.php?id=$did'>$doc</a><font size=2>---$grada[$gra]</font></td>
            <td >$data_get</td>";
			
         if ($viewfullname !=1)echo "<td >$stud_name</td>";          
	     echo "<td >$up_date</td>
         </tr>" ;
   
   }           
   echo "</table>" ;  
   
   //�έp -------------------------------------------------------
   //�ǮաB�ռƲέp	
  
   echo  "<br><table cellSpacing=0 cellPadding=4 width='50%' align=center border=1 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
             <tr bgcolor='#66CCFF'><td>����</td><td>����</td></tr>\n" ;   
   $sqlstr = " select b.grada , count(*) as cc  from  cita_data a,cita_kind b where (a.kind = b.id and a.class_id='$cti_class_id'  and a.order_pos>-1) group by b.grada   " ;
   $result =  $CONN->Execute($sqlstr) ;      
   while ($row = $result->FetchRow() ) {
    $data_get  = $row["grada"] ;
       $num = $row["cc"] ;
     echo  "<tr><td>$grada[$data_get]</td><td>$num </td></tr>\n" ;   
     $school_num_g ++ ;
     $group_num_g += $num ;
   } 
	         
   echo "<tr><td>�@ $school_num_g ��</td><td>�@ $group_num_g ��</td></tr></table>\n<br>" ;  

  */      
?>
