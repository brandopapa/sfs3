<?php
//$Id: a_main_admin.php 7766 2013-11-15 06:16:35Z smallduh $
  include_once( "config.php") ;
  include_once( "../../include/sfs_case_PLlib.php") ;
    
    // --�{�� session 
    sfs_check();
   
//�D�޲z�� 
$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
if ( !checkid($SCRIPT_FILENAME,1)){
      Header("Location: index.php"); 
}         
//========================================================================  
    if ($_POST["Submit"] == "�s�W�@��") {
        
      //�إ߮եZ�s���ƥؿ�(�H����إ�)
      $nday = date("Ymd") ;
      chdir($basepath) ; 	
      $dirstr = "$nday" ;
      $count = 0 ;
      while (is_dir($dirstr)) {
     	 $count ++ ;
     	 $dirstr = "$nday-" . $count;
      }	
      mkdir( $dirstr , 0700) ;        
      
    
        
      $sqlstr =  " insert into  magazine
            (id,num,publish_date,publish,setpasswd,admin,ed_begin,ed_end, book_path ,themes ) 
            values ('0','$_POST[num]','$_POST[publish_date]','$_POST[publish]','$_POST[setpasswd]', '$_POST[admin]','$_POST[edit_begin]' ,'$_POST[edit_end]','$dirstr' ,'$_POST[themes]' )  " ;   
   
      $CONN->Execute($sqlstr) ;         
      header("location:a_main.php") ;
        
    }
    
    if ($_POST["Submit"] == "�ק�") {
    	echo $templ_file ;
      //�˪��ɮ�
    
      $sqlstr =  "update  magazine set id= '$_POST[id]' ,num = '$_POST[num]' ,publish_date='$_POST[publish_date]',
          publish='$_POST[publish]',setpasswd='$_POST[setpasswd]',admin='$_POST[admin]',
          ed_begin='$_POST[edit_begin]',ed_end='$_POST[edit_end]'  ,
          is_fin= '$_POST[check_fin]' , themes='$_POST[themes]' 
          where id= '$_POST[id]'   " ;
      //$sqlstr = stripslashes($sqlstr);     
      $CONN->Execute($sqlstr) ;                
      header("location:a_main.php") ;
        
    }

    if ($_POST["Submit"] == "�^�޲z����") {
      echo $templ_file ;
      //�˪��ɮ�          
      header("location:a_main.php") ;        
    }

    if ($_POST["Submit"] == "�R��") {
      echo $templ_file ;
      //�˪��ɮ�

	  //�R��magazine_chap��ƪ�
      $sqlstr1 = "select id from `magazine_chap` where book_num= '$_POST[id]';";
	  $rs = $CONN->Execute($sqlstr1);
      $rows = $rs -> RecordCount();
	  if($rows>0){
	    while($ar = $rs->FetchRow()){
		  //$id = $ar["id"];
          $sqlstr3 =  "delete from `magazine_paper` where chap_num= '".$ar['id']."';";
	      $CONN->Execute($sqlstr3);
		}
		$sqlstr2 = "delete from magazine_chap where book_num= '$_POST[id]';";
	    $CONN->Execute($sqlstr2);
	  }	      
      $sqlstr =  "delete from magazine where id= '$_POST[id]';";
	  $CONN->Execute($sqlstr);
	  $exec_path = "rm -rf ".$basepath.$_POST[m_path];
	  //echo $exec_path;
	  //exit;
	  exec($exec_path);                
      header("location:a_main.php") ;
        
    }
//========================================================================        
    //���o�˪��ؿ�
    $themesdir = $tpl->template_dir ;   
    $handle = @opendir($themesdir) ;
    while ($filelist = readdir($handle)) {
        if ($filelist<>".." and $filelist<>".") 
          if (is_dir($themesdir."/" .$filelist)) 
             $themes_list[$filelist] = $filelist;
    }         
 
     


head("�q�l�եZ���O�޲z");  
print_menu($m_menu_p);
?>  
  
<html>
<head>
<title>�����q�l�եZ�򥻸�ƽs��</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
</head>

<body bgcolor="#FFFFFF">
<form method="post" action="<? echo $self_php ?>" enctype="multipart/form-data">
  <table width="85%" border="0" cellspacing="0" cellpadding="4" align="center">
    <tr> 
      <td width="73%"> 
        <h1 align="center">�q�l�եZ���O��Ƴ]�w</h1>
      </td>
      <td width="14%"> 
        <div align="center"><a href="a_main.php">�޲z�D�e��</a></div>
      </td>
    </tr>
  </table>

