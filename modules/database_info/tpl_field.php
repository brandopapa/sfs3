<?php 

// $Id: tpl_field.php 5310 2009-01-10 07:57:56Z hami $

// ���J�]�w��
include "database_info_config.php";
// �{���ˬd
sfs_check();

$d_table_name = ($_POST['d_table_name']) ? $_POST['d_table_name'] : $_GET['d_table_name'];

// �إ����O
//$tea1 = new m_unit_class();
//�L�X���Y
if (isset($d_table_name))
	$tablename = $d_table_name;
else
	header ("Location: index.php");
head();
?>
<script language="JavaScript">
   <!--
   function CheckAll()
   {
      for (var i=0;i<document.myform.elements.length;i++)
      {
         var e = document.myform.elements[i];
         if (e.type == 'checkbox' && e.name != 'allbox')
            e.checked = document.myform.allbox.checked;
      }
   }
   function OpConfirm(text)
   {   
      for (var i=0;i<document.myform.elements.length;i++)
      {
         var e = document.myform.elements[i];
         if (e.type == 'checkbox' && e.name != 'allbox' && e.checked == 1 )
            return confirm(text);
      }
      return false;
   }
   //-->
</script>

<?php
$sql_get_tables = "SHOW FIELDS FROM $tablename  ";
$recordSet = $CONN->Execute($sql_get_tables) or die($sql_get_tables);
//�T�w
if ($_POST[do_key]==$btnPost){
	$query = "delete from sys_data_field where d_table_name='$tablename' ";
	$CONN->Execute($query);
	while (!$recordSet->EOF){
		$d_field_name = $recordSet->fields[Field];
		$d_field_cname = "cname_".$recordSet->fields[Field];		
		
		$d_field_type =  addslashes($recordSet->fields[Type]);
		$d_field_order = "order_".$recordSet->fields[Field];
		$d_is_display = "check_".$recordSet->fields[Field];
		$d_field_xml = "xml_".$recordSet->fields[Field];
		$query = "insert into sys_data_field (d_table_name ,d_field_name,d_field_cname,d_field_type,d_field_order,d_is_display,d_field_xml ) values('$tablename','".$d_field_name."','".$_POST[$d_field_cname]."','".$d_field_type."','".$_POST[$d_field_order]."','".$_POST[$d_is_display]."','".$_POST[$d_field_xml]."')";
		//$CONN->debug=true;
		//echo $query;
		$CONN->Execute($query) or die($query);			
		
		$recordSet->MoveNext();
	}
}

if (isset($tablename)){
	$query = "select d_table_name ,d_field_name ,d_field_cname ,d_field_type ,d_field_order ,d_is_display,d_field_xml from sys_data_field WHERE d_table_name = '$tablename' order by d_field_name ";
	$dataSet = $CONN->Execute($query);
	//echo $query;
	while(!$dataSet->EOF){
		$data[$dataSet->fields[d_field_name]][d_field_name]=$dataSet->fields[d_field_name];
		$data[$dataSet->fields[d_field_name]][d_field_type]=$dataSet->fields[d_field_type];
		$data[$dataSet->fields[d_field_name]][d_field_cname]=$dataSet->fields[d_field_cname];
		
		$data[$dataSet->fields[d_field_name]][d_field_order]=$dataSet->fields[d_field_order];
		$data[$dataSet->fields[d_field_name]][d_field_xml]=$dataSet->fields[d_field_xml];
		$data[$dataSet->fields[d_field_name]][d_is_display]= $dataSet->fields[d_is_display];
		
		
		$dataSet->MoveNext();
	}
}


//�Ҳտ��
print_menu($menu_p);
?>  
<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=0 class="main_body" WIDTH="100%" ALIGN="CENTER"> 
<tr>
<td>
<TABLE BORDER=0 CELLPADDING=10 CELLSPACING=0 BGCOLOR="#E6E6FA" WIDTH="100%" ALIGN="CENTER"> 
<TR>
<TD>
<TABLE BORDER="0" BGCOLOR="#FFFFFF" WIDTH="100%" CELLPADDING="2" CELLSPACING="0" align=center >

<TR >
		<td CLASS="grid" valign=top width=100>
		<!-- ��ƪ��� -->
