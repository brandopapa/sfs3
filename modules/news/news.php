<?php
  //$Id: news.php 6525 2011-09-19 07:36:15Z infodaes $
  require "config.php";
 //sfs_check();
  //$debug = 1;
  $query = trim($_POST['query']) ;
  $sortmode = $_GET['sortmode'] ;
  $msg_id = $_GET['msg_id'] ;
  $showpage = $_GET['showpage'] ;
  $poster = addslashes($_GET['poster']) ;
  
  $Submit = $_POST['Submit'] ;
  if (!$query)
     $query = $_GET['query'] ;
  
  
  if ($query) $do = "search" ;
  
  $pre_day = GetdayAdd(date("Y-m-d"),$showdays*-1) ;
  $today = date("Y-m-d") ;

  //���o�o�G�̸��
  $sqlstr = "SELECT poster_job , count(*) as dd  FROM $tbname  where msg_date > '$pre_day' and poster_job<>'' group by  poster_job " ;
  $result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
  while ($row = $result->FetchRow() ) {
      $job_array[] =  $row["poster_job"] ;
  } 
  foreach ($job_array as $key =>$v ) {
    if ($v == $poster)
       $sel_poster .= "<option value=\"$v\" selected >$v \n" ;
    else    
       $sel_poster .= "<option value=\"$v\">$v \n" ;
  }  
  
  $sel_poster =  "<select name=\"poster\" onChange=\"changepage()\" > \n<option value=\"\">��ܥ������ \n " . $sel_poster . "</select>" ;
  
  if ($poster) 
     $where_poster = " and poster_job ='$poster'  " ;
    
  //�ⴿ�m�����w�L������ơA�m���]�w����
  $tsqlstr =  " update $tbname  SET `msg_date_expire` = NULL , TopNews='0' where msg_date_expire < '$today' and TopNews<>'0' " ; 	
  $result = $CONN->Execute( $tsqlstr) ; 

    
  //Ū����Ʈw
  $sqlstr = "SELECT * FROM $tbname  " ;
  if ($do == "search" ){
     $sqlstr =$sqlstr .  " where    ((msg_body like '%$query%') or (msg_subject like '%$query%') )  $where_poster " ;
  }
  else  {
      $sqlstr =$sqlstr . " where ( (msg_date > '$pre_day' and msg_date_expire  is null) or  ( msg_date_expire >= '$today' ) )  $where_poster " ;
  }

   
  //�ƧǤ覡   
  switch ($sortmode) {  
    case 0:  	
        
        if ($do=="search") 
           $sqlstr .= " order by msg_id DESC " ;       
        else         
           $sqlstr .= " order by TopNews DESC ,msg_id DESC " ;  
        break ;
    case 1:
        $sqlstr .= " order by msg_date DESC " ;  
        break ;
    case 2:
        $sqlstr .= " order by msg_hit DESC " ;  
        break ;         
  }      

  if ($debug ) echo $sqlstr ;


  //�p�⭶��
  $result = $CONN->Execute( $sqlstr) ;
  if ($result) {
    $totalnum = $result->RecordCount() ;
    $totalpage =ceil( $totalnum / $msgs_per_page) ;
    
    if (!$showpage)  $showpage = 1 ;  
 
  }  

  if (!$totalpage) $totalpage= 1 ;
  
  head("���G��");
  include "head.php" ; //�W����Y�C


