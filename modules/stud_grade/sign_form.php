<?php
//���J�]�w��
require("config.php") ;

// �{���ˬd
sfs_check();

$class_year_p = class_base(); //�Z��

($IS_JHORES==0) ? $UP_YEAR=6:$UP_YEAR=9;//�P�_�ꤤ�p
//�W�[�ɾǪ��ǮզW�����
$rs01=$CONN->Execute("select new_school from grad_stud where 1");
if(!$rs01) $CONN->Execute("ALTER TABLE grad_stud ADD new_school varchar(40)");

	
$curr_year = curr_year() ;
	
$Submit =$_POST['Submit'];
$curr_grade_school =$_POST['curr_grade_school'];

if ($Submit=="�P�B��") {
	/*
	$sqlstr = "select s.student_sn, s.stud_id, s.curr_class_num, g.grad_sn, g.student_sn as sn  from stud_base as s LEFT JOIN grad_stud as g ON s.stud_id=g.stud_id  where s.stud_study_cond in ('0','15') and s.curr_class_num like '$UP_YEAR%' and g.stud_grad_year='$curr_year'";   
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
	while ($row = $result->FetchRow() ) {    
		$stud_id = $row["stud_id"] ;
		$student_sn = $row['student_sn'];
		$grad_sn = $row["grad_sn"];
		$y = substr($row["curr_class_num"],0,1) ;
		$c = substr($row["curr_class_num"],1,2) ;
		if ($grad_sn>0 && $row['sn']==0) {
			$query = "update grad_stud set student_sn='$student_sn' where grad_sn='$grad_sn'";
			$CONN->Execute($query);
			} elseif ($grad_sn==0){ //�w�s�b���
			$sqlstr = "insert into grad_stud (grad_sn , stud_grad_year , class_year,  class_sort,  stud_id, student_sn, new_school  )
						  values ('0',  '$curr_year','$y', '$c', '$stud_id', '$student_sn',  '')  " ;
			$rs2 =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
			//echo $sqlstr;
		}
	} 
	*/
	//�s���{���X  ���N�J�������R��  �A���s�̷Ӳ{�b���~�~�Ū��ǥͭ��s�إ�
	$sqlstr = "DELETE FROM grad_stud WHERE stud_grad_year='$curr_year'";   
	$result =$CONN->Execute($sqlstr) or user_error("�R�����ѡI<br>$sqlstr",256);
	
	$sqlstr = "select student_sn,stud_id,curr_class_num from stud_base where stud_study_cond in ('0','15') and curr_class_num like '$UP_YEAR%'";   
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
	while ($row = $result->FetchRow() ) {
		$stud_id = $row["stud_id"] ;
		$student_sn = $row['student_sn'];
		$y = substr($row["curr_class_num"],0,1) ;
		$c = substr($row["curr_class_num"],1,2) ;

		$values.="('0','$curr_year','$y','$c','$stud_id','$student_sn',''),";		
	}
	$values=substr($values,0,-1);
	$sqlstr = "insert into grad_stud (grad_sn , stud_grad_year , class_year,  class_sort,  stud_id, student_sn, new_school  ) values $values" ;
	$rs2 =$CONN->Execute($sqlstr) or user_error("�P�B�ƥ��ѡI<br>$sqlstr",256); 
}


if (($Submit=="�]�w�Ǯ�") and $curr_grade_school) {
   //�w�]�����ǥ�  �ɾǨ�S�w�Ǯ�  
   //$sqlstr = "select s.stud_id ,s.curr_class_num , g.grad_sn  from stud_base as s ,grad_stud as g 
   //         where  s.stud_id=g.stud_id and  s.stud_study_cond = '0'  and s.curr_class_num like '$UP_YEAR%' ";
   $sqlstr = "select s.stud_id ,s.curr_class_num , g.grad_sn  from stud_base as s ,grad_stud as g 
            where  s.student_sn=g.student_sn and  s.stud_study_cond = '0'  and s.curr_class_num like '$UP_YEAR%' ";
   //�j�M����Ns.stud_id=g.stud_id�ק令 s.student_sn=g.student_sn�A�קK���~�ͤQ�~�Ǹ����ư��D  modify by kai,103.4.30 
                
   $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
   while ($row = $result->FetchRow() ) {    
        $stud_id = $row["stud_id"] ;
        $grad_sn = $row["grad_sn"];
        $y = substr($row["curr_class_num"],0,1) ;
        $c = substr($row["curr_class_num"],1,2) ;
        if ($grad_sn>0) { //�w�s�b���
          $sqlstr = " update grad_stud set stud_grad_year = '$curr_year', class_year = '$y' , class_sort = '$c' ,new_school = '$curr_grade_school'
                        where grad_sn = '$grad_sn' ";
        //else 
         // $sqlstr = "insert into grad_stud (grad_sn , stud_grad_year , class_year,  class_sort,  stud_id,new_school  )
         //             values ('0',  '$curr_year','$y', '$c', '$stud_id',  '$curr_grade_school')  " ;
        	$rs2 =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
	}
   }              

}


