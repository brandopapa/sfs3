<?
//$Id: view.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

sfs_check();
$class_base_p = class_base();

    $sqlstr = " select *  from stud_team_sign where kid ='$_GET[kid]'  order by sid " ;

    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
    $i = 1 ;
    while (  $row = $result->FetchRow() ) {
        $class_id = $row["class_id"] ;	
        $class_name = $class_base_p[$class_id] ;	
        $stud_name = $row["stud_name"] ;
        $sign_time  = $row["sign_time"] ;    	
        if ($i>$_GET["stud_max"])
           $bk= "�ƨ�" ;
        else 
           $bk= "����" ;   
        $main .= "<tr><td>$i</td><td>$class_name</td><td>$stud_name</td><td>$sign_time</td><td>$bk</td></tr>\n" ;
        $i++ ;
    }
    $main = "<h2>�Z�O�G$_GET[class_kind] ���W��</h2><table border =1> <tr><td>�s��</td><td>�Z��</td><td>�m�W</td><td>���W�ɶ�</td><td>�O�_����</td></tr>\n
             $main</table>" ;
    echo $main ;         
?>