//<!----------------------------------------------------------------------------------
//                                     �n��ܤ�󤺮e
//------------------------------------------------------------------------------------>
if ($msg_id) {
  //�[�@��	 
  $tsqlstr =  " update $tbname set msg_hit = msg_hit+1 where msg_id='$msg_id' " ; 	
  $result = $CONN->Execute( $tsqlstr) ; 
  
  //Ū������
  $tsqlstr =  " SELECT * FROM $tbname where msg_id = $msg_id " ; 
  $result = $CONN->Execute( $tsqlstr) ;   
  if($result) {
    $nb = $result->FetchRow()  ;	
    
    userdata($nb[userid]) ;	
    

    //�u���G�b�դ�
        $inschool = $nb["inSchool"] ;
        if ($inschool and (!check_home_ip()) ) {
            $is_stop = true ;
            $picstr = $stop_icon ; }
        else 
            $is_stop = false ;
?>

<table border="0" cellpadding="1" cellspacing="1" align="center" width="90%" bgcolor="#EBEBEB"
	bordercolor="#FFFFFF">
  <tr bgcolor="#006699" class="titleshow"> 
    <th  align="center" nowrap width="5%" valign="top" class="titleshow"> �s�� </th>
    <th  align="center" nowrap width="60%" valign="top" class="titleshow"> �D �� 
    </th>
    <th  align="center" nowrap  valign="top" class="titleshow"> ¾�� 
    </th>
    <th align="center" nowrap  valign="top" class="titleshow"> ���i�H 
    </th>
    <th align="center" nowrap  valign="top" class="titleshow"> �\�� 
    </th>
    <th  align="center" nowrap width="110" valign="top" class="titleshow"> ���i��� 
    </th>
  </tr>
  <tr bgcolor="D8E9FE" class="bodytext"> 
    <td align="center"  width="5%" valign="top" class="bodytext"><?php echo $nb[msg_id] ?></td>
    <td align="left"  width="60%" valign="top" class="bodytext"> <a href=javascript:show_profile("profile.php?msg_id=<?php echo $nb[msg_id] ?>",450,400)><img src="<? echo $print_icon ?>" border="0"></a>
      <?php echo $nb[msg_subject] ?>
    </td>
    <td align="center"   valign="top" class="bodytext"> <?php echo $nb[poster_job]; ?> </td>
    <td align="center" nowrap  valign="top" class="bodytext">
           <?php 
             if ($user_eamil) echo "<a href=\"mailto:$user_eamil\"> $user_name </a> " ;
             else echo " $user_name " ;
           ?> 
    </td>
    <td align="center"   valign="top" class="bodytext"> <?php echo $nb[msg_hit] ?> </td>
    <td align="center"  width="110" valign="top" class="bodytext"> <?php echo $nb[msg_date] ?> </td>
  </tr>
<?
if ($is_stop) {
?>
  <tr bgcolor="#F0F5FF"> 
    <td  colspan="6" width="100%" class="doctext"> 
      <div>
        <blockquote> 
          <img src="<?php echo $stop_icon ?>"  border="0" >�������i�ȭ��ն餺Ū���I
        </blockquote>
      </div>  
    </td>
  </tr>
<?
  }
else{ 
?>
  <tr bgcolor="#F0F5FF"> 
    <td  colspan="6" width="100%" class="doctext"> 
      <div>
        <blockquote> 
          <?php echo disphtml($nb[msg_body]) ?>
        </blockquote>
      </div>  
    </td>
  </tr>
<?php
  //�������ɮ�
  if ($nb[attach]) {
     echo "  <tr bgcolor=\"#F0F5FF\"> " ;
     echo '    <td  colspan="6" width="100%" class="bodytext"> ' ;

     echo '<blockquote> [����] ' . "<a href=\"$htmlsavepath". $nb[attach] ."\" target=\"_blank\"> $nb[attach] </a>   </blockquote> " ;

     echo " </td></tr> " ;
  } 
  //���������}�G
  if (strlen($nb["url"])>8) {
     echo "  <tr bgcolor=\"#F0F5FF\"> " ;
     echo '    <td  colspan="6" width="100%" class="bodytext"> ' ;

     echo "<blockquote> [�������}�G] <a href=\"". $nb["url"]. "\" target=\"_blank\">". $nb["url"] ."</a>   </blockquote> " ;

     echo " </td></tr> " ;
  } 
}
?>    

 </table>

<?php
   }
}

?>


<!----------------------------------------------------------------------------------
                                     �����D���
