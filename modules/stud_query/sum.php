<?php
// $Id: sum.php 6534 2011-09-22 09:46:05Z infodaes $

include "stud_query_config.php";

//���o�̦h�Z���~��
for ($y=1; $y<=6 ; $y++) {
    $ty[0]= $y ;	
    $tc = class_base('',$ty) ;	
    $t = count( $tc ) ;
    if ($maxclass < $t) {
       $maxY= $y ;
       $maxclass = $t   ;
    }   	
}	
// --�{�� session 
  sfs_check();


  //$cnum = count($class_name) ;
  $cnum = $maxclass ;

  //���X�ť��Юv�W��
  /*
  $query="select a.teach_id , a.name ,b.class_num FROM teacher_base a , teacher_post b where a.teach_id = b.teach_id and  a.teach_condition = '0' and b.post_office = '8' 
  and  b.teach_title_id < 40
  order by b.class_num ";
  */
  //echo $query ;
  $query="select a.teach_id , a.name ,b.class_num FROM teacher_base a , teacher_post b where a.teacher_sn  = b.teacher_sn  and  a.teach_condition = '0' and b.post_office = '8' 
      order by b.class_num ";
  
  $recordSet=$CONN->Execute($query) or die($query);
  if ($recordSet) 
    while ( $row = $recordSet->FetchRow() ) {
      $classn = $row["class_num"] ;
      $teachname = $row["name"] ;
      $y = substr($classn,0,1) ;
      $c = intval(substr($classn,1)) ;
      $class_tea[$y][$c] = $teachname ;
    }
   
  //�إ߼Ȧs���A�s���@�Ӥ���J��X�����  
  $query = "SELECT *  FROM tmp_stud_move ";  
  $recordSet=$CONN->Execute($query) ;
  if (!$recordSet) {
    $query = "CREATE TABLE tmp_stud_move (
      move_id bigint(20) NOT NULL auto_increment,
      stud_id varchar(20) NOT NULL default '',
      move_kind varchar(10) NOT NULL default '',
      move_date date NOT NULL default '0000-00-00',
      PRIMARY KEY  (move_id)
      );" ;
    $CONN->Execute($query) ;
  }
  //�Ȧs��M��
  $query= " DELETE FROM tmp_stud_move " ;
  $recordSet=$CONN->Execute($query) or die($query);
  
  
  $m = date('m') ;

  $ny = date('Y') ;
  if ($m ==1) {
     $prem= 12 ;
     $prey = $ny-1;  }
  else {
     $prem = $m-1 ;
     $prey = $ny ; 
  }


  //�έp�e�@�Ӥ몺���
  $bdate = $prey ."-". $prem ."-01" ;
  $edate = $ny ."-". $m ."-01" ;

  
  //�Ȧs���
  $query= " DELETE FROM tmp_stud_move " ;
  $recordSet=$CONN->Execute($query) or die($query);  
  $query= " select *  FROM stud_move where move_date >= '$bdate'  and move_kind <>99 " ;
  //echo $query ;
  $recordSet=$CONN->Execute($query) or die($query);  
  while ($row = $recordSet->FetchRow()) {  
    $query2 = " INSERT INTO tmp_stud_move ( move_id , stud_id , move_kind ,  move_date ) 
      VALUES ('0', '$row[stud_id]' , '$row[move_kind]', '$row[move_date]') " ;
    $CONN->Execute($query2) ;
  }     
  
