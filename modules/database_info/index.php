<?php 

// $Id: index.php 5310 2009-01-10 07:57:56Z hami $

// ���J�]�w��
include "database_info_config.php";
// �{���ˬd
sfs_check();

if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


// �إ����O
//$tea1 = new m_unit_class();
//�L�X���Y
head();

$sql_get_tables = "SHOW TABLES FROM $mysql_db ";

$recordSet = $CONN->Execute($sql_get_tables);
	
switch($do_key) {
//�T�w
	case $btnPost:
	while (!$recordSet->EOF){
		
		$table = $recordSet->fields[0];
		$cname = "cname_".$recordSet->fields[0];			
		$table_group = "group_".$recordSet->fields[0];
		if($$table_group <>'') {
			$query = "replace into sys_data_table (d_table_name ,d_table_cname,d_table_group) values('$table','".trim($$cname)."','".trim($$table_group)."')";
			$CONN->Execute($query) or die ($query);
		}
		$recordSet->MoveNext();
	}
	break;
	case "delete":
	$query = "delete from sys_data_table where d_table_name='$d_table_name'";
	$CONN->Execute($query) or die($query);	
	break;
}
if(isset($sel_d_table_name)) {
	$query = "select d_table_group from sys_data_table where d_table_name='$sel_d_table_name'"; 
	$res = $CONN->Execute($query) or die($query);
	$d_table_group_id = $res->fields[0];	
}

//���o��ƪ�s��
$query = "select d_table_group,count(d_table_name) as cc from sys_data_table group by d_table_group  desc ";
$res = $CONN->Execute($query) or die($query);
$temp_table_group = $res->fields[d_table_group];
while(!$res->EOF) {
		$group_arr[$res->fields[d_table_group]] = $res->fields[d_table_group]." - ".$res->fields[cc];	
	$res->MoveNext();
}
	$group_arr[none] = "���k��";
if (!isset($d_table_group_id))
	$d_table_group_id = $temp_table_group;
if ($d_table_group_id=='')
	$d_table_group_id='none';
if($d_table_group_id=='none')
	$query = "select d_table_name ,d_table_cname,d_table_group  from sys_data_table  order by d_table_name ";
else
	$query = "select d_table_name ,d_table_cname,d_table_group  from sys_data_table where d_table_group='$d_table_group_id' order by d_table_name ";
$dataSet = $CONN->Execute($query) or die ($query);
while(!$dataSet->EOF){
	$data[$dataSet->fields[d_table_name]][cname]=$dataSet->fields[d_table_cname];
	$data[$dataSet->fields[d_table_name]][group]=$dataSet->fields[d_table_group];
	$dataSet->MoveNext();
}
//�Ҳտ��
print_menu($menu_p);
?>  

<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=0 class=main_body WIDTH="100%" ALIGN="CENTER"> 
<tr>
<td>
<form name="myform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method=post>
<TABLE BORDER=0 CELLPADDING=10 CELLSPACING=0 BGCOLOR="#E6E6FA" WIDTH="100%" ALIGN="CENTER"> 
<TR>
<TD>
<TABLE BORDER="0" BGCOLOR="#FFFFFF" WIDTH="100%" CELLPADDING="2" CELLSPACING="0" align=center >

<TR CLASS="genlisthead">
 <td colspan=4  class="genlistheadt">	
<?php
echo ($mode == "�ק�Ҧ�")? "<input type=submit name=mode value=\"�s���Ҧ�\">&nbsp;<input type=submit name=mode value=\"�ק�Ҧ�\" disabled> &nbsp;<input type=submit name=do_key value=\"$btnPost\">":"<input type=submit name=mode value=\"�s���Ҧ�\" disabled>&nbsp<input type=submit name=mode value=\"�ק�Ҧ�\" >";

echo "			</td>		
		</tr>
		<tr class=\"genlistheadt\" >
			<td >��ƪ�W��</td>
			<td >�����ƪ�W��</td>
			<td >�s��: ";
$sel = new drop_select();
$sel->s_name = "d_table_group_id";
$sel->id= $d_table_group_id;
$sel->arr = $group_arr;
$sel->has_empty = false;
$sel->is_submit = true;
$sel->do_select();

echo "			</td>
			<td >�ʧ@</td>
			
";
	
echo "		</tr>";
$recordSet->MoveFirst()	;
while (!$recordSet->EOF) {
	$table = $recordSet->fields[0];
	if((!@in_array($table,array_keys($data))&& $d_table_group_id=='none') || ( $d_table_group_id<>'none' && $data[$table][group] <>'')) {
		$bgcolor = $cfgBgcolorOne;
		$i++ % 2 ? 0 : $bgcolor = $cfgBgcolorTwo;
		$enc_table = urlencode($table);
		$query = "?d_table_name=$table";
		if ($mode == "�ק�Ҧ�"){
			$d_table_cname	="<input type=text name=\"cname_$table\" value=\"".$data[$table][cname]."\" >";
			$d_table_group	="<input type=text name=\"group_$table\" value=\"".$data[$table][group]."\" >";		
		}
		else {
			$d_table_cname	=$data[$table][cname];
			$d_table_group	=$data[$table][group];		
		}
		?>
		<tr bgcolor=<?php echo $bgcolor; ?>>
		<td ><b><a href="<?php echo "tpl_field.php$query"; ?>"><?php echo $table;?></a></b></td>
	
		<td ><?php echo $d_table_cname;?></td>
		<td ><?php echo $d_table_group;?></td>
		<td ><a href="<?php echo "{$_SERVER['PHP_SELF']}?do_key=delete&d_table_name=$table&d_table_group_id=$d_table_group_id"; ?>" onClick="return confirm('�T�w�R�� <?php echo $data[$table][cname] ?> ?');">�R��</a></td>
		</tr>
	<?php
	}
	$recordSet->MoveNext();
}

echo "</table>\n";	
echo "</form>";
echo "</td></tr></table>";
echo "</td></tr></table>";

//�L�X���Y
foot();
?> 
