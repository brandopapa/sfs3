<?php

// $Id: citain.php 7086 2013-01-18 12:53:24Z infodaes $

include "config.php";
sfs_check();
$session_tea_sn =  $_SESSION['session_tea_sn'] ;

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

$sqlstr =" select *  from cita_kind  where id = '$id'   " ;
$result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
 $row = $result->FetchRow() ;          
 $doc = $row["doc"];     
 $helper = "<br><font size=2 color='brown'>����������G".$row["helper"]."</font><br>";  
 $beg_date = $row["beg_date"];  
 $end_date = $row["end_date"];  

$input_classY = $row["input_classY"];  
$kind_set = $row["kind_set"] ;
$bonus_set = $row["bonus_set"] ;        
$is_hide = $row["is_hide"] ;
$admin = $row["admin"] ;
	


if ($Submit=="�T�w�s�W") {
	$now=date("Y-m-d");
	for($i=0;$i<count ($sel_stud);$i++){
		$sel_data= split (",", $sel_stud[$i]); 
		$stud_id=$sel_data[0];
		$stud_name=$sel_data[1];	
		$num=sprintf('%02d',$sel_data[2]);
		$ni=$sel_data[3];		
		$kind_a= split (",", $kind[$ni]); 
		$order_pos=$kind_a[0]; 
		$data_get=$kind_a[1]; 
		$bonus=$kind_a[2]; 	
		$teacher_name=$guidance_name[$stud_id];
		$sqlstr ="insert into cita_data (kind,stud_id,stud_name,teach_id,class_id,num,data_get,order_pos,up_date,bonus,guidance_name) 
					         values ('$id','$stud_id','$stud_name','$session_tea_sn','$class_id','$num','$data_get','$order_pos','$now','$bonus','$teacher_name')";
		 $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
	}
}
if ($Submit=="�T�w�R��") {	
 	$now=date("Y-m-d");
	for($i=0;$i<count ($sel_stud);$i++){
		$did=$sel_stud[$i];		
		//$sqlstr="UPDATE `cita_data` SET `order_pos` = '-1',`teach_id` = '$session_tea_sn',`up_date` = '$now' where id=$did";
		$sqlstr="DELETE FROM `cita_data` where id=$did";  //�쥻�����O  `order_pos` = '-1' , �ҲըõL�]�p�_��\��A�G�אּ�����R��
		 $result = $CONN->Execute($sqlstr) or user_error("�R�����ѡI<br>$sqlstr",256) ; 
	}
}

//����~��
$year_arr = @split (",", $input_classY); 
$class_base_p = class_base("" , $year_arr);

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;

if ( checkid($SCRIPT_FILENAME,1) or ($admin==$session_tea_sn) ){
   if (!isset($class_num) ) 
      $class_num = "601" ;	 
        //�޲z�̥i�H������
    $class_num_temp .= "�Z�šG<select name=\"class_num\" onchange=\"this.form.submit()\">\n";
		foreach ($class_base_p as $key => $value) {
			if ($key == $class_num)
				$class_num_temp .= "<option value=\"$key\" selected>$value</option>\n";
			else
				$class_num_temp .= "<option value=\"$key\">$value</option>\n";							
		}
    $class_num_temp .= "</select>" ;

}
else {
	//���o�Юv�ҤW�~�šB�Z��
	$query =" select class_num  from teacher_post  where teacher_sn  ='$session_tea_sn'  ";
	$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ; 
	$row = $result->FetchRow();
	$class_num = $row["class_num"];
	 
	if (($class_num <= 0) or (!in_array(substr($class_num,0,1),$year_arr) ) or  ($is_hide ==1)  )  {
	   Header("Location: index.php");
	   exit ;
	}	
	$class_num_temp = $class_base_p[$class_num] ;
	
}

head("�a�A�]���") ;
print_menu($menu_p);
//����
 $kind_arr = split (",", $kind_set);
	$bonus_arr = split (",", $bonus_set);  
$max=count( $kind_arr);
$sel_year = curr_year(); //�ثe�Ǧ~
$sel_seme = curr_seme(); //�ثe�Ǵ�
$class_id=old_class_2_new_id($class_num,$sel_year,$sel_seme);
 
 
	?>
	<script>
	function tagall(status) {		
		var i =0;

	  	while (i < document.chform.elements.length)  {
	    		if (document.chform.elements[i].name=='sel_stud[]') {
      			document.chform.elements[i].checked=status;
	    	}
	    	i++;
	  	}
	}
	function tagall_1(status) {		
		var i =0;

	  	while (i < document.chform_1.elements.length)  {
	    		if (document.chform_1.elements[i].name=='sel_stud[]') {
      			document.chform_1.elements[i].checked=status;
	    	}
	    	i++;
	  	}
	}

	</script>
<?
     //�����ˬd    