//���o�U�Z�k�k�έp��A�W�Ӥ�b�A	
/*
  $sqlstr= " select LEFT(curr_class_num,3) as Tclass  ,stud_sex, count(*) as TC from stud_base
    where  (stud_study_cond = 0 and  create_date < '$edate')
    or (stud_study_cond <> 0 and  update_time >= '$edate')
    group  by Tclass,stud_sex   " ;
*/
  $query= "select LEFT(s.curr_class_num,3) as Tclass ,s.stud_sex , count(*) as TC
            from stud_base s 
            left join tmp_stud_move m on ( m.stud_id = s.stud_id ) 
    where  (s.stud_study_cond = 0  and m.move_date is NULL )  
      or (s.stud_study_cond = 0  and m.move_date <'$edate'   )
    or (s.stud_study_cond <> 0 and  m.move_date >= '$edate' ) 
    group  by Tclass,s.stud_sex   " ;
  
  //echo     $query ;  
  $recordSet=$CONN->Execute($query) or die($query);
  if ($recordSet) 
    while ($row = $recordSet->FetchRow()) {
      $classn = $row["Tclass"]; 
      $sex = $row["stud_sex"] ; 
      $y = substr($classn,0,1) ;
      $c = intval(substr($classn,1)) ;
      $studn[$y][$c][$sex] = $row["TC"] ;
      $studn[$y][$c][0] += $row["TC"] ;
      $Ystudn[$y][$sex] = $Ystudn[$y][$sex]+$row["TC"] ;              //�U�~�ũʧO�έp
      $Ystudn[$y][0] = $Ystudn[$y][0]+$row["TC"] ;  //�U�~���`��
    }
    //�u�����q�Z
    for ($i=0 ;$i<=2; $i++)
       for($cy=1; $cy<=6;$cy++){ 
           //$mYstudn[$cy][$i] = $Ystudn[$cy][$i]  - $studn[$cy][10][$i] ;    //���q�Z
           //$mM_all[$i] = $mM_all[$i] + $mYstudn[$cy][$i] ; 	//���q�Z�`�H�� 
           $M_all[$i] = $M_all[$i] + $Ystudn[$cy][$i] ; 	//���դH�� 
          // $S_all[$i] = $S_all[$i] + $studn[$cy][10][$i] ; 	//���u�Z 
       }    
           

//�W��H�Ƴ����̦~�šB���O�B�k�k

  $query = "select m.* , s.stud_sex , LEFT(s.curr_class_num,1) as Tclass ,count(*) as TC
             from tmp_stud_move m ,stud_base s 
             where m.stud_id=s.stud_id 
             and m.move_date >= '$bdate' 
             and m.move_date < '$edate'
             and m.move_kind <> '99'
             group by Tclass, s.stud_sex , m.move_kind  ";
  //echo  $query ;
  $recordSet=$CONN->Execute($query) or die($query);

  if ($recordSet) 
    while ($row = $recordSet->FetchRow() ) {
      $Tclass = $row["Tclass"] ; 
      $sex = $row["stud_sex"] ; 
      $cond = $row["move_kind"] ; 
      $addn[$Tclass][$cond][$sex] = $row["TC"] ;
      $addn[$Tclass][$cond][0] = $addn[$Tclass][$cond][0]+ $row["TC"] ;
      //�~�šB���O�B�H��
    }
  for ($y=1 ;$y<=6 ; $y++) {
     for ($cond=1;$cond<=8;$cond++) {
       $kind[$cond][0] += $addn[$y][$cond][0] ;
       $kind[$cond][1] += $addn[$y][$cond][1] ;
       $kind[$cond][2] += $addn[$y][$cond][2] ;
     }

  }
  for ($i= 2; $i>=1 ; $i--){
    $all_in[$i] = $kind[1][$i]+$kind[2][$i]+$kind[3][$i]+$kind[4][$i] ;
    $all_out[$i] = $kind[8][$i]+$kind[6][$i]+$kind[11][$i] ;
  }
  $all_in[0] =   $all_in[1]+ $all_in[2]   ;
  $all_out[0] =   $all_out[1]+ $all_out[2]   ;

/*
���o���e�@�Ӥ�k�k�`�H�Ʋέp��	
*/
  $query= "select s.stud_sex ,s.stud_id, s.stud_name , s.stud_study_cond , m.move_date   ,count(*) as TC
            from stud_base s 
            left join tmp_stud_move m on ( m.stud_id = s.stud_id )
    where  (s.stud_study_cond = 0  and m.move_date is NULL  )  
    or (s.stud_study_cond <> 0 and  m.move_date >= '$bdate') 
    group  by s.stud_sex   " ;

  //echo     $query ;  
  $recordSet=$CONN->Execute($query) or die($query);
  if ($recordSet) 
    while ($row = $recordSet->FetchRow() ) {
      $sex = $row["stud_sex"] ; 
      $pre_studn[$sex] = $row["TC"] ;
    }
  $pre_studn[0]= $pre_studn[1] +$pre_studn[2] ;


          

