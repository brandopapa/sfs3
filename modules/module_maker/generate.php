<?php
// $Id: generate.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�]�w�� */
include_once "config.php";
sfs_check();

$sn_col=$_POST['sn_col'];
if(empty($sn_col))user_error("�S�����w�������A�i��|�ް_�{�����~�C",256);
$col_default=$_POST['default'];
$table=$_POST['table'];
$field_name=$_POST['field_name'];
$Cname=$_POST['Cname'];
$use=$_POST['use'];
$input_type=$_POST['input_type'];
$size=$_POST['size'];
$use_default=$_POST['use_default'];
$isfun=$_POST['isfun'];
$maxlen=$_POST['maxlen'];
$is_multiple=$_POST['is_multiple'];
$module_file_name=$_POST['module_file_name'];

//------------------------------------------------------------------------------

$sql_insert = "insert into $table (";
$sql_update = "update $table set ";
$sql_select = "select * from $table";

//���o������
foreach($field_name as $x=>$name){   
	module_maker_col_add($table,$field_name[$x],$Cname[$x],$col_default[$x]);
	if ($use[$x]==1) {   
		$form_main.=make_col($input_type[$x],$field_name[$x],$Cname[$x],$size[$x],$maxlen[$x],$isfun[$x],$use_default[$x],$col_default[$x],$is_multiple[$x]);
		
		// �s�W�� SQL
		$sql_insert_fields .= $field_name[$x] . ",";
		$sql_insert_values .="'". "$"."data[" . $field_name[$x] . "]',";
		// ��s�� SQL
		$sql_update .= $field_name[$x] . "='"."$"."data[". $field_name[$x] . "]',";
		// while �ɪ��@�Ǹ��
		$while_row_array[]="$".$field_name[$x];
		$while_data.="<td>\$$field_name[$x]</td>";
		$while_data_text.="<td>$Cname[$x]</td>";
		
		if(!empty($col_default[$x])){
			if($input_type[$x]=="select" or $input_type[$x]=="checkbox"){
				foreach($use_default[$x] as $dk=>$dv){
					$mdefault="\"$dk\"=>\"$dv\"";
				}
				$default_op[]="\"$x\"=>array($mdefault)";
			}elseif($isfun[$x]!=1){
				$default_op[]="\"$x\"=>\"$col_default[$x]\"";
			}
		}
   }
}

$default_array=implode(",",$default_op);

//����U��SQL�y�k
$sql_insert_fields 	= substr($sql_insert_fields,0,strlen($sql_insert_fields)-1);
$sql_insert_values 	= substr($sql_insert_values,0,strlen($sql_insert_values)-1);
$sql_update 		= substr($sql_update,0,strlen($sql_update)-1);
$while_row		= implode(",",$while_row_array);
// rest
$sql_insert			= $sql_insert . $sql_insert_fields . ") values (" . $sql_insert_values . ")";
$sql_select			= ereg_replace ("\*",$sql_insert_fields,$sql_select);



$while_data="<tr bgcolor='#FFFFFF'>$while_data<td nowrap><a href='\$_SERVER[PHP_SELF]?act=modify&$sn_col=\$$sn_col'>�ק�</a> | <a href='\$_SERVER[PHP_SELF]?act=del&$sn_col=\$$sn_col'>�R��</a></td></tr>";


$while_data_text="<tr bgcolor='#E6E9F9'>$while_data_text<td>�\��</td></tr>";
$whileForm="
	\$tool_bar
	<table width='96%' cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>
	$while_data_text
	\$data
	</table>";

//�s�@�ʤ֪����
$need_function=make_fun($field_name,$isfun,$col_default);

$content="<?php
// \$Id\$

include \"config.php\";
sfs_check();

//�D���]�w
\$school_menu_p=(empty(\$school_menu_p))?array():\$school_menu_p;

//�w�]�ȳ]�w
\$col_default=array($default_array);


\$act=\$_REQUEST[act];