<?php
//----------------------------------------------------------------------------
//�s�W�@��
  if (!$_GET[id]) {
    //�w�]���
    $nday= date("Y-m-d") ;
    $eday = GetdayAdd($nday,10) ;  //�[�W10��

?>  
  <table width="80%" border="1" cellspacing="0" cellpadding="4" align="center" bgcolor="#99CCFF" bordercolorlight="#333333" bordercolordark="#FFFFFF">
    <tr> 
      <td width="29%">���O�G</td>
      <td width="71%"> �� 
        <input type="text" name="num" size="5" maxlength="5">
        �� </td>
    </tr>
    <tr> 
      <td width="29%">�o�����G</td>
      <td width="71%"> 
        <input type="text" name="publish_date" value="<? echo $eday ?>">
      </td>
    </tr>
    <tr> 
      <td width="29%">�o��H�T���G</td>
      <td width="71%"> 
        <textarea name="publish" cols="30" rows='4' >�o��H�G
�s��s�G</textarea>
      </td>
    </tr>
    <tr> 
      <td width="29%">�s��H���N���G<br>
      </td>
      <td width="71%"> 
        <input type="text" name="admin" size="40">
        <br>
        (�H�r�������j) </td>
    </tr>
    <tr> 
      <td width="29%">�w�]�K�X�G</td>
      <td width="71%"> 
        <input type="text" name="setpasswd" size="10" maxlength="10">
        (�U�Z�W�ǨϥαK�X) </td>
    </tr>
    <tr> 
      <td width="29%">�}�l�s�����G</td>
      <td width="71%"> 
        <input type="text" name="edit_begin" value="<? echo $nday ?>">
      </td>
    </tr>
     
    <tr> 
      <td width="29%">�W�ǵ�������G</td>
      <td width="71%"> 
        <input type="text" name="edit_end" value="<? echo $eday ?>">
      </td>
    </tr>
    <tr> 
      <td width="29%">��μ˪��G</td>
      <td width="71%"> 
          <select name="themes">
	<?php
	reset($themes_list);
	 while(list($tkey,$tvalue)= each($themes_list))
	 {
          if ($tkey == $themes)	  
             echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
           else
             echo  sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
          }             	 
 	?>          
          </select>
      </td>
    </tr>
    <tr> 
      <td colspan="2"> 
        <input type="submit" name="Submit" value="�s�W�@��">
        <input type="reset" name="Submit3" value="���]">
      </td>
    </tr>
  </table>
<?
//�R��
}elseif($_GET[id]>0 and $_GET[del]==1){
      $sqlstr =  "select * from magazine  where  id='$_GET[id]' " ;   
      
      $result = mysql_query ($sqlstr,$conID) ; 
      if ($result) 
        while ($row=mysql_fetch_array($result)) {
          $book_num = $row["num"] ; //���o���O    
          $id = $row["id"] ;
          $publish_date = $row["publish_date"] ;
          $publish = $row["publish"] ;
          $setpasswd = $row["setpasswd"] ;
          $admin = $row["admin"] ;
          $is_fin = $row["is_fin"] ;
          $ed_begin = $row["ed_begin"] ;

          $ed_end = $row["ed_end"] ;
          $book_path = $row["book_path"] ;
          $themes = $row["themes"] ;
        }   

?>    
  <table width="80%" border="1" cellspacing="0" cellpadding="4" align="center" bgcolor="#99CCFF" bordercolorlight="#333333" bordercolordark="#FFFFFF">
    <tr> 
      <td width="29%">���O�G</td>
      <td width="71%"> ��
        <input type="text" name="num" size="5" maxlength="5" value="<? echo $book_num ?>" disabled>
        �� </td>
    </tr>
    <tr> 
      <td width="29%">�o�����G</td>
      <td width="71%"> 
        <input type="text" name="publish_date" value="<? echo $publish_date ?>" disabled>
      </td>
    </tr>
    <tr> 
      <td width="29%">�o��H�T���G</td>
      <td width="71%"> 
        <textarea name="publish" cols="30" rows="4" disabled><? echo $publish ?></textarea>
      </td>
    </tr>
    <tr> 
      <td width="29%">�t�d�H�N���G<br>
      </td>
      <td width="71%"> 
        <input type="text" name="admin" size="40" value="<? echo $admin ?>" disabled>
        <br>
        (�H�r�������j) </td>
    </tr>
    <tr> 
      <td width="29%">�w�]�K�X�G</td>
      <td width="71%"> 
        <input type="text" name="setpasswd" size="10" maxlength="10" value="<? echo $setpasswd ?>" disabled>
        (�U�Z�W�ǨϥαK�X) </td>
    </tr>
    <tr> 
      <td width="29%">�}�l�s�����G</td>
      <td width="71%"> 
        <input type="text" name="edit_begin" value="<? echo $ed_begin ?>" disabled>
      </td>
    </tr>

    <tr> 
      <td width="29%">�W�ǵ�������G</td>
      <td width="71%"> 
        <input type="text" name="edit_end" value="<? echo $ed_end ?>" disabled>
      </td>
    </tr>
    <tr> 
      <td width="29%">�����аO�G</td>
      <td width="71%"> 
        <input type="checkbox" name="check_fin" value="1" <? if ($is_fin) echo "checked" ?>  disabled>
        �w�����A���i�A�ק� </td>
    </tr>
    <tr> 
      <td width="29%">�˪���ΡG</td>
      <td width="71%"> 
          <select name="themes" disabled>
	<?php
	reset($themes_list);
	 while(list($tkey,$tvalue)= each($themes_list))
	 {
          if ($tkey == $themes)	  
             echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
           else
             echo  sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
          }             	 
 	?>          
          </select>
      </td>
    </tr>
    <tr> 
      <td colspan="2">
        <input type="submit" name="Submit" value="�R��">
		<input type="submit" name="Submit" value="�^�޲z����">
		<FONT SIZE="" COLOR="#FF0000">�Фp�ߧR����A��ӤW�Ǫ���Ƴ��N�@�֧R��!!</FONT>
        <input type="hidden" name="id" value="<? echo $id ?>">
        <input type="hidden" name="m_path" value="<? echo $book_path ?>">
      </td>
    </tr>
  </table>  
