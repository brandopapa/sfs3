<?php

// $Id: board_user_list.php 5310 2009-01-10 07:57:56Z hami $

  // --�t�γ]�w��
 require "config.php" ;
 require_once "../../include/sfs_case_dataarray.php";
  // --�{��
  sfs_check();
  $SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
  if ( !checkid($SCRIPT_FILENAME,1)){
    head("���׳q�i�����v") ;
    print_menu($menu_p);
    echo "�L�޲z���v���I<br>�жi�J �t�κ޲z / �Ҳ��v���޲z �ק� fixed �Ҳձ��v�C" ;
    foot();
    exit ;    
    //  Header("Location: index.php"); 
  }  
    
  $teacher_arr = teacher_array();
  

  $key=($_GET['key']) ? $_GET['key'] : $_POST['key'];
  $pc_id= $_GET['pc_id'] ;

  $post_office = $_POST['post_office'] ;
  $teach_title_id = $_POST['teach_title_id'] ;
  $teacher_sn = $_POST['teacher_sn'] ;
  $bk_id=($_GET['bk_id']) ? $_GET['bk_id'] : $_POST['bk_id'];
  
switch ($key) {
	case "�T�w�s�W" :
		$sql_insert = "insert into fixed_check (pro_kind_id,post_office,teacher_sn,teach_title_id,is_admin) values ('$bk_id','$post_office','$teacher_sn','$teach_title_id','$is_admin')";
		$CONN->Execute($sql_insert) or user_error("Ū�����ѡI<br>$sql_insert",256) ; 
	break;
	case "delete" :
		$sql_update = "delete  from fixed_check where pc_id='$pc_id'";
		$CONN->Execute($sql_update) or user_error("Ū�����ѡI<br>$sql_update",256) ; 
	break;
}

//�w�]�Ĥ@�Ӫ���
if (!$bk_id) {
	$query = "select bk_id from fixed_kind order by bk_id limit 0,1 ";
	$result = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ; 
	$row = $result->FetchRow() ;
	$bk_id = $row[0];
}

//  --�{�����Y
head(); 
//���s���r��
$linkstr = "bk_id=$bk_id";
print_menu($menu_p,$linkstr); 

$post_office_p = room_kind();
$post_office_p[99] = "�Ҧ��Юv";
$title_p = array();
$query = "SELECT *  FROM teacher_title ";
$query .= " where title_kind >= '$titl_kind' order by title_kind,teach_title_id ";
$result = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;        
while ($row= $result->FetchRow() )
	$title_p[$row["teach_title_id"]] = $row["title_name"];

//��ܸ��
$query = "select * from fixed_kind where bk_id ='$bk_id' ";
$result = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;  
if ($result) {
	$row = $result->FetchRow() ;
	$bk_id = $row["bk_id"];
	$board_name = $row["board_name"];	
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

<!--- �k���� ---->
<form action="<?php echo $PHP_SELF ?>" name=eform method="post">
<input type="hidden"  name="bk_id" value="<?php echo $bk_id ?>">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr> 
	<td align="right" valign="middle" bgcolor="#CCFFFF" width=100 >���v����</td>
	<td><B><font color=red><?php echo "$board_name" ?></font></b>--���v���U�C�s�թέӤH�ϥ�(�i�ƿ��J)</td>
</tr>

<tr>
	<td align="right" valign="middle" bgcolor="#CCFFFF">�B�Ǹs��</td>
	<td>
	<?php  
		$sel1 = new drop_select(); //������O	
		$sel1->s_name = "post_office"; //���W��		
		$sel1->arr = $post_office_p; //���e�}�C		
		$sel1->do_select();	  
	 ?>	
	</td>
</tr>

<tr>
	<td align="right" valign="middle" bgcolor="#CCFFFF">¾�ٸs��</td>
	<td>
	<?php  
		$sel1 = new drop_select(); //������O	
		$sel1->s_name = "teach_title_id"; //���W��		
		$sel1->arr = $title_p; //���e�}�C		
		$sel1->do_select();	  
	 ?>	
	</td>
</tr>
<tr>
	<td align="right" valign="middle" bgcolor="#CCFFFF">�ӧO�Юv</td>
	<td>
	<?php
	$sel = new drop_select();
	$sel->s_name = "teacher_sn";
	$sel->arr = $teacher_arr;
	$sel->do_select();
	?>
	</td>
	</tr>
<tr>
	<td align="center" valign="middle" colspan =2 BGCOLOR=#cbcbcb >
	<input type=submit name=key value="�T�w�s�W">	
	</td>
</tr>
</form>
</table>
<B><font color=red><?php echo "$board_name" ?></font></b> ���v����
<table width=600 border=1>
<tr><td>�B�Ǹs��</td><td>¾�ٸs��</td><td>�ӧO�Юv</td><td>�R�����v</td></tr>
<?php
$sql_select = "select pc_id,pro_kind_id,post_office,teacher_sn,teach_title_id,is_admin from fixed_check where pro_kind_id = '$bk_id' ";
$result = $CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256) ; 

while ($row = $result->FetchRow()) {

	$pc_id = $row["pc_id"];
	$pro_kind_id = $row["pro_kind_id"];
	$post_office = $row["post_office"];
	$teacher_name = $teacher_arr[$row["teacher_sn"]];
	$teach_title_id = $row["teach_title_id"];
	echo sprintf("<tr bgcolor=#FFFFFF><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n",$post_office_p[$post_office],$title_p[$teach_title_id],$teacher_name,"<a href=\"$PHP_SELF?key=delete&bk_id=$pro_kind_id&pc_id=$pc_id\">�R��</a>");
}
?>
</table>
</TD></TR>
</TABLE>
<?php
	foot();
?>
