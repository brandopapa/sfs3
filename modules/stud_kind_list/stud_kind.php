<?php

// $Id: stud_kind.php 7711 2013-10-23 13:07:37Z smallduh $


//���J�]�w��
require("config.php") ;
// --�{�� session 
sfs_check();



//-----------------------------------


  if ($_POST['Submit']=="�ץXEXCEL") {

             
	$filename ="score.xls" ;


	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo show_data(0) ;
	exit;
         
  }       


head("�S�����O�ǥͦW�U");
print_menu($menu_p);
echo "<form name='form1' method='post' >
       <div align='center'><input type='submit' name='Submit' value='�ץXEXCEL'>
       </div>\n" ;
      
echo show_data() ;
echo "</form>" ;
foot() ;


function show_data($view=1 ) {
  global $CONN ;     
  $class_year_p = class_base(); //�Z��

  //$main = "<table width=100% BGCOLOR='#FDDDAB' ><tr><td align=center>" ;
 
    //���o�U���O�W��
    $sqlstr = "select d_id , t_name from sfs_text where  t_kind='stud_kind'  " ;
    $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
    while ($row = $result->FetchRow() ) {
        $d_id = $row["d_id"] ;
        $t_name = $row["t_name"] ;    
        $kind_name[$d_id] = "($d_id)$t_name"   ;
    }


    $sqlstr = "select b.* , d.*  from stud_base b ,stud_domicile d  where b.stud_study_cond = 0  and b.stud_kind <> '0' and (b.stud_kind <> ',0,') and b.stud_kind <> ''  and b.stud_id =d.stud_id order by b.stud_kind , b.curr_class_num " ;
    $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    //echo $sqlstr ;
    
    $i =0;
    
    if ( $result->RecordCount() > 0 ){
    	//$main .= "���ơG". $result->RecordCount() .	"</td></tr>" ;
    	$main .= "<table  align=center  border=\"1\" cellspacing=\"0\" cellpadding=\"2\" bordercolorlight=\"#333354\" bordercolordark=\"#FFFFFF\" >
    	 <tr  class='title_sbody1'>
    	 <td align=center>(�N��)�����O</td><td align=center>�Ǹ�</td><td align=center>�Z��</td><td align=center>�y��</td><td align=center>�m�W</td><td align=center>�����Ҹ�</td>
    	    <td align=center>�ͤ�</td><td align=center>�a�}</td><td align=center>�q��</td>
    	    <td align=center>����</td><td align=center>����</td><td align=center>���@�H</td>
    	 </tr>";
    }
    
    while ($row = $result->FetchRow() ) {
    	$s_addres = $row["stud_addr_1"];
    	$s_home_phone = $row["stud_tel_1"];	  //�a���q��
    	$s_offical_phone = $row["stud_tel_2"];  	//�u�@�a�q��
    
    	$stud_id = $row["stud_id"];
    	$stud_name = $row["stud_name"];
    	$stud_person_id = $row["stud_person_id"];
            $stud_kind = $row["stud_kind"];
    
    	$class_num_curr = $row["curr_class_num"];
    	$s_year_class = substr($class_num_curr,0,3);   //���o�Z��
    
    	$s_num = intval (substr($class_num_curr,-2));	//�y��
    	$s_birthday = $row["stud_birthday"]  ;
    	//�ഫ������
    	if ($view)
            $s_birthday = DtoCh($s_birthday) ; 
            
            $d_guardian_name = $row["guardian_name"] ;
            $fath_name = $row["fath_name"] ;
            $moth_name = $row["moth_name"] ;
            
            $s_kind ="" ;
    	$stud_kind_arr = split("," , $stud_kind) ;
    	foreach( $stud_kind_arr as  $tid =>$tval) {
    	  if ($tval > 0 )
    	     $s_kind .= $kind_name["$tval"]; 
    	}     
                     
    	$main .= ($i%2 == 1) ? "<tr class='nom_1' >" : "<tr class='nom_2'>";
    	$main .= "<td>$s_kind</td>
    	<td>$stud_id</td>
    	<td>$class_year_p[$s_year_class] </td>
    	<td>$s_num </td>
    	<td>$stud_name </td>
    	<td>$stud_person_id </td>
    	<td>$s_birthday </td>
    	<td>$s_addres </td>
    	<td>$s_home_phone </td>
    	<td>$fath_name </td>
    	<td>$moth_name </td>
    	<td>$d_guardian_name </td>
    	</tr>\n";
    	$i++;
    }
    
    $main .= "</table>";
    return $main ;
    
}    

?>