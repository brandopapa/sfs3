<?php
//$Id: grade_data.php 7711 2013-10-23 13:07:37Z smallduh $
//���J�]�w��
require("config.php") ;

// �{���ˬd
sfs_check();
($IS_JHORES==0) ? $UP_YEAR=6:$UP_YEAR=9;//�P�_�ꤤ�p

$class_year_p = class_base("",array($UP_YEAR) ); //�Z��

$key =$_POST['key'];
$curr_class_name =$_POST['curr_class_name'];
	
if ($key)
    Do_CSV($curr_class_name) ;
        	
else {
	head() ;
	//prog(5);
	print_menu($menu_p);
        echo show_menu() ;
	foot() ;

}

//�D���
function show_menu() { 
        global $UP_YEAR ,$PHP_SELF,$class_year_p ;
        
	$class_temp ='';		
        foreach($class_year_p  as $tkey=>$tvalue)
	 {
		  if ($tkey == $curr_class_name)	  
			 $class_temp .=  sprintf ("<option value='%d' selected>%s</option>\n",$tkey,$tvalue);
		   else
			 $class_temp .=   sprintf ("<option value='%d'>%s</option>\n",$tkey,$tvalue);
        }             	 
		         
	$main = "<table width=100% bgcolor='#CCCCCC' >
  		<tr><td align='center'>	 
  		<H2>���~�͸�ƶץX</H2>
  		<form action='$PHP_SELF' method='post' name='pform'> 
	        <table width=50%  cellspacing='0' cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF' border='1' bgcolor='#99CCCC'>
	           <tr><td align=right>��ܯZ��</td>
	             <td><select name='curr_class_name'>
	             <option value='$UP_YEAR'>���Ǧ~</option>
	             $class_temp 
	             </select></td>
	           </tr>
	           <tr><td colspan=2 align=center><input type='submit' name='key' value='�ץX CSV '>
	           </td></tr>
	         </table>
	         </form>
	        </td></tr></table>" ;       
       return $main ; 	           
}
        
//-----------------------------------�ץXcsv

function Do_CSV($class_num) {
  global $UP_YEAR , $CONN  ;
  $class_name = class_name();
  
  /*
  $sqlstr  = " select s.stud_id, s.stud_name,year(s.stud_birthday) as TY , month(s.stud_birthday) as TM, DAYOFMONTH(s.stud_birthday) as TD,
               s.curr_class_num , g.grad_num  
               from stud_base  s
               LEFT JOIN grad_stud as g ON s.stud_id=g.stud_id 
               where  s.stud_study_cond =0  and s.curr_class_num like '$class_num%' 
               order by s.curr_class_num ";
  */
  $sqlstr  = " select s.stud_id, s.stud_name, s.stud_name_eng,year(s.stud_birthday) as TY , month(s.stud_birthday) as TM, DAYOFMONTH(s.stud_birthday) as TD,
               s.curr_class_num , g.grad_num  
               from stud_base  s,grad_stud as g where  s.stud_id=g.stud_id 
               and  s.stud_study_cond =0  and s.curr_class_num like '$class_num%' 
               order by s.curr_class_num ";
               
  $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 

  $row_data[0] =  "�Z��,�y��,�Ǹ�,�m�W,�^��m�W,�~,��,��,�s��";
  
  while ($row =$result->FetchRow() ) {
	
	
	$stud_name = $row["stud_name"];
	$stud_name_eng = $row["stud_name_eng"];
	
	$stud_no=substr($row["curr_class_num"],-2);
	$stud_id=$row["stud_id"];

	$stud_TY = $row["TY"] -1911 ;
	$stud_TM = $row["TM"] ;
	$stud_TD = $row["TD"] ;
	$curr_class_num = $row["curr_class_num"];
	$grad_num = $row["grad_num"];	
	$curr_class_name = $class_name[substr($curr_class_num,0,3)];
        $line_data ="\"$curr_class_name\",\"$stud_no\",\"$stud_id\",\"$stud_name\",\"$stud_name_eng\",\"$stud_TY\",\"$stud_TM\",\"$stud_TD\",\"$grad_num\"" ;
        $row_data[] = $line_data ;
	
  }

	$main=implode("\r\n",$row_data);
	$s=get_school_base();
	$filename =$s['sch_cname'].curr_year()."�Ǧ~�ײ��~�ͦW�U.csv";
	
	//�H��y�覡�e�X ooo.csv

	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: text/x-csv");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo $main;
	
	exit;
	return;

}
  
?>