//include ($head);
?> 
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<style type="text/css">
<!--
.trt {  font-size: 16px; text-align: center }
.trs {  font-size: 12px; text-align: center ; background-color: #FFFFFF}
.ts10 {  font-size: 12px; width: 0.5cm; text-align: center}
.ts20 {  font-size: 12px; width: 1.2cm; text-align: center}
.ts30 {  font-size: 12px; text-align: center; width: 1.5cm}
-->
</style>

<body bgcolor="#FFFFFF" text="#000000">
<table width="900" border="0" cellspacing="0" cellpadding="2" class="trs" bordercolor=\"#000000\" >
  <tr class="trt">
 <td>���</td>
 <td><? echo $school_long_name ."�X�u�β��ʪ��p���i��" ?></td>
 <td><? echo $ny-1911 . "�~" .$prem ."���" ?></td>
</tr>
</table>

<table width="1280" border="1" cellspacing="0" cellpadding="2" class="trs" bordercolor=\"#000000\">
  <tr class="trt"><td colspan="<? echo $cnum*3+2+15 ?>" >������b�y�ǥͼƤ@����H��</td>
</tr>
  <tr class="trs"> 
    <td rowspan="2" class="ts20">�~��</td>
    <td rowspan="2" class="ts30">\�Z��<br>
      ���O\</td>
<?php
    
    //while(list($tkey,$tvalue)= each ($class_name)) 
    //   echo "<td colspan=\"3\" class=\"ts30\">" . $class_name[$tkey] ."�Z</td>" ;
    $ty[0] = $maxY ;
    $className = class_base('',$ty)   ;
    foreach( $className as $k=>$v) 
      echo "<td colspan=\"3\" class=\"ts30\">" . substr($v,4) ."</td>" ;
    echo "<td colspan=\"3\" class=\"ts30\">��J</td>
          <td colspan=\"3\" class=\"ts30\">���</td>
          <td colspan=\"3\" class=\"ts30\">��X</td>
          <td colspan=\"3\" class=\"ts30\">�`�p</td>" ;
    echo "</tr><tr class=\"trs\"> " ;
    //���
    for ($i= 0 ; $i<$cnum ; $i++) 
      echo "<td >�k</td><td >�k</td><td >�p</td>" ;
    //��b�q
    echo "<td >�k</td><td >�k</td><td >�p</td>" ;
    echo "<td >�k</td><td >�k</td><td >�p</td>" ;
    echo "<td >�k</td><td >�k</td><td >�p</td>" ;
    echo "<td >�k</td><td >�k</td><td >�p</td>" ;
   // echo "<td >�k</td><td >�k</td><td >�p</td>" ;
    echo "</tr>\n" ;

    for ($y=1 ; $y<=6 ; $y++) {
      echo "<tr><td rowspan=\"2\" class=\"ts20\">" .$class_year[$y] ."</td>" ;
      echo " <td  class=\"ts30\">�b�y��</td>" ;    	
      for ($i= 0 ; $i <$cnum ; $i++) { 
         if ($studn[$y][$i+1][1]) { 
           echo "<td class=\"st10\">" . $studn[$y][$i+1][1] . "</td>" ;
           echo "<td class=\"st10\">" . $studn[$y][$i+1][2] . "</td>" ;
           echo "<td class=\"st10\">" . $studn[$y][$i+1][0] . "</td>" ;
           $allsum[1] +=  $studn[$y][$i+1][1] ;
           $allsum[2] +=  $studn[$y][$i+1][2] ;
         }
         else  { 
           echo "<td class=\"st10\">&nbsp;</td>" ;
           echo "<td class=\"st10\">&nbsp;</td>" ;
           echo "<td class=\"st10\">&nbsp;</td>" ;
         }

      }
      //��J
      echo "<td>".$addn[$y][2][1] ."&nbsp;</td><td>" . $addn[$y][2][2] ."&nbsp;</td><td>".$addn[$y][2][0] ."&nbsp;</td>" ;
      //���
      echo "<td>".$addn[$y][6][1] ."&nbsp;</td><td>" .$addn[$y][6][2] ."&nbsp;</td><td>".$addn[$y][6][0] ."&nbsp;</td>" ;
      //��X
      echo "<td>".$addn[$y][8][1] ."&nbsp;</td><td>" .$addn[$y][8][2] ."&nbsp;</td><td>".$addn[$y][8][0] ."&nbsp;</td>" ;
      //���q�Z
 
      // echo "<td>". $mYstudn[$y][1]  ."&nbsp;</td><td>" .$mYstudn[$y][2] ."&nbsp;</td><td>".$mYstudn[$y][0] ."&nbsp;</td>" ;
      //�����Z
      echo "<td>".$Ystudn[$y][1]  ."&nbsp;</td><td>" .$Ystudn[$y][2] ."&nbsp;</td><td>".$Ystudn[$y][0] ."&nbsp;</td>" ;

      echo "</tr>\n<tr>" ;
      echo "<td  class=\"ts30\">�ť�</td>" ;
      for ($i= 0 ; $i <$cnum ; $i++) { 
         echo "<td colspan=\"3\" class=\"st30\">" ;
         if ( $class_tea[$y][$i+1] ) echo  $class_tea[$y][$i+1] ."</td>" ;
         else echo "&nbsp;</td>" ;

      }      
      //��b�q
      echo "<td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>" ;
      echo "<td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>" ;
      echo "<td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>" ;
      echo "<td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>" ;
      //echo "<td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>" ;
      echo "</tr>\n" ;        
    }  
    echo "<tr class=\"ts30\"><td colspan=". (($cnum+1)*3-1) .">&nbsp;</td>" ;   
    //���u�Z�έp
    //echo "<td>". $S_all[1] . "</td><td>". $S_all[2] . "</td><td>". ($S_all[1]+$S_all[2]) . "</td>" ;
      //��J
    echo "<td>".$kind[2][1] ."&nbsp;</td><td>" .$kind[2][2] ."&nbsp;</td><td>".$kind[2][0] ."&nbsp;</td>" ;
      //���
    echo "<td>".$kind[6][1] ."&nbsp;</td><td>" .$kind[6][2] ."&nbsp;</td><td>".$kind[6][0] ."&nbsp;</td>" ;
      //��X
    echo "<td>".$kind[8][1] ."&nbsp;</td><td>" .$kind[8][2] ."&nbsp;</td><td>".$kind[8][0] ."&nbsp;</td>" ;
      //���q�Z
    //echo "<td>". $mM_all[1]  ."&nbsp;</td><td>" .$mM_all[2] ."&nbsp;</td><td>".$mM_all[0] ."&nbsp;</td>" ;

      //�����Z
    echo "<td>".$M_all[1]  ."&nbsp;</td><td>" .$M_all[2] ."&nbsp;</td><td>".$M_all[0] ."&nbsp;</td>" ;

    echo "</tr>\n" ;
?> 
 
</table>
<table width="900" border="1" cellspacing="0" cellpadding="2" class="trs" bordercolor=\"#000000\">
  <tr class="trs"> 
    <td rowspan="5" >�ʺA</td>
    <td rowspan="5" >���ʪ��A</td>
    <td rowspan="2" >���O</td>
    <td rowspan="2"  class="ts20">�e�륽<br>
      �b�y��</td>
    <td colspan="6">���뤤�W�[�ǥͼ�</td>
    <td colspan="7">���뤤��־Ǽ�</td>
    <td colspan="2">���</td>
    <td rowspan="2"  class="ts30">����b�y��</td>
    <td rowspan="2"  class="ts30">�ʮu�`��</td>
    <td rowspan="2"  class="ts30">�X�u�v</td>
    <td rowspan="5" >������X�u���p</td>
    <td rowspan="2"  class="ts30">����ʮu���p</td>
    <td rowspan="2"  class="ts30">�X�u�`��</td>
  </tr>
  <tr> 
    <td class="ts20" >�J��</td>
    <td  class="ts20">��J</td>
    <td  class="ts20">�_��</td>
    <td  class="ts20">�d��</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20">�p</td>
    <td  class="ts20">��X</td>
    <td  class="ts20">���</td>
    <td  class="ts20">�h��</td>
    <td  class="ts20">���`</td>
    <td  class="ts20">���~</td>
    <td  class="ts20">�d��</td>
    <td  class="ts20">�p</td>
    <td class="ts20">�W</td>
    <td  class="ts20">��</td>
  </tr>
  <tr> 
    <td >�k</td>
    <td  class="ts20"><? echo $pre_studn[1] ?></td>
    <td  class="ts20"><? echo $kind[1][1] ?>&nbsp;</td>
    <td  class="ts20"><? echo $kind[2][1]+$kind[12][1] ?>&nbsp;</td>
    <td  class="ts20"><? echo ($kind[3][1]+$kind[4][1]) ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20"><? echo $all_in[1] ?>&nbsp;</td>
    <td  class="ts20"><? echo $kind[8][1] ?>&nbsp;</td>
    <td  class="ts20"><? echo $kind[6][1] ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20"><? echo $kind[11][1] ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20"><? echo $all_out[1] ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts30"><? echo $allsum[1] ?></td>
    <td  class="ts30">&nbsp;</td>
    <td  class="ts30">&nbsp;</td>
    <td  class="ts30">&nbsp;</td>
    <td  class="ts30">&nbsp;</td>
  </tr>
  <tr> 
    <td >�k</td>
    <td  class="ts20"><? echo $pre_studn[2] ?></td>
    <td  class="ts20"><? echo $kind[1][2] ?>&nbsp;</td>
    <td  class="ts20"><? echo $kind[2][2]+$kind[12][2]  ?>&nbsp;</td>
    <td  class="ts20"><? echo ($kind[3][2]+$kind[4][2]) ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20"><? echo $all_in[2] ?>&nbsp;</td>
    <td  class="ts20"><? echo $kind[8][2] ?>&nbsp;</td>
    <td  class="ts20"><? echo $kind[6][2] ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20"><? echo $kind[11][2] ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20"><? echo $all_out[2] ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts30"><? echo $allsum[2] ?></td>
    <td  class="ts30">&nbsp;</td>
    <td  class="ts30">&nbsp;</td>
    <td  class="ts30">&nbsp;</td>
    <td  class="ts30">&nbsp;</td>
  </tr>
  <tr> 
    <td >�p</td>
    <td  class="ts20"><? echo $pre_studn[0] ?></td>
    <td  class="ts20"><? echo $kind[1][0] ?>&nbsp;</td>
    <td  class="ts20"><? echo $kind[2][0]+$kind[12][0] ?>&nbsp;</td>
    <td  class="ts20"><? echo ($kind[3][0]+$kind[3][0]) ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20"><? echo $all_in[0] ?>&nbsp;</td>
    <td  class="ts20"><? echo $kind[8][0] ?>&nbsp;</td>
    <td  class="ts20"><? echo $kind[6][0] ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20"><? echo $kind[11][0] ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20"><? echo $all_out[0] ?>&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts20">&nbsp;</td>
    <td  class="ts30"><? echo $allsum[1]+ $allsum[2] ?></td>
    <td  class="ts30">&nbsp;</td>
    <td  class="ts30">&nbsp;</td>
    <td  class="ts30">&nbsp;</td>
    <td  class="ts30">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">�Ƶ�</td>
    <td colspan="22">������W�Ҥ�� &nbsp; &nbsp;&nbsp; ��</td>
  </tr>
</table>
<table width="720" border="0" cellspacing="0" cellpadding="0" align="left" >
<tr class="trs">
<td>�ժ�</td>
<td>&nbsp;</td>
<td>�аȳB�D��</td>
<td>&nbsp;</td>
<td>���U�ժ�</td>
<td>&nbsp;</td>
<td><? echo $ny-1911 . "�~" .$m ."��". date('d') ."����" ?></td>
</tr>
</table>


<? //include ($foot);	?>