------------------------------------------------------------------------------------>
<div align="center">
  <center>
    <table border="0" cellpadding="1" cellspacing="1" align="center" width="90%" bgcolor="#EBEBEB" >
      <tr bgcolor="#006699" > 
        <th  align="center" nowrap width="5%" valign="top" class="titleshow"> 
          �s�� </th>
        <th  align="center" nowrap  width="60%" valign="top" class="titleshow" bgcolor="#006699"> 
          �D �� </th>
        <th  align="center" nowrap  valign="top" class="titleshow"> 
          ¾�� </th>
        <th align="center" nowrap  valign="top" class="titleshow"> 
          ���i�H </th>
        <th align="center" nowrap  valign="top" class="titleshow"> �\�� 
        </th>
        <th  align="center" nowrap width="110" valign="top" class="titleshow"> 
          ���i��� </th>
  </tr>
  

<?php

  $result = $CONN->PageExecute("$sqlstr", $msgs_per_page , $showpage );


  $nday = GetdayAdd(date("Y-m-d"),$showday * -1) ;
  if($result) 
  	while ($nb=$result->FetchRow()) {    
        userdata($nb[userid]) ;	  		
        $linkdata =  basename($PHP_SELF) . "?query=$query&sortmode=$sortmode&showpage=$showpage&poster=$poster&" ;
        
	$top_news = $nb["TopNews"] ;
	
	//�ثe���Ҧb�ϥ�
        $picstr = $main_icon ;
        if ($msg_id ==$nb[msg_id]) 
          $picstr = $reading_icon ;
        else 
          if ($top_news) 
             $picstr = $top_icon ; 
         elseif ($nb[msg_date]>$nday) 
             $picstr = $new_main_icon ;
          

    //�u�q�X���ɶ�
        $showdate = $nb["msg_date"]  ;
        $showd = explode("-", $showdate);
        $showdate = intval($showd[1]) . "-" .$showd[2] ;
    //�u���G�b�դ�
        $inschool = $nb["inSchool"] ;
        if ($inschool and (!check_home_ip()) ) {
            $is_stop = true ;
            $picstr = $stop_icon ; }
        else 
            $is_stop = false ;
        
?>  
  <tr bgcolor="#D8E9FE" class="bodytext"> 
    <td align="center"  width="5%" valign="top" class="bodytext"><?php echo $nb[msg_id] ?></td>
        <td align="left"  width="60%" valign="top" class="bodytext">
         <?
          if ($is_stop )  {
         ?> 
          <img src="<?php echo $picstr ?>"  border="0" alt="���դ��d��"  > <?php echo $nb[msg_subject] ?>
         <? } else { ?> 
          <a href="<? echo $linkdata . 'msg_id=' . $nb[msg_id] ?>">
          <img src="<?php echo $picstr ?>"  border="0" > <?php echo $nb[msg_subject] ?></a>

         <? } ?> 
        </td>
        <td align="center" nowrap valign="top" class="bodytext"> <?php echo $nb[poster_job] ?> </td>
        <td align="center" nowrap  valign="top" class="bodytext"> 
           <?php 
             if ($user_eamil) echo "<a href=\"mailto:$user_eamil\"> $user_name </a> " ;
             else echo " $user_name " ;
           ?>  
        </td>
    <td align="center"   valign="top" class="bodytext"><?php echo $nb[msg_hit] ?></td>
        <td align="center"  width="110" valign="top" class="bodytext"> <?php echo  $showdate ?> </td>
  </tr>
<?php
}


//�̤U��j�M�e��
?>  
      <tr> 
        <td align="center" nowrap colspan="6" valign="top" > 

            <table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr class="bodytext"> 

              <td width="40%" align="left">
                  <input type="hidden" name="msg_id" value="0">
                  <input type="hidden" name="sortmode" value="<?php echo $sortmode ?>">
                </td>


              <td width="20%" align="right" class="bodytext">����r</td>
              <td width="20%" align="left" colspan="2"><font size="2"> 
                <input type="text" name="query" size="16">
                </font> </td>
              <td width="20%" align="left" class="bodytext"> 
                <input type="submit" value="�M��" name="Submit">
              </td>
            </tr>
          </table>


        </td>
      </tr>
    </table>

  </center>
</div>
</form>


<?
  foot() ;
?>