<?php
$query = "select d_table_name ,d_table_cname,d_table_group  from sys_data_table order by d_table_group,d_table_name ";
$grid1 = new ado_grid_menu($_SERVER['PHP_SELF'],$URI,$CONN);
$grid1->key_item = "d_table_name";
$grid1->display_item = array("d_table_name","d_table_cname");
$grid1->width =100;
$grid1->row =12;
$grid1->color_index_item = "d_table_group";
$grid1->default_color = true; //�ϥιw�]�C��
//$grid1->display_color=array("�ǥ͸��"=>"red","���"=>"blue","�Ш|�H��"=>"green","�ݨ�"=>"#5533df","�ǥ�"=>"#550066");
$grid1->sql_str = $query;
$grid1->do_query(); //����R�O 
$upstr = "�]�w <a href=\"index.php?sel_d_table_name=$d_table_name\">$d_table_name </a>";
$grid1->print_grid($d_table_name,$upstr); // ��ܵe�� 

?>		
		</td>
<td valign=top >
<form action=<?php echo $_SERVER['PHP_SELF'] ?> name=myform method=post >
<img src="<?php echo "$URI/images/pixel_clear.gif" ?>" HEIGHT="2" width="100%">
<?php

echo "
	<table border=0 width=100%>\n
		<tr bgcolor=lightgrey>
			<td colspan=6  class=genlistheadt>	
";
		
echo ($_POST['mode'] == "�ק�Ҧ�")? "<input type=submit name=mode value=\"�s���Ҧ�\">&nbsp;<input type=submit name=mode value=\"�ק�Ҧ�\" disabled>&nbsp;<input type=submit name=do_key value=\"$btnPost\">":"<input type=submit name=mode value=\"�s���Ҧ�\" disabled>&nbsp<input type=submit name=mode value=\"�ק�Ҧ�\" >";

echo "		&nbsp;&nbsp;<a href=\"connect.php?table=$d_table_name\">���͵{���X</a></td>
		</tr>
		<tr bgcolor=lightgrey>
			<td align=center>���W��</td>
			<td align=center>���A</td>
			<td align=center>������W</td>
			<td align=center>XML TAG</td>
			<td align=center>��ܱƧ�</td>
			<td align=center>�O�_���&nbsp;";			
			
			if ($_POST['mode'] == "�ק�Ҧ�")
				echo "<input name=\"allbox\" type=\"checkbox\" value=\"1\"  onClick=\"CheckAll();\">";
			
echo"			</td> ";
	
echo "		</tr>";
$recordSet->MoveFirst()	;
while (!$recordSet->EOF) {
	$bgcolor = $cfgBgcolorOne;
	$i++ % 2 ? 0 : $bgcolor = $cfgBgcolorTwo;
	$table = $tablename;
	$d_field_name = $recordSet->fields['Field'];
	$d_field_type = $data[$d_field_name][d_field_type];
	$d_table_name	 = urlencode($table);
	$query = "?tablename=$table";
	
	if ($_POST['mode'] == "�ק�Ҧ�") {	
		
		$d_field_cname	="<input type=text size=10 name=\"cname_$d_field_name\" value=\"".$data[$d_field_name][d_field_cname]."\" >";
		$d_field_xml	="<input type=text size=10 name=\"xml_$d_field_name\" value=\"".$data[$d_field_name][d_field_xml]."\" >";
		$d_field_order	="<input type=text size=2 name=\"order_$d_field_name\" value=\"".$data[$d_field_name][d_field_order]."\" >";
		if ($data[$d_field_name][d_is_display])
			$d_is_display	="<input type=checkbox name=\"check_$d_field_name\" value=1 checked >";
		else
			$d_is_display	="<input type=checkbox name=\"check_$d_field_name\" value=1 >";
	}
	else {
	
		$d_field_cname	=$data[$d_field_name][d_field_cname];
		$d_field_xml	=$data[$d_field_name][d_field_xml];
		$d_field_order	=$data[$d_field_name][d_field_order];
		
		if ($data[$d_field_name][d_is_display])
			$d_is_display = "yes";
		else
			$d_is_display = "no";
	}
	
	?>
	<tr bgcolor=<?php echo $bgcolor; ?>>
	
	<td ><b><?php echo $d_field_name;?></b></td>
	<td ><?php echo $d_field_type;?></td>
	<td ><b><?php echo $d_field_cname;?></b></td>
	<td ><b><?php echo $d_field_xml;?></b></td>
	<td ><?php echo $d_field_order;?></td>
	<td ><?php echo $d_is_display;?></td>
	</tr>
	<?php
	$recordSet->MoveNext();
}

echo "<input type=hidden name=d_table_name value=\"$d_table_name\">";

echo "</table>\n";	
echo "</form>";
?>
		</td>
	</tr>
</table>
</td></tr></table>
</td></tr></table>
<? 
//�L�X���Y
foot();
?> 