if (date("Y-m-d")>=$beg_date and date("Y-m-d")<=$end_date) {

echo "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" name=\"chform_1\">";
		echo "$class_num_temp �@<input type='button' value='����' onClick='javascript:tagall_1(1);'>";
 		echo '<input type="button" value="��������" onClick="javascript:tagall_1(0);">�@';				
		echo "<input type='submit' name='Submit'  value='�T�w�R��'>";
      
      //���D��
    
	echo "<table cellSpacing=0 cellPadding=4 width='60%' border=0 bordercolor='#33CCFF' bgcolor='#CCFFFF'>
          <tr bgcolor='#66CCFF' align='center'> 
            <td width=40>�y��</td><td>�Ǹ�</td><td>�ǥͩm�W</td><td>���Z</td><td>���ɪ�</td><td>�s�פ��</td><td >�R��</td></tr>";              

  
    //�Z�W���W���
    $sqlstr =" select * from cita_data where (kind = '$id' and class_id='$class_id' and order_pos>-1) order by order_pos,num" ;
	//echo $query ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256); 
    while ($row = $result->FetchRow() ) {
        $did = $row["id"] ;	        
        $stud_name = $row["stud_name"] ;
        $data_get = $row["data_get"] ;   
        $up_date = $row["up_date"] ;    
        $class_id = $row["class_id"] ;              
        $stud_id = $row["stud_id"] ;  
		$class_num = $row["num"] ;
		$guidance_name = $row["guidance_name"] ;
		$class_name=class_id_to_full_class_name($class_id);
        echo "<tr align='center'>                
            <td>$class_num</td><td>$stud_id</td><td>$stud_name</td><td>$data_get</td><td>$guidance_name</td><td>$up_date</td>
            <td><input id=c_$stud_id type=checkbox name=sel_stud[] value=$did></td>
			</tr>" ;
   
   }           
   echo "</table><br><font color=red size=5>$doc</font>$helper
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='class_id' value='$class_id'>
</form>";

	//���o�ǥ͸�ư}�C
    $class_id_array=explode("_",$class_id);
    $class_num=intval($class_id_array[2]).$class_id_array[3];
    $sql="select stud_id,stud_name,curr_class_num from stud_base where stud_study_cond=0 and curr_class_num like '$class_num%' order by curr_class_num ";
	$result=$CONN->Execute($sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
$sel_kind= "<select size=1 name=kind[]>";
for($i=0;$i<$max;$i++){
	if($i==($max-1)) $sel="selected";
	$v=$i.",".$kind_arr[$i].",".$bonus_arr[$i];
	$bonus=$bonus_arr[$i]?"(+$bonus_arr[$i])":"";
	$sel_kind.="<option $sel value='$v'>{$kind_arr[$i]}$bonus</option>";
}
$sel_kind.="</select>";

	$now=date("Y-m-d");  
	echo "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" name=\"chform\">";
	echo "<p align='right'><input type='button' value='����' onClick='javascript:tagall(1);'>";
	echo "<input type='button' value='��������' onClick='javascript:tagall(0);'>�@";
		$value="99999,�@,0,0";
	echo "�@�Z�ż����G<input id=\"c_$stud_id\" type=\"checkbox\" name=\"sel_stud[]\" value=\"$value\">$sel_kind";  
	echo "<input type='submit' name='Submit' value='�T�w�s�W'>    <input type='reset' name='Submit2' value='���]'></p>";


	echo "<table border=2 cellpadding=7 cellspacing=0 style='border-collapse: collapse' bordercolor='#111111' width='100%'>
	<tr bgcolor='#ffcccc' align='center'><td>�y��</td><td>�m�W</td><td>�s�W</td><td>����(�n��)</td><td>���ɪ�</td><td>�y��</td><td>�m�W</td><td>�s�W</td><td>����(�n��)</td><td>���ɪ�</td><td>�y��</td><td>�m�W</td><td>�s�W</td><td>����(�n��)</td><td>���ɪ�</td></tr><tr align='center'>";
$l=1;    
$ni=1;

while ($row = $result->FetchRow()) {
	$stud_id=$row["stud_id"];
	$num=substr($row["curr_class_num"],-2);
	$stud_name=$row["stud_name"];	
	$value=$stud_id.",".$stud_name.",".$num.",".$ni;
	echo "<td width=35>$num</td><td>$stud_name</td><td width=35><input id=\"c_$stud_id\" type=\"checkbox\" name=\"sel_stud[]\" value=\"$value\"></td><td>$sel_kind</td><td><input type='text' name='guidance_name[$stud_id]' size=8 value=''></td>";  
	if($l==3) {
		echo "</tr><tr align='center'>";
		$l=0;
	}
    $l++;
	$ni++;
}


echo " 
</table>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='class_id' value='$class_id'>
<input type='hidden' name='class_num' value='$class_num'>

</form>";

}else{
        echo " <img src=\"images/stop.gif\" border=\"0\" alt=\"�������\">�������" ; 
}
foot() ;
?>
