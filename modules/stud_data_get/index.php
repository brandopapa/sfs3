<?php
//$Id: index.php 7711 2013-10-23 13:07:37Z smallduh $
include "config.php";
include "function.php";

$class_name_arr = class_base() ;	//�Z�Ű}�C
        
//���o���e�G
          
        

if ($_POST[Submit] == "�e�X") {
    
     if ($_POST[data]<>"") 
        $put_data = $_POST[data] ;
     
     $name_array = preg_split("/[\n\s,]+/",$put_data) ;


     for ($i = 0 ; $i < count($name_array); $i++ ) {
         if (trim($name_array[$i])<>"") {
           
            $stud_id_array = Get_stud_name(trim($name_array[$i])) ;
            if (count($stud_id_array) >0)  {
            	for ($j = 0 ; $j < count($stud_id_array) ; $j++) {
            	    $csvdata .=  Get_stud_data($stud_id_array[$j]) ."\n" ;
            	}    
            }	
         	
         }		
     	
     }	
 
	//�H��y�覡�e�X data.csv
	header("Content-disposition: attachment; filename=data.xls");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
     echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">\n" ;
     echo "<table border=1><tr><td>�m�W</td><td>�Ǹ�</td><td>�ͤ�</td><td>�������r��</td><td>�Z��</td><td>�y��</td><td>�ʧO</td><td>�q��</td><td>���q��</td><td>�a�}</td><td>���@�H</td><td>����</td><td>���˦��</td><td>����</td></tr> \n" ;
     echo  $csvdata ;
     echo "</table>" ;
	exit;
	return;     

        
}        




//�{��
sfs_check();

//�q�X�����������Y
head("�ǥͦW���^��");
print_menu($school_menu_p) ;

//�D�n���e
$main="
<form action='' method='post' enctype='multipart/form-data' name='form1'>
  <table width='80%'  border='1'>

    <tr>
      <td><p>�W��G</p>
        <p class='style1'>
          (�H�Ů�γr���Τ����J�m�W�B�Ǹ� �� �Z��+�y��60109)<br>
          �d�ҡG<br>
          ���p��,���p�� <br>
          95001 <br>
          10130
          
      </p>      </td>
      <td><p>
        <textarea name='data' cols='40' rows='10'></textarea> 
        </p>        </td>
    </tr>
    <tr>
      <td colspan='2'><div align='center'>
        <input type='submit' name='Submit' value='�e�X'>
      </div></td>
    </tr>
    <tr bgcolor='#CCCCCC'>
      <td>�����G</td>
      <td>�u��J�m�W�A���o�����ӤH��ơA�|��ץX��csv�榡�C</td>
    </tr>    
  </table>
";
echo $main;

//�G������
foot();

?>
