<?php
  // $Id: fixed.php 8082 2014-06-30 11:50:10Z kwcmath $
  require "config.php" ;

  //sfs2 �ɯ� sfs3 ���վ�
  $rs01=$CONN->Execute("select userid from fixedtb where 1");
  if (!$rs01) $CONN->Execute(" ALTER TABLE `fixedtb` ADD `userid` VARCHAR( 12 ) NOT NULL ");
 
  $rs01=$CONN->Execute("select teacher_sn from fixed_check where 1");
  if (!$rs01) $CONN->Execute("ALTER TABLE `fixed_check` ADD `teacher_sn` INT DEFAULT '0' NOT NULL ");
 
  $rs01=$CONN->Execute("select Email_list from fixed_kind where 1");
  if (!$rs01) $CONN->Execute(" ALTER TABLE `fixed_kind` ADD `Email_list` VARCHAR( 100 ) NOT NULL  ");
  
  
  //$debug = 1;
  $showunit = $_POST['showunit'];    
  $showmode = $_POST['showmode'];    
  $showpage = $_POST['showpage'];  
  $user_limited = $_POST['user_limited'];  
 
  
  // �w�]��ܱ��� 
  if (!isset($showunit)) $showunit= "" ; //�������
  if (!isset($showmode)) $showmode= -1 ;  //��ܥ���
  
  //�p�⭶��
  $sqlstr = "SELECT * FROM $tbname  " ;
  if ($showunit) {		//�����w��ܳ��
    $sqlstr .=  " where unitId = '$showunit' " ;
    if ($showmode>=0) $sqlstr .=  " and rep_mode = '$showmode' " ;
  }
  else 				//�����w��ܯS�w���(�|�ݳB�z�B�B�z���B�w�״_)
    if ($showmode>=0) $sqlstr .=  " where rep_mode = '$showmode' " ;
	
		//�W�[�Юv�L�o
	if($user_limited) $sqlstr .=  (strpos($sqlstr, ' where ')?' and':' where')." user = '$user_limited' " ;

    
  $result1 = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
  if ($result1) {
    $totalnum = $result1->RecordCount() ;		//�`����
    $totalpage =ceil( $totalnum / $msgs_per_page) ;	//�`����
  }  
  if (!$totalpage) $totalpage= 1 ;  //�L��ơA�`����1�A��ܲĤ@��
  if (!$showpage)  $showpage = 1 ;  
  
  //Ū�����
  $sqlstr .= ' order By ID DESC ' ;
  //$sqlstr .= ' LIMIT ' . ($showpage-1)*$msgs_per_page . ', ' . $msgs_per_page  ;  
  if ($debug) echo $sqlstr ;
  $result =  $CONN->PageExecute("$sqlstr", $msgs_per_page , $showpage );
  
  $date_diff=$date_diff?$date_diff:120;
  $user_list="SELECT user,count(*) AS amount FROM fixedtb WHERE datediff(CURDATE(),even_date)<=$date_diff GROUP BY user ORDER BY amount DESC";
  $result_list =  $CONN->Execute($user_list) or user_error("Ū�����ѡI<br>$user_list",256) ;
  $user_select="<select name='user_limited' onchange='this.form.submit();'><option value=''></option>";
	while(!$result_list->EOF){
		$user_name=$result_list->fields['user'];
		$user_counter=$result_list->fields['amount'];
		$selected=$user_limited==$user_name?'selected':'';
		$user_select.="<option value='$user_name' $selected>$user_name($user_counter)</option>";
		$result_list->MoveNext();
	}
  $user_select.="</select>";
  
  head("���׳q��") ;
  print_menu($menu_p);

?>