<?
//�ק�
}else
{
      $sqlstr =  "select * from magazine  where  id='$_GET[id]' " ;   
      
      $result = mysql_query ($sqlstr,$conID) ; 
      if ($result) 
        while ($row=mysql_fetch_array($result)) {
          $book_num = $row["num"] ; //���o���O    
          $id = $row["id"] ;
          $publish_date = $row["publish_date"] ;
          $publish = $row["publish"] ;
          $setpasswd = $row["setpasswd"] ;
          $admin = $row["admin"] ;
          $is_fin = $row["is_fin"] ;
          $ed_begin = $row["ed_begin"] ;

          $ed_end = $row["ed_end"] ;
          $book_path = $row["book_path"] ;
          $themes = $row["themes"] ;
        }   

?>    
  <table width="80%" border="1" cellspacing="0" cellpadding="4" align="center" bgcolor="#99CCFF" bordercolorlight="#333333" bordercolordark="#FFFFFF">
    <tr> 
      <td width="29%">���O�G</td>
      <td width="71%"> ��
        <input type="text" name="num" size="5" maxlength="5" value="<? echo $book_num ?>">
        �� </td>
    </tr>
    <tr> 
      <td width="29%">�o�����G</td>
      <td width="71%"> 
        <input type="text" name="publish_date" value="<? echo $publish_date ?>">
      </td>
    </tr>
    <tr> 
      <td width="29%">�o��H�T���G</td>
      <td width="71%"> 
        <textarea name="publish" cols="30" rows="4"><? echo $publish ?></textarea>
      </td>
    </tr>
    <tr> 
      <td width="29%">�t�d�H�N���G<br>
      </td>
      <td width="71%"> 
        <input type="text" name="admin" size="40" value="<? echo $admin ?>">
        <br>
        (�H�r�������j) </td>
    </tr>
    <tr> 
      <td width="29%">�w�]�K�X�G</td>
      <td width="71%"> 
        <input type="text" name="setpasswd" size="10" maxlength="10" value="<? echo $setpasswd ?>">
        (�U�Z�W�ǨϥαK�X) </td>
    </tr>
    <tr> 
      <td width="29%">�}�l�s�����G</td>
      <td width="71%"> 
        <input type="text" name="edit_begin" value="<? echo $ed_begin ?>">
      </td>
    </tr>

    <tr> 
      <td width="29%">�W�ǵ�������G</td>
      <td width="71%"> 
        <input type="text" name="edit_end" value="<? echo $ed_end ?>">
      </td>
    </tr>
    <tr> 
      <td width="29%">�����аO�G</td>
      <td width="71%"> 
        <input type="checkbox" name="check_fin" value="1" <? if ($is_fin) echo "checked" ?> >
        �w�����A���i�A�ק� </td>
    </tr>
    <tr> 
      <td width="29%">�˪���ΡG</td>
      <td width="71%"> 
          <select name="themes">
	<?php
	reset($themes_list);
	 while(list($tkey,$tvalue)= each($themes_list))
	 {
          if ($tkey == $themes)	  
             echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
           else
             echo  sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
          }             	 
 	?>          
          </select>
      </td>
    </tr>
    <tr> 
      <td colspan="2">
        <input type="submit" name="Submit" value="�ק�">
        <input type="reset" name="Submit3" value="���]">
        <input type="hidden" name="id" value="<? echo $id ?>">
        <input type="hidden" name="m_path" value="<? echo $book_path ?>">
      </td>
    </tr>
  </table>  
<?
}  
foot();
?>  
</form>
</body>
</html>
