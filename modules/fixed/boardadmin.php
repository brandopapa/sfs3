<?php

// $Id: boardadmin.php 5310 2009-01-10 07:57:56Z hami $

//�]�w�ɸ��J�ˬd
  require "config.php" ;

  // --�{�� 
  sfs_check();
  $SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
  if ( !checkid($SCRIPT_FILENAME,1)){
    head("���W���]�p") ;
    print_menu($menu_p);
    echo "�L�޲z���v���I<br>�жi�J �t�κ޲z / �Ҳ��v���޲z �ק� fixed �Ҳձ��v�C" ;
    foot();
    exit ;    
    //  Header("Location: index.php"); 
  }  

  $key = $_POST['key'] ;
  $bk_id=($_GET['bk_id']) ? $_GET['bk_id'] : $_POST['bk_id'];
  $board_name =  $_POST['board_name'];
  $email_list = $_POST['email_list'];          


switch($key) {

	case "�T�w�s�W" :
	$sql_insert = "insert into fixed_kind (bk_id,board_name,Email_list) values ('$bk_id','$board_name','$email_list' )";
	$CONN->Execute($sql_insert) or user_error("Ū�����ѡI<br>$sql_insert",256) ; 
	//echo $sql_insert  ;
	break;
	case "�T�w�ק�" :
	$sql_update = "update fixed_kind set board_name='$board_name ',Email_list='$email_list' where bk_id='$bk_id' ";
	$CONN->Execute($sql_update) or user_error("Ū�����ѡI<br>$sql_update",256) ; 
	break;
	case "�T�w�R��" :
	$sql_update = "delete  from fixed_kind  where bk_id='$bk_id'";	
	$CONN->Execute($sql_update) or user_error("Ū�����ѡI<br>$sql_update",256) ; 
	break;
}

//if (empty($bk_id)) $bk_id = 0 ;

if ($key != "�s�W����"){
        
   //  --�ثe���
   if ($bk_id)
	$sqlstr = "select * from fixed_kind where bk_id ='$bk_id' ";
   else
        $sqlstr = "select * from fixed_kind order by bk_id limit 0,1 ";
   $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
   $row = $result->FetchRow() ;
}

	
$bk_id = $row["bk_id"];
$board_name = $row["board_name"];

$email_list = $row["Email_list"];

//  --�{�����Y
head();
//���s���r��
$linkstr = "bk_id=$bk_id";
print_menu($menu_p,$linkstr); 

if ($key == "�R��"){
	echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
	        <form action=\"$PHP_SELF\" name=eform method=\"post\">";
	echo "  <input type=hidden name=\"bk_id\" value=\"$bk_id\">";	
	echo sprintf ("<td align=center>�T�w�R�� <B><font color=red>%s</font></B></td></tr>",$board_name);
	echo "<tr><td align=center><input type=submit name=key value=\"�T�w�R��\">";
	echo "</td></tr></form></table>";
	foot();
	exit;
}
?>



<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr><td valign=top bgcolor="#CCCCCC">
 <table border="0" width="100%" cellspacing="0" cellpadding="0" >
    <tr>
      <td  valign="top" >    
	<?php      
	//�إߥ�����	
	$grid1 = new sfs_grid_menu;  //�إ߿��	   
	//$grid1->bgcolor = $gridBgcolor;  // �C��   
	//$grid1->row = $gri ;	     //��ܵ���
	$grid1->key_item = "bk_id";  // ������W  	
	$grid1->display_item = array("bk_id","board_name");  // �����W   	
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select bk_id,board_name from fixed_kind order by bk_id";   //SQL �R�O   
	$grid1->do_query(); //����R�O   
	
	$grid1->print_grid($bk_id); // ��ܵe��   

	?>
     </td></tr></table>
  </td>

<td width="100%" valign=top bgcolor="#CCCCCC">
   <form action="<?php echo $PHP_SELF ?>" name='eform' method="post" > 

        <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
          <tr> 
            <td align="right"  nowrap>���N��</td>
            <td> 
            <?php 
            if ($key =="�s�W����"  or empty($bk_id)) 
              echo "<input type='text' size='12' maxlength='12' name='bk_id' value='$bk_id'>" ;
            else {
              echo    $bk_id ;
              echo "<input type='hidden' name='bk_id' value='$bk_id'>" ;
            }  
            ?>  
            </td>
          </tr>
          <tr> 
            <td align="right"  nowrap>���W��</td>
            <td> 
              <input type="text" size="20" maxlength="20" name="board_name" value="<?php echo $board_name ?>">
            </td>
          </tr>
          <tr> 
            <td align="right"  nowrap>email�q��</td>
            <td> 
              <input type="text" size="60" name="email_list" value="<?php echo $email_list ?>">
            </td>
          </tr>
          <tr> 
          <td align="center"  nowrap colspan="2">
<?php	
	if ($bk_id == "")
		echo "<input type='submit' name='key' value=\"�T�w�s�W\">  ";
	else if ($key != "�s�W����" ){
		echo "<input type='submit' name='key' value=\"�T�w�ק�\">  ";
		echo "<input type='submit' name='key' value=\"�R��\">  ";
		echo "<input type='submit' name='key' value=\"�s�W����\">  ";
	}
	else{
		echo "<input type=submit name=key value=\"�T�w�s�W\">";
	}

?>            
          </td>
          </tr>
        </table>
    </form>

</td></tr>
</table>

<?php
	foot();
?>