if ($Submit=="�̯Z�Ůy���]�w���Ѧr��" or $Submit=="�̾Ǹ��]�w���Ѧr��") {
	
	if($Submit=="�̯Z�Ůy���]�w���Ѧr��") $order="order by s.curr_class_num"; else  $order="order by s.stud_id";
	
   $kword = "(".$curr_year.")".$grade_word;  //�E�@�n�粦�r
   $m_str = "%0" . $grade_num_len ."d" ;        //�e��� 0
   
   $id =0 ;

   //$sqlstr = "select s.stud_id ,s.curr_class_num , g.grad_sn  from stud_base as s  LEFT JOIN grad_stud as g ON s.stud_id=g.stud_id 
   //         where s.stud_study_cond = '0'  and s.curr_class_num like '$UP_YEAR%' order by s.curr_class_num  ";    
   $sqlstr = "select s.stud_id ,s.curr_class_num , g.grad_sn  from stud_base as s , grad_stud as g 
            where s.stud_study_cond = '0' and  s.student_sn=g.student_sn  and s.curr_class_num like '$UP_YEAR%' $order";
            //�j�M����Ns.stud_id=g.stud_id�ק令 s.student_sn=g.student_sn�A�קK���~�ͤQ�~�Ǹ����ư��D  modify by kai,103.4.30    

   $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
   while ($row = $result->FetchRow() ) {    
        $stud_id = $row["stud_id"] ;
        $grad_sn = $row["grad_sn"];
        $y = substr($row["curr_class_num"],0,1) ;
        $c = substr($row["curr_class_num"],1,2) ;        
        $id ++ ;
        $id_word = sprintf($m_str , $id ) ;
        if ($grad_sn>0) { //�w�s�b���
          $sqlstr = " update grad_stud set stud_grad_year = '$curr_year', class_year = '$y' , class_sort = '$c' ,
                      grad_word = '$kword' , grad_num = '$id_word'
                        where grad_sn = '$grad_sn' ";
        //else 
        //  $sqlstr = "insert into grad_stud (grad_sn , stud_grad_year , class_year,  class_sort,  stud_id , grad_word , grad_num )
          //            values ('0',  '$curr_year','$y', '$c', '$stud_id', '$kword' , '$id_word')  " ;
        	$rs2 =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;       
	}
   }                                   
    
}        
        
//���o�ɾǾǮ�
$grade_school = get_grade_school_table();
$def_grade_school = get_grade_school();

// �d�ݬO�_�w�����

$query = "SELECT COUNT(*) AS cc FROM grad_stud WHERE stud_grad_year = '$curr_year'";
$res = $CONN->Execute($query) or die($query);
$cc = $res->fields['cc'];

head() ;  

print_menu($menu_p);
?>

<table width=100% bgcolor="#CCCCCC" >
  <tr><td align="center">
