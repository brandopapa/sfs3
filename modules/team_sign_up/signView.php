<?
//$Id: signView.php 7712 2013-10-23 13:31:11Z smallduh $
include "config.php";

sfs_check();

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
if ( !checkid($SCRIPT_FILENAME,1)){
    head("���W���]�p") ;
    print_menu($school_menu_p);
    echo "�L�޲z���v���I<br>�жi�J �t�κ޲z / �Ҳ��v���޲z �ק� stud_sign �Ҳձ��v�C" ;
    foot();
    exit ;
    
    //Header("Location: signList.php"); 
}

   //�C�X�U�~���Z��� 
    $sqlstr =" select *  from stud_team_kind   where mid = '$_GET[id]'  " ;
	//echo $sqlstr ;
    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    $i = 1 ;
    while (  $row = $result->FetchRow() ) {
      $kid = $row["id"] ;
      $mid = $row["mid"] ;
      $class_kind = $row["class_kind"] ;
      $stud_max = $row["stud_max"] ;
      $stud_ps = $row["stud_back"] ;
      $class_max = $row["class_max"] ;
      $week_set = $row["week_set"] ;
      $year_set = $row["year_set"] ;     
      $cost = $row["cost"] ;   
      $main .= Get_kind_stud_List($kid,$class_kind,$stud_max,$stud_ps,$cost)  ;
    }
    
	//�H��y�覡�e�X data.csv
	header("Content-disposition: attachment; filename=data.csv");
	header("Content-type: text/x-csv");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
  echo "�Z�O,�O��,�s��,�Z��,�m�W,�q��,���q��,��ʹq��,���W�ɶ�,�O�_����\n" ;
  
  echo $main   ;


function Get_kind_stud_List($kid,$class_kind,$stud_max,$stud_ps,$cost) {      
    global $CONN  ;
    $class_base_p = class_base();
    $sqlstr = " select *  from stud_team_sign where kid ='$kid'  order by sid " ;

    $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
    $i = 1 ;
    while (  $row = $result->FetchRow() ) {
        $class_id = $row["class_id"] ;	
        $class_name = $class_base_p[$class_id] ;	
        $stud_name = $row["stud_name"] ;
        $stud_id = $row["stud_id"] ;
        $sign_time  = $row["sign_time"] ;    	
        if ($i>$stud_max)
           $bk= "�ƨ�" ;
        else 
           $bk= "����" ;   
        $phon = Get_stud_phon($stud_id);      
        $main .= "$class_kind, $cost ,$i,$class_name,$stud_name,$phon,=T(\"$sign_time\"),$bk\n" ;
        $i++ ;  
    }

    return $main ;         
}    


function Get_stud_phon($stud_id) {
     //�ѯZ��+�y���� $get_arr �}�C�����o�G�m�W....
     global $CONN   ;



    $sql="select * from  stud_base  
           where  stud_id  = '$stud_id'   and stud_study_cond = 0   ";

    //�y���B�m�W�B�ͤ�B�a�}�B�q�ܡB�a���B�a���u�@�B�u�@�q��

    $result = $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256) ;
    
    
    $row = $result->FetchRow() ;

	$s_home_phone = $row["stud_tel_1"]  ;	//�a���q��
	$s_offical_phone =$row["stud_tel_2"]  ;	//�u�@�a�q��
	$s_cell_phone =$row["stud_tel_3"]  ;	//�u�@�a�q��
	$data_str  = "=T(\"$s_home_phone\"),=T(\"$s_offical_phone\"),=T(\"$s_cell_phone\")" ;

    
    return $data_str  ;
      	
}		
?>