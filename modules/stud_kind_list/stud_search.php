<?php
// $Id: stud_search.php 5310 2009-01-10 07:57:56Z hami $

  //���J�]�w��
  require("config.php") ;
 
  // �{���ˬd
  sfs_check();
 
  $c_curr_seme = sprintf ("%03s%s",curr_year(),curr_seme()); //�{�b�Ǧ~�Ǵ�  
  $class_name_arr = class_base() ;	//�Z�Ű}�C
  
  head("�j�M");
  //���
  print_menu($menu_p);
  //-----------------------------------------------------------
?>

<form name="form1" method="post" action="<?php echo $PHP_SELF ?>">
  <table width=60% bgcolor="#FDDDAB" align="center" border="1" cellspacing="0" >
    <tr>
      <td align=right width="26%"> �m �W�G<br>
        (�����m�W)</td>
      <td width="74%"> 
        <input type="text" name="searchname"></td></tr>
  <tr>
      <td align=right width="26%"> �� ���G</td>
      <td width="74%"> 
        <input type="text" name="search_id">  </td>
  </tr>
  <tr>
      <td align=right width="26%"> ���@�H�G</td>
      <td width="74%"> 
        <input type="text" name="search_f_name">  </td>
  </tr>  
  <tr>
      <td align=right width="26%"> �q�ܡG</td>
      <td width="74%"> 
        <input type="text" name="search_phon">  </td>
  </tr>    
  <tr>
      <td align=right width="26%"> �a�}�G</td>
      <td width="74%">
        <input type="text" name="search_town">
      </td>
  </tr> 
  <tr>
      <td align=right width="26%"> 
        <input type="submit" name="Submit" value="�e�X"></td>
      <td width="74%"> 
        
      </td>
  </tr></table>  
</form>

<?php
//-----------------------------------
  //�y���B�m�W�B�ͤ�B�a�}�B�q�ܡB�a���B�a���u�@�B�u�@�q��
  
  $Submit =$_POST['Submit'];
  $searchname =$_POST['searchname'];
  $search_id =$_POST['search_id'];
  $search_f_name =$_POST['search_f_name'];
  $search_phon =$_POST['search_phon'];
  $search_town =$_POST['search_town'];
  $search_village =$_POST['search_village'];

  
  $sql_select = "select s.stud_id, s.stud_name, s.stud_person_id , 
                  s.stud_study_cond , s.curr_class_num ,
                  d.guardian_name ,d.fath_name ,d.moth_name 
                  from stud_base as s  LEFT JOIN stud_domicile as d ON s.stud_id=d.stud_id";  
  //$sql_select .= " where s.stud_study_cond = 0 " ;
                   
  if ($Submit =="�e�X") {
	
    if (trim($searchname)<>""){	
        //�ǥͩm�W
   	    $searchname= trim($searchname) ;
   	    //echo $searchname ;
        $searchname = addslashes($searchname);

        $sqlstr = " and s.stud_name like '%".($searchname)."%'"  ;

        //echo $sql_select ;
    }     
    elseif (trim($search_id)<>""){	
        //�Ǹ�
   	    $search_id= trim($search_id) ;
        $sqlstr = " and   s.stud_id like '%$search_id%' "  ;

    }   
    elseif (trim($search_f_name)<>"") {
        //�a���m�W
   	    $search_f_name= trim($search_f_name) ;
        $search_f_name = addslashes($search_f_name);

   	    $sqlstr = " and ( d.guardian_name  like '%" .$search_f_name."%' 
   	                 or  d.fath_name   like '%" .$search_f_name."%' 
   	                or  d.moth_name    like '%" .$search_f_name."%' ) "  ;

        
    }	 
    elseif (trim($search_phon)<>"") {
        //�a���q��
      
   	    $search_phon= trim($search_phon) ;
   	    $sqlstr = " and ( s.stud_tel_1   ='$search_phon' 
   	            or  s.stud_tel_2   ='$search_phon'  
   	            or  s.stud_tel_3  ='$search_phon' ) "  ;

    }	     
    elseif ($search_town) {
        //�a�}
        $search_town = trim($search_town) ;
        $search_town = addslashes($search_town);
        if ($search_town)  
           $sqlstr =  " and  ( s.stud_addr_1   like '%$search_town%' or s.stud_addr_2   like '%$search_town%' ) " ;

    }
    
  }	
   if ($sqlstr) {
   	$sel_year=curr_year();
   	$sel_seme=curr_seme();
   	$query="select * from school_class where year='$sel_year' and semester='$sel_seme'";
   	$res=$CONN->Execute($query);
   	while (!$res->EOF) {
   		$cclass[$res->fields[c_year]][$res->fields[c_sort]]=$res->fields[c_name];
   		$res->MoveNext();
   	}
   	$sqlstr=substr($sqlstr,4);
        $sql_select .= " where $sqlstr  order by stud_study_cond , s.curr_class_num , stud_id ";
        //echo  $sql_select ;
        echo "<table align=center >";
        echo "<tr></td>�ǥͷj�M���G�C��</td></tr><hr>";

       echo "<tr>";
       echo "<td align=center>�Ǹ�</td><td align=center>�Z�O</td><td align=center>�y��</td><td align=center>�m�W</td><td align=center>����</td><td align=center>����</td><td align=center>���@�H</td> ";
       echo "</tr>";

       $result =$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256) ; 
       $i =0;
       while ($row =  $result->FetchRow() ) {
        	$stud_id = $row["stud_id"];
        	$stud_name = $row["stud_name"];
        	$stud_person_id = $row["stud_person_id"];
        	$stud_study_cond  = $row["stud_study_cond"] ;
        	
        	$class_num_curr = $row["curr_class_num"];		//�ثe�Z�šB�y��

        	$classid = intval(substr($class_num_curr,0,3));	//���o�Z��	
        	$class_name_arr[$classid] ;
        	$s_num = intval (substr($class_num_curr,-2));	//�y��
        	  	
       	
        	$d_guardian_name =$row["guardian_name"]  ;
        	$fath_name =$row["fath_name"]  ;
        	$moth_name =$row["moth_name"]  ;

                echo ($i%2 == 1) ? "<tr  BGCOLOR=\"#E2E9F8\" >" : "<tr BGCOLOR=\"#E6F7E2\">";
		echo "<td><a href=\"stu_list.php?stud_id=$stud_id\">$stud_id</a></td>";
        	//echo "<td>" .$class_year[$s_year] . $class_name[$s_class]."�Z</td>";
        	echo "<td>". $class_name_arr[$classid] ."</td>";
        	echo "<td align=right>$s_num</td>";	
        	echo "<td>$stud_name</td>";
       	
        	
        	echo "<td>$fath_name</td>";
        	echo "<td>$moth_name</td>";
        	echo "<td>$d_guardian_name</td>";
                $s_classnum = substr($class_num_curr,0,3);	//�Z�ťN��

        	echo "<td>" ;
            if ($stud_study_cond==0) {

	        $c_curr_class = sprintf("%03s_%s_%02s_%02s",curr_year(),curr_seme(),substr($class_num_curr,0,1),substr($class_num_curr,1,2));
                echo "<a href=\"../stud_base/stud_base.php?stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme\">�򥻸��</a>" ;
            }else 
               echo "(�D�b��)" ;  
            echo "</td>" ;
            
		    echo "</tr>\n";
		    $i++;
          };
          echo "</table>";

   }     
foot();
?>