<div align="center">

        <p><b>
          <?php echo curr_year(); ?>
          �Ǧ~�ײ��~�ǥͤ@����</b> 
        <form name="form1" method="post" action="<?php echo $PHP_SELF ?>">
          <table width="70%" cellspacing='0'  cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF' border='1' bgcolor='#99CCCC' >
	  <tr> 
              <td bgcolor="#99CCCC"> 
                <div align="center">�P�B�������ǥ͸��
                  <input type="submit" name="Submit" value="�P�B��" onClick="return confirm('�P�B�ƫ�~~\r\n�|�N���Ǧ~�׭즳�����~�ͧ@�~��ƧR��\r\n�è̾ڥثe�Ҧ�����[�b�y]�P[�b�a�ۦ�Ш|]�ǥͦW�歫�s�i��]�w\r\n\r\n�T�w�n�o�򰵡H')">
                  </div>
              </td>
            </tr>
	    
            <tr> 
              <td bgcolor="#99CCCC"> 
                <div align="center">�����w�]�ɾǦ� 
                  <select name="curr_grade_school">
                    <option value=''>---</option>
                    <?php
                    foreach($def_grade_school as $tkey => $tvalue ) 
	                echo  sprintf("<option value='%s'>%s</option>\n",$tvalue,$tvalue);

                  ?>
                  </select>
                  <input type="submit" name="Submit" value="�]�w�Ǯ�" <?php if ($cc==0) echo "disabled" ?> >
                </div>
              </td>
            </tr>
            <tr> 
              <td bgcolor="#99CCCC"> 
                <div align="center"> 
                  <input type="submit" name="Submit" value="�̯Z�Ůy���]�w���Ѧr��" <?php if ($cc==0) echo "disabled" ?>>
                  �@�@<input type="submit" name="Submit" value="�̾Ǹ��]�w���Ѧr��" <?php if ($cc==0) echo "disabled" ?>>
                  <br></div>
              </td>
            </tr>
          </table>
        </form>
        <table cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="80%" border="1" >

      <tr class=title_sbody1>
        <td  align="center" >
          �Z��
        </td>
        <td  align="center" >
          �k�ͤH��</td>
        <td  align="center"  >
          �k�ͤH��</td>
          <?php
          	if (count($grade_school)>0){
		
          		foreach ( $grade_school as   $tkey => $tvalue  ){   
          			echo '<td colspan=2 align="center" >';
	          		echo '�ɾǦ� '.$tvalue.'</td>';
        	  	}
		}	
          ?>
        <td  align="center" width="77" >�X�p</td>
      </tr>

<?php
	//$query = "select count(stud_sex=1) as boy , count(stud_sex=2) as girl, count(*) as cc,substring(curr_class_num,1,3)as classn  ";
        $sqlstr = " select sum(s.stud_sex=1) as boy , sum(s.stud_sex=2) as girl, count(*) as cc,substring(s.curr_class_num,1,3) as classn  "; 

                  
if (count($grade_school)>0){
	foreach ( $grade_school as   $tkey => $tvalue  ){  
		$tvalue = addslashes($tvalue); 
		$sqlstr .= ",sum(g.new_school ='$tvalue' and s.stud_sex=1) as m_$tkey ";
		$sqlstr .= ",sum(g.new_school ='$tvalue' and s.stud_sex=2) as l_$tkey ";
	}
}

$sqlstr .= "from stud_base as s  LEFT JOIN grad_stud as g ON s.student_sn=g.student_sn 
            where g.stud_grad_year=".curr_year()." and s.stud_study_cond = '0'  and s.curr_class_num like '$UP_YEAR%' group by classn ";
//echo $sqlstr ;

$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
while ($row = $result->FetchRow() ) {
	$boy = $row[boy];
	$girl = $row[girl];
	$tol = $row[cc];
	$classn = $row["classn"] ;
	$classn = $class_year_p[$classn];
	if ($i++ % 2 ==0)
		echo '<tr class=nom_1>' ;
	else
		echo '<tr class=nom_2>' ;
	$tboy += $boy;
	$tgirl += $girl;
	$ttol += $tol;
?>


        <td align="center"  >
          <?php echo $classn ?>
        </td>
        <td align="center"  >
          <?php echo $boy ?>
        </td>
        <td align="center"  >
         <?php echo $girl ?>
        </td>
         <?php
          	if (count($grade_school)>0) {
         		reset($grade_school);
	         	$x =0;
        	  	while(list($tkey,$tvalue)= each ($grade_school)) {
          			$mmm ="m_$tkey" ;
          			$mmm = $row[$mmm];
		      		$lll ="l_$tkey" ;
          			$lll = $row[$lll];
		         	$a_mmm[$x] += $mmm;
          			$a_lll[$x++] += $lll;          		
	          		echo '<td align="center" >';
        	 		echo $mmm;
        			echo '</td>';
        			echo '<td align="center"  >';
	         		echo $lll;
        			echo '</td>';
          		}          		
		}
         ?>
        <td align="center" >
           <?php echo $tol ?>
        </td>
      </tr>
  
<?php 
}
?>
       <tr class=title_sbody1>
        <td align="center" >
          �X�p
        </td>
        <td align="center" >
          <?php echo $tboy ?></td>
        <td align="center" >
          <?php echo $tgirl ?></td>
         <?php 
         for ($i=0;$i<count($grade_school);$i++) { 
        	echo '<td align="center" >'.$a_mmm[$i].'</td>';
        	echo '<td align="center" >'.$a_lll[$i].'</td>';
         }
          ?>
        <td align="center" ><?php echo $ttol ?></td>
      </tr>

  </table>
</div>
</table>
<?php
foot() ;
?>