<style type="text/css">
<!--
.tr1 {  text-align: center; white-space: nowrap; font-size: 10pt}
.tr2 {  background-color: #faeaea; text-align: center; white-space: nowrap; font-size: 10pt}
.trtop {  font-weight: bold; background-color: #CCCCFF; background-position: center; white-space: nowrap ;text-align: center}


-->
</style>


<body bgcolor="#FFFFFF">
<form name="myform" method="post" action="fixed.php"  >
  <h1 align="center" nowrap>���רt�� </h1>
  <table width="95%" border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="#FFCCCC">
    <tr > 
      <td nowrap>�����G 
        <select name="showunit" onChange="this.form.submit()">
          
          <?php 
            //��ܳ��W��
            if ($showunit=="") echo "<option value='' selected>�������</option> ";
            else echo "<option value='' >�������</option> ";
            foreach( $unitstr as $key => $value) {
                
               $chkstr = ($key==$showunit) ? "selected" : "" ;
               echo "<option value='$key' $chkstr>$value</option> \n"  ;
            }    
                        
     
           ?>         
        </select>
        �@���B�z���ΡG 
        <select name="showmode" onChange="this.form.submit()">
          <?php 
            //�B�z����
            if ($showmode== -1) echo "<option value=\"-1\" selected>����</option>" ;
            else echo "<option value=\"-1\" >����</option>" ;
            foreach( $checkmode as $key => $value) {
                
               $chkstr = ($key==$showmode) ? "selected" : "" ;
               echo "<option value='$key' $chkstr>$value</option> \n"  ;
            }              
     
           ?>          
        </select>
		�@�����ת̭��w
		 <?php 
			//���ת̭��w
			echo "( $date_diff �餺 )�G".$user_select;
		?> 
      </td><td >���ʭ��G  
        <select name="showpage" onChange="this.form.submit()" >
          <?php 
            //����
            for ($i=1 ;$i<=$totalpage;$i++) {
    	      if ($i==$showpage) echo "<option value=\"$i\" selected>�����" ;
              else echo "<option value=\"$i\">�����" ;
              echo  $i . "�� </option> \n" ;
            }
          ?>            
        </select>            
      </td>
      <td nowrap><a href="fixedadmin.php">���</a></td>
    </tr>
  </table>
  <table width="95%" border="1" cellspacing="0" cellpadding="4" bordercolorlight="#CCCCCC" bordercolordark="#FFFFFF" align="center">
    <tr  class="trtop" > 
      <td nowrap >�s��</td>
      <td nowrap >���</td>
      <td nowrap >���פ��e</td>
      <td nowrap >����</td>
      <td nowrap >����H</td>

      <td nowrap >�q�����</td>
      <td nowrap >�^�Ъ�</td>
      <td  nowrap >���</td>
      <td nowrap >�B�z�^��</td>
    </tr>
<?php

  //�C�X�U�����
  if ($result) 
    while ($nb = $result->FetchRow() ) {  

       $user = $nb[user] ;
       $rep_mode= $nb[rep_mode];
        
      if ($rowi) {	//�j�����P�_
        echo '<tr class="tr2"> ' ; 
        $rowi = 0 ; }   
      else {   
        echo '<tr class="tr1"> ' ; 
        $rowi = 1 ; } 
      echo "<td>" ; 
      
      echo "<img src='$chk_image[$rep_mode]' alt='�ƥ����O�ϥ�'>" ;
      echo " $nb[ID] </td> \n" ;
      //�����
	

      echo "<td> $nb[even_date]</td> \n" ;	
      //�ƥD��
      echo "<td ><a href=\"fixedview.php?id=$nb[ID]\">$nb[even_T]</a></td> \n" ;
      //�Y������
      $ti  =$nb[even_mode] ;
      echo "<td ><img src='$mode_image[$ti]' alt='�ƥ󵥯Źϥ�'>$evenmode[$ti]</td> \n" ;      
      
      $edit_link ='' ;
      //�s�׳s��
      if ($_SESSION['session_log_id'] ) 
         if (!strnatcasecmp($nb[userid] , $_SESSION['session_log_id']) and ($rep_mode <> 2))
           $edit_link = "<a href=\"fixedadmin.php?do=edit&id=$nb[ID]\"><img src=\"images/edit.gif\" alt='�ק�q�����e' title='�ק�q�����e' border=\"0\"> </a>\n" ; 
           
      /*
      else     
         if ($rep_mode <> 2) //������
            $edit_link = "<a href=\"fixedadmin.php?do=edit&id=$nb[ID]\"><img src=\"images/edit.gif\" alt='�s��'  border=\"0\"> </a> \n" ; 
      */
                  
      //���H
      echo "<td >$user $edit_link</td>\n" ;      

      
			$u_edit_link ='' ;
      //�t�d���
      $ti = $nb[unitId] ;
      if ((board_checkid($ti)) and ($rep_mode <> 2))
      	$u_edit_link = "<a href=\"fixedadmin.php?do=edit&id=$nb[ID]\"><img src=\"images/edit.gif\" alt='�ק�q�����e' title='�ק�q�����e' border=\"0\"> </a>\n" ;
      echo "<td >$unitstr[$ti] $u_edit_link</td> \n " ;

      //�^�Ъ�
      echo "<td >$nb[rep_user] &nbsp;</td> \n" ;
      //�^�Ф��
      echo "<td >$nb[rep_date] &nbsp;</td> \n" ;
      //�B�z����
      $ti  =$nb[rep_mode] ;
      if ($ti<>2)
         echo "<td ><a href=\"fixedadmin.php?do=reply&id=$nb[ID]\">$checkmode[$ti]</a></td> \n" ;
      else 
         echo "<td >$checkmode[$ti]</td> \n" ;  
         
      echo "</tr>\n" ;
   }  
?> 
  </table>
 
</form>

<?php foot(); ?>
