<?php

// $Id: stud_data.php 6410 2011-04-19 03:44:27Z infodaes $

// --�t�γ]�w��
require("config.php") ;

//--�{�� session
sfs_check();



$c_curr_seme = sprintf ("%03s%s",curr_year(),curr_seme()); //�{�b�Ǧ~�Ǵ�  

$class_list_p = class_base(); //�Z�ŦC��

//�L�X���Y
head("��Ƥ�����");
print_menu($menu_p);

?>

<table border="0" width="100%" cellspacing="0" cellpadding="0" >
<tr><td valign=top bgcolor="#CCCCCC">


<? 

 echo '<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body align="center" >' ;
 echo "<tr class='title_sbody1'><td>�N��</td><td>�m�W</td><td>�Z��</td><td>�y��</td><td>�ͤ�(�褸)</td><td>�����Ҧr��</td><td>�a�}</td><td>���@�H</td><td>�q��</td>\n";
if(checkid($_SERVER['SCRIPT_FILENAME'],1)) {
 $sqlstr = " select * from stud_base as s  LEFT JOIN stud_domicile as d ON s.stud_id=d.stud_id  
            where s.stud_study_cond =0 
            and ( ( s.stud_addr_c ='' or s.stud_birthday='0000-00-00' or right(s.curr_class_num,2)='00'  or s.stud_tel_1='') 
            or (d.fath_name='' and d.moth_name='' and d.guardian_name='') )
            order by  curr_class_num        " ;

	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
	while ($row = $result->FetchRow() ) {

	$s_addres = $row["stud_addr_1"] ;
        $s_home_phone = $row["stud_tel_1"]  ;	//�a���q��

        $d_guardian_name = $row["guardian_name"] ;
        $class_num_curr = $row[curr_class_num] ;
        $stud_id = $row[stud_id] ;
        
        $tclass =  substr( $class_num_curr ,0,3) ;
	echo ($i%2 == 1) ? "<tr class='nom_1' >" : "<tr class='nom_2'>";

        $c_curr_class = sprintf("%03s_%s_%02s_%02s",curr_year(),curr_seme(),substr($class_num_curr,0,1),substr($class_num_curr,1,2));
        $stud_id_link = sprintf("<a href=\"../stud_reg/stud_list.php?stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme\"> %s</a>" ,$stud_id ) ; 

        echo sprintf("<td>%s</td><td>%s</td>",$stud_id_link,$row[stud_name]);
		echo sprintf("<td>%s</td><td>%d&nbsp;</td><td>%s&nbsp;</td><td>%s&nbsp;</td>", $class_list_p[$tclass],substr($row[curr_class_num],-2),$row[stud_birthday],$row[stud_person_id]); 
        echo "<td>$s_addres&nbsp;</td>" ;
        echo "<td>$d_guardian_name &nbsp;</td>" ;
        echo "<td>$s_home_phone &nbsp;</td>" ;


		echo"</tr>\n";
        $i++ ;

	}
}            
?>

</tr>
</table>

</td></tr></table>

<?php foot() ?>
