<?php

// $Id: board_user_list.php 5310 2009-01-10 07:57:56Z hami $

// --�t�γ]�w��
include "board_man_config.php";
// --�{��
sfs_check();
$teacher_arr = teacher_array();
switch ($key) {
	case "�T�w�s�W" :
		$sql_insert = "insert into jboard_check (pro_kind_id,post_office,teacher_sn,teach_title_id,is_admin) values ('$bk_id','$post_office','$teacher_sn','$teach_title_id','$is_admin')";
		mysql_query($sql_insert);
	break;
	case "delete" :
		$sql_update = "delete  from jboard_check where pc_id='$pc_id'";
		mysql_query($sql_update) or die ($sql_update);
	break;
}

//�w�]�Ĥ@�Ӫ���
if (!$bk_id) {
	$query = "select bk_id from jboard_kind order by bk_id limit 0,1 ";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
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
$query .= " where title_kind >= '$titl_kind' and enable=1 order by title_kind,teach_title_id ";
$result = mysql_query($query,$conID)or die ($query);          
while ($row= mysql_fetch_array($result))
	$title_p[$row["teach_title_id"]] = $row["title_name"];

//��ܸ��
$query = "select * from jboard_kind where bk_id ='$bk_id' ";
$result = mysql_query ($query,$conID) or die ($query); 
if ($result) {
	$row = mysql_fetch_array($result);
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
	/*
	$grid1 = new sfs_grid_menu;  //�إ߿��	   
	//$grid1->bgcolor = $gridBgcolor;  // �C��   
	//$grid1->row = $gri ;	     //��ܵ���
	$grid1->key_item = "bk_id";  // ������W  	
	$grid1->display_item = array("bk_order","bk_id","board_name");  // �����W   	
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select bk_id,board_name,bk_order from jboard_kind order by bk_order,bk_id";   //SQL �R�O   
	$grid1->do_query(); //����R�O   
	
	$grid1->print_grid($bk_id); // ��ܵe��   
*/
	?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>">
 <select name="bk_id" onchange="this.form.submit()" size="20">
	<option value="">�w�w�w�w�w</option>

<?php
	$query = "select * from jboard_kind order by bk_order,bk_id ";
	$result= $CONN->Execute($query) or die ($query);
	while( $row = $result->fetchRow()){
		$P=($row['position']>0)?"".str_repeat("|--",$row['position']):"";
		/*
		if ($row["bk_id"] == $bk_id  ){
			echo sprintf(" <option style='color:%s' value=\"%s\" selected>[%05d] %s%s%s</option>",$position_color[$row['position']],$row["bk_id"],$row['bk_order'],$P,$row['bk_order'],$row["board_name"]);
			$board_name = $row["board_name"];
		}
		else
			echo sprintf(" <option style='color:%s' value=\"%s\">[%05d] %s%s%s</option>",$position_color[$row['position']],$row["bk_id"],$row['bk_order'],$P,$row['bk_order'],$row["board_name"]);
  	}
	 */
		if ($row["bk_id"] == $bk_id  ){
			echo sprintf(" <option style='color:%s' value=\"%s\" selected>[%05d] %s%s(%s)</option>",$position_color[$row['position']],$row["bk_id"],$row['bk_order'],$P,$row["board_name"],$row["bk_id"]);
			$board_name = $row["board_name"];
		}
		else
			echo sprintf(" <option style='color:%s' value=\"%s\">[%05d] %s%s(%s)</option>",$position_color[$row['position']],$row["bk_id"],$row['bk_order'],$P,$row["board_name"],$row["bk_id"]);
	  }

	
	echo "</select>";

	?>
</form>
	
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
$sql_select = "select pc_id,pro_kind_id,post_office,teacher_sn,teach_title_id,is_admin from jboard_check where pro_kind_id = '$bk_id' ";
$result = mysql_query ($sql_select,$conID);

while ($row = mysql_fetch_array($result)) {

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
