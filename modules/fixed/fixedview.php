<?php
  // $Id: fixedview.php 5310 2009-01-10 07:57:56Z hami $
  //  ���׳q���t�� 
  //  �L�±Ӫ��b�I�ߤu�@�{
  //  http://sy3es.tnc.edu.tw/~prolin

  require "config.php" ;

  $id = $_GET['id'] ;
  //$debug = 1;
  
  if (!$id)  {  //�����w�s��
   header("Location:fixed.php" ) ; 
   exit ;
  }
  
  //Ū�����
  $sqlstr = "SELECT * FROM $tbname where id = $id " ;

  if ($debug) echo $sqlstr ;

  $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 

  	   $nb= $result->FetchRow() ;
  	   $even_T = $nb[even_T];		//���D
  	   $even_doc = nl2br($nb[even_doc]);		//�ƥ�
           $unitId = $nb[unitId];		//�q�����N�X
           $unitname = $unitstr[$unitId] ;	//�q����줤��W
           //$unitchk = $unitcheck[$unitId] ;	//���s�էP�_
           			
           $user = $nb[user];                   //�����
           $even_date = $nb[even_date];		//������
           $even_mode = $nb[even_mode] ;	//�Ʊ��Y����-�Ʀr
           $even_modestr = $evenmode[$even_mode] ; //�Y����-��r
           $rep_doc =nl2br($nb[rep_doc]);		//�^�Ф��e
           $rep_mode = $nb[rep_mode];		//�״_����
           $rep_mode_str = $checkmode[$rep_mode] ;
           $rep_date = $nb[rep_date] ;
           $rep_user = $nb[rep_user] ;

  head("���׳q��") ;
  print_menu($menu_p); 
?>
<html>
<head>
<title>���׳q����</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
</head>

<body bgcolor="#FFFFFF">
<h1 align="center">���׳q����</h1>
<table width="95%" border="1" cellspacing="0" cellpadding="4" bordercolorlight="#666666" bordercolordark="#FFFFFF" align="center">
  <tr bgcolor="#CCCCFF"> 
    <td width="20%">
     <?php 
      //�s���ιϥ�
      echo "<img src='$mode_image[$even_mode]'> �s���G$id \n" ;
      
     ?>
    </td>
    <td width="60%"><?php echo $even_T ?></td>
    <td width="20%">�Y�����šG<?php echo $even_modestr ?></td>
  </tr>
  <tr bgcolor="#CCCCFF"> 
    <td >�y�z�G</td>
    <td ><?php echo $even_doc ?>&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr bgcolor="#CCCCFF"> 
    <td colspan="2"> 
      �������G<?php echo $even_date ?>
    </td>
    <td >����H�G<?php echo $user ?></td>
  </tr>
  <tr bgcolor="#FFCCCC"> 
    <td ><?php echo "  <img src='$chk_image[$rep_mode]' >" . $rep_mode_str  ;    ?></td>
    <td >&nbsp;</td>
    <td >�t�d���G<?php echo $unitname ?></td>
  </tr>
  <tr bgcolor="#FFCCCC">
    <td>�^�Ф��e�G</td>
    <td><?php echo $rep_doc ?>&nbsp; </td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFCCCC"> 
    <td colspan="2"> 
      �^�Ф���G<?php echo $rep_date ?>
    </td>
    <td >�^�Ъ̡G<?php echo $rep_user ?></td>
  </tr>
</table>
<p align="center"><a href="javascript:history.go(-1);">�^�W�@��</a></p>
<? foot(); ?>
</body>
</html>