//����ʧ@�P�_
if(\$act==\"insert\"){
	".$table."_add(\$_POST[data]);
	header(\"location: \$_SERVER[PHP_SELF]?act=listAll\");
}elseif(\$act==\"update\"){
	".$table."_update(\$_POST[data],\$_POST[$sn_col]);
	header(\"location: \$_SERVER[PHP_SELF]?act=listAll\");
}elseif(\$act==\"del\"){
	".$table."_del(\$_GET[$sn_col]);
	header(\"location: \$_SERVER[PHP_SELF]?act=listAll\");
}elseif(\$act==\"listAll\"){
	\$main=&".$table."_listAll();
}elseif(\$act==\"modify\"){
	\$main=&".$table."_mainForm(\$_GET[$sn_col],\"modify\");
}else{
	\$main=&".$table."_mainForm(\$_POST[$sn_col]);
}


//�q�X����
head(\"{showname}\");
echo \$main;
foot();

//�D�n��J�e��
function &".$table."_mainForm(\$$sn_col=\"\",\$mode){
	global \$school_menu_p,\$col_default;
	
	if(\$mode==\"modify\" and !empty(\$$sn_col)){
		\$dbData=get_".$table."_data(\$$sn_col);
	}
	
	if(is_array(\$dbData) and sizeof(\$dbData)>0){
		foreach(\$dbData as \$a=>\$b){
			\$DBV[\$a]=(!is_null(\$b))?\$b:\$col_default[\$a];
		}
	}else{
		\$DBV=\$col_default;
	}
	
	\$submit=(\$mode==\"modify\")?\"update\":\"insert\";
	
	//�����\���
	\$tool_bar=&make_menu(\$school_menu_p);
	
	\$main=\"
	\$tool_bar
	
	<table cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>
	<form action='\$_SERVER[PHP_SELF]' method='post'>
	$form_main
	</table>
	<input type='hidden' name='$sn_col' value='\$$sn_col'>
	<input type='hidden' name='act' value='\$submit'>
	<input type='submit' value='�e�X'>
	</form>

	<a href='\$_SERVER[PHP_SELF]?act=listAll'>�C�X����</a>
	\";
	return \$main;
}

//�s�W
function ".$table."_add(\$data){
	global \$CONN;
	".multiple_var($is_multiple)."
	\$sql_insert = \"$sql_insert\";
	\$CONN->Execute(\$sql_insert) or user_error(\"�s�W���ѡI<br>\$sql_insert\",256);
	\$$sn_col=mysql_insert_id();
	return \$$sn_col;
}

//��s
function ".$table."_update(\$data,\$$sn_col){
	global \$CONN;
	".multiple_var($is_multiple)."
	\$sql_update = \"$sql_update  where $sn_col='\$$sn_col'\";
	\$CONN->Execute(\$sql_update) or user_error(\"��s���ѡI<br>\$sql_update\",256);
	return \$$sn_col;
}

//�R��
function ".$table."_del(\$$sn_col=\"\"){
	global \$CONN;
	\$sql_delete = \"delete from $table where $sn_col='\$$sn_col'\";
	\$CONN->Execute(\$sql_delete) or user_error(\"�R�����ѡI<br>\$sql_delete\",256);
	return true;
}

//�C�X�Ҧ�
function &".$table."_listAll(){
	global \$CONN,\$school_menu_p;
	//�����\���
	\$tool_bar=&make_menu(\$school_menu_p);
	\$sql_select=\"$sql_select\";
	\$recordSet=\$CONN->Execute(\$sql_select) or user_error(\"Ū�����ѡI<br>\$sql_select\",256);
	while (list($while_row)=\$recordSet->FetchRow()) {
		\$data.=\"$while_data\";
	}
	\$main=\"$whileForm\";
	return \$main;
}

//���o�Y�@�����
function get_".$table."_data(\$$sn_col){
	global \$CONN;
	\$sql_select=\"$sql_select where $sn_col='\$$sn_col'\";
	\$recordSet=\$CONN->Execute(\$sql_select) or user_error(\"Ū�����ѡI<br>\$sql_select\",256);
	\$theData=\$recordSet->FetchRow();
	return \$theData;
}

$need_function
?>";
//exit;

//�}���ɮ׼g�J���
@unlink($UPLOAD_PATH.$FormData[table_name]."_".$FormData[index_page]);
$fp = fopen ($UPLOAD_PATH.$table."_".$module_file_name, "aw") or user_error("�ɮ׶}�ҿ��~�A���ˬd�I",256);
fputs($fp, $content); 
fclose($fp); 

header("location: index2.php?table=$table&index_page=$module_file_name");


//�s�y���
function make_fun($field_name=array(),$isfun=array(),$col_default=array()){
	foreach($field_name as $x=>$name){ 
		$f=explode("(",$col_default[$x]);
		$funname=trim($f[0]);
		if($isfun[$x]=='1' and !function_exists($funname)){
			$fun.=fun_model($col_default[$x]);
		}
	}
	return $fun;
}

//��Ƽҫ�
function fun_model($funname=""){
	$fun_main="
//".$funname." ��ƻ���
function ".$funname."{
	global \$CONN;
	\$main=\"\";
	return \$main;
}
";
	return $fun_main;
}

//�s�y���
function make_col($input_type,$field_name,$Cname,$size,$maxlen,$isfun,$use_default,$col_default,$is_multiple){
	if(empty($Cname))$Cname=$field_name;
	switch ($input_type) {
	
	//�ƿ�֨����
	case "checkbox":
	//�p�G�ƿ�A�[�Jname �[�J []
	$array_mark=($is_multiple)?"[]":"";
	
	$op=explode(";",$col_default);
	foreach($op as $v){
		$checked=(in_array($v,$use_default))?"checked":"";
		$option.="<input type='checkbox' name='data[$field_name]".$array_mark."' value='$v' $checked>$v";
	}
	$col="
	<tr bgcolor='#FFFFFF'>
	<td>$Cname</td>
	<td>$option</td>
	</tr>
	";
	break;

	//���֨���
	case "radio":
	$op=explode(";",$col_default);
	foreach($op as $v){
		$checked=($v==$use_default)?"checked":"";
		$option.="<input type='radio' name='data[$field_name]' value='$v' $checked>$v";
	}
	$col="
	<tr bgcolor='#FFFFFF'>
	<td>$Cname</td>
	<td>$option</td>
	</tr>
	";
	break;
	
	//�������
	case "hidden":
	$v=($isfun[$field_name]=="1")?"\".".stripslashes($col_default).".\"":"\$DBV[$field_name]";
	$col="
	<input type='hidden' name='data[$field_name]' value='$v'>	
	";
	break;
	
	//��r��J���
	case "text":
	$v=($isfun[$field_name]=="1")?"\".".stripslashes($col_default).".\"":"\$DBV[$field_name]";
	
	$col="
	<tr bgcolor='#FFFFFF'>
	<td>$Cname</td>
	<td><input type='text' name='data[$field_name]' value='$v' size='$size' maxlength='$maxlen'></td>
	</tr>
	";
	break;
	
	//�K�X��J���
	case "password":

	$col="
	<tr bgcolor='#FFFFFF'>
	<td>$Cname</td>
	<td><input type='password' name='data[$field_name]' value='\$DBV[$field_name]' size='$size' maxlength='$maxlen'></td>
	</tr>
	";
	break;
	
	//��r�϶�
	case "textarea":
	$col="
	<tr bgcolor='#FFFFFF'>
	<td>$Cname</td>
	<td><textarea name='data[$field_name]' cols='$size' rows='$maxlen'>\$DBV[$field_name]</textarea>
	</td>
	</tr>
	";
	break;
	
	//�U�Կ��
	case "select":
	//�p�G�ƿ�A�[�Jname �[�J []
	$array_mark=($is_multiple)?"[]":"";
	$multiple=($is_multiple)?"multiple":"";
	
	$op=explode(";",$col_default);
	foreach($op as $v){
		$selected=(in_array($v,$use_default))?"selected":"";
		$option.="<option value='$v' $selected>$v\n";
	}
	
	$vv=($isfun[$field_name]=="1")?"\".".stripslashes($col_default).".\"":$option;
	
	$col="
	<tr bgcolor='#FFFFFF'>
	<td>$Cname</td>
	<td>
	<select name='data[$field_name]$array_mark' $multiple>
	$vv
	</select>
	</td>
	</tr>
	";
	break;
	
	//�ɮ׿�J���
	case "file":

	$col="
	<tr bgcolor='#FFFFFF'>
	<td>$Cname</td>
	<td><input type='file' name='data[$field_name]' value='\$DBV[$field_name]' size='$size'></td>
	</tr>
	";
	break;
	
	//������
	case "display":
	$v=($isfun[$field_name]=="1")?"\".".stripslashes($col_default).".\"":"\$DBV[$field_name]";
	$col="
	<tr bgcolor='#FFFFFF'>
	<td>$Cname</td>
	<td>$v<input type='hidden' name='data[$field_name]' value='$v'>	</td>
	</tr>
	";
	break;
	}
return $col;
}

//�ƿ����A�s�W�Χ�s�ɡA�N�ƿ����ȥΡu,�v�°_��
function multiple_var($is_multiple=array()){
	foreach($is_multiple as $field_name=>$v){
		if($v=='1'){
			$main.="\$vvv=implode(\",\",\$data[$field_name]);
	\$data[$field_name]=\$vvv;";
		}
	}
	
	return $main;
}

//���N����Ʀs�J��Ʈw
function module_maker_col_add($table,$ename,$cname,$col_default){
	global $CONN;
	$sql_insert = "replace into module_maker_col (table_name,ename,cname,default_txt) values ('$table','$ename','$cname','$col_default')";
	$CONN->Execute($sql_insert) or user_error("�s�W���ѡI<br>$sql_insert",256);
	$mmscs=mysql_insert_id();
	return $mmscs;
}

?>
